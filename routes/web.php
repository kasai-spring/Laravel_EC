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

Route::get("login", function (){
    return view("login");
})->name("login");

Route::post("login", "LoginController@login");

Route::get("logout", "LoginController@logout");

Route::get("error", function () {
    return view("error");
})->name("error");

Route::group(["prefix" => "register"],function(){
    Route::get("/", function () {
        return view("register");
    });
    Route::post("/", "UserRegisterController@confirm_back");
    Route::post("confirm", "UserRegisterController@confirm");
    Route::post("complete", "UserRegisterController@user_register");
});

Route::get("mypage", "MyPageController@show_mypage")
    ->name("mypage");

Route::get("goods/detail/{good_id}", "GoodsController@show_detail")
    ->where("good_id","[0-9]+");

Route::post("goods/add_cart/{good_id}", "CartController@add_cart")
    ->where("good_id","[0-9]+");

Route::get("cart", "CartController@show_cart");

Route::group(["prefix" => "settlement", "middleware" => "normal_user"], function(){
    Route::post("address", "SettlementController@address_select");
    Route::post("confirm", "SettlementController@confirm");
});

