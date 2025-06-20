<!DOCTYPE html>
<html lang="en">
<head>
  <title>Belleuve</title>
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
				 Belleuve
			</div>
			</td>
			<td>
				<div class="pay-head">
				<h2>Belleuve</h2>
				<h4></h4>
			
				</div>
				<div class="mon">
						<h4><u>Employee Increment Report.</u></h4>
				</div>
			</td>
			
			</tr>
		</table>	
		
			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
					<tr>
						<th>Sl. No.</th>
						<th>Employee Code</th>
						<th>Employee Name</th>
						<th>Designation</th>
						<th>Last Increment Date</th>
						<th>Increment Date</th>
						<th>Previous Basic Pay (<i class="fas fa-rupee-sign"></i>)</th>
						<th>Previous  Pay  Level</th>
						<th>New Basic Pay (<i class="fas fa-rupee-sign"></i>)</th>
						<th>New  Pay  Level</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i=1;
					if(!empty($allincrements)){ 
						foreach($allincrements as $increment){ //print_r($increment); exit;?>
					<tr class="part">
						<td><?php echo $i;  ?></td>
						<td><?php echo $increment->emp_code;  ?></td>
						<td><?php echo $increment->emp_fname." ".$increment->emp_mname." ".$increment->emp_lname; ?></td>
						<td><?php echo $increment->emp_designation;  ?></td>
						<td style="text-align:right;"><?php echo date('d-m-Y', strtotime($increment->approve_date));  ?></td>
						<td style="text-align:right;"><?php echo date('d-m-Y', strtotime($increment->emp_next_increament_date));  ?></td>
						<td style="text-align:right;"><?php echo $increment->old_basicpay;  ?></td>
						<td style="text-align:right;"><?php 
						
        $designationpay=DB::table('pay_scale_basic_masters')->where('pay_scale_basic','=',$increment->old_basicpay) ->orderBy('id', 'desc')->first();
					 $designationpayold=DB::table('pay_scale_masters')->where('id','=',$designationpay->pay_scale_master_id) ->orderBy('id', 'desc')->first();	
						echo $designationpayold->payscale_code;  ?></td>
						<td style="text-align:right;"><?php echo $increment->new_basicpay;  ?></td>
					<td style="text-align:right;"><?php 
						
        $designationpaynew=DB::table('pay_scale_basic_masters')->where('pay_scale_basic','=',$increment->new_basicpay) ->orderBy('id', 'desc')->first();
					 $designationpayoldnew=DB::table('pay_scale_masters')->where('id','=',$designationpaynew->pay_scale_master_id) ->orderBy('id', 'desc')->first();	
						echo $designationpayoldnew->payscale_code;  ?></td>
					</tr>
				<?php $i++; } }?> 
					<!--<tr>
	
					<td style="font-weight:600;" colspan="7">Total in words: RUPEES   </td>
					<td style="font-weight:600;text-align:right;"></td>
					</tr>-->
					
				</tbody>
			</table>
			
	<!------------------------------------->
</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>