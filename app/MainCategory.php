<?php

namespace App;

use App\Observers\MainCategoryObserver;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
//    protected $guarded

    protected $table = "main_categories";

    protected $fillable =
        [
            'translation_lang', 'translation_of', 'name', 'slug', 'photo', 'active', 'created_at', 'updated_at',

        ];


//    Make This Model See Or Observe The Observe We Made MainCategoryObserver..
    protected static function boot()
    {
        parent::boot();
        MainCategory::observe(MainCategoryObserver::class);
    }


    public function scopeParentCategory($query)
    {
        return $query->where('translation_of', 0);
    }




    public function scopeActive($query)
    {
//        To identify specific active
        return $query->where('active', 1); // Where active equal 1 .
    }


    public function scopeSelection($query)
    {
        return $query->select('id', 'translation_lang', 'translation_of', 'name', 'slug', 'photo', 'active');
    }


    public function getActive()
    {
        return $this->active == 1 ? '<span style="color: blue;fon">مفعل</span>' : '<span style="color: darkred;fon">متوقف</span>';

    }

    public function getPhotoAttribute($value)
    {
        return ($value !== null) ? asset('assets/' . $value) : "";

    }

//     To get The translations Of Category not The Main Category With (Default language)
    public function categories()
    {
        return $this->hasMany(self::class, 'translation_of');
    }


    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'category_id');
    }


}

