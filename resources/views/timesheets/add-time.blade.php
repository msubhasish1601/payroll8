@extends('timesheets.layouts.master')

@section('title')
QOLARIS - Timesheet Module
@endsection


@section('content')

<div class="content">

    <!-- Animated -->


    <div class="main-card ">
        <div class="card ">

            <div class="card-body card-block">

                <form  method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    {{csrf_field()}}

                    <!-- <input type="hidden" name="project_id" value=""> -->
                    @php
                    $rowid=0;
                    @endphp
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="email-input" class="sform-control-label" required>Date
                                <!-- <span class="error">(*)</span> -->
                            </label>
                            <input type="date" id="sheet_date" name="sheet_date" class="form-control" value="" required>
                            @if ($errors->has('sheet_date'))
                            <div class="error" style="color:red;">{{ $errors->first('sheet_date') }}</div>
                            @endif
                        </div>
                    </div>
                    <div id="dynamic_row_resource">
                        <div class="row rowresource" id="<?php echo $rowid; ?>">
                            <div class="col-md-3">
                                <label for="password-input" class="sform-control-label">Project Name
                                </label>
                                <select name="project_id[]" id="project_id{{$rowid}}" class="form-control" required>
                                    <option value="" hidden>Select Project</option>
                                    @foreach ($project_name as $emp1)
                                    <option value="{{$emp1->id}}" @if(isset($project_id) && $project_id==$emp1->
                                        id ) selected @endif>
                                        {{($emp1->name)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="selectSm" class="form-control-label">Description</label>
                                <textarea class="form-control" id="description{{$rowid}}" rows="2" name="description[]"></textarea>
                            </div>

                            <div class="col-md-2">
                                <label for="selectSm" class="form-control-label">Hour</label>
                                <input type="text" id="hours{{$rowid}}" name="hours[]" class="form-control" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="selectSm" class="form-control-label">Minutes</label>
                                <select name="minutes[]" id="minutes{{$rowid}}" class="form-control">
                                    <option value="" hidden>Select Minutes</option>
                                    <option value="0">0</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-md-12"></div>
                            <div class="col-md-3">
                                <label for="selectSm" class="form-control-label">Task Status</label>
                                <select name="task_status[]" id="task_status{{$rowid}}" class="form-control" required>
                                    <option value="" hidden>Select Task Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Complete">Complete</option>
                                </select>
                                <!-- <input type="text" id="type" name="type" class="form-control" value=""> -->
                            </div>

                            <div class="col-md-1">
                                <input type="hidden" name="resoure_rowcnt" id="resoure_rowcnt" value="{{$rowid}}">
                                <button class="btn-primary" style="margin-top:64%;" type="button"
                                    onClick="addresourec()">
                                    <i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                <button type="submit" class="btn btn-danger btn-sm" style="position: relative;left: 816px;"
                    name="draft" formaction="{{url('timesheets/save_draft-timesheets') }}">Draft
                </button>
                <button type="submit" class="btn btn-danger btn-sm" style="position: relative;left: 816px;"
                    name="submit" formaction="{{ url('timesheets/save_submit-timesheets') }}">Submit
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
<script type="text/javascript">
function addresourec() {

    var rowid = $('#resoure_rowcnt').val();
    var incrowid = eval(rowid) + 1;
    var resHTML = '<div class="row rowresource" id="' +
        incrowid +
        '"><div class="col-12 col-md-3"><label for="">Project Name</label><select name="project_id[]" id="project_id' +
        incrowid +
        '" required class="form-control"><option value="">Select Project</option>  @foreach ($project_name as $emp1) <option value="{{$emp1->id}}">{{($emp1->name)}}</option> @endforeach </select></div><div class="col-12 col-md-3"><label for="">Description</label><textarea type="text" step="any" name="description[]" rows="1" required id="description' +
        incrowid +
        '" class="form-control" value=""></textarea></div><div class="col-12 col-md-2"><label for="">Hour</label><input type="text" step="any" name="hours[]" required id="hours' +
        incrowid +
        '" class="form-control" value=""></div><div class="col-12 col-md-3"><label for="">Minutes</label><select name="minutes[]" id="minutes' +
        incrowid +
        '" required class="form-control"><option value="">Select Minutes</option><option value="0">0</option><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option></select></div><div class="col-12 col-md-3"><label for="">Task Status</label><select name="task_status[]" id="task_status' +
        incrowid +
        '" required class="form-control"><option value="">Select Task Status</option><option value="Pending">Pending</option><option value="In Progress">In Progress</option><option value="Complete">Complete</option></select></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;padding-left: 10px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="addresourec()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonResource" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

    $("#dynamic_row_resource").append(resHTML);
    $('#resoure_rowcnt').val(incrowid);

}

$(document).on('click', '.deleteButtonResource', function() {
    // alert("click");
    $(this).closest("div.rowresource").remove();
});


// $(document).on('change','.task',function(){
// var thisItem = $(this);
// var thisValue = $(this).val();
// // alert(thisValue);
// if(thisValue == 'Other'){
//     thisItem.closest('input.other').addClass();
// }else{
//     thisItem.closest('.other').hide();
// }
// });

function CheckColors(val){
 var element=document.getElementById('other');
 if(val=='Other')
   element.style.display='block';
 else
   element.style.display='none';
}

</script>

@endsection
