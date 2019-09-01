<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Carts
 *
 * @property int $id
 * @property int $user_id
 * @property int $good_id
 * @property int $good_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts whereGoodCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Carts whereUserId($value)
 * @mixin \Eloquent
 */
class Carts extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }

    public function goods(){
        return $this->belongsTo("App\Models\Goods");
    }
}
