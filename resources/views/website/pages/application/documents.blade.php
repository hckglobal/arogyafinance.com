@extends('website.app')

@section('title')
Application for {{$type}}
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
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <!-- Steps -->
                <div class="pearls row">
                    <div class="pearl done col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.1')}}</span>
                    </div>
                    <div class="pearl done col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.2')}}</span>
                    </div>
                    <div class="pearl current col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-file" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.3')}}</span>
                    </div>
                </div>
                 <!-- End Steps -->
                <!-- Wizard Content -->
                <form id="documents"class="wizard-content" action="/apply/{{$type}}/documents/{{$id}}?locale={{$locale}}" method="POST" enctype="multipart/form-data">
                    <div class="wizard-pane active" id="exampleGettingOne" role="tabpanel">

                         <!--===============================
                         =            Documents            =
                         ================================-->

                         @include('website.pages.application.partials.documents')

                         <!--====  End of Documents  ====-->
                    </div>
                 <input class="btn btn-primary btn-outline pull-right" type="submit" name="submit" value="Submit">

                </form>
                <!-- Wizard Content -->
            </div>
        </div>
        <!-- End Panel Wizard Form Container -->
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
