
<style>
    
  form .input-field {
  flex-direction: row;
  column-gap: 10px;
}
:where(.container, form, .input-field, header) {
  display: flex;
  flex-direction: column;
  align-items: center; 
  justify-content: center;
  
}
form .input-field {
  flex-direction: row;
  column-gap: 10px;
}
.input-field input {
  height: 45px;
  width: 60px;
  border-radius: 6px;
  outline: none;
  font-size: 1.125rem;
  text-align: center;
  border: 1px solid #ddd;
}
.input-field input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.input-field input::-webkit-inner-spin-button,
.input-field input::-webkit-outer-spin-button {
  display: none;
}
form button {
  margin-top: 25px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  border: none;
  padding: 9px 0;
  cursor: pointer;
  border-radius: 6px;
  pointer-events: none;
  background: #6e93f7;
  transition: all 0.2s ease;
}
form button.active {
  background: #4070f4;
  pointer-events: auto;
}
form button:hover {
  background: #0e4bf1;
}
#get_otp_btn{
  width: 330px;
  background-color:#17c671;
  border-color:#17c671;
}
</style>
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
            box-shadow: rgba(255, 128, 0, 1) 1.5em 0 0 0, rgba(128, 255, 0, 1) 1.1em 1.1em 0 0, rgba(255, 128, 0, 1) 0 1.5em 0 0, rgba(128, 255, 0, 1) -1.1em 1.1em 0 0, rgba(255, 128, 0, 1) -1.5em 0 0 0, rgba(128, 255, 0, 1) -1.1em -1.1em 0 0, rgba(255, 128, 0, 1) 0 -1.5em 0 0, rgba(128, 255, 0, 1) 1.1em -1.1em 0 0;
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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo TAB_TITLE; ?> | Faculty Log in</title>
    <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/Holyangle_logo.png"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- PWA Configuration -->
    <meta name="theme-color" content="#317EFB"/>
    <!-- <link rel="manifest" href="manifest.webmanifest?version=1.1"> -->
    <script src="index.js?version=1.1" defer></script>
    <link rel="icon" type="image/png" href="icons/.png" sizes="192x192"/>
    <link rel="icon" type="image/png" href="icons/.png" sizes="128x128"/>
    <link rel="apple-touch-icon" href="icons/.png">

    <link rel="apple-touch-icon" sizes="64x64" href="icons/.png">
    <link rel="apple-touch-icon" sizes="96x96" href="icons/.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icons/.png">
    <link rel="apple-touch-icon" sizes="128x128" href="icons/.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icons/.png">
    <link rel="apple-touch-icon" sizes="167x167" href="icons/.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icons/.png">

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
    
    <meta name="apple-mobile-web-app-title" content="ST. JOSEPH SCHOOL">
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
  <body class="hold-transition login-page back_home_page">
  <div id="custom_loader" class="custom_loader"></div>
      <div class="row margin_left_right_null">
        <div class="card mx-auto login_card">
          <div class="card-header pb-0">
            <div class="col-xs-12">
              <h6><b>Enter OTP Code</b></h6>
            </div>
          </div>
          <div class="card-body">
            <div class="col-xs-12 text-center">
            <img class="mb-2 rounded" height="110" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" /> 
            </div>
            <div class="col-xs-12 mb-2">
              <span><b style="font-size: 20px;"><span class="title_blue"><?php echo SUB_TITLE; ?></span></b></span>
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
              <form action="<?php echo base_url(); ?>checkStaffOtp" method="post" id="studentForgotPassword">
              <div class="text-center" id="alertMsg"></div>
              <input type="hidden" name="username" id="username" value="<?php echo $username_entered ?>" />
              <div class="row" >
                  <label for="otp" style="color:black;">Enter the OTP sent to <?php echo $username;?></label>
              </div>
              <div class="input-field">
                  <input type="number" name="otp[]"/>
                  <input type="number" name="otp[]" disabled />
                  <input type="number" name="otp[]" disabled />
                  <input type="number" name="otp[]" disabled />
              </div>
              <div id="timer" class="text-center" style="color:black;"></div> <!-- Add timer display here -->
            
              <div class="row mt-1">
                <div class="col-xs-6 col-sm-6  col-md-12">
                  <input type="submit" id="get_otp_btn" class="btn btn_submit btn-block" value="Verify OTP" />
                  <!-- <button type="submit" id="get_otp_btn" class="btn btn-success btn-block"><b>Verify OTP</b></button> -->

                </div>
              </div>
           
              <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-12">
                      <span class="float-right" style="margin-top: 10px;color:black;"id="resendLink">Didn't receive the OTP? <a href="#" id="resendOTP">Resend OTP</a></span><br>
                  </div>
              </div>
            </form> 
            <div class="row">
                <div class="col-sm-12 col-md-12">
                  <!-- <a class="float-right" style="margin-top: 10px; color: white;" href="<?php echo base_url() ?>forgotPassword">Forgot Password?</a> -->
              </div>
              </div>
          </div>
          <div class="card-footer">
            <div class="col-xs-12 text-center">
              <span class="footer_text">&copy;<script>document.write(new Date().getFullYear());</script> <a href="http://schoolphins.com/" target="_blank"><span class="title_green">School</span><span class="title_blue">phins</span></a> The Wings of an Education.</span>
            </div>
          </div>
        </div>
      </div>
      <div class="custom_loader"><span id="custom_loader_text" style="color:blue;font-weight:bold;margin-left: -100%;font-size: 17px;display:none;">Loading...</span></div>
  </body>
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
      .back_home_page {
            background-image: url('<?php echo base_url(); ?>assets/dist/img/holyangelcover.jpg') !important;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /* Add a fallback background color */
            background-color: #f8f9fa; /* Choose a suitable color */
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
</html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/extras.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/shards-dashboards.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
<script src="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.js"></script>
<script>
 mdc.textField.MDCTextField.attachTo(document.querySelector('.email'));
jQuery(document).ready(function(){
  jQuery('.datepicker').datepicker({
    autoclose: true,
    format : "dd-mm-yyyy"
  });
});
</script>
<script>

 // Function to start the timer
 function startTimer() {
        var duration = 180; // 3 minutes
        var timerDisplay = document.getElementById('timer');
        var resendLink = document.getElementById('resendLink');
        
        function updateTimer() {
            var minutes = Math.floor(duration / 60);
            var seconds = duration % 60;

            timerDisplay.textContent = "Resend OTP in: " + minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');

            if (duration <= 0) {
                clearInterval(timerInterval);
                // Show the "Resend OTP" link
                resendLink.style.visibility = 'visible';
            } else {
                duration--;
                // Hide the link
                resendLink.style.visibility = 'hidden';
            }
        }

        var timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    }

     // Call startTimer() function when the page loads initially
     window.onload = function() {
        startTimer();
    }
jQuery(document).ready(function() {
  $('#resendOTP').click(function() {
        var username = $("#username").val();
     
        //$('#alertMsg').html('<span>' + loader + '</span>');
        //$('#shortListModelView').modal('show');
        
        $.ajax({
            url: baseURL + '/getOtp',
            type: 'POST',
            data: {
               
              username : username,
            },
            success: function(data) {
              alert("New OTP has been sent!");
                if (data > 0) {  
                  $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  New OTP has been sent!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
               }
                // setTimeout(function() {
                    // location.reload();
                    //$('#shortListModelView').modal('hide');
                  // Start the timer again
                  startTimer();
                // }, 2000);

            },
            error: function(result) {
                alert("Retry Again! Something Went Wrong");
            },
            fail: (function(status) {
                alert("Retry Again! Something Went Wrong");
            }),
            beforeSend: function(d) {
               // $('#alertMsg').html('<span>' + loader + '</span>');
            }
        });

    });
  });
  
</script>
<script type="text/javascript">
  $(function() {
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
  }); 
  $(window).on("load", function() {
    preloaderFadeOutTime = 500;
    function hidePreloader() {
      var preloader = $('.loader');
      preloader.fadeOut(preloaderFadeOutTime);
    }
    hidePreloader();
  });
</script> 
<script>
  const inputs = document.querySelectorAll("input[type='number']"),
  // button = document.querySelector("button");
  submitBtn = document.getElementById("get_otp_btn");
  // iterate over all inputs
  inputs.forEach((input, index1) => {
  input.addEventListener("keyup", (e) => {
    // This code gets the current input element and stores it in the currentInput variable
    // This code gets the next sibling element of the current input element and stores it in the nextInput variable
    // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
  const currentInput = input,
  nextInput = input.nextElementSibling,
  prevInput = input.previousElementSibling;
  // if the value has more than one character then clear it
  if (currentInput.value.length > 1) {
    currentInput.value = "";
    return;
  }
  // if the next input is disabled and the current value is not empty
  //  enable the next input and focus on it
  if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
    nextInput.removeAttribute("disabled");
    nextInput.focus();
  }
  // if the backspace key is pressed
  if (e.key === "Backspace") {
  // iterate over all inputs again
    inputs.forEach((input, index2) => {
    // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
    // and the previous element exists, set the disabled attribute on the input and focus on the previous element
      if (index1 <= index2 && prevInput) {
        input.setAttribute("disabled", true);
        input.value = "";
        prevInput.focus();
      }
    });
  }
    //if the fourth input( which index number is 3) is not empty and has not disable attribute then
    //add active class if not then remove the active class.
    if (!inputs[4].disabled && inputs[4].value !== "") {
      submitBtn.classList.add("active");
      return;
    }
    submitBtn.classList.remove("active");
  });
});
//focus the first input which index is 0 on window load
window.addEventListener("load", () => inputs[0].focus());


</script>  
<script>
    document.getElementById('studentForgotPassword').addEventListener('submit', function() {
    var otpInputs = document.querySelectorAll('input[name="otp[]"]');
    var otpValue = '';
    otpInputs.forEach(function(input) {
        otpValue += input.value;
    });
    // Assign concatenated OTP value to a hidden input field
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'otp_value';
    hiddenInput.value = otpValue;
    this.appendChild(hiddenInput);
});

document.getElementById("get_otp_btn").addEventListener("click", function() {
    // Show loader when button is clicked
    document.getElementById("custom_loader").classList.add("active"); // Add the 'active' class to show the loader

    // Simulate OTP verification process (replace this with your actual verification logic)
    setTimeout(function() {
        // Wait for the window to finish loading before hiding the loader
        window.addEventListener("load", function() {
            // Hide loader after verification process is complete and window has loaded
            document.getElementById("custom_loader").classList.remove("active"); // Remove the 'active' class to hide the loader
        });
    }, 2000); // Simulating 2 seconds delay, replace with actual verification process time
});

</script>