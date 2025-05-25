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
					
					<h4>Miscellaneous Recovery Report for <?php echo $req_month; ?> </h4>

				</div>
			</td>

			</tr>
		</table>

			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
                <tr>
										    <th style="width:8%;">Sl. No.</th>
											<th style="width:12%;">Employee Code</th>
											<th>Employee Name</th>
											<th style="width:10%;">ITAX</th>
											<th style="width:10%;">INSP</th>
											<th style="width:10%;">HRD</th>
											<th style="width:10%;">CO-OPTV</th>
											<th style="width:10%;">FURN</th>
											<th style="width:10%;">MISC.DED</th>
											
										</tr>
				</thead>
                <tbody>
										<?php //print_r($result);?>
                                        @php
                                            $total_i_tax=0;
                                            $total_insu_prem=0;
                                            $total_hrd=0;
                                            $total_co_op=0;
                                            $total_furniture=0;
                                            $total_misc_ded=0;
                                        @endphp
                                        @foreach ($result as $index=>$record)
                                        @php
                                            
                                            $total_i_tax=$total_i_tax+$record->emp_i_tax;
                                            $total_insu_prem=$total_insu_prem+ (float)str_replace(',','',$record->emp_insu_prem);
                                            $total_hrd=$total_hrd+$record->emp_hrd;
                                            $total_co_op=$total_co_op+$record->emp_co_op;
                                            $total_furniture=$total_furniture+$record->emp_furniture;
                                            $total_misc_ded=$total_misc_ded+$record->emp_misc_ded;

                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
											<td>{{$record->old_emp_code}}</td>
											<td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>
											<td>{{$record->emp_i_tax}}</td>
											<td>{{$record->emp_insu_prem}}</td>
											<td>{{$record->emp_hrd}}</td>
											<td>{{$record->emp_co_op}}</td>
											<td>{{$record->emp_furniture}}</td>
											<td>{{$record->emp_misc_ded}}</td>
											
                                        </tr>
                                        @endforeach
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" style="font-weight:700;">
											Grand Total
											</td>
											<td>
                                                <div class="total_i_tax" style="font-weight:700;">{{$total_i_tax}}</div>
                                            </td>
											<td>
                                                <div class="total_insu_prem" style="font-weight:700;">{{$total_insu_prem}}</div>
                                            </td>
											<td>
                                                <div class="total_hrd" style="font-weight:700;">{{$total_hrd}}</div>
                                            </td>
											<td>
                                                <div class="total_co_op" style="font-weight:700;">{{$total_co_op}}</div>
                                            </td>
											<td>
                                                <div class="total_furniture" style="font-weight:700;">{{$total_furniture}}</div>
                                            </td>
											<td>
                                                <div class="total_misc_ded" style="font-weight:700;">{{$total_misc_ded}}</div>
                                            </td>
										</tr>
									</tfoot>
			</table>

	<!------------------------------------->
</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>
