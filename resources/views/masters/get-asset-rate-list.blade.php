@extends('masters.layouts.master')

@section('title')
BELLEVUE - Masters Module
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


  	<!-- Content -->
  	<div class="content">
	    <!-- Animated -->
	    <div class="animated fadeIn">
        <div class="animated fadeIn">
    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Asset Depreciation Rate List</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Settings</a></li>
                                
								<li>/</li>
                                <li class="active">Asset Depreciation Rate List</li>
						
                            </ul>
                        </span>
</div>
</div>

	      <!-- Widgets  -->
	      <div class="row">
	        <div class="main-card">
	          <div class="card">
	            <!-- <div class="card-header"> <strong>Asset Depreciation Rate List</strong> </div> -->
	            <div class="card-body card-block">
                    <!-- @if(Session::has('message'))
					<div class="alert alert-success" style="text-align:center;">
						<span class="glyphicon glyphicon-ok" ></span>
						<em> {{ Session::get('message') }}</em>
					</div>
					@endif -->
                    @include('include.messages')
	            <form action="{{ url('depreciation/rate-table-data') }}" method="post" style="width: 70%;margin: 0 auto;">
	              	  {!! csrf_field() !!}
	                <div class="row form-group">
						<div class="col-md-6">
							<label>Choose Year</label>
							<select name="financial_year"  class="form-control" required>
								<option value="">Please Select Your Year </option>
								<?php  $cur_year = date('Y');
									for ($i=0; $i<=5; $i++) {
										$years= $cur_year--;
										$previous_year = $years+1;
										?>
										<option value="<?php echo $years.'-'.$previous_year ?>" @if(isset($financial_year) && $financial_year==$years.'-'.$previous_year) selected @endif><?php echo $years.'-'.$previous_year ?> </option>

								<?php } ?>
							</select>
						</div>
<div class="col-md-6">
							<label>Choose Type</label>
							<select name="type"  class="form-control" required>
								<option value="">Please Select Your Type </option>
									<option value="Tangible"  @if(isset($type) && $type=='Tangible') selected @endif>Tangible </option>
										<option value="Intangible"  @if(isset($type) && $type=='Intangible') selected @endif>Intangible</option>
							</select>
						</div>
	                </div>

	                <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
	                </div>

                </form>
                @if(!empty($result))
                <form action="{{ url('depreciation/rate-save-data') }}" method="post" >
                  {{ csrf_field() }}
                <div class="content">
                    <!-- Animated -->
                    <div class="animated fadeIn">
                        <!-- Widgets  -->
                        <div class="row">

                            <div class="main-card">
                                <div class="card">
<!-- 
                                        <div class="card-header">
                                            <strong class="card-title">Asset Depreciation Rate List</strong>
                                        </div> -->
                                        
                                        <br/>
                                         <div class="clear-fix">
                                        <table id="bootstrap-data-table" class="table table-stripe table-bordered dataTable no-footer" >
                                            <thead>
                                               
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Item</th>
                                                    <th>Account Code</th>
													 <th>Year</th>
                                                    <th>Rate</th>
                                                   

                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($result as $key=>$value)   
                                                <tr id="{{ $key }}">
                                                    <td>{{ $loop->iteration}}</td>
                                                    <td>{{ $value['item']}}<input type="hidden" name="item[]" id="item{{ $key }}" value="{{ $value['item'] }}"></td>
                                                    <td>{{ $value['code']}}<input type="hidden" name="code[]" id="code{{ $key }}" value="{{ $value['code']}}"></td>
                                                    <td>{{ $value['financial_year']}}<input type="hidden" name="financial_year[]" id="financial_year{{ $key }}" value="{{ $value['financial_year']}}"></td>
                                                    <td><input type="text" name="rate[]" id="rate{{ $key }}" value="{{ $value['rate']}}"></td>
                                                   
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                        <div class="col-md-4 btn-up">
                                            <button type="submit" class="btn btn-danger btn-sm" name="savedata">Save </button>
                                        </div>

                                </div>

                            </div>

                            </div>



                        </div>
                        <!-- /Widgets -->



                    </div>
                    <!-- .animated -->
                </div>
                
                </form>
                @else
                <div class="content">
                    <!-- Animated -->
                    <div class="animated fadeIn">
                        <!-- Widgets  -->
                        <div class="row">

                            <div class="main-card">
                                <div class="card">

                                        <!-- <div class="card-header">
                                            <strong class="card-title">Asset Depreciation Rate List</strong>
                                        </div> -->
                                        <!-- <div class="aply-lv">
                                        <a href="add-employee-type.php" class="btn btn-default">Add Employee Type <i class="fa fa-plus"></i></a>
                                    </div> -->
                                        <br/>
                                         <div class="clear-fix">
                                        <table id="bootstrap-data-table" class="table table-stripe table-bordered dataTable no-footer" >
                                            <thead>
                                              
                                                <tr>
                                                    
                                                    <th>Sl. No.</th>
                                                    <th>Item</th>
                                                    <th>Account Code</th>
													<th>Year</th>
                                                    <th>Rate</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                            </tbody>
                                        </table>


                                </div>

                            </div>

                            </div>



                        </div>
                        <!-- /Widgets -->



                    </div>
                    <!-- .animated -->
                </div>
                <!-- /.content -->
                @endif
               <?php //include("footer.php"); ?>
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

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script>


	$('input[type=text]' ).on('blur',function() {

        var bid = this.id; // button ID
        var trid = $(this).closest('tr').attr('id');

        var gross_openingbalance=$('#gross_openingbalance'+trid).val();
        var gross_addition=$('#gross_addition'+trid).val();
        var gross_deduction=$('#gross_deduction'+trid).val();
        
        var gross_closingbalance=(parseInt(gross_openingbalance)+parseInt(gross_addition) - parseInt(gross_deduction));
        $('#gross_closingbalance'+trid).val(gross_closingbalance);

        var depreciation_opening_balance=$('#depreciation_opening_balance'+trid).val();
        var depreciation= $('#depreciation'+trid).val();
        var depreciation_deduction= $('#depreciation_deduction'+trid).val();

        var depreciation_closing_balance=(parseInt(depreciation_opening_balance)-parseInt(depreciation) - parseInt(depreciation_deduction));
        $('#depreciation_closing_balance'+trid).val(depreciation_closing_balance);

        var netclosing_balance=(parseInt(gross_closingbalance)+parseInt(depreciation_closing_balance));

        $('#netclosing_balance'+trid).val(netclosing_balance);
    });    

</script>

@endsection





@section('scripts')
@include('masters.partials.scripts')

@endsection

