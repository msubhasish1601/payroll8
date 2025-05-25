<!DOCTYPEhtml>
<html>
<head>
    <link href="pdf.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <style>body {-webkit-print-color-adjust: exact;font-family:Arial, Helvetica, sans-serif;}</style>
</head>
<body>

<table border="0" class="acnt" style="text-center;border-collapse:collapse;border:none;position:relative;width:100%;">
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

    <tr>
        <th colspan="3" style="text-align:center;"><h3 style="text-align:center;">To be filled by Stationery Clerk</h3>
            <h4>Issue Slip Dated : {{ \Carbon\Carbon::parse($issued_items[0]->issue_date)->format('d-m-Y') }}</h4>
        </th>
    </tr>
    </thead>
</table>
<table border="1" style="width:80%;border-collapse:collapse;border-color:#000;margin:.0 auto;">
    <tr>
        <th><p class="tab">Sl.<br>No.</p></th>
        <th><p class="tab1">Name of Item</p></th>
        <th><p class="tab">Qty. Issued</p></th>
        <th><p class="tab">Remarks</p></th>
    </tr>
    @foreach($issued_items as $issued_item)
    <tr>
        <td style="padding: 3px;" class="paddin">&nbsp{{ $loop->iteration }}</td>
        <td style="padding: 3px;">{{ $issued_item->item_name }}&nbsp;</td>
        <td style="padding: 3px;">{{ $issued_item->issue_qty }}</td>
        <td style="padding: 3px;">{{ $issued_item->remarks }}</td>
    </tr>
        @endforeach



</table>

<table border="0" style="border-collapse:collapse;width:80%;margin:5% AUTO 0;">
    <tr>
        <td style="width:550px;text-align:center;border: 1px solid #000;
    padding: 10px 3px;font-size: 13px;">Signature of store clerk with date</td>
        <td style="border-top:none;border-bottom:none;border-right:none;"></td>
        <td style=""></td>
        <td style="width:550px;text-align:center;border: 1px solid #000;
    padding: 10px 3px;font-size: 13px;">
            <p>Remarks all items above</p>


        </td>
    </tr>
    <tr>
        <td style="width:200px;text-align:center;border: 1px solid #000;
    padding: 20px 5px;">&nbsp;</td>

        <td style="width:350px;border-top:none;border-bottom:none;border-right:none;"></td>
        <td style="width:350px;"></td>
        <td style="text-align:center;border: 1px solid #000;
    padding: 20px 5px;">



        </td>
    </tr>
    <tr>
        <td style="width:550px;text-align:center;
    padding: 20px 3px;">&nbsp;</td>

        <td style="width:350px;border-top:none;border-bottom:none;border-right:none;"></td>
        <td style="width:350px;"></td>
        <td style="width:550px;text-align:center;border: 1px solid #000;
    padding: 20px 3px;font-size:13px;">

            Signature with Date

        </td>
    </tr>
</table>

<table style="width: 100%;position: relative;">
    <tfoot style="position:fixed;bottom:20px;">
    <tr style="border-top: 1px solid #999;">
        <td style="border:none;width:150px;padding-top:10px;"><img src="{{asset('images/swachh-bharat.png')}}" alt="" width="130"></td>
        <!-- <td style="border:none;text-align:left;padding-top:10px" colspan="4">
            <p style="font-size:9px;margin:0;font-family: 'Hind', sans-serif;">ब्लॉक - ईए, सेक्टर - I (लाबोनी एस्टेट के विपरीत), साल्ट लेक सिटी, कोलकाता - 700064, फोन/Phone- (033) 2337-0750 / 51, फैक्स/Fax - (033) 2321-6814</p>
            <p style="font-size:8px;margin:0;font-family: 'Hind', sans-serif;">Block - EA, Sector - I (Opposite.Laboni Estate), Salt Lake City, Kolkata - 700 064, ?-???/E-mail - inf@bopter.gov.in, ???????/Website - www.bopter.gov.in</p>
        </td> -->
    </tr>

    </tfoot>
</table>


</body>
</html>
