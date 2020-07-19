<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
//    protected $guarded

    protected $table = "main_categories";

    protected $fillable =
        [
            'translation_lang', 'translation_of', 'name', 'slug', 'photo', 'active', 'created_at', 'updated_at',

        ];

    public function scopeActive($query)
    {
//        To identify specific active
        return $query->where('active', 1); // Where active equal 1 .
    }


    public function scopeSelection($query)
    {
        return $query->select('id', 'translation_lang','translation_of', 'name', 'slug', 'photo', 'active');
    }


    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل ';

    }

    public function getPhotoAttribute($value)
    {
        return ($value !== null) ? asset('assets/' . $value) : "";

    }

    public function categories()
    {
        return $this->hasMany(self::class, 'translation_of');
    }


}

