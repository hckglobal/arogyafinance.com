<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Excel;
use DB;
use App\Application;

class CibilDataDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CibilDataDump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Cibil Data Dump from applications,borrower & patient data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $applications = Application::where('type','loan')
            /*->whereIN('id',[3])*/
            ->whereIN('status',['disbursed','closed'])
            ->get();
        //dd($applications);
        $this->exportDataDump($applications);
    }

    public function exportDataDump($applications)
    {
        Excel::create('CIBIL_Data_Dump', function($excel) use ($applications) {
            $excel->sheet('CIBIL-Data-'.Carbon::now()->format('j f Y'), function($sheet) use($applications) {       
                $arr1 =array();
                foreach ($applications as $application) {
                    $borrowers = $application->borrowers;
                    $patient = $application->patient;
                    foreach ($borrowers as $borrower) {
                        $borrower_data = array(
                            $borrower->first_name.' '.$borrower->middle_name.' '.$borrower->last_name,
                            Carbon::parse($borrower->getOriginal('date_of_birth'))->format('dmY'),
                            $borrower->gender,
                            $borrower->pan_card_number,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $borrower->aadhar_card_number,
                            '',
                            '',
                            $borrower->mobile_number,
                            '',
                            '',
                            '',
                            $borrower->alternate_number,
                            '',
                            $borrower->email,
                            '',
                            $borrower->address_line_1.' '.$borrower->address_line_2,
                            $borrower->state,
                            $borrower->pincode,
                            '02',
                            $borrower->residence_type,
                            '',
                            $borrower->state,
                            '',
                            '',
                            '',
                            'NB70010001',
                            'RAMTIRTH LEASING',
                            $application->pin_number,
                            '00',
                            $borrower->type,
                            Carbon::parse($application->getOriginal('disbursement_date'))->format('dmY'),
                            '',
                            Carbon::parse($application->getOriginal('valid_upto'))->format('dmY'),
                            Carbon::now()->format('dmY'),
                            $application->approved_loan_amount,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '00',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $application->approved_loan_tenure,
                            $application->approved_loan_emi,
                            '',
                            '',
                            '',
                            '03',
                            '',
                            $borrower->nature_of_income,
                            $borrower->borrowers_income,
                            'N',
                            'M',
                            ''
                        );
                        array_push($arr1, $borrower_data);
                    }

                    $patient_data =  array(
                        $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name,
                        Carbon::parse($patient->date_of_birth)->format('dmY'),
                        $patient->gender,
                        $patient->pan_card,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $patient->aadhar_card,
                        '',
                        '',
                        $patient->mobile_number,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $patient->address_line_1.' '.$patient->address_line_2,
                        $patient->state,
                        $patient->pincode,
                        '02',
                        '',
                        '',
                        $patient->state,
                        '',
                        '',
                        '',
                        'NB70010001',
                        'RAMTIRTH LEASING',
                        $application->pin_number,
                        '00',
                        'co-borrower',
                        Carbon::parse($application->getOriginal('disbursement_date'))->format('dmY'),
                        '',
                        Carbon::parse($application->getOriginal('valid_upto'))->format('dmY'),
                        Carbon::now()->format('dmY'),
                        $application->approved_loan_amount,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '00',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        $application->approved_loan_tenure,
                        $application->approved_loan_emi,
                        '',
                        '',
                        '',
                        '03',
                        '',
                        '',
                        '',
                        'N',
                        'M',
                        ''
                    );
                    array_push($arr1, $patient_data);
                }
                //set the titles
                $sheet->fromArray($arr1,null,'A1',false,false)
                    ->prependRow(array(
                        'Consumer Name',
                        'Date of Birth',
                        'Gender',
                        'IncomeTaxIDNumber',
                        'Passport Number',
                        'Passport Issue Date',
                        'Passport Expiry Date',
                        'Voter ID Number',
                        'Driving License Number',
                        'Driving License Issue Date',
                        'Driving License Expiry Date',
                        'Ration Card Number',
                        'Universal ID Number',
                        'Additional ID #1',
                        'Additional ID #2',
                        'Telephone No.Mobile',
                        'Telephone No.Residence',
                        'Telephone No.Office',
                        'Extension Office',
                        'Telephone No.Other ',
                        'Extension Other',
                        'Email ID 1',
                        'Email ID 2',
                        'Address Line 1',
                        'State Code 1',
                        'PIN Code 1',
                        'Address Category 1',
                        'Residence Code 1',
                        'Address Line 2',
                        'State Code 2',
                        'PIN Code 2',
                        'Address Category 2',
                        'Residence Code 2',
                        'Current/New Member Code',
                        'Current/New Member Short Name',
                        'Curr/New Account No',
                        'Account Type',
                        'Ownership Indicator',
                        'Date Opened/Disbursed',
                        'Date of Last Payment',
                        'Date Closed',
                        'Date Reported',
                        'High Credit/Sanctioned Amt',
                        'Current  Balance',
                        'Amt Overdue',
                        'No of Days Past Due',
                        'Old Mbr Code',
                        'Old Mbr Short Name',
                        'Old Acc No',
                        'Old Acc Type',
                        'Old Ownership Indicator',
                        'Suit Filed / Wilful Default',
                        'Writtenoff and Settled Status',
                        'Asset Classification',
                        'Value of Collateral',
                        'Type of Collateral',
                        'Credit Limit',
                        'Cash Limit',
                        'Rate of Interest',
                        'RepaymentTenure',
                        'EMI Amount',
                        'Written off Amount (Total) ',
                        'Written off Principal Amount',
                        'Settlement Amt',
                        'Payment Frequency',
                        'Actual Payment Amt',
                        'Occupation Code',
                        'Income',
                        'Net/Gross Income Indicator',
                        'Monthly/Annual Income Indicator',
                        'Error'
                    )
                );
            });
        })->store('xlsx', public_path().'/DataDump', true);
    }
}
