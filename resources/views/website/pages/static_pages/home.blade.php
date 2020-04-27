@extends('website.app')

@section('title')
Home Page
@endsection

@section('styles')

<script data-cfasync="false">
  (function(r,e,E,m,b){E[r]=E[r]||{};E[r][b]=E[r][b]||function(){
  (E[r].q=E[r].q||[]).push(arguments)};b=m.getElementsByTagName(e)[0];m=m.createElement(e);
  m.async=1;m.src=("file:"==location.protocol?"https:":"")+"//s.reembed.com/G-1PQpWA.js";
  b.parentNode.insertBefore(m,b)})("reEmbed","script",window,document,"api");
</script>
@endsection

@section('content')
<!-- <div class="overlay-snippet">
    <img src="/assets/images/christmas_banner.jpg" alt="Merry Christmas">
    <i class="fa fa-times" aria-hidden="true"></i>
</div> -->

<div class="top-padding">
    <div class="container-fluid">
    <!-- Slider main container -->
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/1.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/2.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/3.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/4.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/5.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/6.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/7.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/8.png" />
                </div>
                 <div class="swiper-slide">
                    <img class="img-responsive" src="/assets/images/slides/9.png" />
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
         
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
            <div class="swiper-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
         
            <!-- If we need scrollbar -->
            <!-- <div class="swiper-scrollbar"></div> -->
        </div>
    <!-- End of Slider main container -->
    </div>
</div>
<div class="count-custom">
    <!-- <div class="custom-heading">
        <h3>What makes us iconic</h3>
        <div class="divider">
            <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
        </div>       
    </div> -->
    <section id="fun-facts" class="fun-facts">
        <div class="layer" style="padding:10px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="fun-facts-box text-center pulse wow" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: pulse;">
                            <div class="text-center">
                               <i class="fa fa-flag" aria-hidden="true"></i><h1 class="fun-facts-count" id="countUpMe1" data-endVal="14">0</h1> 
                            </div>                            
                            <h5 class="">{{trans('home.state')}}</h5>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="fun-facts-box text-center pulse wow" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: pulse;">
                            <i class="fa fa-building-o" aria-hidden="true"></i>
                            <h1 class="fun-facts-count" id="countUpMe2" data-endVal="84">0</h1>
                            <h5 class="">{{trans('home.city')}}</h5>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="fun-facts-box text-center pulse wow" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: pulse;">
                            <i class="fa fa-hospital-o" aria-hidden="true"></i>
                            <h1 class="fun-facts-count" id="countUpMe3" data-endVal="650">0</h1>
                            <h5 class="">{{trans('home.hospitals')}}</h5>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </section>

    <section class="apply-now-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="apply-loan apply">
                        <div class="img-apply">
                            <img src="/assets/images/nurse2.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="content-apply">
                            <h4>{{trans('home.medical_loan')}}</h4>
                            <p>{{trans('home.medical_loan_note')}}</p>
                        </div>
                        <div class="apply-button-custom">
                            <a href="/apply/loan/personal-details?locale={{$locale}}">{{trans('home.apply_now')}}</a><i class="fa fa-paper-plane-o"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="apply-card apply">
                        <div class="img-apply">
                            <img src="/assets/images/img1.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="content-apply">
                            <h4>{{trans('home.arogya_card')}}</h4>
                            <p>{{trans('home.arogya_card_note')}}</p>
                        </div>
                        <div class="apply-button-custom">
                            <a href="/apply/card/personal-details?locale={{$locale}}">{{trans('home.apply_now')}}</a><i class="fa fa-paper-plane-o"></i>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>  
    </section>
</div>

