@extends('leave-approver.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
@include('leave-approver.partials.sidebar')
@endsection

@section('header')
@include('leave-approver.partials.header')
@endsection


@section('content')


<style>
.table-stats.order-table.ov-h .table tbody tr td {
    font-size: 12px;
}

.badge {
    width: 100%;
    padding: 6px;
}

.card {
    margin: 34px 0 !important;
}

.orders {
    width: 1190px;
    margin: 0 auto;
}

.aprv-btn {
    margin-top: 46px;
    margin-left: 16px;
}

button.btn.btn-default.aprv {
    background: #10a006;
    color: #fff;
}

button.btn.btn-default.rej {
    background: #d00808;
    color: #fff;
}

.card form {
    padding: 0;
}

.table-stats.order-table.ov-h table thead th {
    vertical-align: top;
    font-size: 11px;
}
</style>

<div class="clearfix"></div>

<div class="orders">
    <div class="row">
        <!-- <div class="col-xl-12">
                            <div class="card dash">

							<div class="st-hd">
								<h4 class="box-title">Tour Applications Details</h4>
							</div>
                                <div class="card-body">
                                    <div class=" ">

                                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                                    <th style="text-align:center;">Employee Code</th>
                                                    <th style="text-align:center;">Name</th>
                                                    <th style="text-align:center;">FROM DATE</th>
                                                    <th style="text-align:center;">TO DATE</th>
                                                    <th style="text-align:center;">Date of Application</th>
						                            <th style="text-align:center;">DURATION (DAY)</th>
                                                    <th style="text-align:center;">Status</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
@if(count($TourApply)>0)
                                                  @foreach($TourApply as $tour)
                                            <?php $fromDate = date("d-m-Y", strtotime($tour->from_date));
$toDate = date("d-m-Y", strtotime($tour->to_date));
$applyDate = date("d-m-Y", strtotime($tour->apply_date));?>

                                                  <tr>
                                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                                    <td style="text-align:center;">{{$tour->employee_code}}</td>
                                                    <td style="text-align:center;">{{$tour->emp_fname}} {{$tour->emp_mname}} {{$tour->emp_lname}}</td>
                                                    <td style="text-align:center;"><span class="name">{{$fromDate}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{$toDate}}</span></td>
                                                    <td style="text-align:center;"><span class="date">{{$applyDate}}</span></td>
						<td style="text-align:center;"><span class="name">{{$tour->duration}}</span></td>
                                                    <td style="text-align:center;">@if($tour->tour_status=='NOT APPROVED')<span class="badge badge-warning">{{$tour->tour_status}}</span>@elseif($tour->tour_status=='REJECTED')<span class="badge badge-danger">{{$tour->tour_status}}</span>
                                                    @elseif($tour->tour_status=='RECOMMENDED')
                                                    <span class="badge badge-info">{{$tour->tour_status}}</span>
                                                    @elseif($tour->tour_status=='APPROVED')<span class="badge badge-success">{{$tour->tour_status}}</span>@endif</td>

                                                   @if($tour->tour_status=='APPROVED'||$tour->tour_status=='REJECTED')
                                                   @else
                                                    <td><a href="{{url('leave-approver/tour-approved-right')}}?id={{base64_encode($tour->id)}}&empid={{base64_encode($tour->employee_code)}}"><i class="fa fa-eye"></i></a></td>
                                                @endif
                                                </tr>
                                             @endforeach
											   @endif
                                            </tbody>
                                        </table>


                                    </div>

                                </div>
                            </div>



                        </div> -->

        <div class="col-xl-12">
            <div class="card dash">
                @include('include.messages')
                <div class="st-hd">
                    <h4 class="box-title">Leave Applications Details</h4>
                </div>

                <div class="card-body">
                    <div class="">

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

                                @if(count($LeaveApply)>0)

                                @foreach($LeaveApply as $lvapply)
                                <?php $leaveapplyDate = date("d-m-Y", strtotime($lvapply->created_at));

$leaveapplyfromDate = date("d-m-Y", strtotime($lvapply->from_date));

$leaveapplytoDate = date("d-m-Y", strtotime($lvapply->to_date));?>

                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                                    <td style="text-align:center;">{{$lvapply->old_emp_code}}</td>
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

                                    <td>
                                        @if(Session('admin')->user_type == 'user')
                                        <a
                                            href="{{url('leave-approver/leave-approved-right')}}?id={{base64_encode($lvapply->id)}}&empid={{base64_encode($lvapply->employee_id)}}"><i
                                                class="fa fa-eye"></i></a>
                                        @endif
                                    </td>

                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        {{--{{$LeaveApply->links()}} --}}

                        <!--<div class="aprv-btn">
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Approved" id="approve" class="btn btn-default aprv"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved</button>
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Rejected" id="rejected" class="btn btn-default rej"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Rejected</button>
                    </div>-->

                    </div>
                    <!--									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>-->
                </div>
            </div>



        </div>

        <!-- <div class="col-xl-12">
            <div class="card dash">

                <div class="st-hd">
                    <h4 class="box-title">Tour Applications Details</h4>
                </div>
                <div class="card-body">
                    <div class=" ">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                    <th style="text-align:center;">Employee Code</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">FROM DATE</th>
                                    <th style="text-align:center;">TO DATE</th>
                                    <th style="text-align:center;">Date of Application</th>
                                    <th style="text-align:center;">DURATION (DAY)</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($TourApply)>0)
                                @foreach($TourApply as $tour)
                                <?php $fromDate = date("d-m-Y", strtotime($tour->from_date));
