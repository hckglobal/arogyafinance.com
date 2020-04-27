@extends('website.app')

@section('title')
Application
@endsection

@section('styles')
    <!-- Loading Plugin -->
    <script src="/assets/js/isLoading.min.js"></script>
    <!-- boootsrap -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.auto-complete.css"/>

@endsection

@section('content')

<div class="container">
    <div class="row">
        <!-- Panel Wizard Form Container -->
        <div class="paddingtop-class invoice-class">
                <div class="custom-heading">
                <h3>Would you like to pay for Arogya Card ?</h3>
                <div class="divider">
                    <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
                </div>
               
            </div>

                @include('website.pages.payment.partials.invoice')
                
                <div class="col-xs-6 col-xs-offset-3 text-center thanku-style">
                  <div class="button-center-documents">
                    @if($application->category()=="One" || $application->category()=="Two")
                    <a href="/redirect-page/{{$application->id}}" class="btn btn-danger btn-outline pull-right" >Pay Later</a>
                    @else
                    <a href="/thank-you/{{$application->id}}" class="btn btn-danger btn-outline pull-right" >Pay Later</a>
                    @endif
                    <a href="/payment/user/{{$application->type}}" class="btn btn-success btn-outline pull-left" >Pay Now</a>
                  </div> 
                </div>
        </div>
    </div>
</div>    

@endsection

@section('script')
<!-- vue js app files -->
<script type="text/javascript" src="/assets/js/vue.min.js"></script>
<script type="text/javascript" src="/assets/js/application.vue.js"></script>

<!-- form wizard files -->
<script type="text/javascript" src="/assets/js/form-wizard.js"></script>
<script type="text/javascript" src="/assets/js/jquery.auto-complete.min.js"></script>
<script type="text/javascript" src="/assets/js/formvalidation.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/form-wizard-config.js"></script>


@endsection
