@extends('projects.layouts.master')

@section('title')
BELLEVUE - Projects Module
@endsection

@section('sidebar')
@include('projects.partials.sidebar')
@endsection

@section('header')
@include('projects.partials.header')
@endsection

@section('scripts')
@include('projects.partials.scripts')
@endsection

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<div class="content">

    <!-- Animated -->
    <div>
        <div class="tab-nav">
            <ul class="nav nav-tabs mt-0">

                <li class="nav-item ">
                    <a class="nav-link first-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Project</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link second-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Document</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link third-button active" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Resource</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link four-button " href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Task</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="animated fadeIn">
            {{--    <div class="main-card first-form">
                <div class="card ">
                    <div class="card-header">
                        <div class="row" style="border:none;">
                            <div class="col-md-6" style="padding: 10px 0px 10px 30px;">
                                <h5 class="card-title">Create New Project Information</h5>
                            </div>
                            <div class="col-md-6" style="padding: 10px 30px;">

                                <span class="right-brd" style="padding-right:15x;">
                                    <ul class="">
                                        <li><a href="#">Project</a></li>
                                        <li>/</li>
                                        <li class="active">Create New Project Information</li>

                                    </ul>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body card-block">

            <form action="{{ url('projects/update-project') }}" method="post" enctype="multipart/form-data"
            class="form-horizontal">
            {{csrf_field()}}

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="<?php echo $ProjectData->id; ?>">

            <div class="row form-group">
                <div class="col-12 col-md-4">
                    <label for="email-input" class=" form-control-label" required>Project Name
                        <!-- <span class="error">(*)</span> -->
                    </label>
                    <input type="text" required id="name" name="name" class="form-control"
                        value="{{$ProjectData->name}}">
                    @if ($errors->has('name'))
                    <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Client
                    </label>
                    <select name="client_id" id="client_id" class="form-control">
                        <option value="" hidden>Select Client</option>
                        @foreach ($clientlist as $emp)
                        <option
                            value="@if($emp->type == 'Public'){{'G'}}@elseif($emp->type == 'Private'){{'P'}}@endif{{'~'}}{{$emp->id}}"
                            @if(isset($id)) selected @endif @if($ProjectData->client_id == $emp->id)
                            {{'selected'}} @endif>
                            {{($emp->name)}}
                        </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label for="password-input" class=" form-control-label">Owner
                    </label>
                    <select name="owner_id" id="owner_id" class="form-control">
                        <option value="" hidden>Select Owner</option>
                        @foreach ($emplist as $emp)
                        <option value="{{$emp->emp_code}}" @if(isset($employee_id) && $employee_id==$emp->
                            emp_code ) selected @endif @if($ProjectData->owner_id == $emp->emp_code)
                            {{'selected'}} @endif>
                            {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}}
                        </option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label"> Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                        value="{{$ProjectData->start_date}}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label"> End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control"
                        value="{{$ProjectData->end_date}}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label"> Project Code</label>
                    <input type="text" id="project_code" name="project_code" class="form-control"
                        value="{{$ProjectData->project_code}}" required readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Actual Start Date</label>
                    <input type="date" id="actual_start_date" name="actual_start_date" class="form-control"
                        value="{{$ProjectData->actual_start_date}}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Actual End Date</label>
                    <input type="date" id="actual_end_date" name="actual_end_date" class="form-control"
                        value="{{$ProjectData->actual_end_date}}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Contract Cost</label>
                    <input type="text" id="contract_cost" name="contract_cost" class="form-control"
                        value="{{$ProjectData->contract_cost}}" required>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Closure Date</label>
                    <input type="date" id="closure_date" name="closure_date" class="form-control"
                        value="{{$ProjectData->closure_date}}">
                </div>

                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Closure Certificate</label>
                    <input type="file" id="closure_certificate" name="closure_certificate" class="form-control"
                        value="{{$ProjectData->closure_certificate}}">
                </div>
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label">Description</label>
                    <textarea class="form-control" id="description" rows="3"
                        name="description">{{$ProjectData->description}}</textarea>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-4">
                    <label for="selectSm" class=" form-control-label"> Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="" hidden>Select Type</option>
                        <option @if($ProjectData->status==0){{'selected'}} @endif value="0">Pending
                        </option>
                        <option @if($ProjectData->status==1){{'selected'}} @endif value="1">Active
                        </option>
                        <option @if($ProjectData->status==2){{'selected'}} @endif value="2">Inactive
                        </option>
                        <option @if($ProjectData->status==3){{'selected'}} @endif value="3">Closed
                        </option>
                        <option @if($ProjectData->status==4){{'selected'}} @endif value="4">Cancelled
                        </option>
                        <option @if($ProjectData->status==5){{'selected'}} @endif value="5">Hold
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <button type="submit" class="btn btn-danger btn-sm" style="position: relative;left: 850px;">Update
            </button>
        </div>
        </form>

    </div>
</div>
<div class="main-card second-form">
    <div class="card">
        <div class="card-header">
            <div class="row" style="border:none;">
                <div class="col-md-6" style="padding: 10px 0px 10px 30px;">
                    <h5 class="card-title">Create New Project Documents Information</h5>
                </div>
                <div class="col-md-6" style="padding: 10px 30px;">

                    <span class="right-brd" style="padding-right:15x;">
                        <ul class="">
                            <li><a href="#">Project Documents</a></li>
                            <li>/</li>
                            <li class="active">Create New Project Documents Information</li>

                        </ul>
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body card-block">
            <form action="{{ url('projects/update-project')}}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                {{csrf_field()}}

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @php
                $rowid=0;
                @endphp
                <div id="dynamic_row_produce">
                    <div class="row rowproduce" id="<?php echo $rowid; ?>">
                        <div class="col-12 col-md-4">
                            <label for="selectSm" class="form-control-label">Document Name</label>
                            <input type="text" id="document_name{{$rowid}}" name="document_name[]" class="form-control"
                                value="">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="selectSm" class="form-control-label">Document File</label>
                            <input type="file" id="document_file{{$rowid}}" name="document_file[]" class="form-control"
                                value="">
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="hidden" name="produce_rowcnt" id="produce_rowcnt" value="{{$rowid}}">
                            <button class="btn-primary" style="margin-top:10%;" type="button" onClick="adddoucment()">
                                <i class="fa fa-plus"></i> </button>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>

                <div class="card-body">
                    <button type="submit" class="btn btn-danger btn-sm" style="position: relative;left: 770px;">Save &
                        Upload
                    </button>
                </div>
            </form>

        </div>
    </div>
</div> --}}
<div class="main-card assign-form">
    <div class="card ">
        <div class="card-header">
            <div class="row" style="border:none;">
                <div class="col-md-6" style="padding: 10px 0px 10px 30px;">
                    <h5 class="card-title">Create New Resource Information</h5>
                </div>
                <div class="col-md-6" style="padding: 10px 30px;">

                    <span class="right-brd" style="padding-right:15x;">
                        <ul class="">
                            <li><a href="#">Resource</a></li>
                            <li>/</li>
                            <li class="active">Create New Resource Information</li>

                        </ul>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body card-block">

            <form action="{{ url('projects/save-resource')}}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                {{csrf_field()}}

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                @php
                $rowid=0;
                @endphp
                <div class="row form-group">
                    <div class="col-12 col-md-6">
                        <label for="email-input" class="sform-control-label" required>Project Name
                            <!-- <span class="error">(*)</span> -->
                        </label>
                        <input type="text" readonly id="project_id" name="project_name" class="form-control"
                            value="<?php echo $resource->name; ?>">
                        @if ($errors->has('name'))
                        <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div id="dynamic_row_resource">
                    <div class="row rowresource" id="<?php echo $rowid; ?>">
                        <div class="row form-group">
                            <div class="col-12 col-md-4" style="padding-left: 5%;">
                                <label for="password-input" class="sform-control-label">Employee Name
                                </label>
                                <select name="employee_id[]" id="employee_id{{$rowid}}" class="form-control" required>
                                    <option value="" hidden>Select Employee</option>
                                    @foreach ($emplist as $emp)
                                    <option value="{{$emp->emp_code}}" @if(isset($employee_id) && $employee_id==$emp->
                                        emp_code ) selected @endif>
                                        {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label>Is Billable</label><br>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        &nbsp;Yes&nbsp;<input type="radio" class="form-check-input" name="is_billable[]"
                                            value="yes" id="is_billable1{{$rowid}}">
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        &nbsp;No&nbsp;<input type="radio" class="form-check-input" name="is_billable[]"
                                            value="no" id="is_billable2{{$rowid}}">
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-3">
                                <label for="selectSm" class="sform-control-label">Billable Percent</label>
                                <input type="number" id="billable_percent{{$rowid}}" name="billable_percent[]"
                                    class="form-control" value="" required>
                            </div>

                            <div class="col-12 col-md-2">
                                <input type="hidden" name="resoure_rowcnt" id="resoure_rowcnt" value="{{$rowid}}">
                                <button class="btn-primary" style="margin-top:36%;" type="button"
                                    onClick="addresourec()">
                                    <i class="fa fa-plus"></i> </button>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-danger btn-sm add-resource"
                        style="position: relative;left: 813px;">Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
</div>
</div>

<div class="clearfix"></div>

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
        '" class="form-control" value=""></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="addresourec()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonProduce" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

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
    var resHTML = '<div class="row rowresource" id="' +
        incrowid +
        '"><div class="col-12 col-md-3"><label for="">Employee Name</label><select name="employee_id[]" id="employee_id' +
        incrowid +
        '" required class="form-control"><option value="">Select Employee</option>  @foreach ($emplist as $emp) <option value="{{$emp->emp_code}}">{{($emp->emp_fname .' '. $emp->emp_mname.' '.$emp->emp_lname)}}</option> @endforeach </select></div><div class="col-12 col-md-2"><label for="">Is Billable</label><br>Yes&nbsp;<input type="radio" value="yes" name="is_billable[' +
    incrowid + ']" id="is_billable1' +
        incrowid +
        '" >&nbsp;No&nbsp;<input type="radio" value="no" name="is_billable[' + incrowid + ']" id="is_billable2' +
        incrowid +
        '" ></div><div class="col-12 col-md-2"><label for="">Billable Percent</label><input type="number" step="any" name="billable_percent[]" required id="billable_percent' +
        incrowid +
        '" class="form-control" value=""></div><div class="col-md-2" style="display: inline-flex;margin-top: 15px;padding-left: 8px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="addresourec()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonResource" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

    $("#dynamic_row_resource").append(resHTML);
    $('#resoure_rowcnt').val(incrowid);

}

$(document).on('click', '.deleteButtonResource', function() {
    // alert("click");
    $(this).closest("div.rowresource").remove();
});


$(document).on('click', '.third-button', function() {
    $('.second-form').hide();
    $('.first-form').hide();
    $('.third-form').show();

    $('.second-button').removeClass('active');
    $('.first-button').removeClass('active');
    $('.third-button').addClass('active');
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