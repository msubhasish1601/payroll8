@extends('rota.layouts.master')

@section('title')
{{ config('app.name', 'Laravel') }} - Rota
@endsection

@section('sidebar')
	@include('rota.partials.sidebar')
@endsection

@section('header')
	@include('rota.partials.header')
@endsection



@section('scripts')
	@include('rota.partials.scripts')
@endsection

@section('content')

 <!-- Content -->
        <div class="content">
           
		   
		</div>
        <!-- /.content -->
        <div class="clearfix"></div>
       


@endsection
