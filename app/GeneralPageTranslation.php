<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class GeneralPageTranslation extends Model
{
    public $fillable =  ['Terms_and_conditions','privacy_policy','about'];
}
