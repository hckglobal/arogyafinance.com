@extends('website.app')

@section('title')
 @if($type=="loan")
 Application for Medical Loan
 @else
 Application for Pre-Approved Arogya Card
 @endif
@endsection

@section('styles')
    <!-- Loading Plugin -->
    <script src="/assets/js/isLoading.min.js"></script>
    <!-- boootsrap -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.auto-complete.css"/>
    <link rel="stylesheet" href="/assets/admin/plugins/select2/select2.min.css">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <!-- Panel Wizard Form Container -->
        <div class="panel paddingtop-class">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <!-- Steps -->
                <div class="pearls row">
                    <div class="pearl current col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.1')}}</span>
                    </div>
                    <div class="pearl col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.2')}}</span>
                    </div>
                    <div class="pearl col-xs-4">
                        <div class="pearl-icon"><i class="glyphicon glyphicon-file" aria-hidden="true"></i>
                        </div>
                        <span class="pearl-title">{{trans('steps.step_no.3')}}</span>
                    </div>
                </div>
                 <!-- End Steps -->
                <!-- Wizard Content -->
                <form id="personal_details" class="wizard-content active" action="/apply/{{$type}}/personal-details?locale={{$locale}}" method="POST" >
                    <div class="wizard-pane active" role="tabpanel">
                        <input type="hidden" name="partner_reference_code" value="{{$referrer_id}}">
                        <input type="hidden" id="type"  name ="type" value="{{$type}}">
                        <input type="hidden" name ="lead_id" value="{{$lead_id}}">
                        
                        <!--=====================================
                        =            Patient Details            =
                        ======================================-->
                        @if($type=="loan")
                           @include('website.pages.application.partials.patient_details')
                        @endif
                        <!--====  End of Patient Details  ====-->

                        <!--======================================
                        =            Borrower Details            =
                        =======================================-->
                        @include('website.pages.application.partials.borrower_details')
                        <!--====  End of Borrower Details  ====-->

                        <!--====================================
                        =            Famliy Details            =
                        =====================================-->
                        @if($type=="card")
                          @include('website.pages.application.partials.family_details')
                        @endif
                         <!--====  End of Famliy Details  ====-->

                        @include('website.pages.application.partials.declaration')
                    </div>
                    <input class="btn btn-primary btn-outline pull-right" type="submit" value="Next">
                </form>
                <!-- Wizard Content -->
            </div>
        </div>
        <!-- End Panel Wizard Form Container -->
    </div>
</div>

@endsection

@section('script')
<script src="/assets/admin/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
$('.hospital_name').autoComplete({
    minChars: 2,
    source: function(term, suggest){
        term = term.toLowerCase();
        var choices = {!! $hospitals !!};
        var matches = [];
        for (i=0; i<choices.length; i++)
            if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
        suggest(matches);
    }
});

$(".select2").select2({
    tags: true
}); 
</script>
@endsection
