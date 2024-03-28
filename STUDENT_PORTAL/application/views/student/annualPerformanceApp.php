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


    <?php
    
    function getSubjectInfo($con,$subject_id){

        $query = "SELECT * FROM tbl_subjects as sub
    
        WHERE sub.subject_code = '$subject_id' AND sub.is_deleted = 0";
    
        $pdo_statement = $con->prepare($query);
    
        $pdo_statement->execute();
    
        return $pdo_statement->fetch();
    
      }
    
    ?>
    
    
   
    
</body>
</html>