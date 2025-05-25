<!DOCTYPE html>
<html lang="en">
<head>
  <title>BELLEVUE | Receipt and Payment Account</title>
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
.sub{padding: 3px 3px 3px 4%;}
.sub2{padding: 3px 3px 3px 6%;}
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
    margin-top:15px; 
	margin-bottom: 6px;
    
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
				<h4>Receipt and Payment Account for the Year Ended 31st March, {{$end_year}}</h4>
				</div>
				
			</td>
			</tr>
		<tr>
			<td colspan="6"><span style="border: 1px solid #000;border: 1px solid #000;padding: 2px 5px;">STATEMENT NO. :1</span></td>
		</tr>
		</table>	


<!--------------------------fund-body------------------------>
<table border="1" style="border-collapse:collapse;width:100%;margin-top:1%;">
	<thead style="background:#ddd;">
		<tr>
			<th style="padding:3px;">RECEIPTS</th>
			<th style="padding:3px;">Current Year</th>
			<th style="padding:3px;">Previous Year</th>
			<th style="padding:3px;">PAYMENTS</th>
			<th style="padding:3px;">Current Year</th>
			<th style="padding:3px;">Previous Year</th>

		</tr>
	</thead>
	<tbody>
		
		<tr>
			<td style="padding:3px;"><b>I. Opening Balances</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>I. Expenses:</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;">a)Cash Balances</td>
			<td style="padding:3px;">@php 
			 $cash = DB::table('cash_balance')


                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
					 $pettycash =  DB::table('petty_balance')


                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
if( !empty($cash))	{
	$cash_bal=$cash->opening_balance;
	
}else{
	 $cash_op = DB::table('company_cash')


                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
									
									
			$cash_bal=$cash_op->opening_balance;						
}	
if( !empty($pettycash))	{
	$petty_bal=$pettycash->opening_balance;
	
}else{
	 $petty_op = DB::table('company_petty')


                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
									
									
			$petty_bal=$petty_op->opening_balance;						
}							
echo ($cash_bal+$petty_bal);
			@endphp</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;">a) Establishment Expenses</td>
			<td style="padding:3px;">@php 
			$total_amount4=0;
			$data['schedule_details_15'] = DB::table('schedule_15')->get();

                        foreach($data['schedule_details_15'] as $schedule_15_det)
                        {
                            if($schedule_15_det->coa_code != '')
                            {

                                $schedule_15 = DB::table('balance_posting')


                                    ->where('transaction_code', '=', $schedule_15_det->coa_code)


 ->where('financial_year', '=', $financial_year)
                                    ->orderBy('id', 'desc')
                                    ->first();

                                    
                                    if(!empty($schedule_15->closing_balance)){
                                        $bal=$schedule_15->closing_balance;
                                       }else{
                                        $bal=0;
                                       }
									   $total_amount4 +=$bal;
                               

                            }
							
							
							
							if($schedule_15_det->account_name=='Salaries and Wages')
							{
			   
			   
			    $schedule_01 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/001/001')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_02 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/001/002')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_03 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/001/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
 $schedule_04 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/001/004')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_05 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/001/005')
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

			if(!empty($schedule_03->closing_balance)){
    $tot2=$schedule_03->closing_balance;
}else{
    $tot2=0;	
}
			if(!empty($schedule_04->closing_balance)){
    $tot3=$schedule_04->closing_balance;
}else{
    $tot3=0;	
}
			if(!empty($schedule_05->closing_balance)){
    $tot4=$schedule_05->closing_balance;
}else{
    $tot4=0;	
}
 $tmain=($tot1+$tot+$tot2+$tot3+$tot4);


			 

							}
			  
			else if($schedule_15_det->account_name=='Allowances and Bonus')
			{ 
			   
			   
			    $schedule_06 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/001')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_07 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/002')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_08 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
 $schedule_09 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/004')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_10 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/005')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();

					 $schedule_11 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/006')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();

			 $schedule_12 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/007')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();

 $schedule_13 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/008')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
 $schedule_14 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/009')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
 $schedule_15 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/002/010')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();					
				if(!empty($schedule_06->closing_balance)){
    $tot5=$schedule_06->closing_balance;
}else{
    $tot5=0;	
}
if(!empty($schedule_07->closing_balance)){
    $tot6=$schedule_07->closing_balance;
}else{
    $tot6=0;
}

			if(!empty($schedule_08->closing_balance)){
    $tot7=$schedule_08->closing_balance;
}else{
    $tot7=0;	
}
			if(!empty($schedule_09->closing_balance)){
    $tot8=$schedule_09->closing_balance;
}else{
    $tot8=0;	
}
			if(!empty($schedule_10->closing_balance)){
    $tot9=$schedule_10->closing_balance;
}else{
    $tot9=0;	
}
if(!empty($schedule_11->closing_balance)){
    $tot10=$schedule_11->closing_balance;
}else{
    $tot10=0;	
}

