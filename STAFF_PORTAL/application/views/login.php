<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo TAB_TITLE; ?> | Faculty Log in</title>
    <!-- icons -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- PWA Configuration -->
    <meta name="theme-color" content="#317EFB"/>
    <link rel="manifest" href="manifest.webmanifest?version=1.1">
    <script src="index.js?version=1.1" defer></script>
    <link rel="icon" type="image/png" href="icons/XAVIER_192.png" sizes="192x192"/>
    <link rel="icon" type="image/png" href="icons/XAVIER_128.png" sizes="128x128"/>
    <link rel="apple-touch-icon" href="icons/XAVIER_180.png">

    <link rel="apple-touch-icon" sizes="64x64" href="icons/XAVIER_64.png">
    <link rel="apple-touch-icon" sizes="96x96" href="icons/XAVIER_96.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icons/XAVIER_120.png">
    <link rel="apple-touch-icon" sizes="128x128" href="icons/XAVIER_128.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icons/XAVIER_152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="icons/XAVIER_167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icons/XAVIER_180.png">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <link href="splashscreens/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="splashscreens/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="splashscreens/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="splashscreens/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="splashscreens/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="splashscreens/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="splashscreens/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="splashscreens/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="splashscreens/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="splashscreens/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    
    <meta name="apple-mobile-web-app-title" content="ST XAVIER'S PRE–UNIVERSITY COLLEGE">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <style>
      body {
        -webkit-user-select: none;
        -webkit-tap-highlight-color: transparent;
        -webkit-touch-callout: none;
      }
    </style>
    <!-- End of PWA Configuration -->

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0"
        href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.0.0.min.css">
    <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";        
        function showLoader(){
            $(".custom_loader").addClass('active');
            $("#custom_loader_text").css('display','block');
        }
        function hideLoader(){
            $(".custom_loader").removeClass('active');
            $("#custom_loader_text").css('display','none');
        }
        $(document).ready(()=>{
          hideLoader();
          $("form").submit(()=>{
            showLoader();
          });
        });
    </script>
    <style>
        /* .back_home_page {
    background-image: url(assets/images/bg.png) !important;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover; */
/* } */
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
            background-color: rgba(0,0,0,0.3);
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

        @keyframes marquee {
      0% {
        background-position: 0;
      }

      100% {
        background-position: -1190px;
      }
    }
    </style>
</head>

<body class="hold-transition login-page back_home_page">
    <div class="custom_loader"><span id="custom_loader_text" style="color:blue;font-weight:bold;margin-left: -100%;font-size: 17px;display:none;">Loading...</span></div>
    <div class="row margin_left_right_null">
        <div class="card mx-auto login_card">
            <div class="card-header pb-0">
                <div class="col-xs-12">
                    <h6><b>Faculty Sign In</b></h6>
                </div>
            </div>
            <div class="card-body">
                <div class="col-xs-12 text-center">
                    <img class="mb-2 rounded" height="110"
                        src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" />
                </div>
                <div class="col-xs-12 mb-2">
                    <span><b style="font-size: 25px;">Faculty - <span
                                class="title_blue"><?php echo SUB_TITLE; ?></span></b></span>
                </div>
                <?php $this->load->helper('form'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
                <?php
              $this->load->helper('form');
              $error = $this->session->flashdata('error');
              if($error)
              { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
                <?php }
              $success = $this->session->flashdata('success');
              if($success){
                  ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                </div>
                <?php } ?>
                <form action="<?php echo base_url(); ?>loginMe" method="post" id="login">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text material-icons text-dark">person</span>
                    </div>
                    <input type="text" class="form-control input_type" id="username" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="10"
                       name="username"  required />
                </div>
              <span style="color:black;">Mobile No. should be registered in Institution Record.</span>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <!-- <input type="checkbox" value="remember-me" id="remember_me" class="mr-2"> Remember me -->
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <!-- <a class="float-right" style="margin-top: 10px;" href="<?php echo base_url() ?>forgotPassword">Forgot Password</a>-->
                        </div>
                    </div>
                    <button type="submit" id="get_otp_btn" class="btn btn-success btn-block"><b>Get OTP</b></button>

                </form>
                <div class="row">
                <!-- <div class="col-sm-6 col-md-6">
                  <a target="_blank" href="<?php echo base_url() ?>assets/downloads/student_SJPUC_UserGuide.pdf" class="float-left" style="margin-top: 10px;">Click here to help <i class="far fa-question-circle"></i></a><br>
                </div>
                <div class="col-sm-6 col-md-6">
                  <a class="float-right" style="margin-top: 10px;" href="<?php echo base_url() ?>forgotPassword">Forgot Password</a>
              </div> -->
              <div class="col-lg-6">
              <a href="https://play.google.com/store/apps/details?id=com.parrophins.kjes_staff_app&pli=1"  style="margin-top:10px;"> 
              <img src="<?php echo base_url() ?>assets/dist/img/AgnesPlaystore1.jpg" alt="" height="50" width="140"  style="margin-top:10px;"></a>
              </div>
              <div class="col-lg-6">
              <a href="https://apps.apple.com/in/app/kjes-staff/id6499444716" >
              <img src="<?php echo base_url() ?>assets/dist/img/AgnesAppstore2.png" alt="" height="50" width="140"  style="margin-top:10px;">
              </a>
              </div>
          </div>

            </div>
            <div class="card-footer">
                <div class="col-xs-12 text-center">
                    <span class="footer_text">&copy;<script>
                        document.write(new Date().getFullYear());
                        </script> <a href="http://schoolphins.com/" target="_blank"><span
                                class="title_green">School</span><span class="title_blue">Phins</span></a> The Wings of an Education.</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<!-- <script src="<?php echo base_url(); ?>assets/js/login/login.js" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/additional-methods.js"
    integrity="sha256-PxEJjwsgsA8v2qW3s/uSv5J00Yw6DQozL54XRIHcGmY=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="<?php echo base_url(); ?>scripts/extras.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>scripts/shards-dashboards.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
<script>
// $(function() {
//   $(this).bind("contextmenu", function(e) {
//     e.preventDefault();
//   });
// }); 
$(document).keydown(function(e) {
    if (e.which === 123) {
        return false;
    }
});


$(function() {

    if (localStorage.chkbx && localStorage.chkbx != '') {
        $('#remember_me').attr('checked', 'checked');
        $('#username').val(localStorage.username);
        $('#password').val(localStorage.pass);
    } else {
        $('#remember_me').removeAttr('checked');
        $('#username').val('');
        $('#password').val('');
    }

    $('#remember_me').click(function() {

        if ($('#remember_me').is(':checked')) {
            // save username and password
            localStorage.username = $('#username').val();
            localStorage.pass = $('#password').val();
            localStorage.chkbx = $('#remember_me').val();
        } else {
            localStorage.username = '';
            localStorage.pass = '';
            localStorage.chkbx = '';
        }
    });
});
</script>