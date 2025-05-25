@extends('holiday.layouts.master')

@section('title')
Holiday Dashboard
@endsection

@section('sidebar')
@include('holiday.partials.sidebar')
@endsection

@section('header')
@include('holiday.partials.header')
@endsection


@section('scripts')
@include('holiday.partials.scripts')
@endsection

@section('content')


<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <div class="row" style="border:none;">
                    <div class="col-md-6">
                        <h5 class="card-title">Add/Edit Holiday</h5>
                    </div>
                    <div class="col-md-6">

                        <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Holiday Management</a></li>
                                <li>/</li>
                                <li><a href="#">Holiday List</a></li>
                                <li>/</li>
                                <li class="active">Add/Edit Holiday</li>

                            </ul>
                        </span>
                    </div>
                </div>

                <!-- Widgets  -->
                <div class="row">
                    <?php //print_r($holidaydtl); exit; ?>
                    <div class="main-card">
                        <div class="card">
                            <!-- <div class="card-header"><strong class="card-title">Add Holiday</strong></div> -->
                            <div class="card-body card-block">
                                <form action="{{ url('holiday/add-holiday') }}" method="post"
                                    enctype="multipart/form-data" class="form-horizontal">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id"
                                        value="<?php if (!empty($holidaydtl->id)) {echo $holidaydtl->id;}?>">


                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="email-input"
                                                class=" form-control-label">From Date <span>(*)</span></label>
                                            <input type="date" id="from_date" required name="from_date"
                                                class="form-control"
                                                value="<?php if (!empty($holidaydtl->from_date)) {echo $holidaydtl->from_date;}?>"
                                                required>
                                            @if ($errors->has('from_date'))
                                            <div class="error" style="color:red;">{{ $errors->first('from_date') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col col-md-3"><label for="email-input"
                                                class=" form-control-label">To Date <span>(*)</span></label>
                                            <input type="date" required id="to_date" name="to_date" class="form-control"
                                                value="<?php if (!empty($holidaydtl->to_date)) {echo $holidaydtl->to_date;}?>"
                                                onchange="calculateDays();" required>
                                            @if ($errors->has('to_date'))
                                            <div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
                                            @endif
                                        </div>
                                        <div class="col col-md-3"><label for="email-input"
                                                class=" form-control-label">Day </label>
                                            <select class="form-control" name="weekname" required>
                                                <option value="sunday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ("sunday" == $holidaydtl->weekname) {echo "selected";}}?>>
                                                    Sunday</option>
                                                <option value="monday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ($holidaydtl->weekname == 'monday') {echo "selected";}}?>>
                                                    Monday</option>
                                                <option value="tuesday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ($holidaydtl->weekname == 'tuesday') {echo "selected";}}?>>
                                                    Tuesday</option>
                                                <option value="wednesday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ($holidaydtl->weekname == 'wednesday') {echo "selected";}}?>>
                                                    Wednesday</option>
                                                <option value="thrusday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ($holidaydtl->weekname == 'thrusday') {echo "selected";}}?>>
                                                    Thursday</option>
                                                <option value="friday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ($holidaydtl->weekname == 'friday') {echo "selected";}}?>>
                                                    Friday</option>
                                                <option value="saturday"
                                                    <?php if (!empty($holidaydtl->weekname)) {if ($holidaydtl->weekname == 'saturday') {echo "selected";}}?>>
                                                    Saturday</option>

                                            </select>
                                            @if ($errors->has('weekname'))
                                            <div class="error" style="color:red;">{{ $errors->first('weekname') }}</div>
                                            @endif
                                        </div>
                                        <div class="col col-md-3"><label for="email-input"
                                                class=" form-control-label">Holiday Type </label>
                                            <select class="form-control" name="holiday_type">
											@foreach($holiday_type as $value):
                 								<option value="{{ $value->id }}" <?php if (!empty($holidaydtl->holiday_type)) {if ($value->id == $holidaydtl->holiday_type) {echo "selected";}}?>>
                                             	{{ $value->name }}
                                         		</option>
                                        	@endforeach

                                            </select>
                                            @if ($errors->has('holiday_type'))
                                            <div class="error" style="color:red;">{{ $errors->first('holiday_type') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col col-md-3"><label for="email-input"
                                                class=" form-control-label">No. of Days </label>
                                            <input type="text" id="day" required name="day" class="form-control"
                                                value="<?php if (!empty($holidaydtl->day)) {echo $holidaydtl->day;}?>"
                                                required readonly>
                                            @if ($errors->has('day'))
                                            <div class="error" style="color:red;">{{ $errors->first('day') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="email-input" class="form-control-label">Holiday Description
                                                <span>(*)</span></label>
                                            <textarea rows="3" class="form-control" id="holiday_descripion"
                                                name="holiday_descripion"><?php if (!empty($holidaydtl->holiday_descripion)) {echo $holidaydtl->holiday_descripion;}?></textarea>
                                            @if ($errors->has('holiday_descripion'))
                                            <div class="error" style="color:red;">
                                                {{ $errors->first('holiday_descripion') }}</div>
                                            @endif
                                        </div>

                                    </div>




                                    <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Reset
                                    </button>
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
    @endsection
	@section('scripts')

    <script>
    function calculateDays() {
        var from_date = $("#from_date").val();
        const myArr = from_date.split("-");
        from_date = myArr[1] + '/' + myArr[2] + '/' + myArr[0];

        var to_date = $("#to_date").val();
        const myArrnew = to_date.split("-");
        to_date = myArrnew[1] + '/' + myArrnew[2] + '/' + myArrnew[0];

        var fromdate = new Date(from_date);
        var todate = new Date(to_date);
        var diffDays = (todate.getDate() - fromdate.getDate()) + 1;
        $("#day").val(diffDays);
    }
    </script>

    <script>
    function getGrades(company_id) {
        //alert(company_id);
        $.ajax({
            type: 'GET',
            url: "{{url('attendance/get-grades')}}/" + company_id,
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
    @include('holiday.partials.scripts')
    @endsection