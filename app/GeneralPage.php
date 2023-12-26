<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class GeneralPage extends Model
{
    use Translatable;
    protected $fillable = ['name'];
    public $translatedAttributes = ['Terms_and_conditions','privacy_policy','about'];

}
