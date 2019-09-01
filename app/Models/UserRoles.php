<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserRoles
 *
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRoles whereDeletedAt($value)
 */
class UserRoles extends Model
{
    protected $guarded = [];

    public function user(){
        $this -> belongsTo("App\Models\User");
    }
}
