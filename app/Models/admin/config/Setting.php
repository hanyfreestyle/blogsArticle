<?php
namespace App\Models\admin\config;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model implements TranslatableContract
{

    use Translatable;
    public $translatedAttributes = ['name','g_title','g_des','closed_mass'];
    protected $fillable = ['facebook','twitter','youtube','instagram','google_api','web_status','phone_num','whatsapp_num'];
    protected $table = "config_settings";
    protected $primaryKey = 'id';
    public $timestamps = false ;


#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     categories
    protected function categories() :Attribute{
        return Attribute::make(
            get: fn($value) => json_decode($value,true),
            set: fn($value) => json_encode($value)
        );
    }

}
