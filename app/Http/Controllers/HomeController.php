<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $data = Good::inRandomOrder()
                ->where("good_stock", "!=", 0)
                ->limit(24)
                ->get();
        } catch (QueryException $e) {
            return redirect()->route("error");
        };
        return view("home", compact("data"));
    }

    public function inquiry(Request $request)
    {
        $rule = ["option" => "required|integer|between:0,3",
            "subject" => "required|string|between:1,15",
            "content" => "required|string|between:15,1000"];
        if (!session()->has("login_id")) {
            $rule = $rule + ["email" => "required|string|email:rfc|between:5,255", "user_name" => "required|string|between:1,8"];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }
        if (session()->has("login_id")) {
            $login_id = session()->get("login_id");
            $email = null;
            $user_name = null;
        } else {
            $login_id = null;
            $email = $request->input("email");
            $user_name = $request->input("user_name");
        }
        switch ($request->input("option")) {
            case 0:
                $option = "ご意見・ご要望";
                break;
            case 1:
                $option = "アカウントについて";
                break;
            case 2:
                $option = "決済について";
                break;
            case 3:
                $option = "その他";
                break;
            default:
                return redirect()->route("error");
        }
        $subject = $request->input("subject");
        $content = $request->input("content");
        session()->put([
            "inquiry_user_id" => $login_id,
            "inquiry_user_name" => $user_name,
            "inquiry_email" => $email,
            "inquiry_option" => $option,
            "inquiry_subject" => $subject,
            "inquiry_content" => $content,
        ]);
        return view("inquiry_confirm");
    }

    public function confirm_back()
    {
        $user_name = session()->pull("inquiry_user_name");
        $email = session()->pull("inquiry_email");
        switch (session()->pull("inquiry_option")) {
            case "ご意見・ご要望":
                $option = 0;
                break;
            case "アカウントについて":
                $option = 1;
                break;
            case "決済について":
                $option = 2;
                break;
            case "その他":
                $option = 3;
                break;
            default:
                return redirect()->route("error");
        }
        $subject = session()->pull("inquiry_subject");
        $content = session()->pull("inquiry_content");
        session()->forget("inquiry_user_id");
        session()->flashInput(["user_name" => $user_name, "email" => $email, "option" => $option, "subject" => $subject,
            "content" => $content]);
        return redirect("inquiry");
    }

    public function inquiry_complete()
    {
        if (!preg_match("/.*confirm\z/", url()->previous())) {
            return redirect()->route("home");
        }
        $login_id = session()->pull("inquiry_user_id");
        $user_name = session()->pull("inquiry_user_name");
        $email = session()->pull("inquiry_email");
        $option = session()->pull("inquiry_option");
        $subject = session()->pull("inquiry_subject");
        $content = session()->pull("inquiry_content");
        session()->forget("inquiry_user_id");
        Inquiry::create([
            "user_id" => $login_id,
            "user_name" => $user_name,
            "email" => $email,
            "option" => $option,
            "subject" => $subject,
            "content" => $content,
        ]);
        return redirect("inquiry/complete");
    }

    public function show_inquiry_complete()
    {
        if (!preg_match("/.*confirm\z/", url()->previous())) {
            return redirect()->route("home");
        }
        return view("inquiry_complete");
    }
}
