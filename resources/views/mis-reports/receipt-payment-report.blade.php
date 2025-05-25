<!DOCTYPE html>
<html lang="en">
<head>
  <title>BELLEVUE | Summary of Receipt &amp; Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
  <style>
body {-webkit-print-color-adjust: exact;font-family:cambria;}
payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 35px;color: #000;text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 19px;text-align:center;margin:0;}
	.payslip .pay-month{text-align:center;}
	.payslip .pay-month h3{margin:0;color: #000;}
	.pay-logo img {max-width: 80px;}
.bank-state table td h2, .bank-state table td h1{text-align:center;}
.bank-state table tr td{vertical-align:top;}
table{width:100%;}
.acnt thead tr th, .acnt tr td{padding:2px 3px;font-size:14px;}
.acnt .head td{background:#ddd;font-weight:600;text-align:center;}.left{text-align:left;}
.center{text-align:center;}.right{text-align:right;}
tbody{height:100%;}
li{padding-bottom:5px;}
.ledger tr td{padding:3px;font-size:14px;}
	.sub{padding-left:30px;}.sub2{padding-left:40px;}
/*tfoot{position:fixed;bottom:0;width:100%;}
.bank-state.header table{position:fixed;top:0;}*/
/*.footer{position:relative;}
.footer table{position:fixed;bottom:0;}*/
	@media print
{
 table {page-break-after: auto;}
  tr    {page-break-inside:avoid !important; page-break-after:auto !important; }
  td    { page-break-inside:avoid !important; page-break-after:auto !important; }
  thead { display:table-header-group !important; }


  tfoot { display:table-footer-group !important;}
 @page {
	size:auto;
    margin-top:0;
	margin-bottom: 0;

	}

}
  </style>
</head>
<body>
<!-------------------Designated-fund-head------------------------>
<div class="payslip">
<table class="comp-det" style="width:100%;">
		<tr>

			<td>
			<div class="pay-logo">
					<img src="{{asset('images/logo2.png')}}" alt="logo">
				</div>
			</td>
			<td>
				<div class="text-center pay-head" style="margin-bottom:20px;">
				<h2>BELLEVUE</h2>
				<!--<h3 style="text-align:center;margin:0;">Establishment Account</h3>-->
				<h4>Consolidated Receipt &amp; Pament Statement</h4>
				<h4>As On 31 st March, 2019 in respect of Establishment Account, Stipend Account</h4>
				</div>

			</td>
			</tr>
		</table>

@php
	$total_receipt=0;
	$total_payment=0;
@endphp
<!--------------------------fund-body------------------------>
<table style="width:100%">
	<thead><tr>
			<th colspan="3" style="padding:4px;border:none;" class="right"></th>
		</tr>
	</thead>
</table>
<table border="1" style="border-collapse:collapse;width:100%;">

	<thead style="background:#ddd;">

		<tr>
			<th style="width:50%;padding:4px;">Payment </th>
			<th style="width:20%;padding:4px;">Current Year</th>
			<th style="width:20%;padding:4px;">Previous Year</th>
		</tr>

	</thead>
	<tbody>
		<tr>
			<td style="padding:3px;"><b>Establishment Account:</b></td>
			<td style="padding:3px;" class="right"></td>
			<td style="padding:3px;" class="right"></td>
		</tr>
		<tr>
			<td style="padding:3px;">Establishment Account</td>
			<td style="padding:3px;" class="right">@if (!empty($payment[0]->total_payment))  {{$payment[0]->total_payment}} @endif</td>
			<td style="padding:3px;" class="right"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>Stipend Account:</b></td>
			<td style="padding:3px;" class="right"></td>
			<td style="padding:3px;" class="right"></td>
		</tr>
		<tr>
			<td style="padding:3px;">Stipend Account</td>
			<td style="padding:3px;" class="right">{{ $stipend_graduate[0]->total_graduate+$stipend_diploma[0]->total_diploma}}</td>
			<td style="padding:3px;" class="right"></td>
		</tr>

		@php 
			$total_payment= $payment[0]->total_payment+$stipend_graduate[0]->total_graduate+$stipend_diploma[0]->total_diploma; 
		@endphp
		<tr>
			<td style="padding:3px;"><b>Total</b></td>
			<td style="padding:3px;" class="right">{{$total_payment}}</td>
			<td style="padding:3px;" class="center"></td>
		</tr>

		<tr style="background:#ddd;">
			<td style="padding:3px;" class="center"><b>Receipt </b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;" class="center"><b></b></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>Establishment Account:</b></td>
			<td style="padding:3px;" class="right"></td>
			<td style="padding:3px;" class="right"></td>
		</tr>
		<tr>
			<td style="padding:3px;">Establishment Account</td>
			<td style="padding:3px;" class="right">@if (!empty($receipt[0]->total_receipt)) {{$receipt[0]->total_receipt}} @endif</td>
			<td style="padding:3px;" class="right"></td>
		</tr>
		

		
		<tr>
			<td style="padding:3px;"><b>Total</b></td>
			<td style="padding:3px;" class="right">@if (!empty($receipt[0]->total_receipt)) {{$receipt[0]->total_receipt}} @endif</td>
			<td style="padding:3px;" class="center"></td>
		</tr>

	</tbody>
</table>


<!----------------------------------------------------->
</div>
<!------------------------------------------------->

</body>

</html>
