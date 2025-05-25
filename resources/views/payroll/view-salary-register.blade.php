<?php
//$month=$monthly_salary_rs[0]->month_yr;
//$montharr = explode('/',$month);
//$m = $montharr[0];
//$y = $montharr[1];
//$m = ltrim($m, '0');
$dt = $month;
$dtar = explode('/', $dt);
$monthName = strftime('%B', mktime(0, 0, 0, $dtar[0]));
$YearName = $dtar[1];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo-small.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin-top: 0;
            margin-bottom: 0;
            /* this affects the margin in the printer settings */
        }
    </style>
    <style>
        body {
            -webkit-print-color-adjust: exact;
        }

        .payslip {
            font-family: cambria;
        }

        .payslip .pay-head h2 {
            font-size: 35px;
            color: #292929;
            text-align: center;
            margin: 0;
        }

        .payslip .pay-head h4 {
            font-size: 19px;
            text-align: center;
            margin: 0;
        }

        .payslip .pay-month {
            text-align: center;
        }

        .payslip .pay-month h3 {
            margin: 0;
            color: #0099be;
        }

        .pay-logo img {
            max-width: 80px;
        }

        .emp-det {
            width: 100%;
        }

        .emp-det thead tr th {
            text-align: center;
        }

        .emp-det thead tr th {
            border-bottom: none;
        }

        .emp-det thead tr th {
            border-bottom: none;
            background: #0099be;
            color: #fff;
            padding: 5px;
            font-size: 18px;
        }

        .emp-det tbody tr td {
            padding: 10px;
        }

        table.emp-det tr td span {
            font-weight: 600;
        }

        .sal-det tr th {
            background: #a7a8a9;
            padding: 5px;
            border-bottom: none;
            color: #000;
            text-align: center;
            font-size: 12px;
        }

        .sal-det tr.part td {
            padding: 5px;
            text-align: left;
            font-weight: 600;
            background: #a7a8a9;
            color: #000;
            text-align: center;
            font-size: 12px;
        }

        .sal-det tr td {
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        .sal-det tr td p {
            text-align: right;
            margin: 0;
        }

        .mon {
            text-align: center;
        }

        .mon h3 {
            color: #0099be;
            margin: 0;
            font-size: 25px;
        }

        .mon h4 {
            margin: 0;
            font-size: 24px;
        }

        .sal-det tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .emp-det {
            margin-bottom: 15px;
        }

        .total td {
            font-weight: 600;
        }

        .leave {
            border-top: none;
        }

        .leave tr th {
            padding: 7px 10px;
            text-align: left;
        }

        @media print {
            @page {
                size: landscape
            }
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
                        <img src="{{ asset('theme/images/payroll-logo.png') }}" alt="logo">
                    </div>
                </td>
                <td>
                    <div class="text-center pay-head">
                    </div>
                    <div class="mon">
                        @if(!empty($company_rs ))
                        <h1 style="margin-bottom: 0;">{{$company_rs->company_name}}</h1>
                        <h2 style="margin:0;">{{$company_rs->company_address}}</h3>
                        @endif
                        <h4>Employee Salary Register for the month of <?php echo $monthName . ' - ' . $YearName; ?></h4>
                    </div>
                </td>
            </tr>
        </table>
        <!--------------------------->
        <?php $totalbasic_pay = 0;?>
        <?php $totalda = 0;?>
        <?php $totalvda = 0;?>
        <?php $totalhra = 0;?>
        <?php $totalothers_alw = 0;?>
        <?php $totaltiff_alw = 0;?>
        <?php $totalconv = 0;?>
        <?php $totalmedical = 0;?>
        <?php $totalmisc_alw = 0;?>
        <?php $totalover_time = 0;?>
        <?php $totalbouns = 0;?>
        <?php $totalleave_inc = 0;?>
        <?php $totalhta = 0;?>

        <?php $totalother_addition = 0;?>
        <?php $totalgross_salary = 0;?>
        <?php $totalprof_tax = 0;?>
        <?php $totalpf = 0;?>
        <?php $totalpf_int = 0;?>
        <?php $totalapf = 0;?>
        <?php $totali_tax = 0;?>
        <?php $totalinsu_prem = 0;?>
        <?php $totalpf_loan = 0;?>
        <?php $totalesi = 0;?>
        <?php $totaladv = 0;?>
        <?php $totalhrd = 0;?>
        <?php $totalco_op = 0;?>
        <?php $totalfurniture = 0;?>
        <?php $totalpf_employer = 0;?>
        <?php $totalmisc_ded = 0;?>
        <?php $totalincome_tax = 0;?>
        <?php $totalothers_deduction = 0;?>
        <?php $totaltotal_deduction = 0;?>
        <?php $totalnet_salary = 0;?>


        <!------------Salary-details----------------->
        <table border="1" class="sal-det" style="width:100%;border-collapse:collapse;border-color:#cacaca;">
            <thead style="margin-top: 10px;">
                <tr>
                    <th rowspan="2">SL.NO.</th>
                    <th rowspan="2">EMPLOYEE ID</th>
                    <th rowspan="2">EMPLOYEE Code</th>
                    <th rowspan="2">EMPLOYEE Name</th>
                    <th rowspan="2">DESIGNATION</th>

                    <th colspan="15">EARNINGS(Amount in <i class="fas fa-rupee-sign"></i>)</th>
                    <th colspan="16">DEDUCTIONS (Amount in <i class="fas fa-rupee-sign"></i>)</th>
                    <th rowspan="2">NET SALARY (<i class="fas fa-rupee-sign"></i>)</th>
                </tr>
                <tr class="part">


                    <td>BASIC PAY </td>
                    @if (count($rate_master) != 0)
                        @foreach ($rate_master as $rate)
                            @if ($rate->id < 27)
                                @if ($rate->head_type == 'earning')
                                    <td>{{ $rate->head_name }}</td>
                                @endif
                            @endif
                        @endforeach
                    @endif
                    <td>OTHERS</td>
                    <td>TOTAL EARNINGS</td>
                    @if (count($rate_master) != 0)
                        @foreach ($rate_master as $rate)
                            @if ($rate->id < 27)
                                @if ($rate->head_type == 'deduction')
                                    <td>{{ $rate->head_name }}</td>
                                @endif
                            @endif
                            @if ($rate->id == 29)
                                @if ($rate->head_type == 'deduction')
                                    <td>{{ $rate->head_name }}</td>
                                @endif
                            @endif
                        @endforeach
                    @endif


                    <!-- <td>Inc. Tax.</td> -->
                    <td>Others</td>
                    <td>TOTAL DEDUCTIONS</td>
                </tr>

            </thead>
            <tbody>
                @foreach ($monthly_salary_rs as $ms)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ms->employee_id }}</td>
                        <td>{{ $ms->old_emp_code }}</td>
                        <td>{{ $ms->emp_name }}</td>
                        <td>{{ $ms->emp_designation }}</td>

                        <td>{{ $ms->emp_basic_pay }}</td>
                        <td>{{ $ms->emp_da }}</td>
                        <td>{{ $ms->emp_vda }}</td>
                        <td>{{ $ms->emp_hra }}</td>
                        <td>{{ $ms->emp_others_alw }}</td>
                        <td>{{ $ms->emp_tiff_alw }}</td>
                        <td>{{ $ms->emp_conv }}</td>
                        <td>{{ $ms->emp_medical }}</td>
                        <td>{{ $ms->emp_misc_alw }}</td>
                        <td>{{ $ms->emp_over_time }}</td>
                        <td>{{ $ms->emp_bouns }}</td>
                        <td>{{ $ms->emp_leave_inc }}</td>
                        <td>{{ $ms->emp_hta }}</td>

                        <td>{{ $ms->other_addition }}</td>
                        <td>{{ $ms->emp_gross_salary }}</td>
                        <td>{{ $ms->emp_prof_tax }}</td>
                        <td>{{ $ms->emp_pf }}</td>
                        <td>{{ $ms->emp_pf_int }}</td>
                        <td>{{ $ms->emp_apf }}</td>
                        <td>{{ $ms->emp_i_tax }}</td>
                        <td>{{ $ms->emp_insu_prem }}</td>
                        <td>{{ $ms->emp_pf_loan }}</td>
                        <td>{{ $ms->emp_esi }}</td>
                        <td>{{ $ms->emp_adv }}</td>
                        <td>{{ $ms->emp_hrd }}</td>
                        <td>{{ $ms->emp_co_op }}</td>
                        <td>{{ $ms->emp_furniture }}</td>
                        <td>{{ $ms->emp_misc_ded }}</td>
                        <td>{{ $ms->emp_pf_employer }}</td>
                        <!-- <td>{{ $ms->emp_income_tax }}</td> -->
                        <td>{{ $ms->emp_others_deduction }}</td>
                        <td>{{ $ms->emp_total_deduction }}</td>
                        <td>{{ $ms->emp_net_salary }}</td>

                    </tr>
                    <?php $totalbasic_pay += (float) str_replace(',', '', $ms->emp_basic_pay);?>
                    <?php $totalda += (float) str_replace(',', '', $ms->emp_da);?>
                    <?php $totalvda += (float) str_replace(',', '', $ms->emp_vda);?>
                    <?php $totalhra += (float) str_replace(',', '', $ms->emp_hra);?>
                    <?php $totalothers_alw += (float) str_replace(',', '', $ms->emp_others_alw);?>
                    <?php $totaltiff_alw += (float) str_replace(',', '', $ms->emp_tiff_alw);?>
                    <?php $totalconv += (float) str_replace(',', '', $ms->emp_conv);?>
                    <?php $totalmedical += (float) str_replace(',', '', $ms->emp_medical);?>
                    <?php $totalmisc_alw += (float) str_replace(',', '', $ms->emp_misc_alw);?>
                    <?php $totalover_time += (float) str_replace(',', '', $ms->emp_over_time);?>
                    <?php $totalbouns += (float) str_replace(',', '', $ms->emp_bouns);?>
                    <?php $totalleave_inc += (float) str_replace(',', '', $ms->emp_leave_inc);?>
                    <?php $totalhta += (float) str_replace(',', '', $ms->emp_hta);?>

                    <?php $totalother_addition += (float) str_replace(',', '', $ms->other_addition);?>
                    <?php $totalgross_salary += (float) str_replace(',', '', $ms->emp_gross_salary);?>
                    <?php $totalprof_tax += (float) str_replace(',', '', $ms->emp_prof_tax);?>
                    <?php $totalpf += (float) str_replace(',', '', $ms->emp_pf);?>
                    <?php $totalpf_int += (float) str_replace(',', '', $ms->emp_pf_int);?>
                    <?php $totalapf += (float) str_replace(',', '', $ms->emp_apf);?>
                    <?php $totali_tax += (float) str_replace(',', '', $ms->emp_i_tax);?>
                    <?php $totalinsu_prem += (float) str_replace(',', '', $ms->emp_insu_prem);?>
                    <?php $totalpf_loan = $totalpf_loan + (float) str_replace(',', '', $ms->emp_pf_loan);?>
                    <?php $totalesi += (float) str_replace(',', '', $ms->emp_esi);?>
                    <?php $totaladv += (float) str_replace(',', '', $ms->emp_adv);?>
                    <?php $totalhrd += (float) str_replace(',', '', $ms->emp_hrd);?>
                    <?php $totalco_op += (float) str_replace(',', '', $ms->emp_co_op);?>
                    <?php $totalfurniture += (float) str_replace(',', '', $ms->emp_furniture);?>
                    <?php $totalpf_employer += (float) str_replace(',', '', $ms->emp_pf_employer);?>
                    <?php $totalmisc_ded += (float) str_replace(',', '', $ms->emp_misc_ded);?>
                    <?php $totalincome_tax += (float) str_replace(',', '', $ms->emp_income_tax);?>
                    <?php $totalothers_deduction += (float) str_replace(',', '', $ms->emp_others_deduction);?>
                    <?php $totaltotal_deduction += (float) str_replace(',', '', $ms->emp_total_deduction);?>
                    <?php $totalnet_salary += (float) str_replace(',', '', $ms->emp_net_salary);?>
                @endforeach

                <tr>
                    <th colspan="5" style="text-align: left;">Total (In RUPEES)</th>
                    <th><?php echo $totalbasic_pay; ?> </th>
                    <th><?php echo $totalda; ?> </th>
                    <th><?php echo $totalvda; ?> </th>
                    <th><?php echo $totalhra; ?> </th>
                    <th><?php echo $totalothers_alw; ?> </th>
                    <th><?php echo $totaltiff_alw; ?> </th>
                    <th><?php echo $totalconv; ?> </th>
                    <th><?php echo $totalmedical; ?> </th>
                    <th><?php echo $totalmisc_alw; ?> </th>
                    <th><?php echo $totalover_time; ?> </th>
                    <th><?php echo $totalbouns; ?> </th>
                    <th><?php echo $totalleave_inc; ?> </th>
                    <th><?php echo $totalhta; ?> </th>

                    <th><?php echo $totalother_addition; ?> </th>
                    <th><?php echo $totalgross_salary; ?> </th>
                    <th><?php echo $totalprof_tax; ?> </th>
                    <th><?php echo $totalpf; ?> </th>
                    <th><?php echo $totalpf_int; ?> </th>
                    <th><?php echo $totalapf; ?> </th>
                    <th><?php echo $totali_tax; ?> </th>
                    <th><?php echo $totalinsu_prem; ?> </th>
                    <th><?php echo $totalpf_loan; ?> </th>
                    <th><?php echo $totalesi; ?> </th>
                    <th><?php echo $totaladv; ?> </th>
                    <th><?php echo $totalhrd; ?> </th>
                    <th><?php echo $totalco_op; ?> </th>
                    <th><?php echo $totalfurniture; ?> </th>
                    <th><?php echo $totalmisc_ded; ?> </th>
                    <th><?php echo $totalpf_employer; ?> </th>
                    <!-- <th><?php echo $totalincome_tax; ?> </th> -->
                    <th><?php echo $totalothers_deduction; ?> </th>
                    <th><?php echo $totaltotal_deduction; ?> </th>
                    <th><?php echo $totalnet_salary; ?> </th>
                </tr>
                <tr>
                    <td colspan="22" style="border-right:none;"></td>
                    <td colspan="2" style="width:150px;border-left:none;"></td>
                </tr>




            </tbody>

        </table>

        <!------------------------------------->
    </div>

    <!---------------------------------------------------->


    <!---------------------js------------------------------------->
    <!-------------------------------------------------------->
</body>

</html>
