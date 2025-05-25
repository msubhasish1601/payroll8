@extends('leavemanagement.layouts.master')

@section('title')
Leave Rule System-Company
@endsection

@section('sidebar')
@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
@include('leavemanagement.partials.header')
@endsection

@section('scripts')
@include('leavemanagement.partials.scripts')
@endsection

@section('content'))

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add/Edit Leave Rule</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Leave Managemnt</a></li>
                        <li>/</li>
                        <li><a href="#">Leave Rule</a></li>
                        <li>/</li>
                        <li class="active">Add/Edit Leave Rule</li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">
            <?php //print_r($leave_rule_data); exit; ?>
            <div class="main-card">
                <div class="card">
                    <div class="card-header">
                        <!-- <strong class="card-title">Add New Leave Rule</strong> -->
                    </div>
                    <div class="card-body card-block">
                        <form action="{{ url('leave-management/save-leave-rule') }}" method="post"
                            enctype="multipart/form-data" class="form-horizontal" style="padding:5% 12%;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <input type="hidden" name="id"
                                    value="<?php if (!empty($leave_rule_data->id)) {echo $leave_rule_data->id;}?>">

                                <div class="col col-md-4">
                                    <label for="text-input" class=" form-control-label">Leave Type
                                        <span>(*)</span></label>
                                    <select class="form-control" required id="leave_type_id" name="leave_type_id">
                                        <option value="" selected disabled>Select</option>
                                        @foreach($leave_type_rs as $leave_type)
                                        <option value="{{$leave_type->id}}"
                                            <?php if (!empty($leave_rule_data->leave_type_id)) {if ($leave_rule_data->leave_type_id == $leave_type->id) {echo "selected";}}?>>
                                            {{ $leave_type->leave_type_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('leave_type_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('leave_type_id') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label for="email-input" class=" form-control-label">Maximum No.
                                        <span>(*)</span></label>
                                    <input type="text" id="max_no" required name="max_no" class="form-control"
                                        value="<?php if (!empty($leave_rule_data->max_no)) {echo $leave_rule_data->max_no;}?>">

                                    @if ($errors->has('max_no'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_no') }}</div>
                                    @endif
                                </div>
                                <div class="col col-md-4">
                                    <label for="text-input" class=" form-control-label">Entitled From Month
                                        <span>(*)</span></label>
                                    <select class="form-control" id="entitled_from_month" name="entitled_from_month"
                                        required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="01"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '01') {echo "selected";}}?>>
                                            01</option>
                                        <option value="02"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '02') {echo "selected";}}?>>
                                            02</option>
                                        <option value="03"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '03') {echo "selected";}}?>>
                                            03</option>
                                        <option value="04"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '04') {echo "selected";}}?>>
                                            04</option>
                                        <option value="05"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '05') {echo "selected";}}?>>
                                            05</option>
                                        <option value="06"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '06') {echo "selected";}}?>>
                                            06</option>
                                        <option value="07"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '07') {echo "selected";}}?>>
                                            07</option>
                                        <option value="08"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '08') {echo "selected";}}?>>
                                            08</option>
                                        <option value="09"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '09') {echo "selected";}}?>>
                                            09</option>
                                        <option value="10"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '10') {echo "selected";}}?>>
                                            10</option>
                                        <option value="11"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '11') {echo "selected";}}?>>
                                            11</option>
                                        <option value="12"
                                            <?php if (!empty($leave_rule_data->entitled_from_month)) {if ($leave_rule_data->entitled_from_month == '12') {echo "selected";}}?>>
                                            12</option>
                                    </select>
                                    @if ($errors->has('entitled_from_month'))
                                    <div class="error" style="color:red;">{{ $errors->first('entitled_from_month') }}
                                    </div>
                                    @endif
                                </div>
                            </div>



                            <div class="row form-group">

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Maximum Balance Enjoy
                                        <span>(*)</span></label>
                                    <input type="text" id="max_balance_enjoy" required name="max_balance_enjoy"
                                        class="form-control"
                                        value="<?php if (!empty($leave_rule_data->max_balance_enjoy)) {echo $leave_rule_data->max_balance_enjoy;}?>">
                                    @if ($errors->has('max_balance_enjoy'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_balance_enjoy') }}
                                    </div>
                                    @endif

									<input type="hidden" id="carry_forward_type" name="carry_forward_type" value="no">
                                </div>
                                <!-- <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Carry Forward Type
                                        <span>(*)</span></label>
                                    <select class="form-control" id="carry_forward_type" name="carry_forward_type"
                                        required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="yes"
                                            <?php //if(!empty($leave_rule_data->carry_forward_type)){ if($leave_rule_data->carry_forward_type == 'yes'){ echo "selected"; } } ?>>
                                            Yes</option>
                                        <option value="no"
                                            <?php //if(!empty($leave_rule_data->carry_forward_type)){ if($leave_rule_data->carry_forward_type == 'no'){ echo "selected"; } }  ?>>
                                            No</option>
                                    </select>
                                    @if ($errors->has('carry_forward_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('carry_forward_type') }}
                                    </div>
                                    @endif
                                </div> -->



                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Effective
                                        From<span>(*)</span></label>
                                    <!--<input type="date" id="effective_from" name="effective_from" class="form-control" value="{{ old('effective_from') }}">-->
                                    <input type="date" id="effective_from" required name="effective_from"
                                        class="form-control" data-date-format="DD MMMM YYYY"
                                        value="<?php if (!empty($leave_rule_data->effective_from)) {echo $leave_rule_data->effective_from;}?>">
                                    @if ($errors->has('effective_from'))
                                    <div class="error" style="color:red;">{{ $errors->first('effective_from') }}</div>
                                    @endif
                                </div>


                                <div class="col-md-3">
                                    <label for="email-input" class="form-control-label">Effective
                                        To<span>(*)</span></label>
                                    <input type="date" data-date-format="DD-MM-YYYY" required id="effective_to"
                                        name="effective_to" class="form-control"
                                        value="<?php if (!empty($leave_rule_data->effective_to)) {echo $leave_rule_data->effective_to;}?>">
                                    @if ($errors->has('effective_to'))
                                    <div class="error" style="color:red;">{{ $errors->first('effective_to') }}</div>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                            <p>(*) marked fields are mandatory</p>
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
@include('leavemanagement.partials.scripts')
<script>
function getGrades(company_id) {
    //alert(company_id);
    $.ajax({
        type: 'GET',
        url: '{{url('
        attendance / get - grades ')}}/' + company_id,
        success: function(response) {
            console.log(response);

            $("#grade_id").html(response);
            //var jqObj = jQuery.parseJSON(response);
            //alert(response);
            //var jqObj =JSON.parse(response);
            //var jqObj = response.map(JSON.parse)
            //var jqObj = jQuery(response);
            //alert(jqObj.emp_present_address);
            //$("#grade_id").val(jqObj.emp_name);
            //$("#address").val(jqObj.emp_present_address);
        }

    });
}
</script>

@endsection