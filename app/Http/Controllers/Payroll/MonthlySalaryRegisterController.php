<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Masters\Company;
use App\Models\Masters\Rate_master;
use App\Models\Masters\Role_authorization;
use App\Models\Payroll\Payroll_detail;
use Illuminate\Http\Request;
use Session;
use Validator;
use View;

class MonthlySalaryRegisterController extends Controller
{
    //
    public function getMonthlySalaryRegister()
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
            $payroll_details_rs = '';
            $data['company_rs'] = $company_rs = Company::where('company_status', '=', 'active')->select('id', 'company_name')->get();

            return view('payroll/salary-register', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewMonthlySalarySummary(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make($request->all(), [

                'month' => 'required',
            ],
                [

                    'month.required' => 'Month is Required',
                ]);

            if ($validator->fails()) {
                return redirect('payroll/vw-salary-register')->withErrors($validator)->withInput();

            }

            $month = $request->month;

            $monthly_salary_rs = Payroll_detail::join('employees', 'employees.emp_code', '=', 'payroll_details.employee_id')
                ->where('payroll_details.month_yr', '=', $month)
                ->select('payroll_details.*', 'employees.old_emp_code')
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();
            $month_yr_new = $month;
            //dd($monthly_salary_rs);
            $monthlist = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $rate_master = Rate_master::get();
            $company_rs = Company::orderBy('id', 'desc')->first();

            if (count($monthly_salary_rs) != 0) {
                return view('payroll.view-salary-register', compact('monthly_salary_rs', 'month', 'month_yr_new', 'monthlist', 'rate_master', 'company_rs'));

            } else {
                Session::flash('error', 'No data Found.');
                return redirect('payroll/vw-salary-register');
            }

        } else {
            return redirect('/');
        }
    }

}
