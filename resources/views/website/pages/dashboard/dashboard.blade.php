@extends('website.app')

@section('title')
Dashboard
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
            <div class="row">
                <div class="col-lg-8 col-xs-6">
                    @if(Session::has('success'))
                    <!-- alert -->
                    <div class="alert alert-success alert-dismissible">
                        <h4><i class="icon fa fa-check"></i> Alert!</h4> Your Loan Application was succesfully submitted.
                    </div>
                    @endif
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <!-- <h3></h3> -->
                            <p><i class="fa fa-file"></i> Application Status: {{ucfirst($application->status)}}</p>
                            @if($application->type == "card" && $application->card_no)
                            <p><i class="fa fa-check"></i> Pre approved Loan Amount: &#8377; {{ucfirst($application->approved_loan_amount)}}</p>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    @if($borrower->application->psychometricTest->isEmpty())
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-file"></i> Psychometric Test</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                                    <p class="title">Please take the Psychometric test</p>
                                    <a href="/eligibility/select-language" class="btn btn-primary">Take Psychometric Test</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    @endif
                    @if(!$application->transaction) @include('website.pages.dashboard.partials.pay_now') @else @include('website.pages.dashboard.partials.payment_transaction_details') @endif
                    <!-- /.box -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-history"></i> Timeline</h3>
                        </div>
                        <div class="box-body">
                            <ul class="timeline">
                                @foreach($logs as $log)
                                <!-- timeline time label -->
                                <li class="time-label">
                                    <span class="bg-red">
                                      {{ Carbon\Carbon::parse($log->created_at)->format('d F Y h:i:s') }}
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <!-- timeline icon -->
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header"><a href="#">Status changed to {{$log->new_value}}</a></h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                @endforeach
                            </ul>
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
