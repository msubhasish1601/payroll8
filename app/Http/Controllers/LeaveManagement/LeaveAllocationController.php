<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveManagement\Leave_allocation;
use App\Models\LeaveManagement\Leave_rule;
use App\Models\LeaveManagement\Leave_type;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeaveAllocationController extends Controller
{
    /**
     * Fetch role authorization data for the current admin.
     */
    private function getRoleAuthorization()
    {
        return Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
            ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
            ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
            ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
            ->where('member_id', session('adminusernmae'))
            ->get();
    }

    /**
     * Display the leave allocation listing.
     */
    public function getLeaveAllocation()
    {
        if (session('admin')) {
            $data['Roledata'] = $this->getRoleAuthorization();

            // Enable query logging for debugging
            DB::enableQueryLog();

            $data['leave_allocation'] = Leave_allocation::join('leave_types', 'leave_allocations.leave_type_id', '=', 'leave_types.id')
                ->join('employees', 'leave_allocations.employee_code', '=', 'employees.emp_code')
                ->select('leave_allocations.*', 'leave_types.leave_type_name', 'employees.*')
                ->whereYear('leave_allocations.created_at', date('Y'))
                ->orderBy('leave_allocations.id', 'desc')
                ->get();

            // Log query for debugging
            Log::debug('Leave Allocation Query: ', DB::getQueryLog());

            return view('leavemanagement.view-leave-allocation', $data);
        }

        return redirect('/');
    }

    /**
     * Display the form to add a new leave allocation.
     */
    public function viewAddLeaveAllocation()
    {
        if (session('admin')) {
            $data['Roledata'] = $this->getRoleAuthorization();
            $data['result'] = '';
            $data['employee_codes'] = [];

            // Enable query logging
            DB::enableQueryLog();

            $data['employees'] = Employee::where('status', 'active')
                ->whereNotIn('emp_status', ['TEMPORARY', 'EX-EMPLOYEE'])
                ->orderBy('old_emp_code', 'asc')
                ->get();

            // Log query for debugging
            Log::debug('Employees Query: ', DB::getQueryLog());

            return view('leavemanagement.add-new-leave-allocation', $data);
        }

        return redirect('/');
    }

    /**
     * Fetch leave allocation data for the selected employees.
     */
    public function getAddLeaveAllocation(Request $request)
    {
        if (session('admin')) {
            $Roledata = $this->getRoleAuthorization();
            $current_year = date('Y');
            $previous_year = $current_year - 1;
            $employee_codes = $request->employee_codes ?? [];

            // Enable query logging
            DB::enableQueryLog();

            $leave_allocations = Leave_rule::leftJoin('leave_types', 'leave_rules.leave_type_id', '=', 'leave_types.id')
                ->select('leave_rules.*', 'leave_types.leave_type_name')
                ->where('leave_rules.effective_from', '>=', "$current_year-01-01")
                ->where('leave_rules.effective_to', '<=', "$current_year-12-31")
                ->get();

            // Log query for debugging
            Log::debug('Leave Rules Query: ', DB::getQueryLog());

            $result = '';
            foreach ($employee_codes as $i => $emp_code) {
                $employee = Employee::where('emp_code', $emp_code)->first();
                if ($employee) {
                    foreach ($leave_allocations as $leave_allocation) {
                        $leave_allocate = Leave_allocation::where('employee_code', $emp_code)
                            ->where('leave_rule_id', $leave_allocation->id)
                            ->where('month_yr', 'like', "%$current_year")
                            ->first();

                        $total_leave_count = 0;
                        if ($leave_allocation->carry_forward_type == 'yes') {
                            $leave_balance = Leave_allocation::where('employee_code', $emp_code)
                                ->where('leave_type_id', $leave_allocation->leave_type_id)
                                ->whereYear('created_at', $previous_year)
                                ->first();
                            $total_leave_count = $leave_balance->leave_in_hand ?? 0;
                        }

                        $leave_in_hand = $total_leave_count + $leave_allocation->max_no;

                        if (!$leave_allocate) {
                            $result .= "<tr>
                                <input type='hidden' value='{$leave_allocation->leave_type_id}' class='form-control' name='leave_type_id[]' id='leave_type_id{$i}' readonly>
                                <input type='hidden' value='{$employee->emp_code}' class='form-control' name='employee_code[]' id='employee_code{$i}' readonly>
                                <td><div class='checkbox'><label><input type='checkbox' name='leave_rule_id[]' value='{$leave_allocation->id}' id='leave_rule_id{$i}'></label></div></td>
                                <td>{$employee->emp_code}</td>
                                <td>{$employee->emp_fname} {$employee->emp_mname} {$employee->emp_lname}</td>
                                <td>{$leave_allocation->leave_type_name}</td>
                                <td><input type='text' value='{$leave_allocation->max_no}' name='max_no[]' class='form-control' id='max_no{$i}' readonly></td>
                                <td><input type='text' id='opening_bal{$i}' name='opening_bal[]' value='{$total_leave_count}' class='form-control' readonly></td>
                                <td><input type='text' id='leave_in_hand{$i}' value='{$leave_in_hand}' name='leave_in_hand[]' class='form-control'></td>
                                <td><input type='text' id='month_yr{$i}' value='" . date('m/Y') . "' name='month_yr[]' class='form-control' readonly></td>
                            </tr>";
                        }
                    }
                }
            }

            $employees = Employee::where('status', 'active')
                ->whereNotIn('emp_status', ['TEMPORARY', 'EX-EMPLOYEE'])
                ->orderBy('old_emp_code', 'asc')
                ->get();

            return view('leavemanagement.add-new-leave-allocation', compact('result', 'Roledata', 'employees', 'employee_codes'));
        }

        return redirect('/');
    }

    /**
     * Fetch leave allocation for a specific employee and rule in the current year.
     */
    public function getLeaveAllocationByYear($leave_rule_id, $employee_code)
    {
        return Leave_allocation::where('employee_code', $employee_code)
            ->where('leave_rule_id', $leave_rule_id)
            ->whereYear('created_at', date('Y'))
            ->first();
    }

    /**
     * Save the new leave allocation.
     */
    public function saveAddLeaveAllocation(Request $request)
    {
        if (session('admin')) {
            $data['Roledata'] = $this->getRoleAuthorization();
            $allocation_list = $request->all();

            if (!empty($allocation_list['leave_rule_id'])) {
                foreach ($allocation_list['leave_rule_id'] as $allocation_value) {
                    if (!empty($allocation_list['employee_code'])) {
                        foreach ($allocation_list['employee_code'] as $key => $employee_code) {
                            $leave_allocation = new Leave_allocation;
                            $leave_allocation->leave_type_id = $allocation_list['leave_type_id'][$key];
                            $leave_allocation->leave_rule_id = $allocation_value;
                            $leave_allocation->max_no = $allocation_list['max_no'][$key];
                            $leave_allocation->opening_bal = $allocation_list['opening_bal'][$key];
                            $leave_allocation->leave_in_hand = $allocation_list['leave_in_hand'][$key];
                            $leave_allocation->month_yr = $allocation_list['month_yr'][$key];
                            $leave_allocation->employee_code = $employee_code;
                            $leave_allocation->leave_allocation_status = 'active';

                            // Check for existing allocation
                            $leave_month = $this->getLeaveAllocationByYear($allocation_value, $employee_code);
                            if (!$leave_month) {
                                $leave_allocation->save();
                            }
                        }
                    }
                }
                Session::flash('message', 'Leave Allocation Information Successfully Saved.');
            } else {
                Session::flash('error', 'No data selected.');
            }

            return redirect('leave-management/leave-allocation-listing');
        }

        return redirect('/');
    }

    /**
     * Display the form to edit a leave allocation.
     */
    public function getLeaveAllocationById($leave_allocation_id)
    {
        if (session('admin')) {
            $data['Roledata'] = $this->getRoleAuthorization();

            // Enable query logging
            DB::enableQueryLog();

            $data['leave_allocation'] = Leave_allocation::findOrFail($leave_allocation_id);
            $data['leave_type'] = Leave_type::findOrFail($data['leave_allocation']->leave_type_id);

            // Log query for debugging
            Log::debug('Leave Allocation by ID Query: ', DB::getQueryLog());

            return view('leavemanagement.edit-leave-allocation', $data);
        }

        return redirect('/');
    }

    /**
     * Update an existing leave allocation.
     */
    public function editLeaveAllocation(Request $request)
    {
        if (session('admin')) {
            $Roledata = $this->getRoleAuthorization();

            Leave_allocation::where('id', $request->id)
                ->update([
                    'leave_in_hand' => $request->leave_in_hand,
                    'month_yr' => $request->month_yr,
                    'updated_at' => now(),
                ]);

            Session::flash('message', 'Leave Allocation Information Successfully Updated.');
            return redirect('leave-management/leave-allocation-listing');
        }

        return redirect('/');
    }
}