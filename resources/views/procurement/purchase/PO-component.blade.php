@extends('procurement.purchase.layouts.master')

@section('title')
Purchase Order For Component
@endsection

@section('sidebar')
	@include('procurement.purchase.partials.sidebar')
@endsection

@section('header')
	@include('procurement.purchase.partials.header')
@endsection



@section('scripts')
	@include('procurement.purchase.partials.scripts')
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
                                <strong class="card-title">Purchase Order for Component</strong>
                            </div>
							@if(Session::has('message'))										
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/purchase/add-po-component') }}" class="btn btn-default">Add Purchase Order <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>PO No.</th>
											<th>Requisition Number</th>
											<th>Total</th>
											<th>Shiping Name</th>
											<th>Shipping Company</th>
											<th>Shipping State</th>
											<th>Shipping City</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($po_comp_rs as $po_comp)
                                        <tr>
											<td>{{ $po_comp->purchase_order_no }}</td>
											<td>{{ $po_comp->requisition_no }}</td>
											<td>{{ $po_comp->total }}</td>
											<td>{{ $po_comp->shipping_name }}</td>
											<td>{{ $po_comp->shipping_company }}</td>
											<td>{{ $po_comp->shipping_state }}</td>
											<td>{{ $po_comp->shipping_city }}</td>
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
