@extends('masters.layouts.master')

@section('title')
BELLEVUE - Masters Module
@endsection

@section('sidebar')
	@include('masters.partials.sidebar')
@endsection
<!-- @section('sidebar')
@include('masters.partials.sidebar')
@endsection -->

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
            <h5 class="card-title">Sub Caste Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                
								<li>/</li>
                                <li class="active">Sub Caste Master</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">
<!-- 						
								<div class="card-header">
									<strong class="card-title">Sub Caste Master</strong>
								</div> -->
								
								<!-- @if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	 -->
								@include('include.messages')
								<div class="aply-lv">
								<a href="{{ url('masters/add-sub-cast') }}" class="btn btn-default">Add Sub Caste Master <i class="fa fa-plus"></i></a>
							</div>
								<br/>
								 <div class="clear-fix">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Caste Name</th>
                                            <th>Sub Caste Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
						@foreach($getSubCast as $Subcast)
                                <tr>
                             <td>{{$loop->iteration}}</td>
                            <td>{{$Subcast->cast_name}}</td>
                             <td>{{$Subcast->sub_cast_name}}</td>
                             <td>{{ucfirst($Subcast->sub_cast_status)}}</td>
                            <td><a href="{{url('masters/edit-sub-cast/')}}/{{$Subcast->id}}"><i class="ti-pencil-alt"></i></a>

						<!--<a href="{{url('masters/vw-sub-cast')}}?del={{$Subcast->id}}" onclick="return confirm('Are you sure you want to delete this department?');"><i class="ti-trash"></i></a>-->
                        
											</td>
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
       <?php //include("footer.php"); ?>
    </div>
    <!-- /#right-panel -->
  @endsection

@section('scripts')
@include('attendance.partials.scripts')

@endsection



