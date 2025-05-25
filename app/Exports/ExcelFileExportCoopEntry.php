<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportCoopEntry implements FromCollection, WithHeadings
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
        $employee_rs = Employee::join('monthly_employee_cooperatives', 'monthly_employee_cooperatives.emp_code', '=', 'employees.emp_code')
            ->select(
                'employees.old_emp_code',
                'employees.emp_code',
                'monthly_employee_cooperatives.*',
                'employees.salutation',
                'employees.emp_fname',
                'employees.emp_mname',
                'employees.emp_lname'
            )
            ->where('monthly_employee_cooperatives.month_yr', '=', $this->month_yr)
            ->orderBy('employees.old_emp_code', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_insu_prem=0;
        $total_co_op=0;
        $total_misc_ded=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_insu_prem=$total_insu_prem+$record->insurance_prem;
                $total_co_op=$total_co_op+$record->coop_amount;
                $total_misc_ded=$total_misc_ded+$record->misc_ded;

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Status'=>ucwords($record->status),
                    'Insurance Premium Deduction'=>$record->insurance_prem,
                    'Cooperative Deduction'=>$record->coop_amount,
                    'Miscellaneous Deduction'=>$record->misc_ded,
                );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'Status'=>'',
                'Insurance Premium Deduction'=>$total_insu_prem,
                'Cooperative Deduction'=>$total_co_op,
                'Miscellaneous Deduction'=>$total_misc_ded,
    
            );

        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Employee Code',
            'Employee Name',
            'Status',
            'Insurance Premium Deduction',
            'Cooperative Deduction',
            'Miscellaneous Deduction',
        ];
    }
}
