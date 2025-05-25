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

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Holiday Type List</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Holiday Management</a></li>
                        <li>/</li>

                        <li class="active">Holiday Type List</li>

                    </ul>
                </span>
            </div>
        </div>

        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <div class="card-header">
                        <div class="aply-lv" style="padding-right: 17px;margin-bottom:15px;">
                            <a href="{{ url('holiday/add-holiday-type') }}" class="btn btn-default">Add New Holiday Type
                                <i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    @include('include.messages')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Holiday Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
foreach ($holiday_rs as $holiday) {

    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>{{ $holiday->name}}</td>

                                        <td><a href='{{url("holiday/add-holiday-type/$holiday->id")}}'
                                                data-toggle="tooltip" data-placement="bottom" title="Edit"><i
                                                    class="ti-pencil-alt"></i></a>
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
    </div>

<!-- .animated -->
</div>
<!-- /.content -->
@endsection

@section('scripts')
@include('holiday.partials.scripts')

@endsection