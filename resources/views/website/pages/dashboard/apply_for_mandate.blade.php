@extends('website.app')

@section('title')
Apply for Mandate
@endsection

@section('styles')
    <!-- Loading Plugin -->
    <script src="/assets/js/isLoading.min.js"></script>
    <!-- boootsrap -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.auto-complete.css"/>

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="application-exist">
            <div class="text-center thanku-style">
                <div class="thanku-img col-xs-12 col-md-12">
                    <img src="/assets/admin/dist/img/warning.svg" alt="">
                </div>
                <div class="col-xs-12 col-md-12">
                    <p>Do you really want to apply for mandate ?</p>
                </div>
                <div class="custom-application-exist">
                    <button class="btn btn-success btn-outline" id="btnSubmit">Request Mandate</button>
                </div>
            </div>
        </div>           
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="https://www.paynimo.com/paynimocheckout/server/lib/checkout.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            function handleResponse(res) {
                if (typeof res != 'undefined' && typeof res.paymentMethod != 'undefined' && typeof res.paymentMethod.paymentTransaction != 'undefined' && typeof res.paymentMethod.paymentTransaction.statusCode != 'undefined' && res.paymentMethod.paymentTransaction.statusCode == '0300') {
                    // success block
                } else if (typeof res != 'undefined' && typeof res.paymentMethod != 'undefined' && typeof res.paymentMethod.paymentTransaction != 'undefined' && typeof res.paymentMethod.paymentTransaction.statusCode != 'undefined' && res.paymentMethod.paymentTransaction.statusCode == '0398') {
                    // initiated block
                } else {
                    // error block
                }
            };

            $(document).off('click', '#btnSubmit').on('click', '#btnSubmit', function(e) {
                e.preventDefault();
        //T515015|1481197581115|5||ac649a1d21704f83befb76f6e7e916b6|9876543210|test@test.com|20-02-2020|01-03-2047|100|M|ADHO|||||1419896920DLBVLV
        var configJson = {
                    'tarCall': false,
                    'features': {
                        'showPGResponseMsg': true,
                        'enableNewWindowFlow': true,    //for hybrid applications please disable this by passing false
                        'enableExpressPay':true,
                        'siDetailsAtMerchantEnd': true,
                        'enableSI':true
                    },
                    'consumerData': {
                        'deviceId': 'WEBSH1', //possible values 'WEBSH1', 'WEBSH2' and 'WEBMD5'
                        'token': {!!json_encode($data['hash'])!!},
                        'returnUrl': {!!json_encode($redirect_url)!!},
                        'responseHandler': handleResponse,
                        'paymentMode': 'all',
                        'merchantLogoUrl': 'https://www.paynimo.com/CompanyDocs/company-logo-md.png',  //provided merchant logo will be displayed
                        'merchantId': {!!json_encode($data['merchantId'])!!},
                        'currency': 'INR',
                        'consumerId': {!!json_encode($data['consumerId'])!!}, //Your unique consumer identifier to register a SI
                        'consumerMobileNo': {!!json_encode($data['consumerMobileNo'])!!},
                        'consumerEmailId': {!!json_encode($data['consumerEmailId'])!!},
                        'txnId': {!!json_encode($data['txnId'])!!},   //Unique merchant transaction ID
                        'items': [{ 'itemId' : {!!json_encode($data['itemId'])!!}, 'amount' : {!!json_encode($data['amount'])!!}, 'comAmt':{!!json_encode($data['comAmt'])!!}}],
                        'customStyle': {
                            'PRIMARY_COLOR_CODE': '#3977b7',   //merchant primary color code
                            'SECONDARY_COLOR_CODE': '#FFFFFF',   //provide merchant's suitable color code
                            'BUTTON_COLOR_CODE_1': '#1969bb',   //merchant's button background color code
                            'BUTTON_COLOR_CODE_2': '#FFFFFF'   //provide merchant's suitable color code for button text
                        },
                        'debitStartDate': {!!json_encode($data['debitStartDate'])!!},
                        'debitEndDate': {!!json_encode($data['debitEndDate'])!!},
                        'maxAmount': {!!json_encode($data['maxAmount'])!!},
                        'amountType': {!!json_encode($data['amountType'])!!},
                        'frequency': {!!json_encode($data['frequency'])!!}, //  Available options DAIL, Week, MNTH, QURT, MIAN, YEAR, BIMN and ADHO
                    }
                };
                $.pnCheckout(configJson);
                if(configJson.features.enableNewWindowFlow){
                    pnCheckoutShared.openNewWindow();
                }
            });
        });
    </script>


@endsection
