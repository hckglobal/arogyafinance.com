@extends('admin.app')

@section('title') 
MIS
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
  @include('admin.partials.content-header')

  <!-- Main content -->
  <section class="content content-fa">
    <div class="row">
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Import Lead</button>
            <a href="/admin/lead/create" class="pull-right btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create New Lead</a>
            <a href="/admin/lead/pending" class="btn btn-primary">Pending Lead</a>
            <a href="/admin/lead/converted-to-loan" class="btn btn-primary">Converted to Loan</a>
            <a href="/admin/lead/converted-to-card" class="btn btn-primary">Converted to Card</a>
            <a href="/admin/lead/rejected" class="btn btn-primary">Rejected Lead</a>
            
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>#Id</th>
                    <th>LEAD NAME</th>
                    <th>MOBILE NUMBER</th>
                    <th>PRODUCT</th>
                    <th>lOCATION</th>
                    @if($type=='pending')
                    <th>ACTIONS</th>
                    @endif
                    @if($type=='rejected')
                    <th>Reason</th>
                    @endif
                </tr>
              </thead>
                  <tbody>
                @forelse($leads as $lead)
                <tr>
                  <td>{{$lead->id}}</td>
                   <td>{{$lead->first_name}} {{$lead->middle_name}} {{$lead->last_name}}</td>
                   <td>{{$lead->mobile_number}}</td>
                   <td>@if($lead->product){{$lead->product->name}}@endif</td>
                   <td>@if($lead->location){{$lead->location->name}}@endif</td>
                   @if($type=='pending')
                     <td>
                       <a href="/apply/loan/personal-details?lead_id={{$lead->id}}&referrer_id={{$lead->referrer_id}}" target="_blank"><i data-toggle="tooltip" data-placement="top" title="Convert to Loan" class="fa fa-file-text-o" aria-hidden="true"></i></a>
                       <a href="/apply/card/personal-details?lead_id={{$lead->id}}&referrer_id={{$lead->referrer_id}}" target="_blank"><i data-toggle="tooltip" data-placement="top" title="Convert to Card" class="fa fa-credit-card" aria-hidden="true"></i></a>                
                       <a  href="javascript:;" type="button" data-toggle="modal" data-target="#lead-{{$lead->id}}"  ><i data-toggle="tooltip" data-placement="top" title="Reject"  class="fa fa-times" aria-hidden="true"></i></a>
                     </td>
                   @endif
                   @if($type=='rejected')
                      <td>
                        {{$lead->rejectionReason->text}}
                      </td>
                    @endif
                    
                </tr>
                <!-- Modal -->
                  <div id="lead-{{$lead->id}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <form action="/admin/lead/reject/{{$lead->id}}" method="POST">
                      {{csrf_field()}}
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Warning!</h4>
                        </div>
                        <div class="modal-body">
                          <p class="danger">Are you sure you want to reject the Mis</p>
                        </div>
                         <div class="modal-body">
                          <p>Give Reason</p>
                            <select class="form-control" name="reject_reason_id">
                              @foreach($reject_reasons as $reason)
                                <option value="{{$reason->id}}">{{$reason->text}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-danger">Submit</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>
                      </div>
                      </form>

                    </div>
                  </div>
                @empty
                <h4>No Data Available</h4>  
                @endforelse
                </tbody>
                
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
        </div>  

        
          </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('admin.pages.lead.import')
        @endsection

        @section('scripts')
        <!-- DataTables -->
        <script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
        
        <!-- page script -->
        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection

