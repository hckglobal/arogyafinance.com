@extends('website.app')

@section('title')
Careers
@endsection

@section('styles')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<section class="quote-forms section-top-space section-gray" id="contact-form">

        <div class="center" id="session">
        @if(Session::has('info'))
            <span class="alert-success">{!! Session::get('info') !!}</span>
        @endif
            <div class="quote-form-background" style="width: 655.75px; margin-left: -124.25px; height: 524px; background-image: url(/assets/images/family.jpg);">
            </div>
            
            <div class="quote-form-content">
                <h2>Careers at<span> Arogya Finance</span></h2>
                <div class="form">

                    <h4>Your Info:*</h4>
                    <form method="post" action="/careers" enctype='multipart/form-data'> 
                    <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                    <input type="text" class="quote-form-element" name="first_name" placeholder="First name...">
                    <input type="text" class="quote-form-element last" name="last_name" placeholder="Last name...">

                    <h4>Contact Info:*</h4>
                    <input type="text" class="quote-form-element" name="phone" placeholder="Phone number...">
                    <input type="text" class="quote-form-element last" name="email" placeholder="Email Id...">
                
                    <h4>Address:*</h4>
                    <textarea name="address" rows="5" cols="5" placeholder="Your message..." class="contact-form-element"></textarea>

                    <h4>City:*</h4>
                    <input type="text" class="quote-form-element quote-form-element1" name="city" placeholder="City">

                    <h4>State *:</h4>                    
                    <span class="custom-dropdown last">
                        <select name="state" class="custom-dropdown-select quote-form-element">
                            <option value="-">-- Select State --</option>
                            @foreach($states as $state)
                            <option value="{{$state->name}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </span>

                    <h4>Postal Code:*</h4>
                    <input type="text" class="quote-form-element quote-form-element1" name="pincode" placeholder="Postal Code">

                    <h4>Department of Interest *:</h4>                    
                    <span class="custom-dropdown last">
                    
                        <select name="department" class="custom-dropdown-select quote-form-element">
                            <option value="-">-- Select One --</option>
                            <option value="Sales">Sales</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Finance">Finance</option>
                            <option value="Credit">Credit</option>
                        </select>
                    </span>

                     <h4>Resume :*</h4>
                     <input type="file" class="quote-form-element quote-form-element1" name="resume">    

                     <div class="g-recaptcha" data-sitekey="6LdclAgUAAAAALawSydJ-FRTjvPClJi9qlG5APKc"></div>

                    <button class="button button-navy-blue send-quote" type="submit">Submit <i class="fa fa-paper-plane-o"></i></button>
                    </form>
                </div>

            </div>
            
            <div class="clear">
            </div>

        </div>

    </section>
    <section class="contact section-gray">
    
        <div class="center">
        
            <i class="fa fa-envelope-o background-icon"></i>
            <div class="contact-details">

                <div class="contact-detail-single">
                
                    <h3><i class="fa fa-map-marker"></i> Company informations</h3>
                    <p><b>Arogya Finance</b> is the brand name  of Ramtirth Leasing and Finance Company Pvt. Ltd.</p>
                    <p class="without-margin-bottom"><strong>Corporate Office</strong></p>
                    <p >102, The Meadows, Sahar Plaza, <br>Andheri-Kurla Road, J.B. Nagar,Andheri (East) Mumbai – 400 059</p>
                    <p class="without-margin-bottom"><strong>Registered Office</strong></p>
                    <p >31, Mystique, Plot No. 129, St. Cyril Road, Off Turner Road, Bandra(W), Mumbai - 400 050</p>
                    <p><b>CIN: U65910MH1995PTC089442 <br/> RBI Registration NO: 13.01234</b></p>
                </div>

                <div class="contact-detail-single">
                
                    <h3><i class="fa fa-envelope-o"></i> Contact details</h3>
                    <p>E-mail address: <br/><a href="mailto:info@arogyafinance.com">info@arogyafinance.com</a></p>     
                    <p class="without-margin-bottom">Tel: 022 2839 2488 <br/>
                     <b>Hotline No: +91 976 920 5032</b>
                    </p>             
                </div>
                
                <div class="contact-detail-single contact-detail-single-last">
                
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30159.088804334926!2d72.85234990473663!3d19.11265204173147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c83ea8b9a6b1%3A0x199349ec65d4f837!2sRamtirth+Leasing+and+Finance+Company+Private+Limited!5e0!3m2!1sen!2sin!4v1461069928013" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>
            
            </div>

        </div>
    </section> 
@endsection

