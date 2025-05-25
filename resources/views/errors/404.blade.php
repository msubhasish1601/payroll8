@extends('errors.layouts.master')

@section('title')
 Dashboard
@endsection

@section('sidebar')
	@include('errors.partials.sidebar')
@endsection

@section('header')
	@include('errors.partials.header')
@endsection

@section('scripts')
	@include('errors.partials.scripts')
@endsection

@section('content'))

 <!-- Content -->
        <div class="content">
                <div class="card">
        <!-- /.row -->
	<div class="card-header" style="color:red;">
404 Page not found </div>
        <div class="card-body" style="margin-top: 20px;"><p align="center">
        	<!-- <a class="btn btn-primary" href="{{ (url()->previous()!='')? url()->previous(): route('dashboard') }}">Back</a> -->
            <a class="btn btn-danger btn-sm" href="{{url('/')}}">Back to Login</a>
        </p>
        </div>
 </div>
 
		</div>
        <!-- /.content -->
        <div class="clearfix"></div>
       


@endsection
