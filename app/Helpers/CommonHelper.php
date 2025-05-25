<?php
namespace App\Helpers;

use App\Models\IncomeTax\ItaxSaving;
use App\Models\IncomeTax\Itax_type_master;
use App\Models\IncomeTax\I_tax_rate_slab_master;
use App\Models\Masters\ItaxRate;
use App\Models\Payroll\PayrollDummy;
use App\Models\Payroll\Payroll_detail;
use App\Models\Payroll\YearlyEmployeeBonus;
use App\Models\Payroll\YearlyEmployeeLencHta;

class CommonHelper
{

    public static function getPaycardDetails($emp_code, $monthyr)
    {

        $payroll_details = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
            ->where('payroll_details.month_yr', '=', $monthyr)
            ->where('payroll_details.employee_id', '=', $emp_code)
            ->select('payroll_details.*', 'employees.old_emp_code')
            ->first();

        $payroll_dummies = PayrollDummy::leftJoin('employees', 'payroll_dummies.employee_id', '=', 'employees.emp_code')
            ->where('payroll_dummies.month_yr', '=', $monthyr)
            ->where('payroll_dummies.employee_id', '=', $emp_code)
            ->select('payroll_dummies.*', 'employees.old_emp_code')
            ->first();

        $bonus = YearlyEmployeeBonus::join('employees', 'employees.emp_code', '=', 'yearly_employee_bonuses.emp_code')
            ->select('employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code', 'yearly_employee_bonuses.*')
            ->where('yearly_employee_bonuses.year', '=', $monthyr)
        //->where('yearly_employee_bonuses.status', '=', 'process')
            ->where('yearly_employee_bonuses.emp_code', '=', $emp_code)
            ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
            ->first();

        $encashments = YearlyEmployeeLencHta::join('employees', 'employees.emp_code', '=', 'yearly_employee_lenc_htas.emp_code')
            ->select('employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code', 'yearly_employee_lenc_htas.*')
            ->where('yearly_employee_lenc_htas.year', '=', $monthyr)
        //->where('yearly_employee_lenc_htas.status', '=', 'process')
            ->where('yearly_employee_lenc_htas.emp_code', '=', $emp_code)
           ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
            ->first();

        $response = ['payroll' => $payroll_details, 'dimmies' => $payroll_dummies, 'bonus_rs' => $bonus, 'encashment_rs' => $encashments];
        return json_encode($response);

    }

