@extends('admin.app')

@section('title') 
Staff Management - Admin | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection


@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   @include('admin.partials.content-header')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" method="post" action="/admin/staff/update/{{$admin->id}}" autocomplete="off">
                            <!-- text input -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" name="first_name" value="{{$admin->first_name}}" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" name="last_name"  value="{{$admin->last_name}}" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input class="form-control" name="mobile_number" value="{{$admin->mobile_number}}" placeholder="Mobile Number">
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" name="email" value="{{$admin->email}}" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Referrer Code</label>
                                    <input class="form-control" name="referrer_code" value="{{$admin->referrer_code}}" placeholder="Referrer Code">
                                </div>
                            </div>                            
                            <div class="col-md-6">    
                                <div class="form-group">
                                  <label>Select Role</label>
                                <select class="form-control" name="role_id[]">
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" @if($admin->roles->contains($role)) selected @endif >{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                   <label>Select Location</label> 
                                    <select name="location_ids[]" class="form-control select2" data-placeholder="Select" multiple="true">
                                       @foreach($locations as $location)
                                        <option value="{{$location->id}}" @if($admin->locations->contains($location->id)) selected @endif>
                                            {{$location->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                  <label>Filter</label>
                                <select class="form-control" name="application_column" id="filter">
                                    @foreach($application_columns as $key => $value)
                                    <option @if($admin->application_column == $key)) selected @endif value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Filter Value</label>
                                    <select name="application_column_value" class="form-control select2" data-placeholder="Select" id="filter_value" data-default-value="{{$admin->application_column_value}}"></select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group"><br>
                                    <label>Send Email Notification </label>
                                    <input type="checkbox" class="form-control" name="email_notification"  @if($admin->email_notification==1) checked @else unchecked @endif>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                    
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Update User </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
        <!-- /.content -->
        <h3>Merchant API Token </h3>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="col-md-7">    
                            <div class="form-group">
                                <label>API Token</label>
                                <input class="form-control" type="text" value="{{$admin->merchant_api_token}}" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3>Update Password</h3>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" method="post" action="/admin/staff/update/password/{{$admin->id}}" autocomplete="off">
                            <!-- text input -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="password" value="" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                    
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Update User Password</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
        <!-- /.content -->
</div>
@endsec
@endsection

@section('scripts')


<!-- page script -->
@endsection

