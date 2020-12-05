<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $fillable = [
        'title',
        'name',

    ];

    public function posts(){
        return $this->hasMany('App\Models\Post') ;
    }
}
