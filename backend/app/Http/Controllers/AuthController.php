<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthLoginRequest;

class AuthController extends Controller
{
    //
    public function login(AuthLoginRequest $request){
    $validated = $request->validated();
    $user_name = $validated['name'];
    $password = $validated['password'];
    if (Auth::attempt(['name' => $user_name, 'password' => $password])) {
        $authUser = Auth::user();
        return response()->json([
            'success' => true,
            'messages' => ['ログインに成功しました。'],
            'user' => [
                "id" => $authUser->id,
                "name" => $authUser->name,
                "email" => $authUser->email,
                "role" => $authUser->role,
                "tableNumer" => $authUser->table
            ],
            'authToken' => $authUser->createToken('auth-token', ['*'], null)->plainTextToken,
        ]);
    }
    return response()->json(
        [
            'success' => false,
            'messages' => ['名前またはパスワードが正しくありません。'],
        ], 401);
    }
}
