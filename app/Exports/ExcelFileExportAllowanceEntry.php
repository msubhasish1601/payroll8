<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportAllowanceEntry implements FromCollection, WithHeadings
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
        $employee_rs = Employee::join('monthly_employee_allowances', 'monthly_employee_allowances.emp_code', '=', 'employees.emp_code')
        ->select(
            'employees.old_emp_code',
            'employees.emp_code',
            'monthly_employee_allowances.*',
            'employees.salutation',
            'employees.emp_fname',
            'employees.emp_mname',
            'employees.emp_lname'
        )
        ->where('monthly_employee_allowances.month_yr', '=', $this->month_yr)
        ->orderBy('employees.old_emp_code', 'asc')
        ->get();

        $h = 1;
        $customer_array = array();
        
        $total_tiff_days=0;
        $total_ent_tiff=0;
        $total_tiff=0;
        $total_conv_days=0;
        $total_ent_conv=0;
        $total_conv=0;
        $total_mics_days=0;
        $total_ent_mics=0;
        $total_mics=0;
        $total_extra_mics=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_tiff_days=$total_tiff_days+$record->no_days_tiffalw;
                $total_ent_tiff=$total_ent_tiff+$record->pay_structure_tiff_alw;
                $total_tiff=$total_tiff+$record->tiffin_alw;
                $total_conv_days=$total_conv_days+$record->no_days_convalw;
                $total_ent_conv=$total_ent_conv+$record->pay_structure_conv_alw;
                $total_conv=$total_conv+$record->convence_alw;
                $total_mics_days=$total_mics_days+$record->no_days_miscalw;
                $total_ent_mics=$total_ent_mics+$record->pay_structure_misc_alw;
                $total_mics=$total_mics+$record->misc_alw;
                $total_extra_mics=$total_extra_mics+$record->extra_misc_alw;

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Status'=>ucwords($record->status),
                    'No. of Tiffin Alw. Days'=>$record->no_days_tiffalw,
                    'Ent. Tiffin Allowance'=>$record->pay_structure_tiff_alw,
                    'Tiffin Allowance'=>$record->tiffin_alw,
                    'No. of Conv. Alw. Days'=>$record->no_days_convalw,
                    'Ent. Conv. Allowance'=>$record->pay_structure_conv_alw,
                    'Conv. Allowance'=>$record->convence_alw,
                    'No. of Mics. Alw. Days'=>$record->no_days_miscalw,
                    'Ent. Mics. Allowance'=>$record->pay_structure_misc_alw,
                    'Mics. Allowance'=>$record->misc_alw,
                    'Extra Mics. Allowance'=>$record->extra_misc_alw,
                );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'Status'=>'',
                'No. of Tiffin Alw. Days'=>$total_tiff_days,
                'Ent. Tiffin Allowance'=>$total_ent_tiff,
                'Tiffin Allowance'=>$total_tiff,
                'No. of Conv. Alw. Days'=>$total_conv_days,
                'Ent. Conv. Allowance'=>$total_ent_conv,
                'Conv. Allowance'=>$total_conv,
                'No. of Mics. Alw. Days'=>$total_mics_days,
                'Ent. Mics. Allowance'=>$total_ent_mics,
                'Mics. Allowance'=>$total_mics,
                'Extra Mics. Allowance'=>$total_extra_mics,
            
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
            'No. of Tiffin Alw. Days',
            'Ent. Tiffin Allowance',
            'Tiffin Allowance',
            'No. of Conv. Alw. Days',
            'Ent. Conv. Allowance',
            'Conv. Allowance',
            'No. of Mics. Alw. Days',
            'Ent. Mics. Allowance',
            'Mics. Allowance',
            'Extra Mics. Allowance',
        ];
    }
}
