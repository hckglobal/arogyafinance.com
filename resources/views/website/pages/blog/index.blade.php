@extends('website.app')

@section('title')
Blogs
@endsection


@section('content')
<section class="section-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="custom-heading">
                    <h3>Blog</h3>
                    <div class="divider">
                        <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row blog-row">
            @foreach ($blogs as $blog)
            <div class="col-md-3 col-sm-12 blog-col">
                <article class="post-grid mb-5">
                    <a class="post-thumb mb-4 d-block" href='{{route('viewblog',[$blog->id])}}'>
                        <img class="blog-image" src="{{$blog->image}}" alt="" class="">
                    </a>
                    <h3 class="post-title mt-1"><a href='{{route('viewblog',[$blog->id])}}'>{{$blog->title}}</a></h3>
                    <h4 class="date">{{$blog->created_at->format('d M y')}}</h4>
                </article>
            </div>
            @endforeach
        </div>
        <div class="pagination mt-5 pt-4">
            {!!$blogs->render()!!}
        </div>

    </div>
</section>
@endsection