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
        <!-- Widgets  -->
        <div class="row">




            <div class="main-card">
                <div class="card">
                    <div class="card-header">
                        <strong>Add Rate Details</strong>
                    </div>


                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                    @endif
                    <div class="card-body card-block">
                        <form action="{{ url('masters/rate-save') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control" name="id" >
                            <div class="row form-group">
							<div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Head Type<span>(*)</span></label>
                                    <select class="form-control" name="pay_type" id="pay_type" onchange="checkhaedtype(this.value);" required>
                                        <option value="" selected disabled >Select</option>
                                        <option value="earning">Earning</option>
                                        <option value="deduction">Deduction</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Head Name<span>(*)</span></label>
                                   
									   <select class="form-control" id="rate_id" name="rate_id" required>
                                        <option value="" selected disabled required>Select</option>
										
								  </select>
                                </div>
	<div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Calculation Type<span>(*)</span></label>
                                    <select class="form-control" name="cal_type" id="cal_type" onchange="checkcaltype(this.value);" required>
                                        <option value="" selected disabled >Select</option>
                                        <option value="F">Fixed</option>
                                        <option value="V">Variable</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">In Percentage <span>(*)</span></label>
                                    <input type="text" class="form-control" id="inpercentage" name="inpercentage" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">In Rupees <span>(*)</span></label>
                                    <input type="text" class="form-control" id="inrupees" name="inrupees"  required>
                                </div>
								  <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Min value <span>(*)</span></label>
                                    <input type="number" step="any" class="form-control" id="min_basic" name="min_basic" required >
                                </div>
								  <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Max Value  <span>(*)</span></label>
                                    <input type="number" step="any" class="form-control" id="max_basic" name="max_basic" required >
                                </div>

                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Effective From<span>(*)</span></label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Effective To <span>(*)</span></label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                    <p>(*) Marked Fields are Mandatory</p>
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