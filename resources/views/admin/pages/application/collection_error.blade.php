@extends('admin.app')

@section('title') 
Collection Error | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('admin.partials.content-header')

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <p>List of Collections failed to import.</p>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>PIN</th>
                  <th>EMI Payment Date</th>
                  <th>Amount Received</th>
                  <th>Narration</th>
                  <th>Ref Number</th>
                  <th>Source</th>
                  <th>Type</th>
                  <th>Transcation No</th>
                </tr>
              </thead>
              <tbody>
                @foreach($error_record as $error)
                <tr>
                  <td>{{$error['pin_number']}}</td>
                  <td>{{$error['emi_payment_date']}}</td>
                  <td>{{$error['amount_received']}}</td>
                  <td>{{$error['narration']}}</td>
                  <td>{{$error['ref_no']}}</td>
                  <td>{{$error['source']}}</td>
                  <td>{{$error['type']}}</td>
                  <td>{{$error['transaction_number']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<!-- DataTables -->
<script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
$(".table").DataTable();

});
</script>
@endsection

