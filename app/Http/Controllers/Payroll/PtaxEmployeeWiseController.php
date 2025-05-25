<?php

namespace App\Http\Controllers\Payroll;

use App\Exports\ExcelFileExportAllowanceEntry;
use App\Exports\ExcelFileExportBonusEntry;
use App\Exports\ExcelFileExportCoopEntry;
use App\Exports\ExcelFileExportDeductedCoop;
use App\Exports\ExcelFileExportDeptSummary;
use App\Exports\ExcelFileExportEncashEntry;
use App\Exports\ExcelFileExportItaxEntry;
use App\Exports\ExcelFileExportMiscRecovery;
use App\Exports\ExcelFileExportNonDeductedCoop;
use App\Exports\ExcelFileExportOvertimeEntry;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee_pay_structure;
use App\Models\Masters\Company;
use App\Models\Masters\Role_authorization;
use App\Models\Payroll\MonthlyEmployeeAllowance;
use App\Models\Payroll\MonthlyEmployeeCooperative;
use App\Models\Payroll\MonthlyEmployeeItax;
use App\Models\Payroll\MonthlyEmployeeOvertime;
use App\Models\Payroll\Payroll_detail;
use App\Models\Payroll\YearlyEmployeeBonus;
use App\Models\Payroll\YearlyEmployeeLencHta;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use View;

class PtaxEmployeeWiseController extends Controller
{
    //
    public function ViewSalaryStatement()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();

