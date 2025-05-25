@extends('attendance.layouts.master')

@section('title')
Payroll Information System-Company
@endsection

@section('sidebar')
	@include('attendance.partials.sidebar')
@endsection

@section('header')
	@include('attendance.partials.header')
@endsection





@section('content')
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
            <div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Upload Data</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
							<li><a href="#">Attendence Management</a></li>
                                <li>/</li>
                                <!-- <li><a href="#">Employee Master</a></li>
                                <li>/</li> -->
                                <li class="active">Upload Data</li>

                            </ul>
                        </span>
</div>
</div>

                <!-- Widgets  -->
                <div class="row">

                    <div class="main-card">
                        <div class="card">
						<!-- <div class="card-header"><strong class="card-title">Upload Data</strong></div> -->

                            <div class="card-body card-block">
                                <form action="#" method="post" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">
                                   @include('include.messages')
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <div class="row form-group">
                                        <!--<div class="col col-md-4"><label for="select" class=" form-control-label">Upload Type <span>(*)</span></label>
                                            <select name="company_name" id="company_name" class="form-control">
                                                <option value="0">Please select</option>
                                                <option value="1">Option #1</option>
                                                <option value="2">Option #2</option>
                                                <option value="3">Option #3</option>
                                            </select>
                                        </div>-->

                                        <div class="col col-md-6">
											<label for="file-input" class=" form-control-label">Request (.csv) File to Upload <span>(*)</span></label>
										<input type="file" id="upload_csv" name="upload_csv" required class="form-control-file">
										@if ($errors->has('upload_csv'))
										<div class="error" style="color:red;">{{ $errors->first('upload_csv') }}</div>
										@endif
										</div>
										<div class="col col-md-6 btn-up"><button type="submit" class="btn btn-danger btn-sm">Upload</button>
									<button type="reset" class="btn btn-danger btn-sm">
										<i class="fa fa-ban"></i> Reset
									</button>
									</div>

                                    </div>




							</form>
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="font-weight:600;font-size:16px;">Download Sample Format <a href="{{ url('/samplecsv/attendance/bellevue-attandance-format.csv') }}">here</a></p>
                                </div>
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

@section('scripts')
@include('attendance.partials.scripts')

@endsection
