<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\GeminiService;
use App\Http\Requests\StartRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Models\Message;
use App\Models\Table;
use App\Models\TalkSession;

class MessageController extends Controller
{
    //
    public function start(StartRequest $request)
    {
        $user = $request->user();
        $deviceNumber = $request->deviceNumber;
        $capacity = $request->capacity;
        if ($user->table_id == null) {
            $table = Table::create([
                'number' => $deviceNumber,
                'capacity' => $capacity
            ]);
            
            $user->update([
                'table_id' => $table->id
            ]);
            TalkSession::create([
                'id' => Str::uuid(),
                'table_id' => $table->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'トークセッションを開始しました',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'トークセッションがすでに開始されています',
        ]);
        
    }   
    public function logs(Request $request)
    {
        $user = $request->user();
        if ($user->table_id == null) {
            return response()->json([
                'success' => false,
                'message' => 'トークセッションが開始されていません',
            ]);
        }

        $talkSession = TalkSession::where('table_id', $user->table_id)->first();
        $messages = Message::where('talk_session_id', $talkSession->id)
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        
        // 各メッセージに対して推奨メニューを取得
        $messages->getCollection()->transform(function ($message) use ($user) {
            if ($message->speaker === 'assistant') {
                $recommendedMenus = DB::table('see_menu')
                    ->where('user_id', $user->id)
                    ->where('see_menu.created_at', '>=', $message->created_at)
                    ->where('see_menu.created_at', '<=', $message->created_at->addSeconds(5))
                    ->join('menus', 'see_menu.menu_id', '=', 'menus.id')
                    ->select('menus.id', 'menus.name', 'menus.price', 'menus.image_path', 'menus.description')
                    ->get()
                    ->map(function ($menu) {
                        if (!empty($menu->image_path)) {
                            $menu->image_path = url("assets/images/saizeriya_img/" . basename($menu->image_path));
                        } else {
                            $menu->image_path = null;
                        }
                        return $menu;
                    });
                $message->menus = $recommendedMenus;
            }
            return $message;
        });

        $messages->withPath('logs');

        return response()->json($messages);
    }
    public function store(MessageStoreRequest $request, GeminiService $geminiService)
    {
        try {
            $user = $request->user();
            $content = $request->input('content');
            
            // ユーザーのテーブルIDに関連するトークセッションを取得
            $talkSession = TalkSession::where('table_id', $user->table_id)->firstOrFail();

            // ユーザーメッセージを保存
            $userMessage = Message::create([
                'talk_session_id' => $talkSession->id,
                'content' => $content,
                'speaker' => 'user',
                'review' => 0,
            ]);

            // チャット履歴を取得
            $chatLog = Message::where('talk_session_id', $talkSession->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->reverse()
                ->map(function($msg) {
                    return [
                        'role' => $msg->speaker === 'user' ? 'user' : 'model',
                        'parts' => [['text' => $msg->content]]
                    ];
                })
                ->toArray();

            // GeminiServiceから応答を取得
            $response = $geminiService->generateContent($content, json_encode($chatLog));

            // エラーレスポンスのチェック
            if (isset($response['success']) && $response['success'] === false) {
                throw new \Exception($response['message'] ?? 'Geminiサービスでエラーが発生しました。');
            }

            // アシスタントのメッセージを保存
            $assistantMessage = Message::create([
                'talk_session_id' => $talkSession->id,
                'content' => $response['message'],
                'speaker' => 'assistant',
                'review' => 0,
            ]);

            // 推奨メニューがあれば保存
            if (!empty($response['recommended_menu_ids'])) {
                $now = now();
                $records = collect($response['recommended_menu_ids'])
                    ->map(function ($menuId) use ($user, $now) {
                        return [
                            'menu_id' => $menuId,
                            'user_id' => $user->id,
                            'created_at' => $now,
                            'updated_at' => $now
                        ];
                    })
                    ->toArray();
                
                DB::table('see_menu')->insertOrIgnore($records);
            }

            return response()->json([
                'success' => true,
                'message' => $response['message'],
                'recommended_menu_ids' => $response['recommended_menu_ids'] ?? []
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in MessageController@store: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'エラーが発生しました: ' . $e->getMessage(),
                'recommended_menu_ids' => []
            ], 500);
        }
    }
}