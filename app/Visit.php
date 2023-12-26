<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['user_id','item_id','visit_time','client_id'];
}
