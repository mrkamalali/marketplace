<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    protected  $table  ="languages";

    protected $fillable =
        [
            'abbr', 'locale', 'name', 'direction', 'active', 'created_at', 'updated_at',
        ];


    public function scopeActive($query)
    {
        return $query->where('active', 1); // Where Active === 1
    }


    public function scopeSelection($query)
    {
        return $query->select('id','abbr' , 'name' , 'direction' , 'active');
    }


    public function getActive()
    {
        return $this->active == 1 ? '<span style="color: blue;fon">مفعل</span>' : '<span style="color: darkred;fon">متوقف</span>';

    }




}
