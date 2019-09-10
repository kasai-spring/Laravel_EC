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

use App\Http\Controllers\SettlementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use function foo\func;


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

Route::group(["prefix" => "mypage", "middleware" => "normal_user"], function(){

    Route::get("/", "MyPageController@show_mypage")
        ->name("mypage");

    Route::get("history", "MyPageController@show_purchase_history");
});

Route::group(["prefix" => "goods"], function(){
    Route::get("search", "GoodsController@search_good");

    Route::get("detail/{good_id}", "GoodsController@show_detail");

    Route::post("add_cart/{good_id}", "CartController@add_cart");
});


Route::group(["prefix" => "cart"], function(){
    Route::get("/", "CartController@show_cart")
        ->name("cart");
    Route::post("change", "Ajax\CartController@change_cart")
        ->middleware("ajax");
});


Route::group(["prefix" => "settlement", "middleware" => "normal_user"], function(){
    Route::post("address", "SettlementController@post_address_select");
    Route::get("address", "SettlementController@get_address_select");
    Route::get("confirm", "SettlementController@get_confirm");
    Route::post("confirm", "SettlementController@post_confirm");
    Route::post("process", "SettlementController@process");
    Route::get("complete", "SettlementController@complete");
});

Route::group(["prefix" => "admin", "middleware" => "admin"], function(){
    Route::get("/", function(){
        return view("admin");
    });
});

Route::group(["prefix" => "developer", "middleware" => "admin"], function (){
    Route::get("/", function(){
       return view("developer");
    });
    Route::post("add_random_goods", "DeveloperController@add_random_goods");
});


