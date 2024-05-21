<style>
    .nf_load_more:hover {
        color: #33cc33 !important;
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
<?php } ?>
<?php
$warning = $this->session->flashdata('warning');
if ($warning) {
?>
    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
    </div>
<?php } ?>
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>


<div class="main-content-container px-3">
    <!-- Page Header -->
    <div class="row mt-1 mb-1 ">
        <div class="col padding_left_right_null">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="fas fa-tachometer-alt"></i> Dashboard / Overview
                    </span>
                    <img class="float-right" height="35" src="<?php echo base_url(); ?>assets/dist/img/logo_stxpuc.jpg" />
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Small Stats Blocks -->
    <?php if ($role == ROLE_TEACHING_STAFF) { ?>
        <div class="row ">
            <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
                <div class="card card-small">
                    <div class="card-header border-bottom card_head_dashboard">
                        <h6 class="m-0 text-dark">Quick Info</h6>
                    </div>
                    <div class="card-body d-flex flex-column p-1">
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                <table class="table table-bordered text-dark mb-0">
                                    <tr class="">
                                        <th width="100">Department</th>
                                        <th><?php echo $staffInfo->department; ?></th>
                                    </tr>
                                    <tr class="">
                                        <th>Subjects</th>
                                        <th>
                                            <?php $out = array();
                                            if (!empty($staffSubjectInfo)) {
                                                foreach ($staffSubjectInfo as $sub) {
                                                    array_push($out, $sub->sub_name . ' - ' . $sub->subject_type);
                                                }
                                                echo implode(', ', $out);
                                            } ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
                <div class="card card-small">
                    <div class="card-header border-bottom card_head_dashboard">
                        <h6 class="m-0 text-dark">Assigned Class</h6>
                    </div>
                    <div class="card-body d-flex flex-column p-1">
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                <table class="table table-bordered text-dark mb-0">
                                    <tr class="">
                                        <th width="100">I PUC</th>
                                        <th>
                                            <?php $out = array();
                                            if (!empty($assignedStaffsection)) {
                                                foreach ($assignedStaffsection as $staff) {
                                                    if ($staff->term_name == 'I PUC') {
                                                        array_push($out, $staff->stream_name . ' - ' . $staff->section_name);
                                                    }
                                                }
                                                echo implode(', ', $out);
                                            } ?>
                                        </th>
                                    </tr>
                                    <tr class="">
                                        <th>II PUC</th>
                                        <th>
                                            <?php $out = array();
                                            if (!empty($assignedStaffsection)) {
                                                foreach ($assignedStaffsection as $staff) {
                                                    if ($staff->term_name == 'II PUC') {
                                                        array_push($out, $staff->stream_name . ' - ' . $staff->section_name);
                                                    }
                                                }
                                                echo implode(', ', $out);
                                            } ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
                <div class="card card-small">
                    <div class="card-header border-bottom card_head_dashboard">
                        <h6 class="m-0 text-dark">Class Completed Count</h6>
                    </div>
                    <div class="card-body d-flex flex-column p-1">
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table-success">
                                            <th>Term</th>
                                            <th>Stream</th>
                                            <th>Section</th>
                                            <th>Theory Class</th>
                                            <th>Lab Class</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (!empty($assignedStaffClass)) {
                                        foreach ($assignedStaffClass as $staff) {
                                            // $totalTheoryCount = 0;
                                            $totalLabCount = 0;
                                            // foreach($staffClassCompletedInfo as $class){
                                            //     if($staff->subject_code == $class->subject_code && $staff->stream_name == $class->stream_name && $staff->section_name == $class->section_name && $staff->term_name == $class->term_name ){
                                            //         $totalTheoryCount++;
                                            //     } else if($staff->subject_code == $class->subject_code && $staff->stream_name == $class->stream_name && $staff->section_name == $class->section_name && $staff->term_name == $class->term_name && $class->subject_type == 'LAB'){
                                            //         $totalLabCount++;
                                            //     }
                                            // } 
                                    ?>
                                            <tr class="text-center">
                                                <th><?php echo $staff->term_name; ?></th>
                                                <th><?php echo $staff->stream_name; ?></th>
                                                <th><?php echo $staff->section_name; ?></th>
                                                <th><?Php echo $classCompletedCount[$staff->row_id]; ?></th>
                                                <th><?Php echo $totalLabCount; ?></th>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr class="text-center table-info">
                                            <th colspan="5">Record not found</th>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_SUPER_ADMIN) { ?>
        <div class="row ">
            <div class="col-lg-3 col-6 mb-2 column_padding_card">
                <div class="card card-small dash-card" style="background: linear-gradient(45deg,#1ce0b9,#55e7ca);">
                    <a onclick="showLoader();" href="<?php echo base_url(); ?>studentDetails" class="dashboard_link">
                        <div class="card-body pt-1 pb-1">
                            <span class="stats-small__label text-uppercase text-white text-center">Students</span>
                            <h6 class="stats-small__value count text-white">
                                <?php echo $totalFirstYearStudents + $totalSecondYearStudents; ?>
                            </h6>
                            <div class="icon pull-right">
                                <i class="fa fa-users dash-icons"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center dash-footer p-1">
                            <a class="more-info text-white" href="#"></a>
                            <span class="text-center">View Students</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6 mb-2 column_padding_card">
                <div class="card card-small dash-card" style="background: linear-gradient(45deg,#4099ff,#73b4ff);">
                    <a onclick="showLoader();" href="<?php echo base_url(); ?>staffDetails" class="dashboard_link">
                        <div class="card-body pt-1 pb-1">
                            <span class="stats-small__label text-uppercase text-white text-center">Staff</span>
                            <h6 class="stats-small__value count text-white">
                                <?php echo $total_staff; ?>
                            </h6>
                            <div class="icon pull-right">
                                <i class="fas fa-chalkboard-teacher dash-icons"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center dash-footer p-1">
                            <a class="more-info text-white" href="#"></a>
                            <span class="text-center">View Staff</span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
                <div class="card card-small dash-card" style="background: #6aacc5;">
                    <a href="#" class="dashboard_link">
                        <div class="card-body pt-1 pb-1">
                            <span class="stats-small__label text-uppercase text-white text-center">SMS</span>
                            <h6 class="stats-small__value count text-white">0</h6>
                            <div class="icon pull-right">
                                <i class="fa fa-envelope dash-icons"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center dash-footer p-1">
                            <a class="more-info text-white" href="#"></a>
                            <span class="text-center">View SMS</span>
                        </div>
                    </a>
                </div>
            </div> -->
            <div class="col-lg-3 col-6 mb-2 column_padding_card">
                <div class="card card-small dash-card" style="background: linear-gradient(45deg,#FF5370,#ff869a);">
                    <a  href="<?php echo base_url(); ?>studentAlumniInfo" class="dashboard_link">
                        <div class="card-body pt-1 pb-1">
                            <span class="stats-small__label text-uppercase text-white text-center">Alumni</span>
                            <h6 class="stats-small__value count text-white"><?php echo $alumniStudents; ?></h6>
                            <div class="icon pull-right">
                                <i class="fa fa-graduation-cap dash-icons"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center dash-footer p-1">
                            <a class="more-info text-white" href="#"></a>
                            <span class="text-center">View Alumni</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6 mb-1 column_padding_card">
                <div class="card card-small dash-card" style="background: linear-gradient(45deg,#90EE90,#90EE90);">
                    <a onclick="showLoader();" href="<?php echo base_url(); ?>viewFeeDashboard">
                        <div class="card-body pt-1 pb-1">
                            <span class=" text-uppercase text-black text-center" style="font-size:18px;">Fee Dashboard </span>
                            <h6 class="stats-small__value count text-transparent"><?php //echo $totalAdmissionCount; ?></h6>
                            <div class="icon pull-right pt-4">
                                <i class="fa fa-file-invoice dash-icons"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center dash-footer p-1">
                            <a class="more-info text-black" href="<?php echo base_url(); ?>viewFeeDashboard"><span
                                    class="text-center text-black">View Fee</span></a>
                        </div>
                    </a>
                </div>
            </div>
        </div>
      
    <?php } ?>

    <div class="row ">
        <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_SUPER_ADMIN) { ?>
            <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 mt-1 padding_left_right_null">
        </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 mt-1 padding_left_right_null">
        </div> -->

    </div>
    <div class="row">

        <div class="col-lg-12 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card card-small">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Student Quick Info</h6>
                </div>
                <div class="card-body p-1">
                    <form role="form" action="<?php echo base_url() ?>redirectStudentView" method="post" role="form" target = "_blank" id="myform1234">
                        <div class="row">
                            <div class="col-9 col-sm-9 ">
                                <div class="autocomplete">
                                    <select class="form-control selectpicker" name="student_id" id="student_id"
                                        data-live-search="true" required autocomplete="off">
                                        <option value="">Enter Student</option>
                                        <?php if (!empty($allStudentInfo)) {
                                                foreach ($allStudentInfo as $std) {  ?>
                                        <option value="<?php echo $std->row_id; ?>">
                                            <b><?php echo $std->student_id . ' - ' . $std->student_name . ' - ' . $std->term_name . ' ' . $std->section_name; ?></b>
                                        </option>
                                        <?php }
                                            } ?>
                                    </select>
                                    <!-- <input value="<?php echo $student_id; ?>" id="student_id" type="text" name="student_id" class="form-control input-sm pull-right" placeholder="Type Student ID" required autocomplete="off"> -->
                                    <!-- <select class="form-control selectpicker" name="student_id" id="student_id"
                                        data-live-search="true" required autocomplete="off">
                                        <option value="">Enter Student</option>
                                        <?php if(!empty($studentRecord)){
                                            foreach($studentRecord as $std){  ?>
                                        <option value="<?php echo $std->row_id; ?>">
                                            <b><?php echo $std->student_name.' - '.$std->sat_number; ?></b>
                                        </option>
                                        <?php } } ?>
                                    </select> -->
                                
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 pl-0">
                                <button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-1">
                    
                </div>
            </div>
        </div>
        <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>

            <div class="col-md-6 col-12 mb-2">
                <div class="card">
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr class="table-primary">
                                    <th colspan="4" class="text-center"  style="background-color:#e3cfff">TOTAL COLLECTION
                                    <form role="form" action="<?php echo base_url() ?>facultyDashboard" method="post" role="form" class="form-inline">

                                    <div class="form-group">
                                        <label for="usr">From:</label>
                                        <input type="text" name="from_date" value="<?php echo date('d-m-Y',strtotime($from_date)); ?>" class="datepicker form-control"
                                            Placeholder="From Date" autocomplete="off" required>
                                    </div>
                                    <div class="form-group ml-2">
                                            <label for="usr">To:</label><input type="text" name="to_date" value="<?php echo date('d-m-Y',strtotime($to_date)); ?>" class="datepicker form-control"
                                            Placeholder="To Date" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-dark btn-sm"><i class="fa fa-search"></i></button>
                                    </div>
                                    </form>
                                    </th>
                                </tr>
                                <tr  style="background-color:#e3cfff">
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>          
                                <tr>
                                    <th class="text-bold">School Fee</th>
                                    <td class="text-bold"><?php echo number_format($fees_paid,2); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-bold">Misc Fee</th>
                                    <td class="text-bold"><?php echo number_format($mis_paid,2); ?></td>
                                </tr>
                                <tr style="background-color:#e3cfff">
                                    <th class="text-bold">TOTAL FEE</th>
                                    <td class="text-bold"><?=number_format($fees_paid + $mis_paid,2) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
        <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card card-small">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Staff Quick Info</h6>
                </div>
                <div class="card-body p-1">
                    <form role="form" action="<?php echo base_url() ?>facultyDashboard" method="post" role="form">
                        <div class="row">
                            <div class="col-9">
                                <div class="autocompleteStaff">
                                <select class="form-control selectpicker" name="staff_id" id=""
                                        data-live-search="true" required autocomplete="off">
                                        <option value="">Enter Staff</option>
                                        <?php if (!empty($AllstaffInfo)) {
                                                foreach ($AllstaffInfo as $std) {  ?>
                                        <option value="<?php echo $std->staff_id; ?>">
                                            <b><?php echo $std->staff_id . ' - ' . $std->name . ' - ' . $std->department; ?></b>
                                        </option>
                                        <?php }
                                            } ?>
                                    </select>
                                    <!-- <input value="<?php echo $staff_id; ?>" id="staff_id" type="text" name="staff_id" class="form-control input-sm pull-right" placeholder="Type Staff ID" required autocomplete="off"> -->
                                </div>
                            </div>
                            <div class="col-3 pl-0">
                                <button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-1">
                    <div class="resultStudent">
                        <?php if (!empty($staffRecord)) { ?>
                            <div class="row">
                                <div class="col-3 text-center">
                                    <?php if (!empty($staffRecord->photo_url)) {  ?>
                                        <img src="<?php echo $staffRecord->photo_url; ?>" class="img-thumbnail" width="100" height="90" alt="Profile Image">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url() ?>assets/dist/img/user.png" class="img-thumbnail" width="100" height="90" alt="Profile Image">
                                    <?php } ?>
                                </div>
                                <div class="col-9">
                                    <h6 class="mb-1">Name: <b><?php echo $staffRecord->name; ?></b></h6>
                                    <hr class="my-0">
                                    <h6 class="mb-1">Staff ID: <b><?php echo $staffRecord->staff_id; ?></b></h6>
                                    <hr class="my-0">
                                    <h6 class="mb-1">Role: <b><?php echo $staffRecord->role; ?></b></h6>
                                    <hr class="my-0">
                                    <h6 class="mb-1">Department: <b><?php echo $staffRecord->department; ?></b></h6>
                                </div>

                            </div>
                            <hr class="my-1">
                            <div class="table-responsive">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="subject-tab" data-toggle="tab" href="#subject" role="tab" aria-controls="subject" aria-selected="false">Subject</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="section-tab" data-toggle="tab" href="#section" role="tab" aria-controls="section" aria-selected="false">Section</a>
                                    </li>

                                </ul>
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-bordered table_quick_info">
                                            <tr class="table-primary">
                                                <td>DOB</td>
                                                <th><?php if ($staffRecord->dob != '0000-00-00') {
                                                        echo date('d-m-Y', strtotime($staffRecord->dob));
                                                    } else {
                                                        echo '<span class="text-denger">Not Updated</span>';
                                                    } ?></th>
                                            </tr>
                                            <tr class="table-success">
                                                <td>Gender</td>
                                                <th><?php echo strtoupper($staffRecord->gender); ?></th>
                                            </tr>
                                            <tr class="table-primary">
                                                <td>Mobile</td>
                                                <th><?php echo $staffRecord->mobile_one; ?></th>
                                            </tr>
                                            <tr class="table-success">
                                                <td>Email</td>
                                                <th><?php echo $staffRecord->email; ?></th>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
                                        <table class="table table-bordered text-dark mb-0">
                                            <thead class="text-center">
                                                <tr class="table_row_background">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Subject Type</th>
                                                    <th>Department</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($staffSubjectInfo)) {
                                                    foreach ($staffSubjectInfo as $staff) { ?>
                                                        <tr class="text-center">
                                                            <th><?php echo $staff->subject_code; ?></th>
                                                            <th><?php echo $staff->sub_name; ?></th>
                                                            <th><?php echo $staff->subject_type; ?></th>
                                                            <th><?php echo $staff->name; ?></th>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr class="text-center">
                                                        <th colspan="5" style="background-color: #e3cfff;">Subject not assigned</th>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="section" role="tabpanel" aria-labelledby="section-tab">
                                        <table class="table table-bordered text-dark mb-0">
                                            <thead class="text-center">
                                                <tr class="table_row_background">
                                                    <th>Term Name</th>
                                                    <th>Stream Name</th>
                                                    <th>Section</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($staffSectionInfo)) {
                                                    foreach ($staffSectionInfo as $staff) { ?>
                                                        <tr class="text-center">
                                                            <th><?php echo $staff->term_name; ?></th>
                                                            <th><?php echo $staff->stream_name; ?></th>
                                                            <th><?php echo $staff->section_name; ?></th>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr class="text-center">
                                                        <th colspan="4" style="background-color: #e3cfff;">Class not assigned</th>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <h6 class="text-center mb-0"><?php echo $staffSearchMsg; ?></h6>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">
        <div class="card card-small p-0">
            <div class="card-header border-bottom card_head_dashboard">
                <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) { ?>
                    <button type="button" class="btn btn-primary float-right px-2 py-2" data-toggle="modal" data-target="#newsFeed">Add Feed</button>
                <?php } ?>
                <h6 class="m-0 text-dark">News Feed</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-small list-group-flush">
                    <li class="list-group-item p-1" id="newsFeed_section">
                        <!-- <span class="text-semibold text-dark" style="font-weight:500"></span> -->
                        <?php if (!empty($newsInfo)) {
                            $segmentID = 0;
                            foreach ($newsInfo as $count => $news) {
                                if (fmod($count, 7) == 0) {
                                    $segmentID++;
                                }
                        ?>
                                <div class="card news_card mb-2 p-2 ml-2 mr-2 newsFeedSegmentID_<?= $segmentID; ?>">
                                    <div class="row px-2">
                                        <div class="col-6">
                                            <b class="float-left"><?php echo date('h:i A', strtotime($news->date)); ?></b>
                                        </div>
                                        <div class="col-6">
                                            <b class="float-right"><?php echo date('d-m-Y', strtotime($news->date)); ?></b>
                                        </div>
                                    </div>
                                    <hr class="mx-1 mt-1 mb-0">
                                    <!-- <?php if (!empty($news->photo_url)) { ?>
                                        <div class="news_header">
                                            <img src="<?php echo base_url() ?><?php echo $news->photo_url; ?>" alt="News Feed" height="230" class="w-100" />
                                        </div>
                                    <?php } ?> -->
                                    <?php if (!empty($news->photo_url)) {
                                        $tempImgs = ['png', 'jpeg', 'jpg'];
                                        $ext = strtolower(pathinfo($news->photo_url, PATHINFO_EXTENSION));
                                        if (in_array($ext, $tempImgs)) {   ?>
                                            <div class="news_header">
                                                <img src="<?php echo base_url() ?><?php echo $news->photo_url; ?>" alt="News Feed" height="130" class="w-100" />
                                            </div>
                                            <div class="card-header px-2 py-1">
                                                <h6 class="news_title mb-0"><?php echo  $news->subject; ?></h6>
                                            </div>
                                        <?php } else { ?>
                                            <div class="card-header px-2 py-1">
                                                <h6 class="news_title mb-0"><?php echo  $news->subject; ?> <a style="font-size:15px;" class="pl-2" target="_blank" href="<?= base_url() . $news->photo_url ?>">view document</a></h6>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="card-header px-2 py-1">
                                            <h6 class="news_title mb-0"><?php echo  $news->subject; ?></h6>
                                        </div>
                                    <?php } ?>
                                    <div class="card-body news_body px-2 py-1">
                                        <span><?php echo $news->description; ?></span>
                                    </div>
                                    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                        <div class="card-footer px-2 py-1 float-right">
                                            <span class="p-2">
                                                <i class="fas fa-thumbs-up like_btn" style="color:<?php
                                                                                                    if ($news->isLiked == 0) {
                                                                                                        echo 'grey;cursor: pointer;';
                                                                                                    } else {
                                                                                                        echo "blue;cursor: pointer;";
                                                                                                    }
                                                                                                    ?>" onclick="like(this)" data-liked="<?= $news->isLiked; ?>" data-row_id="<?= $news->row_id; ?>"></i>
                                                <span class="pl-2" style="font-size:17px;font-weight:bold;"><span class='totalLikes'><?= $news->totalLikes; ?></span></span> Likes
                                            </span>
                                            <a class="btn btn-xs btn-danger deleteNewsFeed float-right" data-row_id="<?php echo $news->row_id; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="text-center">
                                <span class="text-semibold text-dark text-center" style="font-weight:500">News Feed Not Updated</span>
                            </div>
                        <?php } ?>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </li>
                </ul>
                <span onclick="loadMoreNewsFeed();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-left pt-2 pb-2 pl-2 nf_load_more">load more<i class="fas fa-arrow-circle-down pl-1"></i></span>
                <span onclick="showLessNewsFeed();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-right pt-2 pb-2 pr-2 nf_load_more">show less<i class="fas fa-arrow-circle-up pl-1"></i></span>
            </div>
        </div>
    </div>

    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) { ?>
        <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">
            <div class="mb-2">
                <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#student">
                    <a class="float-right mb-0 setting_pointer">Click here </a>
                    <h6 class="mb-0 text-dark">Quick Count Students</h6>
                </div>
                <div id="student" class="collapse">
                    <div class="card card-small">
                        <div class="card-body p-0">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered text-dark mb-0">
                                    <tr class="">
                                        <th width="200">I PUC</th>
                                        <th><?php echo $totalFirstYearStudents; ?></th>
                                    </tr>
                                    <tr class="">
                                        <th>II PUC</th>
                                        <th><?php echo $totalSecondYearStudents; ?></th>
                                    </tr>
                                    <tr class="">
                                        <th>Total</th>
                                        <th>
                                            <?php echo $totalFirstYearStudents + $totalSecondYearStudents; ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
            <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#staff">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="mb-0 text-dark">Quick Count Staff</h6>
            </div>
            <div id="staff" class="collapse">
                <div class="card card-small">
                    <div class="card-body p-0">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered text-dark mb-0">
                                <?php $total = 0;
                                foreach ($deptInfo as $dept) { ?>
                                    <?php if($staffCount[$dept->dept_id] != 0){ ?>
                                    <tr>
                                        <th><?php echo $dept->name; ?></th>
                                        <th class="text-center"><?php echo $staffCount[$dept->dept_id]; ?></th>
                                    </tr>
                                    <?php } ?>
                                <?php $total += $staffCount[$dept->dept_id];
                                } ?>
                                <tr class="">
                                    <th>Total</th>
                                    <th class="text-center">
                                        <?php echo $total; ?>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>

    <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_TEACHING_STAFF || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE ) { ?>

    <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" style="display: flex;flex-wrap: wrap;justify-content: space-between;">
                <h6 class="mb-0 text-dark">Today's Staff Birthdays</h6>
                
            </div>
            <div class="card card-small">
                <div class="card-body p-0" id="demo" class="collapse">
                    <div class="row  p-1">
                        <div class="col-12">
                            <?php if (!empty($staffsBirthday)) {
                                foreach ($staffsBirthday as $birth) { ?>
                                    <div class="col-12">
                                        <h6 class="mb-0" style="font-weight: 600;"><i class="material-icons">cake</i> <?php echo $birth->name; ?> - <?php echo $birth->role; ?></h6>
                                        <hr class="m-1">
                                    </div>

                                <?php }
                            } else { ?>
                                <div class="col-12 text-center">
                                    <h6 class="mb-0" style="font-weight: 600;"><?php echo $staffbirthdayMsg; ?></h6>
                                </div>

                            <?php }  ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" data-toggle="collapse" data-target="#birth">
                            <a class="float-right mb-0  mr-2 mt-2 setting_pointer">Click here </a>
                            <h6 class="mb-0 text-left dash_upcoming_birthday_title"><b>Upcoming Birthday</b></h6>

                        </div>
                        <div class="col-12 collapse" id="birth">

                            <?php if (!empty($staffUpcomingBday)) {
                                foreach ($staffUpcomingBday as $birth) { ?>
                                    <div class="col-12">
                                        <h6 class="mb-0" style="font-weight: 600;"><i class="material-icons">cake</i> <?php $result = strtotime($birth->dob);
                                                                                                                        echo date('d-F', $result);;
                                                                                                                        ?> - <?php echo $birth->name; ?> - <?php echo $birth->role; ?></h6>
                                        <hr class="m-1">
                                    </div>

                                <?php }
                            } else { ?>
                                <div class="col-12 text-center">
                                    <h6 class="mb-0" style="font-weight: 600;"><?php echo $staffUpcomingbirthdayMsg; ?></h6>
                                </div>
                            <?php }  ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" style="display: flex;flex-wrap: wrap;justify-content: space-between;">
                <h6 class="mb-0 text-dark">Today's Students Birthday</h6>
                <!-- <button class="btn btn-sm btn-primary birthDayWishBtn" data-target="student">Wish</button> -->
            </div>
            <div class="card card-small">
                <div class="card-body p-0" id="demo" class="collapse">
                    <div class="row  p-1">
                        <div class="col-12">
                            <?php if (!empty($studentsBirthday)) {
                                foreach ($studentsBirthday as $birth) { ?>
                                    <div class="col-12">
                                        <h6 class="mb-0" style="font-weight: 600;"><i class="material-icons">cake</i> <?php echo $birth->student_name; ?> - <?php echo $birth->term_name; ?></h6>
                                        <hr class="m-1">
                                    </div>

                                <?php }
                            } else { ?>
                                <div class="col-12 text-center">
                                    <h6 class="mb-0" style="font-weight: 600;"><?php echo $studentbirthdayMsg; ?></h6>
                                </div>
                            <?php }  ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12" data-toggle="collapse" data-target="#stdbirth">
                            <a class="float-right mb-0  mr-2 mt-2 setting_pointer">Click here </a>
                            <h6 class="mb-0 text-left dash_upcoming_birthday_title"><b>Upcoming Birthday</b></h6>

                        </div>
                        <div class="col-12 collapse" id="stdbirth">

                            <?php if (!empty($studentUpcomingBday)) {
                                foreach ($studentUpcomingBday as $birth) { ?>
                                    <div class="col-12">
                                        <h6 class="mb-0" style="font-weight: 600;"><i class="material-icons">cake</i> <?php $result = strtotime($birth->dob);
                                                                                                                                                        echo date('d-F', $result);;
                                                                                                                                            ?> - <?php echo $birth->student_name; ?> - <?php echo $birth->term_name; ?></h6>
                                        <hr class="m-1">
                                    </div>

                                <?php }
                            } else { ?>
                                <div class="col-12 text-center">
                                    <h6 class="mb-0" style="font-weight: 600;"><?php echo $studentUpcomingbirthdayMsg; ?></h6>
                                </div>
                            <?php }  ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php } ?>

    <!-- <?php if ($role == ROLE_NON_TEACHING_STAFF || $role == ROLE_ADMIN) { ?>
        <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">
            <div class="card card-small h-100">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Notifications</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-small list-group-flush">
                        <li class="list-group-item d-flex">
                            <span class="text-semibold text-dark mx-auto" style="font-weight:500">Notification Not
                                Found!</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">
            <div class="card card-small h-100">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Student Latecomer</h6>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="panel panel-primary">

                                <div class="panel-body" style="padding: 4px;">
                                    <div class="row">

                                        <div class="col-lg-3 col-sm-12 col-xs-12">
                                            <select class="form-control input-lg" id="by_term_latecomer" name="by_term_latecomer">
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <input type="number" name="student_id_latecomer" id="student_id_latecomer" class="form-control input-lg pull-right" style="text-transform: uppercase" placeholder="Enter Student ID" autocomplete="off" />
                                        </div>

                                        <div class="col-lg-3 col-sm-12 col-xs-12">
                                            <button type="button" id="buttonLatecomerStudent" class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="viewLatecomerStudent">
                                        <h6 class="text-center">Search by Student ID </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?> -->

    <!-- <?php if ($role == ROLE_ADMIN ||  $role == ROLE_OFFICE) { ?>
        <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">

            <div class="card card-small h-100">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Confirm to Send SMS for Absented students</h6>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="panel panel-primary">

                                <div class="panel-body" style="padding: 4px;">
                                    <div class="row">

                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <select class="form-control input-lg" id="by_term_for_sms" name="by_term_for_sms">
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>

                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <button type="button" id="sendAbsentedStudentSMS" class="btn btn-success btn-md btn-block"><i class="fa fa-paper-plane"></i> SEND</button>

                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="smsAbsentedResult" width="100%"></div>

                                        </div>


                                    </div>
                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?> -->

    </div>
    <!-- Event Calendar -->
    <!-- <div class="row">
        <div class="col-lg-12 col-md-12 col-12 mt-1 mb-2 padding_left_right_null">
            <div class="card card-small p-0">
                <div class="card-header border-bottom card_head_dashboard">
                    Event Calendar
                </div>
                <div class="card-body p-0 table-responsive">                    
                    <div id='calendar' style="margin:10px;"></div> 
                </div>
            </div>
        </div>
    </div> -->
    <!-- End of Event Calendar -->
</div>


<!-- Event Calendar Scripts -->
<link href="<?= base_url() ?>assets/calendar/main.css" rel='stylesheet' />
<script src="<?= base_url() ?>assets/calendar/main.js"></script>
<script src="<?= base_url() ?>assets/plugins/sweetalert/sweetalert2.0.js"></script>
<script src="<?= base_url() ?>assets/calendar/event-calendar.js"></script>
<script>
    // const loadCalendar = (events=[])=>{
    //     var calendarEl = document.getElementById('calendar');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         headerToolbar: {
    //             left: 'prev,next',
    //             center: 'title',
    //             right: 'listDay,listMonth' //listWeek
    //         },
    //         views: {
    //             listDay: { buttonText: 'day' },
    //             listMonth: { buttonText: 'month' }
    //         },

    //         initialView: 'listDay',
    //         initialDate: getCustomizedDate(new Date(),"yyyy-mm-dd"),
    //         navLinks: true, 
    //         editable: false,
    //         nowIndicator: true,
    //         dayMaxEvents: true, 
    //         events: [...events]
    //     });
    //     calendar.render();
    // };

    // const getCalendarEvents = async ()=>{
    //     return await $.post("<?= base_url() ?>api/calendar/getCalendarEvents");
    // }

    // $(document).ready(()=>{
    //     //showLoader();
    //     getCalendarEvents()
    //     .then(calEvts=>{
    //         hideLoader();
    //         try{
    //             let events = JSON.parse(calEvts);
    //             events.map((evt)=>{
    //                 evt.allDay = +evt.allDay;
    //                 evt.start = new Date(evt.start);                
    //                 evt.end = new Date(evt.end);
    //             });
    //             loadCalendar(events);
    //         }catch($ex){
    //             hideLoader();
    //             showError("Can't load calendar..!");
    //         }
    //     })
    //     .catch(postErr=>{
    //         hideLoader();
    //         showError("Can't load calendar..!");
    //     });
    // });
</script>
<!-- End of Event Calendar Scripts -->

<div class="modal" id="newsFeed">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add News Feed</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-1">
                <form role="form" action="<?php echo base_url() ?>addNewsFeed" method="post" id="feedForm" enctype="multipart/form-data">
                    <div class="row w-100 mx-0">
                        <div class="col-6 pl-0">
                            <div class="form-group mb-1">
                                <select class="form-control" name="visibility_type" id="visibility_type" required autocomplete="off">
                                    <option value="">Select Visibility</option>
                                    <option value="Student">Student</option>
                                    <option value="Staff">Staff</option>
                                    <option value="ALL">ALL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 pr-0">
                            <div class="form-group mb-1 term-container">
                                <select class="form-control" name="term_name" id="term_name" autocomplete="off">
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                    <option value="ALL">ALL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 px-0">
                            <div class="form-group mb-1">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" required autocomplete="off" maxlength="50" />
                            </div>
                            <div class="form-group mb-1">
                                <textarea cols="40" rows="5" class="form-control" placeholder="Enter Description.." name="description" id="description" required autocomplete="off" maxlength="150"></textarea>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="post_actions">
                                <div class="file btnp-0">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" class="form-control-sm" id="vImg" name="userfile" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                </div>
                            </div>
                        </div>
                        <div class="col-8 mt-1 pr-0">
                            <img src="" class="avatar img-thumbnail" width="100" height="100" id="uploadedImage" alt="News Feed">
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" form="feedForm" class='btn btn-primary'>Post</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script>
    // $(window).on("load", function() {
    //     if($("#visibility_type").val().toUpperCase()=="STUDENT"){
    //         showTerm();
    //     }else{
    //         hideTerm();
    //     }
    // });
</script>

<script>
    var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

    function showLessNewsFeed() {
        if (localStorage.getItem("NFSID") != null) {
            let curSegmentID = parseInt(localStorage.getItem("NFSID"));
            if (curSegmentID != 1) {
                $(".newsFeedSegmentID_" + curSegmentID).hide();
                localStorage.setItem("NFSID", curSegmentID - 1);
            }
        }
    }

    function loadMoreNewsFeed() {
        let nextSegmentID = 1;
        if (localStorage.getItem("NFSID") != null) {
            nextSegmentID = parseInt(localStorage.getItem("NFSID")) + 1;
        }
        if ($(".newsFeedSegmentID_" + nextSegmentID).length == 0) {
            alert("There is no more news feeds to load..");
        } else {
            localStorage.setItem("NFSID", nextSegmentID);
            $(".newsFeedSegmentID_" + nextSegmentID).show();
        }
    }

    function like($this) {
        if ($($this).data('liked') == 0) {
            $.post("<?= base_url() ?>likeNewsFeed", {
                data: $($this).data('row_id')
            }).done(res => {
                if (res != "ERROR") {
                    $($this).css("color", "blue");
                    $($this).data("liked", 1);
                    let $tl = Number($($this).parent().children('span').children('span.totalLikes').html()) + 1;
                    $($this).parent().children('span').children('span.totalLikes').html($tl);
                }
            }).fail(err => {
                console.log(err);
            });
        } else {
            $.post("<?= base_url() ?>disLikeNewsFeed", {
                data: $($this).data('row_id')
            }).done(res => {
                if (res != "ERROR") {
                    $($this).css("color", "grey");
                    $($this).data("liked", 0);
                    let $tl = Number($($this).parent().children('span').children('span.totalLikes').html()) - 1;
                    $($this).parent().children('span').children('span.totalLikes').html($tl);
                }
            }).fail(err => {
                console.log(err);
            });
        }
    }

    function showTerm() {
        $(".term-container").show();
    }

    function hideTerm() {
        $(".term-container").hide();
    }
    $("#visibility_type").on('change', function() {
        let $tempUser = $(this).val().toUpperCase();
        if ($tempUser == "STUDENT") {
            showTerm();
        } else {
            hideTerm();
        }
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#uploadedImage').attr('src', e.target.result);
                $('#uploadedImage').attr('alt', input.files[0].name);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#vImg").change(function() {
        readURL(this);
    });

    jQuery(document).ready(function() {
        $(".news_card").hide();
        localStorage.setItem("NFSID", 1);
        $(".newsFeedSegmentID_1").show();
        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#feedForm").attr("action", baseURL + "facultyDashboard/" + value);
            jQuery("#feedForm").submit();
        });
    });


    // function autocomplete(inp, student_names, student_id) {
    //     /*the autocomplete function takes two arguments,
    //     the text field element and an array of possible autocompleted values:*/
    //     var currentFocus;
    //     /*execute a function when someone writes in the text field:*/
    //     inp.addEventListener("input", function(e) {
    //         var a, b, i, val = this.value;
    //         /*close any already open lists of autocompleted values*/
    //         closeAllLists();
    //         if (!val) { return false;}
    //         currentFocus = -1;
    //         /*create a DIV element that will contain the items (values):*/
    //         a = document.createElement("DIV");
    //         a.setAttribute("id", this.id + "autocomplete-list");
    //         a.setAttribute("class", "autocomplete-items");
    //         /*append the DIV element as a child of the autocomplete container:*/
    //         this.parentNode.appendChild(a);
    //             for (i = 0; i < student_names.length; i++) {
    //             /*check if the item starts with the same letters as the text field value:*/
    //             if (student_names[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
    //                 /*create a DIV element for each matching element:*/
    //                 b = document.createElement("DIV");
    //                 /*make the matching letters bold:*/
    //                 b.innerHTML = "<strong>" + student_names[i].substr(0, val.length) + "</strong>";
    //                 b.innerHTML += student_names[i].substr(val.length);
    //                 /*insert a input field that will hold the current array item's value:*/
    //                 b.innerHTML += "<input type='hidden' value='" + student_id[i] + "'>";
    //                 /*execute a function when someone clicks on the item value (DIV element):*/
    //                 b.addEventListener("click", function(e) {
    //                     /*insert the value for the autocomplete text field:*/
    //                     inp.value = this.getElementsByTagName("input")[0].value;
    //                     /*close the list of autocompleted values,
    //                     (or any other open lists of autocompleted values:*/
    //                     closeAllLists();
    //                 });
    //                 a.appendChild(b);
    //             }
    //         }
    //         /*for each item in the array...*/

    //     });
    //     /*execute a function presses a key on the keyboard:*/
    //     inp.addEventListener("keydown", function(e) {
    //         var x = document.getElementById(this.id + "autocomplete-list");
    //         if (x) x = x.getElementsByTagName("div");
    //         if (e.keyCode == 40) {
    //             /*If the arrow DOWN key is pressed,
    //             increase the currentFocus variable:*/
    //             currentFocus++;
    //             /*and and make the current item more visible:*/
    //             addActive(x);
    //         } else if (e.keyCode == 38) { //up
    //             /*If the arrow UP key is pressed,
    //             decrease the currentFocus variable:*/
    //             currentFocus--;
    //             /*and and make the current item more visible:*/
    //             addActive(x);
    //         } else if (e.keyCode == 13) {
    //             /*If the ENTER key is pressed, prevent the form from being submitted,*/
    //             e.preventDefault();
    //             if (currentFocus > -1) {
    //             /*and simulate a click on the "active" item:*/
    //             if (x) x[currentFocus].click();
    //             }
    //         }
    //     });
    //     function addActive(x) {
    //         /*a function to classify an item as "active":*/
    //         if (!x) return false;
    //         /*start by removing the "active" class on all items:*/
    //         removeActive(x);
    //         if (currentFocus >= x.length) currentFocus = 0;
    //         if (currentFocus < 0) currentFocus = (x.length - 1);
    //         /*add class "autocomplete-active":*/
    //         x[currentFocus].classList.add("autocomplete-active");
    //     }
    //     function removeActive(x) {
    //         /*a function to remove the "active" class from all autocomplete items:*/
    //         for (var i = 0; i < x.length; i++) {
    //         x[i].classList.remove("autocomplete-active");
    //         }
    //     }
    //     function closeAllLists(elmnt) {
    //         /*close all autocomplete lists in the document,
    //         except the one passed as an argument:*/
    //         var x = document.getElementsByClassName("autocomplete-items");
    //         for (var i = 0; i < x.length; i++) {
    //         if (elmnt != x[i] && elmnt != inp) {
    //             x[i].parentNode.removeChild(x[i]);
    //         }
    //         }
    //     }
    //     /*execute a function when someone clicks in the document:*/
    //     document.addEventListener("click", function (e) {
    //         closeAllLists(e.target);
    //     });
    // }

    /*An array containing all the country names in the world:*/
    // var countries = ["123456789","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
    // var student_names = [];
    // var student_id = [];
    // var i=0;
    // $.ajax({
    //     url: '<?php echo base_url(); ?>/getAllCurrentStudents',
    //     type: 'POST',
    //     data: {},
    //     success: function(data) {
    //         var startCount=  data.studentInfo.length;
    //         for(i=0; i<startCount; i++){
    //             student_names[i] = data.studentInfo[i].student_name;
    //             student_id[i] = data.studentInfo[i].student_id;
    //         }
    //     },
    //     error: function(result){
    //         alert("Retry Again! Something Went Wrong");
    //     },
    //     fail:(function(status) {
    //         alert("Retry Again! Something Went Wrong");  
    //     }),
    //     beforeSend:function(d){
    //         // $('.resultStudent').html('<span class="text-center">'+loader+'</span>');
    //     }
    // });

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    // autocomplete(document.getElementById("sat_number_academic"), student_names, sat_number);
    //autocomplete(document.getElementById("student_id"), student_names, student_id);

    $("#sendAbsentedStudentSMS").on('click', function() {
        var term_name = $('#by_term_for_sms').val();
        if (term_name == "") {
            $('.smsAbsentedResult').html(`<div class="alert alert-danger" role="alert">
                                          Please Select Term Name!
                                          </div>`);
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>/sendSMSAbsentedStudents',
                type: 'POST',
                data: {
                    term_name: term_name,
                },
                success: function(data) {
                    $('.smsAbsentedResult').html('');
                    if (data == 'success') {
                        $('.smsAbsentedResult').html(`<div class="alert alert-success" role="alert">
                                          SMS Sent Successfully!
                                          </div>`);
                    }
                },
                error: function(result) {
                    alert("Retry Again! Something Went Wrong");
                },
                fail: (function(status) {
                    alert("Retry Again! Something Went Wrong");
                }),
                beforeSend: function(d) {
                    $('.smsAbsentedResult').html('<span class="text-center">' + loader + '</span>');
                }
            });
        }
    });


    $("#buttonLatecomerStudent").on('click', function() {
        //var term_name = $('#by_term').val();
        var student_id = $('#student_id_latecomer').val();
        var term_name = $('#by_term_latecomer').val();
        if (student_id == "") {
            $('.viewLatecomerStudent').html(`<div class="alert alert-danger" role="alert">
                                          Student ID is Empty!!
                                          </div>`);
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>/getLatecomerByStudentId',
                type: 'POST',
                data: {
                    student_id: student_id,
                    term_name: term_name
                },
                success: function(data) {
                    if (data.studentsRecords == null) {
                        $('.viewLatecomerStudent').html(`<div class="alert alert-info" role="alert">
                                          Student Not Found!!
                                          </div>`);

                    } else {
                        var mobile = data.studentsRecords.father_mobile;
                        if (data.studentsRecords.father_mobile == "") {
                            mobile = data.studentsRecords.mother_mobile;
                        }

                        $('.viewLatecomerStudent').html(`
                <div class="row">
                      <div class="col-lg-3">
                      <img class="text-right"  src="` + baseURL + `/assets/images/PHOTOS_19_21_ALL/` + data.studentsRecords.student_id + `.png" height="100" alt="profile Img">
                      </div>
                      <div class="col-lg-9">
                        <h4>Student Id: <b>` + data.studentsRecords.student_id + `</b></h4>
                        <h4>Term: <b>` + data.studentsRecords.term_name + `</b></h4>
                        <h4>Section: <b>` + data.studentsRecords.section_name + `</b></h4>
                      </div>
                </div>
              <table class="table table-bordered table-responsive" style="border-color:red">
                        <tbody>
                          <tr class="danger">
                            <td width="180">Name</td>
                            <th>` + data.studentsRecords.student_name + `</th>
                          </tr>
                          <tr class="warning">
                            <td>Program Name</td>
                            <th>` + data.studentsRecords.program_name + `</th>
                          </tr>

                          <tr class="active">
                          <td>Stream Name</td>
                            <th>` + data.studentsRecords.stream_name + `</th>
                          </tr>

                          <tr class="active">
                          <td>In Time</td>
                            <th style="color:red;">` + data.in_time + `</th>
                          </tr>
                          <tr class="active">
                          <td>Late Time</td>
                            <th style="color:red;">` + data.late_time + `</th>
                          </tr>

                          <tr class="active">
                          <td>Total Late This Month</td>
                            <th style="color:red;">` + data.late_count_month + `</th>
                          </tr>

                          <tr class="active">
                          <td>Total Late in this Academic</td>
                            <th style="color:red;">` + data.late_count_year + `</th>
                          </tr>

                          
                        </tbody>
                    </table>
                    
                    <div class="row">
                      <div class="col-lg-12">
                      <button type="button" onclick="latecomerConfirm('` + data.studentsRecords.student_id + `','` + data.in_time_db + `','` + data.late_time + `','` + mobile + `','` + data.studentsRecords.student_name + `')" class="btn btn-success btn-block" >Send Message</button>
                      </div>
                    </div>
              `);
                    }
                },
                error: function(result) {
                    alert("Retry Again! Something Went Wrong");
                },
                fail: (function(status) {
                    alert("Retry Again! Something Went Wrong");
                }),
                beforeSend: function(d) {
                    $('.viewLatecomerStudent').html('<span class="text-center">Loading...</span>');
                }
            });
        }
    });





    function latecomerConfirm(student_id, in_time, late_time, mobile, name) {
        $.ajax({
            url: '<?php echo base_url(); ?>/confirmLatecomerInfo',
            type: 'POST',
            data: {
                student_id: student_id,
                in_time: in_time,
                late_time: late_time,
                mobile: mobile,
                name: name,
            },
            success: function(data) {
                if (data.msg == "EXIST") {
                    $('.viewLatecomerStudent').html(`<div class="alert alert-danger" role="alert">
                      Latecomer is already exist for today!
                                          </div>`);
                } else {
                    $('.viewLatecomerStudent').html(`<div class="alert alert-success" role="alert">
                                        ` + data.msg + `
                                          </div>`);
                }

            },
            error: function(result) {
                alert("Retry Again! Something Went Wrong");
            },
            fail: (function(status) {
                alert("Retry Again! Something Went Wrong");
            }),
            beforeSend: function(d) {
                $('.viewLatecomerStudent').html('<span class="text-center">Loading..</span>');
            }
        });
    }
</script>



<?php


function calculateResult($total_marks){
    $percentage = floor(($total_marks / 600) * 100);
    if($percentage >= 85){
        return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
        return "I Class";
    } else if($percentage >= 50 && $percentage <= 59){
        return "II Class";
    } else if($percentage >= 35 && $percentage <= 49){
        return "III Class";
    }
}


?>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('myform1234').addEventListener('submit', function(event) {
            hideLoader();
        });
    });

    function hideLoader(){
        $(".custom_loader").fadeOut();
    } 

   
</script>