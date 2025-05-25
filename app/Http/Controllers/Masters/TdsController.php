<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Masters\Tds;
use App\Models\Masters\Role_authorization;
use App\Models\Masters\Tds_master;
use View;
use Validator;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TdsController extends Controller
{


	public function tdsListing()
	{

		if (!empty(Session::get('admin'))) {

			$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
				->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
				->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
				->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
				->where('member_id', '=', Session::get('adminusernmae'))
				->get();
			try {
				$data['tdslisting']  = Tds_master::all();
			} catch (Exception $e) {

				return $e->getMessage();
			}

			return view('masters/tdslist', $data);
		} else {
			return redirect('/');
		}
	}


	public function addTds()
	{
		if (!empty(Session::get('admin'))) {

			try {
				//$data['coalisting']  = Coa::all();

			} catch (Exception $e) {

				return $e->getMessage();
			}

			return view('masters/vw-tds');
		} else {
			return redirect('/');
		}
	}


	public function saveTds(Request $request)
	{
		if (!empty(Session::get('admin'))) {


			try {
				$tds = new Tds_master();
				$data['tds_section'] = $request->tds_section;
				$data['tds_percentage'] = $request->tds_percentage;
				$data['created_at'] = date('Y-m-d');


				$tds->create($data);
				$request->session()->flash('status', 'success');
				$request->session()->flash('message', 'Record successfully added!');
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('error', 'Some error occured');
			}
			return redirect('masters/tdslisting');
		} else {
			return redirect('/');
		}
	}

	/*
	* update Department view
	* created on: 27-07-2016
	*/
	public function getTdsDtl($tds_id)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['tds_details'] = Tds_master::find($tds_id);
			} catch (Exception $e) {
				return $e->getMessage();
			}

			return view('masters/edit-tds', $data);
		} else {
			return redirect('/');
		}
	}

	public function updateTds(Request $request)
	{
		if (!empty(Session::get('admin'))) {


			try {
				$tds = new Tds_master();
				$data['tds_section'] = $request->tds_section;
				$data['tds_percentage'] = $request->tds_percentage;
				$data['created_at'] = date('Y-m-d');


				Tds_master::where('id', $request['id'])
					->update(['tds_percentage' => $data['tds_percentage']]);
				$request->session()->flash('status', 'success');
				$request->session()->flash('message', 'Record Update Successfully!');
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('error', 'Some error occured');
			}
			return redirect('masters/tdslisting');
		} else {
			return redirect('/');
		}
	}
}
