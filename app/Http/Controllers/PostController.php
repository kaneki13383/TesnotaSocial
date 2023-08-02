<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getAllPosts()
    {
        return response()->json([
            'content' => AllPostsResource::collection(Post::all())
        ]);
    }
    public function createPost(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());

        Post::create([
            'id_user' => $user->id,
            'text' => $request->input('text')
        ]);

        return response()->json([
            'message' => 'Пост успешно опубликован'
        ]);
    }
}
