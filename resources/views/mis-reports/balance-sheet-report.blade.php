<!DOCTYPE html>
<html lang="en">
<head>
  <title>BELLEVUE | Balance Sheet</title>
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
				<h4>Establishment Account</h4>
                <h4>Balance Sheet As on 31st March, {{$toyear}}</h4>
				</div>

			</td>
			</tr>
		</table>


<!--------------------------fund-body------------------------>
<table style="width:100%">
	<thead><tr>
			<th colspan="4" style="padding:4px;border:none;" class="right">Amount in Rs.</th>
		</tr>
	</thead>
</table>
<table border="1" style="border-collapse:collapse;width:100%;">

	<thead>

		<tr>
			<th style="width:60%;padding:4px;">Sources of Funds</th>
			<th style="width:10%;padding:4px;;">Schedule</th>
			<th style="width:10%;padding:4px;">Current Year</th>
			<th style="width:10%;padding:4px;">Previous Year</th>
		</tr>

	</thead>
	<tbody>
            @php $currentyear_total_income = 0; @endphp
            @if(!empty($currentyear_income_list))
            @foreach( $currentyear_income_list as $income_list)

			<tr>
				<td style="padding:3px;"><b>{{ $income_list['schedule_name'] }}</b></td>
                <td style="padding:3px;" class="center">{{  $income_list['schedule_code'] }}</td>
                @if(!empty($income_list['payable_amt']))
				<td class="right" style="padding:3px;">{{ $income_list['payable_amt'] }}</td>
				@else
				<td class="right" style="padding:3px;">0</td>
				@endif
                <td class="right" style="padding:3px;">0</td>
            </tr>
            @php $currentyear_total_income += $income_list['payable_amt']; @endphp
            @endforeach
			@endif

			<tr>
				<td style="padding:3px;" class="center"><b>TOTAL</b></td>
				<td style="padding:3px;"></td>
				<td class="right" style="padding:3px;"><b>{{ $currentyear_total_income }}</b></td>
				<td class="right" style="padding:3px;"><b>0</b></td>
			</tr>
		<tr style="border-left:none;border-right:none;"><td colspan="4" style="padding:3px;">&nbsp;</td></tr>
	</tbody>
	<thead>

		<tr>
			<th style="width:60%;padding:4px;">Application of Funds</th>
			<th style="width:10%;padding:4px;;">Schedule</th>
			<th style="width:10%;padding:4px;">Current Year</th>
			<th style="width:10%;padding:4px;">Previous Year</th>
		</tr>

	</thead>
	<tbody>
            @php $currentyear_total_expenditure=0; @endphp
			@if(!empty($currentyear_expenditure_list))
            @foreach($currentyear_expenditure_list as $current_expenditure)

			<tr>
				<td style="padding:3px;"><b>{{ $current_expenditure['schedule_name'] }}</b> </td>
				<td style="padding:3px;" class="center">{{  $current_expenditure['schedule_code'] }}</td>
				@if(!empty($current_expenditure['payable_amt']))
				<td class="right" style="padding:3px;">{{ $current_expenditure['payable_amt'] }}</td>
				@else
				<td class="right" style="padding:3px;">0</td>
				@endif
				<td class="right" style="padding:3px;">0</td>
			</tr>
			@php $currentyear_total_expenditure+=$current_expenditure['payable_amt']; @endphp
			@endforeach
			@endif
			<tr>
				<td style="padding:3px;" class="center"><b>TOTAL</b></td>
				<td style="padding:3px;"></td>
				<td class="right" style="padding:3px;"><b>{{ $currentyear_total_expenditure }}</b></td>
				<td class="right" style="padding:3px;"><b>0</b></td>
			</tr>



	</tbody>
</table>
<table>
<tr style="border:none;border-bottom:none;">
		<td style="padding:3px;width:40%;">SIGNIFICANT ACCOUNTING POLICIES</td>
		<td class="center" style="width:20%;">23</td>
		<td style="width:20%;"></td>
		<td style="width:20%;"></td>
	</tr>
	<tr style="border:none;border-top:none;border-bottom:none;">
		<td style="padding:3px;width:60%;">CONTINGENT LIABILITIES AND NOTED TO ACCOUNTS</td>
		<td style="width:10%;" class="center">24</td>
		<td style="width:10%;"></td>
		<td style="width:10%;"></td>
	</tr>
</table>
<!----------------------------------------------------->
</div>
<!------------------------------------------------->

</body>

</html>
