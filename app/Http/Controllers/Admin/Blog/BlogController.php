<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Auth;
use App\State;
use App\Blog;
use App\Admin;
use App\Role;
use Redirect;
use Session;
use File;

class BlogController extends Controller
{
    protected $validationRules = [
        'title' => 'required',
        'description' => 'required',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Blogs";
        $blogs = Blog::all();
        return view('admin.pages.blog.index', compact('blogs'))->with(['title'=>$title]);
    }


    /**
     * show page
     *
     * @param  no param
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Blog";
        return view('admin.pages.blog.create')->with(['title'=>$title]);
    }

    
    /**
     * store data.
     *
     * @param  Request $input
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

        $blog =Blog::create($request->all());

        if ($request->hasFile('image')) {
            $basePath = public_path()."/uploads/blogs";
            $file = $request->file('image');
            $file_name = str_slug($file->getClientOriginalName()) . "_" . str_random(5) . "." . $file->getClientOriginalExtension();
            $file->move($basePath, $file_name);
            $blog->image =$file_name;
            $blog->save();
        }
        Session::flash('info', 'New Blog created');
        return redirect('/admin/blog/all');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Blog";
        $blog = Blog::find($id);
        
        return view('admin.pages.blog.edit', compact('blog'))->with(['title'=>$title,'blog'=>$blog]);
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
        $this->validate($request, $this->validationRules);

        $blog = Blog::find($id);
        $blog->update($request->all());

        if ($request->hasFile('image')) {
            $basePath = public_path()."/uploads/blogs";
            $file = $request->file('image');
            $file_name = str_slug($file->getClientOriginalName()) . "_" . str_random(5) . "." . $file->getClientOriginalExtension();
            $file->move($basePath, $file_name);
            $blog->image =$file_name;
            $blog->save();
        }
        Session::flash('info', 'Blog updated');
        return redirect('/admin/blog/all');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog::destroy($id);
        Session::flash('info', 'Blog deleted successfully');
        return redirect('/admin/blog/all');
    }
}
