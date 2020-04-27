<!DOCTYPE html>
<html lang="en-US">
<head>
    <title> @yield ('title') | Arogya Finance </title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Arogya Finance, co-founded by Mr. Jose Peter and Mr. Dheeraj Batra, is a social health care venture,
                    which offers medical loans to the traditionally un-bankable, using innovative risk assessment tools that
                    allows them to finance people outside the formal banking system.">
    <meta name="author" content="Awkword Studio">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Signika:300,400,600,700" />
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.nouislider.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="/assets/admin/dist/css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/blog.css">
    <!-- boootsrap -->
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/swiper.min.css">
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/isLoading.min.js"></script>
    @yield('styles')
    <link rel="stylesheet" href="/assets/css/wfmi-style.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/style.v2.css?v=2.0" />
    <script type="text/javascript"> //<![CDATA[ 
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163472103-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-163472103-1');
</script>
</head>

<script type="text/javascript">
    $.LoadingOverlay("body",{
        image :     "/assets/images/loading.gif",
        color       : "rgba(0, 0, 0, 0.5)",
        maxSize     : "200px"
    });
</script>
<body id="@yield('body-id')">
   @include('website.partials.header')
    <!-- urgent contact -->
      <div class="urgent-call-fixed">
          <div class="content-fixed">
            <h3>Enquiry Form</h3>
              <form action="/urgent-contact-mail" method="POST">
                {{ csrf_field() }}
                <div >
                  <label for="">Your Name</label>
                  <input class="form-control" type="text" name="name">
                </div>
                <div>
                  <label for="">Your Mobile Number</label>
                  <input class="form-control" type="number" name="mobile_number">
                </div>
                <div>
                  <label for="">Your Email</label>
                  <input class="form-control" type="text" name="email">
                </div>
                
                <div class="text-center">
                  <button class="btn btn-primary btn-outline">Submit</button>
                </div>
                
              </form>
          </div>
          <div class="phone">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
          </div>
      </div>
    <!-- end of urgent contact -->
    @yield('content')

    
  @include('website.partials.footer')
    <script src="https://maps.google.com/maps/api/js?sensor=false"></script>
    <script src="/assets/js/jquery.nouislider.all.min.js"></script>
    <script src="/assets/js/smoothscroll.js"></script>
    <script src="/assets/js/parallax.js"></script>
    <script src="/assets/js/jquery.html5-placeholder-shim.js"></script>
    <script src="/assets/js/jquery.dataTables.js"></script>
    <script src="/assets/js/notify.min.js"></script>
    <script src="/assets/js/jquery.steps.min.js"></script>
    <script src="/assets/js/jquery-ui-1.8.22.min.js"></script>
    <script src="/assets/js/jquery.validate.js"></script>
    <script src="/assets/admin/dist/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/swiper.min.js"></script>
    <script src="/assets/js/countUp.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    <!-- Radio and checkbox styles -->
    <script src="/assets/js/check.min.js"></script>

    <!-- HTML5 and CSS3-in older browsers-->
    <script src="/assets/js/modernizr.custom.17475.js"></script>
     
    <!-- Custom function -->
    <script src="/assets/js/functions.js"></script>
    <script src="/assets/js/functions.v2.js?v=2.0"></script>
    <!-- form wizard files -->
    <script type="text/javascript" src="/assets/js/form-wizard.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.auto-complete.min.js"></script>
    <script type="text/javascript" src="/assets/js/formvalidation.bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/form-wizard-config.js"></script>
    <script type="text/javascript" src="/assets/website/application_form_fields.js"></script>
    
    @yield('script')

    @if(\Session::has('message'))
    <script type="text/javascript">
     sweetAlert("Application submitted !", "{{\Session::get('message')}}", "success");
    </script>
    @endif

     @if(\Session::has('otp_verification'))
     <script type="text/javascript">
            swal({
              title: "OTP Verification",
              text: "Please enter the OTP sent to the registered mobile number",
              type: "input",
              showCancelButton: true,
              closeOnConfirm: false,
              animation: "slide-from-top",
              inputPlaceholder: "Write something"
            },
            function(input){
                  $.ajax('/api/verify-otp', {
                      data: {
                          otp:  input
                       },
                       method: 'POST',
                      success: function(data) {
                         if(data.success){
                            window.location = data.link;
                         }
                         //swal("Verification Complete", "Your sanction letter is ready for download","success");
                      },
                      error: function() {
                        swal("Invalid OTP", "The otp you entered is invalid","error");
                      }
                   });
            });
            /*swal({
              title: "OTP Verification",
              text: "Please enter the OTP sent to the registered mobile number",
              type: "input",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, download it!',
              cancelButtonText: 'No, cancel download!',
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false
            }).then(function () {
              swal(
                'Downloaded!',
                'Your file has been downloaded.',
                'success'
              )
            }, function (dismiss) {
              // dismiss can be 'cancel', 'overlay',
              // 'close', and 'timer'
              if (dismiss === 'cancel') {
                swal(
                  'Download cancelled',
                  'Your download was cancelled:)',
                  'error'
                )
              }
            })*/


        </script>
        

    @endif
</body>
</html>
