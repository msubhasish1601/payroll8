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
            <h5 class="card-title">Rate Details</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Payroll Master</a></li>
                                
								<li>/</li>
                                <li class="active">Rate Details</li>
                            </ul>
                        </span>
</div>
</div>
            <!-- Widgets  -->
            <div class="row">
                <div class="main-card">
                    <div class="card">
						<div class="card-header">
							<!-- <strong class="card-title">Rate Master</strong> -->
                             <!-- @if(Session::has('message'))                                        
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                            @endif   -->
                            @include('include.messages')
							<div class="aply-lv">
								<a href="{{ url('masters/add-rate') }}" class="btn btn-default">Add Rate Details <i class="fa fa-plus"></i></a>
							</div>
						</div><br/>
    					<div class="clear-fix">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl no.</th>
    									<th>Head</th>
											<th>Head Type</th>
                                        <th>In Percent</th>
                                        <th>In Rupees</th>
                                        <th>Min. Value</th>
                                        <th>Max. Value</th>
    									<th>Effective from</th>
    									<th>Effective to</th>
    									<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($ratelist as $ratedtl)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ratedtl->head_name }}</td>
										 <td>{{ ucfirst($ratedtl->head_type) }}</td>
                                        <td>{{ $ratedtl->inpercentage }}</td>
                                        <td>{{ $ratedtl->inrupees }}</td>
    									<td>{{ $ratedtl->min_basic }}</td>
                                        <td>{{ $ratedtl->max_basic }}</td>
                                        <td>{{ date('d-m-Y', strtotime($ratedtl->from_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($ratedtl->to_date)) }}</td>
    									<!-- <td><a href='{{url("masters/rate-details/$ratedtl->id")}}'><i class="las la-edit"></i></a></td> -->
                                        <td><a href='{{url("masters/rate-details/$ratedtl->id")}}'><i class="ti-pencil-alt"></i></a>
                                    </tr>
                                     @endforeach
                                </tbody>
                            </table>
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