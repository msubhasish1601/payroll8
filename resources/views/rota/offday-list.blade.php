@extends('rota.layouts.master')
@section('title')
BELLEVUE - Module
@endsection
@section('sidebar')
@include('rota.partials.sidebar')
@endsection

@section('header')
@include('rota.partials.header')
@endsection
@section('scripts')
@include('rota.partials.scripts')
@endsection

@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Day Off</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                <li>/</li>
                                <li class="active">Day Off</li>
						
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
                        <a href="{{ url('rota/add-offday') }}" class="btn btn-default">Add Day Off <i class="fa fa-plus"></i></a>
                    </div>
                    </div>
                    @include('include.messages')
                   
                    <div class="card-body">

                        <div class="srch-rslt" style="overflow-x:scroll;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Sunday</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee_type_rs as $candidate)
                                    
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $candidate->department_name }}</td>
											<td>{{ $candidate->designation_name }}</td>
												
											<td>@if($candidate->sun=='1' )
											 <i class="ti-close"></i>
                                                    
												  @else
													   <i class="ti-check"></i>
                                                    @endif	</td>
											
											<td>@if($candidate->mon=='1' )
                                                     <i class="ti-close"></i>
												  @else
												    <i class="ti-check"></i>
													 
                                                    @endif	</td>
													<td>@if($candidate->tue=='1' )
                                                      <i class="ti-close"></i> 
												  @else
												  <i class="ti-check"></i>
													 
                                                    @endif	</td>
													<td>@if($candidate->wed=='1' )
													 <i class="ti-close"></i>
                                                     
												  @else
													  <i class="ti-check"></i>
                                                    @endif	</td>
													<td>@if($candidate->thu=='1' )
													 <i class="ti-close"></i>
                                                     
												  @else
												   <i class="ti-check"></i>
													 
                                                    @endif	</td>
													<td>@if($candidate->fri=='1' )
													 <i class="ti-close"></i>
                                                    
												  @else
													   <i class="ti-check"></i>
                                                    @endif	</td>
													<td>@if($candidate->sat=='1' )
													 <i class="ti-close"></i>
                                                     
												  @else
													  <i class="ti-check"></i>
                                                    @endif	</td>

                                        <td><a href="{{url('rota/add-offday')}}/{{$candidate->id}}"><i class="ti-pencil-alt"></i></a>



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