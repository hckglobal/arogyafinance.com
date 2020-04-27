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
<div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-body ">
                        <form role="form" method="post" action="/admin/hospital/create">
                            <div class="col-md-6">
                                <h4>Hospital Details</h4>                        
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <label>Hospital name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Hospital Name">
                                </div>
                                <div class="form-group">
                                    <div>
                                       <label>Select Parent Hospital</label> 
                                    </div>
                                    <select name="parent_id" class="form-control select2" data-placeholder="Select">
                                       <option selected name="parent_id" value="">Make Root</option>
                                       @foreach($hospitals as $hospital)
                                        <option value="{{$hospital->id}}">
                                            {{$hospital->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Hospital Location</label>
                                    <input type="text" class="form-control" name="location" 
                                        placeholder="Enter Location">
                                </div>
                                <div class="form-group">
                                    <label>Hospital Website Link</label>
                                    <input type="text" class="form-control" name="url" placeholder="Enter Hospital Website Link">
                                </div>
                                <div class="form-group">
                                    <label>Number Of Branches</label>
                                    <input type="text" class="form-control" name="branches" 
                                        placeholder="Enter Numbers of Branches">
                                </div>
                                <div class="form-group">
                                    <label>Hospital Referrer</label>
                                    <input type="text" class="form-control" name="hospital_referrer" 
                                        placeholder="Enter Merchant Hospital Referrer Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Hospital Bank Details</h4>
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="acc_name" 
                                        placeholder="Enter Account Name">
                                </div>
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="acc_number"
                                        placeholder="Enter Account Number">
                                </div>
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <input type="text" class="form-control" name="acc_type" 
                                        placeholder="Enter Account Type">
                                </div>
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" 
                                        placeholder="Enter Bank Name">
                                </div>
                                <div class="form-group">
                                    <label>Branch Name</label>
                                    <input type="text" class="form-control" name="bank_branch" 
                                        placeholder="Enter Bank Branch Name">
                                </div>
                                <div class="form-group">
                                    <label>IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc_code" 
                                        placeholder="Enter Bank IFSC Code">
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <h4>Hospital POC Details</h4>
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" name="last_name" placeholder="Enter Las Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile_number" placeholder="Enter Mobile Number">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                    <label>Send Email Notification </label>
                                        <input class="icheckbox_flat-blue" type="checkbox" name="email_notification">
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



