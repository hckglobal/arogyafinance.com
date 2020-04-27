@extends('website.app')

@section('title')
Dashboard (E-Sign)
@endsection

@section('styles')
<!-- boootsrap -->
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">
<link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">

@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="dashboard-padding">
            <!-- Side Menu -->
            @include('website.pages.dashboard.partials.side_menu')
            <!-- End Side Menu -->
            <div class="row document-upload">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Mandate Status</h3>
                        </div>
                        
                        <div class="box-body">
                            <div class="panel-body">
                                <!-- Wizard Content -->
                                <div class="form-group">
                                    <h3><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;E-Sign Mandate</h3>
                                    @if($application->mandate->status=='partial')
                                        <div class="col-md-12">
                                            <a href="{{$esign_url_production}}">Request E-Sign Mandate</a>
                                        </div>                                            
                                    @else
                                        <div class="col-md-12">
                                            <p>Status : 
                                                {{$application->mandate->status}}
                                            </p>
                                        </div>
                                    @endif                                    
                                </div>    
                                
                                <!-- Wizard Content -->
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="/assets/js/formvalidation.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/form-wizard-config.js"></script>
@endsection
