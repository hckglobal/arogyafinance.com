<?php

/*
|--------------------------------------------------------------------------
| Eligibility Test Routes
|--------------------------------------------------------------------------
|
| Eligibility Test routes are defined here
|
*/
// Route::group(['prefix'=>'website/blog','namespace'=>'Website\Blog'], function (){
    Route::get('/blog', 'Website\Blog\BlogController@index');
    Route::get('/blog/view/{id}', 'Website\Blog\BlogController@singleBlog')->name('viewblog');
// });
