<!DOCTYPE html>
<html lang="en">
<head>
    <title>BELLEVUE | Stock Register</title>
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
                size:landscape;
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
                    <h4>Stock Register</h4>
                </div>

            </td>
        </tr>
    </table>
    <!--------------------------->
    <!---------------------------------------------------->

    <!------------bank-statement-body---------------------->

    <table border="1" style="border-collapse:collapse;width:100%;">
        <thead style="background:#ddd;">
        <tr>
            <th colspan="10" style="padding:15px 0;">Stock Records from {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }} for {{ $stock_register_items[0]->item_name }}</th>
        </tr>
        <tr>
            <th>Sl. No.</th>
            <th>Item Id</th>
            <th style="width:300px;">Item  Name</th>
            <th>Opening Stock<br> Qty./Unit</th>
            {{--            <th>Indent No. <br>&amp; Date</th>--}}
            <th>Qty. Issue/Unit</th>

            <th>Receive <br>Qty./Unit</th>
            <th>Closing Stock<br> Qty./Unit</th>
            {{--            <th>Department</th>--}}
        </tr>
        </thead>
        <tbody>

        @foreach($stock_register_items as $stock_items)
            <tr>
                <td style="padding:3px;">{{ $loop->iteration }}</td>
                <td style="padding:3px;">{{ $stock_items->item_id }}</td>
                <td style="padding:3px;">{{ $stock_items->item_name }}</td>
                <td style="padding:3px;">{{ $stock_items->opening_balance }}</td>
                {{--            <td style="padding:3px;">{{ $stock_items->opening_balance }}</td>--}}
                <td style="padding:3px;">{{ $stock_items->issue_balance }}</td>
                {{--            <td style="padding:3px;">{{ $stock_items->closing_balance }}, 01/11/2019</td>--}}
                <td>{{ $stock_items->receive_balance }}</td>
                <td>{{ $stock_items->closing_balance }}</td>
                {{--            <td>Purchase</td>--}}
            </tr>
        @endforeach


        </tbody>
    </table>
    <!---------------------------------------->

    <!-----------------------footer------------------------->
    <table style="text-align: center;
    margin-top: 10%;
    width: 20%;
    float: right;
">
        <tr>

            <td style="border-top:1px solid #000;">Verified by &amp; Signed</td>
        </tr>
    </table>
</div>

<!------------------------------------------------->


</body>

</html>
