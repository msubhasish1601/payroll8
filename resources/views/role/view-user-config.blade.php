@extends('role.layouts.master')

@section('title')
{{ config('app.name', 'Laravel') }} Configuration - User
@endsection

@section('sidebar')
@include('role.partials.sidebar')
@endsection

@section('header')
@include('role.partials.header')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">User Configuration</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Role</a></li>
                        <li>/</li>
                        <li><a href="#">User Configuration</a></li>
                        <li>/</li>
                        <li class="active">Add New User</li>
                    </ul>
                </span>
            </div>
        </div>

        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header"><strong class="card-title">User Config</strong></div> -->
                    <div class="card-body">
                        <!-- @if(Session::has('message'))
<div class="alert alert-success" style="text-align:center;color: #ff0000;"><i class="fa fa-check" aria-hidden="true"></i><em > {{ Session::get('message') }}</em></div>
@endif	 -->
                        @include('include.messages')
                        <form action="{{ url('role/save-user-config') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="clearfix"></div>
                            <div class="lv-due" style="border:none;">

                                <div class="row form-group lv-due-body">
                                    <div class="col-md-3">
                                        <label>Employee Code</label>
                                        <select class="form-control" id="emp_code" required name="emp_code"
                                            onchange="getEmployeeName()"
                                            <?php if (!empty($user->id)) {echo 'style="display:none"';}?>>
                                            <option value="">Select</option>
                                            <?php foreach ($employees as $employee) {?>
                                            <option value="<?php echo $employee->emp_code; ?>">
                                                <?php echo $employee->emp_fname . " " . $employee->emp_mname . " " . $employee->emp_lname . " (" . $employee->emp_code . ") "; ?>
                                            </option>
                                            <?php }?>
                                        </select>
                                        <input type="text" name="employee_id"
                                            value="<?php if (!empty($user->id)) {echo $user->employee_id;}?>"
                                            <?php if (empty($user->id)) {echo 'style="display:none"';}?>
                                            class="form-control" readonly="1" />
                                        @if ($errors->has('old_emp_code'))
                                        <div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        <label>Employee Name</label>
                                        <input type="text" required id="emp_name" name="name"
                                            value="<?php if (!empty($user->id)) {echo $user->name;}?>"
                                            class="form-control" readonly="1">
                                    </div>

                                    <div class="col-md-3">
                                        <label>User Email</label>
                                        <input type="text" required name="user_email"
                                            value="<?php if (!empty($user->id)) {echo $user->email;}?>"
                                            <?php if (!empty($user->id)) {echo 'readonly';}?> class="form-control">
                                        @if ($errors->has('user_email'))
                                        <div class="error" style="color:red;">{{ $errors->first('user_email') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <label>User Password</label>
                                        <input type="text" name="user_pass" required class="form-control">
                                        @if ($errors->has('user_pass'))
                                        <div class="error" style="color:red;">{{ $errors->first('user_pass') }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-3" <?php if (empty($user->id)) {?>style="display:none" <?php }?>>
                                        <label>Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="active"
                                                <?php if (!empty($user->status)) {if ($user->status == "active") {?>
                                                selected="selected" <?php }}?>>Active</option>
                                            <option value="deactive"
                                                <?php if (!empty($user->status)) {if ($user->status == "deactive") {?>
                                                selected="selected" <?php }}?>>Deactive</option>
                                        </select>
                                    </div>


                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                        <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i>
                                            Reset</button>

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
@include('role.partials.scripts')

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
function addnewrow(row) {
    alert(row);
    //alert(head);
    /*
    var rowid=row-1;
    if (rowid != '')
    {
    	$('#add'+rowid).attr('disabled',true);
    }
    */
    //var head_id=$("#add"+head+''+row).data("id");
    //var head_name=$("#add"+head+''+row).data("head");
    //alert(head_id);
    //alert(head_name);
    //var rowid=row+1;
    $.ajax({
        type: 'GET',
        url: '{{url("role/get-row-add-user-rights")}}/' + row,
        success: function(jsonStr) {
            alert(jsonStr);
            console.log(jsonStr);

            //var jqObj = jQuery(jsonStr);

            //var classrow=head;
            //alert(classrow);
            $("#rowww").append(jsonStr);

            //$("#itemslot").removeAttr('disabled');
            //	$("#itemslot").html('<i class="fa fa-plus"></i> Add Row');
        }
    });

    //alert(a);
    //d++;
}



function getEmployeeName() {
    //$('#emplyeename').show();
    var emp_code = $("#emp_code option:selected").text();
    var name = emp_code.split("(");
    $("#emp_name").val(name[0]);

    //$("#emp_name").attr("readonly", true);
}
</script>
@endsection