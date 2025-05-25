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
            <h5 class="card-title">Add Class Name</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                <li>/</li>
                                <li><a href="#">Class Name</a></li>
                                <li>/</li>
                                <li class="active">Add Class Name</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Add Education Master</strong>
                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-group-name') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">Class Name <span>(*)</span></label>
                                    <input type="text" required id="group_name" name="group_name" class="form-control" value="">
                                    @if ($errors->has('group_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('group_name') }}</div>
                                    @endif
                                </div>
  <div class="col-md-4">
                                    <label class=" form-control-label">Class Status <span>(*)</span></label>
									<select id="status" name="status" class="form-control" required>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
                                   </select>
                                    @if ($errors->has('group_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('group_name') }}</div>
                                    @endif
                                </div>
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
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->






@endsection