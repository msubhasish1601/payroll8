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
                <h5 class="card-title">Add Savings Type Master</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Savings Type Master</a></li>
                        <li>/</li>
                        <li><a href="#">Add Savings Type Master</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    
                    <div class="card-body card-block">

                        <form action="{{ url('itax/save-saving-type') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year <span>(*)</span></label>
                                    <select name="financial_year" class="form-control" onchange="getTaxTypeInfo(this.value);">
                                        <option value="">Choose a year</option>
                                        <?php $starting_year  = date('Y', strtotime('-10 year'));
                                        $ending_year = date('Y', strtotime('+10 year'));
                                        $current_year = date('Y');
                                        for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                            echo '<option value="' . $starting_year . '-' . ($starting_year + 1) . '"';
                                            if ($starting_year ==  $current_year) {
                                                echo ' selected="selected"';
                                            }
                                            echo ' >' . $starting_year . '-' . ($starting_year + 1) . '</option>';
                                        }               ?>
                                    </select>
                                    @if ($errors->has('financial_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('financial_year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Income Tax Type <span>(*)</span></label>
                                    <select name="i_tax_type"  id="i_tax_type" class="form-control" required>
                                        <option value="" selected disabled>Select</option>
                                        @foreach($income_tax as $tax)
                                        <option value='{{ $tax->id }}'>{{ $tax->tax_desc }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('i_tax_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('i_tax_type') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Saving Type Description <span>(*)</span></label>
                                    <input type="text" required id="saving_type_desc" name="saving_type_desc" class="form-control" value="">
                                    @if ($errors->has('saving_type_desc'))
                                    <div class="error" style="color:red;">{{ $errors->first('saving_type_desc') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">ITax Report Ref.</label>
                                    @php
                                        $itaxRepoRef=\Helpers::getRefItaxRepo();
                                    @endphp
                                    <select name="income_tax_repo_ref"  id="income_tax_repo_ref" class="form-control" >
                                        <option value="" selected disabled>Select</option>
                                        @foreach($itaxRepoRef as $val)
                                        <option value='{{ $val }}'>{{ $val }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('income_tax_repo_ref'))
                                    <div class="error" style="color:red;">{{ $errors->first('income_tax_repo_ref') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Form 16 Ref.</label>
                                    @php
                                        $formXVIRef=\Helpers::getRefFormXVIRepo();
                                    @endphp
                                    <select name="form_xvi_ref"  id="form_xvi_ref" class="form-control" >
                                        <option value="" selected disabled>Select</option>
                                        @foreach($formXVIRef as $val)
                                        <option value='{{ $val }}'>{{ $val }}</option>

                                        @endforeach
                                    </select>
                                    @if ($errors->has('form_xvi_ref'))
                                    <div class="error" style="color:red;">{{ $errors->first('form_xvi_ref') }}</div>
                                    @endif
                                </div>

                            
                                <div class="col-md-4">
                                    <label class=" form-control-label">Maximum Amount <span>(*)</span></label>
                                    <input type="number" step="any" required id="max_amount" name="max_amount" class="form-control" value="">
                                    @if ($errors->has('max_amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_amount') }}</div>
                                    @endif
                                    <p>Input numeric ZERO if there is not ceiling.</p>
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


@section('scripts')
@include('incometax.partials.scripts')
<script type="text/javascript">
function getTaxTypeInfo(fyear)
{
    $.ajax({
        type:'GET',
        url:"{{url('itax/get-income-tax-type')}}/"+btoa(fyear),
        beforeSend: function() {
            $('#i_tax_type').attr('disabled', true);
        },
        success: function(response){
            var obj = jQuery.parseJSON(response);
            //console.log(obj.itypes);
            if (typeof obj.itypes !== 'undefined') {
                var optionStr="<option value=''>Select</option>";
                $.each(obj.itypes, function(i,e){
                    //console.log(e);
                    optionStr+="<option value='"+e.id+"'>"+e.tax_desc+"</option>";
                    
                });
                $('#i_tax_type').html(optionStr);
                $('#i_tax_type').attr('disabled', false);
            }
        }
    });
}
</script>

@endsection