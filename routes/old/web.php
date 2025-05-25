<?php

namespace App\Http\Controllers;

namespace App;

use App\Models\Project\Employee;
use Illuminate\Support\Facades\URL;
use Route;

//use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
 */

$app_url = config("app.url");
if (app()->environment('prod') && !empty($app_url)) {
    URL::forceRootUrl($app_url);
    $schema = explode(':', $app_url)[0];
    URL::forceScheme($schema);
}

Route::get('/test-mail', function () {
    \Mail::raw('This is a test email', function ($message) {
        $message->to('subhasish@qolarisdata.com')->subject('Test Email');
    });

    return 'Email sent!';
});

//******* Routes with Login  start *********//

Route::get('/password/email', 'HomeController@showLinkRequestForm');
Route::post('/password/email', 'HomeController@sendResetLinkEmail');
Route::get('/password/otp', 'HomeController@showOtpForm');

Route::get('/reset-password/{token}', array('as' => 'admin_reset_newpassword', 'uses' => 'HomeController@resetPassword'));
Route::post('/reset-password/{token}', array('as' => 'admin_password_update', 'uses' => 'HomeController@updatePassword'));

// Route::post('/password/otp', 'HomeController@verifyOtp');
// Route::get('/password/reset-password', 'HomeController@showResetForm');
// Route::post('/password/reset-password', 'HomeController@resetPassword');

Route::get('/', 'HomeController@getlogin');
Route::post('/login', 'HomeController@DoLogin');
Route::get('dashboard', 'HomeController@Dashboard');
Route::get('change-password', 'HomeController@changepassword');
Route::post('save-change-password', 'HomeController@savechangepassword');
Route::get('logout', 'HomeController@Logout');
Route::get('masters/dashboard', 'HomeController@mastersdashboard');
Route::get('projects/dashboard', 'HomeController@projectsdashboard');
Route::get('timesheets/dashboard', 'HomeController@timesheetsdashboard');
Route::get('hcm-dashboard', 'HomeController@hcmdashboard');
Route::get('finance-dashboard', 'HomeController@FinanceDashboard');
// Route::get('employee-corner/dashboard', 'EmployeeCorner\HomeController@viewDashboard');
Route::get('projects-dashboard', 'HomeController@ProjectDashboard');
//******* Routes with Login  end *********//
//project routes

//******* Routes with Master start *********//
Route::get('masters/opening-bal-generation', 'Masters\OpenBalanceGenerationController@addbalgpfemployee');
Route::post('masters/opening-bal-generation', 'Masters\OpenBalanceGenerationController@listbalgpfemployee');
Route::get('masters/vw-opening-balance', 'Masters\OpenBalanceGenerationController@addPayrollbalgpfemployee');
Route::post('masters/vw-opening-balance', 'Masters\OpenBalanceGenerationController@listPayrollbalgpfemployee');

Route::get('masters/coas', 'Masters\CoaController@coaListing');
Route::get('masters/coa', 'Masters\CoaController@viewCoa');
Route::post('masters/coa', 'Masters\CoaController@saveCoa');
Route::get('masters/accounttype/{account_type}', 'Masters\CoaController@coaAccounttype');
Route::get('masters/coacode/{account_type}/{account_name}', 'Masters\CoaController@getCoacode');
Route::get('masters/getbasecode/{account_type}/{account_name}', 'Masters\CoaController@getBasecode');

Route::get('masters/accountmasters', 'Masters\AccountMasterController@accountListing');
Route::get('masters/accountmaster', 'Masters\AccountMasterController@viewAccount');
Route::post('masters/accountmaster', 'Masters\AccountMasterController@saveAccount');

Route::get('masters/tdslisting', 'Masters\TdsController@tdsListing');
Route::get('masters/add-tdsdetail', 'Masters\TdsController@addTds');
Route::post('masters/save-tdsdetail', 'Masters\TdsController@saveTds');
Route::get('masters/edit-tdsdetail/{id}', 'Masters\TdsController@getTdsDtl');
Route::post('masters/update-tdsdetail', 'Masters\TdsController@updateTds');

Route::get('masters/company_banklisting', 'Masters\CompanyBankController@getCompanyBankListing');
Route::get('masters/add-companybank', 'Masters\CompanyBankController@viewCompanyAddBank');
Route::post('masters/save-companybank', 'Masters\CompanyBankController@saveCompanyBank');
Route::get('masters/edit-companybank/{id}', 'Masters\CompanyBankController@getCompanyBankDtl');
Route::post('masters/update-companybank', 'Masters\CompanyBankController@updateCompanyBank');

Route::get('masters/vw-bank', 'Masters\BankController@getBankList');
Route::get('masters/add-bank', 'Masters\BankController@viewAddBank');
Route::post('masters/save-bank', 'Masters\BankController@saveBank');
Route::get('masters/edit-bank/{id}', 'Masters\BankController@editAddBank');
Route::post('masters/update-bank', 'Masters\BankController@updateBank');

Route::get('masters/gpf_banklisting', 'Masters\GpfBankController@getGpfBankListing');
Route::get('masters/add-gpfbank', 'Masters\GpfBankController@viewGpfAddBank');
Route::post('masters/save-gpfbank', 'Masters\GpfBankController@saveGpfBank');
Route::get('masters/edit-gpfbank/{id}', 'Masters\GpfBankController@getGpfBankDtl');
Route::post('masters/update-gpfbank', 'Masters\GpfBankController@updateGpfBank');

Route::get('masters/vw-stipend-bank', 'Masters\StipendBankController@getStipendBank');
Route::get('masters/add-stipendbank', 'Masters\StipendBankController@AddStipendBank');
Route::post('masters/save-stipendbank', 'Masters\StipendBankController@saveStipendBank');
Route::get('masters/edit-stipendbank/{id}', 'Masters\StipendBankController@editAddStipendBank');
Route::post('masters/update-stipendbank', 'Masters\StipendBankController@updateStipendBank');

Route::get('masters/vw-company', 'Masters\CompanyController@getCompanies');
Route::get('masters/add-company', 'Masters\CompanyController@addCompanies');
Route::post('masters/save-company', 'Masters\CompanyController@saveCompany');
Route::get('masters/edit-company/{id}', 'Masters\CompanyController@editCompany');
Route::post('masters/update-company', 'Masters\CompanyController@updateCompany');

Route::get('depreciation/rate', 'Masters\DepreciationController@viewDepreciationRateData');
Route::post('depreciation/rate-table-data', 'Masters\DepreciationController@populateDepreciationRateData');
Route::post('depreciation/rate-save-data', 'Masters\DepreciationController@saveDepreciationRateData');

Route::get('masters/vw-cast', 'Masters\CastController@viewCast');
Route::get('masters/add-new-cast', 'Masters\CastController@addCast');
Route::post('masters/save-new-cast', 'Masters\CastController@saveCast');
Route::get('masters/edit-new-cast/{id}', 'Masters\CastController@editCast');
Route::post('masters/update-new-cast', 'Masters\CastController@updateCast');

Route::get('masters/vw-sub-cast', 'Masters\CastController@viewSubCast');
Route::get('masters/add-sub-cast', 'Masters\CastController@addSubCast');
Route::post('masters/save-sub-cast', 'Masters\CastController@saveSubCast');
Route::get('masters/edit-sub-cast/{id}', 'Masters\CastController@editSubCast');
Route::post('masters/update-sub-cast', 'Masters\CastController@updateSubCast');

Route::get('masters/vw-department', 'Masters\DepartmentMasterController@getDepartment');
Route::get('masters/add-new-department', 'Masters\DepartmentMasterController@addNewDepartment');
Route::post('masters/save-new-department', 'Masters\DepartmentMasterController@saveDepartmentData');
Route::get('masters/edit-new-department/{id}', 'Masters\DepartmentMasterController@editNewDepartment');
Route::post('masters/update-new-department', 'Masters\DepartmentMasterController@updateDepartmentData');

Route::get('masters/vw-designation', 'Masters\DesignationController@getDesignations');
Route::get('masters/add-designation', 'Masters\DesignationController@addDesignation');
Route::post('masters/save-designation', 'Masters\DesignationController@saveDesignation');
Route::get('masters/edit-designation/{id}', 'Masters\DesignationController@viewAddDesignation');
Route::post('masters/update-designation', 'Masters\DesignationController@updateDesignation');

Route::get('masters/vw-employee-type', 'Masters\EmployeeTypeController@getEmployeeTypes');
Route::get('masters/add-employee-type', 'Masters\EmployeeTypeController@addEmployeeType');
Route::post('masters/save-employee-type', 'Masters\EmployeeTypeController@saveEmployeeType');
Route::get('masters/edit-employee-type/{id}', 'Masters\EmployeeTypeController@getTypeById');
Route::post('masters/update-employee-type', 'Masters\EmployeeTypeController@updateEmployeeType');

Route::get('masters/vw-grade', 'Masters\GradeController@getGrades');
Route::get('masters/add-grade', 'Masters\GradeController@viewAddGrade');
Route::post('masters/save-grade', 'Masters\GradeController@saveGrade');
Route::get('masters/edit-grade/{id}', 'Masters\GradeController@editGrade');
Route::post('masters/update-grade', 'Masters\GradeController@updateGrade');

