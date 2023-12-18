<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php
$noMatch = $this->session->flashdata('nomatch');
if ($noMatch) {
?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('nomatch'); ?>
    </div>
<?php } ?>



<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fas fa-pencil-alt"></i> Create Exam </span>
                            </span>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4 text-center">
                            <b class="text-dark" style="font-size: 20px;">Total : <?php echo $totalCount; ?></b>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4">
                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) {
                            ?>
                                <button class="btn btn-primary float-right mobile-btn border_right_radius" data-toggle="modal" data-target="#addNewDocModel"><i class="fa fa-plus"></i> Add</button>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <div class="table-responsive-sm">
                    <table class="table table-hover table-bordered mb-2">
                        <tr class="row_filter">
                            <form action="<?php echo base_url() ?>examListing" method="POST" id="byFilterMethod">
                                <th>
                                    <div class="position-relative mb-0">
                                        <input type="text" value="<?php echo $exam_date; ?>" name="exam_date" id="exam_date" class="form-control input-sm datepicker" placeholder="By Date" autocomplete="off">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative mb-0">
                                        <input type="text" value="<?php echo $exam_name; ?>" name="exam_name" id="exam_name" class="form-control input-sm" placeholder="By Exam Name" autocomplete="off">
                                    </div>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="by_class" name="by_class">
                                        <?php if (!empty($by_class)) { ?>
                                            <option value="<?php echo $by_class ?>" selected><b>Selected: <?php echo $by_class ?></b></option>
                                        <?php } ?>
                                        <option value="">Search Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="by_stream" name="by_stream">
                                        <?php if (!empty($by_stream)) { ?>
                                            <option value="<?php echo $by_stream ?>" selected><b>Selected: <?php echo $by_stream ?></b></option>
                                        <?php } ?>
                                        <option value="">Search Stream</option>
                                        <?php if (!empty($streamInfo)) {
                                            foreach ($streamInfo as $stream) { ?>
                                                <option value="<?php echo $stream->stream_name ?>">
                                                    <?php echo $stream->stream_name ?>
                                                </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="exam_type" name="exam_type">
                                        <?php if ($exam_type != "") { ?>
                                            <option value="<?php echo $exam_type; ?>" selected><b>Sorted:
                                                    <?php echo $exam_type; ?></b></option>
                                        <?php } ?>
                                        <option value="">By Exam Type</option>
                                        <option value="THEORY">THEORY</option>
                                        <option value="LAB">LAB</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="subject_name" name="subject_name">
                                        <?php if ($subject_name != "") { ?>
                                            <option value="<?php echo $subject_name; ?>" selected><b>Sorted:
                                                    <?php echo $subject_name; ?></b></option>
                                        <?php } ?>
                                        <option value="">By Subject</option>
                                        <?php if (!empty($subjectInfo)) {
                                            foreach ($subjectInfo as $subject) { ?>
                                                <option value="<?php echo $subject->sub_name; ?>"><?php echo $subject->sub_name; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </th>

                                <th class="text-center"><button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button>
                                </th>
                            </form>
                        </tr>

                        <tr class="table_row_background text-dark text-center">
                            <th>Exam Date</th>
                            <th>Exam Name</th>
                            <th>Term</th>
                            <th>Stream</th>
                            <th>Exam Type</th>
                            <th>Subject</th>
                            <th width="180">Actions</th>
                        </tr>
                        <?php if (!empty($examInfo)) {
                            foreach ($examInfo as $record) { ?>
                                <tr>
                                    <td class="text-center"><?php if ($record->exam_date == '1970-01-01' || $record->exam_date == '0000-00-00') {
                                                                echo "";
                                                            } else {
                                                                echo date('d-m-Y', strtotime($record->exam_date));
                                                            } ?></td>
                                    <td class="text-center"><?php echo $record->exam_name; ?></td>
                                    <td class="text-center"><?php echo $record->class; ?></td>
                                    <td class="text-center"><?php echo $record->stream; ?></td>
                                    <td class="text-center"><?php echo $record->exam_type; ?></td>
                                    <td><?php echo $record->name; ?></td>
                                    <td width="120" class="text-center">
                                        <a href="#" class="btn btn-xs btn-success px-2 py-1" title="Exam Info" data-placement="left" data-toggle="popover" data-trigger="focus" data-content="<b>Time : <?php echo $record->time; ?> <br>"><i class="fa fa-info"></i></a>
                                        <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) { ?>
                                            <!--  <a class="btn btn-xs btn-info"
                                    href="<?php echo base_url(); ?>editExam/<?php echo $record->row_id; ?>" title="Edit"><i
                                        class="fas fa-pencil-alt"></i></a> -->
                                            <a class="btn btn-xs btn-danger deleteExam px-2 py-1" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                            <?php if ($record->exam_status == 1) { ?>
                                                <a class="btn btn-xs btn-success activeExam" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Active"><i class="fa fa-check"></i></a>
                                            <?php } else { ?>
                                                <a class="btn btn-xs btn-danger inactiveExam" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Inactive"><i class="fa fa-times"></i></a>

                                        <?php }
                                        } ?>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr class="card_heading_title text-dark">
                                <td class="text-center" colspan="10">
                                    Exam Not Found!.
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- The Modal -->
<div class="modal" id="addNewDocModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Exam Details</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
                <form action="<?php echo base_url() ?>addExam" method="POST" role="form" enctype="multipart/form-data">
                    <div class="text-center" id="alertMsg"></div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="exam_date" id="exam_date1" class="form-control input-sm exam_date1" placeholder="Exam Date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="time" name="time" data-live-search="true" required>
                                    <option value="">Select Session</option>
                                    <option value="Morning session" selected>Morning session</option>
                                    <!-- <option value="Afternoon session">Afternoon session</option> -->
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="class" name="class" data-live-search="true" required>
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm selectpicker" id="stream" name="stream[]" data-live-search="true" multiple required>
                                    <option value="">Select Stream</option>
                                    <?php if (!empty($streamInfo)) {
                                        foreach ($streamInfo as $stream) { ?>
                                            <option value="<?php echo $stream->stream_name ?>">
                                                <?php echo $stream->stream_name ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" value="I-PREPARATORY EXAMINATION" name="exam_name" id="exam_name" class="form-control input-sm" placeholder="Exam Name" autocomplete="off" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="exam_type" name="exam_type" required>
                                    <option value="">Select Exam Type</option>
                                    <option value="THEORY" selected>THEORY</option>
                                    <!-- <option value="LAB">LAB</option> -->
                                </select>
                                </select>  
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm selectpicker" id="subject_name" name="subject_name" data-live-search="true" required>
                                    <option value="">Select Subject</option>
                                    <?php if (!empty($subjectInfo)) {
                                        foreach ($subjectInfo as $subject) { ?>
                                            <option value="<?php echo $subject->subject_code; ?>"><?php echo $subject->sub_name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/websiteCommon.js" charset="utf-8"></script>
<script type="text/javascript">
    // $('.start_time').datetimepicker({
    //     format: 'hh:mm A',
    //     icons: {
    //         up: "fa fa-chevron-up",
    //         down: "fa fa-chevron-down"
    //     },
    // });
    jQuery(document).ready(function() {
        
        jQuery('.datepicker, .dateSearch, #exam_date1').datepicker({
            autoclose: true,
            orientation: "bottom",
            format: "dd-mm-yyyy",
            startDate: "today"

        });
        

        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#byFilterMethod").attr("action", baseURL + "examListing/" + value);
            jQuery("#byFilterMethod").submit();
        });

        

        $('[data-toggle="popover"]').popover({
            "container": "body",
            "trigger": "focus",
            "html": true
        });
        $('[data-toggle="popover"]').mouseenter(function() {
            $(this).trigger('focus');
        });

        jQuery(document).on("click", ".inactiveExam", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "inactiveExam",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure to Inactive this Exam ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Record successfully Inactivated"); 
                window.location.reload();}
                    else if(data.status = false) { alert("Record Inactivation failed"); }
                    else { alert("Access denied..!"); }
                });
            }

        });

        jQuery(document).on("click", ".activeExam", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "activeExam",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure to Active this Exam ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Record successfully Activated"); 
                window.location.reload();}
                    else if(data.status = false) { alert("Record Activation failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });
    
        jQuery(document).on("click", ".deleteExam", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteExam",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure delete this Exam ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Exam Details successfully Deleted"); 
                window.location.reload();}
                    else if(data.status = false) { alert("Failed to delete Exam Details"); }
                    else { alert("Access denied..!"); }
                });
            }
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