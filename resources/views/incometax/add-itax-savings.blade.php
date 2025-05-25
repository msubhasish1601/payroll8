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
                <h5 class="card-title">Add Income Tax Savings</h5>
            </div>
            <div class="col-md-6">
                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Income Tax Savings</a></li>
                        <li>/</li>
                        <li><a href="#">Add Income Tax Savings</a></li>
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

                        <form action="{{ url('itax/add-employee-savings') }}" method="post"
                            enctype="multipart/form-data" onsubmit="return validateMe();">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Financial Year</label><br>
                                    <input type="hidden" name="financial_year" value="{{$fyear}}">
                                    {{$fyear}}<br>
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Name</label><br>
                                    {{$empInfo->salutation?$empInfo->salutation.' ':''}}{{$empInfo->emp_fname??''}}{{$empInfo->emp_mname?' '.$empInfo->emp_mname:''}}{{$empInfo->emp_lname?' '.$empInfo->emp_lname:''}}<br>
                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Employee Code</label><br>
                                    <input type="hidden" name="emp_code" value="{{$empInfo->emp_code}}">
                                    {{$empInfo->old_emp_code}}<br>
                                </div>

                                <div class="col-md-4">
                                    <label class=" form-control-label">Income Tax Type <span>(*)</span></label>
                                    <select name="i_tax_type"  id="i_tax_type" class="form-control" required  onchange="getSavingsTypeInfo(this.value);">
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
                                    <label class=" form-control-label">Savings Type<span>(*)</span></label>
                                    <select name="saving_type_id"  id="saving_type_id" class="form-control" required>
                                        <option value="" selected disabled>Select</option>
                                        
                                    </select>
                                    @if ($errors->has('saving_type_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('saving_type_id') }}</div>
                                    @endif
                                </div>
                               

                                <div class="col-md-4">
                                    <label class=" form-control-label">Amount <span>(*)</span></label>
                                    <input type="number" step="any" required id="amount" name="amount"
                                        class="form-control" value="">
                                    <input type="hidden" id="maxamount" name="maxamount"
                                        class="form-control" value="">
                                    @if ($errors->has('amount'))
                                    <div class="error" style="color:red;">{{ $errors->first('amount') }}</div>
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
function getSavingsTypeInfo(taxtype)
{
    $.ajax({
        type:'GET',
        url:"{{url('itax/get-saving-type')}}/"+btoa(taxtype),
        beforeSend: function() {
            $('#saving_type_id').attr('disabled', true);
        },
        success: function(response){
            var obj = jQuery.parseJSON(response);
            //console.log(obj);
            if (typeof obj.stypes !== 'undefined') {
                var optionStr="<option value=''>Select</option>";
                var myArray = new Array();
                const maxArray = new Array();
                var json_arr = {};
                $.each(obj.stypes, function(i,e){
                    //console.log(e);
                    optionStr+="<option value='"+e.id+"'>"+e.saving_type_desc+"</option>";
                    json_arr[e.id] = e.max_amount;
                });
                $('#saving_type_id').html(optionStr);
                $('#saving_type_id').attr('disabled', false);

                
                var json_string = JSON.stringify(json_arr);
                //console.log(json_string);
                $('#maxamount').val(btoa(json_string));
                // var parsejson=JSON.parse(atob($('#maxamount').val()));
                // console.log(parsejson[2]);
               

            }
        }
    });
}

function validateMe(){
    var parsejson=JSON.parse(atob($('#maxamount').val()));
    var selectedOption=$('#saving_type_id').val()
    if(eval($('#amount').val())>eval(parsejson[selectedOption]))
    {
        alert("Maximum saving limit under this head is "+parsejson[selectedOption]+".");
        return false;
    }
    return true;
}
</script>

@endsection