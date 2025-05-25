<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bellevue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon"/>
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
				<div class="pay-head">

				<h4></h4>

				</div>
				<div class="mon">
					<?php if (!empty($from_month)) {
    $fromdt = $from_month;
    $fromdate = explode('/', $fromdt);
    $from_date = $frommonthName = strftime('%B', mktime(0, 0, 0, $fromdate[0]));
}
// if (!empty($to_month)) {
//     $todt = $to_month;
//     $todate = explode('/', $todt);
//     $to_date = $tomonthName = strftime('%B', mktime(0, 0, 0, $todate[0]));

// }

?>
					<h4>PF Report for <?php echo $from_date . ' - ' . $fromdate[1]; ?> </h4>

				</div>
			</td>

			</tr>
			<?php if (count($employee_ptax) > 0) {?>
			<tr>
				<td colspan="3" style="padding-bottom: 25px;">In respect of Shri/Smt:  <u><?php echo $employee_ptax[0]->emp_name; ?></u>,  Designation: <u><?php echo $employee_ptax[0]->emp_designation; ?></u>,  Department: <u><?php echo $employee_ptax[0]->emp_department; ?></u>,  Emp-Code: <u><?php echo $employee_ptax[0]->old_emp_code; ?></u>, PF A/C No.: <u><?php echo $employee_ptax[0]->emp_pf_no; ?></u></td>
			</tr>
			<?php }?>
		</table>

			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">

				<thead>
					<tr>
						<th>Sl. No.</th>
						<!-- <th>Month</th> -->
						<th>Employee Contribution (<i class="fas fa-rupee-sign"></i>)</th>
						<th>Employer Contribution (<i class="fas fa-rupee-sign"></i>)</th>
						<th>Opening Balance (<i class="fas fa-rupee-sign"></i>)</th>
						<th>Closing Balance (<i class="fas fa-rupee-sign"></i>)</th>

					</tr>
				</thead>
				<tbody>
					<?php
$total_calculation = 0;
$i = 1;
if (!empty($employee_ptax)) {foreach ($employee_ptax as $val) {?>
					<tr class="part">
						<td><?php echo $i; ?></td>
						<!-- <td><?php echo $val->month_yr; ?></td> -->
						<td style="text-align:right;"><?php

    $total_calculation += $val->emp_pf_mtd + $val->emp_pf + $val->emp_pf_employer_mtd + $val->emp_pf_employer + $val->opening_data;
    echo $val->emp_pf;?></td>
						<td style="text-align:right;"><?php echo $val->emp_pf_employer; ?></td>
						<td style="text-align:right;"><?php echo $val->emp_pf_mtd + $val->emp_pf_employer_mtd + $val->opening_data; ?></td>
						<td style="text-align:right;"><?php echo $val->emp_pf_mtd + $val->emp_pf + $val->emp_pf_employer_mtd + $val->emp_pf_employer + $val->opening_data; ?></td>

					</tr>
				<?php $i++;}}?>
					<tr>
	<?php $number = $total_calculation;
$no = round($number);
$point = round($number - $no, 2) * 100;
$hundred = null;
$digits_1 = strlen($no);
$i = 0;
$str = array();
$words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str[] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
    } else {
        $str[] = null;
    }

}
$str = array_reverse($str);
$result = implode('', $str);
$points = ($point) ?
"." . $words[$point / 10] . " " .
$words[$point = $point % 10] : '';
//echo $result . "Rupees  " . $points . " Paise"; ?>
				<td style="font-weight:600;" colspan="4">Total in words: RUPEES <?php echo strtoupper($result); ?>  </td>
				<td style="font-weight:600;text-align:right;"><?php echo $total_calculation; ?></td>
			</tr>

				</tbody>
			</table>

	<!------------------------------------->
</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>