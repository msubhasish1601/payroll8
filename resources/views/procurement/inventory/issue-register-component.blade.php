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
                                <strong class="card-title">Issue Register for Component</strong>
                            </div>
							@if(Session::has('message'))										
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/inventory/add-issue-register-component') }}" class="btn btn-default">Add <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Component Name</th>
											<th>UOM</th>
											<th>Opening Stock</th>
											<th>Required Qty</th>
											<th>Issue Qty</th>
											<th>Issue Date</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									@foreach($issue_comp_rs as $issue_comp)
									<?php
									$datearr = explode("-",$issue_comp->issue_date);
									$d = $datearr[2];
									$m = $datearr[1];
									$y = $datearr[0];
									$date = $d."-".$m."-".$y;
									?>
                                        <tr>
                                            <td>{{ $issue_comp->component_name }}</td>
											<td>{{ $issue_comp->unit_name }}</td>
											<td>{{ $issue_comp->opening_stock }}</td>
											<td>{{ $issue_comp->indent_required_qty }}</td>
											<td>{{ $issue_comp->issue_qty }}</td>
											<td>{{ $date }}</td>
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