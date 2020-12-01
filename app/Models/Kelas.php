<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'user_id',
    ];

    public function mengikuti()
    {
        return $this->hasMany('App\Mengikuti');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function mengajar()
    {
        return $this->hasMany('App\Mengajar');
    }

    public function request()
    {
        return $this->hasMany('App\Request');
    }

    

}
