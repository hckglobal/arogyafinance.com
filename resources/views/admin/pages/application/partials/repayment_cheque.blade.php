<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i>&nbsp;<b>Repayment Cheque Details</b></h3>
    </div>
    <div class="box-body">
        <table border="1" bordercolor="black" cellspacing="0" width="100%">
            <thead>
                <tr>
               	    <th><center>Date</center></th> 	
                    <th><center>Name of Borrower issuing the repayment cheque</center></th>
                    <th><center>Cheque Number</center></th>
                    <th><center>Bank Name</center></th>
                    <th><center>Branch</center></th>
                    <th><center>Amount</center></th>
                    <th><center>Type</center></th>
                    <th><center>Action</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach($application->repaymentCheques->sortBy('cheque_date') as $repaymentCheque)
                <tr height="20"> 
                    <td align="center">
                        @if($repaymentCheque->getOriginal('cheque_date')=="0000-00-00")
                        <a href="#" class="datetime" data-name="cheque_date" data-type="date" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Select cheque date">
                        </a>
                        @else
                        <a href="#" class="datetime" data-name="cheque_date" data-type="date" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Select cheque date"> {{date('d-m- Y',strtotime($repaymentCheque->cheque_date))}}
                        </a>
                        @endif
                    </td>	
                    <td align="center">
                        <a href="#" class="editable-click inline-edit" data-name="borrower_name" data-type="text" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Enter borrower name">
                            {{$repaymentCheque->borrower_name}}
                        </a> 
                    </td>
                    <td align="center">
                        <a href="#" class="editable-click inline-edit" data-name="cheque_number" data-type="text" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Enter cheque number">
                            {{$repaymentCheque->cheque_number}}
                        </a>
                    </td>
                    <td align="center">
                        <a href="#" class="editable-click inline-edit" data-name="bank_name" data-type="text" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Enter bank name">
                            {{$repaymentCheque->bank_name}}
                        </a>
                    </td>
                    <td align="center">
                        <a href="#" class="editable-click inline-edit" data-name="branch" data-type="text" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Enter branch name">
                            {{$repaymentCheque->branch}}
                        </a>
                    </td>
                    <td align="center"><span style="font-family: DejaVu Sans; sans-serif;"> &#8377; </span>
                        <a href="#" class="editable-click inline-edit" data-name="amount" data-type="text" 
                            data-pk="{{$repaymentCheque->id}}" data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}" data-title="Enter cheque amount">
                            {{$repaymentCheque->amount}}
                        </a>
                    </td>
                    <td align="center">
                        <a href="#" class="cheque_type editable-click" 
                        data-name="type" 
                        data-type="select" data-pk="{{$repaymentCheque->id}}"
                        data-url="/admin/application/repayment-cheque/edit/{{$repaymentCheque->id}}"
                        sourceCache="false" 
                        data-title="Enter cheque type">
                        {{$repaymentCheque->type}}
                    </a>
                    </td>                   
                    <td align="center">
                        @if(Entrust::can('delete-repayment-cheque'))
                        <a href="/admin/application/delete-repayment-cheque/{{$repaymentCheque->id}}" data-toggle="tooltip" data-placement="top" title="Delete Cheque"><i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                        @else
                        --
                        @endif
                    </td>
                </tr>
                @endforeach                
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>