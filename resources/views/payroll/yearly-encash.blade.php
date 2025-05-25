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
                <h5 class="card-title">Yearly Employee Encashments</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Payroll Master</a></li>
                        <li>/</li>

                        <li class="active">Yearly Employee Encashments</li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <div class="card-header">
                        <div class="aply-lv">
                            <a href="{{url('payroll/add-yearly-encashment')}}" class="btn btn-default">Generate Yearly
                                Employee Encashment <i class="fa fa-plus"></i></a>
                        </div>
                        @include('include.messages')
                    </div>

                    <div class="card-body card-block">
                        <form action="{{url('payroll/vw-yearly-encashment')}}" method="post" enctype="multipart/form-data"
                            style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label" style="text-align:right;">Select
                                        Pay Month/Year</label>
                                </div>
                                <div class="col-md-6">
                                    <select data-placeholder="Choose Year..." name="year" id="year" class="form-control"
                                        required>
                                        <option value="" selected disabled> Select </option>
                                        @foreach ($yearlist as $rec)
                                        <option value="<?php echo $rec->year; ?>" @if(isset($req_year) &&
                                            $req_year==$rec->year) selected @endif><?php echo $rec->year; ?></option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('year'))
                                    <div class="error" style="color:red;">{{ $errors->first('year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success"
                                        style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;">Go</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(isset($employee_rs))
                <div class="card">
                    <!----------------view----------------->
                    <!-- <div class="card-header">
						
					</div> -->
                    <div class="card-body card-block">
                        <div class="payroll-table table-responsive"
                            style="width:1190px;margin:0 auto;overflow-x:scroll;">
                            
                                

                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead style="text-align:center;vertical-align:middle;">
                                        <tr>
                                            <th style="width:5%;">Sl. No.</th>
                                            <th style="width:8%;">Employee Id</th>
                                            <th style="width:12%;">Employee Code</th>
                                            <th style="width:18%;">Employee Name</th>
                                            <th style="width:10%;">Year</th>
                                            <th>Leave Enc.</th>
                                            <th>HTA</th>
                                            <th>Commission</th>
                                            <th>Other Income</th>
                                            <th>Other Perks</th>
                                            <th>Med. Reimbersement</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($employee_rs as $record)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$record->emp_code}}</td>
                                            <td>{{$record->old_emp_code}}</td>
                                            <td>{{$record->emp_fname . ' ' . $record->emp_mname . ' ' . $record->emp_lname}}</td>
                                            <td>{{$record->year}}</td>
                                            <td>{{$record->leave_enc}}</td>
                                            <td>{{$record->hta}}</td>
                                            <td>{{$record->commision}}</td>
                                            <td>{{$record->oth_income}}</td>
                                            <td>{{$record->other_perks}}</td>
                                            <td>{{$record->medical_reimbersement}}</td>
                                            <td>
                                                @if($record->status=='process')
                                                <a href="{{url('payroll/edit-yearly-encashment')}}/{{$record->id}}"><i class="ti-pencil-alt"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                    


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


function confirmDelete(e) {
    e.preventDefault();
    if (confirm("Do you want to delete all the generated records for this year?") == true) {
        //text = "You pressed OK!";
        $('#deleteme').val('yes');
        $('#myForm').submit();
    }
}

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

	$('#statusme').val($('#status').val());
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