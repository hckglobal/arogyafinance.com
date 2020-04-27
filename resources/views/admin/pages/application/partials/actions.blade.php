 <div class="row no-print">
            <div class="col-xs-12" id="application">
            <a href="/admin/application/update/status/verify/{{$application->id}} " class="btn btn-block btn-success">Verify</a>  <br>
            <a href="/admin/application/update/status/reject/{{$application->id}} " class="btn btn-block btn-success">Reject</a>  <br>
            <a href="/admin/application/update/status/sanction/{{$application->id}} " class="btn btn-block btn-success">Sanction</a>  <br>
            <a href="/admin/application/update/status/disburst/{{$application->id}} " class="btn btn-block btn-success">Disburst</a>  <br>
            
                <a href="/admin/application/full/download-pdf/{{$application->id}}" class="btn btn-primary airy pull-right">
                      <i class="fa fa-download"></i>Download Application
                </a>                
                @if($application->status=='new' && Entrust::can('verify-application'))
                <a 
                @click="showConfirmModal('/admin/application/verify/{{$application->id}}','verify')"
                 href="javascript:;" 
                 class="btn btn-primary airy">
                  <i class="fa fa-print"></i> Verify Form
                </a>
                @endif

                @if($application->status=='verified' && Entrust::can('sanction-application'))
                <a 
                @click="showConfirmModal('/admin/application/sanction/{{$application->id}}','sanction')" 
                href="javascript:;" 
                class="btn btn-primary airy">
                  <i class="fa fa-print"></i> Sanction Form
                </a>
                @endif

                @if($application->status=='sanctioned' && Entrust::can('disburse-application'))
                <a 
                @click="showConfirmModal('/admin/application/disburse/{{$application->id}}','disburse')" 
                href="javascript:;" 
                class="btn btn-primary airy">
                  <i class="fa fa-print"></i> Disburse Form
                </a>
                @endif

                @if(Entrust::can('sanction-application'))
                 <a  
                 @click="showConfirmModal('mailto:jpeter@arogyafinance.com?subject=Escalation of {{$application->type}} From {{$application->borrower->first_name}} {{$application->borrower->last_name}} | PIN: {{$application->pin_number}} &body=Dear Sir,%0D%0AKindly look into the application received and process the same, details below,%0D%0Awww.arogyafinance.com/admin/application/loan/detail/{{$application->id}}','escalate')" 
                 href="javascript:;" 
                 class="btn btn-primary airy">
                  <i class="fa fa-user"></i> Escalate Form to Admin
                </a>
                @endif

                @if(Entrust::can('genereate-sanction-letter'))
                    <a href="/admin/application/download-pdf/{{$application->id}}" class="btn btn-primary airy pull-right">
                          <i class="fa fa-download"></i> Generate Sanction Letter
                    </a>
                     <a href="/admin/application/download-pdf/{{$application->id}}?type=medtronic" class="btn btn-primary airy pull-right">
                          <i class="fa fa-download"></i> Generate Sanction Letter (Medtronic)
                    </a>
                @endif

                @if(Entrust::can('generate-test-report'))
                    <a href="/admin/application/download-pdf/{{$application->id}}" class="btn btn-primary airy pull-right">
                          <i class="fa fa-download"></i> Generate Test Report
                    </a>
                @endif

                @if($application->status!="rejected")
                  <a 
                  @click="showConfirmModal('/admin/application/reject/{{$application->id}}','reject')"
                   href="javascript:;" 
                   class="btn btn-danger airy">
                    <i class="fa fa-print"></i> Reject Application
                  </a>
                  
                @endif
                @include('admin.application.partials.modal_confirm')
            </div>
        </div>
