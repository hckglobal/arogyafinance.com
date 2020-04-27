@extends('website.app')

@section('title')
CEO Speaks
@endsection

@section('body-id'){{'management'}}@endsection

@section('content')
<section class="box-with-image-right section-top-space">
    <div class="container">
        <div class="row">
            <div class="custom-heading">
                <h3>CEO Speaks</h3>
                <div class="divider">
                    <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="our-board-custom">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="right">
                        <div class="video-testimonials">
                             <div class="videowrapper">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/4e4NRBFHFpw?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="clear"></div>
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="center" id="padding-null">
                        <h3>Co-Founder & CEO Jose Peter Enlightening About Arogya Finance</h3>
                        <p>Hear us out from our Co-Founder & CEO Jose Peter as he enlightens about Arogya Finance</p>
                        <p>To watch more videos visit us at youtube : <a href="https://www.youtube.com/channel/UCKyTQl9c1FI-3nWyYRSgNfQ" target="_blank">Arogya Finance </a></p>
                    </div>
                </div>
                <div class="col-md-2"></div>
                      
        </div>
    </div>
</section>
@endsection