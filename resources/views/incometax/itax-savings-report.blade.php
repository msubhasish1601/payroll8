<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="bellevue-logo.png">
    <title>{{ config('app.name', 'Laravel') }} Itax Report</title>
    <style type="text/css">
    body {
        font-family: "Arial";
    }
    table tr td {
        text-align: right;
        font-size: 13px;
    }

    @media print {
        @page {
            size: landscape
        }
    }
    </style>
</head>

<body>


    <table style="width:100%;border-bottom: 1px dashed #000;padding-bottom: 15px;">
        <thead>
            <tr>
                <th style="text-align:left;width:250px;"><img src="{{ asset('img/bellevue-logo.png') }}" alt="logo">
                </th>
                <th style="text-transform: uppercase;text-align: center;">
                    <h1 style="margin-bottom: 0;">{{ config('app.name', 'Laravel') }}</h1>
                    <h3 style="margin:0;">9, Dr. U.N. Brahmachari Street, Kolkata - 700017</h3>
                    <h4 style="margin: 0;">DETAILS OF REMUNERATION PAID & INCOME TAX
                        DEDUCTABLE FOR THE YEAR {{$fyear}}
                    </h4>
                </th>
            </tr>
        </thead>
    </table>

    <table style="width:100%;margin:15px 0;padding-bottom: 15px;">
        <tr>
            <td style="text-align: left;font-weight: 700;width:30%;">EMPLOYEE NAME</td>
            <td style="text-align: left;width:30%;">{{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}</td>
            <td style="width:20%;">&nbsp;</td>
            <td style="width:20%;">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align: left;font-weight: 700;width:30%;">EMPLOYEE CODE</td>
            <td style="text-align: left;width:30%;">{{$empInfo->old_emp_code??''}}</td>
            <td style="width:20%;">&nbsp;</td>
            <td style="width:20%;">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan=5>
                <table style="width:100%;">
                @php
                    $records=\Helpers::getItaxPayrollDetails($empInfo->emp_code,$fyear);
                    $records=json_decode($records);

                    $standardDed=\Helpers::getStandardDeduction($fyear,'M');
                    $standardDed=json_decode($standardDed);
                    //dd($standardDed);

                    $tot_less=0;
                    $total_income=(float) str_replace(',', '', $records->tot_salary)+(float) str_replace(',', '', $records->tot_bonus)+(float) str_replace(',', '', $records->tot_hta)+(float) str_replace(',', '', $records->tot_leave_enc)+(float) str_replace(',', '', $records->tot_commission)+(float) str_replace(',', '', $records->tot_othperks)+(float) str_replace(',', '', $records->tot_medreimbersement);

                    $total_income_with_conv=$total_income;
                    $total_income=$total_income-(float) str_replace(',', '', $records->tot_conveyence??'');

                    if(isset($records->tot_hra)){
                        $tot_less=$tot_less+(float) str_replace(',', '', $records->tot_hra??'');
                    }
                    if(isset($records->tot_hta)){
                        $tot_less=$tot_less+(float) str_replace(',', '', $records->tot_hta??'');
                    }
                    if(isset($standardDed->itax_slab->amount_to)){
                        $tot_less=$tot_less+(float) str_replace(',', '', $standardDed->itax_slab->amount_to??'');
                    }
                    if(isset($records->tot_ptax)){
                        $tot_less=$tot_less+(float) str_replace(',', '', $records->tot_ptax??'');
                    }

                    $ihrl=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'INTEREST ON H.R.LOAN');
                    $ihrl=json_decode($ihrl);
                    //dd($ihrl);
                    $ihrl_amount=0;
                    if(isset($ihrl->itax_savings->amount)){
                        $ihrl_amount=$ihrl->itax_savings->amount;
                    }
                    $tot_less=$tot_less+(float) str_replace(',', '', $ihrl_amount??'');

                    $mediclaim=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'MEDICAL DEDUCTION');
                    $mediclaim=json_decode($mediclaim);
                    //dd($mediclaim);
                    $mediclaim_amount=0;
                    if(isset($mediclaim->itax_savings->amount)){
                        $mediclaim_amount=$mediclaim->itax_savings->amount;
                    }
                   // $tot_less=$tot_less+(float) str_replace(',', '', $mediclaim_amount??'');

                    $tot_pf=0;
                    if(isset($records->tot_pf)){
                        $tot_pf=(float) str_replace(',', '', $records->tot_pf??'');
                    }

                    $tot_incometax_deducted=0;
                    if(isset($records->tot_incometax_deducted)){
                    $tot_incometax_deducted=(float) str_replace(',', '', $records->tot_incometax_deducted??'');
                    }

                @endphp
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">SALARY</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_salary??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">OTHER PERKS</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_othperks??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">V.D.A</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">0.00</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">BONUS</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_bonus??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">L.T.A</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_hta??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">LEAVE PAY</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_leave_enc??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">OVER TIME</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">0.00</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">COMMISSION</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_commission??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">MEDICAL EXP REIMB.</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_medreimbersement??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">ELECTRICITY PROV.</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">0.00</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">OTHERS</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">0.00</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr style="border-top: 1px dashed #000;">
                        <td style="padding:5px;border-top: 1px dashed #000;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;border-top: 1px dashed #000;text-align: left;width:30%;">&nbsp;</td>
                        <td style="padding:5px;border-top: 1px dashed #000;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;border-top: 1px dashed #000;text-align: left;width:20%;">TOTAL INCOME</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;border-bottom: 1px dashed #000;text-align: left;">{{number_format((float)$total_income_with_conv??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">LESS CONVEYANCE</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$records->tot_conveyence??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">TOTAL INCOME<br>AFTER LESS CONVEYANCE</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$total_income??'', 2, '.', '')}}</td>
                    </tr>

                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">LESS</td>
                        <td style="padding:5px;text-align: left;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">HOUSE RENT RELIEF</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_hra??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">STANDARD DEDUCTION</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{isset($standardDed->itax_slab->amount_to)?number_format((float)$standardDed->itax_slab->amount_to??'', 2, '.', ''):'0.00'}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">MEDICAL DEDUCTION</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$mediclaim_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">INTEREST ON H.R.LOAN</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$ihrl_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">L.T.A</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_hta??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">PROFESSIONAL TAX</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$records->tot_ptax??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">TOTAL</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;border-bottom: 1px dashed #000;text-align: left;">{{number_format((float)$tot_less??'', 2, '.', '')}}</td>
                    </tr>
                    @php
                    $total_income=$total_income-(float) str_replace(',', '', $tot_less??'');
                    @endphp
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$total_income??'', 2, '.', '')}}</td>
                    </tr>
                    @php
                    $nsc=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'N.S.C');
                    $nsc=json_decode($nsc);
                    //dd($nsc);
                    $nsc_amount=0;
                    if(isset($nsc->itax_savings->amount)){
                        $nsc_amount=$nsc->itax_savings->amount;
                    }

                    $nsc_int=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'INTEREST ON N.S.C');
                    $nsc_int=json_decode($nsc_int);
                    //dd($nsc_int);
                    $nsc_int_amount=0;
                    if(isset($nsc_int->itax_savings->amount)){
                        $nsc_int_amount=$nsc_int->itax_savings->amount;
                    }

                    $lic=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'L.I.C');
                    $lic=json_decode($lic);
                    //dd($nsc_int);
                    $lic_amount=0;
                    if(isset($lic->itax_savings->amount)){
                        $lic_amount=$lic->itax_savings->amount;
                    }

                    $hrp=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'HOUSE RENT PAID');
                    $hrp=json_decode($hrp);
                    //dd($nsc_int);
                    $hrp_amount=0;
                    if(isset($hrp->itax_savings->amount)){
                        $hrp_amount=$lic->itax_savings->amount;
                    }

                    $ppf=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'PUBLIC PROVIDENT FUND');
                    $ppf=json_decode($ppf);
                    //dd($nsc_int);
                    $ppf_amount=0;
                    if(isset($ppf->itax_savings->amount)){
                        $ppf_amount=$ppf->itax_savings->amount;
                    }

                    $tsb=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'TAX SAVING BOND');
                    $tsb=json_decode($tsb);
                    //dd($nsc_int);
                    $tsb_amount=0;
                    if(isset($tsb->itax_savings->amount)){
                        $tsb_amount=$tsb->itax_savings->amount;
                    }

                    $ulip=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'UNIT LIKED INSURANCE PLAN');
                    $ulip=json_decode($ulip);
                    //dd($nsc_int);
                    $ulip_amount=0;
                    if(isset($ulip->itax_savings->amount)){
                        $ulip_amount=$ulip->itax_savings->amount;
                    }

                    $tf=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'TUTION FEES');
                    $tf=json_decode($tf);
                    //dd($nsc_int);
                    $tf_amount=0;
                    if(isset($tf->itax_savings->amount)){
                        $tf_amount=$tf->itax_savings->amount;
                    }

                    $rohl=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'REPAYMENT OF HOUSE LOAN');
                    $rohl=json_decode($rohl);
                    //dd($nsc_int);
                    $rohl_amount=0;
                    if(isset($rohl->itax_savings->amount)){
                        $rohl_amount=$rohl->itax_savings->amount;
                    }

                    $us80c=\Helpers::getItaxSavings($empInfo->emp_code,$fyear,'U/S80CCC');
                    $us80c=json_decode($us80c);
                    //dd($nsc_int);
                    $us80c_amount=0;
                    if(isset($us80c->itax_savings->amount)){
                        $us80c_amount=$us80c->itax_savings->amount;
                    }


                    $total_savings=(float) str_replace(',', '', $nsc_amount)+(float) str_replace(',', '', $nsc_int_amount)+(float) str_replace(',', '', $lic_amount)+(float) str_replace(',', '', $hrp_amount)+(float) str_replace(',', '', $ppf_amount)+(float) str_replace(',', '', $tsb_amount)+(float) str_replace(',', '', $ulip_amount)+(float) str_replace(',', '', $tf_amount)+(float) str_replace(',', '', $rohl_amount)+(float) str_replace(',', '', $us80c_amount)+(float) str_replace(',', '', $tot_pf);

                    $applicable_savings=$total_savings;
                    $eightyc=\Helpers::getItaxType($fyear,'80C');
                    $eightyc=json_decode($eightyc);
                    //dd($eightyc);
                    $eightyc_max_amount=150000;
                    if(isset($eightyc->itax_type->max_amount)){
                        $eightyc_max_amount=$eightyc->itax_type->max_amount;
                    }


                    if($total_savings>$eightyc_max_amount){
                        $applicable_savings=$eightyc_max_amount;
                    }

                    $taxable_income=(float) str_replace(',', '', $total_income)-(float) str_replace(',', '', $applicable_savings);
                    @endphp

                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">1.</td>
                        <td style="padding:5px;text-align: left;width:30%;">N.S.C</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$nsc_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">2.</td>
                        <td style="padding:5px;text-align: left;width:30%;">INTEREST ON N.S.C</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$nsc_int_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">3.</td>
                        <td style="padding:5px;text-align: left;width:30%;">L.I.C</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$lic_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">4.</td>
                        <td style="padding:5px;text-align: left;width:30%;">PROVIDENT FUND</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_pf??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">5.</td>
                        <td style="padding:5px;text-align: left;width:30%;">HOUSE RENT PAID</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$hrp_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">6.</td>
                        <td style="padding:5px;text-align: left;width:30%;">PUBLIC PROVIDENT FUND</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$ppf_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">7.</td>
                        <td style="padding:5px;text-align: left;width:30%;">TAX SAVING BOND</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tsb_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">8.</td>
                        <td style="padding:5px;text-align: left;width:30%;">UNIT LIKED INSURANCE PLAN</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$ulip_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">9.</td>
                        <td style="padding:5px;text-align: left;width:30%;">TUTION FEES</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tf_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">10.</td>
                        <td style="padding:5px;text-align: left;width:30%;">REPAYMENT OF HOUSE LOAN</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$rohl_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">11.</td>
                        <td style="padding:5px;text-align: left;width:30%;">U/S80CCC</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$us80c_amount??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">TOTAL SAVINGS</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;border-top: 1px dashed #000;border-bottom: 1px dashed #000;">{{number_format((float)$total_savings??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">LESS U/S 80C</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;border-bottom: 1px dashed #000;">{{number_format((float)$applicable_savings??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">TAXABLE INCOME</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$taxable_income??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">TAX PAID</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;width:20%;">{{number_format((float)$tot_incometax_deducted??'', 2, '.', '')}}</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;">&nbsp;</td>
                    </tr>
                    @php
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
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">TAX PAYABLE</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$taxpayable??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">ADD SURCHARGE</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$surcharge??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">ADD E.CESS</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$cess??'', 2, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;text-align: left;width:2%;">&nbsp;</td>
                        <td style="padding:5px;text-align: right;width:30%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:1%;">&nbsp;</td>
                        <td style="padding:5px;text-align: left;width:20%;">NET TAX PAYABLE</td>
                        <td style="padding:5px;text-align: left;width:1%;">:</td>
                        <td style="padding:5px;text-align: left;">{{number_format((float)$net_payable??'', 2, '.', '')}}</td>
                    </tr>
                </table>
            </td>

        </tr>



    </table>



</body>

</html>
