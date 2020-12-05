<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
class PostController extends Controller
{
    //
    public function index()
    {
        $posts = Post::where('user_id', Auth::id());
        $posts = $posts->orderBy('id', 'desc')->paginate(10);
        if ($search = request()->query('search')) {
            $posts = Post::whereHas('subject', function (Builder $query) use ($search) {
                $query->where('title', 'like', "%$search%");
            })->orWhere('text', 'like', "%$search%")->paginate(10);
            $posts->appends(request()->except('page'));
        }
        return view('posts.list_post', compact('posts'));
    }

    public function show($post_id)
    {
        $posts = Post::where('id',$post_id)->get();   
        return view('posts.detail_post', compact('posts'));
    }

    public function create_post(){
        $subjects = DB::table('subjects')->select('*');
        $subjects = $subjects->get();
        return view('posts.create_post', compact('subjects'));
    }

    public function store(Request $request)
    {
        $posts = new Post;
        $posts->user_id = $request->user_id;
        $posts->subject_id = $request->subject_id; 
        $posts->title = $request->title;
        $posts->cost = $request->cost;
        $posts->text = $request->text;
        $posts->time_required = $request->timerequired;
        $posts->place = $request->place;
        
        $posts->save();
        return redirect('list_post');
    }

    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        $posts->delete();
        return redirect('list_post');
    }

    public function listTeacherRegister($post_id){
        try {
            $post = Post::findOrFail($post_id);
            return view('posts.list_teacher_register',compact('post'));
        }catch (\Exception $e){
            return redirect()->back()->with('msg', "Error : ".$e->getMessage());
        }
    }
    public function searchPost(Request $request){
        // try {
        
            $search = $request->input('search');
            $posts = Post::whereHas('subject', function (Builder $query) use ($search) {
                $query->where('title', 'like', "%$search%");
            })->orWhere('text', 'like', "%$search%")->paginate(10);
            $posts->appends($request->except('page'));

            
            
            
           
           
          
        // }catch (\Exception $e){
        //     return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        // }


        return view('posts.list_post',compact('posts'));

    }

   
}
