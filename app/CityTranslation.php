<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class CityTranslation extends Model
{
    protected $fillable = ['name' ,'meta_title','meta_keywards','meta_Discription'];
    
}
