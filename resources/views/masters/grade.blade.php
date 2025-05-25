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
            <h5 class="card-title">Add Pay level Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                <li>/</li>
                                <li><a href="#">Pay Level Master</a></li>
                                <li>/</li>
                                <li class="active">Add Pay level Master</li>
						
                            </ul>
                        </span>
</div>
</div>
 
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card">
                        <div class="card">
                            <!-- <div class="card-header">
                                <strong>Add Pay level Master</strong>
                            </div> -->
                            <div class="card-body card-block">
                                <form action="{{ url('masters/save-grade') }}" method="post" enctype="multipart/form-data">
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row form-group">
			
									<div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Enter Pay Level <span>(*)</span></label>
                                        <input type="text" required id="grade_name" name="grade_name"  class="form-control" value="<?php  if(app('request')->input('id')){  echo $getGrade[0]->grade_name; } ?>{{ old('grade_name') }}" >
										@if ($errors->has('grade_name'))
											<div class="error" style="color:red;">{{ $errors->first('grade_name') }}</div>
										@endif
                                    </div>
                                          <?php if(app('request')->input('id')){  ?>
                                        
                                        <div class="col-md-6">
                                        <label for="text-input" class=" form-control-label">Status<span>(*)</span></label>
                                                    <select class="form-control" name="status">	
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
