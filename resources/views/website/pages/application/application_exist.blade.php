@extends('website.app')

@section('title')
Application Exist
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
        <div class="application-exist">
            <div class="text-center thanku-style">
                <div class="thanku-img col-xs-12 col-md-12">
                    <img src="/assets/admin/dist/img/warning.svg" alt="">
                </div>
                <div class="col-xs-12 col-md-12">
                    <p>{{$message}}</p>
                </div>
                <div class="custom-application-exist">
                    <div class="col-md-offset-3 col-md-3">
                        <a href="{{$next_url}}" class="btn btn-success btn-outline">
                            Log into Dashboard
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/request-callback" class="btn btn-success btn-outline">
                            Request a Callback
                        </a>
                    </div>                  
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
