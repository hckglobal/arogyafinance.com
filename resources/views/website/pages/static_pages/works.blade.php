@extends('app')

@section('title')
How it works
@endsection

@section('styles')
<!-- boootsrap -->
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
@endsection

@section('content')
<section class="box-with-image-right section-top-space">
            <div class="works">

            </div>
        <div class="arogya-loan-flow">

            <div class="container">
                <div class="row">
                    <div class="col-md-4 loan-work-flow">
                        <img src="/assets/images/loan1.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Click apply for loan  </p>
                        <img src="/assets/images/plus-down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Give a small psychometric test online</p>
                        <img src="/assets/images/plus-down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">We will convey our decision after evaluating <br>your profile within 3 to 48 hours</p>
                        <img src="/assets/images/plus-down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">If approved we at Arogya will pay the hospital fees directly</p>
                        <img src="/assets/images/down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Repay over time as with any loan</p>
                        <img src="/assets/images/down-arrow.png" alt="" class="img-responsive text-center">
                        <div class="apply-now text-center"><button class="btn-primary btn-lg"><a href="/apply/loan">Apply now</a></button></div>
                    </div>
                    <div class="col-md-4">
                    <div class="col-md-12 working-levels">
                        <img src="/assets/images/how-it-works.png" alt="" class="img-responsive text-center">
                    </div>
                    <div class="col-md-12 working-levels">
                    <img src="/assets/images/letter-board.png" alt="" class="img-responsive text-center">
                    </div>
                     <div class="col-md-12 working-levels">
                    <img src="/assets/images/laptop.png" alt="" class="img-responsive text-center">
                    </div> 
                    <div class="col-md-12 working-levels">
                    <img src="/assets/images/people.png" alt="" class="img-responsive text-center">
                    </div>  
                    <div class="col-md-12 working-levels">
                    <img src="/assets/images/dollar-card.png" alt="" class="img-responsive text-center">
                    </div> 
                    <div class="col-md-12 working-levels">
                    <img src="/assets/images/smile.png" alt="" class="img-responsive text-center">
                    </div>
                    </div>
                    <div class="col-md-4 loan-work-flow">
                      <img src="/assets/images/medical-expenses.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Wants us to cover your medical expenses in case of<br>an emergency in future? Apply for Arogya card</p>
                        <img src="/assets/images/plus-down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Give a small interview and test online</p>
                        <img src="/assets/images/plus-down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Approved individuals are given personalised card<br>and letter mentioning loan details</p>
                        <img src="/assets/images/plus-down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Every card will indicate pre-approved loan amount</p>
                        <img src="/assets/images/down-arrow.png" alt="" class="img-responsive text-center">
                        <p class="text-center">Benefits of the card can also be enjoyed by <br>card holder's family members</p>
                        <img src="/assets/images/down-arrow.png" alt="" class="img-responsive text-center">
                        <div class="apply-now text-center"><button class="btn-success btn-lg"><a href="/apply/card">Apply now</a></button></div>  
                    </div>
                </div>
            </div>
			
        	
        </div>
    	<div class="mobile-image">
    		<img src="/assets/images/mobile-works.jpg" alt="" id="mobile-center">
    		<h2>Apply for loan on the move!</h2>
    	</div>
    	<h3 class="works-text">You can complete the application process and pyschometric test on our mobile site too</h3 class="works-text">
    </section>
@endsection