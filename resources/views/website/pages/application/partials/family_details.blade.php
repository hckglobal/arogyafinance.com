<div class="form-group">
    <h3><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;{{trans('personal_detail/family_detail.family_info')}}</h3>
    <div id="family-wrapper">
        <div class="family-member">
            <div class="col-sm-4">
                <label>{{trans('personal_detail/family_detail.fname')}} *</label>
                <input class="form-control" type="text" name="family_members[0][first_name]" placeholder="{{trans('personal_detail/family_detail.fname')}}" aria-required="true" aria-invalid="true">
            </div>
            <div class="col-sm-4">
                <label>{{trans('personal_detail/family_detail.lname')}} *</label>
                <input class="form-control" type="text" name="family_members[0][last_name]" placeholder="{{trans('personal_detail/family_detail.lname')}}" aria-required="true">
            </div>
            <div class="col-sm-4">
                <label>{{trans('personal_detail/family_detail.relation_with_applicant')}} *</label>
                <select class="form-control form-control-select" name="family_members[0][relation]" aria-required="true" aria-invalid="true" :value="'Relation'">
                    <option selected="" disabled="">{{trans('personal_detail/family_detail.select_relation')}}</option>
                    <option value="Father">{{trans('personal_detail/family_detail.father')}}</option>
                    <option value="Mother">{{trans('personal_detail/family_detail.mother')}}</option>
                    <option value="Brother">{{trans('personal_detail/family_detail.brother')}}</option>
                    <option value="Sister">{{trans('personal_detail/family_detail.sister')}}</option>
                    <option value="Spouse">{{trans('personal_detail/family_detail.spouse')}}</option>
                    <option value="Daughter">{{trans('personal_detail/family_detail.daughter')}}</option>
                    <option value="Son">{{trans('personal_detail/family_detail.son')}}</option>
                    <option value="Brother in law">{{trans('personal_detail/family_detail.brother_in_law')}}</option>
                    <option value="Sister in law">{{trans('personal_detail/family_detail.sister_in_law')}}</option>
                    <option value="Mother in law">{{trans('personal_detail/family_detail.mother_in_law')}}</option>
                    <option value="Father in law">{{trans('personal_detail/family_detail.father_in_law')}}</option>
                    <option value="Son in law">{{trans('personal_detail/family_detail.son_in_law')}}</option>
                    <option value="Daughter in law">{{trans('personal_detail/family_detail.daughter_in_law')}}</option>
                    <option value="Self">{{trans('personal_detail/family_detail.self')}}</option>
                    <option value="Others">{{trans('personal_detail/family_detail.others')}}</option>
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4  dob">
                <label>{{trans('personal_detail/family_detail.dob')}} *</label>
                <div class="row">
                    <div class="col-md-4">
                        <select v-model="family_birthday_day" aria-label="Day" class="form-control" name="family_members[0][dob_day]" id="day" title="Day" aria-controls="js_0" aria-haspopup="true" role="null" aria-describedby="js_2">
                            <option  selected="" disabled="true">{{trans('personal_detail/family_detail.day')}}</option>
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
                            <option selected="" disabled="">{{trans('personal_detail/family_detail.month')}}</option>
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
                            <option  selected="" disabled="">{{trans('personal_detail/family_detail.year')}}</option>
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
                <label>{{trans('personal_detail/family_detail.gender')}} *</label>
                <select class="form-control" name="family_members[0][gender]" aria-required="true" >
                    <option selected="" disabled="">{{trans('personal_detail/family_detail.select_gender')}}</option>
                    <option value="Male">{{trans('personal_detail/family_detail.gender_options.male')}}</option>
                    <option value="Female">{{trans('personal_detail/family_detail.gender_options.female')}}</option>
                </select>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="add-family col-md-12 text-center">
        <button type="button" class="btn btn-primary" id="add-family"><i class="fa fa-plus" style="color:#7DBA2F"></i> {{trans('personal_detail/family_detail.add_family_member')}}</button>
    </div>
</div>