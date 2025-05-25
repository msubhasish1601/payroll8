@extends('projects.layouts.master')

@section('title')
QOLARIS - Projects Module
@endsection
@section('content')
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Create New Project Information</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="{{ url('projects/vw-project') }}">Projects</a></li>
                        <li>/</li>
                        <li class="active">Create New Project Information</li>

                    </ul>
                </span>
            </div>
        </div>
        <div class="tab-nav">
            <ul class="nav nav-tabs mt-0">

                <li class="nav-item">
                    <a class="nav-link first-button active" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link second-button disabled" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Document</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link third-button disabled" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Resource</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link four-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Task</a>
                </li> -->
            </ul>
        </div>

        <div class="tab-content">
            <div class="main-card first-form">
                <div class="card ">
                    <div class="card-body card-block">
                        <form action="{{ url('projects/save-project') }}" method="post" enctype="multipart/form-data"
                            class="form-horizontal">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="sform-control-label">Project Name
                                            <!-- <span class="error">(*)</span> -->
                                        </label>
                                        <input type="text" required id="name" name="name" class="form-control" value="">
                                        @if ($errors->has('name'))
                                        <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="client_id" class="sform-control-label">Client
                                        </label>
                                        <select name="client_id" id="client_id" class="form-control select2_el"
                                            required>
                                            <option value="" hidden>Select Client</option>
                                            @foreach ($clientlist as $emp)
                                            <option
                                                value="@if($emp->type == 'Public'){{'G'}}@elseif($emp->type == 'Private'){{'P'}}@endif{{'~'}}{{$emp->id}}"
                                                @if(isset($id)) selected @endif>
                                                {{($emp->name)}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="owner_id" class="sform-control-label">Owner
                                        </label>
                                        <select name="owner_id" id="owner_id" class="form-control select2_el" required>
                                            <option value="" hidden>Select Owner</option>
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

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="selectSm" class="sform-control-label"> Start Date</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="end_date" class="sform-control-label"> End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="project_code" class="sform-control-label"> Project Code</label>
                                        <input type="text" id="project_code" name="project_code" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="actual_start_date" class="form-control-label">Actual Start
                                            Date</label>
                                        <input type="date" id="actual_start_date" name="actual_start_date"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="actual_end_date" class="form-control-label">Actual End Date</label>
                                        <input type="date" id="actual_end_date" name="actual_end_date"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="contract_cost" class="form-control-label">Contract Cost</label>
                                        <input type="number" step="any" id="contract_cost" name="contract_cost"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="allotted_hours" class=" form-control-label">Allotted Hours</label>
                                        <input type="number" step="any" id="allotted_hours" name="allotted_hours"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="closure_date" class="form-control-label">Closure Date</label>
                                        <input type="date" id="closure_date" name="closure_date" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="closure_certificate" class="form-control-label">Closure
                                            Certificate</label>
                                        <input type="file" id="closure_certificate" name="closure_certificate"
                                            class="form-control" value="">
                                    </div>
                                </div>


                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="status" class="form-control-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="" hidden>Select Type</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                            <option value="3">Closed</option>
                                            <option value="4">Cancelled</option>
                                            <option value="5">Hold</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-control-label">Description</label>
                                        <textarea class="form-control" id="description" rows="3"
                                            name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right"
                                        style="position: relative;">Save
                                    </button>

                                </div>
                            </div>

                        </form>
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


    if (p_name != '' && p_client_id != '' && p_owner_id != '' &&
        p_start_date != '' && p_end_date !=
        '' && p_project_code != '' && p_actual_start_date != '' &&
        p_actual_end_date != '' && p_contract_cost !=
        '' && p_closure_date != '' && p_closure_certificate != '' &&
        p_description != '' && p_status != ''
    ) {
        $('.first-form').hide();
        $('.second-form').show();

        $('.first-button').removeClass('active');
        $('.second-button').addClass('active');


    } else {
        alert('Please fill all the fields , then Proceed!');
    }
})
</script>
<script>
function adddoucment() {

    var rowid = $('#produce_rowcnt').val();
    var incrowid = eval(rowid) + 1;
    var resHTML = '<div class="row rowproduce" id="' + incrowid +
        '"><div class="col-md-4"><label for="">Document Name</label><input type="text" step="any" name="document_name[]" required id="document_name' +
        incrowid +
        '" class="form-control" value=""></div><div class="col-md-4"><label for="">Document File</label><input type="file"  name="document_file[]" id="document_file' +
        incrowid +
        '" class="form-control" value=""></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="adddoucment()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonProduce" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

    $("#dynamic_row_produce").append(resHTML);
    $('#produce_rowcnt').val(incrowid);

}

$(document).on('click', '.deleteButtonProduce', function() {
    // alert("click");
    $(this).closest("div.rowproduce").remove();
});

$(document).on('click', '.first-button', function() {
    $('.second-form').hide();
    $('.first-form').show();

    $('.second-button').removeClass('active');
    $('.first-button').addClass('active');
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

$(document).on('change', '#owner_id,#client_id', function() {
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
