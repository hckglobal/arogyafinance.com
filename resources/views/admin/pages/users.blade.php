@extends('admin.app')

@section('title') 
Users- Admin | Glamdoor
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-users')
class="active"
@endsection


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Bookings 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Users</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
               <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Loan Amount</th>
                    <th>Executive No</th>
                    <th>Card No</th>
                    <th>D.O.B</th>
                    <th>Email Id</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Phone No.1</th>
                    <th>Phone No.2</th>
                    <th>Corresponding No</th>
                    <th>Income</th>
                    <th>Family Members</th>
                    <th>Message</th>
                </tr>
              </thead>
              <tbody>
                 @foreach($users as $user)
                <tr>
                    <td>{{$user->first_name}}</td>
                   <td>{{$user->last_name}}</td>
                   <td>{{$user->loan_amount}}</td>
                   <td>{{$user->executive_no}}</td>
                   <td>{{$user->card_no}}</td>
                   <td>{{$user->date_birth}}</td>
                   <td>{{$user->email_id}}</td>
                   <td>{{$user->gender}}</td>
                   <td>{{$user->address}}</td>
                   <td>{{$user->phone1}}</td>
                   <td>{{$user->phone2}}</td>
                   <td>{{$user->corresponding_no}}</td>
                   <td>{{$user->income}}</td>
                   <td>{{$user->family_members}}</td>
                   <td>{{$user->phone2}}</td>
                   <td>{{$user->message}}</td>
                   
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Loan Amount</th>
                    <th>Executive No</th>
                    <th>Card No</th>
                    <th>D.O.B</th>
                    <th>Email Id</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Phone No.1</th>
                    <th>Phone No.2</th>
                    <th>Corresponding No</th>
                    <th>Income</th>
                    <th>Family Members</th>
                    <th>Message</th>
                  </tr>
                </tfoot>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

          
       
        </div><!-- /.content-wrapper -->
        @endsection

        @section('scripts')
        <!-- DataTables -->
        <script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="/admin/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/admin/dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/admin/dist/js/demo.js"></script>
        <!-- page script -->
        <script>
        $(function () {
          $(".table").DataTable();

        });
        </script>
        @endsection

