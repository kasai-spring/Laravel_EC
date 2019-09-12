<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResetPassword
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $expired_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword whereUserId($value)
 * @mixin \Eloquent
 */
class ResetPassword extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }
}
