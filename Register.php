<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    protected $table = 'registers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'teacher_id',
        'status'
    ];

    public function post(){
        return $this->belongsTo('App\Models\Post') ;
    }

   

    public function teacher(){
        return $this->belongsTo('App\Models\User') ;
    }
}
