@extends('admin.app')

@section('title') 
{{$title}}
@endsection

@section('styles')
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')
<div class="content-wrapper">
  @include('admin.partials.content-header')
  <section class="content content-fa">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
              {{$title}}
            </button>            
          </div>
        </div>
      </div>
    </div>    
  </section>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Excel File Only!</h4>
      </div>
      <div class="modal-body">
        <form action= "/admin/hospital/import/parent/hospitals"
              method="post" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <input type="file" name="sample_file" id="sample_file">
          <input type="submit" class="btn btn-success" value="Import" name="Import">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection


