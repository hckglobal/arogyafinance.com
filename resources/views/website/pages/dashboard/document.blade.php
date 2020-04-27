@extends('website.app')

@section('title')
Dashboard (Documents)
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
                            <h3 class="box-title">Upload Documents</h3>
                        </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <!-- Wizard Content -->
                                @if($application->remainingDocumentsCount()>=1)
                                <form class="wizard-content" action="/update-document" method="POST" 
                                    id="application-loan" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="wizard-pane active" id="documents" role="tabpanel">
                                        @include('website.pages.application.partials.documents')
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                                @else
                                <div class="form-group">
                                    <h3><i class="glyphicon glyphicon-open-file"></i>&nbsp;&nbsp;Borrower's Documents</h3>
                                    <div class="col-md-12">
                                        <p class="title">You have uploaded all the documents.</p>
                                    </div>
                                </div>    
                                @endif
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