if(!empty($schedule_12->closing_balance)){
    $tot11=$schedule_12->closing_balance;
}else{
    $tot11=0;	
}
if(!empty($schedule_13->closing_balance)){
    $tot12=$schedule_13->closing_balance;
}else{
    $tot12=0;	
}
if(!empty($schedule_14->closing_balance)){
    $tot13=$schedule_14->closing_balance;
}else{
    $tot13=0;	
}
if(!empty($schedule_15->closing_balance)){
    $tot14=$schedule_15->closing_balance;
}else{
    $tot14=0;	
}
$tmain1=($tot5+$tot6+$tot7+$tot8+$tot9+$tot10+$tot11+$tot12+$tot13+$tot14);


			    
			}  
			  
			  
			  
			  
			
else if($schedule_15_det->account_name=='Staff Welfare Expenses')
{
			   
			   
			    $schedule_16 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/005/001')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_17 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/005/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_18 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/005/004')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
				
				if(!empty($schedule_16->closing_balance)){
    $tot15=$schedule_16->closing_balance;
}else{
    $tot15=0;	
}
if(!empty($schedule_17->closing_balance)){
    $tot16=$schedule_17->closing_balance;
}else{
    $tot16=0;
}

			if(!empty($schedule_18->closing_balance)){
    $tot17=$schedule_18->closing_balance;
}else{
    $tot17=0;	
}
$tmain2=($tot15+$tot16+$tot17);


			   
			  
			  
			  			
}
			  
			  
			  else if($schedule_15_det->account_name=='Retirement and Terminal benefits')
               
			   
			   {
			    $schedule_19 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/006/002')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_20 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/006/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_21 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/006/004')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
		$schedule_22 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/006/005')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
$schedule_23 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/006/006')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
$schedule_24 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/006/007')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
		
				if(!empty($schedule_19->closing_balance)){
    $tot18=$schedule_19->closing_balance;
}else{
    $tot18=0;	
}
if(!empty($schedule_20->closing_balance)){
    $tot19=$schedule_20->closing_balance;
}else{
    $tot19=0;
}

			if(!empty($schedule_21->closing_balance)){
    $tot20=$schedule_21->closing_balance;
}else{
    $tot20=0;	
}

