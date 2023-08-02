<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsResource;
use App\Models\PhotoPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $post = Post::create([
            'id_user' => $user->id,
            'text' => $request->input('text')
        ]);

        $data = $request->file;

        foreach ($data as $photo) {
            $path = Storage::disk('public')->put('photo_posts', $photo);
            PhotoPost::create([
                'id_post' => $post->id,
                'photo' => 'storage/' . $path
            ]);
        }

        return response()->json([
            'message' => 'Пост успешно опубликован'
        ]);
    }
}
