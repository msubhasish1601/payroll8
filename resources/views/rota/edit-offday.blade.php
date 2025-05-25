@extends('rota.layouts.master')

@section('title')
BELLEVUE Configuration - User
@endsection

@section('sidebar')
@include('rota.partials.sidebar')
@endsection

@section('header')
@include('rota.partials.header')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Edit Day Off</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                <li>/</li>
								<li><a href="#">Day Off</a></li>
								<li>/</li>
                                <li class="active">Edit Day Off</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header"><strong class="card-title">Day Off Details</strong></div> -->
                    <div class="card-body">

                        @include('include.messages')
                        <form action="{{ url('rota/update-offday') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php echo $shift_management->id; ?>">
                            <div class="clearfix"></div>
                            <div class="lv-due" style="border:none;">

                                <div class="row form-group lv-due-body">
                                    <div class="col-md-4">
                                        <label>Select Department</label>
                                        <select class="form-control" id="emp_code" required name="department" onchange="chngdepartment(this.value);">
                                            <option value="">Select</option>

                                            @foreach($departs as $dept)
                                            <option value='{{ $dept->id }}' <?php if ($shift_management->department == $dept->id) {  echo 'selected'; } ?>>{{ $dept->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Select Designation</label>
                                        <select class="form-control" id="designation" required name="designation" onchange="chngdepartmentshift(this.value);">
                                        <option value="">Select</option>
					 @foreach($desig as $desig)
                     <option value="{{$desig->id}}" <?php  if($shift_management->designation==$desig->id){ echo 'selected';}  ?>>{{$desig->designation_name}}</option>
                       @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Shift Code</label>
                                        <select class="form-control" id="shift_code" required name="shift_code">
                                        <option value="">Select</option>
												
					 @foreach($shiftc as $shiftcval)
                     <option value="{{$shiftcval->id}}" <?php  if($shift_management->shift_code==$shiftcval->id){ echo 'selected';}  ?>>{{$shiftcval->shift_code}}</option>
                       @endforeach
                                        </select>
                                    </div>
                                   
                                </div>

                                <div class="row form-group lv-due-body">
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-monday" type="checkbox" name="mon" value="1" <?php   if($shift_management->mon=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-monday" class="day-check">Monday</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-Tuesday" type="checkbox" name="tue" value="1" <?php   if($shift_management->tue=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-Tuesday" class="day-check">Tuesday</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-Wednesday" type="checkbox" name="wed" value="1" <?php  if($shift_management->wed=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-Wednesday" class="day-check">Wednesday</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-Thursday" type="checkbox" name="thu" value="1" <?php  if($shift_management->thu=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-Thursday" class="day-check">Thursday</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-Friday" type="checkbox" name="fri" value="1" <?php if($shift_management->mon=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-Friday" class="day-check">Friday</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-Saturday" type="checkbox" name="sat" value="1" <?php  if($shift_management->sat=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-Saturday" class="day-check">Saturday</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input id="inputFloatingLabel-Sunday" type="checkbox" name="sun" value="1" <?php   if($shift_management->sun=='1'){ echo 'checked';}  ?>>
                                        <label for="inputFloatingLabel-Sunday" class="day-check">Sunday</label>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                        <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>

                                    </div>

                                    <div class="clearfix"></div>
                                </div>

                                <!--
					  <div id="rowid">
					  
					  </div>
					  -->


                            </div>
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
@include('rota.partials.scripts')

<script>
    function del(i, head) {
        //alert(i);
        //alert(head);
        var classrow = head + '' + i;

        /*
        if (rowid != ''){
        	//alert(rowid);
        	//$('#add'+rowid).prop('disabled', false);
        	//$('#add'+rowid).removeAttr('disabled');
        	alert("DEL"+i);
        	$('#addrow'+rowid).attr('disabled',false);
        }
        */

        $(".row" + classrow).html('');
    }
</script>

<script>
    function chngdepartment(empid) {

        $.ajax({
            type: 'GET',
            url: '{{url('rota/getEmployeedesigByshiftId')}}/'+empid,
            cache: false,
            success: function(response) {


                document.getElementById("designation").innerHTML = response;
            }
        });
    }

    function chngdepartmentshift(empid) {

        $.ajax({
            type: 'GET',
            url: '{{url('rota/getEmployeedesigBylateId')}}/'+empid,
            cache: false,
            success: function(response) {


                document.getElementById("shift_code").innerHTML = response;
            }
        });
    }
</script>
@endsection