<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->name;
        $users->phone = $request->phone;
        $users->description = $request->description;
        $users->password = Hash::make($request->password);

        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads',$filename);
            $users->image = $filename;
        }
        $users->save();
        return redirect('home');
    }

    public function edit()
    {
        return view('edit');
    }

    public function formregister()
    {
        return view('user.register_to_teacher');
    }

    public function todo(Request $request)
    {
        $users = Auth::user();
        $users->status= $request->status;
        $users->description = $request->description;

        $users->save();
        return redirect('home');
    }

    public function listRegisterTeacher(){
        try {
            $users = DB::table('users')->where('status','1')->paginate(9) ;
            return view('user.list-register',['users' => $users]);
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }

    }

    public function listTeacher(){
        try {
            $users = DB::table('users')->where('role_id',2)->paginate(9) ;
            return view('user.list-teacher',['users'=>$users]);
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }

    }
    public function listStudent(){
        try {
            $users = DB::table('users')->where('role_id',3)->paginate(9) ;
            return view('user.list-student',['users'=>$users]);
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }

    }
    public function detailUser($id){
        try {
            return view('user.detail-user',['user' => User::findOrFail($id)]) ;
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }

    }
    public function searchByNameOrEmail(Request $request){
        try {
            $user = User::query();
            $search = $request->input('search');
            $user->where('name','LIKE','%'.$search.'%')
                ->orWhere('email','LIKE','%'.$search.'%')
                ->orWhere('phone','LIKE','%'.$search.'%');

            $users = $user->paginate(9);
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }


        return view('user.list-student',['users' => $users]);

    }

    public function deleteUser($id){
        try {
            $user = User::findOrFail($id) ;

            if ($user->delete()){
                if ($user->role_id ==  2){
                    return redirect('admin/list-teacher')->with('msg','Xoa thanh cong !');
                }else{
                    return redirect('admin/list-student')->with('msg','Xoa thanh cong !');
                }

            }
            return redirect()->back('home')->with('msg','Xay ra loi! ');
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi : '.$e->getMessage());
        }

    }

    public function registerTeacher($id,$status){
        try {
            // status ==2 : phe duyet , 3: tu choi
            $user = User::findOrFail($id) ;
            $user->status = 0;
            if ($status ==2  && $user->role_id==3){
                $user->role_id = 2;
                $user->save() ;
                return redirect()->back()->with('msg','Duyet thanh cong');
            }else if ($status ==3){
                $user->save() ;
                return redirect()->back()->with('msg','Da tu choi');
            }

        }catch (\Exception $e){
          //  echo $e ;
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }
    }
}
