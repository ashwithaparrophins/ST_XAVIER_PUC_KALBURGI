<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#db5945">
    <title><?php echo TAB_TITLE; ?> | Student Admission</title>
    <!-- icons -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0" href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.0.0.min.css">
    <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    
    <link href="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
  </head>
  <body class="hold-transition login-page">
     
      <div class="row margin_left_right_null">
        <div class="card mx-auto login_card">
          <div class="card-header pb-0 pt-2 card_background">
            <div class="col-xs-12">
              
              <h5 class="mb-2 font_color text-center"><b class="title_blue">Admission 2024 - 2025 Sign In</b></h5>
            </div>
          </div>
          <div class="card-body">
            <div class="col-xs-12 text-center">
              <img src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO;?>"   height="80px">
            </div>
            <div class="col-xs-12 mb-1 text-center">
              <span><b style="font-size: 25px;"> <?php echo SUB_TITLE;?></b></span>
            </div>
            <?php $this->load->helper('form'); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
              <?php
                $this->load->helper('form');
              ?>
            <form action="<?php echo base_url(); ?>loginMe" method="post" id="login">
              <!-- <div class="form-group mb-2"> 
                <label for="username">Email/Mobile Number</label>
                <input type="text"  class="form-control" placeholder="Email or Mobile Number"  id="username" name="username" autocomplete="off" required/>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" autocomplete="off" class="form-control" placeholder="Password" id="password" name="password" required>
              </div>       -->
              <div class="form-group mb-2"> 
                <label class="student_login mdc-text-field mdc-text-field--filled ">
                  <span class="mdc-text-field__ripple"></span>
                  <input name="username" class="mdc-text-field__input" placeholder="Mobile Number" minlength="10" maxlength="10" onkeypress="return isNumber(event)" type="text" aria-labelledby="my-label-id" autocomplete="off" required>
                  <span class="mdc-floating-label" id="my-label-id" style="font-size:18px;color:#2E2252">Mobile Number</span>
                  <span class="mdc-line-ripple"></span>
                </label>
              </div>

              <!-- <div class="form-group mb-2"> 
                <label class="student_password mdc-text-field mdc-text-field--filled ">
                  <span class="mdc-text-field__ripple"></span>
                  <input name="password" id="password" class="mdc-text-field__input" type="password" aria-labelledby="my-label-id" autocomplete="off" required>
                  <span class="mdc-floating-label" id="my-label-id">Password</span>
                  <span class="mdc-line-ripple"><i class="fa fa-eye-slash" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i></span>
                </label>
              </div>     -->
              
              <button type="submit" class="mdc-button mdc-button--raised btn-log btn-block mt-2">Sign In</button>
              <!-- <a href="<?php echo base_url() ?>studentRegister" class="mdc-button mdc-button--raised btn_submit btn-block" value="Registration" style="margin-top:10px;">New Registration</a> -->
            </form>
            <div class="row">
                <div class="col-sm-6 col-md-6">
                  <a target="_blank" href="<?php echo base_url(); ?>assets/downloads/STUDENT_GUIDE_FOR_ONLINE_ADMISSION_PROCEDURE_2022.pdf" class="float-left" style="margin-top: 10px;">Click here for help <i class="far fa-question-circle"></i></a><br>
                </div>
                <div class="col-sm-6 col-md-6">
                  <!-- <a class="float-right" style="margin-top: 10px;" href="<?php echo base_url() ?>forgotPassword">Forgot Password</a> -->
              </div>
              </div>
          </div>
          <div class="card-footer py-2">
          
            <div class="col-xs-12 text-center py-1">
            <span style="font-size: 10px;color: red;">Note: For the best experience use "Google Chrome" Browser. </span><br>
              <span class="">&copy;<script>document.write(new Date().getFullYear())</script>-<?php echo date('y')+1; ?> <a href="javascript:void(0);"><span class="title_green">School</span><span class="title_blue">phins</span></a> The Wings of an Education.</span>
            </div>
          </div>
        </div>
      </div>   
	    <div class="custom_loader"><span id="custom_loader_text" style="color:#0000ff;font-weight:bold;margin-left: -100%;font-size: 17px;display:none;">Loading...</span></div>
  </body>
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
        box-shadow: rgba(26, 26, 255, 1) 1.5em 0 0 0, rgba(64, 255, 0, 1) 1.1em 1.1em 0 0, rgba(26, 26, 255, 1) 0 1.5em 0 0, rgba(64, 255, 0, 1) -1.1em 1.1em 0 0, rgba(26, 26, 255, 1) -1.5em 0 0 0, rgba(64, 255, 0, 1) -1.1em -1.1em 0 0, rgba(26, 26, 255, 1) 0 -1.5em 0 0, rgba(64, 255, 0, 1) 1.1em -1.1em 0 0;
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
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/additional-methods.js" integrity="sha256-PxEJjwsgsA8v2qW3s/uSv5J00Yw6DQozL54XRIHcGmY=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/extras.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/shards-dashboards.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
<script src="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.js"></script>
<script type="text/javascript">
  mdc.textField.MDCTextField.attachTo(document.querySelector('.student_login'));
  mdc.textField.MDCTextField.attachTo(document.querySelector('.student_password'));
  $(function() {
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
  }); 
  // $(window).on("load", function() {
  //   preloaderFadeOutTime = 500;
  //   function hidePreloader() {
  //     var preloader = $('.loader');
  //     preloader.fadeOut(preloaderFadeOutTime);
  //   }
  //   hidePreloader();
  // });
</script>   
<!-- Loader Script -->
<script>
	function showLoader(){
		$(".custom_loader").addClass('active');
		$("#custom_loader_text").css('display','block');
	}
	function hideLoader(){
		$(".custom_loader").removeClass('active');
		$("#custom_loader_text").css('display','none');
	}
	window.onload = () =>{
		hideLoader();
	}
	$(document).ready(()=>{
		$("form").submit(()=>{
			showLoader();
		});
	});
</script>
<!-- End of Loader Script -->
<!--Custom functions -->
<script src="<?=base_url()?>assets/js/helper.js"></script>
<!-- Sweet Alert -->
<script src="<?=base_url()?>assets/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(document).ready(()=>{
        checkForReply("<?=$this->session->flashdata('success')?>","<?=$this->session->flashdata('error')?>");        
    });
    const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
 
  togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      // this.classList.toggle('fa-eye');
      
      var className = $("#togglePassword").attr('class');
      className = className.indexOf('slash') !== -1 ? 'fa fa-eye' : 'fa fa-eye-slash'

      $("#togglePassword").attr('class', className);
  });
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>  