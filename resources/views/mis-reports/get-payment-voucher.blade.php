@extends('masters.layouts.master')

@section('title')
BELLEVUE - Payment Booking
@endsection

@section('sidebar')
    @include('mis-reports.includes.sidebar')
@endsection

@section('header')
    @include('mis-reports.partials.header')
@endsection

@section('scripts')
    @include('mis-reports.includes.scripts')
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
	            <div class="card-header"> <strong>Payment Voucher</strong> </div>
	            <div class="card-body card-block">
                    <!-- @if(Session::has('message'))
					<div class="alert alert-danger" style="text-align:center;">
						<span class="glyphicon glyphicon-ok" ></span>
						<em> {{ Session::get('message') }}</em>
					</div>
					@endif -->
					@include('include.messages')
	            <form action="" method="post" style="width: 70%;margin: 0 auto;" target="_blank">
	              	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                <div class="row form-group">



						<div class="col-md-6">
							<label>From Date</label>
							 <input type="date"  name="from_date" class="form-control" value="" />
						</div>

						<div class="col-md-6">
							<label>To Date</label>
							 <input type="date"  name="to_date" class="form-control" value="" />
						</div>


	                </div>



	                <div class="col-md-4 btn-up">
	                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
	                </div>

	              </form>
	            </div>
	          </div>


	        </div>
	      </div>
	      <!-- /Widgets -->
	    </div>
	    <!-- .animated -->
  	</div>
  	<!-- /.content -->

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>

@endsection

@section('scripts')
@include('attendance.partials.scripts')

@endsection
