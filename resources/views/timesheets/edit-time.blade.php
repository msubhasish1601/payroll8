@extends('timesheets.layouts.master')

@section('title')
QOLARIS - Timesheet Module
@endsection


@section('content')

<div class="content">

    <!-- Animated -->


    <div class="main-card ">
        <div class="card ">

            <form method="post" enctype="multipart/form-data" action="" class="form-horizontal">
                {{csrf_field()}}
                <input type="hidden" name="timesheet_id" value="<?php echo $Timesheet->id; ?>">
                <div class="card-body card-block">
                    @php
                    $rowid=0;
                    @endphp
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="email-input" class="sform-control-label" required>Date
                                <!-- <span class="error">(*)</span> -->
                            </label>
                            <input type="date" id="sheet_date" name="sheet_date" class="form-control"
                                value="{{$Timesheet->sheet_date}}">
                            @if ($errors->has('sheet_date'))
                            <div class="error" style="color:red;">{{ $errors->first('sheet_date') }}</div>
                            @endif
                        </div>
                    </div>
                    <div id="dynamic_row_resource">
                        @foreach($TimesheetData as $key => $t_data)
                        <div class="rowresource" id="<?php echo $key; ?>">
                        <div class="row">

                            <div class="col-md-2">
                                <label for="project_id{{$key}}" class="sform-control-label">Project Name
                                </label>
                                <select name="project_id[]" id="project_id{{$key}}" class="form-control select2_el">
                                    <option value="" hidden>Select Project</option>
                                    @foreach ($project_name as $proj)
                                    <option value="{{$proj->id}}" @if($t_data->project_id == $proj->id)
                                        {{'selected'}} @endif>
                                        {{($proj->name)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">

                                <label for="selectSm" class="form-control-label">Description</label>
                                <textarea class="form-control" id="description{{$key}}" rows="2"
                                    name="description[]">{{$t_data->description}}</textarea>
                            </div>


                            <div class="col-md-2">
                                <label for="selectSm" class="form-control-label">Hour</label>
                                <input type="text" id="hours{{$key}}" name="hours[]" class="form-control"
                                    value="{{$t_data->hours}}">
                            </div>
                            <div class="col-md-2">
                                <label for="selectSm" class="form-control-label">Minutes</label>
                                <select name="minutes[]" id="minutes{{$key}}" class="form-control">
                                    <option value="" hidden>Select Minutes</option>
                                    <option @if($t_data->minutes=='0'){{'selected'}} @endif
                                        value="0">0</option>
                                    <option @if($t_data->minutes=='10'){{'selected'}} @endif
                                        value="10">10</option>
                                    <option @if($t_data->minutes=='20'){{'selected'}} @endif
                                        value="20">20</option>
                                    <option @if($t_data->minutes=='30'){{'selected'}} @endif
                                        value="30">30</option>
                                    <option @if($t_data->minutes=='40'){{'selected'}} @endif
                                        value="40">40</option>
                                    <option @if($t_data->minutes=='50'){{'selected'}} @endif
                                        value="50">50</option>

                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="selectSm" class="form-control-label">Task Status</label>
                                <select name="task_status[]" id="task_status{{$key}}" class="form-control">
                                    <option value="" hidden>Select Task Status</option>
                                    <option @if($t_data->task_status=='Pending'){{'selected'}} @endif
                                        value="Pending">Pending</option>
                                    <option @if($t_data->task_status=='In Progress'){{'selected'}} @endif
                                        value="In Progress">In Progress</option>
                                    <option @if($t_data->task_status=='Complete'){{'selected'}} @endif
                                        value="Complete">Complete</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="hidden" name="resoure_rowcnt" id="resoure_rowcnt" value="{{$rowid}}">
                                @if(count($TimesheetData)==($rowid+1))
                                <button class="btn-primary" style="margin-top:51%;" type="button"
                                    onClick="addresourec()">
                                    <i class="fa fa-plus"></i> </button>
                                @endif
                            </div>
                        </div>

                        <hr/>
                        </div>
                        @php
                            $rowid=$rowid+1;
                        @endphp
                        @endforeach
                    </div>
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-danger btn-sm" style="position: relative;left: 816px;"
                        name="draft">Draft
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm" style="position: relative;left: 816px;"
                        name="submit">Submit
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<div class="clearfix"></div>
@endsection
@section('pagecss')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
@endsection
@section('scripts')
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    initailizeSelect2();
});
// Initialize select2
function initailizeSelect2() {

    $(".select2_el").select2();
}
</script>
<script>
function addresourec() {

    var rowid = $('#resoure_rowcnt').val();
    var incrowid = eval(rowid) + 1;
    var resHTML = '<div class="rowresource" id="' +
        incrowid +
        '"><div class="row"><div class="col-12 col-md-2"><label for="">Project Name</label><select name="project_id[]" id="project_id' +
        incrowid +
        '" required class="form-control select2_el"><option value="">Select Project</option>  @foreach ($project_name as $emp1) <option value="{{$emp1->id}}">{{($emp1->name)}}</option> @endforeach </select></div><div class="col-12 col-md-3"><label for="">Description</label><textarea type="text" step="any" name="description[]" rows="1" required id="description' +
        incrowid +
        '" class="form-control" value=""></textarea></div><div class="col-12 col-md-2"><label for="">Hour</label><input type="text" step="any" name="hours[]" required id="hours' +
        incrowid +
        '" class="form-control" value=""></div><div class="col-12 col-md-2"><label for="">Minutes</label><select name="minutes[]" id="minutes' +
        incrowid +
        '" required class="form-control"><option value="">Select Minutes</option><option value="0">0</option><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option></select></div><div class="col-12 col-md-2"><label for="">Task Status</label><select name="task_status[]" id="task_status' +
        incrowid +
        '" required class="form-control"><option value="">Select Task Status</option><option value="Pending">Pending</option><option value="In Progress">In Progress</option><option value="Complete">Complete</option></select></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;padding-left: 10px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="addresourec()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonResource" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div><hr/></div>';

    $("#dynamic_row_resource").append(resHTML);
    $('#resoure_rowcnt').val(incrowid);

}

$(document).on('click', '.deleteButtonResource', function() {
    // alert("click");
    $(this).closest("div.rowresource").remove();
});

function showfield(el) {
    if (el.value == 'Other') {
        document.getElementById('others').style.display = 'block';
    } else {
        document.getElementById('others').style.display = 'none';
    }
}
</script>
@endsection