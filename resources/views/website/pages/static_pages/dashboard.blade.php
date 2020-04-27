@extends('app')

@section('title')
Dashboard 
@endsection

@section('styles')
<!-- boootsrap -->
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">

@endsection
@section('content')
<div class="container">
    <div class="row">
        <!-- Panel Wizard Form Container -->
          <div class="panel"  style="padding-top: 150px;">
            <div class="panel-heading text-center">
            <div class="col-md-10">
              <h3>Welcome {{$borrower->first_name}} {{$borrower->last_name}}</h3>            	
            </div>
            <div class="col-md-2">
              <a href="/logout" class="btn btn-primary">Logout</a>
            </div>
            <div class="clearfix"></div>
            </div>
            <div class="panel-body">
              <!-- Wizard Content -->
              <form class="wizard-content" action="/update-document"  method="POST" id="application-loan"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="wizard-pane active" id="documents" role="tabpanel">
                @if(!$borrower->answers->count() && $borrower->application->category()!="One")
                 <div class="form-group">
                    <h3><i class="glyphicon glyphicon-open-file"></i>Psychometric Test</h3>
                    <div class="col-md-12">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                        <p class="title">Please take the Psychometric test</p>
                         <a href="/eligibility/select-language" class="btn btn-primary">Take Psychometric Test</a>
                    </div>                    
                 </div>
                 @endif
                 @include('partials.application.documents')
                 <button type="submit" class="btn btn-primary">Upload</button>
                </div>
              </form>
              <!-- Wizard Content -->
            </div>
          </div>
          <!-- End Panel Wizard Form Container -->
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/js/formvalidation.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/form-wizard-config.js"></script>
@endsection
