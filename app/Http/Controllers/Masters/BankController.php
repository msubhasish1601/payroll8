<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Bank;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use view;

class BankController extends Controller
{
    public function getBankList()
    {
        if (!empty(Session::get('admin'))) {

            $bank_rs = Bank::getMasterAndBank();
            $data['bank_rs'] = $bank_rs;
            //print_r($bank_rs); exit;
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('masters/view-banks', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewAddBank()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            $data['MastersbankName'] = Bank::getMastersBank();
            return view('masters/add-bank', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveBank(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            if (is_numeric($request->branch_name) == 1) {
                Session::flash('error', 'Branch Name Should not be numeric.');
                return redirect('masters/vw-bank');
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'bank_name' => 'required|max:255',
                    'branch_name' => 'required|max:255',
                    'ifsc_code' => 'required|unique:banks|max:255',
                    //'swift_code' => 'required|unique:banks|max:255',
                    'account_number' => 'required|unique:banks|max:255',
                ],
                [
                    'bank_name.required' => 'Bank Name Required.',
                    'branch_name.required' => 'Branch name Required',
                    'branch_name.unique' => 'Branch name already exsits',
                    'ifsc_code.required' => 'IFSC name Required',
                    'ifsc_code.unique' => 'IFSC name already exsits',
                    //'swift_code.required' => 'Swift code Name Required',
                    //'swift_code.unique' => 'Swift code Name already exsits',
                    'account_number.required' => 'Account number already Required',
                    'account_number.unique' => 'Account number already exsits',
                ]
            );
            // print_r('hello');
            // die();
            if ($validator->fails()) {

                return redirect('masters/add-bank')
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $data = request()->all();
                // print_r($data);
                // die();
                $bank = new Bank();

                $bank->create($data);
                Session::flash('message', 'Bank Information Successfully saved.');
                return redirect('masters/vw-bank');
            }
        } else {
            return redirect('/');
        }
    }

    public function editAddBank($id)
    {
        if (!empty(Session::get('admin'))) {

            $bankid = $id;
            $data['bankdetails'] = Bank::where('id', $bankid)->get()->toArray();
            $data['MastersbankName'] = Bank::getMastersBank();
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            //print_r($data['MastersbankName']);die;
            return view('masters/edit-bank', $data);
        } else {
            return redirect('/');
        }
    }

    public function updateBank(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            if (is_numeric($request->branch_name) == 1) {
                Session::flash('error', 'Branch Name Should not be numeric.');
                return redirect('masters/vw-bank');
            }

            $data = array(
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'ifsc_code' => $request->ifsc_code,
                'swift_code' => $request->swift_code,
                'account_number' => $request->account_number,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                // 'bank_status' => $request->des_status,
            );
            Bank::where('id', $request->bankid)->update($data);
            Session::flash('message', 'Bank Information Successfully Updated.');
            return redirect('masters/vw-bank');
        } else {
            return redirect('/');
        }
    }
}
