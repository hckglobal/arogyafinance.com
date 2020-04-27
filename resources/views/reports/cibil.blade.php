<html>
<head>
    <title>Cibil Report</title>
    <link rel="stylesheet" media="all" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" media="all" type="text/css" href="/assets/admin/dist/css/cibil-report.css">
    <style type="text/css">
        /* Print styling */

@media print {

[class*="col-sm-"] {
    float: left;
}

[class*="col-xs-"] {
    float: left;
}

.col-sm-12, .col-xs-12 { 
    width:100% !important;
}

.col-sm-11, .col-xs-11 { 
    width:91.66666667% !important;
}

.col-sm-10, .col-xs-10 { 
    width:83.33333333% !important;
}

.col-sm-9, .col-xs-9 { 
    width:75% !important;
}

.col-sm-8, .col-xs-8 { 
    width:66.66666667% !important;
}

.col-sm-7, .col-xs-7 { 
    width:58.33333333% !important;
}

.col-sm-6, .col-xs-6 { 
    width:50% !important;
}

.col-sm-5, .col-xs-5 { 
    width:41.66666667% !important;
}

.col-sm-4, .col-xs-4 { 
    width:33.33333333% !important;
}

.col-sm-3, .col-xs-3 { 
    width:25% !important;
}

.col-sm-2, .col-xs-2 { 
    width:16.66666667% !important;
}

.col-sm-1, .col-xs-1 { 
    width:8.33333333% !important;
}
  
.col-sm-1,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-xs-1,
.col-xs-2,
.col-xs-3,
.col-xs-4,
.col-xs-5,
.col-xs-6,
.col-xs-7,
.col-xs-8,
.col-xs-9,
.col-xs-10,
.col-xs-11,
.col-xs-12 {
float: left !important;
}

body {
    margin: 0;
    padding 0 !important;
    min-width: 768px;
}

.container {
    width: auto;
    min-width: 750px;
}

body {
    font-size: 10px;
}

a[href]:after {
    content: none;
}

.noprint, 
div.alert, 
header, 
.group-media, 
.btn, 
.footer, 
form, 
#comments, 
.nav, 
ul.links.list-inline,
ul.action-links {
    display:none !important;
}

}

