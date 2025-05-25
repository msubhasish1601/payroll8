@extends('role.layouts.master')

@section('title')
{{ config('app.name', 'Laravel') }} - Role
@endsection

@section('sidebar')
@include('role.partials.sidebar')
@endsection

@section('header')
@include('role.partials.header')
@endsection

@section('content')

<!-- Content -->

        
    </div>
<!-- /.content -->
<div class="clearfix"></div>



@endsection

@section('scripts')
@include('role.partials.scripts')
@endsection