    public static function getItaxPayrollDetails($emp_code, $financial_year)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];

        $start_date = date('Y-m-d', strtotime($from_year . '-04-01'));
        $end_date = date('Y-m-d', strtotime($to_year . '-03-31'));

        $m = $start_date;

        $tot_gross_salary = 0;
        $tot_basic = 0;
        $tot_da = 0;
        $tot_vda = 0;
        $tot_pf = 0;
        $tot_hra = 0;
        $tot_ptax = 0;
        $tot_bonus = 0;
        $tot_hta = 0;
        $tot_leave_enc = 0;
        $tot_commission = 0;
        $tot_othperks = 0;
        $tot_medreimbersement = 0;
        $tot_others_alw = 0;
        $tot_over_time = 0;
        $tot_conveyence = 0;
        $tot_incometax_deducted = 0;

        //dd($m);

        while (date('Ym', strtotime($m)) <= date('Ym', strtotime($end_date))) {
            $monthyr = date('m/Y', strtotime($m));
            $payroll_details = Payroll_detail::leftJoin('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->where('payroll_details.month_yr', '=', $monthyr)
                ->where('payroll_details.employee_id', '=', $emp_code)
                ->select('payroll_details.*', 'employees.old_emp_code')
                ->first();

            $bonus = YearlyEmployeeBonus::join('employees', 'employees.emp_code', '=', 'yearly_employee_bonuses.emp_code')
                ->select('employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code', 'yearly_employee_bonuses.*')
                ->where('yearly_employee_bonuses.year', '=', $monthyr)
            //->where('yearly_employee_bonuses.status', '=', 'process')
                ->where('yearly_employee_bonuses.emp_code', '=', $emp_code)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->first();

            $encashments = YearlyEmployeeLencHta::join('employees', 'employees.emp_code', '=', 'yearly_employee_lenc_htas.emp_code')
                ->select('employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code', 'yearly_employee_lenc_htas.*')
                ->where('yearly_employee_lenc_htas.year', '=', $monthyr)
            //->where('yearly_employee_lenc_htas.status', '=', 'process')
                ->where('yearly_employee_lenc_htas.emp_code', '=', $emp_code)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                ->first();

            // dd($payroll_details);
            if (isset($payroll_details->emp_gross_salary)) {
                $tot_gross_salary = (float) str_replace(',', '', $tot_gross_salary) + (float) str_replace(',', '', $payroll_details->emp_gross_salary);
            }
            if (isset($payroll_details->emp_hra)) {
                $tot_hra = (float) str_replace(',', '', $tot_hra) + (float) str_replace(',', '', $payroll_details->emp_hra);
            }
            if (isset($payroll_details->emp_others_alw)) {
                $tot_others_alw = (float) str_replace(',', '', $tot_others_alw) + (float) str_replace(',', '', $payroll_details->emp_others_alw);
            }
            if (isset($payroll_details->emp_over_time)) {
                $tot_over_time = (float) str_replace(',', '', $tot_over_time) + (float) str_replace(',', '', $payroll_details->emp_over_time);
            }
            if (isset($payroll_details->emp_i_tax)) {
                $tot_incometax_deducted = (float) str_replace(',', '', $tot_incometax_deducted) + (float) str_replace(',', '', $payroll_details->emp_i_tax);
            }
            if (isset($payroll_details->emp_basic_pay)) {
                $tot_basic = (float) str_replace(',', '', $tot_basic) + (float) str_replace(',', '', $payroll_details->emp_basic_pay);
            }
            if (isset($payroll_details->emp_da)) {
                $tot_da = (float) str_replace(',', '', $tot_da) + (float) str_replace(',', '', $payroll_details->emp_da);
            }
            if (isset($payroll_details->emp_vda)) {
                $tot_vda = (float) str_replace(',', '', $tot_vda) + (float) str_replace(',', '', $payroll_details->emp_vda);
            }
            if (isset($payroll_details->emp_conv)) {
                $tot_conveyence = (float) str_replace(',', '', $tot_conveyence) + (float) str_replace(',', '', $payroll_details->emp_conv);
            }
            if (isset($payroll_details->emp_prof_tax)) {
                $tot_ptax = (float) str_replace(',', '', $tot_ptax) + (float) str_replace(',', '', $payroll_details->emp_prof_tax);
            }
            if (isset($payroll_details->emp_pf)) {
                $tot_pf = (float) str_replace(',', '', $tot_pf) + (float) str_replace(',', '', $payroll_details->emp_pf);
            }
            if (isset($bonus->bonus)) {
                $tot_bonus = (float) str_replace(',', '', $tot_bonus) + (float) str_replace(',', '', $bonus->bonus);
            }
            if (isset($encashments->hta)) {
                $tot_hta = (float) str_replace(',', '', $tot_hta) + (float) str_replace(',', '', $encashments->hta);
            }
            if (isset($encashments->leave_enc)) {
                $tot_leave_enc = (float) str_replace(',', '', $tot_leave_enc) + (float) str_replace(',', '', $encashments->leave_enc);
            }
            if (isset($encashments->other_perks)) {
                $tot_othperks = (float) str_replace(',', '', $tot_othperks) + (float) str_replace(',', '', $encashments->other_perks);
            }
            if (isset($encashments->medical_reimbersement)) {
                $tot_medreimbersement = (float) str_replace(',', '', $tot_medreimbersement) + (float) str_replace(',', '', $encashments->medical_reimbersement);
            }
            if (isset($encashments->commision)) {
                $tot_commission = (float) str_replace(',', '', $tot_commission) + (float) str_replace(',', '', $encashments->commision);
            }

            $m = date('Y-m-d', strtotime("+1 months", strtotime($m)));
        }

        $response = [
            'tot_salary' => $tot_gross_salary,
            'tot_basic' => $tot_basic,
            'tot_da' => $tot_da,
            'tot_vda' => $tot_vda,
            'tot_conveyence' => $tot_conveyence,
            'tot_incometax_deducted' => $tot_incometax_deducted,
            'tot_hra' => $tot_hra,
            'tot_others_alw' => $tot_others_alw,
            'tot_over_time' => $tot_over_time,
            'tot_ptax' => $tot_ptax,
            'tot_pf' => $tot_pf,
            'tot_bonus' => $tot_bonus,
            'tot_hta' => $tot_hta,
            'tot_leave_enc' => $tot_leave_enc,
            'tot_othperks' => $tot_othperks,
            'tot_medreimbersement' => $tot_medreimbersement,
            'tot_commission' => $tot_commission,
        ];

        //dd($response);
        return json_encode($response);

    }

    public static function getRefItaxRepo()
    {
        return [
            'HOUSE RENT RELIEF',
            'MEDICAL DEDUCTION',
            'INTEREST ON H.R.LOAN',
            'L.T.A',
            'N.S.C',
            'INTEREST ON N.S.C',
            'L.I.C',
            'HOUSE RENT PAID',
            'PUBLIC PROVIDENT FUND',
            'TAX SAVING BOND',
            'UNIT LIKED INSURANCE PLAN',
            'TUTION FEES',
            'REPAYMENT OF HOUSE LOAN',
            'U/S80CCC',
        ];
    }

    public static function getRefFormXVIRepo()
    {
        return [
            'L.I.C.',
            'P.P.F.',
            'U.L.I.P.',
            'N.S.C.',
            'Interest On N.S.C.',
            'Int. on H.Loan',
            'Repay of Housing Loan',
            'Tution Fees',
            'Tax Saving Bond',
            'Jiwan Surksha',
            'Mediclaim',
            'Handicapped',
        ];
    }

    public static function getStandardDeduction($financial_year, $gender)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];
        $assesment_year = ($from_year + 1) . '-' . ($to_year + 1);

        // $itaxSlab=I_tax_rate_slab_master::where('percentage', '=', 0)
        //         ->where('additional_amount', '=', 0)
        //         ->where('financial_year', 'LIKE', $assesment_year)
        //         //->where('gender', '=', $gender)
        //         ->first();

        $response = [
            //'itax_slab'=>$itaxSlab
            'itax_slab' => ['amount_to' => '50000'],
        ];

        //dd($response);
        return json_encode($response);

    }

    public static function getTaxPayableSlab($financial_year, $taxable_amount, $gender)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];
        $assesment_year = ($from_year + 1) . '-' . ($to_year + 1);

        $itaxSlabNoLimit = I_tax_rate_slab_master::where('financial_year', 'LIKE', $financial_year)
            ->where('no_upper_limit', '=', 'Y')
            ->first();

        //dd($itaxSlabNoLimit);
        if ($taxable_amount > $itaxSlabNoLimit->amount_from) {
            $itaxSlab = $itaxSlabNoLimit;
        } else {
            $itaxSlab = I_tax_rate_slab_master::whereRaw('? between amount_from and amount_to', [$taxable_amount])
                ->where('no_upper_limit', '=', 'N')
                ->where('financial_year', 'LIKE', $financial_year)
            //->where('gender', '=', $gender)
                ->first();
        }

        $response = [
            'itax_slab' => $itaxSlab,

        ];

        //dd($response);
        return json_encode($response);

    }

    public static function getItaxSavings($emp_code, $financial_year, $saving_type_desc)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];
        $assesment_year = ($from_year + 1) . '-' . ($to_year + 1);

        $itax_savings = ItaxSaving::join('saving_type_masters', 'saving_type_masters.id', '=', 'itax_savings.saving_type_id')
            ->select('itax_savings.*')
            ->where('itax_savings.financial_year', 'LIKE', $financial_year)
            ->where('itax_savings.emp_code', '=', $emp_code)
            ->where('saving_type_masters.income_tax_repo_ref', 'LIKE', $saving_type_desc)
            ->first();

        $response = [
            'itax_savings' => $itax_savings,
        ];

        //dd($response);
        return json_encode($response);

    }

    public static function getItaxType($financial_year, $tax_desc)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];
        $assesment_year = ($from_year + 1) . '-' . ($to_year + 1);

        $itax_type = Itax_type_master::where('itax_type_masters.financial_year', 'LIKE', $financial_year)
            ->where('itax_type_masters.tax_desc', 'LIKE', $tax_desc)
            ->first();

        $response = [
            'itax_type' => $itax_type,
        ];

        //dd($response);
        return json_encode($response);

    }

    public static function getFormXVISavings($emp_code, $financial_year, $saving_type_desc)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];
        $assesment_year = ($from_year + 1) . '-' . ($to_year + 1);

        $itax_savings = ItaxSaving::join('saving_type_masters', 'saving_type_masters.id', '=', 'itax_savings.saving_type_id')
            ->select('itax_savings.*')
            ->where('itax_savings.financial_year', 'LIKE', $financial_year)
            ->where('itax_savings.emp_code', '=', $emp_code)
            ->where('saving_type_masters.form_xvi_ref', 'LIKE', $saving_type_desc)
            ->first();

        $response = [
            'itax_savings' => $itax_savings,
        ];

        //dd($response);
        return json_encode($response);

    }

    public static function getEffectiveItaxRate($financial_year)
    {
        $fyear = explode('-', $financial_year);
        $from_year = $fyear[0];
        $to_year = $fyear[1];

        $datestring = $to_year . '-03-31';
        // Converting string to date
        $date = strtotime($datestring);
        //echo date("Y-m-t", $date);
        $last_paroll_month_date = date("Y-m-t", $date);

        $interest = ItaxRate::where('effective_from', '<=', $last_paroll_month_date)
            ->where('status', '=', 'active')
            ->orderBy('id', 'desc')
            ->first();

        if (!empty($interest)) {
            $response = ['surcharge' => $interest->surcharge, 'ecess' => $interest->ecess];
        } else {
            $response = ['surcharge' => '0', 'ecess' => '0'];
        }
        return json_encode($response);
    }
    /*
     * Function Name :  encrypt
     * Purpose       :  This function is use for encrypt a string.
     * Author        :  KB
     * Created Date  :
     * Input Params  :  string $value
     * Return Value  :  string
     */

    public static function encrypt($value)
    {
        $cipher = 'AES-128-ECB';
        $key = \Config::get('app.key');
        return openssl_encrypt($value, $cipher, $key);
    }

    /*
     * Function Name :  decrypt
     * Purpose       :  This function is use for decrypt the encrypted string.
     * Author        :  KB
     * Created Date  :
     * Input Params  :  string $value
     * Return Value  :  string
     */

    public static function decrypt($value)
    {
        $cipher = 'AES-128-ECB';
        $key = \Config::get('app.key');
        return openssl_decrypt($value, $cipher, $key);
    }

    /*
     * Function Name :  partialEmailidDisplay
     * Purpose       :  This function is use for hiding some characters of en email id.
     * Author        :  KB
     * Created Date  :
     * Input Params  :  string $value
     * Return Value  :  string
     */

    public static function partialEmailidDisplay($email)
    {
        $rightPartPos = strpos($email, '@');
        $leftPart = substr($email, 0, $rightPartPos);
        $displayChars = (strlen($leftPart) / 2);
        if ($displayChars < 1) {
            $displayChars = 1;
        }
        return substr($leftPart, 0, $displayChars) . '*******' . substr($email, $rightPartPos);
    }

    public static function encryptId($value)
    {
        // $hashids = new Hashids(\Config::get('app.key'));
        // return $hashids->encode($value);
        $cipher = 'AES-128-ECB';
        $key = \Config::get('app.key');
        return base64_encode(openssl_encrypt($value, $cipher, $key));
    }

    public static function decryptId($value)
    {
        // $hashids = new Hashids(\Config::get('app.key'));
        // return (count($decptid = $hashids->decode($value))? $decptid[0]: '');
        $cipher = 'AES-128-ECB';
        $key = \Config::get('app.key');
        return openssl_decrypt(base64_decode($value), $cipher, $key);
    }

    public static function getTaskType()
    {
        return [
            'Planned',
            'Unplanned',
        ];
    }
    public static function getTaskStatus()
    {
        return [
            'Pending',
            'In Process',
            'Complete',
        ];
    }
    public static function getTimesheetStatus()
    {
        return [
            'P' => 'Pending',
            'S' => 'Submitted',
            'A' => 'Approved',
            'R' => 'Rejected',
        ];
    }
}
