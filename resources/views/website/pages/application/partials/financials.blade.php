<div class="form-group">
    <h3> <i class="fa fa-inr"></i> {{trans('financial_detail/financial_detail.title')}}</h3>
    <div class="col-md-4">
        <label>{{trans('financial_detail/financial_detail.no_of_dependants')}}</label>
        <input class="form-control" type="text" name="number_of_dependants" placeholder="{{trans('financial_detail/financial_detail.no_of_dependants')}}">
    </div>
    <div class="col-md-4">
        <label>{{trans('financial_detail/financial_detail.loan_required')}}</label>
        <input class="form-control" value="{{ ( ! empty($lead) ? $lead->requested_loan_amount : '') }}" type="text" name="loan_required" placeholder="{{trans('financial_detail/financial_detail.loan_required')}}" aria-required="true" aria-invalid="true">
    </div>
    <div class="col-md-4">
        <label>{{trans('financial_detail/financial_detail.emi_payable')}}</label>
        <input class="form-control" type="text" name="requested_emi" placeholder="{{trans('financial_detail/financial_detail.emi_payable')}}">
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4">
        <label>{{trans('financial_detail/financial_detail.requested_tenure')}} *</label>
        <select name="requested_tenure" class="form-control" v-model="requested_tenure">
            <option selected="" disabled="">{{trans('financial_detail/financial_detail.select_requested_tenure')}}</option>
            <option value="6">{{trans('financial_detail/financial_detail.tenure_options.1')}}</option>
            <option value="12">{{trans('financial_detail/financial_detail.tenure_options.2')}}</option>
            <option value="18">{{trans('financial_detail/financial_detail.tenure_options.3')}}</option>
            <option value="24">{{trans('financial_detail/financial_detail.tenure_options.4')}}</option>
            <option value="36">{{trans('financial_detail/financial_detail.tenure_options.5')}}</option>
        </select>
    </div>
</div>
