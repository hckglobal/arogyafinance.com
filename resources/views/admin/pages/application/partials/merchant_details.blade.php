<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-university"></i><b> Merchant Details</b></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">                
                <b>Merchant Id </b> : {{$application->merchantName->merchant_id}} <br>
                <b>Merhcant Location Id </b> : {{$application->merchantName->merchant_location_id}}<br>
                <b>Bank Account no </b> : {{$application->merchantName->bank_account_no}} <br>
                <b>Bank Name </b> : {{$application->merchantName->bank_name}} <br>                
            </div>
            <div class="col-md-4">
                <b>Bank Address </b> : {{$application->merchantName->bank_address}} <br>
                <b>Bank IFSC Code </b> : {{$application->merchantName->bank_ifsc_code}} <br>
                <b>Bank Account Name </b> : {{$application->merchantName->bank_account_name}} <br>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>