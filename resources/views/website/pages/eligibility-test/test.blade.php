@extends('website.app')

@section('title')
Eligiblity Test
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Signika:300,400,600,700" />
<link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/jquery.nouislider.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/animate.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/jquery.dataTables.css" />
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/assets/css/test-style.css">
<link rel="stylesheet" href="/assets/css/qunit.css">
@endsection

@section('body-id'){{'about-us'}}@endsection

@section('content') 
<div class="coming" id="coming-soon">
    <section class="container" id="main">
        <div id="test" >
            <h1>Time to complete the test: <span class='timer'>21:00</span></h1>
           
            <div  class="my_camera" id="my_camera">                     
            </div>
            <div id="my_result"></div>
            <!-- Start Survey container -->
            <div id="survey_container">
                <div id="top-wizard">
                    <strong>Progress <span id="location"></span></strong>
                    <div id="progressbar"></div>
                    <div class="shadow"></div>
                </div>
                <!-- end top-wizard -->
                <form name="example-1" id="wrapped" action="" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="borrower_id" value="{{$borrower->id}}" id="borrower_id">
                    <div id="middle-wizard">
                    <!--=====================================
                    =            Questions pool            =
                    ======================================-->

                    <?php $i=1;?>

                    @foreach($questionsArray as $question)


                        <!-- form step -->
                    <div class="step row {{$locale}}">
                        <div class="col-md-10">
                            <h3>{{object_get($question, "text_{$locale}" )}}</h3>
                            <input type="hidden" name="answers[{{$i}}][question_id]" value="{{$question->id}}">
                            <ul class="data-list-2">
                            @foreach($question->options  as $option)
                                <li class="option"><input name="answers[{{$i}}][option_id]" type="radio" class="required check_radio" value="{{$option->id}}"><label>{{object_get($option, "text_{$locale}" )}}</label></li>
                            @endforeach
                            </ul>
                        </div>
                    </div><!-- end step -->

                    <?php $i++; ?>
                    @endforeach                      


                    <!--====  End of Questions Pool  ====-->
                        <div class="submit step" id="complete">
                            <i class="icon-check"></i>
                            <h3>Test Complete! Thank you for you time.</h3>
                            <button type="submit" name="process" class="submit">Submit the Test</button>
                        </div>
                        <!-- end submit step -->
                    </div>
                    <!-- end middle-wizard -->
                    <div id="bottom-wizard">
                        <!-- <button type="button" name="backward" class="backward">Backward</button> -->
                        <button type="button" name="forward" class="forward" style="display:none">Forward </button>
                    </div>
                    <!-- end bottom-wizard -->
                </form>
            </div>
            <!-- end Survey container -->
        </div>            
    </section>
</div>
@endsection

@section('script')


<script src="/assets/js/jquery.js"></script>
<script src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script src="/assets/js/jquery.nouislider.all.min.js"></script>
<script src="/assets/js/smoothscroll.js"></script>
<script src="/assets/js/parallax.js"></script>
<script src="/assets/js/jquery.dataTables.js"></script>
<script src="/assets/js/jquery.steps.min.js"></script>
<script src="/assets/js/jquery-ui-1.8.22.min.js"></script>

<!-- Wizard-->
<script src="/assets/js/jquery.wizard.js"></script>

<!-- Radio and checkbox styles -->
<script src="/assets/js/check.min.js"></script>

<!-- HTML5 and CSS3-in older browsers-->
<script src="/assets/js/modernizr.custom.17475.js"></script>
 <!-- OTHER JS -->
<script src="/assets/js/test-plugins.js" type="text/javascript"></script>
<script src="/assets/js/psychometric_test.js"></script>
<script src="/assets/js/test-functions.js"></script>
<script src="/assets/js/webcam.min.js"></script>
<script src="/assets/js/notify.min.js"></script>
<script src="/assets/js/jquery.validate.js"></script>

<script src="/assets/js/qunit.js"></script>
<script src="/assets/js/say-cheese.js"></script>    
<script src="/assets/js/functions.js"></script>


@endsection


    



    

    



   


