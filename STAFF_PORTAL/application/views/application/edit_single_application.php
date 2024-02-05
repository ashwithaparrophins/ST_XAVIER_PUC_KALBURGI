<style>
.bootstrap-select > .dropdown-toggle{ 
  background: #f5f5f5 !important;
  color: rgb(66 65 65 / 87%) !important;
  height: 58px !important;
  font-size: 20px !important;
  padding: 15px !important;
  border-bottom: 1px solid black !important;
  border-radius: 0px !important;
}


.bootstrap-select > .dropdown-toggle:focus, .bootstrap-select > .dropdown-toggle:hover, .bootstrap-select > .dropdown-toggle:active{ 
  border-bottom: 1px solid #6200ee !important;
  border-top: 1px solid transparent !important;
  border-left: 1px solid transparent !important;
  border-right: 1px solid transparent !important;
  border-radius: 0px !important;
  box-shadow: inset 0 3px 5px rgba(0,0,0,0)!important;
}

.show>.btn-light.dropdown-toggle {
  border-bottom: 1px solid #6200ee !important;
  border-top: 1px solid transparent !important;
  border-left: 1px solid transparent !important;
  border-right: 1px solid transparent !important;
  border-radius: 0px !important;
  box-shadow: inset 0 3px 5px rgba(0,0,0,0)!important;
}


.bootstrap-select .dropdown-menu {
  z-index: 9999 !important;
}

