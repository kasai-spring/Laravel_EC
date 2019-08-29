<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Services\ValueChecker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegisterController extends Controller
{
    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_name" => "required|string|between:4,16",
            "email" => "required|string|email:rfc|unique:users",
            "password" => "required|string|between:6,32|regex:/\A[0-9a-zA-Z_-]+\z/",
            "re_password" => "required|string|same:password",
        ], [
            "user_id.not_regex" => ":attributeは半角英数字とハイフンとアンダーバーのみを入力してください",
            "password.not_regex" => ":attributeは半角英数字とハイフンとアンダーバーのみを入力してください",
            "user_id.unique" => "この:attributeは既に使用されています。",
            "email.unique" => "この:attributeは既に登録されています。",
        ]);
        $user_id = $request->input("user_id");
        $email = $request->input("email");
        $password = $request->input("password");

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->only(["user_id", "email"]));
        } else {
            session()->put(["register_user_id" => $user_id, "register_email" => $email,
                "register_password" => $password]);
            return view("register_confirm", compact("user_id", "email"));
        }

    }

    public function confirm_back()
    {
        $user_id = session()->pull("register_user_id", "");
        $email = session()->pull("register_email", "");
        session()->forget("register_password");
        return view("register", compact("user_id", "email"));
    }

    public function user_register(Request $request)
    {
        $user_id = session()->pull("register_user_id");
        $email = session()->pull("register_email");
        $raw_password = session()->pull("register_password");
        $password = Hash::make($raw_password);
        try{
            $user_create = User::create([
                "id" => 1,
                "user_id" => $user_id,
                "email" => $email,
                "password" => $password,
                "created_at" => now(),
                "updated_at" => now(),
                "last_logined_at" => now(),
            ]);
        }catch(QueryException $e){
            return redirect()
                ->route("error");
        }

        echo $user_create;
        return view("home");
        //return redirect("/");
    }
}
