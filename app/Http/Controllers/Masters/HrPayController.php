<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Hr_pay_parameter;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class HrPayController extends Controller
{
    public function getHrPay()
    {
        if (!empty(Session::get('admin'))) {

            $data['hr_pay'] = Hr_pay_parameter::get();
            return view('masters/hr-pay-parameter', $data);
        } else {
            return redirect('/');
        }
    }

    public function addHrPay()
    {
        if (!empty(Session::get('admin'))) {
            
            return view('masters/add-hr-pay-parameter');
        } else {
            return redirect('/');
        }
    }


    public function saveHrPay(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pf_percentage' => 'required',
                    'pf_bar_amount' => 'required',
                    'apf_percentage' => 'required',
                    'hra_default_percentage' => 'required',
                    'pf_loan_interest' => 'required'

                ],
                [
                    'pf_percentage.required' => 'PF Percentage Required',
                    'pf_bar_amount.required' => 'PF Bar Amount Required',
                    'apf_percentage.required' => 'APF Percentage Required',
                    'hra_default_percentage.required' => 'HRA Default Percent Required',
                    'pf_loan_interest.required' => 'PF Loan Interest Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-hr-pay-parameter')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pf_percentage' => $request->input('pf_percentage'),
                'pf_bar_amount' => $request->input('pf_bar_amount'),
                'apf_percentage' => $request->input('apf_percentage'),
                'hra_default_percentage' => $request->input('hra_default_percentage'),
                'pf_loan_interest' => $request->input('pf_loan_interest')
            );


            $hr_pay = new Hr_pay_parameter();
            $hr_pay->create($data);
            Session::flash('message', 'HR Pay Parameters Information Successfully Saved.');

            return redirect('masters/hr-pay-parameter');
        } else {
            return redirect('/');
        }
    }


    public function editHrPay($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['hr_pay'] = Hr_pay_parameter::where('id', '=', $id)->first();

            return view('masters/edit-hr-pay-parameter', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateHrPay(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pf_percentage' => 'required',
                    'pf_bar_amount' => 'required',
                    'apf_percentage' => 'required',
                    'hra_default_percentage' => 'required',
                    'pf_loan_interest' => 'required'

                ],
                [
                    'pf_percentage.required' => 'PF Percentage Required',
                    'pf_bar_amount.required' => 'PF Bar Amount Required',
                    'apf_percentage.required' => 'APF Percentage Required',
                    'hra_default_percentage.required' => 'HRA Default Percent Required',
                    'pf_loan_interest.required' => 'PF Loan Interest Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-hr-pay-parameter')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pf_percentage' => $request->input('pf_percentage'),
                'pf_bar_amount' => $request->input('pf_bar_amount'),
                'apf_percentage' => $request->input('apf_percentage'),
                'hra_default_percentage' => $request->input('hra_default_percentage'),
                'pf_loan_interest' => $request->input('pf_loan_interest')
            );

            Hr_pay_parameter::where('id', $request['id'])->update($data);
            Session::flash('message', 'HR Pay Parameters Information Successfully Updated.');
            return redirect('masters/hr-pay-parameter');
        } else {
            return redirect('/');
        }
    }

    public function deleteHrPay($id)
    {
        if (!empty(Session::get('admin'))) {

            $dataUpdate = Hr_pay_parameter::where('id', $id)->delete();
            Session::flash('message', 'HR Pay Parameters Information Successfully Deleted.');
            return redirect('masters/hr-pay-parameter');
        } else {
            return redirect('/');
        }
    }
}
