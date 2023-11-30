<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<?php
ini_set('MAX_EXECUTION_TIME', '-1');
date_default_timezone_set("Asia/Kolkata"); 

require APPPATH . 'views/includes/db.php'; 
?>
<style>
.canvasjs-chart-credit{
    display:none !important;
}

/* @media print {
.page-break { display: block; page-break-before: always; }

}  */

@media print {
 .noprint {display:none;}
 ::-webkit-scrollbar {
    display: none;

    
}

 .enable-print { display: block !important;
    /* padding-top:5.5cm;
   padding-bottom:2.5cm; */
 
  }
  
.main-footer,.floating-button{
        display: none !important;
    }
    .wizard-inner, .card-header, .card-footer {
        display: none;
    }
  

    @page {
        size: A4;
        /* margin: 0;  */
    }
    
    .page_break { 
      page-break-after: always !important;
    }
  .break_after { page-break-before: none !important; } 
}
.A4 {
   background: white;
   width: 26cm;
   height: 18.7cm;
   display: block;
   margin: 0 auto;
  padding: 14.3px;
   margin-bottom: 0.5cm;
   box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
   color: #000 !important;
}
#border {
  border-radius: 1px;
  border: 2px solid black;
  width: 18.5cm;
  height: 26.7cm;

}


table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  line-height: 1.5 !important;
  padding: 3px !important;
}

/* ------------------ */
/* new added changes */
/* ----------------- */




.boredr-only-top{
  border-top: solid;
  border-color: black;
  border-width: 1px;
  margin-top: 15px;
}



.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    font-size: 22px !important;
    padding: 5px !important;
    line-height: 1.22 !important;
    vertical-align: top !important;
    border-top: 1px solid #ddd;
    border: 1px solid black !important;
    font-weight: 600 !important;
}
/* tr{
  height: 21px !important;
} */


.border_full{
  border-style: solid;
  padding: 7px;
  border-color: black;
  border-width: 1px;
}
.boredr_left{
border-left: solid;
padding: 7px;
border-color: black;
border-width: 1px;
}
.boredr_right{
border-right: solid;
padding: 7px;
border-color: black;
border-width: 1px;
}
.boredr_left_right{
border-right: solid;
border-left: solid;
padding: 7px;
border-color: black;
border-width: 1px;
}
.boredr_only_bottom{
border-bottom: solid;
/* padding: 7px; */
border-color: black;
border-width: 1px;
}
.text_style_2{
  margin-left: -12px;
  font-weight: bold;
  float: left;
  margin-top: -8px;
}


canvas{
  margin-left: 100px;
width:700px !important;
height:400px !important;
color: #000 !important;

}
</style>


