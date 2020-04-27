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
              <form role="form" method="post" action="/admin/question/edit/{{$question->id}}">
                <!-- text input -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <!-- textarea -->
                <div class="form-group">
                  <label>Question Text</label>
                  <textarea class="form-control" name="text" "rows="3" placeholder="Enter ...">{{$question->text}}</textarea>
                </div>
                <!-- select -->
                <div class="form-group col-md-6">
                  <label>Select Parameter</label>
                  <select class="form-control" name="parameter_id">
                  @foreach($parameters as $parameter)
                    <option value="{{$parameter->id}}" @if($question->parameter_id==$parameter->id) selected @endif>{{$parameter->name}}</option>
                  @endforeach  
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Select Level</label>
                  <select class="form-control" name="level_id">
                  @foreach($levels as $level)
                    <option value="{{$level->id}}" @if($question->level_id==$level->id) selected @endif>{{$level->name}}</option>
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
                     @foreach($question->options as $option)
                      <div class="option">
                          <div class="col-md-6 form-group">
                            <input type="text" name="option_name[]"  value="{{$option->text}}" class="form-control">
                          </div>
                            <div class="col-md-6">
                              <div class="col-md-3">
                                <select name="option_value[]" style="width:100px;height:35px;border: 1px solid #ccc;">
                                  <option value="1"    @if($option->value==1) selected @endif>1.00</option>
                                  <option value="0.75" @if($option->value==0.75) selected @endif>0.75</option>
                                  <option value="0.50" @if($option->value==0.50) selected @endif>0.5</option>
                                  <option value="0.25" @if($option->value==0.25) selected @endif>0.25</option>
                                  <option value="0"    @if($option->value==0) selected @endif>0</option>
                                </select>
                              </div>
                              <div class="col-md-3 pull-right">
                                <button class="remove btn btn-danger">Delete Option</button>
                              </div>
                            </div>
                      </div>
                      <div class="clearfix"></div>
                      @endforeach
                    </div>
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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

@section('scripts')

<!-- page script -->
@endsection

