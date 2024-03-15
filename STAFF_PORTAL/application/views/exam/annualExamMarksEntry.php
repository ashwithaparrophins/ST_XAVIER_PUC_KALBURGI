<?php
 require APPPATH . 'views/includes/db.php'; 

            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
        ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php  
            $success = $this->session->flashdata('success');
            if($success)
            {
        ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>

<?php  
            $noMatch = $this->session->flashdata('nomatch');
            if($noMatch)
            {
        ?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('nomatch'); ?>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}

.loaderScreen {
    display: block;
    visibility: visible;
    position: absolute;
    z-index: 999;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #0a0a0a94;
    vertical-align: bottom;
    padding-top: 20%;
    filter: alpha(opacity=75);
    opacity: 0.75;
    font-size: large;
    color: blue;
    font-style: italic;
    font-weight: 400;

    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
</style>
<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-6">
                            <span class="page-title count_heading">
                                <i class="material-icons">mode_edit</i> Add Annual Exam Mark
                            </span>
                        </div>
                        <div class="col-6">
                            <a onclick="window.history.back();"
                                class="btn primary_color mobile-btn float-right border_left_radius text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php if($role == EXAM_COMMITTEE || $role == ROLE_DIRECTOR || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == CAMPUS_MINISTER) { ?>
                              <!--   <button style="float:right" type="button" data-toggle="modal" data-target="#myDownloadModal"
                                class="btn btn-md btn-primary border_right_radius"> Download Marks Sheet</button> -->
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <form role="form" action="<?php echo base_url(); ?>getStudentForAnnualMark" method="POST" id="byFilterMethod">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-12">
                            <select required name="term_name" id="term_name" class="form-control" data-live-search="true">
                                <?php if(!empty($term_name)){ ?>
                                    <option value="<?php echo $term_name; ?>">Selected: I PUC</option>
                                <?php } ?>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <!-- <option value="II PUC">Supplementary</option> -->

                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <select required name="section_row_id" id="streamName" class="form-control stream_name" data-live-search="true">
                                <?php if(!empty($section_row_id)){ ?>
                                    <option value="<?php echo $section_row_id; ?>">Selected: <?php echo $stream_name.' - '.$section_name; ?></option>
                                <?php } ?>
                                <option value="">Select Stream & Section</option>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-12">
                            <select id="staff_subject_row_id" name="staff_subject_row_id" class="form-control selectpicker" data-live-search="true" required>
                                <?php if(!empty($sub_name)){ ?>
                                <?php } ?>
                                <option value="">Select Subject</option>
                                <?php foreach($staffSubjectInfo as $sub){
                                    if($sub->subject_type == 'THEORY'){
                                        if($subject_row_id == $sub->row_id){ ?>
                                            <option value="<?php echo $sub->row_id; ?>" selected> Selected:
                                                <?php echo $sub_name.'->'.$staff_name; ?>
                                            </option>
                                        <?php }  ?>
                                        <option value="<?php echo $sub->row_id; ?>">
                                            <?php echo strtoupper($sub->sub_name.'->'.(string)$sub->staff_name); ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <select id="exam_type" name="exam_type" class="form-control" data-live-search="true" required>
                                <?php if(!empty($exam_type)){ ?>
                                    <option value="<?php echo $exam_type; ?>" selected> Selected:
                                        <?php echo str_replace('_',' ',$exam_type); ?>
                                    </option>
                                <?php } ?>
                                <option value="">Select Exam</option>
                                <option value="ANNUAL_EXAMINATION">ANNUAL_EXAMINATION</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <button type="submit" id="searchButton" class="btn btn-success btn-block">
                                Search</button>
                        </div>
                    </div>
                </form>
                <hr class="mt-1 mb-1">
                <div class="table-responsive-sm">
                    <?php if(!empty($subject->subject_code)){ ?>
                    <div class="row pb-2">
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Stream:
                                <b><?php echo $stream_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Section:
                                <b><?php echo $section_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Subject: <b><?php echo $subject->sub_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Total Students:
                                <b><?php echo count($studentsInfo); ?><b></b></span>
                        </div>
                    </div>
                    <?php } ?>
                    <form action="<?php echo base_url(); ?>addStudentAnnualMarkByStaff" method="POST" id="addInternalMarK">
                        <?php 
                            $labStatus = 'false';
                            $pass_count = 0;
                            $just_pass_count = 0;
                            $fail_count = 0;
                            $absent_count = 0;
                            $exampted_count = 0;
                            $total_distiction_students = 0;
                            $total_first_class_students = 0;
                            $total_second_class_students = 0;

                            if($exam_type == 'I_UNIT_TEST' ||$exam_type == 'II_UNIT_TEST'){
                                if(!empty($subject->subject_code)){ 
                                    if($subject->subject_code == 12){
                                        $max_lab_mark = 8;
                                        $min_mark_pass = 18;
                                        $max_mark_theory = 50;
                                        $labStatus = false;
                                    } else if($subject->lab_status == 'true'){
                                        $max_lab_mark = 8;
                                        $min_mark_pass = 12;
                                        $max_mark_theory = 35;
                                        $labStatus = $subject->lab_status;
                                    } else {
                                        $min_mark_pass = 18;
                                        $max_mark_theory = 50;
                                        $labStatus = $subject->lab_status;
                                    } 
                                }
                            }else if($exam_type == 'I_PREPARATORY' && $term_name == 'II PUC'){
                                
                               /*  if($subject->subject_code == 12){
                                    $max_lab_mark = 20;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 80;
                                    $labStatus = 'true';
                                } else */ 
                                if($subject->lab_status == 'true' && $subject->subject_code != 12){
                                    $max_lab_mark = 30;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 70;
                                    $labStatus = $subject->lab_status;
                                } else {
                                    $min_mark_pass = 35;
                                    $max_mark_theory = 100;
                                    $labStatus = false;
                                } 
                            }else if($exam_type == 'MID_TERM'){
                                
                              /*  if($subject->subject_code == 12){
                                    $max_lab_mark = 20;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 80;
                                    $labStatus = 'true';
                                } else */ 
                                if($subject->lab_status == 'true'){
                                    $max_lab_mark = 30;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 70;
                                    $labStatus = $subject->lab_status;
                                } else {
                                    $min_mark_pass = 35;
                                    $max_mark_theory = 100;
                                    $labStatus = false;
                                } 
                            }else if($exam_type == 'SUPPLEMENTARY'){
                                
                                if($subject->subject_code == 12){
                                    $max_lab_mark = 20;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 80;
                                    $labStatus = 'true';
                                } else if($subject->lab_status == 'true'){
                                    $max_lab_mark = 30;
                                    $min_mark_pass = 21;
                                    $max_mark_theory = 70;
                                    $labStatus = $subject->lab_status;
                                } else {
                                    $min_mark_pass = 35;
                                    $max_mark_theory = 100;
                                    $labStatus = false;
                                } 
                            }else if($exam_type == 'ANNUAL_EXAMINATION'){
                                
                                if($subject->subject_code == 12){
                                    $max_lab_mark = 20;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 80;
                                    $labStatus = 'true';
                                } else if($subject->lab_status == 'true'){
                                    $max_lab_mark = 30;
                                    $min_mark_pass = 21;
                                    $max_mark_theory = 70;
                                    $labStatus = $subject->lab_status;
                                    $labStatus = 'true';
                                } else {
                                    $max_lab_mark = 20;
                                    $min_mark_pass = 24;
                                    $max_mark_theory = 80;
                                    $labStatus = false;
                                } 
                            }else if($exam_type == 'II_ASSIGNMENT'){
                                
                                if($subject->subject_code == 12){
                                    $max_lab_mark = 20;
                                    $min_mark_pass = 0;
                                    $max_mark_theory = 10;
                                    // $labStatus = 'true';
                                    $labStatus = false;
                                } else if($subject->lab_status == 'true'){
                                    $max_lab_mark = 30;
                                    $min_mark_pass = 0;
                                    $max_mark_theory = 10;
                                    $labStatus = false;
                                    // $labStatus = $subject->lab_status;
                                } else {
                                    $min_mark_pass = 0;
                                    $max_mark_theory = 10;
                                    $labStatus = false;
                                } 
        
                            }else{
                                if(!empty($subject->subject_code)){ 
                                    // if($subject->subject_code == 12){
                                    //     $max_lab_mark = 20;
                                    //     $min_mark_pass = 35;
                                    //     $max_mark_theory = 100;
                                    //     $labStatus = 'true';
                                    // } else if($subject->lab_status == true){
                                    //     $max_lab_mark = 10;
                                    //     $min_mark_pass = 35;
                                    //     $max_mark_theory = 100;
                                    //     $labStatus = $subject->lab_status;
                                    // } else {
                                    //     $min_mark_pass = 35;
                                    //     $max_mark_theory = 100;
                                    //     $labStatus = $subject->lab_status;
                                    // } 

                                    if($subject->subject_code == 12){
                                        $max_lab_mark = 20;
                                        $min_mark_pass = 24;
                                        $max_mark_theory = 80;
                                        $labStatus = true;
                                    } else if($subject->lab_status == true){
                                        $max_lab_mark = 30;
                                        $min_mark_pass = 21;
                                        $max_mark_theory = 70;
                                        $labStatus = true;
                                    } else {
                                        $min_mark_pass = 35;
                                        $max_mark_theory = 100;
                                        $labStatus = false;
                                    } 
                                   
                                  
                                }
                            }
                            // $pass_class_min = 35;
                            // $pass_class_max = 49;
                            // $second_class_min_mark = 50;
                            // $second_class_max_mark = 59;
                            // $first_class_min_mark = 60;
                            // $first_class_max_mark = 84;
                            // $dest_min_mark = 85;
                            // $dest_max_mark = 100;
                            $pass_class_min = 35;
                            $pass_class_max = 49;
                            $second_class_min_mark = 50;
                            $second_class_max_mark = 59;
                            $first_class_min_mark = 60;
                            $first_class_max_mark = 84;
                            $dest_min_mark = 85;
                            $dest_max_mark = 100;
                        ?>
                        <table class="table table-bordered text-dark tblnavigate">
                            <thead class="text-center">
                                <tr class="table_row_background">
                                    <!-- <th width="130">Register No.</th> -->
                                    <th width="100">Student ID</th>
                                    <th>Name</th>
                                    <th width="200">Obt Theory Mark</th>
                                     <?php if($labStatus == 'true'){ ?>
                                    <th width="200">Obt Lab Mark</th>
                                    <?php 
                                     }else{ 
                                     ?>
                                    <th width="200">Obt Internal Mark</th>
                                    <?php } ?>
                                    <th width="200">Actions</th>
                                    <th>Total</th>
                                    <th>Result</th>
                            </thead>
                            <tbody class ="table_view_student_list">
                                <?php
                                    $update_byutton_active = false;
                                    if(!empty($studentsInfo)){
                                        $count_pass_students = 0;
                                        $count_fail_students = 0;
                                        $count_malparactice_students = 0;
                                        $count_absent_students = 0;
                                        $count_examption_students = 0;
                                        $second_class_count = 0;
                                        $distinction_count = 0;
                                        $first_class_count = 0;
                                        $third_class_count = 0;
                                        $pass_class_count = 0;
                                        $count_attendance_shortage = 0;
                                        $update_byutton_active = false;
                                        $hidden_verified_status = 0;
                                        ?>
                                <input type="hidden" value="<?php echo $term_name; ?>" name="term_name" />
                                <input type="hidden" value="<?php echo $section_name; ?>" name="section_name" />
                                <input type="hidden" value="<?php echo $labStatus; ?>" id="lab_status" />
                                <input type="hidden" value="<?php echo $subject_code; ?>" name="subject_id" />
                                <input type="hidden" value="<?php echo $stream_name; ?>" name="stream_name" />
                                <input type="hidden" value="<?php echo $section_row_id; ?>" name="section_row_id" />
                                <input type="hidden" value="<?php echo $exam_type; ?>" name="exam_type" />


                                <input type="hidden" value="<?php echo $staff_subject_row_id; ?>" name="staff_subject_row_id" />
                                <input type="hidden" value="<?php echo $max_mark_theory; ?>" id="max_theory_mark" />
                                <input type="hidden" value="<?php echo $max_lab_mark; ?>" id="max_lab_mark" />
                                <input type="hidden" value="<?php echo $min_mark_pass; ?>" id="min_mark_pass" />
                                <input type="hidden" value="0" id="staff_updated_status" name="staff_updated_status" />
                                
                                <?php foreach($studentsInfo as $record) { ?>
                                <tr>
                                    <td class="text-center admission_no_td"><?php echo $record->student_id; ?></td>
                                    <td class="student_name_td"><?php echo $record->student_name; ?></td>
                                    <?php
                                            $mark_status = false;
                                            $update_mark_status = false;
                                            $total_mark = 0;
                                            if(!empty($studentMarkInfo)){ 
                                                foreach($studentMarkInfo as $mark){
                                                    $student_id = trim($mark->student_id);
                                                        $mark_obt_theory = trim($mark->obt_theory_mark);
                                                        $lab_mark_obt = trim($mark->obt_lab_mark);?>

                                      <td class="obt_theory_mark_td">
                                           <input value="<?php echo $mark_obt_theory;  ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="5"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="obt_theory_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Theory Mark" type="text"
                                            name="obt_theory_mark_<?php echo $student_id; ?>" autocomplete="off" required />
                                    </td>

                                    <?php 
                                    if($labStatus == true){ 
                                        if(is_numeric($lab_mark_obt) && !empty($lab_mark_obt)) {
                                          $total_mark = $lab_mark_obt + $mark_obt_theory;
                                          }else{
                                                $total_mark = $mark_obt_theory;
                                             } 
                                          
                                            ?>
                                   <td>
                                        <input value="<?php echo $lab_mark_obt; ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="4"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="lab_obt_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Lab Mark" type="text"
                                            name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                    </td>
                                    <?php 
                                      } else{
                                                $total_mark = $mark_obt_theory;
                                             } 
                                            ?>

                                    <td class="action_td"> <select onchange="actionTaken('<?php echo $student_id; ?>')"
                                            class="form-control input-sm mark_col_width"
                                            id="other_action_<?php echo $student_id; ?>" name="other_action">
                                            <option value="">No Action</option>
                                            <option value="AB">Absent</option>
                                            <!-- <option value="EXEM">Exemption</option> -->
                                            <option value="MP">Malpractice</option>
                                            <option value="SAT">Shortage of Attendance</option>
                                        </select></td>

                                    <td id="get_total_mark_<?php echo $student_id; ?>"><b
                                            style="color:black"><?php echo $total_mark; ?></b> </td>
                                    <td id="result_<?php echo $student_id; ?>">
                                        <?php 
                                                if($mark_obt_theory == 'AB' || $mark_obt_theory == 'EXEM' || $mark_obt_theory == 'MP' || $mark_obt_theory == 'SAT'){
                                                    echo '<b style="color:red">'.$mark_obt_theory.'</b>';
                                                    if($mark_obt_theory == 'AB'){
                                                        $count_absent_students++;
                                                    } else if ($mark_obt_theory == 'EXEM'){
                                                        $count_examption_students++;
                                                    } else if($mark_obt_theory == 'MP'){
                                                        $count_malparactice_students++;
                                                    }else if($mark_obt_theory == 'SAT'){
                                                        $count_attendance_shortage++;
                                                    }
                                                } else if($mark_obt_theory == ""){
                                                    echo '<b style="color:red">Pending</b>';
                                                } else if($mark_obt_theory < $min_mark_pass){
                                                    $count_fail_students++;
                                                    echo '<b style="color:red">FAIL</b>';
                                                 } else if($mark_obt_theory == "AB"){
                                                    echo '<b style="color:red">FAIL</b>';
                                                } else if($mark_obt_theory == 'AB' && $lab_mark_obt=='AB'){
                                                    echo '<b style="color:red">AB</b>';
                                                } else if($total_mark < 35) {
                                                  $count_fail_students++;
                                                   echo '<b style="color:red">FAIL</b>';
                                                } 
                                                else {
                                                    if($total_mark >= $dest_min_mark){
                                                        $distinction_count++;
                                                    } else if($total_mark >= $first_class_min_mark && $total_mark <= $first_class_max_mark){
                                                        $first_class_count++;
                                                    }else  if($total_mark >= $second_class_min_mark && $total_mark <= $second_class_max_mark){
                                                        $second_class_count++;
                                                    } else {
                                                        $pass_class_count++;
                                                    }
                                                    $count_pass_students++;
                                                    echo '<b style="color:green">PASS</b>';
                                                } ?>
                                    </td>
                                </tr>
                                <?php $update_byutton_active = true;
                                        break;
                                   
                                    }
                                    } else { 
                                       
                                    $mark_status = true;
                                    $student_id = trim($record->student_id);

                                    $markExist = isMarkAlreadyAdded($con,$student_id,$subject_code,$exam_type);
                                    if(!empty($markExist)){
                                        $mark_obt_theory = trim($markExist['obt_theory_mark']);
                                        $lab_mark_obt = trim($markExist['obt_lab_mark']);
                                        $total_mark = $mark_obt_theory + $lab_mark_obt;
                                    }else{
                                        $mark_obt_theory = "";
                                        $lab_mark_obt = "";
                                        $total_mark = "";
                                    }
                                    if($markExist['staff_updated_status'] == 1){
                                        $is_verified = true;
                                        $hidden_verified_status = 1;
                                    }
                                    ?> 
                                    <input type="hidden" id="hidden_verified_status" value="<?php echo $hidden_verified_status; ?>">

                                    <input type="hidden" id="hidden_mark" value="<?php echo $mark_obt_theory ?>">
                                    <input type="hidden" id="hidden_staff_id" value="<?php echo $staff_id ?>">
                                    <td class="obt_theory_mark_td">
                                    <input style="font-size: 15px;font-weight: 700 !important;" 
                                        onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                        value="<?php echo $mark_obt_theory; ?>" onkeypress="return isNumberKey(event)"
                                        id="obt_theory_mark_<?php echo $student_id; ?>"
                                        class="form-control input-sm numberonly mark_col_width mark_readonly"
                                        placeholder="Enter Theory Mark" type="text" maxlength="5" 
                                        name="obt_theory_mark_<?php echo $student_id; ?>" autocomplete="off" required/>
                                </td>
                                <?php
                                 if($labStatus == 'true'){
                                     if(is_numeric($lab_mark_obt) && !empty($lab_mark_obt)) {
                                    $total_mark = $lab_mark_obt + $mark_obt_theory;
                                          }else{
                                                $total_mark = $mark_obt_theory;
                                            } 
                                            ?>  
                                 <td class="obt_lab_mark_td">
                                        <input value="<?php echo $lab_mark_obt; ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="4"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="lab_obt_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width mark_readonly"
                                            placeholder="Enter Lab Mark" type="text"
                                            name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" required/>
                                    </td> 
                                    <?php 
                               } else{
                                if(is_numeric($lab_mark_obt) && !empty($lab_mark_obt)) {
                                    $total_mark = $lab_mark_obt + $mark_obt_theory;
                                          }else{
                                                $total_mark = $mark_obt_theory;
                                            } ?>
                                               <td class="obt_lab_mark_td">
                                        <input value="<?php echo $lab_mark_obt; ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="4"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="lab_obt_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width mark_readonly"
                                            placeholder="Enter Internal Mark" type="text"
                                            name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" required/>
                                    </td> 
                                          <?php  }
                                             ?>
                              
                                <td>
                                    <select onchange="actionTaken('<?php echo $student_id; ?>')"
                                        class="form-control input-sm mark_col_width mark_readonly"
                                        id="other_action_<?php echo $student_id; ?>" name="other_action">
                                        <option value="">No Action</option>
                                        <option value="AB-LAB">Absent-<?php if($labStatus == 'true'){ ?>LAB<?php }else{ ?>INTERNAL<?php } ?></option>
                                        <option value="AB-THEORY">Absent-THEORY</option>
                                        <!-- <option value="EXEM">Exemption</option> -->
                                        <option value="MP-LAB">Malpractice-<?php if($labStatus == 'true'){ ?>LAB<?php }else{ ?>INTERNAL<?php } ?></option>
                                        <option value="MP-THEORY">Malpractice-THEORY</option>
                                        <option value="SAT-LAB">Shortage of Attendance-<?php if($labStatus == 'true'){ ?>LAB<?php }else{ ?>INTERNAL<?php } ?></option>
                                        <option value="SAT-THEORY">Shortage of Attendance-THEORY</option>
                                    </select>
                                </td>
                                <td id="get_total_mark_<?php echo $student_id; ?>"><?php echo $total_mark; ?>  </td>
                                <td id="result_<?php echo $student_id; ?>">
                                    <span style="color:red;">
                                    <?php 
                                    if($subject->subject_code == 12){
                                        if($mark_obt_theory >= 24 && $total_mark >= 35){
                                            $pass_count++;
                                           echo "<b style='color:green'>PASS</b>";
                                            if($total_mark >= $dest_min_mark){
                                                $distinction_count++;
                                            } else if($total_mark >= $first_class_min_mark && $total_mark <= $first_class_max_mark){
                                                $first_class_count++;
                                            }else  if($total_mark >= $second_class_min_mark && $total_mark <= $second_class_max_mark){
                                                $second_class_count++;
                                            }else{
                                                $just_pass_count++;
                                            }
                                          }else if($mark_obt_theory == 'AB' && $lab_mark_obt=='AB'){
                                           $absent_count++;
                                           echo "<b style='color:orange'>AB</b>";
                                          }else if($mark_obt_theory == "AB"){
                                            $fail_count++;
                                            echo "<b style='color:red'>FAIL</b>"; 
                                          }else if($mark_obt_theory == "SA"){
                                            echo "<b style='color:orange'>SA</b>"; 
                                          }else if($mark_obt_theory == "EXEM"){
                                            $exampted_count++;
                                            echo "<b style='color:orange'>EXEM</b>"; 
                                          } else if($mark_obt_theory != ""){
                                            echo "<b style='color:red'>FAIL</b>"; 
                                            $fail_count++;
                                        }else {
                                            echo "<b style='color:orange'>Pending</b>"; 
                                        }   
                                    }else if($labStatus == 'true'){
                                        if($total_mark >= 35 && $mark_obt_theory >= 21 && $lab_mark_obt != 'MP'){
                                            $pass_count++;
                                           echo "<b style='color:green'>PASS</b>";
                                            if($total_mark >= $dest_min_mark){
                                                $distinction_count++;
                                            } else if($total_mark >= $first_class_min_mark && $total_mark <= $first_class_max_mark){
                                                $first_class_count++;
                                            }else  if($total_mark >= $second_class_min_mark && $total_mark <= $second_class_max_mark){
                                                $second_class_count++;
                                            }else{
                                                $just_pass_count++;
                                            }
                                          }else if($mark_obt_theory == 'AB' && $lab_mark_obt=='AB'){
                                           $absent_count++;
                                           echo "<b style='color:orange'>AB</b>";
                                          }else if($mark_obt_theory == "AB"){
                                            $fail_count++;
                                            echo "<b style='color:red'>FAIL</b>"; 
                                          }else if($mark_obt_theory == "SA"){
                                            echo "<b style='color:orange'>SA</b>"; 
                                          }else if($mark_obt_theory == "EXEM"){
                                            $exampted_count++;
                                            echo "<b style='color:orange'>EXEM</b>"; 
                                          } else if($mark_obt_theory != ""){
                                            echo "<b style='color:red'>FAIL</b>"; 
                                            $fail_count++;
                                        }else {
                                            echo "<b style='color:orange'>Pending</b>"; 
                                        }   

                                    }else{

                                        if($total_mark >= 35 && $mark_obt_theory >= 24 && $lab_mark_obt != 'MP'){
                                            $pass_count++;
                                          echo "<b style='color:green'>PASS</b>";
                                            if($total_mark >= $dest_min_mark){
                                                $distinction_count++;
                                            } else if($total_mark >= $first_class_min_mark && $total_mark <= $first_class_max_mark){
                                                $first_class_count++;
                                            }else  if($total_mark >= $second_class_min_mark && $total_mark <= $second_class_max_mark){
                                                $second_class_count++;
                                            }else{
                                                $just_pass_count++;
                                            } 
                                          }else if($mark_obt_theory == 'AB' && $lab_mark_obt=='AB'){
                                           $absent_count++;
                                           echo "<b style='color:orange'>AB</b>";
                                          }else if($mark_obt_theory == "AB"){
                                            $fail_count++;
                                            echo "<b style='color:red'>FAIL</b>"; 
                                          }else if($mark_obt_theory == "SA"){
                                            echo "<b style='color:orange'>SA</b>"; 
                                          }else if($mark_obt_theory == "EXEM"){
                                            $exampted_count++;
                                            echo "<b style='color:orange'>EXEM</b>"; 
                                          } else if($mark_obt_theory != ""){
                                            echo "<b style='color:red'>FAIL</b>"; 
                                            $fail_count++;
                                        }else {
                                            echo "<b style='color:orange'>Pending</b>"; 
                                        }   
                                    

                                    }
                                    
                                   
                                      
                                     ?>
                                    </span>
                                </td>
                                <?php } ?>
                                </tr>
                                <?php } } else { ?>
                                <td colspan="7" class="alert alert-info text-center">
                                    <strong>To Enter mark, Search through above options!</strong>
                                </td>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <?php if(!empty($studentsInfo)){
                            if($staff_id != '123456'){
                             if($is_verified == false){ ?>
                            <div class="row">
                        <div class="col-5">
                            <button type="button" class="btn btn-danger form-submit-btn mb-1 btn-block">Final Submit</button>
                        </div>
                        <div class="col-5">
                            <button type="submit" id="submitMark" class="btn btn-success  mb-1 btn-block">SAVE</button>
                        </div>
                        </div>
                        <?php }else{
                            echo "<b style='color:red;margin-left:400px'>Selected exam mark is already verified</b>";
                        }
                    } else { ?>
                            <div class="row">
                        <div class="col-5">
                            <button type="button" class="btn btn-danger form-submit-btn mb-1 btn-block">Final Submit</button>
                        </div>
                        <div class="col-5">
                            <button type="submit" id="submitMark" class="btn btn-success  mb-1 btn-block">SAVE</button>
                        </div>
                        </div>
                        <?php }
                        } ?>
                        <!-- <div class="col-4">
                            <button type="button" class="btn btn-danger form-submit-btn mb-1 btn-block">Final Submit</button>
                        </div> -->
                        </form>
                        <!-- <div class="row">
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-primary btn-md" id="submitMark" type="submit">Submit</button>
                            </div>
                        </div> -->
                        <!-- <?php if($update_byutton_active == true) { ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <button data-toggle="modal" data-target="#analyzeModal"
                                    type="button" class="btn btn-md btn-primary float-left">Analyze Section</button>
                            </div>
                            <div class="col-lg-6 ">
                                <button class="btn btn-success btn-md float-right" id="submitMark"
                                    type="submit">Update</button>
                            </div>
                            <?php if($update_mark_status == true){ ?>
                            <?php } ?>
                        </div>
                        <?php } ?> -->
                    
                           <?php if(!empty($studentsInfo)){
                                ?>
                        <div class="row text-center mt-2" style="font-size: 20px;">
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                Total: <b><?php echo count($studentsInfo); ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                PASS: <b style="color:green;"><?php echo $pass_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                FAIL: <b style="color:red;"><?php echo $fail_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                ABSENT: <b style="color:red;"><?php echo $absent_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                PASS CLASS: <b style="color:green;"><?php echo $just_pass_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                FIRST CLASS: <b style="color:green;"><?php echo $first_class_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                SECOND CLASS: <b style="color:green;"><?php echo $second_class_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                DISTINCTION: <b style="color:green;"><?php echo $distinction_count; ?></b>
                            </div>
                        </div>
                        <?php } ?>
                  
                    <!-- <div class="row">
                        <div class="col-4">
                            <button class="btn btn-danger form-submit-btn mb-1 btn-block">Final Submit</button>
                        </div>
                            </div> -->
                </div>
            </div>
        </div>
    </div>

   

    <!-- analyze Modal -->
    <div id="analyzeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background: #58c64c;">
                    <h4 class="modal-title">Overall Analyze</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="danger">
                                    <td>Total Students</td>
                                    <td><b><?php echo count($studentsInfo); ?></b></td>
                                </tr>
                                <tr class="warning">
                                    <td>Exemption</td>
                                    <td id="exemption"><b
                                            style="color:red;"><?php echo $count_examption_students; ?></b>
                                    </td>
                                </tr>
                                <tr class="warning">
                                    <td>Absent</td>
                                    <td id="absent"><b style="color:red;"><?php echo $count_absent_students; ?></b></td>
                                </tr>
                                <tr class="warning">
                                    <td>Malpractice</td>
                                    <td id="malpractice"><b
                                            style="color:red;"><?php echo $count_malparactice_students; ?></b></td>
                                </tr>
                                <tr class="warning">
                                    <td>Attendance Shortage</td>
                                    <td id="attendance"><b
                                            style="color:red;"><?php echo $count_attendance_shortage; ?></b></td>
                                </tr>
                                <tr class="success">
                                    <td>Distinction</td>
                                    <td id="distinction"><?php echo $distinction_count; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>I Class</td>
                                    <td id="first_class"><?php echo $first_class_count; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>II Class</td>
                                    <td id="second_class"><?php echo $second_class_count; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Pass Class</td>
                                    <td id="third_class"><?php echo $pass_class_count; ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Pass</td>
                                    <td id="pass_students"><b
                                            style="color:green;"><?php echo $count_pass_students; ?></b>
                                    </td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Fail</td>
                                    <td id="failed_students"><b
                                            style="color:red;"><?php echo $count_fail_students; ?></b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


</div>


<!-- excel Download Modal -->
<div id="myDownloadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Marks Sheet</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Term</label>
                            <select class="form-control required" id="termName" name="term_name">
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Stream</label>
                            <select class="form-control required" id="stream_name_id" required>
                                                <option value="PCMB">PCMB</option>
                                                <option value="PCMC">PCMC</option>
                                                <option value="PCME">PCME</option>
                                                <option value="PCMS">PCMS</option>
                                                <option value="BEBA">BEBA</option>
                                                <option value="BSBA">BSBA</option>
                                                <option value="CSBA">CSBA</option>
                                                <option value="SEBA">SEBA</option>
                                                <option value="CEBA">CEBA</option>
                                                <option value="PEBA">PEBA</option>
                                                <option value="HEPP">HEPP</option>
                                                <option value="MEBA">MEBA</option>
                                                <option value="MSBA">MSBA</option>
                                                <option value="HEPS">HEPS</option>
                                               
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Section</label>
                            <select class="form-control required" id="type" name="type">
                                <option value="ALL">ALL</option>
                                <!-- <option value="ALL">ALL</option> -->
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
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Exam</label>
                            <select class="form-control required" id="examType" name="examType">
                                <option value="">Select Exam</option>
                                <option value="I_UNIT_TEST">I UNIT TEST</option>
                                <option value="II_UNIT_TEST">II UNIT TEST</option>
                               <!--  <?php if($role == EXAM_COMMITTEE) { ?>
                                <option value="ANNUAL_EXAMINATION">ANNUAL EXAMINATION</option>
                                <?php }else{ ?>
                                <option value="ANNUAL_EXAMINATION">ANNUAL EXAMINATION</option>
                                 <option value="I_PREPARATORY">I PREPARATORY</option>
                                 <?php } ?> -->
                                <!-- <option value="I_UNIT_TEST">I UNIT TEST</option> -->
                                <option value="MID_TERM">MID TERM</option> 
                                <option value="I_PREPARATORY">PREPARATORY</option> 
                                 <!--<option value="II_ASSIGNMENT">II ASSIGNMENT</option>
                                <option value="I_TERM">I TERM</option>
                                <option value="II_PREPARATORY">II PREPARATORY</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Report Type</label>
                            <select class="form-control required" id="report_type" name="report_type">
                                <!-- <option value="">Select Report Type</option> -->
                                <option value="ALL">ALL</option>
                                <option value="only_failed">Only Failed</option>
                                <!-- <option value="only_distinction">Only Distinction</option> -->
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="role">Select Download Type</label>
                    <select class="form-control required" id="type" name="type">
                        <option value="All">All Students</option>
                    </select>
                </div> -->

            </div>
            <div class="modal-footer">
                <span id="loader"></span>
                <button type="submit" onclick="downloadExcelSheet();" id="downloadAllMarks"
                    class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable " role="document">
            <div class="modal-content dynamic_width">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 text-center"
                    style="
                        height: 450px;
                        overflow: auto;
                    "
                >
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Student Id</th>
                                <th>Name</th>
                                <th>Theory Mark</th>
                                <?php if($labStatus == "true"){ ?>
                                <th>Lab Mark</th>
                                <?php }else{ ?>
                                <th>Internal Mark</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="confirmationTblBody">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmationBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

<?php
function isMarkAlreadyAdded($con,$student_id,$subject_id,$exam_type){
    $query = "SELECT * FROM tbl_college_internal_exam_marks as mark 
    WHERE mark.student_id = '$student_id' AND mark.subject_code = '$subject_id' 
    AND mark.exam_type = '$exam_type' AND mark.is_deleted = 0 AND mark.exam_year = '2023-24'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}
?>
<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
var term_name = 'I';


jQuery(document).ready(function() {
    var hidden_mark = $("#hidden_mark").val();
    var hidden_staff_id = $("#hidden_staff_id").val();
    var hidden_verified_status = $("#hidden_verified_status").val();

    if(hidden_staff_id!= "123456"){
     if(hidden_mark!= "" && hidden_verified_status == 1){
       $(".mark_readonly").prop('readonly', true);
       $('.mark_readonly').prop('disabled', true);
     }
    }

    var term = $("#term_name").val();
    var stream = $(".stream_name").val();
    var staf_rowId = $("#staff_subject_row_id").val();
    var examType = $("#exam_type").val();

    $("#confirmationBtn").click(()=>{
        $('#staff_updated_status').val('1');
        $("#addInternalMarK").submit();
    });

    $(".form-save-btn").click(()=>{
        // $('#staff_updated_status').val('1');
        $("#addInternalMarK").submit();
    });

    $('#streamName').prop('disabled', 'disabled');
    if(stream != ''){
        $('#streamName').prop('required', true); 
        $('#streamName').prop('disabled', false);
        $('.loaderScreen').hide();
    }

    $('.loaderScreen').hide();
    // $('select').selectpicker();
    $(".numberonly").focus(function() {
        $(this).attr("type", "number")
    });
    $(".numberonly").blur(function() {
        $(this).attr("type", "text")
    });

    $("#submitMark").submit(function(e) {
        e.preventDefault();
    });
    

    $("#submitMark,#searchButton").click(function() {
        if(term == ''){
            $('.loaderScreen').hide();
        } else if(examType == ''){
            $('.loaderScreen').hide();
        } else if(stream == ''){
            $('.loaderScreen').hide();
        } else if(staf_rowId == ''){
            $('.loaderScreen').hide();
        } else if ($('#streamName').prop("disabled") == true) {
        } else{
            $('.loaderScreen').show();
        }
    });


    $(".form-submit-btn").on('click', ()=>{
        let confirmTrs = "";
        var lab_status = $('#lab_status').val();
        var requiredMark = 'mark';
        $(".table_view_student_list > tr").each((tind,  ele)=>{
            let tempAdmissionNo = $(ele).find('td.admission_no_td').html();
            let tempStdName = $(ele).find('td.student_name_td').html();
            // let tempMark = $(ele).find('td.obt_theory_mark_td > input').val();
            let tempAction = $(ele).find('td.action_td > select').val();
               
                  let tempMarkVal = $(ele).find('td.obt_theory_mark_td > input').val();
                    let tempLabMarkVal = $(ele).find('td.obt_lab_mark_td > input').val();
                  
                //   var tempMark = tempMarkVal;
        
            // tempMark = (tempAction != "") ?  tempAction : tempMark;
           
            // tempMark = tempMark || "PENDING";
            if(lab_status == "true"){
            if(tempMarkVal == '' || tempLabMarkVal == ''){
                requiredMark = '';
            }
          }else{
            if(tempMarkVal == '' || tempLabMarkVal == ''){
                requiredMark = '';
            }
          }

            if(lab_status == "true"){
            confirmTrs += `<tr><td>${tempAdmissionNo}</td><td>${tempStdName}</td><td>${tempMarkVal}</td><td>${tempLabMarkVal}</td></tr>`;
            }else{
                confirmTrs += `<tr><td>${tempAdmissionNo}</td><td>${tempStdName}</td><td>${tempMarkVal}</td><td>${tempLabMarkVal}</td></tr>`;  
            }
        });
        if(requiredMark == ''){
            alert('Please enter all marks');
        }else {
        $("#confirmationTblBody").html(confirmTrs);
        $("#confirmationModal").modal('show');
        }
    });
    
    // $("#submitMark").click(function() {
    //     var isValid = true;
    //     $('#addInternalMarK input[type=text]').each(function(i,e) {
    //         if(e.value == '') {
    //             $('.loaderScreen').hide();
    //         }else{
    //             $('.loaderScreen').show();
    //         }
    //     });
    // });
    
    $(function() {
        $('#attendanceDate').datepicker({
            autoclose: true,
            endDate: "today",
            format: 'dd-mm-yyyy',
        });
    });

    $("#term_name").change(function(){
        var term_name = $("#term_name").val()
        $('#streamName').prop('disabled', false);
        $('#streamName option:not(:first)').remove();
        $('#streamName option:selected').remove();
        $('#streamName').append('<option value="">Select Stream & Section</option>');
        // $('#exam_type option:selected').remove();
        if(term_name == 'II PUC'){
            $('#exam_type_two').show();
        }else{
            $('#exam_type_two').hide();
        }
        if(this.value != 0){
            $('#streamName').prop('disabled', false);
            $('#streamName option:not(:first)').remove();
            $.ajax({
            url: '<?php echo base_url(); ?>/getStreamSectionByTerm',
            type: 'POST',
            dataType: "json",
            data: { term_name : term_name },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                if(count != 0){
                    for(var i=0; i<=count; i++){
                        $("#streamName").append(new Option(data.result[i].stream_name +' - '+ data.result[i].section_name, data.result[i].row_id));
                    }
                }else{
                    $('#streamName').prop('disabled', 'disabled');
                }
            }
        });
        }else{
            $('#streamName').prop('disabled', 'disabled');
            $('#streamName option:not(:first)').remove();
            $('#streamName option:selected').remove();
            $('#streamName').append('<option value="">Select Stream & Section</option>');
            // $('#exam_type option:selected').remove();
        }
    });
});

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

function actionTaken(student_id) {
    var value = $('#other_action_' + student_id).val();
    var theory_mark = $("#obt_theory_mark_" + student_id).val();
    var lab_status = $('#lab_status').val();
    // if(lab_status == "true"){
    //     checkMark = 21;
    // }else{
    //     checkMark = 24;
    // }
    if (value != "") {
        if(value=='MP-LAB' || value=='MP-THEORY'){
            if(value == 'MP-THEORY'){
              $("#result_" + student_id).html("<b style='color:red'> FAIL </b>");
              $("#get_total_mark_" + student_id).html("<b style='color:red'> FAIL </b>");
            }else if(value == 'MP-LAB'){
                // if(theory_mark < 35){
                  $("#result_" + student_id).html("<b style='color:red'> FAIL </b>");
                  $("#get_total_mark_" + student_id).html("<b style='color:red'> FAIL </b>");
                // }
            }
        }else{
            if(value=='AB-THEORY' || value=='MP-THEORY' || value=='SAT-THEORY'){
              $("#result_" + student_id).html("<b style='color:red'>" + value.slice(0,2) + "</b>"); 
              $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value.slice(0,2) + "</b>"); 
            }else if(value=='AB-LAB' || value=='MP-LAB' || value=='SAT-LAB'){
             if(theory_mark < 35){
               $("#result_" + student_id).html("<b style='color:red'> FAIL </b>"); 
               $("#get_total_mark_" + student_id).html("<b style='color:red'> FAIL </b>"); 
              }else if(theory_mark!="AB" && theory_mark!="MP" && theory_mark!="SAT") {
                $("#result_" + student_id).html("<b style='color:green'> PASS </b>"); 
                $("#get_total_mark_" + student_id).html("<b style='color:red'> " + value.slice(0,2) + " </b>"); 
              }
            }
        }
        if(value=='AB-THEORY' || value=='MP-THEORY' || value=='SAT-THEORY'){
            $("#obt_theory_mark_" + student_id).val(value.slice(0,2));
            $("#obt_theory_mark_" + student_id).prop('readonly', false);
        }
        if(value=='AB-LAB' || value=='MP-LAB' || value=='SAT-LAB'){
           $("#lab_obt_mark_" + student_id).val(value.slice(0,2));
           $("#lab_obt_mark_" + student_id).prop('readonly', false);
        }
 
    } else {
        $("#result_" + student_id).html("<b style='color:red'>Pending</b>");
        $("#get_total_mark_" + student_id).html("<b style='color:red'>Pending</b>");
        $("#obt_theory_mark_" + student_id).val("");
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val("");
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
    }
}

function getTotalMarks(student_id) { term_name
    var fail_flag = 0;
    var exam_type = $('#exam_type').val();
    var lab_status = $('#lab_status').val();
    var term_name = $('#term_name').val(); 
    var max_theory_mark = $('#max_theory_mark').val();
    var min_mark_pass = $('#min_mark_pass').val();
    var max_lab_mark = $('#max_lab_mark').val();
    var theory_mark = $("#obt_theory_mark_" + student_id).val();
    var lab_mark = $("#lab_obt_mark_" + student_id).val();
    var labCheck = lab_mark;
    // alert(max_lab_mark);
    lab_mark = Number(lab_mark);
    theory_mark = Number(theory_mark);
    var total_mark = 0;
    if(exam_type == 'I_UNIT_TEST' || exam_type == 'II_UNIT_TEST' ){
        var min_mark_pass = min_mark_pass;
        var total_pass_mark = max_theory_mark;
    }else{
        var min_mark_pass = min_mark_pass;
        var total_pass_mark = max_theory_mark;
    }
    if (isNaN(theory_mark) && isNaN(lab_mark)) {
        total_mark = 0;
    } else if (isNaN(theory_mark)) {
        total_mark = lab_mark;
    } else if (isNaN(lab_mark)) {
        total_mark = theory_mark;
    } else {
        total_mark = theory_mark + lab_mark;
    }
    if(theory_mark > total_pass_mark){
        alert("Please enter valid Theory mark");
        $("#obt_theory_mark_" + student_id).val("");
        exit;
    }
    if(lab_status == 'true'){
        if(lab_mark > max_lab_mark){
        alert("Please enter valid Lab mark");
        $("#lab_obt_mark_" + student_id).val("");
        exit;
    }
    }else{
        if(lab_mark > max_lab_mark){
        alert("Please enter valid Lab mark");
        $("#lab_obt_mark_" + student_id).val("");
        exit;
    }  
    }
    if(lab_status == 'true'){
        if(exam_type == 'ANNUAL_EXAMINATION'){
          if (Number(max_theory_mark) == 80 && Number(max_lab_mark) == 20) {
            if (theory_mark < 24 || labCheck == "MP") {
                fail_flag = 1;
            } else if (total_mark < 35) {
                fail_flag = 1;
            } else {
                fail_flag = 0;
            }
        } else {
            if (theory_mark < 21 || labCheck == "MP" || labCheck == "SAT") {
                fail_flag = 1;
            } else if (total_mark < 35) {
                fail_flag = 1;
            } else {
                fail_flag = 0;

            }
        }
    }else{
           if (total_mark < min_mark_pass) {
            fail_flag = 1;
            } else {
            fail_flag = 0;
            } 
    }
    }else{

    if(exam_type == 'ANNUAL_EXAMINATION'){
          if (Number(max_theory_mark) == 80 && Number(max_lab_mark) == 20) {
            if (theory_mark < 24 || labCheck == "MP") {
                fail_flag = 1;
            } else if (total_mark < 35) {
                fail_flag = 1;
            } else {
                fail_flag = 0;
            }
        } else {
            if (theory_mark < 21 || labCheck == "MP" || labCheck == "SAT") {
                fail_flag = 1;
            } else if (total_mark < 35) {
                fail_flag = 1;
            } else {
                fail_flag = 0;

            }
        }
    }else{
           if (total_mark < min_mark_pass) {
            fail_flag = 1;
            } else {
            fail_flag = 0;
            } 
    }
}


    if (fail_flag == 1) {
        $("#get_total_mark_" + student_id).html("<b style='color:red'>" + total_mark + "</b>");
        $("#result_" + student_id).html("<b style='color:red'>FAIL</b>");
    } else {
        $("#get_total_mark_" + student_id).html("<b style='color:green'>" + total_mark + "</b>");
        $("#result_" + student_id).html("<b style='color:green'>PASS</b>");
    }
}


//after load student details update student marks entered or not
function downloadExcelSheet() {
    var loader = '<img height="30" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    var right_mark = '<img src="<?php echo base_url(); ?>/assets/images/right_symbol.png"/>';
    var type = $('#type :selected').val();
    var term_name = $('#termName :selected').val();
    var exam_type = $('#examType :selected').val();
    var stream_name_id = $('#stream_name_id :selected').val();
    var report_type = $('#report_type :selected').val();
    //  var section_name = $('#section_name :selected').val();
    $.ajax({
        url: '<?php echo base_url(); ?>/getInternalMarkSheet',
        type: 'POST',
        dataType: 'json',
        data: {
            type: type,
            term_name: term_name,
            exam_type: exam_type,
            stream_name_id : stream_name_id,
            report_type: report_type,
        },

        success: function(data) {
            $("#downloadAllMarks").prop('disabled', false);
            $("#loader").html(right_mark + "<span style='color:green'><b>Downloaded</b></span>");
            // var studentObj = JSON.parse(data)
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "Examination_Result_file.xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            $("#downloadAllMarks").prop('disabled', false);
            alert("Mark is not added selected section");
            $("#loader").html(
                "<span style='color:red'>Selected class section not found in mark list!!</span>");
        },
        fail: (function(status) {
            $("#downloadAllMarks").prop('disabled', false);
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            $("#downloadAllMarks").prop('disabled', true);
            $("#loader").html(loader);
        }
    });
}
</script>

<script>
var active = 2;
//$('.tblnavigate td').each(function(idx){$(this).html(idx);});
rePosition();

$(document).keydown(function(e) {
    var inp = String.fromCharCode(e.keyCode);
    if (!(/[a-zA-Z0-9-_ ]/.test(inp) || e.keyCode == 96)){
      reCalculate(e);
      rePosition();
      // if key is an arrow key, don't type the user input.
      // if it is any other key (a, b, c, etc)
      // edit the text
      if (e.keyCode > 36 && e.keyCode < 41) {
        return false;
      }
    }
});

// $('td').click(function() {
//     active = $(this).closest('table tbody').find('td').index(this);
//     rePosition();
// });


// function reCalculate(e) {
//     var rows = $('.tblnavigate tbody tr').length;
//     var columns = $('.tblnavigate tbody tr:eq(0) td').length;
//     var temp;

//     if (e.keyCode == 37) { //move left or wrap
//         temp = active;
//         while (temp > 0) {
//             temp = temp - 1;
//             // only advance if there is an input field in the td
//             if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {
//                 active = temp;
//                 break;
//             }
//         }
//     }
//     if (e.keyCode == 38) { // move up
//         temp = active;
//         while (temp - columns >= 0) {
//             temp = temp - columns;
//             // only advance if there is an input field in the td
//             if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {
//                 active = temp;
//                 break;
//             }
//         }
//     }
//     if (e.keyCode == 39) { // move right or wrap
//         temp = active;
//         while (temp < (columns * rows) - 1) {
//             temp = temp + 1;
//             // only advance if there is an input field in the td
//             if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {
//                 active = temp;
//                 break;
//             }
//         }
//     }
//     if (e.keyCode == 40) { // move down
//         temp = active;
//         while (temp + columns <= (rows * columns) - 1) {
//             temp = temp + columns;
//             // only advance if there is an input field in the td
//             if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {
//                 active = temp;
//                 break;
//             }
//         }
//     }
// }

// function rePosition() {
//     console.log(active);
//     $('.active').removeClass('active');
//     $('.tblnavigate tbody tr td').eq(active).addClass('active');
//     $('.tblnavigate tbody tr td').find('input').removeClass('textClass');
//     $('.tblnavigate tbody tr td').eq(active).find('input').addClass('textClass');
//     $('.tblnavigate tbody tr td').eq(active).find('input').select();
//     var input = $('.tblnavigate tbody tr td').eq(active).find('input').focus();
//     scrollInView();
// }

function scrollInView() {
    var target = $('.tblnavigate tbody tr td:eq(' + active + ')');
    if (target.length) {
        var top = target.offset().top;

        $('html,body').stop().animate({
            scrollTop: top - 300
        }, 400);
        return false;
    }
}
</script>