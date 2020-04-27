<div class="form-group">
    <h3><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;
      {{trans('financial_detail/other_earnings_detail.title')}}</h3>
    <div class="col-md-12">
        <span class="title">{{trans('financial_detail/other_earnings_detail.ask_other_earnings')}}</span>
        <span>
          <input class="toggle-field" data-toggle-target=".other_earnings" value="yes" type="radio" name="q4"  id="other-earnings-yes">
          <label for="other-earnings-yes">{{trans('financial_detail/other_earnings_detail.yes')}}</label>
        </span>
        <span>
         <input class="toggle-field" data-toggle-target=".other_earnings" value="no" type="radio" name="q4" id="other-earnings-no">
         <label for="other-earnings-no">{{trans('financial_detail/other_earnings_detail.no')}}</label>
       </span>
    </div>
    <div class="col-md-4 other_earnings toggle-target">
        <select class="form-control" name="other_earnings_type">
            <option selected="" disabled="">{{trans('financial_detail/other_earnings_detail.nature_of_other_earnings')}}</option>
            <option value="Rent">{{trans('financial_detail/other_earnings_detail.nature_of_other_earning_options.1')}}</option>
            <option value="Pension">{{trans('financial_detail/other_earnings_detail.nature_of_other_earning_options.2')}}</option>
            <option value="Freelancing">{{trans('financial_detail/other_earnings_detail.nature_of_other_earning_options.3')}}</option>
            <option value="Part time job">{{trans('financial_detail/other_earnings_detail.nature_of_other_earning_options.4')}}</option>
        </select>
    </div>
    <div class="col-md-4 other_earnings toggle-target">
        <input class="form-control" type="text" name="other_earnings" 
          placeholder="{{trans('financial_detail/other_earnings_detail.title')}}">
    </div>
</div>