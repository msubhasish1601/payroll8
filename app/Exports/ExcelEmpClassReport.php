<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class ExcelEmpClassReport implements FromCollection, WithHeadings
{


    /**
     * @return \Illuminate\Support\Collection
     */
    protected $emp_class_data;
    public function __construct($emp_class_data)
    {
        $this->emp_class_data = $emp_class_data;
    }

    public function collection()
    {
        //dd($this->emp_class_data);

        $record_rs = Employee::select('employees.*', 'employee_pay_structures.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                        ->join('employee_pay_structures', 'employees.emp_code', '=', 'employee_pay_structures.employee_code')
                        ->leftJoin('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                        ->leftJoin('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                        ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                        ->where('employees.emp_group_name', $this->emp_class_data)
                        ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                        ->get();

        $h = 1;
        $collection_array = array();

        //dd($record_rs[0]);

        if (count($record_rs) != 0) {
            foreach ($record_rs as $record) {

                $collection_array[] = array(
                    'Sl No' => $h,
                    'Employee ID'=>$record->emp_code,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Father Name'=>$record->emp_father_name,
                    'Department'=>$record->emp_department,
                    'Designation'=>$record->emp_designation,
                    'DOB'=>$record->emp_dob,
                    'DOJ'=>$record->emp_doj,
                    'Status'=>$record->emp_status,
                    'Address'=>$record->emp_pr_street_no,
                    'City'=>$record->emp_pr_city,
                    'State'=>$record->emp_pr_state,
                    'Country'=>$record->emp_pr_country,
                    'Pincode'=>$record->emp_pr_pincode,
                    'Mobile No.'=>$record->emp_pr_mobile,
                    'Class'=>ucwords($record->group_name),
                    'PF No.'=>$record->emp_pf_no,
                    'UAN No.'=>$record->emp_uan_no,
                    'PAN No.'=>$record->emp_pan_no,
                    'Bank'=>$record->master_bank_name,
                    'IFSC Code'=>$record->emp_ifsc_code,
                    'Account No.'=>$record->emp_account_no,
                    'Basic Pay'=>$record->basic_pay,
                    'HRA'=>$record->hra,
                    'Tiff. Alw.'=>$record->tiff_alw,
                    'Conv. Alw.'=>$record->conv,
                    'Med. Alw.'=>$record->medical,
                    'Misc. Alw.'=>$record->misc_alw,
                    'Other. Alw.'=>$record->others_alw,
                    'PTax'=>$record->prof_tax,
                    'Coop. Ded.'=>$record->co_op,
                    'Insurance Prem. Ded.'=>$record->insu_prem,
                    'emp_pf_inactuals'=>$record->emp_pf_inactuals,
                    'emp_pension'=>$record->emp_pension,

                );
                $h++;
            }

        }
        return collect($collection_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Employee ID',
            'Employee Code',
            'Employee Name',
            'Father Name',
            'Department',
            'Designation',
            'DOB',
            'DOJ',
            'Status',
            'Address',
            'City',
            'State',
            'Country',
            'Pincode',
            'Mobile No.',
            'Class',
            'PF No.',
            'UAN No.',
            'PAN No.',
            'Bank',
            'IFSC Code',
            'Account No.',
            'Basic Pay',
            'HRA',
            'Tiff. Alw.',
            'Conv. Alw.',
            'Med. Alw.',
            'Misc. Alw.',
            'Other. Alw.',
            'PTax',
            'Coop. Ded.',
            'Insurance Prem. Ded.',
            'emp_pf_inactuals',
            'emp_pension',

        ];
    }
}
