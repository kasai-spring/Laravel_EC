<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $guarded = [];

    public function carts(){
        $this->hasMany("App\Models\Carts");
    }

    public function userroles(){
        $this->hasMany("App\Models\Carts");
    }
}
