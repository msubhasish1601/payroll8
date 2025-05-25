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
            <h5 class="card-title">Grace Period</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Time Shift Management</a></li>
                                
								<li>/</li>
                                <li class="active">Grace Period</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <!--<div class="card">
                            <div class="card-header">
                                <strong><i class="fa fa-eye" aria-hidden="true"></i> View Tour Status for the Month: October, 2018</strong>
                            </div>
                            <div class="card-body card-block">
                                <form action="#" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
                                    
                                    
                                    <div class="row form-group">
									<div class="col-md-6">
                                        <label for="from-date" class=" form-control-label">From Date (*)</label>
                                        <input type="date" id="from-date" name="from-date" placeholder="dd/mm/yyyy" class="form-control">
										<p>(*) marked fields are mandatory</p>
                                   </div>
								   <div class="col-md-6">
                                        <label for="to-date" class=" form-control-label">To Date (*)</label>
                                        <input type="date" id="from-date" name="to-date" placeholder="dd/mm/yyyy" class="form-control">
										</div>
                                    </div>
							<div class="card-body" style="text-align:center;">
                                <button type="button" class="btn btn-danger btn-sm">Search</button>
                                <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button>
                            </div>		
                                   
                           
							
                            
							
							</form>
							
							
                        </div>
                        
                    </div>-->

                <div class="card">
                    <div class="card-header">
                    <div class="aply-lv" style="padding-right: 36px;">
                        <a href="{{ url('rota/add-grace-period') }}" class="btn btn-default">Add Grace Period <i class="fa fa-plus"></i></a>
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
													<th>Shift Name</th>
													<th>Work In-Time</th>
													<th>Grace Period</th>
													<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
									@foreach($employee_type_rs as $candidate)
									
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $candidate->department_name }}</td>
											<td>{{ $candidate->designation_name }}</td>
											<td>{{ $candidate->shift_code }}</td>
                                           <td>{{ date('h:i a',strtotime($candidate->time_in)) }}</td>
											    <td>{{ date('h:i a',strtotime($candidate->grace_time)) }}</td>

                                        <td><a href="{{url('rota/edit-grace-period')}}/{{$candidate->id}}"><i class="ti-pencil-alt"></i></a>



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