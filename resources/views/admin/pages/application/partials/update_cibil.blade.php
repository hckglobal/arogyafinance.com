@if($application->cibil_score==-100)
    <div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-info-circle"></i><b> Update Cibil</b></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <form action="/admin/application/{{$application->type}}/update/{{$application->id}}" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}"> Cibil Score: &nbsp;
                <input type="text" name="cibil_score" placeholder="Cibil Score"> &nbsp;
                <button class="btn btn-primary airy" type="submit" style="margin-right: 5px;"><i class="fa fa-download"></i> Update</button>
            </form>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
    </div>
@else
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-info-circle"></i><b> Cibil Score</b></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <b>Cibil score</b> : {{$application->cibil_score}}
                </div>
            </div>
        </div>
    </div>
@endif
