@extends('masters.layouts.master')

@section('title')
Configuration-Supplier
@endsection

@section('sidebar')
@include('masters.partials.sidebar')
@endsection

@section('header')
@include('masters.partials.header')
@endsection


<style>
  #weatherWidget .currentDesc {
    color: #ffffff !important;
  }

  .traffic-chart {
    min-height: 335px;
  }

  #flotPie1 {
    height: 150px;
  }

  #flotPie1 td {
    padding: 3px;
  }

  #flotPie1 table {
    top: 20px !important;
    right: -10px !important;
  }

  .chart-container {
    display: table;
    min-width: 270px;
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
  }

  #flotLine5 {
    height: 105px;
  }

  #flotBarChart {
    height: 150px;
  }

  #cellPaiChart {
    height: 160px;
  }

  .card .btn-danger {
    padding: 4px 10px;
  }

  fieldset {
    border-top: 1px dotted #999;
    padding: 15px 0;
  }

  button.btn.btn-default.bg-white.btn-flat.add_new_supplier {
    background: none;
    height: 37px;
    width: 37px;
    margin-top: -2px;
    border-radius: 0;
    padding: 2px;
    border: 1px solid #ccc;
  }

  .supplier#myModal1 form {
    padding: 30px;
    background: #f9f9f9;
  }

  .supplier#myModal1 form label {
    font-size: 14px;
    font-weight: normal;
  }

  .supplier#myModal1 form .form-control {
    border-radius: 0;
  }
</style>


@section('content')
<!-- Content -->
<div class="content">
  <!-- Animated -->
  <div class="animated fadeIn">
  <div class="row" style="border:none;">
            <div class="col-md-6">       
            <h5 class="card-title">Add New Supplier</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Procurement Master</a></li>
                                
								<li>/</li>
                <li class="active"><a href="#">Supplier</a></li>
                                
                                <li>/</li>
                                <li class="active">Add New Supplier</li>
						
                            </ul>
                        </span>
