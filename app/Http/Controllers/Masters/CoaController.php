<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Account_master;
use Illuminate\Http\Request;
use App\Models\Masters\Coa;
use App\Models\Masters\Coa_master;
use App\Models\Masters\Role_authorization;
use View;
use Validator;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CoaController extends Controller
{


	public function coaListing()
	{
		if (!empty(Session::get('admin'))) {



			try {
				$data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

					->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
					->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
					->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
					->where('member_id', '=', Session::get('adminusernmae'))
					->get();
				$data['coalisting']  = Coa_master::all();
			} catch (Exception $e) {

				return $e->getMessage();
			}

			return view('masters/coalist', $data);
		} else {
			return redirect('/');
		}
	}


	public function viewCoa()
	{
		if (!empty(Session::get('admin'))) {

			try {
				//$data['coalisting']  = Coa::all();

			} catch (Exception $e) {

				return $e->getMessage();
			}

			return view('masters/vw-coa');
		} else {
			return redirect('/');
		}
	}


	public function saveCoa(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			//print_r($request->all()); exit;
			try {
				$coa = new Coa_master();
				$data['account_type'] = $request->account_type;
				$data['account_name'] = $request->account_name;
				$data['coa_code'] = $request->coa_code;
				$data['head_name'] = $request->head_name;
				$data['account_tool'] = $request->account_tool;
				$data['account_reflect_on'] = $request->account_reflect_on;
				$data['coa_remarks'] = $request->coa_remarks;

				if (empty($request->id)) {
					$coa->create($data);
					$request->session()->flash('status', 'success');
					$request->session()->flash('message', 'Record successfully added!');
				}
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('error', 'Some error occured');
			}
			return redirect('masters/coas');
		} else {
			return redirect('/');
		}
	}

	/*
	* update Department view
	* created on: 27-07-2016
	*/
	public function getCoaById($coa_id)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['coa_details'] = Coa::find($coa_id);
			} catch (Exception $e) {
				return $e->getMessage();
			}

			return view('masters/vw-coa', $data);
		} else {
			return redirect('/');
		}
	}

	public function coaAccounttype($account_type)
	{
		if (!empty(Session::get('admin'))) {

			if (!empty(Session::get('admin'))) {
				$account_types = Account_master::where('account_type', '=', $account_type)
					->get();

				echo json_encode($account_types);
			} else {
				return redirect('/');
			}
		} else {
			return redirect('/');
		}
	}

	public function getCoacode($account_type, $account_name)
	{

		if (!empty(Session::get('admin'))) {

			if (!empty(Session::get('admin'))) {
				$coa_codes = Coa_master::where('account_type', '=', $account_type)
					->where('account_name', '=', $account_name)
					->orderBy('id', 'DESC')
					->first();
				echo json_encode($coa_codes);
			} else {
				return redirect('/');
			}
		} else {
			return redirect('/');
		}
	}


	public function getBasecode($account_type, $account_name)
	{
		if (!empty(Session::get('admin'))) {


			if (!empty(Session::get('admin'))) {

				$account_code = Account_master::where('account_type', '=', $account_type)
					->where('account_name', '=', $account_name)
					->first();

				echo json_encode($account_code);
			} else {
				return redirect('/');
			}
		} else {
			return redirect('/');
		}
	}
}