</style>
<?php   
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) {
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<?php 
$certificate_uploaded = array();
$certificate_uploaded_name = array();
?>

<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-user"></i>&nbsp;Edit Application <?php echo $applicationInfo->application_number.' - '.$studentInfo->name; ?>
                            </div>
                            <div class="col-md-4 col-4">
                                <a onclick="showLoader();" href="<?php echo base_url() ?>getAllApplicationInfo" 
                                    class="btn text-white primary_color btn-bck pull-right mobile-bck ">
                                    <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form start -->
        <!-- Default Light Table -->
        <?php //if(empty($appInfo)){ ?>
        <!-- <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
                <img height="270" src="<?php echo base_url(); ?>assets/images/404.png" />
            </div>
        </div> -->
        <?php //} else {  ?>
        <div class="row form-employee">
            <div class="col-12">
                <div class="card card-small c-border p-0 mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-1">
                            <div class="row">
                                <div class="col profile-head">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="personal-tab" data-toggle="tab"
                                                href="#personal" role="tab" aria-controls="personal"
                                                aria-selected="false">Personal Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic"
                                                role="tab" aria-controls="academic" aria-selected="true">Academic
                                                Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="admi-tab" data-toggle="tab" href="#admi" role="tab"
                                                aria-controls="admi" aria-selected="true">Admission
                                                Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="document-tab" data-toggle="tab" href="#document"
                                                role="tab" aria-controls="document" aria-selected="true">Document
                                                Info</a>
                                        </li>
                                        <?php if($studentInfo->joined_status!=1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="approve-tab" data-toggle="tab" href="#approve"
                                                role="tab" aria-controls="approve" aria-selected="true">Approve/Reject</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <form role="form" method="post" action="<?php echo base_url(); ?>updateStudentPersonalData">
                                            <input type="hidden" value="<?php echo $studentInfo->resgisted_tbl_row_id; ?>" id="registered_row_id" name="registered_row_id"/>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-7 col-sm-6">
                                                            <div class="form-group "> 
                                                            <label class="std_name mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input name="fname" id="fname" value="<?php echo $studentInfo->name; ?>" class="mdc-text-field__input text-uppercase" type="text" aria-labelledby="my-label-id"  maxlength="128" autocomplete="off" required>
                                                                <span class="mdc-floating-label" id="my-label-id">Full Name (As per 10th standard records)</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-5 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="dob mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="dob" id="dob" value="<?php echo date('d-m-Y',strtotime($studentInfo->dob)); ?>" class="mdc-text-field__input datepicker" type="text" aria-labelledby="my-label-id" autocomplete="off">
                                                                    <span class="mdc-floating-label" id="my-label-id">Date of Birth</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="native_place mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="native_place" id="native_place" value="<?php echo $studentInfo->native_place; ?>" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" autocomplete="off" required>
                                                                    <span class="mdc-floating-label" id="my-label-id">Native place</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="gender mdc-text-field mdc-text-field--filled">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="gender" id="gender" value="<?php echo $studentInfo->gender; ?>" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" autocomplete="off" required readonly>
                                                                    <span class="mdc-floating-label" id="my-label-id">Admission only for Male Candidate</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-gender mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="gender"
                                                                            id="gender" value="" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Select Gender</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div
                                                                        class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <?php if(!empty($studentInfo->gender)){ ?>
                                                                            <li class="mdc-list-item mdc-list-item--selected"
                                                                                data-value="<?php echo $studentInfo->gender; ?>" aria-selected="true">
                                                                                <?php echo $studentInfo->gender; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="MALE">
                                                                                <span class="mdc-list-item__text">MALE</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="FEMALE">
                                                                                <span class="mdc-list-item__text">FEMALE</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="student_email mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="student_email" id="student_email" value="<?php echo $studentInfo->student_email; ?>" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" autocomplete="off" >
                                                                    <span class="mdc-floating-label" id="my-label-id">Student Email</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="student_mobile mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input name="student_mobile" id="student_mobile" pattern="[0-9]*" value="<?php echo $studentInfo->student_mobile; ?>" class="mdc-text-field__input" type="tel" aria-labelledby="my-label-id" maxlength="10" required autocomplete="off" onkeypress="return isNumber(event)" >
                                                                <span class="mdc-floating-label" id="my-label-id">Whatsapp Number</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                   
                                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                         <div class="form-group">
                                             <label class="native_taluk mdc-text-field mdc-text-field--filled ">
                                                 <span class="mdc-text-field__ripple"></span>
                                                 <input name="native_taluk" id="native_taluk"
                                                     onkeydown="return alphaOnly(event)"
                                                     value="<?php echo $studentInfo->native_taluk; ?>" class="mdc-text-field__input"
                                                     type="text" aria-labelledby="my-label-id" autocomplete="off" placeholder="Place of birth (Taluk)"
                                                     required>
                                                 <span class="mdc-floating-label" id="my-label-id">Place of birth (Taluk)</span>
                                                 <span class="mdc-line-ripple"></span>
                                             </label>
                                         </div>
                                     </div>

                                     <div class="col-lg-4 col-md-6 col-sm-6">
                                         <div class="form-group">
                                             <label class="native_district mdc-text-field mdc-text-field--filled ">
                                                 <span class="mdc-text-field__ripple"></span>
                                                 <input name="native_district" id="native_district"
                                                     onkeydown="return alphaOnly(event)"
                                                     value="<?php echo $studentInfo->native_district; ?>" class="mdc-text-field__input"
                                                     type="text" aria-labelledby="my-label-id" autocomplete="off" placeholder="Place of birth (District)"
                                                     required>
                                                 <span class="mdc-floating-label" id="my-label-id">Place of birth (District)</span>
                                                 <span class="mdc-line-ripple"></span>
                                             </label>
                                         </div>
                                     </div>

                                     <div class="col-lg-4 col-md-6 col-sm-6">
                                         <div class="form-group">
                                             <div
                                                 class="mdc-select mdc-select-nativeState mdc-select--required">
                                                 <div class="mdc-select__anchor" aria-required="true">
                                                     <span class="mdc-select__ripple"></span>
                                                     <input type="text" class="mdc-select__selected-text"
                                                         name="native_state" id="native_state"
                                                         value="" required>
                                                     <i class="mdc-select__dropdown-icon"></i>
                                                     <span class="mdc-floating-label">Place of Birth (State)</span>
                                                     <span class="mdc-line-ripple"></span>
                                                 </div>
                                                 <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                                     <ul class="mdc-list">
                                                         <?php if(!empty($studentInfo->native_state)){ ?>
                                                         <li class="mdc-list-item mdc-list-item--selected"
                                                             data-value="<?php echo $studentInfo->native_state; ?>">
                                                             <?php echo $studentInfo->native_state; ?></li>
                                                         <?php } ?>
                                                         <?php if(!empty($stateInfo)){
                                                        foreach($stateInfo as $state){ ?>
                                                         <li class="mdc-list-item"
                                                             data-value="<?php echo $state->state; ?>">
                                                             <span class="mdc-list-item__text" selected>
                                                                 <?php echo $state->state; ?>
                                                             </span>
                                                         </li>
                                                         <?php } } ?>
                                                     </ul>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group"> 
                                                                <div class="mdc-select mdc-select-nationality mdc-select--required">
                                                                <div class="mdc-select__anchor" aria-required="true">
                                                                    <span class="mdc-select__ripple"></span>
                                                                    <input type="text"  class="mdc-select__selected-text" name="nationality" id="nationality" value="" required>
                                                                    <i class="mdc-select__dropdown-icon"></i>
                                                                    <span class="mdc-floating-label">Select Nationality</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </div>
                                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                    <ul class="mdc-list">
                                                                        <?php if(!empty($studentInfo->nationality)){ ?>
                                                                            <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->nationality; ?>" aria-selected="true"><?php echo $studentInfo->nationality; ?></li>
                                                                        <?php } ?>
                                                                        <?php if(!empty($nationalityInfo)){
                                                                            foreach($nationalityInfo as $nation){ ?>
                                                                            <li class="mdc-list-item" data-value="<?php echo $nation->name; ?>">
                                                                                <span class="mdc-list-item__text">
                                                                                <?php echo $nation->name; ?>
                                                                                </span>
                                                                            </li>
                                                                        <?php } } ?>
                                                                    </ul>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group"> 
                                                                <div class="mdc-select mdc-select-religion mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                    <span class="mdc-select__ripple"></span>
                                                                    <input type="text"  class="mdc-select__selected-text" name="religion" id="religion" value="" required>
                                                                    <i class="mdc-select__dropdown-icon"></i>
                                                                    <span class="mdc-floating-label">Select Religion</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                    <ul class="mdc-list">
                                                                        <?php if(!empty($studentInfo->religion)){ ?>
                                                                            <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->religion; ?>" aria-selected="true"><?php echo $studentInfo->religion; ?></li>
                                                                        <?php } ?>
                                                                        <?php if(!empty($religionInfo)){
                                                                            foreach($religionInfo as $religion){ ?>
                                                                            <li class="mdc-list-item" data-value="<?php echo $religion->name; ?>">
                                                                                <span class="mdc-list-item__text">
                                                                                <?php echo $religion->name; ?>
                                                                                </span>
                                                                            </li>
                                                                        <?php } } ?>
                                                                        <li class="mdc-list-item" data-value="OTHER">
                                                                            <span class="mdc-list-item__text">OTHER</span>
                                                                        </li>
                                                                    </ul>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-caste mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                    <span class="mdc-select__ripple"></span>
                                                                    <input type="text"  class="mdc-select__selected-text" name="caste" id="caste" value="" required>
                                                                    <i class="mdc-select__dropdown-icon"></i>
                                                                    <span class="mdc-floating-label">Select Caste Category</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                    <ul class="mdc-list">
                                                                            <?php if(!empty($studentInfo->caste)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->caste; ?>" aria-selected="true"><?php echo $studentInfo->caste; ?></li>
                                                                            <?php } ?>
                                                                            <?php if(!empty($casteInfo)){
                                                                                foreach($casteInfo as $caste){ ?>
                                                                                <li class="mdc-list-item" data-value="<?php echo $caste->name; ?>">
                                                                                    <span class="mdc-list-item__text">
                                                                                        <?php echo $caste->name; ?>
                                                                                    </span>
                                                                                </li>
                                                                            <?php } } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="sub_caste mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input name="sub_caste" id="sub_caste" value="<?php echo $studentInfo->sub_caste; ?>" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">Sub Caste</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </label>
                                                            </div>
                                                        </div> 
                                                        <div class="col-lg-3 col-md-4 col-sm-3">
                                                            <div class="form-group other_nationality_text">
                                                                <label class="other_nationality mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text"  name="other_nationality" id="other_nationality" class="mdc-text-field__input" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">TYPE YOUR NATIONALITY</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-3">
                                                            <div class="form-group other_religion_text">
                                                                <label class="other_religion_text mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text"  name="other_religion_text" id="other_religion_text" class="mdc-text-field__input" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">TYPE YOUR RELIGION</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-3">
                                                            <div class="form-group other_caste_text">
                                                                <label class="other_caste_text mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text"  name="other_caste_text" id="other_caste_text" class="mdc-text-field__input" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">TYPE YOUR CASTE</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-blood">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="blood_group" value="" data-live-search="true" id="blood_group" >
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Blood Group</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                    <ul class="mdc-list">
                                                                    <?php if(!empty($studentInfo->blood_group)){ ?>
                                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->blood_group; ?>" aria-selected="true"><?php echo $studentInfo->blood_group; ?></li>
                                                                        <?php } ?>
                                                                        <li class="mdc-list-item" data-value="" selected hidden>
                                                                            <span class="mdc-list-item__text">
                                                                            Select Blood Group
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="A+">
                                                                        <span class="mdc-list-item__text">
                                                                            A+
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="B+">
                                                                        <span class="mdc-list-item__text">
                                                                            B+
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="B-">
                                                                        <span class="mdc-list-item__text">
                                                                            B-
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="AB+">
                                                                        <span class="mdc-list-item__text">
                                                                            AB+
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="AB-">
                                                                        <span class="mdc-list-item__text">
                                                                            AB-
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="O+">
                                                                        <span class="mdc-list-item__text">
                                                                            O-
                                                                        </span>
                                                                        </li>
                                                                        <li class="mdc-list-item" data-value="O+">
                                                                        <span class="mdc-list-item__text">
                                                                            O+
                                                                        </span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="mother_tongue mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input name="mother_tongue" id="mother_tongue" value="<?php echo $studentInfo->mother_tongue;?>" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" autocomplete="off" required>
                                                                <span class="mdc-floating-label" id="my-label-id">Mother Tongue</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-6 aadhar_text">
                                                            <div class="form-group">
                                                                <label class="aadhar_no mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input name="aadhar_no" id="aadhar_no" pattern="[0-9]*" value="<?php echo $studentInfo->aadhar_no; ?>" class="mdc-text-field__input" type="tel" aria-labelledby="my-label-id"  maxlength="12" autocomplete="off" onkeypress="return isNumber(event)" >
                                                                <span class="mdc-floating-label" id="my-label-id">Aadhaar Number</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div> 
                                                   
                                                        <div class="col-lg-3 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-physically mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                        <span class="mdc-select__ripple"></span> 
                                                                        <input type="text" class="mdc-select__selected-text" name="physically_challenged" value="" data-live-search="true" id="physicallyChallenged" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Physically Challenged?</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <?php if(!empty($studentInfo->physically_challenged)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->physically_challenged; ?>" aria-selected="true"><?php echo $studentInfo->physically_challenged; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="" selected hidden>
                                                                                <span class="mdc-list-item__text">Select Physically Challenged</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="YES">
                                                                                <span class="mdc-list-item__text">YES</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="NO">
                                                                                <span class="mdc-list-item__text">NO</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-dyslexia mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class" aria-required=>
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="dyslexia_challenged" value="" data-live-search="true" id="dyslexiaChallenged" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Dyslexic?</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <?php if(!empty($studentInfo->dyslexia_challenged)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->dyslexia_challenged; ?>" aria-selected="true"><?php echo $studentInfo->dyslexia_challenged; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="" selected hidden>
                                                                                <span class="mdc-list-item__text">Select Dyslexic</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="YES">
                                                                                <span class="mdc-list-item__text">YES</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="NO">
                                                                                <span class="mdc-list-item__text">NO</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        
                                                        

                                                        <div class="col-lg-3 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-hostel mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class" aria-required=>
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text"
                                                                            name="hostel_facility" value="" data-live-search="true"
                                                                            id="hostel_facility" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Hostel Facility?</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <?php if(!empty($studentInfo->hostel_facility)){ ?>
                                                                            <li class="mdc-list-item mdc-list-item--selected"
                                                                                data-value="<?php echo $studentInfo->hostel_facility; ?>"
                                                                                aria-selected="true"><?php echo $studentInfo->hostel_facility; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="" selected hidden>
                                                                                <span class="mdc-list-item__text">Select</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="YES">
                                                                                <span class="mdc-list-item__text">YES</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="NO">
                                                                                <span class="mdc-list-item__text">NO</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-bus mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class" aria-required=>
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text"
                                                                            name="bus_facility" value="" data-live-search="true"
                                                                            id="bus_facility" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Bus Facility?</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <?php if(!empty($studentInfo->bus_facility)){ ?>
                                                                            <li class="mdc-list-item mdc-list-item--selected"
                                                                                data-value="<?php echo $studentInfo->bus_facility; ?>"
                                                                                aria-selected="true"><?php echo $studentInfo->bus_facility; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="" selected hidden>
                                                                                <span class="mdc-list-item__text">Select</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="YES">
                                                                                <span class="mdc-list-item__text">YES</span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="NO">
                                                                                <span class="mdc-list-item__text">NO</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="caste_no mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="caste_no" id="caste_no"
                                                                        value="<?php echo $studentInfo->caste_no; ?>"
                                                                        class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" placeholder="Caste Certificate No."
                                                                        autocomplete="off" >
                                                                    <span class="mdc-floating-label" id="my-label-id">Caste Certificate No.</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="income_no mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="income_no" id="income_no"
                                                                        value="<?php echo $studentInfo->income_no; ?>"
                                                                        class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" placeholder="Income Certificate No."
                                                                        autocomplete="off" >
                                                                    <span class="mdc-floating-label" id="my-label-id">Income Certificate No.</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6 boarding_point">
                                                            <div class="form-group">
                                                                <label class="boarding_points mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input name="boarding_point" id="boarding_point" placeholder="Boarding Point"
                                                                        value="<?php echo $studentInfo->boarding_point; ?>"
                                                                        class="mdc-text-field__input" type="text" aria-labelledby="my-label-id"
                                                                        autocomplete="off">
                                                                    <span class="mdc-floating-label" id="my-label-id">Boarding Point</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                         
                                                    </div>                        
                                                    <div class="roman_catholic">
                                                        <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1 ">
                                                            <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Parish Priest's Details 
                                                            <span class="float-right"><a href="#" title="Help <i class='far fa-question-circle'></i>" data-toggle="popover" data-content="I. Self-attested (by the student) scanned copy of- the email from the Parish Priest or hard copy of the letter may be uploaded. The details must include the applicant’s name and the name of the parents. <br/> II. Original copies of valid baptism certificate and Parish Priest’s letter must be produced during verification of documents."><span class="badge badge-primary">Help <i class="far fa-question-circle"></i></span></a></span>
                                                            </div>    
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="priest_name mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="text"  name="priest_name" id="priest_name" value="<?php echo $parishPriestInfo->priest_name; ?>" class="mdc-text-field__input text-uppercase" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                                    <span class="mdc-floating-label" id="my-label-id">Parish Priest's Name</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                                <div class="form-group">  
                                                                    <label class="priest_mobile mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input name="priest_mobile" id="priest_mobile" pattern="[0-9]*" value="<?php echo $parishPriestInfo->mobile_number; ?>" class="mdc-text-field__input" type="tel" aria-labelledby="my-label-id"  maxlength="10" autocomplete="off" onkeypress="return isNumber(event)">
                                                                        <span class="mdc-floating-label" id="my-label-id">Parish Priest’s contact number</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-6 col-md-12 col-sm-12 text-center">
                                                                <div class="flex-container">
                                                                    <p class="font-weight-bold text-dark mb-0">Letter from Parish Priest /Baptism Certificate</p>
                                                                    <img src="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $parishPriestInfo->certificate_path;?>"
                                                                      height="200" alt="Parish Priest Certificate"  />
                                                                </div>
                                                            </div>  
                                                        </div>  
                                                    </div>             
                                                    
                                                    <div class="other_christian">
                                                        <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1">
                                                            <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Pastor/Parish Priest’s details 
                                                            <span class="float-right"><a href="#" title="Help <i class='far fa-question-circle'></i>" data-toggle="popover" data-content="I. Self-attested (by the student) scanned copy of- the email from the Pastor/Parish Priest or hard copy of the letter may be uploaded. The details must include the applicant’s name and the name of the parents. <br/> II. Original copies of valid baptism certificate and Pastor/Parish Priest’s letter must be produced during the verification of documents."><span class="badge badge-primary">Help <i class="far fa-question-circle"></i></span></a></span>
                                                            </div>    
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                                <div class="form-group mb-4">
                                                                    <label class="pastor_name mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input type="text"  name="pastor_name" id="pastor_name" value="<?php echo $parishPriestInfo->priest_name; ?>" class="mdc-text-field__input text-uppercase" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                                        <span class="mdc-floating-label" id="my-label-id">Pastor/Parish Priest’s Name</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                                <div class="form-group">  
                                                                    <label class="pastor_mobile mdc-text-field mdc-text-field--filled">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input name="pastor_mobile" id="pastor_mobile" pattern="[0-9]*" value="<?php echo $parishPriestInfo->mobile_number; ?>" class="mdc-text-field__input" type="tel" aria-labelledby="my-label-id"  maxlength="10" autocomplete="off" onkeypress="return isNumber(event)">
                                                                        <span class="mdc-floating-label" id="my-label-id">Pastor/Parish Priest’s contact number</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 text-center">
                                                                <div class="flex-container">
                                                                    <p class="font-weight-bold text-dark mb-0">Letter from Pastor/Parish Priest/Baptism Certificate</p>
                                                                        <img src="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $parishPriestInfo->certificate_path;?>"
                                                                        height="200" alt="Pastor Priest Certificate"  />
                                                                </div>
                                                            </div>  
                                                        </div>  
                                                    </div>             


                                                    
                                                    <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-1 mb-1">
                                                        <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Family Details</div>    
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6">
                                                            <div class="form-group mb-4">
                                                            <label class="father_name mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="father_name" id="father_name" value="<?php echo $studentInfo->father_name; ?>" class="mdc-text-field__input text-uppercase" maxlength="128" aria-labelledby="my-label-id" autocomplete="off" required>
                                                                <span class="mdc-floating-label" id="my-label-id">Father's Name</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="father_qualification mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="text" name="father_qualification" id="father_qualification" value="<?php echo $studentInfo->father_qualification; ?>" class="mdc-text-field__input text-uppercase" onkeydown="return alphaOnly(event)" aria-labelledby="my-label-id" autocomplete="off" >
                                                                    <span class="mdc-floating-label" id="my-label-id">Father's Qualification</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                                            <div class="form-group"> 

                                                                <label class="father_profession mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="father_profession" id="father_profession" value="<?php echo $studentInfo->father_profession; ?>" class="mdc-text-field__input" aria-labelledby="my-label-id" onkeydown="return alphaOnly(event)" autocomplete="off" >
                                                                <span class="mdc-floating-label" id="my-label-id">Father's Occupation</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="father_age mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="tel" pattern="[0-9]*" name="father_age" id="father_age" value="<?php echo $studentInfo->father_age; ?>" class="mdc-text-field__input" maxlength="3" aria-labelledby="my-label-id" onkeypress="return isNumber(event)" autocomplete="off" >
                                                                <span class="mdc-floating-label" id="my-label-id">Father's Age</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>                  
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="mother_name mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="mother_name" id="mother_name" value="<?php echo $studentInfo->mother_name; ?>" class="mdc-text-field__input text-uppercase" maxlength="128" aria-labelledby="my-label-id" autocomplete="off" required>
                                                                <span class="mdc-floating-label" id="my-label-id">Mother's Name</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="mother_qualification mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="mother_qualification" id="mother_qualification" value="<?php echo $studentInfo->mother_qualification; ?>" class="mdc-text-field__input text-uppercase" aria-labelledby="my-label-id" onkeydown="return alphaOnly(event)" autocomplete="off" >
                                                                <span class="mdc-floating-label" id="my-label-id">Mother's Qualification</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="mother_profession mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="mother_profession" id="mother_profession" value="<?php echo $studentInfo->mother_profession; ?>" class="mdc-text-field__input" aria-labelledby="my-label-id" onkeydown="return alphaOnly(event)" autocomplete="off" >
                                                                <span class="mdc-floating-label" id="my-label-id">Mother's Occupation</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="mother_age mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="tel" pattern="[0-9]*" name="mother_age" id="mother_age" value="<?php echo $studentInfo->mother_age; ?>" class="mdc-text-field__input" maxlength="3" aria-labelledby="my-label-id" onkeypress="return isNumber(event)" autocomplete="off" >
                                                                <span class="mdc-floating-label" id="my-label-id">Mother's Age</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">  
                                                                <label class="father_mobile mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="tel" pattern="[0-9]*" name="father_mobile" id="father_mobile" value="<?php echo $studentInfo->father_mobile; ?>" class="mdc-text-field__input" maxlength="10" aria-labelledby="my-label-id" onkeypress="return isNumber(event)" autocomplete="off" required>
                                                                <span class="mdc-floating-label" id="my-label-id">Father's Mobile Number</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="mother_mobile mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="tel" pattern="[0-9]*" name="mother_mobile" id="mother_mobile" value="<?php echo $studentInfo->mother_mobile; ?>" class="mdc-text-field__input" maxlength="10" aria-labelledby="my-label-id" onkeypress="return isNumber(event)" autocomplete="off" required>
                                                                    <span class="mdc-floating-label" id="my-label-id">Mother's Mobile Number</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="father_email mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="email" name="father_email" id="father_email" value="<?php echo $studentInfo->father_email; ?>" class="mdc-text-field__input" maxlength="125" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">Father's Email Id</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="mother_email mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="email" name="mother_email" id="mother_email" value="<?php echo $studentInfo->mother_email; ?>" class="mdc-text-field__input" maxlength="125" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">Mother's Email Id</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group"> 
                                                                <label class="father_annual_income mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="father_annual_income" id="father_annual_income" value="<?php echo $studentInfo->father_annual_income; ?>" class="mdc-text-field__input" aria-labelledby="my-label-id" autocomplete="off" required>
                                                                <span class="mdc-floating-label" id="my-label-id">Father's Annual Income</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>                                    
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="mother_annual_income mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text" name="mother_annual_income" id="mother_annual_income" value="<?php echo $studentInfo->mother_annual_income; ?>" class="mdc-text-field__input" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">Mother's Annual Income</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="monthly_income mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="text" name="monthly_income" id="monthly_income" placeholder="Monthly Income of Family"
                                                                        onkeypress="return isNumber(event)"
                                                                        value="<?php echo $studentInfo->monthly_income; ?>" class="mdc-text-field__input"
                                                                        aria-labelledby="my-label-id" autocomplete="off" required>
                                                                    <span class="mdc-floating-label" id="my-label-id">Monthly Income of Family</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> 
                            
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6 col-md-6">
                                                            <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-0">
                                                                <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Permanent Address</div>    
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 mt-1">
                                                                    <div class="form-group mb-0">
                                                                        <label class="permanent_address_line_1 mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->permanent_address_line_1; ?>" id="permanent_address_line_1" class="mdc-text-field__input" type="text" name="permanent_address_line_1" placeholder="Flat No., House No., Building, Apartment" autocomplete="off" maxlength="150" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">Address Line 1</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>    
                                                                <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                                                    <div class="form-group">
                                                                        <label class="permanent_address_line_2 mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->permanent_address_line_2; ?>" id="permanent_address_line_2" class="mdc-text-field__input" type="text" name="permanent_address_line_2" placeholder="Area, Colony, Street" autocomplete="off" maxlength="150" >
                                                                        <span class="mdc-floating-label" id="my-label-id">Address Line 2</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>   
                                                            </div>
                                                            <div class="row">  
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="permanent_address_taluk mdc-text-field mdc-text-field--filled">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->permanent_address_taluk; ?>"
                                                                            onkeydown="return alphaOnly(event)" id="permanent_address_taluk"
                                                                            class="mdc-text-field__input" type="text"
                                                                            name="permanent_address_taluk" placeholder="Taluk"
                                                                            autocomplete="off" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">Taluk</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                                    <div class="form-group">
                                                                    <div class="mdc-select mdc-select-permanentAddressState mdc-select--required">
                                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                            <span class="mdc-select__ripple"></span>
                                                                            <input type="text"  class="mdc-select__selected-text" name="permanent_address_state" id="permanent_address_state" value="" required>
                                                                            <i class="mdc-select__dropdown-icon"></i>
                                                                            <span class="mdc-floating-label">Select State</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                            </div>
                                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                            <ul class="mdc-list">
                                                                                <?php if(!empty($studentInfo->permanent_address_state)){ ?>
                                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->permanent_address_state; ?>" aria-selected="true"><?php echo $studentInfo->permanent_address_state; ?></li>
                                                                                <?php } ?>
                                                                                <?php if(!empty($stateInfo)){
                                                                                    foreach($stateInfo as $state){ ?>
                                                                                    <li class="mdc-list-item" data-value="<?php echo $state->state; ?>">
                                                                                        <span class="mdc-list-item__text">
                                                                                            <?php echo $state->state; ?>
                                                                                        </span>
                                                                                    </li>
                                                                                <?php } } ?>
                                                                            </ul>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                </div>    
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="permanent_address_district mdc-text-field mdc-text-field--filled">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->permanent_address_district; ?>" id="permanent_address_district" class="mdc-text-field__input" type="text" name="permanent_address_district" placeholder="District" autocomplete="off" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">District</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>  
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="permanent_address_pincode mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->permanent_address_pincode; ?>" id="permanent_address_pincode" class="mdc-text-field__input" type="tel" pattern="[0-9]*" name="permanent_address_pincode" placeholder="Pincode" autocomplete="off" onkeypress="return isNumber(event)" maxlength="7" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">Pincode</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 col-md-6">
                                                            <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1">
                                                                <div class="card-header text-left inside_color pt-3 pb-3 ml-0">
                                                                    <span>Residential Address</span> 
                                                                    <span class="float-right"><input type="checkbox" value="" name="filladdress" id="filladdress" onclick="fillAddress()" /> <span class="pl-1">Same as Permanent Address</span></span>
                                                                </div>    
                                                            </div> 
                                                            <div class="row"> 
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="residence_address_line_1 mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input value="<?php echo $studentInfo->residential_address_line_1; ?>"
                                                                                id="residence_address_line_1" class="mdc-text-field__input"
                                                                                type="text" name="residence_address_line_1"
                                                                                placeholder="Flat No., House No., Building, Apartment"
                                                                                autocomplete="off" required maxlength="150">
                                                                            <span id="my-label-id residency_add_line1"
                                                                                class="mdc-floating-label">Address Line 1</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group"> 
                                                                        <label class="residence_address_line_2 mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->residential_address_line_2; ?>" id="residence_address_line_2" class="mdc-text-field__input" type="text" name="residence_address_line_2" placeholder="Area, Colony, Street" autocomplete="off" maxlength="150">
                                                                        <span class="mdc-floating-label" id="my-label-id">Address Line 2</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="residence_address_taluk mdc-text-field mdc-text-field--filled">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->residence_address_taluk; ?>"
                                                                            onkeydown="return alphaOnly(event)" id="residence_address_taluk"
                                                                            class="mdc-text-field__input" type="text"
                                                                            name="residence_address_taluk" placeholder="Taluk"
                                                                            autocomplete="off" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">Taluk</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group"> 
                                                                        <div class="mdc-select mdc-select-residenceAddressState mdc-select--required">
                                                                            <div class="mdc-select__anchor" aria-required="true">
                                                                            <span class="mdc-select__ripple"></span>
                                                                            <input type="text" class="mdc-select__selected-text" name="residence_address_state" id="residence_address_state" value="" required>
                                                                            <i class="mdc-select__dropdown-icon"></i>
                                                                            <span class="mdc-floating-label">Select State</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                            </div>
                                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                                                                            <ul class="mdc-list">
                                                                                <?php if(!empty($studentInfo->residential_address_state)){ ?>
                                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentInfo->residential_address_state; ?>"><?php echo $studentInfo->residential_address_state; ?></li>
                                                                                <?php } ?>
                                                                                <?php if(!empty($stateInfo)){
                                                                                    foreach($stateInfo as $state){ ?>
                                                                                    <li class="mdc-list-item" data-value="<?php echo $state->state; ?>">
                                                                                        <span class="mdc-list-item__text" selected>
                                                                                            <?php echo $state->state; ?>
                                                                                        </span>
                                                                                    </li>
                                                                                <?php } } ?>
                                                                            </ul>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group"> 
                                                                        <label class="residence_address_district mdc-text-field mdc-text-field--filled">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->residential_address_district; ?>" id="residence_address_district" class="mdc-text-field__input" type="text" name="residence_address_district" placeholder="District" autocomplete="off" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">District</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group"> 
                                                                        <label class="residence_address_pincode mdc-text-field mdc-text-field--filled ">
                                                                        <span class="mdc-text-field__ripple"></span>
                                                                        <input value="<?php echo $studentInfo->residential_address_pincode; ?>" id="residence_address_pincode" pattern="[0-9]*" class="mdc-text-field__input" type="tel" name="residence_address_pincode" placeholder="Pincode" autocomplete="off" onkeypress="return isNumber(event)" maxlength="7" required>
                                                                        <span class="mdc-floating-label" id="my-label-id">Pincode</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1">
                                                        <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Local Guardian's Details (if applicable only)</div>    
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="guardian_name mdc-text-field mdc-text-field--filled ">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <input type="text"  name="guardian_name" id="guardian_name" value="<?php echo $studentInfo->guardian_name; ?>" class="mdc-text-field__input" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                                <span class="mdc-floating-label" id="my-label-id">Guardian's Name</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>  
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="guardian_mobile mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="tel" pattern="[0-9]*" name="guardian_mobile" id="guardian_mobile" value="<?php echo $studentInfo->guardian_mobile; ?>" class="mdc-text-field__input" maxlength="10" aria-labelledby="my-label-id" onkeypress="return isNumber(event)" autocomplete="off">
                                                                    <span class="mdc-floating-label" id="my-label-id">Guardian's Mobile Number</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>    
                                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="guardian_relation mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="text" name="guardian_relation" onkeydown="return alphaOnly(event)" placeholder="Relationship with Guardian"
                                                                        id="guardian_relation" value="<?php echo $studentInfo->guardian_relation; ?>"
                                                                        class="mdc-text-field__input" maxlength="128" aria-labelledby="my-label-id"
                                                                        autocomplete="off">
                                                                    <span class="mdc-floating-label" id="my-label-id">Relationship with Guardian</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>   
                                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                                            <div class="form-group"> 
                                                                <label class="guardian_address mdc-text-field mdc-text-field--filled mdc-textfield--multiline">
                                                                <span class="mdc-text-field__ripple"></span>
                                                                <textarea id="guardian_address" title="Guardian's Address" class="mdc-text-field__input" rows="6" cols="10" name="guardian_address" autocomplete="off"><?php echo $studentInfo->guardian_address; ?></textarea>
                                                                <span class="mdc-floating-label" id="my-label-id">Guardian's Address</span>
                                                                <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                <?php if($role != ROLE_APPROVE_COMMITTEE || $role != ROLE_TEACHING_STAFF ){ ?>
                      
                                                <button type="submit" class="btn btn-md btn-success float-right mb-2">Update</button>
                                                <?php } ?>
                                        </form>
                                    </div>
                                    </div>
                                    </div>
     
                                    <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                                        <form role="form" method="post" action="<?php echo base_url(); ?>updateSchoolData">
                                            <input type="hidden" value="<?php echo $studentInfo->resgisted_tbl_row_id; ?>" id="registered_row_id" name="registered_row_id"/>
                                            
                                            <div class="row">
                                                
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                    <div class="form-group">
                                                        <label class="name_of_the_school mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input type="text"  name="name_of_the_school" id="name_of_the_school" value="<?php echo $studentSchoolInfo->name_of_the_school; ?>" class="mdc-text-field__input"  style="text-transform: uppercase;" maxlength="128" aria-labelledby="my-label-id" autocomplete="off" required>
                                                            <span class="mdc-floating-label" id="my-label-id">Name of the School</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                    <div class="form-group">
                                                        <div class="mdc-select mdc-select-medium mdc-select--required">
                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" name="medium" value="" data-live-search="true" id="medium" required>
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Medium of Instruction</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if(!empty($studentSchoolInfo->medium_instruction)){ ?>
                                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentSchoolInfo->medium_instruction; ?>" aria-selected="true"><?php echo $studentSchoolInfo->medium_instruction; ?></li>
                                                                    <?php } ?>
                                                                    <li class="mdc-list-item" data-value="ENGLISH">
                                                                        <span class="mdc-list-item__text">ENGLISH</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="KANNADA">
                                                                        <span class="mdc-list-item__text">KANNADA</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="MARATHI">
                                                                        <span class="mdc-list-item__text">MARATHI</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="OTHER">
                                                                        <span class="mdc-list-item__text">OTHER</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                    <div class="form-group">
                                                        <div class="mdc-select mdc-select-month mdc-select--required">
                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" name="month_of_passed" value="" data-live-search="true" id="month_of_passed" required>
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Month of Passing</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if (!empty($studentSchoolInfo->month_of_passed)) { ?>
                                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentSchoolInfo->month_of_passed; ?>" aria-selected="true"><?php echo $studentSchoolInfo->month_of_passed; ?></li>
                                                                    <?php } ?>
                                                                    <li class="mdc-list-item" data-value="" selected hidden>
                                                                        <span class="mdc-list-item__text">
                                                                            Select Month
                                                                        </span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="MARCH">
                                                                        <span class="mdc-list-item__text">
                                                                        MARCH
                                                                        </span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="APRIL">
                                                                        <span class="mdc-list-item__text">
                                                                        APRIL
                                                                        </span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="MAY">
                                                                        <span class="mdc-list-item__text">
                                                                            MAY
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                    <div class="form-group">
                                                        <div class="mdc-select mdc-select-year mdc-select--required">
                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" name="year_of_passed" value="" data-live-search="true" id="year_of_passed" required>
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Year of Passing</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if(!empty($studentSchoolInfo->year_of_passed)){ ?>
                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentSchoolInfo->year_of_passed; ?>" aria-selected="true"><?php echo $studentSchoolInfo->year_of_passed; ?></li>
                                                                    <?php } ?>
                                                                    <li class="mdc-list-item" data-value="" selected hidden>
                                                                            <span class="mdc-list-item__text">
                                                                        Select Year
                                                                        </span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="2021">
                                                                        <span class="mdc-list-item__text">
                                                                        2021
                                                                        </span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="2020">
                                                                        <span class="mdc-list-item__text">
                                                                        2020
                                                                        </span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="2019">
                                                                        <span class="mdc-list-item__text">
                                                                        2019
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                           
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1 other_medium_instruction_text">
                                                    <div class="form-group">
                                                        <label class="other_medium_instruction mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input type="text" name="other_medium_instruction" id="other_medium_instruction" value="" class="mdc-text-field__input"  style="text-transform: uppercase;" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id">Other Medium of Instruction</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-2">
                                                    <div class="form-group">
                                                        <label class="school_address mdc-text-field mdc-text-field--filled mdc-textfield--multiline">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <textarea id="school_address" name="school_address" type="text" style="text-transform: uppercase" class="mdc-text-field__input" rows="6" cols="10" maxlength="550" autocomplete="off" required><?php echo $studentSchoolInfo->school_address; ?></textarea>
                                                            <span class="mdc-floating-label" id="my-label-id">Address of the School</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                    <div class="form-group">
                                                        <label class="sslc_board_name mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input type="text"  name="sslc_board_name" id="sslc_board_name" value="<?= $boardInfo->board_name ?>" class="mdc-text-field__input"  style="text-transform: uppercase;" maxlength="128" aria-labelledby="my-label-id" autocomplete="off" readonly required>
                                                            <span class="mdc-floating-label" id="my-label-id">10th Board Name</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                <input type="hidden" id="sslcId" value="<?php $boardInfo->board_name ?>">
                                                <div class="form-group">
                                                    <div class="mdc-select mdc-select-board mdc-select--required">
                                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                            <span class="mdc-select__ripple"></span>
                                                            <input type="text" class="mdc-select__selected-text" name="sslc_board_name" id="sslc_board_name" value="" required>
                                                            <i class="mdc-select__dropdown-icon"></i>
                                                            <span class="mdc-floating-label">10th Board Name</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </div>
                                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                            <ul class="mdc-list">
                                                                <!-- <li class="mdc-list-item" data-value="">
                                                                    <span class="mdc-list-item__text">
                                                                        Select Board Name
                                                                    </span>
                                                                </li> 
                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $boardInfo->row_id ?>">
                                                                    <span class="mdc-list-item__text">
                                                                        <?= $boardInfo->board_name ?>
                                                                    </span>
                                                                </li>
                                                                <?php if (!empty($allBoardsInfo)) {
                                                                    foreach ($allBoardsInfo as $board) {  ?>
                                                                        <li class="mdc-list-item" data-value="<?php echo $board->row_id; ?>">
                                                                            <span class="mdc-list-item__text">
                                                                                <?php echo $board->board_name; ?>
                                                                            </span>
                                                                        </li>
                                                                <?php }
                                                                } ?>
                                                            
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                <div class="form-group register_number">
                                                    <label class="register_number mdc-text-field mdc-text-field--filled ">
                                                        <span class="mdc-text-field__ripple"></span>
                                                        <input type="text" placeholder="Register Number" name="register_number" id="register_number" value="<?php echo $studentSchoolInfo->register_number?>" class="mdc-text-field__input" style="text-transform: uppercase;" aria-labelledby="my-label-id" autocomplete="off" required>
                                                        <span class="mdc-floating-label" id="my-label-id">Register Number</span>
                                                        <span class="mdc-line-ripple"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                <div class="form-group">
                                                    <div class="mdc-select mdc-select-attempts mdc-select--required">
                                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                            <span class="mdc-select__ripple"></span>
                                                            <input type="text" class="mdc-select__selected-text" name="no_of_attempt" value="" data-live-search="true" id="no_of_attempt" required>
                                                            <i class="mdc-select__dropdown-icon"></i>
                                                            <span class="mdc-floating-label">No of Attempts</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </div>
                                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                            <ul class="mdc-list">
                                                                <?php if (!empty($studentSchoolInfo->no_of_attempt)) { ?>
                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $studentSchoolInfo->no_of_attempt; ?>" aria-selected="true"><?php echo $studentSchoolInfo->no_of_attempt; ?></li>
                                                                <?php } ?>
                                                                <li class="mdc-list-item" data-value="" selected hidden>
                                                                    <span class="mdc-list-item__text">
                                                                        Select
                                                                    </span>
                                                                </li>
                                                                <li class="mdc-list-item" data-value="FIRST">
                                                                    <span class="mdc-list-item__text">
                                                                        FIRST
                                                                    </span>
                                                                </li>
                                                                <li class="mdc-list-item" data-value="REPEATER">
                                                                    <span class="mdc-list-item__text">
                                                                        REPEATER
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                                    <div class="form-group other_board_name_text">
                                                        <label class="other_board_name mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input type="text" placeholder="Other Board Name" name="other_board_name" id="other_board_name" value="<?php echo $studentSchoolInfo->other_board_name?>" class="mdc-text-field__input" maxlength="10" style="text-transform: uppercase;" aria-labelledby="my-label-id" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id">Other Board Name</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="studentMarkInfo">
                                                                <?php
                                                                $max_mark_total=0;
                                                                $obtained_mark_total=0;
                                                                $sslc_percentage=0; 
                                                                if(!empty($studentMarkInfo)) {?>
                                                                <div class="table-responsive mt-1">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr class="head-title">
                                                                                <th colspan="7" class="text-center tbl-head">Marks Obtained in 10th Std</th>
                                                                            </tr>
                                                                            <tr class="head-title tbl-head">
                                                                                <th class="text-center">SUBJECT NAME</th>
                                                                                <th class="text-center">MAX MARKS</th>
                                                                                <th class="text-center">MARKS SCORED</th>
                                                                            </tr>
                                                                        </thead>
                                                                       
                                                                        <?php   for($i=0; $i<6; $i++) { ?>
                                                                            <tr>
                                                                                <th><?php echo $studentMarkInfo[$i]->subject_name; ?></th>
                                                                                <th class="text-center"><?php echo $studentMarkInfo[$i]->max_mark; ?></th>
                                                                                <th class="text-center"><?php echo $studentMarkInfo[$i]->obtnd_mark; ?></th>
                                                                                <?php 
                                                                                    $max_mark_total += $studentMarkInfo[$i]->max_mark;
                                                                                    $obtained_mark_total += $studentMarkInfo[$i]->obtnd_mark;
                                                                                ?>
                                                                            </tr>
                                                                            <?php }   $sslc_percentage = $obtained_mark_total / $max_mark_total * 100;
                                                                            ?>
                                                                                
                                                                            <tr class="head-title tbl-head">
                                                                                <th class="text-center">TOTAL </th>
                                                                                <th class="text-center">
                                                                                    <?php echo $max_mark_total; ?></th>
                                                                                <th class="text-center">
                                                                                    <?php echo $obtained_mark_total; ?></th>
                                                                            </tr>
                                                                            <tr class="head-title">
                                                                                <th colspan="7" style="text-align:right"
                                                                                    class="column-percent"> Percentage : <span
                                                                                        style="color:#0027ff;"><?php echo number_format((float)$sslc_percentage, 2, '.', ''); ?>%</span>
                                                                                </th>
                                                                            </tr>
                                                                    </table>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                            <?php if($role != ROLE_APPROVE_COMMITTEE || $role != ROLE_TEACHING_STAFF){ ?>
                                            <button type="submit" class="btn btn-md btn-success float-right mb-2">Update</button>
                                            <?php } ?>
                                        </form>  
                                    </div>                                
                                        

                                    <div class="tab-pane fade" id="admi" role="tabpanel" aria-labelledby="admi-tab">
                                        <form role="form" method="post" action="<?php echo base_url(); ?>updateStudentCombination">
                                            <input type="hidden" value="<?php echo $studentInfo->resgisted_tbl_row_id; ?>" id="registered_row_id" name="registered_row_id"/>
                                            <div class="card-body">
                                                <div class="row">
                                                <div class="col-12 column_padding_card">
                                                                                
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6 col-sm-4 mb-1">
                                                            <div class="form-group">
                                                                <label class="language_first mdc-text-field mdc-text-field--filled ">
                                                                    <span class="mdc-text-field__ripple"></span>
                                                                    <input type="text"  name="language_first" id="language_first" value="English" class="mdc-text-field__input" aria-labelledby="my-label-id"  autocomplete="off" readonly>
                                                                    <span class="mdc-floating-label" id="my-label-id">Language I</span>
                                                                    <span class="mdc-line-ripple"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-4 mb-2">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-program_name mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="program_name" value="" id="program_name" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Select Course for First Preference</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <li class="mdc-list-item" data-value="" disabled selected hidden>
                                                                                <span class="mdc-list-item__text">Select Course for First Preference</span>
                                                                            </li>
                                                                            <?php if(!empty($streamInfo->program_name)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $streamInfo->program_name; ?>" aria-selected="true"><?php echo $streamInfo->program_name; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="SCIENCE">
                                                                            <span class="mdc-list-item__text">
                                                                                SCIENCE
                                                                            </span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="COMMERCE">
                                                                            <span class="mdc-list-item__text">
                                                                                COMMERCE
                                                                            </span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="ARTS">
                                                                            <span class="mdc-list-item__text">
                                                                                ARTS
                                                                            </span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-4 mb-2">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-stream_name mdc-select--required">
                                                                    <div class="mdc-select__anchor" aria-required="true">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="stream_name" id="stream_name" value="" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Select Stream for First Preference</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <?php if(!empty($streamInfo->stream_name)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" id="selectedFirstStream" data-value="<?php echo $streamInfo->stream_name; ?>" aria-selected="true"><?php echo $streamInfo->stream_name; ?></li>
                                                                            <?php } ?>
                                                                            <div id="streamName">
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-md-6 col-sm-4 mb-2 ">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-language_second mdc-select--required">
                                                                    <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="language_second" value="" data-live-search="true" id="language_second" required>
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Language II</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <li class="mdc-list-item" data-value="" selected hidden>
                                                                                <span class="mdc-list-item__text"> Select Second Language </span>
                                                                            </li>
                                                                            <?php if(!empty($streamInfo->second_language)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $streamInfo->second_language; ?>" aria-selected="true"><?php echo $streamInfo->second_language; ?></li>
                                                                            <?php } ?>
                                                                            
                                                                            <li class="mdc-list-item" data-value="KANNADA">
                                                                            <span class="mdc-list-item__text">
                                                                                KANNADA
                                                                            </span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="HINDI">
                                                                            <span class="mdc-list-item__text">
                                                                                HINDI
                                                                            </span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="FRENCH">
                                                                            <span class="mdc-list-item__text">
                                                                                FRENCH
                                                                            </span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-4 mb-2 ">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-second_program_name">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text" class="mdc-select__selected-text" name="second_program_name" value="" data-live-search="true" id="second_program_name" >
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Select Course for Second Preference(Optional)</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list">
                                                                            <li class="mdc-list-item" data-value="" disabled selected hidden>
                                                                                <span class="mdc-list-item__text">
                                                                                Select Course for Second Preference(Optional)
                                                                            </span>
                                                                            </li>
                                                                            <?php if(!empty($streamInfo->second_program_name)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" id="SecondProgramName" data-value="<?php echo $streamInfo->second_program_name; ?>" aria-selected="true"><?php echo $streamInfo->second_program_name; ?></li>
                                                                            <?php } ?>
                                                                            <li class="mdc-list-item" data-value="SCIENCE">
                                                                            <span class="mdc-list-item__text">
                                                                                SCIENCE
                                                                            </span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="COMMERCE">
                                                                            <span class="mdc-list-item__text">
                                                                                COMMERCE
                                                                            </span>
                                                                            </li>
                                                                            <li class="mdc-list-item" data-value="ARTS">
                                                                            <span class="mdc-list-item__text">
                                                                                ARTS
                                                                            </span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-4   mb-2">
                                                            <div class="form-group">
                                                                <div class="mdc-select mdc-select-second_stream_name">
                                                                    <div class="mdc-select__anchor demo-width-class">
                                                                        <span class="mdc-select__ripple"></span>
                                                                        <input type="text"  class="mdc-select__selected-text" name="second_stream_name" id="second_stream_name" value="">
                                                                        <i class="mdc-select__dropdown-icon"></i>
                                                                        <span class="mdc-floating-label">Select Stream For Second Preference(Optional)</span>
                                                                        <span class="mdc-line-ripple"></span>
                                                                    </div>
                                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                        <ul class="mdc-list" id="second_stream_name">
                                                                            <?php if(!empty($streamInfo->second_stream_name)){ ?>
                                                                                <li class="mdc-list-item mdc-list-item--selected" id="selectedSecondStream" data-value="<?php echo $streamInfo->second_stream_name; ?>" aria-selected="true"><?php echo $streamInfo->second_stream_name; ?></li>
                                                                            <?php } ?>
                                                                            <div id="secondStreamPreference">
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-4 col-md-6 col-sm-4 mb-2">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-integrated_batch">
                                        <div class="mdc-select__anchor demo-width-class">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="integrated_batch" value="" data-live-search="true" id="integrated_batch" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Select Integrated Batch*</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item" data-value="" disabled selected hidden>
                                                    <span class="mdc-list-item__text">
                                                    Select Integrated Batch(Optional)
                                                </span>
                                                </li>
                                                <?php if(!empty($streamInfo->integrated_batch)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" id="" data-value="<?php echo $streamInfo->integrated_batch; ?>" aria-selected="true"><?php echo $streamInfo->integrated_batch; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="JEE">
                                                <span class="mdc-list-item__text">
                                                    JEE
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="NEET">
                                                <span class="mdc-list-item__text">
                                                    NEET
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="CPT">
                                                <span class="mdc-list-item__text">
                                                    CPT
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="CET">
                                                <span class="mdc-list-item__text">
                                                    CET
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="CLAT">
                                                <span class="mdc-list-item__text">
                                                    CLAT
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="NONE">
                                                <span class="mdc-list-item__text">
                                                    NONE
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                     </div>
                                </div>
                            </div> -->
                        
                           
                            
                            
                           
                        <!-- </div>  -->

                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>  
                                        <?php if($this->staff_id == '123456' || $this->staff_id == '1000' || $this->staff_id == '1143'){ ?>
                                        <button type="submit" class="btn btn-md btn-success float-right mb-2">Update</button>
                                        <?php } ?>
                                    </form>
                                </div>
                                         
                                
                                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                    <div class="row">
                                    <?php foreach($documentInfo as $doc){ ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="card mb-2">
                                            <div class="uploader text-center">
                                            <?php  $myFile = pathinfo($doc->doc_path); 
                                                                $extension = $myFile['extension']; 
                                                                if($extension == 'pdf'){ ?>
                                                                    <div class="card-header text-dark border-success text-center table_row_backgrond mb-0 font-weight-bold"><?php echo $doc->doc_name; ?></div>
                                                                    <img src="<?php echo base_url(); ?>assets/dist/img/pdf.png" alt="" width="120" height="120">
                                                                <?php }else{ ?>
                                                                    <div class="card-header text-dark border-success text-center table_row_backgrond mb-0 font-weight-bold"><?php echo $doc->doc_name; ?></div>
                                                                    <img id="uploadedImage_one" src="<?php echo ADMISSION_DOCUMENT_PATH.$doc->doc_path; ?>" alt="Preview" class="mt-1" width="120" height="120">
                                                                <?php } ?>
                                            </div>
                                            <div class="card-footer p-1">
                                                <a href="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $doc->doc_path; ?>" class="float-left text-primary font-weight-bold" download>Download</a>
                                                <a href="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $doc->doc_path; ?>" target="_blank" class="float-right text-info font-weight-bold">View</a>
                                            </div> 
                                        </div>
                                        
                                    </div>  
                                    <?php } ?> 
                                    <?php if($studentInfo->caste == 'ROMAN CATHOLIC'){ ?>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card mb-2">
                                                <div class="uploader text-center">
                                                    <div class="card-header text-dark border-success text-center table_row_backgrond mb-0 font-weight-bold">Letter from Parish Priest /Baptism Certificate</div>
                                                    <img id="uploadedImage_one" src="<?php echo ADMISSION_DOCUMENT_PATH.$parishPriestInfo->certificate_path; ?>" alt="Preview" class="mt-1" width="120" height="120">
                                                </div>
                                                <div class="card-footer p-1">
                                                    <a href="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $parishPriestInfo->certificate_path; ?>" class="float-left text-primary font-weight-bold" download>Download</a>
                                                    <a href="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $parishPriestInfo->certificate_path; ?>" target="_blank" class="float-right text-info font-weight-bold">View</a>
                                                </div> 
                                            </div>
                                        </div>  
                                    <?php } ?>
                                    <?php if($studentInfo->caste == 'OTHER CHRISTIANS'){ ?>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card mb-2">
                                                <div class="uploader text-center">
                                                    <div class="card-header text-dark border-success text-center table_row_backgrond mb-0 font-weight-bold">Letter from Pastor/Parish Priest/Baptism Certificate</div>
                                                    <img id="uploadedImage_one" src="<?php echo ADMISSION_DOCUMENT_PATH.$parishPriestInfo->certificate_path; ?>" alt="Preview" class="mt-1" width="120" height="120">
                                                </div>
                                                <div class="card-footer p-1">
                                                    <a href="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $parishPriestInfo->certificate_path; ?>" class="float-left text-primary font-weight-bold" download>Download</a>
                                                    <a href="<?php echo ADMISSION_DOCUMENT_PATH; ?><?php echo $parishPriestInfo->certificate_path; ?>" target="_blank" class="float-right text-info font-weight-bold">View</a>
                                                </div> 
                                            </div>
                                        </div>  
                                    <?php } ?>
                                    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <form role="form" action="<?php echo base_url() ?>updateStudentAdmissionDocument" method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?php echo $studentInfo->resgisted_tbl_row_id; ?>" id="registered_row_id" name="registered_row_id"/>
                                            <div class="card mb-2">
                                                <div class="card-header text-dark border-success text-center table_row_backgrond mb-0 font-weight-bold">Upload Document</div>
                                                <div class="card-body p-1">
                                                    <div class="form-group mb-0">
                                                        <select class="form-control form-control-sm" id="doc_name" name="doc_name" data-live-search="true" required>
                                                            <option value="">Select File Name</option>
                                                            <option value="student_photo">Student Photo</option>
                                                            <option value="sslc_mark_card">SSLC Mark Card</option>
                                                            <option value="physically_challenged_certificate">Physically Challenged Certificate</option>
                                                            <option value="national_level_sports_certificate">National Level Sports Certificate</option>
                                                            <option value="ncc_certificate">NCC Certificate</option>
                                                        </select>
                                                    </div>
                                                  
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="file" class="form-control-sm" id="vImg" name="userfile" accept="image/png, image/jpeg, image/jpg" required>
                                                        </div>
                                                       
                                                        <div class="col-6">
                                                            <img id="uploadedImage" src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" alt="Preview" class="mt-1" width="120" height="120">
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="card-footer p-1">
                                                    <button type="submit" class="btn btn-md btn-success float-right mb-0">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>   -->
                                </div> 
                            </div>


                            <div class="tab-pane fade" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                                <form method="POST" id="approveForm" action="<?php echo base_url() ?>updateStudentAdmissionStatus" role="form">
                                    <input type="hidden" value="<?php echo $applicationInfo->application_number; ?>" id="application_number" name="application_number">
                                    <input type="hidden" value="<?php echo $studentInfo->resgisted_tbl_row_id; ?>" id="registered_row_id" name="registered_row_id"/>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Category of the Student*</label>
                                                <select class="form-control student_category" id="student_category" name="student_category" >
                                                    <?php if(!empty($studentInfo->student_category)){ ?>
                                                        <option value="<?php echo $studentInfo->student_category; ?>" selected><?php echo $studentInfo->student_category; ?></option>
                                                    <?php } ?>
                                                    <option value="">Select Category</option>
                                                    <?php if(!empty($casteInfo)){
                                                        foreach($casteInfo as $caste){ ?>
                                                        <option value="<?php echo $caste->name; ?>">
                                                            <?php echo $caste->name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Select Section*</label>
                                                <select class="form-control section" id="section" name="section" >
                                                    <?php if(!empty($studentInfo->section)){ ?>
                                                        <option value="<?php echo $studentInfo->section; ?>" selected><?php echo $studentInfo->section; ?></option>
                                                    <?php } ?>
                                                    <option value="">Select Section</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label>Any Comments(Optional)</label>
                                            <div class="form-group">
                                                <textarea type="text" class="form-control" style="text-transform: uppercase" placeholder="Any Comments (optional)" id="comments" name="comments"  autocomplete="off"><?php echo $applicationInfo->comments; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                        <?php  
                                                        if($applicationInfo->admission_status == 2){ ?>
                                                            <b class="float-left text-danger">Rejected</b>
                                                        <?php }else{?>
                                                            <button type="submit" class="float-left btn btn-danger text-white" title="Reject" name="add" 
                                                            data-application_number="<?php echo $applicationInfo->application_number; ?>">Reject</button>
                                                        <?php } ?>
                                                    </form>
                                                    <?php if($applicationInfo->admission_status == 1){ ?>
                                                        <b class="float-right text-success">Approved</b>
                                                    <?php }else{?>
                                                        <button type="button" class="btn float-right btn-success text-white ml-2" title="Approve" id="approveAdmission" name="add" data-dismiss="modal"
                                                        data-application_number="<?php echo $applicationInfo->application_number; ?>">Approve</button>
                                                    <?php } ?>
                                        </div>
                                    </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php //} ?>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/admission.js" type="text/javascript"></script>

<script type="text/javascript">
    const dyslexia = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-dyslexia'));
    const physically = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-physically'));
   
    dyslexia.listen('MDCSelect:change', () => {
        if(dyslexia.value == "YES"){
            $('.dyslexiaCertificate').show();
            $('#dyselxiaCertify').prop('required',true);
            $('#dyslexia').html("Upload");
        }else{
            $('.dyslexiaCertificate').hide();  
            $('#dyselxiaCertify').prop('required',false);
        }
    });

    physically.listen('MDCSelect:change', () => {
        if(physically.value == "YES"){
            $('.phCertificate').show();
            $('#ph_certificate').prop('required',true);
            $('#ph_label').html("Upload");
        }else{
            $('.phCertificate').hide();  
            $('#ph_certificate').prop('required',false);
        }
    });

    mdc.textField.MDCTextField.attachTo(document.querySelector('.std_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.dob'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.native_place'));
    // mdc.textField.MDCTextField.attachTo(document.querySelector('.gender'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.student_email'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.student_mobile'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.other_nationality'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.other_religion_text'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.other_caste_text'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.sub_caste'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_tongue'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.aadhar_no'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-gender'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.priest_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.priest_mobile'));

    mdc.textField.MDCTextField.attachTo(document.querySelector('.pastor_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.pastor_mobile'));
    // mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-integrated_batch'));

    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_profession'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_profession'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_qualification'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_qualification'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_age'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_age'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_mobile'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_mobile'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_email'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_email'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.father_annual_income'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mother_annual_income'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.permanent_address_line_1'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.permanent_address_line_2'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.permanent_address_district')); 
    mdc.textField.MDCTextField.attachTo(document.querySelector('.permanent_address_pincode')); 
    const residence_address_line_1 = mdc.textField.MDCTextField.attachTo(document.querySelector('.residence_address_line_1'));
    const residence_address_line_2 = mdc.textField.MDCTextField.attachTo(document.querySelector('.residence_address_line_2'));
    const residence_address_pincode = mdc.textField.MDCTextField.attachTo(document.querySelector('.residence_address_pincode')); 
    const residence_address_district = mdc.textField.MDCTextField.attachTo(document.querySelector('.residence_address_district')) 
    const residence_address_taluk = mdc.textField.MDCTextField.attachTo(document.querySelector('.residence_address_taluk'));

    mdc.textField.MDCTextField.attachTo(document.querySelector('.guardian_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.guardian_mobile'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.guardian_address'));

    const nation = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-nationality'));
    const religion = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-religion'));
    const caste = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-caste'));
    
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-blood'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-permanentAddressState'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-residenceAddressState')); 
    mdc.textField.MDCTextField.attachTo(document.querySelector('.permanent_address_taluk'));

    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-nativeState'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.native_taluk'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.native_district'));

    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-hostel'));
    const bus_facility = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-bus'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.caste_no'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.income_no'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.boarding_points'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.monthly_income'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.guardian_relation'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-attempts'));

    nation.listen('MDCSelect:change', () => {
        if(nation.value == "OTHER"){
            $('.other_nationality_text').show();
        }else{
            $('.other_nationality_text').hide();  
        }

         if(nation.value == "INDIAN"){
            $('.aadhar_text').show();
        }else{
            $('.aadhar_text').hide();  
        }
    });
    bus_facility.listen('MDCSelect:change', () => {
        if (bus_facility.value == "YES") {
            $('.boarding_point').show();
            $('#boarding_point').prop('required', true);
        } else {
            $('.boarding_point').hide();
            $('#boarding_point').prop('required', false);
        }
    });

    religion.listen('MDCSelect:change', () => {
        if(religion.value == "OTHER"){
            $('.other_religion_text').show();
        }else{
            $('.other_religion_text').hide();  
        }
    });

    caste.listen('MDCSelect:change', () => {
        if(caste.value == "OTHER"){
            $('.other_caste_text').show();
        }else{
            $('.other_caste_text').hide();  
        }

         if(caste.value == "ROMAN CATHOLIC"){
            $('.roman_catholic').show();
            $('#priest_name').prop('required',true);
            $('#priest_mobile').prop('required',true);
            // $('#doc_path').prop('required',true);
            $('#priestLabel').html("Upload");
            $('#pastor_name').val('');
            $('#pastor_mobile').val('');
            $('#pastor_file').val('');
        }else{
            $('.roman_catholic').hide();  
            $('#priest_name').prop('required',false);
            $('#priest_mobile').prop('required',false);
            // $('#doc_path').prop('required',false);
            $('#priestLabel').html("Upload");
        }

        if(caste.value == "OTHER CHRISTIANS"){
            $('.other_christian').show();
            $('#pastor_name').prop('required',true);
            $('#pastor_mobile').prop('required',true);
            // $('#pastor_file').prop('required',true);
            $('#pasterLabel').html("Upload");
            $('#priest_name').val('');
            $('#priest_mobile').val('');
            $('#doc_path').val('');
        }else{
            $('.other_christian').hide(); 
            $('#pastor_name').prop('required',false);
            $('#pastor_mobile').prop('required',false);
            // $('#pastor_file').prop('required',false); 
            $('#pasterLabel').html("Upload");
        }

        if(caste.value == "2A" || caste.value == "2B" || caste.value == "3A" || caste.value == "3B" || 
            caste.value == "CAT-I" || caste.value == "SC" || caste.value == "ST"){
            $('.caste_category_certificate').show();
            $('#caste_certificate').prop('required',true);
            $('#casteLabel').html("Upload");
            $('.caste_no').show();
            $('#caste_no').prop('required', true);
            $('.income_no').show();
            $('#income_no').prop('required', true);
        }else{
            $('.caste_category_certificate').hide();
            $('#caste_certificate').prop('required',false); 
            $('#casteLabel').html("Upload"); 
            $('.caste_no').show();
            $('#caste_no').prop('required', false);
            $('.income_no').show();
            $('#income_no').prop('required', false);
        }

    });

    // const board_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-board'));
    const other_board_name = mdc.textField.MDCTextField.attachTo(document.querySelector('.other_board_name'));
    const board_name =  mdc.textField.MDCTextField.attachTo(document.querySelector('.sslc_board_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.register_number'));
    // const changeMDCLabel = ({ focus })=>{
    //     if(focus){
    //         board_name.label.root_.className += ' mdc-floating-label--float-above';
    //         other_board_name.label_.root_.className += ' mdc-floating-label--float-above';
    //     }
    // }

    jQuery(document).ready(function(){
        var dyslexia = $('#dyslexiaChallenged').val();
        if(dyslexia == "YES"){
            $('.dyslexiaCertificate').show(); 
            $('#dyslexia').html("Change");
        }else{
            $('.dyslexiaCertificate').hide();
            $('#dyslexia').html("Change");
        }       

        var physically = $('#physicallyChallenged').val();
        if(physically == "YES"){
            $('.phCertificate').show(); 
            $('#ph_label').html("Change");
        }else{
            $('.phCertificate').hide();
        }
        
        var permanentAddressLine_1 = $("#permanent_address_line_1").val();
    var permanentAddressLine_2 = $("#permanent_address_line_2").val();
    var permanentState = $("#permanent_address_state").val();
    var permanentDistrict = $("#permanent_address_district").val();
    var permanentTaluk = $("#permanent_address_taluk").val();
    var permanentPincode = $("#permanent_address_pincode").val();

    var residenceAddressLine_1 = $("#residence_address_line_1").val();
    var residenceAddressLine_2 = $("#residence_address_line_2").val();
    var residenceState = $("#residence_address_state").val();
    var residenceDistrict = $("#residence_address_district").val();
    var residenceTaluk = $("#residence_address_taluk").val();
    var residencePincode = $("#residence_address_pincode").val();

    if (permanentAddressLine_1 == "" || residenceAddressLine_1 == "") {
        $('#filladdress').attr('checked', false);
    } else if (permanentAddressLine_1 == residenceAddressLine_1 && permanentAddressLine_2 ==
        residenceAddressLine_2 &&
        permanentState == residenceState && permanentDistrict == residenceDistrict && permanentTaluk == residenceTaluk && permanentPincode ==
        residencePincode) {
        $('#filladdress').attr('checked', true);
    } else {
        $('#filladdress').attr('checked', false);
    }

        // $('[data-toggle="popover"]').popover();  
        $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
        $('[data-toggle="popover"]').mouseenter(function(){
            $(this).trigger('focus');
        });

        $("#nextBtn").click(function () {
            $("#icons").css('color', '#008000');
        });

        $('.other_nationality_text').hide();
        $('.other_religion_text').hide();
        $('.other_caste_text').hide();
        $('.caste_category_certificate').hide();

        var caste_name = $('#caste').val();
        if(caste_name == "ROMAN CATHOLIC"){
            $('.roman_catholic').show(); 
            $('#priestLabel').html("Change");
        }else{
            $('.roman_catholic').hide(); 
        }

        if(caste_name == "OTHER CHRISTIANS"){
            $('.other_christian').show();
            $('#pasterLabel').html("Change");
        }else{
            $('.other_christian').hide(); 
        }
        var bus = $('#bus_facility').val();
        if (bus == "YES") {
            $('.boarding_point').show();
            $('#boarding_point').prop('required', true);
        } else {
            $('.boarding_point').hide();
            $('#boarding_point').prop('required', false); 
        }
        if(caste_name == "2A" || caste_name == "2B" || caste_name == "3A" || caste_name == "3B" || 
            caste_name == "CAT-I" || caste_name == "SC" || caste_name == "ST"){
            $('.caste_category_certificate').show();
            $('#casteLabel').html("Change");
        }else{
            $('.caste_category_certificate').hide();
            $('#casteLabel').html("Change"); 
        }

        var nationality_name = $('#nationality').val();
        if(nationality_name == "INDIAN"){
            $('.aadhar_text').show(); 
        }else{
            $('.aadhar_text').hide(); 
        }
        
        var studentProfile = $('#studentProfile').val();
        if(studentProfile == ""){
            $('#studentLabel').html("Upload");
            $('#vImg').prop('required',true);
        }else{
            $('#studentLabel').html("Change");
            $('#vImg').prop('required',false);
        }

        $(".datepicker").datepicker({
            format: 'dd-mm-yyyy',
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            startDate: '01-01-1999',
            endDate: '31-12-2017',
            constrainInput: false
        });

        

        
        $("#fname").keypress(function(event){
            var inputValue = event.charCode;
            if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
                event.preventDefault();
            }
        });
        $("#mother_name").keypress(function(event){
            var inputValue = event.charCode;
            if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
                event.preventDefault();
            }
        });
        $("#father_name").keypress(function(event){
            var inputValue = event.charCode;
            if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
                event.preventDefault();
            }
        });

        $("#subCaste").keypress(function(event){
            var inputValue = event.charCode;
            if(!((inputValue > 64 && inputValue < 91) || (inputValue > 96 && inputValue < 123)||(inputValue==32) || (inputValue==0))){
                event.preventDefault();
            }
        });

    });
    const changeMDCLabel = ({
    focus
}) => {
    if (focus) {
        residence_address_line_1.label_.root_.className += ' mdc-floating-label--float-above';
        residence_address_line_2.label_.root_.className += ' mdc-floating-label--float-above';
        residence_address_district.label_.root_.className += ' mdc-floating-label--float-above';
        residence_address_pincode.label_.root_.className += ' mdc-floating-label--float-above';
    }
}

function fillAddress() {
    if (filladdress.checked == true) {
        var permanent_address_line_1 = $("#permanent_address_line_1").val();
        var permanent_address_line_2 = $("#permanent_address_line_2").val();
        var permanent_address_state = $("#permanent_address_state").val();
        var permanent_address_district = $("#permanent_address_district").val();
        var permanent_address_pincode = $("#permanent_address_pincode").val();
        var permanent_address_taluk = $("#permanent_address_taluk").val();


        $("#residence_address_line_1").val(permanent_address_line_1);
        if (residence_address_line_1.value) residence_address_line_1.valid = true;
        else {
            residence_address_line_1.valid = false;
            residence_address_line_1.focus();
        }

        $("#residence_address_line_2").val(permanent_address_line_2);
        if (residence_address_line_2.value) residence_address_line_2.valid = true;
        else {
            residence_address_line_2.valid = false;
            residence_address_line_2.focus();
        }

        $("#residence_address_state").val(permanent_address_state).attr('selected', true);
        $('residence_address_state').text(permanent_address_state);

        $("#residence_address_district").val(permanent_address_district);
        if (residence_address_district.value) residence_address_district.valid = true;
        else {
            residence_address_district.valid = false;
            residence_address_district.focus();
        }

        $("#residence_address_taluk").val(permanent_address_taluk);
        if (residence_address_taluk.value) residence_address_taluk.valid = true;
        else {
            residence_address_taluk.valid = false;
            residence_address_taluk.focus();
        }

        $("#residence_address_pincode").val(permanent_address_pincode);
        if (residence_address_pincode.value) residence_address_pincode.valid = true;
        else {
            residence_address_pincode.valid = false;
            residence_address_pincode.focus();
        }
        changeMDCLabel({
            focus: true
        });
    } else {
        $("#residence_address_line_1").val('');
        $("#residence_address_line_2").val('');
        $("#residence_address_state").val('');
        $("#residence_address_district").val('');
        $("#residence_address_taluk").val('');
        $("#residence_address_pincode").val('');
    }
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function alphaOnly(event) {
    var key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32);
};
</script>

<script>
    const clickFileInput = element =>{
        $(element).click();
    }

    const MAX_FILE_SIZE = 200; //in KB

    const readFileURL = (input, maxSize)=>{
        return new Promise((resolve, reject)=>{
            try{
                if(input.files && input.files[0]) {
                    if(bytesToKB(input.files[0].size) > maxSize){
                        reject('SIZE_ERROR');
                    }else{
                        var reader = new FileReader();
                        reader.onload = function(evt) {
                            resolve(evt.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }else throw '404_ERROR';
            }catch(err){
                reject(err);
            }
        });
    }

    $("#doc_path").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedImage2').attr('src', result);
            }else{
                $('#uploadedImage2').attr('src', result);
                $('#uploadedImage2').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedImage2').attr('src', '');
            $('#uploadedImage2').attr('alt', 'Letter from Parish Priest /Baptism Certificate');
        }
    });
    $("#pastor_file").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedImage3').attr('src', result);
            }else{
                $('#uploadedImage3').attr('src', result);
                $('#uploadedImage3').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedImage3').attr('src', '');
            $('#uploadedImage3').attr('alt', 'Letter from Pastor/Parish Priest/Baptism Certificate');
        }
    });

    $("#vImg").change(async function() {
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            $('#uploadedImage').attr('src', result);                                                
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedImage').attr('src', '');
            $('#uploadedImage').attr('alt', 'Upload Student Profile Photo');
        }
    });
    $("#caste_certificate").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedImage1').attr('src', result);
            }else{
                $('#uploadedImage1').attr('src', result);
                $('#uploadedImage1').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedImage1').attr('src', '');
            $('#uploadedImage1').attr('alt', 'Upload caste certificate');
        }
    });
    $("#ph_certificate").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedPhysicalImage').attr('src', result);
            }else{
                $('#uploadedPhysicalImage').attr('src', result);
                $('#uploadedPhysicalImage').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedPhysicalImage').attr('src', '');
            $('#uploadedPhysicalImage').attr('alt', 'Upload  Physically Challenged Certificate');
        }
    });
    $("#dyselxiaCertify").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedDyslexiaImage').attr('src', result);
            }else{
                $('#uploadedDyslexiaImage').attr('src', result);
                $('#uploadedDyslexiaImage').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedDyslexiaImage').attr('src', '');
            $('#uploadedDyslexiaImage').attr('alt', 'Upload Dyslexia Certificate');
        }
    });