</div>
</div>
    <!-- Widgets  -->
    <div class="row">
      <div class="main-card">
        <div class="card">
          <!-- <div class="card-header"><strong class="card-title">Add New Supplier</strong></div> -->
          <div class="card-body card-block">
            <form action="{{ url('masters/save-supplier') }}" method="post" enctype="multipart/form-data" style="padding:2% 5%;">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" id="supplier_id" name="id" value="<?php if (!empty($supplier->id)) {
                                                                        echo $supplier->id;
                                                                      } ?>" />

              <div class="clearfix"></div>
              <div class="lv-due" style="border:none;">

                <div class="bef-ship" style="">
                  <div class="row form-group lv-due-body">

                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Business Name</label>
                      <input type="text" class="form-control" id="supplier_business_name" name="supplier_business_name" value="<?php if (!empty($supplier->supplier_business_name)) {
                                                                                                                                  echo $supplier->supplier_business_name;
                                                                                                                                } ?>" <?php if (!empty($supplier->supplier_business_name)) {
                                                                                                                                                                                                                                    echo "readonly";
                                                                                                                                                                                                                                  } ?> required="">
                      @if ($errors->has('supplier_business_name'))
                      <div class="error" style="color:red;">{{ $errors->first('supplier_business_name') }}</div>
                      @endif
                    </div>


                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">GSTIN</label>
                      <input type="text" class="form-control" name="supplier_gstin" value="<?php if (!empty($supplier->supplier_gstin)) {
                                                                                              echo $supplier->supplier_gstin;
                                                                                            } ?>" required="">
                      @if ($errors->has('supplier_gstin'))
                      <div class="error" style="color:red;">{{ $errors->first('supplier_gstin') }}</div>
                      @endif
                    </div>


                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">PAN No.</label>
                      <input type="text" class="form-control" name="pan_no" value="<?php if (!empty($supplier->pan_no)) {
                                                                                      echo $supplier->pan_no;
                                                                                    } ?>" required="">
                      @if ($errors->has('pan_no'))
                      <div class="error" style="color:red;">{{ $errors->first('pan_no') }}</div>
                      @endif
                    </div>


                    <div class="col-md-3">
                      <label>Type Of Supplier</label>
                      <select class="form-control" name="type_of_supplier" id="type_of_supplier" required onchange="generatecode();" <?php if (!empty($supplier->type_of_supplier)) {
                                                                                                                                        echo "disabled";
                                                                                                                                      } ?>>
                        <option>Select Supplier Type</option>
                        <option value="gem" <?php if (!empty($supplier->type_of_supplier)) {
                                              if ($supplier->type_of_supplier == "gem") {
                                                echo "selected";
                                              }
                                            } ?>>Gem</option>
                        <option value="local" <?php if (!empty($supplier->type_of_supplier)) {
                                                if ($supplier->type_of_supplier == "local") {
                                                  echo "selected";
                                                }
                                              } ?>>Local</option>
                      </select>
                      @if ($errors->has('type_of_supplier'))
                      <div class="error" style="color:red;">{{ $errors->first('type_of_supplier') }}</div>
                      @endif

                    </div>

                  </div>


                  <div class="row form-group lv-due-body" style="border-bottom: 1px solid #ddd; padding-bottom:25px;">

                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Supplier Code</label>
                      <input type="text" class="form-control" name="supplier_code" id="supplier_code" value="" required="" readonly />
                      @if ($errors->has('supplier_code'))
                      <div class="error" style="color:red;">{{ $errors->first('supplier_code') }}</div>
                      @endif
                    </div>

                  </div>



                  <div class="clearfix"></div>
                  <h4 style="margin-top:15px;color: #027398;font-size:18px;">Contact Information</h4><br>
                  <div class="row form-group lv-due-body">

                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Contact Person Name</label>
                      <input type="text" class="form-control" name="contact_person_name" value="<?php if (!empty($supplier->contact_person_name)) {
                                                                                                  echo $supplier->contact_person_name;
                                                                                                } ?>" required="">
                      @if ($errors->has('contact_person_name'))
                      <div class="error" style="color:red;">{{ $errors->first('contact_person_name') }}</div>
                      @endif
                    </div>

                    <div class="col-md-3">
                      <label>Designation</label>
                      <input type="text" name="contactperson_designation" value="<?php if (!empty($supplier->contactperson_designation)) {
                                                                                    echo $supplier->contactperson_designation;
                                                                                  } ?>" class="form-control">
                    </div>

                    <div class="col-md-3">

                      <label>Contact No.</label>
                      <input type="text" name="supplier_mobile" value="<?php if (!empty($supplier->supplier_mobile)) {
                                                                          echo $supplier->supplier_mobile;
                                                                        } ?>" class="form-control">
                    </div>

                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Alternative No.</label>
                      <input type="text" class="form-control" name="supplier_alt_no" value="<?php if (!empty($supplier->supplier_alt_no)) {
                                                                                              echo $supplier->supplier_alt_no;
                                                                                            } ?>" required="">
                      @if ($errors->has('supplier_alt_no'))
                      <div class="error" style="color:red;">{{ $errors->first('supplier_alt_no') }}</div>
                      @endif
                    </div>

                  </div>


                  <div class="row form-group lv-due-body">


                    <div class="col-md-3">
                      <label for="text-input" class=" form-control-label">Email</label>
                      <input type="email" class="form-control" name="supplier_email" value="<?php if (!empty($supplier->supplier_email)) {
                                                                                              echo $supplier->supplier_email;
                                                                                            } ?>" required="">
                      @if ($errors->has('supplier_email'))
                      <div class="error" style="color:red;">{{ $errors->first('supplier_email') }}</div>
                      @endif
                    </div>

                    <div class="col-md-6">

                      <label>Communication Address</label>
                      <textarea rows="3" class="form-control" name="contact_person_address" required><?php if (!empty($supplier->contact_person_address)) {
                                                                                                        echo $supplier->contact_person_address;
                                                                                                      } ?></textarea>
                    </div>


                  </div>
                  <div class="col-md-4 btn-up">
                    <button type="submit" class="btn btn-danger btn-sm">Submit</button>

                  </div>
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
<div class="clearfix"></div>

@endsection

@section('scripts')
@include('masters.partials.scripts')

<script>
  function generatecode() {

    var supplier_business_name = $('#supplier_business_name').val();
    var split_value = supplier_business_name.substring(0, 3);
    var type_of_supplier = $('#type_of_supplier option:selected').val();
    var supplier_code = (new Date).getFullYear() + '/' + ((new Date).getMonth() + 1) + '/' + split_value + '/' + type_of_supplier + '/' + Math.floor(Math.random() * 999);

    $('#supplier_code').val(supplier_code);


  }
</script>

@endsection