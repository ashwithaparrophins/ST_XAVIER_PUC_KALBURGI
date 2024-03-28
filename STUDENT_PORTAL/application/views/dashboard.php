<?php require APPPATH . 'views/includes/db.php'; ?>
<div class="loader">
  <img id="loader_img" src="<?php echo base_url(); ?>assets/dist/img/student.gif" class="img-fluid" alt="loader">
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<style>
  .form-group {
    margin-bottom: 0rem !important;
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
  }
</style>
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
<div class="row ">
  <div class="col-md-12 col-lg-12 col-12">
    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
  </div>
</div>
<div class="main-content-container container-fluid px-4 ">
  <div class="row mt-1 mb-2">
    <div class="col padding_left_right_null">
      <div class="card card-small p-0 card_head_dashboard">
        <div class="card-body p-2 ml-2">
          <span class="page-title">
            <i class="fa fa-dashboard"></i> Dashboard / Overview
          </span>
        </div>
      </div>
    </div>
  </div>
  <!-- End Page Header -->
  <!-- Small Stats Blocks -->
  <div class="row padding_left_right_null d_none">
    <div class="col-lg-3 col-6 mb-4 column_padding_card">
      <div class="card card-small dash-card" style="background: #6cd5da;">
        <div class="card-body pt-1 pb-1">
          <span class="stats-small__label text-uppercase text-white text-center">Term</span>
          <h6 class="stats-small__value count text-white"><?php
                                                          echo $studentInfo->term_name;
                                                          ?></h6>
          <div class="icon pull-right">
            <i class="fa fa-university dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <a class="more-info text-white" href="#"><i class="fa fa-arrow-circle-right"></i></a><br>
          <span class="text-center">Term Name</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6 mb-4 column_padding_card">
      <div class="card card-small dash-card" style="background: #da70d6d1;">
        <div class="card-body pt-1 pb-1">
          <span class="stats-small__label text-uppercase text-white text-center">Section</span>
          <h6 class="stats-small__value count text-white"><?php echo $studentInfo->section_name; ?></h6>
          <div class="icon pull-right">
            <i class="fa fa-pie-chart dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <a class="more-info text-white" href="#"><i class="fa fa-arrow-circle-right"></i></a><br>
          <span class="text-center">Section Name</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6 mb-4 column_padding_card">
      <div class="card card-small dash-card" style="background: #5be25bcf;">
        <div class="card-body pt-1 pb-1">
          <span class="stats-small__label text-uppercase text-white text-center">Stream</span>
          <h6 class="stats-small__value count text-white"><?php echo $studentInfo->stream_name; ?></h6>
          <div class="icon pull-right">
            <i class="fa fa-pencil dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <a class="more-info text-white" href="#"><i class="fa fa-arrow-circle-right"></i></a><br>
          <span class="text-center">Stream Name</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6 mb-4 column_padding_card">
      <div class="card card-small dash-card" style="background: #f73686a3;">
        <div class="card-body pt-1 pb-1">
          <span class="stats-small__label text-uppercase text-white text-center">Elective</span>
          <h6 class="stats-small__value count text-white">
            <?php echo strtoupper($studentInfo->elective_sub); ?></h6>
          <div class="icon pull-right">
            <i class="fa fa-book  dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <a class="more-info text-white" href="#"><i class="fa fa-arrow-circle-right"></i></a><br>
          <span class="text-center">Elective Subject</span>
        </div>
      </div>
    </div>
    <?php if($term_name == 'I PUC'){  ?>
    <div class="col-lg-3 col-6 mb-4 column_padding_card">
      <div class="card card-small dash-card" style="background: #1e90ff;">
        <div class="card-body pt-1 pb-1">
          <span class="stats-small__label text-uppercase text-white text-center">Annual Exam</span>
          <h6 class="stats-small__value count text-white">
            </h6>
          <div class="icon pull-right">
            <i class="fa fa-book  dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <a class="more-info text-white" href="<?php echo base_url(); ?>examAnnualPerformance"><i class="fa fa-arrow-circle-right"></i></a><br>
          <span class="text-center">Result</span>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if ($studentInfo->program_name == 'COMMERCE') { ?>
      <!-- <div class="col-lg-6 col-md-6 col-12 mb-4 padding_left_right_null">
        <!-- Quick Post 
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Course Registration</h6>
          </div>
          <div class="card-body d-flex flex-column">
            <div id="msg"></div>
            <form action="<?php echo base_url(); ?>courseRegistrationFeeProcess" method="POST" role="form">
              <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-12">
                  <select class="form-control" name="course_name" required>
                    <option value="">Select Course</option>
                    <option value="Stock Market">STOCK MARKET - 1250</option>
                    <option value="Tally">TALLY - 3000 </option>
                    <option value="Advance Excell">ADVANCE EXCELL - 3000</option>
                  </select>
                </div>
                <div class="form-group  col-lg-6 col-md-6 col-12">
                  <button type="submit" class="btn btn-block btn-accent">Register</button>
                </div>
              </div>
            </form>

            <table class="table table-bordered table_info mb-0 mt-4">
              <thead class="text-center">
                <tr class="table_row_backgrond">
                  <th>Course Name</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <?php if (!empty($regCourseInfo)) {
                foreach ($regCourseInfo as $course) {
                  if ($course->payment_status == 1) { ?>
                    <tr>
                      <td style="padding:7px"><?php echo $course->course_name ?></td>
                      <td class="text-center"><?php echo $course->paid_amount ?></td>
                      <td class="text-center text-success">Success
                      </td>
                    </tr>
              <?php }
                }
              } ?>
            </table>


          </div>
        </div>
        <!-- End Quick Post 
      </div> -->
    <?php } ?>

    <?php if (!empty($feedbackStatus)) {  ?>

      <!-- <div class="col-lg-3 col-6 mb-4 column_padding_card">
    <a class="more-info text-white" href="<?php echo base_url(); ?>viewStaffForFeedback">  
    <div class="card pt-1 pb-1" style="background: #f73686a3;">
  
      <div class="card-body card-small dash-card">
    
          <span class="stats-small__label text-uppercase text-white text-center">Staff Feedback</span>
          <h6 class="stats-small__value count text-white"></h6>
          <div class="icon pull-right">
            <i class="fa fa-book  dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
         <i class="fa fa-arrow-circle-right"></i><br>
          <span class="text-center">Give Feedback</span>
        </div>
      </div>
      
    </div> -->
      <!-- </a> -->
    <?php } ?>

    <?php if ($term_name == 'II PUC') {  ?>
      <!-- <div class="col-lg-3 col-6 mb-4 column_padding_card">
        <a class="more-info text-white" href="<?php echo base_url(); ?>reAdmissionForIIPUC">
          <div class="card pt-1 pb-1" style="background: #f73686a3;">
            <div class="card-body card-small dash-card">
              <span class="stats-small__label text-uppercase text-white text-center">Fee Payment</span>
              <h6 class="stats-small__value count text-white"></h6>
              <div class="icon pull-right">
                <i class="fa fa-book  dash-icons"></i>
              </div>
            </div>
            <div class="card-footer text-center dash-footer p-0">
              <i class="fa fa-arrow-circle-right"></i><br>
              <span class="text-center">Fee Payment II PUC</span>
            </div>
          </div>
      </div> -->
    <?php } else { ?>
      <!-- <div class="col-lg-3 col-6 mb-4 column_padding_card">
        <a class="more-info text-white" href="<?php echo base_url(); ?>viewAdmission_I_PUC">
          <div class="card pt-1 pb-1" style="background: #f73686a3;">
            <div class="card-body card-small dash-card">
              <span class="stats-small__label text-uppercase text-white text-center">Fee Payment</span>
              <h6 class="stats-small__value count text-white"></h6>
              <div class="icon pull-right">
                <i class="fa fa-book  dash-icons"></i>
              </div>
            </div>
            <div class="card-footer text-center dash-footer p-0">
              <i class="fa fa-arrow-circle-right"></i><br>
              <span class="text-center">Fee Payment I PUC</span>
            </div>
          </div>
      </div> -->
    <?php } ?>
    <?php if ($term_name == 'II PUC') {  ?>
      <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card text-center">
      <a href="<?php echo base_url(); ?>examPerformance">
      <div class="card card-small dash-card" style="background: #f54f56d3;">
        <div class="card-body p-1">
          <div class="icon text-center text-white">
            <i class="material-icons ">&#xE6E1;</i>
          </div>
          <h6 class="stats-small__value count text-white">My Performance</h6>
        </div>
        <div class="card-footer text-center dash-footer p-1">
          <span class="text-center"><i class="material-icons ">&#xE6E1;</i> View</span>
        </div>
      </div>
      </a>
    </div> -->
    <?php } ?>
  </div>

  <!-- mobile cards -->
  <div class="row padding_left_right_null mobile_cards_dashboard">


    <?php if ($term_name == 'II PUC') {  ?>
      <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>examPerformance">
      <div class="card card-small dash-card mobile_dashCards">
        <div class="card-body pt-1 pb-1">
          <div class="icon text-center text-white">
            <i class="material-icons card_dash_mobileIcons">&#xE6E1;</i>
          </div>
          <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">My Performance</h6>
        </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
      </div>
      </a>
    </div> -->
    <?php }  ?>
    <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>myAttendance">
      <div class="card card-small dash-card mobile_dashCards">
        <div class="card-body pt-1 pb-1">
          <div class="icon text-center text-white">
            <i class="material-icons card_dash_mobileIcons">format_list_bulleted</i>
          </div>
          <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">My Attendance</h6>
        </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
      </div>
      </a>
    </div> -->
    <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>viewstudyMaterials">
        <div class="card card-small dash-card mobile_dashCards">
          <div class="card-body pt-1 pb-1">
            <div class="icon text-center text-white">
              <i class="material-icons card_dash_mobileIcons">book</i>
            </div>
            <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Study materials</h6>
          </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
        </div>
      </a>
    </div>
    <!-- <div class="col-lg-3 col-6 mb-4 column_padding_card">
      <a href="<?php echo base_url(); ?>viewTimeTable">
      <div class="card card-small dash-card mobile_dashCards">
        <div class="card-body pt-1 pb-1">
          <div class="icon text-center text-white">
            <i class="material-icons card_dash_mobileIcons">access_time</i>
          </div>
          <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Time Table</h6>
        </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
      </div>
      </a>
    </div> -->
    <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>mySuggestion">
        <div class="card card-small dash-card mobile_dashCards">
          <div class="card-body pt-1 pb-1">
            <div class="icon text-center text-white">
              <i class="material-icons card_dash_mobileIcons">forum</i>
            </div>
            <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">My Suggestions</h6>
          </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
        </div>
      </a>
    </div>
    <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>getFeePaymentInfo">
      <div class="card card-small dash-card mobile_dashCards">
        <div class="card-body pt-1 pb-1">
          <div class="icon text-center text-white">
            <i class="material-icons card_dash_mobileIcons">&#xE7FD;</i>
          </div>
          <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Fee Payment I PUC</h6>
        </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View  <i class="fas fa-rupee-sign"></i></span>
          </div>
      </div>
      </a>
    </div> -->
    <?php if ($term_name == 'II PUC') {  ?>
      <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
        <a href="<?php echo base_url(); ?>reAdmissionForIIPUC">
          <div class="card card-small dash-card mobile_dashCards">
            <div class="card-body pt-1 pb-1">
              <div class="icon text-center text-white">
                <i class="material-icons card_dash_mobileIcons">&#xE7FD;</i>
              </div>
              <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Fee Payment II PUC</h6>
            </div>
            <div class="card-footer text-center dash-footer p-1">
              <span class="more-info text-white text-center font-weight-bold">View <i class="fas fa-rupee-sign"></i></span>
            </div>
          </div>
        </a>
      </div> -->
    <?php }  ?>
    <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>viewOnlineClass">
        <div class="card card-small dash-card mobile_dashCards">
          <div class="card-body pt-1 pb-1">
            <div class="icon text-center text-white">
              <i class="material-icons card_dash_mobileIcons">&#xE7FD;</i>
            </div>
            <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Online Class</h6>
          </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>profile">
        <div class="card card-small dash-card mobile_dashCards">
          <div class="card-body pt-1 pb-1">
            <div class="icon text-center text-white">
              <i class="material-icons card_dash_mobileIcons">&#xE7FD;</i>
            </div>
            <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">My Profile</h6>
          </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
        </div>
      </a>
    </div>
    <?php if($term_name == 'I PUC'){  ?>
    <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>examAnnualPerformance">
        <div class="card card-small dash-card mobile_dashCards">
          <div class="card-body pt-1 pb-1">
            <div class="icon text-center text-white">
              <i class="material-icons card_dash_mobileIcons">assignment_turned_in</i>
            </div>
            <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Annual Exam</h6>
          </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">View <i class="material-icons">visibility</i></span>
          </div>
        </div>
      </a>
    </div>
    <?php } ?>

    <?php if ($studentInfo->program_name == 'COMMERCE') { ?>
      <div class="col-lg-6 col-md-6 col-12 mb-4 padding_left_right_null">
        <!-- Quick Post -->
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Course Registration</h6>
          </div>
          <div class="card-body d-flex flex-column">
            <div id="msg"></div>
            <form action="<?php echo base_url(); ?>courseRegistrationFeeProcess" method="POST" role="form">
              <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-12">
                  <select class="form-control" name="course_name" required>
                    <option value="">Select Course</option>
                    <option value="Stock Market">STOCK MARKET - 1250</option>
                    <option value="Tally">TALLY - 3000 </option>
                    <option value="Advance Excell">ADVANCE EXCELL - 3000</option>
                  </select>
                </div>
                <div class="form-group  col-lg-6 col-md-6 col-12">
                  <button type="submit" class="btn btn-block btn-accent">Register</button>
                </div>
              </div>
            </form>

            <table class="table table-bordered table_info mb-0 mt-4">
              <thead class="text-center">
                <tr class="table_row_backgrond">
                  <th>Course Name</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <?php if (!empty($regCourseInfo)) {
                foreach ($regCourseInfo as $course) {
                  if ($course->payment_status == 1) { ?>
                    <tr>
                      <td style="padding:7px"><?php echo $course->course_name ?></td>
                      <td class="text-center"><?php echo $course->paid_amount ?></td>
                      <td class="text-center text-success">Success
                      </td>
                    </tr>
              <?php }
                }
              } ?>
            </table>


          </div>
        </div>
        <!-- End Quick Post -->
      </div>
    <?php } ?>



    <?php if (!empty($feedbackStatus)) {  ?>
      <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
      <a href="<?php echo base_url(); ?>viewStaffForFeedback">
      <div class="card card-small dash-card mobile_dashCards">
        <div class="card-body pt-1 pb-1">
          <div class="icon text-center text-white">
            <i class="material-icons card_dash_mobileIcons">&#xE7FD;</i>
          </div>
          <h6 class="mobile_dash_title text-uppercase text-white text-center mb-0">Staff Feedback</h6>
        </div>
          <div class="card-footer text-center dash-footer p-1">
            <span class="more-info text-white text-center font-weight-bold">Give Feedback <i class="material-icons">visibility</i></span>
          </div>
      </div>
      </a>
    </div> -->

    <?php } ?>
  </div>

  <!-- End Page Header -->
  <div class="row">

    <!-- <div class="col-lg-6 col-12 mb-4 column_padding_card">
      <div class="card">
        <div class="card-header p-2 font-weight-bold card_head_dashboard">
        SJPUC MUN - 2021 Registration
        <a href="https://www.sjpuc.in/announcements/COMMITTEE%20AGENDA%20LIST.pdf" target="_blank" class="btn-sm btn btn-success float-right" download> HELP</a>
        </div>
        <div class="card-body" style="padding: 0px;">
          <?php if ($mun_payment_status) { ?>
            <h5 style="color:green" class="text-center mt-2">Thank You! MUN-2021 registration is completed</h5>
         <?php  } else { ?>
  <form action="<?php echo base_url(); ?>munRegistrationFeeProcess" method="POST" class="text-center">
          <div class="col-lg-12">
          <div class="form-group">
          <label for="usr">WhatsApp Mobile Number</label>
          <input onkeypress="return isNumber(event)" placeholder="Enter your WhatsApp Number" type="text"  maxlength="10" name="mobile" id="mobile" class="form-control" id="usr" autocomplete="off" required>
        </div>
          </div>
        <div class="col-lg-12 mt-2">
        <div class="form-group">
          <label for="committee">Select Preferred Allotments</label>
          <select class="form-control" name="committee" id="committee" required>
            <option value="">Select Preferred Allotments</option>
            <option value="UNSC">UNSC</option>
            <option value="UNHRC">UNHRC</option>
            <option value="ECOSOC">ECOSOC</option>
            <option value="AIPPM">AIPPM</option>
            <option value="CCC">CCC</option>
          </select>
        </div>
          </div>
          <hr>
          <div class="col-12 col-lg-12">
        </div>
        <button type="submit" class="btn-sm btn btn-primary btn-block float-right"> Register</button>
          </form>
         <?php } ?>
        
      </div>
      </div>
      </div> -->
    <?php if ($term_name == 'I PUC') { ?>
      <!-- <div class="col-lg-6 col-12 mb-4 column_padding_card">
      <div class="card">
        <div class="card-header">Second PUC
Orientation Program
        </div>
        <div class="card-body text-center" style="padding: 0px;">
        <a href="https://www.sjpuc.in/announcements/Orientation%20Second%20year%202021%20final.pdf" download> Click here to view</a>
        
        </div>
      </div>
      </div> -->
    <?php  }
    ?>

    <!-- <div class="col-lg-8 col-12 mb-4 padding_left_right_null">
          <div class="card card-small">
            <div class="card-header border-bottom card_head_dashboard">
              <h6 class="m-0 text-dark">Annual Exam Result 2019-20</h6>
            </div>
            <div class="card-body p-0">
            <?php
            if ($term_name == 'I PUC') {
              $dataPointsPie = array();
              $failed_sub_count = 0;
              $query = "SELECT DISTINCT mark.subject_code,sub.subject_code,sub.name,sub.lab_status,sub.sub_type,mark.obt_theory_mark,mark.obt_lab_mark
                    FROM tbl_student_exams_marks as mark, tbl_subjects as sub
                    WHERE sub.subject_code =  mark.subject_code AND student_id = '$studentMarkInfo->student_id'";
              $pdo_statement = $con->prepare($query);
              $pdo_statement->execute();
              $result = $pdo_statement->fetchAll();
              $subjects_code = getSubjectCodes($studentMarkInfo->stream_name);
              if (!empty($result)) {
                $student_mark_info = '<div class="table-responsive-sm">
                    <table class="table table-bordered table_annual_exam mb-0">
                    <tr class="text-center table_row_backgrond">
                        <th width="180" class="text-center">SUBJECT NAME</th>
                        <th width="100" class="text-center">MAX. MARKS</th>
                        <th width="100" class="text-center">OBT. MARK</th>
                      
                        <th width="70" class="text-center">Total</th>
                        <th width="200" class="text-center">RESULT</th>
                    </tr>';
                $subject_total_mark = getSubjectTotal($result, $subjects_code);
                $theory_total_mark = getTheoryTotal($result, $subjects_code);
                $lab_total_mark = getLabTotal($result, $subjects_code);
                $total_subjects = 6;
                $skipped_lang_I = "false";
                $skipped_lang_II = "false";
                $elective_count = 1;
                if ($studentMarkInfo->elective_sub == 'EXEMPTED') {
                  $elective_count++;
                  $student_mark_info .= '
                        <tr>
                            <td>EXEMPTED</td>
                            <td class="text-center">EX</td>
                            <td class="text-center">EX</td>
                            <td>EXEMPTED</td>
                            </tr>';
                }
                foreach ($result as $row) {
                  if ($studentMarkInfo->elective_sub == 'EXEMPTED') {
                    $total_subjects = 5;
                    $first_lag_result = "EXEMPTED";
                    $skipped_lang_I = "true";
                  }
                  if ($row["subject_code"] == '1' || $row["subject_code"] == '3' || $row["subject_code"] == '12') {
                    if ($row["subject_code"] == '12') {
                      $theory_mark_lang_I = (int)$row["obt_theory_mark"];
                      $lab_mark_lang_I = (int)$row["obt_lab_mark"];
                      $total_mark_lang_I = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                      if ($row["obt_theory_mark"] == 'EX' || $row["obt_lab_mark"] == 'EX') {
                        $total_subjects = 5;
                        $first_lag_result = "EXEMPTED";
                        $skipped_lang_I = "true";
                      } else if (!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                        $total_mark_lang_I = $row["obt_theory_mark"];
                        $first_lag_result = "FAIL";
                      } else if (!is_numeric($row["obt_theory_mark"])) {
                        $total_mark_lang_I = $row["obt_lab_mark"];
                        $first_lag_result = "FAIL";
                      } else if (!is_numeric($row["obt_lab_mark"])) {
                        $total_mark_lang_I = $row["obt_theory_mark"];
                        $first_lag_result = "FAIL";
                      } else if ($row["obt_theory_mark"] < 24) {
                        $first_lag_result = "FAIL";
                      } else if ($total_mark_lang_I >= 35) {
                        $first_lag_result = "PASS";
                      } else if ($total_mark_lang_I >= 30) {
                        $second_lang_mark = getMarksBySecondLang($result);
                        $lang_total = $second_lang_mark + $total_mark_lang_I;
                        if ($lang_total >= 70) {
                          $first_lag_result = "EXEMPTED";
                        } else {
                          $first_lag_result = "FAIL";
                        }
                      } else {
                        $first_lag_result = "FAIL";
                      }
                    } else {
                      $theory_mark_lang_I = (int)$row["obt_theory_mark"];
                      $lab_mark_lang_I = '';
                      $total_mark_lang_I = $row["obt_theory_mark"];
                      if ($studentMarkInfo->elective_sub == 'EXEMPTED') {
                        $total_subjects = 5;
                        $first_lag_result = "EXEMPTED";
                        $skipped_lang_I = "true";
                      } else if (!is_numeric($row["obt_theory_mark"])) {
                        $total_mark_lang_I = $row["obt_theory_mark"];
                        $first_lag_result = "FAIL";
                      } else if ($total_mark_lang_I >= 35) {
                        $first_lag_result = "PASS";
                      } else if ($total_mark_lang_I >= 30) {
                        $second_lang_mark = getMarksBySecondLang($result);
                        $lang_total = $second_lang_mark + $total_mark_lang_I;
                        if ($lang_total >= 70) {
                          $first_lag_result = "EXEMPTED";
                        } else {
                          $first_lag_result = "FAIL";
                        }
                      } else {
                        $first_lag_result = "FAIL";
                      }
                    }

                    if ($studentMarkInfo->elective_sub == 'EXEMPTED') {
                      $elective_count++;
                      $convert_number_word = "EXEMPTED";
                      $max_marks = 'EX';
                      $sub_name = "EXEMPTED";
                      array_push($dataPointsPie, array("label" => $row["name"], "y" => 0));
                    } else {
                      $sub_name = $row["name"];
                      $max_marks = '100';
                      $subject_percentage = ((int)$total_mark_lang_I / $max_marks) * 100;
                      // $convert_number_word = convert_number($total_mark_lang_I).' Only';
                      array_push($dataPointsPie, array("label" => $row["name"], "y" => $subject_percentage));
                    }
                    if ($first_lag_result == "FAIL") {
                      $display_result = "<span class='text-danger'>FAIL</span>";
                      $failed_sub_count++;
                    } else if ($first_lag_result == "PASS") {
                      $display_result = "<span class='text-success'>PASS</span>";
                    } else {
                      $display_result = "<span class='text-warning'>EXEMPTED</span>";
                    }
                    $student_mark_info .= '
                        <tr>
                          <td>' . strtoupper($sub_name) . '</td>
                          <td class="text-center">' . $max_marks . '</td>
                          <td class="text-center">' . $total_mark_lang_I . '</td>
                          <th class="text-center">' . $total_mark_lang_I . '</th>
                          <td class="text-center">' . $display_result . '</td>
                        </tr>';
                  }
                }

                foreach ($result as $row) {
                  if ($row["subject_code"] == '02') {
                    $total_mark_lang_II = $row["obt_theory_mark"];
                    $lab_mark_lang_II = '';
                    if ($row["obt_theory_mark"] == 'EX') {
                      $total_subjects = 5;
                      $second_lag_result = "EXEMPTED";
                      $skipped_lang_II = "true";
                    } else if (!is_numeric($row["obt_theory_mark"])) {
                      $total_mark_lang_II = $row["obt_theory_mark"];
                      $second_lag_result = "FAIL";
                    } else if ($total_mark_lang_II >= 35) {
                      $second_lag_result = "PASS";
                    } else if ($total_mark_lang_II >= 30) {
                      $total_language_mark = $total_mark_lang_II + $total_mark_lang_I;
                      if ($total_language_mark >= 70) {
                        $second_lag_result = "EXEMPTED";
                      } else {
                        $second_lag_result = "FAIL";
                      }
                    } else {
                      $second_lag_result = "FAIL";
                    }
                    if ($skipped_lang_II == "true") {
                      $convert_number_word = "EXEMPTED";
                      $max_marks = 'EX';
                      array_push($dataPointsPie, array("label" => $row["name"], "y" => 0));
                    } else {
                      $max_marks = '100';
                      // $convert_number_word = convert_number($total_mark_lang_II).' Only';
                      $subject_percentage = ($total_mark_lang_II / $max_marks) * 100;
                      array_push($dataPointsPie, array("label" => $row["name"], "y" => $subject_percentage));
                    }
                    if ($second_lag_result == "FAIL") {
                      $failed_sub_count++;
                      $display_result = "<span class='text-danger'>FAIL</span>";
                    } else if ($second_lag_result == "PASS") {
                      $display_result = "<span class='text-success'>PASS</span>";
                    } else {
                      $display_result = "<span class='text-warning'>EXEMPTED</span>";
                    }
                    $student_mark_info .= '
                        <tr>
                        <td>' . strtoupper($row["name"]) . '</td>
                        <td class="text-center">' . $max_marks . '</td>
                        <td class="text-center">' . $total_mark_lang_II . '</td>
                     
                        <th class="text-center">' . $total_mark_lang_II . '</th>
                        <td class="text-center">' . $display_result . '</td>
                        </tr>';
                  }
                }
                //subjects optionals
                foreach ($result as $row) {
                  if ($row["subject_code"] == $subjects_code[0]) {
                    if ($row["lab_status"] == 'true') {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = (int)$row["obt_lab_mark"];
                      $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                      if (!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_lab_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($row["obt_theory_mark"] < 21) {
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    } else {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = '';
                      $subject_total = $row["obt_theory_mark"];
                      if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    }
                    $subject_percentage = ($subject_total / 100) * 100;
                    array_push($dataPointsPie, array("label" => $row["name"], "y" => $subject_percentage));
                    $subject_1_result = $subject_result;
                    if ($subject_result == "FAIL") {
                      $failed_sub_count++;
                      $display_result = "<span class='text-danger'>FAIL</span>";
                    } else if ($subject_result == "PASS") {
                      $display_result = "<span class='text-success'>PASS</span>";
                    } else {
                      $display_result = "<span class='text-warning'>EXEMPTED</span>";
                    }
                    $student_mark_info .= '
                                <tr>
                                <td>' . strtoupper($row["name"]) . '</td>
                                <td class="text-center">100</td>
                                <td class="text-center">' . $subject_total . '</td>
                               
                                <th class="text-center">' . $subject_total . '</th>
                                <td class="text-center">' . $display_result . '</td>
                                </tr>';
                  }
                }

                foreach ($result as $row) {
                  if ($row["subject_code"] == $subjects_code[1]) {
                    if ($row["lab_status"] == 'true') {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = (int)$row["obt_lab_mark"];
                      $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                      if (!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_lab_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($row["obt_theory_mark"] < 21) {
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    } else {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = '';
                      $subject_total = $row["obt_theory_mark"];
                      if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    }
                    $subject_percentage = ($subject_total / 100) * 100;
                    array_push($dataPointsPie, array("label" => $row["name"], "y" => $subject_percentage));
                    $subject_2_result = $subject_result;
                    if ($subject_result == "FAIL") {
                      $failed_sub_count++;
                      $display_result = "<span class='text-danger'>FAIL</span>";
                    } else if ($subject_result == "PASS") {
                      $display_result = "<span class='text-success'>PASS</span>";
                    } else {
                      $display_result = "<span class='text-warning'>EXEMPTED</span>";
                    }
                    $student_mark_info .= '
                                        <tr>
                                        <td>' . strtoupper($row["name"]) . '</td>
                                        <td class="text-center">100</td>
                                      
                                        <td class="text-center">' . $subject_total . '</td>
                                        <th class="text-center">' . $subject_total . '</th>
                                        <td class="text-center">' . $display_result . '</td>
                                        </tr>';
                  }
                }

                foreach ($result as $row) {

                  if ($row["subject_code"] == $subjects_code[2]) {
                    if ($row["lab_status"] == 'true') {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = (int)$row["obt_lab_mark"];
                      $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                      if (!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_lab_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($row["obt_theory_mark"] < 21) {
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    } else {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = '';
                      $subject_total = $row["obt_theory_mark"];
                      if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    }
                    $subject_percentage = ($subject_total / 100) * 100;
                    array_push($dataPointsPie, array("label" => $row["name"], "y" => $subject_percentage));
                    $subject_3_result = $subject_result;
                    if ($subject_result == "FAIL") {
                      $failed_sub_count++;
                      $display_result = "<span class='text-danger'>FAIL</span>";
                    } else if ($subject_result == "PASS") {
                      $display_result = "<span class='text-success'>PASS</span>";
                    } else {
                      $display_result = "<span class='text-warning'>EXEMPTED</span>";
                    }
                    $student_mark_info .= '
                                        <tr>
                                        <td>' . strtoupper($row["name"]) . '</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">' . $subject_total . '</td>
                                       
                                        <th class="text-center">' . $subject_total . '</th>
                                        <td class="text-center">' . $display_result . '</td>
                                        </tr>';
                  }
                }

                foreach ($result as $row) {
                  if ($row["subject_code"] == $subjects_code[3]) {
                    if ($row["lab_status"] == 'true') {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = (int)$row["obt_lab_mark"];
                      $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                      if ($student_id === "18P3128") {
                        $subject_result = "EXEMPTED";
                      } else if (!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_lab_mark"];
                        $subject_result = "FAIL";
                      } else if (!is_numeric($row["obt_lab_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($row["obt_theory_mark"] < 21) {
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    } else {
                      $theory_mark = (int)$row["obt_theory_mark"];
                      $lab_mark = '';
                      $subject_total = $row["obt_theory_mark"];
                      if (!is_numeric($row["obt_theory_mark"])) {
                        $subject_total = $row["obt_theory_mark"];
                        $subject_result = "FAIL";
                      } else if ($subject_total >= 35) {
                        $subject_result = "PASS";
                      } else if ($subject_total >= 30) {
                        if ($subject_total_mark >= 140) {
                          $subject_result = "EXEMPTED";
                        } else {
                          $subject_result = "FAIL";
                        }
                      } else {
                        $subject_result = "FAIL";
                      }
                    }
                    $subject_percentage = ($subject_total / 100) * 100;
                    array_push($dataPointsPie, array("label" => $row["name"], "y" => $subject_percentage));
                    $subject_4_result = $subject_result;
                    if ($subject_result == "FAIL") {
                      $failed_sub_count++;
                      $display_result = "<span class='text-danger'>FAIL</span>";
                    } else if ($subject_result == "PASS") {
                      $display_result = "<span class='text-success'>PASS</span>";
                    } else {
                      $display_result = "<span class='text-warning'>EXEMPTED</span>";
                    }
                    $student_mark_info .= '
                                        <tr>
                                        <td>' . strtoupper($row["name"]) . '</td>
                                        <td class="text-center">100</td>
                                        <td class="text-center">' . $subject_total . '</td>
                                      
                                        <th class="text-center">' . $subject_total . '</th>
                                        <td class="text-center">' . $display_result . '</td>
                                        </tr>';
                  }
                }
                $supplyFeePayment = '';
                $total_theory_mark = (int)$theory_total_mark + (int)$theory_mark_lang_I + (int)$total_mark_lang_II;
                $total_lab_mark = (int)$lab_total_mark + (int)$lab_mark_lang_I + (int)$lab_mark_lang_II;
                $total_marks_all_subjects = (int)$subject_total_mark + (int)$total_mark_lang_I + (int)$total_mark_lang_II;
                $_SESSION['failed_sub_count'] = $failed_sub_count;
                if ($subject_4_result == "FAIL" || $subject_3_result == "FAIL" || $subject_2_result == "FAIL" || $subject_1_result == "FAIL" || $first_lag_result == "FAIL" || $second_lag_result == "FAIL") {
                  $final_result =  '<span class="text_fail">FAIL</span>';
                  //$re_admission = '<a href="'.base_url().'viewAdmission" class="btn btn-success my-1 mx-1 float-right">Click Here for Admission to II PUC</a>';

                  $supplyFeePayment = "";
                } else {

                  $final_result = '<span class="text_pass">' . calculateResultAll($total_marks_all_subjects, $total_subjects, $elective_count) . '</span>';
                  // if(empty($paidStatus)){
                  //   $re_admission = '<a href="'.base_url().'viewAdmission" class="btn btn-success my-1 mx-1 float-right">Click Here for Admission to II PUC</a>';

                  // }else{
                  //   $re_admission = '';

                  // }

                }

                // $total_marks_words = convert_number($total_marks_all_subjects);   ++;
                if ($skipped_lang_I == "true") {
                  $max_total_marks = '500';
                  $totalPercentage = ($total_marks_all_subjects / $max_total_marks) * 100;
                } else {
                  $max_total_marks = '600';
                  $totalPercentage = ($total_marks_all_subjects / $max_total_marks) * 100;
                }
                $student_mark_info .= '
                      <tr class="card_head_dashboard">
                      <th>GRAND TOTAL</th>
                      <th class="text-center">' . $max_total_marks . '</th>
                      
                      <th class="text-center"></th>
                      <th class="text-center">' . $total_marks_all_subjects . '</th>
                      <th class="text-center"></th>
                      </tr>
                    </table>
                    <div class="row">
                      <div class="col-sm-6 col-12 my-2 pl-3">
                        <span>Final Result: ' . strtoupper($final_result) . '</span>
                      </div>
                   
                    </div>';

            ?>
                    <div class="row" >
                    <div class="col-lg-12">
                    <?php echo $student_mark_info; ?>
                    </div>
                    </div>
                   <?php } ?>
            </div>
          </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 padding_left_right_null">
          <div class="card card-small">
            <div class="card-header border-bottom card_head_dashboard">
              <h6 class="m-0 text-dark">Subject Wise Percentage - Annual Exam</h6>
            </div>
            <div class="card-body d-flex">
              <div id="chartmark" style="height: 300px; width: 100%;"></div>
                <script>
                function loadGraph() {
                  var chart = new CanvasJS.Chart("chartmark", {
                    animationEnabled: true,
                    title: {
                      text: ""
                    },
                    data: [{
                      type: "pie",
                      startAngle: 240,
                      yValueFormatString: "##0.00\"%\"",
                      indexLabel: "{label} {y}",
                      dataPoints: <?php echo json_encode($dataPointsPie); ?>
                      }]
                    });
                    chart.render();
                  }
                  <?php
                  echo "loadGraph();";
                  ?>
                
                </script>
            </div>
            <div class="card-footer pt-0 pb-1 border-top">
              <div class="row">
                <div class="col view-report">
                  <h6 class="text-dark">Total Percentage: <span class="font-weight-bold"><?php echo round($totalPercentage, 2) . '%'; ?></span></h6>
                </div>
              </div>
            </div>
          </div>
        </div> -->
  <?php } else { ?>
    <!-- <div class="col-lg-8 col-12 mb-4 padding_left_right_null">
          <div class="card card-small">
            <div class="card-header border-bottom card_head_dashboard">
              <h6 class="m-0 text-dark">FINAL EXAM 2021</h6>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive-sm">
                  <table class="table table-bordered table_info mb-0">
                      <thead class="text-center">
                          <tr class="table_row_backgrond">
                              <th>SUBJECTS</th>
                              <th>Max. Marks</th>
                              <th>Min. Marks</th>
                              <th>Marks Scored</th>
                          </tr>
                      </thead>
                      <?php
                      $dataPointsPie = array();
                      $result_subject_fail_status = false;
                      $result_fail_status = false;
                      $max_mark = 0;
                      $min_mark_pass = 0;
                      $total_mark_obtained = 0;
                      $total_max_mark = 0;
                      $total_min_mark = 0;

                      for ($i = 0; $i < count($subjectsCode); $i++) {
                        $result_display = "";
                        $result_subject_fail_status = false;
                        $subjectInfo = getSubjectInfo($con, $subjectsCode[$i]);

                        if ($subjectsCode[$i] == 12) {
                          $labStatus = 'true';
                        } else {
                          $labStatus = $subjectInfo['lab_status'];
                        }
                        if ($labStatus == 'true') {
                          if ($subjectsCode[$i] == 12) {
                            $pass_mark_theory = 25;
                            $pass_mark_lab = 10;
                            $lab_assessment = 10;
                          } else {
                            $pass_mark_theory = 21;
                            $pass_mark_lab = 14;
                            $lab_assessment = 16;
                          }
                        } else {
                          $pass_mark_theory = 35;
                          $pass_mark_lab = 0;
                          $lab_assessment = 0;
                        }


                        if ($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754') {
                          $internal_assessment = 1;
                        } else {
                          $internal_assessment = 5;
                        }
                        $max_mark = 100;
                        $min_mark_pass = 35;

                        $totalTheoryMark = $assignmentExamMarks[$subjectsCode[$i]] + $pass_mark_theory + $internal_assessment + $lab_assessment + $pass_mark_lab;

                        $subject_names = $subjectInfo['name'];
                        if (!empty($totalTheoryMark)) {
                          $finalExamMark = $totalTheoryMark;
                          if ($finalExamMark == 'AB' || $finalExamMark == 'EX' || $finalExamMark == 'MP') {
                            array_push($dataPointsPie, array("label" => $subject_names, "y" => 0));
                          } else {
                            $finalExamResult = ($finalExamMark / $max_mark) * 100;
                            array_push($dataPointsPie, array("label" => $subject_names, "y" => $finalExamResult));
                          }
                        } else {
                          array_push($dataPointsPie, array("label" => $subject_names, "y" => 0));
                        }

                        $total_max_mark += $max_mark;
                        $total_min_mark += $min_mark_pass;
                        $obtainedMark = $totalTheoryMark;
                        $total_mark_obtained += $obtainedMark;
                      ?>
                      <tr>
                          <th class="text-center">
                              <?php echo strtoupper($subject_names); ?></th>
                          <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                          </th>
                          <th class="text-center table_marks_data">
                              <?php echo $min_mark_pass; ?></th>
                       
                      </tr>
                      <?php
                      }
                      if ($total_mark_obtained != 0) {
                        $total_percentage = ($total_mark_obtained / $total_max_mark) * 100; ?>
                          <tr class="text-center table_row_backgrond">
                              <th class="total_row">Total</th>
                              <th><?php echo $total_max_mark; ?></th>
                              <th><?php echo $total_min_mark; ?></th>
                              <th><?php echo $total_mark_obtained; ?></th>
                          </tr>
                          <tr>
                              <th colspan="4">Result:
                                  <?php if ($result_fail_status == true) { ?>
                                  <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                  <?php } else { ?>
                                  <span class="text_pass"><?php echo 'PASS'; ?></span>
                                  <?php } ?></th>
                          </tr>
                        <?php } ?>
                  </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4 padding_left_right_null">
          <div class="card card-small">
            <div class="card-header border-bottom card_head_dashboard">
              <h6 class="m-0 text-dark">Subject Wise Percentage - FINAL EXAM 2021</h6>
            </div>
            <div class="card-body d-flex">
              <div id="chartmark" style="height: 300px; width: 100%;"></div>
                <script>
                function loadGraph() {
                  var chart = new CanvasJS.Chart("chartmark", {
                    animationEnabled: true,
                    title: {
                      text: ""
                    },
                    data: [{
                      type: "pie",
                      startAngle: 240,
                      yValueFormatString: "##0.00\"%\"",
                      indexLabel: "{label} {y}",
                      dataPoints: <?php echo json_encode($dataPointsPie); ?>
                      }]
                    });
                    chart.render();
                  }
                  <?php
                  echo "loadGraph();";
                  ?>
                
                </script>
            </div>
            <div class="card-footer pt-0 pb-1 border-top">
              <div class="row">
                <div class="col view-report">
                  <h6 class="text-dark">Total Percentage: <span class="font-weight-bold"><?php echo round($total_percentage, 2) . '%'; ?></span></h6>
                </div>
              </div>
            </div>
          </div>
        </div> -->
  <?php } ?>

  </div>
  <!-- End Users By Device Stats -->
  <!-- Notification Section -->
  <div class="row">
    <?php //if ($term_name == 'II PUC') { 
    ?>
    <!-- <div class="col-lg-6 col-md-6 col-12 mb-4 padding_left_right_null">
      <div class="card card-small">
        <div class="card-header border-bottom card_head_dashboard">
          <h6 class="m-0 text-dark text-center">FIRST UNIT EXAM 2022</h6>
        </div>
        <div class="card-body d-flex flex-column p-0">
          <div class="table-responsive-sm">
            <table class="table table-bordered table_info mb-0">
              <thead class="text-center">
                <tr class="table_row_backgrond">
                  <th>SUBJECTS</th>
                  <th>Max. Marks</th>
                  <th>In Figure</th>
                  <th>In Words</th>
                </tr>
              </thead>
              <?php
              $exam_status = false;
              $overall_total = 0;
              $max_mark = 0;
              $maxMark = 0;
              $subjects_code = array();
              $elective_sub = strtoupper($record->elective_sub);
              if ($elective_sub == "KANNADA") {
                array_push($subjects_code, '01');
              } else if ($elective_sub == 'HINDI') {
                array_push($subjects_code, '03');
              } else if ($elective_sub == 'FRENCH') {
                array_push($subjects_code, '12');
              } 
              
              array_push($subjects_code, '02');
              $subjects = getSubjectCodes($record->stream_name);
              $subjects_code = array_merge($subjects_code, $subjects);
              $fail_flag = false;
              $lang_total = 0;
              foreach ($subjects_code as $subject) {
                $subjectInfo = getSubjectInfo($con, $subject);
                if ($subject == 12) {
                  $labStatus = 'true';
                } else {
                  $labStatus = 'false';
                }
                $first_lang_mark = 0;
                $exam_type = array('I_UNIT_TEST');
                if ($exam_status == false) {
                  if ($subject == '01' || $subject == '03' || $subject == '12') {
                    $total_mark = 0;
                    foreach ($exam_type as $exam) {
                      $stdMarkInfo = getStudentFinalMarks($con, $record->student_id, $subject, $exam);
                      $sub_marks = 0;
                      $mark_obt = 0;
                      if ($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP') {
                        $mark_obt = $stdMarkInfo['obt_theory_mark'];
                      } else {
                        $mark_obt = $stdMarkInfo['obt_theory_mark'] + $stdMarkInfo['obt_lab_mark'];
                      }
                      $total_mark += $mark_obt;
                      $lang_total += $mark_obt;
                      $first_lang_mark = $mark_obt;
                    }
                    if ($labStatus == 'true') {
                      if ($stdMarkInfo['obt_theory_mark'] < 12) {
                        $fail_flag = true;
                      }
                      $maxMark = 35;
                    } else {
                      if ($stdMarkInfo['obt_theory_mark'] < 18) {
                        $fail_flag = true;
                      }
                      $maxMark = 50;
                    }
                    $max_mark += $maxMark;
              ?>
                    <tr>
                      <td style="padding:7px"> <?php echo $subjectInfo["name"]; ?></td>
                      <td class="text-center"><?php echo $maxMark ?></td>
                      <td class="text-center"><?php echo $mark_obt; ?></td>
                      <td><?php if ($mark_obt == 'AB') {
                            echo 'AB';
                          } else {
                            echo convert_number($mark_obt) . ' Only';
                          } ?></td>
                    </tr>
                  <?php
                    $overall_total += $mark_obt;
                  }
                }
                // else {
                //   $max_mark = 500;
                // }
                if ($subject == '02') {
                  $total_mark = 0;
                  foreach ($exam_type as $exam) {
                    $stdMarkInfo = getStudentFinalMarks($con, $record->student_id, $subject, $exam);
                    $sub_marks = 0;
                    $mark_obt = 0;
                    if ($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' || $stdMarkInfo['obt_theory_mark'] ==  'ASGN') {
                      $mark_obt = $stdMarkInfo['obt_theory_mark'];
                    } else {
                      $mark_obt = $stdMarkInfo['obt_theory_mark'];
                    }
                    $second_lang_mark = $mark_obt;
                    $total_mark += $mark_obt;
                    $lang_total += $mark_obt;
                  }
                  if ($mark_obt < 18) {
                    $fail_flag = true;
                  }
                  $maxMark = 50;
                  $max_mark += $maxMark;
                  ?>
                  <tr>
                    <td style="padding:7px"><?php echo $subjectInfo["name"]; ?></td>
                    <td class="text-center"><?php echo $maxMark ?></td>
                    <td class="text-center"><?php echo $mark_obt; ?></td>
                    <td><?php
                        if ($mark_obt == 'AB') {
                          echo 'AB';
                        } else {
                          echo convert_number($mark_obt) . ' Only';
                        } ?></td>
                  </tr>
              <?php
                  $overall_total += $mark_obt;
                }
              }
              ?>
              <?php
              $subject_total = array();
              $i = 0;
              $total_mark = 0;
              foreach ($subjects as $sub_code) {
                $subjectInfo = getSubjectInfo($con, $sub_code);
                $exam_type = array('I_UNIT_TEST');
                $labStatus = $subjectInfo['lab_status'];
                $mark_display = "";
                foreach ($exam_type as $exam) {
                  $stdMarkInfo = getStudentFinalMarks($con, $record->student_id, $sub_code, $exam);
                  $mark_obt_lab = 0;
                  $sub_marks = 0;
                  $mark_obt = 0;
                  if ($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' || $stdMarkInfo['obt_theory_mark'] ==  'ASGN') {
                    $mark_obt = $stdMarkInfo['obt_theory_mark'];
                    $mark_display =  $stdMarkInfo['obt_theory_mark'];
                  } else {
                    $mark_obt = $stdMarkInfo['obt_theory_mark'];
                  }
                  if ($labStatus == 'true') {
                    if ($mark_obt < 12) {
                      $fail_flag = true;
                    }
                    $maxMark = 35;
                  } else {
                    if ($mark_obt < 18) {
                      $fail_flag = true;
                    }
                    $maxMark = 50;
                  }
                  $max_mark += $maxMark;
                  if ($stdMarkInfo['obt_lab_mark'] == 'AB' || $stdMarkInfo['obt_lab_mark'] == 'EXEM' || $stdMarkInfo['obt_lab_mark'] == 'MP' || $stdMarkInfo['obt_lab_mark'] ==  'ASGN') {
                    $mark_obt_lab = $stdMarkInfo['obt_theory_mark'];
                  } else {
                    $mark_obt_lab = $stdMarkInfo['obt_lab_mark'];
                  }
                  $total_mark_sub = $mark_obt_lab + $mark_obt;
                  // if ($total_mark_sub < 35) {
                  //   $fail_flag = true;
                  // }
                  $total_mark += $mark_obt_lab + $mark_obt;
                  $subject_total[$i] = $total_mark_sub;
                  $i++;
                }
              ?>
                <tr>
                  <td style="padding:7px"><?php echo $subjectInfo["name"]; ?></td>
                  <td class="text-center"><?php echo $maxMark ?></td>
                  <td class="text-center"><?php
                                          if ($mark_display == 'AB') {
                                            echo $mark_display;
                                          } else {
                                            echo $total_mark_sub;
                                          }
                                          ?></td>
                  <td><?php
                      if ($mark_display == 'AB') {
                        echo 'AB';
                      } else {
                        echo convert_number($total_mark_sub) . ' Only';
                      }
                      ?></td>
                </tr>
              <?php
              }
              $overall_total += $total_mark;
              if ($fail_flag == true) {
                // if ($total_mark >= 140) {
                //   if ($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30) {
                //     $final_result =  calculateResult($overall_total, $max_mark);
                //     if ($lang_total >= 70) {
                //       if ($first_lang_mark >= 30 && $second_lang_mark >= 30) {
                //         $final_result =  calculateResult($overall_total, $max_mark);
                //       }
                //     }
                //   } else {
                $final_result = "FAILED";
                //   }
                // }
              } else {
                $final_result = 'PASS';
                // $final_result =  calculateResult($overall_total, $max_mark);
              }
              $total_marks_words = convert_number($overall_total); ?>
              <tr>
                <th>GRAND TOTAL</th>
                <th class="text-center"><?php echo $max_mark; ?></th>
                <th class="text-center"><?php echo $overall_total; ?></th>
                <td><?php echo $total_marks_words . ' Only'; ?></td>
              </tr>
              <tr class="text-left" style="font-size: 16px;">
                <td colspan="3" style="padding:7px !important;text-align: left!important;" class="text-left">Total Marks in words:<b><?php echo $total_marks_words . ' Only'; ?>
                  </b></td>
                <td style="">Result: <b class="text-center"><?php echo strtoupper($final_result); ?></b>
                </td>
                 <td></td> 
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div> -->
    <?php //} 
    ?>
    <!-- <div class="col-lg-6 col-md-6 col-12 mb-4 padding_left_right_null">
      <div class="card card-small">
        <div class="card-header border-bottom card_head_dashboard">
          <h6 class="mb-0 text-dark">Today's Announcement</h6>
          <i onclick="window.location.reload();" title="Refresh" class="fa fa-refresh float-right icon_refresh text-dark" aria-hidden="true"></i>
        </div>
        <div class="card-body p-0">
          <?php
          if (!empty($onlineClassInfo)) { ?>
            <h5>Microsoft Teams Login Info</h5>
            <h6>
              USERNAME: <b id="username"><?php echo $onlineClassInfo->username; ?></b>
              <br>
              PASSWORD: <b><?php echo $onlineClassInfo->password; ?></b></br>
            </h6>

          <?php }
          ?>

          <?php
          if (!empty($notificationMsg)) {
            foreach ($notificationMsg as $notification) {
          ?>
              <li class="list-group-item d-flex px-3 notification_info">
                <span class="text-semibold text-dark" style="font-weight:500"><?php echo $notification->message; ?></span>
                <!-- <span class="ml-auto text-right text-fiord-blue text-semibold" style="font-weight:600">Date</span> 
              </li>
            <?php }
          } else { ?>
            <li class="list-group-item d-flex">
              <span class="text-semibold text-dark mx-auto" style="font-weight:500">Today No
                Announcement</span>
            </li>
          <?php } ?>
          </ul>
        </div>
      </div>
    </div> -->
    <!-- End Top Notification Section -->
    <!-- New Feedback Component -->
    <div class="col-lg-6 col-md-6 col-12 mt-1 mb-2 padding_left_right_null">
        <div class="card card-small p-0">
            <div class="card-header border-bottom card_head_dashboard">
                <h6 class="m-0 text-dark">News Feed</h6>
            </div>
     <div class="card-body p-0">
                <ul class="list-group list-group-small list-group-flush">
                    <li class="list-group-item p-0" id="newsFeed_section">
                        <!-- <span class="text-semibold text-dark" style="font-weight:500"></span> -->                        
                        <?php if(!empty($newsInfo)){
                            $segmentID = 0;
                            foreach($newsInfo as $count=>$news){ 
                            if(fmod($count,7) == 0){ 
                                $segmentID++;
                            }
                            ?> 
                            <div class="card news_card mb-2 p-1 newsFeedSegmentID_<?=$segmentID;?>">
                                <div class="row px-1">
                                    <div class="col-6">
                                        <b class="float-left"><?php echo date('h:i A', strtotime($news->date)); ?></b>
                                    </div>
                                    <div class="col-6">
                                        <b class="float-right"><?php echo date('d-m-Y', strtotime($news->date)); ?></b>
                                    </div>
                                </div>
                                <hr class="mx-1 mt-1 mb-0">                                
                                <?php if(!empty($news->photo_url)){
                                        $tempImgs = ['png','jpeg','jpg'];
                                        $ext = strtolower(pathinfo($news->photo_url, PATHINFO_EXTENSION));
                                        if(in_array($ext,$tempImgs)){   ?>
                                            <div class="news_header">
                                                <img src="<?php echo ADMIN_PATH; ?><?php echo $news->photo_url;?>" alt="News Feed" height="130" class="w-100" />
                                            </div>
                                            <div class="card-header px-2 py-1">
                                                <h6 class="news_title mb-0"><?php echo  $news->subject; ?></h6>
                                            </div>
                                        <?php }else{?>
                                            <div class="card-header px-2 py-1">
                                                <h6 class="news_title mb-0"><?php echo  $news->subject; ?> <a style="font-size:15px;" class="pl-2" target="_blank" href="<?php echo ADMIN_PATH; ?><?php echo $news->photo_url?>">view document</a></h6>
                                            </div>
                                       <?php }
                                } ?>
                                <div class="card-body news_body px-2 py-1">
                                    <span><?php echo $news->description; ?></span>
                                </div>
                                
                                <div class="card-footer px-2 py-1 float-right">
                                    <span class="p-2">
                                        <i data-toggle="tooltip" data-placement="top" title="<?php
                                                echo ($news->isLiked == 0) ? "Like" : "Dislike";
                                            ?>" class="fas fa-thumbs-up like_btn" style="color:<?php 
                                        if($news->isLiked == 0){
                                            echo 'grey;cursor: pointer;';
                                        }else{
                                            echo "blue;cursor: pointer;";
                                        }                                            
                                        ?>" onclick="like(this)" data-liked="<?=$news->isLiked;?>" data-row_id="<?=$news->row_id;?>"></i> 
                                        <span class="pl-2" style="font-size:17px;font-weight:bold;"><span class='totalLikes'><?=$news->totalLikes;?></span></span> Likes
                                    </span>
                                </div>
                                
                            </div>
                        <?php } }else{ ?>
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

    <div class="col-lg-6 col-md-6 col-12 mb-4 padding_left_right_null">
      <!-- Quick Post -->
      <div class="card card-small">
        <div class="card-header border-bottom card_head_dashboard">
          <h6 class="m-0 text-dark">Your Suggestion</h6>
        </div>
        <div class="card-body d-flex flex-column">
          <div id="msg"></div>
          <form class="quick-post-form" id="feedbackForm" method="post">
            <div class="form-group">
              <select class="form-control" id="sel1" name="sel1" required>
                <option value="Select">Select</option>
                <option value="Parent">From Parent</option>
                <option value="Student">From Student</option>
              </select>
            </div>
            <!-- <div class="form-group">
              <input type="text" class="form-control" id="subject" name="subject" aria-describedby="emailHelp" placeholder="Subject" autocomplete="off" required> 
            </div> -->
            <div class="form-group">
              <textarea class="form-control" id="message" name="message" placeholder="Any Message..." autocomplete="off" required></textarea>
            </div>
            <div class="form-group mb-0">
              <button type="button" id="" onclick="sendMessage()" class="btn btn-accent">Send
                Message</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Quick Post -->

      
    </div>
    
  </div>
  


  
  <!-- End New Feedback Component -->
  <!-- Discussions Component -->
  <!-- <div class="col-lg-4 col-md-12 col-sm-12 mb-4 padding_left_right_null">
      <div class="card card-small blog-comments">
        <div class="card-header border-bottom">
          <h6 class="m-0">Study Materials</h6>
        </div>
        <div class="card-body p-0">
          <div class="blog-comments__item d-flex p-3">
            <div class="blog-comments__avatar mr-3">
              <img src="assets/dist/img/pdf.png" alt="Pdf" />
            </div>
            <div class="blog-comments__content">
              <div class="blog-comments__meta text-muted">
                <a class="text-secondary" href="#">James Johnson</a> on
                <a class="text-secondary" href="#">Hello World!</a>
                <span class="text-muted">– 3 days ago</span>
              </div>
              <p class="m-0 my-1 mb-2 text-muted">Well, the way they make shows is, they make one show ...</p>
              <div class="blog-comments__actions">
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-white">
                    <span class="text-success">
                      <i class="material-icons">file_download</i>
                    </span> Download </button>
                  <button type="button" class="btn btn-white">
                    <span class="text-danger">
                      <i class="fas fa-eye"></i>
                    </span> View </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer border-top">
          <div class="row">
            <div class="col text-center view-report">
              <button type="submit" class="btn btn-white">View All Comments</button>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  <!-- End Discussions Component -->

  <!-- Model End -->
</div>


<!-- The Modal -->
<div class="modal fade show" id="myModal" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header card_head_dashboard">
        <h5 class="modal-title">Update Family Info</h5>
        <i data-toggle="modal" data-target="#exampleModal" style="font-size: 33px;color: blue;" class="fa fa-question-circle fa-5 pull-right"></i>
      </div>
      <div class="modal-body">
        <form style="color: black;" action="<?php echo base_url(); ?>updateFamilyInfo" method="post" role="form" id="studentFamilyform">
          <table class="table  table-responsive">
            <thead class="text-center">
              <tr style="background:#78bf83;">
                <th>Name</th>
                <th>Relation</th>
                <th width="80">Age</th>
                <th>Annual Income</th>
              </tr>
            </thead>
            <tr>
              <td>
                <?php echo $studentInfo->father_name; ?>
              </td>
              <td class="text-center">
                Father
              </td>
              <td class="text-center">
                <?php echo $studentInfo->father_age; ?>
                </th>
              <td>
                <div class="form-group">
                  <input placeholder="Father's Annual Income" type="text" class="form-control required" id="fatherAnnualIncome" name="fatherAnnualIncome" maxlength="12" autocomplete="off" onkeypress="return isNumber(event)" required>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $studentInfo->mother_name; ?>
              </td>
              <td class="text-center">
                Mother
              </td>
              <td class="text-center">
                <?php echo $studentInfo->mother_age; ?>
              </td>
              <td>
                <div class="form-group">
                  <input placeholder="Mother's Annual Income" type="text" class="form-control required" id="motherAnnualIncome" name="motherAnnualIncome" maxlength="10" autocomplete="off" required>
                </div>
              </td>
            </tr>
            <?php for ($sib = 1; $sib <= 4; $sib++) { ?>
              <tr>
                <td>
                  <div class="form-group">
                    <input placeholder="<?php echo $sib; ?> Sibling's Name" type="text" class="form-control required" id="siblingName" name="siblingName[]" maxlength="128" autocomplete="off" onkeypress="return onlyAlphabets(event,this);">
                  </div>
                </td>
                <td class="text-center">
                  <div class="form-group">
                    <select class="form-control" id="sibling3" name="siblingRel[]">
                      <option>Select Relation</option>
                      <option value="Brother">Brother</option>
                      <option value="Sister">Sister</option>
                    </select>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input placeholder="Age" type="number" class="form-control required" id="siblingAgeThree" name="siblingAge[]" maxlength="3" autocomplete="off" onkeypress="return isNumber(event)">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input placeholder="Sibling's Annual Income" type="text" class="form-control required" id="SiblingAnnualIncomeThree" name="siblingIncome[]" maxlength="128" autocomplete="off" onkeypress="return isNumber(event)">
                  </div>
                </td>
              </tr>
            <?php } ?>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="studentFamilyform" class="btn btn-success">Update</button>
        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>
<?php
function getStudentFinalMarks($con, $student_id, $subjects_code, $exam_type)
{
  $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
  WHERE exam.student_id = '$student_id' AND exam.subject_code = '$subjects_code'  AND exam.exam_year = '2022-23'
  AND exam.exam_type = '$exam_type' AND exam.is_deleted = 0";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}
function getSubjectCodes($stream_name)
{
  //science
  $PCMB = array("33", "34", "35", '36');
  $PCMC = array("33", "34", "35", '41');
  $PCME = array("33", "34", "35", '40');
  $PCMS = array("33", "34", "35", '31');

  //commarce
  $PEBA = array("29", "22", "27", '30');
  $MEBA = array("75", "22", "27", '30');
  $MSBA = array("75", "31", "27", '30');
  $CSBA = array("41", "31", "27", '30');
  $SEBA = array("31", "22", "27", '30');
  $CEBA = array("41", "22", "27", '30');
  $BEBA = array("75", "22", "27", '30');

  //art
  $HEPS = array("21", "22", "29", '28');
  $HEPP = array("21", "22", "32", '29');
  switch ($stream_name) {
    case "PCMB":
      return  $PCMB;
      break;
    case "PCMC":
      return $PCMC;
      break;
    case "PEBA":
      return $PEBA;
      break;
    case "PCME":
      return $PCME;
      break;
    case "MEBA":
      return $MEBA;
      break;
    case "MSBA":
      return $MSBA;
      break;
    case "CSBA":
      return $CSBA;
      break;
    case "SEBA":
      return $SEBA;
      break;
    case "CEBA":
      return $CEBA;
      break;
    case "HEPS":
      return $HEPS;
      break;
    case "PCMS":
    return $PCMS;
    break;
    case "BEBA":
    return $BEBA;
    break;
     case "HEPP":
    return $HEPP;
    break;
  }
}
function calculateResultAll($percentage, $total_subjects, $elective)
{
  if ($elective > 1) {
    $percentage = floor(($percentage / 500) * 100);
  } else {
    $percentage = floor(($percentage / 600) * 100);
  }

  if ($percentage >= 85) {
    return "Distinction";
  } else if ($percentage >= 60 && $percentage <= 84) {
    return "First Class";
  } else if ($percentage >= 50 && $percentage <= 59) {
    return "Second Class";
  } else if ($percentage >= 35 && $percentage <= 49) {
    return "Third Class";
  }
}

function getMarksBySecondLang($result)
{
  foreach ($result as $row) {
    if ($row["subject_code"] == '02') {
      return $total_mark_lang_II = $row["obt_theory_mark"];
    }
  }
}
function getSubjectTotal($result, $subjects)
{
  $subject_total = 0;
  foreach ($result as $row) {
    for ($i = 0; $i < 4; $i++) {
      if ($row["subject_code"] == $subjects[$i]) {
        $subject_total += (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
      }
    }
  }
  return $subject_total;
}
function getTheoryTotal($result, $subjects)
{
  $theory_total = 0;
  foreach ($result as $row) {
    for ($i = 0; $i < 4; $i++) {
      if ($row["subject_code"] == $subjects[$i]) {
        $theory_total += (int)$row["obt_theory_mark"];
      }
    }
  }
  return $theory_total;
}
function getLabTotal($result, $subjects)
{
  $lab_total = 0;
  foreach ($result as $row) {
    for ($i = 0; $i < 4; $i++) {
      if ($row["subject_code"] == $subjects[$i]) {
        $lab_total += (int)$row["obt_lab_mark"];
      }
    }
  }
  return $lab_total;
}
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Microsoft Teams Login Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if (!empty($onlineClassInfo)) { ?>
          <ul>
            <li>USERNAME: <b id=""><?php echo $onlineClassInfo->username; ?></b>
            </li>
            <li>PASSWORD: <?php echo $onlineClassInfo->password; ?></li>
          </ul>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="feeRemainderModel" tabindex="-1" role="dialog" aria-labelledby="feeRemainderModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feeRemainderModelLabel">Fee Payment Alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-red">
          Fee Payment due by 15-01-2021
        </h4>
        <?php
        if ($term_name == 'II PUC') {
          $url = base_url() . 'viewAdmission_I_PUC';
        } else {
          $url = base_url() . 'viewAdmission';
        }
        if ($pending_fee_amt == 'NOT_PAID') { ?>
          <a href="<?php echo $url; ?>" class="btn btn-success btn-block">CLICK HERE TO PAY YOUR BALANCE
            AMOUNT</a>
        <?php } else { ?>
          <form action="" method="post">
            <div class="card-body" style="padding:5px;">
              <div class="row">
                <div style="font-size: 22px; color:white" class="col-12 col-lg-6">
                  Pending Fee Amount:
                </div>
                <div style="font-size: 22px; color:white" class="col-12 col-lg-4">
                  <b>Rs. <?php echo $pending_fee_amt; ?></b>
                </div>
              </div>
              <input class="form-control mobile-width" value="<?php echo $pending_fee_amt; ?>" type="hidden" id="name" name="amount" autocomplete="off">
            </div>
          </form>
          <a href="<?php echo $url; ?>" class="btn btn-success btn-block">CLICK HERE TO PAY YOUR BALANCE
            AMOUNT</a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if (!empty($onlineClassInfo)) {
  // echo "<script>var statusUpdate = 0;</script>";
} ?>
<script>
  var pending_fee_amt = '<?php echo $pending_fee_amt; ?>';
  $(window).on("load", function() {
    setTimeout(function() {
      $(".loader").hide();
    }, 500);
    if (pending_fee_amt != 0 || pending_fee_amt == 'NOT_PAID') {
      //$('#feeRemainderModel').modal('show');
    }
  });

  function showLessNewsFeed(){
    if(localStorage.getItem("NFSID") !=null){
        let curSegmentID = parseInt(localStorage.getItem("NFSID"));
        if(curSegmentID != 1){
        $(".newsFeedSegmentID_"+curSegmentID).hide();
        localStorage.setItem("NFSID",curSegmentID-1);
        }
    }
}
function loadMoreNewsFeed(){
    let nextSegmentID = 1;
    if(localStorage.getItem("NFSID") !=null){
        nextSegmentID = parseInt(localStorage.getItem("NFSID")) + 1;
    }
    if($(".newsFeedSegmentID_"+nextSegmentID).length ==0){
        alert("There is no more news feeds to load..");
    }else{
        localStorage.setItem("NFSID",nextSegmentID);
        $(".newsFeedSegmentID_"+nextSegmentID).show();
    }
}
  function sendMessage() {
    $('#msg').html('');
    var subject = $("#sel1 option:selected").val();
    var message = $("#message").val();
    if (subject == "Select") {
      $('#msg').html(`<div class="alert alert-danger" role="alert">
         Please Select Option
         <button id="usernameButton type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      </div>`);
    } else if (message == "") {
      $('#msg').html(`<div class="alert alert-danger" role="alert">
         Please Enter Message
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      </div>`);
    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>/sendFeedbackToManagement',
        type: 'POST',
        // dataType:'json',
        data: {
          subject: subject,
          message: message
        },
        success: function(data) {
          $('#msg').html(`<div class="alert alert-success" role="alert">
          ` + data + `
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      </div>`);
        },
        error: function(result) {
          alert("Server Error!!  Failed");
        },
        fail: (function(status) {
          alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
          // $("#staffInfoDownload").prop('disabled', true);
        }
      });
    }
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#uploadedImage1').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#uploadedImage2').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#vImg1").change(function() {
    readURL(this);
  });
  $("#vImg2").change(function() {
    readURL2(this);
  });

  function onlyAlphabets(e, t) {
    return (e.charCode > 64 && e.charCode < 91) || (e.charCode > 96 && e.charCode < 123) || e.charCode == 32;
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
</script>

<?php
function getSubjectInfo($con, $subject_id)
{
  $query = "SELECT * FROM tbl_subjects as sub
    WHERE sub.subject_code = '$subject_id' AND sub.is_deleted = 0";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}
function calculateResult($total_marks, $max_mak)
{
  $percentage = floor(($total_marks / $max_mak) * 100);
  if ($percentage >= 85) {
    return "Distinction";
  } else if ($percentage >= 60 && $percentage <= 84) {
    return "I Class";
  } else if ($percentage >= 50 && $percentage <= 59) {
    return "II Class";
  } else if ($percentage >= 35 && $percentage <= 49) {
    return "III Class";
  } else {
    return "PROMOTED";
  }
}

function calculatePercentage($percentage)
{
  return floor(($percentage / 600) * 100);
}



function convert_number($number)
{
  if (($number < 0) || ($number > 999999999)) {
    throw new Exception("Number is out of range");
  }
  $Gn = floor($number / 1000000);
  /* Millions (giga) */
  $number -= $Gn * 1000000;
  $kn = floor($number / 1000);
  /* Thousands (kilo) */
  $number -= $kn * 1000;
  $Hn = floor($number / 100);
  /* Hundreds (hecto) */
  $number -= $Hn * 100;
  $Dn = floor($number / 10);
  /* Tens (deca) */
  $n = $number % 10;
  /* Ones */
  $res = "";
  if ($Gn) {
    $res .= convert_number($Gn) .  "Million";
  }
  if ($kn) {
    $res .= (empty($res) ? "" : " ") . convert_number($kn) . " Thousand";
  }
  if ($Hn) {
    $res .= (empty($res) ? "" : " ") . convert_number($Hn) . " Hundred";
  }
  $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
  $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");
  if ($Dn || $n) {
    if (!empty($res)) {
      $res .= " ";
    }
    if ($Dn < 2) {
      $res .= $ones[$Dn * 10 + $n];
    } else {
      $res .= $tens[$Dn];
      if ($n) {
        $res .= "-" . $ones[$n];
      }
    }
  }
  if (empty($res)) {
    $res = "Zero";
  }
  return $res;
}

?>