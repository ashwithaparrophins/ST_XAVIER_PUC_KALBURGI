<?php
date_default_timezone_set("Asia/Kolkata"); 
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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-6">
                            <span class="page-title count_heading">
                                <i class="material-icons">show_chart</i> Section Analytics
                            </span>
                        </div>
                        <div class="col-6">
                            <a onclick="window.history.back();"
                                class="btn primary_color mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <form role="form" action="<?php echo base_url(); ?>getSectionPeformanceAnalytics" method="POST" id="byFilterMethod">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12">
                            <select required name="term_name" id="term_name" class="form-control" data-live-search="true">
                                <?php if(!empty($term_name)){ ?>
                                    <option value="<?php echo $term_name; ?>">Selected: <?php echo $term_name; ?></option>
                                <?php } ?>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <select required name="section_row_id" id="streamName" class="form-control stream_name" data-live-search="true">
                                <?php if(!empty($section_row_id)){ ?>
                                    <option value="<?php echo $section_row_id; ?>">Selected: <?php echo $stream_name.' - '.$section_name; ?></option>
                                <?php } ?>
                                <option value="">Select Stream & Section</option>
                                <?php if(!empty($streamInfo)){ 
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->row_id; ?>">
                                            <?php echo $stream->stream_name.' - '.$stream->section_name; ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-12">
                            <select id="exam_type" name="exam_type" class="form-control" data-live-search="true" required>
                                <?php if(!empty($exam_type)){ ?>
                                    <option value="<?php echo $exam_type; ?>" selected> Selected:
                                        <?php echo str_replace('_',' ',$exam_type); ?>
                                    </option>
                                <?php } ?>
                                <option value="">Select Exam</option>
                                <option value="I_UNIT_TEST">I UNIT TEST</option>
                                <option value="MID_TERM_EXAM">MID TERM</option>                       
                                <option value="II_UNIT_TEST">II UNIT TEST</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <button type="submit" id="searchButton" class="btn btn-success btn-block">Search</button>
                        </div>
                    </div>
                </form>
                <?php if(!empty($studentInfo)){ ?>
                        <hr class="mt-1 mb-1">
                        <div class="table-responsive-sm">
                            <?php if(!empty($exam_type)){ ?>
                            <div class="row pb-2">
                                <div class="col-lg-4 col-md-4 col-6 mb-1">
                                    <span class="badge badge-pill badge-info" style="font-size: 16px;">Stream:
                                        <b><?php echo $stream_name; ?></b></span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-6 mb-1">
                                    <span class="badge badge-pill badge-info" style="font-size: 16px;">Section:
                                        <b><?php echo $section_name; ?></b></span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-6 mb-1">
                                    <span class="badge badge-pill badge-info" style="font-size: 16px;">Total Students:
                                        <b><?php echo count($studentInfo); ?><b></b></span>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        
                
                        <?php 

                            $dataPoints_Pie = array();
                            $total_pass_students = 0;
                            $total_fail_students = 0;
                            $total_distiction_students = 0;
                            $total_first_class_students = 0;
                            $total_second_class_students = 0;
                            $total_student_mark_obtained = 0;
                            $total_absented_students = 0;
                            $total_malpractice_students = 0;
                            $total_exempted_students = 0;
                            $total_student_count = 0; 
                            $subject_count = array();
                        ?>

                        <div class="card-header border-bottom card_head_dashboard settings_card mb-2" data-toggle="collapse" data-target="#studnt_mark_info"> 
                            <a class="setting_pointer">Click here to view student mark</a>
                        </div>
                        <div id="studnt_mark_info" class="collapse">
                        <table class="table table-hover table-bordered">

                            <tbody>

                                <tr class="table-primary">

                                    <th class="text-center" width="80">Stud. ID</th>
                                    <th width="230" class="text-center">Name</th>
                                    <th width="80" class="text-center">Elective</th>
                                    <th width="100" class="text-center">Elec. Mark</th>
                                    <?php 

                                    foreach($subInfo as $sub){ ?>
                                        <th><?php echo $sub->sub_name; ?></th>
                                    <?php } ?>
                                    <th width="80" class="text-center">Total</th>
                                    <th width="80" class="text-center">%</th>

                                </tr>

                            

                                <?php 

                                foreach($studentInfo as $std){ 

                                    $subject_fail_status = false;

                                    $total_marks_obtained = 0;

                                    $total_max_marks = 0;

                                    $single_subject_fail_status = false;

                                    $total_student_count++;

                                ?>

                                <tr>

                                    <th class="text-center"><?php echo $std->student_id; ?></th>

                                    <th><?php echo $std->student_name; ?></th>

                                    <th class="text-center"><?php echo $std->elective_sub; ?></th>

                                        <?php if(strtoupper($std->elective_sub) == "KANNADA"){

                                                $subjects_code_elective = '01';

                                                // static $subject_count["01"]["pass_count"] = 0;

                                            }else if(strtoupper($std->elective_sub) == 'HINDI'){

                                                $subjects_code_elective = '03';

                                                // static $subject_count["03"]["pass_count"] = 0;

                                            } else if(strtoupper($std->elective_sub) == 'FRENCH'){

                                                $subjects_code_elective = '12';

                                                // static $subject_count["12"]["pass_count"] = 0;

                                            }else{

                                                $subjects_code_elective = 'EX';

                                            }

                                            if($subjects_code_elective != 'EX'){

                                                $exam_mark = getSubjectMarkInfo($con,$subjects_code_elective,$std->student_id,$exam_type);

                                                if($exam_type != "I_UNIT_TEST" || $exam_type != "II_UNIT_TEST"){
                                                    if($subjects_code_elective == '12'){
                                                        $mark_theory_obt = $exam_mark['obt_theory_mark'];
                                                        $mark_lab_obt = $exam_mark['obt_lab_mark'];
                                                        
                                                        if($mark_theory_obt == 'AB' || $mark_theory_obt == 'EX' || $mark_theory_obt == 'MP'){
                                                            $mark_obt = $mark_theory_obt;
                                                        }else{
                                                            $mark_obt = $mark_theory_obt + $mark_lab_obt;
                                                        }
                                                    }else{
                                                        $mark_theory_obt = $exam_mark['obt_theory_mark'];
                                                        $mark_obt = $mark_theory_obt;
                                                    }
                                                }else{
                                                    $mark_theory_obt = $exam_mark['obt_theory_mark'];
                                                    $mark_obt = $mark_theory_obt;
                                                }
                                                
                                                // $mark_obt = $exam_mark['obt_theory_mark'];

                                                if($subjects_code_elective == '12'){
                                                    if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                                                        $min_mark = 14;
                                                        $max_mark = 40;
                                                    } else if($exam_type == "PREPARATORY_I"){
                                                        $min_mark = 35;
                                                        $max_mark = 100;
                                                    }
                                                    else if($exam_type == "MID_TERM_EXAM"){
                                                        $min_mark = 35;
                                                        $max_mark = 100;
                                                    }
                                                }else{
                                                    if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                                                        $min_mark = 14;
                                                        $max_mark = 40;
                                                    } else if($exam_type == "PREPARATORY_I"){
                                                        $min_mark = 35;
                                                        $max_mark = 100;
                                                    }
                                                    else if($exam_type == "MID_TERM_EXAM"){
                                                        $min_mark = 28;
                                                        $max_mark = 80;
                                                    }
                                                }
                                                

                                                $total_max_marks += $max_mark;

                                                if($mark_obt == 'AB' && $mark_obt != ''){

                                                    $subject_fail_status = true;
                                                    $single_subject_fail_status = true;

                                                    $total_absented_students++;

                                                }else if($mark_obt == 'EX' && $mark_obt != ''){

                                                    $single_subject_fail_status = true;

                                                    $total_exempted_students++;

                                                }else if($mark_obt == 'MP' && $mark_obt != ''){

                                                    $single_subject_fail_status = true;

                                                    $total_malpractice_students++;

                                                }else if($mark_theory_obt < $min_mark){

                                                    $subject_count[$subjects_code_elective]["fail_count"] += 1;

                                                    $subject_fail_status = true;

                                                    $single_subject_fail_status = true;

                                                    $total_marks_obtained += $mark_obt; 

                                                

                                                }else{

                                                    $subject_count[$subjects_code_elective]["pass_count"] += 1;

                                                    $total_marks_obtained += $mark_obt; 

                                                }

                                                if((int) $mark_obt == $mark_obt){

                                                    $percentage_sub = round(($mark_obt / $max_mark) * 100,2);

                                                    if($percentage_sub >= 85){

                                                        $subject_count[$subjects_code_elective]["dist_count"] += 1;

                                                    

                                                    } else if($percentage_sub >= 60 && $percentage_sub <= 84){

                                                        $subject_count[$subjects_code_elective]["first_count"] += 1;

                                                    

                                                    } else if($percentage_sub >= 50 && $percentage_sub <= 59){

                                                        $subject_count[$subjects_code_elective]["second_count"] += 1;

                                                    

                                                    }

                                                }

                                            

                                            

                                            ?>

                                    <th style ="<?php if($single_subject_fail_status == true){ echo 'background: #f59487'; } ?>" class="text-center"><?php echo $mark_obt; ?></th>

                                        <?php  }else{ 

                                            $total_exempted_students++; ?>

                                                <th class="text-center">EX</th>

                                        <?php  }

                                        foreach($subInfo as $sub){ ?>

                                        <?php 

                                        $single_subject_fail_status = false;

                                        if($sub->lab_status == 'true'){

                                            if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                                                $min_mark = 12;
                                                $max_mark = 35;
                                            }else if($exam_type == "PREPARATORY_I"){
                                                $min_mark = 24;
                                                $max_mark = 100;
                                            }else if($exam_type == "MID_TERM_EXAM"){
                                                $min_mark = 21;
                                                $max_mark = 70;
                                            }
                                        }else{
                                            if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                                                $min_mark = 14;
                                                $max_mark = 40;

                                            } else if($exam_type == "PREPARATORY_I"){
                                                $min_mark = 35;
                                                $max_mark = 100;
                                            }else if($exam_type == "MID_TERM_EXAM"){
                                                $min_mark = 28;
                                                $max_mark = 80;
                                            }

                                        } 

                                        $exam_mark = getSubjectMarkInfo($con,$sub->subject_code,$std->student_id,$exam_type);

                                            // $mark_theory_obt = $exam_mark['obt_theory_mark'];
                                            // $mark_lab_obt = $exam_mark['obt_lab_mark'];
                                            
                                            if($sub->lab_status == 'true'){
                                                $mark_theory_obt = $exam_mark['obt_theory_mark'];
                                                $mark_lab_obt = $exam_mark['obt_lab_mark'];
                                                
                                                if($mark_theory_obt == 'AB' || $mark_theory_obt == 'EX' || $mark_theory_obt == 'MP'){
                                                    $mark_obt = $mark_theory_obt;
                                                }else{
                                                    $mark_obt = $mark_theory_obt + $mark_lab_obt;
                                                }
                                            }else{
                                                $mark_theory_obt = $exam_mark['obt_theory_mark'];
                                                $mark_obt = $mark_theory_obt;
                                            }

                                            $total_max_marks += $max_mark;

                                            if($mark_obt == 'AB' && $mark_obt != ''){

                                                $subject_fail_status = true;
                                                $single_subject_fail_status = true;

                                                $total_absented_students++;

                                            }else if($mark_obt == 'EX' && $mark_obt != ''){

                                                $single_subject_fail_status = true;

                                                $total_exempted_students++;

                                            }else if($mark_obt == 'MP' && $mark_obt != ''){

                                                $single_subject_fail_status = true;

                                                $total_malpractice_students++;

                                            }else if($mark_theory_obt < $min_mark){

                                                $subject_fail_status = true;

                                                $single_subject_fail_status = true;

                                                $total_marks_obtained += $mark_obt; 

                                                $subject_count[$sub->subject_code]["fail_count"] += 1;

                                            }else{

                                                $subject_count[$sub->subject_code]["pass_count"] += 1;

                                                $total_marks_obtained += $mark_obt; 

                                            }

                                            if((float) $mark_obt == $mark_obt){

                                            $percentage_sub = round(($mark_obt / $max_mark) * 100,2);

                                    // log_message('debug','testing'.$percentage_sub);

                                            if($percentage_sub >= 85){

                                                $subject_count[$sub->subject_code]["dist_count"] += 1;
                                            

                                            } else if($percentage_sub >= 60 && $percentage_sub <= 84){

                                                $subject_count[$sub->subject_code]["first_count"] += 1;

                                            

                                            } else if($percentage_sub >= 50 && $percentage_sub <= 59){

                                                $subject_count[$sub->subject_code]["second_count"] += 1;

                                            

                                            }

                                        }

                                        ?>

                                    <th style ="<?php if($single_subject_fail_status == true){ echo 'background: #f59487'; } ?>" class="text-center"><?php echo $mark_obt; ?></th>

                                        <?php } 

                                        if($total_marks_obtained != 0){

                                            $percentage = ($total_marks_obtained / $total_max_marks) * 100;
                                            $percentage = round($percentage,2);
                                        }else{

                                            $percentage = 0;

                                        }

                                        

                                        if($subject_fail_status == true){

                                            $total_fail_students++;

                                        }else{

                                            $total_pass_students++;

                                            if($percentage >= 85){

                                                $total_distiction_students++;

                                            } else if($percentage >= 60 && $percentage <= 84){

                                                $total_first_class_students++;

                                            } else if($percentage >= 50 && $percentage <= 59){

                                                $total_second_class_students++;

                                            } 

                                        }

                                    

                                    

                                        ?>
                                    <th class="text-center"><?php echo $total_marks_obtained; ?></th>
                                    <th class="text-center"><?php echo $percentage.'%'; ?></th>
                                </tr>

                        <?php }
                            array_push($dataPoints_Pie, array("label"=> 'First Class', "y"=> $total_first_class_students));
                            array_push($dataPoints_Pie, array("label"=> 'FAIL', "y"=> $total_fail_students));
                            array_push($dataPoints_Pie, array("label"=> 'Second Class', "y"=> $total_second_class_students));
                            array_push($dataPoints_Pie, array("label"=> 'Distinction', "y"=> $total_distiction_students));
                        

                            array_push($dataPoints_Pie, array("label"=> 'Absent', "y"=> $total_absented_students));
                            array_push($dataPoints_Pie, array("label"=> 'Exempted', "y"=> $total_exempted_students));
                            array_push($dataPoints_Pie, array("label"=> 'Malpractice', "y"=> $total_malpractice_students));
                        ?>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr class="table-primary">
                                <th class="text-center">Subject Name</th>
                                <th class="text-center">Passed</th>
                                <th class="text-center">Failed</th>
                                <th class="text-center">Distinction</th>
                                <th class="text-center">First Class</th>
                                <th class="text-center">Second Class</th>
                            </tr>

                            <tr>
                                <th class="text-center">Kannada</th>
                                <th class="text-center"><?php echo $subject_count['01']["pass_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['01']["fail_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['01']["dist_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['01']["first_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['01']["second_count"]; ?></th>
                            </tr>

                            <tr>
                                <th class="text-center">Hindi</th>
                                <th class="text-center"><?php echo $subject_count['03']["pass_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['03']["fail_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['03']["dist_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['03']["first_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['03']["second_count"]; ?></th>
                            </tr>

                            <!-- <tr>
                                <th class="text-center">French</th>
                                <th class="text-center"><?php echo $subject_count['12']["pass_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['12']["fail_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['12']["dist_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['12']["first_count"]; ?></th>
                                <th class="text-center"><?php echo $subject_count['12']["second_count"]; ?></th>
                            </tr> -->

                            <?php foreach($subInfo as $sub){ ?>

                                <tr>
                                    <th class="text-center"><?php echo $sub->sub_name; ?></th>
                                    <th class="text-center"><?php echo $subject_count[$sub->subject_code]["pass_count"]; ?></th>
                                    <th class="text-center"><?php echo $subject_count[$sub->subject_code]["fail_count"]; ?></th>
                                    <th class="text-center"><?php echo $subject_count[$sub->subject_code]["dist_count"]; ?></th>
                                    <th class="text-center"><?php echo $subject_count[$sub->subject_code]["first_count"]; ?></th>
                                    <th class="text-center"><?php echo $subject_count[$sub->subject_code]["second_count"]; ?></th>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>



                <div class="row">
                    <div class="col-lg-6">
                        <div id="chartmarkFinal" style="height: 300px; width: 100%;"></div>
                        <script>
                        function loadGraph() {
                            var chart = new CanvasJS.Chart("chartmarkFinal", {
                                animationEnabled: true,
                                title: {
                                    text: ""
                                },

                                data: [{
                                    type: "pie",
                                    startAngle: 240,
                                    yValueFormatString: "##0\"\"",
                                    indexLabel: "{label} {y}",
                                    dataPoints: <?php echo json_encode($dataPoints_Pie); ?>
                                }]
                            });
                            chart.render();
                        } 

                        <?php echo "loadGraph();"; ?>
                        </script>
                    </div>

                    <div class="col-lg-6">
                        <table class="table  table-bordered">
                            <tr>
                                <th colspan="3" width="50">Total Students</th>
                                <th colspan="3" ><?php echo $total_student_count; ?></th>
                            </tr>

                            <tr>
                                <th colspan="3" class="bg-green" >PASS</th>
                                <th colspan="3" class="bg-green"><?php echo $total_pass_students; ?></th>
                            </tr>

                            <tr>
                                <th colspan="3" style="background:#ab1d0bdb !important;color: white;" >FAIL</th>
                                <th colspan="3" style="background:#ab1d0bdb !important;color: white;"><?php echo $total_fail_students; ?></th>
                            </tr>

                            <tr>
                                <th width="150">First Class</th>
                                <th><?php echo $total_first_class_students; ?></th>
                                <th width="150">Second Class</th>
                                <th><?php echo $total_second_class_students; ?></th>
                                <th width="150">Distinction</th>
                                <th><?php echo $total_distiction_students; ?></th>
                            </tr>

                            <tr>
                                <th width="150">Absent</th>
                                <th><?php echo $total_absented_students; ?></th>
                                <th width="150">Exempted</th>
                                <th><?php echo $total_exempted_students; ?></th>
                                <th width="150">Malpractice</th>
                                <th><?php echo $total_malpractice_students; ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php } else{
                    echo "<div class='alert alert-info text-center'>
                    Search through above options.
                    </div>";
                } ?>
            </div>
        </div>
    </div>




</div>


<?php

function getSubjectMarkInfo($con,$subject_id,$student_id,$exam_type){
    $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
    WHERE exam.subject_code = '$subject_id' AND exam.student_id = '$student_id' AND exam.exam_type = '$exam_type' AND exam.is_deleted = 0 AND exam.exam_year = '2023-24'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();

}

?>
<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
var term_name = 'I';


jQuery(document).ready(function() {
    var term = $("#term_name").val();
    var stream = $(".stream_name").val();
    var staf_rowId = $("#staff_subject_row_id").val();

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
    
    $(function() {
        $('#attendanceDate').datepicker({
            autoclose: true,
            endDate: "today",
            format: 'dd-mm-yyyy',
        });
    });

    $("#term_name").change(function(){
        $('#streamName').prop('disabled', false);
        $('#streamName option:not(:first)').remove();
        $('#streamName option:selected').remove();
        $('#streamName').append('<option value="">Select Stream & Section</option>');
        var term_name = $("#term_name").val()
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
        }
    });
});

function isNumberKey(evt) {
    //alert(mark_ent)
    
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode > 64 && charCode < 91 ) && (charCode < 48 || charCode > 57  || charCode.length < 4))
        return false;
    return true;
}

</script>
