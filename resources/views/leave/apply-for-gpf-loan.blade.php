@extends('leave.layouts.master')

@section('title')
Apply for GPF Loan
@endsection

@section('sidebar')
	@include('leave.partials.sidebar')
@endsection

@section('header')
	@include('leave.partials.header')
@endsection





@section('content')
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                  <?php //echo "<pre>" ; print_r($tour_apply->duration); exit; ?>
                    <div class="main-card">
                        <div class="card">
                            <div class="card-header"><strong class="card-title">Apply for GPF Withdrawal</strong></div>
                            <div class="card-body card-block">
                                <form action="{{ url('employee-corner/gpf-loan-apply') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="closing_balance" id="closing_balance" @if(!empty($fund_check)) value="{{ $fund_check->closing_balance }}" @endif>

											<div class="clearfix"></div>
									<div class="lv-due" style="border:none;">

										<div class="row form-group lv-due-body">
                                        <div class="col-md-4">
										<label for="text-input" class=" form-control-label">Date of Apply</label>
										<input type="date" class="form-control" name="from_date" id="from_date" value=""  required>
										@if ($errors->has('from_date'))
											<div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
										@endif
										</div>
										<div class="col-md-4">
										<label for="text-input" class=" form-control-label">GPF Withdrawal Amount</label>
										<input type="number" class="form-control" name="loan_amt" id="loan_amt" value="" onchange="check_fund();" required>
										@if ($errors->has('loan_amt'))
											<div class="error" style="color:red;">{{ $errors->first('loan_amt') }}</div>
										@endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email-input" class=" form-control-label">Purpose of GPF Withdrawal <span>(*)</span></label>
                                            <input type="text" class="form-control" id="purpose" name="purpose" value="">
                                            @if ($errors->has('purpose'))
                                                <div class="error" style="color:red;">{{ $errors->first('purpose') }}</div>
                                            @endif
                                            </div>


										</div>
									</div>


                                    <div class="row form-group" style="margin-top:15px;">


								   <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm">Apply</button>
										{{-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> --}}
										</div>
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

@section('scripts')
@include('leave.partials.scripts')
<script>
// function get_duration()
// {
// 	var from_date= $("#from_date").val();
// 	var to_date= $("#to_date").val();

// 	var fromdate = new Date(from_date);
// 	var todate = new Date(to_date);

// 	if(todate < fromdate){
// 		$("#from_date").val("");
// 		$("#to_date").val("");
// 		$('#duration').val("");
// 		alert('Please provide valid date!');
// 	}

// 	const diffTime = Math.abs(todate.getTime() - fromdate.getTime());
//     const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
//     	// alert(diffDays);
// 	$('#duration').val(diffDays);
// }

function check_fund()
{
    var loan_amt= $("#loan_amt").val();
    var closing_balance = $("#closing_balance").val();

    if(parseFloat(closing_balance) < parseFloat(loan_amt))
    {
        const wait = time => new Promise((resolve) => setTimeout(resolve, time));
        alert('You have insufficient fund!!!');
        $("#loan_amt").val("");
        $("#from_date").val();
        wait(1000).then(() => window.location='{{ url('employee-corner/gpf-loan-apply') }}'); // 'Hello!

    }
}



</script>
@endsection
