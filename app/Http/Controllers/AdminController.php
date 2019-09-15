<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\GoodsCategory;
use App\Models\Inquiry;
use App\Models\Publisher;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function show_admin_form(Request $request)
    {
        $mode = $request->mode;
        $select_mode = session()->pull("admin_select_mode", 0);
        if (!is_null($mode) && $mode >= 0 && $mode <= 3) {
            $select_mode = $mode;
        }
        $user_data = User::latest("created_at")->paginate(24, ["*"], "user_page");
        foreach ($user_data as $user) {
            if (UserRole::where("user_id", $user->id)->where("role_id", 1)->exists()) {
                $user["Admin"] = 1;
            } else {
                $user["Admin"] = 0;
            }
            if (UserRole::where("user_id", $user->id)->where("role_id", 2)->exists()) {
                $user["Publisher"] = 1;
            } else {
                $user["Publisher"] = 0;
            }
        }
        $goods_data = Good::latest("created_at")->paginate(24, ["*"], "good_page");
        $inquiry_data = Inquiry::latest("created_at")->paginate(12, ["*"], "inquiry_page");
        return view("admin", compact("select_mode", "user_data", "goods_data", "inquiry_data"));
    }

    public function edit_from_form(Request $request)
    {
        $mode = $request->input("mode", 99);
        if ($mode == 0) {
            $validator = Validator::make($request->all(), [
                "user_email" => "required|string|email:rfc"
            ]);
            if ($validator->fails()) {
                return redirect("admin");
            }
            $user = User::where("email", $request->input("user_email"))->first();
            if (session()->get("login_id") == $user->id) {
                //ログイン中のアカウントは削除させない
                return redirect("admin");
            }
            try {
                $user->delete();
            } catch (\Exception $e) {
                return redirect("admin");
            }
            return redirect("admin");
        } else if ($mode == 1) {
            $rule = [
                "user_name" => "required|string|between:2,8",
                "email" => "required|string|email:rfc|unique:users|max:255",
                "password" => "required|string|between:6,32|regex:/[ -~]+/|confirmed",
                "user_type" => "required|integer|between:0,3"
            ];
            $user_type = $request->input("user_type", 99);
            if ($user_type == 1 || $user_type == 3) {
                $rule = array_merge($rule, ["company_name" => "required|string|between:2,16"]);
            }
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                session()->put(["admin_select_mode" => 1]);
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user = User::create([
                "email" => $request->input("email"),
                "password" => Hash::make($request->input("password")),
                "user_name" => $request->input("user_name"),
            ]);
            if ($user_type == 1 || $user_type == 3) {
                UserRole::create([
                    "role_id" => 2,
                    "user_id" => $user->id,
                ]);
                $publisher_id = strtoupper(Str::random(16));
                while (Publisher::where("publisher_id", $publisher_id)->exists()) {
                    $publisher_id = strtoupper(Str::random(16));
                }
                Publisher::create([
                    "publisher_id" => $publisher_id,
                    "user_id" => $user->id,
                    "publisher_name" => $request->input("company_name")
                ]);
            }
            if ($user_type == 2 || $user_type == 3) {
                UserRole::create([
                    "role_id" => 1,
                    "user_id" => $user->id,
                ]);
            }
            return redirect("admin");

        } else if ($mode == 2) {
            $validator = Validator::make($request->all(), [
                "good_id" => "required|string|size:16"
            ]);
            if ($validator->fails()) {
                return redirect("admin");
            }
            Good::where("good_id", $request->input("good_id"))->delete();
            session()->put(["admin_select_mode" => 2]);
            return redirect("admin");
        } else {
            return redirect("admin");
        }
    }

    public function show_edit_user($user_id = null)
    {
        if (is_null($user_id) || $user_id == session()->get("login_id")) {
            return redirect("admin");
        }
        $user_data = User::find($user_id);
        if (is_null($user_data)) {
            return redirect("admin");
        }
        $is_publisher = UserRole::where("user_id", $user_id)->where("role_id", 2)->exists();
        $is_admin = UserRole::where("user_id", $user_id)->where("role_id", 1)->exists();
        $publisher_name = null;
        if ($is_admin && $is_publisher) {
            $user_type = 3;
            $publisher_name = Publisher::where("user_id", $user_id)->first()->publisher_name;
        } else if ($is_admin) {
            $user_type = 2;
        } else if ($is_publisher) {
            $user_type = 1;
            $publisher_name = Publisher::where("user_id", $user_id)->first()->publisher_name;
        } else {
            $user_type = 0;
        }

        return view("admin_edit_user", compact("user_data", "user_type", "user_id", "publisher_name"));
    }

    public function edit_user(Request $request, $user_id = null)
    {
        if (is_null($user_id) || !preg_match("/.*\/user_edit\/" . $user_id . "\z/", url()->previous()) || $user_id == session()->get("login_id")) {
            return redirect("home");
        }
        $rule = [
            "user_name" => "required|string|between:2,8",
            "email" => [Rule::unique("users")->where(function ($q) use ($user_id) {
                $q->where("id", "!=", $user_id);
            }), "required", "string", "email:rfc", "max:255"],
            "password" => "nullable|string|between:6,32|regex:/[ -~]+/|confirmed"
        ];
        if (Publisher::where("user_id", $user_id)->exists() || !is_null($request->input("publisher"))) {
            $rule = array_merge($rule, ["company_name" => "required|string|between:1,16"]);
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        $user = User::find($user_id);
        if (is_null($request->input("password"))) {
            $user->fill(["email" => $request->input("email"), "user_name" => $request->input("user_name")])->save();
        } else {
            $user->fill(["email" => $request->input("email"), "user_name" => $request->input("user_name"), "password" => Hash::make($request->input("password"))])->save();
        }
        if (Publisher::where("user_id", $user_id)->exists() || !is_null($request->input("publisher"))) {
            $publisher = Publisher::where("user_id", $user_id)->first();
            if (is_null($publisher)) {
                $publisher_id = strtoupper(Str::random(16));
                while (Publisher::where("publisher_id", $publisher_id)->exists()) {
                    $publisher_id = strtoupper(Str::random(16));
                }
                Publisher::create([
                    "publisher_id" => $publisher_id,
                    "user_id" => $user_id,
                    "publisher_name" => $request->input("company_name")
                ]);
                UserRole::create([
                    "user_id" => $user_id,
                    "role_id" => 2
                ]);
            } else {
                $publisher->fill(["publisher_name" => $request->input("company_name")])->save();
            }
        }
        if (is_null($request->input("admin"))) {
            UserRole::where("user_id", $user_id)->where("role_id", 1)->delete();
        } else {
            UserRole::firstOrCreate([
                "user_id" => $user_id,
                "role_id" => 1
            ], [
                "user_id" => $user_id,
                "role_id" => 1
            ]);
        }
        return redirect("admin");
    }

    public function show_edit_good($good_id = null)
    {
        if (is_null($good_id)) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        $good_data = Good::where("good_id", $good_id)->first();
        $category_data = GoodsCategory::get();
        if (is_null($good_data)) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        return view("admin_edit_good", compact("good_data", "category_data"));
    }

    public function edit_good(Request $request, $good_id = null)
    {
        if (is_null($good_id) || !preg_match("/.*\/good_edit\/" . $good_id . "\z/", url()->previous())) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        $validator = Validator::make($request->all(), [
            "good_name" => "required|string|between:1,16",
            "good_price" => "required|integer|between:1,10000000",
            "good_stock" => "required|integer|between:1,100000",
            "good_category" => "required|integer|exists:goods_categories,id",
            "good_producer" => "required|string|between:1,16",
        ]);
        if ($validator->fails()) {
            session()->put("admin_select_mode", 2);
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $old_good = Good::where("good_id", $good_id)->first();
        if (is_null($old_good)) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        $good_name = $request->input("good_name");
        $good_price = $request->input("good_price");
        $good_stock = $request->input("good_stock");
        $good_category = $request->input("good_category");
        $good_producer = $request->input("good_producer");
        if ($good_name == $old_good->good_name && $good_price == $old_good->good_price && $good_category == $old_good->good_category && $good_producer && $old_good->good_producer) {
            $old_good->fill(["good_stock" => $good_stock])->save();
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        Good::insert([
            "good_id" => $old_good->good_id,
            "good_name" => $good_name,
            "good_producer" => $good_producer,
            "good_publisher" => $old_good->good_publisher,
            "good_price" => $good_price,
            "good_stock" => $good_stock,
            "good_category" => $good_category,
            "picture_path" => $old_good->picture_path,
            "created_at" => $old_good->created_at,
            "updated_at" => now(),
        ]);
        try {
            $old_good->delete();
        } catch (\Exception $e) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }

        session()->put("admin_select_mode", 2);
        return redirect("admin");
    }
}