if(!empty($schedule_22->closing_balance)){
    $tot21=$schedule_22->closing_balance;
}else{
    $tot21=0;	
}
if(!empty($schedule_23->closing_balance)){
    $tot22=$schedule_23->closing_balance;
}else{
    $tot22=0;	
}
if(!empty($schedule_24->closing_balance)){
    $tot23=$schedule_24->closing_balance;
}else{
    $tot23=0;	
}
$tmain3=($tot18+$tot19+$tot20+$tot21+$tot22+$tot23);
			   }  
			  
			  else if($schedule_15_det->account_name=='Honorarium')
              {
			   
			   
			    $schedule_25 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/010/001')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_26 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/010/002')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
 $schedule_27 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/010/003')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();	
				
				if(!empty($schedule_25->closing_balance)){
    $tot24=$schedule_25->closing_balance;
}else{
    $tot24=0;	
}
if(!empty($schedule_26->closing_balance)){
    $tot25=$schedule_26->closing_balance;
}else{
    $tot25=0;
}

			if(!empty($schedule_27->closing_balance)){
    $tot26=$schedule_27->closing_balance;
}else{
    $tot26=0;	
}
$tmain4=($tot24+$tot25+$tot26);

			  }
			 
			  
		   else if($schedule_15_det->account_name=='News paper reimbursement')
		   { 
			   
			   
			    $schedule_28 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/011/006')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();
							   
			    $schedule_29 =DB::table('balance_posting')


                    ->where('transaction_code', '=', '15/011/007')
                    ->where('financial_year', '=', $financial_year)
                    ->orderBy('id', 'desc')
                    ->first();

				if(!empty($schedule_28->closing_balance)){
    $tot27=$schedule_28->closing_balance;
}else{
    $tot27=0;	
}
if(!empty($schedule_29->closing_balance)){
    $tot28=$schedule_29->closing_balance;
}else{
    $tot28=0;
}

			
$tmain5=($tot27+$tot28);
		   }
			  
							
							
							
							
							
							
						}
						 echo ($total_amount4+ $tmain+$tmain1+$tmain2+$tmain3+$tmain4+$tmain5);
			@endphp</td>
			<td style="padding:3px;"></td>
			
		</tr>
		<tr>
			<td style="padding:3px;">b) Bank Balances</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;">b) Academic Expenses</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">i) In Current Accounts(SBI)</td>
			<td style="padding:3px;">@php 
			 $bank_cur = DB::table('bank_balance')

->where('bank_branch_id', '=', '2')
                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
					 
if( !empty($bank_cur))	{
	$bank_cur_bal=$bank_cur->opening_balance;
	
}else{
	 $bank_cur_op = DB::table('company_bank')
->where('id', '=', '2')

                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
									
									
			$bank_cur_bal=$bank_cur_op->opening_balance;						
}	
			
echo ($bank_cur_bal);
			@endphp</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;">c) Adminstartive Expenses</td>
			<td style="padding:3px;">@php 
			$total_amount=0;
			$data['schedule_details_17'] = DB::table('schedule_17')->get();

                        foreach($data['schedule_details_17'] as $schedule_17_det)
                        {
                            if($schedule_17_det->coa_code != '')
                            {

                                $schedule_17 = DB::table('balance_posting')


                                    ->where('transaction_code', '=', $schedule_17_det->coa_code)


 ->where('financial_year', '=', $financial_year)
                                    ->orderBy('id', 'desc')
                                    ->first();

                                    
                                    if(!empty($schedule_17->closing_balance)){
                                        $bal=$schedule_17->closing_balance;
                                       }else{
                                        $bal=0;
                                       }
									   $total_amount +=$bal;
                               

                            }
						}
						 echo $total_amount;
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">ii) In Deposit Accounts</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;">d) Transportation Expenses</td>
			<td style="padding:3px;">@php 
			$total_amount1=0;
			$data['schedule_details_18'] = DB::table('schedule_18')->get();

                        foreach($data['schedule_details_18'] as $schedule_18_det)
                        {
                            if($schedule_18_det->coa_code != '')
                            {

                                $schedule_18 = DB::table('balance_posting')


                                    ->where('transaction_code', '=', $schedule_18_det->coa_code)


 ->where('financial_year', '=', $financial_year)
                                    ->orderBy('id', 'desc')
                                    ->first();

                                    
                                    if(!empty($schedule_18->closing_balance)){
                                        $bal=$schedule_18->closing_balance;
                                       }else{
                                        $bal=0;
                                       }
									   $total_amount1 +=$bal;
                               

                            }
						}
						 echo $total_amount1;
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">iii) Savings accounts (CANARA)</td>
			<td style="padding:3px;">@php 
			 $bank_sav = DB::table('bank_balance')

->where('bank_branch_id', '=', '1')
                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
					 
if( !empty($bank_sav))	{
	$bank_sav_bal=$bank_sav->opening_balance;
	
}else{
	 $bank_sav_op = DB::table('company_bank')
->where('id', '=', '2')

                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
									
									
			$bank_sav_bal=$bank_sav_op->opening_balance;						
}	
			
