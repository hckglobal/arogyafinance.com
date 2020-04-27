@extends('admin.app')

@section('title') 
Hospitals
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
        @if(Entrust::can('add-hospital'))
          <div class="box-header">
            <a href="/admin/hospital/create" class="pull-right btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create Hospital</a>
          </div>
        @endif
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>HOSPITAL NAME</th>
                    <th>ACTION</th>                    
                </tr>
              </thead>
                  <tbody>
                     @foreach($hospitals as $hospital)
                     @if($hospital->isRoot())
                      <tr>
                        <td><h4><b>{{$hospital->name }}</b></h4>
                          <ul>
                            <table>
                              <tbody>
                              @foreach($hospital->getDescendants() as $descendant)
                                <tr>
                                  <td>
                                    <li><h5>{{$descendant->name }}</h5></li>
                                  </td>
                                  <td  class="descendants">
                                  <style type="text/css">
                                    .descendants a{
                                      display: inline-block;
                                      margin: 0 8px;
                                    }
                                  </style>  
                                    <a href="/admin/hospital/{{$descendant->id}}" data-toggle="tooltip" data-placement="top" title="View Hospital"><i class="fa fa-file" aria-hidden="true"></i></a>
                                     @if(Entrust::can('edit-hospitals')) 
                                     <a href="/admin/hospital/edit/{{$descendant->id}}" data-toggle="tooltip" data-placement="top" title="Edit Hospital"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     @endif
                                     @if(Entrust::can('delete-hospitals'))
                                     <a href="/admin/hospital/delete/{{$descendant->id}}" data-toggle="tooltip" data-placement="top" title="Delete Hospital"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                     @endif
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </ul>
                        </td>
                        <td  class="descendants">
                          <style type="text/css">
                            .descendants a{
                              display: inline-block;
                              margin: 0 8px;
                            }
                          </style>  
                          <a href="/admin/hospital/{{$hospital->id}}" data-toggle="tooltip" data-placement="top" title="View Hospital"><i class="fa fa-file" aria-hidden="true"></i></a>
                          @if(Entrust::can('edit-hospitals')) 
                          <a href="/admin/hospital/edit/{{$hospital->id}}" data-toggle="tooltip" data-placement="top" title="Edit Hospital"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          @endif
                          @if(Entrust::can('delete-hospitals'))
                          <a href="/admin/hospital/delete/{{$hospital->id}}" data-toggle="tooltip" data-placement="top" title="Delete Hospital"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          @endif
                          @if(Entrust::can('import-hospital-branch'))
                          <a href="/admin/hospital/import/{{$hospital->id}}" data-toggle="tooltip" data-placement="top" title="Import Branch">Import</a>
                          @endif
                        </td>
                      </tr>
                      @endif
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

