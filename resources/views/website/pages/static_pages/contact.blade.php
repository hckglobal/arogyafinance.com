@extends('website.app')

@section('title')
Contact Us
@endsection

@section('styles')
<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
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
            <h2>Send us an<span> Email</span></h2>
            <div class="form">
                <h4>Your Info:*</h4>
                <form method="post" action="/contact"> 
                    <input type="hidden" name="_token" value="{{csrf_token()}}"> 
                    <input type="text" class="quote-form-element" name="first_name" placeholder="First name..." required>
                    @if ($errors->has('first_name'))
                        <div class="error">{{ $errors->first('first_name') }}</div>
                    @endif
                    <input type="text" class="quote-form-element last" name="last_name" placeholder="Last name..." required>
                    @if ($errors->has('last_name'))
                        <div class="error">{{ $errors->first('last_name') }}</div>
                    @endif
                    <h4>Contact Info:*</h4>
                    <input type="text" class="quote-form-element" name="phone" placeholder="Phone number..." required>
                    @if ($errors->has('phone'))
                        <div class="error">{{ $errors->first('phone') }}</div>
                    @endif
                    <input type="text" class="quote-form-element last" name="email_id" placeholder="Email Id..." required>
                    @if ($errors->has('email_id'))
                        <div class="error">{{ $errors->first('email_id') }}</div>
                    @endif
                    <h4>Location:*</h4>
                    <input type="text" class="quote-form-element quote-form-element1" name="location" placeholder="" required>
                    @if ($errors->has('location'))
                        <div class="error">{{ $errors->first('location') }}</div>
                    @endif
                    <h4>Enquiry Type:</h4>                
                    <span class="custom-dropdown last">
                        <select name="loan_type" class="custom-dropdown-select quote-form-element" required>
                            <option value="-">-- Select One --</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Medical Loan">Medical Loan</option>
                            <option value="Associate/Partner Request">Associate/Partner Request</option>
                        </select>                
                    </span>                
                    <h4>Subject:*</h4>
                    <input type="text" class="quote-form-element quote-form-element1" name="subject" placeholder="" required>
                    @if ($errors->has('subject'))
                        <div class="error">{{ $errors->first('subject') }}</div>
                    @endif

                    <h4>Message:*</h4>
                    <textarea name="message" rows="5" cols="5" placeholder="Your message..." class="contact-form-element" required></textarea>
                    @if ($errors->has('message'))
                        <div class="error">{{ $errors->first('message') }}</div>
                    @endif
                    
                        {!! NoCaptcha::display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block" style="font-size: 14px;">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    <button class="button button-navy-blue send-quote" type="submit">Send a message<i class="fa fa-paper-plane-o"></i></button>
                </form>
            </div>
        </div>
        <div class="clear"></div>
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
{!! NoCaptcha::renderJs() !!}
@endsection