<div class="box box-default no-print">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-paperclip"></i><b> Documents</b></h3>
                @if($application->documents->count()>0  && !$application->getOldDocuments())
                <a href="/admin/application/download-documents/{{$application->id}}" class=" pull-right btn btn-primary">Download Zip</a>
                @endif
            </div>
            <div class="box-body text-center">
                <div class="row">
                    @if(File::exists(public_path()."/documents/".$application->id."/cibil_report.html"))
                    <div class="col-md-3">
                            <b>CIBIL Report</b>
                            <br>
                            <a href="/documents/{{$application->id}}/cibil_report.html">
                                <button class="btn btn-primary airy"><i class="fa fa-download"></i> View </button>
                            </a>
                    </div>
                    <div class="clearfix"></div>
                    @endif
                    <form action="/documents/delete-documents" method="POST">
                        {{ csrf_field() }}
                    <div class="document-download-custom text-left">
                        @forelse($application->documents as $document)
                            @if(File::exists(public_path()."/documents/".$application->id."/".$application->getDocument($document->type)->file))
                            <div class="col-md-6" style="padding: 5px;">
                                <div class="document-download-custom-design">
                                    <div class="col-md-9">
                                        <div class="row" >
                                            <div class="col-md-1">
                                                @if(Entrust::can('remove-documents'))  
                                                    <input id="{{$document->id}}" type="checkbox" 
                                                    name="documents[]" value="{{$document->id}}">
                                                 @endif
                                            </div>
                                            <div class="col-md-10">
                                                <label class="label-pointer" for="{{$document->id}}">{{$document->name}} ({{$document->type}})</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" >
                                        <a class="btn btn-primary " href="/documents/{{$application->id}}/{{$application->getDocument($document->type)->file}}" download><i class="fa fa-download"></i> Download </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                                @forelse($application->getOldDocuments() as $documents)
                                    @foreach($documents as $key=>$document)
                                    <div class="col-md-6" style="padding: 10px;">
                                        <div class="document-download-custom-design">
                                            <div class="col-md-9">
                                                <div class="row" >
                                                    <div class="col-md-10">
                                                        <label class="label-pointer">{{basename($document)}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3" >
                                                <a class="btn btn-primary " href="https://arogyafinance.s3.ap-south-1.amazonaws.com/{{$document}}" download target="_blank"><i class="fa fa-download"></i>Download</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @empty
                                @endforelse
                        @endforelse
                        @if(Entrust::can('remove-documents'))  
                        @if($application->documents->count()>0 && !$application->getOldDocuments())
                        <div class="col-md-12">
                            <div class="delete-documents-custom">
                                <button type="submit" class="btn btn-danger">Delete Selected Documents</button>
                            </div>
                        </div>
                        @endif
                        @endif
                        
                        
                    </div>
                    </form>
                   <!--  @foreach($application->documents as $document)
                     <div class="col-md-3">
                            <b>{{$document->name}} ({{$document->type}})</b>
                            <br>
                            <a href="/documents/{{$application->id}}/{{$document->file}}" download>
                                <button class="btn btn-primary airy"><i class="fa fa-download"></i> Download </button>
                            </a>

                     </div>
                     @endforeach -->
                </div>
                <!-- /.row -->
            </div> 
            <!-- /.box-body -->
        </div>
