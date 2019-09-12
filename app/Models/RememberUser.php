<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RememberUser
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $expired_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RememberUser whereUserId($value)
 * @mixin \Eloquent
 */
class RememberUser extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }
}
