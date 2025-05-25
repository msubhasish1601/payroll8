<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Rate_details;
use App\Models\Masters\Rate_master;
use App\Models\Masters\Role_authorization;
use Illuminate\Http\Request;
use Session;
use view;

class RateDetails extends Controller
{
    public function addRateDetailsForm()
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

            return view('masters/add-rate-details', $data);
        } else {
            return redirect('/');
        }
    }

    public function SubmitRateDetailsForm(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $request->head_id;

            $data = array(
                'rate_id' => $request['rate_id'],
                'inpercentage' => $request['inpercentage'],
                'inrupees' => $request['inrupees'],
                'max_basic' => $request['max_basic'],
                'min_basic' => $request['min_basic'],
                'pay_type' => $request['pay_type'],
                'from_date' => $request['from_date'],
                'to_date' => $request['to_date'],
                'cal_type' => $request['cal_type'],
            );

            Rate_details::insert($data);
            Session::flash('message', 'Rate Details Successfully Added.');
            return redirect('masters/ratelist');

        } else {
            return redirect('/');
        }
    }

    public function getRateList()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['ratelist'] = Rate_details::leftJoin('rate_masters', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->orderBy('rate_details.id', 'DESC')
                ->get();
            //echo "<pre>"; print_r($data); exit;
            return view('masters/rate-detail', $data);
        } else {
            return redirect('/');
        }
    }

    public function getRateChart($rate_id)
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            $data['ratedtl'] = Rate_details::leftJoin('rate_masters', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->where('rate_details.id', '=', $rate_id)
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();
            return view('masters/edit-rate', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveRateChart(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $request->validate([
                'inpercentage' => 'required|numeric',
                'inrupees' => 'required|numeric',
            ]);
            $data = array(
                'id' => $request->id,
                'inpercentage' => $request->inpercentage,
                'inrupees' => $request->inrupees,
                'pay_type' => $request->pay_type,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
            );

            Rate_details::where('id', $request->id)
                ->update([
                    'inpercentage' => $request['inpercentage'],
                    'inrupees' => $request['inrupees'],
                    'pay_type' => $request['pay_type'],
                    'from_date' => $request['from_date'],
                    'max_basic' => $request['max_basic'],
                    'min_basic' => $request['min_basic'],
                    'to_date' => $request['to_date'],
                    'cal_type' => $request['cal_type'],
                ]);
            //return back()->with('success','Rate Save successfully');
            Session::flash('message', 'Rate Details Successfully Updated.');
            //return back();
            return redirect('masters/ratelist');
        } else {
            return redirect('/');
        }
    }

    public function HeadTypeIdName($head_type)
    {
        $Rate_master_rs = Rate_master::where('head_type', '=', $head_type)

            ->get();
        $result = '';

        $result_status1 = " <option value='' selected disabled >Select</option> ";
        foreach ($Rate_master_rs as $Rate_masteval) {
            $result_status1 .= '<option value="' . $Rate_masteval->id . '"> ' . $Rate_masteval->head_name . '</option>';
        }

        echo $result_status1;
    }
}
