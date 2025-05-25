@extends('payroll.layouts.master')

@section('title')
Payroll Information System-PF Opening Balance
@endsection

@section('sidebar')
@include('payroll.partials.sidebar')
@endsection

@section('header')
@include('payroll.partials.header')
@endsection

@section('scripts')
@include('payroll.partials.scripts')
@endsection

@section('content')


<!-- Content -->
<style>
    .right-panel {

    margin-top: 93px;
}
</style>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">PF Opening Balance</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll</a></li>
                                <li>/</li>
                                <li class="active">PF Opening Balance</li>

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
                        <a href="{{ url('payroll/upload-pf-opening-balance') }}" class="btn btn-default">Upload as Excel <i class="fa fa-upload"></i></a>
                    </div>
                    </div>

                    @include('include.messages')


                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Member Balance</th>
                                    <th>Company Balance</th>
                                    <th>Total Balance</th>
                                    <th>Financial Year</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($pf_opening_balance as $record)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $record->emp_code}}</td>
                                    <td>{{ $record->emp_name}}</td>
                                    <td>{{ $record->member_balance }}</td>
                                    <td>{{ $record->company_balance }}</td>
                                    <td>{{ $record->total_balance }}</td>
                                    <td>{{ $record->emp_financial_year }}</td>
                                </tr>
                                @endforeach
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
<!-- /.content -->
<?php //include("footer.php");
?>
</div>
<!-- /#right-panel -->

@endsection