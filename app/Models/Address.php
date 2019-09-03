<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;


/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property string $postcode
 * @property string $prefecture
 * @property string $city_street
 * @property string $building
 * @property string $addressee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCityStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUserId($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\Users");
    }

    public function setPostcodeAttribute($value)
    {
        $this->attributes["postcode"] = Crypt::encrypt($value);
    }

    public function getPostcodeAttribute($value){
        return Crypt::decrypt($value);
    }

    public function setPrefectureAttribute($value){
        $this->attributes["prefecture"] = Crypt::encrypt($value);
    }

    public function getPrefectureAttribute($value){
        return Crypt::decrypt($value);
    }

    public function setCityStreetAttribute($value){
        $this->attributes["city_street"] = Crypt::encrypt($value);
    }

    public function getCityStreetAttribute($value){
        return Crypt::decrypt($value);
    }

    public function setBuildingAttribute($value){
        $this->attributes["building"] = Crypt::encrypt($value);
    }

    public function getBuildingAttribute($value){
        return Crypt::decrypt($value);
    }

    public function setAddresseeAttribute($value){
        $this->attributes["addressee"] = Crypt::encrypt($value);
    }

    public function getAddresseeAttribute($value){
        return Crypt::decrypt($value);
    }
}
