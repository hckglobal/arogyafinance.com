@extends('admin.app')

@section('title') 
Blogs
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
          <div class="box-header">
            <a href="/admin/blog/create" class="pull-right btn btn-primary">Add Blog</a>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Title</th>
                    <th>Media</th>
                    <th>Actions</th>
                </tr>
              </thead>
                  <tbody>
                    @foreach($blogs as $blog)
                      <tr>
                          {{-- <td>{{$blogid}}</td> --}}
                          <td width="40%">{{$blog->title}}</td>
                          <td width="10%">
                            <img style="width:125px"  src="{{$blog->image}}" alt="">
                          </td>
                          <td width="1%" class="location-fa">
                            <a href="/admin/blog/edit/{{$blog->id}}" data-toggle="tooltip" data-placement="top" title="Edit Location"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="/admin/blog/delete/{{$blog->id}}" data-toggle="tooltip" data-placement="top" title="Delete Location"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

