<?php

namespace App\Http\Controllers\LeaveApprover;

use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Gpf_loan_apply;
use App\Models\LeaveApprover\Leave_apply;
use App\Models\LeaveApprover\Loan_other;
use App\Models\LeaveApprover\Ltc_apply;
use App\Models\LeaveApprover\Pension;
use App\Models\LeaveApprover\Tour_apply;
use App\Models\LeaveApprover\Tour_dtl;
use App\Models\LeaveManagement\Leave_allocation;
use App\Models\LeaveManagement\Leave_type;
use App\Models\Masters\Role_authorization;
use App\Models\Role\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use View;

class LeaveApproverController extends Controller
{
    public function viewdashboard()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return View('leave-approver/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewLeaveApproved()
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            if (Session('admin')->user_type == 'user') {
                $emp_code = Session('admin')->employee_id;

                $data['LeaveApply'] = Leave_apply::join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
                    ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies')
                    ->whereNotIn('leave_applies.status', ['APPROVED', 'REJECTED', 'CANCEL'])
                    ->where(function ($result) use ($emp_code) {
                        if ($emp_code) {
                            $result->where('leave_applies.emp_reporting_auth', $emp_code)
                                ->orWhere('leave_applies.emp_lv_sanc_auth', $emp_code);
                        }
                    })
                    ->orderBy('leave_applies.date_of_apply', 'DESC')
                    ->get();
                // ->paginate(5);

                //echo $data['LeaveApply']; exit;
                //echo "<pre>"; print_r($data['LeaveApply']); exit;

                // $data['TourApply'] = Tour_apply::join('employees', 'tour_applies.employee_code', '=', 'employees.emp_code')
                //     ->whereNotIn('tour_applies.tour_status', ['APPROVED', 'REJECTED', 'CANCEL'])
                //     ->select('tour_applies.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                //     ->where(function ($result) use ($emp_code) {
                //         if ($emp_code) {
                //             $result->where('tour_applies.emp_reporting_auth', $emp_code)
                //                 ->orWhere('tour_applies.emp_sanctioning_auth', $emp_code);
                //         }
                //     })

                //     ->orderBy('tour_applies.apply_date', 'DESC')
                //     ->paginate(5);

                // $data['ltcapply'] = Ltc_apply::join('employees', 'ltc_applies.employee_code', '=', 'employees.emp_code')
                //     ->whereNotIn('ltc_applies.ltc_status', ['APPROVED', 'REJECTED', 'CANCEL'])
                //     ->select('ltc_applies.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')

                //     ->where(function ($result) use ($emp_code) {
                //         if ($emp_code) {
                //             $result->where('ltc_applies.emp_reporting_auth', $emp_code)
                //                 ->orWhere('ltc_applies.emp_lv_sanc_auth', $emp_code);
                //         }
                //     })

                //     ->orderBy('ltc_applies.apply_date', 'DESC')
                //     ->paginate(5);

                // $data['LoanApply'] = Gpf_loan_apply::join('employees', 'gpf_loan_applies.employee_code', '=', 'employees.emp_code')
                //     ->select('gpf_loan_applies.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                //     ->whereNotIn('gpf_loan_applies.loan_status', ['APPROVED', 'REJECTED', 'CANCEL'])

                //     ->where(function ($result) use ($emp_code) {
                //         if ($emp_code) {
                //             $result->where('gpf_loan_applies.emp_reporting_auth', $emp_code)
                //                 ->orWhere('gpf_loan_applies.emp_sanctioning_auth', $emp_code);
                //         }
                //     })
                //     ->orderBy('gpf_loan_applies.apply_date', 'DESC')
                //     ->paginate(5);

                // $data['LoanotherApply'] = Loan_other::join('employees', 'loan_others.employee_code', '=', 'employees.emp_code')
                //     ->select('loan_others.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                //     ->whereNotIn('loan_others.loan_status', ['APPROVED', 'REJECTED', 'CANCEL'])
                //     ->where(function ($result) use ($emp_code) {
                //         if ($emp_code) {
                //             $result->where('loan_others.emp_reporting_auth', $emp_code)
                //                 ->orWhere('loan_others.emp_sanctioning_auth', $emp_code);
                //         }
                //     })

                //     ->orderBy('loan_others.apply_date', 'DESC')
                //     ->paginate(5);
                // $data['PensionApply'] = Pension::join('employees', 'pensions.emp_code', '=', 'employees.emp_code')
                //     ->select('pensions.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                //     ->whereNotIn('pensions.status', ['APPROVED', 'REJECTED', 'CANCEL'])
                //     ->where(function ($result) use ($emp_code) {
                //         if ($emp_code) {
                //             $result->where('pensions.emp_reporting_auth', $emp_code)
                //                 ->orWhere('pensions.emp_lv_sanc_auth', $emp_code);
                //         }
                //     })

                //     ->orderBy('pensions.id', 'DESC')
                //     ->paginate(5);

            } else {

                $data['LeaveApply'] = Leave_apply::join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
                    ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies')

                    ->orderBy('leave_applies.date_of_apply', 'DESC')
                    ->get();
                // ->paginate(5);

                // $data['TourApply'] = Tour_apply::join('employees', 'tour_applies.employee_code', '=', 'employees.emp_code')

                //     ->select('tour_applies.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')

                //     ->orderBy('tour_applies.apply_date', 'DESC')
                //     ->paginate(5);

                // $data['LoanApply'] = Gpf_loan_apply::join('employees', 'gpf_loan_applies.employee_code', '=', 'employees.emp_code')
                //     ->select('gpf_loan_applies.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')

                //     ->orderBy('gpf_loan_applies.apply_date', 'DESC')
                //     ->paginate(5);

                // $data['ltcapply'] = Ltc_apply::join('employees', 'ltc_applies.employee_code', '=', 'employees.emp_code')

                //     ->select('ltc_applies.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')

                //     ->orderBy('ltc_applies.apply_date', 'DESC')
                //     ->paginate(5);

                // $data['LoanotherApply'] = Loan_other::join('employees', 'loan_others.employee_code', '=', 'employees.emp_code')
                //     ->select('loan_others.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')

                //     ->orderBy('loan_others.apply_date', 'DESC')
                //     ->paginate(5);
                // $data['PensionApply'] = Pension::join('employees', 'pensions.emp_code', '=', 'employees.emp_code')
                //     ->select('pensions.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')

                //     ->orderBy('pensions.id', 'DESC')
                //     ->paginate(5);
            }

            // dd($data['LeaveApply']);
            //$data['LeaveApply']=DB::table('leave_apply')->get();

            return view('leave-approver/leave-approved', $data);
        } else {
            return redirect('/');
        }
    }

    public function ViewLeavePermission()
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $id = base64_decode(request()->get('id'));
            // dd($id);
            $data['LeaveApply'] = Leave_apply::join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
            //->join('leave_allocation','leave_apply.leave_type','=','leave_type.id')
                ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies')
                ->where('leave_applies.id', '=', $id)
                ->get();

            // dd($data['LeaveApply']);

            $lv_aply = Leave_apply::where('id', '=', $id)
                ->pluck('employee_id');
            $lv_type = Leave_apply::where('id', '=', $id) // dd($lv_aply);
                ->first();
            $data['Prev_leave'] = Leave_apply::join('leave_types', 'leave_applies.leave_type', '=', 'leave_types.id')
            //->join('leave_allocation','leave_apply.leave_type','=','leave_type.id')
                ->select('leave_applies.*', 'leave_types.leave_type_name', 'leave_types.alies')
                ->where('leave_applies.leave_type', '=', $lv_type->leave_type)
                ->where('leave_applies.employee_id', '=', $lv_aply)
                ->where('leave_applies.status', '=', 'APPROVED')
                ->orderBy('leave_applies.created_at', 'desc')
                ->take(4)
                ->get();
            $from = date('Y-01-01');
            $to = date('Y-12-31');
            $data['totleave'] = Leave_apply::where('status', '=', 'APPROVED')
                ->select(DB::raw('SUM(no_of_leave) AS no_of_leave'))

                ->where('leave_type', '=', $lv_type->leave_type)
                ->where('employee_id', '=', $lv_type->employee_id)

                ->whereBetween('updated_at', [$from, $to])
                ->orderBy('created_at', 'desc')
                ->first();
            // dd($data['Prev_leave']);

            return view('leave-approver/leave-approved-right', $data);

        } else {
            return redirect('/');
        }
    }

    public function SaveLeavePermission(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            // dd($request->all());

            $Allocation = Leave_allocation::where('employee_code', '=', $request->employee_id)
                ->where('leave_type_id', '=', $request->leave_type)
                ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                ->get();

            // dd(($request->no_of_leave) / 2);

            // if ($request->leave_type != 5) {

            //     $Allocation = Leave_allocation::where('employee_code', '=', $request->employee_id)
            //         ->where('leave_type_id', '=', $request->leave_type)
            //         ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
            //         ->get();
            // } else {

            //     $Allocation = Leave_allocation::where('employee_code', '=', $request->employee_id)
            //         ->where('leave_type_id', '=', '3')
            //         ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
            //         ->get();
            // }

            $inhand = $Allocation[0]->leave_in_hand;

            $lv_sanc_auth = Employee::where('emp_code', '=', $request->employee_id)
                ->first();

            $lv_sanc_auth_name = $lv_sanc_auth->emp_lv_sanc_auth;

            if ($request->leave_check == 'APPROVED') {

                if ($request->leave_type == '1' && $request->half_cl == 'half') {
                    $no_of_leave = ($request->no_of_leave) / 2;
                    $lv_inhand = $inhand - $no_of_leave;

                    // dd($lv_inhand);
                } else {
                    $lv_inhand = $inhand - ($request->no_of_leave);
                }

                // dd($lv_inhand);
                if ($lv_inhand < 0) {

                    Session::flash('error', 'Insufficient Leave Balance!');
                    return redirect('leave-approver/leave-approved');

                } else {

                    Leave_apply::where('id', $request->apply_id)
                        ->where('employee_id', $request->employee_id)
                        ->update(['status' => $request->leave_check]);

                    Leave_allocation::where('leave_type_id', '=', $request->leave_type)
                        ->where('employee_code', '=', $request->employee_id)
                        ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                        ->update(['leave_in_hand' => $lv_inhand]);

                    // if ($request->leave_type != 5) {
                    //     Leave_allocation::where('leave_type_id', '=', $request->leave_type)
                    //         ->where('employee_code', '=', $request->employee_id)
                    //         ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    //         ->update(['leave_in_hand' => $lv_inhand]);
                    // } else {
                    //     Leave_allocation::where('leave_type_id', '=', '3')
                    //         ->where('employee_code', '=', $request->employee_id)
                    //         ->where('month_yr', 'like', '%' . $request['month_yr'] . '%')
                    //         ->update(['leave_in_hand' => $lv_inhand]);
                    // }

                    Session::flash('message', 'Leave APPROVED Successfully!');
                    return redirect('leave-approver/leave-approved');
                }

            } else if ($request->leave_check == 'REJECTED') {
                Leave_apply::where('id', $request->apply_id)
                    ->where('employee_id', $request->employee_id)
                    ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);
                Session::flash('message', 'Leave Rejected Successfully!');
                return redirect('leave-approver/leave-approved');

            } else if ($request->leave_check == 'RECOMMENDED') {

                $lv_inhand = $inhand - $request->no_of_leave;
                // dd($lv_inhand);
                if ($lv_inhand < 0) {

                    Session::flash('error', 'Insufficient Leave Balance!');
                    return redirect('leave-approver/leave-approved');

                } else {

                    $emp_code = Session('admin')->employee_id;

                    $sanc_auth = Employee::where('emp_code', $request->employee_id)->first();

                    $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;
                    // dd($report_auth_name);
                    // $sanc_auth = Employee::where('emp_code', $report_auth_name)->first();

                    // $sanc_auth_name = $sanc_auth->emp_reporting_auth;

                    Leave_apply::where('id', $request->apply_id)
                        ->where('employee_id', $request->employee_id)
                        ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks, 'emp_lv_sanc_auth' => $lv_sanc_auth_name]);

                    Session::flash('message', 'Leave Recommended Successfully!');
                    return redirect('leave-approver/leave-approved');
                }

            } else {

                $current_status = Leave_apply::where('id', $request->apply_id)->first();

                if ($current_status->status == 'APPROVED' && $request->leave_check == 'CANCEL') {

                    $lv_inhand = $inhand + $request->no_of_leave;
                    Leave_apply::where('id', $request->apply_id)
                        ->where('employee_id', $request->employee_id)
                        ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);

                    Leave_allocation::where('leave_type_id', $request->leave_type)
                        ->where('employee_code', $request->employee_id)
                        ->update(['leave_in_hand' => $lv_inhand]);

                    // if ($request->leave_type != 5) {
                    //     Leave_allocation::where('leave_type_id', $request->leave_type)
                    //         ->where('employee_code', $request->employee_id)
                    //         ->update(['leave_in_hand' => $lv_inhand]);
                    // } else {
                    //     Leave_allocation::where('leave_type_id', '3')
                    //         ->where('employee_code', $request->employee_id)
                    //         ->update(['leave_in_hand' => $lv_inhand]);
                    // }

                } else {
                    Leave_apply::where('id', $request->apply_id)
                        ->where('employee_id', $request->employee_id)
                        ->update(['status' => $request->leave_check, 'status_remarks' => $request->status_remarks]);
                }

                Session::flash('error', 'Leave Cancel Successfully!');
                return redirect('leave-approver/leave-approved');

            }

        } else {
            return redirect('/');
        }
    }

    public function SaveLeaveApproved(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $check = $request->leave_confirm;
            if ($check == 'Approved') {

                $i = 0;
//                if($request->leave_id)
                //        {
                $checkbox = $request->leave_id;
//
                //  dd($request->leave_type);
                for ($i = 0; $i < count($checkbox); $i++) {

                    $id = $checkbox[$i];
                    Leave_apply::where('id', $id)
                        ->update(['status' => 'APPROVED']);

                    $Allocation = Leave_allocation::where('employee_code', '=', $request->employee_id[$i])
                        ->where('leave_type_id', '=', $request->leave_type[$i])
                        ->get();
                    //dd($Allocation[0]->leave_in_hand);

                }

//            foreach($request->leave_id as $leaveid)
                //            {
                //
                //
                //
                //
                //                            //dd($request->leave_id[$i]);
                //                           $Allocation=Leave_allocation::where('employee_code','=',$employee)
                //                                       ->where('leave_type_id','=',$request->leave_type[$i])
                //                                    ->get();
                //  $Allocation[0]->leave_in_hand;

////                           //dd();
                //                            $request->no_of_leave[$i];
                //             Leave_apply::where('employee_id', $request->employee_code[$i])
                //              ->where('id', $request->leave_id[$i])
                //            ->update(['status' => 'APPROVED']);
                //
                //
                //                           $i++;
                //                        }
                //dd($request->leave_type[$i]);
                //  }

            } else if ($check == 'Rejected') {

            }
            if ($request->employee_code) {
                foreach ($request->employee_code as $employee) {

//                $data['leave_type_id']=$request->leave_type_id;
                    //                $data['leave_rule_id']=$request->leave_rule_id[$i];
                    //                $data['employee_code']=$request->employee_code[$i];
                    //                $data['max_no']=$request->max_no[$i];
                    //                $data['opening_bal']=$request->opening_bal[$i];
                    //                $data['leave_in_hand']=$request->leave_in_hand[$i];
                    //                $data['month_yr']=$request->month_yr[$i];
                    //
                    //                $leave_allocation->create($data);
                    //                $i++;
                }
            }

        } else {
            return redirect('/');
        }

    }

    public function ViewTourPermission()
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $id = base64_decode(request()->get('id'));
            $data['TourApply'] = Tour_apply::where('id', '=', $id)
                ->get();

            $data['tour_dtl'] = Tour_dtl::where('tour_apply_id', '=', $id)->get();
            // dd($data);
            //$data['leave_apply']=Leave_apply::where('id', $id)->get();
            return view('leave-approver/tour-approved-right', $data);

        } else {
            return redirect('/');
        }

    }

    public function SaveTourPermission(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $request->leave_check;

            $request->employee_id;
            if ($request->leave_check == 'APPROVED') {
                Tour_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['tour_status' => 'APPROVED']);
                Session::flash('message', 'Tour Approved Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'RECOMMENDED') {

                $emp_code = Session('admin')->employee_id;

                $sanc_auth = Employee::where('emp_code', $request->employee_id)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                Tour_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['tour_status' => 'RECOMMENDED', 'emp_sanctioning_auth' => $sanc_auth_name]);
                Session::flash('message', 'Tour Recommended Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'REJECTED') {
                Tour_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['tour_status' => 'REJECTED']);
                Session::flash('message', 'Tour Rejected Successfully!');
                return redirect('leave-approver/leave-approved');
            }

        } else {
            return redirect('/');
        }

    }

    public function ViewLtcPermission()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $id = base64_decode(request()->get('id'));
            $empid = base64_decode(request()->get('empid'));
            $data['ltcapply'] = Ltc_apply::where('employee_code', '=', $empid)
                ->where('id', $id)
                ->get();
            // dd($data);
            //$data['leave_apply']=Leave_apply::where('id', $id)->get();
            return view('leave-approver/ltc-approved', $data);
        } else {
            return redirect('/');
        }
    }

    public function SaveLtcPermission(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            if ($request->leave_check == 'APPROVED') {

                Ltc_apply::where('id', $request->apply_id)
                    ->update(['ltc_status' => 'APPROVED']);
                Session::flash('message', 'Ltc Approved Successfully!');
                return redirect('leave-approver/leave-approved');

            } else if ($request->leave_check == 'RECOMMENDED') {

                $emp_code = Session('admin')->employee_id;
                $sanc_auth = Employee::where('emp_code', $request->employee_id)->first();
                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                Ltc_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['ltc_status' => 'RECOMMENDED', 'emp_sanctioning_auth' => $sanc_auth_name]);
                Session::flash('message', 'Ltc Recommended Successfully!');
                return redirect('leave-approver/leave-approved');

            } else if ($request->leave_check == 'REJECTED') {

                Ltc_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['ltc_status' => 'REJECTED']);
                Session::flash('message', 'Ltc Rejected Successfully!');
                return redirect('leave-approver/leave-approved');
            }
        } else {
            return redirect('/');
        }
    }

    public function ViewLoanPermission()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $id = base64_decode(request()->get('id'));
            $empid = base64_decode(request()->get('empid'));
            $data['LoanApply'] = Gpf_loan_apply::where('employee_code', '=', $empid)
                ->where('id', $id)
                ->get();
            // dd($data);
            //$data['leave_apply']=Leave_apply::where('id', $id)->get();
            return view('leave-approver/loan-approved-right', $data);
        } else {
            return redirect('/');
        }

    }

    public function SaveLoanPermission(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $request->leave_check;

            $request->employee_id;
            if ($request->leave_check == 'APPROVED') {
                Gpf_loan_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['loan_status' => 'APPROVED']);
                Session::flash('message', 'Loan Approved Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'RECOMMENDED') {

                $emp_code = Session('admin')->employee_id;

                $sanc_auth = Employee::where('emp_code', $request->employee_id)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                Gpf_loan_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['loan_status' => 'RECOMMENDED', 'emp_sanctioning_auth' => $sanc_auth_name]);
                Session::flash('message', 'Loan Recommended Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'REJECTED') {
                Gpf_loan_apply::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['loan_status' => 'REJECTED']);
                Session::flash('message', 'Loan Rejected Successfully!');
                return redirect('leave-approver/leave-approved');
            }
        } else {
            return redirect('/');
        }

    }

    public function ViewpensionPermission()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $id = base64_decode(request()->get('id'));
            $empid = base64_decode(request()->get('empid'));
            $data['PensionApply'] = Pension::where('id', '=', $id)
                ->first();

            return view('leave-approver/pension-approved-right', $data);
        } else {
            return redirect('/');
        }

    }

    public function SavepensionPermission(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $request->leave_check;

            $request->employee_id;
            if ($request->leave_check == 'APPROVED') {
                Pension::where('emp_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['status' => 'APPROVED']);
                Session::flash('message', 'Pension Approved Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'RECOMMENDED') {

                $sanc_auth = Employee::where('emp_code', $request->employee_id)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                Pension::where('emp_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['status' => 'RECOMMENDED', 'emp_lv_sanc_auth' => $sanc_auth_name]);
                Session::flash('message', 'Pension Recommended Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'REJECTED') {
                Pension::where('emp_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['status' => 'REJECTED']);
                Session::flash('message', 'Pension Rejected Successfully!');
                return redirect('leave-approver/leave-approved');
            }
        } else {
            return redirect('/');
        }
    }

    public function Viewloanother()
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $id = base64_decode(request()->get('id'));
            $empid = base64_decode(request()->get('empid'));

            $data['loanotherApply'] = Loan_other::join('employees', 'loan_others.employee_code', '=', 'employees.emp_code')
                ->select('loan_others.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                ->where('loan_others.id', '=', $id)
                ->first();

            //$data['leave_apply']=Leave_apply::where('id', $id)->get();
            return view('leave-approver/loanother-approved-right', $data);

        } else {
            return redirect('/');
        }

    }

    public function Saveloanother(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $request->leave_check;

            $request->employee_id;
            if ($request->leave_check == 'APPROVED') {
                Loan_other::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['loan_status' => 'APPROVED']);
                Session::flash('message', 'loan Approved Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'RECOMMENDED') {

                $sanc_auth = Employee::where('emp_code', $request->employee_id)->first();

                $sanc_auth_name = $sanc_auth->emp_lv_sanc_auth;

                Loan_other::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['loan_status' => 'RECOMMENDED', 'emp_sanctioning_auth' => $sanc_auth_name]);
                Session::flash('message', 'loan Recommended Successfully!');
                return redirect('leave-approver/leave-approved');
            } else if ($request->leave_check == 'REJECTED') {
                Loan_other::where('employee_code', $request->employee_id)
                    ->where('id', $request->apply_id)
                    ->update(['loan_status' => 'REJECTED']);
                Session::flash('message', 'loan Rejected Successfully!');
                return redirect('leave-approver/leave-approved');
            }
        } else {
            return redirect('/');
        }

    }
}
