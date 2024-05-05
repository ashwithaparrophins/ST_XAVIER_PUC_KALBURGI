<style>
label {
    font-weight: 500 !important;
}

.profile-img img{
    width:130px;
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
<?php
  $warning = $this->session->flashdata('warning');
  if ($warning) { 
  ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <i class="fa fa-check mx-2"></i>
  <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-1">
    <!-- <div class="content-wrapper"> -->
        <section class="content-header">
            <div class="row">
                <div class="col-12">
                    <div class="card card-small p-0 card_heading_title">
                        <div class="card-body p-2 ml-2">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">group</i> Edit Staff
                            </span>

                            <a onclick="showLoader();" href="<?php echo base_url(); ?>staffDetails"
                                class="btn primary_color float-right text-white pt-2" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- form start -->
        <?php if(empty($staffInfo)){ ?>
        <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
                <img height="270" src="<?php echo base_url(); ?>assets/images/404.png" />
            </div>
        </div>
        <?php } else {  ?>
        <!-- Default Light Table -->
        <div class="row form-employee">
            <div class="col-lg-12">
                <div class="card card-small c-border mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2">
                            <div class="row">
                                <div class="col profile-head">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="profile-tab" data-toggle="tab"
                                                href="#profile" role="tab" aria-controls="profile"
                                                aria-selected="false">Personal</a>
                                        </li>
                                        <?php if($role == ROLE_TEACHING_STAFF || $role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_VICE_PRINCIPAL  || $role == ROLE_RECEPTION) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="subject-tab" data-toggle="tab"
                                                href="#subject" role="tab" aria-controls="subject"
                                                aria-selected="false">Subject</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="section-tab" data-toggle="tab"
                                                href="#section" role="tab" aria-controls="section"
                                                aria-selected="false">Section</a>
                                        </li>
                                        <?php } ?>
                                        <?php if($staffInfo->role != "Non-Teaching Staff") { ?>
                                            <li class="nav-item">
                                            <a class="nav-link" id="resign-tab" data-toggle="tab" href="#resign"
                                               role="tab" aria-controls="resign"
                                                aria-selected="true">Resignation Info</a>
                                         </li>

                                            <?php } ?>


                                        <li class="nav-item">
                                            <a class="nav-link" id="leaveIn-tab" data-toggle="tab" href="#leaveIn" role="tab" aria-controls="leaveIn" aria-selected="false">Leave Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="password-tab" data-toggle="tab"
                                                href="#changePassword" role="tab" aria-controls="password"
                                                aria-selected="false">Change
                                                Password</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <form role="form" id="editStaff"
                                                action="<?php echo base_url() ?>updateStaff" method="post"
                                                enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-4">

                                                        <div class="card card-small c-border mb-4 p-2">
                                                            <div class="card-header text-center">
                                                            <label for="fname">Profile Image</label>
                                                                <div class="text-center">
                                                                                                                                  
                                                                <?php 
                                                                $profileImg = $staffInfo->photo_url;
                                                                    if(!empty($profileImg)){ ?>
                                                                <img src="<?php echo $profileImg; ?>" class="avatar rounded-circle img-thumbnail"
                                                                    width="130" height="130" alt="Profile Image" id="uploadedImage">
                                                                <?php } else { ?>
                                                                <img src="<?php echo base_url(); ?>assets/images/user.png" class="avatar rounded-circle img-thumbnail"
                                                                    width="130" height="130" id="uploadedImage" alt="Profile default">
                                                                <?php } ?>
                                                                </div>
                                                                <div class="profileImg">
                                                                    <div class="file btn btn-sm btn-primary">
                                                                        Change
                                                                        <input type="file" class="form-control-sm" id="vImg" name="userfile">
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger font-weight-bold">(The Image maximum size is 2MB)</span>
                                                                <!-- <input type="file" class="form-control-sm" id="vImg" name="userfile"> -->
                                                            </div>
                                                            <input type="hidden"
                                                                value="<?php echo $staffInfo->row_id; ?>" id="row_id"
                                                                name="row_id">
                                                            <div class="form-group">
                                                                <label for="employee_id">Staff ID<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required"
                                                                    value="<?php echo $staffInfo->staff_id; ?>"
                                                                    id="staff_id" name="staff_id" maxlength="128"
                                                                    placeholder="Enter Staff ID" autocomplete="off"
                                                                    required readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fname">Full Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required"
                                                                    value="<?php echo $staffInfo->name; ?>"
                                                                    id="employee_name" name="fname" maxlength="128"
                                                                    placeholder="Enter Full Name" autocomplete="off"
                                                                    required>
                                                            </div>
                                                            <label for="return_date">Date Of Birth (optional)</label>
                                                            <div class="input-group mb-0 mobile_input_width">
                                                                    <input id="dob" type="text" name="dob" class="form-control datepicker emp-dob required"
                                                                        value="<?php if(empty($staffInfo->dob) || $staffInfo->dob == '0000-00-00'){
                                                                            echo "";
                                                                        } else{
                                                                            echo date('d-m-Y',strtotime($staffInfo->dob));
                                                                        } ?>" placeholder="Date of Birth" autocomplete="off" onkeydown="allowHyphen(event)" />
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-secondary" type="button" id="datepicker-trigger">
                                                                            <i class="material-icons date-icon p-2">date_range</i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            <div class="form-group">
                                                                <label for="gender">Gender<span class="text-danger">*</span></label>
                                                                <select class="form-control required selectpicker" id="gender"
                                                                    name="gender" required>
                                                                    <?php if(!empty($staffInfo->gender)){ ?>
                                                                    <option value="<?php echo $staffInfo->gender; ?>"
                                                                        selected>
                                                                        <?php echo strtoupper($staffInfo->gender); ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="blood_group">Blood Group<span class="text-danger">*</span></label>
                                                                <select class="form-control required selectpicker" id="blood_group"
                                                                    name="blood_group" required>
                                                                    <?php if(!empty($staffInfo->blood_group)){ ?>
                                                                    <option value="<?php echo $staffInfo->blood_group; ?>"
                                                                        selected>
                                                                        <?php echo strtoupper($staffInfo->blood_group); ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                    <option value="">Select Blood Group</option>
                                                                    <option value="A+">A+</option>
                                                                    <option value="A-">A-</option>
                                                                    <option value="B+">B+</option>
                                                                    <option value="B-">B-</option>
                                                                    <option value="O+">O+</option>
                                                                    <option value="O-">O-</option>
                                                                    <option value="AB+">AB+</option>
                                                                    <option value="AB-">AB-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                <label for="email ">Email (optional)</label>
                                                                <input type="email" class="form-control required"
                                                                    id="email" value="<?php echo $staffInfo->email; ?>"
                                                                    name="email" maxlength="228"
                                                                    placeholder="Enter Email Address"
                                                                    autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="mobile">Contact Number (optional)</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="mobile"
                                                                    value="<?php echo $staffInfo->mobile; ?>"
                                                                    name="mobile" maxlength="10" minlength="10"
                                                                    placeholder="Enter Contact Number"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="mobile">Date of Join (optional)</label>
                                                                <input type="text" class="form-control datepicker_doj"
                                                                    id="alternative_contact_number" value="<?php  if(empty($staffInfo->doj) || $staffInfo->doj == '0000-00-00'){
                                                                            echo "";
                                                                        } else{
                                                                            echo date('d-m-Y',strtotime($staffInfo->doj));
                                                                        } ?>" name="date_of_join" maxlength="10"
                                                                    placeholder="Select Date of Join">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="role">Role<span class="text-danger">*</span></label>
                                                                <select required name="role"
                                                                    class="form-control  selectpicker" id="role_id"
                                                                    name="role_id" data-live-search="true">
                                                                    <?php if(!empty($staffInfo->role)){ ?>
                                                                    <option value="<?php echo $staffInfo->role_id; ?>"
                                                                        selected>
                                                                        <?php echo strtoupper($staffInfo->role); ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                    <option value="">Select Role</option>
                                                                    <?php   if(!empty($designation))
                                                                            {
                                                                                foreach ($designation as $rl)
                                                                                {
                                                                                    ?>
                                                                    <option value="<?php echo $rl->roleId ?>"
                                                                        <?php if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>>
                                                                        <?php echo $rl->role ?></option>
                                                                    <?php
                                                                                }
                                                                            } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="team_id">Department<span class="text-danger">*</span></label>
                                                                <select required name="department"
                                                                    class="form-control selectpicker"
                                                                    data-live-search="true">
                                                                    <?php if(!empty($staffInfo->department)){ ?>
                                                                    <option
                                                                        value="<?php echo $staffInfo->department_id; ?>"
                                                                        selected>
                                                                        <?php echo strtoupper($staffInfo->department); ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                    <option value="">Select Department</option>
                                                                    <?php
                                                                    if(!empty($departments))
                                                                    {
                                                                        foreach ($departments as $rl)
                                                                        {
                                                                            ?>
                                                                    <option value="<?php echo $rl->dept_id ?>"
                                                                        <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>>
                                                                        <?php echo $rl->name; ?></option>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="mobile">Aadhar Number (optional)</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="aadhar_no" value="<?php echo $staffInfo->aadhar_no; ?>"
                                                                    name="aadhar_no" maxlength="12"
                                                                    placeholder="Enter Aadhar Number"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="mobile">PAN Number (optional)</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="pan_no"
                                                                    value="<?php echo $staffInfo->pan_no; ?>"
                                                                    name="pan_no" maxlength="15"
                                                                    placeholder="Enter PAN Number"
                                                                    autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="mobile">Voter ID No.(optional)</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="voter_no"
                                                                    value="<?php echo $staffInfo->voter_no; ?>"
                                                                    name="voter_no" maxlength="15"
                                                                    placeholder="Enter Voter ID Number"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label for="role">Address (optional)</label>
                                                                <textarea class="form-control required"
                                                                    value="<?php echo set_value('address'); ?>"
                                                                    name="address" id="address" rows="4"
                                                                    placeholder="Address" autocomplete="off" ><?php echo $staffInfo->address; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success float-right">
                                                            Submit </button>
                                                    </div>
                                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                        </div>
                                        </div>
                                       
                                        
                                        <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" data-toggle="modal" data-target="#assignSubjects" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Subject</button>
                                                    <h5 class="text-center font-weight-bold">Assigned Subjects</h5>
                                                    <div class="form-row">
                                                        <table class="table table-bordered text-dark mb-0">
                                                            <thead class="text-center">
                                                                <tr class="table_row_background">
                                                                    <th>Subject Code</th>
                                                                    <th>Subject Name</th>
                                                                    <th>Subject Type</th>
                                                                    <th>Department</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(!empty($staffSubjectInfo)){
                                                                    foreach($staffSubjectInfo as $staff){ ?>
                                                                    <tr class="text-center">
                                                                        <th><?php echo $staff->subject_code; ?></th>
                                                                        <th><?php echo $staff->sub_name; ?></th>
                                                                        <th><?php echo $staff->subject_type; ?></th>
                                                                        <th><?php echo $staff->name; ?></th>
                                                                        <td>
                                                                            <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN || $role == ROLE_OFFICE){ ?>
                                                                            <a class="btn btn-xs btn-danger deleteStaffSubject" href="#" data-row_id="<?php echo $staff->row_id; ?>" title="Delete Subject"><i class="fa fa-trash"></i></a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } }else{ ?>
                                                                    <tr class="text-center">
                                                                        <th colspan="5" style="background-color: #e3cfff;">Subject not assigned</th>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="section" role="tabpanel" aria-labelledby="section-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                        <button type="button" data-toggle="modal" data-target="#assignSection" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Class</button>
                                                        <h5 class="text-center font-weight-bold">Assigned Class</h5>
                                                    <div class="form-row">
                                                        <table class="table table-bordered text-dark mb-0">
                                                            <thead class="text-center">
                                                                <tr class="table_row_background">
                                                                    <th>Term Name</th>
                                                                    <th>Stream Name</th>
                                                                    <th>Section</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(!empty($staffSectionInfo)){
                                                                    foreach($staffSectionInfo as $staff){ ?>
                                                                    <tr class="text-center">
                                                                        <th><?php echo $staff->term_name; ?></th>
                                                                        <th><?php echo $staff->stream_name; ?></th>
                                                                        <th><?php echo $staff->section_name; ?></th>
                                                                        <td>
                                                                            <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN|| $role == ROLE_OFFICE){ ?>
                                                                            <a class="btn btn-xs btn-danger deleteStaffSection" href="#" data-row_id="<?php echo $staff->row_id; ?>" title="Delete Class"><i class="fa fa-trash"></i></a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php } }else{ ?>
                                                                    <tr class="text-center">
                                                                        <th colspan="4" style="background-color: #e3cfff;">Class not assigned</th>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="leaveIn" role="tabpanel" aria-labelledby="leaveIn-tab">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 pr-0 ">
                                                    <div class="card card-small c-border mb-4 p-1">
                                                    <div class="card-header text-center profile-img">
                                                        <?php if(!empty($profileImg)){ ?>
                                                        <img src="<?php echo $profileImg; ?>"
                                                            class="avatar rounded-circle img-thumbnail" width="130"
                                                            height="130" alt="Profile Image">
                                                        <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/images/user.png"
                                                            class="avatar rounded-circle img-thumbnail" width="130"
                                                            height="130" src="#" id="uploadedImage" name="userfile"
                                                           alt="Profile default">
                                                        <?php } ?>
                                                    </div>
                                                    <div class="card-body text-center profile_sidebar pt-0 pl-0 pr-0 mt-1">
                                                            <div class="p-1">
                                                                <i class="fa fa-id-card"></i>
                                                                <span
                                                                    style="color: #1e64b9;"><?php echo $staffInfo->staff_id; ?></span>
                                                            </div>
                                                            <hr class="mt-1 mb-1">
                                                            <div class="p-1">
                                                                <i class="far fa-calendar-alt"></i>
                                                                <span> <?php  if(empty($staffInfo->dob) || $staffInfo->dob == '0000-00-00'){
                                                                            echo "Not Updated";
                                                                        } else{
                                                                            echo date('d-m-Y',strtotime($staffInfo->dob));
                                                                        } ?></span>
                                                            </div>
                                                            <hr class="mt-1 mb-1">
                                                            <div class="p-1">
                                                                <i class="fas fa-mobile-alt"></i>
                                                                <?php if(empty($staffInfo->mobile)){ ?>
                                                                <span class="text-danger">Not Updated</span>
                                                                <?php } else { ?>
                                                                <span> <?php echo $staffInfo->mobile?></span>
                                                                <?php } ?>
                                                            </div>
                                                            <hr class="mt-1 mb-1">
                                                            <div class="p-1">
                                                                <i class="fas fa-envelope"></i>
                                                                <span> <?php if(empty($staffInfo->email)){ ?>
                                                                    <span class="text-danger">Not Updated</span>
                                                                    <?php } else { ?>
                                                                    <span> <?php echo $staffInfo->email?></span>
                                                                    <?php } ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-lg-8 col-md-8 col-12 ">
                                                    <div class="card card-small c-border">
                                                        <div class="card-header p-2">
                                                    <form role="form" action="<?php echo base_url() ?>updateLeaveInfo"
                                                        method="post">

                                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>"
                                                            id="row_id_leave" name="row_id_leave"> <input type="hidden"
                                                            value="<?php echo $staffInfo->staff_id; ?>"
                                                            name="staff_id_leave" />
                                                        <div class="row mb-2">
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="cl">Casual Leave</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="casual_leave"
                                                                    value="<?php if(empty($staffInfo->casual_leave_earned)){ echo "0";}else{echo $staffInfo->casual_leave_earned;} ?>"
                                                                    name="casual_leave" maxlength="5"
                                                                    placeholder="Add Casual Leave"
                                                                    onkeypress="return isNumberKey(event)" required
                                                                    autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="cl">Medical Leave</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="sick_leave"
                                                                    value="<?php if(empty($staffInfo->sick_leave_earned)){ echo "0";}else{echo $staffInfo->sick_leave_earned;} ?>"
                                                                    name="sick_leave" maxlength="5"
                                                                    placeholder="Add Medical Leave"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="cl">Paternity Leave</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="paternity_leave"
                                                                    value="<?php if(empty($staffInfo->paternity_leave_earned)){ echo "0";}else{echo $staffInfo->paternity_leave_earned;} ?>"
                                                                    name="paternity_leave" maxlength="5"
                                                                    placeholder="Add Paternity Leave"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="marriage_leave">Marriage Leave</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="marriage_leave"
                                                                    value="<?php if(empty($staffInfo->marriage_leave_earned)){ echo "0";}else{echo $staffInfo->marriage_leave_earned;} ?>"
                                                                    name="marriage_leave" maxlength="5"
                                                                    placeholder="Add Marriage Leave"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="cl">Maternity Leave</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="maternity_leave"
                                                                    value="<?php if(empty($staffInfo->maternity_leave_earned)){ echo "0";}else{echo $staffInfo->maternity_leave_earned;} ?>"
                                                                    name="maternity_leave" maxlength="5"
                                                                    placeholder="Add Maternity Leave"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="cl">Loss of Pay</label>
                                                                <input type="text" class="form-control required digits"
                                                                    id="lop"
                                                                    value="<?php if(empty($staffInfo->lop_leave)){ echo "0";}else{echo $staffInfo->lop_leave;} ?>"
                                                                    name="lop" maxlength="5"
                                                                    placeholder="Add Loss of Pay"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <hr class="mt-1 mb-1">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-12 col-md-12">
                                                                <button type="submit"
                                                                    class="btn btn-success float-right">
                                                                    Update </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                </div>
                                        </div>

                                            </div>
                                        </div>




                                        <div class="tab-pane fade" id="resign" role="tabpanel" aria-labelledby="resign-tab">
                <div class="row">
                    <div class="col-lg-4 col-md-4 pr-0 ">
                        <div class="card card-small c-border mb-4 p-1">
                            <div class="card-header text-center profile-img">
                                <?php if(!empty($profileImg)){ ?>
                                    <img src="<?php echo $profileImg; ?>"
                                        class="avatar rounded-circle img-thumbnail" width="120" height="130" alt="Profile Image">
                                                <?php } else { ?>
                                                    <img src="<?php echo base_url(); ?>assets/images/user.png"
                                                                class="avatar rounded-circle img-thumbnail" width="130"
                                                                height="100" src="#" id="uploadedImage" name="userfile"
                                                                width="130" height="100" alt="Profile default">
                                                <?php } ?>

                            </div>
                                                        <div
                                                            class="card-body text-center profile_sidebar pt-0 pl-0 pr-0 mt-1">
                                                            <div class="p-1">
                                                                <i class="fa fa-id-card"></i>
                                                                <span
                                                                    style="color: #1e64b9;"><?php echo $staffInfo->staff_id; ?></span>
                                                            </div>
                                                            <hr class="mt-1 mb-1">
                                                            <div class="p-1">
                                                                <i class="far fa-calendar-alt"></i>
                                                                <span> <?php  if(empty($staffInfo->dob) || $staffInfo->dob == '0000-00-00'){
                                                                            echo "Not Updated";
                                                                        } else{
                                                                            echo date('d-m-Y',strtotime($staffInfo->dob));
                                                                        } ?></span>
                                                            </div>
                                                            <hr class="mt-1 mb-1">
                                                            <div class="p-1">
                                                                <i class="fas fa-mobile-alt"></i>
                                                                <?php if(empty($staffInfo->mobile)){ ?>
                                                                <span class="text-danger">Not Updated</span>
                                                                <?php } else { ?>
                                                                <span> <?php echo $staffInfo->mobile?></span>
                                                                <?php } ?>
                                                            </div>
                                                            <hr class="mt-1 mb-1">
                                                            <div class="p-1">
                                                                <i class="fas fa-envelope"></i>
                                                                <span> <?php if(empty($staffInfo->email)){ ?>
                                                                    <span class="text-danger">Not Updated</span>
                                                                    <?php } else { ?>
                                                                    <span> <?php echo $staffInfo->email?></span>
                                                                    <?php } ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-8 col-12 pr-0 ">
                                                <form role="form" action="<?php echo base_url() ?>updateResignationInfo"
                                                        method="post">

                                                        <input type="hidden"
                                                                value="<?php echo $staffInfo->row_id; ?>" id="row_id"
                                                                name="row_id"> 
                                                        <input type="hidden"
                                                            value="<?php echo $staffInfo->staff_id; ?>"
                                                            name="staff_id" />
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6 col-md-6">
                                                                <label for="cl">Resignation Date</label>
                                                                <input type="text" class="form-control required datepicker_resign"
                                                                    id="resign_date"
                                                                    value="<?php if($staffInfo->resignation_date == '' || $staffInfo->resignation_date == '0000-00-00' || $staffInfo->resignation_date == '1970-01-01'){ echo ''; } else{ echo date('d-m-Y',strtotime($staffInfo->resignation_date)); } ?>"
                                                                    name="resign_date"
                                                                    placeholder="Add Resignation Date"
                                                                    onkeypress="return isNumberKey(event)" required
                                                                    autocomplete="off">
                                                            </div>
                                                            
                                                        </div>

                                                        <!-- <hr class="mt-1 mb-1"> -->
                                                        <div class="row mt-3 mr-3">
                                                            <div class="col-12 col-lg-12 col-md-12">
                                                                <button type="submit"
                                                                    class="btn btn-success float-right">
                                                                    Update </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade"
                                            id="changePassword" role="tabpanel" aria-labelledby="password-tab">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 pr-0 ">
                                                    <div class="card card-small c-border mb-4 p-1">
                                                        <div class="card-header text-center">
                                                            <?php if(!empty($profileImg)){ ?>
                                                            <img src="<?php echo $profileImg; ?>"
                                                                class="avatar rounded-circle img-thumbnail" width="130"
                                                                height="130" alt="Profile Image">
                                                            <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/user.png"
                                                                class="avatar rounded-circle img-thumbnail" width="130"
                                                                height="130" id="uploadedImage" name="userfile" alt="Profile default">
                                                            <?php } ?>

                                                        </div>
                                                        <table class="table profile_table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th><i class="fa fa-id-card"></i> ID<span class="float-right">:</span></th>
                                                                    <td><?php echo $staffInfo->staff_id; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><i class="far fa-calendar-alt"></i> DOB<span class="float-right">:</span></th>
                                                                    <td><?php if($staffInfo->dob == '0000-00-00' || empty($staffInfo->dob)){ 
                                                                        echo '<span class="text-danger">Not Updated</span>';
                                                                    } else { 
                                                                        echo $staffInfo->dob; 
                                                                    } ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><i class="fas fa-mobile-alt"></i> MOB.<span class="float-right">:</span></th>
                                                                    <td>
                                                                        <?php if(empty($staffInfo->mobile)){ 
                                                                            echo '<span class="text-danger">Not Updated</span>';
                                                                        } else{ 
                                                                            echo $staffInfo->mobile;
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><i class="fas fa-envelope"></i> EMAIL<span class="float-right">:</span></th>
                                                                    <td>
                                                                        <?php if(empty($staffInfo->email)){ 
                                                                            echo '<span class="text-danger">Not Updated</span>';
                                                                        } else{ 
                                                                            echo $staffInfo->email;
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <hr class="mt-1 mb-1">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 justify-content-center align-self-center">
                                                    <form role="form" method="post"
                                                        action="<?php echo base_url().'changePasswordAdmin/'.$staffInfo->row_id; ?>">
                                                        <!-- <div class="input-group mb-2 profile_changePassword">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text material-icons">lock</span>
                                                        </div>
                                                        <input type="password" class="form-control" placeholder="Old password"
                                                            id="oldPassword" name="oldPassword" autocomplete="off" required />
                                                    </div> -->
                                                        <div class="input-group mb-2 profile_changePassword">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text material-icons">lock</span>
                                                            </div>
                                                            <input type="password" class="form-control"
                                                                placeholder="New Password" id="password"
                                                                name="newPassword" autocomplete="off" required />
                                                        </div>
                                                        <div class="input-group mb-2 profile_changePassword">
                                                            <div class="input-group-prepend">
                                                                <span
                                                                    class="input-group-text material-icons">lock</span>
                                                            </div>
                                                            <input type="password" class="form-control equalTo"
                                                                placeholder="Re-Type Password" id="cNewPassword"
                                                                name="cNewPassword" autocomplete="off" required />
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-success ">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- End Default Light Table -->
    </div>
</div>


<!-- The Modal -->
<div class="modal fade" id="assignSubjects">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header exportModel">
            <h4 class="modal-title">Assign Subjects</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body px-1 pt-1 pb-3">
            <div class="">
                <table class="table table-bordered text-dark mb-0 table_info">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Subject Type</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($subjectInfo)){
                    foreach($subjectInfo as $sub){ ?>
                        <form method="post" role="form" action="<?php echo base_url() ?>updateStaffSubjects">
                            <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                            <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                            <input type="hidden" value="<?php echo $sub->row_id; ?>" id="sub_id" name="sub_id">
                            <input type="hidden" value="<?php echo $sub->subject_code; ?>" id="subject_code" name="subject_code">
                            <tr class="text-center">
                                <td class="text-center"><?php echo $sub->subject_code; ?></td>
                                <td><?php echo $sub->sub_name; ?></td>
                                <td>
                                    <div class="form-group m-0">
                                        <select class="form-control"  name="subjectType" id="subjectType" required>
                                            <option value="">Select Type</option>
                                            <option value="THEORY">THEORY</option>
                                            <?php if($sub->lab_status == 'true') { ?>
                                            <option value="LAB">LAB</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo $sub->name ?></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add</button>
                                </td>
                            </tr>
                        </form>
                        <?php } }else{ ?>
                        <tr class="text-center">
                            <th colspan="5" style="background-color: #e3cfff;">Staff subject is not available</th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="assignSection">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header exportModel">
            <h4 class="modal-title">Assign Class</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body px-1 pt-1 pb-1">
            <div class="">
                <table class="table table-bordered text-dark mb-0 table_info">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Term Name</th>
                            <th>Stream Name</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($sectionInfo)){
                            foreach($sectionInfo as $section){ ?>
                        <tr class="text-center">
                            <form method="POST" role="form" action="<?php echo base_url(); ?>updateStaffSection">
                                <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                                <input type="hidden" value="<?php echo $section->row_id; ?>" id="section_id" name="section_id">
                                <td><?php echo $section->term_name; ?></td>
                                <td><?php echo $section->stream_name; ?></td>
                                <td><?php echo $section->section_name ?></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add</button>
                                </td>
                            </form>
                        </tr>
                        <?php } }else{ ?>
                        <tr class="text-center">
                            <th colspan="5" style="background-color: #e3cfff;">Staff class is not available</th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).ready(function() {
    // var editStaffForm = $("#editStaff");
    //     alert('dd');
    //     var validator = editStaffForm.validate({

    //         rules:{
    //             staff_id : { required : true,remote : { url : baseURL + "checkStaffDExists", type :"post", data : { staff_id : function(){ return $("#staff_id").val(); } } } },
    //         },
    //         messages:{
    //             staff_id : { required : "This field is required", mobile : "Please enter valid Staff ID", remote : "Staff ID already Added" },		
    //         }
    //     });

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        jQuery("#searchList").attr("action", link);
        jQuery("#searchList").submit();
    });

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })

    // Prepare the preview for profile picture
    $("#wizard-picture").change(function() {
        readURL(this);
    });

    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        endDate: "today"
    });
    jQuery('.datepicker_resign').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        // startDate : "01-01-2021",
        // endDate: "today"
    });

});


$(document).ready(function() {
        // Initialize your datepicker here
        $('#dob').datepicker({
            format: 'dd-mm-yyyy', // Use the desired date format
            autoclose: true
        });

        // Trigger the datepicker when the button is clicked
        $('#datepicker-trigger').click(function() {
            $('#dob').datepicker('show');
        });
    });

    // Function to allow hyphen (-) to be entered
    function allowHyphen(event) {
        const input = event.target;
        if (event.key === '-' && input.value.length <= 10) {
            input.value += '-';
            event.preventDefault();
        }
    }

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#vImg").change(function() {
    readURL(this);
});

</script>