<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-inr" aria-hidden="true"></i> Payment</h3>
        <h4>Payment for Arogya {{ucfirst($application->type)}} is Rs.{{$amount}} @if($application->type=='loan')(Inclusive of 18% GST)@endif</h4>
    </div>
    <div class="box-body">
        <div class="form-group">
            <div class="col-md-12">
                @if (Session::has('message_card_failed'))
                <div class="alert alert-danger alert-dismissible">
                    <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Error</h4> {{ Session::get('message_card_failed') }}
                    <br><b>Payment Details:</b>
                    <br> Amount Due: 1000
                </div>
                @endif @if (Session::has('message_card_success'))
                <div class="alert alert-success alert-dismissible">
                    <h4><i class="fa fa-check-circle-o" aria-hidden="true"></i>Success</h4> {{ Session::get('message_card_sucess') }}
                    <br><b> Payment Details:</b>
                    <br> Transaction Number : {{$application->transaction->transaction_number}}
                    <br> Amount Paid : {{$application->transaction->amount}}
                </div>
                @endif
                <a href="/payment/user/{{$application->type}}" class="btn btn-primary">Click here to pay for Arogya {{$application->type}}</a>
                <br>
                <br>
            </div>
            <div class="">
                <div class="col-sm-4">
                    <a href="javascript:void(0);" class="btn btn-primary">Processing Fee Payment</a>
                    <br>
                    <br>
                </div>
                <div class="col-sm-4">
                    <a href="javascript:void(0);" class="btn btn-primary">Documentation Fee</a>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>