 <div class="row invoice-info" style="margin-bottom:10px">
    <div class="col-sm-4 text-center">
        @if($application->hasDocument('photo'))
        <div class="user-avatar">
            <a href="/documents/{{$application->id}}/{{$application->getDocument('photo')->file}}" download>
                <img src="/documents/{{$application->id}}/{{$application->getDocument('photo')->file}}" onerror="this.src='/assets/admin/dist/img/default_image.png'" alt="Download Image" title="Download Image">
            </a>
            
        </div>
        <!-- <div class="col-md-3">
            <a href="/documents/{{$application->id}}/{{$application->getDocument('photo')->file}}" download>
                <button class="btn btn-primary airy"><i class="fa fa-download"></i> Download </button>
            </a>
        </div> -->
        <p><div class="col-md-12">    
            @if(Entrust::can('upload-photo'))<form  action="/admin/application/{{$application->id}}/upload/photo" method="POST" id="application" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="col-md-8">
                    <input type="file" name="new_photo" placeholder="Upload Photo" required>
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary" value="Upload">
                </div>
            </form>
            @endif
        </div></p>
        @else
            @if(Entrust::can('upload-photo'))                                   
            <form  action="/admin/application/{{$application->id}}/upload/photo" method="POST" id="application" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group">
                    <p style="margin-bottom:60px;"></p>
                    <p><label for="exampleInputFile">Choose Photo</label></p>  
                    <p><input style="display: inline;" type="file" name="photo" placeholder="Upload Photo" required></p>
                    <p class="help-block">Please upload a pass-port size photo.</p>
                    <p><button type="submit" class="btn btn-primary">Upload</button></p>
                </div>
            </form>
            @endif                                
        @endif
    </div>
    <div class="col-sm-4 invoice-col capitalize-field">
        <address>
            <br>
            <h3>{{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}</h3>
            <p>{{$application->borrower->address_line_1}},
            @if($application->borrower->address_line_2)
                <br> {{$application->borrower->address_line_2}},
            @endif
            <br> {{$application->borrower->city}},
            <br> {{$application->borrower->state}}
            <br>
            </p>
            <p><i class="fa fa-phone"></i> <b>Mobile : </b><a href="tel:{{$application->borrower->mobile_number}}">{{$application->borrower->mobile_number}}</a><p>
            <p><i class="fa fa-envelope"></i> <b>Email : </b><a class="email-not" href="mailto:{{$application->borrower->email}}">{{$application->borrower->email}}</a></p>
            @if(Entrust::can('update-self-patient'))
                <p>
                    <i class="fa fa-user"></i> <b>Self-Patient : </b>
                    <!-- <a href="#" class="editable-click inline-edit" data-name="self_patient"  data-type="text" 
                        data-pk="{{$application->id}}" data-url="/admin/application/{{$application->id}}/update/self-patient" data-title="Borrower is self-patient ?">
                        @if($application->self_patient)
                        Yes
                        @else
                        No
                        @endif
                    </a> -->
                    <a href="#" class="self_patient editable-click" 
                        data-name="self_patient" 
                        data-type="select" data-pk="{{$application->id}}"
                        data-url="/admin/application/{{$application->id}}/update/self-patient"
                        sourceCache="false" 
                        data-title="Borrower is self-patient ?">
                        @if($application->self_patient)
                        Yes
                        @else
                        No
                        @endif
                    </a>
                </p>
            @endif
            <p>
                <i class="fa fa-info-circle"></i> <b>Mandate status : </b>
                    <span>{{$mandate_status}}</span>
            </p>
            <p>
                <i class="fa fa-info-circle"></i> <b>Mandate UMRN : </b>
                    <span>{{$mandate_umrn?$mandate_umrn:'N/A'}}</span>
            </p>    
        </address>
    </div>
    <!-- /.col -->

    <div class="col-sm-4 invoice-col summary capitalize-field">
        <p>
            <b>Cibil Score: </b>
            @if(Entrust::can('update-cibil-score'))
            <a href="#" class="editable-click inline-edit emphasis" data-name="cibil_score" 
                data-type="text" data-pk="{{$application->id}}" 
                data-url="/admin/application/family-details/edit/{{$application->id}}" 
                data-title="Enter cibil score">{{$application->cibil_score}}
            </a>
            @else
            <span class="emphasis">{{$application->cibil_score}}</span>
            @endif
        </p>
         <p>
            <b>Status: </b>
        <span class="emphasis">
            
            @if($application->status=="sanctioned" && $application->type=="card")
                {{ucfirst('Approved')}}
            @elseif($application->status=="disbursed" && $application->type=="card")
                {{ucfirst('Issued')}}
            @elseif($application->status=="closed" && $application->type=="loan")
                @if($application->ndc_sent)
                    <span style="color: green;">{{ucfirst($application->status)}}</span>
                @else
                    {{ucfirst($application->status)}} 
                @endif    
            @else
                {{ucfirst($application->status)}} 
            @endif
        </span>
            @if($application->status=="closed")
            <p><span style="margin-left: 5px">{{($application->closerReason->name)}}</span> on {{Carbon\Carbon::parse($application->getOriginal('closer_date'))->format('d-m-Y')}}</p>
            @elseif($application->status!="new")
            <b>on {{$status_update_date}} </b>
            @if($application->status=="sanctioned")
            <p><span style="color: red; font-weight: bold;">{{$sanction_expired}}</span></p>
            @endif
            @endif
        </p>

       @if($application->rejection_reason)
        <p> <b>Rejection Reason:</b>
        <span class="vertical-reason">{{$application->rejection_reason}}</span>
        </p>
        @else  

        @endif

        <p>
            <b>Reference Code: </b> <span class="emphasis">{{strtoupper($application->reference_code)}}</span>
        </p>
        @if($application->merchant)
            <p>
                <b>Merchant : </b> <span class="emphasis">{{strtoupper($application->merchant)}}</span>
            </p>
        @endif
        @if(!$application->psychometricTest->isEmpty())
            @if($application->psychometricTest()->where('test_url','!=','')->count()>0)
                <p>
                    <b>Psychometric Test Result</b>:<span class="emphasis">{{$application->psychometricTest()->where('test_url','!=','')->latest()->first()->result}}</span></b>
                </p>
                
                @if(Entrust::can('view-test-result'))
                    @if($application->psychometricTest()->where('test_url','#')->count()>0)
                    <b>Test data not available</b>
                    @else
                    <a href="{{$application->psychometricTest()->where('test_url','!=','')->latest()->first()->test_url}}" class="btn btn-primary no-print">Test Result</a><br>
                    @endif
                @endif
            @endif    
        @endif                
    </div>
    <!-- /.col -->
</div>
