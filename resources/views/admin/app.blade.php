<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Admin | Arogya Finance</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap-editable.css">
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/admin/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/assets/admin/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/assets/admin/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/assets/admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.1/skins/square/grey.css"/> -->
    <!-- icheck style -->
   
    <link rel="stylesheet" href="/assets/admin/dist/css/all.css_icheck.css">
    <!-- custom style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/custom.css">
    <link rel="stylesheet" href="/assets/admin/dist/css/toastr.min.css">
    <link rel="stylesheet" href="/assets/admin/dist/css/sweetalert.css">
    <link rel="stylesheet" href="/assets/admin/plugins/select2/select2.min.css">

    <link rel="stylesheet" href="/assets/admin/dist/css/datetimepicker.css">

    @yield('styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

     <!-- header -->
     @include('admin.partials.header')

     @include('admin.partials.sidebar')

     <!-- sidebar -->

      <!-- Content Wrapper. Contains page content -->
      @yield('content')

      <footer class="main-footer">
        <strong>Copyright &copy; {{date("Y")}} <a target="_blank" href="http://mindise.in/">Mindise</a>.</strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.5 -->
    <script src="/assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script>
        $(document).ready(function(){
          var option = '<div class="option"> <div class="col-md-6 form-group"> <input type="text" name="option_name[]" class="form-control"> </div><div class="col-md-6"> <div class="col-md-3"> <select name="option_value[]" style="width:100px;height:35px;border: 1px solid #ccc;"> <option value="1">1.00</option> <option value="0.75">0.75</option> <option value="0.50">0.5</option> <option value="0.25">0.25</option> <option value="0">0</option> </select> </div><div class="col-md-3 pull-right"> <button class="remove btn btn-danger">Delete Option</button> </div></div></div><div class="clearfix"></div>' ;
            $('.add-option').click(function(){
            $('.parent').append(option);

             $('.remove') .bind( "click", function() {
              $(this).parents('.option').remove();
            });

           });
          $('.remove') .bind( "click", function() {
                $(this).parents('.option').remove();
              });
        });
   </script>

    <script type="text/javascript" src="/assets/admin/bootstrap/js/bootstrap-editable.js"></script>
    <!-- Sparkline -->
    <script src="/assets/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/assets/admin/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="/assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/assets/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="/assets/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/admin/plugins/select2/select2.full.min.js"></script>
    <!-- FastClick -->
    <script src="/assets/admin/plugins/fastclick/fastclick.min.js"></script>
    

    <!-- date picker -->
     <script src="/assets/admin/dist/js/toastr.min.js"></script>
    <script src="/assets/admin/dist/js/sweetalert.min.js"></script>
    <script src="/assets/admin/dist/js/moment-with-locales.js"></script>
    <script src="/assets/admin/dist/js/datetimepicker.js"></script>
    
    <!-- icheck -->
    <script src="/assets/admin/dist/js/icheck-js.js"></script>

    <!-- AdminLTE App -->
    <script src="/assets/admin/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- AdminLTE for demo purposes -->
    <script src="/assets/admin/dist/js/demo.js"></script>

    <script type="text/javascript" src="/assets/js/vue.min.js"></script>
    <script type="text/javascript" src="/assets/js/admin.vue.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.auto-complete.min.js"></script>


     @if(Entrust::can('edit-application-form'))
    <script src="/assets/admin/dist/js/editable.js"></script>
    @endif
    <script src="/assets/admin/dist/js/admin.js"></script>
    <script src="/assets/admin/dist/js/analytics_filter.js"></script>
   
    @yield('scripts')

    <script>
    $(".select2").select2();

    @if(\Session::has('info'))
    toastr.success("{{\Session::get('info')}}");
    @endif

    @if(\Session::has('reference_code'))
         swal({
             title: "Your Reference Code is",
             text: "{{\Session::get('reference_code')}}", 
             type:"info"  
         });
    @endif


  
    </script>
  </body>
</html>
