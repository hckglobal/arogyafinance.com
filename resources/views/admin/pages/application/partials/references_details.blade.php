<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i><b>Referrer Details</b></h3>
    </div>
    <div class="box-body">
    @if($application->references->count()<=1)
    <pre> Minimum two references are required</pre>
    @endif
        <div class="row">
            @foreach($application->references as $reference)
                <div class="col-md-4">
                    
                    <b>Relation</b> : {{$reference->relation}}
                    <br>
                    <b>Name</b> : {{$reference->name}}
                    <br>
                    <b>Mobile Number</b> : {{$reference->mobile_number}}
                    <br>
                    <b>Address</b> : {{$reference->address}}
                    <br>
                </div>
            @endforeach    
        </div>    
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>