<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class ExcelFileExportEncashEntry implements FromCollection, WithHeadings
{
    private $year;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($year)
    {
        
        $this->year = $year;
        
    }
    public function collection()
    {
        $employee_rs = Employee::join('yearly_employee_lenc_htas', 'yearly_employee_lenc_htas.emp_code', '=', 'employees.emp_code')
            ->select(
                'employees.old_emp_code',
                'yearly_employee_lenc_htas.*',
                'employees.salutation',
                'employees.emp_fname',
                'employees.emp_mname',
                'employees.emp_lname'
            )
            ->where('yearly_employee_lenc_htas.year', '=', $this->year)
            ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_lenc=0;
        $total_hta=0;
        $total_comm=0;
        $total_othinc=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {

                $total_lenc=$total_lenc+$record->leave_enc;
                $total_hta=$total_hta+$record->hta;
                $total_comm=$total_comm+$record->commision;
                $total_othinc=$total_othinc+$record->oth_income;

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Status'=>ucwords($record->status),
                    'Leave Enc.'=>$record->leave_enc,
                    'HTA'=>$record->hta,
                    'Commission'=>$record->commision,
                    'Other Income'=>$record->oth_income,
                );
                $h++;
            }

            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'Status'=>'',
                'Leave Enc.'=>$total_lenc,
                'HTA'=>$total_hta,
                'Commission'=>$total_comm,
                'Other Income'=>$total_othinc,
    
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
            'Leave Enc.',
            'HTA',
            'Commission',
            'Other Income',
        ];
    }
}