@if($locale=='en')
    <div class="common-surgeries">
        <div class="custom-heading">
            <h3>common surgeries we finance</h3>
            <!-- <p>disease related key words to be put here</p> -->
            <div class="divider">
                <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-physical-therapy" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Orthopedics Surgeries</h3>
                        <p>Joint Replacement</p>
                        <p>Arthroscopy</p>
                        <p>Carpel Tunnel Release</p>
                        <p>Revision Joint Surgery</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-cardiology" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Cardiology</h3>
                        <p>Angiography</p>
                        <p>Angioplasty</p>
                        <p>Valve Replacement</p>
                        <p>Bypass(CABG)</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-nursery" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Obs &amp; Gynaec</h3>
                        <p>Polypectomy</p>
                        <p>cervical biopsy</p>
                        <p>diagnostic Hysterosopy</p>
                        <p>diagnostic Laprotomy</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-internal-medicine" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Gastroenterology</h3>
                        <p>Gastroscopy Diagnostic</p>
                        <p>colonoscopy Diagnostic</p>
                        <p>Gastroscopy Theaupetic</p>
                        <p>colonoscopy Theaupetic</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-social-services" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Transplant</h3>
                        <p>Renal</p>
                        <p>liver</p>
                        <p>Heart</p>
                        <p>Transplant</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-kidney" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Urology</h3>
                        <p>Cystoscopy</p>
                        <p>Uretoscopy</p>
                        <p>Nephrectomy</p>
                        <p>Prostatectomy</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-infectious-diseases" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>Cosmetic Surgery</h3>
                        <p>Liposuction</p>
                        <p>Breast Lift</p>
                        <p>Breast Augmentation</p>
                        <p>Nose Reshaping</p>
                    </div>
                </div></div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4">
                <div class="owl-item cloned"><div class="single-item text-center">
                    <div class="iocn-holder">
                        <span class="medical-icon-administration" aria-hidden="true"></span>   
                    </div>
                    <div class="text-holder">
                        <h3>spine</h3>
                        <p>Laminectomy</p>
                        <p>Discectomy</p>
                        <p>Spinal Decompression Surgery</p>
                        <p>Spinal Fusion</p>
                    </div>
                </div></div>
            </div>
        </div>
    </div>
   
    <!--  <div class="form2">
    <form>
    <a href="/apply/loan/personal-details"><button class="button button-navy-blue send-contact" type="button">Apply For Loan</button></a>
    <a href="/apply/card/personal-details"><button class="button button-navy-blue send-contact" type="button">Apply For Card</button></a>
    <a href="/login   "><button class="button button-navy-blue send-contact" type="button">Complete Your Application</button></a>
    <a href="/contact"><button class="button button-navy-blue send-contact" type="button">Contact Us</button></a>
    </form>
    </div> -->
    
    <section class="about-us">

        <div class="center">
        
            <div class="green-line">
            </div>
        
            <div class="left">
            
                <h2>About Arogya</h2>
                
                <p>Arogya Finance, co-founded by Mr. Jose Peter and Mr. Dheeraj Batra, is a social health care venture,
                    which offers medical loans to the traditionally<br> un-bankable, using innovative risk assessment tools that   
                    allows them to finance people outside the formal banking system. Patients borrow from and repay
                    Arogya Finance directly leaving them free to get treated wherever they choose to do so. <br>
                    We have been recognized as one of India’s most exciting social innovations by:</p>

                <div class="timeline">
                
                    <div class="timeline-element">
                    
                        
                        <p>Innovations in health care; a Washington DC based organisation, co-founded by Duke Medicine , Mckinsey and Company and the World Economic Forum</p>
                    
                    </div>
                    
                   
                    
                    <div class="timeline-element">
                    
                        <p>Social Entrepreneurship Accelerator at Duke (SEAD), an initiative of the Duke University</p>
                    
                    </div>

                    <div class="timeline-element">
                    
                        <p>Artha Venture Challenge</p>
                    
                    </div>
                    <div class="timeline-element">
                    
                        <p>IDEX Accelerator</p>
                    
                    </div>                                
                </div>

            </div>
        
            <div class="right">
            
                <div class="images-slider">
                
                    <div class="images-slider-change">
                    
                        <div class="images-slider-prev"><i class="fa fa-angle-left"></i></div>
                        <div class="images-slider-next"><i class="fa fa-angle-right"></i></div>
                    
                    </div>
                
                    <div class="images-slider-single" style="background-image: url( '/assets/images/partner-grid.jpg' );background-position: center;">
                    </div>
                    
                    <div class="images-slider-single" style="background-image: url( '/assets/images/partner-grid.jpg' );background-position: center;">
                    </div>
                
                </div>
                
            </div>
            
            <div class="clear">
            </div>
        
        </div>

    </section>

    <section class="references">
        <div class="slider1">
           <div class="slide">
                 <div class="center" id="padding-null">
                    <div class="left">
                        <h3>Testimonial</h3>
                        <h2>Doctor Testimonials</h2>
                        <p>Bariatric Surgery is a high end surgery with major costs involved in the same. It has been seen that majority of the patients who 'do not' undergo Bariatric Surgery is not because they cannot afford the surgery, but because they cannot spend the amount 'at once'.
                            In India, another concern is Insurance nonsupporting the cause of obese patients.
                        </p>
                        <p>
                            To rescue of many, certain Finance companies have come forth to support the obese patients supporting their cause of getting operated for Bariatric Surgery (Weight Loss Surgery).
                        </p>
                        <p>
                            Arogya Finance has been a front runner in working out a model wherein patient pays only 50% amount of the surgery during admission and the remaining has to be paid in installments.
                        </p>
                    </div>
                    <div class="right">
                        <!-- <div class="references" style="min-height: 204px; margin-top: 105px;">
                            <div class="single-reference" data-reference-id="1" style="display: block;">
                                <div class="single-reference-content">
                                    <p>Proin et posuere dolor, a finibus tellus. Phasellus suscipit gravida magna. Nam posuere nisi eu ex sodales, sit amet dictum turpis maximus. Maecenas sodales vehicula tellus, at imperdiet risus.</p>
                                </div>
                                <div class="single-reference-author">
                                    <strong>Anthony Smith</strong>October 12, 2014
                                </div>
                            </div>
                            <div class="single-reference" data-reference-id="2" style="display: none;">
                                <div class="single-reference-content">
                                    <p>Quisque pharetra lorem quis libero ornare fringilla. Maecenas nisl justo, suscipit vel tortor at, varius auctor erat. Maecenas efficitur felis nec arcu volutpat lacinia.</p>
                                </div>
                                <div class="single-reference-author">
                                    <strong>Susane Doe</strong>January 05, 2015
                                </div>
                            </div>
                        </div> -->

                        <div class="video-testimonials">
                             <div class="videowrapper">
                                <iframe width='560' height='345' src='https://embed.reembed.com/player/1RYgr-23bXZl2uKVuP1NefyQ'></iframe>
                             </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
           </div>
           
        </div>    
    </section>

    <!-- <section class="slogan section-gray-top">

        <div class="center">
        
            <i class="fa fa-bar-chart-o background-icon"></i>

            <div class="left">
            
                <h2>Our Belief</h2>
                
                <blockquote>
                
                    <p>Every Indian deserves quality healthcare</p>
                
                </blockquote>
            
            </div>
            
            <div class="right">
            
                <div class="key-number-values">
                    
                    <div class="single single-top single-left">
                    
                        <span class="number">1294</span>
                        <span class="description">No of loans</span>
                    
                    </div>
                    
                    <div class="single single-top single-right">
                    
                        <span class="number">5</span>
                        <span class="description">Amount disbursed</span>
                    
                    </div>
                    
                    <div class="single single-bottom single-left">
                    
                        <span class="number">8</span>
                        <span class="description">Pharma/Hospital tie-up</span>
                    
                    </div>
                    
                    <div class="single single-bottom single-right">
                    
                        <span class="number">12</span>
                        <span class="description">Years of experience</span>
                    
                    </div>
                
                </div>
            
            </div>
            
            <div class="clear">
            </div>
        
        </div>

    </section>
    -->    

    <section class="image-slogan with-parallax" style="background-image: url( '/assets/images/hcare1.jpg' );">

        <div class="flying-1">
        
            <span>Hospital Network</span>
        
        </div>
        
        <div class="flying-2">
        
            <h3></h3>
            <p>Treatment can be availed at any hospital of your choice</p>
            <p>Walk into any of our esteemed hospital partners and avail quality health care and special interest rates.</p>

            <a href="/hospital-partners"><button class="button button-white" data-action="show-quote-popup" data-quote-key="life-insurance">See all<i class="fa fa-paper-plane-o"></i></button></a>
        
        </div>

    </section>
