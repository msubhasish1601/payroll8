<!DOCTYPE html>
<html lang="en">
<head>
    <title>BELLEVUE | Note Sanction Procurement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {-webkit-print-color-adjust: exact;}
        .payslip{font-family:cambria;}
        .payslip .pay-head h2 {font-size: 22px;color: #292929;text-align:center;margin:0;}
        .payslip .pay-head h3{text-align:center;margin:0;}
        .payslip .pay-head h4 {font-size: 17px;text-align:center;margin:0;}
        .payslip .pay-month{text-align:center;}
        .payslip .pay-month h3{margin:0;color: #0099be;}
        .pay-logo img {max-width: 75px;}
        .emp-det{width:100%;}
        .emp-det thead tr th{text-align:center;}
        .emp-det thead tr th{border-bottom:none;}
        .emp-det thead tr th {border-bottom: none;background: #a7a8a9;color: #000;padding: 5px 10px;font-size: 16px;}
        .emp-det tbody tr td{padding:5px 10px;font-size:14px;}
        table.emp-det tr td span {font-weight: 600;}
        .sal-det tr th {background: #a7a8a9;padding: 5px 10px;border-bottom: none;color: #000;text-align:center;}
        .emp-det tr.part td{padding:5px;text-align:left;font-weight:600;border-top:none;background:#efefef;}
        .sal-det tr td{padding:7px 10px;text-align:left;}
        .sal-det tr td p{text-align:right;margin:0;}.mon{text-align:center;font-size:16px;}.mon h3{color:#0099be;margin:0;font-size:25px;}.mon h4{margin:0;}
        .sal-det tr:nth-child(odd) {background-color: #f2f2f2;}
        .emp-det{border-bottom:none;}.total td{font-weight:600;}.leave{border-top:none;}
        .leave tr th{padding:5px 10px;text-align:left;}.leave{}.leave table tr td{text-align:center;}.part td i {font-size: 12px;}
        @media print
        {
            table { page-break-after:auto !important; }
            tr    { page-break-inside:avoid !important; page-break-after:auto !important; }
            td    { page-break-inside:avoid !important; page-break-after:auto !important; }
            thead { display:table-header-group !important; }
            tfoot { display:table-footer-group !important; }
        }
    </style>
</head>
<body>
<!-------------------payslip-body------------------------->
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
                <div class="pay-head">
                    <h2>Board	of	Practical	Training	Eastern	Region	</h2>
                    <h3>(Under	Ministry	Of HRD,	Government	Of	India)</h3>
                    <h4>Block	EA,	Sector-I,	Opposite	Labony	Estate,	Salt	Lake	City,	Kolkata-700064</h4>
                </div>
                <div class="mon">
                    <h4>Sanction for purchase of rate contract store items</h4	>
                </div>
            </td>
        </tr>
    </table>
    <!--------------------------->
    <table style="width:100%;padding-bottom:15px;">
        <tr>
            <th style="text-align:right;font-size:13px;">Sl. No. {{ $results[0]['req_no'] }}</th>
        </tr>
        <tr>
            <th style="text-align:center;font-size:13px;">Sanction of appropriate CFA may be accorded for purchase of following store items (rate contract)</th>

        </tr>
    </table>
    <!--------------employee-details--------------->

    <table border="1" class="emp-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">

        <!------------------------------------------>

        <!------------sanction-note----------------->

        <thead>
        <tr>
            <th>Sl. No.</th>
            <th>Particulars</th>
            <th>Balance quantity available as per store register</th>
            <th>Quantity Proposed</th>
            <th>Rate contract per pc/unit (Rs.)</th>
            <th>Total financial effect (Rs.)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($results as $result)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $result['itemname'] }}</td>
            <td>&nbsp;{{ $result['avl_bal'] }}</td>
            <td>&nbsp;{{ $result['proposed_qty'] }}</td>
            <td>&nbsp;{{ $result['rate_price'] }}</td>
            <td>&nbsp;{{ $result['total_price'] }}</td>
        </tr>
        @endforeach



        </tbody>

        <tfoot>
        <tr>
            <td colspan="6" style="padding-top:40px;padding-right:20px;text-align:right;"><b>Signature</b></td>
        </tfoot>
    </table>

    <table border="1" width="100%" style="border-collapse:collapse;">
        <tr>
            <td style="padding-top:7%;padding-left:15px;">Remarks by O.S.:</td>
        </tr>

        <tr>
            <td style="padding-top:7%;padding-left:15px;">Remarks by A.A.O.:</td>
        </tr>
        <tr>
            <td style="padding-top:7%;padding-left:15px;">Sanction by Director:</td>
        </tr>
    </table>

    <!------------------------------------->

</div>

<!---------------------------------------------------->


<!---------------------js------------------------------------->
<!-------------------------------------------------------->
</body>
</html>
