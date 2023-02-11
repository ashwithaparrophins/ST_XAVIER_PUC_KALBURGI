<div class="loader">
  <img id="loader_img" src="<?php echo base_url(); ?><?php echo LOADER_IMG; ?>" class="img-fluid" alt="loader">
</div>
<style>
.form-group {
    margin-bottom: 0rem !important;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>
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

<div class="row ">
  <div class="col-md-12 col-lg-12 col-12">
      <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
  </div>
</div>
<div class="main-content-container container-fluid px-4 ">
  <div class="row mt-1 mb-2">
    <div class="col padding_left_right_null">
      <div class="card card-small p-0 card_head_dashboard">
          <div class="card-body p-2 ml-2">
            <span class="page-title">
                <i class="fa fa-dashboard"></i> Dashboard / Status
            </span>
          </div>
      </div>
      </div>
  </div>
    

  <div class="row padding_left_right_null">
    <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="#" class="dashboard_link">
        <div class="card card-small dash-card" style="background: #b0cfff;">
          <div class="card-body text-center py-2 mt-3">
            <span class="stats-small__label text-uppercase text-dark">Application Status</span>
            <div class="icon pull-right mt-3">
              <i class="fa fa-file dash-icons"></i>
            </div>
          </div>
          <div class="card-footer text-center dash-footer p-2">
            <div class="more-info text-dark"><i class=""></i></div>
            <span class="text-center"><?php if(!empty($studentApplicationStatus)){
            if($studentApplicationStatus->joined_status == 1){
              echo "<b style='color:green'>Admission Completed</b>";
            }else if($studentApplicationStatus->interview_status == 1){ 
              echo '<a href="'.base_url().'viewAdmission" class="btn btn-danger btn-lg btn-block my-1 mx-1 float-right">Click here for fee payment</a>';
            }else if($studentApplicationStatus->admission_status == 1){ 
              echo '<span class="text-dark">YOUR APPLICATION HAS BEEN VERIFIED BY OUR TEAM AND SUCCESSFULLY SUBMITTED FOR FURTHER SCRUTINY. 
              List of the provisionally selected candidates will be announced on www.sjpuc.in as per the PU Board guidelines. Date will be notified soon.</span>';
            }else if($studentApplicationStatus->admission_status == 2){ 
              echo '<span class="text-dark">YOUR APPLICATION IS INCOMPLETE.
              Kindly rectify the following:<br>'.
              $studentApplicationStatus->comments
              .'</span>';?>
              <a href='<?php echo base_url(); ?>viewPersonalDetail'>Click here for edit</a>
              <?php
            }else{ 
              echo '<span class="text-dark">Application Successfully Applied</span>';
            } }?></span>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="<?php echo base_url(); ?>viewPrintApplication" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">View Application</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div><br>
          <span class="text-center text-dark">View/Print</span>
        </div>
      </div>
      </a>
    </div>
    <?php if($studentApplicationStatus->prospective_status ==0 && $studentApplicationStatus->admission_status ==0){?>

    <div class="col-lg-12 col-12 mb-4 column_padding_card">
                <div class="card">
                    <div class="card-body text-center">
                    <div class="alert alert-warning mb-1" role="alert">
                    <b style="color:red">Note: </b><b style="color:black">If you want digital prospective Please pay 75Rs</b></div>
               <div class="text-center">
               <a href="<?php echo base_url()?>payTmPaymentProcess" class="btn btn-success btn-sm my-1 mx-1 ">Click Here to Pay Prospective Fee</a>
               </div>      
                    </div>
                </div>
            </div>
            <?php }else if($studentApplicationStatus->prospective_status ==1 && $studentApplicationStatus->admission_status ==0){?>
              <div class="col-lg-12 col-12 mb-4 column_padding_card">
                <div class="card">
                    <div class="card-body text-center">  
                <div class="alert alert-warning mb-1" role="alert">
               <b style="color:black">Thank You! Prospective Fee is Paid Rs 75</b><br></div>
               <div class="text-center">
             <a class="align-center" href="https://sjpuc.schoolphins.com/admission/assets/dist/img/pros_2.pdf" class="float-left text-primary font-weight-bold" download>Click Here To Download Brochure</a></div>
              </div>
                </div>
              </div>
             <?php }?>

    

    <?php if(!empty($studentApplicationStatus)){
            if($studentApplicationStatus->joined_status == 1){ ?>


      <!-- <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <div class="card">
        <div class="card-header">
        PUC COLLEGE SHOES AND SOCKS (UNIFORM)
        </div>
        <div class="card-body text-center" style="padding: 0px;">
        <a href="http://sjpuc.schoolphins.com/assets/images/uniform.jpeg" download> Click here to download</a>
        <img src="http://sjpuc.schoolphins.com/assets/images/uniform.jpeg" height="350" class=" img img-responsive uniform_image"/>
        </div>
      </div>
      </div>
    <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="http://sjpuc.schoolphins.com/admission/assets/images/GENERAL%20INSTRUCTIONS.pdf" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">GENERAL INSTRUCTIONS</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->

    <!-- <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="http://sjpuc.schoolphins.com/admission/assets/images/SJPUC handbook 2020-21.pdf" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">HANDBOOK 2020-21</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->
   
    <!-- <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="https://www.youtube.com/watch?v=Q-vCvhK-OKM" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">MICROSOFT TEAMS STUDENT GUIDE</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->

<!-- 
    <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="http://sjpuc.in/announcements/Notebook%20list.pdf" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">NOTEBOOK LIST</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->

<!-- 
    <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="https://www.youtube.com/watch?v=0alvBLGJxY4" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">I PUC ORIENTATION PROGRAM 2020-21</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->
    <!-- <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="http://sjpuc.in/admission_20_21/STUDENT%20GUIDE%20TO%20USE%20MICROSOFT%20TEAM%20FOR%20ONLINE%20TEACHING.pdf" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">GUIDE FOR - ONLINE CLASSES</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->
    <!-- <div class="col-lg-6 col-6 mb-4 column_padding_card">
      <a href="http://sjpuc.in/admission_20_21/GUIDELINES%20TO%20PARENTS%20AND%20STUDENTS%20WITH%20REGARD%20TO%20ONLINE%20CLASSES-%20I%20PUC.pdf" target="_blank" class="dashboard_link">
      <div class="card card-small dash-card" style="background: #b0cfff;">
        <div class="card-body text-center py-2 mt-3">
          <span class="stats-small__label text-uppercase text-dark">GUIDELINES TO PARENTS & STUDENTS- ONLINE CLASSES</span>
          <div class="icon pull-right mt-3">
            <i class="fa fa-file dash-icons"></i>
          </div>
        </div>
        <div class="card-footer text-center dash-footer p-0">
          <div class="more-info text-dark"><i class="fa fa-eye"></i></div>
          <span class="text-center text-dark">CLICK HERE</span>
        </div>
      </div>
      </a>
    </div> -->

            <?php } } ?>
    
  </div> 


 
  <!-- End Page Header -->
  <div class="row">

  </div>

  
  <div class="modal" id="microsoftTeamId">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header table-primary">
          <h5 class="modal-title ">Online Class - Microsoft Teams Credentials</h5>
          <button type="button" class="close" id="microsoftModalClose" data-dismiss="modal">&times;</button>
        </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <table class="table" style="font-size: 16px;">
                  <tr>
                    <th>Username <span class="float-right">:</span></th>
                    <th><?php echo $microsoftTeamInfo->username; ?></th>
                  </tr>
                  <tr>
                    <th>Password <span class="float-right">:</span></th>
                    <th><?php echo $microsoftTeamInfo->password; ?></th>
                  </tr>
                </table>
                <hr class="my-1">
                <span class="font-weight-bold">Microsoft Teams Helpline no. : 9538030893</span>
                <a href="http://sjpuc.schoolphins.com/assets/images/uniform.jpeg" download>Click here PUC COLLEGE SHOES AND SOCKS (UNIFORM)</a>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="microsoftModalCloseBtn" data-dismiss="modal">Close</button>
          </div>

      </div>
    </div>
  </div>
  </div>
  
    
</div>



<?php 
if(!empty($microsoftTeamInfo)){
  echo "<script>var applicationStatus = 1;</script>";
}else{
  echo "<script>var applicationStatus = 0;</script>";
}
?>
<script>

$(window).on("load", function() {
  setTimeout(function(){
    $(".loader").hide();
  }, 500);
 
  if(applicationStatus == 1){
   // $('#microsoftTeamId').show();
  }else{
  //  $('#microsoftTeamId').hide();
  }
});


// for modal dismiss button 
$('#microsoftModalClose,#microsoftModalCloseBtn').on('click', function () {
  $('#microsoftTeamId').hide();
})

$("#icons").css('color', '#008000');
$("#icon").css('color', '#008000');
$("#combination").css('color', '#008000');
$("#document").css('color', '#008000');
$("#payment").css('color', '#008000');

function onlyAlphabets(e, t) {
  return (e.charCode > 64 && e.charCode < 91) || (e.charCode > 96 && e.charCode < 123) || e.charCode == 32;   
}
function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
  }
  return true;
}
</script>