@endif
<section class="contact section-gray">
    <div class="row contact-details">
        <div class="col-md-7">
            <div class="col-md-6">
                 <div class="contact-detail-single">
            
                <h3><i class="fa fa-map-marker"></i> {{trans('home.company_info')}}</h3>
                <p class="without-margin-bottom"><strong>{{trans('home.corporate_office')}}</strong></p>
                <p>{{trans('home.corporate_address_1')}}<br>{{trans('home.corporate_address_2')}}</p>
                <p class="without-margin-bottom"><strong>{{trans('home.reg_office')}}</strong></p>
                <p >{{trans('home.reg_address')}}</p>
                
            </div>
            </div>
            <div class="col-md-6">
                <div class="contact-detail-single">
            
                <h3><i class="fa fa-envelope-o"></i> {{trans('home.contact_detail')}}</h3>
                <p>{{trans('home.email_title')}} : <br/><a href="mailto:info@arogyafinance.com">info@arogyafinance.com</a></p>     
                <p class="without-margin-bottom">{{trans('home.telephone')}} : 022 2839 2488 <br/>
                 <b>{{trans('home.hotline_no')}} : +91 976 920 5032</b>
                </p>             
            </div>
            </div>
            <div class="col-md-12">
                <p><b>"{{trans('home.arogya_note')}}" <br> {{trans('home.cin')}} : U65910MH1995PTC089442</b></p>
            </div>
        </div>
        <div class="col-md-5">
            <div class="contact-detail-single contact-detail-single-last">
            
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30159.088804334926!2d72.85234990473663!3d19.11265204173147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c83ea8b9a6b1%3A0x199349ec65d4f837!2sRamtirth+Leasing+and+Finance+Company+Private+Limited!5e0!3m2!1sen!2sin!4v1461069928013" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>
        </div>
    </div>
