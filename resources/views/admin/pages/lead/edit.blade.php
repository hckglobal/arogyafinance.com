@extends('admin.app')

@section('title') 
Dashboard - Admin | Arogya Finance
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
        <div class="col-md-8">
          
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body ">
              <form role="form" method="post" action="/admin/lead/edit/{{$lead->id}}">
                <!-- text input -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" value="{{$lead->first_name}}" class="form-control" name="first_name" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" value="{{$lead->last_name}}" class="form-control" name="last_name" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                  <label>Mobile Number</label>
                  <input type="number"  value="{{$lead->mobile_number}}" class="form-control" name="mobile_number" placeholder="Enter your Mobile Number">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" value="{{$lead->email}}" placeholder="Enter your Email">
                </div>
                <div class="form-group">
                  <label>Location</label>
                  <input type="text" class="form-control" name="location" value="{{$lead->location}}"  placeholder="Enter your location">
                </div>
                <div class="form-group">
                    <label>Product </label>
                    <select class="form-control" name="product">
                        @foreach($products as $product)
                          <option @if($lead->product == $product->name)) selected @endif value="{{$product->name}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
             
              
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
