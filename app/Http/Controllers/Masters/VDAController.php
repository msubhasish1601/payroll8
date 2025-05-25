<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Employee_type;
use App\Models\Masters\Vda_detail;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class VDAController extends Controller
{

    public function getVdaDetails()
    {
        if (!empty(Session::get('admin'))) {

            $vda_details = Vda_detail::leftJoin('employee_types', 'employee_types.id', '=', 'vda_details.emp_type')
                ->select('vda_details.*', 'employee_types.employee_type_name')
                ->where('employee_types.employee_type_status', '=', 'active')
                ->get();
            return view('masters/vda-details', compact('vda_details'));
        } else {
            return redirect('/');
        }
    }

    public function addVdaDetails()
    {
        if (!empty(Session::get('admin'))) {

            $employee = Employee_type::where('employee_type_status', '=', 'active')->get();
            return view('masters/add-vda-details', compact('employee'));
        } else {
            return redirect('/');
        }
    }

    public function saveVdaDetails(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pay_month_year' => 'required',
                    'emp_type' => 'required',
                    'vda_current' => 'required',
                    'vda_previous' => 'required',
                    'vda_previous_previous' => 'required',
                    'ot_vda' => 'required'

                ],
                [
                    'pay_month_year.required' => 'Pay Month Year Required',
                    'emp_type.required' => 'Employee Type Required',
                    'vda_current.required' => 'VDA Current Required',
                    'vda_previous.required' => 'VDA Previous Required',
                    'vda_previous_previous.required' => 'VDA Previous Previous Required',
                    'ot_vda.required' => 'OT VDA Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-vda-details')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_month_year' => $request->input('pay_month_year'),
                'emp_type' => $request->input('emp_type'),
                'vda_current' => $request->input('vda_current'),
                'vda_previous' => $request->input('vda_previous'),
                'vda_previous_previous' => $request->input('vda_previous_previous'),
                'ot_vda' => $request->input('ot_vda')
            );

            // print_r($data);
            // die();
            $vda_details = new Vda_detail();

            $vda_details->create($data);
            Session::flash('message', 'VDA Details Information Successfully Saved.');

            return redirect('masters/vda-details');
        } else {
            return redirect('/');
        }
    }

    public function deleteVdaDetails($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = Vda_detail::where('id', $id)->delete();
            Session::flash('message', 'VDA Details Information Successfully Deleted.');
            return redirect('masters/vda-details');
        } else {
            return redirect('/');
        }
    }

    public function searchVdaDetails()
    {
        if (!empty(Session::get('admin'))) {
            $result = '';
            $vda_details = Vda_detail::leftJoin('employee_types', 'employee_types.id', '=', 'vda_details.emp_type')
                ->select('vda_details.*', 'employee_types.employee_type_name')
                ->where('employee_types.employee_type_status', '=', 'active')
                ->groupby('vda_details.pay_month_year')
                ->get();
            return view('masters/search-vda-details', compact('vda_details', 'result'));
        } else {
            return redirect('/');
        }
    }

    public function showVdaDetails(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $payroll_details_rs = $result = '';
            $pay_month_year = $request->pay_month_year;
            $validator = Validator::make($request->all(), [
                'pay_month_year' => 'required',
                [
                    'pay_month_year.required' => 'Month Year Required'
                ]
            ]);

            if ($validator->fails()) {
                return redirect('masters/search-vda-details')->withErrors($validator)->withInput();
            }

            $vda_year = Vda_detail::leftJoin('employee_types', 'employee_types.id', '=', 'vda_details.emp_type')
                ->select('vda_details.*', 'employee_types.employee_type_name')
                ->where('employee_types.employee_type_status', '=', 'active')
                ->where('vda_details.pay_month_year', '=', $pay_month_year)
                ->get();
            // print_r($pay_month_year);
            // die();
            $vda_details = Vda_detail::groupby('pay_month_year')->get();
            foreach ($vda_year as $vda) {

                $result .= '<tr style="text-align:center;">
						<td>' . $vda->pay_month_year . '</td>
						<td>' . $vda->employee_type_name . '</td>
						<td>' . $vda->vda_current . '</td>
						<td>' . $vda->vda_previous . '</td>
						<td>' . $vda->vda_previous_previous . '</td>
						<td>' . $vda->ot_vda . '</td>
						
					</tr>';
            }

            return view('masters/search-vda-details', compact('result', 'vda_details', 'vda_year'));
        } else {
            return redirect('/');
        }
    }
}
