@extends('masters.layouts.master')

@section('title')
Payroll Information System-Company
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
<style>
		#bootstrap-data-table th{vertical-align:middle;}tr.spl td {font-weight: 600;}table#bootstrap-data-table tr td {font-size: 12px;padding: 8px 10px;}
	</style>
 <!-- Content -->
  <div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
	<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Opening Balance  Generation for Account (@php print_r($month_yr) ;@endphp

)</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Account Master</a></li>
                                
								<li>/</li>
                                <li class="active">Account opening balance</li>
						
                            </ul>
                        </span>
</div>
</div>
      <!-- Widgets  -->
      <div class="row">
        <div class="main-card">


					<div class="card">
						<!----------------view----------------->
					  <!-- <div class="card-header">
                             <strong class="card-title">Opening Balance  Generation for Account (@php print_r($month_yr) ;@endphp

                               )</strong>
					  </div> -->
						<div class="card-body card-block">
							<div class="payroll-table table-responsive" style="overflow-x:scroll;">
								  @if(Session::has('message'))
                                <div class="alert alert-success" style="text-align:center;">
                                    <span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif
                             <form action="{{url('masters/vw-opening-balance')}}" method="post">
                                                                {{csrf_field()}}


<input type="hidden" name="acc_code1" value="@php print_r($acc_code) ;@endphp">

<input type="hidden" name="mainmonth_yr" value="@php print_r($month_yr) ;@endphp">
								<table id="bootstrap-data-table" class="table table-striped table-bordered">
					        <thead style="text-align:center;vertical-align:middle;">
					          <tr>

											<th rowspan="2">Group Code</th>
											<th rowspan="2">Group Name</th>
											<th rowspan="2">Account Code</th>
                                            <th rowspan="2">Account Name</th>
                                            <th rowspan="2">Month Yr</th>
                                            <th rowspan="2">Financial Year</th>
                                            <th rowspan="2">Opening Balance</th>
                                            <th rowspan="2">Type</th>

					        	</tr>

					        </thead>

					        <tbody>

					        	 @php $space=' ';

					        	 @endphp
					        	  @foreach ($employee_gpf as $val)

                                  <tr>
                                    <td>{{ $val['group_code']}}
                             <input type="hidden" class="form-control" name="group_code[]" style="width:50px;" value="{{ $val['group_code']}}"  >
                             </td>
                             <td>{{ $val['group_name']}}
                             <input type="hidden" class="form-control" name="group_name[]" style="width:50px;" value="{{ $val['group_name']}}"  >
                             </td>
                             <td>{{ $val['account_code']}}
                             <input type="hidden" class="form-control" name="account_code[]" style="width:50px;" value="{{ $val['account_code']}}"  >
                             </td>
                             <td>{{ $val['account_name']}}
                             <input type="hidden" class="form-control" name="account_name[]" style="width:50px;" value="{{ $val['account_name']}}"  >
                             </td>
                             <td>{{ $val['month_yr']}}
                             <input type="hidden" class="form-control" name="month_yr[]" style="width:50px;" value="{{ $val['month_yr']}}"  >
                             </td>
                             <td>{{ $val['financial_year']}}
                             <input type="hidden" class="form-control" name="financial_year[]" style="width:50px;" value="{{ $val['financial_year']}}"  >
                             </td>
                             <td><input type="text" class="form-control" name="open_bal[]"
                                     value="{{$val['opening_balance']}}"	/>  </td>
                                     <td><select name="type[]"   class="form-control" style="width:70px;">
                                        <option value="DR" @php if($val['type']=='DR') {echo 'selected' ;} @endphp>DR</option>
                                        <option value="CR"  @php if($val['type']=='CR') {echo 'selected' ;} @endphp>CR</option>
                                        </select> </td>

					        	</tr>

					        	@endforeach
					        </tbody>

					          <tfoot>
					            <tr>
					              <td colspan="32" style="border:none;">

									<button type="submit" class="btn btn-danger btn-sm">Save</button>

					              </td>
					            </tr>
						 </tfoot>


					      </table>
                          </form>
							</div>
						</div>
						<!------------------------------->

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
	@include('masters.partials.scripts')
	<script>


		$('#all').click(function(event) {

			if(this.checked) {
				//alert("test");
				// Iterate each checkbox
				$(':checkbox').each(function() {
					this.checked = true;
				});
			} else {
				$(':checkbox').each(function() {
					this.checked = false;
				});
			}
		});

		$('input[type=text]' ).on('blur',function() {
		   var bid = this.id; // button ID
		   var trid = $(this).closest('tr').attr('id'); // table row ID
		   //alert(trid);
		   var emp_gross_pay = $('#emp_total_gross_'+trid).val();
		   var emp_ltc= $('#ltc_'+trid).val();
		   var emp_cea= $('#cea_'+trid).val();
		   var emp_travelling_allowance= $('#tra_'+trid).val();
		   var emp_daily_allowance= $('#dla_'+trid).val();
		   var emp_spcl_allowance= $('#spcl_allowance_'+trid).val();
		   var emp_adv= $('#adv_'+trid).val();
		   var emp_adjustment= $('#adjadv_'+trid).val();
		   var emp_medical= $('#mr_'+trid).val();
		   var other_addition=$('#other1_'+trid).val();

		   var total_gross_on_blur=(parseInt(emp_gross_pay)+parseInt(emp_ltc) + parseInt(emp_cea)+ parseInt(emp_travelling_allowance) + parseInt(emp_daily_allowance) + parseInt(emp_spcl_allowance) + parseInt(emp_adv) + parseInt(emp_adjustment) +parseInt(emp_medical)+ parseInt(other_addition));
		   var emp_gross_pay = $('#emp_total_gross_'+trid).val(total_gross_on_blur);
    	   var Tot_deduction= $('#emp_total_deduction_'+trid).val();
		   var netsal=(parseInt(total_gross_on_blur)-parseInt(Tot_deduction));
		   $('#emp_net_salary_'+trid).val(netsal);

		 });


		 $('input[type=text]' ).on('blur',function() {
		   var bid = this.id;
		   var trid = $(this).closest('tr').attr('id');
		   var emp_nps= $('#nps_'+trid).val();
		   var emp_gsli= $('#gsli_'+trid).val();
		   var emp_income_tax= $('#income_tax_'+trid).val();
		   var emp_tax= $('#tax_'+trid).val();
		   var emp_other2= $('#other2_'+trid).val();
		   var emp_total_deduction=(parseInt(emp_nps)+parseInt(emp_gsli) + parseInt(emp_income_tax)+ parseInt(emp_tax) + parseInt(emp_other2));
		   $('#emp_total_deduction_'+trid).val(emp_total_deduction);
		   var emp_gross_pay = $('#emp_total_gross_'+trid).val();
		   var netsal=(parseInt(emp_gross_pay)-parseInt(emp_total_deduction));
		   $('#emp_net_salary_'+trid).val(netsal);

		 });

	</script>
@endsection
