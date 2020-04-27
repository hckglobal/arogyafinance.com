<div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-inr"></i> <b>Calculated Financial Details</b></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <b>Total Borrower's Income</b> : &#8377;{{$application->total_borrowers_income}}
                        <br>
                        <b>Calculated Montly Income</b> : &#8377;{{$application->calculated_income}}
                        <br>
                    </div>
                    <div class="col-md-4">
                        <b>Calculated Loan Amount</b> : &#8377;{{$application->calculated_loan_amount}}
                        <br>
                        <b>Calculated Loan EMI</b> : &#8377;{{$application->calculated_loan_emi}}
                        <br>
                        <b>Calculated Loan Tenure :</b> {{$application->calculated_loan_tenure}} Months (Requested : {{$application->requested_tenure}} Months)
                        <br>
                    </div>

                    <div class="col-md-4">
                       
                        <b>Emi as per flat interest rate</b> :  &#8377; {{$application->flat_interest_rate}}
                      
                        <br>
                        <b>IRR</b> : {{$application->effective_interest_rate}} %
                        <br>

                        <br>
                    
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>