<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\BonusRate;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use View;

class BonusRateController extends Controller
{

    public function listing()
    {

        if (!empty(Session::get('admin'))) {

            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();
            try {
                $data['pfratelisting'] = BonusRate::all();
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/bonusratelist', $data);
        } else {
            return redirect('/');
        }
    }

    public function view()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            try {
                //$data['coalisting']  = Coa::all();

            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/vw-bonusrate', $data);
        } else {
            return redirect('/');
        }
    }

    public function save(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                $gpfrate = new BonusRate();
                $data['effective_from'] = $request->effective_from;

                $data['interest'] = $request->interest;
                $data['status'] = $request->status;

                $data['created_at'] = date('Y-m-d');
                //dd($data);
                $gpfrate->insert($data);
                $request->session()->flash('status', 'success');
                $request->session()->flash('message', 'Record successfully added!');
            } catch (Exception $e) {

                $request->session()->flash('status', 'error');
                $request->session()->flash('error', 'Some error occured');
            }
            return redirect('masters/bonus-rate');
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                if (!empty($request['id'])) {

                    $gpfrate = new BonusRate();
                    $data['effective_from'] = $request->effective_from;

                    $data['interest'] = $request->interest;
                    $data['status'] = $request->status;

                    $data['updated_at'] = date('Y-m-d');
                    BonusRate::where('id', $request['id'])
                        ->update($data);

                    $request->session()->flash('status', 'success');
                    $request->session()->flash('message', 'Record Update Successfully!');
                } else {

                    $request->session()->flash('status', 'error');
                    $request->session()->flash('error', 'Some error occured');
                    $request->session()->flash('status', 'success');

                }
            } catch (Exception $e) {

                $request->session()->flash('status', 'error');
                $request->session()->flash('error', 'Some error occured');
            }
            return redirect('masters/bonus-rate');
        } else {
            return redirect('/');
        }
    }

    public function getBonusRate($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            try {
                $data['gpf_details'] = BonusRate::where('id', '=', $id)->first();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return view('masters/edit-bonusrate', $data);
        } else {
            return redirect('/');
        }
    }
}
