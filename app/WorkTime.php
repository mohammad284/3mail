<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    protected $table = "worktimes";
    protected $fillable = ['item_id','day','opening_time','close_time'];

}
