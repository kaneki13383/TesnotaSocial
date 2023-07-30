<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Autorization extends Controller
{
    public function register(Request $request)
    {
        if (Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Пользователь уже создан',
            ], 401);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        Auth::login($user);
        $token = $user->createToken('auth_token');
        return response()->json([
            'message' => 'Вы успешно зарегистрировались',
            'content' => $token->plainTextToken,
        ], 200);
    }
    public function me()
    {
        return response()->json([
            'message' => 'Данные о пол-ле',
            'content' => Auth::guard('sanctum')->user()
        ]);
    }
    public function logout(): \Illuminate\Http\JsonResponse
    {
        //Удаление токенов
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'message' => 'Вы вышли'
        ], 200);
    }
}
