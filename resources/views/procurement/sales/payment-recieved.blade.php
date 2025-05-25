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
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">List of Payment Recieved</strong>
                            </div>
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/sales/add-new-payment-recieved') }}" class="btn btn-default">Add New <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
							
							<div class="srch-rslt">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive" style="width:990px;overflow-x:scroll;">
                                    <thead>
                                        <tr>
											<th>Company Name</th>
											<th>Payment Recieved Id</th>
											<th>Bill No.</th>
											<th>Billing Amount</th>
											<th>Payment Recieved</th>
											<th>Due Amount</th>
											<th>Payment Date</th>
											<th>Payment Mode</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Adamas Institute of Technology</td>
                                            <td>PR001</td>
											<td>BILLING-2019-165</td>
											<td>36108</td>
											<td>36108</td>
											<td>0</td>
											<td>05/02/2019</td>
											<td>Cash</td>
											<td>Paid</td>
											<td><a href="#"><i class="ti-pencil-alt"></i></a>
												<a href="#"><i class="ti-trash"></i></a></td>
                                        </tr>
                                         
                                         
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
