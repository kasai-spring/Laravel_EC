<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    public function createPublisherData(int $user_id, string $publisher_name)
    {
        $publisher_id = strtoupper(Str::random(16));
        while (static::where("publisher_id", $publisher_id)->exists()) {
            $publisher_id = strtoupper(Str::random(16));
        }
        static::create([
            "publisher_id" => $publisher_id,
            "user_id" => $user_id,
            "publisher_name" => $publisher_name
        ]);
    }

    public function getPublisherData(int $user_id)
    {
        return static::where("user_id", $user_id)->first();
    }

    public function updatePublisherData(int $user_id, string $publisher_name){
        $publisher_data = static::getPublisherData($user_id);
        $publisher_data->fill(["publisher_name" => $publisher_name])->save();
    }
}
