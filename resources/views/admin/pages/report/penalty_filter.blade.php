@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Penalty Report
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
              <div class="row m-t-10 m-b-10">
                  <form action="/admin/report/master/filter-penalty-data" method="get">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="closure_date">Penalty Report Month</label>
                          <div class='input-group date' id='closure_date'>
                              <input type='text' class="form-control" name="closure_date"
                                  @if($input->closure_date!=null)
                                      value="{{$input->closure_date}}"
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
        $('#closure_date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
        });
    });
</script>
@endsection
