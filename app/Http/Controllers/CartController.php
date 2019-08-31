<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Carts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function add_cart(Request $request, $good_id){
        $validator = Validator::make($request->all(),[
            "count" => "required|digits_between:1,30"
            ]);
        if($validator->fails()){
            return redirect()
                ->route("error");
        }
        $login_email = session()->get("login_id");
        //todo ログインIDを取得してカートテーブルに入れる。もしIDが存在しなかったらエラーページに飛ばす

    }
}
