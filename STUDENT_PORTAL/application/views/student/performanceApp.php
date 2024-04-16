<?php require APPPATH . 'views/includes/db.php'; 
$base_url = 'https://sjpuc.schoolphins.com/student/'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" href="<?php echo $base_url; ?>assets/dist/img/dolphin_logo.png">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/6.0.0/material-components-web.min.css" />
    <link rel="stylesheet"
        href="<?php echo $base_url; ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0"
        href="<?php echo $base_url; ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/dist/styles/extras.1.0.0.min.css"> -->

    <link href="<?php echo $base_url; ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
    <meta name="apple-mobile-web-app-title" content="">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">


    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo $base_url; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />


    <style>
    .error {
        color: red;
        font-weight: normal;
    }

    .blink_me {
        animation: blinker 1s linear infinite;
        color: red;
        font-weight: bold;
        float: right;
        padding-left: 10px;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
    </style>
    <!-- <script src="<?php echo $base_url; ?>assets/bower_components/jquery/dist/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/6.0.0/material-components-web.min.js">
    </script>
    <script type="text/javascript">
    var baseURL = "<?php echo $base_url; ?>";
    </script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js"></script>
    <!-- Initializing Firebase -->
    <script src="<?php echo $base_url;?>assets/notification/initialize_firebase.js"></script>
    <!-- Receiving token from FCM server -->
    <script src="<?php echo $base_url;?>assets/notification/fcm-push-notification.js"></script>
    <!-- Handle incoming messages -->
    <script src="<?php echo $base_url;?>assets/notification/handle_message.js"></script>
    <!-- Setting notification count -->
    <script src="<?php echo $base_url;?>assets/notification/notification-counter.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Loader Script -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/jquery/jquery.cookie.js"></script>
    <script src="<?=base_url()?>assets/plugins/sweetalert/sweetalert2.0.js"></script>
    <script>
    function showLoader() {
        $(".custom_loader").addClass('active');
        $("#custom_loader_text").css('display', 'block');
    }

    function hideLoader() {
        $(".custom_loader").removeClass('active');
        $("#custom_loader_text").css('display', 'none');
    }
    $(document).ready(() => {
        $(".btn-backtrack").click((evt) => {
            showLoader();
            if (document.referrer != "" && window.history.length > 1) {
                window.history.go(-1);
            } else {
                location.href = "<?=$base_url?>dashboard";
            }
        });

        $("form").on('submit', (evt) => {
            if ($(evt.target).data('download_form')) {
                $.cookie('isDownloading', '1');
                showLoader();
                const intervalID = setInterval(() => {
                    if ($.cookie('isDownloading') == 0) {
                        hideLoader();
                        clearInterval(intervalID);
                    }
                }, 2000);
            } else {
                showLoader();
            }
        });

        $("li.nav-item > .nav-link[href*='<?=$base_url?>']").on('click', function() {
            showLoader();
        });
    });
    </script>
    <!-- End of Loader Script -->

    <!-- Loader Style -->
    <style>
    /* Absolute Center Spinner */
    .custom_loader {
        position: fixed;
        z-index: 99999;
        height: 2em;
        width: 2em;
        overflow: visible;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .custom_loader.active:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
    }

    /* :not(:required) hides these rules from IE9 and below
        .custom_loader.active:not(:required) {
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        } */

    .custom_loader.active:not(:required):after {
        content: '';
        display: block;
        font-size: 40px;
        width: 0.4em;
        height: 0.4em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(26, 26, 255, 1) 1.5em 0 0 0, rgba(85, 255, 0, 1) 1.1em 1.1em 0 0, rgba(26, 26, 255, 1) 0 1.5em 0 0, rgba(85, 255, 0, 1) -1.1em 1.1em 0 0, rgba(26, 26, 255, 1) -1.5em 0 0 0, rgba(85, 255, 0, 1) -1.1em -1.1em 0 0, rgba(26, 26, 255, 1) 0 -1.5em 0 0, rgba(0, 255, 0, 1) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    </style>
    <!-- End of Loader Style -->




</head>

<body class="hold-transition skin-blue sidebar-mini" style="overflow-x: hidden;">
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

    <?php 
    
            
    

?>
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
                                            role="tab" aria-controls="profile" aria-selected="false">I Unit Test</a>

                                    </li>
                                    

                                    <li class="nav-item">

                                    <a class="nav-link" id="midTerm-tab" data-toggle="tab" href="#midTerm"

                                        role="tab" aria-controls="family" aria-selected="true">Mid Term Exam</a>

                                </li>

                                <li class="nav-item">

                                        <a class="nav-link" id="secondTest-tab" data-toggle="tab" href="#secondTest"
                                            role="tab" aria-controls="secondTest" aria-selected="false">II Unit Test</a>

                                    </li>

                                    <?php //} ?>



                                    <?php// if($term_name == 'II PUC'){ ?>

                                    <!-- 

                                 <li class="nav-item">

                                    <a class="nav-link" id="secondTest-tab" data-toggle="tab" href="#secondTest"

                                        role="tab" aria-controls="secondTest" aria-selected="false">II Unit Test</a>

                                </li>

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

                                                        <th colspan="4" class="table_title text-center">FIRST UNIT TEST
                                                            2023</th>

                                                    </tr>

                                                    <?php //}else{ ?>
                                                    <!-- 
                                                <tr>

                                                    <th colspan="4" class="table_title text-center">I PUC UNIT TEST FEBRUARY/MARCH 2021</th>

                                                </tr> -->

                                                    <?php //} ?>

                                                    <tr class="table_row_backgrond">

                                                        <th>SUBJECTS</th>

                                                        <th>Max. Marks</th>

                                                        <th>Min. Marks</th>

                                                        <th>Marks Scored</th>

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

                                                    // $max_mark = 35;

                                                    // $min_mark_pass = 12;

                                                    $max_mark = 35;

                                                    $min_mark_pass = 12;

                                                }else{

                                                    $max_mark = 40;

                                                    $min_mark_pass = 14;

                                                }

                                                $total_max_mark += $max_mark;

                                                $total_min_mark += $min_mark_pass;

                                                $obtainedMark = $firstUnitTestMarkInfo[$i]->obt_theory_mark;

                                                if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                    $result_subject_fail_status = true;

                                                    $result_display = $obtainedMark;

                                                    $result_fail_status = true;

                                                }else if($min_mark_pass > $obtainedMark){

                                                    $result_subject_fail_status = true;

                                                    $result_fail_status = true;

                                                    $total_mark_obtained += $obtainedMark;

                                                    $result_display = $obtainedMark .'F';

                                                }else{

                                                    $result_subject_fail_status = false;

                                                    $total_mark_obtained += $obtainedMark;

                                                    $result_display = $obtainedMark;

                                                }

                                            ?>

                                                <tr>

                                                    <th class="text-center">

                                                        <?php echo strtoupper($getSubjectName[$i]->name); ?></th>

                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $min_mark_pass; ?></th>

                                                    <?php if($result_subject_fail_status == true){ ?>

                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php }else{ ?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php } ?>

                                                </tr>

                                                <?php  }

                                               if($total_mark_obtained != 0){

                                                $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th><?php echo $total_min_mark; ?></th>

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

                                    <div class="tab-pane fade show" id="midTerm" role="tabpanel"
                                        aria-labelledby="midTerm-tab">

                                        <div class="table-responsive">

                                            <table class="table table-bordered table_info">

                                                <thead class="text-center">

                                                    <tr>

                                                        <th colspan="4" class="table_title text-center">MID TERM EXAM
                                                            2023</th>

                                                    </tr>

                                                    <tr class="table_row_backgrond">

                                                        <th>SUBJECTS</th>

                                                        <th>Max. Marks</th>

                                                        <th>Min. Marks</th>

                                                        <th>Marks Scored</th>

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

                                            $total_percentage = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                if(!empty($midTermExamMarkInfo[$i])){

                                                    

                                                if($midTermExamMarkInfo[$i]->lab_status == 'true'){

                                                    $max_mark = 70;

                                                    $min_mark_pass = 21;

                                                }else{

                                                    $max_mark = 80;

                                                    $min_mark_pass = 28;

                                                }

                                                $total_max_mark += $max_mark;

                                                $total_min_mark += $min_mark_pass;

                                                $obtainedMark = $midTermExamMarkInfo[$i]->obt_theory_mark;

                                                    if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                        $result_subject_fail_status = true;

                                                        $result_display = $obtainedMark;

                                                        $result_fail_status = true;

                                                    }else if($min_mark_pass > $obtainedMark){

                                                        $result_subject_fail_status = true;

                                                        $result_fail_status = true;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark.'F';

                                                    }else{

                                                        $result_subject_fail_status = false;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark;

                                                    }

                                            ?>

                                                <tr>

                                                    <th class="text-center">

                                                        <?php echo strtoupper($midTermExamMarkInfo[$i]->name); ?></th>

                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $min_mark_pass; ?></th>

                                                    <?php if($result_subject_fail_status == true){ ?>

                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php }else{ ?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php } ?>

                                                </tr>

                                                <?php  } }

                                        if($total_mark_obtained != 0){

                                            $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th><?php echo $total_min_mark; ?></th>

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

                                    <div class="tab-pane" id="preparatory" role="tabpanel"
                                        aria-labelledby="preparatory-tab">

                                        <div class="table-responsive">

                                            <table class="table table-bordered table_info">

                                                <thead class="text-center">

                                                    <tr>

                                                        <th colspan="4" class="table_title text-center">PREPARATORY 2023
                                                        </th>

                                                    </tr>

                                                    <tr class="table_row_backgrond">

                                                        <th>SUBJECTS</th>

                                                        <th>Max. Marks</th>

                                                        <th>Min. Marks</th>

                                                        <th>Marks Scored</th>

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

    $total_percentage = 0;

    for($i=0;$i<count($subjects_code);$i++){

        $result_display = "";

        $result_subject_fail_status = false;

        if(!empty($firstPreparatoryMarkInfo[$i])){

            

        if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){

            $max_mark = 70;

            $min_mark_pass = 24;

        }else{

            $max_mark = 100;

            $min_mark_pass = 35;

        }

        $total_max_mark += $max_mark;

        $total_min_mark += $min_mark_pass;

        $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;

            if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                $result_subject_fail_status = true;

                $result_display = $obtainedMark;

                $result_fail_status = true;

            }else if($min_mark_pass > $obtainedMark){

                $result_subject_fail_status = true;

                $result_fail_status = true;

                $total_mark_obtained += $obtainedMark;

                $result_display = $obtainedMark.'F';

            }else{

                $result_subject_fail_status = false;

                $total_mark_obtained += $obtainedMark;

                $result_display = $obtainedMark;

            }

    ?>

                                                <tr>

                                                    <th class="text-center">

                                                        <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->name); ?>
                                                    </th>

                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $min_mark_pass; ?></th>

                                                    <?php if($result_subject_fail_status == true){ ?>

                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php }else{ ?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php } ?>

                                                </tr>

                                                <?php  } }

