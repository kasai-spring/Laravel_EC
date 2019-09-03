<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function __construct()
    {
        $this->middleware("normal_user");
    }

    public function show_mypage(){
        $user_data = User::find(session()->get("login_id"));
        return view("mypage", compact("user_data"));
    }
}
