@extends('role.layouts.master')
@section('title')
{{ config('app.name', 'Laravel') }} - Module
@endsection
@section('sidebar')
	@include('role.partials.sidebar')
@endsection

@section('header')
	@include('role.partials.header')
@endsection
@section('scripts')
	@include('role.partials.scripts')
@endsection

@section('content')

<style>
.body{background:#f5f6fa;}
.card-header{background:none;}
.card{margin-top:0;}
</style> 

<!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                      
            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">User Configuration</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Role</a></li>
                                <li>/</li>
                                <li><a href="#">User Configuration</a></li>
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        
            
                    <div class="card">

                    <div class="card-header">
                              
                    
                   
							   @include('include.messages')
							<div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('role/add-user-config') }}" class="btn btn-default">Add New User <i class="fa fa-plus"></i></a>
							</div>
</div>
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        <th>Sl. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
				                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                              <td>{{ $user->email }}</td>
                                            <td><a href='{{url("role/edit-user-config/$user->id")}}'><i class="ti-pencil-alt"></i></a>
                                                <!--<a href="#"><i class="ti-trash"></i></a>--></td>
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
		
		
        <div class="clearfix"></div>


@endsection
