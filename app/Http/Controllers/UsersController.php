<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    /**
     * @return mixed
     */
    public static function getAllUser()
    {
        $users = DB::table('users')
            ->join('throttle', 'users.id', '=', 'throttle.user_id')
            ->where('throttle.banned', '0')
            ->select('users.id', DB::raw('concat(users.first_name, " ", users.last_name) as full_name'));
        return $users;
    }

    /**
     * @param $userId
     * @return string
     */
    public static function getUserName($userId) {
        $userName = User::find($userId);
        return $userName['first_name'].' '.$userName['last_name'];
    }


}
