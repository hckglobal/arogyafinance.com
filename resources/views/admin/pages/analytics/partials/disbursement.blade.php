<ul class="nav nav-stacked">
	@foreach($application_disbursed as $key=>$value)
  	<li>
    	<a href="/admin/analytics/summary/filter?{{$input->getQueryString()}}&status=disbursed&month_year={{$value->month}} {{$value->year}}">
			<div class="row">
      			<div class="col-md-6">
      				{{$value->month}} {{$value->year}}
      			</div>
      			<div class="col-md-2">
      				<span class="pull-right badge bg-blue">{{$value->count}}</span>
      			</div>
      			<div class="col-md-4">
      				<span class="pull-right badge bg-red">&#8377; {{$value->disbursed_amount}}</span>
      			</div>
      		</div>
    	</a>
  	</li>
  	@endforeach
    <li><hr>
      <a href="#" style="pointer-events: none; cursor: default;">
      <div class="row">
            <div class="col-md-6">
              Total Disbursement
            </div>
            <div class="col-md-2">
              <span class="pull-right badge bg-blue">{{$total_disbursement_count}}</span>
            </div>
            <div class="col-md-4">
              <span class="pull-right badge bg-red">&#8377; {{$total_disbursement_amount}}</span>
            </div>
          </div>
      </a>
    </li>                                    
</ul>