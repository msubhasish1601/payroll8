<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Pay_head_link_master;
use App\Models\Masters\Pay_head_master;
use App\Models\Masters\Pay_type;
use App\Models\Role\Employee;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class EmpPayHeadLinkController extends Controller
{

    public function getEmpPayHeadLink()
    {
        if (!empty(Session::get('admin'))) {

            $emp_pay_head_link = Pay_head_link_master::leftJoin('employees', 'employees.id', '=', 'pay_head_link_masters.emp_name')
                ->select('pay_head_link_masters.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                ->where('employees.status', '=', 'active')
                ->get();
            return view('masters/emp-pay-head-link', compact('emp_pay_head_link'));
        } else {
            return redirect('/');
        }
    }

    public function addEmpPayHeadLink()
    {
        if (!empty(Session::get('admin'))) {

            $employee = Employee::where('status', '=', 'active')->get();
            return view('masters/add-emp-pay-head-link', compact('employee'));
        } else {
            return redirect('/');
        }
    }

    public function saveEmpPayHeadLink(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pay_deduct_id' => 'required',
                    'emp_name' => 'required',
                    'pay_deduct_head' => 'required',
                    'pay_value' => 'required',
                    'pay_type' => 'required',
                    'value_type' => 'required',
                    'min_limit' => 'required',
                    'max_limit' => 'required',
                    'deduct_order' => 'required'

                ],
                [
                    'pay_deduct_id.required' => 'Pay Deduction ID Required',
                    'emp_name.required' => 'Employee Name Required',
                    'pay_deduct_head.required' => 'Pay Deduction Head Required',
                    'pay_value.required' => 'Pay Value Required',
                    'pay_type.required' => 'Pay Type Required',
                    'value_type.required' => 'Value Type Required',
                    'min_limit.required' => 'Minimum Limit Required',
                    'max_limit.required' => 'Maximum Limit Required',
                    'deduct_order.required' => 'Deduction Order Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-emp-pay-head-link')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_deduct_id' => $request->input('pay_deduct_id'),
                'emp_name' => $request->input('emp_name'),
                'pay_deduct_head' => $request->input('pay_deduct_head'),
                'pay_value' => $request->input('pay_value'),
                'pay_type' => $request->input('pay_type'),
                'value_type' => $request->input('value_type'),
                'min_limit' => $request->input('min_limit'),
                'max_limit' => $request->input('max_limit'),
                'deduct_order' => $request->input('deduct_order')
            );

            // print_r($data);
            // die();
            $emp_pay_head_link = new Pay_head_link_master();

            $emp_pay_head_link->create($data);
            Session::flash('message', 'Employee Pay Head Link Information Successfully Saved.');

            return redirect('masters/emp-pay-head-link');
        } else {
            return redirect('/');
        }
    }
     
    public function editEmpPayHeadLink($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['pay_head_link'] = Pay_head_link_master::leftJoin('employees', 'employees.id', '=', 'pay_head_link_masters.emp_name')
                ->where('pay_head_link_masters.id', '=', $id)
                ->where('employees.status', '=', 'active')
                ->select('pay_head_link_masters.*', 'employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname')
                ->first();

            $data['employee'] = Employee::where('status', '=', 'active')->get();
            return view('masters/edit-emp-pay-head-link', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateEmpPayHeadLink(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pay_deduct_id' => 'required',
                    'emp_name' => 'required',
                    'pay_deduct_head' => 'required',
                    'pay_value' => 'required',
                    'pay_type' => 'required',
                    'value_type' => 'required',
                    'min_limit' => 'required',
                    'max_limit' => 'required',
                    'deduct_order' => 'required'

                ],
                [
                    'pay_deduct_id.required' => 'Pay Deduction ID Required',
                    'emp_name.required' => 'Employee Name Required',
                    'pay_deduct_head.required' => 'Pay Deduction Head Required',
                    'pay_value.required' => 'Pay Value Required',
                    'pay_type.required' => 'Pay Type Required',
                    'value_type.required' => 'Value Type Required',
                    'min_limit.required' => 'Minimum Limit Required',
                    'max_limit.required' => 'Maximum Limit Required',
                    'deduct_order.required' => 'Deduction Order Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-emp-pay-head-link')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_deduct_id' => $request->input('pay_deduct_id'),
                'emp_name' => $request->input('emp_name'),
                'pay_deduct_head' => $request->input('pay_deduct_head'),
                'pay_value' => $request->input('pay_value'),
                'pay_type' => $request->input('pay_type'),
                'value_type' => $request->input('value_type'),
                'min_limit' => $request->input('min_limit'),
                'max_limit' => $request->input('max_limit'),
                'deduct_order' => $request->input('deduct_order')
            );

            Pay_head_link_master::where('id', $request['id'])->update($data);
            Session::flash('message', 'Employee Pay Head Link Information Successfully Updated.');
            return redirect('masters/emp-pay-head-link');
        } else {
            return redirect('/');
        }
    }

    public function deleteEmpPayHeadLink($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Pay_head_link_master::where('id', $id)->delete();
            Session::flash('message', 'Employee Pay Head Link Information Successfully Deleted.');
            return redirect('masters/emp-pay-head-link');
        } else {
            return redirect('/');
        }
    }
}
