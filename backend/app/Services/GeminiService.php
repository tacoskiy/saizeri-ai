<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use App\Models\Menu;
use Illuminate\Support\Facades\Log;



/**
 * Gemini APIとの通信を専門に扱うサービスクラス
 */
class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    protected string $model;
    protected float $temperature;
    protected int $maxTokens;
    protected string $systemInstruction;

    public function __construct()
    {
        // 設定ファイルから値を取得
        $geminiConfig = config('services.gemini');
        
        // デバッグ用ログ
        Log::info('Gemini Config:', $geminiConfig);
        
        // 設定が正しく読み込まれているか確認
        if (!isset($geminiConfig['api_key'])) {
            Log::error('Gemini API Key is not set in config');
            throw new \RuntimeException('Gemini API Key is not configured properly.');
        }
        
        $this->apiKey = $geminiConfig['api_key'];
        $this->model = $geminiConfig['model'];
        $this->temperature = $geminiConfig['temperature'];
        $this->maxTokens = $geminiConfig['max_tokens'];
        $this->systemInstruction = $geminiConfig['system_instruction'];

        if (empty($this->apiKey)) {
            throw new \RuntimeException('GEMINI_API_KEYが設定されていません。');
        }
    }

    /**
     * 指定されたプロンプトに基づいてコンテンツを生成する
     *
     * @param string $prompt ユーザーからの入力テキスト
     * @return string モデルからの応答テキスト、またはエラーメッセージ
     */
    public function generateContent(string $prompt, string $chatLog): array
    {
        try {
            // 1. メニュー情報を取得
            $menuItems = Menu::all();
            $menuText = "利用可能なメニュー:\n" . $menuItems->map(function($item) {
                return "- {$item->id}: {$item->name} - {$item->price}円";
            })->implode("\n");

            // 2. システムプロンプト設定
            $systemPrompt = $this->systemInstruction . "\n\n" . $menuText . 
                "\n\n応答は必ず以下のJSON形式で返してください。他のテキストは一切含めないでください：\n" .
                '{
                    "message": "ユーザーへの返答メッセージ",
                    "recommended_menu_ids": [1, 2, 3]  // 推奨メニューのID配列
                }';

            // 3. エンドポイントURL
            $url = $this->baseUrl . "{$this->model}:generateContent?key={$this->apiKey}";

            // 4. リクエストボディ
            $body = [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [['text' => $prompt]]
                    ]
                ],
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ],
                'generationConfig' => [
                    'temperature' => $this->temperature,
                    'maxOutputTokens' => $this->maxTokens
                ]
            ];

            // 5. リクエスト実行
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $body);

            // 6. エラーハンドリング
            if ($response->failed()) {
                \Log::error('Gemini API Error:', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'request' => [
                        'url' => $url,
                        'body' => $body
                    ]
                ]);
                
                throw new \Exception('APIエラーが発生しました。ステータスコード: ' . $response->status());
            }

            $responseData = $response->json();
            
            if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                throw new \Exception('無効なレスポンス形式です。');
            }

            $responseText = $responseData['candidates'][0]['content']['parts'][0]['text'];
            
            // JSON文字列からJSON部分のみを抽出
            if (preg_match('/```json\n([\s\S]*?)\n```/', $responseText, $matches)) {
                $responseText = $matches[1];
            }
            
            $decodedResponse = json_decode($responseText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('JSONデコードエラー:', [
                    'response_text' => $responseText,
                    'error' => json_last_error_msg()
                ]);
                throw new \Exception('無効なJSON形式のレスポンスが返されました。');
            }

            return $decodedResponse;

        } catch (\Exception $e) {
            \Log::error('Error in GeminiService: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'エラーが発生しました: ' . $e->getMessage(),
                'recommended_menu_ids' => []
            ];
        }
    }
}