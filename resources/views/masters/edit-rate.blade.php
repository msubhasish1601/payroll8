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
                        <strong>Edit Rate Details</strong>
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
                        <form action="{{ url('masters/rate-details') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control" name="id" value="{{ $ratedtl[0]->id }}">
                            <div class="row form-group">
							<div class="col-md-3">
								
                                    <label for="text-input" class=" form-control-label">Head Type<span>(*)</span></label>
									 <input type="text" class="form-control" id="pay_type" name="pay_type" value="{{ ucfirst($ratedtl[0]->pay_type) }}" readonly="1" required>
                                
                                  <!--  <select class="form-control" name="pay_type" required  id="pay_type" onchange="checkhaedtype(this);">
                                        <option value="" selected disabled >Select</option>
                                        <option value="earning" <?php if(!empty($ratedtl[0]->pay_type)){ if( $ratedtl[0]->pay_type == "earning"){  echo "selected"; } } ?>>Earning</option>
                                        <option value="deduction" <?php if(!empty($ratedtl[0]->pay_type)){ if( $ratedtl[0]->pay_type == "deduction"){  echo "selected"; } } ?>>Deduction</option>
                                    </select>-->
                                </div>
                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Head Name<span>(*)</span></label>
									
                                    <input type="text" class="form-control" id="head_name" name="head_name" value="{{ $ratedtl[0]->head_name }}" readonly="1" required>
                                
								</div>
<div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Calculation Type<span>(*)</span></label>
                                    <select class="form-control" name="cal_type" id="cal_type" onchange="checkcaltype(this.value);" required>
                                        <option value="" selected disabled >Select</option>
                                        <option value="F"  <?php if(!empty($ratedtl[0]->cal_type)){ if( $ratedtl[0]->cal_type == "F"){  echo "selected"; } } ?>>Fixed</option>
                                        <option value="V"  <?php if(!empty($ratedtl[0]->cal_type)){ if( $ratedtl[0]->cal_type == "V"){  echo "selected"; } } ?>>Variable</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">In Percentage <span>(*)</span></label>
                                    <input type="text" class="form-control" id="inpercentage" name="inpercentage" value="{{ $ratedtl[0]->inpercentage }}" required  <?php if(!empty($ratedtl[0]->cal_type)){ if( $ratedtl[0]->cal_type == "V"){  echo "readonly"; } } ?>>
                                </div>

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">In Rupees <span>(*)</span></label>
                                    <input type="text" class="form-control" id="inrupees" name="inrupees" value="{{ $ratedtl[0]->inrupees }}" required  <?php if(!empty($ratedtl[0]->cal_type)){ if( $ratedtl[0]->cal_type == "V"){  echo "readonly"; } } ?>>
                                </div>
					  <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Min value <span>(*)</span></label>
                                    <input type="number" step="any" class="form-control" id="min_basic" name="min_basic"  value="{{ $ratedtl[0]->min_basic }}"  <?php if(!empty($ratedtl[0]->cal_type)){ if( $ratedtl[0]->cal_type == "V"){  echo "readonly"; } } ?> required>
                                </div>
								  <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Max Value  <span>(*)</span></label>
                                    <input type="number" step="any" class="form-control" id="max_basic" name="max_basic"  value="{{ $ratedtl[0]->max_basic }}"  <?php if(!empty($ratedtl[0]->cal_type)){ if( $ratedtl[0]->cal_type == "V"){  echo "readonly"; } } ?> required>
                                </div>

                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Effective From<span>(*)</span></label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $ratedtl[0]->from_date }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Effective To <span>(*)</span></label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" value="{{ $ratedtl[0]->to_date }}" required>
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