@extends('employee.layouts.master')

@section('title')
Employee Information System-Employees
@endsection

@section('sidebar')
	@include('employee.partials.sidebar')
@endsection

@section('header')
	@include('employee.partials.header')
@endsection

@section('content')
<style>
.content{background: #fff;}
.dash-mar h2 {
    background: linear-gradient(to right, #28ca8e 30% , #0aa3de);
    color: #fff;
    padding: 5px 10px;
    margin-top: 15px;
    font-size: 23px;
}.sb-inr {background-color: #e6e6e6;padding: 15px;height: 146px;    margin-bottom: 25px;}.sb-img i {font-size: 20px;background: #1ebdaa;color: #fff;width: 40px;height: 40px;
padding: 10px 13px;border-radius: 50%;}.sb-name h4 {font-size: 14px;color: #043546;    font-weight: 600;}.sb-img img {max-width: 50px;}
</style>
  <!-- Content -->
      <div class="content">

      	@if(Session::has('message'))										
		<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
		@endif	
            <div class="animated fadeIn">
				<div class="dash-mar">
					<h2>Service Book</h2>
				
                <div class="row">
					<div class="col-md-3">
					<a href="{{ url('personalinfo') }}">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/1.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Personal<br> Information</h4>
							</div>
						</div>
					</a>
					</div>
					
					<div class="col-md-3">
					<a href="{{ url('educationalinfo') }}">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/10.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Educational<br> Information</h4>
							</div>
						</div>
					</a>
					</div>
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/2.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Certificate Attestation (Immutable)</h4>
							</div>
						</div>
					</a>
					</div>
                    <div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/3.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Family Perticulars &amp; Nominations (Mutable)</h4>
							</div>
						</div>
					</a>
					</div>					
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/4.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Details of <br>Service</h4>
							</div>
						</div>
					</a>
					</div>					
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/5.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Leave <br>Record</h4>
							</div>
						</div>
					</a>
					</div>					
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/6.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Details of Leave Travel Concession Availed</h4>
							</div>
						</div>
					</a>
					</div>					
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/7.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>House Building Advance (HBA)</h4>
							</div>
						</div>
					</a>
					</div>					
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/8.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Central Government Employees' Group Insurance Scheme (CGEGIS)</h4>
							</div>
						</div>
					</a>
					</div>					
					<div class="col-md-3">
					<a href="#myModal">
						<div class="text-center sb-inr">
							<div class="sb-img">
							<img src="{{ asset('theme/images/9.png') }}" alt="">
							</div>
							<div class="sb-name">
								<h4>Comments on<br> Internal Audit</h4>
							</div>
						</div>
					</a>
					</div>
                </div>
                </div>
				</div>
                <div class="clearfix"></div>
				
            </div>
      </div>
        <div class="clearfix"></div>
       

@endsection

@section('scripts')
@include('attendance.partials.scripts')
@endsection   
