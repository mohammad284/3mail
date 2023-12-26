<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Question extends Model
{
    use Translatable;
    protected $fillable = ['name'];
    public $translatedAttributes = ['question','answer'];

}
