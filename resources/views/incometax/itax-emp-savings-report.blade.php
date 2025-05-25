@extends('incometax.layouts.master')

@section('title')
BELLEVUE - Income Tax Module
@endsection

@section('sidebar')
@include('incometax.partials.sidebar')
@endsection

@section('header')
@include('incometax.partials.header')
@endsection


@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Income Tax Report</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Income Tax Report</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
 
                    @include('include.messages')


                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col-md-5">
                                <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                <select name="financial_year" id="financial_year" class="form-control select2_el">
                                    <option value="">Choose a year</option>
                                    <?php $starting_year  = date('Y', strtotime('-10 year'));
                                        $ending_year = date('Y', strtotime('-1 year'));
                                        $current_year = date('Y', strtotime('-1 year'));
                                        for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                            echo '<option value="' . $starting_year . '-' . ($starting_year + 1) . '"';
                                            if(isset($fyear) && $fyear!=''){
                                                $recval=$starting_year . '-' . ($starting_year + 1);
                                                if ($recval ==  $fyear) {
                                                    echo ' selected="selected"';
                                                }
                                            }else{
                                                if ($starting_year ==  $current_year) {
                                                    echo ' selected="selected"';
                                                }
                                            }
                                            echo ' >' . $starting_year . '-' . ($starting_year + 1) . '</option>';
                                        }               
                                    ?>
                                </select>
                                @if ($errors->has('financial_year'))
                                <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                @endif
                            </div>
                            <div class="col-md-5">
                                <label class=" form-control-label">Employee Name <span>(*)</span></label>

                                <select data-placeholder="Choose Employee..." name="emp_code" id="emp_code"
                                    class="form-control select2_el" required>
                                    <option value="" selected disabled> Select </option>
                                    <?php foreach ($employeeslist as $employee) {?>
                                    <option value="<?php echo $employee->emp_code; ?>" @if (isset($empcode) &&
                                        $empcode==$employee->emp_code) selected
                                        @endif><?php echo $employee->emp_fname . ' ' . $employee->emp_mname . ' ' . $employee->emp_lname . ' (' . $employee->old_emp_code . ') '; ?>
                                    </option>
                                    <?php }?>
                                </select>


                                @if ($errors->has('emp_code'))
                                <div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
                                @endif
                            </div>
                            <div class="col-md-2 btn-up">
                                <button type="button" class="btn btn-danger btn-sm" onclick="viewDetails();">View
                                </button>
                                @if($fyear!='' || $empcode!='')
                                <button type="button" class="btn btn-default btn-sm" onclick="reset();">Reset </button>
                                @endif
                            </div>
                        </div>
                    </div>
 
                </div>

            </div>



        </div>
        <!-- /Widgets -->



    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
@endsection


@section('scripts')
@include('incometax.partials.scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    initailizeSelect2();
});
// Initialize select2
function initailizeSelect2() {

    $(".select2_el").select2();
}

function viewDetails() {
    if ($('#financial_year').val() != null && $('#emp_code').val() != null) {
        window.open("{{url('itax/employee-savings-report')}}?p=" + btoa($('#financial_year').val()) + "&f=" + btoa(
            $('#emp_code').val()), '_blank');
    } else {
        alert("Please select financial year & Employee.");
    }
}

function reset() {
    window.location.href = "{{url('itax/employee-savings-report')}}";
}
</script>
@endsection