.head-font.title{
 color: #49bcd5 !important;
}
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h5 class="txt-dark">CIBIL REPORT</h6>
<!--                         <h3 class="txt-dark">Score : {{$info['cibil_score']}}</h6>
 -->                    </div>
                    <div class="pull-right">
                         <span class="txt-dark head-font capitalize-font mb-5">Enquiry Date:</span>
                         <span>{{$info['date']}}</span>
                         <br>
                         <span class="txt-dark head-font capitalize-font mb-5">Enquiry Time:</span>
                         <span>{{$info['time']}}</span>
                         <br>
                         <span class="txt-dark head-font capitalize-font mb-5">Control Number:</span>
                         <span>{{$info['control_number']}}</span>
                         <br>
                         <span class="txt-dark head-font capitalize-font mb-5">Member Reference Number:</span>
                         <span>{{$info['member_reference_number']}}</span>
                         <br>
                         <span class="txt-dark head-font capitalize-font mb-5">Member ID:</span>
                         <span>{{$info['member_id']}}</span>  
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-footer"></div>
               <!--  <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <span class="txt-dark head-font inline-block capitalize-font mb-5">Billed to:</span>
                                <span>Damn</span>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                    <span class="txt-dark head-font capitalize-font mb-5">Payment Method:</span>
                                    <br> Visa ending **** 4242
                                    <br> jsmith@email.com
                                </address>
                            </div>
                            <div class="col-xs-6 text-right">
                                <address>
                                    <span class="txt-dark head-font capitalize-font mb-5">order date:</span>
                                    <br> March 7, 2017
                                    <br>
                                    <br>
                                </address>
                            </div>
                        </div>
                        <div class="seprator-block"></div>
                        <div class="invoice-bill-table">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Totals</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BS-200</td>
                                            <td>$10.99</td>
                                            <td>1</td>
                                            <td>$10.99</td>
                                        </tr>
                                        <tr>
                                            <td>BS-400</td>
                                            <td>$20.00</td>
                                            <td>3</td>
                                            <td>$60.00</td>
                                        </tr>
                                        <tr>
                                            <td>BS-1000</td>
                                            <td>$600.00</td>
                                            <td>1</td>
                                            <td>$600.00</td>
                                        </tr>
                                        <tr class="txt-dark">
                                            <td></td>
                                            <td></td>
                                            <td>Subtotal</td>
                                            <td>$670.99</td>
                                        </tr>
                                        <tr class="txt-dark">
                                            <td></td>
                                            <td></td>
                                            <td>Shipping</td>
                                            <td>$15</td>
                                        </tr>
                                        <tr class="txt-dark">
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>$685.99</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div> -->

                 <!-- panel -->
                <div class="panel">
                    <div class="panel-heading section">Report Summary</div>
    
                    <div class="panel-body">
                        <div class="row">
                            
                            <div class="col-md-3"> 
                                <div>
                                    <span class="txt-dark head-font  title inline-block capitalize-font mb-5">
                                        ACCOUNTS
                                    </span> 
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        TOTAL:
                                    </span> 
                                    <span>{{$info['account_count']}}</span>
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        OVERDUE:
                                    </span> 
                                    <span>{{$info['overdue_count']}}</span>
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        ZERO-BALANCE:
                                    </span> 
                                    <span>{{$info['zero_balance_count']}}</span>
                                </div>
                               
                            </div>
                            <div class="col-md-3"> 
                                <div>
                                    <span class="txt-dark head-font inline-block title capitalize-font mb-5">
                                        ADVANCES
                                    </span> 
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        HIGH CR/SANC. AMT:
                                    </span> 
                                    <span>{{$info['sanction_amount']}}</span>
                                </div>
                            </div>

                            <div class="col-md-3"> 
                                <div>
                                    <span class="txt-dark head-font title inline-block capitalize-font mb-5">
                                        BALANCES
                                    </span> 
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        CURRENT:
                                    </span> 
                                    <span>{{$info['current_balance']}}</span>
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        OVERDUE:
                                    </span> 
                                    <span>{{$info['overdue_amount']}}</span>
                                </div>
                            </div>
                            <div class="col-md-3"> 
                                <div>
                                    <span class="txt-dark head-font title inline-block capitalize-font mb-5">
                                        DATE OPENED
                                    </span> 
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        Recent:
                                    </span> 
                                    <span>{{$info['recent_opened_date']}}</span>
                                </div>
                                <div>
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                        OLDEST:
                                    </span> 
                                    <span>{{$info['oldest_opened_date']}}</span>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                  
                </div>
                @foreach($data as $segment)
                <!-- panel -->
                <div class="panel">
                    <div class="panel-heading section">{{$segment['name']}}</div>
                    @foreach($segment['sections'] as $section)
                    <div class="panel-body">
                        <div class="row">
                            @foreach($section as $field)
                            @if($field['field_name']!=="Segment Tag")
                            <div class="col-md-4"> 
                                <span class="txt-dark head-font inline-block capitalize-font mb-5">
                                    {{$field['field_name']}} :
                                </span> 
                                @if (stripos($field['field_name'], 'payment history') !== false && stripos($field['field_name'], 'date') != true) 
                                <span >{{ wordwrap($field['field_value'],3, ' ' , true )}}</span>
                                @else
                                <span>{{$field['field_value']}}</span>
                                @endif
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
               @endforeach
                <div class="panel"> 
                    <div class="panel-footer">
                        <h4 class="text-dark">END OF REPORT FOR {{$info['consumer_name']}}</h4>
                        <p>All information ("Information") contained in this credit information report (CIR) is the current and up to date information collated by TransUnion CIBIL
                            Limited based on information provided by its various members ("Members"). By accessing and using the Information, the user acknowledges and accepts
                            the following: While TransUnion CIBIL takes reasonable care in preparing the CIR, TransUnion CIBIL shall not be responsible for errors and/or omissions
                            caused by inaccurate or inadequate information submitted to it. However, TransUnion CIBIL shall take reasonable steps to ensure accurate reproduction
                            of the information submitted by the Members and, to the extent statutorily permitted, it shall correct any such inaccuracies in the CIR. Further, TransUnion
                            CIBIL does not guarantee the adequacy or completeness of the information and/or its suitability for any specific purpose nor is TransUnion CIBIL
                            responsible for any access or reliance on the CIR. The CIR is not a recommendation by TransUnion CIBIL to any Member to (i) lend or not to lend; (ii)
                            enter into or not to enter into any financial transaction with the concerned individual/entity. Credit Scores do not form part of the CIR. The use of the CIR is
                            governed by the provisions of the Credit Information Companies (Regulation) Act, 2005, the Credit Information Companies Regulations, 2006, Credit
                            Information Companies Rules, 2006 and the terms and conditions of the Operating Rules for TransUnion CIBIL and its Members.</p>
                    </div>
                </div>
                <!-- panel -->
            </div>
        </div>
    </div>
</body>
</html>