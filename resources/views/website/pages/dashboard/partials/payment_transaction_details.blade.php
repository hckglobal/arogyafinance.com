<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-inr" aria-hidden="true"></i> Payment Details</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <div class="col-md-12">
                @if($application->transaction)
                <div class="alert alert-success alert-dismissible">
                    <h4><i class="fa fa-check-circle-o" aria-hidden="true"></i> Success</h4>
                    <h5><strong>Payment Details:</strong></h5>
                    <p>Transaction Number : {{$application->transaction->transaction_number}}</p>
                    <p>Amount Paid : {{$application->transaction->amount}}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>