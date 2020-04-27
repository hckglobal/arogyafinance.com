<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Arogya Card</title>
</head>
    <style>
    
       
    body,p,td,h3{
    font-family: arial, sans-serif;
    font-size: 12px;
    margin: 0;
    margin-bottom: 2px;
}
.header{
    text-align: center;
    margin-bottom: 25px; 
}
.header img{
    height: 80px;
}
h4.date{
    text-align: right;
}
.address p{
    margin: 0;
    font-weight: bold;
    text-transform: uppercase;
}
.address{
    margin-bottom: 25px;
}
p.pin{
    margin-bottom: 25px;
}
p.content{
    margin: 0;
    margin-bottom: 25px;
}
p b{
    text-transform: uppercase;
}
.footer{
    text-align: center;
    color:#641705;
}
.footer h5{
    margin:0;
    margin-top: 50px;
    font-size: 12px;
}
.footer p{
    margin: 0;
    font-size: 10px;
    margin-bottom: 8px;
}
.content p{
    margin: 0;
    margin-bottom:8px; 
}
p.title{
    margin-bottom:25px; 

}
  
  
    .col-offset-4 {
        width: 450px;
    }


    .col-3 {
        width: 25%;
        text-align:left;
        left:0;
        display: inline-block
    }
    .col-2{
    width:20%;
    text-align:left;
        left:0;
        display: inline-block
    }
    .col-10{
    width:80%;
    text-align:left;
        left:0;
        display: inline-block
    }
    .col-8{
        width: 66.66666667%;
        text-align:left;
        left:0;
        display: inline-block;
        
    }

    .col-6 {
        width: 50%;
        left:0;
        text-align:left;
        display: inline-block;
    }

    .col-4 {
        width: 33.33333333%;
        left:0;
        text-align:left;
        display: inline-block;
    }
    .col-9{
        width: 75%;
        left:0;
        text-align:left;
        display: inline-block;
    }
    .float-right{
    text-align:right;
    display:inline-block;
    }


    .clear-fix {
        clear: both;
    }
    .text-center{
        text-align: center;
          -webkit-print-color-adjust: exact; 
    }
    .front-card{
        height: 216px;
        border: 1px solid #000;
        border-radius:14px;
        position: relative;
        
    
        
    }
    .front-card .card-content{
        position: absolute;
        bottom:0;
        top:0;
        left:0;
        right:0;
        padding: 5px 5px 5px 16px;
    }
   .pull-left{
        float: left;
    }
    .pull-right{
        float: right;
    }
    .side-left{
        background: #76b948;
        -webkit-print-color-adjust: exact; 
        height: 216px;
    width: 25px;

    border-radius: 14px 0px 0px 14px;
        
    }
    .front-card .card-content .logo img{
        width: 70px;
        margin: 0px 15px;     
    }
    .content{
        padding:6px 10px;
        margin:3px;
        border-bottom:1px solid #000;
        border-top:1px solid #000;
    }
    .front-card .content p{
        margin:0;
        margin-bottom:3px;
        font-family: serif;
        font-size:8px;
    }
    .member-img{
        margin:3px;
       padding:6px 10px;
        border-bottom:1px solid #000;
        border-top:1px solid #000;
        text-align:center;
        vertical-align: middle;
        display: inline-block;
    }
    .member-img img{
        width: 60px;
        margin-top:10px;
    }
    .signature{
    position: absolute;
    top: 175px;
    left:225px;
    z-index:99;
    }
    .signature img{
    width:40px;
    margin-left:18px;
       }
  
    .signature p{
        font-size: 8px;
        
    }
    
    .side-right img{
        width:107px;
        display:inline-block;
        text-align:right;
    }
    .back-card{
        height: 216px;
        border: 1px solid #000;
        border-radius:14px;
    }
    .back-card p{
        margin:0;
        font-family: serif;
        font-size:6px;
        font-weight: bold;
        margin-bottom:2px;
    }
    .back-card img{
        text-align: center;
        width:80px;
    }
    .brand-arogya{
        text-align: center;
    }
    .brand-arogya h5{
      margin:0;
      font-size: 8px;
      margin-top: 5px;
      margin-bottom: 10px;
    }
    .back-content{
        margin-bottom:8px;
        height:42px;
    }
    .heading-top{
        font-size:8px !important;
        text-align: center;
        margin-bottom:5px !important;
    }
    .barcode{
       margin-left:40px;
    }
    .heading{
         font-size: 8px !important;
        margin: 5px 0 !important;
    }
    h4{
        margin:0;
        font-size: 7px;
        text-align: center;

    }
    .cin{
        font-weight: 600 !important;
        font-size:6px !important;
        margin:3px 0 !important;
    }
    .back{
        padding:10px;
    }
    h6{
        font-weight: 800;
        font-size:8px;
        margin:0;
        margin-top:8px;
    }
    .border{
        padding:10px;
        border:3px dotted #385d8a;
        border-radius:35px;
    }
    #arogya-card{
        position:relative;
    }
    .fold-here{
        position: absolute;
        top:135px;
        left:50%;
    }
    .fold-here img{
        width: 20px;
        display: block;
        margin-left: -10px;
       
    }
    hr{
      border:none;
      border-top:1px dotted #000;
      color:#fff;
      background-color:#fff;
      margin:20px 0;
    }
    
    .cut{
        position: relative;
    }
   
    .cut img{
        width: 26px;
        position: absolute;
        left: 50%;
        top: 25px;
        margin-left: -13px;
    }
    td{
    font-size:8px;
    font-weight:bold;
    
    }
    .side-right{
    position:absolute;
    top:0;
    right:0;
    bottom:0;
    }
   td li{
   list-style:none;
 
   }
   .card{
    margin-top:50px;
   height:300px;
}
   .width{
   
     white-space: break;
   }
   .fixed{
   height:95px;
   }
   blockquote{
  
  margin: 0em 14px;
 
  }
  .family-custom{
  list-style:none;
  margin:0;
  padding:0;  
  }
  .family-custom li{
  font-size:8px;
  }
  .family-p{
  font-size:8px;
  font-weight:bold;
  font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
  }
