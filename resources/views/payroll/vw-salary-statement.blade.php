@extends('payroll.layouts.master')

@section('title')
Payroll Information System-PTAX
@endsection

@section('sidebar')
	@include('payroll.partials.sidebar')
@endsection

@section('header')
	@include('payroll.partials.header')
@endsection



@section('scripts')
	@include('payroll.partials.scripts')
@endsection

@section('content')


  	<!-- Content --> 
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Salary Statement</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Report Module</a></li>
                                <li>/</li>
                                <li class="active">Salary Statement</li>
						
                            </ul>
                        </span>
</div>
</div>
	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>Salary Statement</strong> </div> -->
	            <div class="card-body card-block">
                        @include('include.messages')
	              <form action="" method="post" target="_blank" style="width: 70%;margin: 0 auto;">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">
                            
					<div class="col-md-4">
					<label>Select Month</label>
						<select data-placeholder="Choose Month..." name="month_yr" id="month" class="form-control" required>
                           <option value="" selected disabled > Select </option>
														<?php foreach($monthlist as $month){?>
								<option value="<?php  echo $month->month_yr; ?>"><?php echo $month->month_yr; ?></option>
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
 


@endsection