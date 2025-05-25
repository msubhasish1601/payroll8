<?php

namespace App;

namespace App\Http\Controllers\EmployeeCorner;

use App\Http\Controllers\Controller;
use App\Models\Employee\Leave_apply;
use App\Models\Holiday\Holiday;
use App\Models\LeaveApprover\Gpf_loan_apply;
use App\Models\LeaveApprover\Ltc_apply;
use App\Models\LeaveApprover\Tour_apply;
use App\Models\Leave\Leave_allocation;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Session;
use View;

class HomeController extends Controller
{
    public function viewDashboard()
    {
        if (!empty(Session::get('admin'))) {

            $total_withwral_balance = 0;
            $amt = 0;
            $total_interest_amt = 0;
            $empid = Session('admin')->employee_id;
            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-t');

            $data['LeaveAllocation'] = Leave_allocation::leftJoin('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                ->where('leave_allocations.employee_code', '=', $empid)
                ->whereBetween('leave_allocations.created_at', [$first_day_this_year, $last_day_this_year])
            //->whereDate('leave_allocation.created_at','>=',$first_day_this_year)
                ->select('leave_allocations.*', 'leave_types.leave_type_name', 'leave_types.alies')
                ->get();
            // dd($data['LeaveAllocation']);
            $data['leaveApply'] = Leave_apply::leftJoin('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
                ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies')
                ->where('employee_id', '=', $empid)
                ->whereDate('leave_applies.from_date', '>=', $first_day_this_year)
                ->whereDate('leave_applies.to_date', '<=', $last_day_this_year)
                ->get();
            // dd($data['leaveApply']);
            $data['TourApply'] = Tour_apply::where('employee_code', '=', $empid)
                ->whereDate('from_date', '>=', $first_day_this_year)
                ->whereDate('to_date', '<=', $last_day_this_year)
                ->get();
            $data['ltcapply'] = Ltc_apply::where('employee_code', '=', $empid)
                ->whereDate('from_date', '>=', $first_day_this_year)
                ->whereDate('to_date', '<=', $last_day_this_year)
                ->get();

            $data['LoanApply'] = Gpf_loan_apply::where('employee_code', '=', $empid)->get();

            $employee_details = Employee::where('emp_code', '=', $empid)->first();

            $data['pf_status'] = '';

            /*if ($employee_details->emp_pf_type == 'gpf') {
            $data['pf_status'] = Gpf_opening_balance::where('employee_id', '=', $empid)
            ->orderBy('id', 'DESC')
            ->first();
            $month_a = Gpf_details::where('emp_code', '=', $empid)
            ->orderBy('id', 'DESC')
            ->first();
            $month = (isset($month_a->updated_at)) ? date('m', strtotime($month_a->updated_at)) : '';
            if ($month <= '3') {
            $year = date("Y", strtotime("-1 year"));
            $start_financial_year = $year . '-04-01';
            $to_financial_year = date("Y-03-31");
            } else {
            $year = date("Y", strtotime("+1 year"));
            $start_financial_year = date('Y-04-01');
            $to_financial_year = $year . '-03-31';
            }

            $data['emp_gpf'] = Gpf_details::leftJoin('employees', 'gpf_details.emp_code', '=', 'employees.emp_code')
            ->where('gpf_details.emp_code', '=', $empid)
            ->whereDate('gpf_details.updated_at', '>=', $start_financial_year)
            ->whereDate('gpf_details.updated_at', '<=', $to_financial_year)

            ->get();

            foreach ($data['emp_gpf'] as $withdrawl) {

            $dateex = (explode("/", $withdrawl->month_year));

            if ($dateex[0] <= '09' && $dateex[0] != '01') {
            $datemon = '0' . ($dateex[0] - 1) . '/' . $dateex[1];
            } else if ($dateex[0] == '09') {
            $datemon = '0' . ($dateex[0] - 1) . '/' . $dateex[1];
            } else if ($dateex[0] == '10') {
            $datemon = '09/' . $dateex[1];
            } else if ($dateex[0] == '01') {
            $datemon = '12/' . ($dateex[1] - 1);
            } else {
            $datemon = ($dateex[0] - 1) . '/' . $dateex[1];
            }

            $gpf = Gpf_details::where('month_year', '=', $datemon)
            ->where('emp_code', '=', $empid)
            ->first();
            $withdrawl->month_year;

            if (!empty($gpf)) {

            $date = $gpf->created_at;
            } else {
            $date = 0;
            }

            $employee_withdrawl = Gpf_loan_apply::select(Gpf_loan_apply::raw('sum(loan_amount) as apply_amt'), 'updated_at')
            ->where('employee_code', '=', $empid)
            ->Where('loan_status', '=', 'Paid')

            ->whereDate('updated_at', '>=', $date)
            ->whereDate('updated_at', '<=', $withdrawl->created_at)
            ->first();
            if (!empty($employee_withdrawl->apply_amt)) {
            $amt = $employee_withdrawl->apply_amt;
            } else {
            $amt = 0;
            }
            $total_withwral_balance += $amt;
            $total_interest_amt += $withdrawl->interest_amount;
            }

            $total_amt = $month_a->closing_balance + $total_withwral_balance + $total_interest_amt;
            $data['pf_amt'] = $total_amt;
            //print_r( $data['pf_amt']);exit;
            } elseif ($employee_details->emp_pf_type == 'nps') {
            $data['pf_status'] = Nps_details::where('emp_code', '=', $empid)
            ->orderByDesc('month_year')
            ->first();
            $data['pf_amt'] = $data['pf_status']->closing_balance;
            }*/

            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return View('employeecorner/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewHolidayCalendar()
    {
        if (!empty(Session::get('admin'))) {

            $data['holidays'] = Holiday::all();
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            return view('leave/holiday-calendar', $data);
        } else {
            return redirect('/');
        }
    }

}
