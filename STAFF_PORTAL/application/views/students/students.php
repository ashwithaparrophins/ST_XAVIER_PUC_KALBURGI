<?php require APPPATH . 'views/includes/db.php'; ?>
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
                            <div class="col-lg-4 col-12 col-md-4 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-users"></i> Student Management
                                </span>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right">
                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_TEACHING_STAFF){ ?>
                                    <button type="button" class="btn btn-primary dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <?php }  ?>
                                    <div class="dropdown-menu p-0">
                                        
                                        <!-- <a class="dropdown-item disabled" href="#"><i class="fa fa-mobile"></i> Send SMS</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <!-- <a class="dropdown-item" href="#" id="study_certificate"><i class="fa fa-file"></i> Study Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="mark_card_print"><i class="fa fa-file"></i> Mark Card</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="excellencia_cetificate"><i class="fa fa-file"></i>Excellencia Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="first_year_hall_ticket"><i class="fa fa-file"></i> Hall ticket</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="second_year_hall_ticket"><i class="fa fa-file"></i> Lab Hall ticket</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="biodata_student"><i class="fa fa-file"></i> Bio-Data</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <!-- <a class="dropdown-item" href="#" id="study_certificate"><i class="fa fa-file"></i> Study Certificate</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <?php if($role != ROLE_TEACHING_STAFF){ ?>
                                        <a class="dropdown-item" href="#" id="conduct_certificate"><i class="fa fa-file"></i> Conduct Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="first_year_hall_ticket"><i class="fa fa-file"></i> Hall ticket</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="annual_mark_card"><i class="fa fa-file"></i> Annual Mark Card</a>
                                        <!-- <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="mark_card_print"><i class="fa fa-file"></i> Mark Card</a> -->
                                        <!-- <a class="dropdown-item" href="#" id="first_year_hall_ticket"><i class="fa fa-file"></i> Hall ticket</a> -->
                                        
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#downloadReport" class="btn btn-md btn-primary">
                                        <i class="fa fa-download"></i> Export</a>
                                        <?php }  ?>
                                        <!-- <a id="studentBatchModel" class="dropdown-item " href="#"><i class="fa fa-user"></i> Add Batch</a> -->
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="unit_test_mark_card"><i class="fa fa-file"></i> Unit Test Mark Card</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <!-- <a class="dropdown-item" href="#" id="assign_feedback"><i class="fa fa-file"></i> Assign Student For Feedback</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <!-- <a class="dropdown-item" href="#" id="promoteStudent"><i class="fa fa-file"></i>Promote Student</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <a class="dropdown-item" id="sendNotification" href="#"> <i class="material-icons text-dark">send</i> Send Notification</a>
                                        <a class="dropdown-item" href="#" id="barcode"><i class="fa fa-file"></i> Generate Barcode</a>
                                    </div>
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
                        <table class="display table table-bordered table-striped table-hover w-100">
                            <form action="<?php echo base_url(); ?>studentDetails" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $application_no; ?>" name="application_no" id="application_no" class="form-control input-sm" placeholder="By Application Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name" class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_term" id="by_term">
                                                <?php if(!empty($by_term)){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Selected: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_stream" id="by_stream">
                                                <?php if(!empty($by_stream)){ ?>
                                                    <option value="<?php echo $by_stream; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_Section" id="by_Section">
                                                <?php if(!empty($by_Section)){ ?>
                                                    <option value="<?php echo $by_Section; ?>" selected><b>Selected: <?php echo $by_Section; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Section</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value=" ">ALL(No Section)</option>
                                                <!-- <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option> -->
                                            </select>
                                        </div>
                                   </td>
                                   <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_elective" id="by_elective">
                                                <?php if(!empty($by_elective)){ ?>
                                                    <option value="<?php echo $by_elective; ?>" selected><b>Selected: <?php echo $by_elective; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Elective</option>
                                                <option value="KANNADA">KANNADA</option>
                                                <option value="HINDI">HINDI</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th width="140">Student ID</th>
                                    <th width="140">Appln. No.</th>
                                    <th width="160">Student Name</th>
                                    <th width="50">Term</th>
                                    <th width="110">Stream</th>
                                    <th width="90">Section</th>
                                    <th width="90">Elective</th>
                                    <!-- <th>Fee Status</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentInfo)){
                                    foreach($studentInfo as $std){ 
                                        if($std->term_name == 'I PUC'){
                                            $stdFee = getFirstYearFeeInfo($con,$std->student_id);
                                            if(empty($stdFee)){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else if($stdFee['balance'] == 0){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else{
                                                $fee_status = '<span class="text-danger">'.$stdFee['balance'].'</span>';
                                            }
                                        }else{
                                            $std_status = getSecondYearFeeInfo($con,$std->student_id);
                                            if(empty($std_status)){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else if($std_status['balance'] == 0){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else{
                                                $fee_status = '<span class="text-danger">'.$std_status['balance'].'</span>';
                                            }
                                        }
                                        if ($std->intake_year == '2024-2025' && $std->new_admitted == 0) {                                         
                                            continue; // Skip to the next iteration to avoid displaying this student in the main list
                                        }
                                    ?>
                                    <tr>
                                        <th><input type="checkbox" class="singleSelect" value="<?php echo $std->student_id; ?>" /></th>
                                        <th class="text-center"><?php echo $std->student_id; ?></th>
                                        <th class="text-center"><?php echo $std->application_no; ?></th>
                                        <th><?php echo strtoupper($std->student_name); ?></th>
                                        <th class="text-center"><?php echo $std->term_name; ?></th>
                                        <th class="text-center"><?php echo $std->stream_name; ?></th>
                                        <th class="text-center"><?php echo $std->section_name; ?></th>
                                        <th class="text-center"><?php echo $std->elective_sub; ?></th>
                                        <!-- <th class="text-center"><?php echo $fee_status; ?></th> -->
                                        <th class="text-center" width="140">
                                            <a class="btn btn-xs btn-primary mb-1" target="_blank"
                                            href="<?php echo base_url(); ?>viewStudentInfoById/<?php echo $std->row_id; ?>"
                                            title="View More"><i class="fa fa-eye"></i></a>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){ ?>
                                                <a class="btn btn-xs btn-info mb-1" target="_blank"
                                                href="<?php echo base_url(); ?>editStudent/<?php echo $std->row_id; ?>" title="Edit Student"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                             <?php } ?>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                <a class="btn btn-xs btn-danger deleteStudent mb-1"
                                                data-row_id="<?php echo $std->application_no; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                            <?php } ?>
                                            <?php if($role != ROLE_TEACHING_STAFF) { ?>
                                                <a onclick="openModel('<?php echo $std->student_id; ?>')" class="btn btn-xs btn-warning" style="color: white;" 
                                                title="Give Transfer Certificate"><i class="fa fa-file"></i> Give TC</a>
                                            <?php } ?>
                                                                
                                           
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Student Record Not Found</th>
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


<!-- The Modal -->
<div class="modal fade" id="downloadReport">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header table-primary">
        <h4 class="modal-title">Download Student Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-2">
        <form action="<?php echo base_url() ?>downloadStudentExcelReport" method="POST">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Term</label>
                        <select class="form-control input-sm selectpicker" id="term" name="term" required>
                            <option value="">Select Term</option>
                            <option value="I PUC">I PUC</option>
                            <option value="II PUC">II PUC</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Preference</label>
                        <select class="form-control input-sm selectpicker" id="preference" name="preference" required>
                            <option value="">Select One Preference</option>
                            <option value="ALL">ALL</option>
                            <?php foreach($streamInfo as $stream){ ?>
                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                            <?php } ?>
                         
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Section
                        <select class="form-control input-sm selectpicker" id="section_name" name="section_name" required>
                            <option value="">Select Section</option>
                            <option value="ALL">ALL</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Academic Year
                        <select class="form-control input-sm selectpicker" id="academic_year" name="academic_year" required>
                            <option value="">Select Academic Year</option>
                            <option value="ALL">ALL</option>
                            <option value="2021-2022">2021-2022</option>
                            <option value="2020-2021">2020-2021</option>
                            <option value="2019-2020">2019-2020</option>
                        </select>
                    </div>
                </div> -->

                
            </div>
            <h5>Select Required Fields</h5>
            <div class="row">
                <div class="col-lg-4">
                <input type="hidden" name="fields[]" class="studentId" value="student_id"
                        checked/><span style="font-size: 18px;"> </span>

                    <input type="checkbox" class="studentId disabled" value=""
                        checked disabled/><span style="font-size: 18px;"> &nbsp;&nbsp;STUDENT ID </span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="student_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Student Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="dob" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Date Of Birth</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="student_no" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Student No. </span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="hall_ticket_no" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Hall Ticket No.</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="email"
                        value="email" /><span style="font-size: 18px;"> &nbsp;&nbsp;Email</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="nationality"
                        value="caste" /><span style="font-size: 18px;"> &nbsp;&nbsp; Nationality</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="religion" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Religion</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="category" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Category</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"
                        value="caste" /><span style="font-size: 18px;"> &nbsp;&nbsp;Caste</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="sub_caste" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Sub Caste</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="mother_tongue" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Tongue</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="present_address" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Present Address </span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"
                        value="residential_address" /><span style="font-size: 18px;"> &nbsp;&nbsp;Permanent Address</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="email" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Student Mobile</span>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="father_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Father Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="mother_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="elective_sub " value="elective_sub" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Elective Subject</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="father_mobile" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Father Mobile</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="mother_mobile" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Mobile</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="father_email" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Father Email</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="mother_email" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Email</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="guardian_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Guardian Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="guardian_address" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Guardian Address</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="Is_physically_challenged" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Physically Challenged</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="is_dyslexic" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Dyslexia</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" value="blood_group" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="application_no" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Application Number</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="doj"
                        value="doj" /><span style="font-size: 18px;"> &nbsp;&nbsp;Date Of Admission</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="pu_board_number" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Register Number</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"
                        value="last_register_number" /><span style="font-size: 18px;"> &nbsp;&nbsp;10th Register No.</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="last_board_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;10th Board Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " value="last_percentage" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;10th Percentage</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"
                        value="aadhar_no" /><span style="font-size: 18px;"> &nbsp;&nbsp; Aadhar No.</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"
                        value="sat_number" /><span style="font-size: 18px;"> &nbsp;&nbsp; SAT Number</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"
                        value="native_place" /><span style="font-size: 18px;"> &nbsp;&nbsp; Native Place</span>
                </div>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                class="fa fa-download"></i> Download</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
        </form>
    </div>
  </div>
</div>



<div class="modal fade" id="tcModel" tabindex="-1" role="dialog" aria-labelledby="tcModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                    <h4 class="modal-title" id="stdName"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        <div class="modal-body p-1">
            <table class="table  table-bordered mb-2">
                <tr>
                    <th class="table-primary">Name </th>
                    <th id="studentName" class="table-info"></th>
                    <th class="table-primary">DOB</th>
                    <th id="dob" class="table-info"></th>
                    <th class="table-primary">Section</th>
                    <th id="section" class="table-info"></th>
                </tr>
                <tr >
                    <th class="table-primary">Nationality</th>
                    <th class="table-info" id="nationality"></th>
                    <th class="table-primary">Religion </th>
                    <th class="table-info" id="religion"></th>
                    <th class="table-primary">Caste</th>
                    <th class="table-info">
                        <input type="text" placeholder="Caste" class="form-control " name="caste" id="caste">
                    </th>
                    
                </tr>
                <tr>
                    <th class="table-primary">Father Name </th>
                    <th class="table-info" id="father_name"></th>
                    <th class="table-primary">Mother Name</th>
                    <th class="table-info" id="mother_name"></th>
                    <th class="table-primary">Admission Date</th>
                    <th class="table-info" id="admission_date"></th>
                </tr>
                <tr>
                    <th class="table-primary">Medium </th>
                    <th class="table-info" id="instruction_medium"></th>
                    <th class="table-primary">Optionals</th>
                    <th class="table-info" id="optionals"></th>
                    <th class="table-primary">Languages</th>
                    <th class="table-info" id="languages"></th>
                </tr>
            
            </table>
            <form  id="addTcList">
                <input type="hidden" id="student_id" name="student_id"  />
                <div class="row">
                
                    <div class="col-lg-6 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="leaving_date" class="col-form-label">Date of Leaving:</label>
                            <input type="text" placeholder="Select Student Leaving Date" class="form-control datepicker" name="leaving_date" id="leaving_date">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="date_of_admission" class="col-form-label">Date of Admission:</label>
                            <input type="text" placeholder="Select Student admission Date" class="form-control datepicker" name="date_of_admission" id="date_of_admission">
                        </div>
                    </div>
                </div>




                <div class="row">
                <!-- <div class="col-lg-6 col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="admission_number" class="col-form-label">Admission Number:</label>
                        <input type="text" placeholder="Select Student admission number" class="form-control" name="admission_number" id="admission_number"></div>
                    </div> -->
                    <div class="col-lg-12 col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="qualified_status" class="col-form-label">Whether Qualified for promotion to a higher class?</label>
                        <select class="form-control required" id="qualified_status" name="qualified_status">
                        <option value="YES" >YES</option>
                        <option value="NO">NO </option>
                    </select></div>
                    </div>


                    
                </div>


                
            




                
                
               
                <div class="form-group">
                    <label for="role">Whether the candidate belongs to Scheduled Caste or Tribe?</label>
                    <select class="form-control required" id="belong_sc_st" name="belong_sc_st">
                        <option value="NO">NO </option>
                        <option value="YES" >YES</option>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="last_class">Class in which the student was studying at the time of leaving?</label>
                    <input type="text" placeholder="Select Class" class="form-control" name="last_class" id="last_class">
                </div>
                            <div class="form-group">
                                <label for="fee_due" class="col-form-label pb-0">Fee Due<span>*</span></label>
                                <select class="form-control required pendingFee" id="fee_due" name="fee_due" required>
                                    <option value="" disabled>Select Fee Due</option>
                                    <option  value="YES">YES</option>
                                    <option value="NO">NO </option>
                                </select>
                            </div>
                        
                <div class="form-group">
                    <label for="role">Character and Conduct?</label>
                    <select class="form-control required" id="character" name="character">
                        <option value="GOOD" >GOOD</option>
                        <option value="VERY GOOD">VERY GOOD </option>
                        <option value="SATISFIED">SATISFIED </option>
                    </select>
                </div>

                <div class="alertMessage">
                </div>
                
            </div>
            <div class="modal-footer">
            
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="saveTcInfo" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>


<div class="modal fade-scale" id="printMarkCardOption">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue p-2">
                <h4 class="modal-title">Students Mark Card Confirm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>
                    <input type="hidden" value="I PUC" id="term" />
                    <label style="font-size: 18px;">Total Students Selected for Print Mark Card: <label
                            id="countStudentsForMarkCard"></label></label>
                    <hr class="m-1">
                    <div class="errorMessage">

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Select Examination Year</label>
                            <select class=" form-control input-md" id="exam_year" name="exam_year">
                                <option value="">Select Examination Year</option>
                                 <!-- <option value="FEBRUARY - 2022_D"><strong>Annual Exam(Detained)</strong></option> -->
                                 <option value="annual_exam"><strong>Annual Exam</strong></option>
                                 <!-- <option value="supplementary_exam"><strong>Supplementary Exam</strong></option>
                                <option value="FEBRUARY - 2021"><strong>FEBRUARY - 2021</strong></option>
                                <option value="MARCH - 2021"><strong>MARCH - 2021</strong></option>
                                <option value="JULY - 2021"><strong>JULY - 2021</strong></option>
                                <option value="APRIL - 2021"><strong>APRIL - 2021</strong></option>
                                <option value="FEBRUARY - 2020"><strong>FEBRUARY - 2020</strong></option>
                                <option value="MARCH - 2020"><strong>MARCH - 2020</strong></option>
                                <option value="JULY - 2020"><strong>JULY - 2020</strong></option>
                                <option value="APRIL - 2020"><strong>APRIL - 2020</strong></option>
                                <option value="FEBRUARY - 2019"><strong>FEBRUARY - 2019</strong></option>
                                <option value="MARCH - 2019"><strong>MARCH - 2019</strong></option>
                                <option value="APRIL - 2019"><strong>APRIL - 2019</strong></option>
                                <option value="JULY - 2019"><strong>JULY - 2019</strong></option>
                                <option value="FEBRUARY - 2018"><strong>FEBRUARY - 2018</strong></option> -->
                            </select>
                        </div>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span> Close</button>
                <button id="printMarkSheet" type="button" class="btn btn-md btn-primary"><i
                        class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="studentBatchModelView">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Add Student Batch</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>
                    <label style="font-size: 18px;">Total Students Selected: <label id="countStudents"></label></label>
                    <!-- <hr> -->
                    <lable>Select Batch</lable>
                    <select class="form-control input-sm" id="batch_selected" name="student_batch" autocomplete="off">
                        <!-- <?php if(!empty($aided_status)){ ?>
                            <option value="<?php echo $aided_status; ?>"><?php echo $aided_status; ?></option>
                        <?php } ?> -->
                        <option value="">Select Batch</option>
                        <option value="I">Batch I</option>
                        <option value="II">Batch II</option>
                        
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close</button>
                        <button id="updateStudentBatchInfo" type="button" class="btn btn-md btn-primary"> Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade-scale" id="printReportCardByName">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue p-2">
                <h4 class="modal-title">Students Mark Card</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsgFeedback"></div>
                    <input type="hidden" value="I PUC" id="term" />
                    <label style="font-size: 18px;">Total Students Selected for Print Mark Card: <label
                            id="countStudentsForMarksCard"></label></label>
                    <hr class="m-1">
                    <div class="errorMessage">

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Select Examination Name</label>
                            <select class=" form-control input-md" id="exam_type" name="exam_type">
                                <option value="">Select Examination Name</option>
                                <option value="I_UNIT_TEST" selected><strong>I UNIT TEST</strong></option>
                                <option value="MID_TERM_EXAM"><strong>MID TERM</strong></option>
                                <option value="II_UNIT_TEST"><strong>II UNIT TEST</strong></option>
                                 <!--<option value="I_PREPARATORY"><strong>PREPARATORY</strong></option> -->
                            </select>
                        </div>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span> Close</button>
                <button id="printUnitTestMarkCard" type="button" class="btn btn-md btn-primary"><i
                        class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade-scale" id="assignStudentForFeedback">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue p-2">
                <h4 class="modal-title">Staff Feedback</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>
                    <label style="font-size: 18px;">Total Students Selected : <label
                            id="countStdFeedback"></label></label>
                    <hr class="m-1">
                    <div class="errorMessageFeedback">

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Select Type</label>
                            <select class="form-control text-dark" id="feedback_type" name="feedback_type">
                                <option value="TEACHING">TEACHING</option>
                                <option value="COUNSELLOR">COUNSELLOR</option>
                            </select>
                        </div>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span> Close</button>
                <button id="assignStudentDataForFeedback" type="button" class="btn btn-md btn-primary"><i
                        class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Promotion  -->
<div class="modal fade-scale" id="promoteStudents">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Promote Students</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2"> 
                <form  action="<?php echo base_url() ?>promoteStudent" role="form" method="post" id="promoteStudent"  enctype="multipart/form-data">
                    <input type="hidden" name="student_id" id="students">
                    <div class="text-center" id="alertMsg"></div>        
                    <label style="font-size: 18px;" >Total Students Selected: <label id="studentPromoteCount"></label></label>
                    <!-- <hr> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                        <button type="submit" class="btn btn-success">Promote</button>
                    </div>
                
            </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- The Modal send sms  -->
<div class="modal fade-scale" id="sendNotificationView">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Send Notifiation to Students</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2"> 
                <form  action="<?php echo base_url() ?>sendStudentNotification" role="form" method="post" id="sendNotification"  enctype="multipart/form-data">
                    <input type="hidden" name="student_id" id="students1">
                    <div class="text-center" id="alertMsg"></div>
                       <div class="form-group">
                            <label for="exampleInputEmail1">Date</label>
                           <input type="text" class="form-control required datepicker" id="date"  name="date"   placeholder="Date" autocomplete="off" required/>
                        </div>
                    
                    <hr class="mt-1 mb-2">
                    <div class="form-group">
                        <textarea type="text" class="w-100" name="message" id="messageValue" rows="6" placeholder="Type Message Here..." required></textarea>
                    </div>
                    <div class="col-12">
                       <div class="form-group" id="msg_file">
                          <img src="<?php echo base_url(); ?>assets/dist/img/pdf.png" class="avatar"
                                    width="30" height="40" src="#" id="uploadedImage" name="msg_file" width="80"
                                    height="80" alt="avatar">
                                <label for="fname">File </label>
                                <input type="file" class="form-control" id="msg_file" name="msg_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                        </div>
                    </div>

                    <div class="modal-footer pb-0 px-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
 var students = [];
 var loader = '<img height="70" src="<?php echo base_url(); ?>assets/images/loader.gif"/>';
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "studentDetails/" + value);
        jQuery("#byFilterMethod").submit();
    });
   
    
    $(".custom_loader").hide();
    $("#custom_loader_text").css('display','none');

    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "top",
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

    $(".pendingFee").change(function(){
        if(this.value == "NO"){
            $("#saveTcInfo").show();
        }else{
            alert('Sorry! Fee is due. So, you cannot apply for TC!')
            $("#saveTcInfo").hide();
        }
    });

    $('#excellencia_cetificate').click(function(){
      var students = [];
      if ($('.singleSelect:checkbox:checked').length == 0) {
        alert("Select atleast one Student for Print Excellence Certificate!"); 
        return;
     }
     $('.singleSelect:checked').each(function(i){
          students.push($(this).val());
        });
        var students = JSON.stringify(students);
        
        window.open('<?php echo base_url(); ?>generateExcellenciaCertificate?student_id='+btoa(students));
    });
    
    $('#study_certificate').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Study Certificate!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>generateStudyCertificate?student_id='+btoa(students));
    });
    
    //conduct certificate
    $('#conduct_certificate').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Conduct Certificate!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>generateConductCertificate?student_id='+btoa(students));
    }); 
    
    // student batch 
    $('#studentBatchModel').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student!");
            return;
        } else {
            $('#studentBatchModelView').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudents').html($('.singleSelect:checkbox:checked').length);
    });

    $('#sendNotification').click(function() {
            var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to send notification!");
            return;
        } else {
            
            // alert(students.length);
            $('#sendNotificationView').modal('show');
              $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
          
            //  students = JSON.stringify(students);

        });
            $('#students1').val(JSON.stringify(students));
        }
        $('.singleSelect:checked').each(function(i) {
            // students.push($(this).val());
           
             students = JSON.stringify(students);

        });
        $('#countStudents').html($('.singleSelect:checkbox:checked').length);
    });
    
    $('#updateStudentBatchInfo').click(function() {
        var class_batch = $("#batch_selected").val();
        var students = [];
        
        //$('#alertMsg').html('<span>' + loader + '</span>');
        //$('#shortListModelView').modal('show');
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $.ajax({
            url: baseURL + '/updateStudentBatch',
            type: 'POST',
            data: {
                student_id : JSON.stringify(students),
                class_batch : class_batch,
            },
            success: function(data) {
                if (data > 0) {
                   
                    $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  Selected Students Batch updated successfully!
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
               // $('#alertMsg').html('<span>' + loader + '</span>');
            }
        });

    });

//print mark card for students
    $('#mark_card_print').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#printMarkCardOption').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudentsForMarkCard').html($('.singleSelect:checkbox:checked').length);
    });


    $('#barcode').click(function(){
         students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to generate barcode!");
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
         students = JSON.stringify(students);
         // alert(students);
        window.open('<?php echo base_url(); ?>generateBarcodeForStudent?row_id='+btoa(students));
    });


    $('#printMarkSheet').click(function(){
        var students = [];
        var exam_year = $('#exam_year').val();
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Mark Card!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        if (exam_year == "") {
            $(".errorMessage").html(`<div class="alert alert-danger" role="alert">
                  Please Select Examination Year!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>`);
            return;
        }else if(exam_year == 'FEBRUARY - 2022_D'){
          window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }else if(exam_year == 'annual_exam'){
          window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint2022?student_id='+btoa(students) + '&exam_year=' + exam_year);
         }else if(exam_year == 'supplementary_exam'){
          window.open('<?php echo base_url(); ?>getSupplementaryMarkPrint2022?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }else{
          window.open('<?php echo base_url(); ?>getMarkCardToPrint?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }
    });

    //hall ticket 
    $('#first_year_hall_ticket').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Hall Ticket!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>getFirstYearStudentHallTicket?student_id=' + btoa(students));
    });


    $('#annual_mark_card').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Annual Mark Card!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint2024?student_id=' + btoa(students));
    });



    $('#second_year_hall_ticket').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Hall Ticket!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getSecondYearStudentHallTicket?student_id=' + btoa(students));
    });

    $('#biodata_student').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Bio-Data!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getStudentBiodata?student_id=' + btoa(students));
    });

    // // unit test mark card
    // $('#unit_test_mark_card').click(function(){
    //     var students = [];
    //     if ($('.singleSelect:checkbox:checked').length == 0) {
    //         alert("Select atleast one Student for Print Mark Card!"); 
    //         return;
    //     }
    //     $('.singleSelect:checked').each(function(i){
    //         students.push($(this).val());
    //     });
    //     var students = JSON.stringify(students);
    // }); 
    
    $('#unit_test_mark_card').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#printReportCardByName').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudentsForMarksCard').html($('.singleSelect:checkbox:checked').length);
    });


    $('#printUnitTestMarkCard').click(function(){
        var students = [];
        var exam_type = $('#exam_type').val();
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Mark Card!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        if (exam_type == "") {
            $(".errorMessage").html(`<div class="alert alert-danger" role="alert">
                  Please Select Examination Name!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>`);
            return;
        }else if(exam_type == "MID_TERM_EXAM") {
          window.open('<?php echo base_url(); ?>generateMidTermExamReportCard?student_id='+btoa(students) + '&exam_type=' + exam_type);
         }else if(exam_type == "I_PREPARATORY") {
          window.open('<?php echo base_url(); ?>generatePreparatoryExamReportCard?student_id='+btoa(students) + '&exam_type=' + exam_type);
        }
        else{
          window.open('<?php echo base_url(); ?>generateUnitTestExamReportCard?student_id='+btoa(students) + '&exam_type=' + exam_type);
        }
    });

     $('#promoteStudent').click(function() {
        
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to Promote!");
            return;
        } else {
            
            // alert(students.length);
            $('#promoteStudents').modal('show');
              $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
          
             // students = JSON.stringify(students);

        });
            $('#students').val(JSON.stringify(students));
            // alert($('#students').val());
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
           
            //  students = JSON.stringify(students);

        });
        $('#studentPromoteCount').html($('.singleSelect:checkbox:checked').length);
    });


     $('#promoteStudent').click(function() {

         students = [];
         
        if (msg.length == 0) {
            $('#alertMsg').html(`<div class="alert alert-danger" role="alert">
                Sorry! Confirmation SMS Empty!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`);
        } else {
            $('#alertMsg').html('<span>' + loader + '</span>');
            //$('#shortListModelView').modal('show');
            $('.singleSelect:checked').each(function(i) {
                studentList.push($(this).val());

                 
            });
               
            $.ajax({
                url: baseURL + '/promoteStudent',
                type: 'POST',
                data: {

                    student_id: JSON.stringify(students),
                },
                success: function(data) {
                    $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                    Promoted Successfully!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                  </div>`);
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
        }
    });
    
    // assign student for feedback
    $('#assign_feedback').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#assignStudentForFeedback').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStdFeedback').html($('.singleSelect:checkbox:checked').length);
    });
    
    $('#assignStudentDataForFeedback').click(function() {
        var feedback_type = $('#feedback_type').val();
        var students = [];
        
        //$('#alertMsg').html('<span>' + loader + '</span>');
        //$('#shortListModelView').modal('show');
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $.ajax({
            url: baseURL + '/addMultipleStudentForFeedback',
            type: 'POST',
            data: {
                student_id : JSON.stringify(students),
                feedback_type : feedback_type,
            },
            success: function(data) {
                if (data > 0) {
                   
                    $('.errorMessageFeedback').html(`<div class="alert alert-success" role="alert">
                  Selected Students assigned successfully!
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
               // $('#alertMsg').html('<span>' + loader + '</span>');
            }
        });

    });
    
 
    

    $("#saveTcInfo").click(function(){
          
        var qualified_status = $('#qualified_status :selected').val();
        var reason_unqualified = $('#reason_unqualified_val :selected').val();
        var belong_sc_st = $('#belong_sc_st :selected').val();
        /// var college_due_status = $('#college_due_status :selected').val();
        var character = $('#character :selected').val();
        var leaving_date = $('#leaving_date').val();
        // var admission_number = $('#admission_number').val();
        var fee_due = $('#fee_due').val();
        var last_class = $('#last_class').val();
        var admission_date = $('#date_of_admission').val();
        var student_id = $('#student_id').val();
        var caste = $('#caste').val();
        if(leaving_date == ""){ 
            $(".alertMessage").html('<div class="alert alert-warning alert-dismissable">Sorry! Leaving date Empty!</div>');
            $(".alertMessage").show();
        } else if(fee_due == ""){ 
            $(".alertMessage").html('<div class="alert alert-warning alert-dismissable">Sorry! fee due is empty! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
            $(".alertMessage").show();
        } else if(fee_due == "YES"){ 
            $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Sorry! Fee is due. So, you cannot apply for TC! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
            $(".alertMessage").show();
        }else if(last_class==""){
            $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Sorry! Class is Empty!×</button></div>');
            $(".alertMessage").show();
        }
        else{
            $.ajax({
                url: '<?php echo base_url(); ?>/addNewTcInfo',
                type: 'POST',
                data: {
                    qualified_status: qualified_status,
                    reason_unqualified: reason_unqualified,
                    belong_sc_st: belong_sc_st,
                    character: character,
                    leaving_date: leaving_date,
                    // admission_number: admission_number,
                    student_id : student_id,
                    admission_date : admission_date,
                    caste : caste,
                    last_class : last_class,
                    fee_due : fee_due,
                },

                success: function(data) {
                    $(".alertMessage").html('<div class="alert alert-success alert-dismissable">'+data+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                    $(".alertMessage").show();
                },
                error: function(result){
                    $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Error! Something Went Wrong</div>');
                    $(".alertMessage").show();
                },
                
                fail:(function(status) {
                    $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Error! Something Went Wrong</div>');
                    $(".alertMessage").show();
                }),
                beforeSend:function(d){
                    // $('.modal-title').html('<center> Loading..</center>');
                }
            });
        }
    });

    $('#leaving_date, .datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format : "dd-mm-yyyy"
    });
});

