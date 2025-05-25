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
            <h5 class="card-title">Add Account</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Account Managemnt</a></li>
                                
								<li>/</li>
                                <li><a href="#">Account List</a></li>
                                <li>/</li>
                                <li class="active">Add Account</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card"> 
                        <div class="card">
                            <!-- <div class="card-header">
                            <strong><?php if(empty($account_details->id)){ ?>Add <?php } ?>Account</strong>
                            </div> -->
                            <div class="card-body card-block">
                            <form action="{{ url('masters/accountmaster') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if(!empty($account_details->id)){ echo $account_details->id; }  ?>">
                                <div class="row form-group">                                    
								    
									<div class="col-md-4">
                                        <label class=" form-control-label">Account Group <span>(*)</span></label>
                                          <select name="account_type" class="form-control" required> 
                                            <option value="">Select Account</option>
                                            <option value="assets"<?php if(!empty($account_details->account_type)){ if($account_details->account_type=='assets'){echo "selected"; } } ?>>Assets</option>
                                            <option value="liabilities" <?php if(!empty($account_details->account_type)){ if($account_details->account_type=='liabilities'){echo "selected"; } } ?>>Liabilities</option>
                                            <option value="expenses" <?php if(!empty($account_details->account_type)){ if($account_details->account_type=='expenses'){echo "selected"; } } ?>>Expenses</option>
                                            <option value="income" <?php if(!empty($account_details->account_type)){ if($account_details->account_type=='income'){echo "selected"; } } ?>>Income</option>
                                          </select>
										@if($errors->has('account_type'))
											<div class="error" style="color:red;">{{ $errors->first('account_type') }}</div>
										@endif
                                    </div>

                                    <div class="col-md-4">
                                        <label class=" form-control-label">Account Name <span>(*)</span></label>
                                    
                                        <select name="account_name" id="account_name" class="form-control" required onchange="getAccountHead()" required>

                                         <option value="">Select Account Name </option>   
                                        @foreach($account_head_list as $value):
                                        <option value="{{ $value->account_master_head }}" data-code="{{ $value->account_code }}">
                                             {{ $value->account_master_head }} 
                                         </option>
                                        @endforeach
                                        </select>
                                        @if ($errors->has('account_name'))
                                            <div class="error" style="color:red;">{{ $errors->first('account_name') }}</div>
                                        @endif
                                    </div>


                                    <div class="col-md-4">
                                        <label class="form-control-label">Code <span>(*)</span></label>
                                        <input type="text" name="account_code" id="account_code" class="form-control" value="<?php if(!empty($account_details->account_code)){ echo $account_details->account_code; }  ?>" required readonly>
                                        @if($errors->has('account_code'))
                                            <div class="error" style="color:red;">{{ $errors->first('account_code') }}
                                            </div>
                                        @endif
                                    </div>

                                </div> 
								   
								<div class="row form-group">
									<div class="col-md-6">
                                        <label class="form-control-label">Description</label>
                                        <textarea rows="5" name='account_desc' class="form-control" id="account_desc"><?php if(!empty($account_details->account_desc)){ echo $account_details->account_desc; }  ?></textarea>
                                    </div>

								</div> 
									
								<button type="submit" class="btn btn-danger btn-sm">Submit</button>

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
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>      
<script>

    function getAccountHead(){
        //var account_head_id = $("#account_name option:selected").value();
        var account_code = $('select#account_name').find(':selected').data('code');
        $('#account_code').val(account_code);
    }

</script>   
@endsection
