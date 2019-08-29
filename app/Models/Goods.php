<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Goods
 *
 * @property int $id
 * @property string $good_name
 * @property string $good_producer
 * @property string $good_publisher
 * @property int $good_price
 * @property int $good_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereGoodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereGoodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereGoodPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereGoodProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereGoodPublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Goods whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Goods extends Model
{
    protected $guarded = [];
}
