@extends('procurement.inventory.layouts.master')

@section('title')
Inventory
@endsection

@section('sidebar')
	@include('procurement.inventory.partials.sidebar')
@endsection

@section('header')
	@include('procurement.inventory.partials.header')
@endsection



@section('scripts')
	@include('procurement.inventory.partials.scripts')
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
                                <strong class="card-title">Receive Component</strong>
                            </div>
							@if(Session::has('message'))										
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/inventory/add-receive-component') }}" class="btn btn-default">Add <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Component Name</th>
											<th>UOM</th>
											<th>Opening Stock</th>
											<th>Recieve Stock</th>
											<th>Issue Stock</th>
											<th>Closing Stock</th>
											<th>Recieved Date</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($rcv_comp_rs as $rcv_comp)
                                        <tr>
                                            <td>{{ $rcv_comp->component_name }}</td>
											<td>{{ $rcv_comp->unit_name }}</td>
											<td>{{ $rcv_comp->opening_balance }}</td>
											<td>{{ $rcv_comp->receive_balance }}</td>
											<td>{{ $rcv_comp->issue_balance }}</td>
											<td>{{ $rcv_comp->closing_balance }}</td>
											<td>{{ $rcv_comp->rcv_date }}</td>
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