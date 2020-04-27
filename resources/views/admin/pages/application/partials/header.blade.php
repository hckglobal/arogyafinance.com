<div class="row">
    <div class="col-xs-12" id="application">
        <h2 class="page-header">
                </i> Arogya Finance
                <small>Date: {{$application->created_at}}</small>
                
                <div class="dropdown pull-right btn-action-btn">
				    <button class="btn btn-default dropdown-toggle  action-btn" type="button" id="menu1" data-toggle="dropdown">
				    <i class="fa fa-bars margin-icon"></i>
				    Update Application
				    </button>
				    <ul class="dropdown-menu" role="menu">
                   <!--  <li>
	                    <a href="/admin/application/full/download-pdf/{{$application->id}}" >
	                      <i class="fa fa-download"></i>Download Application
	                    </a>
	                </li> -->
	                @if($application->status=='lead')
		                <li>
	                		<a href="/apply/loan/financial-details/{{$application->id}}" target="_blank">
	                 	    	<i class="fa fa-edit"></i>
	                 	    	Complete Partial Application
	                 		</a>
	                 	</li>	
	                @endif
                    @if(Entrust::can('view-main-menu'))
	                    @if($application->status=='new' && Entrust::can('verify-application'))
	                    <li>
		                	<a @click="showConfirmModal('/admin/application/update/status/verified/{{$application->id}}','verify')" href="javascript:;">
		                  		<i class="fa fa-print"></i> Verify {{$application->type}}
		                	</a>
		                </li>
		                @endif
		                
		                @if($application->status=='verified' && Entrust::can('sanction-application') && $application->references->count()>=2)
			                <li>
			                	<a @click="showConfirmModal('/admin/application/update/status/sanctioned/{{$application->id}}','{{$sanction_label}}')" 
					                href="javascript:;">
			                  		<i class="fa fa-print"></i> 
			                  		{{$application->type=="loan" ? 'Sanction'  : 'Approve'}} {{$application->type}}
			                	</a>
			            	</li>
		                @endif

	                    @if($application->status=='verified' || $application->status=='sanctioned' || $application->status=='disbursed' || $application->status=='closed')
	                    	@if(Entrust::can('send-to-poonawalla'))
	                    	<li>
			                    <a href="/admin/application/send-to-poonawalla/{{$application->id}}" >
			                    	<i class="fa fa-envelope"></i>{{{$application->partner_reference_code=='poonawalla'? 'Send to poonawalla again ?':'Send to poonawalla'}}}
			                    </a>
			                </li>
			                @endif
			            @endif

	                    @if($application->status=='sanctioned' && Entrust::can('disburse-application'))
	                    	@if($application->checkDisbursable())
		                    <li>
		                    	@if($application->merchant=='ablepay')
		                    		<a href="/admin/application/{{$application->id}}/update/merchant" >
		                     	    	<i class="fa fa-file-pdf-o"></i>
		                     	    	{{$application->type=="loan" ? 'Disburse'  : 'Issued'}} {{$application->type}}
		                     		</a>
		                     	@else	
					                <!-- <a  @click="showConfirmModal('/admin/application/update/status/disbursed/{{$application->id}}','disburse')"href="javascript:;">
				                  		<i class="fa fa-print"></i>
				                  		{{$application->type=="loan" ? 'Disburse'  : 'Issued'}} {{$application->type}}
				                  	</a> -->
				                  	<a type="button" data-toggle="modal" data-target="#disburse-application">
				                  		<i class="fa fa-print" aria-hidden="true"></i>
				                  		{{$application->type=="loan" ? 'Disburse'  : 'Issued'}} {{$application->type}}
				                  	</a>
				                @endif
			                </li>
			                @endif
		                @endif
		                
		                @if($application->status=="disbursed" && Entrust::can('close-application'))
			                <li class="cursor">
			                	<a type="button" data-toggle="modal" data-target="#close-application"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Close Application</a>
			                </li>
		                @endif

		                @if(Entrust::can('sanction-application') && $application->status!="closed")
		                	<li>
		                		<a @click="showConfirmModal('mailto:jose@arogyafinance.com?subject=Escalation of {{$application->type}} From {{$application->borrower->first_name}} {{$application->borrower->last_name}} | PIN: {{$application->pin_number}} &body=Dear Sir,%0D%0AKindly look into the application received and process the same, details below,%0D%0Ahttps://arogyafinance.com/admin/application/loan/detail/{{$application->id}}','escalate')" href="javascript:;">
	     	                  		<i class="fa fa-user"></i> Escalate Form to Admin
	     	                	</a>
	     	                </li>
		                @endif

		                @if(Entrust::can('genereate-sanction-letter'))
		                	@if($application->status=='sanctioned' || $application->status=='disbursed' || $application->status=='closed')
			                    <li>
			                     	<a href="/sanction-letter/{{$application->id}}" >
			                     	    <i class="fa fa-file-pdf-o"></i> Generate Sanction Letter
			                     	</a>
			                    </li>

			                    <!-- <li>
			                        <a href="/sanction-letter/medtronic/{{$application->id}}" >
			                     	    <i class="fa fa-file-pdf-o"></i>Generate Sanction Letter (Medtronic)
			                        </a>
			                    </li>

			                    <li>
			                     	<a href="/sanction-letter/mantri/{{$application->id}}" >
			                     		<i class="fa fa-file-pdf-o"></i> Generate Sanction Letter (Credit Mantri)
			                     	</a>
			                    </li> -->
		                    @endif
		                    
		                    @if($application->status=='sanctioned' || $application->status=='disbursed' || $application->status=='closed')
			                    @if($application->valid_from)
			                    <li>
			                     	<a href="/sanction-letter/mid/{{$application->id}}" >
			                     		<i class="fa fa-download"></i> Most Important Document
			                     	</a>
			                    </li>
			                    @endif
			                    <li>
			                     	<a href="/sanction-letter/dpn/{{$application->id}}" >
			                     		<i class="fa fa-download"></i> Demand Promissory Note
			                     	</a>
			                    </li>
			                @endif

			                @if($application->status=='sanctioned' || $application->status=='disbursed')	                    
			                    @if($application->repaymentCheques->count()>0)
			                    <li>
			                     	<a href="/sanction-letter/repayment-cheque/{{$application->id}}" >
			                     		<i class="fa fa-download"></i> Repayment Cheques
			                     	</a>
			                    </li>	                   
		 						@endif
		 					@endif
		                @endif
		                
		                @if($application->id==2)	
		                	<li>
		                     	<a href="/sanction-letter/ach/{{$application->id}}" >
		                     		<i class="fa fa-download"></i> ACH
		                     	</a>
		                    </li>
		                @endif    

	                   <!-- @if(Entrust::can('generate-test-report'))
		                <li>
		                	
			                    <a href="/admin/application/download-pdf/{{$application->id}}" >
			                          <i class="fa fa-download"></i> Generate Test Report
			                    </a>
		                </li>
		                @endif -->
		                @if(Entrust::can('reject-application'))
			                @if($application->status=="lead" || $application->status=="new" || $application->status=="verified"
			                	|| $application->status=="sanctioned")
				                <li>
				                	<a href="javascript:;" type="button" data-toggle="modal" data-target="#reject" >
				                		<i class="fa fa-times" aria-hidden="true"></i> Reject Application
				                	</a>
				                </li> 
			                @endif
		                @endif

		                @if(Entrust::can('add-nominee'))
			                @if($application->status=="lead" || $application->status=="new" || $application->status=="verified"
			                	|| $application->status=="sanctioned")
				                <li class="cursor">
				                	<a type="button" data-toggle="modal" data-target="#add-nominee">
				                		<i class="fa fa-plus" aria-hidden="true"></i>Add Nominee
				                	</a>
				                </li>
			                @endif
			            @endif

			            @if(Entrust::can('add-reference'))
			                @if($application->status=='new' || $application->status=='verified'  && $application->references->count()<=1)
				                <li class="cursor">
				                	<a type="button" data-toggle="modal" data-target="#add-reference">
				                		<i class="fa fa-plus" aria-hidden="true"></i>Add Reference
				                			<small class="label pull-right @if($application->references->count()==0) bg-red @elseif($application->references->count()==1) bg-yellow @else bg-green @endif">{{$application->references->count()}}
			                        		</small>
			                        </a>
				                </li>
			                @endif
		                @endif

		                @if($application->type=="card")
			                <li class="cursor">
			                	<a type="button" data-toggle="modal" data-target="#add-family-member">
			                		<i class="fa fa-plus" aria-hidden="true"></i> Add Family Members
			                	</a>
			                </li>
		                @endif

		                @if($application->status!="closed")
			                <li class="cursor">
			                	<a type="button" data-toggle="modal" data-target="#add-repayment-cheque"><i class="fa fa-plus" aria-hidden="true"></i> Add Repayment Cheque</a>
			                </li>
		                @endif

		                @if(Auth::User()->roles()->first()->name!="partner" || Auth::User()->roles()->first()->name!="sales-representative")
		                <li>
		                	<a href="/admin/application/log/{{$application->id}}" > 
		                		<i class="fa fa-list" aria-hidden="true"></i>Logs
		                	</a>
		                </li>

		                <li>
		                	<a href="/admin/application/tat/{{$application->id}}" >
		                		<i class="fa fa-clock-o" aria-hidden="true"></i> Turn Around Time</a>
		                </li>
		                @endif

		                <li>
		                    <a href="/admin/application/summary/{{$application->id}}" >
		                      <i class="fa fa-download"></i>Download Application Summary
		                    </a>
		                </li>
		                
		                @if(Entrust::can('send-arogya-card') && $application->type=="card")
			                <li>
			                    <a href="/admin/application/download-arogya-card/{{$application->id}}" >
			                      <i class="fa fa-download"></i>Download Arogya Card
			                    </a>
			                </li>
			                <li>
			                    <a href="/admin/application/send-arogya-card/{{$application->id}}" >
			                      <i class="fa fa-credit-card"></i>Send Arogya Card
			                    </a>
			                </li>
		                @endif
		                @if(Entrust::can('send-ndc') && $application->status=="closed")
			                <li>
			                    <a href="/admin/application/send-ndc/{{$application->id}}" >
			                    	<i class="fa fa-envelope"></i>{{{$application->ndc_sent ? 'Send NDC Again' : 'Send NDC'}}}
			                    </a>
			                </li>
		                @endif
		                
		                @if(Entrust::can('can-switch-enable-pyschometric-test'))
			                @if($application->status=="lead" || $application->status=="new" || $application->status=="verified"
			                	|| $application->status=="sanctioned")
				                <li>
				                	<a href="/admin/application/switch-enable-pyschometric-test/{{$application->id}}">
				                    	<i class="fa fa-exchange"></i>
				                      	@if($application->enable_psychometric_test)
				                      		Disable Psychometric Test
					                    @else 
					                      	Enable Psychometric Test 
					                    @endif
				                    </a>
				                </li>
				            @endif
				        @endif    
		                
		                @if(Entrust::can('manage-dmi') && $application->status=='disbursed')
		                	@if($application->dmi_status=='lead')
			                	<li class="cursor">
				                	<a type="button" data-toggle="modal" data-target="#convertToLead">
				                		<i class="glyphicon glyphicon-check" aria-hidden="true"></i>Convert Lead
				                	</a>
				                </li>
			                @endif
			                @if(!$application->dmi_status)
				                <li class="cursor">
			                		<a type="button" data-toggle="modal" data-target="#comment">
			                			<i class="fa fa-paper-plane" aria-hidden="true"></i>Send To DMI
			                		</a>
			                	</li>
		                	@endif
		                @endif
		                
		                @if($application->status=='disbursed' || $application->status=='closed')
		                	@if(Entrust::can('view-repayment-schedule'))
			                <li>
			                	<a href="/admin/application/view-repayment-schedule/{{$application->id}}">
			                      <i class="fa fa-calendar"></i>
			                      	View Repayment Schedule 
			                    </a>
			                </li>
			                <li>
			                	<a href="/admin/application/view-account-repayment-schedule/{{$application->id}}">
			                      <i class="fa fa-inr"></i>
			                      	View Collection Data 
			                    </a>
			                </li>
			                @endif

			                @if(Entrust::can('regenerate-repayment'))
				                <li>
				                	<a href="/admin/application/re-generate/account-repayment/{{$application->id}}">
				                      <i class="ion-refresh"></i>
				                      	Re generate A/c Repayment
				                    </a>
				                </li>
			                @endif		                
		                @endif

	                	@if(Entrust::can('revert-application-stage'))
	                		@if($application->status!='lead' || $application->status!='new')
	                		<li class="cursor">
			                	<a type="button" data-toggle="modal" data-target="#revertStage">
			                		<i class="glyphicon glyphicon-refresh" aria-hidden="true"></i>Revert Stage
			                	</a>
			                </li>
	                		@endif
	                	@endif
	                @endif
	                
	                               

                  </ul>
				  </div>               	
                <div class="clearfix"></div>
              </h2>@include('admin.pages.application.partials.modal_confirm')
    </div>
    <!-- /.col -->
    <!-- Modal -->
    <div id="reject" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="/admin/application/update/status/rejected/{{$application->id}}" method="GET">
                {{csrf_field()}}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Warning!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to Reject the Application </p>
                    </div>
                    <div class="modal-body">
                        <p>Give Reason</p>
                        <select name="rejection_reason_id" id="" class="form-control">
                            @foreach($rejection_reasons as $reason)
                            <option value="{{$reason->id}}">{{$reason->text}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-body">
                        <p>Rejection Note</p>
                        <textarea name="rejection_note" id="" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- line modal -->

<!-- add reference -->

	<div class="modal fade" id="add-reference" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="lineModalLabel">Add References</h3>
			</div>
			<div class="modal-body">
				
	            <!-- content goes here -->
				<form action="/admin/application/save-reference/{{$application->id}}" method="POST">
	             <div class="form-group">
				    <h3><i class="glyphicon glyphicon-user"></i> Reference Info</h3>
				    <div class="col-sm-4">
				        <input type="hidden" name="_token" value="{{csrf_token()}}" />
				        <label>Name*</label>
				        <input class="form-control" type="text" name="name" placeholder="Name" aria-required="true" aria-invalid="true" required="true">
				    </div>
				    <div class="clearfix"></div>
				    <div class="col-md-4">
				        <label>Relation*</label>
				        <select class="form-control" name="relation" aria-required="true" aria-invalid="true" v-model="patient_gender" required="true">
				            <option selected="" disabled="">Select Relation</option>
				            <option value="Friend">Friend</option>
				            <option value="Relative">Relative</option>
				        </select>
				    </div>
				    <div class="col-md-4">
				        <label>Mobile Number*</label>
				        <input class="form-control" type="text" name="mobile_number" placeholder="Mobile Number" aria-required="true" aria-invalid="true" required="true">
				    </div>
				    <div class="clearfix"></div>
				     <div class="col-md-4">
				        <label>Address*</label>
				        <textarea class="form-control" type="text" name="address" placeholder="Address" aria-required="true" aria-invalid="true" required="true"></textarea>
				    </div>
				</div>
				<div class="clearfix"></div>
	              <!-- <button type="submit" class="btn btn-default">Submit</button> -->
	           

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<div class="btn-group btn-group-justified" role="group" aria-label="group button">
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
					</div>
					<div class="btn-group btn-delete hidden" role="group">
						<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
					</div>
					<div class="btn-group" role="group">
						<button type="button" id="saveImage" class="btn btn-default btn-hover-green" data-action="save" role="button">Save</button>
					</div>
				</div>
			</div>
			 </form>
		</div>
	  </div>
	</div>

<!-- add family member -->
	<div class="modal fade" id="add-family-member" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="lineModalLabel">Add Family Member</h3>
			</div>
			<div class="modal-body">
				
	            <!-- content goes here -->
				<form action="/admin/application/save-family-member/{{$application->id}}" method="POST">
	             <div class="form-group">
				    <h3><i class="glyphicon glyphicon-user"></i>Family Info</h3>
				    <div id="family-wrapper">
				        <div class="family-member">
				            <div class="col-sm-4">
				                <label>First Name</label>
				                <input class="form-control" type="text" name="family_members[0][first_name]" placeholder="First Name" aria-required="true" aria-invalid="true">
				            </div>
				            <div class="col-sm-4">
				                <label>Last Name</label>
				                <input class="form-control" type="text" name="family_members[0][last_name]" placeholder="Last Name" aria-required="true">
				            </div>
				            <div class="col-sm-4">
				                <label>Relation with Applicant</label>
				                <select class="form-control form-control-select" name="family_members[0][relation]" aria-required="true" aria-invalid="true" :value="'Relation'">
				                    <option selected="" disabled="">Relation</option>
				                    <option value="Father">Father</option>
				                    <option value="Mother">Mother</option>
				                    <option value="Brother">Brother</option>
				                    <option value="Sister">Sister</option>
				                    <option value="Spouse">Spouse</option>
				                    <option value="Daughter">Daughter</option>
				                    <option value="Son">Son</option>
				                </select>
				            </div>
				            <div class="clearfix"></div>
				            <div class="col-md-4  dob">
				                <!--  <input class="form-control " type="text" name="date_of_birth" placeholder="Date of Birth" aria-required="true" aria-invalid="true"> -->
				                <label>Date of Birth*</label>
				                <div class="row">
				                    <div class="col-md-4">
				                        <select v-model="family_birthday_day" aria-label="Day" class="form-control" name="family_members[0][dob_day]" id="day" title="Day" aria-controls="js_0" aria-haspopup="true" role="null" aria-describedby="js_2">
				                            <option  selected="" disabled="true">Day</option>
				                            <option value="1">1</option>
				                            <option value="2">2</option>
				                            <option value="3">3</option>
				                            <option value="4">4</option>
				                            <option value="5">5</option>
				                            <option value="6">6</option>
				                            <option value="7">7</option>
				                            <option value="8">8</option>
				                            <option value="9">9</option>
				                            <option value="10">10</option>
				                            <option value="11">11</option>
				                            <option value="12">12</option>
				                            <option value="13">13</option>
				                            <option value="14">14</option>
				                            <option value="15">15</option>
				                            <option value="16">16</option>
				                            <option value="17">17</option>
				                            <option value="18">18</option>
				                            <option value="19">19</option>
				                            <option value="20">20</option>
				                            <option value="21">21</option>
				                            <option value="22">22</option>
				                            <option value="23">23</option>
				                            <option value="24">24</option>
				                            <option value="25">25</option>
				                            <option value="26">26</option>
				                            <option value="27">27</option>
				                            <option value="28">28</option>
				                            <option value="29">29</option>
				                            <option value="30">30</option>
				                            <option value="31">31</option>
				                        </select>
				                    </div>
				                    <div class="col-md-4">
				                        <select v-model="family_birthday_month" aria-label="Month" class="form-control" name="family_members[0][dob_month]" id="month" title="Month">
				                            <option selected="" disabled="">Month</option>
				                            <option value="1">Jan</option>
				                            <option value="2">Feb</option>
				                            <option value="3">Mar</option>
				                            <option value="4">Apr</option>
				                            <option value="5">May</option>
				                            <option value="6">Jun</option>
				                            <option value="7">Jul</option>
				                            <option value="8">Aug</option>
				                            <option value="9">Sept</option>
				                            <option value="10">Oct</option>
				                            <option value="11">Nov</option>
				                            <option value="12">Dec</option>
				                        </select>
				                    </div>
				                    <div class="col-md-4">
				                        <select v-model="family_birthday_year" aria-label="Year" class="form-control" name="family_members[0][dob_year]" id="year" title="Year">
				                            <option  selected="" disabled="">Year</option>
				                            <option value="2016">2016</option>
				                            <option value="2015">2015</option>
				                            <option value="2014">2014</option>
				                            <option value="2013">2013</option>
				                            <option value="2012">2012</option>
				                            <option value="2011">2011</option>
				                            <option value="2010">2010</option>
				                            <option value="2009">2009</option>
				                            <option value="2008">2008</option>
				                            <option value="2007">2007</option>
				                            <option value="2006">2006</option>
				                            <option value="2005">2005</option>
				                            <option value="2004">2004</option>
				                            <option value="2003">2003</option>
				                            <option value="2002">2002</option>
				                            <option value="2001">2001</option>
				                            <option value="2000">2000</option>
				                            <option value="1999">1999</option>
				                            <option value="1998">1998</option>
				                            <option value="1997">1997</option>
				                            <option value="1996">1996</option>
				                            <option value="1995">1995</option>
				                            <option value="1994">1994</option>
				                            <option value="1993">1993</option>
				                            <option value="1992">1992</option>
				                            <option value="1991">1991</option>
				                            <option value="1990">1990</option>
				                            <option value="1989">1989</option>
				                            <option value="1988">1988</option>
				                            <option value="1987">1987</option>
				                            <option value="1986">1986</option>
				                            <option value="1985">1985</option>
				                            <option value="1984">1984</option>
				                            <option value="1983">1983</option>
				                            <option value="1982">1982</option>
				                            <option value="1981">1981</option>
				                            <option value="1980">1980</option>
				                            <option value="1979">1979</option>
				                            <option value="1978">1978</option>
				                            <option value="1977">1977</option>
				                            <option value="1976">1976</option>
				                            <option value="1975">1975</option>
				                            <option value="1974">1974</option>
				                            <option value="1973">1973</option>
				                            <option value="1972">1972</option>
				                            <option value="1971">1971</option>
				                            <option value="1970">1970</option>
				                            <option value="1969">1969</option>
				                            <option value="1968">1968</option>
				                            <option value="1967">1967</option>
				                            <option value="1966">1966</option>
				                            <option value="1965">1965</option>
				                            <option value="1964">1964</option>
				                            <option value="1963">1963</option>
				                            <option value="1962">1962</option>
				                            <option value="1961">1961</option>
				                            <option value="1960">1960</option>
				                            <option value="1959">1959</option>
				                            <option value="1958">1958</option>
				                            <option value="1957">1957</option>
				                            <option value="1956">1956</option>
				                            <option value="1955">1955</option>
				                            <option value="1954">1954</option>
				                            <option value="1953">1953</option>
				                            <option value="1952">1952</option>
				                            <option value="1951">1951</option>
				                            <option value="1950">1950</option>
				                            <option value="1949">1949</option>
				                            <option value="1948">1948</option>
				                            <option value="1947">1947</option>
				                            <option value="1946">1946</option>
				                            <option value="1945">1945</option>
				                            <option value="1944">1944</option>
				                            <option value="1943">1943</option>
				                            <option value="1942">1942</option>
				                            <option value="1941">1941</option>
				                            <option value="1940">1940</option>
				                            <option value="1939">1939</option>
				                            <option value="1938">1938</option>
				                            <option value="1937">1937</option>
				                            <option value="1936">1936</option>
				                            <option value="1935">1935</option>
				                            <option value="1934">1934</option>
				                            <option value="1933">1933</option>
				                            <option value="1932">1932</option>
				                            <option value="1931">1931</option>
				                            <option value="1930">1930</option>
				                            <option value="1929">1929</option>
				                            <option value="1928">1928</option>
				                            <option value="1927">1927</option>
				                            <option value="1926">1926</option>
				                            <option value="1925">1925</option>
				                            <option value="1924">1924</option>
				                            <option value="1923">1923</option>
				                            <option value="1922">1922</option>
				                            <option value="1921">1921</option>
				                            <option value="1920">1920</option>
				                            <option value="1919">1919</option>
				                            <option value="1918">1918</option>
				                            <option value="1917">1917</option>
				                            <option value="1916">1916</option>
				                            <option value="1915">1915</option>
				                            <option value="1914">1914</option>
				                            <option value="1913">1913</option>
				                            <option value="1912">1912</option>
				                            <option value="1911">1911</option>
				                            <option value="1910">1910</option>
				                            <option value="1909">1909</option>
				                            <option value="1908">1908</option>
				                            <option value="1907">1907</option>
				                            <option value="1906">1906</option>
				                            <option value="1905">1905</option>
				                        </select>
				                    </div>
				                </div>
				            </div>
				            <div class="col-md-4">
				                <label>Gender*</label>
				                <select class="form-control" name="family_members[0][gender]" aria-required="true" >
				                    <option selected="" disabled="">Select Gender</option>
				                    <option value="Male">Male</option>
				                    <option value="Female">Female</option>
				                </select>
				            </div>
				            <div class="clearfix"></div>
				        </div>
				    </div>
				    <div class="clearfix"></div>
				    <div class="add-family col-md-12 text-center">
				    	<br>
				    	<button type="submit" class="btn btn-default">Submit</button>
	              	</div>
				 </div>
				
	               
	            </form>

			</div>
			<div class="modal-footer">
				<div class="btn-group btn-group-justified" role="group" aria-label="group button">
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
					</div>
					<!-- <div class="btn-group btn-delete hidden" role="group">
						<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
					</div>
					<div class="btn-group" role="group">
						<button type="button" id="saveImage" class="btn btn-default btn-hover-green" data-action="save" role="button">Save</button>
					</div> -->
				</div>
			</div>
		</div>
	  </div>
	</div>

<!-- add repayment cheque -->
<div class="modal fade" id="add-repayment-cheque" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="lineModalLabel">Add Repayment Cheque</h3>
			</div>
			<div class="modal-body">
				<form name="repaymentForm" action="/admin/application/save-repayment-cheque/{{$application->id}}" method="POST" onsubmit="return validate()">
					<div class="form-group">
						<h3><i class="glyphicon glyphicon-user"></i> Repayment Cheque Info</h3>
						<div class="col-sm-4">
						<input type="hidden" name="_token" value="{{csrf_token()}}" />
						<label>Borrower Name*</label>
						<input class="form-control" type="text" name="borrower_name" value="{{$application->borrower?$application->borrower->first_name.' '.$application->borrower->last_name:''}}" placeholder="Borrower Name" aria-required="true" aria-invalid="true" required="true">
						</div>
						<div class="col-md-4">
						<label>Cheque Type*</label>
						<select v-model="type" aria-label="Type" class="form-control" name="type" id="type" title="Cheque Date">
						<option value="ach" selected>ACH</option>
						<option value="pdc">PDC</option>
						<option value="spdc">SPDC</option>
						</select>
						</div>
						<div class="col-md-4">
						<label>Cheque Date</label>
						<input type="date" id="start-date" name="cheque_date" class="form-control datepicker-autoclose"  data-date-format="mm/dd/yyyy" placeholder="Cheque Date">
						</div>
						<div class="col-md-4">
						<label>Cheque Number*</label>
						<input class="form-control" type="text" name="cheque_number" placeholder="Cheque Number" aria-required="true" aria-invalid="true" required="true">
						</div>
						<div class="col-md-4">
						<label>Amount</label>
						<input class="form-control" type="text" name="amount" placeholder="Amount" aria-required="true" aria-invalid="true">
						</div>
						<div class="col-md-4">
						<label>Bank Name*</label>
						<input class="form-control" type="text" name="bank_name" placeholder="Bank Name" aria-required="true" aria-invalid="true" required="true">
						</div>
						<div class="col-md-4">
						<label>Branch*</label>
						<input class="form-control" type="text" name="branch" placeholder="Branch Name" aria-required="true" aria-invalid="true" required="true">
						</div>

						<div class="col-md-4">
						<label>No. of Cheque Leaves (If in Series)</label>
						<input class="form-control" type="number" name="series" placeholder="No. in digits" aria-required="true" aria-invalid="true" min="1" max="36">
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
<!-- add repayment cheque -->

	<div id="comment" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <form action="/admin/application/send-to-dmi/{{$application->id}}" method="GET">
	            {{csrf_field()}}
	            <!-- Modal content-->
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title">Send this application to DMI</h4>
	                </div>                    
	                <div class="modal-footer">
	                    <button type="submit" class="btn btn-danger">Yes</button>
	                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
	<div id="convertToLead" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <form action="/admin/application/convert-to-lead/{{$application->id}}" method="GET">
	            {{csrf_field()}}
	            <!-- Modal content-->
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title">Convert {{$application->pin_number}} Lead</h4>
	                </div>                    
	                <div class="modal-footer">
	                    <button type="submit" class="btn btn-danger">Yes</button>
	                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>


<!-- add nominee -->
	<div id="add-nominee" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content modal-lg">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add  Nominee</h4>
	      </div>
	      <div class="modal-body">
	        <form role="form" action="/admin/application/nominee" method="POST">
	          <input type="hidden" name="application_id" value="{{$application->id}}">
	          <div class="box-body">
	              <div class="col-md-4">
	                <label>Select Nominee Type*</label>
	                <select aria-label="Day" class="form-control" name="type" id="day" title="Day" aria-controls="js_0" aria-haspopup="true" role="null" aria-describedby="js_2">
	                  <option value="co-borrower">Co-Borrower</option>
	                  <option value="guarantor">Guarantor</option>
	                </select>
	              </div>
	              <div class="clearfix"></div>
	              @include('website.pages.application.partials.borrower_details')
	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            <button type="submit" class="btn btn-default" >Submit</button>
	          </div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
<!-- add nominee -->

<!-- close application -->
<div class="modal fade" id="close-application" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3><i class="fa fa-check-circle-o "></i> Close Application</h3>
			</div>
			<div class="modal-body">
				<form action="/admin/application/close-application/{{$application->id}}" method="get">
					<div class="row">
						<div class="col-md-12">
							<h4>Do you really want to close this Application PIN- <b>{{$application->pin_number}}</b></h4>
						</div>		
							<div class="col-md-5">
								<div class="form-group">
									<label>Select Closer Reason</label>
									<select class="form-control" name="closer_reason_id" aria-required="true" aria-invalid="true">
								        <option selected disabled>Select Closer Reason</option>
								        <!-- <option value="pre_mature">Pre Mature</option>
								        <option value="mature">Mature</option>
								        <option value="waived_off">Waived Off</option> -->
								        @foreach($closer_reasons as $closer)
                                        <option value="{{$closer->id}}">{{$closer->name}}</option>
                                        @endforeach
								    </select>
								</div>    
							</div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label>Closer Date</label>                                    
                                        <input type='date' class="form-control" name="closer_date" 
                                        @if($application->getOriginal('closer_date')=="0000-00-00")
                                        value="{{Carbon\Carbon::now()->format('d-m-Y')}}"

                                        @else
                                        value="{{Carbon\Carbon::parse($application->getOriginal('closer_date'))->format('d-m-Y')}}"
                                        @endif
                                        />
                                </div>
                            </div>
							<div class="col-md-12">
	                            <div class="form-group">
	                                <label>Closer Note</label>
	                                <textarea name="closer_note" class="form-control"></textarea>
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
<!-- close application -->

<!-- disburse application -->
<div class="modal fade" id="disburse-application" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">X</span><span class="sr-only">Close</span></button>
				<h3><i class="fa fa-check-circle-o "></i> Disburse Application</h3>
			</div>
			<div class="modal-body">
				<form action="/admin/application/update/status/disbursed/{{$application->id}}" method="get">
					<div class="row">
						<div class="col-md-12">
							<h4>Are you sure you want to disburse the Application PIN- <b>{{$application->pin_number}} ?</b></h4>
						</div>	
						<div class="col-md-12">
                            <div class="form-group">
                                <label>Disbursement Detail</label>
                                <div class="row">
                                	<div class="col-md-6">
										<label for="advance_emi_deduct">
											<input class="icheckbox_flat-blue" type="checkbox" id="advance_emi_deduct" name="advance_emi_deduct" checked> Advance EMI Amount
										</label>
									</div>
                                </div>
                                <div class="row">
                                	<div class="col-md-6">
										<label for="subvention_deduct">
											<input class="icheckbox_flat-blue" type="checkbox" id="subvention_deduct" name="subvention_deduct" checked> Subvention Amount
										</label>
									</div>
                                </div>
                                <div class="row">
                                	<div class="col-md-8">
										<label for="document_processing_fee_deduct">
											<input class="icheckbox_flat-blue" type="checkbox" id="document_processing_fee_deduct" name="document_processing_fee_deduct"> Documentation / Processing Fees Amount
										</label>
									</div>
                                </div>                                
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
<!-- close application -->

<!-- revert application -->
<div class="modal fade" id="revertStage" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Revert Stage</span></button>
				<h3><i class="fa fa-check-circle-o "></i> Revert Application</h3>
			</div>
			<div class="modal-body">
				<form action="/admin/application/revert-stage/{{$application->id}}" method="get">
					<div class="row">
						<div class="col-md-12">
							<h4>Do you really want to revert this Application PIN- <b>{{$application->pin_number}} </b></h4>
						</div>		
							<div class="col-md-5">
								<div class="form-group">
									<label>Select Revert Stage</label>
									<select class="form-control" name="status" aria-required="true" aria-invalid="true" required>
								        @foreach($revert_stages as $rever_stage)
                                        <option value="{{$rever_stage}}">{{$rever_stage}}</option>
                                        @endforeach
								    </select>
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
<!-- revert application -->
</div>

<script type="text/javascript">
    function validate(){
        x=document.myForm
        txt=x.repaymentForm.value
        if (txt>=1 && txt<=36) {
            return true
        }else{
            alert("Must be between 1 and 36")
            return false
        }
}
</script>