<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepostResource;
use App\Models\Repost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepostController extends Controller
{
    function add_repost(Request $request){
        Repost::create([
            'id_user' => Auth::guard('sanctum')->id(),
            'id_repost_user' => $request->input('id_repost_user'),
            'id_post' => $request->input('id_post')
        ]);

        return 'Пост успешно зарепосчен';
    }

    function delete_repost($id_repost){
        Repost::where('id', $id_repost)->delete();

        return 'Репост удален';
    }

    function all_repost($id_user){
        return RepostResource::collection(Repost::where('id_user', $id_user)->get());
    }
}
