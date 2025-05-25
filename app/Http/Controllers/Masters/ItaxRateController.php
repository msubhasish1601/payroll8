<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ItaxRate;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use View;

class ItaxRateController extends Controller
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
                $data['pfratelisting'] = ItaxRate::all();
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/itaxratelist', $data);
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
                ->where('member_id', '=', $email);

            try {
                //$data['coalisting']  = Coa::all();

            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/vw-itaxrate', $data);
        } else {
            return redirect('/');
        }
    }

    public function save(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                $gpfrate = new ItaxRate();
                $data['effective_from'] = $request->effective_from;

                $data['surcharge'] = $request->surcharge;
                $data['ecess'] = $request->ecess;
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
            return redirect('masters/itax-rate');
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                if (!empty($request['id'])) {

                    $gpfrate = new ItaxRate();
                    $data['effective_from'] = $request->effective_from;

                    $data['surcharge'] = $request->surcharge;
                    $data['ecess'] = $request->ecess;
                    $data['status'] = $request->status;

                    $data['updated_at'] = date('Y-m-d');
                    ItaxRate::where('id', $request['id'])
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
            return redirect('masters/itax-rate');
        } else {
            return redirect('/');
        }
    }

    public function getItaxRate($id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email);

            try {
                $data['gpf_details'] = ItaxRate::where('id', '=', $id)->first();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return view('masters/edit-itaxrate', $data);
        } else {
            return redirect('/');
        }
    }
}
