<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware("normal_user");
    }

    public function address_select(){
        $login_id = session()->get("login_id");
        session()->put(["settlement_start_time" => Carbon::now()]);
        $cart_data = Carts::where("user_id", $login_id)
            ->get();
        if(count($cart_data) == 0){
            return redirect()
                ->route("error");
        }
        $address_data = Addresses::where("user_id",$login_id)
            ->whereNull("deleted_at")
            ->get();

        return view("settlement_address", compact("address_data"));
    }

    public function confirm(Request $request){
        $login_id = session()->get("login_id");
        $settlement_start_time = session()->get("settlement_start_time");
        $cart_data = Carts::where("user_id",$login_id);
    }
}
