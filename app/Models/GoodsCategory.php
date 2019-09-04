<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\GoodsCategory
 *
 * @property int $id
 * @property string $category_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GoodsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsCategory extends Model
{
    protected $guarded = [];

    public function goods(){
        $this -> hasMany("App\Models\Good");
    }

}
