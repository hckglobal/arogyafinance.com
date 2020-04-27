<div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-inr"></i> <b>Financial Details</b></h3>
            </div>
            <div class="box-body capitalize-field">
                <div class="row">

                    <div class="col-md-4">
                        <b>Borrower's Income</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="borrowers_income" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter borrower income"> {{$application->borrower->borrowers_income}}</a>
                        <br>
                        <b>Income as per ITR</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="income_itr" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter borrower income itr"> {{$application->borrower->income_itr}}</a>
                        <br>
                        <b>Earning Since</b>: <!-- <a href="#" class="editable-click inline-edit" data-name="earning_since" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter earning since"> {{$application->borrower->earning_since}}</a> -->
                        <a href="#" class="residing_since editable-click" 
                            data-name="earning_since" 
                            data-type="select" data-pk="{{$application->borrower->id}}"
                            data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"
                            sourceCache="false" 
                            data-title="Enter earning since">
                        {{$application->borrower->earning_since}}
                        </a>

                        <br> @if($application->borrower->other_earnings_type)
                        <b>Other Earning Type</b>: <a href="#" class="editable-click inline-edit" data-name="other_earnings_type" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter other earnings type"> {{$application->borrower->other_earnings_type}}</a> 
                        <br>
                        <b>Other Earnings</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="other_earnings" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter other earnings"> {{$application->borrower->other_earnings}}</a>
                        <br> @else
                        <b>Other Earning Type</b>: <a href="#" class="editable-click inline-edit" data-name="other_earnings_type" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter other earnings type"></a> 
                        <br>
                        <b>Other Earnings</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="other_earnings" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter other earnings"></a>
                        
                        <br> @endif
                        <b>Montly EMI Possible</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="requested_emi" data-type="text" data-pk="{{$application->id}}" data-url="/admin/application/family-details/edit/{{$application->id}}" data-title="Enter requested emi"> {{$application->requested_emi}}</a>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <b>Estimated Cost</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="estimated_cost" data-type="text" data-pk="{{$application->id}}" data-url="/admin/application/family-details/edit/{{$application->id}}" data-title="Enter estimated cost"> {{$application->estimated_cost}}</a>
                        <br>
                        <b>Loan Required</b>: &#8377;<a href="#" class="editable-click inline-edit" data-name="loan_required" data-type="text" data-pk="{{$application->id}}" data-url="/admin/application/family-details/edit/{{$application->id}}" data-title="Enter loan required"> {{$application->loan_required}}</a>
                        <br>
                        @if($application->borrower->current_loan_emi)
                            <b>Current Loan EMI</b>: &#8377; <a href="#" class="editable-click inline-edit" data-name="current_loan_emi" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter current loan emi"> {{$application->borrower->current_loan_emi}}</a><br>
                        @else
                            <b>Current Loan EMI</b>: &#8377; <a href="#" class="editable-click inline-edit" data-name="current_loan_emi" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter current loan emi"></a><br>
                        @endif

                        @if($application->borrower->education_expenses)
                            <b>Education Expense</b>:  &#8377; <a href="#" class="editable-click inline-edit" data-name="education_expenses" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter education expenses"> {{$application->borrower->education_expenses}}</a><br>
                        @else
                            <b>Education Expense</b>: &#8377; <a href="#" class="editable-click inline-edit" data-name="education_expenses" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter education expenses"></a><br>
                        @endif
                        
                         @if($application->borrower->house_rent)
                            <b>House Rent</b>: &#8377; <a href="#" class="editable-click inline-edit" data-name="house_rent" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter house rent"> {{$application->borrower->house_rent}}</a><br>
                        @else
                            <b>House Rent</b>: &#8377; <a href="#" class="editable-click inline-edit" data-name="house_rent" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter house rent"></a><br>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <b>Number of Dependants</b>: <a href="#" class="editable-click inline-edit" data-name="number_of_dependants" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter number of dependants"> {{$application->borrower->number_of_dependants}}</a>
                        <br>
                        <b>Nature of Income</b>:
                        <a href="#" class="nature_of_income editable-click" 
                            data-name="nature_of_income" 
                            data-type="select" data-pk="{{$application->borrower->id}}"
                            data-url="/admin/application/borrower/edit/{{$application->borrower->id}}"
                            sourceCache="false" 
                            data-title="Enter nature of income">
                        {{$application->borrower->nature_of_income}}
                        </a>
                        <br>
                        <b>Name of the Firm</b>: <a href="#" class="editable-click inline-edit" data-name="name_of_firm" data-type="text" data-pk="{{$application->borrower->id}}" data-url="/admin/application/borrower/edit/{{$application->borrower->id}}" data-title="Enter number of firm"> {{$application->borrower->name_of_firm}}</a>
                        
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
