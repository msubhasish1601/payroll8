<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Account_master;
use App\Models\Masters\Ledger_master;
use Illuminate\Http\Request;
use App\Models\Masters\Role_authorization;
use View;
use Validator;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Exception;

class AccountMasterController extends Controller
{
	/**
	 * Function Name :  accountListing
	 * Purpose       :  This function is for the listing page of accountListing
	 * Author        :
	 * Created Date  : 
	 * Modified date :          
	 * Input Params  :  NIL
	 * Return Value  :  return to view page

	 */

	public function accountListing()
	{
		if (!empty(Session::get('admin'))) {

			try {
				$data['Roledata'] =  Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
					->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
					->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
					->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
					->where('member_id', '=', Session::get('adminusernmae'))
					->get();

				$data['accountlisting']  = Account_master::all();

				return view('masters/accountlist', $data);
			} catch (Exception $e) {
				throw new \App\Exceptions\AdminException($e->getMessage());
			}
		} else {
			return redirect('/');
		}
	}

	/**
	 * Function Name :  viewAccount
	 * Purpose       :  This function is for the view page of viewAccount
	 * Author        :
	 * Created Date  : 
	 * Modified date :          
	 * Input Params  :  NIL
	 * Return Value  :  return to view page

	 */


	public function viewAccount()
	{
		if (!empty(Session::get('admin'))) {

			try {
				$data['account_head_list'] = Ledger_master::get();
				return view('masters/vw-account', $data);
			} catch (Exception $e) {
				throw new \App\Exceptions\AdminException($e->getMessage());
			}
		} else {
			return redirect('/');
		}
	}


	public function saveAccount(Request $request)
	{
		if (!empty(Session::get('admin'))) {

			//echo "<pre>"; print_r($request->all()); exit;
			try {

				$check_duplicate_account_code = Account_master::where('account_code', '=', $request->account_code)->first();


				if (empty($check_duplicate_account_code)) {
					$accountmaster = new Account_master();
					$data['account_code'] = $request->account_code;
					$data['account_type'] = $request->account_type;
					$data['account_name'] = $request->account_name;
					$data['account_desc'] = $request->account_desc;
					$data['created_at'] = date("Y-m-d H:i:s");
					if (empty($request->id)) {
						$accountmaster->create($data);
						$request->session()->flash('status', 'success');
						$request->session()->flash('message', 'Record successfully added!');
					}
				} else {
					$request->session()->flash('status', 'success');
					$request->session()->flash('error', 'Please Check Your Account Code!.');
				}
			} catch (Exception $e) {

				$request->session()->flash('status', 'error');
				$request->session()->flash('error', 'Some error occured');
			}
			return redirect('masters/accountmasters');
		} else {
			return redirect('/');
		}
	}

	/*
	* update Department view
	* created on: 27-07-2016
	*/
	public function getAccountById($account_id)
	{

		if (!empty(Session::get('admin'))) {

			try {

				$data['account_details'] = Account_master::find($account_id);
			} catch (Exception $e) {
				return $e->getMessage();
			}
			$data['account_head_list'] = Ledger_master::get();
			return view('masters/vw-account', $data);
		} else {
			return redirect('/');
		}
	}
}
