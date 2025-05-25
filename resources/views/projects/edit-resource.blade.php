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
                    <a class="nav-link first-button  active" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Project</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link second-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Document</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link third-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Resource</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link four-button" href="javascript:void(0)"><i
                            class="fas fa-layer-group mr-2"></i>Task</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="animated fadeIn">
            <div class="main-card first-form">
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
                                        <option value="{{$emp->emp_code}}" @if(isset($employee_id) &&
                                            $employee_id==$emp->
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
                                    <input type="date" id="actual_start_date" name="actual_start_date"
                                        class="form-control" value="{{$ProjectData->actual_start_date}}" required>
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
                                    <input type="file" id="closure_certificate" name="closure_certificate"
                                        class="form-control" value="{{$ProjectData->closure_certificate}}">
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
                        <button type="submit" class="btn btn-danger btn-sm"
                            style="position: relative;left: 850px;">Update
                        </button>
                    </div>
                    </form>

                </div>
            </div>
            <div class="main-card second-form" style="display:none;">
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
                        <form action="{{ url('projects/update-project') }}" method="post" enctype="multipart/form-data"
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
                                        <button class="btn-primary" style="margin-top:10%;" type="button"
                                            onClick="adddoucment()">
                                            <i class="fa fa-plus"></i> </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
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
            <div class="main-card third-form" style="display:none;">
                <div class="content">
                    <!-- Animated -->
                    <div class="animated fadeIn">
                        <div class="row" style="border:none;">
                            <div class="col-md-6">
                                <h5 class="card-title">Create New Resource Information</h5>
                            </div>
                            <div class="col-md-6">

                                <span class="right-brd" style="padding-right:15x;">
                                    <ul class="">
                                        <li><a href="#">Resource </a></li>

                                        <li>/</li>
                                        <li class="active">Create New Resource Information</li>

                                    </ul>
                                </span>
                            </div>
                        </div>
                        <!-- Widgets  -->
                        <div class="row">

                            <div class="main-card">
                                <div class="card">

                                    <div class="card-header">
                                        <div class="aply-lv">
                                            <a href="{{ url('projects/add-resource')}}"
                                                class="btn btn-default add-resource">Add New
                                                Resource <i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <!-- @if(Session::has('message'))resource
							<div class="alert alert-success"  projects/add-project style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif	 -->
                                    @include('include.messages')

                                    <br />
                                    <div class="clear-fix">
                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Project Name</th>
                                                    <th>Employee Name</th>
                                                    <th>IsBillable</th>
                                                    <th>Billable Percent</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{--  @foreach($projects_rs as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->project_code }}</td>
                                                <td>{{ $project->client_name }}</td>
                                                <td>{{ $project->emp_fname }} {{ $project->emp_lname }}</td>
                                                <td>
                                                    @if($project->status==0)
                                                    pending
                                                    @elseif($project->status==1)
                                                    active
                                                    @elseif($project->status==2)
                                                    inactive
                                                    @elseif($project->status==3)
                                                    closed
                                                    @elseif($project->status==4)
                                                    cancelled
                                                    @else
                                                    hold
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{url('projects/edit-resource')}}/{{$project->id}}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <!--<a href=""><i class="fa fa-trash" projects/edit-project></i>-->
                                                    </a>
                                                </td>
                                                </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>



                        </div>
                        <!-- /Widgets -->



                    </div>
                    <!-- .animated -->
                </div>
            </div>
            <div class="main-card four-form" style="display:none;">
                <div class="content">
                    <!-- Animated -->
                    <div class="animated fadeIn">
                        <div class="row" style="border:none;">
                            <div class="col-md-6">
                                <h5 class="card-title">Create New Task Information</h5>
                            </div>
                            <div class="col-md-6">

                                <span class="right-brd" style="padding-right:15x;">
                                    <ul class="">
                                        <li><a href="#">Task </a></li>

                                        <li>/</li>
                                        <li class="active">Create New Task Information</li>

                                    </ul>
                                </span>
                            </div>
                        </div>
                        <!-- Widgets  -->
                        <div class="row">

                            <div class="main-card">
                                <div class="card">

                                    <div class="card-header">
                                        <div class="aply-lv">
                                            <a href="{{ url('projects/add-task') }}"
                                                class="btn btn-default add-task">Add New
                                                Task <i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <!-- @if(Session::has('message'))resource
							<div class="alert alert-success"  projects/add-project style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif	 -->
                                    @include('include.messages')

                                    <br />
                                    <div class="clear-fix">
                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Project Name</th>
                                                    <th>Employee Name</th>
                                                    <th>Assigned By</th>
                                                    <th>Task Json</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{--  @foreach($projects_rs as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->project_code }}</td>
                                                <td>{{ $project->client_name }}</td>
                                                <td>{{ $project->emp_fname }} {{ $project->emp_lname }}</td>
                                                <td>
                                                    @if($project->status==0)
                                                    pending
                                                    @elseif($project->status==1)
                                                    active
                                                    @elseif($project->status==2)
                                                    inactive
                                                    @elseif($project->status==3)
                                                    closed
                                                    @elseif($project->status==4)
                                                    cancelled
                                                    @else
                                                    hold
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{url('projects/edit-task')}}/{{$project->id}}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <!--<a href=""><i class="fa fa-trash" projects/edit-project></i>-->
                                                    </a>
                                                </td>
                                                </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>



                        </div>
                        <!-- /Widgets -->



                    </div>
                    <!-- .animated -->
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
            '" class="form-control" value=""></div><div class="col-md-1" style="display: inline-flex;margin-top: 15px;"><button class="btn btn-primary btn-sm" style="margin: 15px 5px;"  type="button" onClick="adddoucment()"> <i class="fa fa-plus"> </i> </button><button class="btn btn-danger btn-sm deleteButtonProduce" style="margin: 15px 5px;background-color:red;" type="button"><i class="fa fa-minus"></i> </button></div></div>';

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
    @section('scripts')
    @endsection
    @include('masters.partials.scripts')