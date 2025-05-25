@extends('payroll.layouts.master')

@section('title')
Payroll Information System-Payroll Generation
@endsection

@section('sidebar')
@include('payroll.partials.sidebar')
@endsection

@section('header')
@include('payroll.partials.header')
@endsection


@section('content')
<style>
#bootstrap-data-table th {
    vertical-align: middle;
}

tr.spl td {
    font-weight: 600;
}

table#bootstrap-data-table tr td {
    font-size: 12px;
    padding: 8px 10px;
}
</style>
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add Yearly Employee Encashment</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Payroll Master</a></li>
                        <li>/</li>
                        <li><a href="#">View Yearly Employee Encashment</a></li>
                        <li>/</li>
                        <li class="active">Add Yearly Employee Encashment</li>
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
						<form action="{{url('payroll/save-encashment')}}" method="post" enctype="multipart/form-data" onsubmit="return validate();">
							{{ csrf_field() }}
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_code">Employee Code <span>(*)</span></label>
                                        <select id="emp_code" name="emp_code"
                                            class="form-control employee select2_el" required>
                                            <option selected disabled value="">Select</option>
                                            @foreach($Employee as $emp)
                                            <option value="{{$emp->emp_code}}" @if(old('emp_code')==$emp->emp_code) selected @endif>
                                                {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}} -
                                                {{$emp->old_emp_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_type">Pay Month/Year <span>(*)</span></label>
                                        <select class="form-control select2_el" name="year" id="year" required>

                                        <option value="" selected disabled> Select </option>
                                        <?php
                                        $reportYear=date('Y');
                                        if (date('m') < 4) {
                                            $reportFinancialYear = ($reportYear - 1) . '-' . $reportYear;
                                            $prevFinancialYear = ($reportYear - 2) . '-' . ($reportYear-1);
                                            $reportMinYear = ($reportYear - 1);
                                            $reportMaxYear = $reportYear;
                                            $prevMinYear = ($reportYear - 2);
                                            $prevMaxYear = ($reportYear-1);
                                        } else {
                                            $reportFinancialYear = $reportYear . '-' . ($reportYear + 1);
                                            $prevFinancialYear = ($reportYear-1) . '-' . ($reportYear );
                                            $reportMinYear = $reportYear;
                                            $reportMaxYear = ($reportYear + 1);
                                            $prevMinYear = ($reportYear-1);
                                            $prevMaxYear = ($reportYear);
                                        }
                            
                                        for ($yy = $reportMinYear; $yy <= $reportMinYear; $yy++) {
                                            for ($mm = 4; $mm <= 12; $mm++) {
                                                if ($mm < 10) {
                                                    $month_yr = '0' . $mm . "/" . $yy;
                                                } else {
                                                    $month_yr = $mm . "/" . $yy;
                                                }
                                                ?>
												<option value="<?php echo $month_yr; ?>"  @if(isset($year_new) && $year_new==$month_yr) selected @endif><?php echo $month_yr; ?></option>
											<?php

                                            }
                                        }

                                        for ($yy = $reportMaxYear; $yy <= $reportMaxYear; $yy++) {
                                            for ($mm = 1; $mm <= 3; $mm++) {
                                                if ($mm < 10) {
                                                    $month_yr = '0' . $mm . "/" . $yy;
                                                } else {
                                                    $month_yr = $mm . "/" . $yy;
                                                }
                                                ?>
												<option value="<?php echo $month_yr; ?>"  @if(isset($year_new) && $year_new==$month_yr) selected @endif><?php echo $month_yr; ?></option>
											<?php

                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="leave_enc">Leave Encashment <span>(*)</span></label>
                                        <input class="form-control" id="leave_enc" step="any" type="number" value="{{ old('leave_enc')==''?0: old('leave_enc') }}" name="leave_enc" required  />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hta">HTA <span>(*)</span></label>
                                        <input class="form-control" id="hta" step="any" type="number" value="{{ old('hta')==''?0: old('hta') }}" name="hta" required  />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="commision">Commission <span>(*)</span></label>
                                        <input class="form-control" id="commision" step="any" type="number" value="{{ old('commision')==''?0: old('commision') }}" name="commision" required  />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="oth_income">Other Income <span>(*)</span></label>
                                        <input class="form-control" id="oth_income" step="any" type="number" value="{{ old('oth_income')==''?0: old('oth_income') }}" name="oth_income" required  />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="other_perks">Other Perks <span>(*)</span></label>
                                        <input class="form-control" id="other_perks" step="any" type="number" value="{{ old('other_perks')==''?0: old('other_perks') }}" name="other_perks" required  />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="medical_reimbersement">Medical Eeimbursement <span>(*)</span></label>
                                        <input class="form-control" id="medical_reimbersement" step="any" type="number" value="{{ old('medical_reimbersement')==''?0: old('medical_reimbersement') }}" name="medical_reimbersement" required  />
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i>&nbsp;Save</button>
                                    <button type="reset" class="btn btn-danger btn-sm" onclick="select2_reset();"><i class="fa fa-ban"></i>&nbsp;Reset</button>
                                </div>
                            </div>
							<p>(*) marked fields are mandatory</p>
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
<script>
    $(document).ready(function() {
        initailizeSelect2();
    });
    // Initialize select2
    function initailizeSelect2() {

        $(".select2_el").select2();
    }

    function select2_reset(){
        $(".select2_el").val(null).trigger('change');
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