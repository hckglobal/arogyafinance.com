@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Loan Closure Status
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
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <b>Loan Closure Date</b></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            @if(!$application->applicationClosure)
                            <form action= "/admin/application/closure-status/{{$application->id}}" method="get">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="end_date">Select Date</label>
                                        <div class='input-group date' id='closure_date'>
                                            <input type='text' class="form-control" 
                                            name="closure_date" @if($input->closure_date) value={{$input->closure_date}} @else
                                            value="{{Carbon\Carbon::now()->format('d-m-Y')}}" @endif>
                                            <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>   
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group contact-search m-b-30">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-block btn-primary">
                                            Get Details
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endif
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <a class="btn btn-block btn-primary" 
                                    href="/admin/application/export/loan-closure/{{$application->id}}?{{$input->getQueryString()}}">
                                    <i class="ion-archive">&nbsp;</i>Export Closure
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">  
                            @if($application->collections()->bounce()->count())
                            <div class="col-md-3">
                                <label></label> <br>
                                <a href="/admin/application/view-cheque-bounce-schedule/{{$application->id}}"
                                  target="_blank">
                                    <button class="btn btn-default">View Bounce</button>
                                </a>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <label></label> <br>
                                <a href="/admin/application/view-account-repayment-schedule/{{$application->id}}"
                                  target="_blank">
                                    <button class="btn btn-default">Acc Repayment Schedule</button>
                                </a>
                            </div>
                            <div class="col-md-1 pull-right">
                                <label></label> <br>
                                <a href="/admin/application/{{$application->type}}/detail/{{$application->id}}"
                                  target="_blank">
                                    <button class="btn btn-default pull-right">Back</button>
                                </a>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
            @if(!$application->applicationClosure)
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <b>Loan Closure Detail</b></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            @if(Entrust::can('manage-legal-charges'))
                            <div class="col-md-6">
                                <form action= "/admin/application/add-closure-charges/{{$application->id}}" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="application_id" value="{{$application->id}}">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Legal Charges</label>
                                            <input type='number' class="form-control" 
                                            name="legal_charges" 
                                            placeholder="Enter legal amount" aria-required="true" aria-invalid="true" required min="0" value="{{$application->legal_charges}}" step=".01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update Legal Charges</button>
                                        </div>
                                    </div> 
                                </form>
                            </div>
                            @endif

                            @if(Entrust::can('manage-waiver-charges'))
                                @if($application->wavied_off<=$max_waiver)
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action= "/admin/application/add-closure-charges/{{$application->id}}" method="post">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" name="application_id" value="{{$application->id}}">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Waiver (Max Limit : {{$max_waiver}})</label>
                                                    <input type='number' class="form-control" 
                                                    name="wavied_off" 
                                                    placeholder="Enter waiver amount" aria-required="true" aria-invalid="true" required min="0" max="{{$max_waiver}}"  value="{{$application->wavied_off}}" step=".01">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Update Waiver Charges</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        @if(Entrust::can('manage-bounce-charges'))
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label> </label><br>
                                        <a type="button" class="btn btn-info" data-toggle="modal" data-target="#add-bounce">
                                            Add Bounce
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(Entrust::can('manage-bounce-charges'))
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label> </label><br>
                                        <a type="button" class="btn btn-info" data-toggle="modal" data-target="#add-collection">
                                            Add Closure Amount
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif                        
                    </div>
                </div>
            </div>
            @endif
            <div class="col-xs-6">
                <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                    <b>Loan Closure Summary as on {{{$application->applicationClosure?Carbon\Carbon::parse($application->applicationClosure->closure_date)->format('j, F Y'):Carbon\Carbon::parse($closure_month)->format('j, F Y')}}}</b></h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <tbody>
                            @if($application->applicationClosure)
                                <tr>
                                    <td>Overdue/EMI</td>
                                    <td>&#8377; {{$application->applicationClosure->overdue_amount}}</td>
                                </tr>
                                <tr>
                                    <td>Principal OS</td>
                                    <td>&#8377; {{$application->applicationClosure->principal_outstanding}}</td>
                                </tr>
                                <tr>
                                    <td>Principal OS Adjustment</td>
                                    <td>&#8377; {{$application->applicationClosure->adjusted_principal}}</td>
                                </tr>
                                
                                <tr>
                                    <td>Dishonor Charges (No of Cheque Bounces: {{$no_of_bounced_cheque}})</td>
                                    <td>&#8377; {{$application->applicationClosure->adjusted_dishonor}}</td>
                                </tr>
                                <tr>
                                    <td>Late Payment Charges (DPD: {{$total_delay_days}})</td>
                                    <td>&#8377; {{$application->applicationClosure->adjusted_late_payment}}</td>
                                </tr>
                                <tr>
                                    <td>Legal Charges</td>
                                    <td>&#8377; {{$application->applicationClosure->adjusted_legal}}</td>
                                </tr>
                                <tr>
                                    <td>Pre-payment Charges</td>
                                    <td>&#8377; {{$application->applicationClosure->adjusted_pre_payment}}</td>
                                </tr>
                                <tr>
                                    <td>Waiver</td>
                                    <td>&#8377; {{$application->applicationClosure->adjusted_waived_off}}</td>
                                </tr>
                                <tr>
                                    <td>Closure Amount</td>
                                    <td>&#8377; {{$application->applicationClosure->closure_amount}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>Overdue/EMI</td>
                                    <td>&#8377; {{$overdue}}</td>
                                </tr>
                                <tr>
                                    <td>Principal OS</td>
                                    <td>&#8377; {{$outstanding_principal}}</td>
                                </tr>
                                <tr>
                                    <td>Dishonor Charges (No of Cheque Bounces: {{$no_of_bounced_cheque}})</td>
                                    <td>&#8377; {{$dishonor_charges}}</td>
                                </tr>
                                <tr>
                                    <td>Late Payment Charges (DPD: {{$total_delay_days}})</td>
                                    <td>&#8377; {{$late_payment_charges}}</td>
                                </tr>
                                <tr>
                                    <td>Legal Charges</td>
                                    <td>&#8377; {{$legal_charges}}</td>
                                </tr>
                                <tr>
                                    <td>Pre-payment Charges</td>
                                    <td>&#8377; {{$pre_payment_charges}}</td>
                                </tr>
                                <tr>
                                    <td>Total Charges</td>
                                    <td>&#8377; {{$total_charges}}</td>
                                </tr>
                                <tr>
                                    <td>Waiver</td>
                                    <td>&#8377; {{$wavied_off}}</td>
                                </tr>
                                <tr>
                                    <td>Closure Amount</td>
                                    <td>&#8377; {{$closure_amount}}</td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>        
                </div>
                </div>
            </div>
        
        </div>
    </section>
