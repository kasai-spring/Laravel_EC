<?php

namespace App\Models;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Good
 *
 * @property int $id
 * @property string $good_id
 * @property string $good_name
 * @property string $good_producer
 * @property int $good_publisher
 * @property int $good_price
 * @property int $good_stock
 * @property string $picture_path
 * @property int $good_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\GoodsCategory $goodscategory
 * @property-read \App\Models\Publisher $publisher
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

    public function goodscategory()
    {
        return $this->belongsTo("App\Models\GoodsCategory", "good_category");
    }

    public function publisher()
    {
        return $this->belongsTo("App\Models\Publisher", "good_publisher");
    }

    /**
     * [Model]
     *
     * @return Collection
     *
     * @throws QueryException
     */
    public function getHomeGoods() : Collection
    {
        return static::inRandomOrder()
            ->where("good_stock", "!=", 0)
            ->limit(24)
            ->get();
    }

    public function getGoodsDataPage(?int $pageNumber){
        return static::latest("created_at")->paginate(24, ["*"], "good_page", $pageNumber);
    }

    public function deleteGoodsData(string $good_id){
        static::where("good_id", $good_id)->delete();
    }

    public function getGoodData(string $good_id){
        return static::where("good_id", $good_id)->first();
    }

    public function goodStockChanger(int $id, int $good_stock){
        static::first($id)->fill(["good_stock" => $good_stock])->save();
    }

    public function updateGoodData(int $id, string $good_name, int $good_price, int $good_stock, string $good_producer,
                                   int $good_category){
        $old_good = static::first($id);
        static::insert([
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
            throw new $e;
        }
    }
}