<div class="main-content-container container-fluid px-4 pt-2">
  <div class="content-wrapper">
    <div class="row noprint">
      <div class="col-12">
        <div class="card card-small p-0 card_heading_title">
          <div class="card-body p-1 card-content-title">
            <div class="row ">
              <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                <i class="fa fa-file"></i> Mark Card
              </div>
              <div class="col-lg-4 col-md-4 col-4"> 
                <a href="#" onClick="window.print();" class="btn text-white btn-success btn-bck float-right">
                <i class="fa fa-download"></i> Print</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row form-employee">
      <div class="col-12">
        <div class="card card-small c-border p-2 mb-4">
        <?php 
                $attendance_date_to = "2022-12-31";
                if(!empty($studentsRecords))
                {
                    $total_students_selected = count($studentsRecords);
                    foreach($studentsRecords as $student)
                    {  
                    $total_students_selected--;

                    if($exam_type == 'I_UNIT_TEST'){
                      $exam_name = 'I UNIT TEST AUGUST 2023';
                    }else if($exam_type == 'MID_TERM'){
                      $exam_name = 'MID-TERM EXAMINATION DECEMBER-2022';
                  }else if($exam_type == 'II_UNIT_TEST'){
                    $exam_name = 'II UNIT TEST DECEMBER 2023';
                  }else if($exam_type == 'I_PREPARATORY'){
                    $exam_name = 'PREPARATORY EXAMINATION JAN & FEB 2023';
                  }
                    if($student->term_name == "I PUC"){ 
                      $img_path = "assets/images/PHOTOS_22_23_ALL/".strtoupper($student->student_id).".JPG";
                    }else{
                      $img_path = "assets/images/PHOTOS_21_22_ALL/".strtoupper($student->student_id).".jpg";
                    }

                    
                 
                                                                   
                    ?>
                    
                    <div class="A4 enable-print" >
                                        <div class="row border_full">
                                            <div  class="col-lg-2 col-sm-2 col-2">
                                                <img style="margin-right: 6px;margin-top: -0px;" height="120" class="pull-right" width="120" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" alt="logo">
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-8" >
                                                <div class="header-heading text-center">
                                                    <b style="font-size: 25px; text-transform: uppercase;"><?php echo TITLE; ?></b>
                                                    <p class="mb-2" style="margin-top: -10px; font-size:16px;"><?php echo ADDRESS; ?></p>
                                                    <!-- <p class="mb-2" style="margin-top: -14px; font-size:16px;">Address</p>
                                                    <p class="mb-2" style="margin-top:-12px; font-size: 23px; margin-bottom: -12px; "> -->
                                                    <b>
                                                     <?php echo $exam_name; ?>
                                                    </b></p> 
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-2 col-sm-2 col-2">
                                            <img style="margin-left: 4px;" class="text-right" width="100" src="<?php echo base_url(); ?><?php echo $img_path; ?>" height="100" alt="logo">
                                          </div> -->
                                        </div> 
                                        <?php //if($student->term_name == "I PUC"){ 
                                              $absent_date_from = date("Y-m-d", strtotime($student->doj));
                                            //    } else { 
                                            // $absent_date_from = '2021-07-01';
                                            //  } ?>
                                   
                                        <div class="row boredr_left_right boredr_only_bottom">
                                            <div class="col-12">
                                                <table class="table table-bordered table-responsive">
                                                    <tbody>
                                                    <tr>
                                                        <th style="font-size: 18px !important;" class="text-center" width="250">Reg No.: <?php echo $student_id = $student->student_id; ?></th>
                                                        <th style="font-size: 18px !important;" colspan="5">Name: <?php echo $student->student_name; ?></th>
                                                        <th style="font-size: 18px !important;" colspan="2" class="text-center">Class: <?php echo $student->term_name . ' '.$student->stream_name.' '.$student->section_name; ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center" rowspan="2" style="vertical-align: middle !important;">SUBJECTS</th>
                                                        <th class="text-center" rowspan="2" style="vertical-align: middle !important;">Max. Marks</th>
                                                        <th class="text-center" rowspan="2" style="vertical-align: middle !important;">Min. Marks</th>
                                                        <?php if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){ ?>
                                                        <th class="text-center" colspan="3" rowspan="2" style="vertical-align: middle !important;">Marks Scored</th>
                                                        <?php }else{ ?>
                                                        <th colspan="3" class="text-center" style="vertical-align: middle !important;">Marks Scored</th>
                                                        <?php } ?>
                                                        <th width="80" class="text-center" style="vertical-align: middle !important;">Attendance</th>
                                                        <th width="80" rowspan="2" class="text-center" style="vertical-align: middle !important;">Percentage of Attn.%</th>
                                                    </tr>
                                                    <tr>
                                                        <?php if($exam_type == 'MID_TERM'){ ?>
                                                          <th class="text-center" style="vertical-align: middle !important;">TH</th>
                                                          <th class="text-center" style="vertical-align: middle !important;">PR</th>
                                                          <th class="text-center" style="vertical-align: middle !important;">TOTAL</th>
                                                        <?php } ?>
                                                        <th width="80" class="text-center">Attended/Held</th>
                                                    </tr>
                                                    <?php 
                                                    if($exam_type == 'I_UNIT_TEST'){
                                                     $attendance_date_to = "2022-08-31";
                                                    }else{
                                                      $attendance_date_to = "2022-12-31";
                                                    }
                                                     $subjects_code = array();
                                                     $subject_names = array();
                                                     $subject_mark = array();
                                                     $subject_mark_unit_test_I = array();
                                                     $subject_mark_unit_test_II = array();
                                                     $subject_mark_chart_I_TEST = array();
                                                     $subject_mark_chart_II_TEST = array();
                                                     $subject_mark_chart = array();
                                                     $elective_sub = strtoupper($student->elective_sub);
                                                   

                                                     $subject_mark_MID_TERM = array();
                                                     $subject_mark_chart_MID_TERM = array();
                                                        if($elective_sub == "KANNADA"){
                                                            array_push($subjects_code, '01');
                                                        }else if($elective_sub == 'HINDI'){
                                                            array_push($subjects_code, '03');
                                                        } else if($elective_sub == 'FRENCH'){
                                                            array_push($subjects_code, '12');
                                                        }else{
                                                          array_push($subject_mark_chart,0);
                                                          array_push($subject_mark_chart_I_TEST,0);
                                                           ?>
                                                            <th>EXEMPTED</th>
                                                            <th class="text-center">EX</th>
                                                            <th class="text-center">EX</th>
                                                            <th class="text-center">EX</th>
                                                            <th class="text-center">EX</th>
                                                            <th  class="text-center">EX</th>
                                                         <?php
                                                        
                                                          array_push($subject_names, 'EXM');
                                                        }
                                                        array_push($subjects_code, '02');
                                                       
                                                        $subjects = getSubjectCodes($student->stream_name);
                                                        $subjects_code = array_merge($subjects_code,$subjects);
                                                        $result_fail_status = false;
                                                        $total_max_mark = 0;
                                                        $total_theory_mark = 0;
                                                        $total_lab_mark = 0;
                                                        $total_min_mark = 0;
                                                        $total_mark_obtained = 0;
                                                        $total_max_mark_I_TEST = 0;
                                                        $total_max_mark_II_TEST = 0;
                                                        $chart_percentage_unit = 0;
                                                        $chart_percentage_mid = 0;
                                                        $chart_percentage = 0;
                                                        $total_class_held_all = 0;
                                                        $total_class_attended_all = 0;
                                                        $total_mark_obtained_I_TEST = 0;
                                                        $total_mark_obtained_II_TEST = 0;
                                                        $max_mark_MID_Term = 0;
                                                        $min_mark_pass_MID_Term = 0;
                                                        $total_max_mark_MID_Term = 0;
                                                        $total_min_mark_pass_MID_Term = 0;
                                                        $total_mark_obtained_MID_TERM = 0;
                                                        for($i=0; $i < count($subjects_code); $i++)
                                                        {
                                                          $absent_count = 0;
                                                          $absent_count_lab = 0;
                                                          $absent_count_theory = 0;
                                                          // $batch_name = '';
                                                          $obtainted_mark = 0;
                                                          $theory_mark = 0;
                                                          $lab_mark = 0;
                                                           $subject_info = getSubjectInfo($con,$subjects_code[$i]); ?>
                                                            <tr>
                                                                <?php
                                                                $exam_mark = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,$exam_type);
                                                                if($exam_mark['obt_theory_mark'] != ''){
                                                                  $theory_mark = $exam_mark['obt_theory_mark'];
                                                                }else{
                                                                  $theory_mark = '-';
                                                                }
                                                                if($exam_mark['obt_lab_mark'] != ''){
                                                                  $lab_mark = $exam_mark['obt_lab_mark'];
                                                                }else{
                                                                  $lab_mark = '-';
                                                                }
                                                                $subjectCode = $subjects_code[$i];
                                                                if(is_numeric($theory_mark)){
                                                                  $obtainted_mark = $theory_mark + $lab_mark;
                                                                } else {
                                                                  $obtainted_mark = $theory_mark;
                                                                }
                                                                
                                                                if($subject_info['lab_status'] == 'true'){
                                                                  // $batchInfo = getBatchInfo($con,$student->section_name,$student->term_name,$student_id,$subjects_code[$i]);
                                                                  // if(!empty($batchInfo)){
                                                                  //   $batch_name = $batchInfo['batch_name'];
                                                                  // } else if($subjects_code[$i] == '40' && $subjects_code[$i] == '34' && $student_id = '17P2109'){
                                                                  //   $batch_name = 'II Batch';
                                                                  // }
                                                                  $batch_name = $student->batch;
                                                                  if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                                                                      $max_mark = 35;
                                                                      
                                                                      $max_mark_midterm = 70;
                                                                      $min_mark_pass = 12;
                                                                      $min_pass = 12;
                                                                  }else if($exam_type == 'MID_TERM'){
                                                                    if($subjectCode == '12'){
                                                                      $max_mark = 100;
                                                                      $min_mark_pass = 35;
                                                                      $min_pass = 24;
                                                                      $minMark_pass_MID_Term = 24;
                                                                    }else{
                                                                      $max_mark = 100;
                                                                      $min_mark_pass = 35;
                                                                      $min_pass = 21;
                                                                      $minMark_pass_MID_Term = 21;
                                                                    }
                                                                  }
                                                                  $max_mark_I_TEST = 35;
                                                                  $max_mark_II_TEST = 35;
                                                                  $min_mark_pass_I_TEST = 12;
                                                                  $minMark_pass_I_TEST = 12;
                                                                  $max_mark_MID_Term = 100;
                                                                  $min_mark_pass_MID_Term = 35;
                                                                  $minMark_pass_MID_Term = 21;
                                                                      // $max_mark_MID_Term = 70;
                                                                      // $min_mark_pass_MID_Term = 35;
                                                                  // }
                                                                }else{
                                                                  if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                                                                    $max_mark = 40;
                                                                    $max_mark_midterm = 100;
                                                                    $min_mark_pass = 14;
                                                                    $min_pass = 14;
                                                                  }else if($exam_type == 'MID_TERM'){
                                                                    if($subjectCode == '12'){
                                                                      $max_mark = 100;
                                                                      $min_mark_pass = 35;
                                                                      $min_pass = 24;
                                                                      $minMark_pass_MID_Term = 24;
                                                                    }else{
                                                                      $max_mark = 100;
                                                                      $min_mark_pass = 35;
                                                                      $min_pass = 35;
                                                                      $minMark_pass_MID_Term = 35;
                                                                    }
                                                                  }
                                                                  $max_mark_I_TEST = 40;
                                                                  $max_mark_II_TEST = 40;
                                                                  $min_mark_pass_I_TEST = 14;
                                                                  $minMark_pass_I_TEST = 14;
                                                                  $max_mark_MID_Term = 100;
                                                                  $min_mark_pass_MID_Term = 35;
                                                                  $minMark_pass_MID_Term = 35;

                                                                }
                                                              //   $absent_count_theory_first= getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,'THEORY');
                                                              // if($absent_count_theory_first != NULL){
                                                              //   $absent_count += 1;
                                                              // } 
                                                              
                                                                $total_max_mark += $max_mark;
                                                                $total_theory_mark += $theory_mark;
                                                                $total_lab_mark += $lab_mark;
                                                                $total_max_mark_I_TEST += $max_mark_I_TEST;
                                                                $total_max_mark_II_TEST += $max_mark_II_TEST;
                                                                $total_min_mark += $min_mark_pass;
                                                                $total_max_mark_MID_Term += $max_mark_midterm;
                                                                $total_min_mark_pass_MID_Term += $min_mark_pass_MID_Term;
                                                                if($obtainted_mark == 'AB' || $obtainted_mark == 'EX' || $obtainted_mark == 'MP'){
                                                                    $result_fail_status = true;
                                                                    $result_display = $obtainted_mark;
                                                                    
                                                                    array_push($subject_mark_chart,0);
                                                                } else if($min_pass > $theory_mark){
                                                                    $result_fail_status = true;
                                                                    $total_mark_obtained += $obtainted_mark;
                                                                    $result_display = $obtainted_mark.'F';
                                                                    $chart_percentage = round(($obtainted_mark/$max_mark)*100,2);
                                                                    array_push($subject_mark_chart,$chart_percentage);
                                                                }else{
                                                                  $total_mark_obtained += $obtainted_mark;
                                                                  $result_display = $obtainted_mark;
                                                                  $chart_percentage = round(($obtainted_mark/$max_mark)*100,2);
                                                                  array_push($subject_mark_chart, $chart_percentage);
                                                                }
                                                                array_push($subject_names, strtoupper($subject_info['name']));
                                                                array_push($subject_mark,$result_display);
                                                              

                                                                if($student->term_name == "II PUC" || $student->term_name == "I PUC"){

                                                                $exam_mark_unit_test = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,'I_UNIT_TEST');
                                                                $obtainted_mark_I_test = $exam_mark_unit_test['obt_theory_mark'];
                                                                if($obtainted_mark_I_test == 'AB' || $obtainted_mark_I_test == 'EX' || $obtainted_mark_I_test == 'MP'){

                                                                    $result_display_unit_I = $obtainted_mark_I_test;
                                                                    array_push($subject_mark_chart_I_TEST,0);
                                                                } else if($min_mark_pass_I_TEST > $obtainted_mark_I_test){
                                                                    $result_display_unit_I = $obtainted_mark_I_test.'F';
                                                                    $total_mark_obtained_I_TEST += $obtainted_mark_I_test;
                                                                    $max_mark_unit = $max_mark / 2; 
                                                                    $chart_percentage_unit = round(($obtainted_mark_I_test/$max_mark_I_TEST)*100,2);
                                                                    array_push($subject_mark_chart_I_TEST, $chart_percentage_unit);
                                                                }else{
                                                                  $total_mark_obtained_I_TEST += $obtainted_mark_I_test;
                                                                  $result_display_unit_I = $obtainted_mark_I_test;
                                                                  $max_mark_unit = $max_mark / 2; 
                                                                  $chart_percentage_unit = round(($obtainted_mark_I_test/$max_mark_I_TEST)*100);
                                                                  array_push($subject_mark_chart_I_TEST, $chart_percentage_unit);
                                                                }
                                                                array_push($subject_mark_unit_test_I,$result_display_unit_I);
                                                              }


                                                                // if($exam_type == 'MID_TERM'){
                                                                //mid term mark info
                                                                $MID_TERM_EXAM = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,'MID_TERM');
                                                                $obtainted_theory_MID_TERM_EXAM = $MID_TERM_EXAM['obt_theory_mark'];
                                                                $obtainted_lab_MID_TERM_EXAM = $MID_TERM_EXAM['obt_lab_mark'];
                                                                $obtainted_MID_TERM_EXAM = $obtainted_theory_MID_TERM_EXAM + $obtainted_lab_MID_TERM_EXAM;
                                                                if($obtainted_MID_TERM_EXAM == 'AB' || $obtainted_MID_TERM_EXAM == 'EX' || $obtainted_MID_TERM_EXAM == 'MP'){
                                                                    $result_display_MID_TERM = $obtainted_MID_TERM_EXAM;
                                                                    array_push($subject_mark_chart_MID_TERM, 0);
                                                                    // array_push($subject_mark_MID_TERM,0);
                                                                } else if($minMark_pass_MID_Term > $obtainted_theory_MID_TERM_EXAM){
                                                                    $result_display_MID_TERM = $obtainted_MID_TERM_EXAM.'F';
                                                                    $total_mark_obtained_MID_TERM += $obtainted_MID_TERM_EXAM;
                                                                    $max_mark_unit = $max_mark / 2; 
                                                                    $chart_percentage_mid = round(($obtainted_MID_TERM_EXAM/$max_mark_MID_Term)*100,2);
                                                                    array_push($subject_mark_chart_MID_TERM, $chart_percentage_mid);
                                                                }else{
                                                                  $total_mark_obtained_MID_TERM += $obtainted_MID_TERM_EXAM;
                                                                  $result_display_MID_TERM = $obtainted_MID_TERM_EXAM;
                                                                  $max_mark_unit = $max_mark / 2; 
                                                                  $chart_percentage_mid = round(($obtainted_MID_TERM_EXAM/$max_mark_MID_Term)*100);
                                                                  array_push($subject_mark_chart_MID_TERM, $chart_percentage_mid);
                                                                }
                                                                array_push($subject_mark_MID_TERM,$result_display_MID_TERM);
                                                              // }


                                                              
                                                              $exam_mark_unit_testII = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,'II_UNIT_TEST');
                                                              $obtainted_mark_II_test = $exam_mark_unit_testII['obt_theory_mark'];
                                                              if($obtainted_mark_II_test == 'AB' || $obtainted_mark_II_test == 'EX' || $obtainted_mark_II_test == 'MP'){

                                                                  $result_display_unit_II= $obtainted_mark_II_test;
                                                                  array_push($subject_mark_chart_II_TEST,0);
                                                              } else if($min_mark_pass_I_TEST > $obtainted_mark_II_test){
                                                                  $result_display_unit_II = $obtainted_mark_II_test.'F';
                                                                  $total_mark_obtained_II_TEST += $obtainted_mark_II_test;
                                                                  $max_mark_unit = $max_mark / 2; 
                                                                  $chart_percentage_unitII = round(($obtainted_mark_II_test/$max_mark_II_TEST)*100,2);
                                                                  array_push($subject_mark_chart_II_TEST, $chart_percentage_unitII);
                                                              }else{
                                                                $total_mark_obtained_II_TEST += $obtainted_mark_II_test;
                                                                $result_display_unit_II = $obtainted_mark_II_test;
                                                                $max_mark_unit = $max_mark / 2; 
                                                                $chart_percentage_unitII = round(($obtainted_mark_II_test/$max_mark_II_TEST)*100);
                                                                array_push($subject_mark_chart_II_TEST, $chart_percentage_unitII);
                                                              }
                                                              array_push($subject_mark_unit_test_II,$result_display_unit_II);
                                                            

                                                                
                                                                $subject_class_held_theory = getTotalClassHeld($con,$subjects_code[$i],$student->term_name,$student->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                                                                $total_dates_held_theory = getTotalClassCompletedDates($con,$subjects_code[$i],$student->term_name,$student->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                                                                // foreach($total_dates_held_theory as $date){
                                                                //   $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date['date'],'THEORY');
                                                                //   if($absent_count_theory != NULL){
                                                                //     $absent_count += 1;
                                                                //   }
                                                                // }
                                                                $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,$attendance_date_to,'THEORY');
                                                                $absent_count += $absent_count_theory;
                                                                $months = array('June','July','August','SEPTEMBER','OCTOBER','NOVEMBER');
                                                                $class_held_P =0;
                                                                  $class_attended_P =0;
                                                                foreach($months as $mon){
                                                                  $absent_count_theory_monthly = getStudentAbsentCountMonthly($con,$subjects_code[$i],$student_id,$mon);
                                                                  $class_held_P += $absent_count_theory_monthly['class_held'];
                                                                  $class_attended_P += $absent_count_theory_monthly['class_attended'];

                                                                }
                                                                // $absent_count_theory_monthly = getStudentAbsentCountMonthly($con,$subjects_code[$i],$student_id,$months);

                                                                

                                                                $subject_class_held_lab = getTotalClassHeld($con,$subjects_code[$i],$student->term_name,$student->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                                                                $total_dates_held_lab = getTotalClassCompletedDates($con,$subjects_code[$i],$student->term_name,$student->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                                                                $total_class_held = $subject_class_held_theory + ($subject_class_held_lab*2);
                                                                // foreach($total_dates_held_lab as $date_lab){
                                                                //   $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date_lab['date'],'LAB');
                                                                //   if($absent_count_theory != NULL){
                                                                //     $absent_count += 2;
                                                                //   }
                                                                // }
                                                                
                                                                $absent_count_lab = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,$attendance_date_to,'LAB');
                                                                if($absent_count_lab != 0){
                                                                  $absent_count += ($absent_count_lab * 2);
                                                                }

                                                                $total_class_presnts = $total_class_held-$absent_count;
                                                                $attendance_percentage = ($class_attended_P/$class_held_P)*100;
                                                              
                                                                // $total_class_held_all += $total_class_held;
                                                                // $total_class_attended_all += $total_class_presnts;

                                                                $total_class_held_all += $class_held_P;
                                                                $total_class_attended_all += $class_attended_P;
                                                                ?>

                                                                <th><?php echo strtoupper($subject_info['name']); ?></th>
                                                                <th class="text-center" style="vertical-align: middle !important;"><?php echo $max_mark; ?></th>
                                                                <th class="text-center" style="vertical-align: middle !important;"><?php echo $min_mark_pass; ?></th>
                                                                <?php if($exam_type == 'MID_TERM'){ ?>
                                                                <th class="text-center" style="vertical-align: middle !important;"><?php echo $theory_mark; ?></th>
                                                                <th class="text-center" style="vertical-align: middle !important;"><?php echo $lab_mark; ?></th>
                                                                <th class="text-center" style="vertical-align: middle !important;"><?php echo $result_display; ?></th>
                                                                <?php }else{ ?>
                                                                <th class="text-center" style="vertical-align: middle !important;" colspan="3"><?php echo $result_display; ?></th>
                                                                <?php } ?>
                                                                <th class="text-center" style="vertical-align: middle !important;"><?php echo $class_attended_P.'/'.$class_held_P; ?></th>
                                                                <th  class="text-center" style="vertical-align: middle !important;"><?php echo round($attendance_percentage,2); ?></th>
                                                            </tr>
                                                            
                                                           <?php
                                                        }
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100;
                                                        $total_attendance_percentage = ($total_class_attended_all/$total_class_held_all)*100;
                                                    ?>
                                                    <tr>
                                                        <th class="text-center">TOTAL</th>
                                                        <th class="text-center" style="vertical-align: middle !important;"><?php echo $total_max_mark; ?></th>
                                                        <th class="text-center" style="vertical-align: middle !important;"><?php echo $total_min_mark; ?></th>
                                                        <?php if($exam_type == 'MID_TERM'){ ?>
                                                        <th class="text-center" style="vertical-align: middle !important;"><?php echo $total_theory_mark; ?></th>
                                                        <th class="text-center" style="vertical-align: middle !important;"><?php echo $total_lab_mark; ?></th>
                                                        <th class="text-center" style="vertical-align: middle !important;"><?php echo $total_mark_obtained; ?></th>
                                                        <?php }else{ ?>
                                                        <th class="text-center" style="vertical-align: middle !important;" colspan="3"><?php echo $total_mark_obtained; ?></th>
                                                        <?php } ?>
                                                        <th></th>
                                                        <th class="text-center" style="vertical-align: middle !important;"><?php echo round($total_attendance_percentage,2).'%'; ?></th>
                                                    </tr>
                                                    <tr style="font-size: 18px;">
                                                        <th colspan="6" style="vertical-align: middle !important;">Overall Secured Percentage of Marks: <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2" style="vertical-align: middle !important;" class="text-center">Result: <span><?php if($result_fail_status == true){echo 'FAIL';}else{echo 'PASS';} ?></span></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- <div style="padding:2px; " class="row text-center boredr_left_right boredr_only_bottom">
                                            <span class="" style="font-size:19px; font-weight:600">Performance Of The Year</span>
                                        </div> -->
                                        <!-- <div class="row boredr_left_right boredr_only_bottom">
                                        <table class="table table-bordered m-1 p-2">
                                            <tbody>
                                                <tr>
                                                    <th class="text-center text-uppercase">Test / Exam Name</th>
                                                    <?php for($i=0; $i < count($subject_names); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo substr($subject_names[$i], 0, 3);?></th>
                                                  <?php } ?>
                                                  <th class="text-center">%</th>
                                                </tr>
                                                <?php if($student->term_name == "II PUC" || $student->term_name == "I PUC"){  ?> 
                                                <tr>
                                                    <th>I UNIT TEST AUGUST-2022</th>
                                                    <?php 
                                                    if($elective_sub == "EXEMPTED"){ ?>
                                                     <th class="text-center">EX</th>
                                                   <?php }
                                                    for($i=0; $i < count($subjects_code); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo $subject_mark_unit_test_I[$i]; ?></th>
                                                  <?php } 
                                                   $total_percentage_unit_I = ($total_mark_obtained_I_TEST/$total_max_mark_I_TEST)*100;
                                                  ?>
                                                  <th class="text-center"><?php echo round($total_percentage_unit_I,2); ?></th>
                                                </tr>
                                                <?php } ?> -->
                                              

                                                
                                                <?php ?>
                                                <!-- // if($exam_type == 'MID_TERM')
                                                // {  -->
                                                <!-- <tr>
                                                    <th>MID-TERM EXAM DECEMBER-2022</th>
                                                    <?php 
                                                    if($elective_sub == "EXEMPTED"){ ?>
                                                     <th class="text-center">EX</th>
                                                   <?php }
                                                    for($i=0; $i < count($subjects_code); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo $subject_mark_MID_TERM[$i]; ?></th>
                                                  <?php } 
                                                   $percentage_mid_term = ($total_mark_obtained_MID_TERM/$total_max_mark_MID_Term)*100;
                                                  ?>
                                                  <th class="text-center"><?php echo round($percentage_mid_term,2); ?></th>
                                               
                                                </tr>
                                                <?php ?> -->
                                                <!--  //}  -->

                                                <!-- <?php  ?>
                                                <tr>
                                                    <th>II UNIT TEST DECEMBER-2022</th>
                                                    <?php 
                                                    if($elective_sub == "EXEMPTED"){ ?>
                                                     <th class="text-center">EX</th>
                                                   <?php }
                                                    for($i=0; $i < count($subjects_code); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo $subject_mark_unit_test_II[$i]; ?></th>
                                                  <?php } 
                                                   $total_percentage_unit_II = ($total_mark_obtained_II_TEST/$total_max_mark_II_TEST)*100;
                                                  ?>
                                                  <th class="text-center"><?php echo round($total_percentage_unit_II,2); ?></th>
                                                </tr>
                                               <?php ?> -->
                                                <!-- // }  -->

<!--                                              
                                            </tbody>
                                        </table>
                                        </div> -->

                                        <!-- <div style="padding:2px; " class="row text-center boredr_left_right boredr_only_bottom">
                                            <span style="font-size:20px; font-weight:600" class="">Performance in Bar Graph</span>
                                        </div>
                                        
                                       
                                        <div class="row boredr_left_right  ">
                                        <canvas class="text-center" id="markChart<?php echo $student_id; ?>"></canvas>
                                            
                                        </div> -->
                                        <script type="text/javascript">
                                              //  function loadGraph() {
                                               
                                              //   var mark_MID_TERM = <?php echo json_encode($subject_mark_chart_MID_TERM); ?>;
                                              //   var mark_UNIT_TEST = <?php echo json_encode($subject_mark_chart_I_TEST); ?>;
                                              //   var mark_UNIT_TEST_II = <?php echo json_encode($subject_mark_chart_II_TEST); ?>;
                                              // 
                                            //   var data = {
                                            //             labels: [
                                            //                 <?php for($i=0; $i < count($subject_names); $i++)
                                            //                   { 
                                            //                   echo "'".strtoupper($subject_names[$i])."',";
                                            //                   } ?>
                                            //                 ],
                                            //     datasets: [
                                            //         {
                                            //             label: 'I TERM TEST SEPTEMBER - 2022',
                                            //             borderColor: 'rgb(0, 0, 0)',
                                            //             borderWidth : '1',
                                            //             backgroundColor: 'rgb(213, 219, 219)',
                                            //             data: mark_UNIT_TEST
                                            //         },
                                            //         {
                                            //             label: 'MID-TERM DECEMBER - 2022',
                                            //             borderColor: 'rgb(0, 0, 0)',
                                            //             borderWidth : '1',
                                            //             backgroundColor: 'rgb( 214, 234, 248)',
                                                       
                                            //             data: mark_MID_TERM
                                            //         },
                                                   
                                            //         {
                                            //             label: 'II UNIT TEST DECEMBER - 2022',
                                            //             borderColor: 'rgb(0, 0, 0)',
                                            //             borderWidth : '1',
                                            //             backgroundColor: 'rgb(169, 223, 191)',
                                            //             data: mark_UNIT_TEST_II
                                            //         },
                                            //     ]
                                            // };
                                                  // var ctx = document.getElementById('markChart<?php echo $student_id; ?>').getContext('2d');
                                                  // var chart = new Chart(ctx, {
                                                      // The type of chart we want to create
                                                      // type: 'bar',
                                                      // // The data for our dataset
                                                      // data: data,
                                                 
                                                      // Configuration options go here
                                                      // options: {
                                                      //   responsive: true,
                                                      //   scales: {
                                                      //         xAxes: [{
                                                      //           barThickness : 43,
                                                      //           ticks: {
                                                      //             fontColor: "black",
                                                      //             fontSize: 15,
                                                                 
                                                      //           }
                                                      //         }],
                                                      //         yAxes: [
                                                      //                 {
                                                      //                   ticks: {
                                                      //                     fontColor: "black",
                                                      //                     fontSize: 15,
                                                      //                     min: 0,
                                                                          // max: 100,// Your absolute max value
                                                                          // callback: function (value) {
                                                                          //   return (value / 100 * 100).toFixed(0); // convert it to percentage
                                                //                           },
                                                //                         },
                                                //                         scaleLabel: {
                                                //                           fontSize: 20,
                                                //                           display: true,
                                                //                           labelString: 'Marks Obtained',
                                                //                         },
                                                //                       },
                                                //                     ],
                                                //           }
                                                //       }
                                                //   });
                                                // }

                                            <?php
                                               // echo "loadGraph();";
                                            ?>
                                        </script>
                                        <div class="row border_full">
                                          <!-- <div class="row "> -->
                                            <div class="col-lg-4 col-sm-4 col-4 text-center ">
                                              <img height="" src="" alt="">
                                            </div>
                                            <div class="col-lg-8 col-8 text-center"> </div> 
                                          <!-- </div> -->
                                          <!-- <div class="row "> -->
                                          <div class="col-lg-4 col-sm-4 col-4 text-center font-weight-bold" style="font-size: 17px;">Principal's Signature</div>
                                          <div class="col-lg-4 col-sm-4 col-4 text-center font-weight-bold" style="font-size: 17px;">Class Teacher's Signature</div>
                                          <div class="col-lg-4 col-sm-4 col-4 text-center font-weight-bold" style="font-size: 17px;">Parent's Signature
                                          <!-- </div> -->
                                          </div>
                                          </div>
                                        <!-- <br/> -->
                                        <!-- <div class="row   ">
                                            
                                        </div> -->
                                </div>
                        <!-- <?php if($total_students_selected > 1) { ?>
                        <div class="page_break"></div>
                        <?php }else{ ?>
                        <div class="break_after"></div>
                        <?php } ?> -->
 
                   <?php  } }?>
            <div class="card-footer p-1">
                <a href="#" onClick="window.print();" class="btn text-white btn-success btn-bck float-right">
                <i class="fa fa-download"></i> Print</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "studentsListing/" + value);
            jQuery("#searchList").submit();
        });
    //     jQuery(function() {
    //     jQuery(this).bind("contextmenu", function(event) {
    //         event.preventDefault();
    //     });
    // });
    });

 
