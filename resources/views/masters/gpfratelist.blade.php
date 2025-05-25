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
            <h5 class="card-title">GPF Rate List</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">GPF Rate List</li>
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
							<a href="{{ url('masters/add-gpf-rate-detail') }}" class="btn btn-default">Add New GPF Rate<i class="fa fa-plus"></i></a>
						</div>
                             <!-- @if(Session::has('message'))
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                            @endif -->
                           
						</div>
                        @include('include.messages')
						<div class="card-body">
							

							<table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        	<th>Sl. No.</th>
                                            <th>Rate of Interest</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									 @foreach($gpfratelisting as $gpflisting)
                                        <tr>
                                        	<td>{{$loop->iteration}}</td>
                                            <td>{{$gpflisting->rate_of_interest}}</td>
                                            <td>{{$gpflisting->from_date}}</td>
                                            <td>{{$gpflisting->to_date}}</td>
                                            <td><a href='{{url("masters/edit-gpf-rate-detail/$gpflisting->id")}}'><i class="ti-pencil-alt"></i></a></td>
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
