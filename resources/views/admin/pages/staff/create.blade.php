@extends('admin.app')

@section('title') 
Staff - Admin | Arogya Finance
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
                        <form role="form" method="post" action="/admin/staff/create" autocomplete="off">
                            <!-- text input -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" name="first_name" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" name="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input class="form-control" name="mobile_number" placeholder="Mobile Number" required>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" name="email" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Referrer Code</label>
                                    <input class="form-control" name="referrer_code" placeholder="Referrer Code">
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                  <label>Select Role</label>
                                <select class="form-control" name="role_ids[]">
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                   <label>Select Location</label> 
                                    <select name="location_ids[]" class="form-control select2" data-placeholder="Select" multiple="true">
                                       @foreach($locations as $location)
                                        <option value="{{$location->id}}">
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
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label>Filter Value</label>
                                    <select name="application_column_value" class="form-control select2" data-placeholder="Select" id="filter_value">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group"><br>
                                    <label>Send Email Notification </label>
                                    <input type="checkbox" class="form-control" name="email_notification">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Create User</button>
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

@endsection

