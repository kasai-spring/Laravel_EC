<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "email" => "required|string|exists:users|email:rfc",
            "password" => "required|string|between:6,32|regex:/\A[0-9a-zA-Z_-]+\z/",
        ]);
        $email = $request->input("email");
        $password = $request->input("password");

        if(!$validator->fails()){
            $user = User::where("email",$email)
            ->whereNull("deleted_at")
            ->first();

            $db_password = $user->password;

            if(Hash::check($password, $db_password)){
                $user->timestamps = false;
                $user->update(["last_logined_at" => now()]);
                session()->put(["login_id" => $email]);
                return redirect()
                    ->route("mypage");
            }
        }
        return redirect()
            ->back()
            ->withErrors(array("error_message" => "メールアドレスもしくはユーザーIDが間違っています"))
            ->withInput($request->only(["email"]));

    }

    public function logout(){
        session()->flush();
        session()->regenerate();
        return redirect()
            ->route("home");
    }
}
