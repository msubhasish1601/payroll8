@extends('leavemanagement.layouts.master')

@section('title')
Leave Allocation System-Company
@endsection

@section('sidebar')
	@include('leavemanagement.partials.sidebar')
@endsection

@section('header')
	@include('leavemanagement.partials.header')
@endsection

@section('scripts')
	@include('leavemanagement.partials.scripts')
@endsection

@section('content')
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
			<div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title"> Leave Selection </h5>      
</div>
<div class="col-md-6">

    <span class="right-brd" style="padding-right:15x;">
     <ul class="">
     <li><a href="#">Leave Managemnt</a></li>
         <li>/</li>
         <li><a href="#">Leave Selection</a></li>
         <li>/</li>
         <li class="active">Role Wise </li>
 
     </ul>
 </span>
</div>
</div>
