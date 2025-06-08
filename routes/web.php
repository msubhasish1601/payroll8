<?php
namespace App\Http\Controllers;

namespace App;

// use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;
// use Mail;
// use Session;

use App\Http\Controllers\Accountpayable\AccountpayablereportController;
use App\Http\Controllers\Attendance\DailyAttendanceController;
use App\Http\Controllers\Attendance\MonthlyAttendanceController;
use App\Http\Controllers\Attendance\ProcessAttendanceController;
use App\Http\Controllers\Attendance\ReportController;
use App\Http\Controllers\Attendance\UploadAttendenceController;
use App\Http\Controllers\EmployeeCorner\HomeController as EmployeeCornerHomeController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\EmployeeServicebookController;
use App\Http\Controllers\Employee\PayStructureController;
use App\Http\Controllers\Holiday\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeTax\IncomeTaxController;
use App\Http\Controllers\IncomeTax\IncometaxTypeController;
use App\Http\Controllers\IncomeTax\ItaxDepositController;
use App\Http\Controllers\IncomeTax\ITaxRateSlabController;
use App\Http\Controllers\IncomeTax\SavingTypeController;
use App\Http\Controllers\LeaveApprover\LeaveApproverController;
use App\Http\Controllers\LeaveManagement\LeaveAllocationController;
use App\Http\Controllers\LeaveManagement\LeaveBalanceController;
use App\Http\Controllers\LeaveManagement\LeaveRuleController;
use App\Http\Controllers\LeaveManagement\LeaveTypeController;
use App\Http\Controllers\Leave\GpfLoanApplyController;
use App\Http\Controllers\Leave\LeaveApplyController;
use App\Http\Controllers\Leave\LoanApplyuserController;
use App\Http\Controllers\Leave\LoginLogutController;
use App\Http\Controllers\Leave\LtcApplyController;
use App\Http\Controllers\Leave\TourApplyController;
use App\Http\Controllers\Loan\LoanController;
use App\Http\Controllers\Masters\AccountMasterController;
use App\Http\Controllers\Masters\BankController;
use App\Http\Controllers\Masters\BonusRateController;
use App\Http\Controllers\Masters\CastController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\CoaController;
use App\Http\Controllers\Masters\CompanyBankController;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\Masters\CooperativeController;
use App\Http\Controllers\Masters\DepartmentMasterController;
use App\Http\Controllers\Masters\DepreciationController;
use App\Http\Controllers\Masters\DesignationController;
use App\Http\Controllers\Masters\EducationController;
use App\Http\Controllers\Masters\EmployeeTypeController;
use App\Http\Controllers\Masters\EmpPayHeadController;
use App\Http\Controllers\Masters\EmpPayHeadLinkController;
use App\Http\Controllers\Masters\EmpTypeDaController;
use App\Http\Controllers\Masters\GpfBankController;
use App\Http\Controllers\Masters\GpfRateController;
use App\Http\Controllers\Masters\GradeController;
use App\Http\Controllers\Masters\GroupNameController;
use App\Http\Controllers\Masters\HraController;
use App\Http\Controllers\Masters\HrPayController;
use App\Http\Controllers\Masters\InterestController;
use App\Http\Controllers\Masters\ItaxRateController;
use App\Http\Controllers\Masters\ItemController;
// use App\Http\Controllers\Masters\LoanController;
use App\Http\Controllers\Masters\OpenBalanceGenerationController;
use App\Http\Controllers\Masters\PayTypeController;
use App\Http\Controllers\Masters\RateDetails;
use App\Http\Controllers\Masters\RateMaster;
use App\Http\Controllers\Masters\ReligionController;
use App\Http\Controllers\Masters\StipendBankController;
use App\Http\Controllers\Masters\SubCategoryController;
use App\Http\Controllers\Masters\SupplierController;
use App\Http\Controllers\Masters\TaxSlabController;
use App\Http\Controllers\Masters\TdsController;
use App\Http\Controllers\Masters\VDAController;
use App\Http\Controllers\Payroll\BankWisePayslipController;
use App\Http\Controllers\Payroll\EmployeeWisePayslipController;
use App\Http\Controllers\Payroll\MonthlySalaryRegisterController;
use App\Http\Controllers\Payroll\PayrollGenerationController;
use App\Http\Controllers\Payroll\PtaxEmployeeWiseController;
use App\Http\Controllers\Projects\ClientController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ResourceController;
use App\Http\Controllers\Projects\TaskController;
use App\Http\Controllers\Projects\TimesheetsController;
use App\Http\Controllers\Role\UserAccessRightsController;
use App\Http\Controllers\Rota\RotaController;
use App\Http\Controllers\Timesheets\TimesheetController as EmployeeCornerTimesheetsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

