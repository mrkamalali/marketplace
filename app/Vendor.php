<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use Notifiable;

    protected $table = "vendors";
//    protected $guarded;

    protected $hidden = ['category_id', 'password'];
//
    protected $fillable = [
        'name','email','mobile','address','latitude','longitude','logo','active', 'category_id','created_at','updated_at',
    ];


    public function scopeSelection($query)
    {
        return $query->select('id', 'category_id', 'name', 'latitude','longitude' ,  'email', 'password', 'active', 'logo', 'mobile');
    }



    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }


    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getActive()
    {
        return $this->active == 1 ? '<span style="color: blue;fon">مفعل</span>' : '<span style="color: darkred;fon">متوقف</span>';

    }


    public function getLogoAttribute($value)
    {
        return ($value !== null) ? asset('assets/' . $value) : "";
    }



    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'category_id');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }


}
