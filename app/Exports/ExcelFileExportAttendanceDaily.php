<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Attendance\Attendence;
use DB;

class ExcelFileExportAttendanceDaily implements FromCollection, WithHeadings
{
    private $month_yr;
    private $employee_id;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr,$employee_id)
    {
        
        $this->month_yr = $month_yr;
        $this->employee_id = $employee_id;
    }
    public function collection()
    {
        
        $employee_rs = Attendence::join('employees', 'employees.emp_code', '=', 'attandence.employee_code')
            ->where('attandence.month', '=', $this->month_yr)
            // ->where('employees.emp_status', '!=', 'TEMPORARY')
            ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
            ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
            ->where('employees.emp_code', '=', $this->employee_id)
            ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();
          
    

        $h = 1;
        $customer_array = array();
        
        $total_itax_amount=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                
                // dd($record);
                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->emp_fname . ' ' . $record->emp_mname . ' ' . $record->emp_lname,
                    'Attendence Date'=>date('d-m-Y',strtotime($record->date)),
                    'Clock In'=>$record->time_in!=""?date('h:i a',strtotime($record->time_in)):'',
                    'Clock Out'=>$record->time_out!=""?date('h:i a',strtotime($record->time_out)):'',
                    'Clock In Location'=>$record->time_in_location,
                    'Clock Out Location'=>$record->time_out_location,
                    'Duty Hours'=>$record->duty_hours,
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
            'Attendence Date',
            'Clock In',
            'Clock Out',
            'Clock In Location',
            'Clock Out Location',
            'Duty Hours',
        ];
    }
}