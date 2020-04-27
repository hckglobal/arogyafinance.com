@extends('website.app')

@section('title')
Psychomrtric Test Check
@endsection

@section('styles')
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
@endsection


@section('body-id'){{'about-us'}} @endsection

@section('content')
<section class='paddingtop-class' style='height:500px'>
    <div class="container">
        <div class="col-md-12 text-center custom-language-title">
            <p style="font-family: 'Signika';font-size:28px;align:center; padding-bottom:30px;color:#676f73;">Are you the borrower of this loan?</p>
            <form action="/eligibility/self-psychometric/{{$application_id}}" method="post">        
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="application_id" value={{$application_id}}>
                <div class="row  text-center">
                    <div class="col-md-4"></div>
                    <div class='col-md-2 col-xs-4 ln-color text-center'>
                        <div class="custom-language">
                            <input name="self_borrower" value="yes" type="radio" id="yes" required>
                            <label for="yes"> Yes, I'm the borrower</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input name="self_borrower" value="no" type="radio" id="no" required>
                            <label for="no"> No, I'm not the borrower</label>
                        </div>
                    </div>                    
                </div>       
                <div class="row">
                    <div class='col-md-12 ln-color' align="center">
                        <input class="btn btn-primary btn-outline" type="submit" value="Submit">
                    </div>
                </div>        
            </form>
        </div>
    </div>
</section>
@endsection
