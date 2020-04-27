@extends('admin.app')

@section('title') 
{{$title}}
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('content')

<div class="content-wrapper">
@include('admin.partials.content-header')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4"> 
                                <h3 class="box-title">Total Applications : {{$applications->count()}}</h3>
                            </div>  
                            <div class="col-md-4">
                                <h3 class="box-title">Total Loan Amount : {{$applications->sum('approved_loan_amount')}}</h3>
                            </div>
                            <div class="col-md-2 pull-right">
                                <a class="btn btn-block btn-primary" href="/admin/report/todays/disbursement?export=yes">
                                    <i class="ion-archive">&nbsp;&nbsp;</i>    Export
                                </a>
                            </div>    
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>PIN</th>
                                    <th>Borrower Name</th>
                                    <th>Loan to be disbursed to</th>
                                    <th>Loan Amount</th>
                                    <th>Tenure</th>
                                    <th>EMI</th>
                                    <th>Advance EMI</th>
                                    <th>Disbursement Date</th>
                                    <th>Product</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{$application->pin_number}}</td>   
                                    <td>{{$application->borrower->first_name}} {{$application->borrower->last_name}}</td>   
                                    <td>{{$application->approved_hospital_name}}</td>   
                                    <td>{{$application->approved_loan_amount}}</td>
                                    <td>{{$application->approved_loan_tenure}}</td>
                                    <td>{{$application->approved_loan_emi}}</td>
                                    <td>{{$application->advance_emi}}</td>
                                    <td>{{Carbon\Carbon::parse($application->getOriginal('disbursement_date'))->format('j F,Y')}}</td>
                                    <td>{{$application->product->name}}</td>
                                    <td>{{$application->location->name}}</td>
                                    <td><a href="/admin/application/{{$application->type}}/detail/{{$application->id}}" class="btn btn-block btn-success">View</a></td>
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

