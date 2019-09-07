<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Cart;
use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function change_cart(Request $request)
    {
        if ($request->mode == "delete") {
            if (session()->has("login_id")) {
                Cart::where("user_id", session()->get("login_id"))
                    ->where("good_id", $request->good_id)
                    ->delete();
            } else {
                $cart_json = Cookie::get("cart_data");
                $cart_data = json_decode($cart_json, true);
                unset($cart_data[$request->good_id]);
                $cart_data = json_encode($cart_data);
                Cookie::queue("cart_data", $cart_data, 10080);
            }
            return response()->json(["result" => "success"]);


        } elseif ($request->mode == "change") {
            $good_id = $request->good_id;
            $quantity = $request->quantity;
            if($quantity < 0 || $quantity >30){
                return response()->json(["result" => "error_over30"], 400);
            }
            $good = Good::where("good_id", $good_id)->first();
            if(is_null($good)){
                return response()->json(["result" => "error_cantfindgood"], 400);
            }

            if (session()->has("login_id")) {
                $login_id = session()->get("login_id");
                $cart = Cart::where("user_id", $login_id)
                    ->where("good_id", $good_id)
                    ->first();
                if($good->good_stock == 0){
                    try {
                        $cart->delete();
                    } catch (\Exception $e) {
                        return response()->json(["result" => "error_cant_delete"], 500);
                    }
                    return response()->json(["result" => "success", "quantity" => 0, "stock" => 0]);
                }elseif($good->good_stock < $quantity){
                    $cart->fill(["quantity" => $good->good_stock])->save();
                    return response()->json(["result"=>"success", "quantity" => $good->good_stock, "stock"=>$good->good_stock]);
                }else{
                    $cart->fill(["quantity" => $quantity])->save();
                    return response()->json(["result" => "success","quantity"=>$quantity, "stock"=>min(30,$good->good_stock)]);
                }
            }else{
                $cart_json = Cookie::get("cart_data");
                $cart_data = json_decode($cart_json, true);
                if(!array_key_exists($good_id, $cart_data)){
                    return response()->json(["result" => "error_cant_find_key_cookie"], 400);
                }
                if($good->good_stock == 0){
                    unset($cart_data[$good_id]);
                    $cart_data = json_encode($cart_data);
                    Cookie::queue("cart_data", $cart_data, 10080);
                    return response()->json(["result" => "success", "quantity" => 0, "stock" => 0]);
                }elseif($good->good_stock < $quantity){
                    $cart_data[$good_id] = $good->good_stock;
                    $cart_data = json_encode($cart_data);
                    Cookie::queue("cart_data", $cart_data, 10080);
                    return response()->json(["result"=>"success", "quantity" => $good->good_stock, "stock"=>$good->good_stock]);
                }else{
                    $cart_data[$good_id] = $quantity;
                    $cart_data = json_encode($cart_data);
                    Cookie::queue("cart_data", $cart_data, 10080);
                    return response()->json(["result" => "success","quantity"=>$quantity, "stock"=>min(30,$good->good_stock)]);
                }

            }
        } else {
            return response()->json(["result" => "error_cant_mode"], 400);
        }

    }

}
