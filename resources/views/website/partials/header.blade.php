 <header>

    <div class="container-fluid hidden-sm hidden-xs" >
        <div class="row">
            <div class="col-md-2">
                <a href="/" class="logo"><img src="/assets/images/logo2.jpg" alt="Insurance Agency"  /></a>
            </div> 
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12 padding-no">
                        <section class="topbar">
                            <!-- <div class="col-md-3 text-center">
                                <ul class="social-icons">
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                                </ul>
                            </div> -->
                            <div class="col-md-3 text-center">
                                <span id="arogya-number">
                                    <a href="tel:+91 9769205032">
                                        <i class="fa fa-phone-square"></i> +91 9769205032
                                    </a>
                                </span>
                            </div>
                            <div class="col-md-5 text-center">
                                <ul class="social-icons select-language">
                                    <li><a href="/locale/en">English</a></li>
                                    <li><a href="/locale/hi">हिंदी</a></li>
                                    <li><a href="/locale/gu">ગુજરતી</a></li>
                                    <li><a href="/locale/bn">বাঙালি</a></li>
                                    <li><a href="/locale/kn">ಕನ್ನಡ್</a></li>
                                    <li><a href="/locale/ml">മലയാളം</a></li>
                                    <li><a href="/locale/ta">தமிழ்</a></li>
                                    <li><a href="/locale/te">తెలుగు</a></li>
                                </ul>
                            </div>
                                                        
                            <div class="col-md-4">
                                <div class="apply-here text-center">
                                    <button type="button" class="btn-custom" data-toggle="modal" 
                                        data-target="#myModal">{{trans('home.apply_here')}}
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 padding-no">
                        <div class="header-custom">
                            @if($locale=='en')
                            <div class="col-md-12 header-custom-nav">
                                <div class="center" style="margin:0;">
                                    <nav>
                                        <ul class="menu">
                                            <li><a href="/" class="active">Home</a></li>
                                            <!-- <li>
                                                <a href="/how-it-works">How it Works</a>
                                            </li> -->
                                            <li>
                                                <a href="javascript:;">About Us</a>
                                                <i class="fa fa-caret-down"></i>
                                                <ul class="submenu animated speed fadeInDown">
                                                    <li><a href="/ceo-speaks">CEO Speaks</a></li>
                                                    <li><a href="/our-board">Our Board</a></li>
                                                    <li><a href="/advisory-board">Advisory Board</a></li>
                                                    <li><a href="/management">Our Management</a></li>
                                                    <!-- <li><a href="#">The Brand</a></li> -->

                                                </ul>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Products</a>
                                                <i class="fa fa-caret-down"></i>
                                                <ul class="submenu animated speed fadeInDown">
                                                    <!-- <li><a href="/news-room">News Room</a></li> -->
                                                    <li><a href="/apply/loan/personal-details?locale={{$locale}}">Standard Loan</a></li>
                                                    <li><a href="/apply/card/personal-details?locale={{$locale}}">Pre-approved Loan</a></li>

                                                </ul>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Partners</a>
                                                <i class="fa fa-caret-down"></i>
                                                <ul class="submenu animated speed fadeInDown">
                                                    <li><a href="/hospital-partners">Hospital Partners</a></li>
                                                    <li><a href="/industry-partners">Industry Partners</a></li>
                                                    <!-- <li><a href="/associate-partners">Associates</a></li> -->
                                                    <!-- <li><a href="#">Labs &amp; Clinics</a></li>
                                                    <li><a href="#">Pharmacies</a></li> -->

                                                </ul>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Press</a>
                                                <i class="fa fa-caret-down"></i>
                                                <ul class="submenu animated speed fadeInDown">
                                                    <!-- <li><a href="/news-room">News Room</a></li> -->
                                                    <li><a href="/news-room">Press</a></li>
                                                   <!--  <li><a href="#">Media</a></li> -->
                                                </ul>
                                            </li>

                                            
                                            <!-- <li>
                                                <a href="javascript:;">What's New</a>
                                            </li> -->
                                            <!-- <li>
                                                <a href="javascript:;">Award</a>
                                            </li> -->
                                            <!-- <li>
                                                <a href="javascript:;">Life at Arogya</a>
                                            </li> -->
                                            <li>
                                                <a href="/contact">Contact Us</a>
                                            </li>
                                            <li>
                                                <a href="/faq">FAQ</a>
                                            </li>
                                            <li>
                                                <a href="/login">Login</a>
                                            </li>
                                        </ul>
                                        <div class="menu-responsive"><i class="fa fa-bars"></i></div>
                                    </nav>
                                    <div class="clear">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>                
            </div>               
        </div>
    </div>
    

    <div class="small-header hidden-lg hidden-md" >
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-4">
                    <div class="logo">
                        <a href="/" class="logo"><img src="/assets/images/logo2.jpg" alt="Insurance Agency"></a>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class=" text-right">
                        <span id="arogya-number"><a href="tel:+91 9769205032"><i class="fa fa-phone-square"></i> +91 9769205032</a></span>
                    </div>
                    <div class="">
                        <div class="apply-here text-right">
                            <button type="button" class="btn-custom" data-toggle="modal" data-target="#myModal">Apply Here</button>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
      

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>
      
        <ul class="nav navbar-nav navbar-right  collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <li><a href="/" class="active">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Us <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/our-board">Our Board</a></li>
                <li><a href="/advisory-board">Advisory Board</a></li>
                <li><a href="/management">Our Management</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="/news-room">News Room</a></li> -->
                <li><a href="/apply/loan/personal-details?locale={{$locale}}">Standard Loan</a></li>
                <li><a href="/apply/card/personal-details?locale={{$locale}}">Pre-approved Loan</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Partners <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/hospital-partners">Hospital Partners</a></li>
                <li><a href="/industry-partners">Industry Partners</a></li>
                <!-- <li><a href="/associate-partners">Associates</a></li> -->
                <!-- <li><a href="#">Labs &amp; Clinics</a></li>
                <li><a href="#">Pharmacies</a></li> -->
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Press <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="/news-room">News Room</a></li> -->
                <li><a href="/news-room">Press</a></li>
               <!--  <li><a href="#">Media</a></li> -->
              </ul>
            </li>

            <li><a href="/login">Login</a></li>
            <li><a href="/faq">FAQ</a></li>
        </ul>
    </div>
</header>

<!-- Modal -->
<div id="myModal" class="modal fade modal-main-custom" role="dialog">
   <i class="fa fa-times cancle-modal" aria-hidden="true" data-dismiss="modal"></i>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="apply-here-custom">
                  <img src="/assets/images/nurse2.jpg" alt="" class="img-responsive">  
                  <div class="apply-custom">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i><a href="/apply/loan/personal-details?locale={{$locale}}">{{trans('home.apply_for_loan')}}</a>
                    </div>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="apply-here-custom">
                  <img src="/assets/images/img1.jpg" alt="" class="img-responsive">  
                  <div class="apply-custom">
                        <i class="fa fa-credit-card" aria-hidden="true"></i><a href="/apply/card/personal-details?locale={{$locale}}">{{trans('home.apply_for_card')}}</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>