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
                <th style="text-align:left;"><img src="{{ asset('img/bellevue-logo.png') }}" alt="logo"></th>
                <th style="text-transform: uppercase;text-align: center;">
                    <h1 style="margin-bottom: 0;">{{ config('app.name', 'Laravel') }}</h1>
                    <h3 style="margin:0;">9, Dr. U.N. Brahmachari Street, Kolkata - 700017</h3>
                    <h4 style="margin: 0;">PAY CARD STATEMENT FOR THE EMPLOYEE MR NILADRI SEKHAR DAS</h4>
                </th>
            </tr>
        </thead>
    </table>

    <table style="width:100%;margin:15px 0;border-bottom: 1px dashed #000;padding-bottom: 15px;">
        <tbody>
            <tr>
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
            <tr>
                <td style="text-align: left;">EMPLOYEE NAME</td>
                <td>OTH ALW</td>
                <td>MISC ALW</td>
                <td>OVER TIME</td>
                <td>BONUS</td>
                <td>LEAVE ENC</td>
                <td>HTA</td>
                <td>COMISSIONM</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
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

            <tr style="border-bottom: 1px dashed #000;">
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
            @if (count($Payroll_details_rs) > 0)
            @foreach ($Payroll_details_rs as $val)
            <tr>
                <td colspan="10">
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    {{ explode('-',$month_yr_new)[0] }}
                     {{-- APRIL ,2022 --}}
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
                <td style="width: 240px;text-align: left;">{{ $val->emp_name??'' }}</td>
                <td>{{ number_format((float)$val->emp_basic_pay??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_da??'', 2, '.', '') }}</td>
                <td> {{ number_format((float)$val->emp_vda??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_hra??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_tiff_alw??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_conv??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_medical??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_gross_salary??'', 2, '.', '') }}</td>
                <td></td>
            </tr>



            <tr>
                <td style="width: 240px;text-align: left;">LATE NIRMAL KUMAR DAS</td>
                <td>{{ number_format((float)$val->emp_others_alw??'', 2, '.', '') }}</td>
                <td> {{ number_format((float)$val->emp_misc_alw??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_over_time??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_bouns??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_leave_inc??'', 2, '.', '') }}</td>
                <td> {{ number_format((float)$val->emp_hta??'', 2, '.', '') }}</td>
                <td>0.00 </td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td style="width: 240px;text-align: left;">{{ $val->old_emp_code??'' }}</td>
                <td>{{ number_format((float)$val->emp_pf??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_apf??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_prof_tax??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_i_tax??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_insu_prem??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_pf_loan??'', 2, '.', '') }} </td>
                <td>{{ number_format((float)$val->emp_esi??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_total_deduction??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_net_salary??'', 2, '.', '') }}</td>
            </tr>

            <tr>
                <td style="width: 240px;text-align: left;"></td>
                <td>{{ number_format((float)$val->emp_pf_int??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_adv??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_hrd??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_co_op??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_furniture??'', 2, '.', '') }}</td>
                <td>{{ number_format((float)$val->emp_misc_ded??'', 2, '.', '') }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="10">
                    <hr>
                </td>
            </tr>

            <?php $totalbasic_pay += (float) str_replace(',', '', $val->emp_basic_pay);?>
            <?php $total_emp_others_alw += (float) str_replace(',', '', $val->emp_others_alw);?>
            <?php $total_emp_pf += (float) str_replace(',', '', $val->emp_pf);?>
            <?php $total_emp_pf_int += (float) str_replace(',', '', $val->emp_pf_int);?>
            <?php $total_emp_da += (float) str_replace(',', '', $val->emp_da);?>
            <?php $total_emp_misc_alw += (float) str_replace(',', '', $val->emp_misc_alw);?>
            <?php $total_emp_apf += (float) str_replace(',', '', $val->emp_apf);?>
            <?php $total_emp_adv += (float) str_replace(',', '', $val->emp_adv);?>

            <?php $total_emp_vda += (float) str_replace(',', '', $val->emp_vda);?>
            <?php $total_emp_over_time += (float) str_replace(',', '', $val->emp_over_time);?>
            <?php $total_emp_prof_tax += (float) str_replace(',', '', $val->emp_prof_tax);?>
            <?php $total_emp_hrd += (float) str_replace(',', '', $val->emp_hrd);?>
            <?php $total_emp_hra += (float) str_replace(',', '', $val->emp_hra);?>
            <?php $total_emp_bouns += (float) str_replace(',', '', $val->emp_bouns);?>
            <?php $total_emp_i_tax += (float) str_replace(',', '', $val->emp_i_tax);?>
            <?php $total_emp_co_op += (float) str_replace(',', '', $val->emp_co_op);?>
            <?php $total_emp_tiff_alw += (float) str_replace(',', '', $val->emp_tiff_alw);?>
            <?php $total_emp_leave_inc += (float) str_replace(',', '', $val->emp_leave_inc);?>
            <?php $total_emp_insu_prem += (float) str_replace(',', '', $val->emp_insu_prem);?>
            <?php $total_emp_furniture += (float) str_replace(',', '', $val->emp_furniture);?>

            <?php $total_emp_conv += (float) str_replace(',', '', $val->emp_conv);?>
            <?php $total_emp_hta += (float) str_replace(',', '', $val->emp_hta);?>
            <?php $total_emp_pf_loan += (float) str_replace(',', '', $val->emp_pf_loan);?>
            <?php $total_emp_misc_ded += (float) str_replace(',', '', $val->emp_misc_ded);?>
            <?php $total_emp_total_deduction += (float) str_replace(',', '', $val->emp_total_deduction);?>
            <?php $total_emp_net_salary += (float) str_replace(',', '', $val->emp_net_salary);?>
            <?php $total_emp_gross_salary += (float) str_replace(',', '', $val->emp_gross_salary);?>



            @endforeach
            @endif

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
                <td>0.00 </td>
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
