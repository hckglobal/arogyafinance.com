<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blogs";
    protected $fillable =['title','slug','image','description'];



    public function setSlugAttribute(){
        $this->attributes['slug'] = slug($this->attributes['title']);
    }

    public function getImageAttribute($value)
    {
        if ($value==null) {
            return "/assets/images/blogs/blogs.jpeg";
        } else {
            return "/uploads/blogs/".$value;
        };
    }
}
