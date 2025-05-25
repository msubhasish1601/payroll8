<?php

namespace App\Http\Controllers\IncomeTax;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncomeTax\ItaxDeposit;
use App\Models\Masters\Role_authorization;
use Validator;
use Session;
use View;
use Illuminate\Support\Facades\Input;
use Auth;

class ItaxDepositController extends Controller
{

    public function getItaxDeposit()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['records'] = ItaxDeposit::get();
            return view('incometax/deposit', $data);
        } else {
            return redirect('/');
        }
    }

    public function addItaxDeposit()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return view('incometax/add-deposit',$data);
        } else {
            return redirect('/');
        }
    }

    public function saveItaxDeposit(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'amount' => 'required',
                    'payment_date' => 'required',
                    'bsr_code' => 'required',
                    'bank' => 'required',
                    'challan_no' => 'required'

                ],
                [
                    'amount.required' => 'Amount Required',
                    'payment_date.required' => 'Payment Date Required',
                    'bsr_code.required' => 'BSR Code Required',
                    'bank.required' => 'Deposit bank information Required',
                    'challan_no.required' => 'Challan No. Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/add-deposit')->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'amount' => $request->input('amount'),
                'payment_date' => $request->input('payment_date'),
                'bsr_code' => $request->input('bsr_code'),
                'bank' => $request->input('bank'),
                'challan_no' => $request->input('challan_no')
            );

            // print_r($data);
            // die();
            $income_tax = new ItaxDeposit();

            $income_tax->create($data);
            Session::flash('message', 'Income Tax Deposit Information Successfully Saved.');

            return redirect('itax/deposit');
        } else {
            return redirect('/');
        }
    }
     
    public function editDeposit($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['records'] = ItaxDeposit::where('id', '=', $id)->first();
            return view('incometax/edit-deposit', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateDeposit(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $validator = Validator::make(
                $request->all(),
                [
                    'amount' => 'required',
                    'payment_date' => 'required',
                    'bsr_code' => 'required',
                    'bank' => 'required',
                    'challan_no' => 'required'

                ],
                [
                    'amount.required' => 'Amount Required',
                    'payment_date.required' => 'Payment Date Required',
                    'bsr_code.required' => 'BSR Code Required',
                    'bank.required' => 'Deposit bank information Required',
                    'challan_no.required' => 'Challan No. Required'

                ]
            );

            if ($validator->fails()) {
                return redirect('itax/edit-deposit/'.$request['id'])->withErrors($validator)->withInput();
            }
            //$data = $request->all();
            $data = array(

                'amount' => $request->input('amount'),
                'payment_date' => $request->input('payment_date'),
                'bsr_code' => $request->input('bsr_code'),
                'bank' => $request->input('bank'),
                'challan_no' => $request->input('challan_no')
            );

            // print_r($data);
            // die();
            ItaxDeposit::where('id', $request['id'])->update($data);
            Session::flash('message', 'Income Tax Deposit Information Successfully Updated.');
            return redirect('itax/deposit');
        } else {
            return redirect('/');
        }
    }

    public function deleteDeposit($id)
    {
        if (!empty(Session::get('admin'))) {
            $dataUpdate = ItaxDeposit::where('id', $id)->delete();
            Session::flash('message', 'Income Tax Deposit Information Successfully Deleted.');
            return redirect('itax/deposit');
        } else {
            return redirect('/');
        }
    }

}
