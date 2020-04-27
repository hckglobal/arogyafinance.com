# Changelog

All notable changes of this project.


## Released

## 3.94.0 - April 16, 2020
- fore closure done

## Released

## 3.93.1 - Mar 13, 2020

### Collection Import Report

- Modified collection import mail content & report data.

## 3.93.0 - Mar 13, 2020

### Revised Eligibility For Psychometric Test

- Revised psychometric test eligibility.

## 3.92.0 - Mar 12, 2020

### Collection Import Error 

- If there is error while importing collection data email will be sent along with the attachment to the user.

## 3.91.0 - Feb 11, 2020

### CIBIL Data Log Report 

- Added menu in master report to generate cibil data log report.

## 3.90.0 - Mar 02, 2020

### Collection & Bounce List		

- Added option to import collection & bounce data at the same time.

## 3.89.0 - Feb 25, 2020

### Application Internal Detail		

- Added permission to update application internal details.

## 3.88.0 - Feb 25, 2020

### Mandate Status		

- Added mandate status and UMRN no. in application show page.

## 3.87.2 - Feb 25, 2020

### Disbursement Email		

- Removed sonali signature image from email content.

## 3.87.1 - Feb 25, 2020

### Penalty Report		

- Added application status and NDC status in penalty report.

## 3.87.0 - Feb 25, 2020

### Penalty Report		

- Added penalty report to master report menu.

## 3.86.0 - Feb 24, 2020

### Report Based On location & Role		

- Added logic to filter user applications various reports based on location & role.

## 3.85.1 - Feb 24, 2020

### Disbursement mail to FC	

- Fixed issue were FC was unable to receive email notification of disbursement.

## 3.85.0 - Feb 24, 2020

### Role Bases Closure Charges 

- Added funcationality to assign loan closure charges to each role.

## 3.84.3 - Feb 20, 2020

### Ingenico Integration 

- Fixed mandate doesn't exist error and added option to retry.
- Added role & logic to fetch finance-partner applications.

## 3.84.2 - Feb 18, 2020

### Ingenico Integration 

- Fixed mandate doesn't exist error issue.

## 3.84.1 - Feb 18, 2020

### Poonawalla Finance 

- If case status is verified / sanctioned /disbursed /closed or ahead button will be visible to send the application to poonawalla.

## 3.84.0 - Feb 18, 2020

### Ingenico Integration 

- Added option in user dashboard to apply for E-mandate.

## 3.83.0 - Feb 17, 2020

### Poonawalla Finance 

- User can mark the application as poonawala by clicking on send to poonawala button in application show page.

## Released

## 3.82.1 - Feb 11, 2020

### Collection Import 

- Updated collection import emi payment date format issue.

## 3.82.0 - Feb 10, 2020

### Psychometric Test 

- Updated psychometric test flow.

## 3.80.0 - Feb 04, 2020

### Disbursement Email Notification 

- Sending disbursement mail of hospital email content to FC.

## 3.79.2 - Jan 28, 2020

### Analytics Report & Datepicker 

- Modified disbursement date format.
- Fixed date-picker issue for previous and next month button.

## 3.79.0 - Jan 28, 2020

### Disbursal Flow

- Disbursed button to be visible only if repayment-cheque & bank detail are added.

## 3.78.0 - Jan 28, 2020

### Internal Detail Section

- Added dropdown options for mode of payment and mapped old data with dropdown options.

## 3.77.4 - Jan 23, 2020

### Analytic Reports

- Fixed analytics report issue for sanction export.

## 3.77.3 - Jan 23, 2020

### Master Reports

- Added permissions to generate master reports.

## 3.77.2 - Jan 23, 2020

### Analytics

- Modificied disbursement date format and displaying disbursed data in chronological order.

## 3.77.1 - Jan 21, 2020

### OD Report

- Added disbursement date in OD report.

## 3.77.0 - Jan 15, 2020

### Income Computation Report

- Added status and closed cases in report.

## 3.76.0 - Jan 14, 2020

### Sanction Expire Logic

- Added a logic to check if case was sanctioned 1 month earlier and also added check for od in pdc report.

## 3.75.4 - Jan 14, 2020

### Repayment Cheque

- Fixed date-selector alignment issue and added ACH to dropdown option with pre-fill borrower name.

### Website Header

- Added Contact Us menu in website header.

### Psychometric Test

- Fixed mobile app psychometric test bug.

### PDC Report

- Added check for current month pdc.

## 3.75.0 - Jan 09, 2020

### Overdue Report

- Fixed contract amount issue and added logic to generate user-basis report.

## 3.74.1 - Jan 08, 2020

### Bugfix

- Fixed MID letter alignment issue.

## 3.74.0 - Jan 08, 2020

### Psychometric Test

- Updated new psychometric test system to arogya system.

## 3.73.2 - Dec 31, 2019

### Bugfixes

- Fixed loan closure bug where advance emi is shown as od amount in od report and loan closure.

## 3.73.1 - Dec 23, 2019

### Optimization 

- Optimized OD Report generation & fixed loan closure total amount bug.

## 3.73.0 - Dec 23, 2019

### Optimization 

- Optimized system generated reports.

## 3.72.0 - Dec 23, 2019

### Loan Closure & Collection Import

- Added a button in account repayment page to view loan closure detail.
- Added a button in collection to mark collected collect as bounce and update the account repayment accordingly.

## 3.70.0 - Dec 18, 2019

### Modification 

- Added legal disclaimer in footer section.

## 3.69.5 - Dec 17, 2019

### Modification 

- Added CIBIL score to analytics export report.

## 3.69.4 - Dec 12, 2019

### Bugfix 

- Fixed mobile application borrower form submission error.

## 3.69.3 - Dec 11, 2019

### Backend Bugfix

- Added all the backend routes to auth middleware.

## 3.69.2 - Dec 10, 2019

### Import ACH modification

- Added conidtion while importing ACH data. i.e application must be of loan type and status must be disbursed or closed. 

## 3.69.1 - Dec 10, 2019

### Bugfix

- Fixed issue where deactivated users were able to login into the system.

## 3.69.0 - Dec 10, 2019

### ACH Import

- Added a button to import ACH data in EMI Report menu.

## 3.68.0 - Dec 09, 2019

### Dedup Logic

- Modified dedup logic. Added logic to match incoming lead detail with aadhar-card, pan-card & id-proof-number.

## 3.68.0 - Nov 15, 2019

### Mobile App Dedup

- Added website dedup logic to mobile application api.