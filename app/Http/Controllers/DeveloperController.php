<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeveloperController extends Controller
{
    public function add_random_goods(){
        for($i = 0;$i<100;$i++){
            $good_id = strtoupper(Str::random(16));
            while(Good::where("good_id", $good_id)->exists() || preg_match("/\A[0-9]+\z/", $good_id)){
                $good_id = strtoupper(Str::random(16));
            }
            Good::create([
                "good_id" => $good_id,
                "good_name" => strtoupper(Str::random(6)),
                "good_producer" => strtoupper(Str::random(8))."工場",
                "good_publisher" => mt_rand(1,11),
                "good_price" => mt_rand(1, 30000),
                "good_stock" => mt_rand(1,100),
                "picture_path" => "default.png",
                "good_category" => mt_rand(1,8),
            ]);
        }
        return redirect()
            ->back();
    }

}