</style>

<body>


    <div id="arogya-card">
        <div class="cut text-center">
            <p>This is your Arogya Card. Please cut here and keep safely.</p>
            <hr>
            <img src="assets/images/scissor.png" alt="">
        </div>
        <div class="fold-here">
            <img src="assets/images/fold.jpg" alt="">
        </div>
        <div class="card">
            <div class="col-6">
                <div class="border">
                    <div class="front-card">
                        <div class="side-left float-left">
                            
                        </div>
                        <div class="side-right">
                            <img src="assets/images/side.png" alt="">
                        </div> 
                        <div class="card-content">
                            <div class="logo">
                                <img src="assets/images/logo.jpg" alt="">
                            </div>
                            <div class="col-9 ">
                                <div class="content">
                                    <table  cellspacing="0" class="compact">
                                        <tbody>
                                            <tr>
                                                <td nowrap>Name of the card holder: </td>                                            
                                                <td nowrap>
                                                    {{$application->borrower->first_name}} 
                                                    {{$application->borrower->middle_name}}
                                                    {{$application->borrower->last_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td nowrap>Member Card Number: </td>
                                                
                                                <td nowrap>{{$application->card_no}}</td>
                                            </tr>
                                            <tr>
                                                <td nowrap>Pre-approved Loan Amount: </td>
                                                
                                                <td nowrap>Rs. {{$application->approved_loan_amount}}</td>
                                            </tr>                                    
                                            <tr>
                                                <td nowrap>Issue Date : {{Carbon\Carbon::parse($application->getOriginal('valid_from'))->format('d/m/Y')}}</td>                                      
                                                <td nowrap>Valid Upto : {{Carbon\Carbon::parse($application->getOriginal('valid_upto'))->format('d/m/Y')}}</td>  
                                            </tr>                                    
                                        </tbody>
                                    </table>
                                    <table  cellspacing="0" class="compact">
                                        <tbody>
                                            @if($application->familymembers->count() >0)
                                                <tr>
                                                    <td nowrap>Eligible Family Members: </td>
                                                    
                                                </tr> 
                                                @foreach($application->familymembers as $familymember)
                                                <tr>
                                                    <td nowrap="normal"  nvalign="top">{{$familymember->first_name}} {{$familymember->last_name}} ({{$familymember->relation}})</td>
                                                </tr> 
                                                @endforeach                                  
                                            @endif
                                        </tbody>
                                    </table>                                    
                                    <div class="clear-fix"></div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="member-img fixed">
                                @if($application->hasDocument('photo'))  
                                    <img src="documents/{{$application->id}}/{{$application->getDocument('photo')->file}}" alt="">
                                @endif
                                </div>                        
                            </div>                      
                            <div class="signature">
                                <img src="assets/images/sign.png" alt=""><br>
                                <p class="float-right"><strong>Issuing Authority</strong></p>
                            </div>                      
                        </div>
                    </div>
                </div>                
            </div>
            <div class="col-6">
            <div class="border">
                <div class="back-card">
               <div class="back">
                <p class="heading-top">In case this card is lost - found, kindly return to the Corporate office address</p>
                <div class="barcode">
                    {!!$barcode!!}
                </div>
                
                <div class="brand-arogya">
                    <h5>Arogya Finance is the brand name of <br> Ramtirth Leasing and Finance Co. Pvt. Ltd.</h5>
                </div>
                <div class="back-content">
                    <div class="col-4">
                    <p>Corporate Office:</p>
                    <p>102, Meadows, Sahar Plaza,</p>
                    <p>J.B Nagar, Andheri Kurla Road,</p>
                    <p>Andheri(East), Mumbai-400059</p>
                    </div>
                    <div class="col-4">
                        <p>Registered Office:</p>
                        <p>31, Mystique, Plot No. 129,</p>
                        <p>St. Cyril Road, Off Turner Road,</p>
                        <p>Bandra(West), Mumbai-400050</p>
                    </div>
                    <div class="col-4">
                        <p>Hotline Number:</p>
                        <p>+91 9769205032</p>
                        <p>Website: www.arogyafinance.com</p>
                        <p>Email: info@arogyafinance.com</p>
                    </div>
                    <div class="clear-fix"></div>
                </div>
                <p class="text-center cin"><strong>CIN: U65910MH1995PTC089442, RBI Registration No. 13.01234</strong></p>
                <p class="heading">If the card holder is undergoing treatment, a co-borrower is required and if the borrower is staying in a rented house, a guarantor is required.</p>
                <h4>This in-principle approval is subject to submission of the required documents by you and your acceptance of the final terms and conditions laid down by the company.</h4>
                <h6>*Subject to 75% of hospitalisation expenses at accredited medical institutions</h6>
               </div>
                
              </div>
                
            </div>
              
            </div>
            <div class="clear-fix"></div>
        </div>
    </div>

    
    <p>
        <b>Value added Services with Arogya Card.</b>
    </p><br>

    <p>
        <b><u>APOLLO PHARMACY </u></b>
    </p><br>

    <p>
        5 to 15 % discount On Medicines & Fast moving Consumer Goods. 
    </p>

    <p>
        Arogya Card holder just needs to flash their card and mention the <b>billing code 5007</b> to avail the special discount.
    </p><br>

    <p>
        <i>*Please note medicines containing drugs under DPCO list shall be exempted from discounts. Please find the link below indicating the Govt. Circular on the same http://pharmaceuticals.gov.in/DPCO2013.pdf</i>
    </p>
    
    <p>
        *Dependents can take a scan copy of ID card to avail the benefits.
    </p>

    <p>
       In case there is any Concern at any store you can call our TOLL NO :1860 500 0101 / 040-60602424 or you can also write to customerservice@apollopharmacy.org 
    </p><br>
    
    <p>
        <b><u>NETMEDS</u></b>
    </p><br>

    <p>
        Coupon name – <b>AFNMS20</b>
    </p><br>

    <p>
        1. The Flat 20% discount is valid only on orders placed via Netmeds.com website or Netmeds App.
    </p>

    <p>
        2. This offer is valid on ANY order value of Prescription Medicines ONLY.  
    </p>
    
    <p>
        3. Please Note: Some of the selected medicines are NOT eligible for a flat 20% discount, and it is indicated on the respective <blockquote>product pages as “No additional discounts apply to this medicine.” </blockquote>
    </p>

    <p>
        4. Customer just needs to mention the Unique Coupon Code: <b>AFNMS20</b> 
 
    </p><br>

    <p>
        <b><u>THYROCARE</u></b>
    </p><br>

    <p>
        Thyrocare will avail special discounts of 50-70 % to Arogya Card Holder on Profile like Wellness Mini, Wellness A, Wellness B, Wellness C & Wellness D.
    </p><br>

    <p>
       Please find below process flow to avail the Discount.
    </p><br>

    <p>
        1. Customer Can drop mail on wellness@thyrocare.com  with the promo code Aarogya17 in the subject line and NAPME details and <blockquote>preferred package and appointment time in the mail body.</blockquote>
    </p>
    
    <p>
        <center>OR</center>
    </p>

    <p>
        2. Arogya Finance customers can also contact Thyrocare on 022-3090 0000/4125 2525 & need to provide promo code i.e. <blockquote><b>Aarogya17</b></blockquote>
    </p>

    <p>
        <center>OR</center>
    </p>

    <p>
        3. SMS Or WhatsApp <b>Aarogya17</b> to 9870666333 with your name and contact details to fix the appointment.
    </p>
    
    
    </body>

</html>
