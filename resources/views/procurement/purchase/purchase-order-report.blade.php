<!DOCTYPE html>
<html lang="en">
<head>
    <title>BELLEVUE | Bank Statement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Hind&display=swap" rel="stylesheet">
    <style>
        body {-webkit-print-color-adjust: exact;font-family:Arial, Helvetica, sans-serif;}
        .bank-state table td h2, .bank-state table td h1{text-align:center;}
        .bank-state table tr td{vertical-align:top;}
        table{width:100%;}
        .acnt thead tr th, .acnt tr td{padding:2px 3px;font-size:14px;}
        .acnt .head td{background:#ddd;font-weight:600;text-align:center;}
        .center{text-align:center;}.right{text-align:right;}
        tbody{height:100%;}
        li{padding-bottom:5px;}
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

<table border="1" class="acnt" style="border-collapse:collapse;border:none;position:relative;width:100%;position: relative;">
    <thead>
    <tr style="border-bottom:none;">
        <th style="text-align:left;border: none;"><img src="{{asset('images/logo2.png')}}" alt="logo" width="100"></th>
        <!-- <th colspan="8" style="text-align:center;border: none;"><h2 style="font-size: 23px;margin: 0;">व्यावहारिक प्रशिक्षण बोर्ड (पूर्वी क्षेत्र)</h2>
            <h1 style="text-align:center;margin:0;font-size:15px;">BOARD OF PRACTICAL TRAINING (EASTERN REGION)</h1>
            <p style="text-align:center;margin:0;font-size: 12px;">भारत सरकार के मानव संसाधन विकास मंत्रालय के उच्चतर शिक्षा विभाग के अधीन</p>
            <p style="text-align:center;margin:0;text-transform:uppercase;font-size: 7.5px;">under minstry of human resource development, Govt. of india, department of higher education</p>
        </th> -->
        <th style="text-align:center;border: none;"><img src="{{asset('images/nats.png')}}" alt="NATS logo" width="80"><p style="margin:0;"><img style="width:120px;" src="{{asset('images/caption.png')}}" alt=""></p><p style="font-size:14px;margin:0">www.mhrdnats.gov.in</p></th>

    </tr>
    </thead>


    <!---------------------------------------------------->

    <!------------bank-statement-body---------------------->
    

    <tr>
        <td colspan="5" style="padding-bottom: 24px;border: none;">Ref : {{ $po_items[0]->requisition_no }}</td>
        <td colspan="5" style="padding-bottom: 24px;text-align:right;border: none;">Date : {{ date('Y-m-d') }}</td>
    </tr>
    <br>

    <tr>
        <td colspan="10" style="border: none; margin-top: 35px;">
            <p style="margin:0;line-height:19px;">To,</p>
            <p></p>
            <p style="margin:0;line-height:19px;">{{$po_items[0]->supplier_name}}</p>
            <p></p>
            <p style="margin:0;line-height:19px;">{{$po_items[0]->supplier_address}}</p>
            <p style="margin:0;line-height:19px;"></p>
            <p style="margin:0;line-height:19px;"></p>
        </td>
    </tr>

    <tr>
        <td colspan="10" style="border: none;padding-bottom:15px;">
            <p style="line-height:19px;margin:0;margin-top:5px;">Sub: Supply / Work Order for {{$po_items[0]->requisition_no}}</p>
        </td>

    </tr>
    <tr>
        <td colspan="10" style="border:none;padding-bottom:10px;">
            Dear Sir,<br><br>

            <p style="text-align:justify;"><span style="padding-left:20px;">With reference to your Quotation received vide Reference No. {{ $po_items[0]->quotation_no }}.  Dated {{ $po_items[0]->quotation_date }}.</span>
            The competent authority is pleased to place the following work/ supply order for the following materials/ goods with quantity, rates as mentioned against each : </p>

        </td>

    </tr>
    </table>
    <!------------------------------------------>

    <!-----------------bank-statement-table-------------------->
<table border="1" style="border-collapse:collapse;width:100%;">
    <tbody class="content" style="border:1px solid #000;">
        <!--  first row -->
        <tr style="background:#cccccc7a;">
            <td style="border-right:1px solid; border-bottom:1px solid;width:1%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">SL.<br>NO.</p></td>
            <!--<td style="border-right:1px solid; border-bottom:1px solid;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Item Code</p></td>-->
            <td style="border-right:1px solid; border-bottom:1px solid;width:15%;"><p style="padding:5px 5px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:left;">Item Name</p></td>
            <!--<td style="border-right:1px solid; border-bottom:1px solid;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Delivery Date</p></td>-->
            <td style="border-right:1px solid; border-bottom:1px solid;width:30%"><p style="padding:5px 5px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:left;">Item Description</p></td>
            <td style="border-right:1px solid; border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px;; font-weight:bold; text-align:center;">Quantity</p></td>
            <td style="border-right:1px solid; border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Unit</p></td>
            <td style="border-right:1px solid; border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Rate(INR)</p></td>
            {{--        <td style="border-right:1px solid; border-bottom:1px solid;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Discount</p></td>--}}
            <td style="border-right:1px solid; border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Tax</p></td>
            <td style="border-right:1px solid; border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Shipping<br> Charges</p></td>
            <td style="border-right:1px solid; border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Other Charges</p></td>
            <td style="border-bottom:1px solid;width: 10%;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">Amount</p></td>
        </tr>
        @php $amount = 0; @endphp
        @foreach($po_items as $po_item)

            <tr style="border-bottom:1px solid;">
                <td style="border-right:none;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $loop->iteration }}</p></td>
                <!--<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center; margin:0px;"></p></td>-->
                <td style="padding:4px 8px;"><p style="padding:0px; margin:0px; font-family: cambria; font-size:12px; font-weight:bold; text-align:left; margin:0px; line-height: 19px;">{{ $po_item->item_name }}</p>

                    <!--<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">04-09-2019</p></td>-->
                <td style="padding:4px 8px;"><p style="padding:0px; margin:0px; font-family: cambria; font-size:12px; font-weight:bold; text-align:left; margin:0px; line-height: 19px;">{{ $po_item->item_desc }}</p>
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $po_item->qty }}</p></td>
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $po_item->unit_name }}</p></td>
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $po_item->price }}</p></td>
                {{--					<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ ($po_item->price) - ($po_item->offer_price) }}</p></td>--}}
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ ($po_item->sgst) + ($po_item->cgst) + ($po_item->igst) }}</p></td>
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $po_item->shipping_charges }}</p></td>
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $po_item->other_charges }}</p></td>
                <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">{{ $po_item->total_with_tax }}</p></td>

            </tr>
            @php $amount += $po_item->total_with_tax; @endphp

        @endforeach













    <!--  second row  -->


        <!--<tr style="border-bottom:1px solid;">
              <td style="border-right:none;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">6</p></td>

              <td style="padding:4px 8px;"><p style="padding:0px; margin:0px; font-family: cambria; font-size:12px; font-weight:bold; text-align:left; margin:0px; line-height: 19px;">Shipping Charges</p>


              <td colspan="4"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">2200</p></td>
              <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>-->
        <!--<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>-->
        <!--<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>
        <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">0</p></td>
        <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">2200</p></td>
