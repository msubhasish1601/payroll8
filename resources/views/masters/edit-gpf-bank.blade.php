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

            <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Edit GPF Bank Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Bank Master</a></li>
                                <li>/</li>
                                <li><a href="#">GPF Bank</a></li>
                                <li>/</li>
                                <li class="active">Edit GPF Bank Master</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card"> 
                        <div class="card">
                            <!-- <div class="card-header">
                            	
                            	<strong>Edit GPF Bank Master</strong>
                            	
                            </div> -->
                            <div class="card-body card-block">
                            <form action="{{ url('masters/update-gpfbank') }}" method="post" enctype="multipart/form-data">
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                 <input type="hidden" name="bankid" value="{{ ((isset($bankdetails) && !empty($bankdetails))?$bankdetails['id']:'')}}">
                                <div class="row form-group">                                    
									<div class="col-md-4">
                                    <label class=" form-control-label">Enter Bank Name <span>(*)</span></label>
                                  
                                    <select name="bank_id" id="bank_id"  class="form-control" <?php if(!empty($bankdetails['branch_name'])){ echo "disabled";} ?> required>
                                      <option value="">Select Bank Name</option>
                                        @foreach($MastersbankName as $value):
                 						             <option value="{{ $value->master_bank_name }}" <?php if(!empty($bankdetails['id'])){ if( $bankdetails['bank_name'] == $value->id){  echo "selected"; } } ?>>
                                             {{ $value->master_bank_name }} 
                                         </option>
                                        @endforeach
                                    </select>

                                    </div>

									                  <div class="col-md-4">
                                        <label class="form-control-label">Enter Branch Name <span>(*)</span></label>
                                        <input type="text" id="branch_name" name="branch_name"  class="form-control" value="{{ (isset($bankdetails['branch_name']) && !empty($bankdetails['branch_name']))?$bankdetails['branch_name']:old('branch_name')}}" <?php if(!empty($bankdetails['branch_name'])){ echo "readonly";} ?> required />
                    										@if ($errors->has('branch_name'))
                    											<div class="error" style="color:red;">{{ $errors->first('branch_name') }}</div>
                    										@endif
                                    </div>


                                    <div class="col-md-4">
                                        <label class=" form-control-label">IFSC Code <span>(*)</span></label>
                                        <input type="text" id="ifsc_code" name="ifsc_code"  class="form-control" value="{{ (isset($bankdetails['ifsc_code']) && !empty($bankdetails['ifsc_code']))?$bankdetails['ifsc_code']:old('ifsc_code')}}" <?php if(!empty($bankdetails['ifsc_code'])){ echo "readonly";} ?> required />
                                        @if ($errors->has('ifsc_code'))
                                            <div class="error" style="color:red;">{{ $errors->first('ifsc_code') }}</div>
                                        @endif
                                    </div>


                                   </div> 
								   
									                  <div class="row form-group">
									
    									                <div class="col-md-4">
                                            <label class=" form-control-label">Enter MICR Code <span>(*)</span></label>
                                            <input type="text" id="micr_code" name="micr_code"  class="form-control" value="{{ (isset($bankdetails['micr_code']) && !empty($bankdetails['micr_code']))?$bankdetails['micr_code']:old('micr_code')}}" <?php if(!empty($bankdetails['micr_code'])){ echo "readonly";} ?> required />
                      										@if ($errors->has('micr_code'))
                      											<div class="error" style="color:red;">{{ $errors->first('micr_code') }}</div>
                      										@endif
                                        </div>

                                        <div class="col-md-4">
                                                <label class=" form-control-label">Opening Balance <span>(*)</span></label>
                                            <input type="text" id="opening_balance" name="opening_balance"  class="form-control" value="{{ (isset($bankdetails['opening_balance']) && !empty($bankdetails['opening_balance']))?$bankdetails['opening_balance']:old('opening_balance')}}" <?php if(!empty($bankdetails['opening_balance'])){ echo "readonly";} ?> required />
                                            @if ($errors->has('opening_balance'))
                                                <div class="error" style="color:red;">{{ $errors->first('opening_balance') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-control-label">Financial Year<span>(*)</span></label>
                                            <select name="financial_year" required class="form-control" <?php if(!empty($bankdetails['id'])){ echo "disabled";} ?>>
                                                <option value="">Choose a year</option>
                                                <?php $starting_year  =date('Y', strtotime('-10 year'));
                                                   $ending_year = date('Y', strtotime('+10 year'));
                                                   $current_year = date('Y');
                                                   for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                                       echo '<option value="'.$starting_year.'-'.($starting_year+1).'"';
                                                       if( $starting_year ==  $current_year ) {
                                                              echo ' selected="selected"';
                                                       }
                                                       echo ' >'.$starting_year.'-'.($starting_year+1).'</option>';
                                                   }               ?>                                               
                                            </select>
                                        
                                            @if ($errors->has('financial_year'))
                                                <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                            @endif
                                        </div>

									</div> 


									<div class="row form-group">
										
                                    <div class="col-md-4">
                                        	<label class=" form-control-label">Status <span>(*)</span></label>

                                        	<select name="bank_status" required id="bank_status"  class="form-control"  >
                 							<option value="active" <?php if(!empty($bankdetails['id'])){ if( $bankdetails['bank_status'] == "active"){  echo "selected"; } } ?>>
                                             Active</option>
                                       		<option value="deactive" <?php if(!empty($bankdetails['id'])){ if( $bankdetails['bank_status'] == "deactive"){  echo "selected"; } } ?>>
                                             Deactive
                                         </option>
                                    </select>
                                        
										@if ($errors->has('bank_status'))
											<div class="error" style="color:red;">{{ $errors->first('bank_status') }}</div>
										@endif
                                    </div>

									</div>	
									
									 <button type="submit" class="btn btn-danger btn-sm">Submit
                                </button>
                                
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
        @endsection

<script>


</script>  


        @section('scripts')
@include('masters.partials.scripts')

@endsection


