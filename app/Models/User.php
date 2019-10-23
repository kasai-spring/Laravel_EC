<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $user_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $last_logined_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUserName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function carts()
    {
        return $this->hasMany("App\Models\Cart");
    }

    public function userroles()
    {
        return $this->hasMany("App\Models\UserRole");
    }

    public function addresses()
    {
        return $this->hasMany("App\Models\Address");
    }

    public function getUsersDataPage(?int $pageNumber)
    {
        return static::latest("created_at")->paginate(24, ["*"], "user_page", $pageNumber);
    }

    public function getUserData(int $user_id)
    {
        return static::find($user_id);
    }

    public function deleteUserData(string $user_email, int $login_id): bool
    {
        $user = static::where("email", $user_email)->first();
        if ($user->id != $login_id) {
            try {
                $user->delete();
            } catch (\Exception $e) {
                throw new $e;
            }
            return true;
        }else{
            return false;
        }
    }

    public function createUserData(string $email, string $password, string $user_name) : int{
        $user = static::create([
            "email" => $email,
            "password" => Hash::make($password),
            "user_name" => $user_name
        ]);
        return $user->id;
    }

    public function updateUserData(int $user_id, string $email, string $user_name, ?string $password)
    {
        $user_data = static::getUserData($user_id);
        $update_data = ["email" => $email, "user_name" => $user_name];
        if(!is_null($password)){
            $update_data = array_merge($update_data, ["password" => Hash::make($password)]);
        }
        $user_data->fill($update_data)->save();
    }
}
