<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bellevue</title>
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
.sub{padding: 0 0 0 15px;}
	@media print
}
{
 table {page-break-after: auto;}
  tr    {page-break-inside:avoid !important; page-break-after:auto !important; }
  td    { page-break-inside:avoid !important; page-break-after:auto !important; }
  thead { display:table-header-group !important; }


  tfoot { display:table-footer-group !important;}
 @page {
	size:landscape;
   margin:5px 10px;

	}

}
  </style>
</head>
<body>
<!-------------------Designated-fund-head------------------------>
<div class="payslip">
<table class="comp-det" style="width:100%;font-size:12px;">
		<tr>

			<td>
			<div class="pay-logo">
					<!-- <img src="{{asset('images/logo2.png')}}" alt="logo"> -->
				</div>
			</td>
			<td>
				<div class="text-center pay-head" style="margin-bottom:20px;">
				<h2>Bellevue</h2>
				<!--<h3 style="text-align:center;margin:0;">Establishment Account</h3>-->
				<!-- <h4>Leave Schedule</h4> -->
				</div>

			</td>
			</tr>

		</table>

<!----------------------------------------------------->


<!---------------------------------------------->
<?php

?>
<table style="text-align:left;width:100%;">
	<tr>
    <td class="text-align:left;"><b>Employee Name : {{ $tour_apply['emp_name'] }}</b></td>
		<td class="text-align:left;"><b>Employee Code : {{  $tour_apply['emp_code'] }}</b></td>
	</tr>
	<tr>
		<td class="text-align:left;"><b>From Date : {{ \Carbon\Carbon::parse($tour_apply['from_date'])->format('d-m-Y') }}</b></td>
		<td class="text-align:left;"><b>To Date : {{ \Carbon\Carbon::parse($tour_apply['to_date'])->format('d-m-Y') }}</b></td>
	</tr>
</table>
<table border="1" style="border-collapse: collapse;">
	<tr>
		<thead>
		<th>Sl. No.</th>
		<th>Date</th>
		<th>Name of Establishment/Institute</th>
		<th>Place</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>

        @foreach($tour_dtl as $value)
		<tr>
            <td class="center">{{$loop->iteration}}</td>
            <td>{{ \Carbon\Carbon::parse($value->tour_date_dtl)->format('d-m-Y') }}</td>
			<td>{{$value->establishment_dtl}}</td>
			<td>{{$value->place_name}}</td>
			<td>{{$value->status}}</td>
		</tr>
        @endforeach


		<tr>
			<td colspan="5" style="border-bottom: none;">* Total advance proposed for release is  <span style="border-bottom:2px dotted #000;">{{ $tour_apply['advanced'] }}</span></td>
		</tr>
		<tr>
			<td colspan="5" style="border-top: none;">TA advance as per rule. Please be paid.</td>
		</tr>
	</tbody>
</table>
<!----------------------------------------------------------->
</div>
<!------------------------------------------------->


</body>

</html>
