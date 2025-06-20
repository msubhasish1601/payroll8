@extends('loan.layouts.master')

@section('title')
Loan Information System - Loan
@endsection

@section('sidebar')
@include('loan.partials.sidebar')
@endsection

@section('header')
@include('loan.partials.header')
@endsection


@section('content')
<!-- Content -->
<div class="content">
	<!-- Animated -->
	<div class="animated fadeIn">
	    <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">View Adjusted Loan</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Loans</a></li>
                        <li>/</li>
                        <li><a href="#">View Adjusted Loan</a></li>
                    </ul>
                </span>
            </div>
        </div>
		<!-- Widgets  -->
		<div class="row">
			<div class="main-card">
				<div class="card">
                @include('include.messages')

					<div class="card-body card-block">
						<form action="{{url('loans/update-loan-adjustment')}}" method="post" enctype="multipart/form-data" >
							{{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="{{$id}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_id">Loan ID</label>
                                        <input type="text" name="loan_id" id="loan_id" value="{{$loan_details->loan_id}}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_code">Employee Code <span>(*)</span></label>
                                        <select id="emp_code" name="emp_code"
                                            class="form-control employee select2_el" required disabled>
                                            <option selected disabled value="">Select</option>
                                            @foreach($Employee as $emp)
                                            <option value="{{$emp->emp_code}}" @if($loan_details->emp_code==$emp->emp_code) selected @endif>
                                                {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}} -
                                                {{$emp->old_emp_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_type">Loan Type <span>(*)</span></label>
                                        <select id="loan_type" name="loan_type"
                                            class="form-control employee select2_el" required disabled>
                                            <option selected disabled value="">Select</option>
                                            <option value="PF" @if($loan_details->loan_type=="PF") selected @endif>PF Loan</option>
                                            <option value="SA" @if($loan_details->loan_type=="SA") selected @endif>Salary Advance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_month">Loan Start Date <span>(*)</span></label>
                                        <input class="form-control" id="start_month" type="date" value="{{ $loan_details->start_month }}" name="start_month"  required disabled/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_amount">Loan Amount <span>(*)</span></label>
                                        <input class="form-control" id="loan_amount" type="number" value="{{ $loan_details->loan_amount }}" name="loan_amount" required  onkeyup="cal_installment();" disabled/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="installment_amount">Installment Amount <span>(*)</span></label>
                                        <input class="form-control" id="installment_amount" type="number" value="{{ $loan_details->installment_amount }}" name="installment_amount"  required  onkeyup="cal_installment();" disabled/>
                                        <input type="hidden" name="no_installments" id="no_installments" value="{{ old('no_installments') }}" class="form-control" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="deduction">Deduction <span>(*)</span></label>
                                        <select id="deduction" name="deduction"
                                            class="form-control select2_el" required disabled>
                                            <option selected disabled value="">Select</option>
                                            <option value="Y" @if($loan_details->deduction=="Y") selected @endif>Yes</option>
                                            <option value="N" @if($loan_details->deduction=="N") selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_balance">Loan Balance</label>
                                        <input type="text" name="loan_balance" id="loan_balance" value="{{$loan_balance}}" class="form-control" readonly disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_balance">Adjust Amount</label>
                                        <input type="text" name="adjust_amount" id="adjust_amount" value="{{$loan_details->adjust_amount}}" class="form-control" readonly disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_balance">Adjust Date</label>
                                        <input type="date" name="adjust_date" id="adjust_date" value="{{$loan_details->adjust_date}}" class="form-control" readonly disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="adjust_remarks">Adjustment Remarks</label>
                                        
                                        <textarea name="adjust_remarks" id="adjust_remarks"  rows="3" class="form-control" required disabled>{{$loan_details->adjust_remarks}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="history.back();">Back</button>
                                    
                                </div>
                            </div>
							
						</form>
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

@section('scripts')
@include('payroll.partials.scripts')

<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initailizeSelect2();
        cal_installment();
    });
    // Initialize select2
    function initailizeSelect2() {

        $(".select2_el").select2();
    }

    function select2_reset(){
        $(".select2_el").val(null).trigger('change');
    }

    function cal_installment(){
        var loan_amount=$("#loan_amount").val();
        if(loan_amount=='') loan_amount=0;
        var installment_amount=$("#installment_amount").val();
        if(installment_amount=='') installment_amount=0;
        if(installment_amount>0){
            var installments=Math.round((eval(loan_amount)/eval(installment_amount))*100)/100;
            $("#no_installments").val(installments);
        }else{
            if(loan_amount>0){
                $("#no_installments").val(1);
            }else{
                $("#no_installments").val(0);
            }
        }
    }

    function validate(){
        //alert($("#installment_amount").val());
        if(eval($("#installment_amount").val())>eval($("#loan_amount").val())){
            alert("Installment Amount can't be greater than Loan Amount.");
            $("#installment_amount").focus();
            return false;
        }
        return true;
    }
</script>
@endsection