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
                            <div class="col-lg-4 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">description</i> Grievance
                                </span>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                <b class="text-dark count_title">Total Grievances: <?php echo $applicationCount; ?></b>
                            </div>
                            <div class="col-lg-3 col-6 col-md-12 col-sm-6 box-tools">
                            <form action="<?php echo base_url(); ?>viewGrievance" method="POST" id="byFilterMethod">
                                <div class="input-group mobile-btn float-right student_search">
                                            <select class="p-1 search_select" name="admission_year" id="admission_year">
                                                <?php if(!empty($admission_year)){ ?>
                                                    <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                                <?php } ?>
                                                <option value="2024">2024</option>

                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                
                                            </select>
                                            <div class="input-group-append">
                                            <button type="submit" class="btn btn-success border_radius_none py-0">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            </div>
                                        </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
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
                                <!-- <td >
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name" class="form-control input-sm text-uppercase" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>  -->
                                    <td>

                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $mobile; ?>" name="mobile" id="mobile" class="form-control input-sm text-uppercase" placeholder="Mobile Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td width="150">
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $application_no; ?>" name="application_no" id="application_no" class="form-control input-sm text-uppercase" placeholder="Application Number" autocomplete="off">
                                        </div>
                                    </td>-->
                                  
                                  
                                  
                                    
                                    <td >
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $subject; ?>" name="subject" id="subject" class="form-control input-sm text-uppercase" placeholder="Subject" autocomplete="off">
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $message; ?>" name="message" id="message" class="form-control input-sm text-uppercase" placeholder="Message" autocomplete="off">
                                        </div>
                                    </td>
                                    <td >
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $date; ?>" name="date" id="date" class="form-control datepicker input-sm text-uppercase" placeholder="Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                    <!-- <th class="text-center">Application No.</th> -->
                                    <!-- <th class="text-center">Name</th> -->
                                    <th class="text-center">Mobile Number</th>
                                    <th class="text-center">Subject</th>
                                    <th class="text-center">Message</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($applicationInfo)){ 
                                    foreach($applicationInfo as $record){ 
                                        if($record->active_status == "1") { ?>
                                    <tr>
                                    <!-- <th style="background-color:#90EE90"><?php echo $record->name; ?></th> -->
                                    <th class="text-center" style="background-color:#90EE90"><?php echo $record->mobile; ?></th>
                                        <th class="text-center" style="background-color:#90EE90"><?php echo $record->subject; ?></th>
                                        <th class="text-center" style="background-color:#90EE90"><?php echo $record->message; ?></th>
                                        <th class="text-center" style="background-color:#90EE90"><?php echo date('d-m-Y',strtotime($record->created_date_time)); ?></th>
                                       <th class="text-center" style="background-color:#90EE90"> <a class="btn btn-xs btn-danger grievanceInactive" href="#"
                                            data-row_id="<?php echo $record->row_id; ?>" title="Active"><i
                                                class="fa fa-times"></i></a></th>
                                    </tr>
                                    <?php } else { ?>
                                        <tr>
                                        <!-- <th><?php echo $record->name; ?></th>  -->
                                        <th class="text-center"><?php echo $record->mobile; ?></th>
                                        <th class="text-center"><?php echo $record->subject; ?></th>
                                        <th class="text-center"><?php echo $record->message; ?></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($record->created_date_time)); ?></th>
                                       <th class="text-center"> <a class="btn btn-xs btn-success grievanceSolved" href="#"
                                            data-row_id="<?php echo $record->row_id; ?>" title="Inactive"><i
                                                class="fa fa-check"></i></a></th>
                                    </tr>
                                    <?php } ?>
                                <?php } }else{ ?>
                                    <tr>
                                        <th colspan="7" class="text-center">Grievance Not Found</th>
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


<script type="text/javascript">
jQuery(document).ready(function() {
    
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewRejectedApplication/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });


    jQuery(document).on("click", ".grievanceSolved", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "grievanceSolved",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to Inactive this Grievance ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				if(data.status = true) { alert("Grievance successfully Inactivated"); 
			 window.location.reload();}
				else if(data.status = false) { alert("Grievance Inactivation failed"); }
				else { alert("Access denied..!"); }
			});
		}

});


jQuery(document).on("click", ".grievanceInactive", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "grievanceInactive",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to Activate this Grievance ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				if(data.status = true) { alert("Grievance successfully Activated"); 
			 window.location.reload();}
				else if(data.status = false) { alert("Grievance Activation failed"); }
				else { alert("Access denied..!"); }
			});
		}

});

    
});
</script>