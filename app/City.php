<?php

namespace App;
use App\CityImage;
use App\Item;


use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class City extends Model
{
    use Translatable;
    protected $table = 'cities';
    protected $fillable = ['image','longitude','latitude'];
    public $translatedAttributes = ['name','meta_title','meta_keywards','meta_Discription'];

   
    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function items(){
        return $this->hasMany('App\Item');
    }
}
