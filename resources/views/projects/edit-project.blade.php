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
                <h5 class="card-title">Modify Project Information</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="{{ url('projects/vw-project') }}">Projects</a></li>
                        <li>/</li>
                        <li class="active">Modify Project Information</li>

                    </ul>
                </span>
            </div>
        </div>
        @include('include.messages')
        <!-- <div class="tab-nav">
            <ul class="nav nav-tabs mt-0">

                <li class="nav-itemc">
                    <a class="nav-link first-button  active" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link second-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link third-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link four-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Allocate Task</a>
                </li>
            </ul>
        </div> -->
        @include('projects.partials.project-tabs')
        <div class="tab-content">
            <div class="animated fadeIn">
                <div class="main-card first-form">
                    <div class="card">
                        <div class="card-body card-block">
                            <form action="{{ url('projects/update-project') }}" method="post"
                                enctype="multipart/form-data" class="form-horizontal">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="<?php echo $ProjectData->id; ?>">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name" class=" form-control-label">Project Name
                                            </label>
                                            <input type="text" required id="name" name="name" class="form-control"
                                                value="{{$ProjectData->name}}">
                                            @if ($errors->has('name'))
                                            <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="client_id" class=" form-control-label">Client
                                            </label>
                                            <select name="client_id" id="client_id" class="form-control select2_el">
                                                <option value="" hidden>Select Client</option>
                                                @foreach ($clientlist as $emp)
                                                <option
                                                    value="@if($emp->type == 'Public'){{'G'}}@elseif($emp->type == 'Private'){{'P'}}@endif{{'~'}}{{$emp->id}}"
                                                    @if(isset($id)) selected @endif @if($ProjectData->client_id ==
                                                    $emp->id)
                                                    {{'selected'}} @endif>
                                                    {{($emp->name)}}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="owner_id" class=" form-control-label">Owner
                                            </label>
                                            <select name="owner_id" id="owner_id" class="form-control select2_el">
                                                <option value="" hidden>Select Owner</option>
                                                @foreach ($emplist as $emp)
                                                <option value="{{$emp->emp_code}}" @if(isset($employee_id) &&
                                                    $employee_id==$emp->
                                                    emp_code ) selected @endif @if($ProjectData->owner_id ==
                                                    $emp->emp_code)
                                                    {{'selected'}} @endif>
                                                    {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}}
                                                </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="project_code" class=" form-control-label"> Project Code</label>
                                            <input type="text" id="project_code" name="project_code"
                                                class="form-control" value="{{$ProjectData->project_code}}" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="start_date" class=" form-control-label"> Start Date</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control"
                                                value="{{$ProjectData->start_date}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="end_date" class=" form-control-label"> End Date</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control"
                                                value="{{$ProjectData->end_date}}">
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="actual_start_date" class=" form-control-label">Actual Start
                                                Date</label>
                                            <input type="date" id="actual_start_date" name="actual_start_date"
                                                class="form-control" value="{{$ProjectData->actual_start_date}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="actual_end_date" class=" form-control-label">Actual End
                                                Date</label>
                                            <input type="date" id="actual_end_date" name="actual_end_date"
                                                class="form-control" value="{{$ProjectData->actual_end_date}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="contract_cost" class=" form-control-label">Contract Cost</label>
                                            <input type="number" step="any" id="contract_cost" name="contract_cost"
                                                class="form-control" value="{{$ProjectData->contract_cost}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="allotted_hours" class=" form-control-label">Allotted
                                                Hours</label>
                                            <input type="number" step="any" id="allotted_hours" name="allotted_hours"
                                                class="form-control" value="{{$ProjectData->allotted_hours}}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="closure_date" class=" form-control-label">Closure Date</label>
                                            <input type="date" id="closure_date" name="closure_date"
                                                class="form-control" value="{{$ProjectData->closure_date}}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="closure_certificate" class=" form-control-label">Closure
                                                Certificate</label>
                                            <input type="file" id="closure_certificate" name="closure_certificate"
                                                class="form-control" value="{{$ProjectData->closure_certificate}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="status" class=" form-control-label"> Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="" hidden>Select Type</option>
                                                <option @if($ProjectData->status==0){{'selected'}} @endif
                                                    value="0">Pending
                                                </option>
                                                <option @if($ProjectData->status==1){{'selected'}} @endif
                                                    value="1">Active
                                                </option>
                                                <option @if($ProjectData->status==2){{'selected'}} @endif
                                                    value="2">Inactive
                                                </option>
                                                <option @if($ProjectData->status==3){{'selected'}} @endif
                                                    value="3">Closed
                                                </option>
                                                <option @if($ProjectData->status==4){{'selected'}} @endif
                                                    value="4">Cancelled
                                                </option>
                                                <option @if($ProjectData->status==5){{'selected'}} @endif value="5">Hold
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="description" class=" form-control-label">Description</label>
                                            <textarea class="form-control" id="description" rows="3"
                                                name="description">{{$ProjectData->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <button type="submit" class="btn btn-primary pull-right"
                                            style="position: relative;">Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="main-card second-form" style="display:none;">
                    <div class="card">
                        <div class="card-body card-block">
                            <form action="{{ url('projects/update-project') }}" method="post"
                                enctype="multipart/form-data" class="form-horizontal">
                                {{csrf_field()}}
                                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                <div id="dynamic_row_produce">
                                    @php
                                    $rowid = 0;
                                    $countProjectDocs = count($ProjectDocument);
                                    @endphp
                                    @if ($countProjectDocs!=0)

                                    @foreach($ProjectDocument as $doc)
                                    <div class="row rowproduce" id="<?php echo $rowid; ?>">
                                        <div class="col-12 col-md-4">
                                            <label for="selectSm" class="form-control-label">Document Name</label>
                                            <input type="hidden" name="document_id[]" id="document_id{{$rowid}}"
                                                value="{{$doc->id}}">
                                            <input type="text" id="document_name{{$rowid}}" name="document_name[]"
                                                class="form-control" value="{{$doc->document_name}}">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="selectSm" class="form-control-label">Document File</label>
                                            <input type="file" id="document_file{{$rowid}}" name="document_file[]"
                                                class="form-control" value="">


                                        </div>
                                        <div class="col-md-2">
                                            @if($doc->document_file!='')

                                            <a href="{{ asset($doc->document_file) }}" target="_blank" download>
                                                <img alt="download" src="{{asset('img/download_icon2.png')}}"
                                                    style="margin: 35px 0 0 0;width:25px;" />
                                            </a>

                                            @endif
                                        </div>
                                        <?php $rowid++;?>



                                        @if ($rowid==($countProjectDocs))
                                        <div class="col-12 col-md-2">
                                            <input type="hidden" name="produce_rowcnt" id="produce_rowcnt"
                                                value="{{$rowid}}">
                                            <button class="btn-primary" style="margin-top: 11%;padding: 3px;"
                                                type="button" onClick="adddoucment()">
                                                <i class="fa fa-plus"></i> </button>
                                        </div>

                                        @endif

                                    </div>
                                    @endforeach
                                    @endif
                                    @if ($countProjectDocs==0)
                                    <div class="row rowproduce" id="<?php echo $rowid; ?>">
                                        <div class="col-12 col-md-4">
                                            <label for="selectSm" class="form-control-label">Document Name</label>
                                            <input type="text" id="document_name{{$rowid}}" name="document_name[]"
                                                class="form-control" value="">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="selectSm" class="form-control-label">Document File</label>
                                            <input type="file" id="document_file{{$rowid}}" name="document_file[]"
                                                class="form-control" value="">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <input type="hidden" name="produce_rowcnt" id="produce_rowcnt"
                                                value="{{$rowid}}">
                                            <button class="btn-primary" style="margin-top: 11%;padding: 3px;"
                                                type="button" onClick="adddoucment()">
                                                <i class="fa fa-plus"></i> </button>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        style="position: relative;left: 770px;">Save & Upload
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="main-card third-form" id="third-form" style="display:none;">
                    <div class="card">
                        <div class="aply-lv">
                            <a href="{{ url('projects/add-resource/'.$project_id)}}"
                                class="btn btn-default add-resource">Add New
                                Resource <i class="fa fa-plus"></i></a>
                        </div>
                        <div class="card-body card-block">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Project Name</th>
                                            <th>Employee Name</th>
                                            <th>IsBillable</th>
                                            <th>Billable Percent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($resource) && !empty($resource))
                                        @foreach($resource as $project)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->project_name }}</td>
                                            <td>{{ $project->emp_fname }} {{ $project->emp_lname }}</td>
                                            <td>{{ $project->is_billable }}</td>
                                            <td>{{ $project->billable_percent }}</td>
                                            <td><a class="link del-record" data-id="{{$project->id}}"
                                                    href="javascript:void(0)" title="Delete"> <i
                                                        class="fa fa-trash text-red"></i> </a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="main-card four-form" style="display:none;">
                    <div class="card">
                        <div class="aply-lv">
                            <a href="{{ url('projects/add-task/'.$project_id) }}" class="btn btn-default add-task">Add
                                New
                                Task <i class="fa fa-plus"></i></a>
                        </div>
                        <div class="card-body card-block">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Project Name</th>
                                            <th>Employee Name</th>
                                            <th>Assigned By</th>
                                            <th>Task</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($task) && !empty($task))
                                        @foreach($task as $project_task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project_task->project_name }}</td>
                                            <td>{{ $project_task->emp_fname }}
                                                {{ $project_task->emp_lname }}
                                            </td>
                                            <td>{{ $project_task->fname }} {{ $project_task->lname }}
                                            </td>
                                            <td>{{$project_task->task_description}}</td>
                                            <td>{{ date('d-m-Y h:i a',strtotime($project_task->created_at)) }}</td>
                                            <td><a class="link"
                                                    href="{{ url('projects/edit-task/'.$project_task->id) }}" title="Edit"> <i
                                                        class="fa fa-edit"></i> </a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
});

