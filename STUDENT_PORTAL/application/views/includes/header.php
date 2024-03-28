<!DOCTYPE html>

<html>



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $pageTitle; ?></title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png">

    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0"
        href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/styles/extras.1.0.0.min.css">



    <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />

    <!-- FontAwesome 4.3.0 -->

    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />





    <style>
    .error {

        color: red;

        font-weight: normal;

    }
    </style>

<script>      
        function showLoader(){
            $(".custom_loader").addClass('active');
            $("#custom_loader_text").css('display','block');
        }
        function hideLoader(){
            // $(".custom_loader").removeClass('active');
            // $("#custom_loader_text").css('display','none');
        }
        $(document).ready(()=>{
            $(".btn-backtrack").click((evt)=>{
                showLoader();
                if(document.referrer != "" && window.history.length > 1){
                    window.history.go(-1);
                }else{
                    location.href = "<?=base_url()?>dashboard";
                }
            });

            $("form").on('submit',(evt)=>{
                if($(evt.target).data('download_form')){
                    $.cookie('isDownloading', '1');
                    showLoader();
                    const intervalID = setInterval(() => {
                        if($.cookie('isDownloading')==0){
                            hideLoader();
                            clearInterval(intervalID);
                        }
                    }, 2000);                    
                }else{
                    showLoader();
                }
            });

            $("li.nav-item > .nav-link[href*='<?=base_url()?>']").on('click',function(){
                showLoader();
            });
        });
    </script>

    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

    <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
    </script>



    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>



