<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $data = Good::inRandomOrder()
                ->whereNull("deleted_at")
                ->limit(24)
                ->get();
        } catch (QueryException $e) {
            return view("error");
        };


        return view("home", compact("data"));

    }
}
