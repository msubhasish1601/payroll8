@extends('employee.layouts.master')

@section('title')
Employee Information System-Employees
@endsection

@section('sidebar')
	@include('employee.partials.sidebar')
@endsection

@section('header')
	@include('employee.partials.header')
@endsection

@section('content')


  	<!-- Content --> 
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Increment Report</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Employee</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">Increment Report</li>
						
                            </ul>
                        </span>
</div>
</div>
		
	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>Increment Report</strong> </div> -->
	            <div class="card-body card-block">
                        <!-- @if(Session::has('message'))										
			<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
			@endif	 -->
			@include('include.messages')
	              <form action="" method="post" style="width: 70%;margin: 0 auto;" target="_blank">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">
                            
					<div class="col-md-4">
					<label>Select Year</label>
					<?php  $currently_selected = date('Y'); $earliest_year = 2010; $latest_year = date('Y'); ?>
						<select data-placeholder="Choose Month..." name="month_yr" id="month" class="form-control" required>
							<option value="" selected disabled > Select </option>
							<?php foreach ( range( $latest_year, $earliest_year ) as $i ) { ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
                        </select>
					</div>
	                
	                  
	                  <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
	                  </div>
	                </div>
	                
	                
	              </form>
	            </div>
	          </div>


	        </div>
	      </div>
	      <!-- /Widgets -->
	    </div>
	    <!-- .animated -->
  	</div>
  	<!-- /.content -->
 



</script> 
@endsection

@section('scripts')

@include('employee.partials.scripts')
@endsection