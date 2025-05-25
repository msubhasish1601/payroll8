@extends('masters.layouts.master')

@section('title')
Payroll Information System-Company
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

    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">@if(isset($bankdetails) && !empty($bankdetails))
            <strong>Edit Bank Master</strong>
                        @else
                        <strong>Add Bank Master</strong>
                        @endif
            </h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Bank Master</a></li>
                                <li>/</li>
								<li><a href="#">Company Bank</a></li>
								<li>/</li>
                                <li class="active">@if(isset($bankdetails) && !empty($bankdetails))
            <strong>Edit Bank Master</strong>
                        @else
                        <strong>Add Bank Master</strong>
                        @endif</li>
						
                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                  
                    <div class="card-body card-block">
                        <form action="{{ url('masters/update-bank') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="bankid" value="{{ ((isset($bankdetails) && !empty($bankdetails))?$bankdetails[0]['id']:'')}}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter Bank Name <span>(*)</span></label>
                                    <?php //print_r($MastersbankName); exit; 
                                    ?>
                                    <select name="bank_name" id="bank_name" class="form-control" required>
                                        @foreach($MastersbankName as $value):
                                        <option value="{{ $value->id }}" <?php if (!empty($bankdetails[0]['id'])) {
                                                                                if ($bankdetails[0]['bank_name'] == $value->id) {
                                                                                    echo "selected";
                                                                                }
                                                                            } ?>>
                                            {{ $value->master_bank_name }}
                                        </option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter Branch Name <span>(*)</span></label>
                                    <input type="text" id="branch_name" required required name="branch_name" class="form-control" value="{{ (isset($bankdetails[0]['branch_name']) && !empty($bankdetails[0]['branch_name']))?$bankdetails[0]['branch_name']:old('branch_name')}}">
                                    @if ($errors->has('branch_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('branch_name') }}</div>
                                    @endif
                                </div>
                           

                          
                                <div class="col-md-4">
                                    <label class=" form-control-label">IFSC Code <span>(*)</span></label>
                                    <input type="text"   required id="ifsc_code" name="ifsc_code" class="form-control" value="{{ (isset($bankdetails[0]['ifsc_code']) && !empty($bankdetails[0]['ifsc_code']))?$bankdetails[0]['ifsc_code']:old('ifsc_code')}}">


                                    @if ($errors->has('ifsc_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('ifsc_code') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter MICR Code </label>
                                    <input type="text"   id="swift_code" name="swift_code" class="form-control" value="{{ (isset($bankdetails[0]['swift_code']) && !empty($bankdetails[0]['swift_code']))?$bankdetails[0]['swift_code']:old('swift_code')}}">
                                    @if ($errors->has('swift_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('swift_code') }}</div>
                                    @endif
                                </div>
                           
                                
                            <div class="col-md-4">
                                    <label class=" form-control-label">Enter Account number <span>(*)</span></label>
                                    <input required type="text" id="account_number" name="account_number" class="form-control" value="{{ (isset($bankdetails[0]['account_number']) && !empty($bankdetails[0]['account_number']))?$bankdetails[0]['account_number']:old('account_number')}}">
                                    @if ($errors->has('account_number'))
                                    <div class="error" style="color:red;">{{ $errors->first('account_number') }}</div>
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