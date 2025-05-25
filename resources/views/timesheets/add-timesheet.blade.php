@extends('timesheets.layouts.master')

@section('title')
QOLARIS - Timesheet Module
@endsection


@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add Timesheet</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="{{ url('timesheets/dashboard') }}">Dashboard</a></li>

                        <li>/</li>
                        <li><a href="{{ url('timesheets/view-sheets') }}">Timesheet</a></li>

                        <li>/</li>
                        <li class="active">Add Timesheet</li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <form method="post" action="{{ url('timesheets/save-timesheet') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body card-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" form-control-label">Timesheet date</label>
                                        <input type="date" class="form-control" name="timesheet_date"
                                            id="timesheet_date" value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="employee_id" id="employee_id"
                                            value="{{ $employee_id }}">
                                            <input type="hidden" name="time_id" id="time_id"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" form-control-label">Total Hours Locked</label>
                                        @php
                                            $totHrs=0;
                                            $totMins=0;
                                            $totalHrMin=$totHrs.'.'.$totMins;
                                            $disabeSubmit="disabled";
                                            if($totalHrMin >= 7){
                                                $disabeSubmit="";
                                            }
                                        @endphp
                                        <div id="divTotalHrsLocked">{{$totHrs}} hrs {{$totMins}} mins</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <legend style="font-size:18px;">Task List</legend>
                                    <div id="divTaskListLoader" style="text-align:center;display:none;">
                                        <img src="{{ asset('img/loading.gif') }}" alt="Loader..">
                                    </div>
                                    <div class="table-responsive" id="divTaskList">
                                        <table class="table table-striped table-bordered" id="tblTaskList">
                                            <thead
                                                style="font-size: 14px;text-align:center;vertical-align:middle;background-color:#ccc;">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project Name</th>
                                                    <th>Task Type</th>
                                                    <th>Task</th>
                                                    <th>Job Description</th>
                                                    <th>Time</th>
                                                    <th>Task Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div>

                                        </div>
                                    </div>
                                    <div class="row" id="divTaskListSubmit" style="display:none;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span>If you do final submission of the task list, you won't be able to
                                                    add/change any details for the said date.</span>
                                                <input type="submit" name="submit-list" id="submit-list"
                                                    value="Submit Timesheet" {{$disabeSubmit}} class="btn btn-danger pull-right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body card-block" style="background-color:#ccc;border:1px dotted #000;">
                            <legend style="font-size:18px;">Add To above Task List</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class=" form-control-label">Project</label>
                                                <select class="form-control" id="atl_project_id" name="atl_project_id">
                                                    <option value=""></option>
                                                    @foreach ($projects as $project)
                                                    <option value="{{$project->id}}">{{($project->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class=" form-control-label">Task Type</label>
                                                @php
                                                $taskTypes=\Helpers::getTaskType();
                                                @endphp
                                                <select class="form-control" id="atl_task_type" name="atl_task_type">
                                                    <option value=""></option>
                                                    @foreach ($taskTypes as $tt)
                                                    <option value="{{$tt}}">{{($tt)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class=" form-control-label">Task</label>
                                                <select class="form-control" id="atl_task" name="atl_task">
                                                    <option value="">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class=" form-control-label">Job Description</label>
                                                <textarea class="form-control" id="atl_jobdesc"
                                                    name="atl_jobdesc"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class=" form-control-label">Task Time</label><br>
                                                <span id="task_time_span"></span>
                                                <input id="task_time" name="task_time" type="hidden" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class=" form-control-label">Task Status</label>
                                                @php
                                                $taskStatuses=\Helpers::getTaskStatus();
                                                @endphp
                                                <select class="form-control" id="atl_task_status"
                                                    name="atl_task_status">
                                                    @foreach ($taskStatuses as $ts)
                                                    <option value="{{$ts}}">{{($ts)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="button" name="add-to-list" id="add-to-list"
                                                    value="Add to list" class="btn btn-primary mt-4 pull-right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>



        </div>
        <!-- /Widgets -->



    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
@endsection
@section('pagecss')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
<style>
select.form-control.timepick {
    float: left;
    width: 50%;
}
</style>
@endsection
@section('scripts')
<!-- <script src="js/hr.timePicker.min.js"></script> -->
<script src="{{ asset('js/jquery.simpletimepicker.js')}}"></script>
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    initailizeSelect2();

    $("#task_time_span").simpleTimePicker({
        output: '#task_time',
        text: {
            hour: 'Hour',
            minute: 'Minute'
        },
        format: 12,
        interval: 5,
        // time: {
        //     selected:'now'
        // },
        css: 'form-control timepick'
    });
});
// Initialize select2
function initailizeSelect2() {
    $(".select2_el").select2();
}
</script>
<script type="text/javascript">
$('#atl_task_type').on('change', function() {
    var project_id = $('#atl_project_id').find(":selected").val();
    var taskType = $(this).find(":selected").val()
    var employee_id = $('#employee_id').val();
    // console.log(taskType);
    if (project_id != '' && taskType != '') {
        if (taskType == 'Unplanned') {
            $('#atl_task').html('<option value="">Other</option>');
        } else {
            $.ajax({
                type: 'GET',
                url: "{{url('projects/get-employee-tasks')}}/" + employee_id + "/" + project_id,
                beforeSend: function() {
                    // $('#district_id').attr('disabled', true);
                },
                success: function(response) {
                    // console.log(response);
                    var obj = jQuery.parseJSON(response);
                    // console.log(obj.length);
                    var strOption = "<option value=''></option> ";
                    if (obj.length > 0) {
                        // console.log(obj[0]);
                        for (i = 0; i < obj.length; i++) {
                            // console.log(obj[i].employee_id);
                            strOption = strOption + "<option value='" + obj[i].id + "'";
                            strOption = strOption + ">" + obj[i].task_description + "</option>";
                        }
                    }
                    $('#atl_task').html(strOption);
                }
            });
        }
    } else {
        $('#atl_task').html('<option value="">Other</option>');
    }
});

function resetAddToListForm(){
    $('#atl_project_id').val('');
    $('#atl_task_type').val('');
    $('#atl_task').html('<option value="">Other</option>');
    $('#atl_jobdesc').val('');
}

$('#add-to-list').on('click', function() {
    var project_id = $('#atl_project_id').find(":selected").val();
    var task_type = $('#atl_task_type').find(":selected").val();
    var task = $('#atl_task').find(":selected").val();
    var desc = $('#atl_jobdesc').val();
    var hour =$("select[name='hour']").val();
    var minute =$("select[name='minute']").val();
    // alert(hour);

    if (project_id == '') {
        alert('Select your project to add.');
        $('#atl_project_id').focus();
    } else if (task_type == '') {
        alert('Select your task type to add.');
        $('#atl_task_type').focus();
    } else if (task_type == 'Planned' && task == '') {
        alert('Select your task to add.');
        $('#atl_task').focus();
    } else if (desc == '') {
        alert('Please provide details of work take care off.');
        $('#atl_jobdesc').focus();
    } else if (hour == '') {
        alert('Please provide hour details.');
        $("select[name='hour']").focus();
    } else if (minute == '') {
        alert('Please provide minute details.');
        $("select[name='minute']").focus();
    } else if (eval(hour) == 0 && eval(minute) == 0) {
        alert('You cannot put ZERO time for any task.');
        $("select[name='hour']").focus();
    } else {
        $.ajax({
            type: 'POST',
            url: "{{url('timesheets/add-to-list')}}",
            data: $('form').serialize(),
            beforeSend: function() {
                // $('#add-to-list').attr('disabled', true);
                $('#divTaskListLoader').show();
                $('#divTaskList').hide();
            },
            success: function(response) {
                // console.log(response.data.timesheet_details);
                // $('#add-to-list').attr('disabled', false);
                var jsonParsed = jQuery.parseJSON(response);
                var json=jsonParsed.data.timesheet_details;
                $('#time_id').val(jsonParsed.data.timesheet.id);
                // console.log(json);
                $(function() {
                    var content = '';
                    var tsdHr = 0;
                    var tsdMin = 0;
                    var taskName="";
                    //content += '<tbody>'; -- **superfluous**
                    for (var i = 0; i < json.length; i++) {
                        tsdHr = tsdHr + eval(json[i].hours);
                        tsdMin = tsdMin + eval(json[i].minutes);
                        if(json[i].task_name !== "" && json[i].task_name != null){
                            taskName=json[i].task_name;
                        }else{
                            taskName="";
                        }

                        content += '<tr>';
                        content += '<td>' + (i+1) + '</td>';
                        content += '<td>' + json[i].project_name + '</td>';
                        content += '<td>' + json[i].task_type + '</td>';
                        content += '<td>' + taskName + '</td>';
                        content += '<td>' + json[i].description + '</td>';
                        content += '<td>' + json[i].task_time + '</td>';
                        content += '<td>' + json[i].task_status + '</td>';
                        content +=
                            '<td style="text-align:center;"><a href="javascript:void(0);" class="delete" onclick="removeFromList('+json[i].id+');"><i class="fa fa-trash text-red"></i></a></td>';
                        content += '</tr>';
                    }

                    var hrInMins = Math.floor(tsdMin / 60);
                    var minInMins = tsdMin % 60;
                    tsdHr = tsdHr + hrInMins;
                    var total_hours = tsdHr + 'hrs ' + minInMins+' mins';
                    var total_hrs = tsdHr + '.' + minInMins;
                    if(parseFloat(total_hrs)>=7){
                        $('#submit-list').attr('disabled', false);
                    }else{
                        $('#submit-list').attr('disabled', true);
                    }
                    $('#divTotalHrsLocked').html(total_hours);
                    // content += '</tbody>';-- **superfluous**
                    //$('table tbody').replaceWith(content);  **incorrect..**
                    $('#tblTaskList tbody').html(content); // **better. give the table a ID, and replace**
                    if(content !=""){
                        $('#divTaskListSubmit').show();
                    }else{
                        $('#divTaskListSubmit').hide();
                    }
                    resetAddToListForm();
                });

            },
            error: function(data) {
                var jsonErrorParsed = jQuery.parseJSON(data.responseJSON);
                // console.log(jsonErrorParsed.error);
                alert(jsonErrorParsed.error);
            },
            complete: function(data) {
                $('#divTaskListLoader').hide();
                $('#divTaskList').show();
            }
        });
    }

});
function removeFromList(id){
    if (confirm("Do you want to remove this task from list?") == true){
        $.ajax({
            type: 'GET',
            url: "{{url('timesheets/remove-from-list')}}/"+id,
            // data: $('form').serialize(),
            beforeSend: function() {
                // $('#add-to-list').attr('disabled', true);
                $('#divTaskListLoader').show();
                $('#divTaskList').hide();
            },
            success: function(response) {
                // console.log(response.data.timesheet_details);
                // $('#add-to-list').attr('disabled', false);
                var jsonParsed = jQuery.parseJSON(response);
                var json=jsonParsed.data.timesheet_details;
                $('#time_id').val(jsonParsed.data.timesheet.id);
                // console.log(json);
                $(function() {
                    var content = '';
                    var tsdHr = 0;
                    var tsdMin = 0;
                    var taskName="";
                    //content += '<tbody>'; -- **superfluous**
                    for (var i = 0; i < json.length; i++) {
                        tsdHr = tsdHr + eval(json[i].hours);
                        tsdMin = tsdMin + eval(json[i].minutes);
                        if(json[i].task_name !== "" && json[i].task_name != null){
                            taskName=json[i].task_name;
                        }else{
                            taskName="";
                        }

                        content += '<tr>';
                        content += '<td>' + (i+1) + '</td>';
                        content += '<td>' + json[i].project_name + '</td>';
                        content += '<td>' + json[i].task_type + '</td>';
                        content += '<td>' + taskName + '</td>';
                        content += '<td>' + json[i].description + '</td>';
                        content += '<td>' + json[i].task_time + '</td>';
                        content += '<td>' + json[i].task_status + '</td>';
                        content +=
                            '<td style="text-align:center;"><a href="javascript:void(0);" class="delete" onclick="removeFromList('+json[i].id+');"><i class="fa fa-trash text-red"></i></a></td>';
                        content += '</tr>';
                    }

                    var hrInMins = Math.floor(tsdMin / 60);
                    var minInMins = tsdMin % 60;
                    tsdHr = tsdHr + hrInMins;
                    var total_hours = tsdHr + 'hrs ' + minInMins+' mins';
                    var total_hrs = tsdHr + '.' + minInMins;
                    if(parseFloat(total_hrs)>=7){
                        $('#submit-list').attr('disabled', false);
                    }else{
                        $('#submit-list').attr('disabled', true);
                    }
                    $('#divTotalHrsLocked').html(total_hours);
                    // content += '</tbody>';-- **superfluous**
                    //$('table tbody').replaceWith(content);  **incorrect..**
                    $('#tblTaskList tbody').html(content); // **better. give the table a ID, and replace**
                    resetAddToListForm();
                });

            },
            error: function(data) {
                var jsonErrorParsed = jQuery.parseJSON(data.responseJSON);
                // console.log(jsonErrorParsed.error);
                alert(jsonErrorParsed.error);
            },
            complete: function(data) {
                $('#divTaskListLoader').hide();
                $('#divTaskList').show();
            }
        });
    }
}
</script>
@endsection
