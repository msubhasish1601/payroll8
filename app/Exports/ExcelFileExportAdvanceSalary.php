<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Loan\Loan;
use DB;

class ExcelFileExportAdvanceSalary implements FromCollection, WithHeadings
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


        if($this->month_yr){

        // $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
        //     ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*', DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month <= '".$this->month_yr."') as recoveries"), DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."') as payroll_deduction"), DB::raw("(SELECT  payroll_details.emp_pf_int FROM payroll_details WHERE payroll_details.employee_id =  employees.emp_code and payroll_details.month_yr = '".$this->month_yr."') as pf_iterest"))
        //     ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $this->month_yr)
        //     ->where('loan_type', '=', $this->loan_type)
        //     ->where('deduction', '=', 'Y')
        //     ->where('loans.loan_amount', '>', 0)
        //     ->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$this->month_yr."')"), '>', 0)
        //     ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
        //     ->get();

        $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
            ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*' )
            ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '=', $this->month_yr)
            ->where('loans.loan_type', '=', $this->loan_type)
            //->where('loans.deduction', '!=', 'Y')
            ->where('loans.loan_amount', '>', 0)
            //->where(DB::raw("(SELECT  Sum(loan_recoveries.amount) FROM loan_recoveries WHERE loan_recoveries.loan_id =  loans.id and loan_recoveries.payout_month = '".$request->month."')"), '>', 0)
            ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();

        }else{
            //echo 0; die;
            $employee_rs = Loan::join('employees', 'employees.emp_code', '=', 'loans.emp_code')
            ->select('employees.salutation','employees.emp_fname', 'employees.emp_mname', 'employees.emp_lname', 'employees.emp_designation', 'employees.old_emp_code','employees.emp_pf_no', 'loans.*')
            //->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $request->month)
            ->where('loan_type', '=', $this->loan_type)
            ->where('deduction', '=', 'Y')
            ->where('loans.loan_amount', '>', 0)
            ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
            ->get();
        }

        $h = 1;
        $customer_array = array();
        $total_loan_amount=0;
        $total_balance=0;
        $total_installment=0;
        $total_pf_interest=0;
        $total_deduction=0;
        $total_loanadjust=0;

        if (count($employee_rs) != 0) {

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

                    if($record->deduction == 'Y'){ $deduction = "Yes"; }else{ $deduction = "No";  }

                    $customer_array[] = array(
                        'Sl No'=> $h,
                        'Employee Id'=>$record->emp_code,
                        'Employee Code'=>$record->old_emp_code,
                        'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                        'Designation'=>$record->emp_designation,
                        'Loan start month'=>date('m/Y',strtotime($record->start_month??'N/A')),
                        'Loan Type'=>$record->loan_type??'N/A',
                        'Loan Amount'=>$record->loan_amount??'N/A',
                        'Installment'=>$record->installment_amount??'N/A',
                        'Deduction'=> $deduction,
                    );
                    $h++;
                }
                // $customer_array[] = array(
                //     'Sl No' => 'Grand',
                //     'Employee Code' => 'Total',
                //     'Employee Name'=> '',
                //     'Loan ID'=> '',
                //     'PF Number'=>'',
                //     'PF Loan Outstanding'=> number_format($total_loan_amount,2),
                //     'PF Loan Deduction'=> number_format($total_installment,2),
                //     'PF Interest'=> number_format($total_pf_interest,2),
                //     'Total Deduction'=> number_format($total_deduction,2),
                //     'PF Loan Balance'=> number_format($total_balance,2),
                //     'Loan Adjust'=> number_format($total_loanadjust,2),
                //     'Final PF Loan Balance'=> number_format(($total_balance-$total_loanadjust),2),
                // );


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
                'Designation',
                'Loan start month',
                'Loan Type',
                'Loan Amount',
                'Installment',
                'Deduction',
            ];

    }
}
