@extends('admin.app')

@section('title')
Import Data
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
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">
                        <h3>Import Data</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if(Entrust::can('edit-collection'))
                        <div class="col-md-4 report-item">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#import-collection">
                                <i class="fa fa-upload"></i>
                                Import Collection Data
                            </button>
                        </div>
                        @endif
                        @if(Entrust::can('edit-collection'))
                        <div class="col-md-4 report-item">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#import-collection">
                                <i class="fa fa-upload"></i>
                                Import Bounce Data
                            </button>
                        </div>
                        @endif
                        <div class="col-md-4"></div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!-- Import collection -->
<div id="import-collection" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Data</h4>
            </div>
            <div class="modal-body">
                <form action="/admin/application/collection/import" method="post" enctype="multipart/form-data" id="import_form">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="file" name="sample_file" id="sample_file" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="import_collection">Import</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<!-- Import collection /-->
@endsection

@section('scripts')
<!-- page script -->
<script>
    $(function () {
        $("#import_collection").click(function(){
            $(this).text('Importing data...')
            .removeClass('btn-primary')
            .addClass('btn-danger')
            .prop('disabled', true);

            $('#import_form').submit();
        })
    });
</script>
@endsection