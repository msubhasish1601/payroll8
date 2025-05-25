@extends('masters.layouts.master')

@section('title')
Payroll Information System-Employee Type
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
            <h5 class="card-title">Edit Employee Type</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">HCM Master</a></li>
                                
								<li>/</li>
                                <li><a href="#">Employee</a></li>
                                
								<li>/</li>
                                <li class="active">Edit Employee Type</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Edit Employee Type</strong>
                    </div> -->
                    <div class="card-body card-block">
                        <form action="{{ url('masters/update-employee-type') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <input type="hidden" name="id" class="form-control" value="<?php if (!empty($employee_type->id)) { echo $employee_type->id;} ?>">

                                <div class="col-md-4">
                                    <label style="float: right;" for="email-input" class=" form-control-label">Enter Employee Type (*)</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" required id="employee_type_name" name="employee_type_name" class="form-control" value="<?php if (!empty($employee_type->employee_type_name)) { echo $employee_type->employee_type_name; } ?>">
                                    @if ($errors->has('employee_type_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('employee_type_name') }}</div>
                                    @endif
                                </div>


                                <button type="submit" class="btn btn-danger btn-sm">Submit
                                </button> &nbsp;&nbsp;&nbsp;

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
<div class="clearfix"></div>
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->





@endsection