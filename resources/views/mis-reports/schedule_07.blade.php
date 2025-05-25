<!DOCTYPE html>
<html lang="en">
<head>
<title>BELLEVUE | Schedule 7 | Current Assets</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
<style>
body {-webkit-print-color-adjust: exact;font-family:cambria;}
payslip{font-family:cambria;}
	.payslip .pay-head h2 {font-size: 35px;color: #000;text-align:center;margin:0;}
	.payslip .pay-head h4 {font-size: 14px;text-align:center;margin:0;}
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
.sub{padding:1px 1px 1px 4%;}
.sub2{padding:1px 1px 1px 6%;}
	@media print
{
 table {page-break-after: auto;}
  tr    {page-break-inside:avoid !important; page-break-after:auto !important; }
  td    { page-break-inside:avoid !important; page-break-after:auto !important; }
  thead { display:table-header-group !important; }


  tfoot { display:table-footer-group !important;}
 @page {
	size:auto;
    margin-top:15px;
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
      <td><div class="pay-logo"> <img src="{{asset('images/logo2.png')}}" alt="logo"> </div></td>
      <td><div class="text-center pay-head" style="margin-bottom:20px;">
          <h2>BELLEVUE</h2>
          <h3 style="text-align:center;margin:0;text-transform:uppercase;">Establishment Account</h3>
          <h4 style="text-transform:uppercase; ">Schedules Forming Part of Balance Sheet as on 31st March, <?php $year=explode("-",$financial_year); echo $year['1']; ?></h4>
        </div></td>
    </tr>
    <tr>
      <td colspan="2"><h4 style="text-decoration:underline;text-transform:uppercase;">Schedule 7 - Current Assets</h4></td>
    </tr>
  </table>
  <table>
    <tr>
      <th style="border-left:none; text-align:right;">Amount in Rupees</th>
    </tr>
  </table>
  <table border="1" style="width:100%;border-collapse:collapse;font-size:11px;">
    <thead style="background:#f5f4f4;">
      <tr>
        <th style="padding:2px;"></th>
        <th style="padding:2px;">Current Year</th>
        <th style="padding:2px;">Previous Year</th>
      </tr>
    </thead>
    <tbody>
	 @php $total_amt = 0;
        $total_A = 0;
        $tot_val=0;
         @endphp
        @foreach($schedule_det as $schedule_09)
        @php
        if(!empty($schedule_09['total_amount'])){
            $tot_val=$schedule_09['total_amount'];
        }
   else{
        $tot_val=0;
    }


       @endphp
		<tr>
			<td style="padding:3px;">{{ $schedule_09['account_name'] }}</td>
			
			<td style="padding:3px;" class="right">   @if($schedule_09['account_name']=='3. Cash in Hand')
               @php 
			   
			   
			    $schedule_01 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '07/004/001')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_02 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '07/004/002')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
				if(!empty($schedule_01->closing_balance)){
    $tot=$schedule_01->closing_balance;
}else{
    $tot=0;	
}
if(!empty($schedule_02->closing_balance)){
    $tot1=$schedule_02->closing_balance;
}else{
    $tot1=0;
}
echo($tot1+$tot);


			  @endphp

                @else
                {{ $tot_val }}
                @endif</td>
			<td style="padding:3px;" class="right">-</td>
		</tr>
		  @php $total_amt += $schedule_09['total_amount']; @endphp
        @endforeach
      <tr>
        <td style="padding:3px;text-align:right;"><b>TOTAL</b></td>
        <td class="right" style="padding:3px;"><b>{{ ($total_amt+$tot1+$tot) }}</b></td>
        <td class="right" style="padding:3px;"><b></b></td>
      </tr>
    </tbody>
  </table>
  <!-------------------annexure----------------------->

  <table class="comp-det" style="width:100%;margin-top:10px;font-size:11px;">
    <tr>
      <td><div class="text-center pay-head" style="margin-bottom:5px;">
          <h4>ANNEXURE A</h4>
        </div></td>
    </tr>
  </table>
  <table><tr><td class="right">Amount in Rupees</td></tr></table>
  <table border="1" style="border-collapse:collapse;font-size:11px;">
  <tr>
  	<td style="padding:1px;" class="center">I</td>
	<td style="padding:1px;"><b>Savings Bank Accounts</b></td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
   <tr>
  	<td style="padding:1px;" class="center">1</td>
	<td style="padding:1px;">Grants from UGC A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">2</td>
	<td style="padding:1px;">University Receipts A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">3</td>
	<td style="padding:1px;">Scholership Nc</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">4</td>
	<td style="padding:1px;">Academic Fee Receipt A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">5</td>
	<td style="padding:1px;">Development (Plan) A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">6</td>
	<td style="padding:3px;">Combined Entrance Exams(CBT) A/c</td>
	<td style="padding:3px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">7</td>
	<td style="padding:1px;">UGC Plan Fellowship A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">8</td>
	<td style="padding:1px;">Corpus Fund  A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">9</td>
	<td style="padding:1px;">Sponsored Projects Fund A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">10</td>
	<td style="padding:1px;">Sponsored Fellowship A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">11</td>
	<td style="padding:1px;">Endowment &amp; Chair  A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">12</td>
	<td style="padding:1px;">UGC JRF Fellowship  A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">13</td>
	<td style="padding:1px;">HBA Fund  A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">14</td>
	<td style="padding:1px;">Conveyance A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">15</td>
	<td style="padding:1px;">UGC Rajiv Gandhi National Fellowship A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">16</td>
	<td style="padding:1px;">Academic Development Fund A/c (EMF)</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">17</td>
	<td style="padding:1px;">Deposit Nc</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">18</td>
	<td style="padding:1px;">Student Fund Nc</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">19</td>
	<td style="padding:1px;">Student Aid Fund A/c</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">20</td>
	<td style="padding:1px;">Plan Grants for specific schemes</td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
  <tr>
  	<td style="padding:1px;" class="center">I</td>
	<td style="padding:1px;"><b>Savings Bank Accounts</b></td>
	<td style="padding:1px;width:124px;" class="right"> @php 
			   
			   
			    $schedule_01 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '07/003/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			   
				if(!empty($schedule_01->closing_balance)){
    $tot2=$schedule_01->closing_balance;
}else{
    $tot2=0;	
}

echo $tot2;


			  @endphp</td>
  </tr>
   <tr>
  	<td style="padding:1px;" class="center">II</td>
	<td style="padding:1px;"><b>Current Accounts</b></td>
	<td style="padding:1px;width:124px;" class="right">@php 
			   
			   
			    $schedule_01 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '07/003/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
		
if(!empty($schedule_02->closing_balance)){
    $tot3=$schedule_02->closing_balance;
}else{
    $tot3=0;
}
echo $tot3;


			  @endphp</td>
  </tr>
   <tr>
  	<td style="padding:1px;" class="center">III</td>
	<td style="padding:1px;"><b>Term Deposits Schedule Banks</b></td>
	<td style="padding:1px;width:124px;" class="right">-</td>
  </tr>
   <tr>
  	<td colspan="2" style="padding:1px;" class="center">Total</td>
	<td style="padding:1px;width:124px;" class="right">{{$tot3+$tot2}}</td>
  </tr>
  </table>
  <!----------------------------
  ---------------------->
</div>
<!------------------------------------------------->
</body>
</html>
