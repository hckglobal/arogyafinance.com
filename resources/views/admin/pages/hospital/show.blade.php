@extends('admin.app')

@section('title') 
Hopital Details | Arogya Finance
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
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="col-md-6">
                            <h4>Hospital Details</h4>  
                            <div class="form-group">
                              <label>Hospital name</label>
                              <input type="text" class="form-control" value="{{$hospital->name}}" readonly="">
                            </div>
                            <div class="form-group">
                              <label>Location</label>
                              <input type="text" class="form-control" value="{{$hospital->location}}" readonly="">
                            </div>
                            <div class="form-group">
                              <label>Url</label>
                              <input type="text" class="form-control" value="{{$hospital->url}}" readonly="">
                            </div>
                            <div class="form-group">
                              <label>Number Of Branches</label>
                              <input type="text" class="form-control" value="{{$hospital->branches}}" readonly="">
                            </div>
                            <div class="form-group">
                              <label>Hospital Referrer</label>
                              <input type="text" class="form-control" value="{{$hospital->hospital_referrer}}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Hospital Bank Details</h4>
                            <div class="form-group">
                                <label>Account Name</label>
                                <input type="text" class="form-control" value="{{$hospital->acc_name}}" readonly="">
                            </div>
                        </div>    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" value="{{$hospital->acc_number}}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-3">    
                            <div class="form-group">
                                <label>Account Type</label>
                                <input type="text" class="form-control" value="{{$hospital->acc_type}}" readonly="">
                            </div>
                        </div>
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" value="{{$hospital->bank_name}}" readonly="">
                            </div>
                            <div class="form-group">
                                <label>Branch Name</label>
                                <input type="text" class="form-control" value="{{$hospital->bank_branch}}" readonly="">
                            </div>
                            <div class="form-group">
                                <label>IFSC Code</label>
                                <input type="text" class="form-control" value="{{$hospital->ifsc_code}}" readonly="">
                            </div>                            
                        </div>                                
                    </div>
                </div>
            </div>
        </div>
    </section>     
</div>
@endsection


