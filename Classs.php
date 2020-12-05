<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'comment_id',
        'student_id',
        'teacher_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User') ;
    }

    public function student(){
        return $this->hasOne('App\Models\User','student_id') ;
    }
    public function teacher(){
        return $this->hasOne('App\Models\User','teacher_id') ;
    }

    public function post(){
        return $this->belongsTo('App\Models\Post') ;
    }

    public function commentss(){
        return $this->hasOne('App\Models\Comment');
    }
}
