
@extends('leavemanagement.layouts.master')

@section('title')
Leave Balance System-Company
@endsection

@section('sidebar')
	@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
	@include('leavemanagement.partials.header')
@endsection

@section('scripts')
	@include('leavemanagement.partials.scripts')
@endsection

@section('content'))


  	<!-- Content -->
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
		<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">  Leave Balance Report</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Leave Managemnt</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Leave Allocation</a></li>
                                <li>/</li> -->
                                <li class="active">Leave Balance Report</li>
						
                            </ul>
                        </span>
</div>
</div>

	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>Leave Balance Report</strong> </div> -->
	            <div class="card-body card-block">
                    @include('include.messages')
	            <form action="{{ url('leave-management/leave-balance-view') }}" method="post" style="width: 70%;margin: 0 auto;" target="_blank">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">
						
						<div class="col-md-6">
							<label>Choose Year</label>
							<select name="year_value" class="form-control" required>
								<option value="">Please Select Your Year </option>
								<?php for($i = date("Y")-3; $i <=date("Y")+5; $i++){
								    echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;
								} ?>
							</select>
						</div>

	                </div>

	                <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm">Show </button>
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

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script>


	function populateBranch(){

        var bank_name = $("#bank_id option:selected" ).val();

        $.ajax({
            type:'GET',
            url:'{{url('company/get-company-bank')}}/'+bank_name,
            success: function(response){

                obj=JSON.parse(response)
                var option = '<option value="" label="Select">Select Branch</option>';
                for (var i=0;i<obj.length;i++){
                   option += '<option value="'+ obj[i].id + '">' + obj[i].branch_name + '</option>';
                }

                $('#bank_branch_id').html(option);
            }
        });
    }

</script>

@endsection

@section('scripts')
@include('leavemanagement.partials.scripts')

@endsection
