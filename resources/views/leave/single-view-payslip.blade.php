@extends('leave.layouts.master')

@section('title')
Payroll Information System
@endsection

@section('sidebar')
@include('leave.partials.sidebar')
@endsection

@section('header')
@include('leave.partials.header')
@endsection



@section('scripts')
@include('leave.partials.scripts')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <div class="card">
                    <div class="card-header">View Payslip</div>
                    @include('include.messages')
                    <div class="card-body card-block">
                        <form action="" method="post" target="_blank">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-4">
                                <label>Select Month</label>
                                <select data-placeholder="Choose Month..." name="month_yr" id="month"
                                    class="form-control" required>
                                    <option value="{{ url('employee/payslip') }}" selected disabled> Select </option>
                                    <?php foreach ($monthlist as $month) {?>
                                    <option value="<?php echo $month->month_yr; ?>"><?php echo $month->month_yr; ?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="col-md-4 btn-up">
                                <button type="submit" class="btn btn-danger btn-sm">View </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.content -->
@endsection