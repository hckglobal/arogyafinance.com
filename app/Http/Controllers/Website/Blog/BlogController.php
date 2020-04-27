<?php

namespace App\Http\Controllers\Website\Blog;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Blog;
use Redirect;




class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Blogs";
        $blogs = Blog::paginate(8);
        // $blogs = Blog::latest();
        // $blogs=$blogs->paginate(3);
        // dd('$id');
        return view('website.pages.blog.index')->with(['locale'=>'en','title'=>$title, 'blogs'=>$blogs]);
    }
    public function singleBlog($id)
    {
        $title = "View Blog";
        $blog = Blog::find($id);
        $blogs = Blog::all();
        return view('website.pages.blog.show')->with(['locale'=>'en', 'title'=>$title, 'blog'=>$blog,'blogs'=>$blogs]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //    
    }
}
