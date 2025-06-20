@extends('loan.layouts.master')

@section('title')
Loan Information System - Loan
@endsection

@section('sidebar')
@include('loan.partials.sidebar')
@endsection

@section('header')
@include('loan.partials.header')
@endsection


@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add Loan</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Loans</a></li>
                        <li>/</li>
                        <li><a href="#">Add Loan</a></li>
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
                        <form action="{{url('loans/save-loan')}}" method="post" enctype="multipart/form-data"
                            onsubmit="return validate();">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_id">Loan ID</label>
                                        <input type="text" name="loan_id" id="loan_id" value="{{$loan_id}}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_code">Employee Code <span>(*)</span></label>
                                        <select id="emp_code" name="emp_code" class="form-control employee select2_el"
                                            required>
                                            <option selected disabled value="">Select</option>
                                            @foreach($Employee as $emp)
                                            <option value="{{$emp->emp_code}}" @if(old('emp_code')==$emp->emp_code)
                                                selected @endif>
                                                {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}} -
                                                {{$emp->old_emp_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_type">Loan Type <span>(*)</span></label>
                                        <select id="loan_type" name="loan_type" class="form-control employee select2_el"
                                            required>
                                            <option selected disabled value="">Select</option>
                                            <option value="PF" @if(old('loan_type')=="PF" ) selected @endif>PF Loan
                                            </option>
                                            <option value="SA" @if(old('loan_type')=="SA" ) selected @endif>Salary
                                                Advance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_month">Loan Start Date <span>(*)</span></label>
                                        <input class="form-control" id="start_month" type="date"
                                            value="{{ old('start_month') }}" name="start_month" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_amount">Loan Amount <span>(*)</span></label>
                                        <input class="form-control" id="loan_amount" type="number"
                                            value="{{ old('loan_amount') }}" name="loan_amount" required
                                            onkeyup="cal_installment();" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="installment_amount">Installment Amount <span>(*)</span></label>
                                        <input class="form-control" id="installment_amount" type="number"
                                            value="{{ old('installment_amount') }}" name="installment_amount" required
                                            onkeyup="cal_installment();" />
                                        <input type="hidden" name="no_installments" id="no_installments"
                                            value="{{ old('no_installments') }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="no_installments">No. of Installments</label>
                                        <input type="text" name="no_installments" id="no_installments" value="{{ old('no_installments') }}" class="form-control" readonly>
                                    </div>
                                </div> -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="deduction">Deduction <span>(*)</span></label>
                                        <select id="deduction" name="deduction" class="form-control" required>
                                            <option selected disabled value="">Select</option>
                                            <option value="Y" @if(old('deduction')=="Y" ) selected @endif>Yes</option>
                                            <option value="N" @if(old('deduction')=="N" ) selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa fa-plus"></i>&nbsp;Save</button>
                                    <button type="reset" class="btn btn-danger btn-sm" onclick="select2_reset();"><i
                                            class="fa fa-ban"></i>&nbsp;Reset</button>
                                </div>
                            </div>
                            <p>(*) marked fields are mandatory</p>
                        </form>
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
<div class="clearfix"></div>
@endsection

@section('scripts')
@include('payroll.partials.scripts')

<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    initailizeSelect2();
});
// Initialize select2
function initailizeSelect2() {

    $(".select2_el").select2();
}

function select2_reset() {
    $(".select2_el").val(null).trigger('change');
}

function cal_installment() {
    var loan_amount = $("#loan_amount").val();
    if (loan_amount == '') loan_amount = 0;
    var installment_amount = $("#installment_amount").val();
    if (installment_amount == '') installment_amount = 0;
    if (installment_amount > 0) {
        var installments = Math.round((eval(loan_amount) / eval(installment_amount)) * 100) / 100;
        $("#no_installments").val(installments);
    } else {
        if (loan_amount > 0) {
            $("#no_installments").val(1);
        } else {
            $("#no_installments").val(0);
        }
    }
}

function validate() {
    //alert($("#installment_amount").val());
    if (eval($("#installment_amount").val()) > eval($("#loan_amount").val())) {
        alert("Installment Amount can't be greater than Loan Amount.");
        $("#installment_amount").focus();
        return false;
    }
    return true;
}
</script>
@endsection