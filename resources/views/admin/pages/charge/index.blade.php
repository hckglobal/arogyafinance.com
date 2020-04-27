@extends('admin.app')

@section('title') 
Charges | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('admin.partials.content-header')

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Roles</th>
                        <th>Principal OS %</th>
                        <th>Overdue/EMI %</th>
                        <th>Dishonor Charges %</th>
                        <th>Late Payment Charges %</th>
                        <th>Legal Charges %</th>
                        <th>Pre-payment Charges %</th>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>{{ucwords($role->name)}}</td>
                        <td>
                            <a href="#" class="editable-click charges" 
                                data-name="principal_os" data-type="number" 
                                data-pk="{{$role->id}}" 
                                data-url="/admin/manage-charges/{{$role->id}}" 
                                data-title="Enter principal os %">
                                {{$role->charge?$role->charge->principal_os:'0'}}
                            </a>
                        </td>
                        <td>
                            <a href="#" class="editable-click charges" 
                                data-name="overdue_emi" data-type="number" 
                                data-pk="{{$role->id}}" 
                                data-url="/admin/manage-charges/{{$role->id}}" 
                                data-title="Enter overdue/emi %">
                                {{$role->charge?$role->charge->overdue_emi:'0'}}
                            </a>
                        </td>
                        <td>
                            <a href="#" class="editable-click charges" 
                                data-name="dishonor" data-type="number" 
                                data-pk="{{$role->id}}" 
                                data-url="/admin/manage-charges/{{$role->id}}" 
                                data-title="Enter dishonor %">
                                {{$role->charge?$role->charge->dishonor:'0'}}
                            </a>
                        </td>
                        <td>
                            <a href="#" class="editable-click charges" 
                                data-name="late_payment" data-type="number" 
                                data-pk="{{$role->id}}" 
                                data-url="/admin/manage-charges/{{$role->id}}" 
                                data-title="Enter late payment %">
                                {{$role->charge?$role->charge->late_payment:'0'}}
                            </a>
                        </td>
                        <td>
                            <a href="#" class="editable-click charges" 
                                data-name="legal" data-type="number" 
                                data-pk="{{$role->id}}" 
                                data-url="/admin/manage-charges/{{$role->id}}" 
                                data-title="Enter legal %">
                                {{$role->charge?$role->charge->legal:'0'}}
                            </a>
                        </td>
                        <td>
                            <a href="#" class="editable-click charges" 
                                data-name="pre_payment" data-type="number" 
                                data-pk="{{$role->id}}" 
                                data-url="/admin/manage-charges/{{$role->id}}" 
                                data-title="Enter pre_payment %">
                                {{$role->charge?$role->charge->pre_payment:'0'}}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No Charges Available</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<!-- DataTables -->
<script src="/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
@endsection

