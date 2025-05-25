@extends('masters.layouts.master')

@section('title')
Configuration-Category
@endsection

@section('sidebar')
	@include('masters.partials.sidebar')
@endsection

@section('header')
	@include('masters.partials.header')
@endsection





@section('content')
      <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">

            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Category</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Procurement Master</a></li>
                                
								<li>/</li>
                                <li class="active">Category</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                  
                       
                        <div class="card">
                            <div class="card-header">
                            <div class="aply-lv" style="padding-right: 36px;">
								<a href="{{ url('masters/add-category') }}" class="btn btn-default">Add New Category <i class="fa fa-plus"></i></a>
							</div>
                            </div>
							<!-- @if(Session::has('message'))										
									<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif	 -->
                            @include('include.messages')
							
                            <div class="card-body">
							
							<div class="srch-rslt" style="overflow-x:scroll;">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Sl no.</th>
											<th>Category Name</th>
                                            <th>Category Code</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
									
                                    <tbody>
										@foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->cat_name }}</td>
                                            <td>{{ $category->cat_code }}</td>
											<td><a href='{{url("masters/edit-category/$category->id")}}'><i class="ti-pencil-alt"></i></a>
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
		
		
        <div class="clearfix"></div>
		
        @endsection

@section('scripts')
@include('masters.partials.scripts')

@endsection