<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['offers'];


    public function users(){
        return $this->belongsToMany('App\User');
    }
    
}
