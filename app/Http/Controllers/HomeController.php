<?php

namespace App\Http\Controllers;
use App\Models\Goods;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data = Goods::inRandomOrder()
            ->limit(24)
            ->get();

    }
}
