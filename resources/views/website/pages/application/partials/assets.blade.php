<div class="form-group" style="padding-right:20px">
    <h3><i class="glyphicon glyphicon-inbox"></i>&nbsp;&nbsp;{{trans('financial_detail/assets_detail.title')}}</h3>
    <div class="col-md-12">
        <p class="title">{{trans('financial_detail/assets_detail.select_assets')}}</p>
    </div>
    <div class="col-md-4">
        <label>{{trans('financial_detail/assets_detail.four_wheeler')}}</label>
        <ul style="list-style-type: none;">
            <li>
                 <input name="assets[]" value="Small hatch back" type="checkbox" id="small-hatchback">
                 <label for="small-hatchback">{{trans('financial_detail/assets_detail.four_wheeler_options.1')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Sedan" type="checkbox" id="sedan">
                 <label for="sedan">{{trans('financial_detail/assets_detail.four_wheeler_options.2')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Luxury" type="checkbox" id="luxury">
                 <label for="luxury">{{trans('financial_detail/assets_detail.four_wheeler_options.3')}}</label>
            </li>
        </ul>
        <label>{{trans('financial_detail/assets_detail.ac')}}</label>
        <ul style="list-style-type: none;">
            <li>
                 <input name="assets[]" value="Window AC" type="checkbox" id="window-ac">
                 <label for="window-ac">{{trans('financial_detail/assets_detail.ac_options.1')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Split AC" type="checkbox" id="split-ac">
                 <label for="split-ac">{{trans('financial_detail/assets_detail.ac_options.2')}}</label>
            </li>
        </ul>
    </div>
    <div class="col-md-4">
        <label>{{trans('financial_detail/assets_detail.tv')}}</label>
        <ul style="list-style-type: none;">
            <li>
                 <input name="assets[]" value="Color TV" type="checkbox" id="colortv">
                 <label for="colortv">{{trans('financial_detail/assets_detail.tv_options.1')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="LCD" type="checkbox" id="lcd">
                 <label for="lcd">{{trans('financial_detail/assets_detail.tv_options.2')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="LED" type="checkbox" id="led">
                 <label for="led">{{trans('financial_detail/assets_detail.tv_options.3')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Plasma" type="checkbox" id="plasma">
                 <label for="plasma">{{trans('financial_detail/assets_detail.tv_options.4')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Smart TV" type="checkbox" id="smart-tv">
                 <label for="smart-tv">{{trans('financial_detail/assets_detail.tv_options.5')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Less than 32 inch Television" type="radio" id="tv-less-than-32">
                 <label for="tv-less-than-32">{{trans('financial_detail/assets_detail.tv_options.6')}}</label>
            </li>
            <li>
                 <input name="assets[]" value="Greater than 32 inch Television" type="radio" id="tv-greater-than-32">
                 <label for="tv-greater-than-32">{{trans('financial_detail/assets_detail.tv_options.7')}}</label>
            </li>
        </ul>
    </div>
    <div class="col-md-4">
        <label>{{trans('financial_detail/assets_detail.others')}}</label>
        <ul style="list-style-type: none;">
            <li>
                <input name="assets[]" value="Refrigerator" type="checkbox" id="refrigerator">
                <label for="refrigerator">{{trans('financial_detail/assets_detail.other_options.1')}}</label>
            </li>
            <li>
                <input name="assets[]" value="Washing Machine" type="checkbox" id="washingmachine">
                <label for="washingmachine">{{trans('financial_detail/assets_detail.other_options.2')}}</label>
             </li>
             <li>
                 <input name="assets[]" value="Two Wheeler" type="checkbox" id="two">
                 <label for="two">{{trans('financial_detail/assets_detail.other_options.3')}}</label>
              </li>
              <li>
                  <input name="assets[]" value="Camera Phone" type="checkbox" id="phone">
                  <label for="phone">{{trans('financial_detail/assets_detail.other_options.4')}}</label>
             </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
