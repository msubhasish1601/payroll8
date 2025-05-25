@extends('projects.layouts.master')

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
                <h5 class="card-title">View Timesheet Sheet</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Timesheet Management</a></li>
                        <li>/</li>
                        <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                        <li class="active">View Timesheet</li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <div class="card-body card-block">
                        <form method="post" action="{{ url('timesheets/') }}" enctype="multipart/form-data"
                            class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label for="text-input" class=" form-control-label">Employee Name </label>
                                    <select name="employee_id" id="employee_id" class="form-control select2_el"
                                        required>
                                        <option value="">Select Employee</option>
                                        @foreach ($emplist as $emp)
                                        <option value="{{$emp->emp_code}}" @if(isset($employee_id) &&
                                            $employee_id==$emp->
                                            emp_code ) selected @endif>
                                            {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('employee_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('employee_id') }}</div>
                                    @endif
                                </div>

                                <div class="col-12 col-md-3" style="padding: 1px 2px 14px 26px;">
                                    <label for="email-input" class="sform-control-label" required>Date
                                        <!-- <span class="error">(*)</span> -->
                                    </label>
                                    <input type="date" id="sheet_date" name="sheet_date" class="form-control select1_el"
                                        value="@if(isset($sheet_date)){{$sheet_date}}@endif" required>
                                    @if ($errors->has('sheet_date'))
                                    <div class="error" style="color:red;">{{ $errors->first('sheet_date') }}</div>
                                    @endif
                                </div>
                                <div class="col col-md-4 btn-up">
                                    <button type="submit" class="btn btn-danger btn-sm">Search</button>
                                    <a class="btn btn-danger btn-sm" href="{{ url('timesheets') }}">
                                        <i class="fa fa-ban"></i> Reset
</a>
                                </div>
                            </div>

                            <div class="row form-group">

                            </div>

                        </form>

                    </div>
                    @if(!empty($timesheet_detail))



                    <div class="card-body card-block">

                        @if(count($timesheet_detail)>0)

                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Task Type</th>
                                        <th>Task</th>
                                        <th>Job Description</th>
                                        <th>Time</th>
                                        <th>Task Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $tsdHr = 0;
                                    $tsdMin = 0;
                                    @endphp
                                    @foreach($timesheet_detail as $tsd)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tsd->project_name }}</td>
                                        <td>{{ $tsd->task_type }}</td>
                                        <td>{{ $tsd->task_name }}</td>
                                        <td>{{ $tsd->description }}</td>
                                        <td>{{ $tsd->task_time }}</td>
                                        <td>{{ $tsd->task_status }}</td>
                                    </tr>
                                    @php
                                    $tsdHr = $tsdHr + $tsd->hours;
                                    $tsdMin = $tsdMin + $tsd->minutes;
                                    @endphp
                                    @endforeach
                                    @php
                                    $hrInMins = floor($tsdMin / 60);
                                    $minInMins = $tsdMin % 60;
                                    $tsdHr = $tsdHr + $hrInMins;
                                    $total_hours = $tsdHr . ':' . $minInMins;
                                    $total_hours_locked = $total_hours;
                                    @endphp
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total:</th>
                                        <th>{{$total_hours_locked}}</th>
                                        <th></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @else
                        <h5 class="text-center"><i class="fa fa-info-circle pr-2"></i>No timesheet received yet.</h5>
                        @endif
                    </div>
                    @endif

                </div>
            </div>
            <!-- /Widgets -->
        </div>
        <!-- .animated -->
    </div>
    <!-- /.content -->
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
    @endsection
