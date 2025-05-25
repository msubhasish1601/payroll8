<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportPayrollEntry implements FromCollection, WithHeadings
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
        
        // $employee_rs = Payroll_detail::join('employees', 'employees.emp_code', '=', 'payroll_details.employee_id')
        //         ->select('employees.old_emp_code', 'payroll_details.*')
        //         ->where('payroll_details.month_yr','=',$this->month_yr)
        //         ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
        //         ->get();
        $employee_rs = Payroll_detail::join('employees', 'employees.emp_code', '=', 'payroll_details.employee_id')
            ->select('employees.old_emp_code', 'payroll_details.*')
            ->where('payroll_details.month_yr', $this->month_yr)
            ->orderBy('employees.old_emp_code', 'asc') // Simplified sorting
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_itax_amount=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->emp_name,
                    'Designation'=>$record->emp_designation,
                    'Month'=>$record->month_yr,
                    'Basic Pay'=>$record->emp_basic_pay,
                    'DA'=>$record->emp_da,
                    'VDA'=>$record->emp_vda,
                    'HRA'=>$record->emp_hra,
                    'OTH ALW'=>$record->emp_others_alw,
                    'TIFF ALW'=>$record->emp_tiff_alw,
                    'CONV'=>$record->emp_conv,
                    'MEDICAL'=>$record->emp_medical,
                    'MISC ALW'=>$record->emp_misc_alw,
                    'OVERTIME'=>$record->emp_over_time,
                    'BONUS'=>$record->emp_bouns,
                    'LEAVE ENC'=>$record->emp_leave_inc,
                    'OTHER EARNING'=>$record->other_addition,
                    'PTAX'=>$record->emp_prof_tax,
                    'PF'=>$record->emp_pf,
                    'PF INT'=>$record->emp_pf_int,
                    'APF'=>$record->emp_apf,
                    'I TAX'=>$record->emp_i_tax,
                    'INSU PERM'=>$record->emp_insu_prem,
                    'PF LOAN'=>$record->emp_pf_loan,
                    'ESI'=>$record->emp_esi,
                    'ADV'=>$record->emp_adv,
                    'HRD'=>$record->emp_hrd,
                    'CO-OP'=>$record->emp_co_op,
                    'FURNITURE'=>$record->emp_furniture,
                    'MISC DED'=>$record->emp_misc_ded,
                    'Employer PF'=>$record->emp_pf_employer,
                    'TDS'=>$record->emp_tds_ded,
                    'HTA'=>$record->emp_hta,
                    'Gross Salary'=>$record->emp_gross_salary,
                    'Total Deductions'=>$record->emp_total_deduction,
                    'Net Salary'=>$record->emp_net_salary,
                );
                $h++;
            }
            

        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Employee Code',
            'Employee Name',
            'Designation',
            'Month',
            'Basic Pay',
            'DA',
            'VDA',
            'HRA',
            'OTH ALW',
            'TIFF ALW',
            'CONV',
            'MEDICAL',
            'MISC ALW',
            'OVERTIME',
            'BONUS',
            'LEAVE ENC',
            'OTHER EARNING',
            'PTAX',
            'PF',
            'PF INT',
            'APF',
            'I TAX',
            'INSU PERM',
            'PF LOAN',
            'ESI',
            'ADV',
            'HRD',
            'CO-OP',
            'FURNITURE',
            'MISC DED',
            'Employer PF',
            'TDS',
            'HTA',
            'Gross Salary',
            'Total Deductions',
            'Net Salary',
        ];
    }
}
