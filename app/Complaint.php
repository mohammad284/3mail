<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['item_id','user_id','title','text','reply'];
}
