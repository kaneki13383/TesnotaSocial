<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
    public function login(Request $request)
    {
        if (!Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Неверные данные',
            ], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Вы успешно вошли',
            'content' => $token,
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
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'message' => 'Вы вышли'
        ], 200);
    }
    public function changeAvatar(Request $request)
    {
        $data = $request->validate([
            'avatar' => ['required', 'file'],
        ]);
        $user = User::find(Auth::guard('sanctum')->id());
        $path = Storage::disk('public')->put('avatars', $data['avatar']);
        // dd($user->id);
        User::where('id', $user->id)->update([
            'avatar' => 'storage/' . $path
        ]);
        return response()->json([
            'message' => 'Поле avatar обновлен',
            'content' => $path,
        ]);
    }
    public function editProfile(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());
        User::where('id', $user->id)->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
        ]);
        return response()->json([
            'message' => 'Данные успешно изменены'
        ]);
    }
}