<body class="hold-transition skin-blue sidebar-mini" style="overflow-x: hidden;">

    <div class="wrapper">

        <a href="<?php echo base_url(); ?>" class="logo">

            <div class="container-fluid">

                <div class="row">

                    <!-- Main Sidebar -->

                    <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">

                        <div class="main-navbar">

                            <nav
                                class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">

                                <a class="navbar-brand w-100 mr-0 pt-1" href="#" style="line-height: 25px;">

                                    <div class="d-table m-auto mobile_display_none">

                                        <img id="main-logo" class="d-inline-block mr-1" style="max-width: 50px;"
                                            src="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png" alt="logo">

                                        <h5 class="d-none d-md-inline title_sidenav"><span
                                                class="title_green">School</span><span class="title_blue">Phins</span>

                                        </h5>

                                        <!-- mobile view -->

                                    </div>

                                    <div class="m-auto sidebar_mobile_view">

                                        <img id="main-logo" class="d-inline-block logo_mobile_view mr-0"
                                            style="max-width: 50px;"
                                            src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" alt="logo">

                                        <h4 class="d-md-inline title_mobile_view"><?php echo SUB_TITLE; ?></h4>

                                    </div>

                                </a>

                                <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">

                                    <i class="material-icons">&#xE5C4;</i>

                                </a>

                                <!-- <div class="sidebar_content content d-none d-md-block">

                <i class="sidebar_toggle_icon" id="togglebutton">&#9776;</i>

              </div> -->

                            </nav>

                        </div>

                        <!-- <div class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">

            

          </div> -->

                        <div class="nav-wrapper">

                            <ul class="nav flex-column">

                                <li class="nav-item">

                                    <a class="nav-link" href="<?php echo base_url(); ?>dashboard">

                                        <i class="fa fa-dashboard"></i>

                                        <span>Dashboard</span>

                                    </a>

                                </li>

                                <?php  if(!empty($feedbackStatus)){  ?>

                                <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>viewStaffForFeedback">

                                        <i class="material-icons">&#xE6E1;</i>

                                        <span>Give Staff Feedback</span>

                                    </a>

                                </li>

                                <?php } ?>

                                <?php  if(!empty($feedbackCounsellorStatus)){  ?>

                                <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>viewSadhanaStaffForFeedback">

                                        <i class="material-icons">&#xE6E1;</i>

                                        <span>Give Counsellor Feedback</span>

                                    </a>

                                </li>

                                <?php } ?>




                                <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>examPerformance">

                                        <i class="material-icons">&#xE6E1;</i>

                                        <span>My Performance</span>

                                    </a>

                                </li>

                                <?php if($term_name == 'I PUC'){  ?>

                                <li class="nav-item">

                                <a class="nav-link " href="<?php echo base_url(); ?>examAnnualPerformance">

                                    <i class="material-icons">&#xE6E1;</i>

                                    <span>Annual Exam</span>

                                </a>

                                </li>

                                <?php } ?>

                                <?php if($term_name == 'II PUC'){  ?>


                                <!-- <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>reAdmissionForIIPUC">

                                        <i class="fas fa-rupee-sign"></i>

                                        <span>Fee Payment</span>

                                    </a>

                                </li> -->

                                <?php } ?>









                                <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>myAttendance">

                                        <i class="material-icons">format_list_bulleted</i>

                                        <span>My Attendance</span>

                                    </a>

                                </li>

                              

                                <!-- <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>viewAnnualExam">

                                        <i class="material-icons">description</i>

                                        <span>Annual Exam Result</span>

                                    </a>

                                </li> -->





                                <li class="nav-item">

                                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
                                        class="nav-link  dropdown-toggle">

                                        <i class="fa fa-file"></i>

                                        <span>Reports</span>

                                    </a>

                                    <ul class="collapse list-unstyled ml-3" id="pageSubmenu">

                                        <li class="nav-item">

                                            <a class="nav-link"
                                                href="<?php echo base_url(); ?>overallStudentAttendance">

                                                <i class="material-icons">school</i>

                                                <span>Attendance</span>

                                            </a>

                                        </li>

                                        <!-- <li class="nav-item">

                                            <a class="nav-link" href="<?php echo base_url(); ?>studentLaterComer">

                                                <i class="fa fa-clock-o"></i>

                                                <span>Latecomer</span>

                                            </a>

                                        </li> -->

                                        <!-- <li class="nav-item">

                                            <a class="nav-link"
                                                href="<?php echo base_url(); ?>myNotifications">

                                                <i class="material-icons">notifications</i>

                                                <span>Notifications</span>

                                            </a>

                                        </li> -->

                                    </ul>

                                </li>

                                <li class="nav-item">

                                            <a class="nav-link"
                                                href="<?php echo base_url(); ?>myNotifications">

                                                <i class="material-icons">notifications</i>

                                                <span>Notifications</span>

                                            </a>

                                        </li>




                               
                                <li class="nav-item">

                                    <!-- <a href="#studyMet" data-toggle="collapse" aria-expanded="false"
                                        class="nav-link  dropdown-toggle">

                                        <i class="fa fa-book"></i>

                                        <span>Study Materials</span>

                                    </a> -->

                                    <!-- <ul class="collapse list-unstyled ml-3" id="studyMet"> -->





                                        <!-- <li class="nav-item">

                                            <a class="nav-link" href="<?php echo base_url(); ?>viewOnlineClass">

                                                <i class="material-icons">book</i>

                                                <span>Online Class</span>

                                            </a>

                                        </li> -->

                                        <li class="nav-item">

                                            <a class="nav-link" href="<?php echo base_url(); ?>viewstudyMaterials">

                                                <i class="material-icons">book</i>

                                                <span> Study Materials</span>

                                            </a>

                                        </li>

                                        <!-- <li class="nav-item">

                                            <a class="nav-link" href="<?php echo base_url(); ?>viewYoutubeVideos">

                                                <i class="fa fa-youtube-play"></i>

                                                <span>YouTube</span>

                                            </a>

                                        </li> -->



                                    <!-- </ul> -->

                                </li>



                                <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>mySuggestion">

                                        <i class="material-icons">forum</i>

                                        <span>My Suggestions</span>

                                    </a>

                                </li>

                                <!-- <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>viewTimeTable">

                                        <i class="material-icons">access_time</i>

                                        <span>Time Table</span>

                                    </a>

                                </li> -->



                                <li class="nav-item">

                                    <a class="nav-link " href="<?php echo base_url(); ?>profile">

                                        <i class="material-icons">&#xE7FD;</i>

                                        <span>Profile</span>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </aside>

                    <!-- End Main Sidebar -->

                    <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">

                        <div class="main-navbar sticky-top bg-white">

                            <!-- Main Navbar -->

                            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">

                                <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">

                                    <div class="input-group input-group-seamless ml-3">

                                        <img class="mt-1" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>"
                                            height="50px">

                                        <h4 class="head_title ml-2 mt-2"><?php echo TITLE; ?></h4>

                                    </div>

                                </form>

                                <ul class="navbar-nav border-left flex-row header-nav ">

                                    <!-- <li class="nav-item border-right dropdown notifications">

                                        <a class="nav-link nav-link-icon text-center" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">

                                            <div class="nav-link-icon__wrapper">

                                                <i class="material-icons">help</i>

                                            </div>

                                        </a> -->
<!-- 
                                        <div class="dropdown-menu dropdown-menu-small"
                                            aria-labelledby="dropdownMenuLink">

                                            <a class="dropdown-item"
                                                href="<?php echo base_url() ?>assets/downloads/student_SJPUC_UserGuide.pdf"
                                                target="_blank">

                                                <div class="notification__icon-wrapper">

                                                    <div class="notification__icon">

                                                        <i class="material-icons">help</i>

                                                    </div>

                                                </div>

                                                <div class="notification__content">

                                                    <span class="notification__category">Student Portal</span>

                                                    <p>User Guide</p>

                                                </div>

                                            </a> -->

                                        <!-- </div> -->

                                    <!-- </li> -->



                                    <li class="nav-item border-right dropdown notifications">

                                        <a class="nav-link nav-link-icon text-center" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">

                                            <div class="nav-link-icon__wrapper">

                                                <i class="material-icons">access_time</i>

                                            </div>

                                        </a>

                                        <div class="dropdown-menu dropdown-menu-small"
                                            aria-labelledby="dropdownMenuLink">

                                            <a class="dropdown-item" href="#">

                                                <div class="notification__icon-wrapper">

                                                    <div class="notification__icon">

                                                        <i class="material-icons">access_time</i>

                                                    </div>

                                                </div>

                                                <div class="notification__content">

                                                    <span class="notification__category">Last Login:</span>

                                                    <p><?= empty($last_login) ? "First Time Login" : date('d-m-Y h:m:s A',strtotime($last_login)); ?>

                                                    </p>

                                                </div>

                                            </a>

                                        </div>

                                    </li>
