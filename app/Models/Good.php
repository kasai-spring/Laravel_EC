<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * App\Models\Good
 *
 * @property int $id
 * @property string $good_id
 * @property string $good_name
 * @property string $good_producer
 * @property string $good_publisher
 * @property int $good_price
 * @property int $good_stock
 * @property string $picture_path
 * @property int $good_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\GoodsCategory $goodscategory
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Good onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodPublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereGoodStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good wherePicturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Good whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Good withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Good withoutTrashed()
 * @mixin \Eloquent
 */
class Good extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function goodscategory(){
        return $this->belongsTo("App\Models\GoodsCategory", "good_category");
    }


}
