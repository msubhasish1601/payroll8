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
                        <strong>Add VDA Details</strong>
                    </div>
                    <div class="card-body card-block">

                        <form action="{{ url('masters/search-vda-details') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row form-group">

                                <div class="col-md-4">
                                    <label class=" form-control-label">Pay Month Year <span>(*)</span></label>
                                    <select class="form-control" name="pay_month_year" required>

                                        <option value='' selected disabled>Select</option>
                                        @foreach($vda_details as $emptype)
                                        <option value='{{ $emptype->pay_month_year }}'  >{{ $emptype->pay_month_year }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('pay_month_year'))
                                    <div class="error" style="color:red;">{{ $errors->first('pay_month_year') }}</div>
                                    @endif
                                </div>

                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">Submit
                            </button>

                        </form>
                    </div>



                </div>
                <div class="card">

                    <div class="card-header">
                        <strong class="card-title">View VDA Details</strong>


                    </div>

                    <form action="{{url('pis/arear-calculation-save')}}" method="post" style="background: none;padding:0;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <br />
                        <div class="clear-fix">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        
                                        <th>Pay Month Year</th>
                                        <th>Employee Type Desc</th>
                                        <th>VDA Current</th>
                                        <th>VDA Previous</th>
                                        <th>VDA Previous Previous</th>
                                        <th>OT VDA</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php print_r($result); ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="32" style="border:none;">
                                            <!-- <button type="button" class="btn btn-danger btn-sm checkall" style="margin-right:2%;">Check All</button> -->
                                            <!-- <button type="submit" class="btn btn-danger btn-sm">Save</button> -->
                                            <!-- <button type="reset" class="btn btn-danger btn-sm"> Reset</button> -->
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>


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
<?php //include("footer.php"); 
?>
</div>
<!-- /#right-panel -->






@endsection