@extends('employeecorner.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
@include('employeecorner.partials.sidebar')
@endsection

@section('header')
@include('employee.partials.header')
@endsection





@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="dash-hd">

            <!-- @if(Session::has('message'))
            <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
            @endif -->
            @include('include.messages')
        </div>


        <div class="st-hd" style="margin-top:30px;">
            <h4 class="box-title">Leave Status</h4>
        </div>
        <div class="row">

            @foreach($LeaveAllocation as $leave)

            <div class="col-lg-4 col-md-6">
                <div class="card dash">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="ti-archive"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="">{{$leave->leave_in_hand}}</span></div>
                                    <div class="stat-heading">{{$leave->alies}} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
        <!-- <div class="st-hd" style="margin-top:30px;">
            <h4 class="box-title">PF Status</h4>
        </div>
        <div class="row">
            @if(!empty($pf_status))

            <div class="col-lg-4 col-md-6">
                <div class="card dash">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="ti-archive"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">

                                    <div class="stat-text"><span class="">{{$pf_status->opening_balance}}</span></div>
                                    <div class="stat-heading">Opening Balance </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card dash">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="ti-archive"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">

                                    <div class="stat-text"><span class=""><?php echo round($pf_amt); ?></span></div>
                                    <div class="stat-heading">PF Balance </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @else

            <div class="col-lg-4 col-md-6">
                <div class="card dash">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="ti-archive"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">

                                    <div class="stat-text"><span class="">0</span></div>
                                    <div class="stat-heading">Opening Balance </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card dash">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="ti-archive"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="">0</span></div>
                                    <div class="stat-heading">PF Balance </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        </div> -->






        <div class="clearfix"></div>

        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card dash">
                        <div class="st-hd">
                            <h4 class="box-title">View Approved &amp; Unapproved Leave </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial" style="text-align:center;">SL. No.</th>
                                            <th style="text-align:center;">Employee Code</th>
                                            <th style="text-align:center;">Name</th>
                                            <th style="text-align:center;">Leave Type</th>
                                            <th style="text-align:center;">Date of Application</th>
                                            <th style="text-align:center;">No. Of Leave</th>
                                            <th style="text-align:center;">Duration</th>
                                            <th style="text-align:center;">Status</th>
                                            <th style="text-align:center;">Remarks(if any)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaveApply as $lvapply)
                                        <tr>
                                            <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                            <td style="text-align:center;">{{$lvapply->employee_id}}</td>
                                            <td style="text-align:center;"><span class="name">{{$lvapply->employee_name}}</span></td>
                                            <td style="text-align:center;"><span class="product">{{$lvapply->leave_type_name}}</span></td>
                                            <td style="text-align:center;"><span class="date"><?php $date = date_create($lvapply->created_at);
echo date_format($date, "d/m/Y");?></span></td>

                                            <td style="text-align:center;"><span class="name">{{$lvapply->no_of_leave}}</span></td>

                                            <td style="text-align:center;"><span class="date"><?php $fromdate = date_create($lvapply->from_date);
