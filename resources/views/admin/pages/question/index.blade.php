@extends('admin.app')

@section('title') 
Questions
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('admin.partials.content-header')

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Id</th>
                    <th>Question Text</th>
                    <th>Action</th>
                    
                </tr>
              </thead>
                  <tbody>
                 @foreach($questions as $question)
                <tr>
                   <td>{{$question->id}}</td>
                   <td>{{$question->text}}</td>
                   <td class="location-fa">
                   <a href="/admin/question/edit/{{$question->id}}" data-toggle="tooltip" data-placement="top" title="Edit Question"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                   <a href="/admin/question/delete/{{$question->id}}" data-toggle="tooltip" data-placement="top" title="Delete Question"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                   </td>
                </tr>
                @endforeach
                </tbody>
                
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->


        
          </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @endsection

        @section('scripts')
        <!-- DataTables -->
        <script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
        
        <!-- page script -->
        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection

