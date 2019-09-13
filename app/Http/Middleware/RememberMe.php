<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CartController;
use App\Models\RememberUser;
use App\Models\User;
use App\Models\UserRole;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

class RememberMe
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has("login_id") && Cookie::has("remember")) {
            $token = Cookie::get("remember");
            $remember = RememberUser::where("token", $token)->where("expired_at" ,">=", Carbon::now())->first();
            if (is_null($remember)) {
//                setcookie("remember");
            } else if ($request->ip() == $remember->ip_address) {
                $user = User::find($remember->user_id);
                $user->timestamps = false;
                $user->fill(["last_logined_at" => now()])->save();
                session()->put(["login_id" => $user->id, "login_name" => $user->user_name]);
                $user_role = UserRole::where("user_id", $user->id)
                    ->get();
                foreach ($user_role as $role) {//role id ごとに権限付与
                    if ($role->role_id == 1) {
                        session()->put(["Admin" => true]);
                    }else if($role->role_id == 2){
                        session()->put(["Publisher" => true]);
                    }
                }
                $cart_json = Cookie::get("cart_data");
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
            }
        }
        return $next($request);
    }
}
