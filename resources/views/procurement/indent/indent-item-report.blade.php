<!DOCTYPE html>
<html lang="en">
<head>

  <title>BELLEVUE | Salary Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
  <style type="text/css" media="print"> @page { size: auto; /* auto is the initial value */
   	margin-top: 0;
    margin-bottom: 0; /* this affects the margin in the printer settings */ }
   </style>
  <style>
  	*
{
   margin:0px;
   padding:0px;
   box-sizing:border-box;
        font-family: Cambria;
}

.board
{
	/*border:1px solid red;*/
	width:100%;
	overflow:hidden;
}

.board1
{
	text-align:center;
	font-family:cambria;
	color:#000;
	font-size:26px;
	margin-top:25px;
	font-weight:600;
}


.line
{
	width:200px;
	height:1.5px;
	background-color:#000;
	margin:0px 0px;
}

.board2
{
	text-align:center;
	font-family:Cambria;
	color:#000;
	font-size:19px;
	margin-top:16px;
	font-weight:600;
}


.line1
{
	width:510px;
	height:2px;
	background-color:#000;
	margin:0px auto;
	margin-bottom:20px;
}


#name
{
	/*border:1px solid red;*/
	width:80%;
	overflow:hidden;
	margin:65px auto;
}


.name
{
	color:#000;
	font-size:16px;
	font-family:cambria;
	letter-spacing:.6px;
}

.date
{
	color:#000;
	font-size:16px;
	font-family:cambria;
	letter-spacing:.6px;
	margin-top:18px;
	margin-bottom:0px;
}


#demand
{
	/*border:1px solid red;*/
	width:80%;
	overflow:hidden;
	margin:0px auto;
}


.demands
{
	color:#000;
	font-size:19px;
	font-family:verdana;
	font-weight:600;
	text-align:center;
}


.line2
{
	width:132px;
	height:2px;
	background-color:#000;
	margin:0px auto;
	margin-bottom:20px;
}


table
{
	margin:60px auto;
}

.tab
{
	font-size:15.5px;
	color:#000;
	font-weight:bold;
	font-family:cambria;
	padding:6px;
	text-align: center;
}


.tab1
{
	font-size:15.5px;
	color:#000;
	font-weight:bold;
	font-family:cambria;

}


.paddin
{
   padding:6px;
}


.approvebox
{
	/*border:1px solid red;*/
	width:80%;
	overflow:hidden;
	margin:0px auto;
}


.box1
{
	/*border:1px solid #000;*/
	width:120px;
	height:128px;
}

.text1
{
    margin-left:15px;
	font-family:verdana;
	margin-top:15px;
	color:#000;
	font-size:16px;
}

.text2
{
	margin-left:15px;
	font-family:verdana;
	margin-top:20px;
	color:#000;
	font-size:16px;
	font-weight:600;
}


.float
{
	width:50%;
	/*border:1px solid #000;*/
	overflow:hidden;
	float:left;
	margin-bottom:40px;
}


.float1
{
	width:50%;
	/*border:1px solid #000;*/
	overflow:hidden;
	float:right;
	margin-bottom:40px;
}


.box2
{
	width:280px;
	height:110px;
	float:right;
	/*border:1px solid #000;*/
}

.text3
{
	text-align:center;
	font-family:verdana;
	margin-top:20px;
	color:#000;
	font-size:14px;
	font-weight:600;
}



.sbox
{
	/*border:1px solid #000;*/
	width:350px;
	height:120px;
	overflow:hidden;
	margin:0px auto;
	margin-bottom:50px;
}

.text4
{
	text-align:center;
	font-family:verdana;
	margin-top:20px;
	color:#000;
	font-size:14px;
	font-weight:600;
}

  </style>
</head>
<body>

