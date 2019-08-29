<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function __construct()
    {
        $this->middleware("normal_user");
    }

    public function show_mypage(){
        return view("mypage");
    }
}
