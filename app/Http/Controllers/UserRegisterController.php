<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegisterController extends Controller
{
    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_name" => "required|string|between:2,8",
            "email" => "required|string|email:rfc|unique:users|max:255",
            "password" => "required|string|between:6,32|regex:/[ -~]+/|confirmed",
        ], [
            "password.confirmed" => ":attributeと再入力パスワードが一致していません",
            "password.regex" => ":attributeは半角英数字、半角記号のみを使用してください",
            "email.unique" => "この:attributeは既に登録されています。",
        ]);

        $user_name = $request->input("user_name");
        $email = $request->input("email");
        $password = $request->input("password");
        try {
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput($request->only(["user_name", "email"]));
            } else {
                session()->put(["register_user_name" => $user_name, "register_email" => $email,
                    "register_password" => $password]);
                return view("register_confirm", compact("user_name", "email"));
            }
        } catch (QueryException $e) {
            return redirect()
                ->route("error");
        }
    }

    public function confirm_back()
    {
        $user_name = session()->pull("register_user_name", "");
        $email = session()->pull("register_email", "");
        session()->forget("register_password");
        session()->flashInput(["user_name" => $user_name, "email" => $email]);
        return redirect("register");
    }

    public function user_register(Request $request)
    {
        $user_name = session()->pull("register_user_name");
        $email = session()->pull("register_email");
        $password = Hash::make(session()->pull("register_password"));
        try {
            $user_create = User::create([
                "user_name" => $user_name,
                "email" => $email,
                "password" => $password,
                "last_logined_at" => now(),
            ]);
            session()->put(["login_id" => $user_create->id, "login_name" => $user_create -> user_name]);
            $cart_json = Cookie::get("cart_data");
            setcookie("cart_data"); //cookie削除
            $cart_data = json_decode($cart_json, true);
            if (is_array($cart_data)) {
                if (count($cart_data) > 0) {
                    $cart_con = new CartController();
                    $cart_con->cookie_to_db($cart_data, $user_create->id);
                }
            }
        } catch (QueryException $e) {
            return redirect()
                ->route("error");
        }

        return redirect()
            ->route("home");
    }
}
