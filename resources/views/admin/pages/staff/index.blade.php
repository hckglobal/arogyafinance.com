@extends('admin.app')

@section('title') 
Staffs - Admin | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
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
        <div class="box">
          <div class="box-header">
            <a href="/admin/staff/create" class="pull-right btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create New User</a>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email Id</th>
                  <th>Role</th>
                  <th>Referrer Code</th>
                  <th>Filter</th>
                  <th>Filter Value</th>
                  @if(Entrust::can('activate-deactitave-users'))
                  <th>Status</th>
                  @endif
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($admins as $admin)
                <tr>
                  <td>{{$admin->first_name}} @if($admin->last_name) {{$admin->last_name}} @endif</td>
                  <td>{{$admin->email}}</td>
                  <td>{{$admin->roles->first()->display_name}}</td>
                  <td>{{$admin->referrer_code}}</td>
                  <td>{{$admin->application_column}}</td>
                  <td>{{$admin->application_column_value}}</td>
                  @if(Entrust::can('activate-deactitave-users'))
                    <td>
                      @if($admin->status)
                        <a href="/admin/staff/change/deactivate/{{$admin->id}}" data-toggle="tooltip" data-placement="top" title="Deactivate User" class="btn btn-danger">Deactivate</a>
                      @else
                        <a href="/admin/staff/change/activate/{{$admin->id}}" data-toggle="tooltip" data-placement="top" title="Activate User" class="btn-group btn btn-success">Activate</a>
                      @endif
                    </td>
                  @endif
                  <td class="location-fa">
                  <a href="/admin/staff/edit/{{$admin->id}}" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                  <a href="/admin/staff/delete/{{$admin->id}}" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<!-- DataTables -->
<script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
$(".table").DataTable();

});
</script>
@endsection