<table border="0" class="acnt" style="border-collapse:collapse;border:none;position:relative;width:100%;">
    <thead>
    <tr style="border-bottom:none;">
        <th style="text-align:left;border: none;"><img src="{{asset('images/logo2.png')}}" alt="logo" width="100"></th>
        <!-- <th style="text-align:center;border: none;"><h2 style="font-size: 22px;margin: 0;">व्यावहारिक प्रशिक्षण बोर्ड (पूर्वी क्षेत्र)</h2>
            <h1 style="text-align:center;margin:0;font-size:14px;">BOARD OF PRACTICAL TRAINING (EASTERN REGION)</h1>
            <p style="text-align:center;margin:0;font-size: 11px;">भारत सरकार के मानव संसाधन विकास मंत्रालय के उच्चतर शिक्षा विभाग के अधीन</p>
            <p style="text-align:center;margin:0;text-transform:uppercase;font-size: 6.5px;">under minstry of human resource development, Govt. of india, department of higher education</p>
        </th> -->
        <th style="text-align:center;border: none;"><img src="{{asset('images/nats.png')}}" alt="NATS logo" width="80"><p style="margin:0;"><img style="width:120px;" src="{{asset('images/caption.png')}}" alt=""></p><p style="font-size:14px;margin:0">www.mhrdnats.gov.in</p></th>

    </tr>
    </thead>

<tr style="margin-top:25px;">
<td colspan="3" class="name" style="margin-bottom: 18px;">Requisition Voucher No. : {{ $indent_item[0]->indent_no }}</td>
</tr>
    <tr>
<td colspan="3" class="name">Name of Section : {{ $indent_item[0]->department_name }}</td>
    </tr>
    <tr>
<td colspan="3" class="date">Date of Requisition : {{ $indent_item[0]->indent_date }}</td>
</tr>
</table>
{{--<section id="demand">--}}
{{--<div class="demands">Demand Slip</div>--}}
{{--<div class="line2"></div>--}}
{{--</section>--}}

<table border="1" style="width:100%;border-collapse:collapse;border-color:#000;">
<thead>
	<tr>
	<th><p class="tab">Sl.<br>No.</p></th>
	<th><p class="tab1">Name of Item</p></th>
	<th><p class="tab">Unit</p></th>
	<th><p class="tab">Qty. Demanded</p></th>
	<th><p class="tab">Qty. Approved</p></th>
        <th><p class="tab">Qty. Rejected</p></th>
	</tr>
</thead>
<tbody>
	@foreach($indent_item as $indent)
<tr>
<td class="paddin" style="text-align: center;">{{ $loop->iteration }}</td>
<td style="text-align: center;">{{ $indent->item_name }}</td>
<td style="text-align: center;">{{ $indent->unitname }}</td>
<td style="text-align: center;">{{ $indent->required_qty }}</td>
<td style="text-align: center;">{{ $indent->approved_qty }}</td>
    <td style="text-align: center;">{{ $indent->rejected_qty }}</td>
</tr>
@endforeach
</tbody>
</table>

<table style="width: 100%;">

    <tr>
        <td style="border-top:1px solid #000;text-align: center;width: 150px;">AAO/OS</td>
        <td></td>

        <td style="border-top:1px solid #000;text-align: center;width: 250px">Signature of Requisitor</td>
    </tr>

</table>


<table style="margin-top: 25px;">
    <tr>
        <td colspan="2" style="width:350px;padding-bottom: 55px;border-top:1px solid #000;text-align: center;">Signature of Officer/Section In Charge</td>
    </tr>
</table>
    <!-----------------------footer------------------------->
<table width="100%;position:relative;">
    <tfoot style="position: fixed;bottom:25px;">

    <!--------------------signature-------------------->

    <!--------------------------------------->
    <tr style="border-top: 1px solid #999;">
        <td style="border:none;width:150px;padding-top:10px;"><img src="{{asset('images/swachh-bharat.png')}}" alt="" width="130"></td>
        <td style="border:none;text-align:left;padding-top:10px;" colspan="4">
            <p style="font-size:9px;margin:0;font-family: 'Hind', sans-serif;">ब्लॉक - ईए, सेक्टर - I (लाबोनी एस्टेट के विपरीत), साल्ट लेक सिटी, कोलकाता - 700064, फोन/Phone- (033) 2337-0750 / 51, फैक्स/Fax - (033) 2321-6814</p>
            <p style="font-size:8px;margin:0;font-family: 'Hind', sans-serif;">Block - EA, Sector - I (Opposite.Laboni Estate), Salt Lake City, Kolkata - 700 064, ई-मेल/E-mail - inf@bopter.gov.in, वेबसाइट/Website - www.bopter.gov.in</p>
        </td>
    </tr>

    </tfoot>
</table>
</div>

<!------------------------------------------------->
</table>



</body>
</html>
