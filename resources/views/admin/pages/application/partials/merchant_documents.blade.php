<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-paperclip"></i><b> Merchant Documents</b></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">                
                <b><a href="{{$application->merchantDocument->consumer_profile_pic}}">
                    Consumer Pprofile Picture </a> </b> <br>
                <b><a href="{{$application->merchantDocument->aadhar_kyc_link}}">Aadhar KYC </a> </b> <br>
                <b><a href="{{$application->merchantDocument->pan_link}}"> PAN</a> </b> <br>
                <b><a href="{{$application->merchantDocument->signed_agreement_link}}">
                     Signed Agreement </a> </b> <br>    
            </div>
            <div class="col-md-4">                
                 <b><a href="{{$application->merchantDocument->nach_link}}">NACH </a> </b> <br>
                 <b><a href="{{$application->merchantDocument->others_link}}"> Others</a> </b> <br>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>