<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function allPostComments(Request $request)
    {
        return CommentResource::collection(Comment::where('id_post', $request->input('id_post'))->get());
    }
    public function createCommnet(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());
        Comment::create([
            'id_user' => $user->id,
            'id_post' => $request->input('id_post'),
            'comment' => $request->input('comment'),
        ]);
        return response()->json([
            'message' => 'Коментарий отправлен!'
        ]);
    }
}
