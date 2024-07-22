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
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row ">
            <div class="col ">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-md-8 col-8 text-black  " style="font-size:22px;"><i
                                    class="fa fa-users"></i>&nbsp;Edit Student <span class="text-uppercase"><?php echo $studentInfo->student_name; ?></span></div>
                            <div class="col-md-4 col-4"> 
                                <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck pull-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form start -->
        <!-- Default Light Table -->
        <div class="row form-contents">
            <div class="col-lg-12 col-12">
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
                                    </ul>
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            
                                            <form role="form" id="updateStudent" action="<?php echo base_url() ?>updateStudent" method="post" enctype="multipart/form-data">
                                                <input type="hidden" value="<?php echo $studentInfo->row_id; ?>" id="row_id" name="row_id">
                                                <input type="hidden" value="<?php echo $studentInfo->application_no; ?>" id="application_no" name="application_no">
                                                <div class="table-responsive-sm table-responsive-md table-responsive-xs">
                                                    <table class="table table-bordered table-striped table_edit_student">
                                                        <tr>
                                                            <td style="background:white" width="100" rowspan="8" class="p-0">
                                                                <div class="profile-img">
                                                                <?php
                                                        $profileImg = $studentInfo->photo_url;
                                                            if(!empty($profileImg)){ ?>
                                                        <img src="<?php echo $profileImg; ?>" class="img-thumbnail"
                                                         alt="Profile Image" id="uploadedImage" name="userfile">
                                                        <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="img-thumbnail"
                                                         id="uploadedImage" name="userfile" alt="Profile default">
                                                        <?php } ?>
                                                                    <div class="file btn btn-sm btn-primary">
                                                                        Change Photo
                                                                        <input type="file" class="form-control-sm" id="vImg" name="userfile">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head mobile_input_width" width="120">Application No.</th>
                                                            <th><?php echo $studentInfo->application_no; ?></th>
                                                            <th class="tbl-head mobile_input_width" width="140">Full Name</th>
                                                            <th width="240">
                                                                <div class="form-group form-group-sm mb-0 mobile_input_width">
                                                                    <input value="<?php echo $studentInfo->student_name; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Student Name" 
                                                                    id="student_name" name="student_name" maxlength="128" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head mobile_input_width" width="140">Date of Birth</th>
                                                            <th width="170">
                                                            <div class="input-group mb-0">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text material-icons date-icon">date_range</span>
                                                                </div>
                                                                <input
                                                                value="<?php if($studentInfo->dob != '0000-00-00' && $studentInfo->dob != '1970-01-01'){
                                                                    echo ($studentInfo->dob);
                                                                } ?>"
                                                                id="dob" type="date" name="dob" class="form-control required " placeholder="Date of Birth" autocomplete="off" />
                                                            </div>
                                                        </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head" width="140">Gender</th>
                                                            <th width="180">
                                                                <div class="form-group mb-0 mobile_input_width">
                                                                    <select class="form-control" id="gender" name="gender">
                                                                        <option value="<?php echo $studentInfo->gender; ?>" >
                                                                            Selected: <?php echo $studentInfo->gender; ?>
                                                                        </option>
                                                                        <option value="MALE">MALE</option>
                                                                        <option value="FEMALE">FEMALE</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Blood Group</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control" id="blood_group" name="blood_group" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->blood_group; ?>" >
                                                                            Selected: <?php echo $studentInfo->blood_group; ?>
                                                                        </option>
                                                                        <option value="A+"> A+</option>
                                                                        <option value="O+">O+</option>
                                                                        <option value="B+">B+</option>
                                                                        <option value="AB+">AB+</option>
                                                                        <option value="A-">A-</option>
                                                                        <option value="B-">B-</option>
                                                                        <option value="AB-">AB-</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Nationality</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select name="nationality" id="nationality" class="form-control" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->nationality; ?>"selected>
                                                                            Selected: <?php echo $studentInfo->nationality; ?>
                                                                        </option>
                                                                        <?php if(!empty($nationalityInfo)){ 
                                                                            foreach ($nationalityInfo as $nationality) { ?>
                                                                                <option value="<?php echo $nationality->name ?>">
                                                                                    <?php echo $nationality->name ?>
                                                                                </option>
                                                                            <?php   } 
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Religion</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select name="religion" id="religion" class="form-control" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->religion; ?>"selected>
                                                                            Selected: <?php echo $studentInfo->religion; ?>
                                                                        </option>
                                                                        <?php if(!empty($religionInfo)){ 
                                                                            foreach ($religionInfo as $religion) { ?>
                                                                                <option value="<?php echo $religion->name ?>">
                                                                                    <?php echo $religion->name ?>
                                                                                </option>
                                                                            <?php   } 
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Caste</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->caste; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Caste" 
                                                                    id="caste" name="caste" maxlength="128" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Category</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select name="category" id="category" class="form-control" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->category; ?>"selected>
                                                                            Selected: <?php echo $studentInfo->category; ?>
                                                                        </option>
                                                                        <?php if(!empty($categoryInfo)){ 
                                                                            foreach ($categoryInfo as $category) { ?>
                                                                                <option value="<?php echo $category->row_id ?>">
                                                                                    <?php echo $category->category_name ?>
                                                                                </option>
                                                                            <?php   } 
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Sub caste</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->sub_caste; ?>" type="text" 
                                                                    class="form-control required" placeholder="Sub Caste" 
                                                                    id="sub_caste" name="sub_caste" autocomplete="off"/>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Mother Tongue</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->mother_tongue; ?>" type="text" 
                                                                        class="form-control required" placeholder="Mother Tongue" 
                                                                        id="mother_tongue" name="mother_tongue" maxlength="280" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Mobile</th>
                                                            <th>
                                                            <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->mobile; ?>" type="text" 
                                                                        class="form-control required" placeholder="Mobile" 
                                                                        id="mobile" name="mobile" maxlength="10" minlength="10" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                          
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">State</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->state; ?>" type="text" 
                                                                        class="form-control required" placeholder="State" 
                                                                        id="state" name="state" maxlength="280" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>


                                                            <th class="tbl-head">Pincode</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->pincode; ?>" type="text" 
                                                                        class="form-control required" placeholder="Pincode" 
                                                                        id="pincode" name="pincode" maxlength="280" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Aadhar No</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->aadhar_no; ?>" type="text" 
                                                                        class="form-control required" placeholder="Aadhar No" onkeypress="return isNumberKey(event)"
                                                                        id="aadhar_no" name="aadhar_no" maxlength="12" minlength="12" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>

                                                        </tr>
                                                        <tr>
                                                        <th class="tbl-head">Place of Birth</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->place_of_birth; ?>" type="text" 
                                                                        class="form-control required" placeholder="Place of Birth" 
                                                                        id="place_of_birth" name="place_of_birth" maxlength="280" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>


                                                            <th class="tbl-head">Taluk</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->taluk; ?>" type="text" 
                                                                        class="form-control required" placeholder="Taluk" 
                                                                        id="taluk" name="taluk" maxlength="280" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">District</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->district; ?>" type="text" 
                                                                        class="form-control required" placeholder="District"
                                                                        id="district" name="district" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>

                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Primary Mobile</th>
                                                            <th>
                                                            <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->primary_mobile; ?>" type="text" 
                                                                        class="form-control required" placeholder="Primary Mobile" 
                                                                        id="primary_mobile" name="primary_mobile" maxlength="10" minlength="10" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <?php $RouteName = $transport->getStudentPickUpInfo($studentInfo->route_id);?>
                                                            <th class="tbl-head" >I PUC Route</th>
                                                            <th width="240">
                                                                <div class="form-group mb-0 input_mobile_width">
                                                                    <select class="form-control " id="route" name="route" autocomplete="off">
                                                                        <?php if (!empty($studentInfo->route_id)) { ?>
                                                                            <option value="<?php echo $studentInfo->route_id; ?>">
                                                                                Selected: <?php echo $RouteName->pickup_point_name; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Transport Route</option>
                                                                        <?php foreach($routeInfo as $route){ ?>
                                                                            <option value="<?php echo $route->row_id; ?>"><?php echo $route->pickup_point; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <?php if ($studentInfo->term_name == 'II PUC') { ?>
                                                            <?php $RouteNameII = $transport->getStudentPickUpInfo($studentInfo->route_id_II);?>
                                                            <th class="tbl-head" >II PUC Route</th>
                                                            <th width="240">
                                                                <div class="form-group mb-0 input_mobile_width">
                                                                    <select class="form-control " id="routeII" name="routeII" autocomplete="off">
                                                                        <?php if (!empty($studentInfo->route_id_II)) { ?>
                                                                            <option value="<?php echo $studentInfo->route_id_II; ?>">
                                                                                Selected: <?php echo $RouteNameII->pickup_point_name; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Transport Route</option>
                                                                        <?php foreach($routeInfo as $route){ ?>
                                                                            <option value="<?php echo $route->row_id; ?>"><?php echo $route->pickup_point; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <?php } ?>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="table-responsive mt-1">
                                                    <table class="table table-bordered table_edit_student ">
                                                        <tr>
                                                            <th class="tbl-head" width="250">Physically Challenged</th>
                                                            <th width="250">
                                                                <select class="form-control mobile_input_width" id="is_handicapped" name="is_handicapped" data-live-search="true">
                                                                    <option value="<?php echo $studentInfo->Is_physically_challenged; ?>" >
                                                                        Selected: <?php if($studentInfo->Is_physically_challenged == 0){ echo "No"; }else{ echo "Yes"; } ?>
                                                                    </option>
                                                                    <option value="0" >No</option>
                                                                    <option value="1" >Yes</option>
                                                                </select>
                                                            </th>
                                                            <th class="tbl-head" width="250">Dyslexia</th>
                                                            <th>
                                                                <select class="form-control mobile_input_width" id="is_dyslexic" name="is_dyslexic" data-live-search="true">
                                                                    <option value="<?php echo $studentInfo->is_dyslexic; ?>">
                                                                        Selected: <?php echo $studentInfo->is_dyslexic; ?>
                                                                    </option>
                                                                    <option value="No" >No</option>
                                                                    <option value="Yes" >Yes</option>
                                                                </select>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="card" style="font-size:16px; font-weight:900">
                                                            <div class="card-header head-title text-center p-1 tbl-head">
                                                                <span style="font-size:16px; font-weight:900">Present Address</span></div>
                                                            <div class="card-body p-1">
                                                                <textarea type="text" rows="4" class="form-control required p-1" placeholder="Present Address" id="present_address" 
                                                                name="present_address"autocomplete="off"><?php echo $studentInfo->present_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="card " style="font-size:16px; font-weight:900">
                                                            <div class="card-header head-title text-center p-1 tbl-head">
                                                                <span style="font-size:16px; font-weight:900">Permanent Address</span></div>
                                                            <div class="card-body p-1">
                                                            <div class="form-group mb-0">
                                                                <textarea type="text" rows="4" class="form-control required p-1" placeholder="Permanent Address" id="permanent_address"
                                                                 name="permanent_address"autocomplete="off"><?php echo $studentInfo->permanent_address; ?></textarea>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mt-2">
                                                        <thead>
                                                            <tr class="head-title">
                                                                <th colspan="8" class="text-center tbl-head">Family Info</th>
                                                            </tr>
                                                            <tr class="head-title tbl-head">
                                                                <th class="text-center">Member Name</th>
                                                                <th class="text-center">Relationship</th>
                                                                <th class="text-center">Qualification</th>
                                                                <th class="text-center">Profession</th>
                                                                <th class="text-center">Annual Income</th>
                                                                <th class="text-center">Mobile Number</th>
                                                                <th class="text-center">Email Id</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <th><input value="<?php echo $studentInfo->father_name; ?>" type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Name" 
                                                                    id="father_name" name="father_name" maxlength="250" autocomplete="off" required/></th>
                                                            <th width="190">
                                                                <input type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Relation Type" 
                                                                    value="FATHER" autocomplete="off" readonly/>
                                                            </th>
                                                            <th><input value="<?php echo $studentInfo->father_educational_qualification; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Qualification" 
                                                                    id="father_educational_qualification" name="father_educational_qualification" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_profession; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Profession" 
                                                                    id="father_profession" name="father_profession" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_annual_income; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Annual Income" 
                                                                    id="father_annual_income" name="father_annual_income" maxlength="15" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_mobile; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Mobile Number" 
                                                                    id="father_mobile" name="father_mobile" maxlength="15" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_email; ?>" type="email" 
                                                                    class="form-control required mobile_input_width" placeholder="Email" 
                                                                    id="father_email" name="father_email" autocomplete="off"/></th>
                                                        </tr>
                                                        <tr>
                                                            <th><input value="<?php echo $studentInfo->mother_name; ?>" type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Name" 
                                                                    id="mother_name" name="mother_name" maxlength="250" autocomplete="off" required/></th>
                                                            <th width="190">
                                                                <input type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Relation Type" 
                                                                    value="MOTHER" autocomplete="off" readonly/>
                                                            </th>
                                                            <th><input value="<?php echo $studentInfo->mother_educational_qualification; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Qualification" 
                                                                    id="mother_educational_qualification" name="mother_educational_qualification" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_profession; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Profession" 
                                                                    id="mother_profession" name="mother_profession" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_annual_income; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Annual Income" 
                                                                    id="mother_annual_income" name="mother_annual_income" maxlength="15" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_mobile; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Mobile Number" 
                                                                    id="mother_mobile" name="mother_mobile" maxlength="15" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_email; ?>" type="email" 
                                                                    class="form-control required mobile_input_width" placeholder="Email" 
                                                                    id="mother_email" name="mother_email" autocomplete="off"/></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                                            </form>
                                          
                                        </div>
                                        <div class="tab-pane fade" id="academic" role="tabpanel"
                                            aria-labelledby="academic-tab">
                                            <form role="form" action="<?php echo base_url() ?>updateStudentAcademicInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $studentInfo->row_id; ?>" id="row_id" name="row_id">
                                                <input type="hidden" value="<?php echo $studentInfo->application_no; ?>" id="application_no" name="application_no">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table_edit_student ">
                                                        <tr>
                                                            <th class="tbl-head" width="160">Application Number</th>
                                                            <th width="140"><?php echo $studentInfo->application_no; ?></th>
                                                            <th class="tbl-head" width="160">PU Board No.</th>
                                                            <th width="140"><input value="<?php echo $studentInfo->pu_board_number; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Register Number" 
                                                                    id="register_no" name="register_no" autocomplete="off"/></th>
                                                            <th class="tbl-head" width="120">Student ID</th>
                                                            <th width="160"><?php echo $studentInfo->student_id; ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head" width="150">Elective</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control" id="elective_sub" name="elective_sub" required>
                                                                        <option value="<?php echo $studentInfo->elective_sub; ?>" selected:>
                                                                            Selected: <?php echo $studentInfo->elective_sub; ?>
                                                                        </option>
                                                                        <option value="Kannada">Kannada</option>
                                                                        <option value="Hindi">Hindi</option>
                                                                        <option value="French">French</option>
                                                                        <option value="Exempted">Exempted</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Term</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="term_name" name="term_name" autocomplete="off" required>
                                                                        <option value="<?php echo $studentInfo->term_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->term_name); ?>
                                                                        </option>
                                                                        <option value="">Select Term</option>
                                                                        <option value="I PUC">I PUC</option>
                                                                        <option value="II PUC">II PUC</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Stream</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="stream_name" name="stream_name" autocomplete="off" required>
                                                                        <option value="<?php echo $studentInfo->stream_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->stream_name); ?>
                                                                        </option>
                                                                        <option value="">Select Stream</option>
                                                                        <?php if(!empty($streamInfo)){
                                                                            foreach($streamInfo as $stream){ ?>
                                                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Section</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="section_name" name="section_name" autocomplete="off">
                                                                        <?php if(!empty($studentInfo->section_name)){ ?>
                                                                        <option value="<?php echo $studentInfo->section_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->section_name); ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Section</option>
                                                                        <option value="A">A</option>
                                                                        <option value="B">B</option>
                                                                        <option value="C">C</option>
                                                                        <option value="D">D</option>
                                                                        <option value="E">E</option>
                                                                        <option value="F">F</option>
                                                                        <option value="G">G</option>
                                                                        <option value="H">H</option>
                                                                        <option value="I">I</option>
                                                                        <option value="J">J</option>
                                                                        <option value="K">K</option>
                                                                        <option value="L">L</option>
                                                                        <option value="M">M</option>
                                                                        <option value="N">N</option>
                                                                        <option value="O">O</option>
                                                                        <option value="P">P</option>
                                                                        <option value="Q">Q</option>
                                                                        <option value="R">R</option>
                                                                        <option value="S">S</option>
                                                                        <option value=" ">ALL (No Section)</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head" width="160">Hall Ticket No.</th>
                                                            <th width="140"><input value="<?php echo $studentInfo->hall_ticket_no; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Hall Ticket Number" 
                                                                    id="hall_ticket_no" name="hall_ticket_no" autocomplete="off"/></th>
                                                                    <th class="tbl-head" width="160">Date of Admission</th>
                                                    <th width="140">
                                                        <div class="input-group mb-0">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text material-icons date-icon">date_range</span>
                                                                </div>
                                                                <input
                                                                value="<?php if($studentInfo->date_of_admission != '0000-00-00' && $studentInfo->date_of_admission != '1970-01-01'){
                                                                    echo ($studentInfo->date_of_admission);
                                                                } ?>"
                                                                id="date_of_admission" type="date" name="date_of_admission" class="form-control required " placeholder="Admisison Date" autocomplete="off" required />
                                                            </div>
                                                        </div>
                                                    </th>

                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">SAT Number</th>
                                                            <th>
                                                            <input value="<?php echo $studentInfo->sat_number;?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="SAT Number" 
                                                                    id="sat_number" name="sat_number" autocomplete="off"/>
                                                            </th>
                                                            <th class="tbl-head" width="160">Date of Join</th>
                                                        <th width="140">
                                                        <div class="input-group mb-0">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text material-icons date-icon">date_range</span>
                                                                </div>
                                                                <input
                                                                value="<?php if($studentInfo->doj != '0000-00-00' && $studentInfo->doj != '1970-01-01'){
                                                                    echo ($studentInfo->doj);
                                                                } ?>"
                                                                id="doj" type="date" name="doj" class="form-control required " placeholder="Date of Join" autocomplete="off" required />
                                                            </div>
                                                        </div>
                                                        </th>
                                                        <th class="tbl-head"> Admission Number</th>
                                                        <th width="140"><input value="<?php echo $studentInfo->admission_number; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Admission Number" 
                                                                    id="admission_number" name="admission_number" autocomplete="off"/></th>


                                                            <!-- <th></th> -->
                                                        </tr>
                                                    </table>
                                                </div>
                                                <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
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
        <!-- End Default Light Table -->
    </div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}
jQuery(document).ready(function() {

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })
    
    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        endDate: "today"
    });

            // Get the ID of the active tab from local storage
            var activeTabId = localStorage.getItem('vincentpuTabIdStudE');

            // If the ID is not null or undefined, activate the corresponding tab
            if (activeTabId) {
            $('#myTab a[href="#' + activeTabId + '"]').tab('show');
            }

            // Store the ID of the clicked tab in local storage
            $('#myTab a').on('click', function() {
                var tabId = $(this).attr('href').substring(1);
                localStorage.setItem('vincentpuTabIdStudE', tabId);
            });

});


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

$(document).ready(function() {
        // Initialize your datepicker here
        // $('#dob').datepicker({
        //     format: 'dd-mm-yyyy', // Use the desired date format
        //     autoclose: true
        // });

        // Trigger the datepicker when the button is clicked
        $('#datepicker-trigger').click(function() {
            $('#dob').datepicker('show');
        });

        // $("#datepicker-trigger-admission").click(function() {
        //     $("#date_of_admission").datepicker("show");
        // });

        $("#datepicker-trigger-join").click(function() {
            $("#doj").datepicker("show");
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
</script>