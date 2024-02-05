<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.2);
}

input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    color: red;
    width: 10px;
    height: 10px;
    visibility: visible;
    border: 1px solid #3c8dbc;
    padding: 2px;
    margin: 1px 0;
    border-radius: 1px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
}

input[type=checkbox]:checked:after {
    content: "\2714";
    display: unset;
    font-weight: bold;
    width: 10px;
    height: 10px;
    padding: 2px
}

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
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class=" col-12 col-md-6 col-lg-3 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-file"></i> Approved Application
                                </span>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <b class="text-dark" style="font-size: 18px;">Total: <?php echo $studentCount; ?></b>
                            </div>
                            <div class="col-lg-2">
                            <form action="<?php echo base_url() ?>newAdmission" method="POST" id="byFilterMethod">
                            <div class="input-group mobile-btn float-right student_search">
                                        <select class="p-1 search_select" name="admission_year" id="admission_year">
                                            <?php if(!empty($admission_year)){ ?>
                                                <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                            <?php } ?>
                                            <option value="<?php echo ADMISSION_YEAR?>"><?php echo ADMISSION_YEAR?></option>
                                            <option value="<?php echo 2023?>"><?php echo 2023?></option>

                                            <!-- <option value="2021">2021</option> -->
                                            
                                        </select>
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                            </div>
                            
                                <div class="col-lg-3">
                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    <!-- <a style="float:right" class="btn btn-md btn-success pull-right mobile-btn border_right_radius" 
                                    id="shortListModel"><i class="fa fa-hourglass-start" style="color:white;"></i> <span style="color:white;">Shortlist</span> </a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-1 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Application Number</th>
                                    <th>Name</th>
                                    <th width="50">Percentage(%)</th>
                                    <!-- <th>Integrated Batch</th> -->
                                    <th>Category</th>
                                    <th>Pref-1</th>
                                    <th>Pref-2</th>
                                    <th>Board</th>
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>
                                </tr>
                                <tr class="row_filter">
                                        <th></th> 
                                        <th style="padding: 1px;"> <input type="text" name="application_number"
                                                id="application_number" value="<?php echo $application_number; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Application Number"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;"> <input type="text" name="student_name"
                                                id="student_name" value="<?php echo $student_name; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Name"
                                                autocomplete="off" />
                                        </th>

                                        <th style="padding: 1px;"> <input type="text" name="percentage_from"
                                                id="percentage_from" value="<?php echo $percentage_from; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="SSLC Percentage"
                                                autocomplete="off" />
                                        </th>

                                        <!-- <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="integrated_batch" name="integrated_batch"
                                                autocomplete="off">
                                                <?php if(!empty($integrated_batch)){ ?>
                                                <option value="<?php echo $integrated_batch; ?>"><?php echo $integrated_batch; ?>
                                                </option>
                                                <?php } ?>
                                                <option value="">Integrated Batch</option>
                                                <option value="JEE">JEE</option>
                                                <option value="NEET">NEET</option>
                                                <option value="CPT">CPT</option>
                                                <option value="CET">CET</option>
                                                <option value="CLAT">CLAT</option>
                                                <option value="NONE">NONE</option>

                                            </select>
                                        </th> -->

                                        <th width="110" style="padding: 1px;">
                                            <select class="form-control input-sm" id="by_category_name" name="by_category_name">
                                                <?php if($by_category_name != ""){ ?>
                                                    <option value="<?php echo $by_category_name; ?>" selected><b>Selected: <?php echo $by_category_name; ?></b></option>
                                                <?php } ?>  
                                                <option value="" >By Category</option>
                                                <?php if(!empty($casteInfo)){
                                                    foreach($casteInfo as $caste){ ?>
                                                    <option value="<?php echo $caste->name; ?>">
                                                        <?php echo $caste->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="by_first_preference" name="by_first_preference"
                                                autocomplete="off">
                                                <?php if(!empty($by_first_preference)){ ?>
                                                <option value="<?php echo $by_first_preference; ?>"><?php echo $by_first_preference; ?>
                                                </option>
                                                <?php } ?>
                                                <option value="">First Preference</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>">
                                                    <?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>

                                            </select>
                                        </th>
                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="by_second_preference" name="by_second_preference"
                                                autocomplete="off">
                                                <?php if(!empty($by_second_preference)){ ?>
                                                <option value="<?php echo $by_second_preference; ?>"><?php echo $by_second_preference; ?>
                                                </option>
                                                <?php } ?>
                                                <option value="">Second Preference</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>">
                                                    <?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>

                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="by_board_name" name="by_board_name" autocomplete="off">
                                                <?php if(!empty($by_board_name)){ ?>
                                                <option value="<?php echo $by_board_name; ?>">
                                                    <?php echo $by_board_name; ?></option>
                                                <?php } ?><option value="">By Board</option>
                                                <?php if(!empty($boardInfo)){ 
                                                    foreach($boardInfo as $board){ ?>
                                                    <option value="<?php echo $board->board_name; ?>"><?php echo $board->board_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <!-- <th width="110" style="padding: 1px;">
                                            <select class="form-control input-sm" id="sms_status" name="sms_status">
                                                <?php if($sms_status != ""){ ?>
                                                <option value="<?php echo $sms_status; ?>" selected>
                                                    <?php echo $sms_status; ?></option>
                                                <?php } ?>
                                                <option value=""> Filter By</option>
                                                <option value=""> ALL</option>
                                                <option value="Shortlisted">Shortlisted</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                        </th> -->
                                        <th style="padding: 1px;" class="text-center">
                                            <button type="submit"
                                            class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button>
                                        </th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if(!empty($studentInfo)) {
                                    foreach($studentInfo as $record) {
                                        if($record->shortlisted_status == 1){
                                            $status = "<b style='color:green'>Shortlisted</b>";
                                        }else{
                                            $status = "<b style='color:red'>Pending</b>";
                                        }
                                ?> <tr>
                                    <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $record->application_number; ?>" /></th>
                                    <th class="text-center"><?php echo $record->application_number; ?></th>
                                    <th><?php echo $record->name; ?></th>
                                    <th class="text-center"><?php echo $record->sslc_percentage .' %'; ?> </th>
                                    <!-- <th class="text-center"><?php echo $record->integrated_batch; ?> </th> -->
                                    <td><?php echo $record->student_category; ?></td>
                                    <td><?php echo $record->stream_name; ?></td>
                                    <td><?php echo $record->second_stream_name; ?></td>
                                    <th><?php echo $record->board_name; ?></th>
                                    <!-- <td><?php echo $status; ?></td> -->
                                   
                                    <th class="text-center">
                                        <a class="btn btn-xs btn-info" title="<?php echo $record->name; ?>" data-toggle="popover" data-placement="left" 
                                            data-content="<b>Student Mobile No.:</b> <?php echo $record->student_mobile; ?><br/><b>Father Mobile No.:</b> <?php echo $record->father_mobile; ?> <br/> <b>Mother Mobile No.:</b> <?php echo $record->mother_mobile; ?> <br/>"
                                            href="#" title="View More"><i class="fa fa-info-circle"></i></a>
                                        <a class="btn btn-xs btn-primary" target="_blank"
                                            href="<?php echo base_url(); ?>editSingleStudentApplications/<?php echo $record->resgisted_tbl_row_id; ?>"
                                            title="View More"><i class="fa fa-eye"></i></a>
                                        <!-- <a class="btn btn-xs btn-primary p-2" target="_blank"
                                        href="<?php echo base_url(); ?>viewPrintApplication/<?php echo $record->resgisted_tbl_row_id; ?>"
                                        title="Edit"><i class=""></i> Print</a> -->
                                        <a class="btn btn-xs btn-primary p-2" target="_blank"
                                            href="<?php echo base_url(); ?>viewPrintApplication/<?php echo $record->resgisted_tbl_row_id; ?>"
                                            title="Edit"><i class=""></i> Print</a>
                                    </th>
                                </tr>
                                <?php } }else{ ?>
                                    <tr>
                                        <td class="text-center" colspan="10">Student Record Not Found</td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Application Number</th>
                                    <th>Name</th>
                                    <th width="50">Percentage(%)</th>
                                    <!-- <th>Integrated Batch</th> -->
                                    <th>Category</th>
                                    <th>Pref-1</th>
                                    <th>Pref-2</th>
                                    <th>Board</th>
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer text-center pt-1 px-1 pb-0">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
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
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Confirm Shortlist Students</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>
                    <div class="row">
                        <div class="col-lg-12">
                    <label style="font-size: 18px;">Total Students Selected: <label id="countStudents"></label></label>
                        </div>
                    <!-- <hr> -->
                    <!-- <div class="col-lg-6">
                    <label style="font-size: 18px;" id="alertMsg">Select List</label>

                         <select class="form-control input-sm" id="shortlist_number" name="shortlist_number" autocomplete="off">    
                            <option value="">Select</option>
                             <option value="1" >I</option>
                            <option value="2" >II</option>
                             <option value="3" >III</option>
                            <option value="4" >IV</option>
                        </select>
                    </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close</button>
                        <button id="addStudentShortlisted" type="button" class="btn btn-md btn-primary"> Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    // $(".reason_unqualified").hide();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "newAdmission/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker, .dateSearch').datepicker({
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

    
    $('#shortListModel').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Shortlist!");
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
        // var online_interview_date = $("#online_interview_date").val();
        // var interview_link = $("#interview_link").val();
        // var any_comments = $("#any_comments").val();
        // var shortlist_number = $("#shortlist_number").val();

        // var contenteditable = document.querySelector('[contenteditable]'),
        // content = contenteditable.textContent;
        var students = [];
       

        $('#alertMsg').html('<span>' + loader + '</span>');
        //$('#shortListModelView').modal('show');
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $.ajax({
            url: baseURL + '/updateShortListedStudents',
            type: 'POST',
            data: {
                students_appliction_number: JSON.stringify(students),
                // online_interview_date: online_interview_date,
                // interview_link: interview_link,
                // any_comments: any_comments,
                // shortlist_number: shortlist_number,
            },
            success: function(data) {
                if (data > 0) {
                    $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  Selected Students Shortlisted Successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
                }
                setTimeout(function() {
                    location.reload();
                    //$('#shortListModelView').modal('hide');

                }, 2000);

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

    $('#leaving_date, .datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy"
    });
    
    // popover
    $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
    $('[data-toggle="popover"]').mouseenter(function(){
      $(this).trigger('focus');
    }); 
});

</script>