</script>
<?php

function getSubjectInfo($con,$subject_id){
    $query = "SELECT * FROM tbl_subjects as sub
    WHERE sub.subject_code = '$subject_id'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}
function getSubjectMarkInfo($con,$subject_id,$student_id,$exam_type){
    $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
    WHERE exam.subject_code = '$subject_id' AND exam.student_id = '$student_id' AND exam.exam_type = '$exam_type' AND exam.office_validation_status = 0 AND exam_year = '2023-24'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}

function getTotalClassHeld($con,$subject_id,$term_name,$section_name,$type,$batch_name,$absent_date_from,$attendance_date_to){
 
  if(!empty($batch_name)){
    $query = "SELECT * FROM tbl_class_completed_by_staff as class
    WHERE class.subject_code = '$subject_id' AND class.term_name = '$term_name' AND class.class_year = '2023' AND class.section_name = '$section_name' AND 	class.subject_type = '$type' AND class.batch = '$batch_name' AND class.is_deleted = 0 AND class.is_deleted = 0 AND
    class.date between '$absent_date_from' AND '$attendance_date_to' ";
  }else{
    $query = "SELECT * FROM tbl_class_completed_by_staff as class
    WHERE class.subject_code = '$subject_id' AND class.term_name = '$term_name' AND class.class_year = '2023' AND class.section_name = '$section_name' AND 	class.subject_type = '$type' AND class.is_deleted = 0 AND
    class.date between '$absent_date_from' AND '$attendance_date_to' ";
  }
  $result = $con->prepare($query); 
  $result->execute(); 
  return $result->rowCount();
}

