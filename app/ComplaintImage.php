<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintImage extends Model
{
    protected $fillable = ['complaint_id','image'];
}
