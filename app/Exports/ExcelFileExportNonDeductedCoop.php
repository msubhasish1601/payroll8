<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Attendance\Upload_attendence;
use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportNonDeductedCoop implements FromCollection, WithHeadings
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
        $empPayStructure=Employee_pay_structure::where('employee_pay_structures.co_op', '>',0)->pluck('employee_code');

        $employee_rs = Employee::join('monthly_employee_cooperatives', 'monthly_employee_cooperatives.emp_code', '=', 'employees.emp_code')
            ->select(
                'employees.old_emp_code',
                'employees.emp_code',
                'monthly_employee_cooperatives.coop_amount',
                'employees.salutation',
                'employees.emp_fname',
                'employees.emp_mname',
                'employees.emp_lname'
                )
            ->where('monthly_employee_cooperatives.month_yr', '=', $this->month_yr)
            ->whereIn('employees.emp_code', $empPayStructure)
            ->where('monthly_employee_cooperatives.coop_amount','=',0)
            ->orderBy('employees.old_emp_code', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        $total_amount=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_amount=$total_amount+$record->coop_amount;
                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Cops Amount'=>$record->coop_amount,
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
