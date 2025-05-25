<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon"/>
<title>BELLEVUE | Bank Book</title>
</head>

<body>

<table style="width:100%;text-align:center;font-family:cambria;">
<thead>
	<tr>
		<th><h1 style="margin:0;font-size:25px;">BELLEVUE</h1>
			<h2 style="margin:0;font-size:20px;">(Under Ministry Of HRD, Government Of India)</h2>
			<h4 style="margin:0">Block EA, Sector-I, Opposite Labony Estate, Salt Lake City, Kolkata-700064</h4>
			<h4 style="margin:0;">Bank Book</h4>
			<h4 style="margin:0;">ESTABLISHMENT ACCOUNT</h4>
			<h4 style="margin:0;"><?php   if(!empty($current_balance->bank_name)){ echo strtoupper($current_balance->bank_name); } ?></h4>
			<h5 style="margin:0;">From <?php echo date("d-m-Y", strtotime($fromdate)); ?> to <?php echo date("d-m-Y", strtotime($todate)); ?></h5>
		</th>
	</tr>
</thead>

</table>

<table style="width:100%;font-family:cambria;margin-top:20px;">
	<thead>
		<tr>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Date</th>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Particulars</th>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Voucher Type</th>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Voucher No.</th>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Receipt</th>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Payment</th>
			<th style="border-top:1px solid #000;border-bottom:1px solid #000;">Balance</th>
		</tr>
	</thead>
	<tbody>

		<tr>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php if(!empty($current_balance->opening_balance)){echo date('d-m-Y',strtotime($current_balance->created_at)); }  ?></td>
			<td style="width:230px;vertical-align:top;padding:5px;font-size:12px;">Opening Balance</td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php if(!empty($current_balance->opening_balance)){echo $current_balance->opening_balance; }  ?></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php if(!empty($current_balance->opening_balance)){echo $current_balance->opening_balance; }  ?></td>
		</tr>


		<?php $total_expense=0;
		 $total_income = 0;
		 $closing_balance = 0;
		if(!empty($payment_dtl)){foreach($payment_dtl as $payment){ ?>
		<tr>

                <td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php  echo date("d-m-Y", strtotime($payment['payment_booking_date'])); ?></td>
                <td style="width:230px;vertical-align:top;padding:5px;font-size:12px;"><?php echo $payment['narration'];  ?></td>
                <td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php echo $payment['voucher_type'];  ?></td>

			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php echo $payment['voucher_no'];  ?></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php echo $payment['income']; ?></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php echo $payment['expense'];  ?></td>
			<td style="vertical-align:top;text-align:center;padding:5px;font-size:12px;"><?php echo $payment['balance_amt'];  ?></td>
		</tr>


        <?php $total_expense += $payment['expense'];
              $total_income += $payment['income'];

              $closing_balance = $payment['balance_amt'];

			} } ?>


		<tr>
		<td style="font-size:12px;text-align:left;padding-top:10px;" colspan="5">Closing Balance</td>
		<td style="font-size:12px;text-align:right;padding-top:10px;border-top: 2px solid #000;">-</td>
		<td style="font-size:12px;text-align:right;padding-top:10px;border-top: 2px solid #000;"><?php echo $closing_balance;?></td>
	</tr>
	</tbody>
</table>
</body>
</html>
