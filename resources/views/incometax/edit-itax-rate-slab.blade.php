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


@section('content')

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Edit Income Tax Rate Slab</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Income Tax Rate Slab Master</a></li>
                        <li>/</li>
                        <li><a href="#">Edit Income Tax Rate Slab</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    @include('include.messages')
                    <div class="card-body card-block">

                        <form action="{{ url('itax/update-itax-rate-slab') }}" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $tax_rate->id }}">
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <input type="text" required id="financial_year" name="financial_year" class="form-control" value="{{ $tax_rate->financial_year }}" readonly>
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class=" form-control-label">Gender <span>(*)</span></label>
                                    <select name="gender" class="form-control">
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male" <?php if($tax_rate->gender == 'Male'){ echo 'selected'; } ?>>Male</option>
                                        <option value="Female" <?php if($tax_rate->gender == 'Female'){ echo 'selected'; } ?>>Female</option>

                                    </select>
                                    @if ($errors->has('gender'))
                                    <div class="error" style="color:red;">{{ $errors->first('gender') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class=" form-control-label">Amount From <small>(Lower Limit)</small><span>(*)</span></label>
                                    <input type="number" step="any" required id="amount_from" name="amount_from" class="form-control"
                                        value="{{ $tax_rate->amount_from }}">
                                    @if ($errors->has('amount_from'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_from') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount To <small>(Upper Limit)</small><span>(*)</span></label>
                                    <input type="number" step="any" required id="amount_to" name="amount_to" class="form-control"
                                        value="{{ $tax_rate->amount_to }}">
                                    @if ($errors->has('amount_to'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount_to') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class=" form-control-label">No Upper Limit</label>
                                    <input type="checkbox" name="no_upper_limit"  id="no_upper_limit" value="-1" @if($tax_rate->no_upper_limit=='Y') checked @endif>
                                </div>

                                <div class="col-md-6">
                                    <label class=" form-control-label">Deduction Percentage <span>(*)</span></label>
                                    <input type="number" step="any" required id="percentage" name="percentage" class="form-control"
                                        value="{{ $tax_rate->percentage }}">
                                    @if ($errors->has('percentage'))
                                    <div class="error" style="color:red;">{{ $errors->first('percentage') }}</div>
                                    @endif
                                </div>



                                

                                <div class="col-md-6">
                                    <label class=" form-control-label">Additional Deduction Amount <small>(in Rs.)</small> <span>(*)</span></label>
                                    <input type="number" step="any" required id="additional_amount" name="additional_amount"
                                        class="form-control" value="{{ $tax_rate->additional_amount }}">
                                    @if ($errors->has('additional_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('additional_amount') }}
                                    </div>
                                    @endif
                                </div>


                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">Submit
                            </button>
                            <p>(*) marked fields are mandatory</p>
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

@section('scripts')
@include('incometax.partials.scripts')
<script type="text/javascript">
    $('#no_upper_limit').on("click",function(){
        
        if($('#no_upper_limit').prop('checked')){
            $('#amount_to').val(0);
            $('#amount_to').attr('readonly',true);
        }else{
            $('#amount_to').attr('readonly',false);
        }
    });
</script>
@endsection