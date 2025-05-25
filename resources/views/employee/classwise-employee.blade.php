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



@section('scripts')
	@include('employee.partials.scripts')
@endsection

@section('content')


  	<!-- Content --> 
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Class Wise Employees</h5>      
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
	              <form action="{{url('employee-corner/classwise-employee-report')}}" method="post" style="width: 70%;margin: 0 auto;" target="_blank">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">
					
					       <div class="col-md-4">
	                    <label class=" form-control-label">Select Class</label>
	                    <select class="form-control" name="class_name_new" >
							<option value="">Select</option>
							@if(isset($class_name) && count($class_name)!=0)
							@foreach($class_name as $val)
								<option  value="{{$val->id}}"  @if(isset($class_name_new) && $class_name_new == $val->id ) selected="selected" @endif>{{$val->group_name}}</option>
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