@extends('masters.layouts.master')

@section('title')
BELLEVUE - Bank Book
@endsection

@section('sidebar')
    @include('mis-reports.includes.sidebar')
@endsection

@section('header')
    @include('masters.partials.header')
@endsection

@section('scripts')
    @include('mis-reports.includes.scripts')
@endsection

@section('content')


  	<!-- Content -->
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">

	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <div class="card-header"> <strong>Bank Book Report</strong> </div>
	            <div class="card-body card-block">
                    <!-- @if(Session::has('message'))
					<div class="alert alert-danger" style="text-align:center;">
						<span class="glyphicon glyphicon-ok" ></span>
						<em> {{ Session::get('message') }}</em>
					</div>
					@endif -->
					@include('include.messages')
	            <form action="" method="post" style="width: 70%;margin: 0 auto;" target="_blank">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">

						<div class="col-md-3">
							<label>Bank Name</label>
							<select name="bank_id" id="bank_id" class="form-control" onchange="populateBranch()" required>
								<option value="" selected disabled > Select </option>
								<?php foreach($banklist as $bank){ ?>
								<option value="<?php echo $bank->master_bank_name; ?>"><?php echo $bank->master_bank_name; ?></option>
								<?php } ?>
	                        </select>
						</div>

		                <div class="col-md-3">
                            <label>Branch <span>(*)</span></label>
                            <select class="form-control" name="bank_branch_id" id="bank_branch_id" required>
							<option value="" selected disabled > Select </option>
								<?php foreach($banklist as $bank){ ?>
								<option value="<?php echo $bank->branch_name; ?>"><?php echo $bank->branch_name; ?></option>
								<?php } ?>
                            </select>
                        </div>


						<div class="col-md-3">
							<label>From Date</label>
							 <input type="date"  name="from_date" class="form-control" value="" />
						</div>

						<div class="col-md-3">
							<label>To Date</label>
							 <input type="date"  name="to_date" class="form-control" value="" />
						</div>


	                </div>



	                <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
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
            url:'{{url('company/get-company-bank-pay')}}/'+bank_name,
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
@include('attendance.partials.scripts')

@endsection
