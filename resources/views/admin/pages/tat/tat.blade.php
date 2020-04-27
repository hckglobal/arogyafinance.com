@extends('admin.app')

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('title') 
Users Turn Around Time
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
                        <h3 class="box-title">Turn Around Time</h3>
                    </div>
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>User</th>
                                  <th>Status</th>
                                  <th>Total Time Took (in Hrs)</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user=>$statuses)
                                    <tr>
                                        <td>{{$user}}</td>
                                        <td>{{$statuses->keys()->first()}}</td>
                                        <td>{{$statuses->first()->sum(6)}} | {{$statuses->map(function ($people) {
    return $people->count();
})->first()}} </td>
                                    </tr>
                                    @foreach($statuses->except($statuses->keys()->first()) as $key=>$value)
                                        <tr>
                                            <td width="45%"></td>
                                            <td width="25%">{{$key}}</td>
                                            <td>{{$value->sum(6)}} | {{$value->count()}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


