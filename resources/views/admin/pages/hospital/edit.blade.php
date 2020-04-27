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
                        <form role="form" method="post" action="/admin/hospital/edit/{{$hospital->id}}">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="col-md-6">
                                <h4>Hospital Details</h4>  
                                <div class="form-group">
                                  <label>Hospital name</label>
                                  <input type="text" class="form-control" name="name" value="{{$hospital->name}}" placeholder="Enter Hospital Name">
                                </div>
                                @if($hospital->isChild())
                                <div class="form-group">
                                    <div>
                                       <label>Select Parent Hospital</label> 
                                    </div>
                                    <select name="parent_id" class="form-control select2" data-placeholder="Select">
                                       <option selected name="parent_id" value="">Make Root</option>
                                       @foreach($hospitals as $all_hospital)
                                        <option 
                                        @if($all_hospital->id==$hospital->parent_id) selected @endif
                                        value="{{$all_hospital->id}}">
                                            {{$all_hospital->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                  <label>Location</label>
                                  <input type="text" class="form-control" value="{{$hospital->location}}" name="location" placeholder="Enter City">
                                </div>
                                <div class="form-group">
                                  <label>Hospital Website Link</label>
                                  <input type="text" class="form-control" value="{{$hospital->url}}" name="url" placeholder="Enter Hospital Website Link">
                                </div>
                                <div class="form-group">
                                  <label>Number Of Branches</label>
                                  <input type="text" class="form-control" value="{{$hospital->branches}}" name="branches" placeholder="Enter Numbers of Branches">
                                </div>
                                <div class="form-group">
                                  <label>Hospital Referrer</label>
                                  <input type="text" class="form-control" value="{{$hospital->hospital_referrer}}" name="hospital_referrer" placeholder="Enter Merchant Hospital Referrer Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Hospital Bank Details</h4>
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="acc_name" 
                                        value="{{$hospital->acc_name}}" placeholder="Enter Account Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="acc_number"
                                        value="{{$hospital->acc_number}}" placeholder="Enter Account Number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Account Type</label>
                                    <input type="text" class="form-control" name="acc_type" 
                                        value="{{$hospital->acc_type}}" placeholder="Enter Account Type">
                                </div>
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" 
                                        value="{{$hospital->bank_name}}" placeholder="Enter Bank Name">
                                </div>
                                <div class="form-group">
                                    <label>Branch Name</label>
                                    <input type="text" class="form-control" name="bank_branch" 
                                        value="{{$hospital->bank_branch}}" placeholder="Enter Bank Branch Name">
                                </div>
                                <div class="form-group">
                                    <label>IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc_code" 
                                        value="{{$hospital->ifsc_code}}" placeholder="Enter Bank IFSC Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Hospital POC Details</h4>
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="{{$hospital->first_name}}" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{$hospital->last_name}}" placeholder="Enter Las Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile_number" value="{{$hospital->mobile_number}}" placeholder="Enter Mobile Number">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email"
                                        value="{{$hospital->email}}" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                        <label>Send Email Notification</label>
                                        <input class="icheckbox_flat-blue" type="checkbox" name="email_notification" @if($hospital->email_notification==1) checked @else unchecked @endif>
                                    </div>
                            </div>
                            <div class="col-md-12">    
                                <div class="box-footer pull-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>     
</div>
@endsection


