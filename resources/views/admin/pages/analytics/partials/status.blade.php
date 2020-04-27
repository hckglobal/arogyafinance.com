<ul class="nav nav-stacked">
    @foreach($application_status as $application)
    <li>
      @if($title=='MIS Summary')
        <a href="/admin/analytics/mis/summary/filter?status={{$application->status}}&{{$input->getQueryString()}}">{{ucfirst($application->status)}} 
            <span class="pull-right badge bg-blue">{{$application->count}}</span>
          </a>
        @else
          <a href="/admin/analytics/summary/filter?status={{$application->status}}&{{$input->getQueryString()}}">{{ucfirst($application->status)}} 
            <span class="pull-right badge bg-blue">{{$application->count}}</span>
          </a>
        @endif
    </li>                           
    @endforeach

    @if($title!='MIS Summary')
      @foreach($application_disbursed_status as $application)
        <li>
          <a href="/admin/analytics/summary/filter?status={{$application->status}}&{{$input->getQueryString()}}">{{ucfirst($application->status)}} 
            <span class="pull-right badge bg-blue">{{$application->count}}</span>
          </a>
        </li>                           
      @endforeach
    @endif
    <hr>
      <strong>Rejected Cases</strong>
    <hr>
    @foreach($application_reject_status as $application)
    <li>
      @if($title=='MIS Summary')
        <a href="/admin/analytics/mis/summary/filter?reject_reason_id={{$application->id}}&{{$input->getQueryString()}}">{{ucfirst($application->text)}} 
            <span class="pull-right badge bg-blue">{{$application->count}}</span>
          </a>
        @else
          <a href="/admin/analytics/summary/filter?reject_reason_id={{$application->id}}&{{$input->getQueryString()}}">{{ucfirst($application->text)}} 
            <span class="pull-right badge bg-blue">{{$application->count}}</span>
          </a>
        @endif
    </li>                           
    @endforeach                                  
</ul>