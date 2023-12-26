<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['user_id' ,'item_id','client_status','count','client_evaluation','review'];

}
