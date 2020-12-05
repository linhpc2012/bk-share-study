<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments' ;
    protected $primaryKey = 'id';
    protected $fillable= [
        'classs_id',
        'comment'
    ];

    public function clas(){
        return $this->belongsTo('App\Models\Classs') ;
    }

}
