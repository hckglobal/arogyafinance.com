<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;
use App\Admin;
use App\Hospital;
use Excel;
use DB;

class DataDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DataDump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate DataDump for applications,borrower & patient data';

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
        $previous_month = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $applications = DB::table('applications')
            ->where('applications.created_at','<=',$previous_month)
            ->leftjoin('borrowers', function ($join) {
                $join->on('applications.id', '=', 'borrowers.application_id')
                     ->where('borrowers.type', '=','primary');
            })
            ->leftjoin('patients', function ($join) {
                $join->on('applications.id', '=', 'patients.application_id');
            })
            ->leftjoin('locations', function ($join) {
                $join->on('locations.id', '=', 'applications.location_id');
            })
            ->leftjoin('products', function ($join) {
                $join->on('products.id', '=', 'applications.product_id');
            })
            ->select('applications.id','applications.type','applications.cibil_score','applications.hospital_name',
                     'applications.approved_hospital_name','applications.total_borrowers_income','applications.calculated_income',
                     'applications.calculated_loan_amount','applications.calculated_loan_emi','applications.calculated_loan_tenure',
                     'applications.approved_loan_amount','applications.approved_loan_emi','applications.approved_loan_tenure',
                     'applications.treatment_type','applications.estimated_cost','applications.loan_required','applications.status',
                     'applications.other_expense','applications.requested_tenure','applications.requested_emi',
                     'applications.interest_rate','applications.subvention','applications.processing_fee','applications.pin_number',
                     'applications.reference_code','applications.created_at','applications.updated_at','applications.referrer_id',
                     'applications.referrer_company_id','applications.valid_from','applications.valid_upto',
                     'applications.disbursement_date','applications.product_id','applications.location_id','applications.card_no',
                     'applications.rejection_reason_id','applications.partner_reference_code','applications.arogya_card_id',
                     'applications.rejection_note','applications.enable_psychometric_test','applications.test_language',
                     'applications.documentation_charge','applications.advance_emi','applications.dmi_status',
                     'applications.dmi_issue_date','applications.dmi_sent','applications.self_patient','applications.merchant',
                     'applications.mode_of_payment','applications.foir','applications.bank_customer_name','applications.bank_name',
                     'applications.bank_account_number','applications.lead_id','applications.bank_account_type',
                     'applications.bank_ifsc_code','applications.closer_reason_id','applications.closer_note','applications.closer_date',
                     'applications.ndc_sent',
                     'borrowers.id as borrower_id','borrowers.type as borrower_type',
                     'borrowers.first_name as borrower_first_name',
                     'borrowers.middle_name as borrower_middle_name',
                     'borrowers.last_name as borrower_last_name',
                     'borrowers.date_of_birth as borrower_date_of_birth',
                     'borrowers.gender as borrower_gender',
                     'borrowers.mobile_number as borrower_mobile_number',
                     'borrowers.email as borrower_email',
                     'borrowers.residence_type as borrower_residence_type',
                     'borrowers.city as borrower_city',
                     'borrowers.state as borrower_state',
                     'borrowers.pincode as borrower_pincode',
                     'borrowers.address_line_1 as borrower_address_line_1',
                     'borrowers.address_line_2 as borrower_address_line_2',
                     'borrowers.marital_status as borrower_marital_status',
                     'borrowers.borrowers_income as borrower_borrowers_income',
                     'borrowers.earning_since as borrower_earning_since',
                     'borrowers.nature_of_income as borrower_nature_of_income',
                     'borrowers.source_of_income as borrower_source_of_income',
                     'borrowers.employer_details as borrower_employer_details',
                     'borrowers.name_of_firm as borrower_name_of_firm',
                     'borrowers.income_itr as borrower_income_itr',
                     'borrowers.current_loan_emi as borrower_current_loan_emi',
                     'borrowers.education_expenses as borrower_education_expenses',
                     'borrowers.house_rent as borrower_house_rent',
                     'borrowers.number_of_dependants as borrower_number_of_dependants',
                     'borrowers.other_earnings as borrower_other_earnings',
                     'borrowers.other_earnings_type as borrower_other_earnings_type',
                     'borrowers.monthly_emi_possible as borrower_monthly_emi_possible',
                     'borrowers.id_proof_type as borrower_id_proof_type',
                     'borrowers.id_proof_number as borrower_id_proof_number',
                     'borrowers.pan_card_number as borrower_pan_card_number',
                     'borrowers.aadhar_card_number as borrower_aadhar_card_number',
                     'borrowers.created_at as borrower_created_at',
                     'borrowers.updated_at as borrower_updated_at',
                     'borrowers.alternate_number as borrower_alternate_number',
                     'borrowers.relation_with_patient as borrower_relation_with_patient',
                     'borrowers.residing_since as borrower_residing_since',
                     'borrowers.permanent_address as borrower_permanent_address',
                     'borrowers.permanent_city as borrower_permanent_city',
                     'borrowers.permanent_state as borrower_permanent_state',
                     'borrowers.permanent_pincode as borrower_permanent_pincode',
                     'patients.id as patient_id',
                     'patients.first_name as patient_first_name',
                     'patients.middle_name as patient_middle_name',
                     'patients.last_name as patient_last_name',
                     'patients.date_of_birth as patient_date_of_birth',
                     'patients.gender as patient_gender',
                     'patients.mobile_number as patient_mobile_number',
                     'patients.created_at as patient_created_at',
                     'patients.updated_at as patient_updated_at',
                     'patients.address_line_1 as patient_address_line_1',
                     'patients.address_line_2 as patient_address_line_2',
                     'patients.city as patient_city',
                     'patients.state as patient_state',
                     'patients.pincode as patient_pincode',
                     'patients.pan_card as patient_pan_card',
                     'patients.aadhar_card as patient_aadhar_card',
                     'patients.driving_id as patient_driving_id',
                     'patients.voting_id as patient_voting_id',
                     'patients.residing_since as patient_residing_since',
                     'patients.marital_status as patient_marital_status',
                     'patients.permanent_address as patient_permanent_address',
                     'patients.permanent_city as patient_permanent_city',
                     'patients.permanent_state as patient_permanent_state',
                     'patients.permanent_pincode as patient_permanent_pincode'
            )->get();
            //dd($applications);
        $this->exportDataDump($applications);
    }

    public function exportDataDump($applications)
    {
        Excel::create('DataDump', function($excel) use ($applications) {
            $excel->sheet(Carbon::now()->format('j f Y'), function($sheet) use($applications) {       
                $arr1 =array();
                foreach ($applications as $key => $application) {
                    $application_data =  array(
                        $application->id,
                        $application->type,
                        $application->cibil_score,
                        $application->hospital_name,
                        $application->approved_hospital_name,
                        $application->total_borrowers_income,
                        $application->calculated_income,
                        $application->calculated_loan_amount,
                        $application->calculated_loan_emi,
                        $application->calculated_loan_tenure,
                        $application->approved_loan_amount,
                        $application->approved_loan_emi,
                        $application->approved_loan_tenure,
                        $application->treatment_type,
                        $application->estimated_cost,
                        $application->loan_required,
                        $application->status,
                        $application->other_expense,
                        $application->requested_tenure,
                        $application->requested_emi,
                        $application->interest_rate,
                        $application->subvention,
                        $application->processing_fee,
                        $application->pin_number,
                        $application->reference_code,
                        $application->created_at,
                        $application->updated_at,
                        $application->referrer_id,
                        $application->referrer_company_id,
                        $application->valid_from,
                        $application->valid_upto,
                        $application->disbursement_date,
                        $application->product_id,
                        $application->location_id,
                        $application->card_no,
                        $application->rejection_reason_id,
                        $application->partner_reference_code,
                        $application->arogya_card_id,
                        $application->rejection_note,
                        $application->enable_psychometric_test,
                        $application->test_language,
                        $application->documentation_charge,
                        $application->advance_emi,
                        $application->dmi_status,
                        $application->dmi_issue_date,
                        $application->dmi_sent,
                        $application->self_patient,
                        $application->merchant,
                        $application->mode_of_payment,
                        $application->foir,
                        $application->bank_customer_name,
                        $application->bank_name,
                        $application->bank_account_number,
                        $application->lead_id,
                        $application->bank_account_type,
                        $application->bank_ifsc_code,
                        $application->closer_reason_id,
                        $application->closer_note,
                        $application->closer_date,
                        $application->ndc_sent,
                        $application->borrower_id,
                        $application->borrower_type,
                        $application->borrower_first_name,
                        $application->borrower_middle_name,
                        $application->borrower_last_name,
                        $application->borrower_date_of_birth,
                        $application->borrower_gender,
                        $application->borrower_mobile_number,
                        $application->borrower_email,
                        $application->borrower_residence_type,
                        $application->borrower_city,
                        $application->borrower_state,
                        $application->borrower_pincode,
                        $application->borrower_address_line_1,
                        $application->borrower_address_line_2,
                        $application->borrower_marital_status,
                        $application->borrower_borrowers_income,
                        $application->borrower_earning_since,
                        $application->borrower_nature_of_income,
                        $application->borrower_source_of_income,
                        $application->borrower_employer_details,
                        $application->borrower_name_of_firm,
                        $application->borrower_income_itr,
                        $application->borrower_current_loan_emi,
                        $application->borrower_education_expenses,
                        $application->borrower_house_rent,
                        $application->borrower_number_of_dependants,
                        $application->borrower_other_earnings,
                        $application->borrower_other_earnings_type,
                        $application->borrower_monthly_emi_possible,
                        $application->borrower_id_proof_type,
                        $application->borrower_id_proof_number,
                        $application->borrower_pan_card_number,
                        $application->borrower_aadhar_card_number,
                        $application->borrower_created_at,
                        $application->borrower_updated_at,
                        $application->borrower_alternate_number,
                        $application->borrower_relation_with_patient,
                        $application->borrower_residing_since,
                        $application->borrower_permanent_address,
                        $application->borrower_permanent_city,
                        $application->borrower_permanent_state,
                        $application->borrower_permanent_pincode,
                        $application->patient_id,
                        $application->patient_first_name,
                        $application->patient_middle_name,
                        $application->patient_last_name,
                        $application->patient_date_of_birth,
                        $application->patient_gender,
                        $application->patient_mobile_number,
                        $application->patient_created_at,
                        $application->patient_updated_at,
                        $application->patient_address_line_1,
                        $application->patient_address_line_2,
                        $application->patient_city,
                        $application->patient_state,
                        $application->patient_pincode,
                        $application->patient_pan_card,
                        $application->patient_aadhar_card,
                        $application->patient_driving_id,
                        $application->patient_voting_id,
                        $application->patient_residing_since,
                        $application->patient_marital_status,
                        $application->patient_permanent_address,
                        $application->patient_permanent_city,
                        $application->patient_permanent_state,
                        $application->patient_permanent_pincode
                        );
                    array_push($arr1, $application_data);
                }
                //set the titles
                $sheet->fromArray($arr1,null,'A1',false,false)->prependRow(array(
                        'id','type','cibil_score','hospital_name','approved_hospital_name','total_borrowers_income','calculated_income','calculated_loan_amount','calculated_loan_emi','calculated_loan_tenure','approved_loan_amount','approved_loan_emi','approved_loan_tenure','treatment_type','estimated_cost','loan_required','status','other_expense','requested_tenure','requested_emi','interest_rate','subvention','processing_fee','pin_number','reference_code','created_at','updated_at','referrer_id','referrer_company_id','valid_from','valid_upto','disbursement_date','product_id','location_id','card_no','rejection_reason_id','partner_reference_code','arogya_card_id','rejection_note','enable_psychometric_test','test_language','documentation_charge','advance_emi','dmi_status','dmi_issue_date','dmi_sent','self_patient','merchant','mode_of_payment','foir','bank_customer_name','bank_name','bank_account_number','lead_id','bank_account_type','bank_ifsc_code','closer_reason_id','closer_note','closer_date','ndc_sent','borrower_id','borrower_type','borrower_first_name','borrower_middle_name','borrower_last_name','borrower_date_of_birth','borrower_gender','borrower_mobile_number','borrower_email','borrower_residence_type','borrower_city','borrower_state','borrower_pincode','borrower_address_line_1','borrower_address_line_2','borrower_marital_status','borrower_borrowers_income','borrower_earning_since','borrower_nature_of_income','borrower_source_of_income','borrower_employer_details','borrower_name_of_firm','borrower_income_itr','borrower_current_loan_emi','borrower_education_expenses','borrower_house_rent','borrower_number_of_dependants','borrower_other_earnings','borrower_other_earnings_type','borrower_monthly_emi_possible','borrower_id_proof_type','borrower_id_proof_number','borrower_pan_card_number','borrower_aadhar_card_number','borrower_created_at','borrower_updated_at','borrower_alternate_number','borrower_relation_with_patient','borrower_residing_since','borrower_permanent_address','borrower_permanent_city','borrower_permanent_state','borrower_permanent_pincode','patient_id','patient_first_name','patient_middle_name','patient_last_name','patient_date_of_birth','patient_gender','patient_mobile_number','patient_created_at','patient_updated_at','patient_address_line_1','patient_address_line_2','patient_city','patient_state','patient_pincode','patient_pan_card','patient_aadhar_card','patient_driving_id','patient_voting_id','patient_residing_since','patient_marital_status','patient_permanent_address','patient_permanent_city','patient_permanent_state','patient_permanent_pincode'
                    )
                );
            });
        })->store('xlsx', public_path().'/DataDump', true);
    }
}