echo ($bank_sav_bal);
			@endphp</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;">e) Repairs & Maintenance</td>
			<td style="padding:3px;">@php 
			$total_amount2=0;
			$data['schedule_details_19'] = DB::table('schedule_19')->get();

                        foreach($data['schedule_details_19'] as $schedule_19_det)
                        {
                            if($schedule_19_det->coa_code != '')
                            {

                                $schedule_19 = DB::table('balance_posting')


                                    ->where('transaction_code', '=', $schedule_19_det->coa_code)


 ->where('financial_year', '=', $financial_year)
                                    ->orderBy('id', 'desc')
                                    ->first();

                                    
                                    if(!empty($schedule_19->closing_balance)){
                                        $bal=$schedule_19->closing_balance;
                                       }else{
                                        $bal=0;
                                       }
									   $total_amount2 +=$bal;
                               

                            }
						}
						 echo $total_amount2;
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;">f) Prior period Expenses</td>
			<td style="padding:3px;">@php 
			$total_amount3=0;
			$data['schedule_details_22'] = DB::table('schedule_22')->get();

                        foreach($data['schedule_details_22'] as $schedule_22_det)
                        {
                            if($schedule_22_det->coa_code != '')
                            {

                                $schedule_22 = DB::table('balance_posting')


                                    ->where('transaction_code', '=', $schedule_22_det->coa_code)


 ->where('financial_year', '=', $financial_year)
                                    ->orderBy('id', 'desc')
                                    ->first();

                                    
                                    if(!empty($schedule_22->closing_balance)){
                                        $bal=$schedule_22->closing_balance;
                                       }else{
                                        $bal=0;
                                       }
									   $total_amount3 +=$bal;
                               

                            }
						}
						 echo $total_amount3;
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>

		<tr>
			<td style="padding:3px;"><b>II) Grants Received</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>II) Payment Against Earmarked<br>/Endowment Funds</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		
		<tr>
			<td style="padding:3px;">a) From Government of India</td>
			<td style="padding:3px;">{{$grant_in_aid[0]->grant_in_aid_amt}}</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>

		<tr>
			<td style="padding:3px;">b) From State Government</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;">c) From other sources (details)<br>(Grants for capital &amp; revenue/exp. to be shown<br> seperately if available)</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>III) Academic Receipts</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>III) Payment Against Sponsored Project / Schemes</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>IV) Receipts against Earmarked/Endowment Funds</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>IV) Payment Against Earmarked<br>/Endowment Funds</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;vertical-align:top;"><b>V) Receipts against sponsored projects/schemes</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>V) Investment and Deposit made</b>
				<ul class="sub" style="list-style:none;">
					<li>a) Out of Earmarked /Endowment funds</li>
					<li>b) Out of own funds (Investment-others)</li>
				</ul>
			</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>VI) Receipts against Sponsored Fellowships / Scholerships</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>VI) Term Deposit with Scheduled Banks</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>VII) Income on Investment from</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>VII) Expenditure on Fixed Assets and Capital Work-in-Progress</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">a) Earmarked/Endowment funds</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub">a)Fixed Assets</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub">b)Capital Work-in-Progress</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>VIII) Interest Received on</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>VIII) Other Payment including statutory payments</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">a) Bank Deposit</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">b) Loan &amp; Advances</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td class="sub">c) Savings Bank Accounts</td>
			<td style="padding:3px;">{{$saving_bank_account[0]->saving_account_amt}}</td>
			<td style="padding:3px;"></td>
			<td class="sub"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>IX) Investments Encashed</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>IX) Refunds of Grants</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>X) Term Deposits with Scheduled Banks Encashed</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>X) Deposits and Advances</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
	<tr>
			<td style="padding:3px;"><b>XI) Other Income (Including Prior Period Income)</b></td>
			<td style="padding:3px;">{{$other_income[0]->other_income_amt}}</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>XI) Other Payments</b></td>
			<td style="padding:3px;">-</td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>XII) Deposits and Advances</b></td>
			<td style="padding:3px;">{{$deposit_advance[0]->deposit_advance_amt}}</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"><b>XII) Closing balances</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>XIII) Miscellaneous Receipts including Satutory Receipts</b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub">a) Cash in Hand</td>
			<td style="padding:3px;">@php 
			 $cash_close = DB::table('cash_balance')


                                   
                                    ->orderBy('id', 'desc')
                                    ->first();
					 $pettycash_close =  DB::table('petty_balance')


                                   
                                    ->orderBy('id', 'desc')
                                    ->first();
