@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
CIBIL Dump Report
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >

  <!-- Main content -->
  <section class="content" id="application" >
    <div class="row">
      <div class="col-xs-12">
        <!-- filter -->
        <div class="box">
          <!-- box header -->
            <div class="box-header">
              <h3>CIBIL Dump Report</h3>
              <small>* Please provide a valid <b>disbursement date</b></small>
              <div class="row m-t-10 m-b-10">
                  <form action="/admin/report/master/filter-cibil-dump-data" method="get">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="start_date">From</label>
                          <div class='input-group date' id='start_date'>
                              <input type='text' class="form-control" name="start_date"
                                  @if($input->start_date!=null)
                                      value="{{$input->start_date}}"
                                  @endif
                              >
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                      </div>   
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="end_date">To</label>
                          <div class='input-group date' id='end_date'>
                              <input type='text' class="form-control" name="end_date"
                                  @if($input->end_date!=null)
                                      value="{{$input->end_date}}"
                                  @endif
                              >
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                      </div>   
                    </div>
                    <div class="col-md-2">
                        <div class="form-group contact-search m-b-30">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary">
                                <i class="ion-archive">&nbsp;&nbsp;</i> Download
                            </button>
                        </div>
                    </div>
                  </form>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /filter -->
      </div>
    </div>
  </section><!-- /content -->

</div><!-- /content-wrapper -->

@endsection
@section('scripts')           
<script type="text/javascript">
    $(document).ready(function() {
        $('#start_date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
        });
        $('#end_date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
        });
    });
</script>
@endsection
