<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\User;
use App\Models\Cart;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function show_cart()
    {
        $cart = new Cart();
        //ログインしてる場合
        if (session()->has("login_id")) {
            $login_id = session()->get("login_id");
            try{
                $cart->checkCartData($login_id);
                $cart_check = $cart->checkCartData($login_id);
                if (!$cart_check) {
                    session()->flash("flash_message", "在庫切れのためカート内の一部の商品の数量を変更、もしくは削除しました");
                }
                $cart_data = $cart->getCartData($login_id);
            }catch (\Exception $e){
                return redirect()->route("error");
            }
            return view("cart", compact("cart_data"));
        }
        //ログインしてない場合
        $cart_json = Cookie::get("cart_data");
        $cart_cookie = json_decode($cart_json, true);
        if (is_null($cart_cookie) || count($cart_cookie) == 0) {
            $total_price = 0;
            $cart_data = array();
            return view("cart", compact("cart_data","total_price"));
        }
        try{
            $cart_data = $cart->getCartDataCookie($cart_cookie);
        }catch (\Exception $e){
            return redirect()->route("error");
        }
        return view("cart", compact("cart_data"));
    }

    public function add_cart(Request $request, $good_id)
    {
        $validator = Validator::make($request->all(), [
            "quantity" => "required|numeric|between:1,30"
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route("error");
        }
        $quantity = $request->input("quantity");
        //ログインしてる場合
        if (session()->has("login_id")) {
            $login_id = session()->get("login_id");
            try {
                $cart = Cart::firstOrNew(["user_id" => $login_id, "good_id" => $good_id]);
                if ($cart->quantity + $quantity > 30) {
                    $cart->quantity = 30;
                    session()->flash("flash_message", "同じ商品を30個以上購入することはできません");
                } else {
                    $cart->quantity = ($cart->quantity + $quantity);
                }
                $cart->save();
            } catch (QueryException $e) {
                return redirect()
                    ->route("error");
            }
            return redirect()
                ->route("cart");
        }

        //ログインしてない場合
        $cart_json = Cookie::get("cart_data");
        $cart_data = json_decode($cart_json, true);
        if (is_null($cart_data)) {
            $cart_data = array();
        }
        if (array_key_exists($good_id, $cart_data)) {
            if ($cart_data[$good_id] + $quantity > 30) {
                $cart_data[$good_id] = 30;
                session()->flash("flash_message", "同じ商品を30個以上購入することはできません");
            } else {
                $cart_data[$good_id] += $quantity;
            }
        } else {
            $cart_data[$good_id] = $quantity;
        }
        $cart_json = json_encode($cart_data);
        Cookie::queue("cart_data", $cart_json, 10080);
        return redirect()
            ->route("cart");
    }

    public function cookie_to_db(array $cart_data, int $login_id): bool
    {
        $cart_count = Cart::where("user_id", $login_id)->count();
        foreach ($cart_data as $good_id => $quantity) {
            $cart = Cart::firstOrNew(["user_id" => $login_id, "good_id" => $good_id]);
            if ($cart->quantity + $quantity > 30) {
                $cart->quantity = 30;
            } else {
                $cart->quantity = ($cart->quantity + $quantity);
            }
            $cart->save();
        }
        return true;
    }
}
