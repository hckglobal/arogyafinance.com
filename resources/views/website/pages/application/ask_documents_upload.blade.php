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
                <div class="col-xs-6 col-xs-offset-3 text-center">

                <div class="img-document">
                    <img src="/assets/images/agreement.svg" alt="">
                </div>
                <form class="wizard-content" action="/apply/{{$type}}/ask-documents-upload/{{$id}}?locale={{$locale}}" method="POST" id="application" enctype="multipart/form-data">
                    <div class="wizard-pane active" role="tabpanel">
                          <label style="font-size:20px;">{{trans('document_detail/ask_document_upload.title')}}</label> <br/>
                          <div class="button-center-documents">
                            <input type="submit" name="submit" class="btn btn-primary btn-outline pull-right" 
                            value="{{trans('document_detail/ask_document_upload.no')}}" style="margin-left: 12px;">
                              <a href="/apply/{{$type}}/documents/{{$id}}?locale={{$locale}}" 
                                class="btn btn-primary btn-outline pull-right" >{{trans('document_detail/ask_document_upload.yes')}}
                              </a>                              
                          </div>                      
                    </div>
                </form>
                </div>
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