function openModel(student_id){

    $(".alertMessage").hide();
    $('.modal-title').html('Transfer Certificate <span style="float:right;">Student ID: '+ student_id + '</span>');
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentTcInfo',
        type: 'POST',
        data: {
            student_id : student_id,
        },

        success: function(data) {
            var studentTcInfo = JSON.parse(data);
            
            if(studentTcInfo != null){
            // var leavingDate = studentTcInfo.leaving_date
           
            var leavingDate = "03-31-2024";
            var admissionDate = studentTcInfo.date_of_admission;
            
            $('#leaving_date').val(appendLeadingZeroes(new Date(leavingDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getFullYear()));
            // $('#leaving_date').val(studentTcInfo.leaving_date);
            $('#qualified_status').val(studentTcInfo.is_promoted);
            $('#belong_sc_st').val(studentTcInfo.is_belongs_sc_st);
            
            $('#last_class').val(studentInfo.term_name + ' ' + studentInfo.program_name);

            // $('#admission_number').val(studentInfo.admission_no);

            var admission = appendLeadingZeroes(new Date(admissionDate).getDate()) 
                    + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
                    + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear());

                    if(admissionDate != ''){
                        $('#date_of_admission').val(admission);
                    }
            if(studentTcInfo.reason_unqualified != ""){
                $('#reason_unqualified_val').val(studentTcInfo.reason_unqualified);
                $(".reason_unqualified").show();
            }else{
                $('#reason_unqualified_val').val(studentTcInfo.reason_unqualified);
                $(".reason_unqualified").hide();
            }
            $("#saveTcInfo").text("Update");
            }else{
            $("#saveTcInfo").text("Save");
            $(".reason_unqualified").hide();
            $('#addTcList')[0].reset();
            }
        },
        error: function(result)
            {
                $(".modal-title").html("Error");
            },
            fail:(function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
    });
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentById',
        type: 'POST',

        data: {
            student_id : student_id,
        },

        success: function(data) {
    // alert('admissionDate');
            
            var leavingDate = "03-31-2024";
            var studentInfo = JSON.parse(data);
            var admissionDate = studentInfo.date_of_admission;
            $('#student_id').val(student_id);
        //    alert(studentInfo.student_name);
            $('#stdName').html(studentInfo.student_name);
            $('#studentName').html(studentInfo.student_name);
            $('#dob').html(studentInfo.dob);
            $('#section').html(studentInfo.section_name);
            $('#nationality').html(studentInfo.nationality);
            $('#father_name').html(studentInfo.father_name);
            $('#mother_name').html(studentInfo.mother_name);
            // $('#admission_number').val(studentInfo.admission_no);
            // $('#last_class').val(studentInfo.last_class);
            $('#last_class').val(studentInfo.term_name + ' ' + studentInfo.program_name);



            $('#religion').html(studentInfo.religion);
            $('#caste').val(studentInfo.caste);
            $('#languages').html(studentInfo.elective_sub);
            $('#leaving_date').val(appendLeadingZeroes(new Date(leavingDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getFullYear()));
            $('#admission_date').html(appendLeadingZeroes(new Date(admissionDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear()));
            //  $('#admission_date').html(studentInfo.date_of_admission);


            var admission = appendLeadingZeroes(new Date(admissionDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear());

            if(admissionDate != ''){
                $('#date_of_admission').val(admission);
            }

            $('#instruction_medium').html("English");
            $('#optionals').html(studentInfo.stream_name);
            // if(studentInfo.date_of_admission == ""){
            // alert("Please Upadte Admission Date!");
            // return;
            // }
            $('#tcModel').modal('show');
        },
        error: function(result)
            {
                $(".modal-title").html("Error");
            },
            fail:(function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
    });
    
}   
    
function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
</script>


<?php
    function getFirstYearFeeInfo($con,$student_id){
        $query = "SELECT * FROM tbl_fee_pending_info_2021 as fee 
        WHERE fee.student_id = '$student_id'";
        $pdo_statement = $con->prepare($query);
        $pdo_statement->execute();
        return $pdo_statement->fetch();
    }

    
    function getSecondYearFeeInfo($con,$student_id){
        $query = "SELECT * FROM tbl_fee_pending_ii_2021 as fee 
        WHERE fee.student_id = '$student_id'";
        $pdo_statement = $con->prepare($query);
        $pdo_statement->execute();
        return $pdo_statement->fetch();
    }
?>