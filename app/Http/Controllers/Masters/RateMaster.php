<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Rate_master;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use view;

class RateMaster extends Controller
{
    public function addRateMasterDetailsForm()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['Rate'] = Rate_master::get();

            return view('masters/add-rate-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function SubmitRateMasterDetailsForm(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $exit = Rate_master::where('head_name', '=', $request['head_name'])->where('head_type', '=', $request['head_type'])->first();
            if (empty($exit)) {

                $data = array(
                    'head_name' => $request['head_name'],
                    'head_type' => $request['head_type'],

                );

                Rate_master::insert($data);
                Session::flash('message', 'Rate Master Successfully Added.');
            } else {
                Session::flash('error', 'Rate Master Already Exits.');
            }
            return redirect('masters/rate-master');

        } else {
            return redirect('/');
        }
    }

    public function getRateMasterList()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['ratelist'] = Rate_master::orderBy('id', 'DESC')
                ->get();
            //echo "<pre>"; print_r($data); exit;
            return view('masters/rate-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function getRateMasterChart($rate_id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['ratedtl'] = Rate_master::where('id', '=', $rate_id)

                ->get();
            return view('masters/edit-rate-master', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveRateMasterChart(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $exit = Rate_master::where('head_name', '=', $request['head_name'])->where('head_type', '=', $request['head_type'])->where('id', '!=', $request->id)->first();
            if (empty($exit)) {
                Rate_master::where('id', $request->id)
                    ->update([
                        'head_name' => $request['head_name'],
                        'head_type' => $request['head_type'],

                    ]);

                Session::flash('message', 'Rate Master Successfully Updated.');

            } else {
                Session::flash('error', 'Rate Master Already Exits.');
            }

            return redirect('masters/rate-master');
        } else {
            return redirect('/');
        }
    }
}
