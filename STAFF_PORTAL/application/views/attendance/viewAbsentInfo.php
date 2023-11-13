<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.1);
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
                            <div class="col-8 col-md-5 col-lg-6 col-sm-5 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">description</i> Attendance Management
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-4">
                                <div class="count_heading">Total: <?php echo $count_attendance; ?></div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){ ?>
                                <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_right_radius"
                                        data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#downloadAttReport">
                                            <i class="fa fa-download"></i> Absent Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#downloadClassReport"
                                            href="#">
                                            <i class="fa fa-download"></i> Class Completed Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#downloadClassReportNew" href="#">
                                            <i class="fa fa-download"></i> Subject Wise Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col-12 column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Date</th>
                                    <th>Student ID</th>
                                    <th>Staff Name</th>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Time</th>
                                    <th>Term</th>
                                    <th>Stream</th>
                                    <th>Action</th>
                                </tr>
                                <tr class="row_filter">
                                    <form action="<?php echo base_url() ?>viewAttendanceInfo" method="POST"
                                        id="byFilterMethod">
                                        <th></th>
                                        <th style="padding: 1px;">
                                            <input type="text" name="absentDate" id="absentDate"
                                                value="<?php echo $absentDate; ?>"
                                                class="form-control input-sm pull-right datepicker"
                                                style="text-transform: uppercase" placeholder="By Date"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;">
                                            <input type="text" name="student_id" id="student_id"
                                                value="<?php echo $student_id; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Student ID"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="staff_name" name="staff_name"
                                                data-live-search="true">
                                                <?php if(!empty($staff_name)){ ?>
                                                <option value="<?php echo $staff_name; ?>" selected><b>Sorted:
                                                        <?php echo $staff_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Staff</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($staffInfo)){
                                                    foreach($staffInfo as $staff){ ?>
                                                <option value="<?php echo $staff->staff_name; ?>">
                                                    <?php echo $staff->staff_name; ?></option>
                                                <?php } } ?>

                                            </select>
                                        </th>
                                        <th width="90" style="padding: 1px;">
                                            <select class="form-control input-sm" id="subject_id" name="subject_id">
                                                <?php if(!empty($subject_id)){ ?>
                                                <option value="<?php echo $subject_id; ?>" selected><b>Sorted:
                                                        <?php echo $subject_id; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Subject</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($subjectInfo)){
                                                    foreach($subjectInfo as $sub){ ?>
                                                <option value="<?php echo $sub->subject_code; ?>">
                                                    <?php echo $sub->sub_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>

                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="subject_type" name="subject_type">
                                                <?php if(!empty($subject_type)){ ?>
                                                <option value="<?php echo $subject_type; ?>" selected><b>Sorted:
                                                        <?php echo $subject_type; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Type</option>
                                                <option value="">ALL</option>
                                                <option value="THEORY">THEORY</option>
                                                <option value="LAB">LAB</option>

                                            </select>
                                        </th>

                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="time" name="time">
                                                <?php if(!empty($time)){ ?>
                                                <option value="<?php echo $time; ?>" selected><b>Sorted:
                                                        <?php echo $time; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Time</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($timingsInfo)){
                                                    foreach($timingsInfo as $time){ ?>
                                                <option value="<?php echo $time->row_id; ?>">
                                                    <?php echo $time->start_time.'-',$time->end_time; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="by_term" name="by_term">
                                                <?php if($by_term != ""){ ?>
                                                <option value="<?php echo $by_term; ?>" selected><b>Sorted:
                                                        <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="stream_name" name="stream_name">
                                                <?php if(!empty($stream_name)){ ?>
                                                <option value="<?php echo $stream_name; ?>" selected><b>Sorted:
                                                        <?php echo $stream_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>">
                                                    <?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th style="padding: 1px;" class="text-center">
                                            <button type="submit" class="btn btn-success btn-md btn-block"><i
                                                    class="fa fa-filter"></i> Filter</button>
                                        </th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($attendanceRecords)) {
                                    foreach($attendanceRecords as $record) { ?>
                                <tr>
                                    <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $record->student_id; ?>" /></th>
                                    <th width="100"><?php echo date('d-m-Y',strtotime($record->absent_date)) ?></th>
                                    <th width="100"><?php echo $record->student_id ?></th>
                                    <th><?php echo $record->staff_name; ?></th>
                                    <th class="text-center"><?php echo $record->sub_name; ?></th>
                                    <th width="100" class="text-center"><?php echo $record->subject_type; ?></th>
                                    <th width="120" class="text-center">
                                        <?php echo $record->start_time.'-'.$record->end_time; ?></th>
                                    <th width="140" class="text-center"><?php echo $record->term_name; ?></th>
                                    <th class="text-center"><?php echo $record->stream_name; ?></th>
                                    <th class="text-center">
                                        <span class="text-danger">Absent</span>
                                        <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){ ?>
                                        <a class="btn btn-xs btn-danger deleteStudentAttendance" href="#"
                                            data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                        <?php } ?>
                                    </th>
                                </tr>
                                <?php } }else{ ?>
                                <tr>
                                    <th class="text-center" colspan="10">Attendance record not found</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Date</th>
                                    <th>Student ID</th>
                                    <th>Staff Name</th>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Time</th>
                                    <th>Term</th>
                                    <th>Stream</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="downloadAttReport">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Attendance Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Term</label>
                            <select class="form-control input-sm" id="term_name" name="term_name">
                                <!-- <option value="" >Select Term</option> -->
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="role">Stream</label>
                        <select class="form-control input-sm" id="streamName" name="streamName">
                            <!-- <option value="">By Stream</option> -->
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $stream){ ?>
                            <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="role">Section</label>
                        <select class="form-control input-sm" id="section_name" name="section_name" autocomplete="off">
                            <option value="">Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <!-- <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="ALL">ALL (No Section)</option> -->
                        </select>
                    </div>
                    <!-- </div>
                <div class="row"> -->
                    <div class="col-6 mb-2">
                        <label for="role">Date From(Optional)</label>
                        <input type="text" name="date_from" id="date_from" class="form-control from_date"
                            style="text-transform: uppercase" placeholder="Date From" />
                    </div>
                    <div class="col-6 mb-2">
                        <label for="role">Date To(Optional)</label>
                        <input type="text" name="date_to" id="date_to" class="form-control to_date"
                            style="text-transform: uppercase" placeholder="Date To" />
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id="loader"></div>
                <button id="downloadAttendanceReport" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="downloadClassReport">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Class Completed Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Term</label>
                            <select class="form-control input-sm" id="term" name="term_name">
                                <!-- <option value="" >Select Term</option> -->
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="role">Stream</label>
                        <select class="form-control input-sm" id="stream" name="streamName">
                            <!-- <option value="">By Stream</option> -->
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $stream){ ?>
                            <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="role">Section</label>
                        <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                            <!-- <option value="">Select Section</option> -->
                            <option value="ALL">ALL</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <!-- <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option> -->
                        </select>
                    </div>
                    <!-- </div>
                <div class="row"> -->
                    <div class="col-6 mb-2">
                        <label for="role">Date From</label>
                        <input type="text" required name="date_from" id="dateFrom" class="form-control from_date"
                            style="text-transform: uppercase" placeholder="Date From" />
                    </div>
                    <div class="col-6 mb-2">
                        <label for="role">Date To</label>
                        <input type="text" required name="date_to" id="dateTo" class="form-control to_date"
                            style="text-transform: uppercase" placeholder="Date To" />
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id="loader_class"></div>
                <button id="downloadClassReportBtn" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadClassReportNew">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Attendance Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Term</label>
                            <select class="form-control input-sm" id="term_nameNew" name="term_name">
                                <!-- <option value="" >Select Term</option> -->
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="role">Stream</label>
                        <select class="form-control input-sm" id="streamNameNew" name="streamName">
                            <!-- <option value="">By Stream</option> -->
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $stream){ ?>
                            <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="role">Subject</label>
                    <select class="form-control input-sm" id="subject_idNew" name="subject_id">
                    <option value="">Select Subject</option>
                        <?php if(!empty($subjectInfo)){
                                                    foreach($subjectInfo as $sub){ ?>
                        <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->sub_name; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                    <div class="col-6 mb-2">
                        <label for="role">Section</label>
                        <select class="form-control input-sm" id="section_nameNew" name="section_name"
                            autocomplete="off">
                            <option value="">Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <!-- <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="ALL">ALL (No Section)</option> -->
                        </select>
                    </div>
                    <!-- </div>
                <div class="row"> -->
                    <div class="col-6 mb-2">
                        <label for="role">Date From</label>
                        <input type="text" name="date_from" id="date_fromNew" class="form-control from_date"
                            style="text-transform: uppercase" placeholder="Date From" />
                    </div>
                    <div class="col-6 mb-2">
                        <label for="role">Date To</label>
                        <input type="text" name="date_to" id="date_toNew" class="form-control to_date"
                            style="text-transform: uppercase" placeholder="Date To" />
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div id="loader"></div>
                <button id="downloadAttendanceReportNew" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/attendance.js" type="text/javascript"></script>
<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
jQuery(document).ready(function() {
    // $('select').selectpicker();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewAttendanceInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate: 0,
        startDate: "01-03-2020",

    });

    jQuery('.from_date,.to_date').datepicker({
        autoclose: true,
        dateFormat: "dd-mm-yy",
        maxDate: 0,
        startDate: "01-03-2020",
        maxDate: 2,
    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });


    $('#downloadAttendanceReport').click(function() {
        var term_name = $('#term_name').val();
        var section_name = $('#section_name').val();
        var stream_name = $('#streamName').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var percentage_sort = $('#percentage_sort').val();
        if (section_name == '') {
            var section = 'ALL';
        } else {
            var section = section_name;
        }
        if (term_name == "") {
            alert("Term is Empty!!");
            // }else if(stream_name == ""){
            //     alert("Stream is Empty!!");
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>/downloadAbsentedStudentInfo',
                type: 'POST',
                dataType: 'json',
                data: {
                    date_from: date_from,
                    date_to: date_to,
                    term_name: term_name,
                    section_name: section_name,
                    stream_name: stream_name
                },
                success: function(data) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    // $("#downloadAttReport").hide();
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", term_name + "_" + stream_name + "_" + section +
                        "_ATTENDANCE_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail: (function(status) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    $('#loader').html(loader);
                    $("#downloadAttendanceReport").prop('disabled', true);
                }
            });
        }
    });



    $('#downloadAttendanceReportNew').click(function() {
        var term_name = $('#term_nameNew').val();
        var section_name = $('#section_nameNew').val();
        var stream_name = $('#streamNameNew').val();
        var date_from = $('#date_fromNew').val();
        var date_to = $('#date_toNew').val();
        var subject_code = $('#subject_idNew').val();

        if (section_name == '') {
            var section = 'ALL';
        } else {
            var section = section_name;
        }
        if (term_name == "") {
            alert("Term is Empty!!");
            }else if(date_from == ""){
                alert("Select Date From!!");
            }else if(date_to == ""){
                alert("Select Date To!!");
            }else if(subject_code == ""){
                alert("Select Subject!!");
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>/downloadClassCompletedReportNew',
                type: 'POST',
                dataType: 'json',
                data: {
                    date_from: date_from,
                    date_to: date_to,
                    term_name: term_name,
                    section_name: section_name,
                    stream_name: stream_name,
                    subject_code: subject_code

                },
                success: function(data) {
                    $('#loader').html('');
                    $("#downloadAttendanceReportNew").prop('disabled', false);
                    // $("#downloadAttReport").hide();
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", term_name + "_" + stream_name + "_" + section +
                        "_ATTENDANCE_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) {
                    $('#loader').html('');
                    $("#downloadAttendanceReportNew").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail: (function(status) {
                    $('#loader').html('');
                    $("#downloadAttendanceReportNew").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    $('#loader').html(loader);
                    $("#downloadAttendanceReportNew").prop('disabled', true);
                }
            });
        }
    });



    $('#downloadClassReportBtn').click(function() {
        var term_name = $('#term').val();
        var section_name = $('#section').val();
        var stream_name = $('#stream').val();
        var date_from = $('#dateFrom').val();
        var date_to = $('#dateTo').val();
        var percentage_sort = $('#percentageSort').val();
        if (section_name == '') {
            var section = 'ALL';
        } else {
            var section = section_name;
        }
        if (term_name == "") {
            alert("Term is Empty!!");
        } else if (stream_name == "") {
            alert("Stream is Empty!!");
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>/downloadClassCompletedReport',
                type: 'POST',
                dataType: 'json',
                data: {
                    date_from: date_from,
                    date_to: date_to,
                    term_name: term_name,
                    section_name: section_name,
                    stream_name: stream_name
                },
                success: function(data) {
                    $('#loader_class').html('');
                    $("#downloadClassReportBtn").prop('disabled', false);
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", term_name + "_" + stream_name + "_" + section +
                        "_ATTENDANCE_CLASS_COMPLETED_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) {
                    $('#loader_class').html('');
                    $("#downloadClassReportBtn").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail: (function(status) {
                    $('#loader_class').html('');
                    $("#downloadClassReportBtn").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    $('#loader_class').html(loader);
                    $("#downloadClassReportBtn").prop('disabled', true);
                }
            });
        }
    });


});
</script>