@extends('admin.pages.application.sanction_letters.partial.layout')

@section('content')   
    <p style="margin-top:10px;">
        Collection error for your reference.
    </p>
    <p style="margin-top:10px;">
        <table  cellspacing="0" class="compact" border="1" align="center" cellpadding="1">
            <tbody>
                <tr class="table-heading" align="center" valign="center" >
                    <th>PIN</th>
                    <th>EMI Payment Date</th>
                    <th>Amount Received</th>
                    <th>Narration</th>
                    <th>Ref Number</th>
                    <th>Source</th>
                    <th>Type</th>
                    <th>Transcation No</th>
                </tr>
                @foreach($error_record as $error)
                <tr>
                  <td>{{$error['pin_number']}}</td>
                  <td>{{$error['emi_payment_date']}}</td>
                  <td>{{$error['amount_received']}}</td>
                  <td>{{$error['narration']}}</td>
                  <td>{{$error['ref_no']}}</td>
                  <td>{{$error['source']}}</td>
                  <td>{{$error['type']}}</td>
                  <td>{{$error['transaction_number']}}</td>
                </tr>
                @endforeach 
            </tbody>
        </table> 
    </p>     
@endsection