// get all class completed dates
function getTotalClassCompletedDates($con,$subject_id,$term_name,$section_name,$type,$batch_name,$absent_date_from,$attendance_date_to){
 
  if(!empty($batch_name)){
    $query = "SELECT * FROM tbl_class_completed_by_staff as class
    WHERE class.subject_code = '$subject_id' AND class.term_name = '$term_name' AND class.class_year = '2023' AND class.section_name = '$section_name' AND 	class.subject_type = '$type' AND class.batch = '$batch_name' AND class.is_deleted = 0 AND
    class.date between '$absent_date_from' AND '$attendance_date_to' ";
  }else{
    $query = "SELECT * FROM tbl_class_completed_by_staff as class
    WHERE class.subject_code = '$subject_id' AND class.term_name = '$term_name' AND class.class_year = '2023' AND class.section_name = '$section_name' AND 	class.subject_type = '$type' AND class.is_deleted = 0 AND
    class.date between '$absent_date_from' AND '$attendance_date_to' ";
  }
  $result = $con->prepare($query); 
  $result->execute(); 
  return $result->fetchAll();
}
// AND ab.office_verified_status = 0 
// function getStudentAbsentCount($con,$subject_id,$student_id,$absent_date,$type){
//   $query = "SELECT * FROM tbl_student_attendance_details as ab WHERE ab.student_id = '$student_id' AND ab.absent_date = '$absent_date' 
//   AND ab.is_deleted = 0 AND 
//   ab.staff_subject_row_id IN(SELECT sub.row_id FROM tbl_staff_teaching_subjects as sub WHERE sub.subject_code='$subject_id' AND sub.subject_type='$type' AND sub.is_deleted = 0)";
//   $result = $con->prepare($query); 
//   $result->execute(); 
//   return $result->fetchAll();
// }


