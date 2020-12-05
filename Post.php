<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'subject_id',
        'class_id',
        'title',
        'cost',
        'text',
        'time_required',
        'place',
        'status',
        'created_at' ,
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }

    public function classs(){
        return $this->hasOne('App\Models\Classs');
    }

    public function registers(){
        return $this->hasMany('App\Models\Register') ;
    }
}
