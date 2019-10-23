<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $user_id
 * @property string $good_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUserId($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }

    //カートテーブルの数量と商品テーブルの在庫との論理チェック
    public function checkCartData(int $login_id) : bool
    {
        $cart_data = static::where("user_id", $login_id)
            ->join("goods", "goods.good_id", "=", "carts.good_id")
            ->whereNull("goods.deleted_at")
            ->whereColumn("goods.good_stock", "<", "carts.quantity")
            ->get();
        if(count($cart_data) == 0){
            return true;
        }
        foreach ($cart_data as $data) {
            if ($data->good_stock == 0) {
                static::where("user_id", $login_id)
                    ->where("good_id", $data->good_id)
                    ->delete();
            } else {
                $cart = static::where("user_id", $login_id)
                    ->where("good_id", $data->good_id)
                    ->first();
                $cart->fill(["quantity" => $data->good_stock])
                    ->save();
            }
        }
        return false;
    }

    public function getCartData(int $login_id)
    {
        return static::where("user_id", $login_id)
            ->join("goods", "goods.good_id", "=", "carts.good_id")
            ->whereNull("goods.deleted_at")
            ->get();
    }

    public function getCartDataCookie(array $cart_cookie)
    {
        $cart_data = Good::whereNull("deleted_at")//(deleted_atがNull) && (cookieに入ってる商品IDのいずれかと一致する)
        ->where(function ($q) use ($cart_cookie) {
            foreach ($cart_cookie as $good => $quantity) {
                $q->orWhere("good_id", $good);
            }
        })
            ->get();
        foreach ($cart_data as $data){
            $data["quantity"] = $cart_cookie[$data->good_id];
        }
        return $cart_data;
    }

}