<!-- 
                                    <li class="nav-item border-right dropdown notifications">

                                        <a class="nav-link nav-link-icon text-center" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">

                                            <div class="nav-link-icon__wrapper">

                                                <i class="fas fa-bell"></i>

                                                <?php 

                    $i = 1;
               
                    if(!empty($notificationMsg)){
                     

                      foreach($notificationMsg as $notification){ 

                        ?>

                                                <span class="badge badge-pill badge-danger"><?php echo $i++; ?></span>

                                                <?php  } } ?>

                                            </div>

                                        </a>

                                        <div class="dropdown-menu dropdown-menu-small"
                                            aria-labelledby="dropdownMenuLink">

                                            <?php 

                      if(!empty($notificationMsg)){

                      foreach($notificationMsg as $notification){ ?>

                                            <a class="dropdown-item" href="#">

                                                <div class="notification__icon-wrapper">

                                                    <div class="notification__icon">

                                                        <i class="material-icons">notifications_active</i>

                                                    </div>

                                                </div>

                                                <div class="notification__content mt-1">

                                                    <b><?php echo $notification->message; ?></b>

                                                </div>

                                            </a>

                                            <?php }  }else{ ?>

                                            <a class="dropdown-item" href="#">

                                                <div class="notification__icon-wrapper">

                                                    <div class="notification__icon">

                                                        <i class="material-icons">notifications_none</i>

                                                    </div>

                                                </div>

                                                <div class="notification__content mt-2">

                                                    <b class="">No New Notifications</b>

                                                </div>

                                            </a>

                                            <?php } ?>
                                            <a class="dropdown-item" onclick="showLoader();" href="<?=base_url()?>myNotifications">
                          <div class="notification__content mt-2" style="width:100%">
                              <b class=" float-right">View all <i class="fas fa-arrow-right"></i></b>
                          </div>
                        </a>
                                        </div>

                                    </li> -->

                                    <li class="nav-item dropdown nav-profile">

                                        <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="true" aria-expanded="false">

                                            <img class="user-avatar rounded-circle mr-2"
                                                src="<?php echo $studentInfo->photo_url; ?>"
                                                alt="User Avatar" />



                                            <span
                                                class="d-none d-md-inline-block"><?php echo substr($student_name, 0, 5); ?></span>

                                        </a>

                                        <div class="dropdown-menu dropdown-menu-small dropdown-margin">

                                            <div class="row  user-header text-center">

                                                <div class="col-12 col-lg-12 ">

                                                    <img class=" rounded-circle text-center "
                                                        src="<?php echo $studentInfo->photo_url; ?>"
                                                        alt="User Avatar" height="100" width="100">



                                                    <p class="mb-1"> <?php echo $student_name; ?></p>

                                                    <span style="font-size:12px;"> <?php echo $term_name; ?>

                                                        <?php echo $section_name; ?></span>

                                                </div>

                                            </div>

                                            <hr class="mt-0 mb-1">

                                            <!-- Menu Footer-->

                                            <div class="row user-footer ">

                                                <div class="col-12 col-lg-12 ">

                                                    <a href="<?php echo base_url(); ?>profile"
                                                        class="btn  btn-primary profile-btn pull-left "><i
                                                            class="fa fa-user-circle"></i> Profile</a>

                                                    <a href="<?php echo base_url(); ?>logout"
                                                        class="btn  btn-danger signout-btn  pull-right"><i
                                                            class="fa fa-sign-out"></i> Sign out</a>

                                                </div>

                                            </div>

                                        </div>

                                    </li>

                                </ul>

                                <nav class="nav">

                                    <a href="#"
                                        class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left"
                                        data-toggle="collapse" data-target=".header-navbar" aria-expanded="false"
                                        aria-controls="header-navbar">

                                        <i class="material-icons">&#xE5D2;</i>

                                    </a>

                                </nav>

                            </nav>

                        </div>



                        <script>
                        $('#togglebutton').click(function() {

                                    document.getElementById("mySidebar").style.width = "250px";

                                    document.getElementById("main").style.marginLeft = "250px";

                                }



                                $('#togglebutton').click(function() {

                                        document.getElementById("mySidebar").style.width = "0";

                                        document.getElementById("main").style.marginLeft = "0";

                                    }
                        </script>