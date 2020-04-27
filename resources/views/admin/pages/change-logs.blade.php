@extends('admin.app')

@section('title') 
Change logs
@endsection

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="/assets/admin/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('active-dashboard')
class="active"
@endsection

@section('content')

<div class="content-wrapper">
    @include('admin.partials.content-header')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid">
                            <!-- Changelogs -->
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <h3> V 3.93.1
                                                <small class="pull-right">13<sup>th</sup>March 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection Import Report</h4></li>
                                                <ul>
                                                    <li>Modified collection import mail content & report data.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.93.0
                                                <small class="pull-right">13<sup>th</sup>March 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Revised Eligibility For Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Revised psychometric test eligibility.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.92.0
                                                <small class="pull-right">12<sup>th</sup>March 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection Import Error</h4></li>
                                                <ul>
                                                    <li>If there is error while importing collection data email will be sent along with the attachment to the user.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.91.0
                                                <small class="pull-right">06<sup>th</sup>March 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>CIBIL Data-Log Report</h4></li>
                                                <ul>
                                                    <li>Added menu in master report to generate cibil data-log report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.90.0
                                                <small class="pull-right">02<sup>nd</sup>March 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection & Bounce List</h4></li>
                                                <ul>
                                                    <li>Added option to import collection & bounce data at the same time.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.89.0
                                                <small class="pull-right">25<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Application Internal Detail</h4></li>
                                                <ul>
                                                    <li>Added permission to update application internal details.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.88.0
                                                <small class="pull-right">25<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Mandate Status</h4></li>
                                                <ul>
                                                    <li>Added mandate status and UMRN no. in application show page.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.87.2
                                                <small class="pull-right">25<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Disbursement Email</h4></li>
                                                <ul>
                                                    <li>Removed sonali signature image from email content.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.87.1
                                                <small class="pull-right">25<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Penalty Report</h4></li>
                                                <ul>
                                                    <li>Added application status and NDC status in penalty report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.87.0
                                                <small class="pull-right">25<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Penalty Report</h4></li>
                                                <ul>
                                                    <li>Added penalty report to master report menu.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.86.0
                                                <small class="pull-right">24<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Report Based On location & Role</h4></li>
                                                <ul>
                                                    <li>Added logic to filter user applications various reports based on location & role.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.85.1
                                                <small class="pull-right">24<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Disbursement mail to FC</h4></li>
                                                <ul>
                                                    <li>Fixed issue were FC was unable to receive email notification of disbursement.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.85.0
                                                <small class="pull-right">24<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Role Bases Closure Charges</h4></li>
                                                <ul>
                                                    <li>Added funcationality to assign loan closure charges to each role.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.84.3
                                                <small class="pull-right">20<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Ingenico Integration</h4></li>
                                                <ul>
                                                    <li>Fixed mandate doesn't exist error issue and added retry option.</li>
                                                    <li>Added role & logic to fetch finance-partner applications.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.84.2
                                                <small class="pull-right">18<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Ingenico Integration</h4></li>
                                                <ul>
                                                    <li>Fixed mandate doesn't exist error issue.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.84.1
                                                <small class="pull-right">18<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Poonawalla Finance</h4></li>
                                                <ul>
                                                    <li>If case status is verified / sanctioned /disbursed /closed button will be visible to send the application to poonawalla.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.84.0
                                                <small class="pull-right">18<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Ingenico Integration</h4></li>
                                                <ul>
                                                    <li>Added option in user dashboard to apply for E-mandate.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.83.0
                                                <small class="pull-right">17<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Poonawalla Finance</h4></li>
                                                <ul>
                                                    <li>User can mark the application as poonawala by clicking on send to poonawala button in application show page.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.82.1
                                                <small class="pull-right">11<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection Import</h4></li>
                                                <ul>
                                                    <li>Updated collection import emi payment date format issue.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V 3.82.0
                                                <small class="pull-right">10<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Updated psychometric test flow.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.80.0
                                                <small class="pull-right">04<sup>th</sup>February 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Disbursement Email Notification</h4></li>
                                                <ul>
                                                    <li>-Sending disbursement mail of hospital email content to FC.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.79.2
                                                <small class="pull-right">28<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Analytics Report & Date-picker</h4></li>
                                                <ul>
                                                    <li>Modified disbursement date format.
                                                    </li>
                                                    <li>Fixed date-picker issue for previous and next month button.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.79.0
                                                <small class="pull-right">28<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Disbursal Flow</h4></li>
                                                <ul>
                                                    <li>Disbursed button to be visible only if repayment-cheque & bank detail are added.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.78.0
                                                <small class="pull-right">28<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Internal Detail Section</h4></li>
                                                <ul>
                                                    <li>Added dropdown options for mode of payment and mapped old data with dropdown options.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.77.4
                                                <small class="pull-right">23<sup>rd</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Analytics</h4></li>
                                                <ul>
                                                    <li>Fixed analytics report issue for sanction export.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.77.3
                                                <small class="pull-right">23<sup>rd</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Analytics</h4></li>
                                                <ul>
                                                    <li>
                                                        Modificied disbursement date format and displaying disbursed data in chronological order.
                                                    </li>
                                                </ul>
                                                <li><h4>Master Reports</h4></li>
                                                <ul>
                                                    <li>Added permissions to generate master reports.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.77.1
                                                <small class="pull-right">21<sup>st</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>OD Report</h4></li>
                                                <ul>
                                                    <li>Added disbursement date in OD report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.77.0
                                                <small class="pull-right">15<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Income Computation Report</h4></li>
                                                <ul>
                                                    <li>Added status and closed cases in report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.76.0
                                                <small class="pull-right">14<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Sanction Expired</h4></li>
                                                <ul>
                                                    <li>Added a message is application was sanctioned 1 month earlier and not disbursed till date and updated EMI report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>

                                        <div class="header">
                                            <h3> V  3.75.4
                                                <small class="pull-right">14<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Fixed mobile app psychometric test bug.</li>
                                                </ul>
                                                <li><h4>PDC Report</h4></li>
                                                <ul>
                                                    <li>Added check for current month pdc.</li>
                                                </ul>
                                                <li><h4>Website</h4></li>
                                                <ul>
                                                    <li>Added contact us menu in website.</li>
                                                </ul>
                                                <li><h4>Repayment Cheque</h4></li>
                                                <ul>
                                                    <li>Fixed date-selector alignment issue and added ACH to dropdown option with pre-fill borrower name.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.75.0
                                                <small class="pull-right">09<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Overdue Report</h4></li>
                                                <ul>
                                                    <li>Fixed contract amount issue and added logic to generate user-basis report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.74.1
                                                <small class="pull-right">08<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix</h4></li>
                                                <ul>
                                                    <li>Fixed MID letter alignment issue.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.74.0
                                                <small class="pull-right">08<sup>th</sup>January 2020</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Updated new psychometric test system to arogya system.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.73.2
                                                <small class="pull-right">31<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Optimization</h4></li>
                                                <ul>
                                                    <li>Fixed loan closure bug where advance emi is shown as od amount in od report and loan closure.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.73.1
                                                <small class="pull-right">27<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Optimization</h4></li>
                                                <ul>
                                                    <li>Optimized OD Report generation & fixed loan closure total amount bug.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.73.0
                                                <small class="pull-right">23<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Report Optimization</h4></li>
                                                <ul>
                                                    <li>Optimized system generated reports.</li>
                                                </ul>
                                                <li><h4>Loan Closure & Collection Import</h4></li>
                                                <ul>
                                                    <li>Added a button in account repayment page to view loan closure detail.</li>
                                                    <li>Added a button in collection to mark collected collect as bounce and update the account repayment accordingly.</li>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.70.0
                                                <small class="pull-right">18<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Disclaimer</h4></li>
                                                <ul>
                                                    <li>Added legal disclaimer in the footer section.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.69.5
                                                <small class="pull-right">17<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Modification - Analytics Report</h4></li>
                                                <ul>
                                                    <li>Added CIBIL score to analytics export report.</li>
                                                    <li>Loan Closure & Collection Import</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.69.4
                                                <small class="pull-right">12<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix Mobile Application</h4></li>
                                                <ul>
                                                    <li>Fixed mobile application borrower form submission error.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.69.3
                                                <small class="pull-right">11<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix</h4></li>
                                                <ul>
                                                    <li>Added all the backend routes to auth middleware.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.69.2
                                                <small class="pull-right">10<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix</h4></li>
                                                <ul>
                                                    <li>Fixed issue where deactivated users were able to login into the system.
                                                    </li>
                                                    <li>Added conidtion while importing ACH data. i.e application must be of loan type and status must be disbursed or closed. </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.69.0
                                                <small class="pull-right">10<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Import ACH</h4></li>
                                                <ul>
                                                    <li>Added option in EMI Report menu to import ACH data.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.68.0
                                                <small class="pull-right">09<sup>th</sup>December 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Mobile App Dedup</h4></li>
                                                <ul>
                                                    <li>Added website dedup logic to mobile application.</li>
                                                    <li>Modified dedup logic. Added logic to match incoming lead detail with aadhar-card, pan-card & id-proof-number.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.67.3
                                                <small class="pull-right">30<sup>th</sup>October 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Footer Updation</h4></li>
                                                <ul>
                                                    <li>Social media links have been updated and all links when clicked, gets opened in a new tab.
                                                    </li>
                                                    <li>Copyright section updated.
                                                    </li>
                                                </ul>
                                               
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.67.3
                                                <small class="pull-right">06<sup>th</sup>November 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Documents Issue</h4></li>
                                                <ul>
                                                    <li>Fixed user document list issue.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.67.2
                                                <small class="pull-right">15<sup>th</sup>October 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Report File Extension</h4></li>
                                                <ul>
                                                    <li>Changed all the system generated report file extension from csv to xlsx.
                                                    </li>
                                                </ul>
                                                <li><h4>Collection Export</h4></li>
                                                <ul>
                                                    <li>Fixed collection export issue. In few cases collected amount was misplaced.</li>
                                                    <li>Fixed Collection export date format issue.</li>
                                                    <li>Remove location,product,reject reason code from data dump report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.65.0
                                                <small class="pull-right">14<sup>th</sup>October 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Close Application</h4></li>
                                                <ul>
                                                    <li>Added a menu to close applications in bulk.</li>
                                                </ul>
                                                <li><h4>Import Parent Hospitals</h4></li>
                                                <ul>
                                                    <li>Added a menu to import parent hospitals in bulk.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.63.1
                                                <small class="pull-right">03<sup>rd</sup>September 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Change psychometric test language selection option title for hindi.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.63.0
                                                <small class="pull-right">27<sup>th</sup>August 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Master Report</h4></li>
                                                <ul>
                                                    <li>
                                                    Added a report to Master Report menu called Approval Log Report, which list out the application cases where Jose Sir has commented in Notes section and describe the application stage log detail, when it was sanction along with the basic details.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.62.3
                                                <small class="pull-right">27<sup>th</sup>August 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Application Log</h4></li>
                                                <ul>
                                                    <li>
                                                    Fixed a bug where system failed to capture the application log detail while updating application stage.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.62.2
                                                <small class="pull-right">23<sup>rd</sup>August 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Master Report</h4></li>
                                                <ul>
                                                    <li>
                                                    Added a report to Master Report menu called Log Report, which describe the application stages log detail when it was verified, sanction, disbursed & closed along with the basic details.</li>
                                                </ul>
                                                <li><h4>Date Bugfix</h4></li>
                                                <ul>
                                                    <li>
                                                    Added 2019 to dropdown list.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.61.1
                                                <small class="pull-right">19<sup>th</sup>August 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Sanction Letter</h4></li>
                                                <ul>
                                                    <li>Fixed sanction date issue.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.61.0
                                                <small class="pull-right">13<sup>th</sup>August 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Master Report</h4></li>
                                                <ul>
                                                    <li>Added a new menu-Income Computation Report.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.60.4
                                                <small class="pull-right">26<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>First Letter Bugfix.</h4></li>
                                                <ul>
                                                    <li>Fixed first letter email CC issue.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.60.3
                                                <small class="pull-right">24<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Regional Language</h4></li>
                                                <ul>
                                                    <li>Updated regional languages telugu for borrower's relation with patient drop-down.</li>
                                                    <li>Updated label name for all the regional languages like select location, Treatment Type, & Hospital name.</li>
                                                    <li>Fixed Malayalam language drop-down issue.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.60.0
                                                <small class="pull-right">24<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Regional Language</h4></li>
                                                <ul>
                                                    <li>Added regional languages for borrower's relation with patient drop-down.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.59.2
                                                <small class="pull-right">22<sup>nd</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Search Filter</h4></li>
                                                <ul>
                                                    <li>Added borrowers mobile number, email & alternate number in searchable field</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.59.1
                                                <small class="pull-right">19<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix MIS Date Filter</h4></li>
                                                <ul>
                                                    <li>Filtering data for Data Dump & CIBIL Dump based on Disbursement Date logic</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.59.0
                                                <small class="pull-right">18<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>MIS Filter Report</h4></li>
                                                <ul>
                                                    <li>Added date filter option to generate reports for :</li>
                                                    <ul>
                                                        <li>Collection Data Dump</li>
                                                        <li>Closure</li>
                                                        <li>Data Dump</li>
                                                        <li>Outstanding Principal</li>
                                                    </ul>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.55.1
                                                <small class="pull-right">17<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Repayment Collection bugfix</h4></li>
                                                <ul>
                                                    <li>Fixed Repayment Advance EMI Collection issue, where user revert stage from disbursed stage to other and re-disbursed the same case again. which lead to creation of multiple Advance EMI entries in collection record.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.55.0
                                                <small class="pull-right">16<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Application Form Modification</h4></li>
                                                <ul>
                                                    <li>Removed Address line 2 from all the form and letters generated by the system.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.54.3
                                                <small class="pull-right">09<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix</h4></li>
                                                <ul>
                                                    <li>Fixed case-sensitive issue for gender. </li>
                                                </ul>
                                                <li><h4>Email Notification</h4></li>
                                                <ul>
                                                    <li>Removed latesh Email address from system</li>
                                                </ul>
                                                <li><h4>Analytics Filter</h4></li>
                                                <ul>
                                                    <li>Added Disbursed & Closed option in filter option</li>
                                                </ul>
                                                <li><h4>Bugfix Collection</h4></li>
                                                <ul>
                                                    <li>Update collection logic.Fixed collection import issue where user was able to import collection but repayment was not reflected.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.53.0
                                                <small class="pull-right">08<sup>th</sup>July 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Captcha</h4></li>
                                                <ul>
                                                    <li>Added Capthca in contact-us page</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.52.0
                                                <small class="pull-right">25<sup>th</sup>June 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Sanction Letter</h4></li>
                                                <ul>
                                                    <li>Replaced sanction letter content.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.51.0
                                                <small class="pull-right">06<sup>th</sup>May 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li>OD Report date set to current month.</li>
                                                <li>Data-dump & Cibil data-dump file updated.</li>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.50.1
                                                <small class="pull-right">06<sup>th</sup>May 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfixes</h4></li>
                                                <ul>
                                                    <li>OD Report date set to current month.</li>
                                                    <li>Data-dump & Cibil data-dump file updated.</li>
                                                </ul>
                                            </ul>    
                                        </div>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.50.0
                                                <small class="pull-right">03<sup>rd</sup>May 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Disbursement Notification</h4></li>
                                                <ul>
                                                    <li>Disbursement Email content changed as per the release documentation v3.41.0.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.49.0
                                                <small class="pull-right">29<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>PDC & ACH</h4></li>
                                                <ul>
                                                    <li>Displaying list of disbursed cases for this month with PDC & ACH details.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.48.1
                                                <small class="pull-right">26<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>CIBIL DATA Date Format</h4></li>
                                                <ul>
                                                    <li>Modified CIBIL Data Date Format (dmY) as per Jay.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.48.0
                                                <small class="pull-right">26<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>MIS Data Dump</h4></li>
                                                <ul>
                                                    <li>Added a menu to download data dump of last month.</li>
                                                </ul>
                                                <li><h4>CIBIL Data Dump</h4></li>
                                                <ul>
                                                    <li>Added a menu to download CIBIL data dump till date.</li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.47.0
                                                <small class="pull-right">26<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Closure Report</h4></li>
                                                <ul>
                                                    <li>Generate a CSV File which list oout all the Disbursed & Closed Loan Cases, where Outstanding Principal amount is equal to zero or less then zero.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.46.0
                                                <small class="pull-right">26<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Today's Disbursement</h4></li>
                                                <ul>
                                                    <li>List of all the Sanctioned Applications with Disbursed-documents uploaded. User can also download the same data with the help of Export Button.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.45.1
                                                <small class="pull-right">19<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Principal Adjustment</h4></li>
                                                <ul>
                                                    <li>Displaying Account Repayment Principal Adjustment amount if no permission is given.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.45.0
                                                <small class="pull-right">19<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Added Entrust for Principal Adjustment</h4></li>
                                                <ul>
                                                    <li>Added permission to update Account Repayment Principal Adjustment.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.44.0
                                                <small class="pull-right">19<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Outstanding Report</h4></li>
                                                <ul>
                                                    <li>Once Application stage is marked as Closed, system will automatically update the record of outstanding report.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.43.0
                                                <small class="pull-right">19<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection Report</h4></li>
                                                <ul>
                                                    <li>Added a menu "Collection Report" in siderbar under Maser Report menu.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.42.2
                                                <small class="pull-right">18<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection Import</h4></li>
                                                <ul>
                                                    <li>Allowing to Import collection data of Disbursed & Closed Stage.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.42.0
                                                <small class="pull-right">18<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Collection Update</h4></li>
                                                <ul>
                                                    <li>Modifiedi Collection & Repayment Logic.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.41.0
                                                <small class="pull-right">16<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Partner Permissions</h4></li>
                                                <ul>
                                                    <li>Enabled Update Application Button with the below list of permission.
                                                    </li>
                                                    <ul>
                                                        <li>Complete Partial Application</li>
                                                        <li>Generate Sanction Letter</li>
                                                        <li>Generate Sanction Letter (Medtronic)</li>
                                                        <li>Generate Sanction Letter (Credit Mantri)</li>
                                                        <li>Generate sanction letter</li>
                                                        <li>Most Important Document</li>
                                                        <li>Demand Promissory Note</li>
                                                        <li>Download Repayment cheque</li>
                                                        <li>Add repayment cheque</li>
                                                        <li>Add Nominee</li>
                                                        <li>Reject Application</li>
                                                        <li>Add Reference</li>
                                                        <li>Download Application Summary</li>
                                                        
                                                    </ul>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.40.0
                                                <small class="pull-right">09<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Revert Stage</h4></li>
                                                <ul>
                                                    <li>Added option to change application stage in Update Application Menu.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.39.0
                                                <small class="pull-right">09<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Sales Representative</h4></li>
                                                <ul>
                                                    <li>Added Sales Representative Role with limited permissions.
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.38.0
                                                <small class="pull-right">09<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Hospital Dropdown</h4></li>
                                                <ul>
                                                    <li>Added a dropdown in Patient detail section to select hospital name. 
                                                    </li>
                                                </ul>
                                            </ul>    
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.37.0
                                                <small class="pull-right">05<sup>th</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Document Upload</h4></li>
                                                <ul>
                                                    <li>Enabled Documents upload via Arogya Mobile App.
                                                    </li>
                                                </ul>
                                                <li><h4>Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Enabled Apply for Psychometric Test via Arogya Mobile App.
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.35.1
                                                <small class="pull-right">03<sup>rd</sup> April 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>SMS Notification</h4></li>
                                                <ul>
                                                    <li>Enabled SMS Notification for borrower via Arogya Mobile App.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.35.0
                                                <small class="pull-right">29<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Mobile API's Integration</h4></li>
                                                <ul>
                                                    <li>Arogya Team can use Arogya Mobile App to apply for Loan/Card Applications.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.34.0
                                                <small class="pull-right">28<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Activate/Deactivate User's Account</h4></li>
                                                <ul>
                                                    <li>When a new user is created, it is set to Activated by default. We had added a option to Activate/Deactivate a user account once it is greated.</li>
                                                    <li>Admin can view all the Account Activity logs under Manage Staff menu.</li>
                                                </ul>
                                                <li><h4>Disable Notification for Deactivated User</h4></li>
                                                <ul>
                                                    <li>Once a user account is deactivated, system will stop all the system generated Notifications for the user.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.33.0
                                                <small class="pull-right">28<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Complete Parital Application Form</h4></li>
                                                <ul>
                                                    <li>Enabled Update Application button in application show page for users to complete partial application.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.32.6
                                                <small class="pull-right">15<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>BugFix</h4></li>
                                                <ul>
                                                    <li>Removed Option to select Admin from Manage Locations menu.</li>
                                                    <li>Display the Admin name related to that location.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.32.5
                                                <small class="pull-right">15<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>BugFix</h4></li>
                                                <ul>
                                                    <li>Fixed Family Memerbs Regional form for English,Kannada,Malayalam Languages.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.32.4
                                                <small class="pull-right">15<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>BugFix</h4></li>
                                                <ul>
                                                    <li>Sending Pre-Approved Application SMS Notification to FC, Credit-manager & Partner only if Application belong to category 1 Or Category 2 were Psychometric Test is Accepted.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.32.3
                                                <small class="pull-right">13<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>BugFix</h4></li>
                                                <ul>
                                                    <li>Resolved issue where admin were not able to remove locations.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.32.2
                                                <small class="pull-right">11<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Send Mail to Multiple FC</h4></li>
                                                <ul>
                                                    <li>Based on the Location & FC mapping FC receives SMS & Email Notification regarding application status.</li>
                                                </ul>
                                                <li><h4>Mapping Multiple Users to Location</h4></li>
                                                <ul>
                                                    <li>If a location has multiple users for the same location, they all share the applications allocated to that location.
                                                    </li>
                                                </ul>
                                                <li><h4>Bugfix - Verify Email Notification</h4></li>
                                                <ul>
                                                    <li>Fixed Bug where email was not sent on verification of application.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.32.0
                                                <small class="pull-right">05<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Apply For Top up</h4></li>
                                                <ul>
                                                    <li>
                                                        Added a menu in User Dashboard to apply for Card top up.
                                                    </li>
                                                </ul>
                                                <li><h4>Mapping Multiple Users to Location</h4></li>
                                                <ul>
                                                    <li>If a location has multiple users for the same location, they all share the applications allocated to that location.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.30.2
                                                <small class="pull-right">08<sup>th</sup> March 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Bugfix Partner Email Notification</h4></li>
                                                <ul>
                                                    <li>updated logic for sending the email notification to hospitals & partners.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.30.0
                                                <small class="pull-right">22<sup>nd</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Email Notification</h4></li>
                                                <ul>
                                                    <li>When a partner application is
                                                        sanctioned, a formal email is sent to Hospital & Partner with attached sanction letter.
                                                    </li>
                                                    <li>When a partner application is
                                                        disbursed, a formal email is sent to Hospital & Partner.
                                                    </li>
                                                    <li>Fetch the list of applications
                                                        disbursed last week based on disbursement date(Last Monday to this Sunday ). E.g If todayâ€™s date is 22 Feb 2019,
                                                        We fetch the Partner(sistema) applications where are disbursed between 11 Feb 2019 & 18 Feb 2019 and send email to respective hospitals (based on schedule time Every Monday at 11:00 AM).
                                                    </li>
                                                </ul>
                                                <li><h4>Hospital POC</h4></li>
                                                <ul>
                                                    <li>Under Hospital Management Menu, added a option to update hospital name, mobile number & email address.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.28.1
                                                <small class="pull-right">20<sup>th</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Welcome Letter Issue Resolved</h4></li>
                                                <ul>
                                                    <li>Replaced 5th of every month to dynamic day based on valid from date.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.28.0
                                                <small class="pull-right">15<sup>th</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>SMS Notification</h4></li>
                                                <ul>
                                                    <li>Removed document uploaded check from SMS notification section.
                                                    </li>
                                                    <li>Sending sms to partner regarding the application.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.27.0
                                                <small class="pull-right">15<sup>th</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Financial Calculation Updated</h4></li>
                                                <ul>
                                                    <li>Updated financial calculation logic.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.26.0
                                                <small class="pull-right">6<sup>th</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Remove Assets</h4></li>
                                                <ul>
                                                    <li>Remove the assets detail section from the Financial Detail form.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.25.0
                                                <small class="pull-right">6<sup>th</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>SMS Notification (FC & Credit Manager)</h4></li>
                                                <ul>
                                                    <li>After successful submission of loan / card application, along with borrower now Financial Counsellor  & Credit Manager will receive SMS notification regarding the application.
                                                    </li>
                                                    <li></li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.24.3
                                                <small class="pull-right">4<sup>th</sup> February 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>CIBIL Score</h4></li>
                                                <ul>
                                                    <li>Added entrust to update CIBIL Score.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.24.2
                                                <small class="pull-right">30<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>MID</h4></li>
                                                <ul>
                                                    <li>Added Documentation Charge with GST amount in MID Letter.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.24.1
                                                <small class="pull-right">29<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Custom Hospital Name</h4></li>
                                                <ul>
                                                    <li>Customer can enter the hospital name of their choice while filling personal detail form.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.24.0
                                                <small class="pull-right">24<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Hospital Hierarchy</h4></li>
                                                <ul>
                                                    <li>Added option to select hospital hierarchy.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.23.0
                                                <small class="pull-right">22<sup>nd</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Partner Notes</h4></li>
                                                <ul>
                                                    <li>Added partner notes under internal detail section.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.22.0
                                                <small class="pull-right">16<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Analytics MIS Date Filter</h4></li>
                                                <ul>
                                                    <li>Modified MIS Analytics date filter, replaced year & month date filter with From & To date filter.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>

                                        <hr>
                                        <div class="header">
                                            <h3> V  3.21.0
                                                <small class="pull-right">15<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Topup Applications</h4></li>
                                                <ul>
                                                    <li>Added a button in user dashboard to apply for top-up applications.
                                                    </li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.20.0
                                                <small class="pull-right">14<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Dashboard Search Result</h4></li>
                                                <ul>
                                                    <li>Search result wil display data based on user(FC) logged into the system.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.19.0
                                                <small class="pull-right">11<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Merchant Applications Data</h4></li>
                                                <ul>
                                                    <li>Merchant can only fetch and query the applications related to them.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.18.0
                                                <small class="pull-right">11<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Added Psychometric Test Result in API</h4></li>
                                                <ul>
                                                    <li>Merchant can view the psychometric test result while fetching applications detail</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.17.0
                                                <small class="pull-right">10<sup>th</sup> January 2019</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Dashboard Updates</h4></li>
                                                <ul>
                                                    <li>Disbursement date - enable to edit disbursement date.</li>
                                                    <li>Enable menu to download Sanction,MID & DPN after sanction stage.</li>
                                                    <li>Display primary borrower first followed by co-borrower & guarantor.</li>
                                                    <li>Remove delete button from search result.</li>
                                                    <li>Rename lead applications to partial application from loan & card application
                                                    menu.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.12.1
                                                <small class="pull-right">21<sup>st</sup> December 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>EMI Notifications</h4></li>
                                                <ul>
                                                    <li>EMI Notification is sent to all the borrowers whoes EMI need tobe collected based on A/C repayment schedule.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.11.1
                                                <small class="pull-right">21<sup>st</sup> December 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>CIBIL Deduplication (Release #001)</h4></li>
                                                <ul>
                                                    <li>If a new application comes in it will be checked against CIBIL duplication.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.10.1
                                                <small class="pull-right">16<sup>th</sup> November 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Outstanding Principal Report</h4></li>
                                                <ul>
                                                    <li>Added Outstanding Principal as sub-menu in
                                                    Master Report menu for generating all disbursed cases outstanding principal report.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.9.1
                                                <small class="pull-right">3<sup>rd</sup> October 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Digio (Mandate creation)</h4></li>
                                                <ul>
                                                    <li>Added a menu in User Dashboard to apply for Mandate once mandate is created & signed, it's status will be displayed in User Dashboard & Backend.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.8.1
                                                <small class="pull-right">10<sup>th</sup> September 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Delete Borrower Bug</h4></li>
                                                <ul>
                                                    <li>Resolved</li>
                                                </ul>
                                            </ul>
                                        </div>
                                   
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.8.0
                                                <small class="pull-right">31<sup>st</sup> August 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Lead Applications</h4></li>
                                                <ul>
                                                    <li>Added Lead applications as sub-menu in Loan & Card Applicaitons</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.7.0
                                                <small class="pull-right">1<sup>st</sup> August 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Birthday Card</h4></li>
                                                <ul>
                                                    <li>Happy Birthday Email will be sent to all the borrower's having birthday daily at 8AM.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    
                                        <hr>
                                        <div class="header">
                                            <h3> V  3.6.0
                                                <small class="pull-right">21<sup>st</sup> July 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Psychometric Test</h4></li>
                                                <ul>
                                                    <li>Old Psychometric test system is replaced with the new Psychometric test system.</li>
                                                </ul>
                                                <li><h4>Category based document upload</h4></li>
                                                <ul>
                                                    <li>Based on the category of application document need to be uploaded.
                                                    </li>
                                                </ul>
                                                <li><h4>Lead Import</h4></li>
                                                <ul>
                                                    <li>Added product option in lead.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    
                                        <hr>
                                        <div class="header">
                                            <h3> V  2.4.0
                                                <small class="pull-right">4<sup>th</sup> July 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Today's Disbursement</h4></li>
                                                <ul>
                                                    <li>Added new feature in menu to view and export todays disbursed applications.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    
                                        <hr>
                                        <div class="header">
                                            <h3> V  2.3.0
                                                <small class="pull-right">4<sup>th</sup> July 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Repayment Schedule</h4></li>
                                                <ul>
                                                    <li>Added new menu under application update button i.e Repayment schedule (auto-generated for each application).</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    
                                        <hr>
                                        <div class="header">
                                            <h3> V  2.2.0
                                                <small class="pull-right">4<sup>th</sup> July 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>Category Breakdown</h4></li>
                                                <ul>
                                                    <li>Reworked on category breakdown based on cibil score.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    
                                        <hr>
                                        <div class="header">
                                            <h3> V  2.1.0
                                                <small class="pull-right">28<sup>th</sup> April 2018</small>
                                            </h3>
                                        </div>
                                        <div class="body">
                                            <ul>
                                                <li><h4>AWS</h4></li>
                                                <ul>
                                                    <li>Moved Arogya to AWS server.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

