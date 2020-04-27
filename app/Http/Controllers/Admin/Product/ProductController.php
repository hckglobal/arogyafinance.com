<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the product.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Manage Product";
        $products = Product::all();
        return view('admin.pages.product.index')->with(['title'=>$title,'products'=>$products]);
    }

    /**
     * Show the form for creating a new product.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add Product";
        return view('admin.pages.product.create')->with(['title'=>$title]);
    }

    /**
     * Store a newly created product in database.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create($request->all());
        Session::flash('info','New Product created');
        return redirect('/admin/product/all');
    }

    /**
     * Display the specified product.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified product.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Product";
        $product = Product::find($id);
        return view('admin.pages.product.edit')->with(['title'=>$title,'product'=>$product]);
    }

    /**
     * Update the specified product in database.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        Session::flash('info','Product updated');
        return redirect('/admin/product/all');
    }

    /**
     * Remove the specified product from database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        Session::flash('info','Product deleted successfully');
        return redirect('/admin/product/all');
    }
}