$toDate = date("d-m-Y", strtotime($tour->to_date));
$applyDate = date("d-m-Y", strtotime($tour->apply_date));?>

                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                    <td style="text-align:center;">{{$tour->employee_code}}</td>
                                    <td style="text-align:center;">{{$tour->emp_fname}} {{$tour->emp_mname}}
                                        {{$tour->emp_lname}}</td>
                                    <td style="text-align:center;"><span class="name">{{$fromDate}}</span></td>
                                    <td style="text-align:center;"><span class="product">{{$toDate}}</span></td>
                                    <td style="text-align:center;"><span class="date">{{$applyDate}}</span></td>
                                    <td style="text-align:center;"><span class="name">{{$tour->duration}}</span></td>
                                    <td style="text-align:center;">@if($tour->tour_status=='NOT APPROVED')<span
                                            class="badge badge-warning">{{$tour->tour_status}}</span>@elseif($tour->tour_status=='REJECTED')<span
                                            class="badge badge-danger">{{$tour->tour_status}}</span>
                                        @elseif($tour->tour_status=='RECOMMENDED')
                                        <span class="badge badge-info">{{$tour->tour_status}}</span>
                                        @elseif($tour->tour_status=='APPROVED')<span
                                            class="badge badge-success">{{$tour->tour_status}}</span>@endif
                                    </td>

                                    @if($tour->tour_status=='APPROVED'||$tour->tour_status=='REJECTED')
                                    @else
                                    <td><a
                                            href="{{url('leave-approver/tour-approved-right')}}?id={{base64_encode($tour->id)}}&empid={{base64_encode($tour->employee_code)}}"><i
                                                class="fa fa-eye"></i></a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{$TourApply->links()}}
                        <! --<div class="aprv-btn">
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Approved" id="approve" class="btn btn-default aprv"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved</button>
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Rejected" id="rejected" class="btn btn-default rej"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Rejected</button>
                    </div>- ->

                    </div>
                    <! --									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>- ->
                </div>
            </div>



        </div> -->

        <!-- <div class="col-xl-12">
            <div class="card dash">

                <div class="st-hd">
                    <h4 class="box-title"> GPF Withdrawal Applications Details</h4>
                </div>
                <div class="card-body">
                    <div class=" ">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                    <th style="text-align:center;">Employee Code</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">Date of Application</th>
                                    <th style="text-align:center;">Loan Amount</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(count($LoanApply)>0)

                                @foreach($LoanApply as $loan)
                                <?php
