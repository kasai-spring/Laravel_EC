<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Users
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $user_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $last_logined_at
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereLastLoginedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users whereUserName($value)
 * @mixin \Eloquent
 */
class Users extends Model
{
    protected $guarded = [];

    public function carts(){
        $this->hasMany("App\Models\Carts");
    }

    public function userroles(){
        $this->hasMany("App\Models\UserRoles");
    }

    public function addresses(){
        $this->hasMany("App\Models\Addresses");
    }
}
