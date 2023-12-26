<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $fillable = ['clientIP','browser','platform','time'];
}