            return view('payroll/vw-salary-statement', $data);
        } else {
            return redirect('/');
        }
    }

    public function ShowSalaryStatementReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['payroll_rs'] = Payroll_detail::where('month_yr', '=', $request->month_yr)
                ->select('*')
                ->get();
            $monthlist = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['company_rs'] = Company::orderBy('id', 'desc')->first();
            if (count($data['payroll_rs']) != 0) {
                //$data['month_yr']=$request->month_yr;
                //dd($data);
                return view('payroll/summery-salary-statement', $data);
            } else {
                Session::flash('error', 'Payslip is not Generated .');
                $data['month_yr_new'] = $request->month_yr;
                return view('payroll/vw-salary-statement', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function ViewPtaxDeptWise()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            return view('payroll/vw-p-tax-department-wise', $data);

        } else {
            return redirect('/');
        }
    }

    public function ShowReportPtaxDeptWise(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['month_yr'] = $request->month_yr;
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();

            $data['employee_ptax'] = Payroll_detail::select('payroll_details.employee_id', 'payroll_details.emp_name', 'payroll_details.emp_prof_tax', 'payroll_details.emp_designation', DB::raw('(select old_emp_code from employees where payroll_details.employee_id = employees.emp_code) as old_emp_code'))
                ->where('payroll_details.month_yr', '=', $request->month_yr)
                ->where('payroll_details.emp_prof_tax', '>', '0')
                ->orderBy(DB::raw('(select old_emp_code from employees where payroll_details.employee_id = employees.emp_code)'), 'asc')
                ->get();

            //dd($data['employee_ptax']);
            $data['company_rs'] = Company::orderBy('id', 'desc')->first();

            if (count($data['employee_ptax']) != 0) {
                return view('payroll/ptax-department-wise-report', $data);

            } else {
                $data['month_yr_new'] = $request->month_yr;

                Session::flash('error', 'Data not found');
                return view('payroll/vw-p-tax-department-wise', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function ViewGpfMonthlyWise()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            return view('payroll/vw-gpf', $data);
        } else {
            return redirect('/');
        }
    }

    public function ShowReportGpfMonthlyWise(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['month_yr'] = $request->month_yr;
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();

            $arrMY = explode('/', $request->month_yr);
            $reportMonth = $arrMY[0];
            $reportYear = $arrMY[1];
            $reportFinancialYear = '';
            $reportMinYear = '';
            $reportMaxYear = '';
            if ($reportMonth < 4) {
                $reportFinancialYear = ($reportYear - 1) . '-' . $reportYear;
                $reportMinYear = ($reportYear - 1);
                $reportMaxYear = $reportYear;
            } else {
                $reportFinancialYear = $reportYear . '-' . ($reportYear + 1);
                $reportMinYear = $reportYear;
                $reportMaxYear = ($reportYear + 1);
            }

            //dd($reportFinancialYear);

            $data['employee_ptax'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'payroll_details.id',
                    'payroll_details.employee_id',
                    'payroll_details.emp_name',
                    'payroll_details.emp_pf',
                    'payroll_details.emp_apf',
                    'payroll_details.emp_designation',
                    'payroll_details.emp_basic_pay as basic_pay',
                    'employees.emp_pf_no',
                    'employees.emp_pension',
                    'employees.emp_pf_inactuals',
                    'employees.old_emp_code',
                    'employees.emp_department',
                    'payroll_details.emp_pf_employer',
                    'payroll_details.emp_pf_pension',
                    DB::raw("(SELECT sum(emp_pf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_pf_mtd"),
                    DB::raw("(SELECT sum(emp_pf_employer) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_pf_employer_mtd"),
                    DB::raw("(SELECT sum(emp_pf_pension) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_pf_pension_mtd"),
                    DB::raw("(SELECT sum(emp_apf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_apf_mtd"),
                    DB::raw("(SELECT 0) as opening_data")
                )
                ->where('payroll_details.month_yr', '=', $request->month_yr)
                ->where('payroll_details.emp_pf', '>', '0')
            //->where('employees.emp_code', '=', '7257')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();
            if (count($data['employee_ptax']) != 0) {
                foreach ($data['employee_ptax'] as $val) {
                    $employer_contribution = 0;
                    $pension_contribution = 0;
                    $emp_pf_employer_mtd = 0;
                    //$applicable_pf=$val->emp_pf+$val->emp_apf;
                    if ($val->emp_pension == 'Y') {

                        if ($val->basic_pay > 15000 && $val->emp_pf_inactuals == 'N') {
                            $pension_contribution = 1250;
                        } else {

                            $pension_contribution = round($val->basic_pay * 8.33 / 100);
                        }

                        if ($pension_contribution > 1250) {
                            $pension_contribution = 1250;
                        }
                        $employer_contribution = round($val->emp_pf - $pension_contribution);
                        //$emp_pf_employer_mtd=round($val->emp_pf_mtd-$pension_contribution);

                    } else {
                        $employer_contribution = $val->emp_pf;
                        $pension_contribution = 0;
                        $emp_pf_employer_mtd = 0;
                    }
                    // echo "Emp Code: ".$val->old_emp_code." PF: ".$val->emp_pf." EPF: ".$employer_contribution." Pension: ".$pension_contribution."<br>";

                    $payd = Payroll_detail::find($val->id);

                    $payd->emp_pf_employer = $employer_contribution;
                    $payd->emp_pf_pension = $pension_contribution;

                    //dd($payd);
                    $payd->save();
                }

            }

            $data['employee_ptax'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'payroll_details.id',
                    'payroll_details.employee_id',
                    'payroll_details.emp_name',
                    'payroll_details.emp_pf',
                    'payroll_details.emp_apf',
                    'payroll_details.emp_designation',
                    'payroll_details.emp_basic_pay as basic_pay',
                    'employees.emp_pf_no',
                    'employees.emp_pension',
                    'employees.emp_pf_inactuals',
                    'employees.old_emp_code',
                    'employees.emp_department',
                    'payroll_details.emp_pf_employer',
                    'payroll_details.emp_pf_pension',
                    DB::raw("(SELECT sum(emp_pf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_mtd"),
                    DB::raw("(SELECT sum(emp_pf_employer) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_employer_mtd"),
                    DB::raw("(SELECT sum(emp_pf_pension) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_pension_mtd"),
                    DB::raw("(SELECT sum(emp_apf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request->month_yr . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_apf_mtd"),
                    DB::raw("(SELECT 0) as opening_data")
                )
                ->where('payroll_details.month_yr', '=', $request->month_yr)
                ->where('payroll_details.emp_pf', '>', '0')
            //->where('employees.emp_code', '=', '7257')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            // dd($data['employee_ptax']);

            if (count($data['employee_ptax']) != 0) {
                return view('payroll/gpf-report-new', $data);

            } else {
                $data['month_yr_new'] = $request->month_yr;

                Session::flash('error', 'Data not found');
                return view('payroll/vw-gpf', $data);
            }
        } else {
            return redirect('/');
        }
    }
    public function ViewGpfEmployeewise()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['employeeslist'] = Employee::get();
            return view('payroll/vw-gpf-employeewise', $data);
        } else {
            return redirect('/');
        }
    }

    public function ShowReportGpfEmployeewise(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $arrMY = explode('/', $request['from_month']);
            $reportMonth = $arrMY[0];
            $reportYear = $arrMY[1];
            $reportFinancialYear = '';
            $reportMinYear = '';
            $reportMaxYear = '';
            if ($reportMonth < 4) {
                $reportFinancialYear = ($reportYear - 1) . '-' . $reportYear;
                $reportMinYear = ($reportYear - 1);
                $reportMaxYear = $reportYear;
            } else {
                $reportFinancialYear = $reportYear . '-' . ($reportYear + 1);
                $reportMinYear = $reportYear;
                $reportMaxYear = ($reportYear + 1);
            }

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_ptax'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'payroll_details.id',
                    'payroll_details.employee_id',
                    'payroll_details.emp_name',
                    'payroll_details.emp_pf',
                    'payroll_details.emp_apf',
                    'payroll_details.emp_designation',
                    'employees.emp_pf_no',
                    'employees.emp_pension',
                    'employees.emp_pf_inactuals',
                    'employees.old_emp_code',
                    'employees.emp_department',
                    'payroll_details.emp_pf_employer',
                    'payroll_details.emp_pf_pension',
                    DB::raw("(SELECT sum(emp_pf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_pf_mtd"),
                    DB::raw("(SELECT sum(emp_pf_employer) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_pf_employer_mtd"),
                    DB::raw("(SELECT sum(emp_pf_pension) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_pf_pension_mtd"),
                    DB::raw("(SELECT sum(emp_apf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and (((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMinYear . " and SUBSTRING_INDEX(month_yr, '/', 1)>3  and SUBSTRING_INDEX(month_yr, '/', 1)<=12 ) or ((SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1))=" . $reportMaxYear . " and SUBSTRING_INDEX(month_yr, '/', 1)<4 ))) as emp_apf_mtd"),
                    DB::raw("(SELECT 0) as opening_data"),
                    DB::raw("(SELECT basic_pay FROM employee_pay_structures WHERE employee_code=employees.emp_code) as basic_pay")
                )
                ->where('payroll_details.month_yr', '=', $request['from_month'])
                ->where('payroll_details.employee_id', '=', $request['emp_code'])
                ->where('payroll_details.emp_pf', '>', '0')
            //->where('employees.emp_code', '=', '7257')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            if (count($data['employee_ptax']) != 0) {
                foreach ($data['employee_ptax'] as $val) {
                    $employer_contribution = 0;
                    $pension_contribution = 0;
                    $emp_pf_employer_mtd = 0;
                    //$applicable_pf=$val->emp_pf+$val->emp_apf;
                    if ($val->emp_pension == 'Y') {

                        if ($val->basic_pay > 15000 && $val->emp_pf_inactuals == 'N') {
                            $pension_contribution = 1250;
                        } else {

                            $pension_contribution = round($val->basic_pay * 8.33 / 100);
                        }

                        if ($pension_contribution > 1250) {
                            $pension_contribution = 1250;
                        }
                        $employer_contribution = round($val->emp_pf - $pension_contribution);
                        //$emp_pf_employer_mtd=round($val->emp_pf_mtd-$pension_contribution);

                    } else {
                        $employer_contribution = $val->emp_pf;
                        $pension_contribution = 0;
                        $emp_pf_employer_mtd = 0;
                    }
                    // echo "Emp Code: ".$val->old_emp_code." PF: ".$val->emp_pf." EPF: ".$employer_contribution." Pension: ".$pension_contribution."<br>";

                    $payd = Payroll_detail::find($val->id);

                    $payd->emp_pf_employer = $employer_contribution;
                    $payd->emp_pf_pension = $pension_contribution;

                    //dd($payd);
                    $payd->save();
                }

            }

            $data['employee_ptax'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'payroll_details.id',
                    'payroll_details.employee_id',
                    'payroll_details.emp_name',
                    'payroll_details.emp_pf',
                    'payroll_details.emp_apf',
                    'payroll_details.emp_designation',
                    'employees.emp_pf_no',
                    'employees.emp_pension',
                    'employees.emp_pf_inactuals',
                    'employees.old_emp_code',
                    'employees.emp_department',
                    'payroll_details.emp_pf_employer',
                    'payroll_details.emp_pf_pension',
                    DB::raw("(SELECT sum(emp_pf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_mtd"),
                    DB::raw("(SELECT sum(emp_pf_employer) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_employer_mtd"),
                    DB::raw("(SELECT sum(emp_pf_pension) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_pf_pension_mtd"),
                    DB::raw("(SELECT sum(emp_apf) FROM payroll_details WHERE employee_id= employees.emp_code and `month_yr`!='" . $request['from_month'] . "' and SUBSTRING_INDEX(month_yr, '/', 1)<" . $reportMonth . " and SUBSTRING_INDEX(SUBSTRING_INDEX(month_yr, '/', 2), '/', -1)<=" . $reportYear . " ) as emp_apf_mtd"),
                    DB::raw("(SELECT 0) as opening_data"),
                    DB::raw("(SELECT basic_pay FROM employee_pay_structures WHERE employee_code=employees.emp_code) as basic_pay")
                )
                ->where('payroll_details.month_yr', '=', $request['from_month'])
                ->where('payroll_details.employee_id', '=', $request['emp_code'])
                ->where('payroll_details.emp_pf', '>', '0')
            //->where('employees.emp_code', '=', '7257')
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            $data['from_month'] = $request['from_month'];
            //$data['to_month'] = $request['to_month'];

            //dd($data['employee_ptax']);

            if (count($data['employee_ptax']) != 0) {
                // return view('payroll/gpf-reoprt-employeewise', $data);
                return view('payroll/gpf-report-employeewise', $data);

            } else {
                $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
                $data['employeeslist'] = Employee::get();
                $data['month_yr_from'] = $request->from_month;
                //$data['month_yr_to'] = $request->to_month;
                $data['employee_new'] = $request['emp_code'];

                Session::flash('error', 'Data not found');

                return view('payroll/vw-gpf-employeewise', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function ViewIncometaxAll()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            return view('payroll/vw-imcome-all', $data);
        } else {
            return redirect('/');
        }
    }

    public function ShowReportIncomeAll(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['employee_ptax'] = array();
            $employeeslist = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select('payroll_details.*', 'employees.old_emp_code')
                ->where('payroll_details.emp_i_tax', '>', '0')
                ->whereBetween('payroll_details.month_yr', [$request['from_month'], $request['to_month']])
            //->where('payroll_details.month_yr', '=', $request['from_month'])
                ->groupBy('payroll_details.employee_id')
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            // $employeeslist =Payroll_detail::select('payroll_details.*', DB::raw('(select sum(`payroll_details`.emp_i_tax)) as income_tax') , DB::raw('(select old_emp_code from employees where payroll_details.employee_id = employees.emp_code) as old_emp_code') )
            //     ->whereBetween('payroll_details.month_yr', [$request['from_month'], $request['to_month']])
            //     ->where('payroll_details.emp_i_tax', '>', '0')
            //     ->groupBy('payroll_details.employee_id')
            //    // ->orderBy('payroll_details.emp_prof_tax', 'desc')
            //     ->get();

            // dd($employeeslist);
            $data['company_rs'] = Company::orderBy('id', 'desc')->first();

            foreach ($employeeslist as $employee) {
                $employee_pan_no = Employee::where('emp_code', '=', $employee->employee_id)
                    ->first();

                $employee_payroll = array();
                if ($employee->emp_i_tax > 0) {
                    //$data['employee_ptax'][] =$employee;
                    $employee_payroll = DB::select("SELECT sum(`payroll_details`.emp_i_tax) as income_tax  , `payroll_details`.* FROM `payroll_details` where employee_id='" . $employee->employee_id . "' and month_yr between '" . $request['from_month'] . "' and '" . $request['to_month'] . "'")[0];

                    $data['employee_ptax'][] = array('emp_code' => $employee->employee_id, 'emp_name' => $employee->emp_name, 'emp_designation' => $employee->emp_designation, 'emp_pf_no' => $employee->employee_id, 'employee_payroll' => $employee_payroll, 'emp_pan_no' => $employee_pan_no->emp_pan_no, 'old_emp_code' => $employee_pan_no->old_emp_code, 'emp_income_tax' => $employee_payroll->income_tax);
                }

            }
            // dd($data['employee_ptax']);
            if (count($data['employee_ptax']) != 0) {
                $data['from_month'] = $request['from_month'];
                $data['to_month'] = $request['to_month'];
                //dd($data);
                return view('payroll/income-all-report', $data);
            } else {
                $data['month_from'] = $request['from_month'];
                $data['month_to'] = $request['to_month'];
                $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
                Session::flash('error', 'Data not found');
                return view('payroll/vw-imcome-all', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function ViewIncomEmployeewise()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['employeeslist'] = Employee::get();

            return view('payroll/vw-incometax-employeewise', $data);
        } else {
            return redirect('/');
        }
    }

    public function ShowReportIncomeEmployeewise(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['employee_ptax'] = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select('payroll_details.employee_id', 'payroll_details.emp_name', 'payroll_details.emp_i_tax as emp_income_tax', 'payroll_details.emp_designation', 'employees.emp_pan_no', 'employees.old_emp_code', 'payroll_details.month_yr')
                ->whereBetween('payroll_details.month_yr', [$request['from_month'], $request['to_month']])
                ->where('payroll_details.employee_id', '=', $request['emp_code'])
            //->where('payroll_details.emp_income_tax','>',0) , 'payroll_details.emp_cess'
                ->orderBy('payroll_details.month_yr', 'desc')
                ->get();

            $data['company_rs'] = Company::orderBy('id', 'desc')->first();

            if (count($data['employee_ptax']) != 0) {
                $data['from_month'] = $request['from_month'];
                $data['to_month'] = $request['to_month'];
                return view('payroll/incometax-reoprt-employeewise', $data);

            } else {
                $data['month_from'] = $request['from_month'];
                $data['month_to'] = $request['to_month'];
                Session::flash('error', 'Data not found');
                $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
                $data['employeeslist'] = Employee::get();
                $data['employee_new'] = $request['emp_code'];

                return view('payroll/vw-incometax-employeewise', $data);
            }
            //dd($data);
        } else {
            return redirect('/');
        }
    }

    public function ViewDeptRepoAll()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/vw-department-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showDeptRepoAll(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::leftJoin('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'employees.emp_department',
                    DB::raw('COALESCE(Sum(payroll_details.emp_basic_pay),0) as emp_basic_pay'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_da),0) as emp_da'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_vda),0) as emp_vda'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_hra),0) as emp_hra'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_prof_tax),0) as emp_prof_tax'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_others_alw),0) as emp_others_alw'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_tiff_alw),0) as emp_tiff_alw'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_conv),0) as emp_conv'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_medical),0) as emp_medical'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_misc_alw),0) as emp_misc_alw'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_over_time),0) as emp_over_time'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_bouns),0) as emp_bouns'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_co_op),0) as emp_co_op'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_pf),0) as emp_pf'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_pf_int),0) as emp_pf_int'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_apf),0) as emp_apf'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_i_tax),0) as emp_i_tax'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_insu_prem),0) as emp_insu_prem'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_pf_loan),0) as emp_pf_loan'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_esi),0) as emp_esi'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_adv),0) as emp_adv'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_absent_deduction),0) as emp_absent_deduction'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_hrd),0) as emp_hrd'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_furniture),0) as emp_furniture'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_misc_ded),0) as emp_misc_ded'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_leave_inc),0) as emp_leave_inc'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_hta),0) as emp_hta'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_gross_salary),0) as emp_gross_salary'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_total_deduction),0) as emp_total_deduction'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_net_salary),0) as emp_net_salary')
                )
                ->where('payroll_details.month_yr', '=', $request->month)
                ->groupBy('employees.emp_department')
                ->orderBy('employees.emp_department', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/vw-department-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function printDeptRepoAll(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $data['company_rs'] = Company::orderBy('id', 'desc')->first();

            $employee_rs = Employee::leftJoin('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'employees.emp_department',
                    DB::raw('COALESCE(Sum(payroll_details.emp_basic_pay),0) as emp_basic_pay'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_da),0) as emp_da'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_vda),0) as emp_vda'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_hra),0) as emp_hra'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_prof_tax),0) as emp_prof_tax'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_others_alw),0) as emp_others_alw'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_tiff_alw),0) as emp_tiff_alw'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_conv),0) as emp_conv'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_medical),0) as emp_medical'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_misc_alw),0) as emp_misc_alw'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_over_time),0) as emp_over_time'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_bouns),0) as emp_bouns'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_co_op),0) as emp_co_op'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_pf),0) as emp_pf'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_pf_int),0) as emp_pf_int'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_apf),0) as emp_apf'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_i_tax),0) as emp_i_tax'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_insu_prem),0) as emp_insu_prem'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_pf_loan),0) as emp_pf_loan'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_esi),0) as emp_esi'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_adv),0) as emp_adv'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_absent_deduction),0) as emp_absent_deduction'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_hrd),0) as emp_hrd'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_furniture),0) as emp_furniture'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_misc_ded),0) as emp_misc_ded'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_leave_inc),0) as emp_leave_inc'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_hta),0) as emp_hta'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_gross_salary),0) as emp_gross_salary'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_total_deduction),0) as emp_total_deduction'),
                    DB::raw('COALESCE(Sum(payroll_details.emp_net_salary),0) as emp_net_salary')
                )
                ->where('payroll_details.month_yr', '=', $request->month)
                ->groupBy('employees.emp_department')
                ->orderBy('employees.emp_department', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/prn-department-summary', $data);
        } else {
            return redirect('/');
        }
    }

    public function dept_summary_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportDeptSummary($month_yr), 'DepartmentSummary-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewDeductedCoopRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/vw-deducted-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showDeductedCoopRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'payroll_details.emp_co_op',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('payroll_details.month_yr', '=', $request->month)
                ->where('payroll_details.emp_co_op', '>', 0)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/vw-deducted-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function printDeductedCoopRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'payroll_details.emp_co_op',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('payroll_details.month_yr', '=', $request->month)
                ->where('payroll_details.emp_co_op', '>', 0)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/prn-deducted-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function deducted_coop_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportDeductedCoop($month_yr), 'DeductedCoopReport-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewNonDeductedCoopRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/vw-non-deducted-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showNonDeductedCoopRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $empPayStructure = Employee_pay_structure::where('employee_pay_structures.co_op', '>', 0)->pluck('employee_code');
            //dd($empPayStructure);
            $employee_rs = Employee::join('monthly_employee_cooperatives', 'monthly_employee_cooperatives.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'monthly_employee_cooperatives.coop_amount',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('monthly_employee_cooperatives.month_yr', '=', $request->month)
                ->whereIn('employees.emp_code', $empPayStructure)
                ->where('monthly_employee_cooperatives.coop_amount', '=', 0)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/vw-non-deducted-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function printNonDeductedCoopRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $empPayStructure = Employee_pay_structure::where('employee_pay_structures.co_op', '>', 0)->pluck('employee_code');

            $employee_rs = Employee::join('monthly_employee_cooperatives', 'monthly_employee_cooperatives.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'monthly_employee_cooperatives.coop_amount',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('monthly_employee_cooperatives.month_yr', '=', $request->month)
                ->whereIn('employees.emp_code', $empPayStructure)
                ->where('monthly_employee_cooperatives.coop_amount', '=', 0)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/prn-non-deducted-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function non_deducted_coop_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportNonDeductedCoop($month_yr), 'NonDeductedCoopReport-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewMiscRecoveryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/vw-misc-recovery-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showMiscRecoveryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'payroll_details.emp_co_op',
                    'payroll_details.emp_i_tax',
                    'payroll_details.emp_insu_prem',
                    'payroll_details.emp_hrd',
                    'payroll_details.emp_furniture',
                    'payroll_details.emp_misc_ded',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('payroll_details.month_yr', '=', $request->month)
            // ->whereOr('payroll_details.emp_co_op','>',0)
            // ->whereOr('payroll_details.emp_i_tax','>',0)
            // ->whereOr('payroll_details.emp_insu_prem','>',0)
            // ->whereOr('payroll_details.emp_hrd','>',0)
            // ->whereOr('payroll_details.emp_furniture','>',0)
            // ->whereOr('payroll_details.emp_misc_ded','>',0)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/vw-misc-recovery-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function printMiscRecoveryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'payroll_details.emp_co_op',
                    'payroll_details.emp_i_tax',
                    'payroll_details.emp_insu_prem',
                    'payroll_details.emp_hrd',
                    'payroll_details.emp_furniture',
                    'payroll_details.emp_misc_ded',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('payroll_details.month_yr', '=', $request->month)

                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/prn-misc-recovery-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function misc_recovery_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportMiscRecovery($month_yr), 'MiscRecoveryReport-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewCoopEntryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = MonthlyEmployeeCooperative::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/monthly-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showCoopEntryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = MonthlyEmployeeCooperative::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('monthly_employee_cooperatives', 'monthly_employee_cooperatives.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'monthly_employee_cooperatives.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('monthly_employee_cooperatives.month_yr', '=', $request->month)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/monthly-coop-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function coop_entry_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportCoopEntry($month_yr), 'MonthlyCoopEntry-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewIncometaxEntryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = MonthlyEmployeeItax::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/monthly-incometax-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showIncometaxEntryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = MonthlyEmployeeCooperative::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('monthly_employee_itaxes', 'monthly_employee_itaxes.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'monthly_employee_itaxes.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('monthly_employee_itaxes.month_yr', '=', $request->month)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/monthly-incometax-report', $data);
        } else {
            return redirect('/');
        }
    }
    public function incometax_entry_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportItaxEntry($month_yr), 'MonthlyIncomeTaxEntry-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewOvertimeEntryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = MonthlyEmployeeOvertime::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/monthly-overtime-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showOvertimeEntryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = MonthlyEmployeeOvertime::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('monthly_employee_overtimes', 'monthly_employee_overtimes.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'monthly_employee_overtimes.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('monthly_employee_overtimes.month_yr', '=', $request->month)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/monthly-overtime-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function overtime_entry_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportOvertimeEntry($month_yr), 'MonthlyOvertimeEntry-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewAllowanceEntryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['monthlist'] = MonthlyEmployeeAllowance::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/monthly-allowance-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showAllowanceEntryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['monthlist'] = MonthlyEmployeeAllowance::select('month_yr')->distinct('month_yr')->get();
            $data['req_month'] = $request->month;

            $employee_rs = Employee::join('monthly_employee_allowances', 'monthly_employee_allowances.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'employees.emp_code',
                    'monthly_employee_allowances.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('monthly_employee_allowances.month_yr', '=', $request->month)
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/monthly-allowance-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function allowance_entry_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str = '';
            if ($month_yr != '') {
                $month_yr_str = explode('/', $month_yr);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportAllowanceEntry($month_yr), 'MonthlyAllowanceEntry-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewBonusEntryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['result'] = '';
            return view('payroll/yearly-bonus-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showBonusEntryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['req_year'] = $request->year;

            $employee_rs = Employee::join('yearly_employee_bonuses', 'yearly_employee_bonuses.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'yearly_employee_bonuses.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('yearly_employee_bonuses.year', '=', $request->year)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/yearly-bonus-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function bonus_entry_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $year = '';
            if (isset($request->year)) {
                $year = $request->year;
                $type = isset($request->type) ? $request->type : 'BonusEntry';
                $month_yr_str = explode('/', $request->year);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportBonusEntry($year, $type), ucwords($type) . ' Report-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewEncashEntryRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeLencHta::select('year')->distinct('year')->get();
            $data['result'] = '';
            return view('payroll/yearly-encash-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showEncashEntryRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeLencHta::select('year')->distinct('year')->get();
            $data['req_year'] = $request->year;

            $employee_rs = Employee::join('yearly_employee_lenc_htas', 'yearly_employee_lenc_htas.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'yearly_employee_lenc_htas.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('yearly_employee_lenc_htas.year', '=', $request->year)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/yearly-encash-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function encash_entry_report_xlsexport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $year = '';
            if (isset($request->year)) {
                $year = $request->year;
                $month_yr_str = explode('/', $request->year);
                $month_yr_str = implode('-', $month_yr_str);
            }

            return Excel::download(new ExcelFileExportEncashEntry($year), 'YearlyEncashmentEntry-' . $month_yr_str . '.xlsx');
        } else {
            return redirect('/');
        }
    }

    public function ViewBonusCompleteRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['result'] = '';
            return view('payroll/yearly-complete-bonus-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showBonusCompleteRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['req_year'] = $request->year;

            $employee_rs = Employee::join('yearly_employee_bonuses', 'yearly_employee_bonuses.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'yearly_employee_bonuses.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('yearly_employee_bonuses.year', '=', $request->year)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/yearly-complete-bonus-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function ViewBonusOnlyRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['result'] = '';
            return view('payroll/yearly-only-bonus-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showBonusOnlyRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['req_year'] = $request->year;

            $employee_rs = Employee::join('yearly_employee_bonuses', 'yearly_employee_bonuses.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'yearly_employee_bonuses.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('yearly_employee_bonuses.year', '=', $request->year)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/yearly-only-bonus-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function ViewExgratiaOnlyRepo()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['result'] = '';
            return view('payroll/yearly-only-exgratia-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function showExgratiaOnlyRepo(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            $data['req_year'] = $request->year;

            $employee_rs = Employee::join('yearly_employee_bonuses', 'yearly_employee_bonuses.emp_code', '=', 'employees.emp_code')
                ->select(
                    'employees.old_emp_code',
                    'yearly_employee_bonuses.*',
                    'employees.salutation',
                    'employees.emp_fname',
                    'employees.emp_mname',
                    'employees.emp_lname'
                )
                ->where('yearly_employee_bonuses.year', '=', $request->year)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->get();

            $data['result'] = $employee_rs;

            return view('payroll/yearly-only-exgratia-report', $data);
        } else {
            return redirect('/');
        }
    }

} //end of class
