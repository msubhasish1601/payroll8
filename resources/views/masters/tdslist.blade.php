@extends('masters.layouts.master')

@section('title')
BELLEVUE - Masters Module
@endsection

@section('sidebar')
    @include('masters.partials.sidebar')
@endsection

@section('header')
    @include('masters.partials.header')
@endsection



@section('scripts')
    @include('masters.partials.scripts')
@endsection

@section('content')
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none;">
<div class="col-md-6">       
<h5 class="card-title">TDS List</h5>      
</div>
<div class="col-md-6">

			   <span class="right-brd" style="padding-right:15x;">
				<ul class="">
					<!-- <li><a href="#">Account Master</a></li> -->
					<!-- <li>/</li> -->
					<li><a href="#">Account Master</a></li>
					<li>/</li>
					<li class="active">TDS Master</li>
			
				</ul>
			</span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">

						<div class="card-header">
                        <div class="aply-lv" style="padding-right: 17px;margin-bottom:15px;">
							<a href="{{ url('masters/add-tdsdetail') }}" class="btn btn-default">Add New Tds <i class="fa fa-plus"></i></a>
						</div>
                             <!-- @if(Session::has('message'))                                        
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                            @endif   -->
                            @include('include.messages')
						</div>			
                           
						<div class="card-body">
							
								
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>Sl. No.</th>
                                            <th>TDS Section</th>
                                            <th>TDS Percentage</th>
											<th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									 @foreach($tdslisting as $tds)
                                        <tr>
                                        	<td>{{$loop->iteration}}</td>
											<td>{{$tds->tds_section}}</td>
                                            <td>{{$tds->tds_percentage}}</td>
                                            <td><a href='{{url("masters/edit-tdsdetail/$tds->id")}}'><i class="ti-pencil-alt"></i></a></td>
                                            
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

@section('scripts')
@include('attendance.partials.scripts')

@endsection
