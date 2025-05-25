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
            <h5 class="card-title"><?php if(empty($tds_details->id)){ ?>Add <?php } ?>Tds</h5>      
</div>
<div class="col-md-6">

                           <span class="right-brd" style="padding-right:15x;">
                            <ul class="">
                                <li><a href="#">Account Master</a></li>
                                
								<li>/</li>
                                <li><a href="#">TDS Master</a></li>
                                
								<li>/</li>

                                <li class="active"><?php if(empty($tds_details->id)){ ?>Add <?php } ?>Tds</li>
						
                            </ul>
                        </span>
</div>
</div>
                <!-- Widgets  -->
                <div class="row">
                  
                    <div class="main-card"> 
                        <div class="card">
                            <!-- <div class="card-header">
                            <strong><?php if(empty($tds_details->id)){ ?>Add <?php } ?>Tds</strong>
                             
                            </div> -->
                            <div class="card-body card-block">
                            <form action="{{ url('masters/save-tdsdetail') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="<?php if(!empty($tds_details->id)){ echo $tds_details->id; }  ?>">
                                <div class="row form-group">                                    
								    
                                    <div class="col-md-6">
                                        <label class="form-control-label">TDS Section <span>(*)</span></label>
                                        <input type="text" name="tds_section" id="tds_section" class="form-control" value="<?php if(!empty($tds_details->tds_section)){ echo $tds_details->tds_section; }  ?>" <?php if(!empty($tds_details->id)){ echo "readonly"; }  ?> required>
                                        @if ($errors->has('tds_section'))
                                            <div class="error" style="color:red;">{{ $errors->first('tds_section') }}</div>
                                        @endif
                                    </div>


                                    <div class="col-md-6">
                                        <label class=" form-control-label">TDS Percentage<span>(*)</span></label>
                                        <input type="number" name="tds_percentage" class="form-control" value="<?php if(!empty($tds_details->tds_percentage)){ echo $tds_details->tds_percentage; }  ?>" required>

                                        @if ($errors->has('tds_percentage'))
                                            <div class="error" style="color:red;">{{ $errors->first('tds_percentage') }}</div>
                                        @endif
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


<script>

    function selectAccountname(){
      var account_type_id = $("#account_type").val();
      $.ajax({
        type:'GET',
        url:'{{url('masters/accounttype')}}/'+account_type_id,        
        success: function(response){
            var obj = jQuery.parseJSON( response );
            option = '<option value="">Select Account Name</option>';
            for (var i=0;i<obj.length;i++){
              option += '<option value="'+ obj[i].account_name + '">' + obj[i].account_name +  '</option>';
            }
            $('#account_name').html(option);            
        }
      });
    }

    function generateCode(){
      var account_type_id = $("#account_type").val();
      var account_name = $("#account_name").val();
      $.ajax({
        type:'GET',
        url:'{{url('masters/coacode')}}/'+account_type_id+'/'+account_name,        
        success: function(response){
            //console.log(response);
            if(response=='null'){
                
                $.ajax({
                    type:'GET',
                    url:'{{url('masters/getbasecode')}}/'+account_type_id+'/'+account_name,        
                    success: function(response){
                        var obj = jQuery.parseJSON( response );
                        var final_code = obj.account_code+'/00'+1;
                        $('#coa_code').val(final_code);           
                    }
                });

            }else{

                var obj = jQuery.parseJSON( response );
                var res = obj.coa_code.split("/");
                var set_base_code = parseInt(res[2])+1;
                var set_base_code_length = set_base_code.toString().length;
                if(set_base_code_length==1){
                    var final_code = res[0]+'/'+res[1]+'/00'+set_base_code;

                }else{
                    var final_code = res[0]+'/'+res[1]+'/0'+set_base_code;  
                }
               
                $('#coa_code').val(final_code);  
            }                   
        }
      });
    }

</script>


@section('scripts')
@include('masters.partials.scripts')

@endsection
