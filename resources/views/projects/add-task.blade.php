@extends('projects.layouts.master')

@section('title')
QOLARIS - Projects Module
@endsection

@section('content')

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="tab-content">
            <div class="animated fadeIn">
                <div class="main-card task-form">
                    <div class="card">
                        <div class="aply-lv">
                            <h5 class="card-title pull-left">Create New Task Information - {{$task->name}}</h5>
                            <a class="btn btn-default pull-right"
                                href="{{url('projects/edit-project/'.$project_id)}}">Back</a>
                        </div>
                        <div class="card-body card-block">

                            <form action="{{ url('projects/save-task') }}" method="post" enctype="multipart/form-data"
                                class="form-horizontal">
                                {{csrf_field()}}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                                @php
                                $rowid=0;
                                @endphp

                                <div id="dynamic_row_resource">
                                    <div class="row rowresource" id="<?php echo $rowid; ?>">
                                        <div class="col-12 col-md-4" style="padding-left: 4%;">
                                            <div class="form-group">
                                                <label for="password-input" class="form-control-label">Employee Name
                                                </label>
                                                <select name="employee_id[]" id="employee_id{{$rowid}}"
                                                    class="form-control select2_el" required>
                                                    <option value="" hidden>Select Employee</option>
                                                    @foreach ($emplist as $emp)
                                                    <option value="{{$emp->emp_code}}" @if(isset($employee_id) &&
                                                        $employee_id==$emp->
                                                        emp_code ) selected @endif>
                                                        {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3" style="padding-left: 0%;">
                                            <div class="form-group">
                                                <label for="password-input" class="sform-control-label">Assigned By
                                                </label>
                                                <select name="assigned_by[]" id="assigned_by{{$rowid}}"
                                                    class="form-control select2_el" required>
                                                    <option value="" hidden>Select Assigned</option>
                                                    @foreach ($emplist as $emp)
                                                    <option value="{{$emp->emp_code}}" @if(isset($employee_id) &&
                                                        $employee_id==$emp->
                                                        emp_code ) selected @endif>
                                                        {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="selectSm" class="sform-control-label">Task
                                                    Description</label>
                                                <input type="text" id="task_description{{$rowid}}"
                                                    name="task_description[]" class="form-control" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-1">
                                            <div class="form-group">

                                                <button class="btn-primary" style="margin-top:90%;" type="button"
                                                    onClick="addresourec()">
                                                    <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="resoure_rowcnt" id="resoure_rowcnt" value="{{$rowid}}">
                                    <button type="submit" class="btn btn-primary pull-right"
                                        style="position: relative;">Save
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
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
$(document).on('click', '.savebutton', function() {
    //alert("click");
    var p_name = $('#name').val();
    var p_client_id = $('#client_id').val();
    var p_owner_id = $('#owner_id').val();
    var p_start_date = $('#start_date').val();
    var p_end_date = $('#end_date').val();
    var p_project_code = $('#project_code').val();
    var p_actual_start_date = $('#actual_start_date').val();
    var p_actual_end_date = $('#actual_end_date').val();
    var p_contract_cost = $('#contract_cost').val();
    var p_closure_date = $('#closure_date').val();
    var p_closure_certificate = $('#closure_certificate').val();
    var p_description = $('#description').val();
    var p_status = $('#status').val();


    if (p_name != '' && p_client_id != '' && p_owner_id != '' && p_project_code != '') {
        $('.first-form').hide();
        $('.second-form').show();

        $('.first-button').removeClass('active');
        $('.second-button').addClass('active');


    } else {
        alert('Please fill all the required fields , then Proceed!');
    }
})


function adddoucment() {

    var rowid = $('#produce_rowcnt').val();
    var incrowid = eval(rowid) + 1;
    var resHTML = "<div class='row rowproduce' id='" + incrowid;
    resHTML +=
        "'><div class='col-md-4'><label for=''>Document Name</label><input type='text' name='document_name[]' required id='document_name";
    resHTML += incrowid +
        "' class='form-control' value=''></div><div class='col-md-4'><label for=''>Document File</label><input type='file'  name='document_file[]' id='document_file";
    resHTML += incrowid +
        "' class='form-control' value=''></div><div class='col-md-1' style='display: inline-flex;margin-top: 15px;'><button class='btn btn-primary btn-sm' style='margin: 15px 5px;'  type='button' onClick='addresourec()'> <i class='fa fa-plus'> </i> </button><button class='btn btn-danger btn-sm deleteButtonProduce' style='margin: 15px 5px;background-color:red;' type='button'><i class='fa fa-minus'></i> </button></div></div>";

    $("#dynamic_row_produce").append(resHTML);
    $('#produce_rowcnt').val(incrowid);

}

$(document).on('click', '.deleteButtonProduce', function() {
    // alert("click");
    $(this).closest("div.rowproduce").remove();
});

function addresourec() {
    var rowid = $('#resoure_rowcnt').val();
    var incrowid = eval(rowid) + 1;
    //alert(rowid);
    $.ajax({
        url: "{{url('projects/get-add-row-item-task-new')}}/" + rowid,
        type: "GET",
        success: function(response) {
            $("#dynamic_row_resource").append(response);
            $('#resoure_rowcnt').val(incrowid);
            $(".select2_el").select2();
        }
    });
}
/*
function addresourec() {

    var rowid = $('#resoure_rowcnt').val();
    var incrowid = eval(rowid) + 1;
    var resHTML = '<div class="row rowresource" id="' + incrowid +        '"><div class="col-12 col-md-3"><label for="">Employee Name</label><select name="employee_id[]" id="employee_id' +        incrowid +
        '" required class="form-control"><option value="">Select Employee</option>  @foreach ($emplist as $emp) <option value="{{$emp->emp_code}}">{{($emp->emp_fname . '
    '. $emp->emp_mname.'
    '.$emp->emp_lname)}}</option> @endforeach </select></div><div class="col-12 col-md-3"><label for="">Assigned By</label><select name="assigned_by[]" id="assigned_by' +
    incrowid +
        '" required class="form-control"><option value="">Select Assigned</option>  @foreach ($emplist as $emp) <option value="{{$emp->emp_code}}">{{($emp->emp_fname . '
    '. $emp->emp_mname.'
    '.$emp->emp_lname)}}</option> @endforeach </select></div><div class="col-12 col-md-3"><label for="">Task Json</label><input type="text" step="any" name="task_json[]" required id="task_json' +
    incrowid +
        '" class="form-control" value=""></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;padding-left: 10px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="addresourec()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonResource" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

    $("#dynamic_row_resource").append(resHTML);
    $('#resoure_rowcnt').val(incrowid);

}
*/
$(document).on('click', '.deleteButtonResource', function() {
    // alert("click");
    $(this).closest("div.rowresource").remove();
});


$(document).on('click', '.four-button', function() {
    $('.second-form').hide();
    $('.first-form').hide();
    $('.third-form').hide();
    $('.four-form').show();

    $('.second-button').removeClass('active');
    $('.first-button').removeClass('active');
    $('.third-button').removeClass('active');
    $('.four-button').addClass('active');
});


$('#end_date').on('change', function() {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    if (endDate < startDate) {
        // alert('End date should be greater than Start date.');
        Swal.fire('End date should be greater than Start date !');
        $('#end_date').val('');
    }
});

$('#actual_end_date').on('change', function() {
    var startDate = $('#actual_start_date').val();
    var endDate = $('#actual_end_date').val();
    if (endDate < startDate) {
        // alert('Actual End date should be greater than Actual Start date.');
        Swal.fire('Actual End date should be greater than Actual Start date !');
        $('#actual_end_date').val('');
    }
});

$(document).on('change', '#owner_id, #client_id', function() {
    var expclientId = $('#client_id').val().split('~');;
    var clientId = expclientId[1];
    var clientType = expclientId[0];
    var ownerId = $('#owner_id').val();
    var year = new Date().getFullYear();
    // alert(expclientId[0]);
    if (clientId != '' && clientType != '' && ownerId != '') {
        var project_id = clientType + '/' + clientId + '/' + year + '/' + ownerId;
    } else {
        var project_id = '';
    }

    $('#project_code').val(project_id);

});
</script>
@endsection