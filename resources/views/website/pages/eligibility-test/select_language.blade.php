@extends('website.app')

@section('title')
Select Language Page
@endsection

@section('styles')
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
@endsection


@section('body-id'){{'about-us'}} @endsection

@section('content')
<section class='paddingtop-class' style='height:500px'>
    <div class="container">
        <div class=" col-md-10 col-md-offset-2 custom-language-title">
            <p style="font-family: 'Signika';font-size:28px;align:center; padding-bottom:30px;color:#676f73;">Select A Language</p>
            <form action="{{$test_link}}" method="post">        
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="api_token" value={{env('PSYCHOMETRIC_TEST_API_TOKEN')}}>
                <input type="hidden" name="username" value={{$reference_code}}>
                <div class="row">
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input name="locale" value="en" type="radio" id="locale-en">
                            <label for="locale-en">English</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">                            
                            <input type="radio" name="locale" value="hi" id="locale-hi">
                            <label for="locale-hi">हिंदी</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input type="radio" name="locale" value="mr" id="locale-mr">
                            <label for="locale-mr">मराठी</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">                            
                            <input type="radio" name="locale" value="gu" id="locale-gu">
                            <label for="locale-gu">ગુજરાતી</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input type="radio" name="locale" value="bn" id="locale-bn">
                            <label for="locale-bn">বাঙালি</label>
                        </div>
                    </div>                    
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input type="radio" name="locale" value="kn" id="locale-kn">
                            <label for="locale-kn">ಕನ್ನಡ್</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input type="radio" name="locale" value="ml" id="locale-ml">
                            <label for="locale-ml">മലയാളം</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input type="radio" name="locale" value="ta" id="locale-ta">
                            <label for="locale-ta">தமிழ்</label>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-4 ln-color'>
                        <div class="custom-language">
                            <input type="radio" name="locale" value="te" id="locale-te">
                            <label for="locale-te">తెలుగు</label>
                        </div>
                    </div>                    
                </div><br>        
                <div class="row">
                    <div class='col-md-10 ln-color btn btn-lg' align="center">
                        <input class="btn btn-primary btn-outline" type="submit" value="Submit">
                    </div>
                </div>        
            </form>
        </div>
    </div>
</section>
@endsection
