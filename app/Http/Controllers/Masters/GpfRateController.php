<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Gpf_rate_master;
use App\Models\Masters\Pf_rate_master;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use View;

class GpfRateController extends Controller
{

    public function gpfRateListing()
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
                $data['gpfratelisting'] = Gpf_rate_master::all();
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/gpfratelist', $data);
        } else {
            return redirect('/');
        }
    }

    public function pfRateListing()
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
                $data['pfratelisting'] = Pf_rate_master::all();
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/gpfratelist', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewGpfRate()
    {
        if (!empty(Session::get('admin'))) {
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

            return view('masters/vw-gpfrate', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveGpfRate(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                $gpfrate = new Gpf_rate_master();
                $data['rate_of_interest'] = $request->rate_of_interest;
                $data['from_date'] = $request->from_date;
                $data['to_date'] = $request->to_date;
                $data['effect_on'] = $request->effect_on;
                $data['gpf_no'] = $request->gpf_no;
                $data['created_at'] = date('Y-m-d');

                $gpfrate->create($data);
                $request->session()->flash('status', 'success');
                $request->session()->flash('message', 'Record successfully added!');
            } catch (Exception $e) {

                $request->session()->flash('status', 'error');
                $request->session()->flash('error', 'Some error occured');
            }
            return redirect('masters/gpf-rate-listing');
        } else {
            return redirect('/');
        }
    }

    public function updateGpfRate(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                if (empty($request['id'])) {

                    $gpfrate = new Gpf_rate_master();
                    $data['rate_of_interest'] = $request->rate_of_interest;
                    $data['from_date'] = $request->from_date;
                    $data['to_date'] = $request->to_date;
                    $data['effect_on'] = $request->effect_on;
                    $data['gpf_no'] = $request->gpf_no;
                    $data['created_at'] = date('Y-m-d');

                    $gpfrate->create($data);
                    $request->session()->flash('status', 'success');
                    $request->session()->flash('message', 'Record successfully added!');
                } else {

                    Gpf_rate_master::where('id', $request['id'])
                        ->update(['effect_on' => $request['effect_on'], 'gpf_no' => $request['gpf_no']]);
                    $request->session()->flash('status', 'success');
                    $request->session()->flash('message', 'Record Update Successfully!');
                }
            } catch (Exception $e) {

                $request->session()->flash('status', 'error');
                $request->session()->flash('error', 'Some error occured');
            }
            return redirect('masters/gpf-rate-listing');
        } else {
            return redirect('/');
        }
    }

    public function getgpfrateDtl($id)
    {

        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            try {

                $data['gpf_details'] = Gpf_rate_master::where('id', '=', $id)
                    ->first();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return view('masters/edit-gpfrate', $data);
        } else {
            return redirect('/');
        }
    }
}
