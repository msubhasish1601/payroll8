@extends('procurement.indent.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
	@include('procurement.indent.partials.sidebar')
@endsection

@section('header')
	@include('procurement.indent.partials.header')
@endsection



@section('scripts')
	@include('procurement.indent.partials.scripts')
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
                                <strong class="card-title">Purchase Request for Component</strong>
                            </div>
							@if(Session::has('message'))										
									<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('procurement/indent/add-new-requisition-component') }}" class="btn btn-default">Add <i class="fa fa-plus"></i></a>
							</div>
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Requisition No.</th>
											<th>Requisition Made by</th>
											<th>Requisition Date</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									
									@foreach($req_comp_rs as $req_comp)
									<?php
									$req_dt_arr=explode('-',$req_comp->requisition_date);
									$d=$req_dt_arr[2];
									$m=$req_dt_arr[1];
									$y=$req_dt_arr[0];
									$req_dt=$d.'-'.$m.'-'.$y;
									$id = $req_comp->id;
									?>
                                        <tr>
                                            <td>{{ $req_comp->requisition_no }}</td>
											<td>{{ $req_comp->requisition_made_by }}</td>
											<td><?php echo $req_dt; ?></td>
											<td>{{ $req_comp->status }}</td>
											<td><a href="#"><i class="ti-pencil-alt"></i></a>
												<a href="#"><i class="ti-trash"></i></a>
												@if($req_comp->status == 'Not Approved')
												<a href="{{url('procurement/indent/edit-comp-status')}}/{{ $id }}" title="Approve"><i class="ti-thumb-up"></i></a>
												@endif
											</td>
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