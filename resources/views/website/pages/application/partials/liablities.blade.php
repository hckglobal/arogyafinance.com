<div class="form-group">
  <h3><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;{{trans('financial_detail/liablities_detail.title')}} </h3>
    <div class="col-md-4">
    <span class="title">{{trans('financial_detail/liablities_detail.ask_existing_loan')}}</span>&nbsp;
    <span>
    <input class="toggle-field" data-toggle-target="#loan_amount" value="yes" type="radio"  name="q1" id="existing-loan-yes">
    <label for="existing-loan-yes">{{trans('financial_detail/liablities_detail.yes')}}</label>
    </span>
    <span>
    <input class="toggle-field" data-toggle-target="#loan_amount" value="no" type="radio"  name="q1"id="existing-loan-no">
    <label for="existing-loan-no">{{trans('financial_detail/liablities_detail.no')}}</label>
    </span>
    <input class="form-control toggle-target" id="loan_amount" type="text" name="current_loan_emi" placeholder="{{trans('financial_detail/liablities_detail.loan_emi')}}">
    </div>
  <div class="col-md-4">
    <span class="title">{{trans('financial_detail/liablities_detail.ask_education_expenses')}}</span>&nbsp;
    <span>
    <input class="toggle-field" data-toggle-target="#education-expenses" value="yes" type="radio" name="q2"  id="education-expenses-yes">
    <label for="education-expenses-yes">{{trans('financial_detail/liablities_detail.yes')}}</label>
    </span>
    <span>
    <input class="toggle-field" data-toggle-target="#education-expenses" value="no" type="radio" name="q2" id="education-expenses-no">
    <label for="education-expenses-no">{{trans('financial_detail/liablities_detail.no')}}</label>
    </span>
    <input class="form-control toggle-target" type="text" id="education-expenses" name="education_expenses" placeholder="{{trans('financial_detail/liablities_detail.education_expenses')}}">
    </div>
  <div class="col-md-4">
    <span class="title">{{trans('financial_detail/liablities_detail.ask_rent_expenses')}}</span> &nbsp;
    <span>
    <input class="toggle-field" data-toggle-target="#house-rent" value="yes" type="radio"  name="q3"  id="house-rent-yes">
    <label for="house-rent-yes">{{trans('financial_detail/liablities_detail.yes')}}</label>
    </span>
    <span>
    <input class="toggle-field" data-toggle-target="#house-rent" value="no" type="radio"  name="q3" id="house-rent-no">
    <label for="house-rent-no">{{trans('financial_detail/liablities_detail.no')}}</label>
    </span>
    <input class="form-control toggle-target" type="text" id="house-rent" name="house_rent" placeholder="{{trans('financial_detail/liablities_detail.monthly_rent_expense')}}">
    </div>
  <div class="clearfix"></div>
</div>