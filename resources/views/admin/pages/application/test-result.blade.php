@extends('admin.app')

@section('title')
Dashboard- Admin | Arogya Finance
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
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>

          </h1>
          <ol class="breadcrumb">
            <li class="active"></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="invoice">
          @if(Entrust::can('view-screenshots'))
            <h3>Psychometric Test Screenshots</h3>
            @foreach($borrower->screenshots as $photo)
              <div class="user-avatar col-md-3">     
                    <img src="{{'/'.$photo->url}}" class="img-responsive thumbnail" >                
              </div>
            @endforeach
          @endif  
        <div class="col-md-12 ">
         <h3 >
           Eligibility Test Result For :
           {{$borrower->first_name}} {{$borrower->middle_name}} {{$borrower->last_name}}</h3>

        </div>
          <div class="col-md-3">
         Ability Total : {{$borrower->score('ability')}} ({{$borrower->result('ability')}})
          </div>
          <div class="col-md-3">
         Integrity Total : {{$borrower->score('integrity')}} ({{$borrower->result('integrity')}})
          </div>
          <div class="col-md-3">
          Intension Total : {{$borrower->score('intention')}} ({{$borrower->result('intention')}})
          </div>
          <div class="col-md-3">
          Risk Total : {{$borrower->score('risk')}} ({{$borrower->result('risk')}})
          </div>
          <div class="col-md-12"> <h3>Total Score:{{$borrower->score('total')}} ({{$borrower->result('total')}}) </h3></div>
          
          <div class="clearfix"></div>
          <!-- Table row  -->
          @if(Entrust::can('view-test-details'))
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Question</th>
                    <th>Option</th>
                    <th>Value</th>
                    <th>Parameter</th>
                    <th>Level</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($borrower->answers as $answer)
                  <tr>

                    <td>{{$answer->question->text_en}}</td>
                    <td>{{$answer->option->text_en}}</td>
                    <td>{{$answer->option->value}}</td>
                    <td>{{$answer->question->parameter->name}}</td>
                    <td>{{$answer->question->level->name}}</td>


                    </tr>
                   @endforeach

                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
          @endif


          <!-- this row will not appear when printing -->
          <!-- <div class="row no-print">
            <div class="col-xs-12">
              <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
            </div>
          </div> -->
        </section><!-- /.content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
        @endsection

        @section('scripts')

        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection
