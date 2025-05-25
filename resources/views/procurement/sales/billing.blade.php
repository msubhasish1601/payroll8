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
                                <strong class="card-title">Billing</strong>
                            </div>
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/sales/add-new-billing') }}" class="btn btn-default">Add New <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
							
							<div class="srch-rslt">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered table-responsive" style="width:990px;overflow-x:scroll;">
                                    <thead>
                                        <tr>
											<th>Company Name</th>
											<th>CCR</th>
											<th>Bill To</th>
											<th>Item</th>
											<th>UOM</th>
											<th>Qty.</th>
											<th>Total Price</th>
											<th>Discount</th>
											<th>CGST (%)</th>
											<th>SGST (%)</th>
											<th>IGST (%)</th>
											<th>Total Amount Including Tax</th>
											<th>Date of Billing</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($billing_rs as $billing)
                                        <tr>
                                            <td>{{ $billing->institute_name }}</td>
                                            <td>{{ $billing->ccr }}</td>
											<td>{{ $billing->bill_to }}</td>
											<td>{{ $billing->item_name }}</td>
											<td>{{ $billing->unit_of_measurement }}</td>
											<td>{{ $billing->qty }}</td>
											<td>{{ $billing->tot_price }}</td>
											<td>{{ $billing->discount }}</td>
											<td>{{ $billing->cgst }}</td>
											<td>{{ $billing->sgst }}</td>
											<td>{{ $billing->igst }}</td>
											<td>{{ $billing->amt_including_tax }}</td>
											<td>{{ $billing->billing_dt }}</td>
											<td>{{ $billing->billing_status }}</td>
											<td><a href="#"><i class="ti-pencil-alt"></i></a>
												<a href="#"><i class="ti-trash"></i></a></td>
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
