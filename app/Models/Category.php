<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $guarded = [];
    protected $with = ['translations'];


    protected $translatedAttributes = ['name'];
    public $timestamps =false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['translations'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeParentCategory($query){
        $query -> whereNull('parent_id');
    }

    public function scopeSubParentCategory($query){
        $query -> whereNotNull('parent_id');
    }

    public function getStatus(){
        return $this -> is_active ==1  ? 'Active':'Deactive';
    }

    public function subCategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function mainCategories()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


}
