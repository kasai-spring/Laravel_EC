<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SettlementController extends Controller
{
    public function address_select(){
        $login_id = session()->get("login_id");
        $cart_data = Cart::where("user_id", $login_id)
            ->get();
        if(count($cart_data) == 0){
            return redirect()
                ->route("error");
        }
        $address_data = Address::where("user_id",$login_id)
            ->orderBy("created_at","desc")
            ->limit(3)
            ->get();

        return view("settlement_address", compact("address_data"));
    }

    public function confirm(Request $request){
        if($request->input("select_address") == 0){
            $validator = Validator::make($request->all(),[

            ]);
        }
        $login_id = session()->get("login_id");
        $cart_data = Cart::where("user_id",$login_id)
            ->limit(30)
            ->orderByDesc("updated_at")
            ->get();
        session()->put(["cart_data" => $cart_data]);
        Address::create([
            "user_id" => $login_id,
            "postcode" => $request->input("postcode"),
            "prefecture" => $request->input("prefecture"),
            "city_street" => $request->input("address"),
            "building" => $request->input("building"),
            "addressee" => $request->input("addressee")
        ]);

        return view("home");
    }
}
