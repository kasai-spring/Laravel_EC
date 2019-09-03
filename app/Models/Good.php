<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Good
 *
 * @property int $id
 * @property string $good_name
 * @property string $good_producer
 * @property string $good_publisher
 * @property int $good_price
 * @property string $picture_path
 * @property int $good_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $carts
 * @property-read \App\Models\GoodsCategory $goodscategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodPublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good wherePicturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Good extends Model
{
    protected $guarded = [];

    public function carts(){
        return $this->hasMany("App\Models\Carts");
    }

    public function goodscategory(){
        return $this->belongsTo("App\Models\GoodsCategory", "good_category");
    }


}
