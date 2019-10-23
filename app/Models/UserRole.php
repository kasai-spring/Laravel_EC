<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\UserRole
 *
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereUserId($value)
 * @mixin \Eloquent
 */
class UserRole extends Model
{
    protected $guarded = [];

    public function user(){
        $this -> belongsTo("App\Models\User");
    }

    public function isAdmin(int $user_id) : bool
    {
        if(static::where("user_id", $user_id)->where("role_id", 1)->exists()){
            return true;
        }else{
            return false;
        }
    }

    public function isPublisher(int $user_id) : bool
    {
        if(static::where("user_id", $user_id)->where("role_id", 2)->exists()){
            return true;
        }else{
            return false;
        }
    }
    public function userRoleCreate(int $user_id, int $role_id){
        static::create([
            "user_id" => $user_id,
            "role_id" => $role_id,
        ]);
    }

    public function userRoleDelete(int $user_id, int $role_id){
        static::where("user_id", $user_id)->where("role_id", $role_id)->delete();
    }
}
