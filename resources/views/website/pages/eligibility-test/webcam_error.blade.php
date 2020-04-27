@extends('website.app')

<!-- title -->
@section('title')
Please enable your webcam
@endsection
<!-- /title -->
@section('body-id'){{'about-us'}}@endsection
<!-- content  -->
@section('content')
<section class="box-with-image-right section-top-space">

        <div class="center">
        	<div class="col-md-12 offset-md-3 text-center thanku-style">
				<div class="thanku-img"><img src="/assets/images/webcam_error.png" alt="">
				</div>
				<p>This online test requires you to have a webcam enabled. Please try give necessary permission or try from a different computer</p>
				<a href="/" class="btn btn-primary btn-outline">OK</a>
		    </div>
            
        </div>

    </section>
@endsection