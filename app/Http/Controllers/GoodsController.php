<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function show_detail(Request $request, $good_id){
        $good_data = Good::where("id",$good_id)
            ->whereNull("deleted_at")
            ->first();
        $good_category_id = $good_data->good_category;
        $relate_goods = Good::where("good_category",$good_category_id)
            ->whereNull("deleted_at")
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view("good_detail", compact("good_data", "relate_goods"));
    }
}
