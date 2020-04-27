@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
EMI
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  <section class="content" id="application" >
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3>PDC Report</h3> 
                <div class="row m-t-10 m-b-10">
                    <form action="/admin/applications/emi-export" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="col-md-3">
                            <label for="cheque_date">Select PDC date</label>
                            <select class="form-control" name="cheque_date">
                                <option value="" disabled selected>Select PDC date</option>
                                <option @if($input->cheque_date == "all")) selected @endif value="all"> All</option>
                                <option @if($input->cheque_date == "05")) selected @endif value="05"> 5th of Month</option>
                                <option @if($input->cheque_date == "09")) selected @endif value="09"> 9th of Month</option>
                                <option @if($input->cheque_date == "15")) selected @endif value="15"> 15th of Month</option>
                            </select>    
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group contact-search m-b-30">
                            <label>&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="ion-archive">&nbsp;&nbsp;</i>   Export
                                </button>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group contact-search m-b-30">
                                <label>&nbsp;</label>
                                <a class="btn btn-block btn-primary" href="/admin/applications/emi">
                                    <i class="ion-refresh">&nbsp;&nbsp;</i>Clear Filter
                                </a>    
                            </div>
                        </div>
                    </form>
                    <div class="col-md-2 pull-right">
                        <div class="form-group contact-search m-b-30">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#importACHData">
                              Import ACH
                            </button>
                            <div id="importACHData" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">
                                                Import Excel File Only!
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action= "/admin/applications/emi/import/ach-data" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="file" name="sample_file">
                                                <input type="submit" class="btn btn-success" value="Import" name="Import">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection