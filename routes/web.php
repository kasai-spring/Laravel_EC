<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get("/", "HomeController@index")->name("home");

Route::get("login", function () {
    return view("login");
})->name("login");

Route::post("login", "LoginController@login");

Route::get("logout", "LoginController@logout");

Route::get("error", function () {
    return view("error");
})->name("error");

Route::get("register", function () {
    return view("register");
});

Route::post("register", "UserRegisterController@confirm_back");

Route::post("register/confirm", "UserRegisterController@confirm");

Route::post("register/complete", "UserRegisterController@user_register");

Route::get("mypage", "MyPageController@show_mypage")
    ->name("mypage");


