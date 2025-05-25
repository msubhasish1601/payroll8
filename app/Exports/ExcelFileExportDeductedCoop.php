<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Attendance\Upload_attendence;
use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportDeductedCoop implements FromCollection, WithHeadings
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
        $employee_rs = Employee::join('payroll_details', 'payroll_details.employee_id', '=', 'employees.emp_code')
            ->select(
                'employees.old_emp_code',
                'employees.emp_code',
                'payroll_details.emp_co_op',
                'employees.salutation',
                'employees.emp_fname',
                'employees.emp_mname',
                'employees.emp_lname'
                )
            ->where('payroll_details.month_yr', '=', $this->month_yr)
            ->where('payroll_details.emp_co_op','>',0)
            ->orderBy('employees.old_emp_code', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        $total_amount=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_amount=$total_amount+$record->emp_co_op;
                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Cops Amount'=>$record->emp_co_op,
                );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'Cops Amount'=>$total_amount,

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
            'Cops Amount',
        ];
    }
}