$applyDate = date("d-m-Y", strtotime($loan->apply_date));?>

                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                    <td style="text-align:center;">{{$loan->employee_code}}</td>
                                    <td style="text-align:center;">{{$loan->emp_fname}} {{$loan->emp_mname}}
                                        {{$loan->emp_lname}}</td>
                                    <td style="text-align:center;"><span class="date">{{$applyDate}}</span></td>
                                    <td style="text-align:center;"><span class="name">{{$loan->loan_amount}}</span></td>
                                    <td style="text-align:center;">@if($loan->loan_status=='NOT APPROVED')<span
                                            class="badge badge-warning">{{$loan->loan_status}}</span>@elseif($loan->loan_status=='REJECTED')<span
                                            class="badge badge-danger">{{$loan->loan_status}}</span>
                                        @elseif($loan->loan_status=='RECOMMENDED')
                                        <span class="badge badge-info">{{$loan->loan_status}}</span>
                                        @elseif($loan->loan_status=='APPROVED')<span
                                            class="badge badge-success">{{$loan->loan_status}}</span>@endif
                                    </td>

                                    @if($loan->loan_status=='APPROVED'||$loan->loan_status=='REJECTED')
                                    @else
                                    <td><a
                                            href="{{url('leave-approver/loan-approved-right')}}?id={{base64_encode($loan->id)}}&empid={{base64_encode($loan->employee_code)}}"><i
                                                class="fa fa-eye"></i></a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{$LoanApply->links()}}

                        <! --<div class="aprv-btn">
                                                 <button type="submit" onclick="calculate_leave(this.value)" value="Approved" id="approve" class="btn btn-default aprv"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved</button>
                                                 <button type="submit" onclick="calculate_leave(this.value)" value="Rejected" id="rejected" class="btn btn-default rej"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Rejected</button>
                        </div>- ->

                    </div>
                    <! --									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>- ->
                </div>
            </div>



        </div> -->

        <!-- <div class="col-xl-12">
            <div class="card dash">

                <div class="st-hd">
                    <h4 class="box-title">LTC Applications Details</h4>
                </div>
                <div class="card-body">
                    <div class="">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                    <th style="text-align:center;">Employee Code</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">FROM DATE</th>
                                    <th style="text-align:center;">TO DATE</th>
                                    <th style="text-align:center;">Date of Application</th>
                                    <th style="text-align:center;">DURATION (DAY)</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($ltcapply)>0)
                                @foreach($ltcapply as $ltc)
                                <?php $fromDate = date("d-m-Y", strtotime($ltc->from_date));
