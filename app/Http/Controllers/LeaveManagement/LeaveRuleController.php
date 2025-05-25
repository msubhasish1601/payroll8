<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveManagement\Leave_rule;
use App\Models\LeaveManagement\Leave_type;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use View;

class LeaveRuleController extends Controller
{
    public function getLeaveRules()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $data['leave_rule_rs'] = Leave_rule::join('leave_types', 'leave_rules.leave_type_id', '=', 'leave_types.id')

                ->select('leave_rules.*', 'leave_types.leave_type_name')
                ->where('leave_rules.leave_rule_status', '=', 'active')
                ->get();

            return view('leavemanagement/view-leave-rule', $data);
        } else {
            return redirect('/');
        }
    }

    public function leaveRules()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            $data['leave_type_rs'] = Leave_type::where('leave_type_status', '=', 'active')->select('id', 'leave_type_name')->get();
            //$company_rs=Company::where('company_status','=','active')->select('id','company_name')->get();

            return view('leavemanagement/leave-rule', $data);
        } else {
            return redirect('/');
        }
    }

    public function checkEntry($leave_type_id, $effective_from, $effective_to)
    {
        $results = DB::select(DB::raw("SELECT * FROM `leave_rules` WHERE `leave_type_id`='" . $leave_type_id . "' AND (`effective_from` >='" . $effective_from . "' AND `effective_from` <='" . $effective_from . "' OR `effective_to` >='" . $effective_to . "' AND `effective_to` <='" . $effective_to . "')"));
        return $results;
    }

    public function saveAddLeaveRule(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $validator = Validator::make($request->all(), [

                'leave_type_id' => 'required|max:255',
                'max_no' => 'required|max:10',
                'entitled_from_month' => 'required',
                'max_balance_enjoy' => 'required',
                'carry_forward_type' => 'required',
                'effective_from' => 'required',
                'effective_to' => 'required',
            ],
                [
                    'leave_type_id.required' => 'Leave Type Name Required',
                    'max_no.required' => 'Maximum No. Required',
                    'entitled_from_month.required' => 'Entitled From Month Required',
                    'max_balance_enjoy.required' => 'Maximum Balance Enjoy Required',
                    'carry_forward_type.required' => 'Carry Forward Type Required',
                    'effective_from.required' => 'Effective From Required',
                    'effective_to.required' => 'Effective To Required',
                ]);

            if ($validator->fails()) {
                return redirect('leave-management/leave-rule-listing')->withErrors($validator)->withInput();
            }

            //$data=request()->except(['_token']);

            $data = $request->all();
            if (!empty($request->id)) {

                Leave_rule::where('id', $request->id)
                    ->update(['leave_type_id' => $request->leave_type_id,
                        'max_no' => $request->max_no, 'entitled_from_month' => $request->entitled_from_month, 'max_balance_enjoy' => $request->max_balance_enjoy, 'carry_forward_type' => $request->carry_forward_type, 'effective_from' => $request->effective_from, 'effective_to' => $request->effective_to]);
                Session::flash('message', 'Leave Rule Information Successfully Updated.');
            } else {

                $leave_rule = new Leave_rule();
                $check_entry = $this->checkEntry($data['leave_type_id'], $data['effective_from'], $data['effective_to']);

                if (count($check_entry) == 0) {
                    $leave_rule->leave_type_id = $request->leave_type_id;
                    $leave_rule->max_no = $request->max_no;
                    $leave_rule->entitled_from_month = $request->entitled_from_month;
                    $leave_rule->carry_forward_type = $request->max_balance_enjoy;
                    $leave_rule->max_balance_enjoy = $request->max_balance_enjoy;
                    $leave_rule->effective_from = date('Y-m-d', strtotime($request->effective_from));
                    $leave_rule->effective_to = date('Y-m-d', strtotime($request->effective_to));

                    $leave_rule->created_at = date('Y-m-d H:i:s');
                    $leave_rule->updated_at = date('Y-m-d H:i:s');

                    $leave_rule->save();
                    Session::flash('message', 'Leave Rule Information Successfully Saved.');

                } else {
                    Session::flash('erorr', 'Leave Rule Information alredy Exists.');
                    return redirect('leave-management/leave-rule-listing');
                }
            }

            return redirect('leave-management/leave-rule-listing');

        } else {
            return redirect('/');
        }
    }

    public function getLeaveRulesById($leave_rule_id)
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['leave_rule_rs'] = Leave_rule::where('id', $leave_rule_id)->first();

            $data['leave_rule_data'] = Leave_rule::where('id', $leave_rule_id)->first();
            $data['leave_type_rs'] = Leave_type::where('leave_type_status', '=', 'active')->select('id', 'leave_type_name')->get();
            //$company_rs=Company::where('company_status','=','active')->select('id','company_name')->get();

            return view('leavemanagement/leave-rule', $data);
        } else {
            return redirect('/');
        }
    }

}
