<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Pay_head_master;
use App\Models\Masters\Pay_type;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class EmpPayHeadController extends Controller
{

    public function getEmpPayHead()
    {
        if (!empty(Session::get('admin'))) {

            $emp_pay_head = Pay_head_master::leftJoin('pay_types','pay_types.id', '=', 'pay_head_masters.pay_type')
            ->select('pay_head_masters.*', 'pay_types.pay_type_name')
            ->where('pay_head_masters.pay_head_status', '=', 'active')->get();
            return view('masters/emp-pay-head', compact('emp_pay_head'));
        } else {
            return redirect('/');
        }
    }

    public function addNewPayHead()
    {
        if (!empty(Session::get('admin'))) {

            $pay_type = Pay_type::where('pay_type_status', '=', 'active')->get();
            return view('masters/add-new-pay-head', compact('pay_type'));
        } else {
            return redirect('/');
        }
    }


    public function savePayHead(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pay_type' => 'required',
                    'pay_deduction_name' => 'required',
                    'pay_deduction_head' => 'required',
                    'function_name' => 'required',
                    'value_type' => 'required',
                    'pay_value' => 'required',
                    'calculation_order' => 'required',
                    'print_order' => 'required',
                    'i_order' => 'required'

                ],
                [
                    'pay_type.required' => 'Pay Type Required',
                    'pay_deduction_name.required' => 'Pay Deduction Name Required',
                    'pay_deduction_head.required' => 'Pay Deduction Head Required',
                    'function_name.required' => 'Function Name Required',
                    'value_type.required' => 'Value Type Required',
                    'pay_value.required' => 'Pay Value Required',
                    'calculation_order.required' => 'Calculation Order Required',
                    'print_order.required' => 'Print Order Required',
                    'i_order.required' => 'I Order Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-new-pay-head')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_type' => $request->input('pay_type'),
                'pay_deduction_name' => $request->input('pay_deduction_name'),
                'pay_deduction_head' => $request->input('pay_deduction_head'),
                'function_name' => $request->input('function_name'),
                'value_type' => $request->input('value_type'),
                'pay_value' => $request->input('pay_value'),
                'calculation_order' => $request->input('calculation_order'),
                'print_order' => $request->input('print_order'),
                'i_order' => $request->input('i_order'),
                'pay_head_status' => $request->input('pay_head_status')
            );

            // print_r($data);
            // die();
            $emp_pay_head = new Pay_head_master();

            $pay_head = Pay_head_master::where('pay_deduction_name', '=', $request->input('pay_deduction_name'))->where('pay_head_status', '=', 'active')->first();

            if (empty($pay_head)) {
                $emp_pay_head->create($data);
                Session::flash('message', 'Employee Pay Head Information Successfully Saved.');
            } else {
                Session::flash('error', 'Employee Pay Head Already Exits.');
            }
            return redirect('masters/emp-pay-head');
        } else {
            return redirect('/');
        }
    }

    public function editPayHead($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['pay_head'] = Pay_head_master::leftJoin('pay_types', 'pay_head_masters.pay_type', '=', 'pay_types.id')
                ->where('pay_head_masters.id', '=', $id)
                ->select('pay_head_masters.*', 'pay_types.pay_type')
                ->first();

            $data['pay_type'] = Pay_type::where('pay_type_status', '=', 'active')->get();
            return view('masters/edit-pay-head', $data);
        } else {
            return redirect('/');
        }
    }

    public function updatePayHead(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$validator = Validator::make(
                $request->all(),
                [
                    'pay_type' => 'required',
                    'pay_deduction_name' => 'required',
                    'pay_deduction_head' => 'required',
                    'function_name' => 'required',
                    'value_type' => 'required',
                    'pay_value' => 'required',
                    'calculation_order' => 'required',
                    'print_order' => 'required',
                    'i_order' => 'required'

                ],
                [
                    'pay_type.required' => 'Pay Type Required',
                    'pay_deduction_name.required' => 'Pay Deduction Name Required',
                    'pay_deduction_head.required' => 'Pay Deduction Head Required',
                    'function_name.required' => 'Function Name Required',
                    'value_type.required' => 'Value Type Required',
                    'pay_value.required' => 'Pay Value Required',
                    'calculation_order.required' => 'Calculation Order Required',
                    'print_order.required' => 'Print Order Required',
                    'i_order.required' => 'I Order Required'

                ]
            );

			if ($validator->fails()) {
                return redirect('masters/edit-pay-head')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_type' => $request->input('pay_type'),
                'pay_deduction_name' => $request->input('pay_deduction_name'),
                'pay_deduction_head' => $request->input('pay_deduction_head'),
                'function_name' => $request->input('function_name'),
                'value_type' => $request->input('value_type'),
                'pay_value' => $request->input('pay_value'),
                'calculation_order' => $request->input('calculation_order'),
                'print_order' => $request->input('print_order'),
                'i_order' => $request->input('i_order'),
                'pay_head_status' => $request->input('pay_head_status')
            );

				Pay_head_master::where('id', $request['id'])->update($data);
				Session::flash('message', 'Employee Pay Head Information Successfully Updated.');
				return redirect('masters/emp-pay-head');
			
		} else {
			return redirect('/');
		}
	}

    public function deletePayHead($id)
    {
        if (!empty(Session::get('admin'))) {

				$dataUpdate = Pay_head_master::where('id', $id)
					->update(['pay_head_status' => 'inactive']);
				return back()->with('delete', 'Employee Pay Head Information Successfully Deleted.');
			
        } else {
            return redirect('/');
        }
    }
}
