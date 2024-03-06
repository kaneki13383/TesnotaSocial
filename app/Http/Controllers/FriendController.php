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
        $fisrt = Friend::where('id_user', $id_user)->orWhere('id_friend', $id_user)->first();
        $second = Friend::where('id_user', $id_user)->get();

        if (empty($fisrt)) {
            return 'Добавить в друзья';
        } else {
            if ($fisrt['status'] == 0) {
                if (count($second) == 0) {
                    return 'Хочет добавить вас в друзья';
                } else {
                    return 'Запрос в друзья отправлен';
                }
            }
            if ($fisrt['status'] == 1) {
                return 'У вас в друзьях';
            }
        }
    }

    function accept_frined($id_user)
    {
        Friend::where('id_friend', $id_user)->update([
            'status' => 1
        ]);
    }

    function my_friends($id_user)
    {
        $sql_1 = FrinedResource::collection(Friend::where('id_user', $id_user)->get('id_friend'));


        $sql_2 = FrinedResource::collection(Friend::where('id_friend', $id_user)->get('id_user'));

        $res = array_map('array_merge', $sql_1, $sql_2);

        return $res;
    }
}
