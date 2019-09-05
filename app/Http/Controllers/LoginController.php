<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|exists:users|email:rfc",
            "password" => "required|string|between:6,32|regex:/[-~]/",
        ]);
        $email = $request->input("email");
        $password = $request->input("password");

        if (!$validator->fails()) {
            $user = User::where("email", $email)
                ->whereNull("deleted_at")
                ->first();

            $db_password = $user->password;

            if (Hash::check($password, $db_password)) {
                $user->timestamps = false;
                $user->fill(["last_logined_at" => now()])->save();
                session()->put(["login_id" => $user->id]);
                $user_role = UserRole::where("user_id", $user->id)
                    ->get();
                foreach ($user_role as $role) {//role id ごとに権限付与
                    if ($role->role_id == 1) {
                        session()->put(["Admin" => true]);
                    }
                }
                $cart_json = \Cookie::get("cart_data");
                setcookie("cart_data"); //cookie削除
                $cart_data = json_decode($cart_json, true);
                if (is_array($cart_data)) {
                    if (count($cart_data) > 0) {
                        $cart_con = new CartController();
                        if (!$cart_con->cookie_to_db($cart_data, $user->id)) {
                            //todo フラッシュメッセージ
                        };
                    }
                }
                return redirect(session()->pull("login_pre_page", "/"));
            }
        }
        return redirect()
            ->back()
            ->withErrors(array("error_message" => "メールアドレスもしくはユーザーIDが間違っています"))
            ->withInput($request->only(["email"]));

    }

    public function logout()
    {
        session()->flush();
        session()->regenerate();
        return redirect()
            ->route("home");
    }
}
