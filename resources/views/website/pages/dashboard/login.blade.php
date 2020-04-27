@extends('website.app')

@section('title')
Login
@endsection

@section('body-id'){{'about-us'}}@endsection

@section('content')
<section class="box-with-image-right section-top-space">
    <div class="center">
        <div class="green-line">
        </div>
        <div class="content" style="text-align:center; margin-bottom:5%;">
            <h2>{{$title}}</h2>
            <span class="error"></span>
            <br>
            <form id="login" class="form">
                <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                <input type="hidden" name="next" value="{{Request::get('next')}}">
                <input type="text" required class="quote-form-element quote-form-element1" name="reference_code" placeholder="Reference Code">
                <button class="button button-navy-blue" type="submit">Login</button>
            </form>
        </div>
</section>
@endsection @section('script')
<script type="text/javascript">
$("#login").submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "login",
        data: $(this).serialize(),
        success: function(data) {
            window.location = data;
        },
        // vvv---- This is the new bit
        error: function(jqXHR, textStatus, errorThrown) {
            $('span.error').html('Invalid reference code');
        }
    });

});
</script>
@endsection
