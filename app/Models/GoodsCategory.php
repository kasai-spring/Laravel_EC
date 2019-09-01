<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GoodsCategory
 *
 * @property int $id
 * @property string $category_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GoodsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsCategory extends Model
{
    protected $guarded = [];

    public function goods(){
        $this -> hasMany("App\Models\Goods");
    }

}
