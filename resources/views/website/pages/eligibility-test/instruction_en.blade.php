@extends('website.app')

@section('title')
About-us Page
@endsection

@section('body-id'){{'about-us'}}@endsection

@section('content')
<section class="box-with-image-right section-top-space">
    <div class="center">
        <div class="green-line">
        </div>
        <div class="content" style=" margin-bottom:5%;">
         <div class="en">
            <h2>Instructions For Eligibility Test</h2>
            <ul class="instructions">
                <li>This is a timed test. Duration for the test is 20 minutes.</li>
                <li>This questionnaire consists of questions divided into 2 sections.</li>
                <li>We acknowledge that all persons are different and the answers are not to form a judgement of who is right or who is wrong.</li>
                <li>This questionnaire is part of our assessment process for offering the loan.</li>
                <li>Both sections contains many situations described which are imaginary and hypothetical and you might have come across some or not faced some. There are no right or wrong answers. Please choose the answer which describes you best.</li>
                <li>You have to answer assuming what you think you would do naturally in such a situation. Please do not spend time analysing and debating. We request you to give top of the mind answers. It is important that you answer all the questions.</li>
                <li>By taking this test you accept that the decision of giving the loan is at the sole discretion of the company and it may take its decision based on the questionnaire, the documents produced as well as any other method it may deem fit.</li>
            </ul>
        </div>
            <a href="/eligibility/test/en">
                <button class="button button-navy-blue card-button" data-action="show-quote-popup" data-quote-key="life-insurance">Continue for test<i class="fa fa-paper-plane-o"></i></button>
            </a>
        </div>
</section>
@endsection
