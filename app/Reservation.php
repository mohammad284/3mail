<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['vendor_id','user_id','item_id','status','cancel','reservation_day','reservation_presons','reservation_time','message','text'];
}
