
<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css" media="print"> @page  { size: auto; /* auto is the initial value */
   	margin-top: 0;
    margin-bottom: 0; /* this affects the margin in the printer settings */ }
   </style>
  <style>
body {-webkit-print-color-adjust: exact;}
  	.payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 35px;color: #292929;text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 19px;text-align:center;margin:0;}
	.payslip .pay-month{text-align:center;}
	.payslip .pay-month h3{margin:0;color: #0099be;}
	.pay-logo img {max-width: 80px;}
	.emp-det{width:100%;}
	.emp-det thead tr th{text-align:center;}
	.emp-det thead tr th{border-bottom:none;}
	.emp-det thead tr th {border-bottom: none;background: #0099be;color: #fff;padding: 5px;font-size: 18px;}
	.emp-det tbody tr td{padding:10px;}
	table.emp-det tr td span {font-weight: 600;}
	.sal-det tr th {background: #a7a8a9;padding: 5px;border-bottom: none;color: #000;text-align:center;font-size:12px;}
	.sal-det tr.part td{padding:5px;text-align:left;font-weight:600;background: #a7a8a9;color:#000;text-align:center;font-size:12px;}
	.sal-det tr td{padding:5px;text-align:center;font-size:12px;}
	.sal-det tr td p{text-align:right;margin:0;}.mon{text-align:center;}.mon h3{color:#0099be;margin:0;font-size:25px;}.mon h4{margin:0;font-size: 24px;}
	.sal-det tr:nth-child(odd) {background-color: #f2f2f2;}
	.emp-det{margin-bottom:15px;}.total td{font-weight:600;}.leave{border-top:none;}
	.leave tr th{padding:7px 10px;text-align:left;}
	@media  print{@page  {size: portrait}}
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
				<div class="text-center pay-head">
				<h2>{{ config('app.name', 'Laravel') }}</h2>
				<h4></h4>
				</div>
				<div class="mon">
					<h4>Employee Leave Register December {{ $year_value }}</h4>
				</div>
			</td>
			</tr>
		</table>
	<!--------------------------->


	<!------------Salary-details----------------->
			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
					<tr>
						<th rowspan="2">Sl. No.</th>
						<th rowspan="2">EMPLOYEE CODE</th>
						<th rowspan="2">EMPLOYEE NAME</th>
						<th rowspan="2">DESIGNATION</th>
						<th colspan="14">LEAVE TYPE</th>
					</tr>
					<tr class="part">
					<?php foreach ($leave_type as $leave_name) {?>
						<td><?php echo $leave_name->leave_type_name; ?></td>
					<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0;foreach ($leave_rs as $ls) {$i++;?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $ls['old_emp_code']; ?></td>
						<td><?php echo $ls['emp_name']; ?></td>
						<td><?php echo $ls['emp_designation']; ?></td>
						<?php foreach ($leave_type as $leave_name) {?>
						<td><?php
$leavetype = DB::Table('leave_allocations')
        ->where('leave_type_id', '=', $leave_name->id)
        ->where('employee_code', '=', $ls['old_emp_code'])
        ->whereYear('created_at', '=', $year_value)

        ->orderBy('id', 'desc')
        ->first();
    if (!empty($leavetype)) {
        echo $leavetype->leave_in_hand;
    } else {
        echo '0';
    }

    ?></td>
					<?php }?>
						</tr>
                 <?php }?>

				</tbody>
			</table>

	<!------------------------------------->
</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>