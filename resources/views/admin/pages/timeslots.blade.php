@extends('admin.app')

@section('title') 
Manage TimeSlots- Admin | Glamdoor
@endsection

@section('styles')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="/assets/admin/plugins/iCheck/all.css">
@endsection

@section('active-timeslots')
class="active"
@endsection


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Timeslots 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">


          <!-- SELECT2 EXAMPLE -->
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Blocked TimeSlots</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form action="/assets/admin/manage-timeslots" method="POST">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <div class="col-md-12">
                   <!-- checkbox -->
                   @foreach($timeslots as $timeslot)
                  <div class="form-group col-md-4 col-sm-3">
                    <label class="" style="cursor:pointer">
                      <div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                        <input type="checkbox" name="blocked_timeslots[]" value="{{$timeslot->id}}"class="flat-red" @if($timeslot->blocked)checked @endif style="position: absolute; opacity: 0;">
                        
                      </div>
                        {{$timeslot->timeslot}}
                    </label>
                  </div>
                  @endforeach
                   <input type="submit" value="Save Changes" class="btn btn-success">
                 </div>
                
                 </form>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
            </div>
          </div><!-- /.box -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('scripts')
    <!-- iCheck 1.0.1 -->
    <script src="/assets/admin/plugins/iCheck/icheck.min.js"></script>
<script>
//Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });
</script>
@endsection

