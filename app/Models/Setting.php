<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;

    protected $table = 'settings';
    protected $with =['translations'];
    protected $fillable = ['id','key', 'is_translatable','plain_value'];
    public $timestamps=true;

    protected $translatedAttributes =['value'];
    protected $casts = [
      'is_translatable' => 'boolean',
    ];

    public static function setMany($settings){
        foreach($settings as $key => $value){
            self::set($key,$value);
        }

    }

    public static function set($key, $value){

            if($key === 'translatable'){
                return static::setTranslatableSetting($value);
            }
            if(is_array($value)){
                $value = json_encode($value);
            }
             static::updateOrcreate(['key' => $key, 'plain_value' => $value]);
    }

     public static function setTranslatableSetting($settings = []){
        foreach ($settings as $key => $value){
             static::updateOrcreate(['key' => $key],[
                'is_translatable' => true,
                'value' => $value
             ]);

        }

     }

}
