<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    function all_users()
    {
        return User::where('id', '!=', Auth::guard('sanctum')->id())->get();
    }
}
