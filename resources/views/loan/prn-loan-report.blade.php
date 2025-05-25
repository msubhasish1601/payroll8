<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bellevue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css" media="print"> @page { size: auto; /* auto is the initial value */
   	margin-top: 0;
    margin-bottom: 0; /* this affects the margin in the printer settings */ }
   </style>
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <style>
body {-webkit-print-color-adjust: exact;}
  	.payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 35px;color: #000;text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 19px;text-align:right;margin:0;}
	.payslip .pay-month{text-align:right;}
	.payslip .pay-month h3{margin:0;color: #0099be;}
	.pay-logo img {max-width: 80px;}
	.pay-head h5{margin:0;text-align:right;font-size:15px;}
	.emp-det{width:100%;}
	.emp-det thead tr th{text-align:center;}
	.emp-det thead tr th{border-bottom:none;}
	.emp-det thead tr th {border-bottom: none;background: #0099be;color: #fff;padding: 5px;font-size: 18px;}
	.emp-det tbody tr td{padding:10px;}
	table.emp-det tr td span {font-weight: 600;}
	.sal-det tr th {background: #a9a4a4;padding: 5px 10px;border-bottom: none;color: #000;text-align:center;}
	.sal-det tr.part td{padding:7px 10px;text-align:left;border-top:none;}
	.sal-det tr td{padding:7px 10px;text-align:left;}
	.sal-det tr td p{text-align:right;margin:0;}.mon{text-align:right;}.mon h3{color:#0099be;margin:0;font-size:25px;}.mon h4{margin:0;font-size: 24px;text-align: center;}
	.sal-det tr:nth-child(odd) {background-color: #f2f2f2;}
	.emp-det{margin-bottom:15px;}.total td{font-weight:600;}.leave{border-top:none;}
	.leave tr th{padding:7px 10px;text-align:left;}
  </style>
</head>
<body>
<!-------------------payslip-body------------------------->
<div class="payslip">
	<!-----------company-details----------->
		<table class="comp-det" style="width:100%;">
		<tr>
			<td>
			<div class="pay-logo">
				<img src="{{ asset('theme/images/payroll-logo.png') }}" alt="logo">
			</div>
			</td>
			<td>
				
				<div class="mon">
					
					<h4><?php echo ($req_type=='SA')? "Salary Advance" : "PF Loan"; ?> Recovery Report for <?php echo $req_month; ?> </h4>

				</div>
			</td>

			</tr>
		</table>
		@if($req_type=='PF')
			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
                <tr>
					<th style="width:8%;">Sl. No.</th>
					<th style="width:5%;">Employee Code</th>
					<th>Employee Name</th>
					<th style="width:5%;">Loan ID</th>
					<th style="width:5%;">PF Number</th>
					<th style="width:5%;">PF Loan Outstanding </th>
					<th style="width:5%;">PF Loan Deduction </th>
					<th style="width:5%;">PF Interest </th>
					<th style="width:5%;">Total Deduction </th>
					<th style="width:5%;">PF Loan Balance</th>
					<th style="width:5%;">Loan Adjust</th>
					<th style="width:5%;">Final PF Loan Balance</th>
				</tr>
				</thead>
                <tbody>
					@php
                                            
                                            
						$total_loan_amount=0;
						
						$total_balance=0;
						$total_installment=0;
						$total_pf_interest=0;
						$total_deduction=0;
						$total_loanadjust=0;
					   
					@endphp

					@foreach ($result as $index=>$record)
					@php

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
						
					@endphp

					<tr>
						<td>{{$loop->iteration}}</td>
						
						<td>{{$record->old_emp_code}}</td>
						<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
						<td>{{ucwords($record->loan_id)}}</td>
						<td>{{ucwords($record->emp_pf_no)}}</td>
						<td>{{$record->loan_amount}}</td>
						
						<td>{{$record->payroll_deduction}}</td>
						
						<td>{{$pf_interest}}</td>
						<td>{{ number_format($record->payroll_deduction+$pf_interest,2) }}</td>
						<td>{{ number_format($balance,2) }}</td>
						<td>{{ number_format($record->adjust_amount,2) }}</td>
						<td>{{ number_format($balance-$record->adjust_amount,2) }}</td>
						
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" style="font-weight:700;">
						Grand Total
						</td>
						
						<td>
							<div class="total_loan_amount" style="font-weight:700;">{{number_format($total_loan_amount,2)}}</div>
						</td>
						
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_installment,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_pf_interest,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_deduction,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_balance,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_loanadjust,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format(($total_balance-$total_loanadjust),2)}}</div>
						</td>
						
						
						
					</tr>
				</tfoot>
			</table>
		@endif
		@if($req_type=='SA')
			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
				<tr>
					<th style="width:8%;">Sl. No.</th>
					<th style="width:12%;">Employee Code</th>
					<th>Employee Name</th>
					<th style="width:10%;">Loan ID</th>
					
					<th style="width:5%;">Outstanding Amount</th>
					<th >Deducted Amount</th>
					<th style="width:5%;">Balance Amount</th>
					<th style="width:5%;">Adjust Amount</th>
					<th style="width:5%;">Final Balance Amount</th>
				</tr>
				</thead>
                <tbody>
					@php
                                            
						$total_loan_amount=0;
						
						$total_balance=0;
						$total_loanadjust=0;
						$total_installment=0;
						
					@endphp

					@foreach ($result as $index=>$record)
					@php
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
						
					@endphp

					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$record->old_emp_code}}</td>
						<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
						<td>{{ucwords($record->loan_id)}}</td>
						
						<td>{{$record->loan_amount}}</td>
						<td>{{$record->payroll_deduction}}</td>
						<td>{{ number_format($balance,2) }}</td>
						<td>{{ number_format($record->adjust_amount,2) }}</td>
						<td>{{ number_format($balance-$record->adjust_amount,2) }}</td>
						
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" style="font-weight:700;">
						Grand Total
						</td>
						
						<td>
							<div class="total_loan_amount" style="font-weight:700;">{{number_format($total_loan_amount,2)}}</div>
						</td>
						
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_installment,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_balance,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format($total_loanadjust,2)}}</div>
						</td>
						<td>
							<div class="total_balance" style="font-weight:700;">{{number_format(($total_balance-$total_loanadjust),2)}}</div>
						</td>
						
						
						
					</tr>
				</tfoot>
			</table>
		@endif
	<!------------------------------------->
</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>
