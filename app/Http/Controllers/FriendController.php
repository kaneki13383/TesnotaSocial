<?php

namespace App\Http\Controllers;

use App\Http\Resources\FrinedResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    function all_users()
    {
        return User::where('id', '!=', Auth::guard('sanctum')->id())->get();
    }

    function add_friend(Request $request, $id_friend)
    {
        $id_user = $request->input('id_user');

        $check_friend = Friend::where([
            ['id_user', '=', $id_user],
            ['id_friend', '=', $id_friend]
        ])->orWhere([
            ['id_user', '=', $id_friend],
            ['id_friend', '=', $id_user],
        ])->get();

        if (count($check_friend) == 0) {
            Friend::create([
                'id_user' => $id_user,
                'id_friend' => $id_friend
            ]);
        }
    }

    function check_status_frined($id_user)
    {
        $id_user = (int)$id_user;
        $fisrt_check = Friend::where('id_user', Auth::guard('sanctum')->id())->where('id_friend', $id_user)->first();
        if (empty($fisrt_check)) {
            $second_check = Friend::where('id_user', $id_user)->where('id_friend', Auth::guard('sanctum')->id())->first();
            if (empty($second_check)) {
                return 'Добавить в друзья';
            } else if ($second_check['status'] == 0) {
                return 'Хочет добавить вас в друзья';
            } else if ($second_check['status'] == 1) {
                return 'У вас в друзьях';
            }
        } else if ($fisrt_check['status'] == 0) {
            return 'Запрос в друзья отправлен';
        } else if ($fisrt_check['status'] == 1) {
            return 'У вас в друзьях';
        }
    }

    function accept_frined($id_user)
    {
        Friend::where('id_friend', $id_user)->update([
            'status' => 1
        ]);
    }

    function my_friends()
    {
        return FrinedResource::collection(Friend::where('id_user', Auth::user()->id)->orWhere('id_friend', Auth::user()->id)->where('status', 1)->get());
    }

    function delete_friend($id)
    {
        Friend::where('id', $id)->delete();
        return 'Удален';
    }
}
