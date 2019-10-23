<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\GoodsCategory;
use App\Models\Inquiry;
use App\Models\Publisher;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $user = new User();
        try {
            $user_data = $user->getUsersDataPage($request->user_page);
            $user_role = new UserRole();
            foreach ($user_data as $user) {
                if ($user_role->isAdmin($user->id)) {
                    $user["Admin"] = 1;
                } else {
                    $user["Admin"] = 0;
                }
                if ($user_role->isPublisher($user->id)) {
                    $user["Publisher"] = 1;
                } else {
                    $user["Publisher"] = 0;
                }
            }
            $good = new Good();
            $goods_data = $good->getGoodsDataPage($request->good_page);
            $inquiry = new Inquiry();
            $inquiry_data = $inquiry->getInquiryData($request->inquiry_page);
        } catch (\Exception $e) {
            return redirect()->route("error");
        }
        return view("admin", compact("select_mode", "user_data", "goods_data", "inquiry_data"));
    }

    public function edit_from_form(Request $request)
    {
        $mode = $request->input("mode", 99); // 99はエラー時の数字
        if ($mode == 0) {
            $validator = Validator::make($request->all(), [
                "user_email" => "required|string|email:rfc"
            ]);
            if ($validator->fails()) {
                return redirect("admin");
            }
            $user = new User();
            try {
                if (!$user->deleteUserData($request->input("user_email"), session()->get("login_id"))) {
                    return redirect("admin");//ログイン中のアカウントを削除しようとしたからエラー
                }
            } catch (\Exception $e) {
                return redirect("admin");//SQLエラー
            }
            return redirect("admin");
        } else if ($mode == 1) {
            $rule = [
                "user_name" => "required|string|between:2,8",
                "email" => "required|string|email:rfc|unique:users|max:255",
                "password" => "required|string|between:6,32|regex:/[ -~]+/|confirmed",
                "user_type" => "required|integer|between:0,3"
            ];
            $user_type = $request->input("user_type", 0);
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
            try {
                DB::transaction(function () use ($request, $user_type) {
                    $user = new User();
                    $user_id = $user->createUserData($request->input("email"), $request->input("password"),
                        $request->input("user_name"));
                    $user_role = new UserRole();
                    if ($user_type == 1 || $user_type == 3) {
                        $user_role->userRoleCreate($user_id, 2);
                        $publisher = new Publisher();
                        $publisher->createPublisherData($user_id, $request->input("company_name"));
                    }
                    if ($user_type == 2 || $user_type == 3) {
                        $user_role->userRoleCreate($user_id, 1);
                    }
                });
            } catch (\Throwable $e) {
                return redirect()->route("error");
            }
            return redirect("admin");

        } else if ($mode == 2) {
            $validator = Validator::make($request->all(), [
                "good_id" => "required|string|size:16"
            ]);
            if ($validator->fails()) {
                return redirect("admin");
            }
            $good = new Good();
            try {
                $good->deleteGoodsData($request->input("good_id"));
            } catch (\Exception $e) {
                return redirect()->route("error");
            }
            session()->put(["admin_select_mode" => 2]);
            return redirect("admin");
        } else {
            return redirect()->route("error");
        }
    }

    public function show_edit_user($user_id = null)
    {
        if (is_null($user_id) || $user_id == session()->get("login_id")) {//ログイン中のアカウントは編集させない
            return redirect("admin");
        }
        $user = new User();
        $user_data = $user->getUserData($user_id);
        if (is_null($user_data)) {
            return redirect("admin");
        }
        $user_role = new UserRole();
        $is_publisher = $user_role->isPublisher($user_id);
        $is_admin = $user_role->isAdmin($user_id);
        $publisher_name = null;
        $publisher = new Publisher();
        if ($is_admin && $is_publisher) {
            $user_type = 3;
            $publisher_name = $publisher->getPublisherData($user_id)->publisher_name;
        } else if ($is_admin) {
            $user_type = 2;
        } else if ($is_publisher) {
            $user_type = 1;
            $publisher_name = $publisher->getPublisherData($user_id)->publisher_name;
        } else {
            $user_type = 0;
        }

        return view("admin_edit_user", compact("user_data", "user_type", "user_id", "publisher_name"));
    }

    public function edit_user(Request $request, $user_id = null)
    {
        if (is_null($user_id) || !preg_match("/.*\/user_edit\/" . $user_id . "\z/", url()->previous()) ||
            $user_id == session()->get("login_id")) {
            return redirect("home");
        }
        $rule = [
            "user_name" => "required|string|between:2,8",
            "email" => [Rule::unique("users")->where(function ($q) use ($user_id) {
                $q->where("id", "!=", $user_id);
            }), "required", "string", "email:rfc", "max:255"],
            "password" => "nullable|string|between:6,32|regex:/[ -~]+/|confirmed"
        ];
        try {
            $user_role = new UserRole();
            $is_publisher = $user_role->isPublisher($user_id);
        } catch (\Exception $e) {
            return redirect()->route("error");
        }
        if ($is_publisher || !is_null($request->input("publisher"))) {
            $rule = array_merge($rule, ["company_name" => "required|string|between:1,16"]);
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        try {
            DB::transaction(function () use ($user_id, $request, $is_publisher, $user_role) {
                $user = new User();
                $user->updateUserData($user_id, $request->input("email"), $request->input("user_name"),
                    $request->input("password"));
                $publisher = new Publisher();
                if ($is_publisher) {//すでにパブリッシャーで、更新する場合
                    $publisher->updatePublisherData($user_id, $request->input("company_name"));
                } elseif (!is_null($request->input("publisher"))) {//パブリッシャー新規登録
                    $user_role->userRoleCreate($user_id, 2);
                    $publisher->createPublisherData($user_id, $request->input("company_name"));
                }
                $is_admin = $user_role->isAdmin($user_id);
                if (is_null($request->input("admin")) && $is_admin) {
                    $user_role->userRoleDelete($user_id, 1);
                } else if (!is_null($request->input("admin")) && !$is_admin) {
                    $user_role->userRoleCreate($user_id, 1);
                }
            });
        } catch (\Throwable $e) {
            return redirect()->route("error");
        }

        return redirect("admin");
    }

    public function show_edit_good($good_id = null)
    {
        if (is_null($good_id)) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        $good = new Good();
        $good_data = $good->getGoodData($good_id);
        $goods_category = new GoodsCategory();
        $category_data = $goods_category->getGoodsCategory();
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
            "good_name" => "required|string|between:1,32",
            "good_price" => "required|integer|between:1,10000000",
            "good_stock" => "required|integer|between:1,100000",
            "good_category" => "required|integer|exists:goods_categories,id",
            "good_producer" => "required|string|between:1,32",
        ]);
        if ($validator->fails()) {
            session()->put("admin_select_mode", 2);
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $good = new Good();
        $old_good = $good->getGoodData($good_id);
        if (is_null($old_good)) {
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        $good_name = $request->input("good_name");
        $good_price = $request->input("good_price");
        $good_stock = $request->input("good_stock");
        $good_category = $request->input("good_category");
        $good_producer = $request->input("good_producer");
        if ($good_name == $old_good->good_name && $good_price == $old_good->good_price &&
            $good_category == $old_good->good_category && $good_producer == $old_good->good_producer) {//在庫のみが変更されてる場合
            try {
                $good->goodStockChanger($old_good->id, $good_stock);
            } catch (\Exception $e) {
                return redirect()->route("error");
            }
            session()->put("admin_select_mode", 2);
            return redirect("admin");
        }
        try {
            $good->updateGoodData($old_good->id, $good_name, $good_price, $good_stock, $good_producer, $good_category);
        } catch (\Exception $e) {
            return redirect()->route("error");
        }
        session()->put("admin_select_mode", 2);
        return redirect("admin");
    }
}