$toDate = date("d-m-Y", strtotime($ltc->to_date));
$applyDate = date("d-m-Y", strtotime($ltc->apply_date));?>

                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                    <td style="text-align:center;">{{$ltc->employee_code}}</td>
                                    <td style="text-align:center;">{{$ltc->emp_fname}} {{$ltc->emp_mname}}
                                        {{$ltc->emp_lname}}</td>
                                    <td style="text-align:center;"><span class="name">{{$fromDate}}</span></td>
                                    <td style="text-align:center;"><span class="product">{{$toDate}}</span></td>
                                    <td style="text-align:center;"><span class="date">{{$applyDate}}</span></td>
                                    <td style="text-align:center;"><span class="name">{{$ltc->duration}}</span></td>
                                    <td style="text-align:center;">@if($ltc->ltc_status=='NOT APPROVED')<span
                                            class="badge badge-warning">{{$ltc->ltc_status}}</span>@elseif($ltc->ltc_status=='REJECTED')<span
                                            class="badge badge-danger">{{$ltc->ltc_status}}</span>
                                        @elseif($ltc->ltc_status=='RECOMMENDED')
                                        <span class="badge badge-info">{{$ltc->ltc_status}}</span>
                                        @elseif($ltc->ltc_status=='APPROVED')<span
                                            class="badge badge-success">{{$ltc->ltc_status}}</span>@endif
                                    </td>

                                    @if($ltc->ltc_status=='APPROVED'||$ltc->ltc_status=='REJECTED')
                                    @else
                                    <td><a
                                            href="{{url('leave-approver/ltc-approved')}}?id={{base64_encode($ltc->id)}}&empid={{base64_encode($ltc->employee_code)}}"><i
                                                class="fa fa-eye"></i></a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{$ltcapply->links()}}

                        <! --<div class="aprv-btn">
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Approved" id="approve" class="btn btn-default aprv"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved</button>
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Rejected" id="rejected" class="btn btn-default rej"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Rejected</button>
                    </div>- ->

                    </div>
                    <! --                                    <div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>- ->
                </div>
            </div>



        </div> -->

        <!-- <div class="col-xl-12">
            <div class="card dash">

                <div class="st-hd">
                    <h4 class="box-title">Pension Applications Details</h4>
                </div>
                <div class="card-body">
                    <div class="">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                    <th style="text-align:center;">Employee Code</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">Date of Retirement</th>

                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($PensionApply)>0)

                                @foreach($PensionApply as $Pension)

                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                    <td style="text-align:center;">{{$Pension->emp_code}}</td>
                                    <td style="text-align:center;">{{$Pension->emp_fname}} {{$Pension->emp_mname}}
                                        {{$Pension->emp_lname}}</td>
                                    <td style="text-align:center;"><span
                                            class="date">{{ date("d-m-Y", strtotime($Pension->emp_retirement_date))}}</span>
                                    </td>

                                    <td style="text-align:center;">@if($Pension->status=='NOT APPROVED')<span
                                            class="badge badge-warning">{{$Pension->status}}</span>@elseif($Pension->status=='REJECTED')<span
                                            class="badge badge-danger">{{$Pension->status}}</span>
                                        @elseif($Pension->status=='RECOMMENDED')
                                        <span class="badge badge-info">{{$Pension->status}}</span>
                                        @elseif($Pension->status=='APPROVED')<span
                                            class="badge badge-success">{{$Pension->status}}</span>@endif
                                    </td>

                                    @if($Pension->status=='APPROVED'||$Pension->status=='REJECTED')
                                    @else
                                    <td><a
                                            href="{{url('pension-approver/pension-approved-right')}}?id={{base64_encode($Pension->id)}}&empid={{base64_encode($Pension->emp_code)}}"><i
                                                class="fa fa-eye"></i></a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{$PensionApply->links()}}
                        <! --<div class="aprv-btn">
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Approved" id="approve" class="btn btn-default aprv"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved</button>
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Rejected" id="rejected" class="btn btn-default rej"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Rejected</button>
                    </div>- ->

                    </div>
                    <! --									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div> - ->
                </div>
            </div>



        </div> -->






        <!-- <div class="col-xl-12">
            <div class="card dash">

                <div class="st-hd">
                    <h4 class="box-title">Loan Applications Details</h4>
                </div>
                <div class="card-body">
                    <div class=" ">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial" style="text-align:center;">SL. No.</th>
                                    <th style="text-align:center;">Employee Code</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">Date of Apply</th>
                                    <th style="text-align:center;">Amoumt</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(count($LoanotherApply)>0)
                                @foreach($LoanotherApply as $Loanother)

                                <tr>
                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                    <td style="text-align:center;">{{$Loanother->employee_code}}</td>
                                    <td style="text-align:center;">{{$Loanother->emp_fname}} {{$Loanother->emp_mname}}
                                        {{$Loanother->emp_lname}}</td>
                                    <td style="text-align:center;"><span
                                            class="date">{{ date("d-m-Y", strtotime($Loanother->apply_date))}}</span>
                                    </td>
                                    <td style="text-align:center;">{{$Loanother->loan_amount}}</td>
                                    <td style="text-align:center;">@if($Loanother->loan_status=='NOT APPROVED')<span
                                            class="badge badge-warning">{{$Loanother->loan_status}}</span>@elseif($Loanother->loan_status=='REJECTED')<span
                                            class="badge badge-danger">{{$Loanother->loan_status}}</span>
                                        @elseif($Loanother->loan_status=='RECOMMENDED')
                                        <span class="badge badge-info">{{$Loanother->loan_status}}</span>
                                        @elseif($Loanother->loan_status=='APPROVED')<span
                                            class="badge badge-success">{{$Loanother->loan_status}}</span>@endif
                                    </td>

                                    @if($Loanother->loan_status=='APPROVED'||$Loanother->loan_status=='REJECTED')
                                    @else
                                    <td><a
                                            href="{{url('loanother-approver/loanother-approved-right')}}?id={{base64_encode($Loanother->id)}}&empid={{base64_encode($Loanother->employee_code)}}"><i
                                                class="fa fa-eye"></i></a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{$LoanotherApply->links()}}
                        <! --<div class="aprv-btn">
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Approved" id="approve" class="btn btn-default aprv"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approved</button>
                                             <button type="submit" onclick="calculate_leave(this.value)" value="Rejected" id="rejected" class="btn btn-default rej"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Rejected</button>
                    </div>- ->

                    </div>
                    <! --									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>- ->
                </div>
            </div>



        </div> -->





    </div>

    <!-- .animated -->

</div>
@endsection

@section('scripts')
@include('leave-approver.partials.scripts')

<script>
// Listen for click on toggle checkbox for each Page
$('#all_check').click(function(event) {

    if (this.checked) {
        //alert("test");
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;
        });
    }
});
</script>
<script>
function calculate_leave(row) {
    //var max_no= $("approve").val();
    //alert(row)
    // max_no=8;
    //var opening_bal= $("#opening_bal"+row).val();

    //var leave_in_hand=max_no-opening_bal;

    $("#leave_confirm").val(row);
    return false;
}
</script>

@endsection