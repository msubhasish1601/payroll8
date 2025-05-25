<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Employee\Emp_actual_paystructure;
use App\Models\Leave\Leave_allocation;
use App\Models\Masters\Company;
use App\Models\Masters\Group_name_detail;
use App\Models\Masters\Rate_master;
use App\Models\Masters\Role_authorization;
use App\Models\Payroll\Payroll_detail;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Session;
use Validator;
use View;

class EmployeeWisePayslipController extends Controller
{
    //
    public function getEmployeeWisePayslip()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $data['result'] = '';
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['employeeslist'] = Employee::get();
            $Payroll_details_rs = '';
            return view('payroll.employeewise-view-payslip', $data);
        } else {
            return redirect('/');
        }
    }

    public function getEmployeePayCart()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['result'] = '';
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['employeeslist'] = Employee::get();
            $Payroll_details_rs = '';

            return view('payroll.employeewise-paycart', $data);

        } else {
            return redirect('/');
        }
    }

    public function showEmployeePayCart(Request $request)
    {

        //dd($request->all());

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $employeeslist = Employee::get();
            $Payroll_details_rs = $result = '';
            $emp_id = $request->emp_code; //dd($emp_id);
            $month_yr = $request->month_yr;

            // $validator = Validator::make($request->all(), [
            //     'month_yr' => 'required',
            //     [
            //         'month_yr.required' => 'Month Year Required',
            //     ],
            // ]);

            // if ($validator->fails()) {
            //     return redirect('payroll/vw-employeewise-view-payslip')->withErrors($validator)->withInput();
            // }

            $Payroll_details_rs = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->where('payroll_details.month_yr', '=', explode('-', $month_yr)[0])
                ->where('payroll_details.employee_id', '=', $emp_id)
                ->select('payroll_details.*', 'employees.old_emp_code')
                ->get();

            //dd($Payroll_details_rs);

            $month_yr_new = $month_yr;
            $emp_id_new = $emp_id;
            $monthlist = Payroll_detail::select('month_yr')->distinct('month_yr')->get();

            return view('payroll.employeewise-paycart-slip', compact('Payroll_details_rs', 'Roledata', 'month_yr_new', 'emp_id_new', 'monthlist', 'employeeslist'));
        } else {
            return redirect('/');
        }
    }

    public function getEmployeePayCard()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['result'] = '';

            $data['employeeslist'] = Employee::get();
            $Payroll_details_rs = '';

            return view('payroll.employee-paycard', $data);

        } else {
            return redirect('/');
        }
    }

    public function showEmployeePayCard(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            // dd($request->all());

            $data['from_my'] = $from_my = $request->monthyr_from;
            $data['to_my'] = $to_my = $request->monthyr_to;

            $arrFromMy = explode('-', $from_my);
            $arrToMy = explode('-', $to_my);

            $data['from_month'] = $from_month = $arrFromMy[1];
            $data['from_year'] = $from_year = $arrFromMy[0];

            $data['to_month'] = $to_month = $arrToMy[1];
            $data['to_year'] = $to_year = $arrToMy[0];

            $data['emp_code'] = $emp_code = $request->emp_code;

            $data['empInfo'] = $empInfo = Employee::where('emp_code', '=', $emp_code)->first();

            $data['company_rs'] = Company::orderBy('id', 'desc')->first();
            // dd($data);

            return view('payroll.employee-paycard-details', $data);
        } else {
            return redirect('/');
        }
    }

    public function showEmployeeWisePayslip(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');
            $Roledata = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            $employeeslist = Employee::get();
            $Payroll_details_rs = $result = '';
            $emp_id = $request->emp_code; //dd($emp_id);
            $month_yr = $request->month_yr;
            $validator = Validator::make($request->all(), [
                'month_yr' => 'required',
                //        'emp_code' => ['required',
                //        Rule::exists('Payroll_details')->where(function ($query) use($emp_id) {
                //            $query->where('emp_code', $emp_id);
                //        }),
                //        ],
                [
                    'month_yr.required' => 'Month Year Required',
                ],
            ]);

            if ($validator->fails()) {
                return redirect('payroll/vw-employeewise-view-payslip')->withErrors($validator)->withInput();
            }

            if ($emp_id == '') {

                //        $company_rs=Company::where('company_status','=','active')->select('id','company_name')->get();
                //        $Payroll_details_rs=PayrollDetails::where('emp_code','=',$emp_id)->where('company_id','=',$company_id)->select('*')->get()->first();

                $Payroll_details_rs = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->where('payroll_details.month_yr', '=', $month_yr)
                    ->select('payroll_details.*', 'employees.old_emp_code')
                    ->get();
            } else {

                $Payroll_details_rs = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->where('payroll_details.month_yr', '=', $month_yr)
                    ->where('payroll_details.employee_id', '=', $emp_id)
                    ->select('payroll_details.*', 'employees.old_emp_code')
                    ->get();

            }
            if (count($Payroll_details_rs) != 0) {
                foreach ($Payroll_details_rs as $payroll) {

                    $result .= '<tr style="text-align:center;">
							<td>' . $payroll->old_emp_code . '</td>
							<td>' . $payroll->emp_name . '</td>
							<td>' . $payroll->emp_designation . '</td>
							<td>' . $payroll->month_yr . '</td>
							<td>' . $payroll->emp_gross_salary . '</td>
							<td>' . $payroll->emp_total_deduction . '</td>
							<td>' . $payroll->emp_net_salary . '</td>
							<td><a href="' . url('payroll/payslip') . '/' . encrypt($payroll->employee_id) . '/' . encrypt($payroll->id) . '" target="_blank"><i class="ti-eye"></i></a></td>
						</tr>';
                    //dd($result);
                }
            } else {
                Session::flash('error', 'Payslip is not Generated .');
            }

            //dd($result);
            $month_yr_new = $month_yr;
            $emp_id_new = $emp_id;
            $monthlist = Payroll_detail::select('month_yr')->distinct('month_yr')->get();

            return view('payroll/employeewise-view-payslip', compact('result', 'Payroll_details_rs', 'Roledata', 'month_yr_new', 'emp_id_new', 'monthlist', 'employeeslist'));
        } else {
            return redirect('/');
        }
    }

    public function viewPayrollDetails($emp_id, $pay_dtl_id)
    {
        if (!empty(Session::get('admin'))) {

            $emp_id = Crypt::decrypt($emp_id);
            $pay_dtl_id = Crypt::decrypt($pay_dtl_id);

            if ($emp_id) {
                $data['payroll_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                    ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                    ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                    ->where('payroll_details.employee_id', '=', $emp_id)
                    ->where('payroll_details.id', '=', $pay_dtl_id)
                    ->select('payroll_details.*', 'employees.*', 'bank_masters.master_bank_name', 'group_name_details.group_name')
                    ->get();

                $data['leave_hand'] = Leave_allocation::join('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                    ->where('leave_allocations.employee_code', '=', $emp_id)
                    ->where('leave_allocations.leave_allocation_status', '=', 'active')
                    ->select('leave_allocations.*', 'leave_types.leave_type_name')
                    ->get();

                $montharr = explode('/', $data['payroll_rs'][0]->month_yr);
                $calculate_month = $montharr[0] - 2;

                if (strlen($calculate_month) == 1) {
                    $leave_calculate = "0" . $calculate_month;
                } else {
                    $leave_calculate = $calculate_month;
                }

                $caculate_month_for_leave = $leave_calculate . "/" . $montharr[1];

                $data['current_month_days'] = date('t', strtotime($montharr[1] . '-' . $montharr[0] . '-01'));

                $data['actual_payroll'] = Emp_actual_paystructure::where('emp_code', '=', $emp_id)
                    ->first();

                $data['company_rs'] = Company::orderBy('id', 'desc')->first();
                $data['rate_master'] = Rate_master::get();

                //dd($data);

                return view('payroll/vwpayslip', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function getAllPayslips(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //dd($request->month_yr);
            // $emp_id = Crypt::decrypt($emp_id);
            // $pay_dtl_id = Crypt::decrypt($pay_dtl_id);

            $month_yr = $request->month_yr;
            $class_name_new = $request->class_name_new;

            $allEmp = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->where('payroll_details.month_yr', '=', $month_yr)
                ->where(function ($query) use ($class_name_new) {
                    if (isset($class_name_new) && $class_name_new != '') {
                        $query->where('employees.emp_group_name', '=', $class_name_new);
                    }
                })

                ->select('payroll_details.*', 'employees.*', 'bank_masters.master_bank_name')
                ->orderBy('employees.old_emp_code', 'asc')
                ->get();

            $main_data = [];
            foreach ($allEmp as $record) {
                $emp_id = $record->employee_id;
                //dd($emp_id);
                if ($emp_id) {
                    $data['payroll_rs'] = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                        ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                        ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                        ->where('payroll_details.employee_id', '=', $emp_id)
                        ->where('payroll_details.month_yr', '=', $month_yr)
                        ->select('payroll_details.*', 'employees.*', 'bank_masters.master_bank_name', 'group_name_details.group_name')
                        ->get();

                    $data['leave_hand'] = Leave_allocation::join('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                        ->where('leave_allocations.employee_code', '=', $emp_id)
                        ->where('leave_allocations.leave_allocation_status', '=', 'active')
                        ->select('leave_allocations.*', 'leave_types.leave_type_name')
                        ->get();

                    $montharr = explode('/', $data['payroll_rs'][0]->month_yr);
                    $calculate_month = $montharr[0] - 2;

                    if (strlen($calculate_month) == 1) {
                        $leave_calculate = "0" . $calculate_month;
                    } else {
                        $leave_calculate = $calculate_month;
                    }

                    $caculate_month_for_leave = $leave_calculate . "/" . $montharr[1];

                    $data['current_month_days'] = date('t', strtotime($montharr[1] . '-' . $montharr[0] . '-01'));

                    $data['actual_payroll'] = Emp_actual_paystructure::where('emp_code', '=', $emp_id)
                        ->first();

                    $data['company_rs'] = Company::orderBy('id', 'desc')->first();
                    $data['rate_master'] = Rate_master::get();

                    array_push($main_data, $data);

                }
            }
            // dd($main_data[0]);
            return view('payroll/vwallpayslip', ['payslipdata' => $main_data]);
        } else {
            return redirect('/');
        }

    }

    public function getMonthlyPaySlips()
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
            $company_rs = Company::where('company_status', '=', 'active')->select('id', 'company_name')->get();
            $data['class_name'] = Group_name_detail::where('status', '=', 'active')->get();
            //dd($data);
            return view('payroll/pay-slips', $data);
        } else {
            return redirect('/');
        }
    }

    public function showSinglePayslip()
    {
        if (!empty(Session::get('admin'))) {

            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return view('leave/single-view-payslip', $data);
        } else {
            return redirect('/');
        }
    }

    public function singlePayslip(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $month = $request->month_yr;
            $employee_code = Session('admin')->employee_id;

            $data['payroll_rs'] = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->leftJoin('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->where('payroll_details.employee_id', '=', $employee_code)
                ->where('payroll_details.month_yr', '=', $month)
                ->select('payroll_details.*', 'employees.*', 'bank_masters.master_bank_name')
                ->get();

            $data['leave_hand'] = Leave_allocation::leftJoin('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                ->where('leave_allocations.employee_code', '=', $employee_code)
                ->where('leave_allocations.leave_allocation_status', '=', 'active')
                ->select('leave_allocations.*', 'leave_types.leave_type_name')
                ->get();

            if (count($data['payroll_rs']) != 0) {
                $montharr = explode('/', $data['payroll_rs'][0]->month_yr);

                $calculate_month = $montharr[0] - 2;

                if (strlen($calculate_month) == 1) {
                    $leave_calculate = "0" . $calculate_month;
                } else {
                    $leave_calculate = $calculate_month;
                }

                $caculate_month_for_leave = $leave_calculate . "/" . $montharr[1];

                $data['current_month_days'] = date('t', strtotime($montharr[1] . '-' . $montharr[0] . '-01'));

                $data['actual_payroll'] = Emp_actual_paystructure::where('emp_code', '=', $employee_code)
                    ->first();

                $data['company_rs'] = Company::orderBy('id', 'desc')->first();
                $data['rate_master'] = Rate_master::get();

                return view('leave/vwsinglepayslip', $data);
            } else {
                Session::flash('error', 'Payslip is not Generated .');
                return redirect('employee/payslip');
            }
        } else {
            return redirect('/');
        }
    }
}
