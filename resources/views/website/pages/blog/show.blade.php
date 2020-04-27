@extends('website.app')

@section('title')
Blogs
@endsection

@section('content')

<section class="section-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="single-post p-5">
                    <div class="post-header mb-5 text-center">
                        <div class="custom-heading">
                            <span>
                                <img class="blog-back" src="/assets/images/blogs/chevron-left.png" onclick="history.back(-1)" alt="">
                            </span>
                            <h3>
                                {{$blog->title}}
                            </h3>
                            
                            <!-- <p>disease related key words to be put here</p> -->
                            <div class="divider">
                                <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
                            </div>
                        </div>


                        <div class="post-featured-image mt-5">
                            <img src="{{$blog->image}}" class="img-fluid blog-featured-img" alt="featured-image">
                        </div>
                    </div>
                    <div class="post-body">
                        <div class="content">
                            {!!$blog->description!!}
                        </div>
                    </div>
                </div>

                {{-- <div class="more"> 
                    <h4 class="text-center widget-title">Trending Posts</h4>
                    <div class="container">
                        <div class="row blog-row">
                            @foreach ($blogs as $blog)
                                
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <article class="post-grid mb-5">
                                    <a class="post-thumb mb-4 d-block" href="#">
                                        <img src="https://via.placeholder.com/250x250/123123/222" alt="" class="">
                                    </a>
                                <h4 class="post-title mt-1 text-center"><a href="">{{$blog['blog_title']}}</a></h4>

                <h4 class="date">{{$blog['publish_date']}}</h4>

                </article>
            </div>
            @endforeach
        </div>
    </div>
    </div> --}}
    </div>
    </div>
    </div>
    </div>
    </div>
</section>
@endsection