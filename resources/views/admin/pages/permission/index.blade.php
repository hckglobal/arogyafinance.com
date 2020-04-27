@extends('admin.app')

@section('title') 
Permissions
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection




@section('content')


<div class="content-wrapper" style="min-height: 946px;"><div style="padding: 20px 30px; background: rgb(243, 156, 18); z-index: 999999; font-size: 16px; font-weight: 600; display: none;"><a class="pull-right" href="#" data-toggle="tooltip" data-placement="left" title="" style="color: rgb(255, 255, 255); font-size: 20px;" data-original-title="Never show me this again!">×</a><a href="https://themequarry.com" style="color: rgba(255, 255, 255, 0.901961); display: inline-block; margin-right: 10px; text-decoration: none;">Ready to sell your theme? Submit your theme to our new marketplace now and let over 200k visitors see it!</a><a class="btn btn-default btn-sm" href="https://themequarry.com" style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">Let's Do It!</a></div>
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
       <!-- sidebar -->
       @include('admin.pages.permission.partials.sidebar')

        <!-- /.col -->
        <div class="col-md-8">
          <div class="box box-primary">
           
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="box-header with-border">
               <h3 class="box-title">Permissions</h3>
              </div>


              <div class="table-responsive mailbox-messages">
                <form action="/admin/manage-permission/{{$role->id}}" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                 @foreach($permissions as  $key=>$permission)
                  <div class="col-md-4">
                  <div class="checkbox">
                    <label label="permission-{{$key}}">
                      <input class="icheckbox_flat-blue" type="checkbox" name="permissions[]" value="{{$permission->id}}" id="permission-{{$key}}"  @if($rolePermissions->contains($permission))checked @endif>
                       &nbsp;{{$permission->display_name}}
                    </label>
                  </div>
                  </div>
                 @endforeach
                  <input class="btn btn-primary pull-right" style="margin-top:50px; margin-bottom:50px; margin-right:50px;" type="submit" value="Update Permissions">

                </form>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
          
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <!-- /.content -->
  </div>

@endsection

    

