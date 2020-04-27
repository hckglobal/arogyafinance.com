<div class="box box-widget widget-user-2 col-md-4">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-aqua-active">
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username">{{$borrower->first_name}} {{$borrower->last_name}}</h3>
        <h5 class="widget-user-desc">Arogya {{$application->type}} applicant</h5>
    </div>
    <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
            <li class="{{Request::is('user/dashboard') ? 'active':''}}">
                <a href="/user/dashboard">Dashboard</a>
            </li>
            @if($application->type == "card" && $application->card_no)
            <li class="{{Request::is('user/apply-for-loan')? 'active':''}}">
                <a href="/user/apply-for-loan">Apply for Loan </a>
            </li>
            @endif
            <li class="{{Request::is('user/documents') ? 'active':''}}">
                <a href="/user/documents">Documents</a>
            </li>
            <li class="{{Request::is('user/payment-status') ? 'active':''}}">
                <a href="/user/payment-status">Payments</a>
            </li>
            
            <li>
                @if($application->status=='sanctioned' || $application->status=='disbursed')
                        <a href="/user/request/emandate/{{$application->id}}" type="button"> E-Mandate</a>
                @endif  
            </li>
            <li class="{{Request::is('user/apply-for-topup/*') ? 'active':''}}">
                <a href="/user/apply-for-topup" target="_blank">Apply For Topup</a>
            </li>
            <li class="{{Request::is('logout') ? 'active' : ''}}">
                <a href="/logout">Logout</a>
            </li>
        </ul>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mandate-details" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h3 class="modal-title" id="lineModalLabel">Request Mandate</h3>
        </div>
        <div class="modal-body">
            <form action="/user/request/mandate/{{$application->id}}" method="GET">
             <div class="form-group">
                <h3><i class="glyphicon glyphicon-bank"></i>Bank Details</h3>
                <div class="col-sm-12">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <label>Bank Name</label>
                    <input class="form-control" type="text" 
                    @if($application->bank_name) value="{{$application->bank_name}}" @else value="" @endif
                    value=""name="bank_name" placeholder="Bank name" aria-required="true" aria-invalid="true" required="true">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <label>Bank Account Holder Name</label>
                    <input class="form-control" type="text" 
                        @if($application->bank_customer_name) value="{{$application->bank_customer_name}}" @else value="" @endif
                        name="bank_customer_name" placeholder="A/c holder name" aria-required="true" aria-invalid="true" required="true">
                </div>
                <div class="col-md-6">
                    <label>Bank Account Number</label>
                    <input class="form-control" type="text" 
                        @if($application->bank_account_number) value="{{$application->bank_account_number}}" @else value="" @endif
                        name="bank_account_number" placeholder="A/c number" aria-required="true" aria-invalid="true" required="true">
                </div>
                <div class="col-md-6">
                    <label>Bank Account Type</label>
                    <select class="form-control" name="bank_account_type" aria-required="true" aria-invalid="true" required="true">
                        <option selected="" disabled="">Select A/c Type</option>
                        <option @if($application->bank_account_type == "current_account")) selected @endif value="current_account">Current Account</option>
                        <option @if($application->bank_account_type == "savings")) selected @endif value="savings">Savings</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Bank IFSC Code</label>
                    <input class="form-control" type="text" 
                        @if($application->bank_ifsc_code) value="{{$application->bank_ifsc_code}}" @else value="" @endif
                        name="bank_ifsc_code" placeholder="IFSC code" aria-required="true" aria-invalid="true" required="true">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
         </form>
    </div>
  </div>
</div>
<!-- line modal -->