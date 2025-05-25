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
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title"><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loan Configuration </h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Loan Master</a></li>

                        <li>/</li>
                        <li class="#"><a href="#">Loan Configaration</a></li>

                        <li>/</li>
                        <li class="active"><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loan Configuration </li>

                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">
                <div class="card">
                    <!-- <div class="card-header">
                            <strong><?php if(empty($loan_details->id)){ ?>Add <?php } ?>Loan Configuration </strong>

                            </div> -->
                    <div class="card-body card-block">
                        <form action="{{ url('masters/save-loanconfdetail') }}" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id"
                                value="<?php if(!empty($loan_details->id)){ echo $loan_details->id; }  ?>">
                            <div class="row form-group">

                                <div class="col-md-3">
                                    <label class="form-control-label">Loan Type<span>(*)</span></label>
                                    <select name="loan_type" class="form-control" required>
                                        <option value="" selected disabled>Select Loan Type</option>
                                        @foreach($loan_rs as $loan)
                                        <option value="{{ $loan->id }}"
                                            <?php if(isset($loan_details->loan_type) && !empty($loan_details->loan_type==$loan->id)){ echo 'selected'; }  ?>>
                                            {{ $loan->loan_type }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('loan_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('loan_id') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class=" form-control-label"> Max. Sanction Amount<span>(*)</span></label>
                                    <input type="text" name="max_sanction_amt" class="form-control"
                                        value="<?php if(!empty($loan_details->max_sanction_amt)){ echo $loan_details->max_sanction_amt; }  ?>"
                                        required>
                                    @if ($errors->has('max_sanction_amt'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_sanction_amt') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class=" form-control-label">Max. Number Of
                                        Installment<span>(*)</span></label>
                                    <input type="text" name="max_time" class="form-control"
                                        value="<?php if(!empty($loan_details->max_time)){ echo $loan_details->max_time; }  ?>"
                                        required>
                                    @if ($errors->has('max_time'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_time') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class=" form-control-label">Rate of Interest<span>(*)</span></label>
                                    <input type="text" name="rate_of_interest" class="form-control"
                                        value="<?php if(!empty($loan_details->rate_of_interest)){ echo $loan_details->rate_of_interest; }  ?>"
                                        required>



                                    @if ($errors->has('rate_of_interest'))
                                    <div class="error" style="color:red;">{{ $errors->first('rate_of_interest') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class=" form-control-label">Min. Working years<span>(*)</span></label>


                                    <select name="max_working_time" id="max_working_time" class="form-control" required>
                                        <?php for($i=1;$i<=40;$i++){ ?>
                                        <option value="<?=$i;?>"
                                            <?php if(!empty($loan_details->max_working_time)) { if($loan_details->max_working_time == $i){ echo "selected"; } } ?>>
                                            <?= $i ?></option>
                                        @php } @endphp
                                    </select>

                                    @if ($errors->has('max_working_time'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_working_time') }}</div>
                                    @endif
                                </div>


                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active"
                                            <?php if(!empty($loan_details->status)) { if($loan_details->status == "active"){ echo "selected"; } } ?>>
                                            Active</option>
                                        <option value="deactive"
                                            <?php if(!empty($loan_details->status)) { if($loan_details->status == "deactive"){ echo "selected"; } } ?>>
                                            Deactive</option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">Submit</button>

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
<?php //include("footer.php"); ?>
</div>
<!-- /#right-panel -->

@endsection


@section('scripts')
@include('masters.partials.scripts')

@endsection