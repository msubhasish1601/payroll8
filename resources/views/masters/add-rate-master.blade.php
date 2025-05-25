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
                        <strong>Add Rate Master</strong>
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
                        <form action="{{ url('masters/rate-master-save') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control" name="id" >
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Head Name<span>(*)</span></label>
                                     <input type="text" class="form-control" id="head_name" name="head_name" required>
									 
                                </div>

                              
                              <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Head Type<span>(*)</span></label>
                                    <select class="form-control" name="head_type" required>
                                        <option value="" selected disabled >Select</option>
                                        <option value="earning">Earning</option>
                                        <option value="deduction">Deduction</option>
                                    </select>
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