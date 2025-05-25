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

    <div class="row" style="border:none;margin-right:15px;margin-left:15px;">
            <div class="col-md-6">
            <h5 class="card-title">Edit Company Information</h5>
        </div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Company</a></li>

								<li>/</li>
                                <li class="active">Edit Company Information</li>

                            </ul>
                        </span>
</div>
</div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Edit Company Information</strong>

                    </div> -->
                    <div class="card-body card-block">

                        <form action="{{ url('masters/update-company') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            {{csrf_field()}}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="<?php echo $CompanyData[0]->id; ?>">

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Company Name <span class="error">(*)</span></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="company_name" required name="company_name" readonly class="form-control" value="<?php if (!empty($CompanyData[0]->company_name)) {echo $CompanyData[0]->company_name;}?>" >
                                    @if ($errors->has('company_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company Address <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><textarea  required id="company_address" name="company_address" rows=5 class="form-control"><?php if (!empty($CompanyData[0]->company_address)) {echo trim($CompanyData[0]->company_address);}?></textarea>
                                    @if ($errors->has('company_address'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_address') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company Phone No. <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><input type="number" required id="company_phone" name="company_phone" class="form-control" value="<?php if (!empty($CompanyData[0]->company_phone)) {echo $CompanyData[0]->company_phone;}?>">

                                    @if ($errors->has('company_phone'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_phone') }}</div>
                                    @endif
                                </div>


                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company FAX </label></div>
                                <div class="col-12 col-md-9"><input type="text"  id="company_fax" name="company_fax" class="form-control" value="<?php if (!empty($CompanyData[0]->company_fax)) {echo $CompanyData[0]->company_fax;}?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Company Pan <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><input required type="text" id="company_pan" name="company_pan" class="form-control" value="<?php if (!empty($CompanyData[0]->company_pan)) {echo $CompanyData[0]->company_pan;}?>">

                                    @if ($errors->has('company_pan'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_pan') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Company Website</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_web" name="company_web" class="form-control" value="<?php if (!empty($CompanyData[0]->company_web)) {echo $CompanyData[0]->company_web;}?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Company mail ID</label></div>
                                <div class="col-12 col-md-9"><input type="email" id="company_mail" name="company_mail" class="form-control" value="<?php if (!empty($CompanyData[0]->company_mail)) {echo $CompanyData[0]->company_mail;}?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company CIN <span class="error">(*)</span></label></div>
                                <div class="col-12 col-md-9"><input type="text" required id="company_cin" name="company_cin" class="form-control" value="<?php if (!empty($CompanyData[0]->company_cin)) {echo $CompanyData[0]->company_cin;}?>">
                                    @if ($errors->has('company_cin'))
                                    <div class="error" style="color:red;">{{ $errors->first('company_cin') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company GSTIN</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_gstin" name="company_gstin" class="form-control" value="<?php if (!empty($CompanyData[0]->company_gstin)) {echo $CompanyData[0]->company_gstin;}?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company CGST(in%)</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_cgst" name="company_cgst" class="form-control" value="<?php if (!empty($CompanyData[0]->company_cgst)) {echo $CompanyData[0]->company_cgst;}?>"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company SGST(in%)</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_sgst" name="company_sgst" class="form-control" value="<?php if (!empty($CompanyData[0]->company_sgst)) {echo $CompanyData[0]->company_sgst;}?>"></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Company IGST(in%)</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="company_igst" name="company_igst" class="form-control" value="<?php if (!empty($CompanyData[0]->company_igst)) {echo $CompanyData[0]->company_igst;}?>"></div>
                            </div>




                            <div class="row form-group">



                                <div class="col col-md-3"><label for="file-multiple-input" class=" form-control-label">Company Logo</label></div>
                                <div class="col-12 col-md-9"><input type="file" id="company_logo" name="company_logo"  class="form-control-file" >  <?php if (!empty($CompanyData[0]->company_logo)) {?>
								<img src="{{ asset($CompanyData[0]->company_logo) }}" height="auto" width="80px">
								<?php }?></div>

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



    </div>
    <!-- /Widgets -->



</div>
<!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>





@endsection