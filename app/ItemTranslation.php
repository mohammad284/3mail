<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ItemTranslation extends Model
{
    public $fillable =  ['name','description','address','meta_title','meta_keywards','meta_Discription','food_menu'];
}
