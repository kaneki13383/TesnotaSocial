<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());
        $like = Like::where('id_post', $request->input('id_post'))->where('id_user', $user->id);

        $check = false;

        if ($like->exists()) {
            $like->delete();
            $check = false;
        } else {
            Like::create([
                'id_post' => $request->input('id_post'),
                'id_user' => Auth::user()->id,
            ]);
            $check = true;
        }

        return response()->json([
            'data' => Like::all()->where('id_post', $request->input('id_post')),
            'count' => Like::all()->where('id_post', $request->input('id_post'))->count(),
            'check' => $check
        ]);
    }
    public function destroy($id)
    {
        $like = Like::find($id);
        $like->delete();
    }
    public function checkLike(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());
        $like = Like::where('id_post', $request->input('id_post'))->where('id_user', $user->id)->get()->last();

        if ($like != null) {
            if ($like->id_user != $user->id) {
                return response()->json([
                    'check' => false
                ]);
            } else {
                return response()->json([
                    'check' => true
                ]);
            }
        } else {
            return response()->json([
                'check' => false
            ]);
        }
    }
}
