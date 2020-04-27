<div class="form-group">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <h3><i class="glyphicon glyphicon-tags "></i>&nbsp;&nbsp;{{trans('personal_detail/borrwor_detail.borrower_info')}}</h3>
    <div class="col-md-12">
        <p class="title">{{trans('personal_detail/borrwor_detail.note')}}</p>
    </div>
    <div class="to_be_hidden">
        <div class="col-md-4">
            <label>{{trans('personal_detail/borrwor_detail.fname')}} *</label>
            <input class="form-control" type="text" name="borrower_first_name" id="borrower_first_name" value="{{ ( ! empty($lead) ? $lead->first_name : '') }}" placeholder="{{trans('personal_detail/borrwor_detail.fname')}}" aria-required="true" aria-invalid="true">
        </div>
        <div class="col-md-4">
            <label>{{trans('personal_detail/borrwor_detail.mname')}}</label>
            <input class="form-control" type="text" name="borrower_middle_name" id="borrower_middle_name" value="{{ ( ! empty($lead) ? $lead->middle_name : '') }}" placeholder="{{trans('personal_detail/borrwor_detail.mname')}}" aria-required="true" aria-invalid="true">
        </div>
        <div class="col-md-4">
            <label>{{trans('personal_detail/borrwor_detail.lname')}} *</label>
            <input class="form-control" type="text" name="borrower_last_name" id="borrower_last_name" value="{{ ( ! empty($lead) ? $lead->last_name : '') }}" placeholder="{{trans('personal_detail/borrwor_detail.lname')}}" aria-required="true" aria-invalid="true">
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4  dob">
            <!--  <input class="form-control " type="text" name="date_of_birth" placeholder="Date of Birth" aria-required="true" aria-invalid="true"> -->
            <label>{{trans('personal_detail/borrwor_detail.dob')}}*</label>
            <div class="row">
                <div class="col-md-4">
                    <select  aria-label="Day" class="form-control borrower_birthday_day" name="borrower_birthday_day" id="day" title="Day" aria-controls="js_0" aria-haspopup="true" role="null" aria-describedby="js_2">
                        <option  selected="" disabled="true">{{trans('personal_detail/borrwor_detail.day')}}</option>
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
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
                    <select  aria-label="Month" class="form-control borrower_birthday_month" name="borrower_birthday_month" id="month" title="Month">
                        <option selected="" disabled="">{{trans('personal_detail/borrwor_detail.month')}}</option>
                        <option value="01">Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Aug</option>
                        <option value="09">Sept</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select  aria-label="Year" class="form-control borrower_birthday_year" name="borrower_birthday_year" id="year" title="Year">
                        <option  selected="" disabled="">{{trans('personal_detail/borrwor_detail.year')}}</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
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
        <label>{{trans('personal_detail/borrwor_detail.gender')}} *</label>
        <select class="form-control borrower_gender"  name="borrower_gender" id="borrower_gender" aria-required="true" aria-invalid="true">
            <option selected="" disabled="">{{trans('personal_detail/borrwor_detail.select_gender')}}</option>
            <option value="Male">{{trans('personal_detail/borrwor_detail.gender_options.male')}}</option>
            <option value="Female">{{trans('personal_detail/borrwor_detail.gender_options.female')}}</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.mobile_no')}} *</label>
        <input class="form-control" type="text" name="borrower_mobile_number" 
        id="borrower_mobile_number" value="{{ ( ! empty($lead) ? $lead->mobile_number : '') }}" placeholder="{{trans('personal_detail/borrwor_detail.mobile_no')}}" aria-required="true" aria-invalid="true">
    </div>
