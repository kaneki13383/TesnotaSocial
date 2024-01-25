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
            'posts' => AllPostsResource::collection(Post::latest()->paginate(10)),
            'pagination' => Post::latest()->paginate(10)
        ]);
    }
    public function getMyPosts()
    {
        return response()->json([
            'posts' => AllPostsResource::collection(Post::where('id_user', Auth::guard('sanctum')->id())->latest()->paginate(10)),
            'pagination' => Post::latest()->paginate(10)
        ]);
    }
    public function getUserPosts($id)
    {
        return response()->json([
            'posts' => AllPostsResource::collection(Post::where('id_user', $id)->latest()->paginate(10)),
            'pagination' => Post::latest()->paginate(10)
        ]);
    }
    public function createPost(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());

        if ($request->input('text')) {
            $post = Post::create([
                'id_user' => $user->id,
                'text' => $request->input('text')
            ]);
        } else {
            $post = Post::create([
                'id_user' => $user->id,
                'text' => ''
            ]);
        }

        $data = $request->file;

        if ($data) {
            foreach ($data as $photo) {
                $path = Storage::disk('public')->put('photo_posts', $photo);
                PhotoPost::create([
                    'id_post' => $post->id,
                    'photo' => 'storage/' . $path
                ]);
            }
        }

        return response()->json([
            'message' => 'Пост успешно опубликован'
        ]);
    }
    public function deletePost($id)
    {
        Post::where('id', $id)->delete();
    }
}