$app_url = config("app.url");
if (app()->environment('prod') && ! empty($app_url)) {
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

//******* Routes with Login start *********//
Route::get('/password/email', [HomeController::class, 'showLinkRequestForm']);
Route::post('/password/email', [HomeController::class, 'sendResetLinkEmail']);
Route::get('/password/otp', [HomeController::class, 'showOtpForm']);

Route::get('/reset-password/{token}', [HomeController::class, 'resetPassword'])->name('admin_reset_newpassword');
Route::post('/reset-password/{token}', [HomeController::class, 'updatePassword'])->name('admin_password_update');

// Route::post('/password/otp', [HomeController::class, 'verifyOtp']);
// Route::get('/password/reset-password', [HomeController::class, 'showResetForm']);
// Route::post('/password/reset-password', [HomeController::class, 'resetPassword']);

Route::get('/', [HomeController::class, 'getlogin']);
Route::post('/login', [HomeController::class, 'DoLogin']);
Route::get('dashboard', [HomeController::class, 'Dashboard']);
Route::get('change-password', [HomeController::class, 'changepassword']);
Route::post('save-change-password', [HomeController::class, 'savechangepassword']);
Route::get('logout', [HomeController::class, 'Logout']);
Route::get('masters/dashboard', [HomeController::class, 'mastersdashboard']);
Route::get('projects/dashboard', [HomeController::class, 'projectsdashboard']);
Route::get('timesheets/dashboard', [HomeController::class, 'timesheetsdashboard']);
Route::get('hcm-dashboard', [HomeController::class, 'hcmdashboard']);
Route::get('finance-dashboard', [HomeController::class, 'FinanceDashboard']);
// Route::get('employee-corner/dashboard', [EmployeeCornerHomeController::class, 'viewDashboard']);
Route::get('projects-dashboard', [HomeController::class, 'ProjectDashboard']);
//******* Routes with Login end *********//

//******* Routes with Master start *********//
Route::get('masters/opening-bal-generation', [OpenBalanceGenerationController::class, 'addbalgpfemployee']);
Route::post('masters/opening-bal-generation', [OpenBalanceGenerationController::class, 'listbalgpfemployee']);
Route::get('masters/vw-opening-balance', [OpenBalanceGenerationController::class, 'addPayrollbalgpfemployee']);
Route::post('masters/vw-opening-balance', [OpenBalanceGenerationController::class, 'listPayrollbalgpfemployee']);

Route::get('masters/coas', [CoaController::class, 'coaListing']);
Route::get('masters/coa', [CoaController::class, 'viewCoa']);
Route::post('masters/coa', [CoaController::class, 'saveCoa']);
Route::get('masters/accounttype/{account_type}', [CoaController::class, 'coaAccounttype']);
Route::get('masters/coacode/{account_type}/{account_name}', [CoaController::class, 'getCoacode']);
Route::get('masters/getbasecode/{account_type}/{account_name}', [CoaController::class, 'getBasecode']);

Route::get('masters/accountmasters', [AccountMasterController::class, 'accountListing']);
Route::get('masters/accountmaster', [AccountMasterController::class, 'viewAccount']);
Route::post('masters/accountmaster', [AccountMasterController::class, 'saveAccount']);

Route::get('masters/tdslisting', [TdsController::class, 'tdsListing']);
Route::get('masters/add-tdsdetail', [TdsController::class, 'addTds']);
Route::post('masters/save-tdsdetail', [TdsController::class, 'saveTds']);
Route::get('masters/edit-tdsdetail/{id}', [TdsController::class, 'getTdsDtl']);
Route::post('masters/update-tdsdetail', [TdsController::class, 'updateTds']);

Route::get('masters/company_banklisting', [CompanyBankController::class, 'getCompanyBankListing']);
Route::get('masters/add-companybank', [CompanyBankController::class, 'viewCompanyAddBank']);
Route::post('masters/save-companybank', [CompanyBankController::class, 'saveCompanyBank']);
Route::get('masters/edit-companybank/{id}', [CompanyBankController::class, 'getCompanyBankDtl']);
Route::post('masters/update-companybank', [CompanyBankController::class, 'updateCompanyBank']);

Route::get('masters/vw-bank', [BankController::class, 'getBankList']);
Route::get('masters/add-bank', [BankController::class, 'viewAddBank']);
Route::post('masters/save-bank', [BankController::class, 'saveBank']);
Route::get('masters/edit-bank/{id}', [BankController::class, 'editAddBank']);
Route::post('masters/update-bank', [BankController::class, 'updateBank']);

Route::get('masters/gpf_banklisting', [GpfBankController::class, 'getGpfBankListing']);
Route::get('masters/add-gpfbank', [GpfBankController::class, 'viewGpfAddBank']);
Route::post('masters/save-gpfbank', [GpfBankController::class, 'saveGpfBank']);
Route::get('masters/edit-gpfbank/{id}', [GpfBankController::class, 'getGpfBankDtl']);
Route::post('masters/update-gpfbank', [GpfBankController::class, 'updateGpfBank']);

Route::get('masters/vw-stipend-bank', [StipendBankController::class, 'getStipendBank']);
Route::get('masters/add-stipendbank', [StipendBankController::class, 'AddStipendBank']);
Route::post('masters/save-stipendbank', [StipendBankController::class, 'saveStipendBank']);
Route::get('masters/edit-stipendbank/{id}', [StipendBankController::class, 'editAddStipendBank']);
Route::post('masters/update-stipendbank', [StipendBankController::class, 'updateStipendBank']);

Route::get('masters/vw-company', [CompanyController::class, 'getCompanies']);
Route::get('masters/add-company', [CompanyController::class, 'addCompanies']);
Route::post('masters/save-company', [CompanyController::class, 'saveCompany']);
Route::get('masters/edit-company/{id}', [CompanyController::class, 'editCompany']);
Route::post('masters/update-company', [CompanyController::class, 'updateCompany']);

Route::get('depreciation/rate', [DepreciationController::class, 'viewDepreciationRateData']);
Route::post('depreciation/rate-table-data', [DepreciationController::class, 'populateDepreciationRateData']);
Route::post('depreciation/rate-save-data', [DepreciationController::class, 'saveDepreciationRateData']);

Route::get('masters/vw-cast', [CastController::class, 'viewCast']);
Route::get('masters/add-new-cast', [CastController::class, 'addCast']);
Route::post('masters/save-new-cast', [CastController::class, 'saveCast']);
Route::get('masters/edit-new-cast/{id}', [CastController::class, 'editCast']);
Route::post('masters/update-new-cast', [CastController::class, 'updateCast']);

Route::get('masters/vw-sub-cast', [CastController::class, 'viewSubCast']);
Route::get('masters/add-sub-cast', [CastController::class, 'addSubCast']);
Route::post('masters/save-sub-cast', [CastController::class, 'saveSubCast']);
Route::get('masters/edit-sub-cast/{id}', [CastController::class, 'editSubCast']);
Route::post('masters/update-sub-cast', [CastController::class, 'updateSubCast']);

Route::get('masters/vw-department', [DepartmentMasterController::class, 'getDepartment']);
Route::get('masters/add-new-department', [DepartmentMasterController::class, 'addNewDepartment']);
Route::post('masters/save-new-department', [DepartmentMasterController::class, 'saveDepartmentData']);
Route::get('masters/edit-new-department/{id}', [DepartmentMasterController::class, 'editNewDepartment']);
Route::post('masters/update-new-department', [DepartmentMasterController::class, 'updateDepartmentData']);

Route::get('masters/vw-designation', [DesignationController::class, 'getDesignations']);
Route::get('masters/add-designation', [DesignationController::class, 'addDesignation']);
Route::post('masters/save-designation', [DesignationController::class, 'saveDesignation']);
Route::get('masters/edit-designation/{id}', [DesignationController::class, 'viewAddDesignation']);
Route::post('masters/update-designation', [DesignationController::class, 'updateDesignation']);

Route::get('masters/vw-employee-type', [EmployeeTypeController::class, 'getEmployeeTypes']);
Route::get('masters/add-employee-type', [EmployeeTypeController::class, 'addEmployeeType']);
Route::post('masters/save-employee-type', [EmployeeTypeController::class, 'saveEmployeeType']);
Route::get('masters/edit-employee-type/{id}', [EmployeeTypeController::class, 'getTypeById']);
Route::post('masters/update-employee-type', [EmployeeTypeController::class, 'updateEmployeeType']);

Route::get('masters/vw-grade', [GradeController::class, 'getGrades']);
Route::get('masters/add-grade', [GradeController::class, 'viewAddGrade']);
Route::post('masters/save-grade', [GradeController::class, 'saveGrade']);
Route::get('masters/edit-grade/{id}', [GradeController::class, 'editGrade']);
Route::post('masters/update-grade', [GradeController::class, 'updateGrade']);

Route::get('masters/vw-religion', [ReligionController::class, 'viewReligionList']);
Route::get('masters/add-new-religion', [ReligionController::class, 'addReligionForm']);
Route::post('masters/save-new-religion', [ReligionController::class, 'saveReligionFormSubmit']);
Route::get('masters/edit-new-religion/{id}', [ReligionController::class, 'editReligionForm']);
Route::post('masters/update-new-religion', [ReligionController::class, 'updateReligionFormSubmit']);

Route::get('masters/gpf-rate-listing', [GpfRateController::class, 'gpfRateListing']);
Route::get('masters/add-gpf-rate-detail', [GpfRateController::class, 'viewGpfRate']);
Route::post('masters/gpf-rate-save', [GpfRateController::class, 'saveGpfRate']);
Route::get('masters/edit-gpf-rate-detail/{id}', [GpfRateController::class, 'getgpfrateDtl']);
Route::post('masters/update-gpf-rate', [GpfRateController::class, 'updateGpfRate']);

// PF interest rate master
Route::get('masters/pfinterest', [InterestController::class, 'gpfPfListing']);
Route::get('masters/add-pfinterest', [InterestController::class, 'viewPfRate']);
Route::post('masters/pfinterestsave', [InterestController::class, 'savePfRate']);
Route::get('masters/edit-pfinterest/{id}', [InterestController::class, 'getPfrateDtl']);
Route::post('masters/update-pfinterest', [InterestController::class, 'updateGpfRate']);

// BonusRate master
Route::get('masters/bonus-rate', [BonusRateController::class, 'listing']);
Route::get('masters/add-bonus-rate', [BonusRateController::class, 'view']);
Route::post('masters/save-bonus-rate', [BonusRateController::class, 'save']);
Route::get('masters/edit-bonus-rate/{id}', [BonusRateController::class, 'getBonusRate']);
Route::post('masters/update-bonus-rate', [BonusRateController::class, 'update']);

// ItaxRate master
Route::get('masters/itax-rate', [ItaxRateController::class, 'listing']);
Route::get('masters/add-itax-rate', [ItaxRateController::class, 'view']);
Route::post('masters/save-itax-rate', [ItaxRateController::class, 'save']);
Route::get('masters/edit-itax-rate/{id}', [ItaxRateController::class, 'getItaxRate']);
Route::post('masters/update-itax-rate', [ItaxRateController::class, 'update']);

Route::get('masters/ratelist', [RateDetails::class, 'getRateList']);
Route::get('masters/add-rate', [RateDetails::class, 'addRateDetailsForm']);
Route::post('masters/rate-save', [RateDetails::class, 'SubmitRateDetailsForm']);
Route::get('masters/rate-details/{rate_id}', [RateDetails::class, 'getRateChart']);
Route::post('masters/rate-details', [RateDetails::class, 'saveRateChart']);
Route::get('masters/head-type-by-id/{head_type}', [RateDetails::class, 'HeadTypeIdName']);

Route::get('masters/rate-master', [RateMaster::class, 'getRateMasterList']);
Route::get('masters/add-rate-master', [RateMaster::class, 'addRateMasterDetailsForm']);
Route::post('masters/rate-master-save', [RateMaster::class, 'SubmitRateMasterDetailsForm']);
Route::get('masters/rate-master-details/{rate_id}', [RateMaster::class, 'getRateMasterChart']);
Route::post('masters/rate-master-details', [RateMaster::class, 'saveRateMasterChart']);

Route::get('masters/vw-category', [CategoryController::class, 'categoryList']);
Route::get('masters/add-category', [CategoryController::class, 'addCategory']);
Route::post('masters/save-category', [CategoryController::class, 'saveCategory']);
Route::get('masters/edit-category/{id}', [CategoryController::class, 'editCategory']);
Route::post('masters/update-category', [CategoryController::class, 'updateCategory']);

Route::get('masters/vw-item', [ItemController::class, 'getItem']);
Route::get('masters/add-item', [ItemController::class, 'viewItem']);
Route::post('masters/save-item', [ItemController::class, 'saveItem']);
Route::get('masters/edit-item/{id}', [ItemController::class, 'getItemById']);
Route::post('masters/update-item', [ItemController::class, 'updateItem']);
Route::get('masters/subcategory/{category_id}', [SubCategoryController::class, 'subCategoryID']);

Route::get('masters/vw-sub-category', [SubCategoryController::class, 'index']);
Route::get('masters/add-sub-category', [SubCategoryController::class, 'Create']);
Route::post('masters/save-sub-category', [SubCategoryController::class, 'store']);
Route::get('masters/edit-sub-category/{id}', [SubCategoryController::class, 'edit']);
Route::post('masters/update-sub-category', [SubCategoryController::class, 'update']);

Route::get('masters/vw-supplier', [SupplierController::class, 'getSupplier']);
Route::get('masters/add-supplier', [SupplierController::class, 'viewSupplier']);
Route::post('masters/save-supplier', [SupplierController::class, 'saveSupplier']);
Route::get('masters/edit-supplier/{id}', [SupplierController::class, 'getSupplierById']);
Route::post('masters/update-supplier', [SupplierController::class, 'updateSupplier']);

Route::get('masters/loanlisting', [LoanController::class, 'loanListing']);
Route::get('masters/add-loandetail', [LoanController::class, 'viewLoan']);
Route::get('masters/edit-loandetail/{id}', [LoanController::class, 'getLoanDtl']);
Route::post('masters/save-loandetail', [LoanController::class, 'saveLoan']);
Route::post('masters/update-loandetail', [LoanController::class, 'updateLoan']);

Route::get('masters/vw-loan-conf', [LoanController::class, 'loanConListing']);
Route::get('masters/add-loanconfdetail', [LoanController::class, 'viewConLoan']);
Route::get('masters/edit-loanconfdetail/{id}', [LoanController::class, 'getConLoanDtl']);
Route::post('masters/save-loanconfdetail', [LoanController::class, 'saveConLoan']);
Route::post('masters/update-loanconfdetail', [LoanController::class, 'updateConLoan']);

// Employee Pay Head Master
Route::get('masters/emp-pay-head', [EmpPayHeadController::class, 'getEmpPayHead']);
Route::get('masters/add-new-pay-head', [EmpPayHeadController::class, 'addNewPayHead']);
Route::post('masters/save-pay-head', [EmpPayHeadController::class, 'savePayHead']);
Route::get('masters/edit-pay-head/{id}', [EmpPayHeadController::class, 'editPayHead']);
Route::post('masters/update-pay-head', [EmpPayHeadController::class, 'updatePayHead']);
Route::get('masters/del-pay-head/{id}', [EmpPayHeadController::class, 'deletePayHead']);
Route::get('employee/department-name/{emp_department}', [EmployeeController::class, 'EmpDepartment']);

// Employee Type Da
Route::get('masters/emp-type-da', [EmpTypeDaController::class, 'getEmpTypeDA']);
Route::get('masters/add-emp-type-da', [EmpTypeDaController::class, 'addEmpTypeDA']);
Route::post('masters/save-emp-type-da', [EmpTypeDaController::class, 'saveEmpTypeDA']);
Route::get('masters/edit-emp-type-da/{id}', [EmpTypeDaController::class, 'editEmpTypeDA']);
Route::post('masters/update-emp-type-da', [EmpTypeDaController::class, 'updateEmpTypeDA']);
Route::get('masters/del-emp-type-da/{id}', [EmpTypeDaController::class, 'deleteEmpTypeDA']);

// P Tax Slab
Route::get('masters/tax-slab', [TaxSlabController::class, 'getTaxSlab']);
Route::get('masters/add-tax-slab', [TaxSlabController::class, 'addTaxSlab']);
Route::post('masters/save-tax-slab', [TaxSlabController::class, 'saveTaxSlab']);
Route::get('masters/edit-tax-slab/{id}', [TaxSlabController::class, 'editTaxSlab']);
Route::post('masters/update-tax-slab', [TaxSlabController::class, 'updateTaxSlab']);
Route::get('masters/del-tax-slab/{id}', [TaxSlabController::class, 'deleteTaxSlab']);

// CO-OPERATIVE MASTER
Route::get('masters/cooperative-master', [CooperativeController::class, 'getCoopMaster']);
Route::get('masters/add-cooperative-master', [CooperativeController::class, 'addCoopMaster']);
Route::post('masters/save-cooperative-master', [CooperativeController::class, 'saveCoopMaster']);
Route::get('masters/edit-cooperative-master/{id}', [CooperativeController::class, 'editCoopMaster']);
Route::post('masters/update-cooperative-master', [CooperativeController::class, 'updateCoopMaster']);
Route::get('masters/del-cooperative-master/{id}', [CooperativeController::class, 'deleteCoopMaster']);

// HRA MASTER
Route::get('masters/hra-master', [HraController::class, 'getHraMaster']);
Route::get('masters/add-hra-master', [HraController::class, 'addHraMaster']);
Route::post('masters/save-hra-master', [HraController::class, 'saveHraMaster']);
Route::get('masters/edit-hra-master/{id}', [HraController::class, 'editHraMaster']);
Route::post('masters/update-hra-master', [HraController::class, 'updateHraMaster']);
Route::get('masters/del-hra-master/{id}', [HraController::class, 'deleteHraMaster']);

// HR Pay Parameter
Route::get('masters/hr-pay-parameter', [HrPayController::class, 'getHrPay']);
Route::get('masters/add-hr-pay-parameter', [HrPayController::class, 'addHrPay']);
Route::post('masters/save-hr-pay-parameter', [HrPayController::class, 'saveHrPay']);
Route::get('masters/edit-hr-pay-parameter/{id}', [HrPayController::class, 'editHrPay']);
Route::post('masters/update-hr-pay-parameter', [HrPayController::class, 'updateHrPay']);
Route::get('masters/del-hr-pay-parameter/{id}', [HrPayController::class, 'deleteHrPay']);

// Education Master
Route::get('masters/education', [EducationController::class, 'getEducation']);
Route::get('masters/add-education', [EducationController::class, 'addEducation']);
Route::post('masters/save-education', [EducationController::class, 'saveEducation']);
Route::get('masters/edit-education/{id}', [EducationController::class, 'editEducation']);
Route::post('masters/update-education', [EducationController::class, 'updateEducation']);
Route::get('masters/del-education/{id}', [EducationController::class, 'deleteEducation']);

// Employee Pay Head Link Master
Route::get('masters/emp-pay-head-link', [EmpPayHeadLinkController::class, 'getEmpPayHeadLink']);
Route::get('masters/add-emp-pay-head-link', [EmpPayHeadLinkController::class, 'addEmpPayHeadLink']);
Route::post('masters/save-emp-pay-head-link', [EmpPayHeadLinkController::class, 'saveEmpPayHeadLink']);
Route::get('masters/edit-emp-pay-head-link/{id}', [EmpPayHeadLinkController::class, 'editEmpPayHeadLink']);
Route::post('masters/update-emp-pay-head-link', [EmpPayHeadLinkController::class, 'updateEmpPayHeadLink']);
Route::get('masters/del-emp-pay-head-link/{id}', [EmpPayHeadLinkController::class, 'deleteEmpPayHeadLink']);

// VDA Details
Route::get('masters/vda-details', [VDAController::class, 'getVdaDetails']);
Route::get('masters/add-vda-details', [VDAController::class, 'addVdaDetails']);
Route::post('masters/save-vda-details', [VDAController::class, 'saveVdaDetails']);
Route::get('masters/del-vda-details/{id}', [VDAController::class, 'deleteVdaDetails']);
Route::get('masters/search-vda-details', [VDAController::class, 'searchVdaDetails']);
Route::post('masters/search-vda-details', [VDAController::class, 'showVdaDetails']);

// Pay type
Route::get('masters/pay-type', [PayTypeController::class, 'getPayType']);
Route::get('masters/add-pay-type', [PayTypeController::class, 'addPayType']);
Route::post('masters/save-pay-type', [PayTypeController::class, 'savePayType']);
Route::get('masters/edit-pay-type/{id}', [PayTypeController::class, 'editPayType']);
Route::post('masters/update-pay-type', [PayTypeController::class, 'updatePayType']);
Route::get('masters/del-pay-type/{id}', [PayTypeController::class, 'deletePayType']);

// Group Name
Route::get('masters/group-name', [GroupNameController::class, 'getGroupName']);
Route::get('masters/add-group-name', [GroupNameController::class, 'addGroupName']);
Route::post('masters/save-group-name', [GroupNameController::class, 'saveGroupName']);
Route::get('masters/edit-group-name/{id}', [GroupNameController::class, 'editGroupName']);
Route::post('masters/update-group-name', [GroupNameController::class, 'updateGroupName']);
Route::get('masters/del-group-name/{id}', [GroupNameController::class, 'deleteGroupName']);
//******* Routes with Master end *********//

//******* Routes with Role start *********//
Route::get('role/dashboard', [UserAccessRightsController::class, 'viewdashboard']);
Route::get('role/vw-users', [UserAccessRightsController::class, 'viewUserConfig']);
Route::get('role/add-user-config', [UserAccessRightsController::class, 'viewUserConfigForm']);
Route::post('role/save-user-config', [UserAccessRightsController::class, 'SaveUserConfigForm']);
Route::get('role/edit-user-config/{user_id}', [UserAccessRightsController::class, 'GetUserConfigForm']);
Route::post('role/update-user-config', [UserAccessRightsController::class, 'UpdateUserConfigForm']);

Route::get('role/view-users-role', [UserAccessRightsController::class, 'viewUserAccessRights']);
Route::get('role/add-user-role', [UserAccessRightsController::class, 'viewUserAccessRightsForm']);
Route::post('role/save-user-role', [UserAccessRightsController::class, 'saveUserAccessRightsForm']);
Route::get('role/delete-users-role/{role_authorization_id}', [UserAccessRightsController::class, 'deleteUserAccess']);

Route::get('role/get-sub-modules/{id_module}', [UserAccessRightsController::class, 'subModuleID']);
Route::get('role/get-role-menu/{id_sub_module}', [UserAccessRightsController::class, 'subMenuID']);
//******* Routes with Role end *********//

//******* Routes with MIS start *********//
Route::get('mis/dashboard', [AccountpayablereportController::class, 'viewdashboard']);
Route::get('consoliated-balancesheet', [AccountpayablereportController::class, 'consoliatedBalancesheetView']);
Route::post('consoliated-balancesheet', [AccountpayablereportController::class, 'consoliatedBalancesheetReport']);

Route::get('receipt-payment-report', [AccountpayablereportController::class, 'receiptPaymentView']);
Route::post('receipt-payment-report', [AccountpayablereportController::class, 'receiptPaymentReport']);

Route::get('sumary-report-income', [AccountpayablereportController::class, 'getIncomeSummaryReport']);
Route::post('sumary-report-income', [AccountpayablereportController::class, 'viewIncomeSummaryReport']);

Route::get('balance-sheet-report', [AccountpayablereportController::class, 'balanceSheetView']);
Route::post('balance-sheet-report', [AccountpayablereportController::class, 'balanceSheetReport']);

Route::get('income-expenditure-report', [AccountpayablereportController::class, 'incomeExpenditureView']);
Route::post('income-expenditure-report', [AccountpayablereportController::class, 'incomeExpenditureReport']);

Route::get('income-schedules', [AccountpayablereportController::class, 'viewIncomeSchedules']);
Route::post('schedule-code', [AccountpayablereportController::class, 'viewIncomeScheduleReport']);

Route::get('bs-schedules', [AccountpayablereportController::class, 'viewBalanceSchedules']);
Route::post('bs_schedule-code', [AccountpayablereportController::class, 'viewBalanceScheduleReport']);

Route::get('establishment-receipt-payment', [AccountpayablereportController::class, 'establishmentReceiptPayment']);
Route::post('establishment-receipt-payment', [AccountpayablereportController::class, 'establishmentReceiptPaymentReport']);

Route::get('cash-book-report', [AccountpayablereportController::class, 'getCashbookReport']);
Route::post('cash-book-report', [AccountpayablereportController::class, 'viewCashbookReport']);

Route::get('petty-book-report', [AccountpayablereportController::class, 'getPettyCashReport']);
Route::post('petty-book-report', [AccountpayablereportController::class, 'viewPettyCashReport']);

Route::get('bankbook/report', [AccountpayablereportController::class, 'bankbookView']);
Route::post('bankbook/report', [AccountpayablereportController::class, 'showBankbookReport']);
Route::get('company/get-company-bank-pay/{bank_name}', [AccountpayablereportController::class, 'getBankName']);

Route::get('contra-voucher-report', [AccountpayablereportController::class, 'getContraVoucherReport']);
Route::post('contra-voucher-report', [AccountpayablereportController::class, 'viewContraVoucherReport']);

Route::get('receipt-voucher-report', [AccountpayablereportController::class, 'getReceiptVoucherReport']);
Route::post('receipt-voucher-report', [AccountpayablereportController::class, 'viewReceiptVoucherReport']);

Route::get('payment-voucher-report', [AccountpayablereportController::class, 'getPaymentVoucherReport']);
Route::post('payment-voucher-report', [AccountpayablereportController::class, 'viewPaymentVoucherReport']);

Route::get('party-ledger-report', [AccountpayablereportController::class, 'getPartyLedgerReport']);
Route::post('party-ledger-report', [AccountpayablereportController::class, 'showPartyLedgerReport']);

Route::get('glhead/report', [AccountpayablereportController::class, 'glHeadView']);
Route::get('glhead/report/{gl_head_type}', [AccountpayablereportController::class, 'getGlHeadView']);
Route::post('glhead/report', [AccountpayablereportController::class, 'showGlHeadReport']);

Route::get('trial-balance-report', [AccountpayablereportController::class, 'trialView']);
Route::post('trial-balance-report', [AccountpayablereportController::class, 'showtrialReport']);
//******* Routes with MIS end *********//

//******* Routes with HCM start *********//
Route::get('employee/dashboard', [EmployeeController::class, 'viewdashboard']);
Route::get('employees', [EmployeeController::class, 'getEmployees']);
Route::post('xls-export-employees', [EmployeeController::class, 'employees_xlsexport']);
Route::post('xls-export-employee-only', [EmployeeController::class, 'employees_xlsexportonly']);

Route::get('employees/class', [EmployeeController::class, 'employeesByClass']);
Route::get('employees/department', [EmployeeController::class, 'employeesByDepartment']);

Route::post('employees/department-export-report', [EmployeeController::class, 'emp_dep_xlsexport']);
Route::post('employees/class-export-report', [EmployeeController::class, 'emp_class_xlsexport']);
Route::get('employees/ex-report', [EmployeeController::class, 'emp_ex_report']);

Route::get('add-employee', [EmployeeController::class, 'viewAddEmployee']);
Route::post('save-employee', [EmployeeController::class, 'saveEmployee']);
Route::get('edit-employee', [EmployeeController::class, 'editEmployee']);
Route::post('update-employee', [EmployeeController::class, 'updateEmployee']);
Route::get('settings/get-add-row-item/{row}', [EmployeeController::class, 'ajaxAddRow']);
Route::get('settings/get-add-row-earn/{row}', [EmployeeController::class, 'ajaxAddRowearn']);
Route::get('settings/get-add-row-deduct/{row}', [EmployeeController::class, 'ajaxAddRowdeduct']);
Route::get('settings/get-earn/{headname}/{val}/{emp_basic_pay}', [EmployeeController::class, 'ajaxAddvalue']);

Route::get('attendance/get-employee-bank/{emp_bank_id}', [EmployeeController::class, 'empBankID']);
Route::get('attendance/get-employee-bank-ifsc-code/{emp_branch_id}', [EmployeeController::class, 'empBranchID']);
Route::get('attendance/get-employee-scale/{emp_payscale_id}', [EmployeeController::class, 'empPayID']);
Route::get('attendance/get-grades/{companyid}', [EmployeeController::class, 'companyID']);
Route::get('attendance/get-employee-type/{companyid}', [EmployeeController::class, 'empTypecompanyID']);

Route::get('paystructure-dashboard', [PayStructureController::class, 'viewPayStructureDashboard']);
Route::post('save-paystructure', [PayStructureController::class, 'savePaystructure']);
Route::get('paystructure', [PayStructureController::class, 'getPaystructure']);
Route::get('paystructure/paystructuredelete/{paystructure_id}', [PayStructureController::class, 'deletePaystructure']);

Route::get('promotion', [EmployeeController::class, 'promotionView']);
Route::get('employee/get-employee-all-details/{empid}/{month}/{year}', [EmployeeController::class, 'empDetails']);
Route::post('save-promotion', [EmployeeController::class, 'savePromotion']);

Route::get('promotionreport', [EmployeeController::class, 'viewPromotionReport']);
Route::post('promotionreport', [EmployeeController::class, 'reportPromotionReport']);

Route::get('macp', [EmployeeController::class, 'macpView']);
Route::post('macp', [EmployeeController::class, 'saveMacp']);

Route::get('macpreport', [EmployeeController::class, 'viewMcapReport']);
Route::post('macpreport', [EmployeeController::class, 'reportMcapReport']);

Route::get('increment-report', [EmployeeController::class, 'viewIncrement']);
Route::post('increment-report', [EmployeeController::class, 'reportIncrement']);

Route::get('servicebook', [EmployeeServicebookController::class, 'servicebook']);
//******* Routes with HCM end *********//

//******* Routes with Leave Management start *********//
Route::get('leavemanagement/dashboard', [LeaveTypeController::class, 'viewdashboard']);
Route::get('leave-management/new-leave-type', [LeaveTypeController::class, 'viewAddLeaveType']);
Route::post('leave-management/new-leave-type', [LeaveTypeController::class, 'saveLeaveType']);
Route::get('leave-management/leave-type-listing', [LeaveTypeController::class, 'getLeaveType']);
Route::get('leave-management/leave-type-listing/{ltype_id}', [LeaveTypeController::class, 'getLeaveTypeDtl']);

Route::get('leave-management/save-leave-rule', [LeaveRuleController::class, 'leaveRules']);
Route::post('leave-management/save-leave-rule', [LeaveRuleController::class, 'saveAddLeaveRule']);
Route::get('leave-management/leave-rule-listing', [LeaveRuleController::class, 'getLeaveRules']);
Route::get('leave-management/view-leave-rule/{leave_rule_id}', [LeaveRuleController::class, 'getLeaveRulesById']);

Route::get('leave-management/save-leave-allocation', [LeaveAllocationController::class, 'viewAddLeaveAllocation']);
Route::post('leave-management/get-leave-allocation', [LeaveAllocationController::class, 'getAddLeaveAllocation']);
Route::post('leave-management/save-leave-allocation', [LeaveAllocationController::class, 'saveAddLeaveAllocation']);
Route::get('leave-management/leave-allocation-listing', [LeaveAllocationController::class, 'getLeaveAllocation']);
Route::get('leave-management/leave-allocation-dtl/{leave_allocation_id}', [LeaveAllocationController::class, 'getLeaveAllocationById']);
Route::post('leave-management/save-edit-leave-allocation', [LeaveAllocationController::class, 'editLeaveAllocation']);

Route::get('leave-management/leave-balance', [LeaveBalanceController::class, 'getLeaveBalance']);
Route::get('leave-management/leave-balance-view', [LeaveBalanceController::class, 'leaveBalanceView']);
Route::post('leave-management/leave-balance-view', [LeaveBalanceController::class, 'leaveBalanceReport']);
//******* Routes with Leave Management end *********//

//******* Routes with Holiday start *********//
Route::get('holiday/dashboard', [HolidayController::class, 'viewdashboard']);
Route::get('holidays', [HolidayController::class, 'viewHolidayDetails']);
Route::get('holiday/add-holiday', [HolidayController::class, 'viewAddHoliday']);
Route::post('holiday/add-holiday', [HolidayController::class, 'saveHolidayData']);
Route::get('holiday/add-holiday/{holiday_id}', [HolidayController::class, 'getHolidayDtl']);
Route::get('holiday/holidaydelete/{holiday_id}', [HolidayController::class, 'deleteHoliday']);

Route::get('holiday-type', [HolidayController::class, 'viewHolidayTypeDetails']);
Route::get('holiday/add-holiday-type', [HolidayController::class, 'viewAddHolidayType']);
Route::post('holiday/add-holiday-type', [HolidayController::class, 'saveHolidayTypeData']);
Route::get('holiday/add-holiday-type/{holiday_id}', [HolidayController::class, 'getHolidayTypeDtl']);
//******* Routes with Holiday end *********//

//******* Routes with Leave & Tour start *********//
Route::get('leave-approver/dashboard', [LeaveApproverController::class, 'viewdashboard']);
Route::get('leave-approver/leave-approved', [LeaveApproverController::class, 'viewLeaveApproved']);
Route::post('leave-approver/leave-approved', [LeaveApproverController::class, 'SaveLeaveApproved']);
Route::get('leave-approver/leave-approved-right', [LeaveApproverController::class, 'ViewLeavePermission']);
Route::post('leave-approver/leave-approved-right', [LeaveApproverController::class, 'SaveLeavePermission']);
Route::get('leave-approver/tour-approved-right', [LeaveApproverController::class, 'ViewTourPermission']);
Route::post('leave-approver/tour-approved-right', [LeaveApproverController::class, 'SaveTourPermission']);
Route::get('leave-approver/loan-approved-right', [LeaveApproverController::class, 'ViewLoanPermission']);
Route::post('leave-approver/loan-approved-right', [LeaveApproverController::class, 'SaveLoanPermission']);
Route::get('pension-approver/pension-approved-right', [LeaveApproverController::class, 'ViewpensionPermission']);
Route::post('pension-approver/pension-approved-right', [LeaveApproverController::class, 'SavepensionPermission']);

Route::get('loanother-approver/loanother-approved-right', [LeaveApproverController::class, 'Viewloanother']);
Route::post('loanother-approver/loanother-approved-right', [LeaveApproverController::class, 'Saveloanother']);

Route::get('leave-approver/ltc-approved', [LeaveApproverController::class, 'ViewLtcPermission']);
Route::post('leave-approver/ltc-approved', [LeaveApproverController::class, 'SaveLtcPermission']);
//******* Routes with Leave & Tour Approver end *********//

//******* Routes with attendance start *********//
Route::get('attendance/dashboard', [UploadAttendenceController::class, 'viewdashboard']);
Route::get('attendance/upload-data', [UploadAttendenceController::class, 'viewUploadAttendence']);
Route::post('attendance/upload-data', [UploadAttendenceController::class, 'importExcel']);
Route::get('attendance/daily-attendance', [DailyAttendanceController::class, 'viewDailyAttendance']);
Route::post('attendance/daily-attendance', [DailyAttendanceController::class, 'getDailyAttandance']);
Route::post('attendance/add-daily-attendance', [DailyAttendanceController::class, 'updateDailyAttendance']);
Route::get('attendance/process-attendance', [ProcessAttendanceController::class, 'viewProcessAttendance']);
Route::post('attendance/process-attendance', [ProcessAttendanceController::class, 'getProcessAttandance']);
Route::post('attendance/add-process-attendance', [ProcessAttendanceController::class, 'updateDailyProcessAttendance']);
Route::post('attendance/save-Process-Attandance', [ProcessAttendanceController::class, 'saveProcessAttandance']);
Route::get('attendance/monthly-attendance', [MonthlyAttendanceController::class, 'viewMonthlyAttendance']);
Route::post('attendance/monthly-attendance', [MonthlyAttendanceController::class, 'getMonthlyAttandance']);
Route::get('attendance/delete-monthly-attandance/', [MonthlyAttendanceController::class, 'deleteMonthlyAttandance']);

Route::get('attendance/daily-attendance-report', [ReportController::class, 'viewDailyAttendance']);
Route::post('attendance/daily-attendance-report', [ReportController::class, 'getDailyAttandance']);
Route::post('attendance/xls-export-daily-attendance-report', [ReportController::class, 'attandences_xlsexport']);
//******* Routes with attendance end *********//

//******* Routes with HCM Employee Corner start *********//
Route::get('employee-corner/dashboard', [EmployeeCornerHomeController::class, 'viewDashboard']);
Route::get('employee-corner/employee-profile', [EmployeeController::class, 'getEmployeeById']);
Route::get('employee-corner/holiday-calendar', [EmployeeCornerHomeController::class, 'viewHolidayCalendar']);
Route::get('employee-corner/apply-leave', [LeaveApplyController::class, 'viewapplyleaveapplication']);
Route::post('employee-corner/save-apply-leave', [LeaveApplyController::class, 'saveApplyLeaveData']);
Route::get('employee-corner/get-leave-in-hand/{id_leave_type}', [LeaveApplyController::class, 'leaveTypeID']);
Route::post('employee-corner/holiday-count', [LeaveApplyController::class, 'holidayLeaveApplyAjax']);

Route::post('employee-corner/change-password', [EmployeeController::class, 'savecahngepass']);

Route::get('employee-corner/tourlisting', [TourApplyController::class, 'tourapplicationListing']);
Route::get('employee-corner/apply-for-tour', [TourApplyController::class, 'viewApplytourapplication']);
Route::post('employee-corner/apply-for-tour', [TourApplyController::class, 'saveApplytourapplication']);
Route::get('employee-corner/tourdtl/{tour_id}', [TourApplyController::class, 'getTourdtlById']);

Route::get('employee-corner/apply-for-ltc', [LtcApplyController::class, 'viewApplyltcapplication']);
Route::post('employee-corner/apply-for-ltc', [LtcApplyController::class, 'saveApplyltcapplication']);

Route::get('employee-corner/loanlisting', [LoanApplyuserController::class, 'luserapplicationListing']);
Route::get('employee-corner/loan-apply', [LoanApplyuserController::class, 'viewApplyluserapplication']);
Route::post('employee-corner/save-loan-apply', [LoanApplyuserController::class, 'saveApplyluserapplication']);
Route::post('employee-corner/get-loan-in-hand/{id_leave_type}', [LoanApplyuserController::class, 'leavetypeAjax']);

Route::get('employee/payslip', [EmployeeWisePayslipController::class, 'showSinglePayslip']);
Route::post('employee/payslip', [EmployeeWisePayslipController::class, 'singlePayslip']);

Route::get('employee-corner/vw-login-logout-status', [LoginLogutController::class, 'viewLoginLogout']);
Route::post('employee-corner/login-logout-status', [LoginLogutController::class, 'searchLoginLogout']);

Route::get('employee-corner/gpf-details', [EmployeeController::class, 'getPfDetails']);

Route::get('employee-corner/gpf-loan-apply', [GpfLoanApplyController::class, 'viewLoanApply']);
Route::post('employee-corner/gpf-loan-apply', [GpfLoanApplyController::class, 'saveLoanApply']);

Route::get('employee-corner/pension', [EmployeeController::class, 'getPensionDetails']);
Route::post('employee-corner/pension', [EmployeeController::class, 'savePension']);
//******* Routes with HCM Employee Corner end *********//

//******* Routes with Finance & Accounts start *********//
// Loans
Route::get('loans/view-loans', [LoanController::class, 'viewLoan']);
Route::get('loans/add-loan', [LoanController::class, 'addLoan']);
Route::post('loans/save-loan', [LoanController::class, 'saveLoan']);
Route::get('loans/edit-loan/{id}', [LoanController::class, 'editLoan']);
Route::post('loans/update-loan', [LoanController::class, 'updateLoan']);

Route::post('loans/xls-export-loan-list', [LoanController::class, 'loan_list_xlsexport']);

Route::get('loans/adjust-loan/{id}', [LoanController::class, 'adjustLoan']);
Route::post('loans/update-loan-adjustment', [LoanController::class, 'updateLoanAdjustment']);
Route::get('loans/view-adjust-loan/{id}', [LoanController::class, 'viewAdjustLoan']);

Route::get('loans/vw-loan-report', [LoanController::class, 'ViewLoanRepo']);
Route::post('loans/vw-loan-report', [LoanController::class, 'showLoanRepo']);
Route::post('loans/prn-loan-report', [LoanController::class, 'printLoanRepo']);
Route::post('loans/xls-export-loan-report', [LoanController::class, 'loan_repo_xlsexport']);

Route::get('loans/check-advance-salary', [LoanController::class, 'checkAdvanceSalary']);
Route::post('loans/check-advance-salary', [LoanController::class, 'showCheckAdvanceSalary']);
Route::post('loans/xls-export-check-advance-salary', [LoanController::class, 'advance_salary_xlsexport']);

Route::get('loans/adjustment-report', [LoanController::class, 'loanAdjustmentReport']);
Route::post('loans/xls-export-adjustment-report', [LoanController::class, 'adjustment_report_xlsexport']);

// Itax module
Route::get('itax/dashboard', [IncomeTaxController::class, 'dashboard']);

// I Tax Rate Slab Master
Route::get('itax/itax-rate-slab', [ITaxRateSlabController::class, 'getITaxRateSlab']);
Route::get('itax/add-itax-rate-slab', [ITaxRateSlabController::class, 'addITaxRateSlab']);
Route::post('itax/save-itax-rate-slab', [ITaxRateSlabController::class, 'saveITaxRateSlab']);
Route::get('itax/edit-itax-rate-slab/{id}', [ITaxRateSlabController::class, 'editITaxRateSlab']);
Route::post('itax/update-itax-rate-slab', [ITaxRateSlabController::class, 'updateITaxRateSlab']);
Route::get('itax/del-itax-rate-slab/{id}', [ITaxRateSlabController::class, 'deleteITaxRateSlab']);

// Income Tax Type
Route::get('itax/income-tax-type', [IncometaxTypeController::class, 'getIncometaxType']);
Route::get('itax/add-income-tax-type', [IncometaxTypeController::class, 'addIncometaxType']);
Route::post('itax/save-income-tax-type', [IncometaxTypeController::class, 'saveIncometaxType']);
Route::get('itax/edit-income-tax-type/{id}', [IncometaxTypeController::class, 'editIncometaxType']);
Route::post('itax/update-income-tax-type', [IncometaxTypeController::class, 'updateIncometaxType']);
Route::get('itax/del-income-tax-type/{id}', [IncometaxTypeController::class, 'deleteIncometaxType']);

Route::get('itax/get-income-tax-type/{fyear}', [IncometaxTypeController::class, 'getItaxTypeByFiscalYear']);

// ITax Deposit
Route::get('itax/deposit', [ItaxDepositController::class, 'getItaxDeposit']);
Route::get('itax/add-deposit', [ItaxDepositController::class, 'addItaxDeposit']);
Route::post('itax/save-deposit', [ItaxDepositController::class, 'saveItaxDeposit']);
Route::get('itax/edit-deposit/{id}', [ItaxDepositController::class, 'editDeposit']);
Route::post('itax/update-deposit', [ItaxDepositController::class, 'updateDeposit']);
Route::get('itax/del-deposit/{id}', [ItaxDepositController::class, 'deleteDeposit']);

// Saving Type Master
Route::get('itax/saving-type', [SavingTypeController::class, 'getSavingType']);
Route::get('itax/add-saving-type', [SavingTypeController::class, 'addSavingType']);
Route::post('itax/save-saving-type', [SavingTypeController::class, 'saveSavingType']);
Route::get('itax/edit-saving-type/{id}', [SavingTypeController::class, 'editSavingType']);
Route::post('itax/update-saving-type', [SavingTypeController::class, 'updateSavingType']);
Route::get('itax/del-saving-type/{id}', [SavingTypeController::class, 'deleteSavingType']);

Route::get('itax/get-saving-type/{taxtypeid}', [SavingTypeController::class, 'getSavingsTypeByTaxType']);

// Employee itax savings
Route::get('itax/employee-savings', [IncomeTaxController::class, 'getEmployeeSavings']);
Route::get('itax/add-employee-savings', [IncomeTaxController::class, 'addEmployeeSavings']);
Route::post('itax/add-employee-savings', [IncomeTaxController::class, 'saveEmployeeSavings']);
Route::get('itax/edit-employee-savings', [IncomeTaxController::class, 'editEmployeeSavings']);
Route::post('itax/edit-employee-savings', [IncomeTaxController::class, 'updateEmployeeSavings']);
Route::get('itax/del-employee-savings', [IncomeTaxController::class, 'deleteEmployeeSavings']);

// Itax Report
Route::get('itax/employee-savings-report', [IncomeTaxController::class, 'getEmployeeSavingsReport']);

// Form16
Route::get('itax/form-sixteen', [IncomeTaxController::class, 'getEmployeeFormSixteen']);

// Payroll
Route::get('payroll/dashboard', [PayrollGenerationController::class, 'payrollDashboard']);

Route::get('payroll/vw-payroll-generation', [PayrollGenerationController::class, 'getPayroll']);
Route::post('payroll/vw-payroll-generation', [PayrollGenerationController::class, 'showPayroll']);
Route::post('payroll/xls-export-payroll-generation', [PayrollGenerationController::class, 'payroll_xlsexport']);

Route::get('payroll/add-payroll-generation', [PayrollGenerationController::class, 'viewPayroll']);
Route::post('payroll/add-payroll-generation', [PayrollGenerationController::class, 'savePayrollDetails']);
Route::get('payroll/getEmployeePayrollById/{empid}/{month}/{year}', [PayrollGenerationController::class, 'empPayrollAjax']);

// Salary adjustment
Route::get('payroll/vw-adjustment-payroll-generation', [PayrollGenerationController::class, 'getAdjustPayroll']);
Route::get('payroll/adjustment-payroll-generation', [PayrollGenerationController::class, 'viewAdjustPayroll']);
Route::post('payroll/adjustment-payroll-generation', [PayrollGenerationController::class, 'saveAdjustmentPayrollDetails']);

// Without payslip - voucher payroll entry
Route::get('payroll/vw-voucher-payroll-generation', [PayrollGenerationController::class, 'getVoucherPayroll']);
Route::get('payroll/voucher-payroll-generation', [PayrollGenerationController::class, 'viewVoucherPayroll']);
Route::post('payroll/voucher-payroll-generation', [PayrollGenerationController::class, 'saveVoucherPayroll']);

Route::get('payroll/vw-payroll-generation-all-employee', [PayrollGenerationController::class, 'getPayrollallemployee']);
Route::post('payroll/vw-payroll-generation-all-employee', [PayrollGenerationController::class, 'showPayrollallemployee']);
Route::get('payroll/add-generate-payroll-all', [PayrollGenerationController::class, 'addPayrollallemployee']);
Route::post('payroll/vw-generate-payroll-all', [PayrollGenerationController::class, 'listPayrollallemployee']);
Route::post('payroll/save-payroll-all', [PayrollGenerationController::class, 'SavePayrollAll']);

Route::get('payroll/vw-process-payroll', [PayrollGenerationController::class, 'getProcessPayroll']);
Route::post('payroll/vw-process-payroll', [PayrollGenerationController::class, 'vwProcessPayroll']);
Route::post('payroll/edit-process-payroll', [PayrollGenerationController::class, 'updateProcessPayroll']);

Route::get('payroll/opening-bal-generation', [PayrollGenerationController::class, 'addbalgpfemployee']);
Route::post('payroll/opening-bal-generation', [PayrollGenerationController::class, 'listbalgpfemployee']);
Route::get('post/vw-opening-bal-payroll-generation', [PayrollGenerationController::class, 'addPayrollbalgpfemployee']);
Route::get('payroll/deletepayroll/{payroll_id}', [PayrollGenerationController::class, 'deletePayrolldeatisl']);
Route::get('payroll/deletepayroll-all/{payroll_id}', [PayrollGenerationController::class, 'deletePayrollAll']);
Route::get('pis/payrolldelete/{payroll_id}', [PayrollGenerationController::class, 'deletePayroll']);

// New version of pf opening
Route::get('payroll/pf-opening-balance', [PayrollGenerationController::class, 'viewPfOpeningBalance']);
Route::get('payroll/upload-pf-opening-balance', [PayrollGenerationController::class, 'uploadPfOpeningBalance']);
Route::post('payroll/upload-pf-opening-balance', [PayrollGenerationController::class, 'importPfOpeningBalance']);

// Yearly bonus input
Route::get('payroll/vw-yearly-bonus', [PayrollGenerationController::class, 'getYearlyBonus']);
Route::post('payroll/vw-yearly-bonus', [PayrollGenerationController::class, 'viewYearlyBonus']);
Route::get('payroll/add-yearly-bonus', [PayrollGenerationController::class, 'addYearlyBonus']);
Route::post('payroll/add-yearly-bonus', [PayrollGenerationController::class, 'listAddYearlyBonus']);
Route::post('payroll/save-bonus-all', [PayrollGenerationController::class, 'SaveBonusAll']);
Route::post('payroll/update-bonus-all', [PayrollGenerationController::class, 'UpdateBonusAll']);

Route::get('payroll/yearly-bonus-entry-report', [PtaxEmployeeWiseController::class, 'ViewBonusEntryRepo']);
Route::post('payroll/yearly-bonus-entry-report', [PtaxEmployeeWiseController::class, 'showBonusEntryRepo']);
Route::post('payroll/xls-export-yearly-bonus-entry-report', [PtaxEmployeeWiseController::class, 'bonus_entry_report_xlsexport']);

// Ptax Employee Wise
Route::get('payroll/ptax-employee-wise', [PtaxEmployeeWiseController::class, 'showPtaxEmployeeWise']);
Route::post('payroll/ptax-employee-wise', [PayrollGenerationController::class, 'showPtax']);
Route::post('payroll/xls-export-ptax-employee-wise', [PtaxEmployeeWiseController::class, 'ptax_xlsexport']);

// Monthly Salary Register
Route::get('payroll/monthly-salary-register', [MonthlySalaryRegisterController::class, 'showMonthlySalaryRegister']);
Route::post('payroll/monthly-salary-register', [MonthlySalaryRegisterController::class, 'showMonthlySalary']);
Route::post('payroll/xls-export-monthly-salary-register', [MonthlySalaryRegisterController::class, 'monthly_salary_xlsexport']);

// Bank Wise Payslip
Route::get('payroll/bank-wise-payslip', [BankWisePayslipController::class, 'showBankWisePayslip']);
Route::post('payroll/bank-wise-payslip', [BankWisePayslipController::class, 'showBankWise']);
Route::post('payroll/xls-export-bank-wise-payslip', [BankWisePayslipController::class, 'bank_wise_xlsexport']);

// Employee Wise Payslip
Route::get('payroll/employee-wise-payslip', [EmployeeWisePayslipController::class, 'showEmployeeWisePayslip']);
Route::post('payroll/employee-wise-payslip', [EmployeeWisePayslipController::class, 'showEmployeeWise']);
Route::post('payroll/xls-export-employee-wise-payslip', [EmployeeWisePayslipController::class, 'employee_wise_xlsexport']);
//******* Routes with Finance & Accounts end *********//

//******* Routes with Project start *********//
Route::get('projects/clients', [ClientController::class, 'getClients']);
Route::get('projects/add-clients', [ClientController::class, 'addClients']);
Route::post('projects/save-clients', [ClientController::class, 'saveClients']);
Route::get('projects/edit-clients/{id}', [ClientController::class, 'editClients']);
Route::post('projects/update-clients', [ClientController::class, 'updateClient']);
// Route::get('projects/delete-client/{client_id}', [ClientController::class, 'deleteClient']);

Route::get('projects/vw-project', [ProjectController::class, 'getProjects']);
Route::get('projects/add-project', [ProjectController::class, 'addProjects']);
Route::post('projects/save-project', [ProjectController::class, 'saveProjects']);
Route::get('projects/edit-project/{id}', [ProjectController::class, 'editProjects']);
Route::post('projects/update-project', [ProjectController::class, 'updateProjects']);
// Route::get('projects/delete-project/{project_id}', [ProjectController::class, 'deleteProject']);

Route::get('projects/vw-resource', [ResourceController::class, 'getResource']);
Route::get('projects/add-resource/{id}', [ResourceController::class, 'addResource']);
Route::post('projects/save-resource', [ResourceController::class, 'saveResource']);
Route::get('projects/edit-resource/{id}', [ResourceController::class, 'editResource']);
Route::post('projects/update-resource', [ResourceController::class, 'updateResource']);
Route::get('projects/delete_resource/{id}', [ResourceController::class, 'deleteResource']);

//timesheet view
Route::get('timesheets/', [TimesheetsController::class, 'view_Timesheet']);
Route::post('timesheets/', [TimesheetsController::class, 'get_Timesheet']);

Route::get('projects/vw-task', [TaskController::class, 'getTask']);
Route::get('projects/add-task/{id}', [TaskController::class, 'addTask']);
Route::post('projects/save-task', [TaskController::class, 'saveTask']);
Route::get('projects/edit-task/{id}', [TaskController::class, 'editTask']);
Route::post('projects/update-task', [TaskController::class, 'updateTask']);
// Route::get('projects/delete-task/{task_id}', [TaskController::class, 'deleteTask']);

Route::get('projects/timesheets', [TimesheetsController::class, 'viewTimesheets']);
Route::get('projects/add-timesheet', [TimesheetsController::class, 'viewAddTimesheet']);
Route::post('projects/add-timesheet', [TimesheetsController::class, 'saveTimesheet']);
Route::get('projects/edit-timesheet/{timesheet_id}', [TimesheetsController::class, 'editTimesheet']);
Route::post('projects/update-timesheet', [TimesheetsController::class, 'updateTimesheet']);
Route::get('projects/delete-timesheet/{timesheet_id}', [TimesheetsController::class, 'deleteTimesheet']);
//******* Routes with Project end *********//

//******* Routes with Timesheet start *********//
Route::get('timesheets/view-sheets', [TimesheetController::class, 'getTimesheets']);
Route::get('timesheets/add-timesheet', [TimesheetController::class, 'addTimesheet']);
Route::post('timesheets/save-timesheet', [TimesheetController::class, 'saveTimesheet']);
// Route::get('timesheets/edit-timesheet/{timesheet_id}', [TimesheetController::class, 'editTimesheet']);
// Route::post('timesheets/update-timesheet', [TimesheetController::class, 'updateTimesheet']);
// Route::get('timesheets/delete-timesheet/{timesheet_id}', [TimesheetController::class, 'deleteTimesheet']);
Route::post('timesheets/add-to-list', [TimesheetController::class, 'addToList']);
Route::get('timesheets/remove-from-list/{tsd_id}', [TimesheetController::class, 'removeFromList']);
//******* Routes with Timesheet end *********//

//******* Routes with Rota start *********//
Route::get('rota/dashboard', [RotaController::class, 'viewdashboard']);
Route::get('rota/rota', [RotaController::class, 'viewRota']);
Route::get('rota/add-rota', [RotaController::class, 'viewAddRota']);
Route::post('rota/add-rota', [RotaController::class, 'saveRota']);
Route::get('rota/edit-rota/{rota_id}', [RotaController::class, 'editRota']);
Route::post('rota/update-rota', [RotaController::class, 'updateRota']);
Route::get('rota/delete-rota/{rota_id}', [RotaController::class, 'deleteRota']);
//******* Routes with Rota end *********//

Route::get('payroll/yearly-bonus-report', [PtaxEmployeeWiseController::class, 'ViewBonusCompleteRepo']);
Route::post('payroll/yearly-bonus-report', [PtaxEmployeeWiseController::class, 'showBonusCompleteRepo']);

Route::get('payroll/yearly-bonus-only-report', [PtaxEmployeeWiseController::class, 'ViewBonusOnlyRepo']);
Route::post('payroll/yearly-bonus-only-report', [PtaxEmployeeWiseController::class, 'showBonusOnlyRepo']);

Route::get('payroll/yearly-exgratia-report', [PtaxEmployeeWiseController::class, 'ViewExgratiaOnlyRepo']);
Route::post('payroll/yearly-exgratia-report', [PtaxEmployeeWiseController::class, 'showExgratiaOnlyRepo']);

//yearly encachments
Route::get('payroll/vw-yearly-encashment', [PayrollGenerationController::class, 'getYearlyEncash']);
Route::post('payroll/vw-yearly-encashment', [PayrollGenerationController::class, 'viewYearlyEncash']);
Route::get('payroll/add-yearly-encashment', [PayrollGenerationController::class, 'addYearlyEncash']);
Route::post('payroll/add-yearly-encashment', [PayrollGenerationController::class, 'listAddYearlyEncash']);
Route::post('payroll/save-encashment-all', [PayrollGenerationController::class, 'SaveEncashAll']);
Route::post('payroll/save-encashment', [PayrollGenerationController::class, 'SaveEncash']);

Route::get('payroll/edit-yearly-encashment/{id}', [PayrollGenerationController::class, 'editYearlyEncash']);

Route::post('payroll/update-encashment', [PayrollGenerationController::class, 'UpdateEncash']);
Route::post('payroll/update-encashment-all', [PayrollGenerationController::class, 'UpdateEncashAll']);

Route::get('payroll/yearly-encashment-entry-report', [PtaxEmployeeWiseController::class, 'ViewEncashEntryRepo']);
Route::post('payroll/yearly-encashment-entry-report', [PtaxEmployeeWiseController::class, 'showEncashEntryRepo']);
Route::post('payroll/xls-export-yearly-encash-entry-report', [PtaxEmployeeWiseController::class, 'encash_entry_report_xlsexport']);

//coop
Route::get('payroll/vw-montly-coop', [PayrollGenerationController::class, 'getMonthlyCoopDeduction']);
Route::post('payroll/vw-montly-coop', [PayrollGenerationController::class, 'viewMonthlyCoopDeduction']);
Route::get('payroll/add-montly-coop-all', [PayrollGenerationController::class, 'addMonthlyCoopDeductionAllemployee']);
Route::post('payroll/vw-add-coop-all', [PayrollGenerationController::class, 'listCoopAllemployee']);
Route::post('payroll/save-coop-all', [PayrollGenerationController::class, 'SaveCoopAll']);
Route::post('payroll/update-coop-all', [PayrollGenerationController::class, 'UpdateCoopAll']);

//add process attendance
Route::get('attendance/add-montly-attendance-data-all', [ProcessAttendanceController::class, 'addMonthlyAttendancePAAllemployee']);
Route::post('attendance/add-montly-attendance-data-all', [ProcessAttendanceController::class, 'listAttendanceAllemployee']);
Route::post('attendance/save-montly-attendance-data-all', [ProcessAttendanceController::class, 'SaveAttendanceAllemployee']);
Route::get('attendance/view-montly-attendance-data-all', [ProcessAttendanceController::class, 'viewMonthlyAttendanceAllemployee']);
Route::post('attendance/view-montly-attendance-data-all', [ProcessAttendanceController::class, 'listMonthlyAttendanceAllemployee']);
Route::post('attendance/update-montly-attendance-data-all', [ProcessAttendanceController::class, 'UpdateAttendanceAllemployee']);

Route::get('attendance/report-monthly-attendance', [ProcessAttendanceController::class, 'reportMonthlyAttendanceAllemployee']);
Route::post('attendance/report-monthly-attendance', [ProcessAttendanceController::class, 'getMonthlyAttendanceReport']);
Route::post('attendance/xls-export-attendance-report', [ProcessAttendanceController::class, 'attandence_xlsexport']);

//incometax
Route::get('payroll/vw-montly-itax', [PayrollGenerationController::class, 'getMonthlyItaxDeduction']);
Route::post('payroll/vw-montly-itax', [PayrollGenerationController::class, 'viewMonthlyItaxDeduction']);
Route::get('payroll/add-montly-itax-all', [PayrollGenerationController::class, 'addMonthlyItaxDeductionAllemployee']);
Route::post('payroll/vw-add-itax-all', [PayrollGenerationController::class, 'listItaxAllemployee']);
Route::post('payroll/save-itax-all', [PayrollGenerationController::class, 'SaveItaxAll']);
Route::post('payroll/update-itax-all', [PayrollGenerationController::class, 'UpdateItaxAll']);

//generate allowances
Route::get('payroll/vw-montly-allowances', [PayrollGenerationController::class, 'getMonthlyEarningAllowances']);
Route::post('payroll/vw-montly-allowances', [PayrollGenerationController::class, 'viewMonthlyEarningAllowances']);
Route::get('payroll/add-montly-allowances', [PayrollGenerationController::class, 'addMonthlyAllowancesAllemployee']);
Route::post('payroll/vw-add-allowances-all', [PayrollGenerationController::class, 'listAllowancesAllemployee']);
Route::post('payroll/save-allowances-all', [PayrollGenerationController::class, 'SaveAllowancesAll']);
Route::post('payroll/update-allowances-all', [PayrollGenerationController::class, 'UpdateAllowancesAll']);

//generate all payslips
Route::get('payroll/vw-all-payslips', [EmployeeWisePayslipController::class, 'getMonthlyPaySlips']);
Route::post('payroll/vw-all-payslips', [EmployeeWisePayslipController::class, 'getAllPayslips']);

//generate overtime
Route::get('payroll/vw-montly-overtime', [PayrollGenerationController::class, 'getMonthlyOvertimes']);
Route::post('payroll/vw-montly-overtimes', [PayrollGenerationController::class, 'viewMonthlyOvertimes']);
Route::get('payroll/add-montly-overtimes', [PayrollGenerationController::class, 'addMonthlyOvertimesAllemployee']);
Route::post('payroll/vw-add-overtimes-all', [PayrollGenerationController::class, 'listOvertimesAllemployee']);
Route::post('payroll/save-overtimes-all', [PayrollGenerationController::class, 'SaveOvertimesAll']);
Route::post('payroll/update-overtimes-all', [PayrollGenerationController::class, 'UpdateOvertimesAll']);

//******* Routes with Finance & Accounts end *********//

//Group Name
Route::get('masters/group-name', [GroupNameController::class, 'getGroupName']);
Route::get('masters/add-group-name', [GroupNameController::class, 'addGroupName']);
Route::post('masters/save-group-name', [GroupNameController::class, 'saveGroupName']);
Route::get('masters/edit-group-name/{id}', [GroupNameController::class, 'editGroupName']);
Route::post('masters/update-group-name', [GroupNameController::class, 'updateGroupName']);
Route::get('masters/del-group-name/{id}', [GroupNameController::class, 'deleteGroupName']);
//******* Routes with Master end *********//

//******* Routes with Payroll report start *********//
Route::get('payroll/paycart', [EmployeeWisePayslipController::class, 'getEmployeePayCart']);
Route::post('payroll/paycart', [EmployeeWisePayslipController::class, 'showEmployeePayCart']);

Route::get('payroll/paycard', [EmployeeWisePayslipController::class, 'getEmployeePayCard']);
Route::post('payroll/paycard', [EmployeeWisePayslipController::class, 'showEmployeePayCard']);

Route::get('payroll/vw-employeewise-view-payslip', [EmployeeWisePayslipController::class, 'getEmployeeWisePayslip']);
Route::post('payroll/vw-employeewise-view-payslip', [EmployeeWisePayslipController::class, 'showEmployeeWisePayslip']);

Route::get('payroll/vw-salary-register', [MonthlySalaryRegisterController::class, 'getMonthlySalaryRegister']);
Route::post('payroll/view-salary-register', [MonthlySalaryRegisterController::class, 'viewMonthlySalarySummary']);

Route::get('payroll/vw-bank-statement', [BankWisePayslipController::class, 'getBankWisePayslip']);
Route::post('payroll/vw-bank-statement', [BankWisePayslipController::class, 'showBankWiseStatement']);
Route::post('payroll/view-bank-statement', [BankWisePayslipController::class, 'viewBankStatement']);
Route::post('payroll/xls-export-bank-statement', [BankWisePayslipController::class, 'xlsExportBankStatement']);
Route::get('payroll/salary-statement', [PtaxEmployeeWiseController::class, 'ViewSalaryStatement']);
Route::post('payroll/salary-statement', [PtaxEmployeeWiseController::class, 'ShowSalaryStatementReport']);
Route::get('payroll/vw-p-tax-department-wise', [PtaxEmployeeWiseController::class, 'ViewPtaxDeptWise']);
Route::post('payroll/vw-p-tax-department-wise', [PtaxEmployeeWiseController::class, 'ShowReportPtaxDeptWise']);
Route::get('payroll/vw-gpf-wise', [PtaxEmployeeWiseController::class, 'ViewGpfMonthlyWise']);
Route::post('payroll/vw-gpf-wise', [PtaxEmployeeWiseController::class, 'ShowReportGpfMonthlyWise']);
Route::get('payroll/vw-gpf-emplyeewise', [PtaxEmployeeWiseController::class, 'ViewGpfEmployeewise']);
Route::post('payroll/vw-gpf-emplyeewise', [PtaxEmployeeWiseController::class, 'ShowReportGpfEmployeewise']);
Route::get('payroll/payslip/{emp_id}/{pay_dtl_id}', [EmployeeWisePayslipController::class, 'viewPayrollDetails']);

Route::get('payroll/vw-incomtax-all', [PtaxEmployeeWiseController::class, 'ViewIncometaxAll']);
Route::post('payroll/vw-incomtax-all', [PtaxEmployeeWiseController::class, 'ShowReportIncomeAll']);
Route::get('payroll/vw-incometax-emplyeewise', [PtaxEmployeeWiseController::class, 'ViewIncomEmployeewise']);

Route::post('payroll/vw-incometax-emplyeewise', [PtaxEmployeeWiseController::class, 'ShowReportIncomeEmployeewise']);

Route::get('payroll/vw-department-summary', [PtaxEmployeeWiseController::class, 'ViewDeptRepoAll']);
Route::post('payroll/vw-department-summary', [PtaxEmployeeWiseController::class, 'showDeptRepoAll']);
Route::post('payroll/prn-department-summary', [PtaxEmployeeWiseController::class, 'printDeptRepoAll']);
Route::post('payroll/xls-export-department-summary', [PtaxEmployeeWiseController::class, 'dept_summary_xlsexport']);

Route::get('payroll/vw-deducted-coop-report', [PtaxEmployeeWiseController::class, 'ViewDeductedCoopRepo']);
Route::post('payroll/vw-deducted-coop-report', [PtaxEmployeeWiseController::class, 'showDeductedCoopRepo']);
Route::post('payroll/prn-deducted-coop-report', [PtaxEmployeeWiseController::class, 'printDeductedCoopRepo']);
Route::post('payroll/xls-export-deducted-coop-report', [PtaxEmployeeWiseController::class, 'deducted_coop_xlsexport']);

Route::get('payroll/vw-non-deducted-coop-report', [PtaxEmployeeWiseController::class, 'ViewNonDeductedCoopRepo']);
Route::post('payroll/vw-non-deducted-coop-report', [PtaxEmployeeWiseController::class, 'showNonDeductedCoopRepo']);
Route::post('payroll/prn-non-deducted-coop-report', [PtaxEmployeeWiseController::class, 'printNonDeductedCoopRepo']);
Route::post('payroll/xls-export-non-deducted-coop-report', [PtaxEmployeeWiseController::class, 'non_deducted_coop_xlsexport']);

Route::get('payroll/vw-misc-recovery-report', [PtaxEmployeeWiseController::class, 'ViewMiscRecoveryRepo']);
Route::post('payroll/vw-misc-recovery-report', [PtaxEmployeeWiseController::class, 'showMiscRecoveryRepo']);
Route::post('payroll/prn-misc-recovery-report', [PtaxEmployeeWiseController::class, 'printMiscRecoveryRepo']);
Route::post('payroll/xls-export-misc-recovery-report', [PtaxEmployeeWiseController::class, 'misc_recovery_xlsexport']);

Route::get('payroll/monthly-coop-entry-report', [PtaxEmployeeWiseController::class, 'ViewCoopEntryRepo']);
Route::post('payroll/monthly-coop-entry-report', [PtaxEmployeeWiseController::class, 'showCoopEntryRepo']);
Route::post('payroll/xls-export-monthly-coop-entry-report', [PtaxEmployeeWiseController::class, 'coop_entry_report_xlsexport']);

Route::get('payroll/monthly-incometax-entry-report', [PtaxEmployeeWiseController::class, 'ViewIncometaxEntryRepo']);
Route::post('payroll/monthly-incometax-entry-report', [PtaxEmployeeWiseController::class, 'showIncometaxEntryRepo']);
Route::post('payroll/xls-export-monthly-incometax-entry-report', [PtaxEmployeeWiseController::class, 'incometax_entry_report_xlsexport']);

Route::get('payroll/monthly-overtime-entry-report', [PtaxEmployeeWiseController::class, 'ViewOvertimeEntryRepo']);
Route::post('payroll/monthly-overtime-entry-report', [PtaxEmployeeWiseController::class, 'showOvertimeEntryRepo']);
Route::post('payroll/xls-export-monthly-overtime-entry-report', [PtaxEmployeeWiseController::class, 'overtime_entry_report_xlsexport']);

Route::get('payroll/monthly-allowance-entry-report', [PtaxEmployeeWiseController::class, 'ViewAllowanceEntryRepo']);
Route::post('payroll/monthly-allowance-entry-report', [PtaxEmployeeWiseController::class, 'showAllowanceEntryRepo']);
Route::post('payroll/xls-export-monthly-allowance-entry-report', [PtaxEmployeeWiseController::class, 'allowance_entry_report_xlsexport']);

//******* Routes with Payroll report end *********//

//******* Routes with Rota start *********//

//rota dashboard
Route::get('rota-dashboard', [RotaController::class, 'RotaDashboard']);

//shift management
Route::get('rota/shift-management', [RotaController::class, 'viewshift']);
Route::get('rota/add-shift-management', [RotaController::class, 'viewAddNewShift']);
Route::post('rota/save-shift-management', [RotaController::class, 'saveShiftData']);
Route::get('rota/getEmployeedesigByshiftId/{empid}', [RotaController::class, 'ajaxEmpShift']);
Route::get('rota/edit-shift-management/{id}', [RotaController::class, 'editShift']);
Route::post('rota/update-shift-management', [RotaController::class, 'updateShiftData']);

//Late policy
Route::get('rota/late-policy', [RotaController::class, 'viewlate']);
Route::get('rota/add-late-policy', [RotaController::class, 'viewAddNewlate']);
Route::get('rota/getEmployeedesigBylateId/{empid}', [RotaController::class, 'ajaxEmpShiftLate']);
Route::post('rota/save-late-policy', [RotaController::class, 'savelateData']);
Route::get('rota/edit-late-policy/{id}', [RotaController::class, 'editlate']);
Route::post('rota/update-late-policy', [RotaController::class, 'updatelateData']);

//Day Off
Route::get('rota/offday', [RotaController::class, 'viewoffday']);
Route::get('rota/add-offday', [RotaController::class, 'viewAddNewoffday']);
Route::get('rota/edit-offday/{id}', [RotaController::class, 'editoffday']);
Route::post('rota/save-offday', [RotaController::class, 'saveoffdayData']);
Route::post('rota/update-offday', [RotaController::class, 'updateoffdayData']);

//Grace Period
Route::get('rota/grace-period', [RotaController::class, 'viewgrace']);
Route::get('rota/add-grace-period', [RotaController::class, 'viewAddNewgrace']);
Route::get('rota/edit-grace-period/{id}', [RotaController::class, 'editGrace']);
Route::post('rota/save-grace-period', [RotaController::class, 'savegraceData']);
Route::post('rota/update-grace-period', [RotaController::class, 'updategraceData']);

//Duty Roster
Route::get('rota/duty-roster', [RotaController::class, 'viewroster']);
Route::get('rota/getEmployeedailyattandeaneshightById/{empid}', [RotaController::class, 'ajaxEmpCode']);
Route::post('rota/add-duty-roster', [RotaController::class, 'saverosterData']);

Route::get('rota/add-employee-duty', [RotaController::class, 'viewAddNewemployeeduty']);
Route::post('rota/save-employee-duty', [RotaController::class, 'saveemployeedutyData']);

Route::get('rota/add-department-duty', [RotaController::class, 'viewAddNewdepartmentduty']);
Route::post('rota/save-department-duty', [RotaController::class, 'savedepartmentdutyData']);
Route::get('rota/getEmployeedesigBydutytshiftId/{empid}', [RotaController::class, 'ajaxEmpShiftCode']);
Route::get('rota/getEmployeedailyattandeaneshightdutyById/{empid}', [RotaController::class, 'ajaxRotaEmp']);

Route::get('appleave/leave-status/{employee_id}', [AppemployeeController::class, 'allleavreqe']);
Route::get('appemployees/attendance-monthwise/{emp_id}/{month_yr}', [AppemployeeController::class, 'viewattendancemonthwise']);
Route::get('appemployees/view-approved-leave/{emp_id}', [AppemployeeController::class, 'viewapprovedleave']);
Route::get('appemployees/daily-attendance/{emp_id}', [AppemployeeController::class, 'viewdailyattendancemonthwise']);
//******* Routes with Rota end *********//

/***** Project management routes************ */
//------Admin routes start-------
//Clients route
Route::get('projects/clients', [ClientController::class, 'getClients']);
Route::get('projects/add-clients', [ClientController::class, 'addClients']);
Route::post('projects/save-clients', [ClientController::class, 'saveClients']);
Route::get('projects/edit-clients/{id}', [ClientController::class, 'editClients']);
Route::post('projects/update-clients', [ClientController::class, 'updateClient']);

//Project route
Route::get('projects/vw-project', [ProjectController::class, 'getProjects']);
Route::get('projects/add-project', [ProjectController::class, 'addProjects']);
Route::post('projects/save-project', [ProjectController::class, 'saveProjects']);
Route::get('projects/edit-project/{id}', [ProjectController::class, 'editProjects']);
Route::post('projects/update-project', [ProjectController::class, 'updateProjects']);

//Resource  route
Route::get('projects/vw-resource', [ResourceController::class, 'getResource']);
Route::get('projects/add-resource/{id}', [ResourceController::class, 'addResource']);
Route::post('projects/save-resource', [ResourceController::class, 'saveResource']);
Route::get('projects/edit-resource/{id}', [ResourceController::class, 'editResource']);
Route::get('projects/delete_resource/{id}', [ResourceController::class, 'deleteResource']);
Route::post('projects/update-resource', [ResourceController::class, 'updateResource']);
Route::get('projects/delete-resource/{id}', [ResourceController::class, 'deleteResource']);

//timesheet view
Route::get('timesheets/', [TimesheetsController::class, 'view_Timesheet']);
Route::post('timesheets/', [TimesheetsController::class, 'get_Timesheet']);

//------Admin routes end-------
//------Employee login routes start-------
Route::get('timesheets/view-sheets', [EmployeeCornerTimesheetsController::class, 'getTimesheets']);
Route::get('timesheets/add-timesheet', [EmployeeCornerTimesheetsController::class, 'addTimesheet']);
Route::post('timesheets/save-timesheet', [EmployeeCornerTimesheetsController::class, 'saveTimesheet']);
Route::post('timesheets/add-to-list', [EmployeeCornerTimesheetsController::class, 'addToList']);
Route::get('timesheets/remove-from-list/{tsd_id}', [EmployeeCornerTimesheetsController::class, 'removeFromList']);

// Route::get('timesheets/add-timesheets', 'Timesheets\TimesheetController@addTimesheets');
// Route::post('timesheets/add-timesheets', 'Timesheets\TimesheetController@saveTimesheets');
// Route::post('timesheets/save_draft-timesheets', 'Timesheets\TimesheetController@saveTimesheets');
// Route::post('timesheets/save_draft-timesheets', 'Timesheets\TimesheetController@save_draft');
// Route::post('timesheets/save_submit-timesheets', 'Timesheets\TimesheetController@save_submit');
Route::get('timesheets/edit-timesheets/{id}', [EmployeeCornerTimesheetsController::class, 'editTimesheets']);
Route::get('timesheets/view-timesheets/{id}', [EmployeeCornerTimesheetsController::class, 'viewTimesheets']);
// Route::post('timesheets/update-timesheets', 'Timesheets\TimesheetController@updateTimesheets');
// Route::post('timesheets/update-draft-timesheets', 'Timesheets\TimesheetController@updatedraftTimesheets');
Route::post('timesheets/edit-timesheets/{id}', [EmployeeCornerTimesheetsController::class, 'saveTimesheets']);

//Task route
Route::get('projects/get-employee-tasks/{employee_id}/{project_id}', [ProjectController::class, 'getProjectTasks']);

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
