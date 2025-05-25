@extends('masters.layouts.master')

@section('title')
BELLEVUE - Payment Booking
@endsection

@section('sidebar')
    @include('mis-reports.includes.sidebar')
@endsection

@section('header')
    @include('masters.partials.header')
@endsection

@section('scripts')
    @include('mis-reports.includes.scripts')
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
                        <div class="card-header"> <strong>GL Report</strong> </div>
                        <div class="card-body card-block">
                            <!-- @if(Session::has('message'))
                                <div class="alert alert-danger" style="text-align:center;">
                                    <span class="glyphicon glyphicon-ok" ></span>
                                    <em> {{ Session::get('message') }}</em>
                                </div>
                            @endif -->
                            @include('include.messages')
                            <form action="" method="post" style="width: 70%;margin: 0 auto;" target="_blank">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row form-group">

                                        <div class="col-md-4">
                                            <label>GL Head Type</label>
                                            <select name="gl_head_type" id="gl_head_type" class="form-control" required onchange="getGlHeads()">
                                                <option value=""> Select GL Type </option>
                                                <option value="income"> Income </option>
                                                <option value="expense"> Expense/Liability/Asset </option>

                                            </select>
                                        </div>

                                    <div class="col-md-4">
                                        <label>GL Head</label>
                                        <select name="gl_head" id="gl_head" class="form-control" required>
                                            <option value=""> Select </option>

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Choose Year</label>
                                        <select name="financial_year"  class="form-control" required>
                                            <option value="">Please Select Your Year </option>
                                            <?php  $cur_year = date('Y');
                                                for ($i=0; $i<=5; $i++) {
                                                    $years= $cur_year--;
                                                    $previous_year = $years+1;
                                                    ?>
                                                    <option value="<?php echo $years.'-'.$previous_year ?>"><?php echo $years.'-'.$previous_year ?> </option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-4 btn-up">
                                    <button type="submit" class="btn btn-danger btn-sm" id="showbankstatement">Show </button>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script>
        function getGlHeads()
        {
            var gl_head_type = $("#gl_head_type option:selected").val();
            // alert(gl_head_type);
            $.ajax({
                type:'GET',
                url:'{{url('glhead/report')}}/'+gl_head_type,
                success: function(response){

                // console.log(response);
                var obj= JSON.parse(response);
                // console.log(obj);
                var option = '<option value="" label="Select">Select </option>';
                for (var i=0;i<obj.length;i++){
                   option += '<option value="'+ obj[i].account_code + '">' + obj[i].account_name + '</option>';
                }

                $('#gl_head').html(option);


            }
      });
        }

    </script>

@endsection

@section('scripts')
    @include('attendance.partials.scripts')

@endsection
