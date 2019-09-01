<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\User;
use App\Models\Carts;

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
        $cart_data = Carts::where("user_id",$login_id)
            ->get();
    }

    public function add_cart(Request $request, $good_id)
    {
        $validator = Validator::make($request->all(), [
            "count" => "required|digits_between:1,30"
        ]);
        $login_id = session()->get("login_id");
        if ($validator->fails() || !Goods::find($good_id)->whereNull("deleted_at")->exists() ||
            !User::find($login_id)->whereNull("deleted_at")->exists()) {
            return redirect()
                ->route("error");
        }


        try {
            Carts::create([
                "user_id" => $login_id,
                "good_id" => $good_id,
                "good_count" => $request->input("count"),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        } catch (QueryException $e) {
            return redirect()
                ->route("error");
        }

        return redirect()
            ->route("home");
    }
}
