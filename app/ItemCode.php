<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCode extends Model
{
    protected $fillable = ['item_id','user_id','code'];
}
