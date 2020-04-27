<div class="form-group">
    <h3><i class="glyphicon glyphicon-open-file"></i>&nbsp;&nbsp;{{trans('document_detail/document_detail.title')}}</h3>
        <div class="col-md-12">
            <p class="title">{{trans('document_detail/document_detail.note')}}</p>
            @if(isset($application))
            <p>{{trans('document_detail/document_detail.you_have')}} {{$application->remainingDocumentsCount()}} {{trans('document_detail/document_detail.documents_remaining')}}</p>
            @endif
        </div>
        
        @if( !$application->hasDocument('id-proof')  )
            <div class="col-md-6">
                <select class="form-control form-control-document" name="documents[0][name]">
                    <option selected="" disabled="">{{trans('document_detail/document_detail.select_id_proof')}}</option>
                    <option value="PAN Card">{{trans('document_detail/document_detail.id_proof_options.1')}}</option>
                    <option value="Aadhar Card">{{trans('document_detail/document_detail.id_proof_options.2')}}</option>
                    <option value="Permanent Driving License">{{trans('document_detail/document_detail.id_proof_options.3')}}</option>
                    <option value="Photo Credit Card">{{trans('document_detail/document_detail.id_proof_options.4')}}</option>
                    <option value="Passport">{{trans('document_detail/document_detail.id_proof_options.5')}}</option>
                    <option value="Government Employee ID Card">{{trans('document_detail/document_detail.id_proof_options.6')}}</option>
                    <option value="Election Card">{{trans('document_detail/document_detail.id_proof_options.7')}}</option>
                    <option value="Photo Bank Passbook">{{trans('document_detail/document_detail.id_proof_options.8')}}</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="hidden" multiple name="documents[0][type]" value="id-proof">
                <input type="file" multiple name="documents[0][files][]" id="upload1" placeholder="Upload ID Proof">
            </div>
            <div class="clearfix"></div>
        @endif      
    
        @if( !$application->hasDocument('address-proof') )
            <div class="col-md-6">
                <select class="form-control form-control-document" name="documents[1][name]">
                    <option selected="" disabled="">{{trans('document_detail/document_detail.select_address_proof')}}</option>
                    <option value="Ration Card">
                        {{trans('document_detail/document_detail.address_proof_options.1')}}
                    </option>    
                    <option value="Election/Voting Card">
                        {{trans('document_detail/document_detail.address_proof_options.2')}}
                    </option>    
                    <option value="Electricity Bill">
                        {{trans('document_detail/document_detail.address_proof_options.3')}}
                    </option>    
                    <option value="Water Bill">
                        {{trans('document_detail/document_detail.address_proof_options.4')}}
                    </option>    
                    <option value="Postpaid landline phone Bill">
                        {{trans('document_detail/document_detail.address_proof_options.5')}}
                    </option>    
                    <option value="Passport">
                        {{trans('document_detail/document_detail.address_proof_options.6')}}
                    </option>    
                    <option value="Permanent Driving License">
                        {{trans('document_detail/document_detail.address_proof_options.7')}}
                    </option>    
                    <option value="Municipal tax Bill">
                        {{trans('document_detail/document_detail.address_proof_options.8')}}
                    </option>    
                    <option value="Share Certificate of Society">
                        {{trans('document_detail/document_detail.address_proof_options.9')}}
                    </option>    
                    <option value="House Purchase Deed">
                        {{trans('document_detail/document_detail.address_proof_options.10')}}
                    </option>    
                    <option value="Gas Connection (only PSU)">
                        {{trans('document_detail/document_detail.address_proof_options.11')}}
                    </option>    
                    <option value="LIC Policy">
                        {{trans('document_detail/document_detail.address_proof_options.12')}}
                    </option>    
                    <option value="Bank Statement (only of scheduled/commercial banks)">
                        {{trans('document_detail/document_detail.address_proof_options.13')}}
                    </option>
                    <option value="Rent Agreement">
                        <option value="Bank Statement (only of scheduled/commercial banks)">
                        {{trans('document_detail/document_detail.address_proof_options.14')}}
                    </option>
                    </option>
                    <option value="Employer’s certificate on letterhead">
                        <option value="Bank Statement (only of scheduled/commercial banks)">
                        {{trans('document_detail/document_detail.address_proof_options.15')}}
                    </option>
                    </option>
                    <option value="RC Book">
                        <option value="Bank Statement (only of scheduled/commercial banks)">
                        {{trans('document_detail/document_detail.address_proof_options.16')}}
                    </option>
                    </option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="hidden" multiple name="documents[1][type]" value="address-proof">
                <input type="file" name="documents[1][files][]" id="upload2" placeholder="Upload Residence Proof">
            </div>
            <div class="clearfix"></div>
        @endif
        
        @if($application->category()=="Three" || $application->category()=="Four" || $application->category()=="Uncategorized")    
            @if( !$application->hasDocument('residence-ownership-proof') && !(stripos($application->borrower->residence_type, 'owned')===false) )
                <div class="col-md-6">
                    <select class="form-control form-control-document" name="documents[2][name]">
                        <option selected="" disabled="">
                            {{trans('document_detail/document_detail.select_residence_ownership_proof')}}
                        </option>
                        <option value="Purchase deed">
                            {{trans('document_detail/document_detail.residence_ownership_proof_options.1')}}
                        </option>
                        <option value="Share certificates">
                            {{trans('document_detail/document_detail.residence_ownership_proof_options.2')}}
                        </option>
                        <option value="Electricity bill having ownership address">
                            {{trans('document_detail/document_detail.residence_ownership_proof_options.3')}}
                        </option>
                        <option value="Index 2">
                            {{trans('document_detail/document_detail.residence_ownership_proof_options.4')}}
                        </option>
                        <option value="Property tax certificate">
                            {{trans('document_detail/document_detail.residence_ownership_proof_options.5')}}
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="hidden" multiple name="documents[2][type]" value="residence-ownership-proof">
                    <input type="file" multiple name="documents[2][files][]" id="upload1" placeholder="Upload Residence Ownership Proof">
                </div>
                <div class="clearfix"></div>
            @endif
        @endif

        @if($application->category()=="Three" || $application->category()=="Four" || $application->category()=="Uncategorized")
            @if( !$application->hasDocument('income-proof') )
                <div class="col-md-6">
                    <select class="form-control form-control-document" name="documents[3][name]">
                        <option selected="" disabled="">
                            {{trans('document_detail/document_detail.select_income_proof')}}
                        </option>
                        <option disabled="">
                            === {{trans('document_detail/document_detail.if_salaried')}} ===
                        </option>
                            <option value="Salary Slip">
                                {{trans('document_detail/document_detail.salaried_options.1')}}
                            </option>
                            <option value="Form 16">
                                {{trans('document_detail/document_detail.salaried_options.2')}}
                            </option>
                            <option value="Letter from employer stating monthly salary">
                                {{trans('document_detail/document_detail.salaried_options.3')}}
                            </option>
                            <option value="ITR*">
                                {{trans('document_detail/document_detail.salaried_options.4')}}*
                            </option>

                        <option disabled="">
                            === {{trans('document_detail/document_detail.if_self_employeed')}} ===
                        </option>
                            <option value="Latest two years ITR* (Income Tax Returns)">
                                {{trans('document_detail/document_detail.self_employeed_options.1')}}
                            </option>
                            <option value="Balance Sheet for last 2 years">
                                {{trans('document_detail/document_detail.self_employeed_options.2')}}
                            </option>
                            <option value="P&L Statement for last 2 years">
                                {{trans('document_detail/document_detail.self_employeed_options.3')}}
                            </option>
                            <option value="Income Computation Statement (CA attested)">
                                {{trans('document_detail/document_detail.self_employeed_options.4')}}
                            </option>
                            <option value="Bank statement of last 12 months reflecting income (Rs. 10 Lacs in case of service/Rs. 20 Lacs in case of sales)">
                                {{trans('document_detail/document_detail.self_employeed_options.5')}}
                            </option>
                            <option value="Sales Tax/Service Tax Receipt or Register">
                                {{trans('document_detail/document_detail.self_employeed_options.6')}}
                            </option>
                            <option value="" disabled="">
                                {{trans('document_detail/document_detail.self_employeed_options.7')}}
                            </option>

                        <option disabled>
                            === {{trans('document_detail/document_detail.if_agriculture')}} ===
                        </option>
                            <option value="Mandi Receipt">
                                {{trans('document_detail/document_detail.agriculture_options.1')}}
                            </option>
                            <option value="Kisan Passbook">
                                {{trans('document_detail/document_detail.agriculture_options.2')}}
                            </option>
                            <option value="Bank Statement">
                                {{trans('document_detail/document_detail.agriculture_options.3')}}
                            </option>
                            <option value="Kisan Credit Card">
                                {{trans('document_detail/document_detail.agriculture_options.4')}}
                            </option>
                        
                        <option disabled>
                            === {{trans('document_detail/document_detail.if_pension')}} ===
                        </option>                        
                            <option value="Proof of Pension">
                                {{trans('document_detail/document_detail.pension_options.1')}}
                            </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="hidden" multiple name="documents[3][type]" value="income-proof">
                    <input type="file" multiple name="documents[3][files][]" id="upload3" placeholder="Upload Income Proof">
                </div>
                <div class="clearfix"></div>
            @endif
        
            @if( !$application->hasDocument('bank-statement') )
                <div class="col-md-12">
                    <label>{{trans('document_detail/document_detail.upload_bank_statements')}}</label>
                    <input type="hidden" name="documents[4][name]" value="Bank Statement">
                    <input type="hidden" multiple name="documents[4][type]" value="bank-statement">
                    <input multiple style="display: inline;" type="file" name="documents[4][files][]" id="upload4" placeholder="Upload Bank Statement">
                    <div class="clearfix"></div>
                </div>
            @endif
        @endif    

        @if( !$application->hasDocument('photo') )
            <div class="col-md-12">
                <label>{{trans('document_detail/document_detail.upload_photo')}} :</label>
                <input type="hidden" name="documents[5][name]" value="Photo">
                <input type="hidden" multiple name="documents[5][type]" value="photo">
                <input style="display: inline;" type="file" name="documents[5][files][]" id="upload5" placeholder="Upload Photo">
            </div>
        @endif
</div>