echo date_format($fromdate, "d/m/Y");?> To <?php $todate = date_create($lvapply->to_date);
echo date_format($todate, "d/m/Y");?></span></td>
                                            <td style="text-align:center;">@if($lvapply->status=='NOT APPROVED')<span class="badge badge-warning">{{$lvapply->status}}</span>@elseif($lvapply->status=='REJECTED')<span class="badge badge-danger">{{$lvapply->status}}</span>@elseif($lvapply->status=='APPROVED')<span class="badge badge-success">{{$lvapply->status}}</span>
                                                @elseif($lvapply->status=='RECOMMENDED')<span class="badge badge-info">{{$lvapply->status}}</span>
                                                @elseif($lvapply->status=='CANCEL')<span class="badge badge-danger">{{$lvapply->status}}</span>
                                                @endif</td>

                                            @if($lvapply->status=='CANCEL' || $lvapply->status=='REJECTED')
                                            <td>{{ $lvapply->status_remarks }}</td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>-->
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card dash">
                        <div class="st-hd">
                            <h4 class="box-title">View Approved &amp; Unapproved Tour Application </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial" style="text-align:center;">SL. No.</th>
                                            <th style="text-align:center;">EMPLOYEE CODE</th>
                                            <th style="text-align:center;">FROM DATE</th>
                                            <th style="text-align:center;">TO DATE</th>
                                            <th style="text-align:center;">Date of Application</th>
                                            <th style="text-align:center;">DURATION (DAY)</th>
                                            <th style="text-align:center;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($TourApply as $tour)
                                        <tr>
                                            <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                            <td style="text-align:center;">{{$tour->employee_code}}</td>
                                            <td style="text-align:center;"><span class="name">{{$tour->from_date}}</span></td>
                                            <td style="text-align:center;"><span class="product">{{$tour->to_date}}</span></td>
                                            <td style="text-align:center;"><span class="date">{{$tour->apply_date}}</span></td>
                                            <td style="text-align:center;"><span class="name">{{$tour->duration}}</span></td>
                                            <td style="text-align:center;">@if($tour->tour_status=='NOT APPROVED')<span class="badge badge-warning">{{$tour->tour_status}}</span>@elseif($tour->tour_status=='REJECTED')<span class="badge badge-danger">{{$tour->tour_status}}</span>
                                                @elseif($tour->tour_status=='RECOMMENDED')<span class="badge badge-info">{{$tour->tour_status}}</span>
                                                @elseif($tour->tour_status=='APPROVED')<span class="badge badge-success">{{$tour->tour_status}}</span>@endif</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>-->
                        </div>
                    </div>



                </div>

                <!-- <div class="col-xl-12">
                    <div class="card dash">
                        <div class="st-hd">
                            <h4 class="box-title">View Approved &amp; Unapproved GPF Withdrawal Application </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial" style="text-align:center;">SL. No.</th>
                                            <th style="text-align:center;">EMPLOYEE CODE</th>
                                            <th style="text-align:center;">Date of Application</th>
                                            <th style="text-align:center;">Amount</th>
                                            <th style="text-align:center;">Status</th>
                                            <th style="text-align:center;">Remarks(if any)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($LoanApply as $loan)
                                        <tr>
                                            <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                            <td style="text-align:center;">{{$loan->employee_code}}</td>

                                            <td style="text-align:center;"><span class="date">{{$loan->apply_date}}</span></td>
                                            <td style="text-align:center;"><span class="date">{{$loan->loan_amount}}</span></td>
                                            <td style="text-align:center;">@if($loan->loan_status=='NOT APPROVED')<span class="badge badge-warning">{{$loan->loan_status}}</span>@elseif($loan->loan_status=='REJECTED')<span class="badge badge-danger">{{$loan->loan_status}}</span>
                                                @elseif($loan->loan_status=='RECOMMENDED')<span class="badge badge-info">{{$loan->loan_status}}</span>
                                                @elseif($loan->loan_status=='APPROVED')<span class="badge badge-success">{{$loan->loan_status}}</span>@endif</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <! --									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>-- >
                        </div>
                    </div>



                </div> -->



                <!--<div class="col-xl-4">
                            <div class="row">
                                <div class="col-lg-6 col-xl-12">
                                    <div class="card br-0">
                                        <div class="card-body">
                                            <div class="chart-container ov-h">
                                                <div id="flotPie1" class="float-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-12">
                                    <div class="card bg-flat-color-3  ">
                                        <div class="card-body">
                                            <h4 class="card-title m-0  white-color ">August 2018</h4>
                                        </div>
                                         <div class="card-body">
                                             <div id="flotLine5" class="flot-line"></div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title box-title">To Do List</h4>
                                <div class="card-content">
                                    <div class="todo-list">
                                        <div class="tdl-holder">
                                            <div class="tdl-content">
                                                <ul>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox"><i class="check-box"></i><span>Conveniently fabricate interactive technology for ....</span>
                                                            <a href='#' class="fa fa-times"></a>
                                                            <a href='#' class="fa fa-pencil"></a>
                                                            <a href='#' class="fa fa-check"></a>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox"><i class="check-box"></i><span>Creating component page</span>
                                                            <a href='#' class="fa fa-times"></a>
                                                            <a href='#' class="fa fa-pencil"></a>
                                                            <a href='#' class="fa fa-check"></a>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" checked><i class="check-box"></i><span>Follow back those who follow you</span>
                                                            <a href='#' class="fa fa-times"></a>
                                                            <a href='#' class="fa fa-pencil"></a>
                                                            <a href='#' class="fa fa-check"></a>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" checked><i class="check-box"></i><span>Design One page theme</span>
                                                            <a href='#' class="fa fa-times"></a>
                                                            <a href='#' class="fa fa-pencil"></a>
                                                            <a href='#' class="fa fa-check"></a>
                                                        </label>
                                                    </li>

                                                    <li>
                                                        <label>
                                                            <input type="checkbox" checked><i class="check-box"></i><span>Creating component page</span>
                                                            <a href='#' class="fa fa-times"></a>
                                                            <a href='#' class="fa fa-pencil"></a>
                                                            <a href='#' class="fa fa-check"></a>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title box-title">Live Chat</h4>
                                <div class="card-content">
                                    <div class="messenger-box">
                                        <ul>
                                            <li>
                                                <div class="msg-received msg-container">
                                                    <div class="avatar">
                                                       <img src="images/avatar/64-1.jpg" alt="">
                                                       <div class="send-time">11.11 am</div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div class="inner-box">
                                                            <div class="name">
                                                                John Doe
                                                            </div>
                                                            <div class="meg">
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis sunt placeat velit ad reiciendis ipsam
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="msg-sent msg-container">
                                                    <div class="avatar">
                                                       <img src="images/avatar/64-2.jpg" alt="">
                                                       <div class="send-time">11.11 am</div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div class="inner-box">
                                                            <div class="name">
                                                                John Doe
                                                            </div>
                                                            <div class="meg">
                                                                Hay how are you doing?
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="send-mgs">
                                            <div class="yourmsg">
                                                <input class="form-control" type="text">
                                            </div>
                                            <button class="btn msg-send-btn">
                                                <i class="pe-7s-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="calender-cont widget-calender">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="card ov-h">
                            <div class="card-body bg-flat-color-2">
                                <div id="flotBarChart" class="float-chart ml-4 mr-4"></div>
                            </div>
                            <div id="cellPaiChart" class="float-chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card weather-box">
                            <h4 class="weather-title box-title">Weather</h4>
                            <div class="card-body">
                                <div class="weather-widget">
                                    <div id="weather-one" class="weather-one"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade none-border" id="event-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><strong>Add New Event</strong></h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade none-border" id="add-category">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><strong>Add a category </strong></h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Category Name</label>
                                            <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Choose Category Color</label>
                                            <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                <option value="success">Success</option>
                                                <option value="danger">Danger</option>
                                                <option value="info">Info</option>
                                                <option value="pink">Pink</option>
                                                <option value="primary">Primary</option>
                                                <option value="warning">Warning</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>-->
                <!-- .animated -->


                <!-- <div class="col-xl-12">
                    <div class="card dash">
                        <div class="st-hd">
                            <h4 class="box-title">View Approved &amp; Unapproved LTC Application </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial" style="text-align:center;">SL. No.</th>
                                            <th style="text-align:center;">EMPLOYEE CODE</th>
                                            <th style="text-align:center;">FROM DATE</th>
                                            <th style="text-align:center;">TO DATE</th>
                                            <th style="text-align:center;">Date of Application</th>
                                            <th style="text-align:center;">DURATION (DAY)</th>
                                            <th style="text-align:center;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ltcapply as $ltc)
                                        <tr>
                                            <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>

                                            <td style="text-align:center;">{{$ltc->employee_code}}</td>
                                            <td style="text-align:center;"><span class="name">{{$ltc->from_date}}</span></td>
                                            <td style="text-align:center;"><span class="product">{{$ltc->to_date}}</span></td>
                                            <td style="text-align:center;"><span class="date">{{$ltc->apply_date}}</span></td>
                                            <td style="text-align:center;"><span class="name">{{$ltc->duration}}</span></td>
                                            <td style="text-align:center;">@if($ltc->ltc_status=='NOT APPROVED')<span class="badge badge-warning">{{$ltc->ltc_status}}</span>@elseif($ltc->ltc_status=='REJECTED')<span class="badge badge-danger">{{$ltc->ltc_status}}</span>
                                                @elseif($ltc->ltc_status=='RECOMMENDED')<span class="badge badge-info">{{$ltc->ltc_status}}</span>
                                                @elseif($ltc->ltc_status=='APPROVED')<span class="badge badge-success">{{$ltc->ltc_status}}</span>@endif</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                </div> -->



            </div>
        </div>
        <!-- /.content -->
        @endsection

        @section('scripts')
        @include('employeecorner.partials.scripts')

        @endsection