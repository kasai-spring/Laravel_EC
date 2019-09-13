<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Publisher;
use App\Models\PurchaseHistory;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function show_publisher_page(){
        $publisher_id = Publisher::where("user_id", session()->get("login_id"))->first()->id;
        $sales_history = PurchaseHistory::whereHas("good", function($q) use ($publisher_id) {
            $q->where("good_publisher", $publisher_id);
        })->get();
        $goods_data = Good::where("good_publisher", $publisher_id)->get();
        return view("publisher", compact("sales_history","goods_data"));
    }
}
