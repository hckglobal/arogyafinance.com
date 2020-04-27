<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	DB::table('permissions')->truncate();

        Permission::create(["name"=>"verify-application","display_name"=>"Verify Application","description"=>"Can View Application"]);
		Permission::create(["name"=>"sanction-application","display_name"=>"Sanction Application","description"=>"Can View Sanction Application"]);
		Permission::create(["name"=>"edit-cibil-score","display_name"=>"Edit Cibil Score","description"=>"Can edit cibil score"]);
		Permission::create(["name"=>"manage-questions","display_name"=>"Manage questions","description"=>"Can manage questions"]);
		Permission::create(["name"=>"view-loan-application","display_name"=>"View Loan Application","description"=>"Can view Loan application form"]);
		Permission::create(["name"=>"update-application","display_name"=>"Update Application","description"=>"Can Update Application"]);
		Permission::create(["name"=>"view-test-result","display_name"=>"View Test Result","description"=>"Can View Test Result"]);
		Permission::create(["name"=>"genereate-sanction-letter","display_name"=>"Generate Sanction Letter","description"=>"Can Generate Sanction Letter"]);
		Permission::create(["name"=>"generate-test-report","display_name"=>"Generate Test Report","description"=>"Can Generate Test Report"]);
		Permission::create(["name"=>"view-card-application","display_name"=>"View Card Application","description"=>"Can view application form"]);
		Permission::create(["name"=>"manage-staff","display_name"=>"Manage Staff","description"=>"Can Manage Staff"]);
		Permission::create(["name"=>"manage-locations","display_name"=>"Manage Locations","description"=>"Can Manage Locations"]);
		Permission::create(["name"=>"manage-hospitals","display_name"=>"Manage Hospitals","description"=>"Can Manage Locations"]);
		Permission::create(["name"=>"manage-affiliates","display_name"=>"Manage Affiliates","description"=>"Can Manage Affiliates"]);
		Permission::create(["name"=>"manage-referrer","display_name"=>"Manage Referrer","description"=>"Can Manage Referrer"]);
		Permission::create(["name"=>"view-disbursed-loan-application","display_name"=>"View Disbursed Loan","description"=>"Can View Disbursed Loan"]);
		Permission::create(["name"=>"view-sanctioned-loan-application","display_name"=>"View Sanctioned Loan Application","description"=>"Can View Sanctioned Loan Forms"]);
		Permission::create(["name"=>"view-verified-loan-application","display_name"=>"View Verified Loan Application","description"=>"Can View Verified Loan Forms"]);
		Permission::create(["name"=>"view-rejected-loan-application","display_name"=>"View Rejected Loan","description"=>"Can View Rejected Loan Forms"]);
		Permission::create(["name"=>"view-new-loan-application","display_name"=>"New Loan Application","description"=>"Can View New Loan Application"]);
		Permission::create(["name"=>"view-sanctioned-card-application","display_name"=>"View Sanctioned Card","description"=>"Can View Sanctioned Card Forms"]);
		Permission::create(["name"=>"view-verified-card-application","display_name"=>"View Verified Card","description"=>"Can View Verified Card Forms"]);
		Permission::create(["name"=>"view-rejected-card-application","display_name"=>"View Rejected Card","description"=>"Can View Rejected Card Forms"]);
		Permission::create(["name"=>"view-new-card-application","display_name"=>"New Card Application","description"=>"View New Card Application"]);
		Permission::create(["name"=>"view-disbursed-card-application","display_name"=>"View Disbursed Card","description"=>"Can View Disbursed Card"]);
		Permission::create(["name"=>"disburse-application","display_name"=>"Disburse Application","description"=>"Can Disburse Application"]);
		Permission::create(["name"=>"manage-partner","display_name"=>"Manage Partner","description"=>"Can Manage Partner"]);
		Permission::create(["name"=>"manage-leads","display_name"=>"Manage Leads","description"=>"Can Manage Leads"]);
		Permission::create(["name"=>"create-psychometric-test","display_name"=>"Create Psychometric Test","description"=>"Can Create Psychometric Test"]);
		Permission::create(["name"=>"manage-treatment-type","display_name"=>"Manage Treatment Type","description"=>"Can manage Treatment Type"]);
		Permission::create(["name"=>"edit-application-form","display_name"=>"Edit Application Form","description"=>"Can Edit Application Form"]);
		Permission::create(["name"=>"can-switch-enable-pyschometric-test","display_name"=>"Switch Enable Psychometric Test","description"=>"Can Switch Enable Psychometric Test"]);
    	Permission::create(["name"=>"manage-reports","display_name"=>"Manage Report","description"=>"Can Manage Reports"]);
		Permission::create(["name"=>"post-disburse","display_name"=>"Update Disbursed case form","description"=>"Can change the data of disbursed case application"]);
		Permission::create(["name"=>"manage-products","display_name"=>"Manage Products","description"=>"Can Manage Products"]);
		Permission::create(["name"=>"manage-dmi","display_name"=>"Manage DMI","description"=>"Can Manage DMI"]);
		Permission::create(["name"=>"send-arogya-card","display_name"=>"Send Arogya Card","description"=>"Can Send Arogya Card"]);	
    	Permission::create(["name"=>"view-main-menu","display_name"=>"View main menu","description"=>"View main menu"]);	
    	Permission::create(["name"=>"view-loan-against-card","display_name"=>"View loan against card application","description"=>"can view loan against card application"]);
    	Permission::create(["name"=>"view-screenshots","display_name"=>"View Screenshots","description"=>"can view psychometric test screenshots"]);
    	Permission::create(["name"=>"view-test-details","display_name"=>"View Test Details","description"=>"can view psychometric test details"]);	
    	Permission::create(["name"=>"remove-documents","display_name"=>"Can Remove Documents","description"=>"can remove documents of the application"]);
    }
}