Route::get('masters/vw-religion', 'Masters\ReligionController@viewReligionList');
Route::get('masters/add-new-religion', 'Masters\ReligionController@addReligionForm');
Route::post('masters/save-new-religion', 'Masters\ReligionController@saveReligionFormSubmit');
Route::get('masters/edit-new-religion/{id}', 'Masters\ReligionController@editReligionForm');
Route::post('masters/update-new-religion', 'Masters\ReligionController@updateReligionFormSubmit');

Route::get('masters/gpf-rate-listing', 'Masters\GpfRateController@gpfRateListing');
Route::get('masters/add-gpf-rate-detail', 'Masters\GpfRateController@viewGpfRate');
Route::post('masters/gpf-rate-save', 'Masters\GpfRateController@saveGpfRate');
Route::get('masters/edit-gpf-rate-detail/{id}', 'Masters\GpfRateController@getgpfrateDtl');
Route::post('masters/update-gpf-rate', 'Masters\GpfRateController@updateGpfRate');

//PF interest rate master
Route::get('masters/pfinterest', 'Masters\InterestController@gpfPfListing');
Route::get('masters/add-pfinterest', 'Masters\InterestController@viewPfRate');
Route::post('masters/pfinterestsave', 'Masters\InterestController@savePfRate');
Route::get('masters/edit-pfinterest/{id}', 'Masters\InterestController@getPfrateDtl');
Route::post('masters/update-pfinterest', 'Masters\InterestController@updateGpfRate');

//BonusRate master
Route::get('masters/bonus-rate', 'Masters\BonusRateController@listing');
Route::get('masters/add-bonus-rate', 'Masters\BonusRateController@view');
Route::post('masters/save-bonus-rate', 'Masters\BonusRateController@save');
Route::get('masters/edit-bonus-rate/{id}', 'Masters\BonusRateController@getBonusRate');
Route::post('masters/update-bonus-rate', 'Masters\BonusRateController@update');

//ItaxRate master
Route::get('masters/itax-rate', 'Masters\ItaxRateController@listing');
Route::get('masters/add-itax-rate', 'Masters\ItaxRateController@view');
Route::post('masters/save-itax-rate', 'Masters\ItaxRateController@save');
Route::get('masters/edit-itax-rate/{id}', 'Masters\ItaxRateController@getItaxRate');
Route::post('masters/update-itax-rate', 'Masters\ItaxRateController@update');

Route::get('masters/ratelist', 'Masters\RateDetails@getRateList');
Route::get('masters/add-rate', 'Masters\RateDetails@addRateDetailsForm');
Route::post('masters/rate-save', 'Masters\RateDetails@SubmitRateDetailsForm');
Route::get('masters/rate-details/{rate_id}', 'Masters\RateDetails@getRateChart');
Route::post('masters/rate-details', 'Masters\RateDetails@saveRateChart');
Route::get('masters/head-type-by-id/{head_type}', 'Masters\RateDetails@HeadTypeIdName');

Route::get('masters/rate-master', 'Masters\RateMaster@getRateMasterList');
Route::get('masters/add-rate-master', 'Masters\RateMaster@addRateMasterDetailsForm');
Route::post('masters/rate-master-save', 'Masters\RateMaster@SubmitRateMasterDetailsForm');
Route::get('masters/rate-master-details/{rate_id}', 'Masters\RateMaster@getRateMasterChart');
Route::post('masters/rate-master-details', 'Masters\RateMaster@saveRateMasterChart');

Route::get('masters/vw-category', 'Masters\CategoryController@categoryList');
Route::get('masters/add-category', 'Masters\CategoryController@addCategory');
Route::post('masters/save-category', 'Masters\CategoryController@saveCategory');
Route::get('masters/edit-category/{id}', 'Masters\CategoryController@editCategory');
Route::post('masters/update-category', 'Masters\CategoryController@updateCategory');

Route::get('masters/vw-item', 'Masters\ItemController@getItem');
Route::get('masters/add-item', 'Masters\ItemController@viewItem');
Route::post('masters/save-item', 'Masters\ItemController@saveItem');
Route::get('masters/edit-item/{id}', 'Masters\ItemController@getItemById');
Route::post('masters/update-item', 'Masters\ItemController@updateItem');
Route::get('masters/subcategory/{category_id}', 'Masters\SubCategoryController@subCategoryID');

Route::get('masters/vw-sub-category', 'Masters\SubCategoryController@index');
Route::get('masters/add-sub-category', 'Masters\SubCategoryController@Create');
Route::post('masters/save-sub-category', 'Masters\SubCategoryController@store');
Route::get('masters/edit-sub-category/{id}', 'Masters\SubCategoryController@edit');
Route::post('masters/update-sub-category', 'Masters\SubCategoryController@update');

Route::get('masters/vw-supplier', 'Masters\SupplierController@getSupplier');
Route::get('masters/add-supplier', 'Masters\SupplierController@viewSupplier');
Route::post('masters/save-supplier', 'Masters\SupplierController@saveSupplier');
Route::get('masters/edit-supplier/{id}', 'Masters\SupplierController@getSupplierById');
Route::post('masters/update-supplier', 'Masters\SupplierController@updateSupplier');

Route::get('masters/loanlisting', 'Masters\LoanController@loanListing');
Route::get('masters/add-loandetail', 'Masters\LoanController@viewLoan');
Route::get('masters/edit-loandetail/{id}', 'Masters\LoanController@getLoanDtl');
Route::post('masters/save-loandetail', 'Masters\LoanController@saveLoan');
Route::post('masters/update-loandetail', 'Masters\LoanController@updateLoan');

Route::get('masters/vw-loan-conf', 'Masters\LoanController@loanConListing');
Route::get('masters/add-loanconfdetail', 'Masters\LoanController@viewConLoan');
Route::get('masters/edit-loanconfdetail/{id}', 'Masters\LoanController@getConLoanDtl');
Route::post('masters/save-loanconfdetail', 'Masters\LoanController@saveConLoan');
Route::post('masters/update-loanconfdetail', 'Masters\LoanController@updateConLoan');

//Employee Pay Head Master
Route::get('masters/emp-pay-head', 'Masters\EmpPayHeadController@getEmpPayHead');
Route::get('masters/add-new-pay-head', 'Masters\EmpPayHeadController@addNewPayHead');
Route::post('masters/save-pay-head', 'Masters\EmpPayHeadController@savePayHead');
Route::get('masters/edit-pay-head/{id}', 'Masters\EmpPayHeadController@editPayHead');
Route::post('masters/update-pay-head', 'Masters\EmpPayHeadController@updatePayHead');
Route::get('masters/del-pay-head/{id}', 'Masters\EmpPayHeadController@deletePayHead');
Route::get('employee/department-name/{emp_department}', 'Employee\EmployeeController@EmpDepartment');

//Employee Type Da
Route::get('masters/emp-type-da', 'Masters\EmpTypeDaController@getEmpTypeDA');
Route::get('masters/add-emp-type-da', 'Masters\EmpTypeDaController@addEmpTypeDA');
Route::post('masters/save-emp-type-da', 'Masters\EmpTypeDaController@saveEmpTypeDA');
Route::get('masters/edit-emp-type-da/{id}', 'Masters\EmpTypeDaController@editEmpTypeDA');
Route::post('masters/update-emp-type-da', 'Masters\EmpTypeDaController@updateEmpTypeDA');
Route::get('masters/del-emp-type-da/{id}', 'Masters\EmpTypeDaController@deleteEmpTypeDA');

//P Tax Slab
Route::get('masters/tax-slab', 'Masters\TaxSlabController@getTaxSlab');
Route::get('masters/add-tax-slab', 'Masters\TaxSlabController@addTaxSlab');
Route::post('masters/save-tax-slab', 'Masters\TaxSlabController@saveTaxSlab');
Route::get('masters/edit-tax-slab/{id}', 'Masters\TaxSlabController@editTaxSlab');
Route::post('masters/update-tax-slab', 'Masters\TaxSlabController@updateTaxSlab');
Route::get('masters/del-tax-slab/{id}', 'Masters\TaxSlabController@deleteTaxSlab');

//CO-OPERATIVE MASTER
Route::get('masters/cooperative-master', 'Masters\CooperativeController@getCoopMaster');
Route::get('masters/add-cooperative-master', 'Masters\CooperativeController@addCoopMaster');
Route::post('masters/save-cooperative-master', 'Masters\CooperativeController@saveCoopMaster');
Route::get('masters/edit-cooperative-master/{id}', 'Masters\CooperativeController@editCoopMaster');
Route::post('masters/update-cooperative-master', 'Masters\CooperativeController@updateCoopMaster');
Route::get('masters/del-cooperative-master/{id}', 'Masters\CooperativeController@deleteCoopMaster');

//HRA MASTER
Route::get('masters/hra-master', 'Masters\HraController@getHraMaster');
Route::get('masters/add-hra-master', 'Masters\HraController@addHraMaster');
Route::post('masters/save-hra-master', 'Masters\HraController@saveHraMaster');
Route::get('masters/edit-hra-master/{id}', 'Masters\HraController@editHraMaster');
Route::post('masters/update-hra-master', 'Masters\HraController@updateHraMaster');
Route::get('masters/del-hra-master/{id}', 'Masters\HraController@deleteHraMaster');

