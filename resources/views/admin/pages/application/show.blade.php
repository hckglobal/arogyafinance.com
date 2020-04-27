@extends('admin.app')

@section('title')
 {{$title}}
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<div class="content-wrapper">
  @include('admin.partials.content-header')
  <section class="invoice">
    @include('admin.pages.application.partials.header')
    @include('admin.pages.application.partials.summary')
    @if($application->arogyaCard)
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> Existing Arogya Card Holder</h3>
          <a href="/admin/application/card/detail/{{$application->arogya_card_id}}" target="_blank">
              <button class="btn btn-primary airy">View Arogya Card</button>
          </a>
        </div>
      </div>
    @else
    @endif
        
    <!-- agar arogya loan empty nahi hain to andar ja -->
    @if(!$application->arogyaLoans->isEmpty() && Entrust::can('view-loan-against-card'))
      <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Applied Loan</h3>
        @foreach($application->arogyaLoans as $loan)
          <a href="/admin/application/loan/detail/{{$loan->id}}">
            <button class="btn btn-primary airy">View Loan</button>
          </a>
        @endforeach
      </div>
      </div>
    @else
    @endif
    @include('admin.pages.application.partials.borrower_details')

    @if($application->type=="loan")
      @include('admin.pages.application.partials.patient_details')
    @endif

    @if($application->merchants)
      @include('admin.pages.application.partials.merchant_details')
      @include('admin.pages.application.partials.merchant_documents')
    @endif

    @if($application->assets->count() > 0)
      @include('admin.pages.application.partials.assets')
    @endif

    @if($application->type=="card")
      @include('admin.pages.application.partials.family_details')
    @endif

    @include('admin.pages.application.partials.financial_details')

    @include('admin.pages.application.partials.calculated_financial_details')

    @if($application->referrer_id == !null)
      @include('admin.pages.application.partials.referrer_details')
    @endif

    @include('admin.pages.application.partials.documents_upload')

    @if(Entrust::can('update-cibil-score'))
      @include('admin.pages.application.partials.update_cibil')
    @endif
    @if($application->references->count()>0)
      @include('admin.pages.application.partials.references_details')
    @endif

    @if($application->repaymentCheques->count()>0)
      @include('admin.pages.application.partials.repayment_cheque')
    @endif

    @include('admin.pages.application.partials.internal_details')

  </section>
  <div class="clearfix"></div>
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="/assets/js/vue.min.js"></script>
<script type="text/javascript" src="/assets/js/admin.vue.js"></script>
<script type="text/javascript" src="/assets/js/jquery.auto-complete.min.js"></script>
<script type="text/javascript" src="/assets/admin/dist/js/editable.js"></script>
@endsection