if($total_mark_obtained != 0){

    $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th><?php echo $total_min_mark; ?></th>

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


                                    <div class="tab-pane fade" id="secondTest" role="tabpanel"
                                        aria-labelledby="secondTest-tab">

                                        <h6 class="text-center text-dark mb-1"></h6>

                                        <div class="table-responsive-sm">

                                            <table class="table table-bordered table_info">

                                                <thead class="text-center">

                                                    <tr>

                                                        <th colspan="4" class="table_title text-center">SECOND UNIT TEST
                                                            2023</th>

                                                    </tr>

                                                    <tr class="table_row_backgrond">

                                                        <th>SUBJECTS</th>

                                                        <th>Max. Marks</th>

                                                        <th>Min. Marks</th>

                                                        <th>Marks Scored</th>

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

                                            $total_percentage = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                // if(!empty($SecondUnitTestMarkInfo[$i])){

                                                    if($getSubjectName[$i]->lab_status == 'true'){

                                                        $max_mark = 35;

                                                        $min_mark_pass = 12;

                                                    }else{

                                                        $max_mark = 40;

                                                        $min_mark_pass = 14;

                                                    }

                                                    $total_max_mark += $max_mark;

                                                    $total_min_mark += $min_mark_pass;

                                                    $obtainedMark = $SecondUnitTestMarkInfo[$i]->obt_theory_mark;

                                                    if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                        $result_subject_fail_status = true;

                                                        $result_display = $obtainedMark;

                                                        $result_fail_status = true;

                                                    }else if($min_mark_pass > $obtainedMark){

                                                        $result_subject_fail_status = true;

                                                        $result_fail_status = true;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark .'F';

                                                    }else{

                                                        $result_subject_fail_status = false;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark;

                                                    }

                                                // }

                                            ?>

                                                <tr>

                                                    <th class="text-center">

                                                        <?php echo strtoupper($getSubjectName[$i]->name); ?>
                                                    </th>

                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $min_mark_pass; ?></th>

                                                    <?php if($result_subject_fail_status == true){ ?>

                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php }else{ ?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php } ?>

                                                </tr>

                                                <?php  }

                                               if($total_mark_obtained != 0){

                                                $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th><?php echo $total_min_mark; ?></th>

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

                                    <?php if($term_name == 'II PUC'){ ?>

                                    <div class="tab-pane fade show " id="firstPreparatory" role="tabpanel"
                                        aria-labelledby="firstPreparatory-tab">

                                        <div class="table-responsive">

                                            <table class="table table-bordered table_info">

                                                <thead class="text-center">

                                                    <tr>

                                                        <th colspan="4" class="table_title text-center">Preparatory Exam
                                                            2021</th>

                                                    </tr>

                                                    <tr class="table_row_backgrond">

                                                        <th>SUBJECTS</th>

                                                        <th>Max. Marks</th>

                                                        <th>Min. Marks</th>

                                                        <th>Marks Scored</th>

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

                                            $total_percentage = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                if(!empty($firstPreparatoryMarkInfo[$i])){

                                                    

                                                if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){

                                                    $max_mark = 70;

                                                    $min_mark_pass = 24;

                                                }else{

                                                    $max_mark = 100;

                                                    $min_mark_pass = 35;

                                                }

                                                $total_max_mark += $max_mark;

                                                $total_min_mark += $min_mark_pass;

                                                $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;

                                                    if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                        $result_subject_fail_status = true;

                                                        $result_display = $obtainedMark;

                                                        $result_fail_status = true;

                                                    }else if($min_mark_pass > $obtainedMark){

                                                        $result_subject_fail_status = true;

                                                        $result_fail_status = true;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark.'F';

                                                    }else{

                                                        $result_subject_fail_status = false;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark;

                                                    }

                                            ?>

                                                <tr>

                                                    <th class="text-center">

                                                        <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->name); ?>
                                                    </th>

                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $min_mark_pass; ?></th>

                                                    <?php if($result_subject_fail_status == true){ ?>

                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php }else{ ?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $result_display; ?></th>

                                                    <?php } ?>

                                                </tr>

                                                <?php  } }

                                        if($total_mark_obtained != 0){

                                            $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th><?php echo $total_min_mark; ?></th>

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

                                    <?php } ?>



                                    <div class="tab-pane  fade show" id="final_exam" role="tabpanel"
                                        aria-labelledby="final_exam-tab">

                                        <div class="table-responsive">

                                            <table class="table table-bordered table_info">

                                                <thead class="text-center">

                                                    <tr>

                                                        <th colspan="4" class="table_title text-center">Final Exam 2021
                                                        </th>

                                                    </tr>

                                                    <tr class="table_row_backgrond">

                                                        <th>SUBJECTS</th>

                                                        <th>Max. Marks</th>

                                                        <th>Min. Marks</th>

                                                        <th>Marks Scored</th>

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

                                            $total_percentage = 0;

                                            $totalTheoryMark = 0;

                                            $totalLabMark = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                $subjectInfo = getSubjectInfo($con,$subjects_code[$i]);

                                                //if(!empty($assignmentExamMarks[$subjects_code[$i]])){

                                                    

                                                    

                                                    if($subjects_code[$i] == 12){

                                                        $labStatus = 'true';

                                                    }else{

                                                        $labStatus = $subjectInfo['lab_status'];

                                                    }

                                                    if($labStatus == 'true'){

                                                        if($subjects_code[$i] == 12){

                                                            $pass_mark_theory = 25;

                                                            $pass_mark_lab = 10;

                                                            $lab_assessment = 10;

                                                        }else{

                                                            $pass_mark_theory = 21;

                                                            $pass_mark_lab = 14;

                                                            $lab_assessment = 16;

                                                        }

                                                    }else{

                                                        $pass_mark_theory = 35;

                                                        $pass_mark_lab = 0;

                                                        $lab_assessment = 0;

                                                    }

                                                   

                                                    

                                                    if($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754'){

                                                        $internal_assessment = 1;

                                                    }else{

                                                        $internal_assessment = 5;

                                                    }

                                                    $max_mark = 100;

                                                        $min_mark_pass = 35;

                                                    

                                                    $totalTheoryMark = $assignmentExamMarks[$subjects_code[$i]] + $pass_mark_theory + $internal_assessment + $lab_assessment + $pass_mark_lab;

                                                  



                                                // if($assignmentExamMarks[$i]->lab_status == 'true'){

                                                //     $max_mark = 70;

                                                //     $min_mark_pass = 24;

                                                // }else{

                                                //     $max_mark = 100;

                                                //     $min_mark_pass = 35;

                                                // }

                                                $total_max_mark += $max_mark;

                                                $total_min_mark += $min_mark_pass;

                                                $obtainedMark = $totalTheoryMark;

                                                    $total_mark_obtained += $totalTheoryMark;

                                                    // if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                    //     $result_subject_fail_status = true;

                                                    //     $result_display = $obtainedMark;

                                                    //     $result_fail_status = true;

                                                    // }else if($min_mark_pass > $obtainedMark){

                                                    //     $result_subject_fail_status = true;

                                                    //     $result_fail_status = true;

                                                    //     $total_mark_obtained += $obtainedMark;

                                                    //     $result_display = $obtainedMark.'F';

                                                    // }else{

                                                    //     $result_subject_fail_status = false;

                                                    //     $total_mark_obtained += $obtainedMark;

                                                    //     $result_display = $obtainedMark;

                                                    // }

                                            ?>

                                                <tr>

                                                    <th class="text-center">

                                                        <?php echo strtoupper($subjectInfo['name']); ?></th>

                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                    </th>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $min_mark_pass; ?></th>

                                                    <?php //if($result_subject_fail_status == true){   style="background: #f76a7ebf"?>

                                                    <th class="text-center table_marks_data">

                                                        <?php echo $totalTheoryMark; ?></th>

                                                    <?php//}else{ ?>

                                                    <!-- <th class="text-center table_marks_data">

                                                <?php echo $result_display; ?></th> -->

                                                    <?php //} ?>

                                                </tr>

                                                <?php  //} 

                                        }

                                        if($total_mark_obtained != 0){

                                            $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                                <tr class="text-center table_row_backgrond">

                                                    <th class="total_row">Total</th>

                                                    <th><?php echo $total_max_mark; ?></th>

                                                    <th><?php echo $total_min_mark; ?></th>

                                                    <th><?php echo $total_mark_obtained; ?></th>

                                                </tr>



                                                <tr>

                                                    <th colspan="2" class="total_row">Percentage :

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

                                    <div class="tab-pane fade" id="graph" role="tabpanel" aria-labelledby="graph-tab">

                                        <?php $dataPoints = array();

                                        $dataPoints2 = array();

                                        $dataPoints3 = array();

                                        $dataPoints4 = array();

                                        $total_max_mark = 0;

                                        $firstUnitTestResult = 0;

                                        $midTermExamResult = 0;

                                        $secondUnitTestResult = 0;

                                        $firstPreparatoryResult = 0;

                                        for($i=0;$i<count($subjects_code);$i++){

                                            if($term_name == 'I PUC'){

                                                $subject_names = $firstUnitTestMarkInfo[$i]->name;

                                            if(!empty($firstUnitTestMarkInfo[$i]->obt_theory_mark)){                                  

                                                if($firstUnitTestMarkInfo[$i]->lab_status == 'true'){

                                                //   $max_mark = 35;

                                                //   $min_mark_pass = 12;

                                                  $max_mark = 50;

                                                  $min_mark_pass = 18;

                                                }else{

                                                  $max_mark = 50;

                                                  $min_mark_pass = 18;

                                                }

                                                $firstUnitTestMark = $firstUnitTestMarkInfo[$i]->obt_theory_mark;

                                                if($firstUnitTestMark == 'AB' || $firstUnitTestMark == 'EX' || $firstUnitTestMark == 'MP'){

                                                    array_push($dataPoints, array("label"=> $subject_names, "y"=> 0));

                                                }else{

                                                    $firstUnitTestResult = ($firstUnitTestMark / $max_mark)*50;

                                                    array_push($dataPoints, array("label"=> $subject_names, "y"=>$firstUnitTestResult));

                                                }

                                            }else{

                                            array_push($dataPoints, array("label"=> $subject_names, "y"=> 0));

                                            }

                                            }else{

                                                $subject_names = $firstPreparatoryMarkInfo[$i]->name;

                                            }

                                            if(!empty($midTermExamMarkInfo[$i]->obt_theory_mark)){

                                                $midTermMark = $midTermExamMarkInfo[$i]->obt_theory_mark;                                      

                                                if($midTermExamMarkInfo[$i]->lab_status == 'true'){

                                                  $max_mark = 70;

                                                  $min_mark_pass = 24;

                                                }else{

                                                  $max_mark = 100;

                                                  $min_mark_pass = 35;

                                                }

                                                if($midTermMark == 'AB' || $midTermMark == 'EX' || $midTermMark == 'MP'){

                                                    array_push($dataPoints2, array("label"=> $subject_names, "y"=> 0));

                                                }else{

                                                    $midTermExamResult = ($midTermMark / $max_mark)*100;

                                                    array_push($dataPoints2, array("label"=> $subject_names, "y"=> $midTermExamResult));

                                                }

                                            }else{

                                                array_push($dataPoints2, array("label"=> $subject_names, "y"=> 0));

                                            }

                                            

                                            if(!empty($SecondUnitTestMarkInfo[$i]->obt_theory_mark)){       

                                                $secondUnitTestMark = $SecondUnitTestMarkInfo[$i]->obt_theory_mark;                           

                                                if($SecondUnitTestMarkInfo[$i]->lab_status == 'true'){

                                                  $max_mark = 35;

                                                  $min_mark_pass = 12;

                                                }else{

                                                  $max_mark = 50;

                                                  $min_mark_pass = 18;

                                                }

                                                if($secondUnitTestMark == 'AB' || $secondUnitTestMark == 'EX' || $secondUnitTestMark == 'MP'){

                                                    array_push($dataPoints3, array("label"=> $subject_names, "y"=> 0));

                                                }else{

                                                    $secondUnitTestResult = ($secondUnitTestMark / $max_mark)*100;

                                                    array_push($dataPoints3, array("label"=> $subject_names, "y"=>$secondUnitTestResult));

                                                }

                                            }else{

                                                array_push($dataPoints3, array("label"=> $subject_names, "y"=> 0));

                                            }

                                            

                                            if($term_name == 'II PUC'){

                                                if(!empty($firstPreparatoryMarkInfo[$i]->obt_theory_mark)){       

                                                    $firstPreparatorytMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;                           

                                                    if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){

                                                        $max_mark = 70;

                                                        $min_mark_pass = 24;

                                                    }else{

                                                        $max_mark = 100;

                                                        $min_mark_pass = 35;

                                                    }

                                                    if($firstPreparatorytMark == 'AB' || $firstPreparatorytMark == 'EX' || $firstPreparatorytMark == 'MP'){

                                                        array_push($dataPoints4, array("label"=> $subject_names, "y"=> 0));

                                                    }else{

                                                        $firstPreparatoryResult = ($firstPreparatorytMark / $max_mark)*$max_mark;

                                                        array_push($dataPoints4, array("label"=> $subject_names, "y"=>$firstPreparatoryResult));

                                                    }

                                                }else{

                                                    array_push($dataPoints4, array("label"=> $subject_names, "y"=> 0));

                                                }

                                            }



                                        }

                                        ?>

                                        <!-- <div class="row">

                                    <div class="col-12"> -->

                                        <div id="performanceChart" style="height:400px; width:100%;" class="w-100">
                                        </div>

                                        <script>
                                        function loadGraph() {

                                            var chart = new CanvasJS.Chart("performanceChart", {

                                                animationEnabled: true,

                                                exportEnabled: true,

                                                responsive: true,

                                                theme: "light1",

                                                title: {

                                                    text: ""

                                                },

                                                data: [{

                                                        type: "column",

                                                        name: "I UNIT TEST FEBRUARY/MARCH 2021",

                                                        showInLegend: true,

                                                        yValueFormatString: "##0",

                                                        dataPoints: <?php echo json_encode($dataPoints); ?>

                                                    }, {

                                                        type: "column",

                                                        name: "PREPARATORY 2021",

                                                        showInLegend: true,

                                                        yValueFormatString: "##0",

                                                        dataPoints: <?php echo json_encode($dataPoints4); ?>

                                                    },



                                                ]

                                            });

                                            chart.render();

                                        }

                                        <?php 

                                            echo "loadGraph();"; 

                                        ?>
                                        </script>

                                        <!-- </div>

                                </div> -->

                                    </div>

                                </div>

                            </div>

                        </div>

                    </li>

                </ul>

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