<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Classs;
use App\Models\Register;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClasssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function take_clas(Request $request)
    {
        $registers = new Register;
        $registers->post_id = $request->post_id;
        $registers->teacher_id = $request->teacher_id;
        $registers->status=1;
        $registers->save();
        return redirect('home');
    }

    public function index()
    {
        $classes = Classs::where('student_id',Auth::id())->OrWhere('teacher_id', Auth::id());
        $classes = $classes->orderBy('id', 'desc')->paginate(10);
        $comments = Comment::get() ;
        return view('classs.list_class', compact('classes', 'comments'));
    }

    public function detailUser($id){
        try {
            return view('classs.detail_user',['user' => User::findOrFail($id)]) ;
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }
    }

    public function show($post_id)
    {
        $posts = Post::where('id',$post_id)->get();   
        return view('classs.post_detail', compact('posts'));
    }

    public function create( $register_id)
    {
        try {
            $register = Register::findOrFail($register_id) ;
            if($register->post->status != 2){
                $classs = new Classs() ;
                $classs->student_id = $register->post->user_id ;
                $classs->teacher_id = $register->teacher->id ;
                $classs->post_id = $register->post->id ;
                $classs->status =1;
                $register->post->status =2 ;

                $register->post->save();
                $classs->save() ;
                return redirect('list_post')->with('msg','Chọn giáo viên thành công');
            }else{
                return redirect()->back()->with('msg','Lớp đã đóng.');
            }

        }catch (\Exception $e){
            return redirect()->back()->with('msg','Error : '.$e->getMessage()) ;
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classs  $classs
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classs  $classs
     * @return \Illuminate\Http\Response
     */
    public function edit(Classs $classs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classs  $classs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classs $classs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classs  $classs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classs $classs)
    {
        //
    }
}
