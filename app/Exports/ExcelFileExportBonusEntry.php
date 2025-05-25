<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class ExcelFileExportBonusEntry implements FromCollection, WithHeadings
{
    private $year;
    private $type;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($year,$type='BonusEntry')
    {
        
        $this->year = $year;
        $this->type = $type;
        
    }
    public function collection()
    {
        $employee_rs = Employee::join('yearly_employee_bonuses', 'yearly_employee_bonuses.emp_code', '=', 'employees.emp_code')
            ->select(
                'employees.old_emp_code',
                'yearly_employee_bonuses.*',
                'employees.salutation',
                'employees.emp_fname',
                'employees.emp_mname',
                'employees.emp_lname'
            )
            ->where('yearly_employee_bonuses.year', '=', $this->year)
            ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_bonus=0;
        $total_exgratia=0;
        $total_deduction=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_bonus=$total_bonus+$record->bonus;
                $total_exgratia=$total_exgratia+$record->exgratia;
                $total_deduction=$total_deduction+$record->deduction;

                if($this->type=='complete'){
                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Bonus'=>$record->bonus,
                        'Exgratia'=>$record->exgratia,
                        'Total'=>$record->bonus+$record->exgratia,
                    );
                }elseif($this->type=='BonusOnly'){
                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Bonus'=>$record->bonus,
                    );
                }elseif($this->type=='Exgratia'){
                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Exgratia'=>$record->exgratia,
                    );
                }else{
                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Status'=>ucwords($record->status),
                        'Bonus'=>$record->bonus,
                        'Exgratia'=>$record->exgratia,
                        'Deduction'=>$record->deduction,
                    );
                }

                $h++;
            }
            if($this->type=='complete'){
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code'=>'Total',
                    'Employee Name'=>'',
                    'Bonus'=>$total_bonus,
                    'Exgratia'=>$total_exgratia,
                    'Total'=>$total_bonus+$total_exgratia,
        
                );
            }elseif($this->type=='BonusOnly'){
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code'=>'Total',
                    'Employee Name'=>'',
                    'Bonus'=>$total_bonus,
                );
            }elseif($this->type=='Exgratia'){
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code'=>'Total',
                    'Employee Name'=>'',
                    'Exgratia'=>$total_exgratia,
                );
            }else{
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code'=>'Total',
                    'Employee Name'=>'',
                    'Status'=>'',
                    'Bonus'=>$total_bonus,
                    'Exgratia'=>$total_exgratia,
                    'Deduction'=>$total_deduction,
        
                );
            }

        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        if($this->type=='complete'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Bonus',
                'Exgratia',
                'Total',
            ];
        }elseif($this->type=='BonusOnly'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Bonus',
            ];
        }elseif($this->type=='Exgratia'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Exgratia',
            ];
        }else{
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Status',
                'Bonus',
                'Exgratia',
                'Deduction',
            ];
        }
    }
}
