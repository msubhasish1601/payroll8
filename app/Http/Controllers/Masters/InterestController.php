<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Interest;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use View;

class InterestController extends Controller
{

    public function gpfPfListing()
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
                $data['pfratelisting'] = Interest::all();
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('masters/pfratelist', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewPfRate()
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

            return view('masters/vw-pfrate', $data);
        } else {
            return redirect('/');
        }
    }

    public function savePfRate(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                $gpfrate = new Interest();
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
            return redirect('masters/pfinterest');
        } else {
            return redirect('/');
        }
    }

    public function updateGpfRate(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            try {

                if (!empty($request['id'])) {

                    $gpfrate = new Interest();
                    $data['effective_from'] = $request->effective_from;

                    $data['interest'] = $request->interest;
                    $data['status'] = $request->status;

                    $data['updated_at'] = date('Y-m-d');
                    Interest::where('id', $request['id'])
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
            return redirect('masters/pfinterest');
        } else {
            return redirect('/');
        }
    }

    public function getPfrateDtl($id)
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
                $data['gpf_details'] = Interest::where('id', '=', $id)->first();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return view('masters/edit-pfrate', $data);
        } else {
            return redirect('/');
        }
    }
}
