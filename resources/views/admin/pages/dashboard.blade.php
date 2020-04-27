@extends('admin.app')

@section('title')
Dashboard - Admin | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
{!! Charts::assets() !!}
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header')
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$loanForms}}</h3>
                        <p>Loan Forms</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-list"></i>
                    </div>
                   
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$cardForms}}</h3>
                        <p>Card Forms</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-card"></i>
                    </div>
                    
                </div>
            </div>
            @if($user->hasRole(['partner','affiliate']))
            <!-- Loan Url -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box info-margin">
                    <span class="info-box-icon bg-green"><i class="fa fa-file-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number">Loan Url</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="input-group">
                    <input id="loan" type="text" name="message" value="{{$link}}/apply/loan/personal-details?referrer_id={{$user->referrer_code}}" class="form-control bg-input-white" readonly>
                        <span class="input-group-btn">
                            <!-- <button type="submit" class="btn btn-primary btn-flat copy" 
                                data-target="#loan">Apply
                            </button> -->
                            <a 
                                href="{{$link}}/apply/loan/personal-details?referrer_id={{$user->referrer_code}}" 
                                class="btn btn-primary btn-flat copy" target="_blank">                            
                                Apply
                            </a>
                        </span>
                </div>
            </div>
            <!-- Card Url -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box info-margin">
                    <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number">Card Url</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <div class="input-group">
                    <input id="card" type="text" name="message"  value="{{$link}}/apply/card/personal-details?referrer_id={{$user->referrer_code}}" class="form-control bg-input-white" readonly>
                    <span class="input-group-btn">
                        <!-- <button type="submit"  class="btn btn-primary btn-flat copy" 
                            data-target="#card">Apply
                        </button> -->
                        <a 
                            href="{{$link}}/apply/card/personal-details?referrer_id={{$user->referrer_code}}" 
                            class="btn btn-primary btn-flat copy" target="_blank">                            
                            Apply
                        </a>
                    </span>
                </div>
                <!-- /.info-box -->
            </div>
            @endif
            <!-- ./col -->
            @if($user->hasRole(['admin','supervisor','credit-manager']))
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$unCatLoan}}</h3>
                        <p>Uncategorized Loan Forms</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-alert-circled"></i>
                    </div>
                   
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$unCatCard}}</h3>
                        <p>Uncategorized Card Forms</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-alert-circled"></i>
                    </div>
                        
                </div>
            </div>
            @endif
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-md-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Loan Applications this year - Data Analysis</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>    
                            
                    </div>  
                    <!-- /.box-body --> 
                </div>
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-md-6 connectedSortable">
               <!-- Custom tabs (Charts with tabs)-->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Card Applications this year  - Data Analysis</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                     
                    <!-- /.box-body -->
                </div>
            </section>
            <!-- right col --> 
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('scripts')
<!-- AdminLTE for demo purposes -->
<script src="/assets/admin/plugins/chartjs/Chart.min.js"></script>
<script src="/assets/admin/dist/js/analytics.js"></script>
<!-- page script -->


<!-- <script>
    $('.copy').click(function(){
        var target = $(this).data('target');
        $(target).select();
        document.execCommand("copy");
        alert('Url Copied!');
    });
</script> -->
@endsection
 