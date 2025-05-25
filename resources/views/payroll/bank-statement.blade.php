@extends('payroll.layouts.master')

@section('title')
Payroll Information System-Cast
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
            <h5 class="card-title">Bank Statement</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Report Module</a></li>
                                <li>/</li>
                                <li class="active">Bank Statement</li>

                            </ul>
                        </span>
</div>
</div>
	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>Bank Statement</strong> </div> -->
				@include('include.messages')
	            <div class="card-body card-block">
	              <form action="{{url('payroll/vw-bank-statement')}}" method="post" style="width: 70%;margin: 0 auto;">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">
					<div class="col-md-4">
					<label>Select Month</label>
						<select class="form-control" name="month_yr" required="required">
							<option value="">Select</option>
							@if(isset($month_details) && !empty($month_details))
							@foreach($month_details as $key=>$month)
								<option  value="{{$month->month_yr}}" @if($monthyr == $month->month_yr ) selected="selected" @endif>{{$month->month_yr}}</option>
							@endforeach
							@endif
						</select>
					</div>
					       <!-- <div class="col-md-4">
	                    <label class=" form-control-label">Select Class</label>
	                    <select class="form-control" name="class_name_new" >
							<option value="">Select</option>
							@if(isset($class_name) && count($class_name)!=0)
							@foreach($class_name as $val)
								<option  value="{{$val->id}}"  @if(isset($class_name_new) && $class_name_new == $val->id ) selected="selected" @endif>{{$val->group_name}}</option>
							@endforeach
							@endif

						</select>
	                  </div> -->
	                  <div class="col-md-4">
	                    <label class=" form-control-label">Select Bank</label>
	                    <select class="form-control" name="bank" >
							<option value="">Select</option>
							@if(isset($bank_details) && count($bank_details)!=0)
							@foreach($bank_details as $val)
								<option  value="{{$val->bank_name}}"  @if(isset($bankname) && $bankname == $val->bank_name ) selected="selected" @endif>{{$val->master_bank_name}}</option>
							@endforeach
							@endif

						</select>
	                  </div>

	                  <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
	                  </div>
	                </div>


	              </form>
	            </div>
	          </div>
			  <h5 class="card-title">View Bank Statement</h5>

	          <div class="card" >

				<div class="aply-lv" style="float:right">
					@if($result!='')
					<div style="float:right"><form action="{{url('payroll/view-bank-statement')}}" method="post" target="_blank" style="background: none;padding:0;">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
						<input type="hidden" name="bankname" value="{{ (isset($bankname))?$bankname:'' }}"/>
							<input type="hidden" name="class_name_new" value="{{ (isset($class_name_new))?$class_name_new:'' }}"/>
						<input type="hidden" name="monthyr" value="{{ (isset($monthyr) && !empty($monthyr))?$monthyr:'' }}"/>

						<button type="submit" class="btn btn-danger btn-sm">View</button>
					</form></div>
					<div  style="float:right;margin-top: -7px;"><form  method="post" action="{{ url('payroll/xls-export-bank-statement') }}" enctype="multipart/form-data" style="background: none;padding:0;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="bankname" value="{{ (isset($bankname))?$bankname:'' }}"/>
							<input type="hidden" name="class_name_new" value="{{ (isset($class_name_new))?$class_name_new:'' }}"/>
						<input type="hidden" name="monthyr" value="{{ (isset($monthyr) && !empty($monthyr))?$monthyr:'' }}"/>
                                <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                            </form></div>
					@endif
				</div>


	            <br/>
	            <div class="clear-fix">
				<div class="card-body card-block">
				<div class="table-responsive">
	              <table id="bootstrap-data-table" class="table table-striped table-bordered">
	                <thead style="text-align:center;vertical-align: middle;">
	                  <tr style="font-size:11px;text-align:center">
					  <th>Employee ID</th>
					  <th>Employee Code</th>
					  <th>Employee Name</th>
					  <!-- <th>Class</th> -->
					  <th>Bank</th>
					  <th>Net Salary</th>
					  <th>Month</th>
	                  </tr>

	                </thead>
	                <tbody>
						@php echo $result; @endphp
					</tbody>
	              </table>
				 </div>
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


<!-- <script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#showbankstatement',function(){
			$('#View_Bank_Statement').css('display','block');
		});
	})

</script>  -->
@endsection
