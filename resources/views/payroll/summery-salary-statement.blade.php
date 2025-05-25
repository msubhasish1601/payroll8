<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon"/>
  <style type="text/css" media="print"> @page { size: auto; /* auto is the initial value */
   	margin-top: 0;
    margin-bottom: 0; /* this affects the margin in the printer settings */ }
   </style>
  <style>
body {-webkit-print-color-adjust: exact;}
  	.payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 35px;color: #292929;text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 17px;text-align:right;margin:0;}
	.payslip .pay-month{text-align:center;}
	.payslip .pay-month h3{margin:0;color: #0099be;}
	.pay-logo img {max-width: 75px;}
	.emp-det{width:100%;}
	.emp-det thead tr th{text-align:center;}
	.emp-det thead tr th{border-bottom:none;}
	.emp-det thead tr th {border-bottom: none;background: #a7a8a9;color: #000;padding: 5px 10px;font-size: 16px;}
	.emp-det tbody tr td{padding:5px 10px;font-size:14px;}
	table.emp-det tr td span {font-weight: 600;}
	.sal-det tr th {background: #a7a8a9;padding: 5px 10px;border-bottom: none;color: #000;text-align:center;}
	.emp-det tr.part td{padding:5px 10px;text-align:left;font-weight:600;border-top:none;background:#efefef;}
	.sal-det tr td{padding:7px 10px;text-align:left;}
	.sal-det tr td p{text-align:right;margin:0;}.mon{text-align:center;}.mon h3{color:#0099be;margin:0;font-size:25px;}.mon h4{margin:0;font-size: 24px;}
	.sal-det tr:nth-child(odd) {background-color: #f2f2f2;}
	.emp-det{border-bottom:none;}.total td{font-weight:600;}.leave{border-top:none;}
	.leave tr th{padding:5px 10px;text-align:left;}.leave{}.leave table tr td{text-align:center;}.part td i {font-size: 12px;}
	@media print
{
  table { page-break-after:auto !important; }
  tr    { page-break-inside:avoid !important; page-break-after:auto !important; }
  td    { page-break-inside:avoid !important; page-break-after:auto !important; }
  thead { display:table-header-group !important; }
  tfoot { display:table-footer-group !important; }
}
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
						@if(!empty($company_rs ))
                        <h1 style="margin-bottom: 0;">{{$company_rs->company_name}}</h1>
                        <h2 style="margin:0;">{{$company_rs->company_address}}</h3>
                        @endif
					<?php if (count($payroll_rs) > 0) {?>
					<?php
$dt = $payroll_rs[0]->month_yr;
    $dtar = explode('/', $dt);
    $paymonth = $monthName = strftime('%B', mktime(0, 0, 0, $dtar[0]));
    ?>
					<h4>Salary Statement for the month of <?php echo $paymonth . ' - ' . $dtar[1]; ?></h4>
				<?php }?>
				</div>
			</td>
			</tr>
		</table>
	<!--------------------------->
	<!--------------employee-details--------------->

		<?php if (!empty($payroll_rs)) {?>
		 <?php $totalbasic_pay = 0;?>
					  <?php $totalda = 0;?>
               <?php $totalvda = 0;?>
               <?php $totalhra = 0;?>
               <?php $totalothers_alw = 0;?>
               <?php $totaltiff_alw = 0;?>
               <?php $totalconv = 0;?>
               <?php $totalmedical = 0;?>
               <?php $totalmisc_alw = 0;?>
               <?php $totalover_time = 0;?>
               <?php $totalbouns = 0;?>
               <?php $totalleave_inc = 0;?>
               <?php $totalhta = 0;?>

               <?php $totalother_addition = 0;?>
						 <?php $totalgross_salary = 0;?>
						   <?php $totalprof_tax = 0;?>
               <?php $totalpf = 0;?>
               <?php $totalpf_int = 0;?>
               <?php $totalapf = 0;?>
               <?php $totali_tax = 0;?>
               <?php $totalinsu_prem = 0;?>
               <?php $totalpf_loan = 0;?>
               <?php $totalesi = 0;?>
			   <?php $totaladv = 0;?>
			     <?php $totalhrd = 0;?>
				   <?php $totalco_op = 0;?>
				     <?php $totalfurniture = 0;?>
				     <?php $totalpf_employer = 0;?>
					  <?php $totalmisc_ded = 0;?>
               <?php $totalincome_tax = 0;?>
               <?php $totalothers_deduction = 0;?>
						 <?php $totaltotal_deduction = 0;?>
						 <?php $totalnet_salary = 0;?>


		<?php
$total_earnings = 0;
    $total_deduction = 0;

    $total_gross_salary = 0;
    $total_net_salary = 0;
    $total_deduction_salary = 0;

    foreach ($payroll_rs as $payroll) {
        $totalbasic_pay += (float) str_replace(',', '', $payroll->emp_basic_pay);
        $totalda += (float) str_replace(',', '', $payroll->emp_da);
        $totalvda += (float) str_replace(',', '', $payroll->emp_vda);
        $totalhra += (float) str_replace(',', '', $payroll->emp_hra);
        $totalothers_alw += (float) str_replace(',', '', $payroll->emp_others_alw);
        $totaltiff_alw += (float) str_replace(',', '', $payroll->emp_tiff_alw);
        $totalconv += (float) str_replace(',', '', $payroll->emp_conv);
        $totalmedical += (float) str_replace(',', '', $payroll->emp_medical);
        $totalmisc_alw += (float) str_replace(',', '', $payroll->emp_misc_alw);
        $totalover_time += (float) str_replace(',', '', $payroll->emp_over_time);
        $totalbouns += (float) str_replace(',', '', $payroll->emp_bouns);
        $totalleave_inc += (float) str_replace(',', '', $payroll->emp_leave_inc);
        $totalhta += (float) str_replace(',', '', $payroll->emp_hta);

        $totalother_addition += (float) str_replace(',', '', $payroll->other_addition);
        $totalgross_salary += (float) str_replace(',', '', $payroll->emp_gross_salary);
        $totalprof_tax += (float) str_replace(',', '', $payroll->emp_prof_tax);
        $totalpf += (float) str_replace(',', '', $payroll->emp_pf);
        $totalpf_int += (float) str_replace(',', '', $payroll->emp_pf_int);
        $totalapf += (float) str_replace(',', '', $payroll->emp_apf);
        $totali_tax += (float) str_replace(',', '', $payroll->emp_i_tax);
        $totalinsu_prem += (float) str_replace(',', '', $payroll->emp_insu_prem);

        $totalpf_loan += (float) str_replace(',', '', $payroll->emp_pf_loan);
        $totalesi += (float) str_replace(',', '', $payroll->emp_esi);
        $totaladv += (float) str_replace(',', '', $payroll->emp_adv);
        $totalhrd += (float) str_replace(',', '', $payroll->emp_hrd);
        $totalco_op += (float) str_replace(',', '', $payroll->emp_co_op);
        $totalfurniture += (float) str_replace(',', '', $payroll->emp_furniture);
        $totalpf_employer += (float) str_replace(',', '', $payroll->emp_pf_employer);
        $totalmisc_ded += (float) str_replace(',', '', $payroll->emp_misc_ded);
        $totalincome_tax += (float) str_replace(',', '', $payroll->emp_income_tax);
        $totalothers_deduction += (float) str_replace(',', '', $payroll->emp_others_deduction);
        //echo "==".$payroll->emp_total_deduction."<br>";
        $totaltotal_deduction += (float) str_replace(',', '', $payroll->emp_total_deduction);
        $totalnet_salary += (float) str_replace(',', '', $payroll->emp_net_salary);

        //dd($payroll);

    }

    $total_earnings = $totalbasic_pay + $totalda + $totalvda + $totalhra + $totalothers_alw + $totaltiff_alw + $totalconv + $totalmedical +
        $totalmisc_alw + $totalover_time + $totalbouns + $totalleave_inc + $totalhta + $totalother_addition;

    $total_deduction = $totalprof_tax + $totalpf + $totalpf_int + $totalapf + $totali_tax + $totalinsu_prem + $totalpf_loan + $totalesi
         + $totaladv + $totalhrd + $totalco_op + $totalfurniture + $totalpf_employer + $totalmisc_ded + $totalincome_tax + $totalothers_deduction;

    ?>

		<table border="1" class="emp-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">

	<!------------------------------------------>

	<!------------Salary-details----------------->
				<thead>
					<tr>
						<th colspan="2" width="50%">Earnings</th>
						<th colspan="2" width="50%">Deduction</th>
					</tr>
				</thead>
				<tbody>
					<tr class="part">
						<td>Particulars</td>
						<td style="text-align:right;">Amount (<img src="{{ asset('theme/images/rupee.png') }}" alt="" style="width: 8px;vertical-align: middle;">)</td>
						<td>Particulars</td>
						<td style="text-align:right;">Amount (<img src="{{ asset('theme/images/rupee.png') }}" alt="" style="width: 8px;vertical-align: middle;">)</td>
					</tr>

					<tr>

						<td>Basic Pay</td>
						<td style="text-align:right;"><?php echo $totalbasic_pay; ?></td>
						<td>PROF TAX</td>
						<td style="text-align:right;"><?php echo $totalprof_tax; ?></td>
					</tr>
					<tr>

						<td>DA</td>
						<td style="text-align:right;"><?php echo $totalda; ?></td>
						<td>PF</td>
						<td style="text-align:right;"><?php echo $totalpf; ?></td>
					</tr>
					<tr>

						<td>VDA</td>
						<td style="text-align:right;"><?php echo $totalvda; ?></td>
						<td>PF INT</td>
						<td style="text-align:right;"><?php echo $totalpf_int; ?></td>
					</tr>
					<tr>

						<td>HRA</td>
						<td style="text-align:right;"><?php echo $totalhra; ?></td>
						<td>APF</td>
						<td style="text-align:right;"><?php echo $totalapf; ?></td>
					</tr>
					<tr>

						<td>TIFF ALW.</td>
						<td style="text-align:right;"><?php echo $totaltiff_alw; ?></td>
						<td>I TAX</td>
						<td style="text-align:right;"><?php echo $totali_tax; ?></td>
					</tr>
					<tr>

						<td>OTH ALW</td>
						<td style="text-align:right;"><?php echo $totalothers_alw; ?></td>
						<td>INSU PERM</td>
						<td style="text-align:right;"><?php echo $totalinsu_prem; ?></td>
					</tr>
					<tr>

						<td>CONV</td>
						<td style="text-align:right;"><?php echo $totalconv; ?></td>
						<td>PF LOAN</td>
						<td style="text-align:right;"><?php echo $totalpf_loan; ?></td>
					</tr>
					<tr>

						<td>MEDICAL</td>
						<td style="text-align:right;"><?php echo $totalmedical; ?></td>
						<td>ESI</td>
						<td style="text-align:right;"><?php echo $totalesi; ?></td>
					</tr>
					<tr>

						<td>MISC ALW</td>
						<td style="text-align:right;"><?php echo $totalmisc_alw; ?></td>
						<td>ADV</td>
						<td style="text-align:right;"><?php echo $totaladv; ?></td>
					</tr>
					<tr>

						<td>OVER TIME</td>
						<td style="text-align:right;"><?php echo $totalover_time; ?></td>
						<td>HRD</td>
						<td style="text-align:right;"><?php echo $totalhrd; ?></td>
					</tr>
					<tr>

						<td>BONUS</td>
						<td style="text-align:right;"><?php echo $totalbouns; ?></td>
						<td>CO-OP</td>
						<td style="text-align:right;"><?php echo $totalco_op; ?></td>
					</tr>
					<tr>

						<td>LEAVE ENC</td>
						<td style="text-align:right;"><?php echo $totalleave_inc; ?></td>
						<td>FURNITURE</td>
						<td style="text-align:right;"><?php echo $totalfurniture; ?></td>
					</tr>
					<tr>

						<td>HTA</td>
						<td style="text-align:right;"><?php echo $totalhta; ?></td>
						<td>MISE DED</td>
						<td style="text-align:right;"><?php echo $totalmisc_ded; ?></td>
					</tr>



					<tr>



						<td rowspan="2">Other </td>
						<td rowspan="2" style="text-align:right;"><?php echo $totalother_addition; ?></td>

						<!-- <td>Income Tax</td>
						<td style="text-align:right;"><?php echo $totalincome_tax; ?></td> -->
					</tr>
					<!-- <tr>

					<td>Employer PF Contribution</td>
						<td style="text-align:right;"><?php echo $totalpf_employer; ?></td>


					</tr> -->


					<tr>

						<td>Others</td>
						<td style="text-align:right;"><?php echo $totalothers_deduction; ?></td>

					</tr>





					<tr class="total">
						<td>Total</td>
						<td style="text-align:right;"><?php echo $total_earnings; ?></td>
						<td>Total</td>
						<td style="text-align:right;"><?php echo $total_deduction; ?></td>
					</tr>

					<tr>
						<td style="font-weight:600;border-right:none;" colspan="2"></td>
						<td style="font-weight:600;text-align:left;border-left:none;">Total Earnings</td>
						<td style="font-weight:600;text-align:right;border-left: none;"><?php echo $totalgross_salary; ?></td>

					</tr>

					<tr>
						<td style="font-weight:600;border-right:none;" colspan="2">
						<td style="font-weight:600;text-align:left;border-left: none;">Total Deduction</td>
						<td style="font-weight:600;text-align:right;border-left: none;"><?php echo $totaltotal_deduction; ?></td>

					</tr>
					<tr>

   <?php $number = $totalnet_salary;
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
    // $points = ($point) ?
    // "." . $words[$point / 10] . " " .
    // $words[$point = $point % 10] : '';
    //echo $result . "Rupees  " . $points . " Paise"; ?>

						<td colspan="2" style="border-right:none;font-weight:600;text-align:left;font-size:16px;"></td>
						<td style="font-weight:600;text-align:left;border-left: none;font-size:16px;">Net Pay</td>
						<td style="font-weight:600;text-align:right;border-left: none;"> <?php echo $totalnet_salary; ?></td>

					</tr>

					<tr>

						<td style="font-weight:600;text-align:right;font-size:14px;" colspan="4">Net Pay in Words (RUPEES <?php echo strtoupper($result); ?>)</td>

					</tr>

					<tr>
						<td style="padding-top:5%;text-align:center;font-weight:600;">Dealing Assistant</td>
						<td style="padding-top:5%;text-align:center;font-weight:600;">Junior Accountant</td>
						<td style="padding-top:5%;text-align:center;font-weight:600;">Admin cum Accounts Officer</td>
						<td style="padding-top:5%;text-align:center;font-weight:600;">Director</td>
					</tr>
				</tbody>
			</table>
			<?php }?>
	<!------------------------------------->


</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>