Borrower Name : {{$application->borrower->first_name}} {{$application->borrower->middle_name}} {{$application->borrower->last_name}}<br>
@if($application->pin_number!='')
PIN : {{$application->pin_number}}
@endif <br>
<br>
<a href="https://arogyafinance.com/admin/application/{{$application->type}}/detail/{{$application->id}}"> Click here to view application detail.
</a> 