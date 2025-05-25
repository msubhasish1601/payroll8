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
            <h5 class="card-title">Company GPF Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Bank Master</a></li>
                                
								<li>/</li>
                                <li class="active">Company GPF Master</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">
						
								<div class="card-header">
                                <div class="aply-lv">
									<a href="{{ url('masters/add-gpfbank') }}" class="btn btn-default">Add GPF Bank Master <i class="fa fa-plus"></i></a>
								</div>
								</div>
								
								<!-- @if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	 -->
								@include('include.messages')
								
								<br/>
								 <div class="clear-fix">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Bank Name</th>
											<th>Branch Name</th>
											<th>IFSC Code</th>
											<th>MICR Code</th>
                                            <th>Opening Balance</th>
                                            <th>Bank Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										@foreach($company_bank_listing as $companybank)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $companybank->bank_name }}</td>
                                            <td>{{ $companybank->branch_name }}</td>
                                            <td>{{ $companybank->ifsc_code }}</td>
                                            <td>{{ $companybank->micr_code }}</td>
                                            <td>{{ $companybank->opening_balance }}</td>
                                            <td>{{ $companybank->bank_status }}</td>
											<td>
												<a href='{{url("masters/edit-gpfbank/$companybank->id")}}'><i class="ti-pencil-alt"></i></a>
												
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