$('.del-record').on('click', function() {
    var id = $(this).attr("data-id");
    if (confirm("Sure of deleting the record?") == true) {
        window.location.href = "{{url('projects/delete-resource/')}}/" + id;
    }
});
// function destroyData(id){
//     if (confirm("Sure of deleting the record?") == true) {
//         window.location.href="{{url('projects/delete-resource/')}}/"+id;
//     }
// }
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
        '" class="form-control" value=""></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;"><button class="btn btn-primary btn-sm" style="margin: 15px 0px;"  type="button" onClick="adddoucment()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonProduce" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

    $("#dynamic_row_produce").append(resHTML);
    $('#produce_rowcnt').val(incrowid);

}

$(document).on('click', '.deleteButtonProduce', function() {
    // alert("click");
    $(this).closest("div.rowproduce").remove();
});

// $(document).on('click', '.add-resource', function() {
//     $('.first-form').hide();
//     $('.second-form').hide();
//     $('.third-form').hide();
//     $('.assign-form').show();

//     $('.first-button').removeClass('active');
//     $('.second-button').removeClass('active');
//     $('.third-button').addClass('active');
// });

$(document).on('click', '.first-button', function() {
    $('.second-form').hide();
    $('.third-form').hide();
    $('.four-form').hide();
    $('.first-form').show();

    $('.second-button').removeClass('active');
    $('.third-button').removeClass('active');
    $('.four-button').removeClass('active');
    $('.first-button').addClass('active');
});

$(document).on('click', '.second-button', function() {
    $('.first-form').hide();
    $('.third-form').hide();
    $('.four-form').hide();
    $('.second-form').show();

    $('.first-button').removeClass('active');
    $('.third-button').removeClass('active');
    $('.four-button').removeClass('active');
    $('.second-button').addClass('active');
});

$(document).on('click', '.third-button', function() {
    $('.first-form').hide();
    $('.second-form').hide();
    $('.four-form').hide();
    $('.third-form').show();

    $('.first-button').removeClass('active');
    $('.second-button').removeClass('active');
    $('.four-button').removeClass('active');
    $('.third-button').addClass('active');
});

$(document).on('click', '.four-button', function() {
    $('.first-form').hide();
    $('.second-form').hide();
    $('.third-form').hide();
    $('.four-form').show();

    $('.first-button').removeClass('active');
    $('.second-button').removeClass('active');
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