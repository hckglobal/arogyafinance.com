@extends('admin.app')

@section('title') 
{{$title}} | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Location</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" method="post" action="/admin/location/edit/{{$location->id}}" autocomplete="off">
                            <!-- text input -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Name</label>
                                    <input class="form-control" name="name" value="{{$location->name}}" placeholder="Location Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary location-update-btn">Update Location</button>
                                </div>
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

