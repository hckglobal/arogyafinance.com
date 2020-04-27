@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Repayment Collections
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')
<div class="content-wrapper" >
    <section class="content" id="application" >
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-2"> 
                                <h3 class="box-title">PIN : {{$application->pin_number}}</h3>
                            </div>
                            @if(Entrust::can('edit-collection'))
                              <div class="col-md-2">
                                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add-collection">
                                    Add Collection
                                  </button>
                              </div>                              
                            @endif
                            @if($application->collections()->bounce()->count())
                            <div class="col-md-2">
                                <a href="/admin/application/view-cheque-bounce-schedule/{{$application->id}}"
                                  target="_blank">
                                    <button class="btn btn-default">View Bounce</button>
                                </a>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <a href="/admin/application/view-account-repayment-schedule/{{$application->id}}"
                                  target="_blank">
                                    <button class="btn btn-default pull-right">Acc Repayment Schedule</button>
                                </a>
                            </div>
                            <div class="col-md-1">
                                <a href="/admin/application/{{$application->type}}/detail/{{$application->id}}"
                                  target="_blank">
                                    <button class="btn btn-default pull-right">Back</button>
                                </a>
                            </div>  
                        </div>  
                    </div>
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Narration</th>
                                    <th>EMI Payment Date</th>
                                    <th>Amount Received</th>
                                    <th>Reference Number</th>
                                    <th>Source</th>
                                    <th colspan="3" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collections as $collection)
                                <tr>
                                  @if($collection->type!='emi')
                                    <td>{{$collection->narration}}</td>
                                    <td>{{$collection->emi_payment_date}}</td>
                                    <td>{{$collection->amount_received}}</td>
                                    <td>{{$collection->ref_no}}</td>
                                    <td>{{$collection->source}}</td>
                                    <td colspan="3" class="text-center"></td>                                  
                                  @else
                                    @if(Entrust::can('edit-collection'))
                                      <td>
                                        <a href="#" class="editable-click inline-edit" 
                                          data-name="narration" data-type="text" 
                                          data-pk="{{$collection->id}}" data-url="/admin/application/collection/edit/{{$collection->id}}" 
                                          data-title="Enter narration">{{$collection->narration}}
                                        </a>
                                      </td>
                                      <td>
                                          <a href="#" class="editable-click inline-edit" 
                                            data-name="emi_payment_date" data-type="text" 
                                            data-pk="{{$collection->id}}" data-url="/admin/application/collection/edit/{{$collection->id}}" 
                                            data-title="Enter amount received">{{$collection->emi_payment_date}}
                                          </a>
                                      </td>
                                      <td>
                                          <a href="#" class="editable-click inline-edit" 
                                            data-name="amount_received" data-type="text" 
                                            data-pk="{{$collection->id}}" data-url="/admin/application/collection/edit/{{$collection->id}}" 
                                            data-title="Enter amount received">{{$collection->amount_received}}
                                          </a>
                                      </td>
                                      <td>
                                          <a href="#" class="editable-click inline-edit" 
                                            data-name="ref_no" data-type="text" 
                                            data-pk="{{$collection->id}}" data-url="/admin/application/collection/edit/{{$collection->id}}" 
                                            data-title="Enter refernce number">{{$collection->ref_no}}
                                          </a>
                                      </td>    
                                      <td>
                                          <a href="#" class="editable-click inline-edit" 
                                            data-name="source" data-type="text" 
                                            data-pk="{{$collection->id}}" data-url="/admin/application/collection/edit/{{$collection->id}}" 
                                            data-title="Enter refernce number">{{$collection->source}}
                                          </a>
                                      </td>
                                      <td class="text-center">
                                          @if(Entrust::can('delete-collection'))
                                            <a href="/admin/application/collection-delete/{{$collection->id}}" 
                                            data-toggle="tooltip" data-placement="top" title="Delete Collection">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                          @endif
                                      </td>
                                      @if(Entrust::can('manage-cheque-bounce'))
                                        <td @if($collection->bounce==1)class="text-center collection-bounce" @else class="text-center" @endif>
                                            
                                              @if($collection->bounce==0)
                                              <a href="/admin/application/collection-mark-bounce/{{$collection->id}}" 
                                              data-toggle="tooltip" data-placement="top" title="Mark Bounce" target="_blank">
                                              <i class="fa fa-chain-broken" aria-hidden="true"></i>
                                              </a>
                                              @else
                                                <a href="/admin/application/collection-view-bounce/{{$collection->id}}" 
                                              data-toggle="tooltip" data-placement="top" title="view Bounce" target="_blank">
                                              <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                              </a>
                                              @endif
                                        </td>
                                        
                                        <td class="text-center">
                                          @if($collection->bounce==1)
                                            <a href="/admin/application/collection-bounce-delete/{{$collection->id}}" 
                                              data-toggle="tooltip" data-placement="top" title="Delete Bounce">
                                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                          @endif
                                        </td>
                                      @endif
                                    @else
                                      <td>{{$collection->narration}}</td>
                                      <td>{{$collection->emi_payment_date}}</td>
                                      <td>{{$collection->amount_received}}</td>
                                      <td>{{$collection->ref_no}}</td>    
                                      <td>{{$collection->source}}</td>
                                      <td colspan="3" class="text-center"></td>
                                    @endif
                                  @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Add New collection -->
<div class="modal fade" id="add-collection" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h3><i class="fa fa-check-circle-o "></i> Add New collection</h3>
      </div>
      <div class="modal-body">
        <form action= "/admin/application/collection/add" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="application_id" value="{{$application->id}}">
        <input type="hidden" name="type" value="emi">
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Payment Date *</label>
                    <input type='date' class="form-control" name="emi_payment_date" 
                    placeholder="Select payment date" aria-required="true" aria-invalid="true" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Amount Received *</label>
                    <input class="form-control" type="text" name="amount_received" placeholder="Enter amount" aria-required="true" aria-invalid="true" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label>Transaction Number *</label>
                    <input class="form-control" type="text" name="transaction_number" placeholder="Enter transaction number" aria-required="true" aria-invalid="true">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Reference Number</label>
                    <input class="form-control" type="text" name="ref_no" placeholder="Enter refernce number" aria-required="true" aria-invalid="true">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Source</label>
                    <input class="form-control" type="text" name="source" placeholder="Enter point of source" aria-required="true" aria-invalid="true">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label>Narration *</label>
                    <textarea name="narration" class="form-control" placeholder="Enter narration" aria-required="true" aria-invalid="true" required></textarea>
                </div>
              </div>
            </div>
          <div class="clearfix"></div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>  
<!-- Add New collection -->
@endsection