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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettlementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use function foo\func;


Route::get("/", "HomeController@index")->name("home");

Route::group(["prefix" => "login", "middleware" => "guest"], function(){
    Route::get("/", "LoginController@show_login")->name("login");

    Route::post("/", "LoginController@login");

    Route::get("forget", function (){
        return view("password_forget");
    });

    Route::post("forget", "LoginController@forget_password");

    Route::get("forget/{reset_token}", "LoginController@show_reset_password");

    Route::post("forget/reset", "LoginController@reset_password");

    Route::get("forget_mail_send", "LoginController@send_forget_mail");
});

Route::get("logout", "LoginController@logout");

Route::get("error", function () {
    return view("error");
})->name("error");

Route::group(["prefix" => "register", "middleware" => "guest"],function(){
    Route::get("/", function () {
        return view("register");
    });
    Route::post("/", "UserRegisterController@confirm_back");
    Route::post("confirm", "UserRegisterController@confirm");
    Route::post("complete", "UserRegisterController@user_register");
});

Route::group(["prefix" => "account", "middleware" => "normal_user"], function(){

    Route::get("/", "MyPageController@show_mypage")
        ->name("mypage");
    Route::get("history", "MyPageController@show_purchase_history");
    Route::get("setting", function (){
        return view("setting");
    });
    Route::get("setting/name", "MyPageController@show_setting_name");
    Route::post("setting/name", "MyPageController@setting_name");
    Route::get("setting/email", "MyPageController@show_setting_email");
    Route::post("setting/email", "MyPageController@setting_email");
    Route::get("setting/password", function (){
        return view("setting_password");
    });
    Route::post("setting/password", "MyPageController@setting_password");
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
    Route::get("/", "AdminController@show_admin_form");
    Route::post("/", "AdminController@edit_from_form");
    Route::get("user_edit/{user_id?}", "AdminController@show_edit_user");
    Route::post("user_edit/{user_id?}","AdminController@edit_user");
    Route::get("good_edit/{good_id?}", "AdminController@show_edit_good");
    Route::post("good_edit/{good_id?}","AdminController@edit_good");
});

Route::group(["prefix" => "developer", "middleware" => "admin"], function (){
    Route::get("/", function(){
       return view("developer");
    });
    Route::post("add_random_goods", "DeveloperController@add_random_goods");
    Route::get("test_module", "DeveloperController@test_module");
});

Route::group(["prefix" => "inquiry"], function(){
    Route::get("/", function (){
        return view("inquiry");
    });
    Route::post("/", "HomeController@confirm_back");
    Route::post("confirm", "HomeController@inquiry");
    Route::get("complete", "HomeController@show_inquiry_complete");
    Route::post("complete", "HomeController@inquiry_complete");
});

Route::group(["prefix" => "publisher", "middleware" => "publisher"], function(){
    Route::get("/", "PublisherController@show_publisher_page");
    Route::post("/", "PublisherController@publisher_good_controller");
    Route::get("edit/{good_id?}","PublisherController@show_good_edit");
    Route::post("edit/{good_id?}","PublisherController@good_edit");
});




