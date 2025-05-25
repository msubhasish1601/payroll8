<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Attendance\Upload_attendence;
use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportMiscRecovery implements FromCollection, WithHeadings
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
                'payroll_details.emp_i_tax',
                'payroll_details.emp_insu_prem',
                'payroll_details.emp_hrd',
                'payroll_details.emp_furniture',
                'payroll_details.emp_misc_ded',
                'employees.salutation',
                'employees.emp_fname',
                'employees.emp_mname',
                'employees.emp_lname'
            )
            ->where('payroll_details.month_yr', '=', $this->month_yr)
            
            ->orderBy('employees.old_emp_code', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        $total_i_tax=0;
        $total_insu_prem=0;
        $total_hrd=0;
        $total_co_op=0;
        $total_furniture=0;
        $total_misc_ded=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_i_tax=$total_i_tax+$record->emp_i_tax;
                $total_insu_prem=$total_insu_prem+$record->emp_insu_prem;
                $total_hrd=$total_hrd+$record->emp_hrd;
                $total_co_op=$total_co_op+$record->emp_co_op;
                $total_furniture=$total_furniture+$record->emp_furniture;
                $total_misc_ded=$total_misc_ded+$record->emp_misc_ded;

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'ITAX'=>$record->emp_i_tax,
                    'INSP'=>$record->emp_insu_prem,
                    'HRD'=>$record->emp_hrd,
                    'CO-OPTV'=>$record->emp_co_op,
                    'FURN'=>$record->emp_furniture,
                    'MISC.DED'=>$record->emp_misc_ded,
                );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'ITAX'=>$total_i_tax,
                'INSP'=>$total_insu_prem,
                'HRD'=>$total_hrd,
                'CO-OPTV'=>$total_co_op,
                'FURN'=>$total_furniture,
                'MISC.DED'=>$total_misc_ded,
    
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
            'ITAX',
            'INSP',
            'HRD',
            'CO-OPTV',
            'FURN',
            'MISC.DED',
        ];
    }
}
