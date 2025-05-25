<?php

namespace App\Http\Controllers\Accountpayable;

use App\Http\Controllers\Controller;
use App\Models\AccountPayable\Balance_posting;
use Illuminate\Http\Request;
use App\Models\AccountPayable\Bank_balance;
use App\Models\AccountPayable\Company_petty;
use App\Models\AccountPayable\Gl_entry;
use App\Models\AccountPayable\Payment_dtl;
use App\Models\AccountPayable\Payment_rcvd_dtl;
use App\Models\AccountPayable\Petty_balance;
use App\Models\AccountPayable\Received_voucher_entry;
use App\Models\AccountPayable\Schedule_10;
use App\Models\AccountPayable\Schedule_12;
use App\Models\AccountPayable\Schedule_13;
use App\Models\AccountPayable\Schedule_15;
use App\Models\AccountPayable\Schedule_master;
use App\Models\AccountPayable\Sundae_debtors;
use App\Models\AccountPayable\Supplier;
use App\Models\AccountPayable\Voucher_entry;
use App\Models\Masters\Account_master;
use App\Models\Masters\Account_opening_balance;
use App\Models\Masters\Bs_schedule_master;
use App\Models\Masters\Coa_master;
use App\Models\Masters\Company_bank;
use App\Models\Masters\Role_authorization;
use View;
use Validator;
use Session;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class AccountpayablereportController extends Controller
{
    public function viewdashboard()
    {
        if (!empty(Session::get('admin'))) {

            return View('mis-reports/dashboard');
        } else {
            return redirect('/');
        }
    }

    public function bankbookView()
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
            } catch (Exception $e) {

                return $e->getMessage();
            }


            $data['banklist'] = Company_bank::leftJoin('bank_masters', 'company_banks.bank_name', '=', 'bank_masters.master_bank_name')
                ->groupBy('company_banks.bank_name')
                ->get();

            return view('accountpayable/vw-bankbook', $data);
        } else {
            return redirect('/');
        }
    }

    
    public function showBankbookReport(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            try {
                $payment_dtl = Bank_balance::where('bank_branch_id', '=', $request->bank_branch_id)

                    ->where('voucher_no', '!=', '325-19-20')
                    ->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', $request->to_date)

                    ->orderBy('id', 'ASC')
                    ->get();
                //
                foreach ($payment_dtl as $payment) {

                    $narration_vou = Payment_dtl::where('voucher_id', '=', $payment->voucher_no)

                        ->first();

                    if (!empty($narration_vou)) {
                        $narration = $narration_vou->narration;
                        $voucher_type = $narration_vou->vouchertype;
                        $payment_booking_date = $narration_vou->payment_booking_date;
                    } else {
                        $narration_vou_rec = Payment_rcvd_dtl::where('voucher_no', '=', $payment->voucher_no)

                            ->first();
                        $narration = $narration_vou_rec->remarks;
                        $voucher_type = $narration_vou_rec->voucher_type;
                        $payment_booking_date = $narration_vou_rec->payment_rcv_date;
                    }


                    $data['payment_dtl'][] = array(
                        'voucher_type' => $voucher_type,
                        'narration' => $narration,
                        'payment_booking_date' => $payment_booking_date,

                        'voucher_no' => $payment->voucher_no,
                        'income' => $payment->income,
                        'expense' => $payment->expense,
                        'balance_amt' => $payment->balance_amt
                    );
                }


                $data['current_balance'] = Company_bank::where('id', '=', $request->bank_branch_id)
                    ->first();
            } catch (Exception $e) {
                return $e->getMessage();
            }

            $data['fromdate'] = $request->from_date;
            $data['todate'] = $request->to_date;

            return view('accountpayable/report-bankbook', $data);
        } else {
            return redirect('/');
        }
    }


    public function trialView()
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
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('accountpayable/vw-trial');
        } else {
            return redirect('/');
        }
    }


    public function showtrialReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $range = [$request->from_date, $request->to_date];
            try {
                $dtl = Gl_entry::whereBetween('gl_date', $range)
                    ->groupBy('gl_account_head')
                    ->get();

                $data['creditdtl'] = Gl_entry::select(Gl_entry::raw('sum(amount) as amount'))
                    ->whereBetween('gl_date', $range)
                    ->where('transaction_type', '=', 'credit')
                    ->first();
                    
                $data['debitdtl'] = Gl_entry::select(Gl_entry::raw('sum(amount) as amount'))
                    ->whereBetween('gl_date', $range)
                    ->where('transaction_type', '=', 'debit')
                    ->first();
                    
                foreach ($dtl as $val) {
                    
                    $account = Account_master::where('account_code', '=', $val->gl_account_head)
                        ->first();

                    $data['gldtl'][] = array('gl_account_head' => $account->account_name, 'account_head' => $val->gl_account_head);
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }

            $data['fromdate'] = $request->from_date;
            $data['todate'] = $request->to_date;

            return view('accountpayable/trial-balance', $data);
        } else {
            return redirect('/');
        }
    }

    public function billregisterView()
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
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('accountpayable/vw-billregister');
        } else {
            return redirect('/');
        }
    }



    public function showBillRegisterReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            try {
                $data['voucher_list'] = Voucher_entry::leftJoin('payment_dtls', 'voucher_entries.voucher_no', '=', 'payment_dtls.voucher_id')
                    ->where('voucher_entry.voucher_type', '=', 'payment_vendor')
                    ->whereDate('bill_booking_date', '>=', $request->from_date)
                    ->whereDate('bill_booking_date', '<=', $request->to_date)
                    ->get();
                //echo "<pre>"; print_r($data['voucher_list']); exit;
            } catch (Exception $e) {
                return $e->getMessage();
            }

            $data['fromdate'] = $request->from_date;
            $data['todate'] = $request->to_date;

            return view('accountpayable/bill-register', $data);
        } else {
            return redirect('/');
        }
    }

    public function incomeExpenditureView()
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
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('accountpayable/vw-income-expenditure', $data);
        } else {
            return redirect('/');
        }
    }


    public function incomeExpenditureReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            //echo "<pre>"; print_r($request->financial_year); exit;
            $getyear_range = explode("-", $request->financial_year);
            $start_year = date("$getyear_range[0]-04-01");
            $end_year = date("$getyear_range[1]-03-31");

            try {

                $income_account_heads = Schedule_master::where('particular_type', 'income')->get();

                foreach ($income_account_heads as $income_account_head) {

                    $income = Balance_posting::where('transaction_code', 'LIKE', $income_account_head->schedule . '/%')

                        ->where('financial_year', '=', $request->financial_year)


                        ->groupBy('transaction_code')
                        ->get();

                    $tolam = 0;
                    foreach ($income as $value) {

                        $schedule = Balance_posting::where('transaction_code', '=', $value->transaction_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();


                        $tolam += $schedule->closing_balance;
                    }





                    $data['currentyear_income_list'][] = array('schedule_code' => $income_account_head->schedule, 'schedule_name' => $income_account_head->particulars, 'payable_amt' => $tolam);
                }
                // echo "<pre>"; print_r($data['currentyear_income_list']); exit;

                $account_expenses = Schedule_master::where('particular_type', 'expense')->get();

                foreach ($account_expenses as $expenses) {


                    $expense = Balance_posting::where('transaction_code', 'LIKE', $expenses->schedule . '/%')

                        ->where('financial_year', '=', $request->financial_year)

                        ->groupBy('transaction_code')
                        ->get();
                    //

                    $tolamt = 0;
                    foreach ($expense as $value) {

                        $schedule = Balance_posting::where('transaction_code', '=', $value->transaction_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();


                        $tolamt += $schedule->closing_balance;
                    }


                    $data['currentyear_expenditure_list'][] = array('schedule_code' => $expenses->schedule, 'schedule_name' => $expenses->particulars, 'payable_amt' => $tolamt);
                }





                //echo "<pre>"; print_r($data['currentyear_expenditure_list']); exit;


                // exit;

            } catch (Exception $e) {
                return $e->getMessage();
            }
            // $data['income_expenditure']=array(4,9,10,11,12,13,14,15,16,17,18,19,20,21,22);
            //$data['fromyear']=$start_year;
            $data['toyear'] = $getyear_range[1];

            return view('accountpayable/income-expenditure-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getSundryDebtorsReport()
    {
        if (!empty(Session::get('admin'))) {

            $due_parties = Sundae_debtors::where('status', 'NP')->groupBy('party_name')->get();

            return view('accountpayable/get-sundry-debtors-report', compact('due_parties'));
            // dd($due_parties);
        } else {
            return redirect('/');
        }
    }

    public function viewSundryDebtorsReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //print_r($request->party_name); exit;
            if ($request->party_name == '0') {
                $due_parties = Sundae_debtors::where('status', 'NP')->get();
                return view('accountpayable/sundry-debtors-report-all', compact('due_parties'));
            } else {
                $due_parties = Sundae_debtors::where('party_name', '=', $request->party_name)->get();
                return view('accountpayable/sundry-debtors-report-individual', compact('due_parties'));
            }
            // echo "<pre>" ;print_r($due_parties); exit;
            // return view('accountpayable/sundry-debtors-report', compact('due_parties'));
        } else {
            return redirect('/');
        }
    }

    public function getPartyLedgerReport()
    {
        $suppliers = Supplier::where('supplier_status', 'active')->get();
        return view('accountpayable/get-party-ledger-report', compact('suppliers'));
    }

    public function showPartyLedgerReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            // dd($request);
            $credit_amt = 0;
            $debit_amt = 0;
            $bank = '';
            $party_name = $request->party_name;
            $party_details = Voucher_entry::leftJoin('payment_dtls', 'voucher_entries.voucher_no', '=', 'payment_dtls.voucher_id')
                ->leftJoin('coa_masters', 'voucher_entries.transaction_code', '=', 'coa_masters.coa_code')
                ->leftJoin('sundae_debtors', 'voucher_entries.voucher_no', '=', 'sundae_debtors.voucherno')
                ->where('sundae_debtors.party_name', '=', $party_name)
                ->where('voucher_entries.account_tool', '=', 'debit')
                ->select('voucher_entries.*', 'payment_dtls.vouchertype', 'payment_dtls.payment_status', 'coa_masters.head_name')
                ->get();

            foreach ($party_details as $party_detail) {

                $party_details_bank = Payment_dtl::where('voucher_id', '=', $party_detail->voucher_no)

                    ->first();
                if (!empty($party_details_bank)) {
                    $bank = $party_details_bank->bank_id;
                    $payment_amout = $party_details_bank->payment_amount;
                    $payment_date = $party_details_bank->payment_release_date;
                } else {
                    $bank = '';
                    $payment_amout = 0;
                    $payment_date = '';
                }


                if ((!empty($party_detail->voucher_type))) {
                    $credit_amt += $party_detail->payable_amt;
                    // $debit_amt = 0;
                }
            }

            // echo"<pre>"; echo $debit_amt; exit;

            // dd($party_details);
            return view('accountpayable/party-ledger-report', compact('party_details', 'bank', 'payment_amout', 'payment_date', 'party_name', 'debit_amt', 'credit_amt'));
        } else {
            return redirect('/');
        }
    }

    public function glHeadView()
    {
        if (!empty(Session::get('admin'))) {

            return view('accountpayable/vw-report-gl-head');
        } else {
            return redirect('/');
        }
    }

    public function getGlHeadView($gl_type)
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

                if ($gl_type == 'income') {
                    $gl_heads = Account_master::where('account_type', 'income')->get();
                } else {
                    $gl_heads = Account_master::where('account_type', '!=', 'income')->get();
                }
            } catch (Exception $e) {

                return $e->getMessage();
            }

            // $gl_heads = DB::table('account_master')->get();

            echo json_encode($gl_heads);
            // return view('accountpayable/vw-report-gl-head',$data);
        } else {
            return redirect('/');
        }
    }

    public function showGlHeadReport(Request $request)
    {

        if (!empty(Session::get('admin'))) {
            //print_r($request->all()); exit;
            $request->financial_year;
            $arr = explode('-', $request->financial_year);
            $financial_year = date('Y') + 1;
            $start_year = date($arr[0] . "-04-01");
            $end_year = date($arr[1] . "-03-31");

            try {
                if ($request->gl_head_type == 'income') {

                    $data['acc_main_name'] = Account_master::where('account_code', '=', $request->gl_head)
                        ->first();

                    $account_heads = Gl_entry::where('gl_account_head', '=', $request->gl_head)
                        ->whereBetween('voucher_date', [$start_year, $end_year])
                        ->groupBy('voucher_no')
                        ->get();

                    foreach ($account_heads as $account_head) {

                        $income_lists = Gl_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->where('gl_account_head', '=', $request->gl_head)
                            ->where('transaction_head', '=', $account_head->transaction_head)
                            ->orderBy('voucher_date', 'ASC')
                            ->first();

                        if (empty($account_head->voucher_date)) {

                            $account_name = Company_bank::where('account_code', '=', $income_lists->transaction_head)
                                ->first();

                            $payer_name = $account_name->bank_name;
                        } else {

                            $account_name = Coa_master::where('coa_code', '=', $income_lists->transaction_head)
                                ->first();
                            $payer_name = $account_name->head_name;
                        }

                        $income_list_credit = Gl_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->where('gl_account_head', '=', $request->gl_head)
                            ->where('transaction_head', '=', $account_head->transaction_head)
                            ->where('transaction_type', '=', 'credit')
                            ->orderBy('voucher_date', 'ASC')
                            ->first();
                        $income_list_debit = Gl::table('gl_entry')
                            ->where('voucher_no', '=', $account_head->voucher_no)
                            ->where('gl_account_head', '=', $request->gl_head)
                            ->where('transaction_head', '=', $account_head->transaction_head)
                            ->where('transaction_type', '=', 'debit')
                            ->orderBy('voucher_date', 'ASC')
                            ->first();
                        if (!empty($income_list_credit)) {
                            $credit = $income_list_credit->amount;
                        } else {
                            $credit = 0;
                        }


                        if (!empty($income_list_debit)) {
                            $debit = $income_list_debit->amount;
                        } else {
                            $debit = 0;
                        }

                        $income_list_opening = Account_opening_balance::where('financial_year', '=', $request->financial_year)
                            ->where('account_code', '=', $account_head->transaction_head)

                            ->first();
                        if (!empty($income_list_opening)) {
                            $close = $income_list_opening->closing_balance;
                        } else {
                            $close = 0;
                        }
                        $narration_vou = Voucher_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->first();
                        if (!empty($narration_vou)) {
                            $narration = $narration_vou->entry_remark;
                            $voucher_type = $narration_vou->voucher_type;
                        } else {
                            $narration_vou_rec = Received_voucher_entry::where('voucher_no', '=', $account_head->voucher_no)
                                ->first();
                            $narration = $narration_vou_rec->remarks;
                            $voucher_type = $narration_vou_rec->voucher_type;
                        }


                        $data['currentyear_income_expenses_list'][] = array(
                            'gl_date' => $income_lists->gl_date,
                            'credit_name' => $payer_name, 'narration' => $narration,
                            'transaction_type' => $income_lists->transaction_type,
                            'voucher_type' => $voucher_type,
                            'voucher_no' => $account_head->voucher_no,
                            'debit_amount' => $debit,
                            'credit_amount' => $credit,
                            'open_bal' => $close
                        );
                    }
                } else {
                    $data['acc_main_name'] = Account_master::where('account_code', '=', $request->gl_head)
                        ->first();
                    $account_heads = Gl_entry::where('gl_account_head', '=', $request->gl_head)
                        ->whereBetween('voucher_date', [$start_year, $end_year])

                        ->groupBy('voucher_no')
                        ->get();

                    foreach ($account_heads as $account_head) {

                        $expenses_lists = Gl_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->where('gl_account_head', '=', $request->gl_head)
                            ->where('transaction_head', '=', $account_head->transaction_head)
                            ->orderBy('voucher_date', 'ASC')
                            ->first();



                        if (empty($account_head->voucher_date)) {

                            $account_name = Company_bank::where('account_code', '=', $expenses_lists->transaction_head)
                                ->first();
                            $payer_name = $account_name->bank_name;
                        } else {

                            $account_name = Coa_master::where('coa_code', '=', $expenses_lists->transaction_head)
                                ->first();
                            $payer_name = $account_name->head_name;
                        }

                        $income_list_credit = Gl_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->where('gl_account_head', '=', $request->gl_head)
                            ->where('transaction_head', '=', $account_head->transaction_head)
                            ->where('transaction_type', '=', 'credit')
                            ->orderBy('voucher_date', 'ASC')
                            ->first();
                        if (!empty($income_list_credit)) {
                            $credit = $income_list_credit->amount;
                        } else {
                            $credit = 0;
                        }

                        $income_list_debit = Gl_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->where('gl_account_head', '=', $request->gl_head)
                            ->where('transaction_head', '=', $account_head->transaction_head)
                            ->where('transaction_type', '=', 'debit')
                            ->orderBy('voucher_date', 'ASC')
                            ->first();
                        if (!empty($income_list_debit)) {
                            $debit = $income_list_debit->amount;
                        } else {
                            $debit = 0;
                        }

                        $income_list_opening = Account_opening_balance::where('financial_year', '=', $request->financial_year)
                            ->where('account_code', '=', $account_head->transaction_head)

                            ->first();
                        if (!empty($income_list_opening)) {
                            $close = $income_list_opening->closing_balance;
                        } else {
                            $close = 0;
                        }
                        $narration_vou = Voucher_entry::where('voucher_no', '=', $account_head->voucher_no)
                            ->first();
                        if (!empty($narration_vou)) {
                            $narration = $narration_vou->entry_remark;
                            $voucher_type = $narration_vou->voucher_type;
                        } else {
                            $narration_vou_rec = Received_voucher_entry::where('voucher_no', '=', $account_head->voucher_no)
                                ->first();
                            $narration = $narration_vou_rec->remarks;
                            $voucher_type = $narration_vou_rec->voucher_type;
                        }

                        //echo "<pre>"; print_r($account_head); exit;
                        $data['currentyear_income_expenses_list'][] = array(
                            'gl_date' => $account_head->gl_date,
                            'credit_name' => $payer_name,
                            'narration' => $narration,
                            'transaction_type' => $expenses_lists->transaction_type,
                            'voucher_type' => $voucher_type,
                            'voucher_no' => $account_head->voucher_no,

                            'debit_amount' => $debit,
                            'credit_amount' => $credit,
                            'open_bal' => $close
                        );
                    }
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }

            $data['fromdate'] = $start_year;
            $data['todate'] = $end_year;

            //$data['current_balance'] = DB::table('bank_balance')->first();

            return view('accountpayable/gl-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function libalitiesView()
    {
        if (!empty(Session::get('admin'))) {
            $email = Auth::user()->email;
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            try {
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('accountpayable/vw-libilities', $data);
        } else {
            return redirect('/');
        }
    }


    public function showLibalitiesReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            $getyear_range = explode("-", $request->financial_year);
            $start_year = date("$getyear_range[0]-04-01");
            $end_year = date("$getyear_range[1]-03-31");

            try {

                $account_liabilities = Account_master::where('account_type', '=', 'liabilities')
                    ->get();

                foreach ($account_liabilities as $liabilities) {

                    $liability = Voucher_entry::select(Voucher_entry::raw('sum(payable_amt) as payableamt'))
                        ->where('bill_status', '=', 'Paid')
                        ->where('account_head_id', '=', $liabilities->account_code)
                        ->whereBetween('bill_booking_date', [$start_year, $end_year])
                        ->get();

                    $data['currentyear_liabilities_list'][] = array('sub_account_name' => $liabilities->account_name, 'payable_amt' => $liability[0]->payableamt);
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }


            $data['fromyear'] = $getyear_range[0];
            $data['toyear'] = $getyear_range[1];

            return view('accountpayable/libilities-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getReceiptVoucherReport()
    {
        if (!empty(Session::get('admin'))) {

            return view('mis-reports/get-receipt-voucher');
        } else {
            return redirect('/');
        }
    }

    public function viewReceiptVoucherReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // dd($request);
            $data['start'] = $request->from_date;
            $data['end'] = $request->to_date;

            $data['receipt_details'] = Gl_entry::leftJoin('payment_rcvd_dtl', 'gl_entries.voucher_no', '=', 'payment_rcvd_dtl.voucher_no')
                ->whereDate('gl_entries.payment_rcv_date', '>=', $request->from_date)
                ->whereDate('gl_entries.payment_rcv_date', '<=', $request->to_date)
                ->select('gl_entries.*', 'payment_rcvd_dtl.remarks as narration', 'payment_rcvd_dtl.payment_mode')
                ->orderBy('id')
                // ->toSql();
                ->get();

            foreach ($data['receipt_details'] as $receipt_detail) {
                if ($receipt_detail->voucher_date == '0000-00-00' && $receipt_detail->payment_mode == 'cash') {
                    $dr_act = Coa_master::where('coa_code', $receipt_detail->dr_account)->first();

                    $cr_act = Coa_master::where('coa_code', $receipt_detail->cr_account)->first();

                    $data['debt_act'] = $dr_act->head_name;
                    $data['crdt_act'] = $cr_act->head_name;
                    // echo "<pre>"; print_r($data['dr_act']->head_name);
                } elseif ($receipt_detail->voucher_date == '0000-00-00' && $receipt_detail->payment_mode != 'cash') {
                    $dr_act_1 = Company_bank::where('id', $receipt_detail->dr_account)->first();

                    $cr_act_1 = Coa_master::where('coa_code', $receipt_detail->cr_account)->first();

                    $data['debt_act_1'] = $dr_act_1->bank_name;
                    $data['crdt_act_1'] = $cr_act_1->head_name;
                }
            }

            return view('mis-reports/receipt-voucher-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getPaymentVoucherReport()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/get-payment-voucher');
        } else {
            return redirect('/');
        }
    }

    public function viewPaymentVoucherReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            // dd($request);
            $data['start'] = $request->from_date;
            $data['end'] = $request->to_date;

            $payment_details = Gl_entry::leftJoin('payment_dtls', 'gl_entries.voucher_no', '=', 'payment_dtls.voucher_id')
                ->whereDate('gl_entries.payment_release_date', '>=', $request->from_date)
                ->whereDate('gl_entries.payment_release_date', '<=', $request->to_date)
                //->orWhereDate('gl_entry.voucher_date','>=',$request->from_date)
                //->orWhereDate('gl_entry.voucher_date','<=',$request->to_date)
                ->where('payment_dtls.vouchertype', '!=', 'contra')
                ->where('payment_dtls.payment_status', '=', 'Paid')
                ->select('gl_entries.*', 'payment_dtls.narration as narration', 'payment_dtls.vouchertype as vouchertype')
                ->orderBy('id')
                ->get();
            //echo "<pre>"; print_r($payment_details); exit;

            foreach ($payment_details as $payment_dels) {
                $debt_act = '';
                $cr_act = '';
                $crdt_act = '';

                $debt_act = $payment_dels->dr_account;
                $cr_act = Company_bank::where('id', $payment_dels->cr_account)->first();
                $crdt_act = $cr_act->bank_name;

                $data['payment_details'][] = array('payment_release_date' => $payment_dels->payment_release_date, 'voucher_no' => $payment_dels->voucher_no, 'dr_account' => $debt_act, 'cr_account' => $crdt_act, 'amt' => $payment_dels->amount, 'narration' => $payment_dels->narration);
            }
            //echo "<pre>"; print_r($data['payment_details']);exit;

            return view('mis-reports/payment_voucher', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewIncomeScheduleReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {
            // dd($request);
            $arr = explode("-", $_REQUEST['financial_year']);
            $data['start_year'] = date('Y');
            $data['end_year'] = date('Y') + 1;


            // $start_financial_year = $data['start_year']."-04-01";
            // $to_financial_year = $data['end_year']."-03-31";


            $financial_year = date('Y') + 1;
            $start_year = '04/' . $arr['0'];
            $end_year = '04/' . $arr['1'];;
            $range = [$start_year, $end_year];

            $data['currentyear_income_list'] = array();
            $data['currentyear_expense_list'] = array();

            $account_heads = Account_master::where('account_code', 'LIKE', $request->party_name . '%')->get();

            foreach ($account_heads as $account_head) {
                $sub_accountlist = array();
                $schedule_no = explode("/", $account_head->account_code);
                // echo $schedule_no[0]; exit;
                if ($schedule_no[0] == '10') {
                    $data['schedule_details_10'] = Schedule_10::get();

                    foreach ($data['schedule_details_10'] as $schedule_10_det) {
                        if ($schedule_10_det->coa_code != '') {

                            $schedule_10 = Balance_posting::where('transaction_code', '=', $schedule_10_det->coa_code)
                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();
                            if (!empty($schedule_10->closing_balance)) {
                                $tot = $schedule_10->closing_balance;
                            } else {
                                $tot = 0;
                            }
                            //echo "<pre>"; print_r(); exit;

                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_10_det->account_name,
                                'total_amount' => $tot, 'tot_type' => $schedule_10_det->type
                            );
                        } else {
                            if (!empty($schedule_10_det->type)) {
                                $type = $schedule_10_det->type;
                            } else {
                                $type = '';
                            }

                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_10_det->account_name,
                                'total_amount' => '0', 'tot_type' => $type
                            );
                        }
                    }
                    // echo "<pre>"; print_r($data['schedule_det']); exit;
                    // dd($data['schedule_det']);
                    $data['financial_year'] = $request->financial_year;
                    // echo "<pre>"; print_r($data['total_received_amount']); exit;

                    return view('mis-reports/schedule_10', $data);
                }

                if ($schedule_no[0] == '12') {
                    $data['schedule_details_12'] = Schedule_12::get();

                    foreach ($data['schedule_details_12'] as $schedule_12_det) {
                        if ($schedule_12_det->coa_code != '') {

                            $schedule_12 = Balance_posting::where('transaction_code', '=', $schedule_12_det->coa_code)


                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();

                            //->toSql();

                            //echo "<pre>"; print_r(); exit;
                            if (!empty($schedule_12->closing_balance)) {
                                $bal = $schedule_12->closing_balance;
                            } else {
                                $bal = 0;
                            }
                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_12_det->account_name,
                                'coa_name' => $schedule_12_det->coa_name, 'total_amount' => $bal
                            );
                        } else {
                            $data['schedule_det'][] = array('account_name' => $schedule_12_det->account_name, 'coa_name' => $schedule_12_det->coa_name, 'total_amount' => '0');
                        }
                    }
                    // echo "<pre>"; print_r($data); exit;
                    $data['financial_year'] = $request->financial_year;

                    return view('mis-reports/schedule_12', $data);
                }

                if ($schedule_no[0] == '13') {

                    $data['schedule_details_13'] = Schedule_13::get();

                    foreach ($data['schedule_details_13'] as $schedule_13_det) {
                        if ($schedule_13_det->coa_code != '') {

                            $schedule_13 = Balance_posting::where('transaction_code', '=', $schedule_13_det->coa_code)
                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();
                            if (!empty($schedule_13->closing_balance)) {
                                $tot = $schedule_13->closing_balance;
                            } else {
                                $tot = 0;
                            }
                            //echo "<pre>"; print_r(); exit;

                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_13_det->account_name,
                                'total_amount' => $tot, 'tot_type' => $schedule_13_det->type
                            );
                        } else {
                            if (!empty($schedule_13_det->type)) {
                                $type = $schedule_13_det->type;
                            } else {
                                $type = '';
                            }

                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_13_det->account_name,
                                'total_amount' => '0', 'tot_type' => $type
                            );
                        }
                    }
                    // echo "<pre>"; print_r($data['schedule_det']); exit;
                    // dd($data['schedule_det']);
                    $data['financial_year'] = $request->financial_year;
                    return view('mis-reports/schedule_13', $data);
                }

                if ($schedule_no[0] == '15') {
                    $data['schedule_details_15'] = Schedule_15::get();

                    foreach ($data['schedule_details_15'] as $schedule_15_det) {
                        if ($schedule_15_det->coa_code != '') {

                            $schedule_15 = Balance_posting::where('transaction_code', '=', trim($schedule_15_det->coa_code))


                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();

                            //->toSql();
                            //print_r($schedule_07->closing_balance);exit;
                            //echo "<pre>"; print_r(); exit;
                            if (!empty($schedule_15->closing_balance)) {
                                $bal = $schedule_15->closing_balance;
                            } else {
                                $bal = 0;
                            }
                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_15_det->account_name,
                                'total_amount' => $bal
                            );
                        } else {
                            $data['schedule_det'][] = array('account_name' => $schedule_15_det->account_name,  'total_amount' => '0');
                        }
                    }
                    // echo "<pre>"; print_r($data); exit;
                    $data['financial_year'] = $request->financial_year;
                    return view('mis-reports/schedule_15', $data);
                }


                if ($schedule_no[0] == '17') {
                    $data['schedule_details_17'] = DB::table('schedule_17')->get();

                    foreach ($data['schedule_details_17'] as $schedule_17_det) {
                        if ($schedule_17_det->coa_code != '') {

                            $schedule_17 = Balance_posting::where('transaction_code', '=', $schedule_17_det->coa_code)


                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();

                            //->toSql();

                            //echo "<pre>"; print_r(); exit;
                            if (!empty($schedule_17->closing_balance)) {
                                $bal = $schedule_17->closing_balance;
                            } else {
                                $bal = 0;
                            }
                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_17_det->account_name,
                                'coa_name' => $schedule_17_det->coa_name, 'total_amount' => $bal
                            );
                        } else {
                            $data['schedule_det'][] = array('account_name' => $schedule_17_det->account_name, 'coa_name' => $schedule_17_det->coa_name, 'total_amount' => '0');
                        }
                    }
                    // echo "<pre>"; print_r($data); exit;
                    $data['financial_year'] = $request->financial_year;
                    return view('mis-reports/schedule_17', $data);
                }


                if ($schedule_no[0] == '18') {
                    $data['schedule_details_18'] = DB::table('schedule_18')->get();

                    foreach ($data['schedule_details_18'] as $schedule_18_det) {
                        if ($schedule_18_det->coa_code != '') {

                            $schedule_18 = Balance_posting::where('transaction_code', '=', $schedule_18_det->coa_code)
                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();
                            //echo "<pre>"; print_r(); exit;
                            if (!empty($schedule_18->closing_balance)) {
                                $bal = $schedule_18->closing_balance;
                            } else {
                                $bal = 0;
                            }
                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_18_det->account_name,
                                'coa_name' => $schedule_18_det->coa_name, 'total_amount' => $bal
                            );
                        } else {
                            $data['schedule_det'][] = array('account_name' => $schedule_18_det->account_name, 'coa_name' => $schedule_18_det->coa_name, 'total_amount' => '0');
                        }
                    }

                    $data['financial_year'] = $request->financial_year;
                    return view('mis-reports/schedule_18', $data);
                }


                if ($schedule_no[0] == '19') {
                    $data['schedule_details_19'] = DB::table('schedule_19')->get();

                    foreach ($data['schedule_details_19'] as $schedule_19_det) {
                        if ($schedule_19_det->coa_code != '') {
                            $schedule_19 =  DB::table('balance_posting')


                                ->where('transaction_code', '=', $schedule_19_det->coa_code)
                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();
                            if (!empty($schedule_19->closing_balance)) {
                                $bal = $schedule_19->closing_balance;
                            } else {
                                $bal = 0;
                            }
                            $data['schedule_det'][] = array(
                                'sl_no' => $schedule_19_det->sl_no,
                                'account_name' => $schedule_19_det->account_name, 'coa_name' => '',
                                'total_amount' => $bal
                            );
                        } else {
                            $data['schedule_det'][] =
                                array(
                                    'sl_no' => $schedule_19_det->sl_no,
                                    'account_name' => $schedule_19_det->account_name, 'coa_name' => '',
                                    'total_amount' => '0'
                                );
                        }
                    }
                    // echo "<pre>"; print_r($data['schedule_det']);exit;
                    // exit;
                    $data['financial_year'] = $request->financial_year;
                    return view('mis-reports/schedule_19', $data);
                }

                if ($schedule_no[0] == '22') {
                    $data['schedule_details_22'] = DB::table('schedule_22')->get();

                    foreach ($data['schedule_details_22'] as $schedule_22_det) {
                        if ($schedule_22_det->coa_code != '') {

                            $schedule_22 = DB::table('balance_posting')


                                ->where('transaction_code', '=', $schedule_22_det->coa_code)
                                ->where('financial_year', '=', $request->financial_year)
                                ->orderBy('id', 'desc')
                                ->first();
                            if (!empty($schedule_22->closing_balance)) {
                                $bal = $schedule_22->closing_balance;
                            } else {
                                $bal = 0;
                            }
                            //echo "<pre>"; print_r(); exit;

                            $data['schedule_det'][] = array(
                                'account_name' => $schedule_22_det->account_name,
                                'coa_name' => $schedule_22_det->coa_name, 'total_amount' =>  $bal
                            );
                        } else {
                            $data['schedule_det'][] = array('account_name' => $schedule_22_det->account_name, 'coa_name' => $schedule_22_det->coa_name, 'total_amount' => '0');
                        }
                    }
                    // echo "<pre>"; print_r($data); exit;
                    // dd($data['schedule_det']);
                    $data['financial_year'] = $request->financial_year;
                    return view('mis-reports/schedule_22', $data);
                }
            }
            // echo "<pre>"; print_r($data['currentyear_expense_list']);

            // exit;

            if ($request->party_name == '09') {

                $data['schedule_details_09'] = DB::table('schedule_09')->get();

                foreach ($data['schedule_details_09'] as $schedule_09_det) {
                    if ($schedule_09_det->coa_code != '') {

                        $schedule_09 = Balance_posting::where('transaction_code', '=', $schedule_09_det->coa_code)
                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();
                        if (!empty($schedule_09->closing_balance)) {
                            $tot = $schedule_09->closing_balance;
                        } else {
                            $tot = 0;
                        }
                        //echo "<pre>"; print_r(); exit;

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_09_det->account_name,
                            'total_amount' => $tot, 'tot_type' => $schedule_09_det->type
                        );
                    } else {
                        if (!empty($schedule_09_det->type)) {
                            $type = $schedule_09_det->type;
                        } else {
                            $type = '';
                        }

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_09_det->account_name,
                            'total_amount' => '0', 'tot_type' => $type
                        );
                    }
                }
                // echo "<pre>"; print_r($data['schedule_det']); exit;
                // dd($data['schedule_det']);
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_09', $data);
            }
            if ($request->party_name == '11') {
                $data['schedule_details_11'] = DB::table('schedule_11')->get();

                foreach ($data['schedule_details_11'] as $schedule_11_det) {
                    if ($schedule_11_det->coa_code != '') {

                        $schedule_11 = Balance_posting::where('transaction_code', '=', $schedule_11_det->coa_code)
                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();
                        if (!empty($schedule_11->closing_balance)) {
                            $tot = $schedule_11->closing_balance;
                        } else {
                            $tot = 0;
                        }
                        //echo "<pre>"; print_r(); exit;

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_11_det->account_name,
                            'total_amount' => $tot, 'tot_type' => $schedule_11_det->type
                        );
                    } else {
                        if (!empty($schedule_11_det->type)) {
                            $type = $schedule_11_det->type;
                        } else {
                            $type = '';
                        }

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_11_det->account_name,
                            'total_amount' => '0', 'tot_type' => $type
                        );
                    }
                }
                // echo "<pre>"; print_r($data['schedule_det']); exit;
                // dd($data['schedule_det']);
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_11', $data);
            }
            if ($request->party_name == '14') {
                $data['schedule_details_14'] = DB::table('schedule_14')->get();

                foreach ($data['schedule_details_14'] as $schedule_14_det) {
                    if ($schedule_14_det->coa_code != '') {

                        $schedule_14 = Balance_posting::where('transaction_code', '=', $schedule_14_det->coa_code)
                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();
                        if (!empty($schedule_14->closing_balance)) {
                            $tot = $schedule_14->closing_balance;
                        } else {
                            $tot = 0;
                        }
                        //echo "<pre>"; print_r(); exit;

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_14_det->account_name,
                            'total_amount' => $tot
                        );
                    } else {
                        $data['schedule_det'][] = array('account_name' => $schedule_14_det->account_name,  'total_amount' => '0');
                    }
                }
                // echo "<pre>"; print_r($data); exit;
                // dd($data['schedule_det']);
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_14', $data);
            }
            if ($request->party_name == '16') {
                $data['schedule_details_16'] = DB::table('schedule_16')->get();

                foreach ($data['schedule_details_16'] as $schedule_16_det) {
                    if ($schedule_16_det->coa_code != '') {

                        $schedule_16 = Balance_posting::where('transaction_code', '=', $schedule_16_det->coa_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();

                        //->toSql();

                        //echo "<pre>"; print_r(); exit;
                        if (!empty($schedule_16->closing_balance)) {
                            $bal = $schedule_16->closing_balance;
                        } else {
                            $bal = 0;
                        }
                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_16_det->account_name,
                            'coa_name' => $schedule_16_det->coa_name, 'total_amount' => $bal
                        );
                    } else {
                        $data['schedule_det'][] = array('account_name' => $schedule_16_det->account_name, 'coa_name' => $schedule_16_det->coa_name, 'total_amount' => '0');
                    }
                }
                // echo "<pre>"; print_r($data); exit;
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_16', $data);
            }
            if ($request->party_name == '20') {
                $data['schedule_details_20'] = DB::table('schedule_20')->get();

                foreach ($data['schedule_details_20'] as $schedule_20_det) {
                    if ($schedule_20_det->coa_code != '') {

                        $schedule_20 = Balance_posting::where('transaction_code', '=', $schedule_20_det->coa_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();

                        //->toSql();

                        //echo "<pre>"; print_r(); exit;
                        if (!empty($schedule_20->closing_balance)) {
                            $bal = $schedule_20->closing_balance;
                        } else {
                            $bal = 0;
                        }
                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_20_det->account_name,
                            'coa_name' => $schedule_20_det->coa_name, 'total_amount' => $bal
                        );
                    } else {
                        $data['schedule_det'][] = array('account_name' => $schedule_20_det->account_name, 'coa_name' => $schedule_20_det->coa_name, 'total_amount' => '0');
                    }
                }
                // echo "<pre>"; print_r($data); exit;
                $data['financial_year'] = $request->financial_year;


                return view('mis-reports/schedule_20', $data);
            }
            if ($request->party_name == '21') {


                $data['schedule_details_21'] = DB::table('schedule_21')->get();

                foreach ($data['schedule_details_21'] as $schedule_21_det) {
                    if ($schedule_21_det->coa_code != '') {

                        $schedule_21 = Balance_posting::where('transaction_code', '=', $schedule_21_det->coa_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();

                        //->toSql();

                        //echo "<pre>"; print_r(); exit;
                        if (!empty($schedule_21->closing_balance)) {
                            $bal = $schedule_21->closing_balance;
                        } else {
                            $bal = 0;
                        }
                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_21_det->account_name,
                            'coa_name' => $schedule_21_det->coa_name, 'total_amount' => $bal
                        );
                    } else {
                        $data['schedule_det'][] = array('account_name' => $schedule_21_det->account_name, 'coa_name' => $schedule_21_det->coa_name, 'total_amount' => '0');
                    }
                }
                // echo "<pre>"; print_r($data); exit;
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_21', $data);
            }
        } else {
            return redirect('/');
        }
    }


    public function viewBalanceSchedules()
    {
        if (!empty(Session::get('admin'))) {

            $schedules = Bs_schedule_master::get();
            return view('mis-reports/get-balance-schedules', compact('schedules'));
        } else {
            return redirect('/');
        }
    }

    public function viewBalanceScheduleReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            // dd($request);
            $data['start_year'] = date('Y');
            $data['end_year'] = date('Y') + 1;

            $financial_year = date('Y') + 1;
            $start_year = date("Y-04-01");
            $end_year = date("$financial_year-03-31");

            $data['currentyear_income_list'] = array();
            $data['currentyear_expense_list'] = array();

            if ($request->party_name == '01') {
                $data['grant_sum'] = Received_voucher_entry::select(Received_voucher_entry::raw('sum(total_amt) as grant_sum_amt'))
                    ->where('bill_status', '=', 'received')
                    ->where('account_head_id', 'LIKE', '10/001' . '%')
                    ->whereNotNull('transaction_code')
                    ->whereBetween('created_at', [$start_year, $end_year])
                    //->toSql();
                    ->get();

                return view('mis-reports/schedule_01', $data);
            }

            if ($request->party_name == '03') {

                $data['schedule_details_03'] = DB::table('schedule_03')->get();

                foreach ($data['schedule_details_03'] as $schedule_03_det) {
                    if ($schedule_03_det->coa_code != '') {

                        $schedule_03 = Balance_posting::where('transaction_code', '=', $schedule_03_det->coa_code)
                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();
                        if (!empty($schedule_03->closing_balance)) {
                            $tot = $schedule_03->closing_balance;
                        } else {
                            $tot = 0;
                        }
                        //echo "<pre>"; print_r(); exit;

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_03_det->account_name,
                            'total_amount' => $tot, 'tot_type' => $schedule_03_det->type
                        );
                    } else {
                        if (!empty($schedule_03_det->type)) {
                            $type = $schedule_03_det->type;
                        } else {
                            $type = '';
                        }

                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_03_det->account_name,
                            'total_amount' => '0', 'tot_type' => $type
                        );
                    }
                }
                // echo "<pre>"; print_r($data['schedule_det']); exit;
                // dd($data['schedule_det']);
                $data['financial_year'] = $request->financial_year;
                return view('mis-reports/schedule_3', $data);
            }

            if ($request->party_name == '07') {
                $data['schedule_details_07'] = DB::table('schedule_07')->get();

                foreach ($data['schedule_details_07'] as $schedule_07_det) {
                    if ($schedule_07_det->coa_code != '') {

                        $schedule_07 = Balance_posting::where('transaction_code', '=', trim($schedule_07_det->coa_code))


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();

                        //->toSql();
                        //print_r($schedule_07->closing_balance);exit;
                        //echo "<pre>"; print_r(); exit;
                        if (!empty($schedule_07->closing_balance)) {
                            $bal = $schedule_07->closing_balance;
                        } else {
                            $bal = 0;
                        }
                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_07_det->account_name,
                            'total_amount' => $bal
                        );
                    } else {
                        $data['schedule_det'][] = array('account_name' => $schedule_07_det->account_name,  'total_amount' => '0');
                    }
                }
                // echo "<pre>"; print_r($data); exit;
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_07', $data);
            }

            if ($request->party_name == '08') {

                $data['schedule_details_08'] = DB::table('schedule_08')->get();

                foreach ($data['schedule_details_08'] as $schedule_08_det) {
                    if ($schedule_08_det->coa_code != '') {

                        $schedule_08 = Balance_posting::where('transaction_code', '=', $schedule_08_det->coa_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();

                        //->toSql();
                        if (!empty($schedule_08->closing_balance)) {
                            $bal = $schedule_08->closing_balance;
                        } else {
                            $bal = 0;
                        }
                        //echo "<pre>"; print_r(); exit;
                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_08_det->account_name,
                            'total_amount' => $bal
                        );
                    } else {
                        $data['schedule_det'][] = array(
                            'account_name' => $schedule_08_det->account_name,
                            'total_amount' => '0'
                        );
                    }
                }

                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_8', $data);
            }


            if ($request->party_name == '02') {
                return view('mis-reports/schedule_02', $data);
            }
            if ($request->party_name == '04') {
                $data['financial_year'] = $request->financial_year;

                return view('mis-reports/schedule_04', $data);
            }
            if ($request->party_name == '05') {
                return view('mis-reports/schedule_05', $data);
            }
            if ($request->party_name == '06') {
                return view('mis-reports/schedule_06', $data);
            }
            if ($request->party_name == '13') {
                return view('mis-reports/schedule_13', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function viewIncomeSchedules()
    {
        if (!empty(Session::get('admin'))) {

            $schedules = Schedule_master::get();
            return view('mis-reports/get-income-schedules', compact('schedules'));
        } else {
            return redirect('/');
        }
    }

    public function getIncomeSummaryReport()
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
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('mis-reports/get-income-summary-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewIncomeSummaryReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            $financial_year = date('Y') + 1;
            $start_year = date("Y-04-01");
            $end_year = date("$financial_year-03-31");

            $schedules = DB::table('schedule_master')->get();

            $sum_amt_income = 0;
            $sum_amt_expense = 0;
            foreach ($schedules as $schedule) {
                $income_amount_total = DB::table('payment_rcvd_dtl')
                    ->where('payment_status', 'Received')
                    ->where('account_code', 'LIKE', $schedule->schedule . '%')
                    ->whereBetween('payment_rcv_date', [$start_year, $end_year])
                    ->select(DB::raw('sum(net_amt) as total_amt'))
                    ->get();

                // echo "<pre>"; print_r($income_amount_total); exit;
                $sum_amt_income += $income_amount_total[0]->total_amt;

                $expense_amount_total = DB::table('payment_dtl')
                    ->leftJoin('voucher_entry', 'payment_dtl.voucher_id', '=', 'voucher_entry.voucher_no')
                    ->where('payment_dtl.payment_status', 'Paid')
                    ->where('voucher_entry.account_head_id', 'LIKE', $schedule->schedule . '%')
                    ->whereBetween('payment_dtl.payment_release_date', [$start_year, $end_year])
                    ->select(DB::raw('sum(payment_dtl.payment_amount) as total_amt'))
                    ->get();

                $sum_amt_expense += $expense_amount_total[0]->total_amt;

                $sum_amt = $sum_amt_income - $sum_amt_expense;
            }
            // echo "<pre>"; print_r($sum_amt); exit;


            // echo "<pre>"; print_r($income_amount_total); exit;

            return view('mis-reports/income-summary-report', compact('sum_amt'));
        } else {
            return redirect('/');
        }
    }




    public function balanceSheetView()
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
            } catch (Exception $e) {

                return $e->getMessage();
            }

            return view('mis-reports/get-balance-sheet', $data);
        } else {
            return redirect('/');
        }
    }

    public function balanceSheetReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            //echo "<pre>"; print_r($request->financial_year); exit;
            $getyear_range = explode("-", $request->financial_year);
            $start_year = date("$getyear_range[0]-04-01");
            $end_year = date("$getyear_range[1]-03-31");

            try {



                $income_account_heads = DB::table('bs_schedule_master')->where('particular_type', 'income')->get();

                foreach ($income_account_heads as $income_account_head) {

                    $income = DB::table('balance_posting')


                        ->where('transaction_code', 'LIKE', $income_account_head->schedule . '/%')

                        ->where('financial_year', '=', $request->financial_year)


                        ->groupBy('transaction_code')
                        ->get();

                    $tolam = 0;
                    foreach ($income as $value) {

                        $schedule = DB::table('balance_posting')

                            ->where('transaction_code', '=', $value->transaction_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();


                        $tolam += $schedule->closing_balance;
                    }





                    $data['currentyear_income_list'][] = array('schedule_code' => $income_account_head->schedule, 'schedule_name' => $income_account_head->particulars, 'payable_amt' => $tolam);
                }
                // echo "<pre>"; print_r($data['currentyear_income_list']); exit;

                $account_expenses = DB::table('bs_schedule_master')->where('particular_type', 'expense')->get();

                foreach ($account_expenses as $expenses) {


                    $expense = DB::table('balance_posting')


                        ->where('transaction_code', 'LIKE', $expenses->schedule . '/%')

                        ->where('financial_year', '=', $request->financial_year)

                        ->groupBy('transaction_code')
                        ->get();
                    //

                    $tolamt = 0;
                    foreach ($expense as $value) {

                        $schedule = DB::table('balance_posting')

                            ->where('transaction_code', '=', $value->transaction_code)


                            ->where('financial_year', '=', $request->financial_year)
                            ->orderBy('id', 'desc')
                            ->first();


                        $tolamt += $schedule->closing_balance;
                    }


                    $data['currentyear_expenditure_list'][] = array('schedule_code' => $expenses->schedule, 'schedule_name' => $expenses->particulars, 'payable_amt' => $tolamt);
                }






                //echo "<pre>"; print_r($data['currentyear_expenditure_list']); exit;


                // exit;

            } catch (Exception $e) {
                return $e->getMessage();
            }
            // $data['income_expenditure']=array(4,9,10,11,12,13,14,15,16,17,18,19,20,21,22);
            //$data['fromyear']=$start_year;
            $data['toyear'] = $getyear_range[1];

            return view('mis-reports/balance-sheet-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getContraVoucherReport()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/get-contra-voucher');
        } else {
            return redirect('/');
        }
    }

    public function viewContraVoucherReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['start'] = $request->from_date;
            $data['end'] = $request->to_date;

            $payment_contralist = Voucher_entry::where('voucher_type', '=', 'contra')
                ->whereDate('bill_booking_date', '>=', $request->from_date)
                ->whereDate('bill_booking_date', '<=', $request->to_date)
                ->groupBy('voucher_no')
                ->get();

            $data['contra_list'] = array();

            foreach ($payment_contralist as $paycontra) {

                $entrylist = Voucher_entry::where('voucher_no', '=', $paycontra->voucher_no)
                    ->where('account_tool', '=', 'credit')
                    ->orderBy('id', 'asc')
                    ->first();

                $credit_account_name = Company_bank::where('id', '=', $entrylist->bank_branch_id)->first();

                if (!empty($credit_account_name)) {

                    $cr_account = $credit_account_name->bank_name;
                } else {
                    $credit_account_name = Coa_master::where('coa_code', '=', $entrylist->transaction_code)->first();
                    $cr_account = $credit_account_name->head_name;
                }

                $entrylistdebit = Voucher_entry::where('voucher_no', '=', $paycontra->voucher_no)
                    ->where('account_tool', '=', 'debit')
                    ->orderBy('id', 'asc')
                    ->first();

                $credit_account_name_debit = Company_bank::where('id', '=', $entrylistdebit->bank_branch_id)->first();

                if (!empty($credit_account_name_debit)) {

                    $dr_account = $credit_account_name_debit->bank_name;
                } else {
                    $credit_account_name = Coa_master::where('coa_code', '=', $entrylistdebit->transaction_code)->first();
                    $dr_account = $credit_account_name->head_name;
                }


                $data['contra_list'][] = array(
                    'booking_date' => $paycontra->bill_booking_date,
                    'voucher_no' => $paycontra->voucher_no, 'dr_account' => $dr_account,
                    'cr_account' => $cr_account, 'narration' => $paycontra->entry_remark, 'dr_amt' => $paycontra->payable_amt,
                    'cr_amt' => $paycontra->payable_amt
                );
            }
            //exit;
            return view('mis-reports/contra-voucher-report', $data);
        } else {
            return redirect('/');
        }
    }

    public function getCashbookReport()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/get-cashbook');
        } else {
            return redirect('/');
        }
    }


    public function viewCashbookReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {


            $data['fromdate'] = $request->from_date;
            $data['todate'] = $request->to_date;

            $cash_balance = DB::table('cash_balance')
                ->whereDate('created_at', '>=', $request->from_date)
                ->whereDate('created_at', '<=', $request->to_date)
                ->get();
            //echo "<pre>";print_r($cash_balance); exit;
            $data['cash_list'] = array();

            foreach ($cash_balance as $cashdtl) {

                $entrylist = DB::table('voucher_entry')

                    ->where('voucher_no', '=', $cashdtl->voucher_no)

                    ->orderBy('id', 'asc')
                    ->first();
                if (empty($entrylist)) {
                    $entrylist = DB::table('received_voucher_entry')

                        ->where('voucher_no', '=', $cashdtl->voucher_no)

                        ->orderBy('id', 'asc')
                        ->first();
                    $remark = $entrylist->remarks;
                } else {
                    $remark = $entrylist->entry_remark;
                }

                $credit_account_name = DB::table('company_bank')->where('account_code', '=', $entrylist->transaction_code)->first();

                if (!empty($credit_account_name)) {

                    $cr_account = $credit_account_name->bank_name;
                } else {
                    $credit_account_name = DB::table('coa_master')->where('coa_code', '=', $entrylist->transaction_code)->first();
                    $cr_account = $credit_account_name->head_name;
                }


                $data['contra_list'][] = array(
                    'booking_date' => $cashdtl->created_at,
                    'vouchertype' => $entrylist->voucher_type,
                    'voucher_no' => $entrylist->voucher_no,
                    'cr_account' => $cr_account,
                    'narration' => $remark, 'income_amt' => $cashdtl->income,
                    'expense_amt' => $cashdtl->expense, 'balance_amt' => $cashdtl->balance_amt
                );
            }

            $data['current_balance'] = DB::table('company_cash')
                ->first();

            return view('mis-reports/report-cashbook', $data);
        } else {
            return redirect('/');
        }
    }



    public function getPettyCashReport()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/get-pettycash');
        } else {
            return redirect('/');
        }
    }

    public function viewPettyCashReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $data['fromdate'] = $request->from_date;
            $data['todate'] = $request->to_date;

            $petty_balance = Petty_balance::whereDate('created_at', '>=', $request->from_date)
                ->whereDate('created_at', '<=', $request->to_date)
                ->get();

            $data['petty_list'] = array();

            foreach ($petty_balance as $pettydtl) {

                $entrylist = Voucher_entry::where('voucher_no', '=', $pettydtl->voucher_no)

                    ->orderBy('id', 'asc')
                    ->first();
                if (empty($entrylist)) {
                    $entrylist = Received_voucher_entry::where('voucher_no', '=', $cashdtl->voucher_no)

                        ->orderBy('id', 'asc')
                        ->first();
                    $remark = $entrylist->remarks;
                } else {
                    $remark = $entrylist->entry_remark;
                }

                //echo "<pre>";print_r($entrylist); exit;
                $credit_account_name = Company_bank::where('id', '=', $entrylist->transaction_code)->first();
                if (!empty($credit_account_name)) {

                    $cr_account = $credit_account_name->bank_name;
                } else {
                    $credit_account_name = Coa_master::where('coa_code', '=', $entrylist->transaction_code)->first();
                    $cr_account = $credit_account_name->head_name;
                }
                $data['petty_list'][] = array(
                    'booking_date' => $pettydtl->created_at,
                    'vouchertype' => $entrylist->voucher_type,
                    'voucher_no' => $entrylist->voucher_no,
                    'cr_account' => $cr_account, 'narration' => $remark,
                    'income_amt' => $pettydtl->income, 'expense_amt' => $pettydtl->expense,
                    'balance_amt' => $pettydtl->balance_amt
                );
            }


            $data['current_balance'] = Company_petty::first();
            //echo "<pre>"; print_r($data); exit;
            return view('mis-reports/report-pettycash', $data);
        } else {
            return redirect('/');
        }
    }

    public function receiptPaymentView()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/vw-receipt-payment-report');
        } else {
            return redirect('/');
        }
    }


    public function receiptPaymentReport(Request $request)
    {

        if (!empty(Session::get('admin'))) {

            // dd($request);

            $financial_year = date('Y') + 1;
            $start_year = date("Y-04-01");
            $end_year = date("$financial_year-03-31");

            $data['payment'] = DB::table('payment_dtl')->select(DB::raw('sum(payment_amount) as total_payment'))->get();
            $data['receipt'] = DB::table('payment_rcvd_dtl')->select(DB::raw('sum(net_amt) as total_receipt'))->get();
            $data['stipend_graduate'] = DB::table('stipend')->select(DB::raw('sum(graduate) as total_graduate'))->get();
            $data['stipend_diploma'] = DB::table('stipend')->select(DB::raw('sum(diploma) as total_diploma'))->get();
            //echo "<pre>"; print_r($data['payment']); print_r($data['receipt']); exit;

            return view('mis-reports/receipt-payment-report', $data);
        } else {
            return redirect('/');
        }
    }



    public function establishmentReceiptPayment()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/vw-establishment-payment-receipt');
        } else {
            return redirect('/');
        }
    }


    public function establishmentReceiptPaymentReport(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $getyear_range = explode("-", $request->financial_year);
            $data['start_year'] = date("$getyear_range[0]");
            $data['end_year'] = date("$getyear_range[1]");

            $start_financial_year = date("$getyear_range[0]-04-01");
            $to_financial_year = date("$getyear_range[1]-03-31");

            $data['receive_cash_in_hand'] = DB::table('cash_balance')
                ->select(DB::raw('sum(income) as closing_amt'))
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();

            $data['receive_saving_balance'] = DB::table('bank_balance')
                ->where('bank_branch_id', '=', 1)
                ->select(DB::raw('sum(income) as receive_saving_amt'))
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();


            $data['receive_current_balance'] = DB::table('bank_balance')
                ->where('bank_branch_id', '=', 2)
                ->select(DB::raw('sum(income) as receive_current_amt'))
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();

            $data['grant_in_aid'] = DB::table('received_voucher_entry')
                ->select(DB::raw('sum(total_amt) as grant_in_aid_amt'))
                ->where('transaction_code', 'LIKE', '10/001' . '%')
                ->where('bill_status', '=', 'Received')
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();

            $data['saving_bank_account'] = DB::table('received_voucher_entry')
                ->select(DB::raw('sum(total_amt) as saving_account_amt'))
                ->where('transaction_code', 'LIKE', '12/001' . '%')
                ->where('bill_status', '=', 'Received')
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();

            $data['other_income'] = DB::table('received_voucher_entry')
                ->select(DB::raw('sum(total_amt) as other_income_amt'))
                ->where('transaction_code', 'LIKE', '15/001' . '%')
                ->where('bill_status', '=', 'Received')
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();


            $data['deposit_advance'] = DB::table('received_voucher_entry')
                ->select(DB::raw('sum(total_amt) as deposit_advance_amt'))
                ->where('transaction_code', 'LIKE', '13/004' . '%')
                ->where('bill_status', '=', 'Received')
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();
            $data['other_receipt'] = DB::table('received_voucher_entry')
                ->select(DB::raw('sum(total_amt) as other_receipt_amt'))
                ->where('transaction_code', 'LIKE', '13/001' . '%')
                ->where('bill_status', '=', 'Received')
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();

            $data['establishment_expenses'] = DB::table('voucher_entry')
                ->select(DB::raw('sum(payable_amt) as establishment_expenses_amt'))
                ->where('bill_status', '=', 'Paid')
                ->where('transaction_code', 'LIKE', '15' . '%')
                ->whereBetween('bill_booking_date', [$start_financial_year, $to_financial_year])
                ->get();

            $data['administrative_expenses'] = DB::table('voucher_entry')
                ->select(DB::raw('sum(payable_amt) as administrative_expenses_amt'))
                ->where('bill_status', '=', 'Paid')
                ->where('transaction_code', 'LIKE', '17' . '%')
                ->whereBetween('bill_booking_date', [$start_financial_year, $to_financial_year])
                ->get();

            $data['transport_expenses'] = DB::table('voucher_entry')
                ->select(DB::raw('sum(payable_amt) as transport_expenses_amt'))
                ->where('bill_status', '=', 'Paid')
                ->where('transaction_code', 'LIKE', '18' . '%')
                ->whereBetween('bill_booking_date', [$start_financial_year, $to_financial_year])
                ->get();

            $data['repairs_expenses'] = DB::table('voucher_entry')
                ->select(DB::raw('sum(payable_amt) as repairs_expenses_amt'))
                ->where('bill_status', '=', 'Paid')
                ->where('transaction_code', 'LIKE', '19' . '%')
                ->whereBetween('bill_booking_date', [$start_financial_year, $to_financial_year])
                ->get();
            $data['period_expenses'] = DB::table('voucher_entry')
                ->select(DB::raw('sum(payable_amt) as period_expenses_amt'))
                ->where('bill_status', '=', 'Paid')
                ->where('transaction_code', 'LIKE', '22/001' . '%')
                ->whereBetween('bill_booking_date', [$start_financial_year, $to_financial_year])
                ->get();

            $data['other_payment'] = DB::table('voucher_entry')
                ->select(DB::raw('sum(payable_amt) as other_payment_amt'))
                ->where('bill_status', '=', 'Paid')
                ->where('transaction_code', 'LIKE', '15' . '%')
                ->whereBetween('bill_booking_date', [$start_financial_year, $to_financial_year])
                ->get();

            $data['payment_cash_in_hand'] = DB::table('cash_balance')
                ->select(DB::raw('sum(expense) as closing_amt'))
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();

            $data['payment_saving_balance'] = DB::table('bank_balance')
                ->where('bank_branch_id', '=', 1)
                ->select(DB::raw('sum(expense) as closing_amt'))
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();


            $data['payment_current_balance'] = DB::table('bank_balance')
                ->where('bank_branch_id', '=', 2)
                ->select(DB::raw('sum(expense) as closing_amt'))
                ->whereBetween('created_at', [$start_financial_year, $to_financial_year])
                ->get();
            $data['financial_year'] = $request->financial_year;
            return view('mis-reports/establishment-payment-receipt-report', $data);
        } else {
            return redirect('/');
        }
    }


    public function consoliatedBalancesheetView()
    {
        if (!empty(Session::get('admin'))) {
            return view('mis-reports/vw-consoliated-balancesheet');
        } else {
            return redirect('/');
        }
    }

    public function consoliatedBalancesheetReport()
    {
        if (!empty(Session::get('admin'))) {

            return view('mis-reports/report-consoliated-balancesheet');
        } else {
            return redirect('/');
        }
    }

    public function getBankName($bank_name)
    {
        if (!empty(Session::get('admin'))) {

            $company_branch_list = Company_bank::where('bank_name', '=', $bank_name)->get();
            echo json_encode($company_branch_list);
        } else {
            return redirect('/');
        }
    }
}