</tr>

<tr style="border-bottom:1px solid;">
        <td style="border-right:none;"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">7</p></td>

        <td style="padding:4px 8px;"><p style="padding:0px; margin:0px; font-family: cambria; font-size:12px; font-weight:bold; text-align:left; margin:0px; line-height: 19px;">Other Charges</p>


        <td colspan="4"><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>
        <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>-->
        <!--<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>-->
        <!--<td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;"></p></td>
        <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">0</p></td>
        <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:12px; font-weight:normal; text-align:center;">0</p></td>
</tr>-->

        <?php $number = $amount;
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            "." . $words[$point / 10] . " " .
            $words[$point = $point % 10] : '';
        ?>

        <tr>
            <td colspan="3" style="width:44%;"><p style="padding:5px 10px; margin:0px; font-family: cambria; font-size:13px; font-weight:bold; text-align:left;">Amount in words: (<i class="fas fa-rupee-sign" aria-hidden="true"></i>) {{strtoupper($result)}} only  </p></td>
            <td colspan="4" style="border-right:none;text-align:right;padding-left:15px;font-weight:600;"><p style="font-size:13px;">Total Amount</p></td>
            <td colspan="2" style="border-left:none;"></td>
            <td><p style="padding:5px 0px; margin:0px; font-family: cambria; font-size:14px; font-weight:bold; text-align:center;">{{ $amount }}</p>  </td>
        </tr>




    <tr>
        <td colspan="10">
            <h5 style="padding-left:15px;">Terms &amp; conditions:</h5>
            <ul style="list-style:none;">
                <li>{{ $po_items[0]->terms_n_condition }}</li>
            </ul>
        </td>
    </tr>

        <tr>

            <td colspan="10" style="border: none;text-align:right;"><span style="padding-right:12%;border:none;">Yours faithfully</span> <br><br><br><br></br> <span style="padding-right:1%;font-family: cambria;
    font-style: italic;font-size: 18px;">For <b>Board of Practical Training (ER)</b></span></td>
        </tr>
    </tbody>

    <!---------------------------------------->

    <!-----------------------footer------------------------->

    <tfoot style="position: fixed;bottom:25px;">

    <!--------------------signature-------------------->

    <!--------------------------------------->
    <tr style="border-top: 1px solid #999;">
        <td style="border:none;padding-top:10px;"><img src="{{asset('images/swachh-bharat.png')}}" alt="" width="130"></td>
        <!-- <td style="border:none;text-align:left;padding-top:10px;width:100%;" colspan="9">
            <p style="font-size:10px;margin:0;font-family: 'Hind', sans-serif;">ब्लॉक - ईए, सेक्टर - I (लाबोनी एस्टेट के विपरीत), साल्ट लेक सिटी, कोलकाता - 700064, फोन/Phone- (033) 2337-0750 / 51, फैक्स/Fax - (033) 2321-6814</p>
            <p style="font-size:9px;margin:0;font-family: 'Hind', sans-serif;">Block - EA, Sector - I (Opposite.Laboni Estate), Salt Lake City, Kolkata - 700 064, ई-मेल/E-mail - inf@bopter.gov.in, वेबसाइट/Website - www.bopter.gov.in</p>
        </td> -->
    </tr>

    </tfoot>
</table>
</div>

<!------------------------------------------------->


</body>

</html>
