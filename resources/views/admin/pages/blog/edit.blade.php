@extends('admin.app')

@section('title')
{{$title}} | Arogya Finance
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/assets/admin/plugins/summernote/summernote.css">
@endsection


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('admin.partials.content-header')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Blog</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form role="form" method="post" action="/admin/blog/edit/{{$blog->id}}" autocomplete="off"
                            enctype='multipart/form-data'>
                            <!-- text input -->
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" name="title" value="{{$blog->title}}"
                                        placeholder="Blog Title" required="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Blog Image</label>
                                    <input class="form-control" type="file" accept="image/png, image/jpeg"
                                        value="{{$blog->image}}" name="image">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control editor" cols="30" rows="10" placeholder="Enter the description here." required="true">{{$blog->description}}</textarea>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary location-update-btn">Update Blog</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
</div>
<!-- /.row -->
<!-- /.content -->
</div>

@endsection

@section('scripts')
<script src="/assets/admin/plugins/summernote/summernote.js"></script>
<script>
    $(document).ready(function() {
    $('.editor').summernote();
    });
</script>
<!-- page script -->
@endsection