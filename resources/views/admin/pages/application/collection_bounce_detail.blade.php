@extends('admin.app')

@section('title') 
Cheque Bounce
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   @include('admin.partials.content-header')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <b>Collection Details</b></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Narration</th>
                                    <th>EMI Payment Date</th>
                                    <th>Amount Received</th>
                                    <th>Reference Number</th>
                                    <th>Source</th>
                                    <th>Transaction No.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$collection->narration}}</td>
                                    <td>{{$collection->emi_payment_date}}</td>
                                    <td>{{$collection->amount_received}}</td>
                                    <td>{{$collection->ref_no}}</td>
                                    <td>{{$collection->source}}</td>
                                    <td>{{$collection->transaction_number}}</td>
                                    <td></td>                                  
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <b>Cheque Bounce Details</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Narration</th>
                                    <th>Bounce Date</th>
                                    <th>Amount</th>
                                    <th>Reference Number</th>
                                    <th>Source</th>
                                    <th>Transaction No.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$bounce->narration}}</td>
                                    <td>{{$bounce->emi_payment_date}}</td>
                                    <td>{{$bounce->amount_received}}</td>
                                    <td>{{$bounce->ref_no}}</td>
                                    <td>{{$bounce->source}}</td>
                                    <td>{{$collection->transaction_number}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
</div>
@endsection

