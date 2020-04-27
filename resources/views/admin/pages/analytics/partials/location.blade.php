<ul class="nav nav-stacked">
	@foreach($application_location as $application)
    <li>
    	@if($title=='MIS Summary')
	    	<a href="/admin/analytics/mis/summary/filter?location={{$application->location_id}}&{{$input->getQueryString()}}">{{$application->name}} 
	        	<span class="pull-right badge bg-blue">{{$application->count}} </span>
	      	</a>
      	@else
      		<a href="/admin/analytics/summary/filter?location={{$application->location_id}}&{{$input->getQueryString()}}">{{$application->name}} 
	        	<span class="pull-right badge bg-blue">{{$application->count}}</span>
	      	</a>
      	@endif
    </li>                           
  @endforeach                                  
</ul>