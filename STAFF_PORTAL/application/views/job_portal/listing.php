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
<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if ($error) { 
?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong>
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
    $success = $this->session->flashdata('success');
    if ($success) { 
?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Job Application
                                </span>
                            </div>
                            
                            <div class="col-lg-3 col-md-5 col-12">
                             <form action="<?php echo base_url() ?>jobPortal" method="POST" id="byFilterMethod">

                                <div class="input-group">
                                        <div class="input-group-prepend">
                                            <!-- <span class="input-group-text" ><b>From Date</b></span> -->
                                            </div>
                                        <input type="text" value="<?php echo date('d-m-Y',strtotime($date_from_filter)); ?>"
                                            class="form-control rounded datepicker" id="" name="date_from_filter"
                                            placeholder="Date From" style="font-weight:500;color:black;" aria-label="Search"
                                            aria-describedby="search-addon" autocomplete="off" />

                                            <input type="text" value="<?php echo date('d-m-Y',strtotime($date_to_filter)); ?>"
                                            class="form-control rounded datepicker" id="" name="date_to_filter"
                                            placeholder="Date To" style="font-weight:500;color:black;" aria-label="Search"
                                            aria-describedby="search-addon" autocomplete="off" />
                                 

                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-secondary border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                    </div>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                Total Count : <?php echo $totalApplicants; ?>
                                </span>
                            </div>
                             <!-- <div class="col-lg-1 col-12 col-md-4 col-sm-4">
                                    <a class="btn btn-danger mobile-btn pull-right"  id="shortListModel"
                                        href="#"><i class="fa fa-plus"></i>
                                        Shortlist</a>
                                </div> -->
                                <div class="col-lg-2 col-12 col-md-4 col-sm-4">
                                    <!-- <a class="btn btn-danger mobile-btn pull-left" id="addot" href="#"><i class="fa fa-plus"></i> Shortlist</a> -->
                                    <a onclick="showLoader();window.history.back();" class="btn btn-secondary mobile-btn float-right text-white" value="Back"><i class="fa fa-arrow-circle-left"></i> Back</a>
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
                        <table class="display table table-bordered table-striped table-hover w-100">
                            <tr>
                                
                              <th width="1%">

                              </th>  
                            <th style="padding: 1px;">
                                        <input type="text" name="applied_date" value="<?php echo $applied_date; ?>" class="form-control datepicker input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Applied Date"/>
                                    </th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="subject" value="<?=$subject;?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Subject"/>
                                    </th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="applicant_name" value="<?=$applicant_name;?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Name"/>
                                    </th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="mobile_number" value="<?=$mobile_number;?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Mobile Number"/>
                                    </th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="qualification" value="<?=$qualification;?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Qualification"/>
                                    </th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="work_experience" value="<?=$work_experience;?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Work Experience"/>
                                    </th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="bed_percent" value="<?=$bed_percent;?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By B.Ed Percent"/>
                                    </th>
                                    <th style="padding: 1px;">
                                    <select class="form-control" data-live-search="true" id="job_post" name="job_post">
                                    <?php if($job_post != ""){ ?>

                                    <option value="<?php echo $job_post; ?>" selected><b>Sorted:

                                            <?php echo $job_post; ?></b></option>

                                    <?php } ?>
                                    <option value="">Select Job Post</option>

                                    <?php foreach($getPostName as $job){ ?>
                                    <option value="<?php echo $job->job_post ?>"><?php echo $job->job_post ?></option>
                                    <?php } ?>

                                    </select>
                                    </th>
                                    <th style="padding: 1px;"></th>                     
                                    <th style="padding: 1px;" class="text-center">
                                        <button type="submit" class="btn btn-success btn-md btn-block"> Filter</button>
                                    </th>
                                </form>
                            </tr>
                            <thead>
                                <tr class="text-center table_row_background">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Applied Date</th>
                                    <th>Subject</th>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Qualification</th>
                                    <th>Work Experience</th>
                                    <th>B.Ed Percent</th>
                                    <th>Job Post</th>
                                    <th>Resume</th>
                                    <th class="text-center" width="100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($applicants)){
                                    foreach($applicants as $apcnt){
                                ?>
                                    <tr>
                                    <td><input type="checkbox" class="singleSelect"
                                                     value="<?php echo $apcnt->row_id; ?>" /></td>

                                    <td><?php echo date('d-m-Y', strtotime($apcnt->created_date_time)); ?></td>
                                        <td><?=$apcnt->subject;?></td>
                                        <td><?=$apcnt->fullname;?></td>
                                        <td><?=$apcnt->mobile_number;?></td>
                                        <td><?=$apcnt->qualification;?></td>
                                        <td><?=$apcnt->work_experience;?></td>
                                        <td><?=$apcnt->bed_percent;?></td>
                                        <td><?=$apcnt->job_post;?></td>
                                        <td class="text-center">
                                            <?php
                                                if(!empty($apcnt->resume)){
                                                        $resumeUrl = JOB_PORTAL_PATH.$apcnt->resume;
                                                    ?>
                                                        <a class="btn btn-xs btn-info mb-1" target="_blank" href="<?=$resumeUrl;?>" title="View Resume">
                                                            <i class="fa fa-file"></i> View Resume
                                                        </a>
                                            <?php   }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                                if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $this->staff_id == '204' || $role == ROLE_SUPER_ADMIN)
                                                {                                    ?>
                                                    <a class="btn btn-xs btn-success" target="_blank" href="<?=base_url();?>jobPortal/viewApplicant/<?=$apcnt->row_id;?>" title="View Detailed View"><i class="fa fa-eye"></i>  </a>
                                                    <button class="btn btn-xs btn-danger" onclick="deleteApplicant(this,'<?=$apcnt->row_id;?>','<?=$apcnt->fullname;?>')" title="Delete the Applicant"><i class="fa fa-trash"></i>  </button>
                                            <?php } else { ?>
                                                    <a class="btn btn-xs btn-success" target="_blank" href="<?=base_url();?>jobPortal/viewApplicant/<?=$apcnt->row_id;?>" title="View Detailed View"><i class="fa fa-eye"></i>  </a>
                                                    <button class="btn btn-xs btn-danger" onclick="deleteApplicant(this,'<?=$apcnt->row_id;?>','<?=$apcnt->fullname;?>')" title="Delete the Applicant"><i class="fa fa-trash"></i>  </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else { ?>
                                    <tr class="table-info">
                                        <td class="text-center" colspan="11">
                                        Sorry! No applicants found!
                                        </td>
                                    </tr>
                            <?php }
                            ?>
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

<!-- The Modal -->
<div class="modal" id="shortListModelView">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header table-primary ">
                <h4 class="modal-title">Confirm Shortlist Application</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>
                    <label style="font-size: 18px;">Total Application Selected: <label id="countStudents"></label></label>
                    <hr class="m-1">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                        <button id="addStudentShortlisted" type="button" class="btn btn-md btn-primary"> Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "jobPortal/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        
        format: "dd-mm-yyyy",
       
    });
    jQuery('#last_date_add').datepicker({
        autoclose: true,
        orientation: "bottom",
       
        dateFormat: 'dd-mm-yy',
       
    });
    
   
    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    $('#shortListModel').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Application To Shortlist!");
            return;
        } else {
            $('#shortListModelView').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudents').html($('.singleSelect:checkbox:checked').length);
    });

    $('#addStudentShortlisted').click(function() {
        // alert('hi');
        var students = [];
        $('#alertMsg').html('<span>' + loader + '</span>');
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        // alert(students);
        $.ajax({
            url: baseURL + "updateShortlistApplication",
            type: 'POST',
            data: {
                students_appliction_number: JSON.stringify(students),
            },
            
            success: function(data) {
                if (data > 0) {
                    $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  Selected Application Shortlisted Successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
                }
                setTimeout(function() {
                    location.reload();
                }, 500);

            },
            error: function(result) {
                alert("Retry Again! Something Went Wrong");
            },
            fail: (function(status) {
                alert("Retry Again! Something Went Wrong");
            }),
            beforeSend: function(d) {
                $('#alertMsg').html('<span>' + loader + '</span>');
            }
        });

    });
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>

<script>
    function deleteApplicant($this,apcntID,apcntName){
        if(confirm("Are you sure to delete the applicant with name "+apcntName.toUpperCase()+" ?")){
            $.post("<?=base_url()?>jobPortal/deleteApplicant",{row_id:apcntID}).done(res=>{
                if(res > 0){
                    alert("Applicant deleted successfully");
                    $($this).parent().parent().remove();
                }else{
                    alert("Something went wrong. Please try later.");
                }
            })
            .fail(err=>{
                console.log(err);
            });
        }
    }


    
</script>