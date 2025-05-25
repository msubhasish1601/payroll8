<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="bellevue-logo.png">
    <title>{{ config('app.name', 'Laravel') }} Form 16</title>
    <style type="text/css">
    body {
        font-family: "Arial";
    }

    table tr td {
        text-align: right;
        font-size: 14px;
    }

    @media print {
        @page {
            size: potrait
        }
    }
    </style>
</head>

<body>
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="text-transform: uppercase;text-align: center;">
                    <h1 style="margin-bottom: 0;">FORM NO. 16</h1>
                    <!-- <h3 style="margin:0;"></h3> -->
                    <h4 style="margin: 0;">(See rule 31 (I) (a))</h4>
                </th>
            </tr>
            <tr>
                <td style="text-align: left;padding-top:10px;padding-bottom:10px;">Certificate under section 203 of the
                    Income
                    Tax Act.,1961 for Tax deducted at source from income chargeable under the head "Salaries"</td>
            </tr>
        </thead>
    </table>

    <table style="width:100%;padding-bottom: 15px;">
        <tr>
            <td
                style="width:33%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;text-align: left;padding:10px;">
                Name & Address of Employer</td>
            <td
                style="width:33%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;text-align: center;padding:10px;">
                &nbsp;</td>
            <td
                style="width:34%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;text-align: left;padding:10px;">
                Name & Designation of Employee</td>
        </tr>
        <tr>
            <td style="width:33%;text-align: left;padding:10px;">BELLE VUE CLINIC,<br>9, DR. U. N. BRAHMACHARI
                STREET,<br>KOLKATA - 700017</td>
            <td style="width:33%;text-align: left;padding:10px;">&nbsp;</td>
            <td style="width:34%;text-align: left;padding:10px;">
                {{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}<br>{{$empInfo->emp_designation??''}}<br>Employee
                No : {{$empInfo->old_emp_code??''}}</td>
        </tr>
        <tr>
            <td style="width:100%;text-align: left;padding:10px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:33%;text-align: left;padding:10px;">PAN/GIR NO</td>
            <td style="width:33%;text-align: left;padding:10px;">TAN</td>
            <td style="width:34%;text-align: left;padding:10px;">PAN/GIR NO: {{$empInfo->emp_pan_no??''}}</td>
        </tr>
        <tr>
            <td style="width:33%;text-align: left;padding:10px;">AAATB4004B</td>
            <td style="width:33%;text-align: left;padding:10px;">CALB00187F</td>
            <td style="width:34%;text-align: left;padding:10px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:100%;text-align: left;padding:10px;" colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:33%;text-align: left;padding:10px;">Period From : {{$start_date}}</td>
            <td style="width:33%;text-align: left;padding:10px;">To : {{$end_date}}</td>
            <td style="width:34%;text-align: left;padding:10px;">Assessment Year : {{$assesment_year}}</td>
        </tr>
        <tr>
            <td style="width:100%;text-align: center;padding:10px;padding-bottom:0px;" colspan="3">TDS Circle where
                Annual Return/Statement u/s206 is to be filled ITO-21(5)/Kol</td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td
                style="width:100%;text-align: center;padding:10px;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">
                DETAILS OF SALARY PAID AND OTHER INCOME AND TAX DEDUCTED</td>
        </tr>
    </table>
    @php
    $standardDed=\Helpers::getStandardDeduction($fyear,'M');
    $standardDed=json_decode($standardDed);
    //dd($standardDed);

    $records=\Helpers::getItaxPayrollDetails($empInfo->emp_code,$fyear);
    $records=json_decode($records);

    //dd($records);

    $tot_basic=0;
    if(isset($records->tot_basic)){
    $tot_basic=(float) str_replace(',', '', $records->tot_basic??'');
    }
    $tot_da=0;
    if(isset($records->tot_da)){
    $tot_da=(float) str_replace(',', '', $records->tot_da??'');
    }
    $tot_others_alw=0;
    if(isset($records->tot_others_alw)){
    $tot_others_alw=(float) str_replace(',', '', $records->tot_others_alw??'');
    }
    $tot_hra=0;
    if(isset($records->tot_hra)){
    $tot_hra=(float) str_replace(',', '', $records->tot_hra??'');
    }
    $tot_bonus=0;
    if(isset($records->tot_bonus)){
    $tot_bonus=(float) str_replace(',', '', $records->tot_bonus??'');
    }
    $tot_hta=0;
    if(isset($records->tot_hta)){
    $tot_hta=(float) str_replace(',', '', $records->tot_hta??'');
    }
    $tot_over_time=0;
    if(isset($records->tot_over_time)){
    $tot_over_time=(float) str_replace(',', '', $records->tot_over_time??'');
    }
    $tot_commission=0;
    if(isset($records->tot_commission)){
    $tot_commission=(float) str_replace(',', '', $records->tot_commission??'');
    }
    $tot_leave_enc=0;
    if(isset($records->tot_leave_enc)){
    $tot_leave_enc=(float) str_replace(',', '', $records->tot_leave_enc??'');
    }
    $tot_medreimbersement=0;
    if(isset($records->tot_medreimbersement)){
    $tot_medreimbersement=(float) str_replace(',', '', $records->tot_medreimbersement??'');
    }
    $tot_othperks=0;
    if(isset($records->tot_othperks)){
    $tot_othperks=(float) str_replace(',', '', $records->tot_othperks??'');
    }
    $tot_conveyence=0;
    if(isset($records->tot_conveyence)){
    $tot_conveyence=(float) str_replace(',', '', $records->tot_conveyence??'');
    }
    $tot_incometax_deducted=0;
    if(isset($records->tot_incometax_deducted)){
    $tot_incometax_deducted=(float) str_replace(',', '', $records->tot_incometax_deducted??'');
    }

    $tot_basic_da=(float) str_replace(',', '', $tot_basic)+(float) str_replace(',', '', $tot_da);


    $tot_exemption=0;

    $total_income=(float) str_replace(',', '', $tot_basic_da)+(float) str_replace(',', '', $tot_others_alw)+(float)
    str_replace(',', '', $tot_hra)+(float) str_replace(',', '', $tot_bonus)+(float) str_replace(',', '',
    $tot_hta)+(float) str_replace(',', '', $tot_over_time)+(float) str_replace(',', '', $tot_commission)+(float)
    str_replace(',', '', $tot_leave_enc)+(float) str_replace(',', '', $tot_medreimbersement)+(float) str_replace(',',
    '', $tot_othperks);

    $tot_std_ded=isset($standardDed->itax_slab->amount_to)?number_format((float)$standardDed->itax_slab->amount_to??'',
    2, '.', ''):'0.00';

    $tot_exemption=(float) str_replace(',', '', $tot_std_ded)+(float) str_replace(',', '', $tot_hra)+(float)
    str_replace(',', '', $tot_conveyence)+(float) str_replace(',', '', $tot_hta);

    $tot_balance=(float) str_replace(',', '', $total_income)-(float) str_replace(',', '', $tot_exemption);

    $tot_ptax=0;
    if(isset($records->tot_ptax)){
    $tot_ptax=(float) str_replace(',', '', $records->tot_ptax??'');
    }

    $ihl=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Int. on H.Loan');
    $ihl=json_decode($ihl);
    //dd($ihl);
    $ihl_amount=0;
    if(isset($ihl->itax_savings->amount)){
    $ihl_amount=$ihl->itax_savings->amount;
    }

    $ded_aggregate_five=(float) str_replace(',', '', $tot_ptax)+(float) str_replace(',', '', $ihl_amount);

    $tot_chargeable_inc_3_5=(float) str_replace(',', '', $tot_balance)-(float) str_replace(',', '',
    $ded_aggregate_five);
    $tot_gross_income=$tot_chargeable_inc_3_5;
    @endphp
    <table style="width:100%;">
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">1.</td>
            <td style="padding:5px;text-align: left;width:30%;">Gross salary*</td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;"></td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">A) Basic Salary (Basic+DA)</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_basic_da??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">B) Other Allowances</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$tot_others_alw??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">C) H.R.A</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_hra??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">D) Bonus</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_bonus??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">E) L.T.A</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_hta??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">F) Over Time</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_over_time??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">G) Uniform Alw.</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">0.00</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">H) Commission</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$tot_commission??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">I) Leave Encash</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_leave_enc??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">K) Medical Expe. Reimbr.</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$tot_medreimbersement??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">L) Other Perks</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_othperks??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: center;width:30%;">Total</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$total_income??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">2a.</td>
            <td style="padding:5px;text-align: left;width:30%;">Less :Standard deduction</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{isset($standardDed->itax_slab->amount_to)?number_format((float)$standardDed->itax_slab->amount_to??'', 2, '.', ''):'0.00'}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">2b.</td>
            <td style="padding:5px;text-align: left;width:30%;">Less :Allowance to the extent exempt u/s.10</td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;"></td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">I) HRA</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_hra??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">II) Conveyance Allow</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$tot_conveyence??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">III) LTA</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_hta??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: center;width:30%;">Total Exemption</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_exemption??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">3.</td>
            <td style="padding:5px;text-align: left;width:30%;">Balance (1-2)</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_balance??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">4.</td>
            <td style="padding:5px;text-align: left;width:30%;">Deduction</td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;"></td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">a. Tax on Employment</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_ptax??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;width:30%;">b. Less Int. on H.Loan(u/s 24(b))</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$ihl_amount??'', 2, '.', '')}}
            </td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">5.</td>
            <td style="padding:5px;text-align: left;width:30%;">Aggregate of 4 (a) to (c)</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$ded_aggregate_five??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">6.</td>
            <td style="padding:5px;text-align: left;width:30%;">Income Chargeable under the head salaries (3-5)</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$tot_chargeable_inc_3_5??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">7.</td>
            <td style="padding:5px;text-align: left;width:30%;">Add :Any other income reported by the employee</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">0.00</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">8.</td>
            <td style="padding:5px;text-align: left;width:30%;">Gross Total Income (6 plus 7)</td>
            <td style="padding:5px;text-align: left;width:1%;">:</td>
            <td style="padding:5px;text-align: left;width:20%;">
                {{number_format((float)$tot_gross_income??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
            <td style="padding:5px;text-align: left;">&nbsp;</td>
        </tr>
    </table>
    @php
        $tot_pf=0;
        if(isset($records->tot_pf)){
            $tot_pf=(float) str_replace(',', '', $records->tot_pf??'');
        }

        $lic=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'L.I.C.');
        $lic=json_decode($lic);
        //dd($lic);
        $lic_amount=0;
        if(isset($lic->itax_savings->amount)){
            $lic_amount=$lic->itax_savings->amount;
        }

        $ppf=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'P.P.F.');
        $ppf=json_decode($ppf);
        //dd($ppf);
        $ppf_amount=0;
        if(isset($ppf->itax_savings->amount)){
            $ppf_amount=$ppf->itax_savings->amount;
        }

        $ulip=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'U.L.I.P.');
        $ulip=json_decode($ulip);
        //dd($ulip);
        $ulip_amount=0;
        if(isset($ulip->itax_savings->amount)){
            $ulip_amount=$ulip->itax_savings->amount;
        }

        $nsc=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'N.S.C.');
        $nsc=json_decode($nsc);
        //dd($nsc);
        $nsc_amount=0;
        if(isset($nsc->itax_savings->amount)){
            $nsc_amount=$nsc->itax_savings->amount;
        }

        $intnsc=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Interest On N.S.C.');
        $intnsc=json_decode($intnsc);
        //dd($intnsc);
        $intnsc_amount=0;
        if(isset($intnsc->itax_savings->amount)){
            $intnsc_amount=$intnsc->itax_savings->amount;
        }

        $rohl=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Repay of Housing Loan');
        $rohl=json_decode($rohl);
        //dd($rohl);
        $rohl_amount=0;
        if(isset($rohl->itax_savings->amount)){
            $rohl_amount=$rohl->itax_savings->amount;
        }

        $tf=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Tution Fees');
        $tf=json_decode($tf);
        //dd($tf);
        $tf_amount=0;
        if(isset($tf->itax_savings->amount)){
            $tf_amount=$tf->itax_savings->amount;
        }

        $tsb=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Tax Saving Bond');
        $tsb=json_decode($tsb);
        //dd($tsb);
        $tsb_amount=0;
        if(isset($tsb->itax_savings->amount)){
            $tsb_amount=$tsb->itax_savings->amount;
        }

        $js=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Jiwan Surksha');
        $js=json_decode($js);
        //dd($js);
        $js_amount=0;
        if(isset($js->itax_savings->amount)){
            $js_amount=$js->itax_savings->amount;
        }

        $tot_savings_c=(float) str_replace(',', '', $tot_pf)+(float) str_replace(',', '', $lic_amount)+(float) str_replace(',', '', $ppf_amount)+(float) str_replace(',', '', $ulip_amount)+(float) str_replace(',', '', $nsc_amount)+(float) str_replace(',', '', $intnsc_amount)+(float) str_replace(',', '', $rohl_amount)+(float) str_replace(',', '', $tf_amount)+(float) str_replace(',', '', $tsb_amount)+(float) str_replace(',', '', $js_amount);

        $tot_savings_c_qualify=$tot_savings_c;

        $eightyc=\Helpers::getItaxType($fyear,'80C');
        $eightyc=json_decode($eightyc);
        //dd($eightyc);
        $eightyc_max_amount=150000;
        if(isset($eightyc->itax_type->max_amount)){
            $eightyc_max_amount=$eightyc->itax_type->max_amount;
        }

        if($tot_savings_c>$eightyc_max_amount){
            $tot_savings_c_qualify=$eightyc_max_amount;
        }

        $mediclaim=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Mediclaim');
        $mediclaim=json_decode($mediclaim);
        //dd($mediclaim);
        $mediclaim_amount=0;
        if(isset($mediclaim->itax_savings->amount)){
            $mediclaim_amount=$mediclaim->itax_savings->amount;
        }

        $divyang=\Helpers::getFormXVISavings($empInfo->emp_code,$fyear,'Handicapped');
        $divyang=json_decode($divyang);
        //dd($divyang);
        $divyang_amount=0;
        if(isset($divyang->itax_savings->amount)){
            $divyang_amount=$divyang->itax_savings->amount;
        }

        $eightyd=\Helpers::getItaxType($fyear,'80D');
        $eightyd=json_decode($eightyd);
        //dd($eightyd);
        $eightyd_max_amount=25000;
        if(isset($eightyd->itax_type->max_amount)){
            $eightyd_max_amount=$eightyd->itax_type->max_amount;
        }
        $tot_savings_d=(float) str_replace(',', '', $mediclaim_amount)+(float) str_replace(',', '', $divyang_amount);
        $tot_savings_d_qualify=$tot_savings_d;

        if($tot_savings_d>$eightyd_max_amount){
            $tot_savings_d_qualify=$eightyd_max_amount;
        }

        $total_deduction_via=(float) str_replace(',', '', $tot_savings_c_qualify)+(float) str_replace(',', '', $tot_savings_d_qualify);

        $tot_income=(float) str_replace(',', '', $tot_gross_income)-(float) str_replace(',', '', $total_deduction_via);
        $taxable_income=$tot_income;

        $taxable_slab=\Helpers::getTaxPayableSlab($fyear,$taxable_income,'M');
        $taxable_slab=json_decode($taxable_slab);
        //echo $taxable_income;
        //dd($taxable_slab);
        $taxpayable =0;
        if(isset($taxable_slab->itax_slab->percentage)){
            $taxpayable=(($taxable_income*$taxable_slab->itax_slab->percentage)/100);
            $taxpayable = round($taxpayable,2)+$taxable_slab->itax_slab->additional_amount;
        }
        $taxpayable = $taxpayable-(float) str_replace(',', '', $tot_incometax_deducted);
        $taxpayable = round($taxpayable,2);


        $rates=\Helpers::getEffectiveItaxRate($fyear);
        $rates=json_decode($rates);

        $surcharge=0;
        if($taxpayable>0){
            $surcharge=(($taxpayable*$rates->surcharge)/100);
        }
        $surcharge = round($surcharge,2);

        $net_payable=(float)$taxpayable+(float)$surcharge;

        $cess=0;
        if($taxpayable>0){
            $cess=(($taxpayable*$rates->ecess)/100);
        }
        $cess = round($cess,2);
        $net_payable=(float)$taxpayable+(float)$cess;

    @endphp
    <table style="width:100%;">
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">9.</td>
            <td style="padding:5px;text-align: left;width:30%;">Deduction under Chapter VI-A</td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">Gross</td>

            <td style="padding:5px;text-align: left;">Qualify</td>
            <td style="padding:5px;text-align: left;">Deductible</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">(A) Section 80C,80CCC and 80CCD</td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;"></td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(a) Provident Fund</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_pf??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(b) L.I.C.</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$lic_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(c) P.P.F.</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$ppf_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(d) U.L.I.P.</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$ulip_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(e) N.S.C.</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$nsc_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(f) Interest On N.S.C.</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$intnsc_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(g) Repay of Housing Loan</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$rohl_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(h) Tution Fees</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tf_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(i) Tax Saving Bond</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tsb_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">(j) Jiwan Surksha</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$js_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;"></td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;"></td>

            <td style="padding:5px;text-align: left;">{{number_format((float)$tot_savings_c_qualify??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">(B) Other Sections(for e.g.80D,80E,80G etc.)</td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;"></td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">Mediclaim (80D)</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$mediclaim_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>
            <td style="padding:5px;text-align: left;width:30%;">
                <div style="padding-left:15px;">Handicapped (80U)</div>
            </td>
            <td style="padding:5px;text-align: left;width:1%;"></td>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$divyang_amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;">{{number_format((float)$tot_savings_d_qualify??'', 2, '.', '')}}</td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$total_deduction_via??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">10.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Aggregate of deductible amount under chapter
                VI-A</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$total_deduction_via??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">11.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Total Income (8-10)</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$tot_income??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">12.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Tax On Total Income</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$tot_incometax_deducted??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">13.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Tax payable</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$taxpayable??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">14.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Add Surcharge</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$surcharge??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">15.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Add Education Cess</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$cess??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">16.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Total Tax</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$net_payable??'', 2, '.', '')}}</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">17.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Less : Tax Deducted at Source</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">0.00</td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">18.</td>
            <td style="padding:5px;text-align: left;width:51%;" colspan="3">Tax payable/refundale</td>
            <td style="padding:5px;text-align: left;"></td>
            <td style="padding:5px;text-align: left;">{{number_format((float)$net_payable??'', 2, '.', '')}}</td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td
                style="width:100%;text-align: center;padding:10px;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">
                Details of Tax Deducted and Deposited into Central Government Account</td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td style="padding:5px;text-align: left;width:20%;border-bottom: 1px dashed #000;">Amount</td>

            <td style="padding:5px;text-align: left;width:15%;border-bottom: 1px dashed #000;">Payment Date</td>
            <td style="padding:5px;text-align: left;width:15%;border-bottom: 1px dashed #000;">Chln No</td>
            <td style="padding:5px;text-align: left;width:15%;border-bottom: 1px dashed #000;">BSR Code</td>
            <td style="padding:5px;text-align: left;border-bottom: 1px dashed #000;">Name of Bank & Branch Where Tax
                Deposited</td>
        </tr>
        @if(count($deposit_records)>0)
        @foreach($deposit_records as $deposits)
        <tr>
            <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$deposits->amount??'', 2, '.', '')}}</td>

            <td style="padding:5px;text-align: left;width:15%;">{{date('d/m/Y',strtotime($deposits->payment_date))}}</td>
            <td style="padding:5px;text-align: left;width:15%;">{{$deposits->challan_no}}</td>
            <td style="padding:5px;text-align: left;width:15%;">{{$deposits->bsr_code}}</td>
            <td style="padding:5px;text-align: left;">{{$deposits->bank}}</td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="5" style="padding:5px;text-align:left;">
                <p>Certified that a sum of Rs.0.00 (in
                    words)...............................................................................
                    RUPEES ONLY........................................................
                    has been deducted at source and paid to the credit of the Central Government.
                    Further certified that the above information is true and correct as per records</p>

            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align:center;padding:35px 5px;">Signature of the person responsible
                for deduction of tax.</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:left">
                Place :<br>
                Date :
            </td>
            <td colspan="2" style="text-align:left">
                Full Name : <br>
                Designation :
            </td>
        </tr>
    </table>

    <div style="page-break-before:always">&nbsp;</div>
    <table style="width:100%;">
        <thead>
            <tr>
                <th style="text-transform: uppercase;text-align: center;">
                    <h1 style="margin-bottom: 0;">FORM NO.12BA</h1>
                    <!-- <h3 style="margin:0;"></h3> -->
                    <h4 style="margin: 0;">See Rule 26A(2)</h4>
                </th>
            </tr>
            <tr>
                <td style="text-align: left;padding-top:10px;padding-bottom:10px;">Statement showing particulars of
                    perquisites,other fringe benefits or amenities and profits in lieu of salary with value thereof.
                </td>
            </tr>
        </thead>
    </table>

    <table style="width:100%;padding-bottom: 15px;">
        <tr>
            <td
                style="width:33%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;text-align: left;padding:10px;">
                Name & Address of Employer</td>
            <td
                style="width:33%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;text-align: center;padding:10px;">
                &nbsp;</td>
            <td
                style="width:34%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;text-align: left;padding:10px;">
                Name & Designation of Employee</td>
        </tr>
        <tr>
            <td style="width:33%;text-align: left;padding:10px;">BELLE VUE CLINIC,<br>9, DR. U. N. BRAHMACHARI
                STREET,<br>KOLKATA - 700017</td>
            <td style="width:33%;text-align: left;padding:10px;">&nbsp;</td>
            <td style="width:34%;text-align: left;padding:10px;">{{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}<br>{{$empInfo->emp_designation??''}}<br>Employee
                No : {{$empInfo->old_emp_code??''}}</td>
        </tr>

        <tr>
            <td style="width:33%;text-align: left;padding:10px;"></td>
            <td style="width:33%;text-align: left;padding:10px;"></td>
            <td style="width:34%;text-align: left;padding:10px;">Assessment Year : {{$assesment_year}}</td>
        </tr>

    </table>
    <table style="width:100%;">
        <tr>
            <td
                style="padding:5px;text-align: left;width:2%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">
                Sl No.<br>&nbsp;</td>

            <td style="padding:5px;text-align: left;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">Nature
                of Perquisite
                (see rule 3)<br>&nbsp;</td>
            <td
                style="padding:5px;text-align: left;width:15%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">
                <div style="text-align:center;">Value of Perquisite
                    as per rule<br>
                    (Rs)</div>
            </td>
            <td
                style="padding:5px;text-align: left;width:15%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">
                <div style="text-align:center;">Amount,if any paid
                    by employee<br>
                    (Rs)</div>
            </td>
            <td
                style="padding:5px;text-align: left;width:15%;border-bottom: 1px dashed #000;border-top: 1px dashed #000;">
                <div style="text-align:center;">Amount of taxable
                    Perquisite<br>
                    (Rs)</div>
            </td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">1</td>

            <td style="padding:5px;text-align: left;">Accommodation</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">2</td>

            <td style="padding:5px;text-align: left;">Cars</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">3</td>

            <td style="padding:5px;text-align: left;">Sweeper,gardener,watchman</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">4</td>

            <td style="padding:5px;text-align: left;">Gas,electricity,water</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">5</td>

            <td style="padding:5px;text-align: left;">Concessional loan</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">6</td>

            <td style="padding:5px;text-align: left;">Holiday expenses</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">7</td>

            <td style="padding:5px;text-align: left;">Free or concessional travel</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">8</td>

            <td style="padding:5px;text-align: left;">Free meals</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">9</td>

            <td style="padding:5px;text-align: left;">Education</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">10</td>

            <td style="padding:5px;text-align: left;">Gifts,vouchers,etc.</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">11</td>

            <td style="padding:5px;text-align: left;">Credit Card expenses</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">12</td>

            <td style="padding:5px;text-align: left;">Club expenses</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">13</td>

            <td style="padding:5px;text-align: left;">Use of movable assets by employees</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">14</td>

            <td style="padding:5px;text-align: left;">Transfer of assets to employees</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">15</td>

            <td style="padding:5px;text-align: left;">Stock options(non-qualified options)</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">16</td>

            <td style="padding:5px;text-align: left;">Other benefits or amenities</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;">17</td>

            <td style="padding:5px;text-align: left;">Profits in lieu of salary as per section 17(3)</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>

            <td style="padding:5px;text-align: left;">Total Value of Perquisites</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="padding:5px;text-align: left;width:2%;"></td>

            <td style="padding:5px;text-align: left;">Total Value of profit in lieu of salary</td>
            <td style="padding:5px;text-align: right;width:15%;">0.00</td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
            <td style="padding:5px;text-align: right;width:15%;"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px dashed #000;" colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5" style="padding:5px;text-align:left;">
                <p>
                    I, Ramesh Kumar Biyani son of Late Madan Lal Biyani as an Accountant do hereby declare on behalf of
                    {{ config('app.name', 'Laravel') }}
                    CLINIC that the information given above is based on the books of account,documents and other
                    relevant records or
                    information available with us and the details of value of each such perquisite are in accordance
                    with section 17 and
                    rules framed thereunder and that such information is true and correct.</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding:35px 5px 35px 5px;text-align:center;">Signature of the person responsible
                for deduction of tax.</td>
        </tr>
        <tr>

            <td style="padding:5px;text-align:left;" colspan="3">Dated : ,<br> Places: </td>
            <td style="padding:5px;text-align:left;" colspan="2">Full Name :<br><br>
                Designation: </td>


        </tr>
    </table>

</body>

</html>