</div>
    <div class="clearfix"></div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.alternate_no')}}</label>
        <input class="form-control" type="text" name="alternate_number" 
        id="alternate_number" value="{{ ( ! empty($lead) ? $lead->alternate_number : '') }}" 
        placeholder="{{trans('personal_detail/borrwor_detail.alternate_no')}}" aria-required="true" aria-invalid="true">
    </div>
    
    <div class="col-md-4">
    <label>{{trans('personal_detail/borrwor_detail.email')}} *</label>
    <input class="form-control" value="{{ ( ! empty($lead) ? $lead->email : '') }}" type="text" name="email" placeholder="{{trans('personal_detail/borrwor_detail.email')}}" aria-required="true" aria-invalid="true">
    </div>

    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.marital_status')}} *</label>
        <select class="form-control"  name="marital_status" aria-required="true" aria-invalid="true">
            <option selected="" disabled>{{trans('personal_detail/borrwor_detail.select_marital_status')}}</option>
            <option value="Single">{{trans('personal_detail/borrwor_detail.marital_status_options.single')}}</option>
            <option value="Married">
                {{trans('personal_detail/borrwor_detail.marital_status_options.married')}}
            </option>
            <option value="Separated">{{trans('personal_detail/borrwor_detail.marital_status_options.separated')}}</option>
            <option value="Divorced">{{trans('personal_detail/borrwor_detail.marital_status_options.divorced')}}</option>
            <option value="Widowed">{{trans('personal_detail/borrwor_detail.marital_status_options.widowed')}}</option>
        </select>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4">
      <label>{{trans('personal_detail/borrwor_detail.ask_pan_card')}} *</label>&nbsp;
        <span>
            <input class="toggle-pan-card-field has-success" data-toggle-target=".pan-card-number" name="pan_present" id="pan-card-yes" value="yes"  type="radio"/>
            <label for="pan-card-yes">{{trans('personal_detail/borrwor_detail.yes')}}</label>
        </span>
        <span>
            <input class="toggle-pan-card-field" name="pan_present" data-toggle-target=".pan-card-number" id="pan-card-no"  value="no" type="radio"  />
            <label for="pan-card-no">{{trans('personal_detail/borrwor_detail.no')}}</label>
        </span>
        <transition name="fade">
            <input class="form-control pan-card-number"  type="text" id="pan_card_number" name="pan_card_number" placeholder="{{trans('personal_detail/borrwor_detail.id_proof_options.pan_card')}}" aria-required="true"  style="display: none;">
        </transition>
    </div>

<div class="col-md-4">
  <label>{{trans('personal_detail/borrwor_detail.ask_aadhar_card')}} *</label>&nbsp;
  <span>
    <input class="toggle-aadhar-card-field has-success" data-toggle-target=".aadhar-card-number" name="aadhar_present" id="aadhar-card-yes"  value="yes" type="radio" >
    <label for="aadhar-card-yes">{{trans('personal_detail/borrwor_detail.yes')}}</label>
</span>
<span>
    <input class="toggle-aadhar-card-field" data-toggle-target=".aadhar-card-number" name="aadhar_present"  id="aadhar-card-no"  value="no" type="radio" >
    <label for="aadhar-card-no">{{trans('personal_detail/borrwor_detail.no')}}</label>
</span>
<transition name="fade">
    <input class="form-control aadhar-card-number" type="text" name="aadhar_card_number" placeholder="{{trans('personal_detail/borrwor_detail.id_proof_options.aadhar_card')}}" aria-required="true"   id="aadhar_card_number" style="display: none">
</transition>
</div>

<div class="col-md-4">
    <label>{{trans('personal_detail/borrwor_detail.id_proof')}}</label>
    <select class="form-control form-control-select"  name="id_proof_type" id="id_proof_type" aria-required="true" aria-invalid="true">
        <option selected="" disabled="" value="">{{trans('personal_detail/borrwor_detail.select_id_proof')}}</option>
        <option value="Aadhaar Card" class="hidden">{{trans('personal_detail/borrwor_detail.id_proof_options.aadhar_card')}}</option>
        <option value="PAN Card" class="hidden">{{trans('personal_detail/borrwor_detail.id_proof_options.pan_card')}}</option>
        <option value="Driving License">{{trans('personal_detail/borrwor_detail.id_proof_options.driving_license')}}</option>
        <option value="Voter ID">{{trans('personal_detail/borrwor_detail.id_proof_options.voter_id')}}</option>
        <option value="Ration Card">{{trans('personal_detail/borrwor_detail.id_proof_options.ration_card')}}</option>
        <option value="Passport">{{trans('personal_detail/borrwor_detail.id_proof_options.passport')}}</option>

    </select>
</div>
<div class="clearfix"></div>
<div class="col-md-4">
    <label id="idproof">{{trans('personal_detail/borrwor_detail.id_proof_no')}} *</label>
    <input class="form-control" type="text" :readonly="block_id_proof_number"  id="id_proof_number" name="id_proof_number" placeholder="{{trans('personal_detail/borrwor_detail.id_proof_no')}}" aria-required="true" aria-invalid="true">
</div>

