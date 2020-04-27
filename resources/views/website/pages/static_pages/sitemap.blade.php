@extends('website.app')

@section('title')
Sitemap
@endsection

@section('content')
<section class="contact-full section-top-space">
    
        <div class="center">
        
            <div class="green-line">
            </div>
        
            <div class="left">

                <h2>Send us an email!</h2>
                <p>Donec eget elit vitae tortor convallis mattis. Aliquam erat volutpat. Integer vitae quam ut leo accumsan consequat eu ac sapien. Quisque tincidunt leo enim, in pulvinar felis consectetur ac.</p>
            
                <form method="post" class="form">

                    <input type="text" name="Name" placeholder="Your name..." class="contact-form-element contact-form-client-name" />
                    <input type="text" name="Phone number" placeholder="Your phone number..." class="contact-form-element last" />
                    <input type="text" name="E-mail" placeholder="Your e-mail..." class="contact-form-element contact-form-client-email" />
                    <input type="text" name="Title" placeholder="E-mail title..." class="contact-form-element contact-form-client-message-title last" />

                    <textarea name="Message" rows="5" cols="5" placeholder="Your message..." class="contact-form-element"></textarea>
                    <button class="button button-navy-blue send-contact" type="button">Send a message! <i class="fa fa-paper-plane-o"></i></button>
                    
                    <div class="contact-form-thanks">
                            
                        <div class="contact-form-thanks-content">
                        
                            Your message has been sent successfully. 
                            <span class="contact-form-thanks-close">Close this notice.</span>
                        
                        </div>
                    
                    </div>    
                                                                         
                </form>
            
            </div>
        
            <div class="right">
                <div id="google-map-full" data-lat="37.42565" data-lng="-122.13535" data-zoom-level="12">
                </div>
                
            </div>
            
            <div class="clear">
            </div>
        
        </div>
    
    </section>
@endsection