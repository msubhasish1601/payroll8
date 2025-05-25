@extends('payroll.layouts.master')

@section('title')
Payroll Information System
@endsection

@section('sidebar')
@include('payroll.partials.sidebar')
@endsection

@section('header')
@include('payroll.partials.header')
@endsection



@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Employee Pay Card</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Payroll</a></li>
                        <li>/</li>
                        <li class="active">Pay Card</li>

                    </ul>
                </span>
            </div>
        </div>

        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header"> <strong>Employeewise Payslip</strong> </div> -->
                    @include('include.messages')
                    <div class="card-body card-block">


                        <form action="{{ url('payroll/paycard') }}" target="_blank" method="post" onsubmit="return validate();">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="monthyr_from" class=" form-control-label">Month Year (From)
                                        <span>(*)</span></label>
                                    <input type="month" name="monthyr_from"  id="monthyr_from" class="form-control" required>

                                </div>
                                <div class="col-md-3">
                                    <label for="monthyr_to" class=" form-control-label">Month Year (To)
                                        <span>(*)</span></label>
                                    <input type="month" name="monthyr_to" id="monthyr_to" class="form-control" required>

                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter Employee Id <span>(*)</span></label>
                                    <select data-placeholder="Choose Employee..." name="emp_code"
                                        class="form-control select2_el" required>
                                        <option value="" selected disabled> Select </option>
                                        <?php foreach ($employeeslist as $employee) {?>
                                        <option value="<?php echo $employee->emp_code; ?>" @if (isset($emp_id_new) &&
                                            $emp_id_new==$employee->emp_code) selected
                                            @endif><?php echo $employee->emp_fname . ' ' . $employee->emp_mname . ' ' . $employee->emp_lname . ' (' . $employee->old_emp_code . ') '; ?>
                                        </option>
                                        <?php }?>
                                    </select>


                                    @if ($errors->has('emp_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-2 btn-up">
                                    <button type="submit" class="btn btn-danger btn-sm">View </button>
                                </div>
                            </div>


                        </form>
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
@include('payroll.partials.scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    initailizeSelect2();
});
// Initialize select2
function initailizeSelect2() {

    $(".select2_el").select2();
}
function validate(){
    var st = $("#monthyr_from").val().split('-');
    var ed = $("#monthyr_to").val().split('-');

    const startdate=st[1]+'/01/'+st[0];
    const enddate=ed[1]+'/01/'+ed[0];

    const date1 = new Date(startdate);
    const date2 = new Date(enddate);
    const diffTime = parseInt(date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    if(diffDays<0){
        alert('Please select correct month-year range.');
        return false;
    }
    //alert(diffDays);
    return true;
}
</script>
@endsection