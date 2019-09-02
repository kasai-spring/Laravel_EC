<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * App\Models\Addresses
 *
 * @property int $id
 * @property int $user_id
 * @property int $postcode
 * @property string $prefecture
 * @property string $city_street
 * @property string|null $building
 * @property string $addressee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Users $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereAddressee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereCityStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Addresses whereUserId($value)
 * @mixin \Eloquent
 */
class Addresses extends Model
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
