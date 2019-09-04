<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function show_detail(Request $request, $good_id){
        if(!preg_match("/[0-9A-Za-z]+/", $good_id)){
            return redirect()
                ->route("error");
        }
        $good_data = Good::where("good_id",$good_id)
            ->whereNull("deleted_at")
            ->first();
        if($good_data == null){
            return redirect()
                ->route("home");
        }
        $relate_goods = Good::where("good_category",$good_data->good_category)
            ->whereNull("deleted_at")
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view("good_detail", compact("good_data", "relate_goods"));
    }
}
