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
        <div class="col-md-12">
          
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" method="post" action="/admin/question/create">
                <!-- text input -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <!-- textarea -->
                <div class="form-group">
                  <label>Question English</label>
                  <textarea class="form-control" name="text_en" rows="3" placeholder="Enter Your Question"></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Question Hindi</label>
                  <textarea class="form-control" name="text_hi" rows="3" placeholder="Enter Your Question"></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Question Marathi</label>
                  <textarea class="form-control" name="text_mr" rows="3" placeholder="Enter Your Question"></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Question Gujarati</label>
                  <textarea class="form-control" name="text_gu" rows="3" placeholder="Enter Your Question"></textarea>
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Question Bengali</label>
                  <textarea class="form-control" name="text_bn" rows="3" placeholder="Enter Your Question"></textarea>
                </div>

                <!-- select -->
                <div class="form-group col-md-6">
                  <label>Select Parameter</label>
                  <select class="form-control" name="parameter">
                  @foreach($parameters as $parameter)
                    <option value="{{$parameter->id}}">{{$parameter->name}}</option>
                  @endforeach  
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Select Level</label>
                  <select class="form-control" name="level">
                  @foreach($levels as $level)
                    <option value="{{$level->id}}">{{$level->name}}</option>
                  @endforeach  
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label>Insert Option Text &amp; Select the value</label> 
                              <div class="pull-right" style="margin-bottom:10px;">
                                <button class="add-option btn btn-primary" type="button">Add Option</i></button>
                              </div>
                    <div class="clearfix"></div>
                    <div class="parent col-md-12">
                      <div class="option">
                          <div class="col-md-6 form-group">
                            <input type="text" name="option_name[]" class="form-control">
                          </div>
                            <div class="col-md-6">
                              <div class="col-md-3">
                                <select name="option_value[]" style="width:100px;height:35px;border: 1px solid #ccc;">
                                  <option value="1">1.00</option>
                                  <option value="0.75">0.75</option>
                                  <option value="0.50">0.5</option>
                                  <option value="0.25">0.25</option>
                                  <option value="0">0</option>
                                </select>
                              </div>
                              <div class="col-md-3 pull-right">
                                <button class="remove btn btn-danger">Delete Option</button>
                              </div>
                            </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
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