</div>

<!-- Add Cheque Bounce collection -->
<div class="modal fade" id="add-bounce" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h3><i class="fa fa-check-circle-o "></i> Bounce Detail</h3>
      </div>
      <div class="modal-body">
        <form action= "/admin/application/collection-add-bounce/{{$application->id}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. of Cheque Bounce *</label>
                        <input class="form-control" type="number" name="no_of_cheque_bounce" placeholder="Enter no. of cheque bounce" aria-required="true" aria-invalid="true" required step="1" min="1"  max="100">
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>  
<!-- Add Cheque Bounce collection -->

<!-- Add Closure Collection -->
<div class="modal fade" id="add-collection" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h3><i class="fa fa-check-circle-o "></i> Add Closure Amount</h3>
      </div>
      <div class="modal-body">
        <form action= "/admin/application/collection/add-closure-amount" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="application_id" value="{{$application->id}}">
        <input type="hidden" name="type" value="emi">
        @if($input->closure_date)
            <input type="hidden" name="emi_payment_date" value="{{$input->closure_date}}">
        @else
            <input type="hidden" name="emi_payment_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
        @endif
        <input type="hidden" name="amount_received" value="{{$closure_amount}}">
        <input type="hidden" name="narration" value="Closure Amount">
        <input type="hidden" name="dishonor_charges" value="{{$dishonor_charges}}">
        <input type="hidden" name="late_payment_charges" value="{{$late_payment_charges}}">
        <input type="hidden" name="pre_payment_charges" value="{{$pre_payment_charges}}">
        <input type="hidden" name="legal_charges" value="{{$legal_charges}}">
        <input type="hidden" name="wavied_off" value="{{$wavied_off}}">
        <input type="hidden" name="overdue" value="{{$overdue}}">
        <input type="hidden" name="outstanding_principal" value="{{$outstanding_principal}}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Closure Date *</label>
                    <div id='closure_date'>
                        <input type='text' class="form-control" 
                        name="emi_payment_date"  disabled @if($input->closure_date) value={{$input->closure_date}} @else
                        value="{{Carbon\Carbon::now()->format('d-m-Y')}}" @endif>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Closure Amount*</label>
                    <input class="form-control" type="text" name="amount_received" value="{{$closure_amount}}" placeholder="Enter amount" aria-required="true" aria-invalid="true" disabled>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Transaction Number *</label>
                    <input class="form-control" type="text" name="transaction_number" placeholder="Enter transaction number" aria-required="true" aria-invalid="true" required>
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
            <div class="col-md-12">
                <div class="form-group">
                    <label>Narration *</label>
                    <textarea name="narration" class="form-control" placeholder="Enter narration" aria-required="true" aria-invalid="true" required disabled>Closure Amount</textarea>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>  
<!-- Add Closure Collection -->

@endsection

@section('scripts')           
<script type="text/javascript">
    $(document).ready(function() {
        $('#closure_date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
        });
    });
</script>
@endsection