<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\PurchaseHistory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MyPageController extends Controller
{

    public function show_mypage(){
        $user_data = User::find(session()->get("login_id"));
        return view("mypage", compact("user_data"));
    }

    public function show_purchase_history(){
        $login_id = session()->get("login_id");
        $transaction_data = Transaction::where("user_id", $login_id)
            ->paginate(5);
        $history_data = array();
        foreach ($transaction_data as $item){//トランザクションIDごとに履歴をまとめる
            $history_data[$item->id] = PurchaseHistory::where("transaction_id",$item->id)
                ->get();
            $total_price = 0;
            foreach ($history_data[$item->id] as $good){
                $total_price += $good->quantity * $good->good->good_price;
            }
            $item["total_price"] = $total_price;
        }
        return view("purchase_history", compact("transaction_data", "history_data"));
    }

    public function show_setting_name(){
        $user_name = User::find(session()->get("login_id"))->user_name;
        return view("setting_name", compact("user_name"));
    }

    public function setting_name(Request $request){
        if (!preg_match("/.*setting\/name\z/", url()->previous())) {
            return redirect(url("account/setting"));
        }
        $validator = Validator::make($request->all(),[
            "user_name" => "required|string|between:2,8"
        ]);
        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_name = $request->input("user_name");
        $user = User::find(session()->get("login_id"));
        $user->fill(["user_name" => $user_name])->save();
        session()->put(["login_name" => $user->user_name]);
        session()->flash("setting_message","名前を変更しました");
        return redirect("account/setting/name");
    }

    public function show_setting_email(){
        $email = User::find(session()->get("login_id"))->email;
        return view("setting_email", compact("email"));
    }

    public function setting_email(Request $request){
        if (!preg_match("/.*setting\/email\z/", url()->previous())) {
            return redirect(url("account/setting"));
        }
        $validator = Validator::make($request->all(),[
            "email" => "required|string|email:rfc|unique:users|max:255"
        ],[
            "email.unique" => "この:attributeは既に登録されています。",
        ]);
        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $email = $request->input("email");
        $user = User::find(session()->get("login_id"));
        $user->fill(["email" => $email])->save();
        session()->flash("setting_message","メールアドレスを変更しました");
        return redirect("account/setting/email");
    }

    public function setting_password(Request $request){
        if (!preg_match("/.*setting\/password\z/", url()->previous())) {
            return redirect(url("account/setting"));
        }
        $validator = Validator::make($request->all(),[
            "password" => "required|string|between:6,32|regex:/[ -~]+/|confirmed"
        ],[
            "password.confirmed" => ":attributeと再入力パスワードが一致していません",
            "password.regex" => ":attributeは半角英数字、半角記号のみを使用してください",
        ]);
        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        $password = Hash::make($request->input("password"));
        $user = User::find(session()->get("login_id"));
        $user->fill(["password" => $password])->save();
        session()->flash("setting_message","パスワードを変更しました");
        return redirect("account/setting/password");
    }
}
