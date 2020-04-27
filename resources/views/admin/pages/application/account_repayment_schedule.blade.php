@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Account Repayment Schedule
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
                            <div class="col-md-3"> 
                                <h3 class="box-title">PIN : {{$application->pin_number}}</h3>
                            </div>  
                            <div class="col-md-3">
                                <h3 class="box-title">Overdue Amount : 
                                    {{$overdues}}
                                </h3>        
                            </div>
                            <div class="col-md-3"> 
                                <h3 class="box-title">Overdue in month : 
                                    {{$dpd}}
                                </h3>
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
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-3"> 
                                <h3 class="box-title">Loan Amount : &#8377; {{$application->approved_loan_amount}}</h3>
                            </div>  
                            <div class="col-md-3">
                                <h3 class="box-title">No. Advance EMI : 
                                    {{$application->advance_emi}}
                                </h3>        
                            </div>
                            <div class="col-md-3"> 
                                <h3 class="box-title">Tenure : {{$application->approved_loan_tenure}}</h3>
                            </div>
                            
                            <div class="col-md-2"> 
                                <a class="btn btn-block btn-primary" 
                                    href="/admin/application/export/collections/{{$application->id}}">
                                    <i class="ion-archive">&nbsp;</i>Export Collections
                                </a>
                            </div>

                            @if($application->status=='disbursed')
                            <div class="col-md-1">
                                <a href="/admin/application/closure-status/{{$application->id}}" 
                                    target="_blank">
                                    <button class="btn btn-default pull-right">Closure</button>
                                </a>
                            </div>
                            @endif
                            <!-- <form action= "/admin/application/closure-status/{{$application->id}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="application_id" value="{{$application->id}}">
                                <div class="col-md-1">
                                        <button type="submit" class="btn btn-default pull-right">
                                            Closure
                                        </button>
                                    </div>
                                </div>
                            </form> -->
                        </div>  
                    </div>
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-striped">
                            <thead>
                                <tr style="border-bottom: solid 2px black;border-top: solid 2px black">
                                    <td>Month at</td>
                                    <td>EMI Month</td>
                                    <td>EMI Amount</td>
                                    <td>Principal</td>
                                    <td>Interest</td>
                                    <td>Outstanding Principal</td>
                                    <td>Amount Received</td>
                                    <td>Payment Date</td>
                                    <td>Principal Adjustment</td>
                                    <td>Delay Charges</td>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php 
                                    if($ac_repayment_schedules->first()->type!='emi')
                                        $count=0;
                                    else  
                                        $count=1 
                                ?>
                                @foreach($ac_repayment_schedules as $ac_repayment_schedule)
                                    @if(Carbon\Carbon::parse($ac_repayment_schedule->emi_month)->format('Y-m')==Carbon\Carbon::now()->format('Y-m') && $ac_repayment_schedule->type=="emi")
                                    <tr style="border-bottom: solid 2px grey;border-top: solid 2px grey">
                                    @else
                                    <tr>
                                    @endif
                                    <td>{{$count++}}</td>
                                    <td>
                                        @if($ac_repayment_schedule->type=="emi")
                                            {{Carbon\Carbon::parse($ac_repayment_schedule['emi_month'])->format('d-m-Y')}}
                                        @endif                                         
                                    </td>
                                    <td>&#8377; {{$ac_repayment_schedule['emi']}}</td>
                                    <td>&#8377; {{$ac_repayment_schedule['principal']}}</td>
                                    <td>&#8377; {{$ac_repayment_schedule['interest']}}</td>
                                    <td>&#8377; {{$ac_repayment_schedule['outstanding_principal']}}</td>
                                    <td>
                                        <b>&#8377; {{number_format($ac_repayment_schedule->amount_received)}}
                                        </b>
                                    </td>
                                    <td>
                                        @if(isset($ac_repayment_schedule->emi_payment_date))
                                        @if($ac_repayment_schedule->type=="emi")
                                        {{Carbon\Carbon::parse($ac_repayment_schedule->getOriginal('emi_payment_date'))->format('d-m-Y')}}
                                        @else
                                        Advance EMI
                                        @endif
                                        
                                        @endif
                                    </td>
                                    <td>
                                        @if(Entrust::can('edit-collection'))
                                            @if($ac_repayment_schedule->type=="emi")
                                            <div class="row">
                                                <form 
                                                action="/admin/application/add-principal-adjustment/{$ac_repayment_schedule->id}" method="post">
                                                    <div class="col-md-7 input-group">
                                                        <input type="hidden" value="{{csrf_token()}}" name="_token">
                                                        <input type="hidden" name="id" value="{{$ac_repayment_schedule->id}}">
                                                        <input type="hidden" name="application_id" value="{{$application->id}}">
                                                        <input type="hidden" name="old_value" value="{{$ac_repayment_schedule->principal_adjustment_amount}}">
                                                        <input type="text" name="principal_adjustment_amount" 
                                                        value="{{$ac_repayment_schedule->principal_adjustment_amount}}" placeholder="" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button type="submit" class="btn btn-success btn-flat">Add</button>
                                                        </span>                                
                                                    </div>
                                                </form>
                                            </div>
                                            @endif
                                        @else
                                            {{$ac_repayment_schedule->principal_adjustment_amount}}
                                        @endif
                                    </td>
                                    <!-- <td>{{$ac_repayment_schedule->getDelayDays()['late_payment_charges']}}</td> -->
                                    <td>&#8377; {{$ac_repayment_schedule->delay_charges}}</td>
                                </tr>
                                @endforeach
                                <tr style="border-bottom: solid 2px black;border-top: solid 2px black">
                                    <td colspan="2">
                                        <b>Total</b>
                                    </td>
                                    <td>
                                        <b>&#8377; {{number_format($ac_repayment_schedules->sum('emi'))}}</b>
                                    </td>
                                    <td>
                                        <b>&#8377; {{number_format(round($ac_repayment_schedules->sum('principal')))}}</b>
                                    </td>
                                    <td colspan="2">
                                        <b>&#8377; {{number_format(round($ac_repayment_schedules->sum('interest')))}}</b>
                                    </td>
                                    <td>
                                        <b>&#8377; {{number_format($ac_repayment_schedules->sum('amount_received'))}}</b>
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        <b>&#8377; {{number_format($ac_repayment_schedules->sum('principal_adjustment_amount'))}}</b>
                                    </td>
                                    <!-- <td>&#8377; {{$application->getLatePaymentCharges()['late_payment_charges']}}</td> -->
                                    <td>&#8377; {{$ac_repayment_schedules->sum('delay_charges')}}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
