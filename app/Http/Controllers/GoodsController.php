<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\GoodsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoodsController extends Controller
{
    public function show_detail(Request $request, $good_id)
    {
        if (!preg_match("/[0-9A-Za-z]+/", $good_id)) {
            return redirect()
                ->route("error");
        }
        $good_data = Good::where("good_id", $good_id)
            ->whereNull("deleted_at")
            ->first();
        if ($good_data == null) {
            return redirect()
                ->route("home");
        }
        $relate_goods = Good::where("good_category", $good_data->good_category)
            ->whereNull("deleted_at")
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view("good_detail", compact("good_data", "relate_goods"));
    }

    public function search_good(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "q" => "nullable|string|max:32",
            "category" => "nullable|integer",
            "sort" => "nullable|integer|between:0,3"
        ]);

        $sort = $request->input("sort");
        if (is_null($sort)) {
            $sort = 0;
        }
        if ($sort == 1) {
            $query = Good::oldest("created_at");
        } elseif ($sort == 2) {
            $query = Good::orderBy("good_price");
        } elseif ($sort == 3) {
            $query = Good::orderByDesc("good_price");
        } else {
            $query = Good::latest("created_at");
        }
        if (!$validator->fails()) {
            $category_id = $request->input("category");
            if (is_null($category_id)) {
                $category_id = 0;
            }
        } else {
            $category_id = 0;
        }
        if ($category_id != 0) {
            $query->where("good_category", $category_id);
        }
        $q = $request->input("q");

        if (!is_null($q) && !$validator->failed()) {
            $search_list = explode(" ", preg_replace("/　/", " ", $q));
            foreach ($search_list as $word) {
                $word = "%" . $word . "%";
                $query->where(function ($q) use ($word) {
                    $q->where("good_name", "like", $word)
                        ->orWhere("good_producer", "like", $word)
                        ->orWhereHas("publisher", function ($q) use ($word) {
                            $q->where("publisher_name", "like", $word);
                        });
                });
            }
        }

        $category_data = GoodsCategory::get();
        $goods_data = $query->paginate(24);
        return view("search_result", compact("goods_data", "q", "category_data", "category_id", "sort"));
    }
}
