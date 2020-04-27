@extends('website.app')

@section('title')
FAQ
@endsection

@section('content')
<section class="box-with-image-right section-top-space faq-section-custom">
   <div class="container">
       <div class="row">
        <div class="custom-heading">
            <h3>frequently asked questions</h3>
            <div class="divider">
                <span><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
            </div>
        </div>
        <div class="text-center">
            <h2>All you need to know about us.</h2>
                
                <p>To enable people to access quality health care by offering them a loan at the right place and the right time.</p>
        </div>
           <div class="col-md-8 col-md-offset-2">
               <div class="content">

                
                <ul class="accordion">
                

                    <li class="accordion-section">
                        <a class="accordion-section-title" href="#accordion-1"><i class="fa fa-plus" aria-hidden="true"></i>What is Arogya Finance?</a>
                        <div id="accordion-1" class="accordion-section-content">
                            <p>Arogya Finance is the Brand name of Ramtirth Leasing and Finance Company Pvt. Ltd. an NBFC registered with Reserve Bank of India. Arogya Finance offers Medical Loans to families to meet health care costs.</p>
                        </div>
                    </li>
                    
                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-2"> <i class="fa fa-plus" aria-hidden="true"></i>How is a medical loan from Arogya Finance different than a regular bank loan?</a>
                        <div id="accordion-2" class="accordion-section-content">
                            <p>'Regular' bank loans are only accessible to those who are inside the 'formal' system - i.e. those who can provide income documents or have assets to collateralize. For the majority of people in India, such an approach is a non-starter. Arogya Finance has developed a proprietary approach, which allows it to lend to those in the 'informal' sector who don't always have access to salary slips, collateral, etc. Arogya does that through the use of a special test developed, refined, and perfected by its army of experts.</p>
                        </div>
                    
                    </li>
                    
                    <li class="accordion-section">
                        <a class="accordion-section-title" href="#accordion-3"> <i class="fa fa-plus" aria-hidden="true"></i>What can the loan be used for?</a>
                        <div id="accordion-3" class="accordion-section-content">
                            <p>The loan is to be used only for medical needs. The loan, once approved, is disbursed directly to the caregiver (i.e. hospitals, nursing homes) ensuring proper use.</p>
                        </div>
                    </li>
                    
                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-4"> <i class="fa fa-plus" aria-hidden="true"></i>What is the EMI of the loan?</a>
                        <div id="accordion-4" class="accordion-section-content">
                            <p>The EMI depends on the borrower's eligibility and on the amount and duration of the loan taken. We work with the borrower to make sure the EMIs are affordable.</p>
                        </div>
                    
                    </li>
                    
                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-5"> <i class="fa fa-plus" aria-hidden="true"></i>What is the maximum amount of the loan?</a>
                        <div id="accordion-5" class="accordion-section-content">
                            <p>Arogya doesn't define a maximum figure for the amount that can be borrowed. The goal is to work with the borrower to ensure that the total amount and EMIs are affordable and that the amount is enough to cover the particular health needs.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-6"> <i class="fa fa-plus" aria-hidden="true"></i>Does Arogya Finance play a role in determining the nature of treatment prescribed?</a>
                        <div id="accordion-6" class="accordion-section-content">
                            <p>No, Arogya Finance plays no role whatsoever in determining type of care to be provided.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-7"> <i class="fa fa-plus" aria-hidden="true"></i>How do I apply?</a>
                        <div id="accordion-7" class="accordion-section-content">
                            <p>To apply online, please click here, <a href="https://arogyafinance.com/apply/loan">Apply for Loan</a>. You can send us an email by clicking here, <a href="mailto:info@arogyafinance.com"> “Contact Us”</a>. You can also call us at <a href="tel:09769205032">+91 9769205032</a></p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-8"> <i class="fa fa-plus" aria-hidden="true"></i>What documents do I need?</a>
                        <div id="accordion-8" class="accordion-section-content">
                            <p>Ideally, we would like to see (1) address proof, (2) ID proof, (3) proof of ownership, and (4) proof of income. But we can work with whatever documents you are able to bring with you.</p>
                        </div>
                    
                    </li>
                    
                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-9"> <i class="fa fa-plus" aria-hidden="true"></i>What will I be asked?</a>
                        <div id="accordion-9" class="accordion-section-content">
                            <p>The online application process will guide you and result in an instant approval, if all criteria are met. In the manual process, the Arogya Finance Counselor will begin by asking some basic questions about your background, income sources, etc, and will then ask some forward looking questions about your plans for the future. The process should take about 3-4 hours. And that's it!</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-10" ><i class="fa fa-plus" aria-hidden="true"></i>Can I take a loan for a family member?</a>
                        <div id="accordion-10" class="accordion-section-content">
                            <p>Arogya Finance generally lends to a family member, so yes, you can take a loan for a family member. However, Arogya does not allow people to take loans on behalf of friends or other acquaintances.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-11" ><i class="fa fa-plus" aria-hidden="true"></i>When will I find out if I am approved or not?</a>
                        <div id="accordion-11" class="accordion-section-content">
                            <p>If you apply online, chances are that you will get an instant approval. If not, an arogya counseller will speak to you soon to complete the formalities. In case of a physical application, Arogya is able to reach and share a decision within 24 hours of meeting with the borrower. Our average turnaround time is about 3 hours (In case of emergency it could be as little as 3 hours.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-12"> <i class="fa fa-plus" aria-hidden="true"></i>How will the money be paid to my health care provider?</a>
                        <div id="accordion-12" class="accordion-section-content">
                            <p>Arogya transfers the money directly to the provider so the patient's care can begin immediately.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-13"> <i class="fa fa-plus" aria-hidden="true"></i>Will I have to pay any other fees?</a>
                        <div id="accordion-13" class="accordion-section-content">
                            <p>There is a documentation charge of Rs 500 and one time 2% processing fee.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-14"> <i class="fa fa-plus" aria-hidden="true"></i>How do I repay the loan?</a>
                        <div id="accordion-14" class="accordion-section-content">
                            <p>Arogya prefers post-dated checks (PDCs) but if the borrower is not able to provide them, Arogya works with the borrower to explore alternate options.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-15"> <i class="fa fa-plus" aria-hidden="true"></i>When is the first payment due?</a>
                        <div id="accordion-15" class="accordion-section-content">
                            <p>The first payment is due on the 9th of every month after the patient is discharged from the care facility.</p>
                        </div>
                    
                    </li>

                  

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-17"> <i class="fa fa-plus" aria-hidden="true"></i>What is the tenure of the loan?</a>
                        <div id="accordion-17" class="accordion-section-content">
                            <p>The tenure of the loan depends on the borrower's need but cannot exceed 4 years.</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-18"> <i class="fa fa-plus" aria-hidden="true"></i>How do I become part of the Arogya Finance network?</a>
                        <div id="accordion-18" class="accordion-section-content">
                            <p>Just call us at +919769205032 or e-mail us at partners@arogyafinance.com</p>
                        </div>
                    
                    </li>

                    <li class="accordion-section">
                    
                        <a class="accordion-section-title" href="#accordion-19"> <i class="fa fa-plus" aria-hidden="true"></i>As a partner will I be liable if a borrower defaults on his/her commitment?</a>
                        <div id="accordion-19" class="accordion-section-content">
                            <p>No, Arogya Finance assumes the risk of default. Our partners have no liability and are paid immediately for the services they provide</p>
                        </div>
                    
                    </li>
                
                </ul>
                
                <!-- <p>Etiam id ante est. Aenean pellentesque quam vel purus tincidunt tristique. Integer arcu nibh, tempus id ultricies ut, vulputate nec nunc.</p>
                <form method="get" action="index.html" class="form">
                
                    <input type="text" placeholder="Type...">
                    <button class="button button-navy-blue send-phone-call-quote">Search!</button>
                
                </form>
                 -->
            </div>
           </div>
       </div>
   </div>    
</section>
@endsection
@section('script')
<script type="text/javascript">
    $('.accordion a').click(function (e) {
        e.preventDefault();
        $("i", this).toggleClass("fa-plus fa-minus");
        $(this).siblings('div').toggle("slow");  
    });
</script>
@endsection