if( !empty($cash_close))	{
	$cash_close_bal=$cash_close->balance_amt;
	
}else{
	 $cash_op = DB::table('company_cash')


                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
									
									
			$cash_close_bal=$cash_op->opening_balance;						
}	
if( !empty($pettycash_close))	{
	$petty_close_bal=$pettycash_close->balance_amt;
	
}else{
	 $petty_op = DB::table('company_petty')


                                   
                                    ->orderBy('id', 'asc')
                                    ->first();
									
									
			$petty_close_bal=$petty_op->opening_balance;						
}							
echo ($cash_close_bal+$petty_close_bal);
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub">b) Bank Balances</td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b>XIV) Any Other Receipts</b></td>
			<td style="padding:3px;">{{$other_receipt[0]->other_receipt_amt}}</td>
			<td style="padding:3px;"></td>
			<td class="sub2">i) In Current Accounts (SBI)</td>
			<td style="padding:3px;">@php 
			 $bank_sav_close = DB::table('bank_balance')

->where('bank_branch_id', '=', '2')
                                   
                                    ->orderBy('id', 'desc')
                                    ->first();
					 
if( !empty($bank_sav_close))	{
	$bank_sav_bal_close=$bank_sav_close->balance_amt;
	
}else{
	 $bank_sav_op = DB::table('company_bank')
->where('id', '=', '2')

                                   
                                    ->orderBy('id', 'desc')
                                    ->first();
									
									
			$bank_sav_bal_close=$bank_sav_op->opening_balance;						
}	
			
echo ($bank_sav_bal_close);
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>
		<tr>
			<td style="padding:3px;"><b></b></td>
			<td style="padding:3px;"></td>
			<td style="padding:3px;"></td>
			<td class="sub2">ii) In Savings Accounts (CANARA)</td>
			<td style="padding:3px;">@php 
			 $bank_cur_close = DB::table('bank_balance')

->where('bank_branch_id', '=', '1')
                                   
                                    ->orderBy('id', 'desc')
                                    ->first();
					 
if( !empty($bank_cur_close))	{
	$bank_cur_bal_close=$bank_cur_close->balance_amt;
	
}else{
	 $bank_sav_op = DB::table('company_bank')
->where('id', '=', '2')

                                   
                                    ->orderBy('id', 'desc')
                                    ->first();
									
									
			$bank_cur_bal_close=$bank_sav_op->opening_balance;						
}	
			
echo ($bank_cur_bal_close);
			@endphp</td>
			<td style="padding:3px;"></td>
		</tr>
		@php 
			$total_receipt=0;
			$total_receipt= $cash_bal+$petty_bal + $bank_cur_bal + $bank_sav_bal;

		@endphp

		@php 
			$total_payment=0;
			$total_payment=$total_amount4+ $tmain+$tmain1+$tmain2+$tmain3+$tmain4+$tmain5 +$total_amount+$total_amount1+$total_amount2+$total_amount3+$cash_close_bal+$petty_close_bal+$bank_sav_bal_close+$bank_cur_bal_close
		@endphp
		<tr>
			<td style="padding:3px;" class="center"><b>TOTAL</b></td>
			<td style="padding:3px;"><b>{{$total_receipt}}</b></td>
			<td style="padding:3px;"><b></b></td>
			<td class="center"><b>TOTAL</b></td>
			<td style="padding:3px;"><b>{{$total_payment}}</b></td>
			<td style="padding:3px;"><b></b></td>
		</tr>
	</tbody>
</table>

<!----------------------------------------------------->
</div>
<!------------------------------------------------->
<!---------------------endowment-funds----------------->

<!----------------------------------------------->

</body>

</html>