<!-- 
    <div class="center">
    
        <i class="fa fa-envelope-o background-icon"></i>
        <div class="contact-details">

         <div class="contact-detail-single">
            
                <h3><i class="fa fa-map-marker"></i> Company information</h3>
                <p class="without-margin-bottom"><strong>Corporate Office</strong></p>
                <p >102,Meadows, Sahar Plaza, <br>Andheri-Kurla Road, J.B. Nagar,Andheri (East) Mumbai – 400 059</p>
                <p class="without-margin-bottom"><strong>Registered Office</strong></p>
                <p >31, Mystique, Plot No. 129, St. Cyril Road, Off Turner Road, Bandra(W), Mumbai - 400 050</p>
                <p><b>"Arogya Finance is the Brand name of Ramtirth Leasing and Finance Company Pvt. Ltd. an NBFC registered with Reserve Bank of India under RBI Registration No.: 13.01234" <br> CIN: U65910MH1995PTC089442</b></p>
            </div>

            <div class="contact-detail-single">
            
                <h3><i class="fa fa-envelope-o"></i> Contact details</h3>
                <p>E-mail address: <br/><a href="mailto:info@arogyafinance.com">info@arogyafinance.com</a></p>     
                <p class="without-margin-bottom">Tel: 022 2839 2488 <br/>
                 <b>Hotline No: +91 976 920 5032</b>
                </p>             
            </div>
            
            
        
        </div>

    </div> -->

</section> 
@endsection
    

  

