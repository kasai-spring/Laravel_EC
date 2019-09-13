<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\PurchaseHistory
 *
 * @property int $id
 * @property int $user_id
 * @property int $good_id
 * @property int $quantity
 * @property int $address_id
 * @property int $transaction_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Good $good
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PurchaseHistory whereUserId($value)
 * @mixin \Eloquent
 */
class PurchaseHistory extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }

    public function good(){
        return $this->belongsTo("App\Models\Good");
    }

    public function address(){
        return $this->belongsTo("App\Models\Address");
    }
}
