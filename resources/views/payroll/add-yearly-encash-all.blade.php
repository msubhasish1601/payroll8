@extends('payroll.layouts.master')

@section('title')
Payroll Information System-Payroll Generation
@endsection

@section('sidebar')
@include('payroll.partials.sidebar')
@endsection

@section('header')
@include('payroll.partials.header')
@endsection


@section('content')
<style>
#bootstrap-data-table th {
    vertical-align: middle;
}

tr.spl td {
    font-weight: 600;
}

table#bootstrap-data-table tr td {
    font-size: 12px;
    padding: 8px 10px;
}
</style>
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add Yearly Employee Encashment</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Payroll Master</a></li>
                        <li>/</li>
                        <li><a href="#">View Yearly Employee Encashment</a></li>
                        <li>/</li>
                        <li class="active">Add Yearly Employee Encashment</li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    @include('include.messages')

                    @if ($errors->has('year.*'))
                    <div class="alert alert-success" style="text-align:center;"><span
                            class="glyphicon glyphicon-ok"></span><em><i class="fa fa-warning"></i>
                            {{ $errors->first('year.*') }}</em></div>
                    @endif
                    <!-- @include('include.messages') -->
                    <div class="card-body card-block">
                        <form action="{{url('payroll/add-yearly-encashment')}}" method="post" enctype="multipart/form-data"
                            style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label" style="text-align:right;">Select
                                    Pay Month/Year</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="year" id="year" required>

                                        <option value="" selected disabled> Select </option>
                                        <?php
for ($yy = 2022; $yy <= date('Y'); $yy++) {
    for ($mm = 1; $mm <= 12; $mm++) {
        if ($mm < 10) {
            $month_yr = '0' . $mm . "/" . $yy;
        } else {
            $month_yr = $mm . "/" . $yy;
        }
        ?>
												<option value="<?php echo $month_yr; ?>"  @if(isset($year_new) && $year_new==$month_yr) selected @endif><?php echo $month_yr; ?></option>
											<?php

    }
}
?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;
					height: 32px;">Go</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($result!='')
                <div class="card">
                    <!----------------view----------------->
                    <!-- <div class="card-header">
						<strong class="card-title">Payroll Generation for All Employee</strong>
					</div> -->
                    <div class="card-body card-block">
                        <div class="payroll-table table-responsive"
                            style="width:1190px;margin:0 auto;overflow-x:scroll;">
                            <form action="{{url('payroll/save-encashment-all')}}" method="post" >
                                {{csrf_field()}}
                                <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
								
                                <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl"
                                    class="sm_emp_code_ctrl" value="" />

                                <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl"
                                    class="sm_month_yr_ctrl" value="" />

                                <input type="hidden" id="sm_basic_ctrl" name="sm_basic_ctrl" class="sm_basic_ctrl"
                                    value="" />
                                <input type="hidden" id="sm_leaveenc_ctrl" name="sm_leaveenc_ctrl" class="sm_leaveenc_ctrl"
                                    value="" />
                                <input type="hidden" id="sm_hta_ctrl" name="sm_hta_ctrl"
                                    class="sm_hta_ctrl" value="" />
                                

                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead style="text-align:center;vertical-align:middle;">
                                        <tr>
                                            <th style="width:5%;">Sl. No.</th>
                                            <th style="width:8%;">Employee Id</th>
                                            <th style="width:12%;">Employee Code</th>
                                            <th style="width:18%;">Employee Name</th>
                                            <th style="width:10%;">Year</th>
                                            <th>Basic Pay</th>
                                            <th>Leave Enc.</th>
                                            <th>HTA</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php print_r($result);?>
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="border:none;">
                                                
                                                        <button type="button" class="btn btn-danger btn-sm checkall"
                                                            style="margin-right:2%;">Check All</button>

                                                        <button type="reset" class="btn btn-danger btn-sm">
                                                            Reset</button>
															<button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="map_controls();">Save</button>
                                                    
                                            </td>
                                            <td>
                                                <div class="total_leaveenc" style="font-weight:700;"></div>
                                            </td>
                                            <td>
                                                <div class="total_hta" style="font-weight:700;"></div>
                                            </td>
                                            
                                        </tr>
                                    </tfoot>


                                </table>
                            </form>
                        </div>
                    </div>
                    <!------------------------------->

                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /Widgets -->
</div>
<!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>


@endsection

@section('scripts')
@include('payroll.partials.scripts')
<script>
var clicked = false;
$(".checkall").on("click", function() {
    // $(".checkhour").prop("checked", !clicked);
    // clicked = !clicked;

    var ele = document.getElementsByName('empcode_check[]');
    // alert(ele.length);
    for (var i = 0; i < ele.length; i++) {
        if (ele[i].type == 'checkbox')
            ele[i].checked = true;
    }
    map_controls();
});



function map_controls() {

    var cb = $('.checkhour:checked').map(function() {
        return this.value;
    }).get().join(',');
    $('#cboxes').val(cb);

    var cb1 = $('.sm_emp_code').map(function() {
        return this.value;
    }).get().join(',');
    $('#sm_emp_code_ctrl').val(cb1);

    var cb2 = $('.sm_month_yr').map(function() {
        return this.value;
    }).get().join(',');
    $('#sm_month_yr_ctrl').val(cb2);

    var cb3 = $('.sm_basic').map(function() {
        return this.value;
    }).get().join(',');
    $('#sm_basic_ctrl').val(cb3);

    var cb4 = $('.sm_leaveenc').map(function() {
        return this.value;
    }).get().join(',');
    $('#sm_leaveenc_ctrl').val(cb4);

    var cb5 = $('.sm_hta').map(function() {
        return this.value;
    }).get().join(',');
    $('#sm_hta_ctrl').val(cb5);

   
}

$(document).on("keyup", ".sm_leaveenc", function() {
    doSumLeaveEnc();

});
$(document).on("keyup", ".sm_hta", function() {
    doSumHta();

});


$(document).ready(function() {
    $("#bootstrap-data-table").dataTable().fnDestroy();
    $('#bootstrap-data-table').DataTable({
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        initComplete: function(settings, json) {
            doSumLeaveEnc();
            doSumHta();
            
        }
    });

});

function doSumLeaveEnc() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(6).nodes();
    var total = table.column(6).nodes()
        .reduce(function(sum, node) {
            return sum + parseFloat($(node).find('input').val());
        }, 0);

    total = Math.round(total * 100) / 100;
    $(".total_leaveenc").html(total);
}

function doSumHta() {
    var table = $('#bootstrap-data-table').DataTable();
    var nodes = table.column(7).nodes();
    var total = table.column(7).nodes()
        .reduce(function(sum, node) {
            return sum + parseFloat($(node).find('input').val());
        }, 0);

    total = Math.round(total * 100) / 100;
    $(".total_hta").html(total);
}


</script>
@endsection