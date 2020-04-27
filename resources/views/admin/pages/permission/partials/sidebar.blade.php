<div class="col-md-4">





<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">User Roles</h3>

    <div class="box-tools">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body no-padding" style="display: block;">
    <ul class="nav nav-pills nav-stacked">
      @foreach($roles as $role)
      <li class="{{Request::is('/admin/manage-permission/*') ? 'active': ''}}">
        <a href="/admin/manage-permission/{{$role->id}}">
           {{$role->display_name}}
        <span class="label label-primary pull-right">{{$role->permissions->count()}}</span></a>
      </li>
      @endforeach
        
      </ul>
    </div>
    <!-- /.box-body -->
  </div>


  </div>