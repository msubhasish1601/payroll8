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
            <div class="animated fadeIn">.

            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Account List</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Account Management</a></li>
                                
								<li>/</li>
                                <li class="active">Account List</li>
						
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
								<a href="{{ url('masters/accountmaster') }}" class="btn btn-default">Add New Account <i class="fa fa-plus"></i></a>
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
											<th>Account Code</th>
                                            <th>Account Type</th>
                                            <th>Account Name</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									 @foreach($accountlisting as $accountlist)
                                        <tr>
                                        	<td>{{$loop->iteration}}</td>
											<td>{{$accountlist->account_code}}</td>
                                            <td>{{ucfirst($accountlist->account_type)}}</td>
                                            <td>{{$accountlist->account_name}}</td>
                                           
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
