<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResetPassword
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResetPassword query()
 * @mixin \Eloquent
 */
class ResetPassword extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }
}
