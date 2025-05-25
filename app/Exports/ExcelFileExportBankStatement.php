<?php

namespace App\Exports;

use App\Models\Payroll\Payroll_detail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelFileExportBankStatement implements FromCollection, WithHeadings
{
    private $monthyr;
    private $bankname;
    private $class_name_new;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($monthyr, $bankname, $class_name_new)
    {

        $this->monthyr = $monthyr;
        $this->bankname = $bankname;
        $this->class_name_new = $class_name_new;

    }
    public function collection()
    {

        if ($this->class_name_new == '' && $this->bankname == '') {
            //echo 'No class no bank';
            $employee_rs = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->where('payroll_details.month_yr', '=', $this->monthyr)

                ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                ->get();
        } else if ($this->class_name_new == '' && $this->bankname != '') {
            //echo 'No class but bank';
            $employee_rs = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->where(['payroll_details.month_yr' => $this->monthyr, 'employees.emp_bank_name' => $this->bankname])

                ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                ->get();
        } else if ($this->class_name_new != '' && $this->bankname == '') {
            //echo 'No bank but class';
            $employee_rs = Payroll_detail::join('employees', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->where(['payroll_details.month_yr' => $this->monthyr, 'group_name_details.id' => $this->class_name_new])

                ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                ->get();
        } else {
            //echo 'Else';
            $employee_rs = Payroll_detail::join('employees1', 'payroll_details.employee_id', '=', 'employees.emp_code')
                ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                ->join('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                ->where('payroll_details.month_yr', '=', $this->monthyr)
                ->where('employees.emp_group_name', '=', $this->class_name_new)
                ->where('employees.emp_bank_name', '=', $this->bankname)
                ->select('payroll_details.*', 'employees.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                ->orderByRaw('CAST(employees.old_emp_code AS UNSIGNED)')
                ->get();
        }

        //dd($employee_rs);

        $h = 1;
        $customer_array = array();

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {

                //dd($record);
                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Id' => $record->employee_id,
                    'Employee Code' => $record->old_emp_code,
                    'Employee Name' => $record->emp_name,
                    //'Class' => $record->group_name,
                    'Bank' => $record->master_bank_name,
                    'A/c. No.' => $record->emp_account_no,
                    'Net Salary' => $record->emp_net_salary,
                    'Month' => $record->month_yr,
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
            'Employee Id',
            'Employee Code',
            'Employee Name',
            //'Class',
            'Bank',
            'A/c. No.',
            'Net Salary',
            'Month',

        ];
    }
}
