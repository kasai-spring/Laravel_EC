<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\GoodsCategory;
use App\Models\Publisher;
use App\Models\PurchaseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublisherController extends Controller
{
    public function show_publisher_page(Request $request)
    {
        $publisher_id = Publisher::where("user_id", session()->get("login_id"))->first()->id;
        $sales_history = PurchaseHistory::whereHas("good", function ($q) use ($publisher_id) {
            $q->where("good_publisher", $publisher_id);
        })->latest("created_at")->paginate(24, ["*"], "history_page");
        $mode = $request->mode;
        $select_mode = session()->pull("publisher_select_mode", 0);
        if (!is_null($mode) && 0 <= $mode && 2 >= $mode) {
            $select_mode = $mode;
        }
        $goods_data = Good::where("good_publisher", $publisher_id)->latest("created_at")->paginate(24, ["*"], "goods_page");
        $category_data = GoodsCategory::get();
        return view("publisher", compact("sales_history", "goods_data", "category_data", "select_mode"));
    }

    public function publisher_good_controller(Request $request)
    {
        $mode = $request->input("mode");
        if ($mode == 1) {
            $validator = Validator::make($request->all(), [
                "good_id" => "required|string|size:16",
            ]);
            if ($validator->fails()) {
                session()->put("publisher_select_mode", 1);
                return redirect("publisher");
            }
            $publisher_id = Publisher::where("user_id", session()->get("login_id"))->first()->id;
            $good_id = $request->input("good_id");
            Good::where("good_id", $good_id)->where("good_publisher", $publisher_id)->delete();
            session()->put("publisher_select_mode", 1);
            return redirect("publisher");
        } else if ($mode == 2) {
            $picture = $request->file("good_picture", null);
            $validator = Validator::make($request->all(), [
                "good_name" => "required|string|between:1,32",
                "good_producer" => "required|string|between:1,32",
                "good_price" => "required|integer|between:1,10000000",
                "good_stock" => "required|integer|between:1,100000",
                "good_category" => "required|integer|exists:goods_categories,id",
                "good_picture" => "nullable|image|mimes:jpg,png,jpeg|max:1024"
            ]);
            if ($validator->fails()) {
                session()->put("publisher_select_mode", 2);
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $good_id = strtoupper(Str::random(16));
            while (Good::where("good_id", $good_id)->exists() || preg_match("/\A[0-9]+\z/", $good_id)) {
                $good_id = strtoupper(Str::random(16));
            }
            $publisher_id = Publisher::where("user_id", session()->get("login_id"))->first()->id;
            if(!is_null($picture)){
                $picture_path = $picture->store("public/goods_images");
                $picture_path = preg_replace("/public\/goods_images\//","", $picture_path);
            }else{
                $picture_path = "default.png";
            }
            Good::create([
                "good_id" => $good_id,
                "good_name" => $request->input("good_name"),
                "good_producer" => $request->input("good_producer"),
                "good_publisher" => $publisher_id,
                "good_price" => $request->input("good_price"),
                "good_stock" => $request->input("good_stock"),
                "good_category" => $request->input("good_category"),
                "picture_path" => $picture_path,
            ]);
            session()->put("publisher_select_mode", 1);
            return redirect(url("publisher"));

        } else {
            return redirect(url("publisher"));
        }
    }

    public function show_good_edit($good_id = null)
    {
        if (is_null($good_id)) {
            session()->put("publisher_select_mode", 1);
            return redirect("publisher");
        }
        $good_data = Good::where("good_id", $good_id)->where("good_publisher", session()->get("login_id"))->first();
        if (is_null($good_data)) {
            session()->put("publisher_select_mode", 1);
            return redirect("publisher");
        }
        return view("publisher_edit", compact("good_data"));
    }

    public function good_edit(Request $request, $good_id = null)
    {
        if (is_null($good_id) || !preg_match("/.*\/edit\/" . $good_id . "\z/", url()->previous())) {
            return redirect("publisher");
        }
        $validator = Validator::make($request->all(), [
            "good_name" => "required|string|between:1,32",
            "good_price" => "required|integer|between:1,10000000",
            "good_stock" => "required|integer|between:1,100000",
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        $good_name = $request->input("good_name");
        $good_price = $request->input("good_price");
        $good_stock = $request->input("good_stock");
        //旧データ取得&削除&新データ追加
        $publisher_id = Publisher::where("user_id", session()->get("login_id"))->first()->id;
        $old_good = Good::where("good_id", $good_id)->where("good_publisher", $publisher_id)->first();
        if (is_null($old_good)) {
            return redirect("publisher");
        }
        if ($good_name == $old_good->good_name && $good_price == $old_good->good_price) {
            $old_good->fill(["good_stock" => $good_stock])->save();
            session()->put("publisher_select_mode", 1);
            return redirect("publisher");
        }
        Good::insert([
            "good_id" => $good_id,
            "good_name" => $good_name,
            "good_producer" => $old_good->good_producer,
            "good_publisher" => $publisher_id,
            "good_price" => $good_price,
            "good_stock" => $good_stock,
            "good_category" => $old_good->good_category,
            "picture_path" => $old_good->picture_path,
            "created_at" => $old_good->created_at,
            "updated_at" => now(),
        ]);

        try {
            $old_good->delete();
        } catch (\Exception $e) {
            session()->put("publisher_select_mode", 1);
            return redirect("publisher");
        }

        session()->put("publisher_select_mode", 1);
        return redirect("publisher");
    }
}
