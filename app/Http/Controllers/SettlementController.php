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

class SettlementController extends Controller
{
    public function address_select()
    {
        if (!preg_match("/.*cart\z/", url()->previous())) {
            redirect()
                ->route("error");
        }
        $login_id = session()->get("login_id");
        if (Cart::where("user_id", $login_id)->doesntExist()) {
            return redirect(url("cart"));
        }
        $address_data = Address::where("user_id", $login_id)
            ->latest("updated_at")
            ->limit(3)
            ->get();
        session()->put(["address_data" => $address_data]);

        return view("settlement_address", compact("address_data"));
    }

    public function confirm(Request $request)
    {
        if (!preg_match("/.*address\z/", url()->previous())) {
            return redirect()
                ->route("error");
        }
        $select_address = $request->input("select_address");
        $address_data = session()->pull("address_data");
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
                "city_street" => "required|string|between:4,25",
                "building" => "present|string|between:1,25",
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
            ]);
        } elseif ($select_address >= 1 || $select_address <= 3) {
            $address = $address_data[$select_address - 1];
            session()->put([
                "address_postcode" => $address->postcode,
                "address_prefecture" => $address->prefecture,
                "address_city_street" => $address->city_street,
                "address_building" => $address->building,
                "address_addressee" => $address->addressee,
                "address_id" => $address->id,
            ]);
        } else {
            return redirect()
                ->route("error");
        }
        session()->put(["payment_method" => $payment_method]);
        $login_id = session()->get("login_id");
        $cart_data = Cart::where("user_id", $login_id)
            ->limit(30)
            ->join("goods", "goods.good_id", "=", "carts.good_id")
            ->oldest("carts.updated_at")
            ->whereNull("goods.deleted_at")
            ->get();
        session()->put(["cart_data" => $cart_data]);


        return view("settlement_confirm");
    }

    public function process()
    {
        if (!preg_match("/.*confirm\z/", url()->previous())) {
            return redirect()
                ->route("error");
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
                foreach ($cart_data as $cart){
                    $goods_id = Good::find($cart->id)
                        ->withTrashed()
                        ->lockForUpdate()
                        ->first();
                    dd($goods_id);
                    if(is_null($goods_id)){
                        throw new \Exception("NOT FOUND GOODS");
                    }
                    if($cart->quantity > $goods_id->good_stock){
                        throw new \Exception("NO STOCK");
                    }
                    //dump($goods_id);

                    //decrement("good_stock", $cart->quantity);
                    //dd($goods_id);
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
            return redirect()
                ->route("error");
        }

        return redirect()
            ->route("home");
    }

}
