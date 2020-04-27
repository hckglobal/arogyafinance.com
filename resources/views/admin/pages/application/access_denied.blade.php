@extends('admin.app')

@section('title')
Access Denied
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        403 Error Page
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h2 class="headline text-red">Access Denied</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

          <p>
            The Page you are trying to access is restricted.
          </p>
          <a href="/admin/dashboard" class="btn btn-danger btn-flat">Go to Dashboard</a></td>
           

        </div>
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>

@endsection

