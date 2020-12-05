<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class AdminController extends Controller
{
    //
    public function index(){
        $numOfTeacher = DB::table('users')->where('role_id',2)->count() ;
        $numOfRegisterTeacher = DB::table('users')->where('status',1)->count() ;
        $numOfStudent = DB::table('users')->where('role_id',3)->count() ;
        $totalPostNum = Post::all()->count();
        return view('admin.admin',compact("numOfRegisterTeacher","numOfTeacher","numOfStudent", 'totalPostNum')) ;
    }

    public function postsList(Request $request)
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('admin.post', compact('posts'));
    }

    public function postOfUser($user_id)
    {
        $posts = Post::where('user_id',$user_id)->orderBy('created_at','desc')->paginate(10);
        return view('admin.post', compact('posts'));
    }

}