</script>
<script>
    $("#saveStudentPersonalInfoForm").submit(evt=>{
        showLoader();      
        if(caste.value == "OTHER CHRISTIANS"){
            hideLoader();
            if($("#pastor_file").val() == ""){
                if($("#uploadedImage3").attr('src') == ""){
                    evt.preventDefault();
                    showWarningAlert('Please Upload Pastor/Parish Priest/Baptism Certificate');
                }
            }
        }else if(caste.value == "ROMAN CATHOLIC"){
            hideLoader();
            if($("#doc_path").val() == ""){
                if($("#uploadedImage2").attr('src') == ""){
                    evt.preventDefault();
                    showWarningAlert('Please Upload Parish Priest /Baptism Certificate');
                }
            }
        }
    });
</script>

    
<script type="text/javascript">
    mdc.textField.MDCTextField.attachTo(document.querySelector('.name_of_the_school'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.other_medium_instruction'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.school_address'))
    const medium = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-medium'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-month'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-year'));

    medium.listen('MDCSelect:change', () => {
        if(medium.value == "OTHER"){
            $('.other_medium_instruction_text').show();
            $('#other_medium_instruction').prop('required',true);
        }else{
            $('.other_medium_instruction_text').hide();  
            $('#other_medium_instruction').prop('required',false);
        }
    });

    // const board_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-board'));
    // const other_board_name = mdc.textField.MDCTextField.attachTo(document.querySelector('.other_board_name'));

    // const changeMDCLabel = ({ focus })=>{
    //     if(focus){
    //         board_name.label.root_.className += ' mdc-floating-label--float-above';
    //         other_board_name.label_.root_.className += ' mdc-floating-label--float-above';
    //     }
    // }
    // const showChangeBoardModal = ()=>{
    //     changeMDCLabel({focus: true});
    //     $("#changeBoardModal").modal('show');
    // }
    // $("#updateStudentBoardInfoForm").submit(evt=>{
    //     if(board_name.value == ""){
    //         evt.preventDefault();
    //         alert('Please select Board');
    //     }else if(board_name.value == 4){
    //         if(other_board_name.value == ""){
    //             evt.preventDefault();
    //             alert('Please enter other board name');
    //             other_board_name.focus();
    //         }
    //     }else showLoader();
    // });

    if(board_name.value == 4)$('.other_board_name_text').show();
    else $('.other_board_name_text').hide();
    board_name.listen('MDCSelect:change', () => {
        other_board_name.value = "";
        if(board_name.value == 4){
            $('.other_board_name_text').show();
            $('#other_board_name').prop('required',true);
        }else{
            $('.other_board_name_text').hide(); 
            $('#other_board_name').prop('required',false); 
        }
    });
    jQuery(document).ready(function(){

        $('.other_medium_instruction_text').hide();

        
        var sslcMarkCard = $('#sslcMarkCard').val();
        if(sslcMarkCard == ""){
            $('#sslc_label').html("Upload");
            $('#sslc_card').prop('required',true);
        }else{
            $('#sslc_label').html("Change");
            $('#sslc_card').prop('required',false);
        }

     
       
   
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


<script type="text/javascript">
    mdc.textField.MDCTextField.attachTo(document.querySelector('.language_first'));
    const stream_name_selected = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-stream_name'));
    const second_stream_name_selected = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-second_stream_name'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-language_second'));
    const program_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-program_name'));
    const second_program_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-second_program_name'));

    program_name.listen('MDCSelect:change', () => {
        var programName = program_name.value;
        stream_name_selected.value = "";
        if(programName == ""){
            $('#second_stream_name').attr('readonly',true);
        }
        $('#stream_name option:not(:first)').remove();
        $.ajax({
            url: '<?php echo base_url(); ?>/getStreamNamesByProgram',
            type: 'POST',
            data: { program_name : programName},
            success: function(data) { 
                var newHtml = "";
                $('#stream_name').attr('disabled',false);
                $('#selectedFirstStream').remove();
                $("#coverScreen").hide();  
                var count = data.stream_name.length;
                for(var i=0; i<count; i++){
                    newHtml += '<li class="mdc-list-item" data-value="'+data.stream_name[i].stream_name+'><span class="mdc-list-item__text">'+data.stream_name[i].stream_name+'</span></li>'
                }
                $("#streamName").html(newHtml);
            },
            error: function(result){
                alert("Retry Again! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Retry Again! Something Went Wrong");  
            }),
            beforeSend:function(d){
                $("#coverScreen").show();
            }
        });
    });

    second_program_name.listen('MDCSelect:change', () => {
        var second_programName = second_program_name.value;
        second_stream_name_selected.value = "";
        if(second_programName == ""){
            $('#second_stream_name').attr('readonly',true);
        } 
        $('#second_stream_name option:not(:first)').remove();
        $.ajax({
            url: '<?php echo base_url(); ?>/getStreamNamesByProgram',
            type: 'POST',
            data: { program_name : second_programName},
            success: function(data) {
                var newHtml = "";
                $('#second_stream_name').attr('readonly',false);
                $('#selectedSecondStream').remove();
                $("#coverScreen").hide();
                var count = data.stream_name.length;
                for(var i=0; i<count; i++){
                    newHtml += '<li class="mdc-list-item" data-value="'+data.stream_name[i].stream_name+'><span class="mdc-list-item__text">'+data.stream_name[i].stream_name+'</span></li>'
                }
                $("#secondStreamPreference").html(newHtml);
            },
            error: function(result){
                alert("Retry Again! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Retry Again! Something Went Wrong");  
            }),
            beforeSend:function(d){
                $("#coverScreen").show();
            }
        });
    });

    $(function () {
        $("#icons").css('color', '#008000');
        $("#icon").css('color', '#008000');
        $("#NextBtn").click(function () {
            $("#combination").css('color', '#008000');
        });
    });

