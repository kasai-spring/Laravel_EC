<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function add_random_goods(){
        for($i = 0;$i<100;$i++){
            $good_id = $this->makeRandStr();
            while(Good::where("good_id", $good_id)->exists()){
                $good_id = $this->makeRandStr();
            }
            Good::create([
                "good_id" => $good_id,
                "good_name" => $this->makeRandStr(6),
                "good_producer" => $this->makeRandStr(8)."工場",
                "good_publisher" => $this->makeRandStr(8)."会社",
                "good_price" => mt_rand(1, 100000),
                "good_stock" => mt_rand(1,1000),
                "picture_path" => "default.png",
                "good_category" => mt_rand(1,5),
            ]);
        }
        return redirect()
            ->back();
    }

    function makeRandStr($length = 16) {
        static $chars = 'ABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= $chars[mt_rand(0, 35)];
        }
        return $str;
    }
}
