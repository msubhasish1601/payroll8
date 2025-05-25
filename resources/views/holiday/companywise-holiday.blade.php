@extends('holiday.layouts.master')

@section('title')
Holiday Dashboard
@endsection

@section('sidebar')
@include('holiday.partials.sidebar')
@endsection

@section('header')
@include('holiday.partials.header')
@endsection

@section('scripts')
@include('holiday.partials.scripts')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Holiday List</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Holiday Management</a></li>
                        <li>/</li>
                        <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                        <li class="active">Holiday List</li>

                    </ul>
                </span>
            </div>
        </div>

        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <div class="card-header">
                        <!-- <strong class="card-title">Holiday List</strong> -->
                        <div class="aply-lv" style="padding-right: 17px;margin-bottom:15px;">
                            <a href="{{ url('holiday/add-holiday') }}" class="btn btn-default">Add New Holiday <i
                                    class="fa fa-plus"></i></a>
                            <a href="{{ url('holiday/upload-holiday-list') }}" class="btn btn-default">Upload Holiday
                                List <i class="fa fa-upload"></i></a>
                        </div>
                    </div>

                    @include('include.messages')
                    <div class="card-body">
                        <!--
								<div class="aply-lv" style="padding-right: 17px;margin-bottom:15px;">
								<a href="{{ url('holiday/add-holiday') }}" class="btn btn-default">Add New Holiday <i class="fa fa-plus"></i></a>
							</div> -->

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>No. of Days</th>
                                    <th>Holiday Description</th>
                                    <th>Day of Week</th>
                                    <th>Holiday Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
foreach ($holiday_rs as $holiday) {

    $from_date = date("d-m-Y", strtotime($holiday->from_date));
    $to_date = date("d-m-Y", strtotime($holiday->to_date));

    //dd($holiday);
    ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>{{ $holiday->years}}</td>
                                    <td>{{ $from_date.'  -  '.$to_date}}</td>
                                    <td>{{ $holiday->day}}</td>
                                    <td>{{ $holiday->holiday_descripion}}</td>
                                    <td>{{ ucfirst($holiday->weekname) }}</td>
                                    <td>{{ ucfirst($holiday->name) }}</td>
                                    <td><a href='{{url("holiday/add-holiday/$holiday->id")}}'><i
                                                class="ti-pencil-alt"></i></a>
                                        <a href='{{url("holiday/holidaydelete/$holiday->id")}}'
                                            onclick="return confirm('Are you sure you want to delete this holiday?');"><i
                                                class="ti-trash"></i></a>
                                    </td>
                                </tr>
                                <?php $i++;?>
                                <?php
}
?>
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

@section('scripts')
@include('holiday.partials.scripts')

@endsection