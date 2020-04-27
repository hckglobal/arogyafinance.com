@extends('website.app')

@section('title')
Application for
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
        <div class="panel paddingtop-class">
                
                <div class="col-xs-6 col-xs-offset-3 text-center thanku-style">
                  <div class="thanku-img"><img src="/assets/admin/dist/img/success.svg" alt=""></div>
                  <p>{{$message}}</p>
                  <a href="{{$next_url}}" class="btn btn-primary btn-outline" >OK</a>
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