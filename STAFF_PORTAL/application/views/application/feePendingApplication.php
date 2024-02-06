<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
}
</style>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-6 col-md-5 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">description</i> Application Fee Pending
                                </span>
                            </div>
                            <div class="col-lg-3 col-md-5 col-sm-4 col-6">
                                <b class="text-dark count_title" >Total Applications: <?php echo $applicationCount; ?></b>
                            </div>
                            <div class="col-lg-3 col-6 col-md-12 col-sm-6 box-tools">
                            <form action="<?php echo base_url(); ?>viewApplicationFeePending" method="POST" id="byFilterMethod">
                                <div class="input-group mobile-btn float-right student_search">
                                            <select class="p-1 search_select" name="admission_year" id="admission_year">
                                                <?php if(!empty($admission_year)){ ?>
                                                    <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                                <?php } ?>
                                                <option value="<?php echo ADMISSION_YEAR?>"><?php echo ADMISSION_YEAR?></option>

                                                <option value="2023">2023</option>
                                                <!-- <option value="2022">2022</option>
                                                <option value="2021">2021</option> -->
                                                
                                            </select>
                                            <div class="input-group-append">
                                            <button type="submit" class="btn btn-success border_radius_none py-0">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            </div>
                                        </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-12">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="table table-bordered table-striped table-hover w-100 mb-2">
                                <tr class="filter_row">
                                    <td width="150">
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $application_no; ?>" name="application_no" id="application_no" class="form-control input-sm text-uppercase" placeholder="Application Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name" class="form-control input-sm text-uppercase" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    
                                   
                                    <td width="140">
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_dob; ?>" name="by_dob" id="by_dob" class="form-control datepicker input-sm text-uppercase" placeholder="Date of Birth" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" id="program_name" name="program_name">
                                                <?php if(!empty($program_name)){?>
                                                <option value="<?php echo $program_name; ?>" selected>Selected:<?php echo $program_name; ?></option>     
                                                <?php }?>
                                                <option value="">Select Course </option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" id="stream_name" name="stream_name">
                                                <?php if(!empty($stream_name)){?>
                                                <option value="<?php echo $stream_name; ?>" selected>Selected:<?php echo $stream_name; ?></option>     
                                                <?php }?>
                                                <option value="">Select Stream Name </option>
                                                <?php if(!empty($StreamInfo)){
                                                            foreach($StreamInfo as $record){ ?>
                                                <option value="<?php echo $record->stream_name; ?>"><?php echo $record->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" id="religion" name="religion">
                                                <?php if(!empty($religion)){?>
                                                <option value="<?php echo $religion; ?>" selected>Selected:<?php echo $religion; ?></option>     
                                                <?php }?>
                                                <option value="">Select Religion </option>
                                                <?php if(!empty($religionInfo)){
                                                            foreach($religionInfo as $record){ ?>
                                                <option value="<?php echo $record->name; ?>"><?php echo $record->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>

                                     
                                      
                                  
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                    <th class="text-center">Application No.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">DOB</th>
                                    <th class="text-center">Course</th>
                                    <th class="text-center">Stream</th>
                                    <th class="text-center">Religion</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($applicationInfo)){ 
                                    foreach($applicationInfo as $record){ 
                                        // $isExist = $markInfo->isPaymentDone($record->resgisted_tbl_row_id);
                                        // if(empty($isExist)) { ?>
                                    <tr>
                                        <th class="text-center"><?php echo $record->application_number; ?></th>
                                        <th><?php echo $record->name; ?></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($record->dob)); ?></th>
                                        <th class="text-center"><?php echo $record->program_name; ?></th>
                                        <th class="text-center"><?php echo $record->stream_name; ?></th>
                                        <th class="text-center"><?php echo $record->religion; ?></th>

                                        <th class="text-center">
                                            <span><a href="#" title="Name : <?php echo $record->name; ?>" data-toggle="popover" data-content="<span class='font-weight-bold'>Father's Info</span> <br/> Name: <?php echo $record->father_name; ?> <br/> Mobile No.: <?php echo $record->father_mobile; ?> <br/> <hr class='mx-0 my-1'> <span class='font-weight-bold'>Mother's Info</span> <br/> Name: <?php echo $record->mother_name; ?> <br/> Mobile No.: <?php echo $record->mother_mobile; ?><br/><hr class='mx-0 my-1'> Email: <?php echo $record->student_email; ?>"><span class="badge badge-primary"> <i class="fa fa-info-circle"></i></span></a></span>  
                                            <?php if($role == ROLE_ADMIN ||  $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                <a class="btn btn-xs btn-danger applicationPendingPaymentComplete"
                                        data-row_id="<?php echo $record->resgisted_tbl_row_id; ?>" href="#" title="Paid">
                                        <i class="fas fa-money-bill-alt"></i> Paid</a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{ ?>
                                    <tr>
                                        <th colspan="7" class="text-center">Application Not Found</th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/admission.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewApplicationFeePending/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    jQuery(document).on("click", ".applicationPendingPaymentComplete", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "applicationPendingPaymentComplete",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure that Student Application Payment Completed?");
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Application successfully Updated"); }
				else if(data.status = false) { alert("Failed to Update"); }
				else { alert("Access denied..!"); }
			});
		}
	});
    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    // popover
    $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
    $('[data-toggle="popover"]').mouseenter(function(){
        $(this).trigger('focus');
    });
});
</script>