<?php

namespace App\Http\Controllers;


use App\Mail\PasswordForget;
use App\Models\RememberUser;
use App\Models\ResetPassword;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function show_login()
    {
        $email = null;
        if (Cookie::has("remember")) {
            $token = Cookie::get("remember");
            $remember = RememberUser::where("token", $token)->where("expired_at", ">=", Carbon::now())->first();
            if (!is_null($remember)) {
                $email = $remember->user->email;
            }
        }
        return view("login", compact("email"));
    }

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
                session()->put(["login_id" => $user->id, "login_name" => $user->user_name]);
                if (!is_null($request->input("remember_me"))) {
                    $token = Cookie::get("remember");
                    if(is_null($token) || RememberUser::where("token",$token)->where("user_id", $user->id)->doesntExist()){
                        $token = Str::random(64);
                        while (RememberUser::where("token", $token)->exists()) {
                            $token = Str::random(64);
                        }
                    }
                    RememberUser::updateOrCreate([
                        "user_id" => $user->id,
                        "token" => $token,], [
                        "ip_address" => $request->ip(),
                        "expired_at" => Carbon::now()->addMonth()
                    ]);
                    Cookie::queue("remember", $token, 43800, null, null, false, true);
                } else {
                    RememberUser::where("token", Cookie::get("remember"))->where("user_id", $user->id)->delete();
                    setcookie("remember");
                }
                $user_role = UserRole::where("user_id", $user->id)
                    ->get();
                foreach ($user_role as $role) {//role id ごとに権限付与
                    if ($role->role_id == 1) {
                        session()->put(["Admin" => true]);
                    }else if($role->role_id == 2){
                        session()->put(["Publisher" => true]);
                    }
                }
                $cart_json = \Cookie::get("cart_data");
                setcookie("cart_data"); //cookie削除
                $cart_data = json_decode($cart_json, true);
                if (is_array($cart_data)) {
                    if (count($cart_data) > 0) {
                        $cart_con = new CartController();
                        if (!$cart_con->cookie_to_db($cart_data, $user->id)) {
                            //todo フラッシュメッセージ(CookieからDBに入れる際に在庫参照した際にカートの数量を調整した場合のメッセージ)
                        };
                    }
                }
                return redirect(session()->pull("login_pre_page", "/"));
            }
        }
        return redirect()
            ->back()
            ->withErrors(array("error_message" => "メールアドレスもしくはパスワードが間違っています"))
            ->withInput($request->only(["email"]));

    }

    public function forget_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|email:rfc"
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $email = $request->input("email");
        $user = User::where("email", $email)
            ->first();
        if (!is_null($user)) {
            $token = Str::random(60);
            while (ResetPassword::where("token", $token)->exists()) {
                $token = Str::random(60);
            }
            ResetPassword::create([
                "user_id" => $user->id,
                "token" => $token,
                "expired_at" => Carbon::now()->addHour()
            ]);
            Mail::to($email)->send(new PasswordForget($token));
        }

        return redirect("login/forget_mail_send");
    }

    public function send_forget_mail()
    {
        if (!preg_match("/.*forget\z/", url()->previous())) {
            return redirect(url("home"));
        }

        return view("password_forget_send");
    }

    public function show_reset_password($reset_token)
    {
        $reset = ResetPassword::where("token", $reset_token)
            ->first();
        if (is_null($reset) || Carbon::now()->gt($reset->expired_at)) {
            return redirect()
                ->route("error");
        }
        session()->put("reset_password_id", $reset->user_id);
        return view("password_reset");
    }

    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|email:rfc",
            "password" => "required|string|between:6,32|regex:/[ -~]+/|confirmed",
        ], [
            "password.confirmed" => ":attributeと再入力パスワードが一致していません",
            "password.regex" => ":attributeは半角英数字、半角記号のみを使用してください",
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        $user_id = session()->get("reset_password_id");
        if (is_null($user_id)) {
            return redirect()
                ->route("error");
        }
        $email = $request->input("email");
        $user = User::find($user_id);
        if ($email != $user->email) {
            //回数制限つけたほうがいいかも...?
            return redirect()
                ->route("error");
        }
        $password = Hash::make($request->input("password"));
        $user->fill(["password" => $password])->save();
        ResetPassword::where("user_id", $user_id)->delete();
        session()->forget("reset_password_id");

        session()->flash("flash_message", "パスワード再設定が完了しました。ログインしてください");
        return redirect()->route("login");
    }

    public function logout()
    {
        session()->flush();
        session()->regenerate();
        if (Cookie::has("remember")) {
            $token = Cookie::get("remember");
            RememberUser::where("token", $token)->delete();
            setcookie("remember");
        }
        return redirect()
            ->route("home");
    }
}
