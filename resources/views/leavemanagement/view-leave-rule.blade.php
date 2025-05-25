@extends('leavemanagement.layouts.master')

@section('title')
Leave Rule System-Company
@endsection

@section('sidebar')
@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
@include('leavemanagement.partials.header')
@endsection

@section('scripts')
@include('leavemanagement.partials.scripts')
@endsection

@section('content'))

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Leave Rule</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Leave Management</a></li>
                        <li>/</li>
                        <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                        <li class="active">Leave Rule</li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">





                    <div class="card-body">
                        <div class="card-header">
                            <div class="aply-lv" style="padding-right: 18px;margin-bottom:15px;">
                                <a href="{{ url('leave-management/save-leave-rule') }}" class="btn btn-default"
                                    style="margin-top:10px;">Add New Leave Rule <i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        @include('include.messages')
                        <!-- <div class="aply-lv" style="padding-right: 18px;margin-bottom:15px;">
								<a href="{{ url('leave-management/save-leave-rule') }}" class="btn btn-default">Add New Leave Rule <i class="fa fa-plus"></i></a>
							</div> -->

                        <div class="srch-rslt" style="overflow-x:scroll; margin-top:10px;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>


                                        <th>Leave Type</th>
                                        <th>Maximum No</th>
                                        <th>Entitled From Month</th>
                                        <th>Max. Balance Enjoy</th>
                                        <!-- <th>Carry Forward Type</th> -->
                                        <th>Effective From</th>
                                        <th>Effective To</th>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leave_rule_rs as $leaveRule)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$leaveRule->leave_type_name}}</td>
                                        <td>{{$leaveRule->max_no}}</td>
                                        <td>{{$leaveRule->entitled_from_month}}</td>
                                        <td>{{$leaveRule->max_balance_enjoy}}</td>
                                        <!-- <td>{{$leaveRule->carry_forward_type}}</td> -->
                                        <td>{{$leaveRule->effective_from}}</td>
                                        <td>{{$leaveRule->effective_to}}</td>
                                        <td><a href='{{url("leave-management/view-leave-rule/$leaveRule->id")}}'><i
                                                    class="ti-pencil-alt"></i></a></td>
                                    </tr>
                                    @endforeach
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
