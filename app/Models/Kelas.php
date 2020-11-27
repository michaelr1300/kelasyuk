<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    public function mengajar()
    {
        return $this->hasMany('App\Mengajar');
    }

    public function mengikuti()
    {
        return $this->hasMany('App\Mengikuti');
    }

    public function request()
    {
        return $this->hasMany('App\Request');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->hasMany('App\Post');
    }

}
