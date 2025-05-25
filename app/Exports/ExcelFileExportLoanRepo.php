<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Loan\Loan;
use DB;

class ExcelFileExportLoanRepo implements FromCollection, WithHeadings
{
    private $month_yr;
    private $loan_type;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr,$loan_type)
    {
        
        $this->month_yr = $month_yr;
        $this->loan_type = $loan_type;
        
    }
    public function collection()
    {
        $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
            ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*', DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month <= '".$this->month_yr."') as recoveries"),DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."') as payroll_deduction"), DB::raw("(SELECT  payroll_details.emp_pf_int FROM payroll_details WHERE payroll_details.employee_id =  employees.emp_code and payroll_details.month_yr = '".$this->month_yr."') as pf_iterest"))
            ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $this->month_yr)
            ->where('loan_type', '=', $this->loan_type)
            ->where('deduction', '=', 'Y')
            ->where('loans.loan_amount', '>', 0)
            ->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."')"), '>', 0)
                ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();

        $h = 1;
        $customer_array = array();
        
        $total_loan_amount=0;
						
        $total_balance=0;
        $total_installment=0;
        $total_pf_interest=0;
        $total_deduction=0;
        $total_loanadjust=0;

        if (count($employee_rs) != 0) {
            if($this->loan_type=='PF'){
                foreach ($employee_rs as $record) {
                    $balance=0;
                    if($record->recoveries==null){
                        $balance = $record->loan_amount;
                    }else{
                        $balance = $record->loan_amount-$record->recoveries;
                    }
                    
                    $total_loan_amount=$total_loan_amount+$record->loan_amount;
                    $total_installment=$total_installment+$record->payroll_deduction;
                    $total_pf_interest=$total_pf_interest+$record->pf_iterest;
                    $total_deduction=$total_deduction+$record->payroll_deduction+$record->pf_iterest;
                   
                    $total_balance=$total_balance+$balance;
                    $total_loanadjust=$total_loanadjust+$record->adjust_amount;

                    $pf_interest=$record->pf_iterest;

                    $customer_array[] = array(
                        'Sl No'=> $h,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Loan ID'=>$record->loan_id,
                        'PF Number'=>$record->emp_pf_no,
                        'PF Loan Outstanding'=>$record->loan_amount,
                        'PF Loan Deduction'=>$record->payroll_deduction,
                        'PF Interest'=>$pf_interest,
                        'Total Deduction'=>number_format($record->payroll_deduction+$pf_interest,2),
                        'PF Loan Balance'=>number_format($balance,2),
                        'Loan Adjust'=>number_format($record->adjust_amount,2),
                        'Final PF Loan Balance'=>number_format($balance-$record->adjust_amount,2),
        
                    );
                    $h++;
                }
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code' => 'Total',
                    'Employee Name'=> '',
                    'Loan ID'=> '',
                    'PF Number'=>'',
                    'PF Loan Outstanding'=> number_format($total_loan_amount,2),
                    'PF Loan Deduction'=> number_format($total_installment,2),
                    'PF Interest'=> number_format($total_pf_interest,2),
                    'Total Deduction'=> number_format($total_deduction,2),
                    'PF Loan Balance'=> number_format($total_balance,2),
                    'Loan Adjust'=> number_format($total_loanadjust,2),
                    'Final PF Loan Balance'=> number_format(($total_balance-$total_loanadjust),2),
                );
                    
            }
            if($this->loan_type=='SA'){
                foreach ($employee_rs as $record) {
                    $balance=0;
                    if($record->recoveries==null){
                        $balance = $record->loan_amount;
                    }else{
                        $balance = $record->loan_amount-$record->recoveries;
                    }
                    
                    $total_loan_amount=$total_loan_amount+$record->loan_amount;
                   
                    $total_balance=$total_balance+$balance;
                    $total_installment=$total_installment+$record->payroll_deduction;
                    $total_loanadjust=$total_loanadjust+$record->adjust_amount;
    
                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Loan ID'=>$record->loan_id,
                        
                        'Outstanding Amount'=>$record->loan_amount,
                        'Deducted Amount'=>$record->payroll_deduction,
                        'Balance Amount'=>number_format($balance,2),
                        'Adjust Amount'=>number_format($record->adjust_amount,2),
                        'Final Balance Amount'=>number_format($balance-$record->adjust_amount,2),
        
                    );
                    $h++;
                }
                $customer_array[] = array(
                    'Sl No' => 'Grand',
                    'Employee Code' => 'Total',
                    'Employee Name' => '',
                    'Loan ID' => '',
                   
                    'Outstanding Amount'=>$total_loan_amount,
                    'Deducted Amount'=>$total_installment,
                    'Balance Amount'=>number_format($total_balance,2),
                    'Adjust Amount'=>number_format($total_loanadjust,2),
                    'Final Balance Amount'=>number_format(($total_balance-$total_loanadjust),2),
                );
    
            }

        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        if($this->loan_type=='PF'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Loan ID',
                'PF Number',
                'PF Loan Outstanding',
                'PF Loan Deduction',
                'PF Interest',
                'Total Deduction',
                'PF Loan Balance',
                'Loan Adjust',
                'Final PF Loan Balance',
            ];
                
        }
        if($this->loan_type=='SA'){
            return [
                'Sl No',
                'Employee Code',
                'Employee Name',
                'Loan ID',
                'Outstanding Amount',
                'Deducted Amount',
                'Balance Amount',
                'Adjust Amount',
                'Final Balance Amount',
            ];
    
        }
    }
}
