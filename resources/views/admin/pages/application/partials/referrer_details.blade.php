<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i><b>Referrer Details</b></h3>
    </div>
    <div class="box-body">
        <div class="row">
            
            <div class="col-md-4">
                <b>Referrer Id</b> : {{$application->referrer_id}}
                <br>
                <b>Referrer Name</b> : {{$application->referrer->name}}
                <br>
                <b>Referrer Description</b> : {{$application->referrer->description}}
                <br>
            </div>
            <div class="col-md-4">
                <b>Unique Id</b> : {{$application->referrer->uid}}
                <br>
                <b>Affiliate Name </b> : {{$application->referrer->affiliate->name}}
                <br>
            </div>
          
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>