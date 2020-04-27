
        <div class="box box-default capitalize-field">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i><b>Family Details</b> </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    @foreach($application->familyMembers as  $key=>$family)
                    <div class="col-md-4">
                         <b> {{++$key}}) Name</b> : <span>{{$family->first_name}} {{$family->last_name}} ({{$family->relation}})</span>
                    </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
     