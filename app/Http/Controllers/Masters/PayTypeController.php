<?php

namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Pay_type;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class PayTypeController extends Controller
{

    public function getPayType()
    {
        if (!empty(Session::get('admin'))) {

            
            $data['pay_type'] = Pay_type::get();
            return view('masters/view-pay-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function addPayType()
    {
        if (!empty(Session::get('admin'))) {

            return view('masters/add-pay-type');
        } else {
            return redirect('/');
        }
    }

    public function savePayType(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'pay_type_name' => 'required',
                    'pay_type_status' => 'required'

                ],
                [
                    'pay_type_name.required' => 'Pay Type Required',
                    'pay_type_status.required' => 'Status Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/add-pay-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_type_name' => $request->input('pay_type_name'),
                'pay_type_status' => $request->input('pay_type_status')
            );

            $pay_type = new Pay_type();
            $pay_type->create($data);
            Session::flash('message', 'Pay Type Information Successfully Saved.');

            return redirect('masters/pay-type');
        } else {
            return redirect('/');
        }
    }

    public function editPayType($id)
    {
        if (!empty(Session::get('admin'))) {

            $data['pay_type'] = Pay_type::where('id', '=', $id)->first();
            return view('masters/edit-pay-type', $data);
        } else {
            return redirect('/');
        }
    }

    public function updatePayType(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			$validator = Validator::make(
                $request->all(),
                [
                    'pay_type_name' => 'required',
                    'pay_type_status' => 'required'

                ],
                [
                    'pay_type_name.required' => 'Pay Type Required',
                    'pay_type_status.required' => 'Status Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('masters/edit-pay-type')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'pay_type_name' => $request->input('pay_type_name'),
                'pay_type_status' => $request->input('pay_type_status')
            );

				Pay_type::where('id', $request['id'])->update($data);
				Session::flash('message', 'Pay Type Information Successfully Updated.');
				return redirect('masters/pay-type');
			
		} else {
			return redirect('/');
		}
	}

    public function deletePayType($id)
    {
        if (!empty(Session::get('admin'))) {

				$dataUpdate = Pay_type::where('id', $id)->delete();
                Session::flash('message', 'Pay Type Information Successfully Deleted.');
				return redirect('masters/pay-type');
			
        } else {
            return redirect('/');
        }
    }
}
