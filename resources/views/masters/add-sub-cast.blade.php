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
            <h5 class="card-title">Add sub caste Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                
								<li>/</li>
                                <li><a href="#">sub caste Master</a></li>
                                <li>/</li>
                                <li class="active">Add sub caste Master</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">
                            <!-- <div class="card-header">
                                <strong>Add Sub Caste Master</strong>
                            </div> -->
                            <div class="card-body card-block">
                                <form action="{{ url('masters/save-sub-cast') }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row form-group">
									<div class="col-md-6">
                                        <label for="text-input" class=" form-control-label">Select Caste <span>(*)</span></label>
										<?php //print_r($getCast); exit; ?>
									<select class="form-control" name="cast_id" required>
	  <option value='' selected disabled>Select</option>

		@foreach($getCast as $cast)
      <option value='{{ $cast->id }}'<?php if(app('request')->input('id')){ if( $getCast[0]->cast_name == $cast->cast_name ){ echo 'selected';}   }  ?> <?php if(old('cast_id') == $cast->cast_name){ echo "selected"; } ?> >{{ $cast->cast_name }}</option>
										@endforeach
									</select>



											@if ($errors->has('cast_id'))
												<div class="error" style="color:red;">{{ $errors->first('cast_id') }}</div>
											@endif
										</div>
                                   

									<div class="col-md-6">
                                        <label for="email-input" class=" form-control-label">Enter Sub Caste Name <span>(*)</span></label>
                                        <input type="text" id="designation_name" name="sub_cast_name" required  class="form-control" value="<?php if(app('request')->input('id')){  echo $getCast[0]->sub_cast_name;   }  ?>{{ old('sub_cast_name') }}">
										@if ($errors->has('sub_cast_name'))
											<div class="error" style="color:red;">{{ $errors->first('sub_cast_name') }}</div>
										@endif
                                    </div>
                                        <?php if(app('request')->input('id')){  ?>
                                        
                                        <div class="col-md-6">
                                        <label for="text-input" class=" form-control-label">Status<span>(*)</span></label>
                                                    <select class="form-control" name="cast_status">	
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                    </select>
											
					</div>
                                        
                                        <?php  } ?>
                                   </div> 
									 
									
									 <button type="submit" class="btn btn-danger btn-sm">Submit
                                </button>
                               
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
