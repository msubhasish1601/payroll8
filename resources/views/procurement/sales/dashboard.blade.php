@extends('procurement.sales.layouts.master')

@section('title')
Sales
@endsection

@section('sidebar')
	@include('procurement.sales.partials.sidebar')
@endsection

@section('header')
	@include('procurement.sales.partials.header')
@endsection



@section('scripts')
	@include('procurement.sales.partials.scripts')
@endsection

@section('content')

        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
               <!--<div class="dash-hd">
					<h3>Dashboard</h3>
				</div>
                <div class="row">
				
				<div class="clearfix"></div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card dash">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="ti-archive"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">8</span></div>
                                            <div class="stat-heading">CL in Hand</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card dash">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="ti-layout"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">10</span></div>
                                            <div class="stat-heading">PL in Hand</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card dash">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="ti-shift-right-alt"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">5</span></div>
                                            <div class="stat-heading">HP in Hand</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card dash">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="ti-arrow-circle-right"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count">6</span></div>
                                            <div class="stat-heading">SL in Hand</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
               
                <!--<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">Traffic </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card-body">
                                        <div id="traffic-chart" class="traffic-chart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card-body">
                                        <div class="progress-box progress-1">
                                            <h4 class="por-title">Visits</h4>
                                            <div class="por-txt">96,930 Users (40%)</div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar bg-flat-color-1" role="progressbar" style="width: 40%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="progress-box progress-2">
                                            <h4 class="por-title">Bounce Rate</h4>
                                            <div class="por-txt">3,220 Users (24%)</div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar bg-flat-color-2" role="progressbar" style="width: 24%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="progress-box progress-2">
                                            <h4 class="por-title">Unique Visitors</h4>
                                            <div class="por-txt">29,658 Users (60%)</div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar bg-flat-color-3" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="progress-box progress-2">
                                            <h4 class="por-title">Targeted  Visitors</h4>
                                            <div class="por-txt">99,658 Users (90%)</div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar bg-flat-color-4" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div> 
                            <div class="card-body"></div>
                        </div>
                    </div>
                </div>-->
               
                <div class="clearfix"></div>
                
                <!--<div class="orders">
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
                                                    <th class="serial">#</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Leave Type</th>
                                                    <th>Date of Application</th>
													<th>Supervisor Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="serial">1.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="product">Casual Leave</span></td>
                                                    <td><span class="date">04/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-complete">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">2.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="product">Casual Leave</span></td>
                                                    <td><span class="date">04/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-complete">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">3.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="product">Casual Leave</span></td>
                                                    <td><span class="date">04/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-complete">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">4.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="product">Casual Leave</span></td>
                                                    <td><span class="date">10/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-pending">Rejected</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">5.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="product">Casual Leave</span></td>
                                                    <td><span class="date">12/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-pending">Rejected</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
									<div class="dash-vw-all"><a href="leave-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>
                                </div>
                            </div> 
							
							<div class="card dash">
							<div class="st-hd">
								<h4 class="box-title">View Tour Application</h4>
							</div>
                                <div class="card-body">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th class="serial">#</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Date of Application</th>
													<th>Supervisor Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="serial">1.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="date">04/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-complete">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">2.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="date">04/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-complete">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">3.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="date">04/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-complete">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">4.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="date">10/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-pending">Rejected</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">5.</td>
                                                    
                                                    <td>1234</td>
                                                    <td><span class="name">Amitava Ganguly</span></td>
                                                    <td><span class="date">12/10/2018</span></td>
													<td><span class="name">Dibyendu Paul</span></td>
                                                    <td><span class="badge badge-pending">Rejected</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
										
                                    </div> 
									<div class="dash-vw-all"><a href="tour-application.php" class="btn btn-default"><i class="fa fa-eye"></i> View All</a></div>
                                </div>
								
                            </div>
							
                        </div>  

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
            
            </div>
			
        </div>
        <div class="clearfix"></div>
       <?php //include("includes/footer.php"); ?>
    </div>
</div>-->
    <!-- Scripts -->
     @endsection