<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i>&nbsp;PDC Report for period of {{$date}}</h3>
    </div>
    <div class="box-body">
    <table border="1" bordercolor="black" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Date</th>  
                    <th>Name of Borrower issuing the repayment cheque</th>
                    <th>Cheque Number</th>
                    <th>Bank Name</th>
                    <th>Branch</th>
                    <th>Amount</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pdcs as $pdc)
                  @foreach($pdc as $pdc_key=>$pdc_value)  
                  <tr height="20"> 
                      <td>
                          @if($pdc_value->getOriginal('cheque_date')!="0000-00-00")
                           {{date('d-m- Y',strtotime($pdc_value->cheque_date))}}
                          @endif
                      </td> 
                      <td>{{$pdc_value->borrower_name}}</td>
                      <td>{{$pdc_value->cheque_number}}</td>
                      <td>{{$pdc_value->bank_name}}</td>
                      <td>{{$pdc_value->branch}}</td>
                      <td><span style="font-family: DejaVu Sans; sans-serif;"> &#8377; </span>
                          {{$pdc_value->amount}}
                      </td>
                      <td>{{$pdc_value->type}}</td>           
                  </tr>
                  @endforeach
                @endforeach                
            </tbody>
        </table>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>