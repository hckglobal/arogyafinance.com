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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collection as $bounce)
                                <tr>
                                    <td>{{$bounce->narration}}</td>
                                    <td>{{$bounce->emi_payment_date}}</td>
                                    <td>{{$bounce->amount_received}}</td>
                                    <td>{{$bounce->ref_no}}</td>
                                    <td>{{$bounce->source}}</td>
                                    <td>{{$bounce->transaction_number}}</td>
                                    <td>
                                        @if(Entrust::can('manage-cheque-bounce'))
                                            <a href="/admin/application/collection-bounce-delete/{{$bounce->id}}" 
                                            data-toggle="tooltip" data-placement="top" title="Delete Bounce">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
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

