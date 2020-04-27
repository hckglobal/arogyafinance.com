<ul class="nav nav-stacked">
	@if($title=='MIS Summary')
		<li>
	    	<a href="#" style="pointer-events: none; cursor: default;"> 
	        	<span class="pull-left badge bg-blue">{{$leads}}</span>
	      	</a>
	    </li>
	@else
		@foreach($application_types as $application)
	    <li>
	    	<a href="#" style="pointer-events: none; cursor: default;">{{$application->type}} 
	        	<span class="pull-right badge bg-blue">{{$application->count}}</span>
	      	</a>
	    </li>                           
	  	@endforeach
	@endif
	                                  
</ul>