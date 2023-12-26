<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferUser extends Model
{
    protected $table = 'offer_users';
    protected $fillable = ['user_id','offer_id','vendor_id','item_id','start_offer_date','end_offer_date','used'];
}