//HR Pay Parameter
Route::get('masters/hr-pay-parameter', 'Masters\HrPayController@getHrPay');
Route::get('masters/add-hr-pay-parameter', 'Masters\HrPayController@addHrPay');
Route::post('masters/save-hr-pay-parameter', 'Masters\HrPayController@saveHrPay');
Route::get('masters/edit-hr-pay-parameter/{id}', 'Masters\HrPayController@editHrPay');
Route::post('masters/update-hr-pay-parameter', 'Masters\HrPayController@updateHrPay');
Route::get('masters/del-hr-pay-parameter/{id}', 'Masters\HrPayController@deleteHrPay');

//Education Master
Route::get('masters/education', 'Masters\EducationController@getEducation');
Route::get('masters/add-education', 'Masters\EducationController@addEducation');
Route::post('masters/save-education', 'Masters\EducationController@saveEducation');
Route::get('masters/edit-education/{id}', 'Masters\EducationController@editEducation');
Route::post('masters/update-education', 'Masters\EducationController@updateEducation');
Route::get('masters/del-education/{id}', 'Masters\EducationController@deleteEducation');

//Employee Pay Head Link Master
Route::get('masters/emp-pay-head-link', 'Masters\EmpPayHeadLinkController@getEmpPayHeadLink');
Route::get('masters/add-emp-pay-head-link', 'Masters\EmpPayHeadLinkController@addEmpPayHeadLink');
Route::post('masters/save-emp-pay-head-link', 'Masters\EmpPayHeadLinkController@saveEmpPayHeadLink');
Route::get('masters/edit-emp-pay-head-link/{id}', 'Masters\EmpPayHeadLinkController@editEmpPayHeadLink');
Route::post('masters/update-emp-pay-head-link', 'Masters\EmpPayHeadLinkController@updateEmpPayHeadLink');
Route::get('masters/del-emp-pay-head-link/{id}', 'Masters\EmpPayHeadLinkController@deleteEmpPayHeadLink');

//VDA Details
Route::get('masters/vda-details', 'Masters\VDAController@getVdaDetails');
Route::get('masters/add-vda-details', 'Masters\VDAController@addVdaDetails');
Route::post('masters/save-vda-details', 'Masters\VDAController@saveVdaDetails');
Route::get('masters/del-vda-details/{id}', 'Masters\VDAController@deleteVdaDetails');
Route::get('masters/search-vda-details', 'Masters\VDAController@searchVdaDetails');
Route::post('masters/search-vda-details', 'Masters\VDAController@showVdaDetails');

//Pay type
Route::get('masters/pay-type', 'Masters\PayTypeController@getPayType');
Route::get('masters/add-pay-type', 'Masters\PayTypeController@addPayType');
Route::post('masters/save-pay-type', 'Masters\PayTypeController@savePayType');
Route::get('masters/edit-pay-type/{id}', 'Masters\PayTypeController@editPayType');
Route::post('masters/update-pay-type', 'Masters\PayTypeController@updatePayType');
Route::get('masters/del-pay-type/{id}', 'Masters\PayTypeController@deletePayType');
//******* Routes with Master end *********//

//******* Routes with Role start *********//
Route::get('role/dashboard', 'Role\UserAccessRightsController@viewdashboard');
Route::get('role/vw-users', 'Role\UserAccessRightsController@viewUserConfig');
Route::get('role/add-user-config', 'Role\UserAccessRightsController@viewUserConfigForm');
Route::post('role/save-user-config', 'Role\UserAccessRightsController@SaveUserConfigForm');
Route::get('role/edit-user-config/{user_id}', 'Role\UserAccessRightsController@GetUserConfigForm');
Route::post('role/update-user-config', 'Role\UserAccessRightsController@UpdateUserConfigForm');

Route::get('role/view-users-role', 'Role\UserAccessRightsController@viewUserAccessRights');
Route::get('role/add-user-role', 'Role\UserAccessRightsController@viewUserAccessRightsForm');
Route::post('role/save-user-role', 'Role\UserAccessRightsController@saveUserAccessRightsForm');
Route::get('role/delete-users-role/{role_authorization_id}', 'Role\UserAccessRightsController@deleteUserAccess');

Route::get('role/get-sub-modules/{id_module}', 'Role\UserAccessRightsController@subModuleID');
Route::get('role/get-role-menu/{id_sub_module}', 'Role\UserAccessRightsController@subMenuID');
//******* Routes with Role end *********//

//******* Routes with MIS start *********//

Route::get('mis/dashboard', 'Accountpayable\AccountpayablereportController@viewdashboard');
Route::get('consoliated-balancesheet', 'Accountpayable\AccountpayablereportController@consoliatedBalancesheetView');
Route::post('consoliated-balancesheet', 'Accountpayable\AccountpayablereportController@consoliatedBalancesheetReport');

Route::get('receipt-payment-report', 'Accountpayable\AccountpayablereportController@receiptPaymentView');
Route::post('receipt-payment-report', 'Accountpayable\AccountpayablereportController@receiptPaymentReport');

Route::get('sumary-report-income', 'Accountpayable\AccountpayablereportController@getIncomeSummaryReport');
Route::post('sumary-report-income', 'Accountpayable\AccountpayablereportController@viewIncomeSummaryReport');

Route::get('balance-sheet-report', 'Accountpayable\AccountpayablereportController@balanceSheetView');
Route::post('balance-sheet-report', 'Accountpayable\AccountpayablereportController@balanceSheetReport');

Route::get('income-expenditure-report', 'Accountpayable\AccountpayablereportController@incomeExpenditureView');
Route::post('income-expenditure-report', 'Accountpayable\AccountpayablereportController@incomeExpenditureReport');

Route::get('income-schedules', 'Accountpayable\AccountpayablereportController@viewIncomeSchedules');
Route::post('schedule-code', 'Accountpayable\AccountpayablereportController@viewIncomeScheduleReport');

Route::get('bs-schedules', 'Accountpayable\AccountpayablereportController@viewBalanceSchedules');
Route::post('bs_schedule-code', 'Accountpayable\AccountpayablereportController@viewBalanceScheduleReport');

Route::get('establishment-receipt-payment', 'Accountpayable\AccountpayablereportController@establishmentReceiptPayment');
Route::post('establishment-receipt-payment', 'Accountpayable\AccountpayablereportController@establishmentReceiptPaymentReport');

Route::get('cash-book-report', 'Accountpayable\AccountpayablereportController@getCashbookReport');
Route::post('cash-book-report', 'Accountpayable\AccountpayablereportController@viewCashbookReport');

Route::get('petty-book-report', 'Accountpayable\AccountpayablereportController@getPettyCashReport');
Route::post('petty-book-report', 'Accountpayable\AccountpayablereportController@viewPettyCashReport');

Route::get('bankbook/report', 'Accountpayable\AccountpayablereportController@bankbookView');
Route::post('bankbook/report', 'Accountpayable\AccountpayablereportController@showBankbookReport');
Route::get('company/get-company-bank-pay/{bank_name}', 'Accountpayable\AccountpayablereportController@getBankName');

Route::get('contra-voucher-report', 'Accountpayable\AccountpayablereportController@getContraVoucherReport');
Route::post('contra-voucher-report', 'Accountpayable\AccountpayablereportController@viewContraVoucherReport');

Route::get('receipt-voucher-report', 'Accountpayable\AccountpayablereportController@getReceiptVoucherReport');
Route::post('receipt-voucher-report', 'Accountpayable\AccountpayablereportController@viewReceiptVoucherReport');

Route::get('payment-voucher-report', 'Accountpayable\AccountpayablereportController@getPaymentVoucherReport');
Route::post('payment-voucher-report', 'Accountpayable\AccountpayablereportController@viewPaymentVoucherReport');

Route::get('party-ledger-report', 'Accountpayable\AccountpayablereportController@getPartyLedgerReport');
Route::post('party-ledger-report', 'Accountpayable\AccountpayablereportController@showPartyLedgerReport');

Route::get('glhead/report', 'Accountpayable\AccountpayablereportController@glHeadView');
Route::get('glhead/report/{gl_head_type}', 'Accountpayable\AccountpayablereportController@getGlHeadView');
Route::post('glhead/report', 'Accountpayable\AccountpayablereportController@showGlHeadReport');

Route::get('trial-balance-report', 'Accountpayable\AccountpayablereportController@trialView');
Route::post('trial-balance-report', 'Accountpayable\AccountpayablereportController@showtrialReport');
//******* Routes with MIS end *********//

//******* Routes with HCM start *********//

//Employee
Route::get('employee/dashboard', 'Employee\EmployeeController@viewdashboard');
Route::get('employees', 'Employee\EmployeeController@getEmployees');
Route::post('xls-export-employees', 'Employee\EmployeeController@employees_xlsexport');
Route::post('xls-export-employee-only', 'Employee\EmployeeController@employees_xlsexportonly');

Route::get('employees/class', 'Employee\EmployeeController@employeesByClass');
Route::get('employees/department', 'Employee\EmployeeController@employeesByDepartment');

Route::post('employees/department-export-report', 'Employee\EmployeeController@emp_dep_xlsexport');
Route::post('employees/class-export-report', 'Employee\EmployeeController@emp_class_xlsexport');
Route::get('employees/ex-report', 'Employee\EmployeeController@emp_ex_report');

