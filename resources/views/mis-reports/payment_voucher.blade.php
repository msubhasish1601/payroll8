<!DOCTYPE html>
<html lang="en">
<head>
  <title>BELLEVUE | Receipt Voucher Report</title>
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
/*tfoot{position:fixed;bottom:0;width:100%;}
.bank-state.header table{position:fixed;top:0;}*/
/*.footer{position:relative;}
.footer table{position:fixed;bottom:0;}*/
.sub{padding:3px 3px 3px 4%;}
.sub2{padding:3px 3px 3px 6%;}
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
<!-------------------income-expenditure-account------------------------->
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
                <h4>Payment Voucher Report<br> From {{\Carbon\Carbon::parse($start)->format('d-m-Y')}} to {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</h4>
				</div>

			</td>
			</tr>
		</table>

<table border="0" style="width:100%;border-collapse:collapse;">
	<thead style="background:#f4f5f5">
		<tr>
            {{-- <th style="padding:3px;width:50px;">Sl. No.</th> --}}
            <th style="padding:3px;width:100px;">Voucher No.</th>
			<th style="padding:3px;width:100px;" class="center">Date</th>
			<th style="padding:3px;width:500px;">Particulars</th>
			<th style="padding:3px;width:100px;">Debit</th>
			<th style="padding:3px;width:100px;">Credit</th>
		</tr>
	</thead>
	<tbody>
        @foreach($payment_details as $payment_detail)
		<tr>
            <td style="padding:3px;">{{ \Carbon\Carbon::parse($payment_detail['payment_release_date'])->format('d-m-Y') }}</td>
            <td style="padding:3px;">{{ $payment_detail['voucher_no'] }}</td>
            <td style="padding:3px 3px 3px 3%;"> {{ $payment_detail['dr_account'] }} </td>
			<td style="padding:3px;" class="center">{{ $payment_detail['amt'] }}</td>
            <td style="padding:3px;" class="center"></td>
        </tr>
        <tr>
            <td style="padding:3px;"></td>
            <td style="padding:3px;"></td>
            <td style="padding:3px 3px 3px 3%;">{{ $payment_detail['cr_account'] }} <br> {{ $payment_detail['narration'] }}</td>
			<td style="padding:3px;" class="center"></td>
            <td style="padding:3px;" class="center">{{ $payment_detail['amt'] }}</td>

        </tr>
        @endforeach

        {{-- @foreach($receipt_details as $receipt_detail_1)
		<tr>
            <td style="padding:3px;"></td>
            <td style="padding:3px;"></td>
			<td style="padding:3px;"></td>

        </tr>
        @endforeach --}}
	</tbody>
</table>

</div>
<!------------------------------------------------->


</body>

</html>
