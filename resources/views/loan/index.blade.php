@extends('loan.layouts.master')

@section('title')
Loan Information System - Loan
@endsection

@section('sidebar')
@include('loan.partials.sidebar')
@endsection

@section('header')
@include('loan.partials.header')

@endsection


@section('content')
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Loans</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Loans</a></li>
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
                        <form  method="post" action="{{ url('loans/xls-export-loan-list') }}" enctype="multipart/form-data" style="padding:0;background:none;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button  title="Download Excel" class="btn btn-default" type="submit" style="float:right;margin-top:-7px;"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                        </form>
                        <a href="{{ url('loans/add-loan') }}" class="btn btn-default" style="float:right;">Add Loan <i class="fa fa-plus"></i></a>
                    </div>
                    </div>

                    @include('include.messages')

                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Employee ID</th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Loan ID</th>
                                    <th>Loan Start Month</th>
                                    <th>Loan Type</th>
                                    <th>Loan Amount</th>
                                    <th>Installment Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Deduction</th>
                                    <th>Adjust</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee_rs as $employee)

                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $employee->emp_code}}</td>
                                    <td>{{ $employee->old_emp_code}}</td>
                                    <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                    <td>{{ $employee->emp_designation }}</td>
                                    <td>{{ $employee->loan_id }}</td>
                                    <td>{{ date('m/Y',strtotime($employee->start_month)) }}</td>
                                    <td>
                                        @if($employee->loan_type=='SA')
                                            Salary Advance
                                        @endif
                                        @if($employee->loan_type=='PF')
                                            PF Loan
                                        @endif
                                    </td>
                                    <td>{{ $employee->loan_amount }}</td>
                                    <td>{{ $employee->installment_amount }}</td>
                                    <td>{{ $employee->balance==null? $employee->loan_amount : $employee->loan_amount-$employee->balance }}</td>
                                    <td>{{ ($employee->deduction=='Y')?'Yes':'No' }}</td>
                                    <td>
                                        @if($employee->adjust_date==null || $employee->adjust_date=='0000-00-00')
                                        <a class="btn btn-primary" href="{{url('loans/adjust-loan')}}/{{$employee->id}}">Adjust</a>

                                        @else
                                        <a class="btn " href="{{url('loans/view-adjust-loan')}}/{{$employee->id}}">View</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($employee->adjust_date==null || $employee->adjust_date=='0000-00-00')
                                        <a href="{{url('loans/edit-loan')}}/{{$employee->id}}"><i class="ti-pencil-alt"></i></a>
                                        @endif
                                    </td>
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
@endsection

@section('scripts')
@include('loan.partials.scripts')

@endsection
