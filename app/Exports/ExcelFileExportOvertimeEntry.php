<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportOvertimeEntry implements FromCollection, WithHeadings
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
        $employee_rs = Employee::join('monthly_employee_overtimes', 'monthly_employee_overtimes.emp_code', '=', 'employees.emp_code')
        ->select(
            'employees.old_emp_code',
            'employees.emp_code',
            'monthly_employee_overtimes.*',
            'employees.salutation',
            'employees.emp_fname',
            'employees.emp_mname',
            'employees.emp_lname'
        )
        ->where('monthly_employee_overtimes.month_yr', '=', $this->month_yr)
        ->orderBy('employees.old_emp_code', 'asc')
        ->get();

        $h = 1;
        $customer_array = array();
        
        $total_lm_ot_hrs=0;
        $total_cm_ot_hrs=0;
        $total_lm_ot=0;
        $total_cm_ot=0;
        $total_ot=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_lm_ot_hrs=$total_lm_ot_hrs+$record->last_month_ot_hrs;
                $total_cm_ot_hrs=$total_cm_ot_hrs+$record->current_month_ot_hrs;
                $total_lm_ot=$total_lm_ot+$record->last_month_ot;
                $total_cm_ot=$total_cm_ot+$record->curr_month_ot;
                $total_ot=$total_ot+$record->ot_alws;

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Status'=>ucwords($record->status),
                    'Basic'=>$record->pay_structure_basic,
                    'Last Month OT Hrs.'=>$record->last_month_ot_hrs,
                    'Current Month OT Hrs.'=>$record->current_month_ot_hrs,
                    'Last Month OT'=>$record->last_month_ot,
                    'Current Month OT'=>$record->curr_month_ot,
                    'Overtime Allowance'=>$record->ot_alws,
                        );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'Status'=>'',
                'Basic'=>'',
                'Last Month OT Hrs.'=>$total_lm_ot_hrs,
                'Current Month OT Hrs.'=>$total_cm_ot_hrs,
                'Last Month OT'=>$total_lm_ot,
                'Current Month OT'=>$total_cm_ot,
                'Overtime Allowance'=>$total_ot,
        
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
            'Basic',
            'Last Month OT Hrs.',
            'Current Month OT Hrs.',
            'Last Month OT',
            'Current Month OT',
            'Overtime Allowance',
        ];
    }
}