Route::get('add-employee', 'Employee\EmployeeController@viewAddEmployee');
Route::post('save-employee', 'Employee\EmployeeController@saveEmployee');
Route::get('edit-employee', 'Employee\EmployeeController@editEmployee');
Route::post('update-employee', 'Employee\EmployeeController@updateEmployee');
Route::get('settings/get-add-row-item/{row}', 'Employee\EmployeeController@ajaxAddRow');
Route::get('settings/get-add-row-earn/{row}', 'Employee\EmployeeController@ajaxAddRowearn');
Route::get('settings/get-add-row-deduct/{row}', 'Employee\EmployeeController@ajaxAddRowdeduct');
Route::get('settings/get-earn/{headname}/{val}/{emp_basic_pay}', 'Employee\EmployeeController@ajaxAddvalue');

Route::get('attendance/get-employee-bank/{emp_bank_id}', 'Employee\EmployeeController@empBankID');
Route::get('attendance/get-employee-bank-ifsc-code/{emp_branch_id}', 'Employee\EmployeeController@empBranchID');
Route::get('attendance/get-employee-scale/{emp_payscale_id}', 'Employee\EmployeeController@empPayID');
Route::get('attendance/get-grades/{companyid}', 'Employee\EmployeeController@companyID');
Route::get('attendance/get-employee-type/{companyid}', 'Employee\EmployeeController@empTypecompanyID');

Route::get('paystructure-dashboard', 'Employee\PayStructureController@viewPayStructureDashboard');
Route::post('save-paystructure', 'Employee\PayStructureController@savePaystructure');
Route::get('paystructure', 'Employee\PayStructureController@getPaystructure');
Route::get('paystructure/paystructuredelete/{paystructure_id}', 'Employee\PayStructureController@deletePaystructure');

Route::get('promotion', 'Employee\EmployeeController@promotionView');
Route::get('employee/get-employee-all-details/{empid}/{month}/{year}', 'Employee\EmployeeController@empDetails');
Route::post('save-promotion', 'Employee\EmployeeController@savePromotion');

Route::get('promotionreport', 'Employee\EmployeeController@viewPromotionReport');
Route::post('promotionreport', 'Employee\EmployeeController@reportPromotionReport');

Route::get('macp', 'Employee\EmployeeController@macpView');
Route::post('macp', 'Employee\EmployeeController@saveMacp');

Route::get('macpreport', 'Employee\EmployeeController@viewMcapReport');
Route::post('macpreport', 'Employee\EmployeeController@reportMcapReport');

Route::get('increment-report', 'Employee\EmployeeController@viewIncrement');
Route::post('increment-report', 'Employee\EmployeeController@reportIncrement');

Route::get('servicebook', 'Employee\EmployeeServicebookController@servicebook');

//******* Routes with HCM end *********//

//******* Routes with Leave Management start *********//
Route::get('leavemanagement/dashboard', 'LeaveManagement\LeaveTypeController@viewdashboard');
Route::get('leave-management/new-leave-type', 'LeaveManagement\LeaveTypeController@viewAddLeaveType');
Route::post('leave-management/new-leave-type', 'LeaveManagement\LeaveTypeController@saveLeaveType');
Route::get('leave-management/leave-type-listing', 'LeaveManagement\LeaveTypeController@getLeaveType');
Route::get('leave-management/leave-type-listing/{ltype_id}', 'LeaveManagement\LeaveTypeController@getLeaveTypeDtl');

Route::get('leave-management/save-leave-rule', 'LeaveManagement\LeaveRuleController@leaveRules');
Route::post('leave-management/save-leave-rule', 'LeaveManagement\LeaveRuleController@saveAddLeaveRule');
Route::get('leave-management/leave-rule-listing', 'LeaveManagement\LeaveRuleController@getLeaveRules');
Route::get('leave-management/view-leave-rule/{leave_rule_id}', 'LeaveManagement\LeaveRuleController@getLeaveRulesById');

Route::get('leave-management/save-leave-allocation', 'LeaveManagement\LeaveAllocationController@viewAddLeaveAllocation');

Route::post('leave-management/get-leave-allocation', 'LeaveManagement\LeaveAllocationController@getAddLeaveAllocation');

Route::post('leave-management/save-leave-allocation', 'LeaveManagement\LeaveAllocationController@saveAddLeaveAllocation');

Route::get('leave-management/leave-allocation-listing', 'LeaveManagement\LeaveAllocationController@getLeaveAllocation');

Route::get('leave-management/leave-allocation-dtl/{leave_allocation_id}', 'LeaveManagement\LeaveAllocationController@getLeaveAllocationById');

Route::post('leave-management/save-edit-leave-allocation', 'LeaveManagement\LeaveAllocationController@editLeaveAllocation');

Route::get('leave-management/leave-balance', 'LeaveManagement\LeaveBalanceController@getLeaveBalance');
Route::get('leave-management/leave-balance-view', 'LeaveManagement\LeaveBalanceController@leaveBalanceView');
Route::post('leave-management/leave-balance-view', 'LeaveManagement\LeaveBalanceController@leaveBalanceReport');

//******* Routes with Leave Management end *********//

//******* Routes with  Holiday start *********//
Route::get('holiday/dashboard', 'Holiday\HolidayController@viewdashboard');
Route::get('holidays', 'Holiday\HolidayController@viewHolidayDetails');
Route::get('holiday/add-holiday', 'Holiday\HolidayController@viewAddHoliday');
Route::post('holiday/add-holiday', 'Holiday\HolidayController@saveHolidayData');
Route::get('holiday/add-holiday/{holiday_id}', 'Holiday\HolidayController@getHolidayDtl');
Route::get('holiday/holidaydelete/{holiday_id}', 'Holiday\HolidayController@deleteHoliday');

Route::get('holiday-type', 'Holiday\HolidayController@viewHolidayTypeDetails');
Route::get('holiday/add-holiday-type', 'Holiday\HolidayController@viewAddHolidayType');
Route::post('holiday/add-holiday-type', 'Holiday\HolidayController@saveHolidayTypeData');
Route::get('holiday/add-holiday-type/{holiday_id}', 'Holiday\HolidayController@getHolidayTypeDtl');

//******* Routes with  Holiday end *********//
//******* Routes with  Leave & Tour start *********//
Route::get('leave-approver/dashboard', 'LeaveApprover\LeaveApproverController@viewdashboard');
Route::get('leave-approver/leave-approved', 'LeaveApprover\LeaveApproverController@viewLeaveApproved');
Route::post('leave-approver/leave-approved', 'LeaveApprover\LeaveApproverController@SaveLeaveApproved');
Route::get('leave-approver/leave-approved-right', 'LeaveApprover\LeaveApproverController@ViewLeavePermission');
Route::post('leave-approver/leave-approved-right', 'LeaveApprover\LeaveApproverController@SaveLeavePermission');
Route::get('leave-approver/tour-approved-right', 'LeaveApprover\LeaveApproverController@ViewTourPermission');
Route::post('leave-approver/tour-approved-right', 'LeaveApprover\LeaveApproverController@SaveTourPermission');
Route::get('leave-approver/loan-approved-right', 'LeaveApprover\LeaveApproverController@ViewLoanPermission');
Route::post('leave-approver/loan-approved-right', 'LeaveApprover\LeaveApproverController@SaveLoanPermission');
Route::get('pension-approver/pension-approved-right', 'LeaveApprover\LeaveApproverController@ViewpensionPermission');
Route::post('pension-approver/pension-approved-right', 'LeaveApprover\LeaveApproverController@SavepensionPermission');

Route::get('loanother-approver/loanother-approved-right', 'LeaveApprover\LeaveApproverController@Viewloanother');
Route::post('loanother-approver/loanother-approved-right', 'LeaveApprover\LeaveApproverController@Saveloanother');

Route::get('leave-approver/ltc-approved', 'LeaveApprover\LeaveApproverController@ViewLtcPermission');
Route::post('leave-approver/ltc-approved', 'LeaveApprover\LeaveApproverController@SaveLtcPermission');

//******* Routes with Leave & Tour Approver end *********//

//******* Routes with  attendance start *********//
Route::get('attendance/dashboard', 'Attendance\UploadAttendenceController@viewdashboard');
Route::get('attendance/upload-data', 'Attendance\UploadAttendenceController@viewUploadAttendence');
Route::post('attendance/upload-data', 'Attendance\UploadAttendenceController@importExcel');
Route::get('attendance/daily-attendance', 'Attendance\DailyAttendanceController@viewDailyAttendance');
Route::post('attendance/daily-attendance', 'Attendance\DailyAttendanceController@getDailyAttandance');
Route::post('attendance/add-daily-attendance', 'Attendance\DailyAttendanceController@updateDailyAttendance');
Route::get('attendance/process-attendance', 'Attendance\ProcessAttendanceController@viewProcessAttendance');
Route::post('attendance/process-attendance', 'Attendance\ProcessAttendanceController@getProcessAttandance');
Route::post('attendance/add-process-attendance', 'Attendance\ProcessAttendanceController@updateDailyProcessAttendance');
Route::post('attendance/save-Process-Attandance', 'Attendance\ProcessAttendanceController@saveProcessAttandance');
Route::get('attendance/monthly-attendance', 'Attendance\MonthlyAttendanceController@viewMonthlyAttendance');
Route::post('attendance/monthly-attendance', 'Attendance\MonthlyAttendanceController@getMonthlyAttandance');
Route::get('attendance/delete-monthly-attandance/', 'Attendance\MonthlyAttendanceController@deleteMonthlyAttandance');

//sm
Route::get('attendance/daily-attendance-report', 'Attendance\ReportController@viewDailyAttendance');
Route::post('attendance/daily-attendance-report', 'Attendance\ReportController@getDailyAttandance');
Route::post('attendance/xls-export-daily-attendance-report', 'Attendance\ReportController@attandences_xlsexport');
//******* Routes with attendance end *********//

