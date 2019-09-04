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
    public function __construct()
    {
        $this->middleware("normal_user"); //todo 一時的 のちにCookie実装
    }

    public function show_cart(){
        $login_id = session()->get("login_id");
        $cart_data = Cart::where("user_id", $login_id)
            ->join("goods","goods.good_id","=","carts.good_id")
            ->whereNull("goods.deleted_at")
            ->get();

        return view("cart", compact("cart_data"));
    }

    public function add_cart(Request $request, $good_id)
    {

        $validator = Validator::make($request->all(), [
            "quantity" => "required|numeric|between:1,30"
        ]);
        $login_id = session()->get("login_id");
        if ($validator->fails() || !Good::where("good_id",$good_id)->whereNull("deleted_at")->exists() ||
            !User::find($login_id)->whereNull("deleted_at")->exists())
        {
            return redirect()
                ->route("error");
        }

        try {
            Cart::create([
                "user_id" => $login_id,
                "good_id" => $good_id,
                "quantity" => $request->input("quantity"),
            ]);
        } catch (QueryException $e) {
            return redirect()
                ->route("home");
        }

        return redirect()
            ->route("home");
    }
}
