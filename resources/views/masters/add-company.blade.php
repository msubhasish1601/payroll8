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

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

    <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Create New Company Information</h5>      
</div>
<div class="col-md-6">

    <span class="right-brd" style="padding-right:15x;">
    <ul class="">
        <li><a href="#">Company</a></li>
        <li>/</li>
        <li class="active">Create New Company Information</li>

    </ul>
</span>
</div>
</div>


        <!-- Widgets  -->
    

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Create New Company Information</strong>

                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/save-company') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            {{csrf_field()}}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Company Name <span class="error">(*)</span></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" required id="company_name" name="company_name" <?php echo  request()->has('c_id') ? 'readonly' : '' ?> class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_name: '' }}{{ old('company_name') }}">
                                    @if ($errors->has('company_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company Address <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><textarea required id="company_address" name="company_address" rows=5 class="form-control">{{ request()->has('c_id') ? $CompanyData[0]->company_address : '' }} {{ old('company_address') }} </textarea>
                                    @if ($errors->has('company_address'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_address') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company Phone No. <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><input type="number"  required id="company_phone" name="company_phone" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_phone : '' }}{{ old('company_phone') }}">

                                    @if ($errors->has('company_phone'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_phone') }}</div>
                                    @endif
                                </div>


                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company FAX </label></div>
                                <div class="col-12 col-md-9"><input  type="text" id="company_fax" name="company_fax" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_fax : '' }}{{ old('company_fax') }}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company Pan <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><input required type="text" id="company_pan" name="company_pan" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_pan : '' }}{{ old('company_pan') }}">

                                    @if ($errors->has('company_pan'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_pan') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Company Website</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_web" name="company_web" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_web : '' }}{{ old('company_web') }}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Company mail ID</label></div>
                                <div class="col-12 col-md-9"><input type="email" id="company_mail" name="company_mail" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_mail : '' }}{{ old('company_mail') }}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company CIN <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><input type="text"  required id="company_cin" name="company_cin" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_cin : '' }}{{ old('company_cin') }}">
                                    @if ($errors->has('company_cin'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_cin') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company GSTIN</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_gstin" name="company_gstin" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_gstin : '' }}{{ old('company_gstin') }}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company CGST(in%)</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_cgst" name="company_cgst" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_cgst : '' }}{{ old('company_cgst') }}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company SGST(in%)</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_sgst" name="company_sgst" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_sgst : '' }}{{ old('company_sgst') }}"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company IGST(in%)</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_igst" name="company_igst" class="form-control" value="{{ request()->has('c_id') ? $CompanyData[0]->company_igst : '' }}{{ old('company_igst') }}"></div>
                            </div>




                            <div class="row form-group">
                                @if(request()->has('c_id'))
                                <input type="hidden" value="{{ request()->has('c_id') ? $CompanyData[0]->company_logo : '' }}" name="company_logo">

                                @else
                                <div class="col col-md-3"><label for="file-multiple-input" class=" form-control-label">Company Logo</label></div>
                                <div class="col-12 col-md-9"><input type="file" id="company_logo" name="company_logo" class="form-control-file" value="{{ old('company_logo') }}"></div>
                                @endif
                            </div>



                            <div class="card-body">
                                <button type="submit" class="btn btn-danger btn-sm">Submit
                                </button>

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
<div class="clearfix"></div>





@endsection