//******* Routes with HCM Employee Corner start *********//
Route::get('employee-corner/dashboard', 'EmployeeCorner\HomeController@viewDashboard');
Route::get('employee-corner/employee-profile', 'Employee\EmployeeController@getEmployeeById');
Route::get('employee-corner/holiday-calendar', 'EmployeeCorner\HomeController@viewHolidayCalendar');
Route::get('employee-corner/apply-leave', 'Leave\LeaveApplyController@viewapplyleaveapplication');
Route::post('employee-corner/save-apply-leave', 'Leave\LeaveApplyController@saveApplyLeaveData');
Route::get('employee-corner/get-leave-in-hand/{id_leave_type}', 'Leave\LeaveApplyController@leaveTypeID');
Route::post('employee-corner/holiday-count', 'Leave\LeaveApplyController@holidayLeaveApplyAjax');

Route::post('employee-corner/change-password', 'Employee\EmployeeController@savecahngepass');

Route::get('employee-corner/tourlisting', 'Leave\TourApplyController@tourapplicationListing');
Route::get('employee-corner/apply-for-tour', 'Leave\TourApplyController@viewApplytourapplication');
Route::post('employee-corner/apply-for-tour', 'Leave\TourApplyController@saveApplytourapplication');
Route::get('employee-corner/tourdtl/{tour_id}', 'Leave\TourApplyController@getTourdtlById');

Route::get('employee-corner/apply-for-ltc', 'Leave\LtcApplyController@viewApplyltcapplication');
Route::post('employee-corner/apply-for-ltc', 'Leave\LtcApplyController@saveApplyltcapplication');

Route::get('employee-corner/loanlisting', 'Leave\LoanApplyuserController@luserapplicationListing');
Route::get('employee-corner/loan-apply', 'Leave\LoanApplyuserController@viewApplyluserapplication');
Route::post('employee-corner/save-loan-apply', 'Leave\LoanApplyuserController@saveApplyluserapplication');
Route::post('employee-corner/get-loan-in-hand/{id_leave_type}', 'Leave\LoanApplyuserController@leavetypeAjax');

Route::get('employee/payslip', 'Payroll\EmployeeWisePayslipController@showSinglePayslip');
Route::post('employee/payslip', 'Payroll\EmployeeWisePayslipController@singlePayslip');

Route::get('employee-corner/vw-login-logout-status', 'Leave\LoginLogutController@viewLoginLogout');
Route::post('employee-corner/login-logout-status', 'Leave\LoginLogutController@searchLoginLogout');

Route::get('employee-corner/gpf-details', 'Employee\EmployeeController@getPfDetails');

Route::get('employee-corner/gpf-loan-apply', 'Leave\GpfLoanApplyController@viewLoanApply');
Route::post('employee-corner/gpf-loan-apply', 'Leave\GpfLoanApplyController@saveLoanApply');

Route::get('employee-corner/pension', 'Employee\EmployeeController@getPensionDetails');
Route::post('employee-corner/pension', 'Employee\EmployeeController@savePension');

//******* Routes with HCM Employee Corner end *********//

//******* Routes with Finance & Accounts start *********//
//loans
Route::get('loans/view-loans', 'Loan\LoanController@viewLoan');
Route::get('loans/add-loan', 'Loan\LoanController@addLoan');
Route::post('loans/save-loan', 'Loan\LoanController@saveLoan');
Route::get('loans/edit-loan/{id}', 'Loan\LoanController@editLoan');
Route::post('loans/update-loan', 'Loan\LoanController@updateLoan');

Route::post('loans/xls-export-loan-list', 'Loan\LoanController@loan_list_xlsexport');

Route::get('loans/adjust-loan/{id}', 'Loan\LoanController@adjustLoan');
Route::post('loans/update-loan-adjustment', 'Loan\LoanController@updateLoanAdjustment');
Route::get('loans/view-adjust-loan/{id}', 'Loan\LoanController@viewAdjustLoan');

Route::get('loans/vw-loan-report', 'Loan\LoanController@ViewLoanRepo');
Route::post('loans/vw-loan-report', 'Loan\LoanController@showLoanRepo');
Route::post('loans/prn-loan-report', 'Loan\LoanController@printLoanRepo');
Route::post('loans/xls-export-loan-report', 'Loan\LoanController@loan_repo_xlsexport');

Route::get('loans/check-advance-salary', 'Loan\LoanController@checkAdvanceSalary');
Route::post('loans/check-advance-salary', 'Loan\LoanController@showCheckAdvanceSalary');
Route::post('loans/xls-export-check-advance-salary', 'Loan\LoanController@advance_salary_xlsexport');

Route::get('loans/adjustment-report', 'Loan\LoanController@loanAdjustmentReport');
Route::post('loans/xls-export-adjustment-report', 'Loan\LoanController@adjustment_report_xlsexport');

//itax module

Route::get('itax/dashboard', 'IncomeTax\IncomeTaxController@dashboard');

//I Tax Rate Slab Master
Route::get('itax/itax-rate-slab', 'IncomeTax\ITaxRateSlabController@getITaxRateSlab');
Route::get('itax/add-itax-rate-slab', 'IncomeTax\ITaxRateSlabController@addITaxRateSlab');
Route::post('itax/save-itax-rate-slab', 'IncomeTax\ITaxRateSlabController@saveITaxRateSlab');
Route::get('itax/edit-itax-rate-slab/{id}', 'IncomeTax\ITaxRateSlabController@editITaxRateSlab');
Route::post('itax/update-itax-rate-slab', 'IncomeTax\ITaxRateSlabController@updateITaxRateSlab');
Route::get('itax/del-itax-rate-slab/{id}', 'IncomeTax\ITaxRateSlabController@deleteITaxRateSlab');

//Income Tax Type
Route::get('itax/income-tax-type', 'IncomeTax\IncometaxTypeController@getIncometaxType');
Route::get('itax/add-income-tax-type', 'IncomeTax\IncometaxTypeController@addIncometaxType');
Route::post('itax/save-income-tax-type', 'IncomeTax\IncometaxTypeController@saveIncometaxType');
Route::get('itax/edit-income-tax-type/{id}', 'IncomeTax\IncometaxTypeController@editIncometaxType');
Route::post('itax/update-income-tax-type', 'IncomeTax\IncometaxTypeController@updateIncometaxType');
Route::get('itax/del-income-tax-type/{id}', 'IncomeTax\IncometaxTypeController@deleteIncometaxType');

Route::get('itax/get-income-tax-type/{fyear}', 'IncomeTax\IncometaxTypeController@getItaxTypeByFiscalYear');

//ITax Deposit
Route::get('itax/deposit', 'IncomeTax\ItaxDepositController@getItaxDeposit');
Route::get('itax/add-deposit', 'IncomeTax\ItaxDepositController@addItaxDeposit');
Route::post('itax/save-deposit', 'IncomeTax\ItaxDepositController@saveItaxDeposit');
Route::get('itax/edit-deposit/{id}', 'IncomeTax\ItaxDepositController@editDeposit');
Route::post('itax/update-deposit', 'IncomeTax\ItaxDepositController@updateDeposit');
Route::get('itax/del-deposit/{id}', 'IncomeTax\ItaxDepositController@deleteDeposit');

//Saving Type Master
Route::get('itax/saving-type', 'IncomeTax\SavingTypeController@getSavingType');
Route::get('itax/add-saving-type', 'IncomeTax\SavingTypeController@addSavingType');
Route::post('itax/save-saving-type', 'IncomeTax\SavingTypeController@saveSavingType');
Route::get('itax/edit-saving-type/{id}', 'IncomeTax\SavingTypeController@editSavingType');
Route::post('itax/update-saving-type', 'IncomeTax\SavingTypeController@updateSavingType');
Route::get('itax/del-saving-type/{id}', 'IncomeTax\SavingTypeController@deleteSavingType');

Route::get('itax/get-saving-type/{taxtypeid}', 'IncomeTax\SavingTypeController@getSavingsTypeByTaxType');

//employee itax savings
Route::get('itax/employee-savings', 'IncomeTax\IncomeTaxController@getEmployeeSavings');
Route::get('itax/add-employee-savings', 'IncomeTax\IncomeTaxController@addEmployeeSavings');
Route::post('itax/add-employee-savings', 'IncomeTax\IncomeTaxController@saveEmployeeSavings');
Route::get('itax/edit-employee-savings', 'IncomeTax\IncomeTaxController@editEmployeeSavings');
Route::post('itax/edit-employee-savings', 'IncomeTax\IncomeTaxController@updateEmployeeSavings');
Route::get('itax/del-employee-savings', 'IncomeTax\IncomeTaxController@deleteEmployeeSavings');

//Itax Report
Route::get('itax/employee-savings-report', 'IncomeTax\IncomeTaxController@getEmployeeSavingsReport');

//Form16
Route::get('itax/form-sixteen', 'IncomeTax\IncomeTaxController@getEmployeeFormSixteen');

//payroll
Route::get('payroll/dashboard', 'Payroll\PayrollGenerationController@payrollDashboard');

Route::get('payroll/vw-payroll-generation', 'Payroll\PayrollGenerationController@getPayroll');
Route::post('payroll/vw-payroll-generation', 'Payroll\PayrollGenerationController@showPayroll');
Route::post('payroll/xls-export-payroll-generation', 'Payroll\PayrollGenerationController@payroll_xlsexport');

