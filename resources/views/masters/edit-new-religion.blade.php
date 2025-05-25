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
            <h5 class="card-title"> Edit Religion Master</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                
								<li>/</li>
                                <li><a href="#">Religion Master</a></li>
                                
								<li>/</li>
                                <!-- <li><a href="#">Pay level Master</a></li> -->
                                
								
                                <li class="active">Edit Religion Master</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Edit New Religion</strong>
                    </div> -->
                    <div class="card-body card-block">
                        <p>(*) Marked Fields are Mandatory</p>
                        <form action="{{ url('masters/update-new-religion') }}" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php echo $getRel[0]->id;  ?>">
                            <div class="row form-group">


                                <!--<div class="col-md-4">
                                        <label for="email-input" class=" form-control-label">Religion ID <span>(*)</span></label>
        <input type="text" class="form-control" id="rel_id" name="rel_id" value="<?php //if(app('request')->input('id')){  echo $getRel[0]->religion_id;   }  
                                                                                    ?>{{ old('rel_id') }}">
										@if ($errors->has('rel_id'))
											<div class="error" style="color:red;">{{ $errors->first('rel_id') }}</div>
										@endif
                                    </div>-->

                                <div class="col-md-4">
                                    <label for="text-input" class=" form-control-label">Religion Name <span>(*)</span></label>
                                

                                    <input type="text" required class="form-control" id="reli_name" name="rel_name" value="<?php echo $getRel[0]->religion_name;  ?>{{ old('reli_name') }}">
                                    @if ($errors->has('rel_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('rel_name') }}</div>
                                    @endif
                                </div>


                                <div class="col-md-4">
                                    <label for="text-input" class=" form-control-label">Status<span>(*)</span></label>
                                    <select class="form-control" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>

                                </div>
  </div>
  <div class="row form-group">


                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-danger btn-sm">Submit</button>
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
@endsection