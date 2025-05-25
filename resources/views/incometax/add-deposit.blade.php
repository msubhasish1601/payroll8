@extends('incometax.layouts.master')

@section('title')
BELLEVUE - Income Tax Module
@endsection

@section('sidebar')
@include('incometax.partials.sidebar')
@endsection

@section('header')
@include('incometax.partials.header')
@endsection

@section('scripts')
@include('incometax.partials.scripts')
@endsection

@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Add Income Tax Type Master</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Income Tax Type Master</a></li>
                        <li>/</li>
                        <li><a href="#">Add Income Tax Type Master</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                   
                    <div class="card-body card-block">

                        <form action="{{ url('itax/save-deposit') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                
                                <div class="col-md-4">
                                    <label class=" form-control-label">Payment Date <span>(*)</span></label>
                                    <input type="date" required id="payment_date" name="payment_date" class="form-control" value="">
                                    @if ($errors->has('payment_date'))
                                    <div class="error" style="color:red;">{{ $errors->first('payment_date') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount <span>(*)</span></label>
                                    <input type="number" step="any" required id="amount" name="amount" class="form-control" value="">
                                    @if ($errors->has('amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount') }}</div>
                                    @endif
                                    
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Challan No. <span>(*)</span></label>
                                    <input type="text"  id="challan_no" name="challan_no" class="form-control" value="" required>
                                    @if ($errors->has('challan_no'))
                                    <div class="error" style="color:red;">{{ $errors->first('challan_no') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">BSR Code <span>(*)</span></label>
                                    <input type="text"  id="bsr_code" name="bsr_code" class="form-control" value="" required>
                                    @if ($errors->has('bsr_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('bsr_code') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Name of Bank & Branch Where Tax Deposited <span>(*)</span></label>
                                    <textarea type="text"  id="bank" name="bank" class="form-control" required></textarea>
                                    @if ($errors->has('bank'))
                                    <div class="error" style="color:red;">{{ $errors->first('bank') }}</div>
                                    @endif
                                </div>

                            </div>
                            <p>(*) marked fields are mandatory</p>
                            
                            <button type="submit" class="btn btn-danger btn-sm">Submit
                            </button>

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
<div class="clearfix"></div>
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->






@endsection