Route::get('payroll/add-payroll-generation', 'Payroll\PayrollGenerationController@viewPayroll');
Route::post('payroll/add-payroll-generation', 'Payroll\PayrollGenerationController@savePayrollDetails');
Route::get('payroll/getEmployeePayrollById/{empid}/{month}/{year}', 'Payroll\PayrollGenerationController@empPayrollAjax');

//salary adjustment
Route::get('payroll/vw-adjustment-payroll-generation', 'Payroll\PayrollGenerationController@getAdjustPayroll');
Route::get('payroll/adjustment-payroll-generation', 'Payroll\PayrollGenerationController@viewAdjustPayroll');
Route::post('payroll/adjustment-payroll-generation', 'Payroll\PayrollGenerationController@saveAdjustmentPayrollDetails');

//---

//without payslip - voucher payroll entry
Route::get('payroll/vw-voucher-payroll-generation', 'Payroll\PayrollGenerationController@getVoucherPayroll');
Route::get('payroll/voucher-payroll-generation', 'Payroll\PayrollGenerationController@viewVoucherPayroll');
Route::post('payroll/voucher-payroll-generation', 'Payroll\PayrollGenerationController@saveVoucherPayroll');

//----

Route::get('payroll/vw-payroll-generation-all-employee', 'Payroll\PayrollGenerationController@getPayrollallemployee');
Route::post('payroll/vw-payroll-generation-all-employee', 'Payroll\PayrollGenerationController@showPayrollallemployee');
Route::get('payroll/add-generate-payroll-all', 'Payroll\PayrollGenerationController@addPayrollallemployee');
Route::post('payroll/vw-generate-payroll-all', 'Payroll\PayrollGenerationController@listPayrollallemployee');
Route::post('payroll/save-payroll-all', 'Payroll\PayrollGenerationController@SavePayrollAll');

Route::get('payroll/vw-process-payroll', 'Payroll\PayrollGenerationController@getProcessPayroll');
Route::post('payroll/vw-process-payroll', 'Payroll\PayrollGenerationController@vwProcessPayroll');
Route::post('payroll/edit-process-payroll', 'Payroll\PayrollGenerationController@updateProcessPayroll');

Route::get('payroll/opening-bal-generation', 'Payroll\PayrollGenerationController@addbalgpfemployee');
Route::post('payroll/opening-bal-generation', 'Payroll\PayrollGenerationController@listbalgpfemployee');
Route::get('post/vw-opening-bal-payroll-generation', 'Payroll\PayrollGenerationController@addPayrollbalgpfemployee');
Route::get('payroll/deletepayroll/{payroll_id}', 'Payroll\PayrollGenerationController@deletePayrolldeatisl');
Route::get('payroll/deletepayroll-all/{payroll_id}', 'Payroll\PayrollGenerationController@deletePayrollAll');
Route::get('pis/payrolldelete/{payroll_id}', 'Payroll\PayrollGenerationController@deletePayroll');

//New version of pf opening
Route::get('payroll/pf-opening-balance', 'Payroll\PayrollGenerationController@viewPfOpeningBalance');
Route::get('payroll/upload-pf-opening-balance', 'Payroll\PayrollGenerationController@uploadPfOpeningBalance');
Route::post('payroll/upload-pf-opening-balance', 'Payroll\PayrollGenerationController@importPfOpeningBalance');

//yearly bonus input
Route::get('payroll/vw-yearly-bonus', 'Payroll\PayrollGenerationController@getYearlyBonus');
Route::post('payroll/vw-yearly-bonus', 'Payroll\PayrollGenerationController@viewYearlyBonus');
Route::get('payroll/add-yearly-bonus', 'Payroll\PayrollGenerationController@addYearlyBonus');
Route::post('payroll/add-yearly-bonus', 'Payroll\PayrollGenerationController@listAddYearlyBonus');
Route::post('payroll/save-bonus-all', 'Payroll\PayrollGenerationController@SaveBonusAll');
Route::post('payroll/update-bonus-all', 'Payroll\PayrollGenerationController@UpdateBonusAll');

Route::get('payroll/yearly-bonus-entry-report', 'Payroll\PtaxEmployeeWiseController@ViewBonusEntryRepo');
Route::post('payroll/yearly-bonus-entry-report', 'Payroll\PtaxEmployeeWiseController@showBonusEntryRepo');
Route::post('payroll/xls-export-yearly-bonus-entry-report', 'Payroll\PtaxEmployeeWiseController@bonus_entry_report_xlsexport');

Route::get('payroll/yearly-bonus-report', 'Payroll\PtaxEmployeeWiseController@ViewBonusCompleteRepo');
Route::post('payroll/yearly-bonus-report', 'Payroll\PtaxEmployeeWiseController@showBonusCompleteRepo');

Route::get('payroll/yearly-bonus-only-report', 'Payroll\PtaxEmployeeWiseController@ViewBonusOnlyRepo');
Route::post('payroll/yearly-bonus-only-report', 'Payroll\PtaxEmployeeWiseController@showBonusOnlyRepo');

Route::get('payroll/yearly-exgratia-report', 'Payroll\PtaxEmployeeWiseController@ViewExgratiaOnlyRepo');
Route::post('payroll/yearly-exgratia-report', 'Payroll\PtaxEmployeeWiseController@showExgratiaOnlyRepo');

//yearly encachments
Route::get('payroll/vw-yearly-encashment', 'Payroll\PayrollGenerationController@getYearlyEncash');
Route::post('payroll/vw-yearly-encashment', 'Payroll\PayrollGenerationController@viewYearlyEncash');
Route::get('payroll/add-yearly-encashment', 'Payroll\PayrollGenerationController@addYearlyEncash');
Route::post('payroll/add-yearly-encashment', 'Payroll\PayrollGenerationController@listAddYearlyEncash');
Route::post('payroll/save-encashment-all', 'Payroll\PayrollGenerationController@SaveEncashAll');
Route::post('payroll/save-encashment', 'Payroll\PayrollGenerationController@SaveEncash');

Route::get('payroll/edit-yearly-encashment/{id}', 'Payroll\PayrollGenerationController@editYearlyEncash');

Route::post('payroll/update-encashment', 'Payroll\PayrollGenerationController@UpdateEncash');
Route::post('payroll/update-encashment-all', 'Payroll\PayrollGenerationController@UpdateEncashAll');

Route::get('payroll/yearly-encashment-entry-report', 'Payroll\PtaxEmployeeWiseController@ViewEncashEntryRepo');
Route::post('payroll/yearly-encashment-entry-report', 'Payroll\PtaxEmployeeWiseController@showEncashEntryRepo');
Route::post('payroll/xls-export-yearly-encash-entry-report', 'Payroll\PtaxEmployeeWiseController@encash_entry_report_xlsexport');

//coop
Route::get('payroll/vw-montly-coop', 'Payroll\PayrollGenerationController@getMonthlyCoopDeduction');
Route::post('payroll/vw-montly-coop', 'Payroll\PayrollGenerationController@viewMonthlyCoopDeduction');
Route::get('payroll/add-montly-coop-all', 'Payroll\PayrollGenerationController@addMonthlyCoopDeductionAllemployee');
Route::post('payroll/vw-add-coop-all', 'Payroll\PayrollGenerationController@listCoopAllemployee');
Route::post('payroll/save-coop-all', 'Payroll\PayrollGenerationController@SaveCoopAll');
Route::post('payroll/update-coop-all', 'Payroll\PayrollGenerationController@UpdateCoopAll');

//add process attendance
Route::get('attendance/add-montly-attendance-data-all', 'Attendance\ProcessAttendanceController@addMonthlyAttendancePAAllemployee');
Route::post('attendance/add-montly-attendance-data-all', 'Attendance\ProcessAttendanceController@listAttendanceAllemployee');
Route::post('attendance/save-montly-attendance-data-all', 'Attendance\ProcessAttendanceController@SaveAttendanceAllemployee');
Route::get('attendance/view-montly-attendance-data-all', 'Attendance\ProcessAttendanceController@viewMonthlyAttendanceAllemployee');
Route::post('attendance/view-montly-attendance-data-all', 'Attendance\ProcessAttendanceController@listMonthlyAttendanceAllemployee');
Route::post('attendance/update-montly-attendance-data-all', 'Attendance\ProcessAttendanceController@UpdateAttendanceAllemployee');

Route::get('attendance/report-monthly-attendance', 'Attendance\ProcessAttendanceController@reportMonthlyAttendanceAllemployee');
Route::post('attendance/report-monthly-attendance', 'Attendance\ProcessAttendanceController@getMonthlyAttendanceReport');
Route::post('attendance/xls-export-attendance-report', 'Attendance\ProcessAttendanceController@attandence_xlsexport');

//incometax
Route::get('payroll/vw-montly-itax', 'Payroll\PayrollGenerationController@getMonthlyItaxDeduction');
Route::post('payroll/vw-montly-itax', 'Payroll\PayrollGenerationController@viewMonthlyItaxDeduction');
Route::get('payroll/add-montly-itax-all', 'Payroll\PayrollGenerationController@addMonthlyItaxDeductionAllemployee');
Route::post('payroll/vw-add-itax-all', 'Payroll\PayrollGenerationController@listItaxAllemployee');
Route::post('payroll/save-itax-all', 'Payroll\PayrollGenerationController@SaveItaxAll');
Route::post('payroll/update-itax-all', 'Payroll\PayrollGenerationController@UpdateItaxAll');

