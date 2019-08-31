<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $data = Goods::inRandomOrder()
                ->whereNull("deleted_at")
                ->limit(24)
                ->get();
        } catch (QueryException $e) {
            return view("error");
        };


        return view("home", compact("data"));

    }
}
