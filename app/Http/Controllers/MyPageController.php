<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\PurchaseHistory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class MyPageController extends Controller
{

    public function show_mypage(){
        $user_data = User::find(session()->get("login_id"));
        return view("mypage", compact("user_data"));
    }

    public function show_purchase_history(){
        $login_id = session()->get("login_id");
        $transaction_data = Transaction::where("user_id", $login_id)
            ->paginate(5);
        $history_data = array();
        foreach ($transaction_data as $item){//トランザクションIDごとに履歴をまとめる
            $history_data[$item->id] = PurchaseHistory::where("transaction_id",$item->id)
                ->get();
            $total_price = 0;
            foreach ($history_data[$item->id] as $good){
                $total_price += $good->quantity * $good->good->good_price;
            }
            $item["total_price"] = $total_price;
        }
        return view("purchase_history", compact("transaction_data", "history_data"));

    }
}
