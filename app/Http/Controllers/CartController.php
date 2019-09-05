<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\User;
use App\Models\Cart;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function show_cart()
    {
        //ログインしてる場合
        if (session()->has("login_id")) {
            $login_id = session()->get("login_id");
            $cart_data = Cart::where("user_id", $login_id)
                ->join("goods", "goods.good_id", "=", "carts.good_id")
                ->whereNull("goods.deleted_at")
                ->whereColumn("goods.good_stock", "<", "carts.quantity")
                ->get();

            if (count($cart_data) > 0) {
                session()->flash("flash_message", "在庫切れのためカート内の一部の商品の数量を変更、もしくは削除しました");
            }
            foreach ($cart_data as $data) {
                if ($data->good_stock == 0) {
                    Cart::where("user_id", $login_id)
                        ->where("good_id", $data->good_id)
                        ->delete();
                } else {
                    $cart = Cart::where("user_id", $login_id)
                        ->where("good_id", $data->good_id)
                        ->first();
                    $cart->fill(["quantity" => $data->good_stock])
                        ->save();
                }
            }

            $cart_data = Cart::where("user_id", $login_id)
                ->join("goods", "goods.good_id", "=", "carts.good_id")
                ->whereNull("goods.deleted_at")
                ->get();

            return view("cart", compact("cart_data"));
        }
        //ログインしてない場合
        $cart_json = \Cookie::get("cart_data");
        $cart_cookie = json_decode($cart_json, true);
        if (is_null($cart_cookie) || count($cart_cookie) == 0) {
            $cart_data = array();
            return view("cart", compact("cart_data"));
        }
        $cart_data = Good::whereNull("deleted_at")//(deleted_atがNull) && (cookieに入ってる商品IDのいずれかと一致する)
        ->where(function ($q) use ($cart_cookie) {
            foreach ($cart_cookie as $good => $quantity) {
                if ($good === array_key_first($cart_cookie)) {
                    $q->where("good_id", $good);
                } else {
                    $q->orWhere("good_id", $good);
                }
            }
        })
            ->get();
        foreach ($cart_data as $good) {//データベースから取得したデータに個数付与
            $good["quantity"] = $cart_cookie[$good->good_id];
        }
        return view("cart", compact("cart_data"));
    }

    public function add_cart(Request $request, $good_id)
    {
        $validator = Validator::make($request->all(), [
            "quantity" => "required|numeric|between:1,30"
        ]);
        if ($validator->fails() ||
            Good::where("good_id", $good_id)->whereNull("deleted_at")->doesntExist()) {
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
        $cart_json = \Cookie::get("cart_data");
        $cart_data = json_decode($cart_json, true);
        if (is_null($cart_data)) {
            $cart_data = array();
        }
        if (count($cart_data) >= 30) {
            return redirect()
                ->back();
        }
        if (array_key_exists($good_id, $cart_data)) {
            if ($cart_data[$good_id] + $quantity > 30) {
                $cart_data[$good_id] = 30;
            } else {
                $cart_data[$good_id] += $quantity;
            }
        } else {
            $cart_data[$good_id] = $quantity;
        }
        $cart_json = json_encode($cart_data);
        \Cookie::queue("cart_data", $cart_json, 10080);
        return redirect()
            ->route("cart");

    }

    public function cookie_to_db(array $cart_data, int $login_id): bool
    {
        $cart_count = Cart::where("user_id", $login_id)->count();
        if ($cart_count > 30) {
            return false;
        }
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