//generate allowances
Route::get('payroll/vw-montly-allowances', 'Payroll\PayrollGenerationController@getMonthlyEarningAllowances');
Route::post('payroll/vw-montly-allowances', 'Payroll\PayrollGenerationController@viewMonthlyEarningAllowances');
Route::get('payroll/add-montly-allowances', 'Payroll\PayrollGenerationController@addMonthlyAllowancesAllemployee');
Route::post('payroll/vw-add-allowances-all', 'Payroll\PayrollGenerationController@listAllowancesAllemployee');
Route::post('payroll/save-allowances-all', 'Payroll\PayrollGenerationController@SaveAllowancesAll');
Route::post('payroll/update-allowances-all', 'Payroll\PayrollGenerationController@UpdateAllowancesAll');

//generate all payslips
Route::get('payroll/vw-all-payslips', 'Payroll\EmployeeWisePayslipController@getMonthlyPaySlips');
Route::post('payroll/vw-all-payslips', 'Payroll\EmployeeWisePayslipController@getAllPayslips');

//generate overtime
Route::get('payroll/vw-montly-overtime', 'Payroll\PayrollGenerationController@getMonthlyOvertimes');
Route::post('payroll/vw-montly-overtimes', 'Payroll\PayrollGenerationController@viewMonthlyOvertimes');
Route::get('payroll/add-montly-overtimes', 'Payroll\PayrollGenerationController@addMonthlyOvertimesAllemployee');
Route::post('payroll/vw-add-overtimes-all', 'Payroll\PayrollGenerationController@listOvertimesAllemployee');
Route::post('payroll/save-overtimes-all', 'Payroll\PayrollGenerationController@SaveOvertimesAll');
Route::post('payroll/update-overtimes-all', 'Payroll\PayrollGenerationController@UpdateOvertimesAll');

//******* Routes with Finance & Accounts end *********//

//Group Name
Route::get('masters/group-name', 'Masters\GroupNameController@getGroupName');
Route::get('masters/add-group-name', 'Masters\GroupNameController@addGroupName');
Route::post('masters/save-group-name', 'Masters\GroupNameController@saveGroupName');
Route::get('masters/edit-group-name/{id}', 'Masters\GroupNameController@editGroupName');
Route::post('masters/update-group-name', 'Masters\GroupNameController@updateGroupName');
Route::get('masters/del-group-name/{id}', 'Masters\GroupNameController@deleteGroupName');
//******* Routes with Master end *********//

//******* Routes with Payroll report start *********//
Route::get('payroll/paycart', 'Payroll\EmployeeWisePayslipController@getEmployeePayCart');
Route::post('payroll/paycart', 'Payroll\EmployeeWisePayslipController@showEmployeePayCart');

Route::get('payroll/paycard', 'Payroll\EmployeeWisePayslipController@getEmployeePayCard');
Route::post('payroll/paycard', 'Payroll\EmployeeWisePayslipController@showEmployeePayCard');

Route::get('payroll/vw-employeewise-view-payslip', 'Payroll\EmployeeWisePayslipController@getEmployeeWisePayslip');
Route::post('payroll/vw-employeewise-view-payslip', 'Payroll\EmployeeWisePayslipController@showEmployeeWisePayslip');

Route::get('payroll/vw-salary-register', 'Payroll\MonthlySalaryRegisterController@getMonthlySalaryRegister');
Route::post('payroll/view-salary-register', 'Payroll\MonthlySalaryRegisterController@viewMonthlySalarySummary');
Route::get('payroll/vw-bank-statement', 'Payroll\BankWisePayslipController@getBankWisePayslip');
Route::post('payroll/vw-bank-statement', 'Payroll\BankWisePayslipController@showBankWiseStatement');
Route::post('payroll/view-bank-statement', 'Payroll\BankWisePayslipController@viewBankStatement');
Route::post('payroll/xls-export-bank-statement', 'Payroll\BankWisePayslipController@xlsExportBankStatement');
Route::get('payroll/salary-statement', 'Payroll\PtaxEmployeeWiseController@ViewSalaryStatement');
Route::post('payroll/salary-statement', 'Payroll\PtaxEmployeeWiseController@ShowSalaryStatementReport');
Route::get('payroll/vw-p-tax-department-wise', 'Payroll\PtaxEmployeeWiseController@ViewPtaxDeptWise');
Route::post('payroll/vw-p-tax-department-wise', 'Payroll\PtaxEmployeeWiseController@ShowReportPtaxDeptWise');
Route::get('payroll/vw-gpf-wise', 'Payroll\PtaxEmployeeWiseController@ViewGpfMonthlyWise');
Route::post('payroll/vw-gpf-wise', 'Payroll\PtaxEmployeeWiseController@ShowReportGpfMonthlyWise');
Route::get('payroll/vw-gpf-emplyeewise', 'Payroll\PtaxEmployeeWiseController@ViewGpfEmployeewise');
Route::post('payroll/vw-gpf-emplyeewise', 'Payroll\PtaxEmployeeWiseController@ShowReportGpfEmployeewise');
Route::get('payroll/payslip/{emp_id}/{pay_dtl_id}', 'Payroll\EmployeeWisePayslipController@viewPayrollDetails');

Route::get('payroll/vw-incomtax-all', 'Payroll\PtaxEmployeeWiseController@ViewIncometaxAll');
Route::post('payroll/vw-incomtax-all', 'Payroll\PtaxEmployeeWiseController@ShowReportIncomeAll');
Route::get('payroll/vw-incometax-emplyeewise', 'Payroll\PtaxEmployeeWiseController@ViewIncomEmployeewise');

Route::post('payroll/vw-incometax-emplyeewise', 'Payroll\PtaxEmployeeWiseController@ShowReportIncomeEmployeewise');

Route::get('payroll/vw-department-summary', 'Payroll\PtaxEmployeeWiseController@ViewDeptRepoAll');
Route::post('payroll/vw-department-summary', 'Payroll\PtaxEmployeeWiseController@showDeptRepoAll');
Route::post('payroll/prn-department-summary', 'Payroll\PtaxEmployeeWiseController@printDeptRepoAll');
Route::post('payroll/xls-export-department-summary', 'Payroll\PtaxEmployeeWiseController@dept_summary_xlsexport');

Route::get('payroll/vw-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@ViewDeductedCoopRepo');
Route::post('payroll/vw-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@showDeductedCoopRepo');
Route::post('payroll/prn-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@printDeductedCoopRepo');
Route::post('payroll/xls-export-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@deducted_coop_xlsexport');

Route::get('payroll/vw-non-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@ViewNonDeductedCoopRepo');
Route::post('payroll/vw-non-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@showNonDeductedCoopRepo');
Route::post('payroll/prn-non-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@printNonDeductedCoopRepo');
Route::post('payroll/xls-export-non-deducted-coop-report', 'Payroll\PtaxEmployeeWiseController@non_deducted_coop_xlsexport');

Route::get('payroll/vw-misc-recovery-report', 'Payroll\PtaxEmployeeWiseController@ViewMiscRecoveryRepo');
Route::post('payroll/vw-misc-recovery-report', 'Payroll\PtaxEmployeeWiseController@showMiscRecoveryRepo');
Route::post('payroll/prn-misc-recovery-report', 'Payroll\PtaxEmployeeWiseController@printMiscRecoveryRepo');
Route::post('payroll/xls-export-misc-recovery-report', 'Payroll\PtaxEmployeeWiseController@misc_recovery_xlsexport');

Route::get('payroll/monthly-coop-entry-report', 'Payroll\PtaxEmployeeWiseController@ViewCoopEntryRepo');
Route::post('payroll/monthly-coop-entry-report', 'Payroll\PtaxEmployeeWiseController@showCoopEntryRepo');
Route::post('payroll/xls-export-monthly-coop-entry-report', 'Payroll\PtaxEmployeeWiseController@coop_entry_report_xlsexport');

Route::get('payroll/monthly-incometax-entry-report', 'Payroll\PtaxEmployeeWiseController@ViewIncometaxEntryRepo');
Route::post('payroll/monthly-incometax-entry-report', 'Payroll\PtaxEmployeeWiseController@showIncometaxEntryRepo');
Route::post('payroll/xls-export-monthly-incometax-entry-report', 'Payroll\PtaxEmployeeWiseController@incometax_entry_report_xlsexport');

Route::get('payroll/monthly-overtime-entry-report', 'Payroll\PtaxEmployeeWiseController@ViewOvertimeEntryRepo');
Route::post('payroll/monthly-overtime-entry-report', 'Payroll\PtaxEmployeeWiseController@showOvertimeEntryRepo');
Route::post('payroll/xls-export-monthly-overtime-entry-report', 'Payroll\PtaxEmployeeWiseController@overtime_entry_report_xlsexport');

Route::get('payroll/monthly-allowance-entry-report', 'Payroll\PtaxEmployeeWiseController@ViewAllowanceEntryRepo');
Route::post('payroll/monthly-allowance-entry-report', 'Payroll\PtaxEmployeeWiseController@showAllowanceEntryRepo');
Route::post('payroll/xls-export-monthly-allowance-entry-report', 'Payroll\PtaxEmployeeWiseController@allowance_entry_report_xlsexport');

