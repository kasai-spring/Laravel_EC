<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Publisher
 *
 * @property int $id
 * @property string $publisher_id
 * @property int $user_id
 * @property string $publisher_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Publisher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher wherePublisherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publisher whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Publisher withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Publisher withoutTrashed()
 * @mixin \Eloquent
 */
class Publisher extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user(){
        $this -> belongsTo("App\Models\User");
    }

    public function goods(){
        $this->hasMany("App\Models\Good");
    }
}
