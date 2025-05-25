<!DOCTYPE html>
<html lang="en">
<head>
  <title>BELLEVUE | Journal Voucher</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
  <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon"/>
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
<!-------------------bank-statement-head------------------------->
<div class="payslip">
	<!-----------company-details----------->
		<table class="comp-det" style="width:100%;">
		<tr>

			<td>
			<div class="pay-logo">
					<img src="{{asset('images/logo2.png')}}" alt="logo">
				</div>
			</td>
			<td>
				<div class="text-center pay-head">
				<h2>BELLEVUE</h2>
                <h4>Journal Voucher for {{ $party_name }}</h4>
				</div>

			</td>
			</tr>
		</table>
	<!--------------------------->
<!---------------------------------------------------->

<!------------journal-voucher-body---------------------->
{{-- <table style="width:100%;width: 100%;border: 2px solid #000;border-radius: 5px;padding: 0 3px;">
	<tr>
		<td>Voucher No.:  JV/1308/000000040</td>
		<td class="right">Date: 11/11/2019</td>
	</tr> --}}
	{{-- <tr>

		<td>Cost Center:  ADMINISTRATION(A01)</td>
		<td class="right">Status Posted</td>
	</tr>
	<tr>
		<td colspan="2">Department:  ADMINISTRATION (ADM )</td>
	</tr> --}}

{{-- </table> --}}
{{-- <table style="width:100%">
<tr>
	<td>BEING THE AMT FOR SUPPLY LINE REPAIR VALVE CHANGE INCLUDING MATERIAL SUPPLY & LABOUR CHARGES. BILL NO. - 0 DT. 29/08/13 - AJOY SAHA.</td>
	</tr> --}}
{{-- <tr>
	<td><b><u>Supplier Detail</u></b></td>
</tr> --}}

{{-- </table> --}}

{{-- <table class="ledger" style="width:100%;border: 1px solid #000;">
<thead style="padding: 5px;
    background:#ddd;">
	<tr>
		<th class="left" style="padding: 5px; width:20%;">Supplier</th>
		<th class="left" style="padding: 5px; width:40%;">Narration</th>
		<th class="right" style="padding: 5px; width:20%;">Debit</th>
		<th class="right" style="padding: 5px; width:20%;">Credit</th>
	</tr>
</thead>
	<tr>
		<td>AJOY KUMAR SAHA (0300343)</td>
		<td>BEING THE AMT FOR SUPPLY LIN 1,910.00
REPAIR VALVE CHANGE INCLUDIN
MATERIAL SUPPLY & LABOUR
CHARGES. BILL NO. - 0 DT. 29/08/1
AJOY SAHA.. AJOY KUMAR SAHA
6% WCT ON Rs.1560/-</td>

<td class="right"></td>
<td class="right">1,910</td>
	</tr>
<tr>
	<td>AJOY KUMAR SAHA (0300343)</td>
	<td></td>
	<td class="right">94.00</td>
	<td></td>
</tr>
<tr>
	<td class="right" colspan="2">Total</td>
	<td class="right" style="border-top:1px dashed #000;padding:10px 0;">94.00</td>
	<td class="right" style="border-top:1px dashed #000;padding:10px 0;">1,910</td>
</tr>

</table> --}}

<table class="ledger" style="width:100%;border: 1px solid #000;">
	<thead style="padding: 5px;background:#ddd;">
		<tr>
            <th class="left" style="padding: 5px; width:10%;">Seq No.</th>
            <th class="left" style="padding: 5px; width:10%;">Voucher No.</th>
			<th class="left" style="padding: 5px; width:10%;">Account Name(Code)</th>
            <th class="left" style="padding: 5px; width:40%;">Description/Narration</th>
            <th class="left" style="padding: 5px; width:10%;">Date</th>
			<th class="right" style="padding: 5px; width:20%;">Debit</th>
			<th class="right" style="padding: 5px; width:20%;">Credit</th>
		</tr>
	</thead>

    @php $total_credit_amt = 0; $total_debit_amt = 0; @endphp
    @foreach($party_details as $party_detail)
    @php $bank=''; $payment_amout=0;
    $payment_date='';@endphp
    <tr>
    <td>00{{ $loop->iteration }}</td>
    <td>{{ $party_detail->voucher_no }}</td>
    <td>{{ $party_detail->head_name }}({{ $party_detail->transaction_code }})</td>

    <td>{{ $party_detail->entry_remark }}</td>




    <td>{{ \Carbon\Carbon::parse($party_detail->bill_booking_date)->format('d/m/Y') }}</td>
    <td class="right"></td>
    <td>{{ $party_detail->payable_amt }}</td>
</tr>
@php
$total_credit_amt+=$party_detail->payable_amt;
$party_details_bank = App\Models\AccountPayable\Payment_dtl::where('voucher_id','=',$party_detail->voucher_no)

    ->first();
    if(!empty($party_details_bank)){
$bank=$party_details_bank->bank_id;
$payment_amout=$party_details_bank->payment_amount;
$payment_date=$party_details_bank->payment_release_date;
    }else{
        $bank='';
        $payment_amout=0;
        $payment_date='';
    }
    $total_debit_amt+=$payment_amout;
@endphp
@if($bank!='')
 <tr>
    <td></td>

<td>{{ $party_detail->voucher_no }}</td>
    <td>{{ $bank }}</td>

    <td>{{ $party_detail->entry_remark }}</td>




    <td>{{ \Carbon\Carbon::parse($party_detail->bill_booking_date)->format('d/m/Y') }}</td>
    <td class="right">{{ $payment_amout }}</td>
    <td></td>


    </tr>
    @endif
    {{-- @php $total_credit_amt += $credit_amt; $total_debit_amt += $debit_amt; @endphp --}}
    @endforeach

	</tr>
	<tr class="3">
		<td colspan="5" class="right">Total:</td>
		<td class="right" style="border-top:1px dashed #000;padding:10px 0;">{{$total_debit_amt}}</td>
		<td class="right" style="border-top:1px dashed #000;padding:10px 0;">{{$total_credit_amt}}</td>
	</tr>
</table>

<!---------------------------------------->

<!-----------------------footer------------------------->
<table style="width:100%;text-align:center;margin-top:10%;">
	<tr>
				<td style="width:33.33%;">___________________________<br>
				Prepared by</td>
				<td style="width:33.33%;">___________________________<br>Approved by</td>
				<td style="width:33.33%;">______________________________________<br>Authorised by</td>
			</tr>
</table>
</div>

<!------------------------------------------------->


</body>

</html>