//******* Routes with Payroll report end *********//

//******* Routes with Rota start *********//

//rota dashboard
Route::get('rota-dashboard', 'Rota\RotaController@RotaDashboard');

//shift management
Route::get('rota/shift-management', 'Rota\RotaController@viewshift');
Route::get('rota/add-shift-management', 'Rota\RotaController@viewAddNewShift');
Route::post('rota/save-shift-management', 'Rota\RotaController@saveShiftData');
Route::get('rota/getEmployeedesigByshiftId/{empid}', 'Rota\RotaController@ajaxEmpShift');
Route::get('rota/edit-shift-management/{id}', 'Rota\RotaController@editShift');
Route::post('rota/update-shift-management', 'Rota\RotaController@updateShiftData');

//Late policy
Route::get('rota/late-policy', 'Rota\RotaController@viewlate');
Route::get('rota/add-late-policy', 'Rota\RotaController@viewAddNewlate');
Route::get('rota/getEmployeedesigBylateId/{empid}', 'Rota\RotaController@ajaxEmpShiftLate');
Route::post('rota/save-late-policy', 'Rota\RotaController@savelateData');
Route::get('rota/edit-late-policy/{id}', 'Rota\RotaController@editlate');
Route::post('rota/update-late-policy', 'Rota\RotaController@updatelateData');

//Day Off
Route::get('rota/offday', 'Rota\RotaController@viewoffday');
Route::get('rota/add-offday', 'Rota\RotaController@viewAddNewoffday');
Route::get('rota/edit-offday/{id}', 'Rota\RotaController@editoffday');
Route::post('rota/save-offday', 'Rota\RotaController@saveoffdayData');
Route::post('rota/update-offday', 'Rota\RotaController@updateoffdayData');

//Grace Period
Route::get('rota/grace-period', 'Rota\RotaController@viewgrace');
Route::get('rota/add-grace-period', 'Rota\RotaController@viewAddNewgrace');
Route::get('rota/edit-grace-period/{id}', 'Rota\RotaController@editGrace');
Route::post('rota/save-grace-period', 'Rota\RotaController@savegraceData');
Route::post('rota/update-grace-period', 'Rota\RotaController@updategraceData');

//Duty Roster
Route::get('rota/duty-roster', 'Rota\RotaController@viewroster');
Route::get('rota/getEmployeedailyattandeaneshightById/{empid}', 'Rota\RotaController@ajaxEmpCode');
Route::post('rota/add-duty-roster', 'Rota\RotaController@saverosterData');

Route::get('rota/add-employee-duty', 'Rota\RotaController@viewAddNewemployeeduty');
Route::post('rota/save-employee-duty', 'Rota\RotaController@saveemployeedutyData');

Route::get('rota/add-department-duty', 'Rota\RotaController@viewAddNewdepartmentduty');
Route::post('rota/save-department-duty', 'Rota\RotaController@savedepartmentdutyData');
Route::get('rota/getEmployeedesigBydutytshiftId/{empid}', 'Rota\RotaController@ajaxEmpShiftCode');
Route::get('rota/getEmployeedailyattandeaneshightdutyById/{empid}', 'Rota\RotaController@ajaxRotaEmp');

Route::get('appleave/leave-status/{employee_id}', 'AppemployeeController@allleavreqe');
Route::get('appemployees/attendance-monthwise/{emp_id}/{month_yr}', 'AppemployeeController@viewattendancemonthwise');
Route::get('appemployees/view-approved-leave/{emp_id}', 'AppemployeeController@viewapprovedleave');
Route::get('appemployees/daily-attendance/{emp_id}', 'AppemployeeController@viewdailyattendancemonthwise');
//******* Routes with Rota end *********//

/***** Project management routes************ */
//------Admin routes start-------
//Clients route
Route::get('projects/clients', 'Projects\ClientController@getClients');
Route::get('projects/add-clients', 'Projects\ClientController@addClients');
Route::post('projects/save-clients', 'Projects\ClientController@saveClients');
Route::get('projects/edit-clients/{id}', 'Projects\ClientController@editClients');
Route::post('projects/update-clients', 'Projects\ClientController@updateClient');

//Project route
Route::get('projects/vw-project', 'Projects\ProjectController@getProjects');
Route::get('projects/add-project', 'Projects\ProjectController@addProjects');
Route::post('projects/save-project', 'Projects\ProjectController@saveProjects');
Route::get('projects/edit-project/{id}', 'Projects\ProjectController@editProjects');
Route::post('projects/update-project', 'Projects\ProjectController@updateProjects');

//Resource  route
Route::get('projects/vw-resource', 'Projects\ResourceController@getResource');
Route::get('projects/add-resource/{id}', 'Projects\ResourceController@addResource');
Route::post('projects/save-resource', 'Projects\ResourceController@saveResource');
Route::get('projects/edit-resource/{id}', 'Projects\ResourceController@editResource');
Route::get('projects/delete_resource/{id}', 'Projects\ResourceController@deleteResource');
Route::post('projects/update-resource', 'Projects\ResourceController@updateResource');
Route::get('projects/delete-resource/{id}', 'Projects\ResourceController@deleteResource');

//timesheet view
Route::get('timesheets/', 'Projects\TimesheetsController@view_Timesheet');
Route::post('timesheets/', 'Projects\TimesheetsController@get_Timesheet');

//------Admin routes end-------
//------Employee login routes start-------
Route::get('timesheets/view-sheets', 'Timesheets\TimesheetController@getTimesheets');
Route::get('timesheets/add-timesheet', 'Timesheets\TimesheetController@addTimesheet');
Route::post('timesheets/save-timesheet', 'Timesheets\TimesheetController@saveTimesheet');
Route::post('timesheets/add-to-list', 'Timesheets\TimesheetController@addToList');
Route::get('timesheets/remove-from-list/{tsd_id}', 'Timesheets\TimesheetController@removeFromList');

//Task route
Route::get('projects/get-employee-tasks/{employee_id}/{project_id}', 'Projects\ProjectController@getProjectTasks');
Route::get('projects/get-add-row-item-task-new/{row}', function ($row) {
    $emplist = Employee::where('status', '=', 'active')
    // ->where('emp_status', '!=', 'TEMPORARY')
        ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
        ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
    // ->where('employees.emp_code', '=', '1831')
        ->orderBy('emp_fname', 'asc')
        ->get();
    $row = $row + 1;

    $result = '<div class="row rowresource" id="' . $row . '">';
    $result = $result . '<div class="col-12 col-md-4" style="padding-left: 4%;"><div class="form-group"><label  class="form-control-label">Employee Name</label><select name="employee_id[]" id="employee_id' . $row . '" class="form-control select2_el" required> <option value="" hidden>Select Employee</option>';

    foreach ($emplist as $rec) {
        $result = $result . '<option value="' . $rec->emp_code . '">' . $rec->emp_fname . ' ' . $rec->emp_mname . ' ' . $rec->emp_lname . '</option>';
    }

    $result = $result . '</select></div></div><div class="col-12 col-md-3" style="padding-left: 0%;"><div class="form-group"><label for="password-input" class="sform-control-label">Assigned By</label><select name="assigned_by[]" id="assigned_by' . $row . '" class="form-control select2_el" required>
    <option value="" hidden>Select Assigned</option>';

    foreach ($emplist as $rec) {
        $result = $result . '<option value="' . $rec->emp_code . '">' . $rec->emp_fname . ' ' . $rec->emp_mname . ' ' . $rec->emp_lname . '</option>';
    }
    $result = $result . '</select></div></div><div class="col-12 col-md-4"><div class="form-group"><label for="selectSm" class="sform-control-label">Task Description</label><input type="text" id="task_description' . $row . '" name="task_description[]" class="form-control" value="" required></div></div>';

    $result = $result . '<div class="col-md-1" style="display: inline-flex;margin-top: 15px;padding-left: 10px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="addresourec()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonResource" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

    echo $result;
});
//------Employee login routes end-------

//sanjay work
// Route::get('timesheets/add-timesheets', 'Timesheets\TimesheetController@addTimesheets');
// Route::post('timesheets/add-timesheets', 'Timesheets\TimesheetController@saveTimesheets');
// Route::post('timesheets/save_draft-timesheets', 'Timesheets\TimesheetController@saveTimesheets');
// Route::post('timesheets/save_draft-timesheets', 'Timesheets\TimesheetController@save_draft');
// Route::post('timesheets/save_submit-timesheets', 'Timesheets\TimesheetController@save_submit');
// Route::get('timesheets/edit-timesheets/{id}', 'Timesheets\TimesheetController@editTimesheets');
// Route::get('timesheets/view-timesheets/{id}', 'Timesheets\TimesheetController@viewTimesheets');
// Route::post('timesheets/update-timesheets', 'Timesheets\TimesheetController@updateTimesheets');
// Route::post('timesheets/update-draft-timesheets', 'Timesheets\TimesheetController@updatedraftTimesheets');
// Route::post('timesheets/edit-timesheets/{id}', 'Timesheets\TimesheetController@saveTimesheets');

Route::get('projects/vw-task', 'Projects\TaskController@getTask');
Route::get('projects/add-task/{id}', 'Projects\TaskController@addTask');
Route::post('projects/save-task', 'Projects\TaskController@saveTask');
Route::get('projects/edit-task/{id}', 'Projects\TaskController@editTask');
Route::post('projects/update-task', 'Projects\TaskController@updateTask');
