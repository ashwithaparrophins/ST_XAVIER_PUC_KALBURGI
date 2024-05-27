<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo TAB_TITLE; ?> | Student/Parent Log in</title>
    <!-- icons -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" id="main-stylesheet" data-version="1.0.0" href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
   
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
  </head>
  <body class="hold-transition login-page">
      <div class="loader">
        <img id="loader_img" src="<?php echo base_url(); ?>assets/dist/img/student.gif" class="img-fluid" alt="loader">
      </div>
      <div class="row margin_left_right_null">
        <div class="card mx-auto login_card">
          <div class="card-header pb-0">
            <div class="col-xs-12">
              <h6><b>Sign In</b></h6>
            </div>
          </div>
          <div class="card-body">
            <div class="col-xs-12 text-center">
              <img src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" height="80px">
            </div>
            <div class="col-xs-12 mb-2">
              <span><b style="font-size: 25px;"><span class="title_green">School</span><span class="title_blue">Phins</span> - <span class="title_blue"><?php echo SUB_TITLE; ?></span></b></span>
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
            <!-- <form action="<?php echo base_url(); ?>loginMe" method="post" id="login">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text material-icons text-dark">person</span>
                </div>
                <input type="text" class="form-control input_type" placeholder="Username (Student ID)" name="student_id" autocomplete="off" required/>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text material-icons text-dark">lock</span>
                </div>
                <input type="password" class="form-control input_type" placeholder="Password" name="password" autocomplete="off" required/>
              </div>
              <button type="submit" class="btn btn-log btn-block">Student/Parent Log in</button>
            </form> -->
            <div class="col-xs-12 mb-2 text-center">
              <span><b style="font-size: 20px;"><span>Student or Parent Android and iOS App is available</span>  <span class="title_blue"></span></b></span>
            </div>
            <div class="col-xs-12 mb-2 text-center">
              <span><b style="font-size: 20px;"><span>Click here to download </span>  <span class="title_blue"></span></b></span>
            </div>
            <div class="row">
                <!-- <div class="col-sm-6 col-md-6">
                  <a target="_blank" href="<?php echo base_url() ?>assets/downloads/student_SJPUC_UserGuide.pdf" class="float-left" style="margin-top: 10px;"></i></a><br>
                </div>
                <div class="col-sm-6 col-md-6">
                  <a class="float-right" style="margin-top: 10px;" href="<?php echo base_url() ?>forgotPassword">Forgot Password</a>
              </div> -->
              <div class="col-lg-6">
              <!-- <a href="<?php echo base_url() ?>assets/dist/img/app-release.apk" download style="margin-top:10px;"> -->
              <a href="https://play.google.com/store/apps/details?id=com.parrophins.indian_cbse" style="margin-top:10px;"> 
              <img src="<?php echo base_url() ?>assets/dist/img/play2.png" alt="" height="50" width="140"  style="margin-top:10px;border-radius:5px;"></a>
              </div>
              <div class="col-lg-6">
              <a href="https://apps.apple.com/in/app/st-josephs-school-bangalore/id6447512347" >
              <img src="<?php echo base_url() ?>assets/dist/img/app1.jpg" alt="" height="50" width="140"  style="margin-top:10px;border-radius:5px;" >
              </a>
              </div>
              </div>
          </div>
          <div class="card-footer">
            <div class="col-xs-12 text-center">
              <span class="">&copy;<script>document.write(new Date().getFullYear())</script>-24 <a href="http://parrophins.com/" target="_blank"><span class="title_green">School</span><span class="title_blue">Phins</span></a> The Wings of an Education.</span>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script type="text/javascript">
  // $(function() {
  //   $(this).bind("contextmenu", function(e) {
  //       e.preventDefault();
  //   });
  // }); 
  $(window).on("load", function() {
    preloaderFadeOutTime = 500;
    function hidePreloader() {
      var preloader = $('.loader');
      preloader.fadeOut(preloaderFadeOutTime);
    }
    hidePreloader();
  });
</script>   