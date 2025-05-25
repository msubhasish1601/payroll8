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
<h5><?php if(empty($coa_details->id)){ ?>Add <?php } ?>Chart Of Account</h5>
</div>
<div class="col-md-6">

               <span class="right-brd" style="padding-right:15x;">
                <ul class="">
                    <li><a href="#">Account Master</a></li>
                    <li>/</li>
                    <li><a href="#">Chart Of Account</li>
                    <li>/</li>
                    <li class="active">Add Chart Of Account</li>
            
                </ul>
            </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card"> 
                        <div class="card">
                            <!-- <div class="card-header">
                            <strong><?php if(empty($coa_details->id)){ ?>Add <?php } ?>Chart Of Account</strong>
                             
                            </div> -->
                            <div class="card-body card-block">
                            <form action="{{ url('masters/coa') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if(!empty($coa_details->id)){ echo $coa_details->id; }  ?>">
                                <div class="row form-group">                                    
								    
									<div class="col-md-3">
                                        <label class=" form-control-label">Account Type <span>(*)</span></label>
                                          <select name="account_type" id="account_type" class="form-control" onchange="selectAccountname()" required> 
                                            <option value="">Select Account</option>
                                            <option value="assets"<?php if(!empty($coa_details->account_type)){ if($coa_details->account_type=='assets'){echo "selected"; } } ?>>Assets</option>
                                            <option value="liabilities" <?php if(!empty($coa_details->account_type)){ if($coa_details->account_type=='liabilities'){echo "selected"; } } ?>>Liabilities</option>
                                            <option value="expenses" <?php if(!empty($coa_details->account_type)){ if($coa_details->account_type=='expenses'){echo "selected"; } } ?>>Expenses</option>
                                            <option value="income" <?php if(!empty($coa_details->account_type)){ if($coa_details->account_type=='income'){echo "selected"; } } ?>>Income</option>
                                          </select>
										@if ($errors->has('account_type'))
											<div class="error" style="color:red;">{{ $errors->first('account_type') }}</div>
										@endif
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-control-label">Account Name <span>(*)</span></label>
                                          <select name="account_name" id="account_name" class="form-control" onchange="generateCode()" required> 
                                            
                                           </select>
                                           @if ($errors->has('account_name'))
                                            <div class="error" style="color:red;">{{ $errors->first('account_name') }}</div>
                                        @endif 
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-control-label">Code <span>(*)</span></label>
                                        <input type="text" name="coa_code" id="coa_code" class="form-control" value="<?php if(!empty($coa_details->coa_code)){ echo $coa_details->coa_code; }  ?>" required readonly>
                                        @if ($errors->has('coa_code'))
                                            <div class="error" style="color:red;">{{ $errors->first('coa_code') }}</div>
                                        @endif
                                    </div>


                                    <div class="col-md-3">
                                        <label class=" form-control-label">Head Name<span>(*)</span></label>
                                         <input type="text" name="head_name" class="form-control" value="<?php if(!empty($coa_details->head_namehead_name)){ echo $coa_details->head_namehead_name; }  ?>" required>
                                        @if ($errors->has('head_name'))
                                            <div class="error" style="color:red;">{{ $errors->first('head_name') }}</div>
                                        @endif
                                    </div> 
                                </div> 
								   
								<div class="row form-group">

									<div class="col-md-3">
                                        <label class=" form-control-label">Accounting Tools<span>(*)</span></label>
                                          <select name="account_tool" id="account_tool" class="form-control" required> 
                                            <option value="">Select Account Tool</option>
                                            <option value="debit"<?php if(!empty($coa_details->account_type)){ if($coa_details->account_type=='debit'){echo "selected"; } } ?>>Debit</option>
                                            <option value="credit" <?php if(!empty($coa_details->account_type)){ if($coa_details->account_type=='credit'){echo "selected"; } } ?>>Credit</option>
                                           
                                          </select>
										@if ($errors->has('account_type'))
											<div class="error" style="color:red;">{{ $errors->first('account_type') }}</div>
										@endif
                                    </div>


                                    <div class="col-md-3">
                                        <label class=" form-control-label">Account Reflect On<span>(*)</span></label>
                                          <select name="account_reflect_on" id="account_reflect_on" class="form-control" required> 
                                            <option value="">Select Account Tool</option>
                                            <option value="pl"<?php if(!empty($coa_details->account_reflect_on)){ if($coa_details->account_reflect_on=='pl'){echo "selected"; } } ?>>PL</option>
                                            <option value="bs" <?php if(!empty($coa_details->account_reflect_on)){ if($coa_details->account_reflect_on=='bs'){echo "selected"; } } ?>>BS</option>
                                           
                                          </select>
                                        @if ($errors->has('account_type'))
                                            <div class="error" style="color:red;">{{ $errors->first('account_type') }}</div>
                                        @endif
                                    </div>

									<div class="col-md-6">
                                        <label class="form-control-label">Description</label>
                                         <textarea rows="5" name='coa_remarks' class="form-control"><?php if(!empty($coa_details->coa_remarks)){ echo $coa_details->coa_remarks; }  ?></textarea>
										@if ($errors->has('coa_remarks'))
											<div class="error" style="color:red;">{{ $errors->first('coa_remarks') }}</div>
										@endif
                                    </div>

								</div> 
									
								<?php if(empty($coa_details->id)){ ?>
								<button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                <?php } ?>
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
       <?php //include("footer.php"); ?>
    </div>
    <!-- /#right-panel -->

@endsection


<script>

    function selectAccountname(){
      var account_type = $("#account_type").val();
     
      $.ajax({
        type:'GET',
        url:'{{url('masters/accounttype')}}/'+account_type,        
        success: function(response){
            var obj = jQuery.parseJSON(response);
    
            option = '<option value="">Select Account Name</option>';
            for (var i=0;i<obj.length;i++){
              option += '<option value="'+ obj[i].account_name + '">' + obj[i].account_name +  '</option>';
            }
            $('#account_name').html(option);            
        }
      });
    }

    function generateCode(){
      var account_type_id = $("#account_type").val();
      var account_name = $("#account_name").val();

      $.ajax({
        type:'GET',
        url:'{{url('masters/coacode')}}/'+account_type_id+'/'+account_name,        
        success: function(response){
            
            if(response=='null'){
                
                $.ajax({
                    type:'GET',
                    url:'{{url('masters/getbasecode')}}/'+account_type_id+'/'+account_name,        
                    success: function(response){
                        var obj = jQuery.parseJSON( response );
                        var final_code = obj.account_code+'/00'+1;
                        $('#coa_code').val(final_code);           
                    }
                });

            }else{

                var obj = jQuery.parseJSON( response );
                var res = obj.coa_code.split("/");
                var set_base_code = parseInt(res[2])+1;
                var set_base_code_length = set_base_code.toString().length;
                if(set_base_code_length==1){
                    var final_code = res[0]+'/'+res[1]+'/00'+set_base_code;

                }else{
                    var final_code = res[0]+'/'+res[1]+'/0'+set_base_code;  
                }
               
                $('#coa_code').val(final_code);  
            }                   
        }
      });
    }

</script>


@section('scripts')
@include('masters.partials.scripts')

@endsection
