<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Category;
use App\ItemImage;
use App\City;

class Item extends Model
{
    use Translatable;
    protected $table = 'items';
    protected $fillable = ['phone_number','city_id','longitude','latitude','vendor_id','whatsapp_phone','link','item_states','qrcode_image','imaging_type','rating'];
    public $translatedAttributes = ['name','description','meta_title','meta_keywards','meta_Discription','address','food_menu'];

    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function images(){
        return $this->hasMany('App\ItemImage');
    }


}