<div class="col-md-4">
    <label>{{trans('personal_detail/borrwor_detail.near_arogya_center')}} *</label>
    <select class="form-control" name="location_id" >
        <option selected="" disabled="">{{trans('personal_detail/borrwor_detail.select_location')}}</option>
        @if(!empty($lead))
            <option selected value="{{$lead->location->id}}">{{$lead->location->name}}</option>
        @else
            @foreach($locations as $location)
            <option value="{{$location->id}}">{{$location->name}}</option>
            @endforeach
        @endif
    </select>
</div>


<div class="col-md-4">
    <label>{{trans('personal_detail/borrwor_detail.residence_type')}} *</label>
    <select class="form-control form-control-select" name="residence_type" aria-required="true" aria-invalid="true">
        <option selected="" disabled="">{{trans('personal_detail/borrwor_detail.select_residence_type')}}</option>
        <option value="Parental">{{trans('personal_detail/borrwor_detail.parental')}}</option>
        <optgroup label="{{trans('personal_detail/borrwor_detail.owned')}}">
            <option value="Owned - 1 BHK">1 {{trans('personal_detail/borrwor_detail.bhk')}}</option>
            <option value="Owned - 2 BHK">2 {{trans('personal_detail/borrwor_detail.bhk')}}</option>
            <option value="Owned - 3 BHK">3 {{trans('personal_detail/borrwor_detail.bhk')}}</option>
        </optgroup>
        <optgroup label="{{trans('personal_detail/borrwor_detail.rented')}}">
            <option value="Rented - 1 BHK">1 {{trans('personal_detail/borrwor_detail.bhk')}}</option>
            <option value="Rented - 2 BHK">2 {{trans('personal_detail/borrwor_detail.bhk')}}</option>
            <option value="Rented - 3 BHK">3 {{trans('personal_detail/borrwor_detail.bhk')}}</option>
        </optgroup>
        <option value="Company Provided">{{trans('personal_detail/borrwor_detail.company_provided')}}</option>
    </select>
</div>
<div class="to_be_hidden">
    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.address_line')}} *</label>
        <input class="form-control" type="text" name="address_line_1" id="borrower_address_line_1" placeholder="{{trans('personal_detail/borrwor_detail.address_line')}}" aria-required="true" aria-invalid="true">
    </div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.state')}} *</label>
        <select class="form-control" name="borrower_state" id="borrower_state" aria-required="true" aria-invalid="true">
            <option disabled="" selected="">{{trans('personal_detail/borrwor_detail.select_state')}}</option>
            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
            <option value="Himachal Pradesh">Himachal Pradesh</option>
            <option value="Punjab">Punjab</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Uttaranchal">Uttaranchal</option>
            <option value="Haryana">Haryana</option>
            <option value="Delhi">Delhi</option>
            <option value="Rajasthan">Rajasthan</option>
            <option value="Uttar Pradesh">Uttar Pradesh</option>
            <option value="Bihar">Bihar</option>
            <option value="Sikkim">Sikkim</option>
            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
            <option value="Nagaland">Nagaland</option>
            <option value="Manipur">Manipur</option>
            <option value="Mizoram">Mizoram</option>
            <option value="Tripura">Tripura</option>
            <option value="Meghalaya">Meghalaya</option>
            <option value="Assam">Assam</option>
            <option value="West Bengal">West Bengal</option>
            <option value="Jharkhand">Jharkhand</option>
            <option value="Orissa">Orissa</option>
            <option value="Chhattisgarh">Chhattisgarh</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Daman and Diu">Daman and Diu</option>
            <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Andhra Pradesh">Andhra Pradesh</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Goa">Goa</option>
            <option value="Lakshadweep">Lakshadweep</option>
            <option value="Kerala">Kerala</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Pondicherry">Pondicherry</option>
            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
            <option value="Telangana">Telangana</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.city')}} *</label>
        <input class="form-control" type="text" name="borrower_city" id="borrower_city" placeholder="{{trans('personal_detail/borrwor_detail.city')}}" aria-required="true" aria-invalid="true">
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/borrwor_detail.pin_code')}} *</label>
        <input class="form-control" type="text" name="borrower_pincode" id="borrower_pincode" placeholder="{{trans('personal_detail/borrwor_detail.pin_code')}}" aria-required="true" aria-invalid="true">
    </div>
</div>
<div class="clearfix"></div>

</div>
