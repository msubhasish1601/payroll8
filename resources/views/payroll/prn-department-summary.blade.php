<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ config('app.name', 'Laravel') }}</title>
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
                @if(!empty($company_rs ))
				<h1 style="margin-bottom: 0;text-align: center;">{{$company_rs->company_name}}</h1>
                        <h2 style="margin:0;text-align: center;">{{$company_rs->company_address}}</h3>
                        @endif
					<h4>Department Summary Report for <?php echo $req_month; ?> </h4>

				</div>
			</td>

			</tr>
		</table>

			<table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
				<thead>
                <tr>
										    <th style="width:5%;">Sl. No.</th>
											<th style="width:8%;">Department Name</th>
											<th style="width:12%;">Basic<br>OTH ALW<br>PF<br>PF INT</th>
											<th style="width:18%;">DA<br>MISC ALW<br>APF<br>ADV</th>
											<th style="width:15%;">VDA<br>OVER TIME<br>PROF. TAX<br>HRD</th>
											<th style="width:10%;">TIFF ALW<br>LEAVE ENC<br>INSU PREM<br>FURNITURE</th>
											<th >CONV<br>HTA<br>PF LOAN<br>MISC DED</th>
											<th >MEDICAL<br>TOT INC<br>ESI<br>TOT DED</th>
											<th >NET PAY</th>
										</tr>
				</thead>
                <tbody>
										<?php //print_r($result);?>
                                        @php
                                            $total_basic=0;
                                            $total_othalw=0;
                                            $total_pf=0;
                                            $total_pfint=0;
                                            $total_da=0;
                                            $total_miscalw=0;
                                            $total_apf=0;
                                            $total_adv=0;
                                            $total_vda=0;
                                            $total_ot=0;
                                            $total_ptax=0;
                                            $total_hrd=0;
                                            $total_tiffalw=0;
                                            $total_leave_enc=0;
                                            $total_insu_prem=0;
                                            $total_furniture=0;
                                            $total_conv=0;
                                            $total_hta=0;
                                            $total_pfloan=0;
                                            $total_misc_ded=0;
                                            $total_medical=0;
                                            $total_totinc=0;
                                            $total_esi=0;
                                            $total_ded=0;
                                            $total_netpay=0;
                                        @endphp
                                        @foreach ($result as $index=>$record)
                                        @php
                                            $total_basic=$total_basic+$record->emp_basic_pay;
                                            $total_othalw=$total_othalw+$record->emp_others_alw;
                                            $total_pf=$total_pf+$record->emp_pf;
                                            $total_pfint=$total_pfint+$record->emp_pf_int;
                                            $total_da=$total_da+$record->emp_da;
                                            $total_miscalw=$total_miscalw+$record->emp_misc_alw;
                                            $total_apf=$total_apf+$record->emp_apf;
                                            $total_adv=$total_adv+$record->emp_adv;
                                            $total_vda=$total_vda+$record->emp_vda;
                                            $total_ot=$total_ot+$record->emp_over_time;
                                            $total_ptax=$total_ptax+$record->emp_prof_tax;
                                            $total_hrd=$total_hrd+$record->emp_hrd;
                                            $total_tiffalw=$total_tiffalw+$record->emp_tiff_alw;
                                            $total_leave_enc=$total_leave_enc+$record->emp_leave_inc;
                                            $total_insu_prem=$total_insu_prem+$record->emp_insu_prem;
                                            $total_furniture=$total_furniture+$record->emp_furniture;
                                            $total_conv=$total_conv+$record->emp_conv;
                                            $total_hta=$total_hta+$record->emp_hta;
                                            $total_pfloan=$total_pfloan+$record->emp_pf_loan;
                                            $total_misc_ded=$total_misc_ded+$record->emp_misc_ded;
                                            $total_medical=$total_medical+$record->emp_medical;
                                            $total_totinc=$total_totinc+$record->emp_gross_salary;
                                            $total_esi=$total_esi+$record->emp_esi;
                                            $total_ded=$total_ded+$record->emp_total_deduction;
                                            $total_netpay=$total_netpay+$record->emp_net_salary;
                                        @endphp

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
											<td>{{$record->emp_department}}</td>
											<td>{{$record->emp_basic_pay}}<br>{{$record->emp_others_alw}}<br>{{$record->emp_pf}}<br>{{$record->emp_pf_int}}</td>
											<td>{{$record->emp_da}}<br>{{$record->emp_misc_alw}}<br>{{$record->emp_apf}}<br>{{$record->emp_adv}}</td>
											<td>{{$record->emp_vda}}<br>{{$record->emp_over_time}}<br>{{$record->emp_prof_tax}}<br>{{$record->emp_hrd}}</td>
											<td>{{$record->emp_tiff_alw}}<br>{{$record->emp_leave_inc}}<br>{{$record->emp_insu_prem}}<br>{{$record->emp_furniture}}</td>
											<td>{{$record->emp_conv}}<br>{{$record->emp_hta}}<br>{{$record->emp_pf_loan}}<br>{{$record->emp_misc_ded}}</td>
											<td>{{$record->emp_medical}}<br>{{$record->emp_gross_salary}}<br>{{$record->emp_esi}}<br>{{$record->emp_total_deduction}}</td>
											<td>{{$record->emp_net_salary}}</td>
                                        </tr>
                                        @endforeach
									</tbody>
                                    <tfoot>
										<tr>
											<td colspan="2" style="border:none;font-weight:700;">
											Grand Total
											</td>
											<td>
                                                <div class="total_basic" style="font-weight:700;">{{$total_basic}}</div>
                                                <div class="total_othalw" style="font-weight:700;">{{$total_othalw}}</div>
                                                <div class="total_pf" style="font-weight:700;">{{$total_pf}}</div>
                                                <div class="total_pfint" style="font-weight:700;">{{$total_pfint}}</div>
                                            </td>
											<td>
                                                <div class="total_da" style="font-weight:700;">{{$total_da}}</div>
                                                <div class="total_miscalw" style="font-weight:700;">{{$total_miscalw}}</div>
                                                <div class="total_apf" style="font-weight:700;">{{$total_apf}}</div>
                                                <div class="total_adv" style="font-weight:700;">{{$total_adv}}</div>
                                            </td>
											<td>
                                                <div class="total_vda" style="font-weight:700;">{{$total_vda}}</div>
                                                <div class="total_ot" style="font-weight:700;">{{$total_ot}}</div>
                                                <div class="total_ptax" style="font-weight:700;">{{$total_ptax}}</div>
                                                <div class="total_hrd" style="font-weight:700;">{{$total_hrd}}</div>
                                            </td>
											<td>
                                                <div class="total_tiffalw" style="font-weight:700;">{{$total_tiffalw}}</div>
                                                <div class="total_leave_enc" style="font-weight:700;">{{$total_leave_enc}}</div>
                                                <div class="total_insu_prem" style="font-weight:700;">{{$total_insu_prem}}</div>
                                                <div class="total_furniture" style="font-weight:700;">{{$total_furniture}}</div>
                                            </td>
											<td>
                                                <div class="total_conv" style="font-weight:700;">{{$total_conv}}</div>
                                                <div class="total_hta" style="font-weight:700;">{{$total_hta}}</div>
                                                <div class="total_pfloan" style="font-weight:700;">{{$total_pfloan}}</div>
                                                <div class="total_misc_ded" style="font-weight:700;">{{$total_misc_ded}}</div>
                                            </td>
											<td>
                                                <div class="total_medical" style="font-weight:700;">{{$total_medical}}</div>
                                                <div class="total_totinc" style="font-weight:700;">{{$total_totinc}}</div>
                                                <div class="total_esi" style="font-weight:700;">{{$total_esi}}</div>
                                                <div class="total_ded" style="font-weight:700;">{{$total_ded}}</div>
                                            </td>
											<td>
                                                <div class="total_netpay" style="font-weight:700;">{{$total_netpay}}</div>
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
