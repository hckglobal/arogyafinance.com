<div class="form-group">
<!--     <h3> &#8377; Declaration</h3>
 -->    <div class="col-md-12">
        <label class="input-label-space" for="small-hatchback">{{trans('personal_detail/patient_detail.ask_arogya_card') }}</label>
        <button class="btn-primary btn" type="button" onclick='window.location.assign("/login?next=user/apply-for-loan")'>{{ trans('personal_detail/patient_detail.yes') }}</button> 

        <button class="btn btn-primary btn-red no" type="button">{{trans('personal_detail/patient_detail.no') }}</button>
    
    </div>
</div>

<div class="form-group">
    <h3><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;{{trans('personal_detail/patient_detail.patient_info') }}</h3>
   <!--  <div class="col-sm-4">
             <input onclick='window.location.assign("/login?next=user/apply-for-loan")' value="Small hatch back" type="checkbox" id="small-hatchback">
             <label for="small-hatchback">Do you have an Arogya Card ?</label>
    </div> -->
    <div class="col-sm-4">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <label>{{trans('personal_detail/patient_detail.fname')}} *</label>
        <input class="form-control" type="text" name="patient_first_name" id="patient_first_name" value="{{ ( ! empty($lead) ? $lead->first_name : '') }}" placeholder="{{trans('personal_detail/patient_detail.fname')}}" aria-required="true" aria-invalid="true">
    </div>
    <div class="col-sm-4">
        <label>{{trans('personal_detail/patient_detail.mname')}}</label>
        <input class="form-control" type="text" name="patient_middle_name" id="patient_middle_name" placeholder="{{trans('personal_detail/patient_detail.mname')}}" aria-required="true">
    </div>
    <div class="col-sm-4">
        <label>{{trans('personal_detail/patient_detail.lname')}} *</label>
        <input class="form-control" type="text" name="patient_last_name" id="patient_last_name" 
        value="{{ ( ! empty($lead) ? $lead->last_name : '') }}" placeholder="{{trans('personal_detail/patient_detail.lname')}}" aria-required="true">
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4  dob">
        <label>{{trans('personal_detail/patient_detail.dob')}} *</label>
        <div class="row">
            <div class="col-md-4">
                <select aria-label="Day" class="form-control patient_birthday_day" name="patient_birthday_day" id="day" title="Day" aria-controls="js_0" aria-haspopup="true" role="null" aria-describedby="js_2" v-model='patient_birthday_day'>
                    <option  selected="" disabled="">{{trans('personal_detail/patient_detail.day')}}</option>
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
                <select aria-label="Month" class="form-control patient_birthday_month" name="patient_birthday_month" id="month" title="Month" v-model='patient_birthday_month'>
                    <option  selected="" disabled="">{{trans('personal_detail/patient_detail.month')}}</option>
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
                <select aria-label="Year" class="form-control patient_birthday_year" name="patient_birthday_year" id="year" title="Year" v-model='patient_birthday_year'>
                    <option selected="" disabled="">{{trans('personal_detail/patient_detail.year')}}</option>
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
        <label>{{trans('personal_detail/patient_detail.gender')}} *</label>
        <select class="form-control" name="patient_gender" id="patient_gender" aria-required="true" aria-invalid="true" v-model="patient_gender">
            <option selected="" disabled="">{{trans('personal_detail/patient_detail.select_gender')}}</option>
            <option value="Male">{{trans('personal_detail/patient_detail.gender_options.male')}}</option>
            <option value="Female">{{trans('personal_detail/patient_detail.gender_options.female')}}</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.mobile_no')}} *</label>
        <input class="form-control" type="text" name="patient_mobile_number" id="patient_mobile_number" 
        value="{{ ( ! empty($lead) ? $lead->mobile_number : '') }}"
        placeholder="{{trans('personal_detail/patient_detail.mobile_no')}}" aria-required="true" aria-invalid="true" >
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.address_line')}} *</label>
        <input class="form-control" type="text" name="patient_address_line_1" id="patient_address_line_1" placeholder="{{trans('personal_detail/patient_detail.address_line')}}" aria-required="true" aria-invalid="true">
    </div>
    
    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.state')}} *</label>
        <select class="form-control" name="patient_state" id="patient_state" aria-required="true" aria-invalid="true">
            <option disabled="" selected="">{{trans('personal_detail/patient_detail.select_state')}}</option>
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
        <label>{{trans('personal_detail/patient_detail.city')}} *</label>
        <input class="form-control" type="text" name="patient_city" id="patient_city" placeholder="{{trans('personal_detail/patient_detail.city')}}" aria-required="true" aria-invalid="true">
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.pin_code')}} *</label>
        <input class="form-control" type="text" name="patient_pincode" id="patient_pincode" placeholder="{{trans('personal_detail/patient_detail.pin_code')}}" aria-required="true" aria-invalid="true">
    </div>

    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.treatment_type')}} *</label>
        <select class="form-control" name="treatment_type">
            <option selected="" disabled="">{{trans('personal_detail/patient_detail.select_treatment_type')}}</option>
            @foreach($treatment_type as $name)
            <option value="{{$name}}">{{$name}}</option>
            @endforeach
        </select>

    </div>
    
    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.hospital_name')}} *</label>
        <!-- <input type="text" value="{{ ( ! empty($lead) ? $lead->hospital_name : '') }}" name="hospital_name" class="form-control hospital_name" placeholder= "{{trans('personal_detail/patient_detail.hospital_name')}}" area-required="true"> -->
        <select name="hospital_name" class="form-control select2" 
            data-placeholder="">
           <option selected disabled>Select Hospital</option>
           @foreach($hospitals as $hospital)
            @if($hospital->isRoot())
            
                @if($hospital->getDescendants()->count())
                    <optgroup label="{{$hospital->name}}">
                        @foreach($hospital->getDescendants() as $descendant)
                        <option value="{{$descendant->name}}">
                            {{$descendant->name}}
                        </option>
                        @endforeach
                    </optgroup> 
                @else
                    <option value="{{$hospital->name}}">
                        {{$hospital->name}}
                    </option>
                @endif
               
            @endif
            @endforeach
        </select>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-4">
        <label>{{trans('personal_detail/patient_detail.estimated_cost')}} *</label>
        <input class="form-control" type="text" name="estimated_cost" placeholder="{{trans('personal_detail/patient_detail.estimated_cost')}}" aria-required="true" aria-invalid="true">
    </div>

