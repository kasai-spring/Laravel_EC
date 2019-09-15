<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Good;
use App\Models\PurchaseHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettlementController extends Controller
{
    public function post_address_select()
    {
        if (!preg_match("/.*confirm\z/", url()->previous())) {
            return redirect(url("cart"));
        }
        $login_id = session()->get("login_id");
        if (Cart::where("user_id", $login_id)->doesntExist()) {
            return redirect()->back();
        }
        $address_data = Address::where("user_id", $login_id)
            ->latest("updated_at")
            ->limit(3)
            ->get();
        session()->put(["address_data" => $address_data]);
        switch (session()->pull("payment_method")) {
            case "クレジットカード":
                $payment_method = 1;
                break;
            case "口座振替":
                $payment_method = 2;
                break;
            case "代金引換":
                $payment_method = 3;
                break;
            default:
                $payment_method = 1;
        }
        if (session()->pull("address_id") === 0) {
            $postcode = session()->pull("address_postcode");
            $prefecture = session()->pull("address_prefecture");
            $city_street = session()->pull("address_city_street");
            $building = session()->pull("address_building");
            $addressee = session()->pull("address_addressee");
        } else {
            $postcode = null;
            $prefecture = null;
            $city_street = null;
            $building = null;
            $addressee = null;
        }

        $iteration_id = session()->pull("iteration_id");
        session()->forget("address_id");

        return view("settlement_address", compact("address_data", "payment_method", "postcode", "prefecture", "city_street", "building", "addressee", "iteration_id"));
    }

    public function get_address_select()
    {
        if (!preg_match("/.*address\z/", url()->previous()) && !preg_match("/.*cart\z/", url()->previous())) {
            return redirect(url("cart"));
        }

        $login_id = session()->get("login_id");

        if (Cart::where("user_id", $login_id)->doesntExist()) {
            return redirect()->route("cart");
        }
        $address_data = Address::where("user_id", $login_id)
            ->latest("updated_at")
            ->limit(3)
            ->get();
        session()->put(["address_data" => $address_data]);


        return view("settlement_address", compact("address_data"));
    }

    public function get_confirm()
    {
        if (!preg_match("/.*confirm\z/", url()->previous()) && !preg_match("/.*address\z/", url()->previous())) {
            return redirect(url("cart"));
        }
        $login_id = session()->get("login_id");
        $check_data = $this->stock_checker($login_id);
        $cart_data = $check_data[0];
        if (count($cart_data) == 0) {
            session()->flash("flash_message", "在庫切れのため商品を削除した結果、カート内に商品がなくなりました");
            return redirect()->route("cart");
        }
        $total_price = 0;
        foreach ($cart_data as $cart){
            $total_price += $cart->quantity * $cart->good_price;
        }
        $cart_token = Str::random(32);
        if ($check_data[1]) {
            session()->flash("flash_message", "在庫切れのため商品数を変更しました");
        }
        session()->put(["cart_data" => $cart_data, "cart_token" => $cart_token, "total_price" => $total_price]);
        return view("settlement_confirm");
    }

    public function post_confirm(Request $request)
    {
        if (!preg_match("/.*address\z/", url()->previous())) {
            return redirect(url("cart"));
        }
        $select_address = $request->input("select_address");
        $login_id = session()->get("login_id");
        $address_data = session()->get("address_data");
        switch ($request->input("payment")) {
            case 1:
                $payment_method = "クレジットカード";
                break;
            case 2:
                $payment_method = "口座振替";
                break;
            case 3:
                $payment_method = "代金引換";
                break;
            default:
                return redirect()
                    ->route("error");
        }
        if ($select_address == 0) { //住所を入力した場合
            $validator = Validator::make($request->all(), [
                "postcode" => "required|digits:7",
                "prefecture" => "required|string|between:3,4",
                "city_street" => "required|string|between:4,29",
                "building" => "nullable|string|between:1,20",
                "addressee" => "required|string|between:2,16",
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput($request->all());
            }
            session()->put([
                "address_postcode" => $request->input("postcode"),
                "address_prefecture" => $request->input("prefecture"),
                "address_city_street" => $request->input("city_street"),
                "address_building" => $request->input("building"),
                "address_addressee" => $request->input("addressee"),
                "address_id" => 0,
                "iteration_id" => $select_address,
            ]);
        } elseif ($select_address >= 1 || $select_address <= 3) {
            $address = $address_data[$select_address - 1];
            if (Address::where("user_id", $login_id)->where("id", $address->id)->doesntExist()) {
                return redirect()->route("error");
            }
            session()->put([
                "address_postcode" => $address->postcode,
                "address_prefecture" => $address->prefecture,
                "address_city_street" => $address->city_street,
                "address_building" => $address->building,
                "address_addressee" => $address->addressee,
                "address_id" => $address->id,
                "iteration_id" => $select_address,
            ]);
        } else {
            return redirect()->route("error");
        }
        session()->put(["payment_method" => $payment_method]);

        return redirect("settlement/confirm");
    }

    public function process(Request $request)
    {
        if ($request->input("cart_token") != session()->get("cart_token") ||
            !preg_match("/.*confirm\z/", url()->previous())) {
            return redirect(url("cart"));
        }
        try {
            DB::transaction(function () {
                $address_id = session()->get("address_id");
                $login_id = session()->get("login_id");
                if ($address_id == 0) {
                    $address = Address::create([
                        "user_id" => $login_id,
                        "postcode" => session()->get("address_postcode"),
                        "prefecture" => session()->get("address_prefecture"),
                        "city_street" => session()->get("address_city_street"),
                        "building" => session()->get("address_building"),
                        "addressee" => session()->get("address_addressee")
                    ]);

                    $address_id = $address->id;
                }
                $payment_method = session()->get("payment_method");
                $transaction = Transaction::create([
                    "user_id" => $login_id,
                    "payment_method" => $payment_method,
                ]);
                $cart_data = session()->get("cart_data");
                foreach ($cart_data as $cart) {
                    $goods_id = Good::lockForUpdate()
                        ->find($cart->id);
                    if (is_null($goods_id)) {
                        throw new \Exception("NOT FOUND GOODS");
                    }
                    if ($cart->quantity > $goods_id->good_stock) {
                        throw new \Exception("NO STOCK");
                    }
                    $goods_id->decrement("good_stock", $cart->quantity);
                    PurchaseHistory::create([
                        "user_id" => $login_id,
                        "good_id" => $cart->id,
                        "quantity" => $cart->quantity,
                        "address_id" => $address_id,
                        "transaction_id" => $transaction->id
                    ]);
                    Cart::where("good_id", $cart->good_id)
                        ->where("user_id", $login_id)
                        ->delete();
                }

            });
        } catch (\Throwable $e) {
            return redirect()->back();
        }

        session()->forget(["cart_token", "address_id", "address_postcode", "address_prefecture", "address_city_street", "address_building", "address_addressee", "payment_method"]);

        return redirect(url("settlement/complete"));
    }

    public function complete()
    {
        if (!preg_match("/.*confirm\z/", url()->previous())) {
            return redirect(url("home"));
        }

        return view("settlement_complete");
    }

    public function stock_checker($login_id)
    {
        $cart_data = Cart::where("user_id", $login_id)
            ->join("goods", "goods.good_id", "=", "carts.good_id")
            ->oldest("carts.created_at")
            ->whereNull("goods.deleted_at")
            ->get();
        $quantity_change = false;
        foreach ($cart_data as $key => $cart) {
            if ($cart->good_stock < $cart->quantity) {
                $cart_q = Cart::where("user_id", $login_id)->where("good_id", $cart->good_id)
                    ->first();
                $quantity_change = true;
                if ($cart->good_stock == 0) {
                    unset($cart_data[$key]);
                    try {
                        $cart_q->delete();
                    } catch (\Exception $e) {
                        return redirect()
                            ->route("error");
                    }
                } else {
                    $cart->quantity = $cart->good_stock;
                    $cart->save();
                    $cart_q->fill(["quantity" => $cart->good_stock])->save();
                }
            }
        }
        return array($cart_data, $quantity_change);
    }

}
