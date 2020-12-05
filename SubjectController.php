<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_tag()
    {
        //
        return view('tags.create_tag');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {
        //
        $subjects = new Subject;
        $subjects->title = $request->title;
        $subjects->name = $request->name;

        $subjects->save();
        return redirect('list_tag');
    }

    public function searchByTag(Request $request){
        try {
            $subjects = Subject::query();
            $search = $request->input('search');
            $subjects->where('title','LIKE','%'.$search.'%')
                ->orWhere('name','LIKE','%'.$search.'%');

            $subjects = $subjects->paginate(10);
        }catch (\Exception $e){
            return redirect()->back()->with('msg','Xay ra loi !'.$e->getMessage());
        }
        return view('tags.list-tag',['subjects' => $subjects]);
    }

    public function showListTag(){
        $subjects = DB::table('subjects')->select('*');
        $subjects = $subjects->orderBy('id', 'desc')->paginate(10);
        return view('tags.list-tag', compact('subjects'));
    }

    



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