</div>
<div class="form-group">
    <h3><i class="glyphicon glyphicon-user"></i> {{trans('personal_detail/patient_detail.relation')}}</h3>
    <div class="col-md-4">       
       <input  name="self_patient" type="checkbox" value="1" id="self_patient">
       <label for="self_patient">{{trans('personal_detail/patient_detail.self_patient')}}</label>
    </div>
    <div class="col-md-4">       
       <input  name="same_address" type="checkbox" id="same_address">
       <label for="same_address">{{trans('personal_detail/patient_detail.copy_address')}}</label>
    </div>
    <div class="col-md-4">
    <label for="relation_with_patient" id="relation_with_patient_label">{{trans('personal_detail/patient_detail.borrower_relation')}}</label>       
       <select class="form-control form-control-select" id="relation_with_patient" name="relation_with_patient" 
            aria-required="true" aria-invalid="true">
            <option selected="" disabled="">{{trans('personal_detail/patient_detail.select_relation')}}</option>
            <option value="Father">{{trans('personal_detail/patient_detail.father')}}</option>
            <option value="Mother">{{trans('personal_detail/patient_detail.mother')}}</option>
            <option value="Brother">{{trans('personal_detail/patient_detail.brother')}}</option>
            <option value="Sister">{{trans('personal_detail/patient_detail.sister')}}</option>
            <option value="Spouse">{{trans('personal_detail/patient_detail.spouse')}}</option>
            <option value="Daughter">{{trans('personal_detail/patient_detail.daughter')}}</option>
            <option value="Son">{{trans('personal_detail/patient_detail.son')}}</option>
            <option value="Brother in law">{{trans('personal_detail/patient_detail.brother_in_law')}}</option>
            <option value="Sister in law">{{trans('personal_detail/patient_detail.sister_in_law')}}</option>
            <option value="Mother in law">{{trans('personal_detail/patient_detail.mother_in_law')}}</option>
            <option value="Father in law">{{trans('personal_detail/patient_detail.father_in_law')}}</option>
            <option value="Son in law">{{trans('personal_detail/patient_detail.son_in_law')}}</option>
            <option value="Daughter in law">{{trans('personal_detail/patient_detail.daughter_in_law')}}</option>
            <option value="Self">{{trans('personal_detail/patient_detail.self')}}</option>
            <option value="Others">{{trans('personal_detail/patient_detail.others')}}</option>
        </select>       
    </div>
</div>
