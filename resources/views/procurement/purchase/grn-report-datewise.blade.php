<!DOCTYPE html>
<html lang="en">
<head>
  <title>BELLEVUE | GRN Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
  <style>body {-webkit-print-color-adjust: exact;font-family:Arial, Helvetica, sans-serif;}</style>
</head>
<body>

<table border="0" class="acnt" style="text-center;border-collapse:collapse;border:none;position:relative;width:100%;">
	<thead>
		<tr style="border-bottom:none;">
			<th style="text-align:left;border: none;"><img src="{{asset('images/logo2.png')}}" alt="logo" width="100"></th>
			<!-- <th style="text-align:center;border: none;"><h2 style="font-size: 23px;margin: 0;">व्यावहारिक प्रशिक्षण बोर्ड (पूर्वी क्षेत्र)</h2>
				<h1 style="text-align:center;margin:0;font-size:13px;">BELLEVUE</h1>
				 <p style="text-align:center;margin:0;font-size: 12px;">भारत सरकार के मानव संसाधन विकास मंत्रालय के उच्चतर शिक्षा विभाग के अधीन</p>
				<p style="text-align:center;margin:0;text-transform:uppercase;font-size: 6.5px;">under minstry of human resource development, Govt. of india, department of higher education</p>
			</th> -->
			<th style="text-align:center;border: none;"><img src="{{asset('images/nats.png')}}" alt="NATS logo" width="80"><p style="margin:0;"><img style="width:120px;" src="{{asset('images/caption.png')}}" alt=""></p><p style="font-size:14px;margin:0">www.mhrdnats.gov.in</p></th>

		</tr>

		<tr>
			<th colspan="3" style="text-align:center;"><h3 style="text-align:center;">GRN Register</h3>
				<h4>From {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</h4>
			</th>
		</tr>
	</thead>
</table>
<table border="1" style="width:100%;border-collapse:collapse;border-color:#000;margin:0 auto;">
<tr>
<th><p class="tab">Sl.<br>No.</p></th>
<th style="width:200px;"><p class="tab1">Item</p></th>
<th><p class="tab1">Unit</p></th>
<th><p class="tab">Order Qty.</p></th>
<th><p class="tab">Received Qty.</p></th>
<th><p class="tab">Balance Qty.</p></th>
</tr>

@foreach($grn_items as $grn_item)
<tr>
<td class="paddin">{{ $loop->iteration }}</td>
<td>{{ $grn_item->item_name }}</td>
<td>{{ $grn_item->unit_name }}</td>
<td>{{ $grn_item->qty }}</td>
<td>{{ $grn_item->receive_qty }}</td>
<td>{{ $grn_item->balance_qty }}</td>

</tr>
@endforeach



</table>

<table border="0" style="border-collapse:collapse;width:100%;margin:50px auto 0;">
	<tr>
<td style="text-align:center;border: 1px solid #000;
    padding: 10px 3px;width:370px;font-size:13px;">AAO / OS</td>
<td style="border-top:none;border-bottom:none;border-right:none;width:300px"></td>
<td style=""></td>
	<td style="font-size:13px;width:350px;text-align:center;border: 1px solid #000;
    padding: 10px 3px;">
		<p>Authorised Signature</p>


	</td>
</tr>
<tr>
<td style="text-align:center;border: 1px solid #000;
    padding: 20px 5px;">&nbsp;</td>

	<td style="border-top:none;border-bottom:none;border-right:none;"></td>
<td></td>
	<td style="text-align:center;border: 1px solid #000;
    padding: 20px 5px;">



	</td>
</tr>
</table>

<table style="width:100%;position:relative;">
<tfoot style="position:fixed;bottom:10px;">
<tr style="border-top: 1px solid #999;">
	<td style="border:none;width:150px;padding-top:10px;"><img src="{{asset('images/swachh-bharat.png')}}" alt="" width="130"></td>
	<!-- <td style="border:none;text-align:left;padding-top:10px">
		<p style="font-size:9px;margin:0;font-family: 'Hind', sans-serif;">ब्लॉक - ईए, सेक्टर - I (लाबोनी एस्टेट के विपरीत), साल्ट लेक सिटी, कोलकाता - 700064, फोन/Phone- (033) 2337-0750 / 51, फैक्स/Fax - (033) 2321-6814</p>
		 <p style="font-size:8px;margin:0;font-family: 'Hind', sans-serif;">Block - EA, Sector - I (Opposite.Laboni Estate), Salt Lake City, Kolkata - 700 064, ई-मेल/E-mail - inf@bopter.gov.in, वेबसाइट/Website - www.bopter.gov.in</p>
	</td> -->
</tr>

</tfoot>
</table>


</body>
</html>
