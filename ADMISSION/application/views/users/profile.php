 <style>
    <?php if($_SESSION['application_number_status'] == false){ ?>
    .main-sidebar .nav #schoolDetailLink, .main-sidebar .nav #combinationDetailLink,
    .main-sidebar .nav #documentDetail, .main-sidebar .nav #paymentDetail{
        display: none !important;
    }

    <?php } 
    if($_SESSION['application_number_status'] == true){ ?> 
      #icons, #icon, #combination, #document, #payment{
        color: #008000 !important;
      }
    <?php } ?>
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
                <i class="fa fa-user-circle"></i> My Profile
              </span>
            <a onclick="showLoader();window.history.back();" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>
            </div>
          </div>
        </div>
      </div>
  </section>
  <div class="row form-employee">
    <div class="col-lg-3 col-md-3 col-sm-3 pr-0 padding_left_right_null">
      <div class="card card-small c-border mb-4 p-1">
        <div class="card-header text-center profile-img">
          <?php if(!empty($photoInfo->doc_path)){ ?>
            <img src="<?php echo base_url(); ?><?php echo $photoInfo->doc_path; ?>" class="avatar rounded-circle img-thumbnail" width="130" height="130" alt="User Image" >  
          <?php }else{ ?>
            <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="avatar rounded-circle img-thumbnail" width="130" height="130" alt="User Image" >  
          <?php } ?>
        </div>
        <div class="card-body text-center profile_sidebar pt-0 pl-0 pr-0 mt-1">
          <div class="p-1">
            <i class="fa fa-id-card"></i>
            <span style="color: #1e64b9;"></span>
            <?php echo $name; ?>
          </div><hr class="mt-1 mb-1">
          <div class="p-1">
            <i class="fas fa-mobile-alt"></i>
            <span><?php echo $studentInfo->mobile; ?></span>
          </div><hr class="mt-1 mb-1">
          <div class="p-1">
            <i class="fas fa-envelope"></i>
            <span><?php echo $studentInfo->email; ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-sm-9 padding_left_right_null">
      <div class="card card-small c-border mb-4">
        <ul class="list-group list-group-flush">
          <li class="list-group-item p-3">
            <div class="row">
              <div class="col profile-head">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="password-tab" data-toggle="tab" href="#changePassword" role="tab" aria-controls="password" aria-selected="false">Change Password</a>
                  </li>
                </ul>
                <div class="tab-content profile-tab" id="myTabContent">
                  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table profile_table">
                      <tbody>
                        <tr>
                          <th width="200">Name<span class="float-right">:</span></th>
                          <td><?php echo $studentInfo->name; ?></td>
                        </tr>      
                        <!-- <tr>
                          <th>10th Register/Hall Ticket/ Unique No.<span class="float-right">:</span> </th>
                          <td><?php echo $studentInfo->registration_number; ?></td>
                        </tr>   -->
                        <tr>
                          <th>Mobile No.<span class="float-right">:</span></th>
                          <td><?php echo $studentInfo->mobile; ?></td>
                        </tr>  
                        <tr>
                          <th>Email<span class="float-right">:</span></th>
                          <td><?php echo $studentInfo->email; ?></td>
                        </tr>  
                      </tbody>
                    </table>    
                  </div>
                  <div class="<?= ($active == "changepass")? "active" : "" ?> tab-pane fade mx-auto" id="changePassword" role="tabpanel" aria-labelledby="password-tab">
                    <form role="form" method="post" action="<?php echo base_url() ?>changePassword">
                      <div class="input-group mb-2 profile_changePassword">
                         <label class="oldPassword mdc-text-field mdc-text-field--filled ">
                            <span class="mdc-text-field__ripple"></span>
                            <input name="oldPassword" id="oldPassword" class="mdc-text-field__input" type="password" aria-labelledby="my-label-id"
                            value="" autocomplete="off" required/>
                            <span class="mdc-floating-label" id="my-label-id">Old password</span>
                            <span class="mdc-line-ripple"><i class="fa fa-eye-slash" id="togglePassword" style="margin-left: -30px; cursor: pointer;color:black;"></i></span>
                        </label>
                      </div>
                      <div class="input-group mb-2 profile_changePassword">
                        <label class="newPassword mdc-text-field mdc-text-field--filled ">
                            <span class="mdc-text-field__ripple"></span>
                            <input name="password" id="password" class="mdc-text-field__input" type="password" aria-labelledby="my-label-id"
                            value="" autocomplete="off" required/>
                            <span class="mdc-floating-label" id="my-label-id">New password</span>
                            <span class="mdc-line-ripple"><i class="fa fa-eye-slash" id="togglePasswordn" style="margin-left: -30px; cursor: pointer;color:black;"></i></span>
                        </label>
                      </div>
                      <div class="input-group mb-2 profile_changePassword">
                        <label class="cPassword mdc-text-field mdc-text-field--filled ">
                            <span class="mdc-text-field__ripple"></span>
                            <input name="cpassword" id="cpassword" class="mdc-text-field__input" type="password" aria-labelledby="my-label-id"
                            value="" autocomplete="off" required/>
                            <span class="mdc-floating-label" id="my-label-id">Re-Type password</span>
                            <span class="mdc-line-ripple"><i class="fa fa-eye-slash" id="togglePasswordc" style="margin-left: -30px; cursor: pointer;color:black;"></i></span>
                        </label>
                      </div>
                      <div class="text-center">
                        <button class="mdc-button mdc-button--raised btn_primary" type="submit">
                          <span class="mdc-button__label">Update</span>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>  
</div>
<script type="text/javascript">
  mdc.textField.MDCTextField.attachTo(document.querySelector('.oldPassword'));
  mdc.textField.MDCTextField.attachTo(document.querySelector('.newPassword'));
  mdc.textField.MDCTextField.attachTo(document.querySelector('.cPassword'));
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#oldPassword');
 
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    // this.classList.toggle('fa fa-eye');
    var className = $("#togglePassword").attr('class');
    className = className.indexOf('slash') !== -1 ? 'fa fa-eye' : 'fa fa-eye-slash'

    $("#togglePassword").attr('class', className);
});


const togglePasswordc = document.querySelector('#togglePasswordc');
  const passwordc = document.querySelector('#cpassword');
 
  togglePasswordc.addEventListener('click', function (e) {
    // toggle the type attribute
    const typec = passwordc.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordc.setAttribute('type', typec);
    // toggle the eye slash icon
    // this.classList.toggle('fa fa-eye');

    var className = $("#togglePasswordc").attr('class');
    className = className.indexOf('slash') !== -1 ? 'fa fa-eye' : 'fa fa-eye-slash'

    $("#togglePasswordc").attr('class', className);
});

const togglePasswordn = document.querySelector('#togglePasswordn');
  const passwordn = document.querySelector('#password');
 
  togglePasswordn.addEventListener('click', function (e) {
    // toggle the type attribute
    const typec = passwordn.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordn.setAttribute('type', typec);
    // toggle the eye slash icon
    // this.classList.toggle('fa fa-eye');

    var className = $("#togglePasswordn").attr('class');
    className = className.indexOf('slash') !== -1 ? 'fa fa-eye' : 'fa fa-eye-slash'

    $("#togglePasswordn").attr('class', className);
});
</script>