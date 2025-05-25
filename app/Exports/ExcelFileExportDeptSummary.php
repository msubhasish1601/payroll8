<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Attendance\Upload_attendence;
use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportDeptSummary implements FromCollection, WithHeadings
{
    private $month_yr;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr)
    {
        
        $this->month_yr = $month_yr;
        
    }
    public function collection()
    {
        $employee_rs = Employee::leftJoin('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
            ->select(
                'employees.emp_department',
                DB::raw('COALESCE(Sum(payroll_details.emp_basic_pay),0) as emp_basic_pay'),
                DB::raw('COALESCE(Sum(payroll_details.emp_da),0) as emp_da'),
                DB::raw('COALESCE(Sum(payroll_details.emp_vda),0) as emp_vda'),
                DB::raw('COALESCE(Sum(payroll_details.emp_hra),0) as emp_hra'),
                DB::raw('COALESCE(Sum(payroll_details.emp_prof_tax),0) as emp_prof_tax'),
                DB::raw('COALESCE(Sum(payroll_details.emp_others_alw),0) as emp_others_alw'),
                DB::raw('COALESCE(Sum(payroll_details.emp_tiff_alw),0) as emp_tiff_alw'),
                DB::raw('COALESCE(Sum(payroll_details.emp_conv),0) as emp_conv'),
                DB::raw('COALESCE(Sum(payroll_details.emp_medical),0) as emp_medical'),
                DB::raw('COALESCE(Sum(payroll_details.emp_misc_alw),0) as emp_misc_alw'),
                DB::raw('COALESCE(Sum(payroll_details.emp_over_time),0) as emp_over_time'),
                DB::raw('COALESCE(Sum(payroll_details.emp_bouns),0) as emp_bouns'),
                DB::raw('COALESCE(Sum(payroll_details.emp_co_op),0) as emp_co_op'),
                DB::raw('COALESCE(Sum(payroll_details.emp_pf),0) as emp_pf'),
                DB::raw('COALESCE(Sum(payroll_details.emp_pf_int),0) as emp_pf_int'),
                DB::raw('COALESCE(Sum(payroll_details.emp_apf),0) as emp_apf'),
                DB::raw('COALESCE(Sum(payroll_details.emp_i_tax),0) as emp_i_tax'),
                DB::raw('COALESCE(Sum(payroll_details.emp_insu_prem),0) as emp_insu_prem'),
                DB::raw('COALESCE(Sum(payroll_details.emp_pf_loan),0) as emp_pf_loan'),
                DB::raw('COALESCE(Sum(payroll_details.emp_esi),0) as emp_esi'),
                DB::raw('COALESCE(Sum(payroll_details.emp_adv),0) as emp_adv'),
                DB::raw('COALESCE(Sum(payroll_details.emp_absent_deduction),0) as emp_absent_deduction'),
                DB::raw('COALESCE(Sum(payroll_details.emp_hrd),0) as emp_hrd'),
                DB::raw('COALESCE(Sum(payroll_details.emp_furniture),0) as emp_furniture'),
                DB::raw('COALESCE(Sum(payroll_details.emp_misc_ded),0) as emp_misc_ded'),
                DB::raw('COALESCE(Sum(payroll_details.emp_leave_inc),0) as emp_leave_inc'),
                DB::raw('COALESCE(Sum(payroll_details.emp_hta),0) as emp_hta'),
                DB::raw('COALESCE(Sum(payroll_details.emp_gross_salary),0) as emp_gross_salary'),
                DB::raw('COALESCE(Sum(payroll_details.emp_total_deduction),0) as emp_total_deduction'),
                DB::raw('COALESCE(Sum(payroll_details.emp_net_salary),0) as emp_net_salary')
            )
            ->where('payroll_details.month_yr', '=', $this->month_yr)
            ->groupBy('employees.emp_department')
            ->orderBy('employees.emp_department', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        $total_basic=0;
        $total_othalw=0;
        $total_pf=0;
        $total_pfint=0;
        $total_da=0;
        $total_miscalw=0;
        $total_apf=0;
        $total_adv=0;
        $total_vda=0;
        $total_ot=0;
        $total_ptax=0;
        $total_hrd=0;
        $total_tiffalw=0;
        $total_leave_enc=0;
        $total_insu_prem=0;
        $total_furniture=0;
        $total_conv=0;
        $total_hta=0;
        $total_pfloan=0;
        $total_misc_ded=0;
        $total_medical=0;
        $total_totinc=0;
        $total_esi=0;
        $total_ded=0;
        $total_netpay=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_basic=$total_basic+$record->emp_basic_pay;
                $total_othalw=$total_othalw+$record->emp_others_alw;
                $total_pf=$total_pf+$record->emp_pf;
                $total_pfint=$total_pfint+$record->emp_pf_int;
                $total_da=$total_da+$record->emp_da;
                $total_miscalw=$total_miscalw+$record->emp_misc_alw;
                $total_apf=$total_apf+$record->emp_apf;
                $total_adv=$total_adv+$record->emp_adv;
                $total_vda=$total_vda+$record->emp_vda;
                $total_ot=$total_ot+$record->emp_over_time;
                $total_ptax=$total_ptax+$record->emp_prof_tax;
                $total_hrd=$total_hrd+$record->emp_hrd;
                $total_tiffalw=$total_tiffalw+$record->emp_tiff_alw;
                $total_leave_enc=$total_leave_enc+$record->emp_leave_inc;
                $total_insu_prem=$total_insu_prem+$record->emp_insu_prem;
                $total_furniture=$total_furniture+$record->emp_furniture;
                $total_conv=$total_conv+$record->emp_conv;
                $total_hta=$total_hta+$record->emp_hta;
                $total_pfloan=$total_pfloan+$record->emp_pf_loan;
                $total_misc_ded=$total_misc_ded+$record->emp_misc_ded;
                $total_medical=$total_medical+$record->emp_medical;
                $total_totinc=$total_totinc+$record->emp_gross_salary;
                $total_esi=$total_esi+$record->emp_esi;
                $total_ded=$total_ded+$record->emp_total_deduction;
                $total_netpay=$total_netpay+$record->emp_net_salary;


                $customer_array[] = array(
                    'Sl No' => $h,
                    'Department Name'=>$record->emp_department,
                    'Basic'=>$record->emp_basic_pay,
                    'OTH ALW'=>$record->emp_others_alw,
                    'PF'=>$record->emp_pf,
                    'PF INT'=>$record->emp_pf_int,
                    'DA'=>$record->emp_da,
                    'MISC ALW'=>$record->emp_misc_alw,
                    'APF'=>$record->emp_apf,
                    'ADV'=>$record->emp_adv,
                    'VDA'=>$record->emp_vda,
                    'OVER TIME'=>$record->emp_over_time,
                    'PROF. TAX'=>$record->emp_prof_tax,
                    'HRD'=>$record->emp_hrd,
                    'TIFF ALW'=>$record->emp_tiff_alw,
                    'LEAVE ENC'=>$record->emp_leave_inc,
                    'INSU PREM'=>$record->emp_insu_prem,
                    'FURNITURE'=>$record->emp_furniture,
                    'CONV'=>$record->emp_conv,
                    'HTA'=>$record->emp_hta,
                    'PF LOAN'=>$record->emp_pf_loan,
                    'MISC DED'=>$record->emp_misc_ded,
                    'MEDICAL'=>$record->emp_medical,
                    'TOT INC'=>$record->emp_gross_salary,
                    'ESI'=>$record->emp_esi,
                    'TOT DED'=>$record->emp_total_deduction,
                    'NET PAY'=>$record->emp_net_salary,
        
                );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Department Name'=>'Total',
                'Basic'=>$total_basic,
                'OTH ALW'=>$total_othalw,
                'PF'=>$total_pf,
                'PF INT'=>$total_pfint,
                'DA'=>$total_da,
                'MISC ALW'=>$total_miscalw,
                'APF'=>$total_apf,
                'ADV'=>$total_adv,
                'VDA'=>$total_vda,
                'OVER TIME'=>$total_ot,
                'PROF. TAX'=>$total_ptax,
                'HRD'=>$total_hrd,
                'TIFF ALW'=>$total_tiffalw,
                'LEAVE ENC'=>$total_leave_enc,
                'INSU PREM'=>$total_insu_prem,
                'FURNITURE'=>$total_furniture,
                'CONV'=>$total_conv,
                'HTA'=>$total_hta,
                'PF LOAN'=>$total_pfloan,
                'MISC DED'=>$total_misc_ded,
                'MEDICAL'=>$total_medical,
                'TOT INC'=>$total_totinc,
                'ESI'=>$total_esi,
                'TOT DED'=>$total_ded,
                'NET PAY'=>$total_netpay,
    
            );

        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Department Name',
            'Basic',
            'OTH ALW',
            'PF',
            'PF INT',
            'DA',
            'MISC ALW',
            'APF',
            'ADV',
            'VDA',
            'OVER TIME',
            'PROF. TAX',
            'HRD',
            'TIFF ALW',
            'LEAVE ENC',
            'INSU PREM',
            'FURNITURE',
            'CONV',
            'HTA',
            'PF LOAN',
            'MISC DED',
            'MEDICAL',
            'TOT INC',
            'ESI',
            'TOT DED',
            'NET PAY',
        ];
    }
}
