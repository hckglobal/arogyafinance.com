<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> <b>Assets</b></h3>
    </div>
    <div class="box-body">
        <div class="row">
        @foreach($application->assets as $asset)
            
                <div class="col-md-3">
                    <li>{{$asset->name}}</li>
                </div>                
            
        @endforeach    
        </div>
    </div>
</div>
