@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Repayment Schedule
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')
<div class="content-wrapper" >
    <section class="content" id="application" >
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-9"> 
                                <h3 class="box-title">PIN : {{$application->pin_number}}</h3>
                            </div>  
                            <div class="col-md-2">
                                <a href="/admin/application/view-repayment-collections/{{$application->id}}" 
                                    target="_blank">
                                    <button class="btn btn-default pull-right">View Collections</button>
                                </a>
                            </div>
                            <div class="col-md-1">
                                <a href="/admin/application/{{$application->type}}/detail/{{$application->id}}"
                                    target="_blank">
                                    <button class="btn btn-default pull-right">Back</button>
                                </a>
                            </div>  
                        </div>  
                    </div>
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>EMI No.</td>
                                    <td>EMI Type</td>
                                    <td>EMI Date</td>
                                    <td>EMI Amount</td>
                                    <td>Principal Amount</td>
                                    <td>Interest Amount</td>
                                    <td>Outstanding Principal Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                            <tr align="center" valign="center">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$application->approved_loan_amount}}</td>
                            </tr>
                            @foreach($application->idealRepaymentSchedule() as $ideal_repayment_schedule)
                            <tr align="center" valign="center">
                                <td>@if($ideal_repayment_schedule['type']!='advance_emi')
                                    {{++$ideal_repayment_schedule['month_at']}}
                                    @else
                                    0
                                    @endif</td>
                                <td>{{$ideal_repayment_schedule['type']}}</td>
                                <td>
                                    @if($ideal_repayment_schedule['type']!='Advance EMI')
                                        @if($ideal_repayment_schedule['emi_month']!='0000-00-00')
                                            {{Carbon\Carbon::parse($ideal_repayment_schedule['emi_month'])->format('m-Y')}}
                                        @endif
                                    @endif
                                </td>
                                <td>{{$ideal_repayment_schedule['emi']}}</td>                        
                                <td>@if($ideal_repayment_schedule['type']=='Advance EMI') -- @else{{round($ideal_repayment_schedule['principal'])}} @endif</td>
                                <td>@if($ideal_repayment_schedule['type']=='Advance EMI') -- @else {{round($ideal_repayment_schedule['interest'])}} @endif</td>
                                <td>{{round($ideal_repayment_schedule['outstanding_principal'])}}</td>
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

