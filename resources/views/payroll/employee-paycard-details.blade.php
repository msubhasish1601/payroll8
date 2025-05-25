<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="bellevue-logo.png">
    <title>{{ config('app.name', 'Laravel') }} Paycard Statement</title>
    <style type="text/css">
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
                <th style="text-align:left;width:250px;"><img src="{{ asset('theme/images/payroll-logo.png') }}" alt="logo" width="83px"></th>
                <th style="text-transform: uppercase;text-align: center;">
                    @if(!empty($company_rs ))
                    <h1 style="margin-bottom: 0;">{{$company_rs->company_name}}</h1>
                    <h3 style="margin:0;">{{$company_rs->company_address}}</h3>
                    @endif
                    <h4 style="margin: 0;">PAY CARD STATEMENT FOR THE EMPLOYEE
                        {{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}<br>FROM {{date('F Y',strtotime($from_year.'-'.$from_month.'-01'))}} TO {{date('F Y',strtotime($to_year.'-'.$to_month.'-01'))}}
                    </h4>
                </th>
            </tr>
        </thead>
    </table>


    <table style="width:100%;margin:15px 0;border-bottom: 1px dashed #000;padding-bottom: 15px;">
        <thead>
            <tr style="font-weight: 700;">
                <td></td>
                <td>BASIC</td>
                <td>DA</td>
                <td>VDA</td>
                <td>HRA</td>
                <td>TIFF ALW</td>
                <td>CONV</td>
                <td>MEDICAL</td>
                <td>TOT INC</td>
                <td></td>
            </tr>
            <tr style="font-weight: 700;">
                <td style="text-align: left;">EMPLOYEE NAME</td>
                <td>OTH ALW</td>
                <td>MISC ALW</td>
                <td>OVER TIME</td>
                <td>BONUS</td>
                <td>LEAVE ENC</td>
                <td>HTA</td>
                <td>COMMISSION</td>
                <td></td>
                <td></td>
            </tr>

            <tr style="font-weight: 700;">
                <td style="text-align: left;">FATHER'S NAME</td>
                <td>PF</td>
                <td>APF</td>
                <td>PROF TAX</td>
                <td>I TAX</td>
                <td>INSU PREM</td>
                <td>PF LOAN</td>
                <td>ESI</td>
                <td>TOT DED</td>
                <td>NET PAY</td>
            </tr>

            <tr style="border-bottom: 1px dashed #000;font-weight: 700;">
                <td style="text-align: left;">EMPLOYEE CODE</td>
                <td>PF INT</td>
                <td>ADV</td>
                <td>HRD</td>
                <td>CO-OP</td>
                <td>FURNITURE</td>
                <td>MISC DED</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
$totalbasic_pay = 0;
$total_emp_others_alw = 0;
$total_emp_pf = 0;
$total_emp_pf_int = 0;
$total_emp_da = 0;
$total_emp_misc_alw = 0;
$total_emp_apf = 0;
$total_emp_adv = 0;

$total_emp_vda = 0;
$total_emp_over_time = 0;
$total_emp_prof_tax = 0;
$total_emp_hrd = 0;
$total_emp_hra = 0;
$total_emp_bouns = 0;
$total_emp_i_tax = 0;
$total_emp_co_op = 0;

$total_emp_commission = 0;

$total_emp_tiff_alw = 0;
$total_emp_leave_inc = 0;
$total_emp_insu_prem = 0;
$total_emp_furniture = 0;
$total_emp_conv = 0;
$total_emp_hta = 0;
$total_emp_pf_loan = 0;
$total_emp_misc_ded = 0;
$total_emp_total_deduction = 0;
$total_emp_net_salary = 0;
$total_emp_gross_salary = 0;
?>
            @php
                $start_date=date('Y-m-d',strtotime($from_year.'-'.$from_month.'-01'));
                $end_date=date('Y-m-d',strtotime($to_year.'-'.$to_month.'-01'));

                $m=$start_date;

                while(date('Ym',strtotime($m))<=date('Ym',strtotime($end_date)))
                {
                    $records=\Helpers::getPaycardDetails($empInfo->emp_code,date('m/Y',strtotime($m)));
                    $records=json_decode($records);
                    if($records->payroll!=null || $records->dimmies!=null){
                        if(date('m/Y',strtotime($m))=='04/2022'){
                            //dd($records->bonus_rs->bonus);
                        }
                       //dd($records->bonus_rs);

            @endphp

            @if($records->payroll!=null)
                <tr>
                    <td colspan="10">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">

                        {{date('F, Y',strtotime($m))}}

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="width: 240px;text-align: left;">
                        {{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}
                    </td>
                    <td>{{ number_format((float)$records->payroll->emp_basic_pay??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_da??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_vda??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_hra??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_tiff_alw??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_conv??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_medical??'', 2, '.', '') }}</td>
                    <td>
                        @php
                            $effective_gross=$records->payroll->emp_gross_salary;
                            if(isset($records->bonus_rs->bonus)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)-(float) str_replace(',', '', $records->payroll->emp_bouns)+(float) str_replace(',', '', $records->bonus_rs->bonus);
                            }
                            if(isset($records->encashment_rs->leave_enc)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)-(float) str_replace(',', '', $records->payroll->emp_leave_inc)+(float) str_replace(',', '', $records->encashment_rs->leave_enc);
                            }
                            if(isset($records->encashment_rs->hta)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)-(float) str_replace(',', '', $records->payroll->emp_hta)+(float) str_replace(',', '', $records->encashment_rs->hta);
                            }
                            if(isset($records->encashment_rs->commision)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)+(float) str_replace(',', '', $records->encashment_rs->commision);
                            }
                        @endphp
                        {{ number_format((float)$effective_gross??'', 2, '.', '') }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 240px;text-align: left;">{{$empInfo->emp_father_name??''}}</td>
                    <td>{{ number_format((float)$records->payroll->emp_others_alw??'', 2, '.', '') }}</td>
                    <td> {{ number_format((float)$records->payroll->emp_misc_alw??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_over_time??'', 2, '.', '') }}</td>
                    <td>
                        @if(isset($records->bonus_rs->bonus))
                        {{ number_format((float)$records->bonus_rs->bonus??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td>
                        @if(isset($records->encashment_rs->leave_enc))
                        {{ number_format((float)$records->encashment_rs->leave_enc??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td>
                        @if(isset($records->encashment_rs->hta))
                        {{ number_format((float)$records->encashment_rs->hta??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td>
                        @if(isset($records->encashment_rs->commision))
                        {{ number_format((float)$records->encashment_rs->commision??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="width: 240px;text-align: left;">{{$empInfo->old_emp_code??''}}</td>
                    <td>{{ number_format((float)$records->payroll->emp_pf??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_apf??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_prof_tax??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_i_tax??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_insu_prem??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_pf_loan??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$records->payroll->emp_esi??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_total_deduction??'', 2, '.', '') }}</td>
                    <td>
                        @php
                        $effective_net=$records->payroll->emp_net_salary;
                        if(isset($records->bonus_rs->bonus)){
                            $effective_net=(float) str_replace(',', '', $effective_net)-(float) str_replace(',', '', $records->payroll->emp_bouns)+(float) str_replace(',', '', $records->bonus_rs->bonus);
                        }
                        if(isset($records->encashment_rs->leave_enc)){
                            $effective_net=(float) str_replace(',', '', $effective_net)-(float) str_replace(',', '', $records->payroll->emp_leave_inc)+(float) str_replace(',', '', $records->encashment_rs->leave_enc);
                        }
                        if(isset($records->encashment_rs->hta)){
                            $effective_net=(float) str_replace(',', '', $effective_net)-(float) str_replace(',', '', $records->payroll->emp_hta)+(float) str_replace(',', '', $records->encashment_rs->hta);
                        }
                        if(isset($records->encashment_rs->commision)){
                            $effective_net=(float) str_replace(',', '', $effective_net)+(float) str_replace(',', '', $records->encashment_rs->commision);
                        }

                        @endphp
                        {{ number_format((float)$effective_net??'', 2, '.', '') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px;text-align: left;"></td>
                    <td>{{ number_format((float)$records->payroll->emp_pf_int??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_adv??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_hrd??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_co_op??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_furniture??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->payroll->emp_misc_ded??'', 2, '.', '') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <?php $totalbasic_pay += (float) str_replace(',', '', $records->payroll->emp_basic_pay);?>
                <?php $total_emp_others_alw += (float) str_replace(',', '', $records->payroll->emp_others_alw);?>
                <?php $total_emp_pf += (float) str_replace(',', '', $records->payroll->emp_pf);?>
                <?php $total_emp_pf_int += (float) str_replace(',', '', $records->payroll->emp_pf_int);?>
                <?php $total_emp_da += (float) str_replace(',', '', $records->payroll->emp_da);?>
                <?php $total_emp_misc_alw += (float) str_replace(',', '', $records->payroll->emp_misc_alw);?>
                <?php $total_emp_apf += (float) str_replace(',', '', $records->payroll->emp_apf);?>
                <?php $total_emp_adv += (float) str_replace(',', '', $records->payroll->emp_adv);?>

                <?php $total_emp_vda += (float) str_replace(',', '', $records->payroll->emp_vda);?>
                <?php $total_emp_over_time += (float) str_replace(',', '', $records->payroll->emp_over_time);?>
                <?php $total_emp_prof_tax += (float) str_replace(',', '', $records->payroll->emp_prof_tax);?>
                <?php $total_emp_hrd += (float) str_replace(',', '', $records->payroll->emp_hrd);?>
                <?php $total_emp_hra += (float) str_replace(',', '', $records->payroll->emp_hra);?>
                <?php
if (isset($records->bonus_rs->bonus)) {
    $total_emp_bouns += (float) str_replace(',', '', $records->bonus_rs->bonus);
}
if (isset($records->encashment_rs->commision)) {
    $total_emp_commission += (float) str_replace(',', '', $records->encashment_rs->commision);
}
?>
                <?php $total_emp_i_tax += (float) str_replace(',', '', $records->payroll->emp_i_tax);?>
                <?php $total_emp_co_op += (float) str_replace(',', '', $records->payroll->emp_co_op);?>
                <?php $total_emp_tiff_alw += (float) str_replace(',', '', $records->payroll->emp_tiff_alw);?>
                <?php
if (isset($records->encashment_rs->leave_enc)) {
    $total_emp_leave_inc += (float) str_replace(',', '', $records->encashment_rs->leave_enc);
}

?>
                <?php $total_emp_insu_prem += (float) str_replace(',', '', $records->payroll->emp_insu_prem);?>
                <?php $total_emp_furniture += (float) str_replace(',', '', $records->payroll->emp_furniture);?>

                <?php $total_emp_conv += (float) str_replace(',', '', $records->payroll->emp_conv);?>
                <?php
if (isset($records->encashment_rs->hta)) {
    $total_emp_hta += (float) str_replace(',', '', $records->encashment_rs->hta);
}

?>
                <?php $total_emp_pf_loan += (float) str_replace(',', '', $records->payroll->emp_pf_loan);?>
                <?php $total_emp_misc_ded += (float) str_replace(',', '', $records->payroll->emp_misc_ded);?>
                <?php $total_emp_total_deduction += (float) str_replace(',', '', $records->payroll->emp_total_deduction);?>
                <?php
$effective_net = $records->payroll->emp_net_salary;
if (isset($records->bonus_rs->bonus)) {
    $effective_net = (float) str_replace(',', '', $effective_net) - (float) str_replace(',', '', $records->payroll->emp_bouns) + (float) str_replace(',', '', $records->bonus_rs->bonus);
}
if (isset($records->encashment_rs->leave_enc)) {
    $effective_net = (float) str_replace(',', '', $effective_net) - (float) str_replace(',', '', $records->payroll->emp_leave_inc) + (float) str_replace(',', '', $records->encashment_rs->leave_enc);
}
if (isset($records->encashment_rs->hta)) {
    $effective_net = (float) str_replace(',', '', $effective_net) - (float) str_replace(',', '', $records->payroll->emp_hta) + (float) str_replace(',', '', $records->encashment_rs->hta);
}
$total_emp_net_salary += (float) str_replace(',', '', $effective_net);
$total_emp_net_salary += $total_emp_commission;
?>
                <?php
$effective_gross = $records->payroll->emp_gross_salary;
if (isset($records->bonus_rs->bonus)) {
    $effective_gross = (float) str_replace(',', '', $effective_gross) - (float) str_replace(',', '', $records->payroll->emp_bouns) + (float) str_replace(',', '', $records->bonus_rs->bonus);
}
if (isset($records->encashment_rs->leave_enc)) {
    $effective_gross = (float) str_replace(',', '', $effective_gross) - (float) str_replace(',', '', $records->payroll->emp_leave_inc) + (float) str_replace(',', '', $records->encashment_rs->leave_enc);
}
if (isset($records->encashment_rs->hta)) {
    $effective_gross = (float) str_replace(',', '', $effective_gross) - (float) str_replace(',', '', $records->payroll->emp_hta) + (float) str_replace(',', '', $records->encashment_rs->hta);
}

$total_emp_gross_salary += (float) str_replace(',', '', $effective_gross);
$total_emp_gross_salary += $total_emp_commission;
?>


            @else
            <tr>
                    <td colspan="10">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">

                        {{date('F, Y',strtotime($m))}}

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="width: 240px;text-align: left;">
                        {{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}
                    </td>
                    <td>{{ number_format((float)$records->dimmies->emp_basic_pay??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_da??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_vda??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_hra??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_tiff_alw??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_conv??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_medical??'', 2, '.', '') }}</td>
                    <td>
                        @php
                            $effective_gross=$records->dimmies->emp_gross_salary;
                            if(isset($records->bonus_rs->bonus)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)-(float) str_replace(',', '', $records->dimmies->emp_bouns)+(float) str_replace(',', '', $records->bonus_rs->bonus);
                            }
                            if(isset($records->encashment_rs->leave_enc)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)-(float) str_replace(',', '', $records->dimmies->emp_leave_inc)+(float) str_replace(',', '', $records->encashment_rs->leave_enc);
                            }
                            if(isset($records->encashment_rs->hta)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)-(float) str_replace(',', '', $records->dimmies->emp_hta)+(float) str_replace(',', '', $records->encashment_rs->hta);
                            }
                            if(isset($records->encashment_rs->commision)){
                                $effective_gross=(float) str_replace(',', '', $effective_gross)+(float) str_replace(',', '', $records->encashment_rs->commision);
                            }
                        @endphp
                        {{ number_format((float)$effective_gross??'', 2, '.', '') }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 240px;text-align: left;">{{$empInfo->emp_father_name??''}}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_others_alw??'', 2, '.', '') }}</td>
                    <td> {{ number_format((float)$records->dimmies->emp_misc_alw??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_over_time??'', 2, '.', '') }}</td>
                    <td>
                        @if(isset($records->bonus_rs->bonus))
                        {{ number_format((float)$records->bonus_rs->bonus??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td>
                        @if(isset($records->encashment_rs->leave_enc))
                        {{ number_format((float)$records->encashment_rs->leave_enc??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td>
                        @if(isset($records->encashment_rs->hta))
                        {{ number_format((float)$records->encashment_rs->hta??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td>
                        @if(isset($records->encashment_rs->commision))
                        {{ number_format((float)$records->encashment_rs->commision??'', 2, '.', '') }}
                        @else
                        0.00
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="width: 240px;text-align: left;">{{$empInfo->old_emp_code??''}}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_pf??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_apf??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_prof_tax??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_i_tax??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_insu_prem??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_pf_loan??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$records->dimmies->emp_esi??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_total_deduction??'', 2, '.', '') }}</td>
                    <td>
                        @php
                        $effective_net=$records->dimmies->emp_net_salary;
                        if(isset($records->bonus_rs->bonus)){
                            $effective_net=(float) str_replace(',', '', $effective_net)-(float) str_replace(',', '', $records->dimmies->emp_bouns)+(float) str_replace(',', '', $records->bonus_rs->bonus);
                        }
                        if(isset($records->encashment_rs->leave_enc)){
                            $effective_net=(float) str_replace(',', '', $effective_net)-(float) str_replace(',', '', $records->dimmies->emp_leave_inc)+(float) str_replace(',', '', $records->encashment_rs->leave_enc);
                        }
                        if(isset($records->encashment_rs->hta)){
                            $effective_net=(float) str_replace(',', '', $effective_net)-(float) str_replace(',', '', $records->dimmies->emp_hta)+(float) str_replace(',', '', $records->encashment_rs->hta);
                        }
                        if(isset($records->encashment_rs->commision)){
                            $effective_net=(float) str_replace(',', '', $effective_net)+(float) str_replace(',', '', $records->encashment_rs->commision);
                        }

                        @endphp
                        {{ number_format((float)$effective_net??'', 2, '.', '') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 240px;text-align: left;"></td>
                    <td>{{ number_format((float)$records->dimmies->emp_pf_int??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_adv??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_hrd??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_co_op??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_furniture??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$records->dimmies->emp_misc_ded??'', 2, '.', '') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <?php $totalbasic_pay += (float) str_replace(',', '', $records->dimmies->emp_basic_pay);?>
                <?php $total_emp_others_alw += (float) str_replace(',', '', $records->dimmies->emp_others_alw);?>
                <?php $total_emp_pf += (float) str_replace(',', '', $records->dimmies->emp_pf);?>
                <?php $total_emp_pf_int += (float) str_replace(',', '', $records->dimmies->emp_pf_int);?>
                <?php $total_emp_da += (float) str_replace(',', '', $records->dimmies->emp_da);?>
                <?php $total_emp_misc_alw += (float) str_replace(',', '', $records->dimmies->emp_misc_alw);?>
                <?php $total_emp_apf += (float) str_replace(',', '', $records->dimmies->emp_apf);?>
                <?php $total_emp_adv += (float) str_replace(',', '', $records->dimmies->emp_adv);?>

                <?php $total_emp_vda += (float) str_replace(',', '', $records->dimmies->emp_vda);?>
                <?php $total_emp_over_time += (float) str_replace(',', '', $records->dimmies->emp_over_time);?>
                <?php $total_emp_prof_tax += (float) str_replace(',', '', $records->dimmies->emp_prof_tax);?>
                <?php $total_emp_hrd += (float) str_replace(',', '', $records->dimmies->emp_hrd);?>
                <?php $total_emp_hra += (float) str_replace(',', '', $records->dimmies->emp_hra);?>
                <?php
if (isset($records->bonus_rs->bonus)) {
    $total_emp_bouns += (float) str_replace(',', '', $records->bonus_rs->bonus);
}
if (isset($records->encashment_rs->commision)) {
    $total_emp_commission += (float) str_replace(',', '', $records->encashment_rs->commision);
}
?>
                <?php $total_emp_i_tax += (float) str_replace(',', '', $records->dimmies->emp_i_tax);?>
                <?php $total_emp_co_op += (float) str_replace(',', '', $records->dimmies->emp_co_op);?>
                <?php $total_emp_tiff_alw += (float) str_replace(',', '', $records->dimmies->emp_tiff_alw);?>
                <?php
if (isset($records->encashment_rs->leave_enc)) {
    $total_emp_leave_inc += (float) str_replace(',', '', $records->encashment_rs->leave_enc);
}

?>
                <?php $total_emp_insu_prem += (float) str_replace(',', '', $records->dimmies->emp_insu_prem);?>
                <?php $total_emp_furniture += (float) str_replace(',', '', $records->dimmies->emp_furniture);?>

                <?php $total_emp_conv += (float) str_replace(',', '', $records->dimmies->emp_conv);?>
                <?php
if (isset($records->encashment_rs->hta)) {
    $total_emp_hta += (float) str_replace(',', '', $records->encashment_rs->hta);
}

?>
                <?php $total_emp_pf_loan += (float) str_replace(',', '', $records->dimmies->emp_pf_loan);?>
                <?php $total_emp_misc_ded += (float) str_replace(',', '', $records->dimmies->emp_misc_ded);?>
                <?php $total_emp_total_deduction += (float) str_replace(',', '', $records->dimmies->emp_total_deduction);?>
                <?php
$effective_net = $records->dimmies->emp_net_salary;
if (isset($records->bonus_rs->bonus)) {
    $effective_net = (float) str_replace(',', '', $effective_net) - (float) str_replace(',', '', $records->dimmies->emp_bouns) + (float) str_replace(',', '', $records->bonus_rs->bonus);
}
if (isset($records->encashment_rs->leave_enc)) {
    $effective_net = (float) str_replace(',', '', $effective_net) - (float) str_replace(',', '', $records->dimmies->emp_leave_inc) + (float) str_replace(',', '', $records->encashment_rs->leave_enc);
}
if (isset($records->encashment_rs->hta)) {
    $effective_net = (float) str_replace(',', '', $effective_net) - (float) str_replace(',', '', $records->dimmies->emp_hta) + (float) str_replace(',', '', $records->encashment_rs->hta);
}
$total_emp_net_salary += (float) str_replace(',', '', $effective_net);
$total_emp_net_salary += $total_emp_commission;
?>
                <?php
$effective_gross = $records->dimmies->emp_gross_salary;
if (isset($records->bonus_rs->bonus)) {
    $effective_gross = (float) str_replace(',', '', $effective_gross) - (float) str_replace(',', '', $records->dimmies->emp_bouns) + (float) str_replace(',', '', $records->bonus_rs->bonus);
}
if (isset($records->encashment_rs->leave_enc)) {
    $effective_gross = (float) str_replace(',', '', $effective_gross) - (float) str_replace(',', '', $records->dimmies->emp_leave_inc) + (float) str_replace(',', '', $records->encashment_rs->leave_enc);
}
if (isset($records->encashment_rs->hta)) {
    $effective_gross = (float) str_replace(',', '', $effective_gross) - (float) str_replace(',', '', $records->dimmies->emp_hta) + (float) str_replace(',', '', $records->encashment_rs->hta);
}

$total_emp_gross_salary += (float) str_replace(',', '', $effective_gross);
$total_emp_gross_salary += $total_emp_commission;
?>
            @endif
            @php
                    }
                    $m = date('Y-m-d', strtotime("+1 months", strtotime($m)));
                }
            @endphp



                <tr>
                    <td colspan="10">
                        <hr>
                    </td>
                </tr>

                <tr style="font-weight: 600;">
                    <td rowspan="4" style="text-align:left;">GRAND TOTAL </td>
                    <td>{{ number_format((float)$totalbasic_pay??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_da??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_vda??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_hra??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_tiff_alw??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$total_emp_conv??'', 2, '.', '') }} </td>
                    <td>0.00</td>
                    <td>{{ number_format((float)$total_emp_gross_salary??'', 2, '.', '') }} </td>
                    <td></td>
                </tr>

                <tr style="font-weight: 600;">
                    <td>{{ number_format((float)$total_emp_others_alw??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_misc_alw??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_over_time??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_bouns??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_leave_inc??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_hta??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_commission??'', 2, '.', '') }} </td>

                    <td></td>
                    <td></td>
                </tr>

                <tr style="font-weight: 600;">
                    <td>{{ number_format((float)$total_emp_pf??'', 2, '.', '') }}</td>
                    <td>{{ number_format((float)$total_emp_apf??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_prof_tax??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_i_tax??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_insu_prem??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_pf_loan??'', 2, '.', '') }} </td>
                    <td>0.00</td>
                    <td>{{ number_format((float)$total_emp_total_deduction??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_net_salary??'', 2, '.', '') }}</td>
                </tr>

                <tr style="font-weight: 600;">
                    <td>{{ number_format((float)$total_emp_pf_int??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_adv??'', 2, '.', '') }}  </td>
                    <td>{{ number_format((float)$total_emp_hrd??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_co_op??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_furniture??'', 2, '.', '') }} </td>
                    <td>{{ number_format((float)$total_emp_misc_ded??'', 2, '.', '') }} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

        </tbody>
    </table>



</body>

</html>