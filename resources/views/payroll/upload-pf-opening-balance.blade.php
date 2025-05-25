@extends('payroll.layouts.master')

@section('title')
Payroll Information System-Upload PF Opening Balance
@endsection

@section('sidebar')
@include('payroll.partials.sidebar')
@endsection

@section('header')
@include('payroll.partials.header')
@endsection

@section('scripts')
@include('payroll.partials.scripts')
@endsection

@section('content')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

    <div class="row" style="border:none;">
            <div class="col-md-6">
            <h5 class="card-title">Upload PF Opening Balance</h5>
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                            <li><a href="#">Payroll</a></li>
                                <li>/</li>
                                <li class="active">Upload PF Opening Balance</li>

                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Add New Caste</strong>
                    </div> -->
                    <div class="card-body card-block">
                        <p>(*) Marked Fields are Mandatory</p>
                        <form action="{{ url('payroll/upload-pf-opening-balance') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12 col-lg-10 col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Choose XLS File to Import') !!} <span>*</span>
                                        {{ Form::file('import_file', ['required','class' => 'form-control','data-msg-accept'=>"File must be XLS or XLSX",'accept'=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"]) }}
                                    </div>
                                    <div class="form-group">
                                        <a target="_blank" href="{{ URL::to('/sampledata/pf-opening-balance-import-sample-format.xlsx') }}">Click to view/download sample format</a>

                                    </div>
                                    <p><strong>Note:</strong> Please do keep the headers mention in the sample format as it is in future data imports.</p>
                                    <button type="submit" class="btn btn-primary btn-submit">Import Data</button>
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
