<?php require APPPATH . 'views/includes/db.php'; ?>



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php

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

<div class="main-content-container container-fluid px-4">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <div class="row mt-1 mb-2">

            <div class="col padding_left_right_null">

                <div class="card card-small p-0 card_head_dashboard">

                    <div class="card-body p-2 ml-2">

                        <span class="page-title">

                            <i class="material-icons">&#xE6E1;</i> My Performance

                        </span>

                        <a onclick="window.history.back(); return false;"
                            class="btn btn-primary float-right text-white pt-2" value="Back">Back </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <div class="row form-employee">

        <div class="col-12 padding_left_right_null">

            <div class="card card-small c-border mb-4">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item">

                        <div class="row">

                            <div class="col profile-head">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <?php //if($term_name == 'I PUC'){ ?>

                                    <li class="nav-item">

                                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                                            role="tab" aria-controls="profile" aria-selected="false">Annual Exam</a>

                                    </li>

                                

                                    <!-- <li class="nav-item">

                                            <a class="nav-link" id="midTerm-tab" data-toggle="tab" href="#midTerm"

                                                role="tab" aria-controls="family" aria-selected="true">Mid Term Exam</a>

                                        </li> -->
                                        
                                        <!-- <li class="nav-item">

                                        <a class="nav-link" id="secondTest-tab" data-toggle="tab" href="#secondTest"
                                            role="tab" aria-controls="secondTest" aria-selected="false">II Unit Test</a>

                                    </li> -->

                                    <?php //} ?>



                                    <?php// if($term_name == 'II PUC'){ ?>

                                    <!--

                                      

                                        <li class="nav-item">

                                            <a class="nav-link" id="preparatory-tab" data-toggle="tab" href="#preparatory"

                                                role="tab" aria-controls="preparatory" aria-selected="false">Preparatory</a>

                                    </li> -->

                                    <?php// } ?>

                                    <?php if($term_name == 'II PUC'){ ?>

                                    <!-- <li class="nav-item">

                                            <a class="nav-link" id="firstPreparatory-tab" data-toggle="tab" href="#firstPreparatory"

                                                role="tab" aria-controls="firstPreparatory" aria-selected="false">Preparatory Exam</a>

                                        </li> -->

                                    <?php } ?>

                                    <!-- <li class="nav-item">

                                        <a class="nav-link active" id="final_exam-tab" data-toggle="tab" href="#final_exam"

                                            role="tab" aria-controls="final_exam" aria-selected="false">Final Exam</a>

                                    </li> -->

                                    <!-- <li class="nav-item">

                                        <a class="nav-link" id="graph-tab" data-toggle="tab" href="#graph" role="tab"

                                            aria-controls="family" aria-selected="true">Graph</a>

                                    </li> -->

                                </ul>

                                <div class="tab-content profile-tab" id="myTabContent">

                                    <?php// if($term_name == 'I PUC'){ ?>

                                    <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">

                                        <h6 class="text-center text-dark mb-1"></h6>

                                        <div class="table-responsive-sm">

                                            <table class="table table-bordered table_info">

                                                <thead class="text-center">

                                                    <?php //if($term_name == 'II PUC'){ ?>

                                                    <tr>

                                                        <th colspan="5" class="table_title text-center">ANNUAL EXAM
                                                            2024</th>

                                                    </tr>

                                                    <?php //}else{ ?>
                                                    <!-- 
                                                        <tr>

                                                            <th colspan="4" class="table_title text-center">I PUC UNIT TEST FEBRUARY/MARCH 2021</th>

                                                        </tr> -->

                                                    <?php //} ?>

                                                    <tr class="table_row_backgrond">

                                                        <th rowspan="2">Subjects</th>

                                                        <th style="width:250px" rowspan="2">Max. Marks</th>

                                                        <th style="width:120px">TH</th>

                                                        <th style="width:120px">PR/IA</th>

                                                        <th style="width:250px" rowspan="2">Marks Scored</th>

                                                    </tr>

                                                    <tr class="table_row_backgrond">

                                                    

                                                        <th>(70/80)</th>

                                                        <th>(30/20)</th>

                                                        

                                                        </tr>

                                                </thead>

                                                <?php 

                                               

                                                    $result_subject_fail_status = false;

                                                    $result_fail_status = false;

                                                    $max_mark = 0;

                                                    $min_mark_pass = 0;

                                                    $total_mark_obtained = 0;

                                                    $total_max_mark = 0;

                                                    $total_min_mark = 0;

                                                 

                                                    for($i=0;$i<count($subjects_code);$i++){

                                                        $result_display = "";

                                                        $result_subject_fail_status = false;

                                                        if($getSubjectName[$i]->lab_status == 'true'){                      

                                                            $max_mark = 100;

                                                            $min_mark_pass = 21;

                                                        }else{

                                                            $max_mark = 100;

                                                            $min_mark_pass = 28;

                                                        }

                                                        $total_max_mark += $max_mark;

                                                        $total_min_mark += $min_mark_pass;

                                                        $obtainedMark = $firstUnitTestMarkInfo[$i]->obt_theory_mark;
                                                        $obtainedLabMark = $firstUnitTestMarkInfo[$i]->obt_lab_mark;

                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                            $result_subject_fail_status = true;

                                                            $result_display = $obtainedMark;

                                                            $result_fail_status = true;

                                                        }else if($min_mark_pass > $obtainedMark){

                                                            $result_subject_fail_status = true;

                                                            $result_fail_status = true;

                                                            $result_display = $obtainedMark .'F';

                                                        }else if(35 > (int)$obtainedMark + (int)$obtainedLabMark){

                                                            $result_subject_fail_status = true;

                                                            $result_fail_status = true;

                                                            $result_display = $obtainedMark .'F';

                                                        }else{

                                                            $result_subject_fail_status = false;
                                                            $result_display = $obtainedMark;

                                                        }
                                                        $total_mark_obtained += (int)$obtainedMark + (int)$obtainedLabMark;

                                                    ?>

                                                <tr>

                                                    <th class="">

                                                        <?php echo strtoupper($getSubjectName[$i]->name); ?></th>


                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <?php if($result_subject_fail_status == true){ ?>

                                                    <th style=""
                                                        class="text-center table_marks_data">

                                                        <?php echo $obtainedMark; ?></th>

                                                    <?php }else{ ?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $obtainedMark; ?></th>

                                                    <?php } ?>


                                                    <?php if($result_subject_fail_status == true){ ?>

                                                        <th style=""
                                                            class="text-center table_marks_data">

                                                            <?php echo $obtainedLabMark; ?></th>

                                                        <?php }else{ ?>

                                                        <th class="text-center table_marks_data">

                                                            <?php echo $obtainedLabMark; ?></th>

                                                        <?php } ?>

                                                        <?php if($result_subject_fail_status == true){ ?>
                                                        <th style="" class="text-center table_marks_data">

                                                        <?php echo (int)$obtainedMark + (int)$obtainedLabMark; ?></th>
                                                        <?php }else{ ?>
                                                            <th class="text-center table_marks_data">
                                                        <?php echo (int)$obtainedMark + (int)$obtainedLabMark; ?></th>
                                                        <?php } ?>

                                                </tr>

                                                <?php  }

                                                       if($total_mark_obtained != 0){

                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Grand Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th colspan="2"></th>

                                                    <th><?php echo $total_mark_obtained; ?></th>

                                                </tr>



                                                <tr>

                                                    <th colspan="2" class="total_row">Percentage:

                                                        <?php echo round($total_percentage,2).'%'; ?></th>

                                                    <th colspan="2">Result:

                                                        <?php if($result_fail_status == true){ ?>

                                                        <span class="text_fail"><?php echo 'FAIL'; ?></span>

                                                        <?php } else { ?>

                                                        <span class="text_pass"><?php echo 'PASS'; ?></span>

                                                        <?php } ?>
                                                    </th>

                                                </tr>

                                                <?php } ?>

                                            </table>

                                        </div>

                                    </div>

                                    <?php //} ?>                                                            

                                </div>

                            </div>

                        </div>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>



<?php 

function getSubjectInfo($con,$subject_id){

    $query = "SELECT * FROM tbl_subjects as sub

    WHERE sub.subject_code = '$subject_id' AND sub.is_deleted = 0";

    $pdo_statement = $con->prepare($query);

    $pdo_statement->execute();

    return $pdo_statement->fetch();

  }



   

?>