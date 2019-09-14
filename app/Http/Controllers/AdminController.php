<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show_admin_form(Request $request){
        $mode = $request->mode;
        $select_mode = session()->pull("admin_select_mode", 0);
        if(!is_null($mode) && $mode >= 0 && $mode <= 3){
            $select_mode = $mode;
        }
        $user_data = User::latest("created_at")->paginate(24,["*"],"user_page");
        foreach($user_data as $user){
            if(UserRole::where("user_id", $user->id)->where("role_id",1)->exists()){
                $user["Admin"] = 1;
            }else{
                $user["Admin"] = 0;
            }
            if(UserRole::where("user_id", $user->id)->where("role_id",2)->exists()){
                $user["Publisher"] = 1;
            }else{
                $user["Publisher"] = 0;
            }
        }
        $goods_data = Good::latest("created_at")->paginate(24, ["*"],"good_page");
        $inquiry_data = Inquiry::latest("created_at")->paginate(12,["*"],"inquiry_page");
        return view("admin",compact("select_mode", "user_data", "goods_data", "inquiry_data"));
    }
}