jQuery(document).ready(function(){
    if($("#stream_name").val() != ""){
        $('#stream_name').attr('disabled',false);
        }else{
        $('#stream_name').attr('disabled',true);
    }
    if($("#second_stream_name").val() != ""){
        $('#second_stream_name').attr('readonly',false);
        }else{
        $('#second_stream_name').attr('readonly',true);
    }

    var sports = $('input[name="sports"]:checked').val();
    if(sports == "YES"){
        $('.sportsCertificate').show();
        $('#sports_label').html("Change");
    }else{
        $('.sportsCertificate').hide();
    } 


    var ncc = $('input[name="ncc"]:checked').val();
    if(ncc == "YES"){
        $('.nccCertificate').show();
        $('#ncc_label').html("Change");
    }else{
        $('.nccCertificate').hide();
    }

    $('input[name=ncc]').change(function(){
        var value = $('input[name=ncc]:checked').val();
        if(value == "YES"){
            $('.nccCertificate').show();
            $('#ncc_input').prop('required',true);
            $('#ncc_label').html("Upload");
        }else{
            $('.nccCertificate').hide();  
            $('#ncc_input').prop('required',false);
        }
    });
    
    $('input[name=sports]').change(function(){
        var value = $('input[name=sports]:checked').val();
        if(value == "YES"){
            $('.sportsCertificate').show();
            $('#sports_input').prop('required',true);
            $('#sports_label').html("Upload");
        }else{
            $('.sportsCertificate').hide();  
            $('#sports_input').prop('required',false);
        }
    });

});
</script>