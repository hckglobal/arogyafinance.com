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
            <div class="col-md-6">
                <!-- general form elements disabled -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <b>Cheque Bounce Details</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" method="post" action="/admin/application/collection-mark-bounce/{{$collection->id}}" method="post">
                            <!-- text input -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="application_id" value="{{$collection->application->id}}">
                            <input type="hidden" name="amount_received" value="-{{$collection->amount_received}}">
                            <input type="hidden" name="type" value="bounce">
                            <input type="hidden" name="transaction_number" value="{{$collection->transaction_number}}">

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bounce Date *</label>
                                    <input type='date' class="form-control" name="emi_payment_date" 
                                    placeholder="Select payment date" aria-required="true" aria-invalid="true" required>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                    <label>Narration *</label>
                                    <textarea name="narration" class="form-control" placeholder="Enter narration" aria-required="true" aria-invalid="true" required></textarea>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reference Number</label>
                                    <input class="form-control" type="text" name="ref_no" placeholder="Enter refernce number" aria-required="true" aria-invalid="true">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label>Source</label>
                                    <input class="form-control" type="text" name="source" placeholder="Enter point of source" aria-required="true" aria-invalid="true">
                                </div>
                              </div>
                            <div class="clearfix"></div>

                            <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">Add Bounce</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
</div>
@endsection