function getStudentAbsentCount($con,$subject_id,$student_id,$absent_date_from,$attendance_date_to,$type){
 
  $query = "SELECT * FROM tbl_student_attendance_details as ab WHERE ab.student_id = '$student_id' AND 
  ab.absent_date BETWEEN '$absent_date_from' AND '$attendance_date_to'
  AND ab.is_deleted = 0 AND ab.year = '2023' AND
  ab.staff_subject_row_id IN(SELECT sub.row_id FROM tbl_staff_teaching_subjects as sub WHERE sub.subject_code='$subject_id' AND sub.subject_type='$type' AND sub.is_deleted = 0)";
  $result = $con->prepare($query); 
  $result->execute(); 
  return $result->rowCount();
}


function getStudentAbsentCountMonthly($con,$subject_id,$student_id,$months){
 
  $query = "SELECT * FROM tbl_attendance_additional_info as ab WHERE ab.student_id = '$student_id' 
  AND ab.is_deleted = 0 AND ab.year = '2023' AND ab.subject_code = '$subject_id' AND ab.month = '$months'";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}


function getBatchInfo($con,$section_name,$term_name,$student_id,$subject_id){
  $query = "SELECT * FROM  tbl_class_batch_details as batch,  tbl_staff_teaching_subjects as sub
  WHERE sub.row_id = batch.staff_teaching_subject_id AND sub.subject_id = '$subject_id' AND
   batch.section_name = '$section_name' AND batch.term_name = '$term_name' AND
   '$student_id' between batch.student_id_from AND batch.student_id_to AND batch.is_deleted = 0";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}

function getSubjectCodes($stream_name){
  //science
  $PCMB = array("33", "34", "35", '36');
  $PCMC = array("33", "34", "35", '41');
  $PCME = array("33", "34", "35", '40');
  $PCMS = array("33", "34", "35", '31');
  //commarce
  $BEBA = array("75", "22", "27", '30');
  $BSBA = array("75", "31", "27", '30');
  $CSBA = array("41", "31", "27", '30');
  $SEBA = array("31", "22", "27", '30');
  $EBAC = array("41", "22", "27", '30');
  $PEBA = array("29", "22", "27", '30');
  //art
  $HEPP = array("21", "22", "32", '29');
  $MEBA = array("75", "22", "27", '30');
  $MSBA = array("75", "31", "27", '30');
  $HEPS = array("21", "22", "29", '28');
  $HEPE = array("21", "22", "29", '52');

  switch ($stream_name) {
      case "PCMB":
          return  $PCMB;
          break;
      case "PCMC":
          return $PCMC;
          break;
      case "PCME":
          return $PCME;
          break;
      case "PCMS":
          return $PCMS;
          break;
      case "PEBA":
          return $PEBA;
          break;
      case "BEBA":
          return $BEBA;
          break;
      case "BSBA":
          return $BSBA;
          break;
      case "CSBA":
          return $CSBA;
          break;
      case "SEBA":
          return $SEBA;
          break;
      case "EBAC":
          return $EBAC;
          break;
      case "HEPP":
          return $HEPP;
          break;
      case "HEPS":
          return $HEPS;
          break;
      case "MEBA":
          return $MEBA;
          break;
      case "MSBA":
          return $MSBA;
          break;
      case "HEPE":
          return $HEPE;
          break;
  }
}
?>