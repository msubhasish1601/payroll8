@extends('leave-approver.layouts.master')

@section('title')
Employee Information System-Leave Applications Details
@endsection

@section('sidebar')
@include('leave-approver.partials.sidebar')
@endsection

@section('header')
@include('leave-approver.partials.header')

@endsection



@section('content')

<!-- Content -->
<style>
.right-panel {

    margin-top: 93px;
}

.card form {
    padding: 19px 0 0 0;
    background: none;
}
</style>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Leave & Tour Approver</a></li>
                        <li>/</li>
                        <li class="active">Leave Applications Details</li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">

                    <div class="st-hd">
                        <h4 class="box-title">Leave Applications Details</h4>
                    </div>

                    @include('include.messages')


                    <br />
                    <div class="clear-fix">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                    <th style="text-align:center;">Employee Code</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">Leave Type</th>
                                    <th style="text-align:center;">FROM DATE</th>
                                    <th style="text-align:center;">TO DATE</th>
                                    <th style="text-align:center;">Date of Application</th>
                                    <th style="text-align:center;">No. of Leave</th>
                                    <th style="text-align:center;">Status</th>
                                    <!-- <th style="text-align:center;">Remarks</th> -->
                                    <th style="text-align:center;">Remarks(if any)</th>
                                    <!-- <th style="text-align:center;">Action</th> -->
                                    @if(Session('admin')->user_type== 'user')
                                    <th style="text-align:center;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($LeaveApply as $lvapply)
                                @php
                                $leaveapplyDate = date("d-m-Y", strtotime($lvapply->created_at));

                                $leaveapplyfromDate = date("d-m-Y", strtotime($lvapply->from_date));

                                $leaveapplytoDate = date("d-m-Y", strtotime($lvapply->to_date));
                                @endphp
                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                                    <td style="text-align:center;">{{$lvapply->employee_id}}</td>
                                    <td style="text-align:center;"><span class="name">{{$lvapply->employee_name}}</span>
                                    </td>
                                    <td style="text-align:center;"><span
                                            class="product">{{$lvapply->leave_type_name}}</span></td>
                                    <td style="text-align:center;"><span class="product">{{$leaveapplyfromDate}}</span>
                                    </td>
                                    <td style="text-align:center;"><span class="product">{{$leaveapplytoDate}}</span>
                                    </td>
                                    <td style="text-align:center;"><span class="date">{{$leaveapplyDate}}</span></td>
                                    <td style="text-align:center;"><span class="name">{{$lvapply->no_of_leave}}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        @if($lvapply->status=='NOT APPROVED')
                                        <span class="badge badge-warning">
                                            {{$lvapply->status}}
                                        </span>
                                        @elseif($lvapply->status=='REJECTED')
                                        <span class="badge badge-danger">{{$lvapply->status}}</span>
                                        @elseif($lvapply->status=='APPROVED')
                                        <span class="badge badge-success">{{$lvapply->status}}</span>
                                        @elseif($lvapply->status=='RECOMMENDED')
                                        <span class="badge badge-info">{{$lvapply->status}}</span>
                                        @elseif($lvapply->status=='CANCEL')
                                        <span class="badge badge-danger">{{$lvapply->status}}</span>
                                        @endif
                                    </td>
                                    @if($lvapply->status=='CANCEL' || $lvapply->status=='REJECTED')
                                    <td>{{ $lvapply->status_remarks }}</td>
                                    @else

                                    <td></td>
                                    @endif
                                    @if(Session('admin')->user_type == 'user')
                                    <td>
                                        <a
                                            href="{{url('leave-approver/leave-approved-right')}}?id={{base64_encode($lvapply->id)}}&empid={{base64_encode($lvapply->employee_id)}}"><i
                                                class="fa fa-eye"></i></a>
                                    </td>
                                    @endif
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

</div>
<!-- /#right-panel -->

@endsection
@section('scripts')
@include('employee.partials.scripts')

@endsection