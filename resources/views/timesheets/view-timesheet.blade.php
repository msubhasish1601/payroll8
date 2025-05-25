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
                <h5 class="card-title">View Timesheet</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="{{ url('timesheets/dashboard') }}">Dashboard</a></li>

                        <li>/</li>
                        <li><a href="{{ url('timesheets/view-sheets') }}">Timesheet</a></li>

                        <li>/</li>
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
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="email-input" class=" form-control-label" required>Employee Name
                                </label>
                                <input type="text" required id="employee_id" name="employee_id" class="form-control"
                                    value="<?php echo $employeename->emp_fname . ' ' . $employeename->emp_lname; ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="email-input" class="sform-control-label" required>Date
                            </label>
                            <input type="date" id="sheet_date" name="sheet_date" class="form-control"
                                value="{{$Timesheet->sheet_date}}" readonly>
                        </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <a class="btn btn-default" style="margin-top:9%"
                                href="{{url('timesheets/view-sheets')}}">Back</a>
                        </div>
                    </div>

                    <div class="clear-fix">
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
                                @foreach($TimesheetData as $tsd)
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
                </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->




@endsection