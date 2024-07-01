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
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12 padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1 card_head_dashboard">
                        <div class="row ">
                            <div class="col-md-6 col-8 text-black m-auto " style="font-size:22px;"><i
                                    class="fa fa-user"></i>&nbsp;Add Student Details
                            </div>
                            <div class="col-md-6 col-4 m-auto"> <a href="#" onclick="GoBackWithRefresh();return false;"
                                    class="btn text-white btn-primary btn-bck float-right mobile-btn "><i
                                        class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a></div>
                        </div>
                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addStudent" action="<?php echo base_url() ?>addStudentInfoToDB"
                            method="post" role="form" enctype="multipart/form-data">
                            <div class="row form-contents">
                                <div class="col-lg-3 text-center">
                                    <div class="text-center">
                                        <label for="fname">Profile Image</label>
                                    </div>
                                    <img src="<?php echo base_url(); ?>assets/images/user.png"
                                        class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                        id="uploadedImage" name="userfile" alt="avatar">
                                    <div class="profileImg">
                                        <div class="file btn btn-sm btn-primary">
                                            Change
                                            <input type="file" class="form-control-sm" id="vImg" name="userfile">
                                          
                                        </div>
                                    </div>
                                    <span class="text-danger font-weight-bold">(The Image maximum size is 2MB)</span>
                                </div>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="student_name">Full Name<span
                                                        class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="student_name"
                                                    name="student_name" placeholder="Full Name" autocomplete="off"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="gender">Gender<span
                                                        class="text-danger required_star">*</span></label>
                                                <select class="form-control" id="gender" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="MALE">MALE</option>
                                                    <option value="FEMALE">FEMALE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="dob">Date of Birth<span
                                                        class="text-danger required_star"></span></label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span
                                                            class="input-group-text material-icons date-icon">date_range</span>
                                                    </div>
                                                    <input id="dob" type="text" name="dob"
                                                        class="form-control required datepicker"
                                                        placeholder="Date of Birth" autocomplete="off"/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="term_name">Term<span
                                                        class="text-danger required_star">*</span></label>
                                                <select class="form-control" id="term_name" name="term_name" required >
                                                    <option value="">Select Term</option>
                                                    <option value="I PUC">I PUC</option>
                                                    <option value="II PUC">II PUC</option>
                                                </select>
                                            </div>
                                        </div>


                                        <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="program_name">Program<span
                                                        class="text-danger required_star">*</span></label>
                                                <select class="form-control" id="program_name" name="program_name" required>
                                                    <option value="">Select Program</option>
                                                    <option value="SCIENCE">SCIENCE</option>
                                                    <option value="ARTS">ARTS</option>
                                                    <option value="COMMERCE">ARTS</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="student_id">Student ID</label>
                                                <input type="text" class="form-control" id="student_id"
                                                    name="student_id" placeholder="Student ID"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div> -->

                                        <div class="col-md-4 col-12">
                                            <label for="section_name">Stream<span
                                                        class="text-danger required_star">*</span></label>
                                            <select class="form-control" id="stream_name" name="stream_name" required>
                                                                        <option value="">Select Stream</option>
                                                                        <?php if(!empty($streamInfo)){
                                                                            foreach($streamInfo as $stream){ ?>
                                                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                                        <?php } } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="admission_no">Admission Number<span
                                                        class="text-danger required_star"></span></label>
                                                <input type="text" class="form-control" id="admission_no"
                                                    name="admission_no" placeholder="Admission Number"
                                                    onkeypress="return isNumber(event)" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="date_of_admission">Date of Admission<span
                                                        class="text-danger required_star"></span></label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span
                                                            class="input-group-text material-icons date-icon">date_range</span>
                                                    </div>
                                                    <input id="date_of_admission" type="text" name="date_of_admission"
                                                        class="form-control required datepicker"
                                                        placeholder="Date of Admission" autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="sat_number">SAT Number</label>
                                                <input type="text" class="form-control" id="sat_number"
                                                    name="sat_number" placeholder="SAT Number"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div> -->

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="program_name">Program<span
                                                        class="text-danger required_star">*</span></label>
                                                <select class="form-control" id="program_name" name="program_name" required>
                                                    <option value="">Select Program</option>
                                                    <option value="SCIENCE">SCIENCE</option>
                                                    <option value="ARTS">ARTS</option>
                                                    <option value="COMMERCE">COMMERCE</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="elective_sub">Elective<span
                                                        class="text-danger required_star"></span></label>
                                                <select class="form-control" id="elective_sub" name="elective_sub">
                                                    <option value="">Select Elective</option>
                                                    <option value="HINDI">HINDI</option>
                                                    <option value="KANNADA">KANNADA</option>
                                                    <option value="SANSKRIT">SANSKRIT</option>
                                                    <!-- <option value="FRENCH">FRENCH</option> -->
                                                    <option value="EXEMPTED">EXEMPTED</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12 ">
                                            <label for="admission_staus">Admission Status<span class="text-danger required_star">*</span></label>
                                            <select class="form-control" id="admission_status" name="admission_status" required>
                                                <option value="">Select Admission Status</option>
                                                <option value="1">New Admission</option>
                                                <option value="0">Regular</option>
                                            </select>
                                    </div>

                                    <div class="col-md-4 col-12 intakeInfo">
                                            <label for="intake_year">Intake year<span class="text-danger required_star">*</span></label>
                                            <select class="form-control" id="intake_year" name="intake_year" required>
                                                <option value="">Select Intake year</option>
                                                <option value="2024-25">2024-25</option>
                                                <option value="2023-24">2023-24</option>
                                                <option value="2022-23">2022-23</option>
                                                <option value="2021-22">2021-22</option>
                                                <option value="2020-21">2020-21</option>
                                            </select>
                                    </div>


                                    <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="student_id">Student ID<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control" id="student_id"
                                                    name="student_id" placeholder="Student ID"
                                                   autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <label for="section_name">Section</label>
                                            <select class="form-control" id="section_name" name="section_name">
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
                                                                        <option value="ALL">ALL (No Section)</option>
                                            </select>
                                        </div>

                                         <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="student_id">Student ID</label>
                                                <input type="text" class="form-control" id="student_id"
                                                    name="student_id" placeholder="Student ID"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div> -->
                                        <div class="col-md-4 col-12">
                                            <label for="application_no">Application Number</label>
                                            <input type="text" class="form-control" id="application_no"
                                                    name="application_no" placeholder="Application Number"
                                                    autocomplete="off">
                                            
                                        </div>
                                        <!-- <div class="col-md-4 col-12">
                                            <label for="previous_class">Previous Class</label>
                                            <select class="form-control" id="previous_class" name="previous_class">
                                                <option value="">Select Previous Class</option>
                                                <option value="FRESH">FRESH</option>
                                                <?php if(!empty($termInfo)){
                                              foreach($termInfo as $term){ ?>
                                                <option value="<?php echo $term->term_name; ?>">
                                                    <?php echo $term->term_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div> -->
                                        <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="previous_school">Previous School Name</label>
                                                <input type="text" class="form-control" id="previous_school"
                                                    name="previous_school" placeholder="Previous School Name"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="previous_tc_no">Previous TC NO.</label>
                                                <input type="text" class="form-control" id="previous_tc_no"
                                                    name="previous_tc_no" placeholder="Previous TC NO."
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="tc_recieved_date">TC Received Date</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span
                                                            class="input-group-text material-icons date-icon">date_range</span>
                                                    </div>
                                                    <input id="tc_date" type="text" name="tc_date"
                                                        class="form-control required datepicker"
                                                        placeholder="TC Recieved Date" autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="no_of_dependent">No. of Dependent</label>
                                                <input type="text" class="form-control" id="no_of_dependent"
                                                    name="no_of_dependent" placeholder="No. of Dependent"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div> -->

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="pu_board_number">PU Board Number</label>
                                                <input type="text" class="form-control" id="pu_board_number"
                                                    name="pu_board_number" placeholder="PU Board Number"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="hall_ticket_number">Hall Ticket Number</label>
                                                <input type="text" class="form-control" id="hall_ticket_number"
                                                    name="hall_ticket_number" placeholder="Hall Ticket Number"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="sat_number">SAT Number</label>
                                                <input type="text" class="form-control" id="sat_number"
                                                    name="sat_number" placeholder="SAT Number"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 col-12 ">
                                            <label for="admission_staus">Special Course</label>
                                            <select class="form-control" id="special_course" name="special_course" >
                                                <option value="">Select Special Course</option>
                                                <option value="PCM">PCM</option>
                                                <option value="PCB">PCB</option>
                                                <option value="PCMB">PCMB</option>
                                            </select>
                                        </div> -->
                                       
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="last_studied">Percentage <span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control" title="State"
                                                    placeholder="Percentage" id="percentage" name="percentage" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="sat_number">SSLC Marks</label>
                                                <input type="text" class="form-control" id="sslc_marks"
                                                    name="sslc_marks" placeholder="SSLC Marks"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="sat_number">Primary Mobile <span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control" id="primary_mobile"
                                                    name="primary_mobile" placeholder="Primary Mobile" maxlength="10" minlength="10"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row form-contents">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Email" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="aadhar_no">Aadhar Number</label>
                                                <input type="text" class="form-control" id="aadhar_no" name="aadhar_no"
                                                    placeholder="Aadhar Number" onkeypress="return isNumberKey(event)"
                                                    pattern="[0-9]*" maxlength="12" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="blood_group">Blood Group</label>
                                                <select class="form-control" id="blood_group" name="blood_group">
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="nationality_name">Nationality</label>
                                                <select name="nationality_name" id="nationality_name"
                                                    class="form-control  selectpicker" data-live-search="true">
                                                    <option value="">Select Nationality</option>
                                                    <?php if(!empty($nationalityInfo)){
                                                    foreach($nationalityInfo as $nation){ ?>
                                                    <option value="<?php echo $nation->name; ?>">
                                                        <?php echo $nation->name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="religion_name">Religion</label>
                                                <select name="religion_name" id="religion_name"
                                                    class="form-control  selectpicker" data-live-search="true">
                                                    <option value="">Select Religion</option>
                                                    <?php if(!empty($religionInfo)){
                                            foreach($religionInfo as $rec){ ?>
                                                    <option value="<?php echo $rec->name; ?>">
                                                        <?php echo $rec->name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="category_name">Category </label>
                                                <select name="category_name" id="category_name"
                                                    class="form-control  selectpicker" data-live-search="true">
                                                    <option value="">Select Category</option>
                                                    <?php if(!empty($categoryInfo)){
                                                                foreach($categoryInfo as $category){ ?>
                                                    <option value="<?php echo $category->category_name; ?>">
                                                        <?php echo $category->category_name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="caste">Caste</label>
                                                <select name="caste" id="caste" class="form-control  selectpicker"
                                                    data-live-search="true">
                                                    <option value="">Select Caste</option>
                                                    <?php if(!empty($casteInfo)){
                                                        foreach($casteInfo as $caste){ ?>
                                                    <option value="<?php echo $caste->name; ?>">
                                                        <?php echo $caste->name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">Sub Caste</label>
                                                <input type="text" class="form-control" title="Sub Caste"
                                                    placeholder="Sub Caste" id="sub_caste" name="sub_caste"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">Mother Tongue</label>
                                                <input type="text" class="form-control" title="Mother Tongue"
                                                    placeholder="Mother Tongue" id="mother_tongue" name="mother_tongue"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">Place of Birth</label>
                                                <input type="text" class="form-control" title="Place of Birth"
                                                    placeholder="Place of Birth" id="place_of_birth"
                                                    name="place_of_birth" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="taluk">Taluk</label>
                                                <input type="text" class="form-control" id="taluk" name="taluk"
                                                    placeholder="Taluk" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">District</label>
                                                <input type="text" class="form-control" title="District"
                                                    placeholder="District" id="district" name="district"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">State</label>
                                                <input type="text" class="form-control" title="State"
                                                    placeholder="State" id="state" name="state" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="email">Pincode</label>
                                                <input type="text" class="form-control" title="Pincode"
                                                    placeholder="Pincode" id="pincode" name="pincode" autocomplete="off">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="last_studied">Last Studied<span>*</span></label>
                                                <input type="text" class="form-control" title="State"
                                                    placeholder="last_studied" id="last_studied" name="last_studied" autocomplete="off" required>
                                            </div>
                                        </div> -->

                                        


                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="permanent_address">Permanent Address<span
                                                        class="text-danger required_star"></span></label>
                                                <textarea class="form-control required"
                                                    value="<?php echo set_value('permanent_address'); ?>"
                                                    name="permanent_address" id="permanent_address" rows="4"
                                                    placeholder="Permanent Address" autocomplete="off"
                                                    ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="present_address">Present Address<span
                                                        class="text-danger required_star"></span></label>
                                                <textarea class="form-control required"
                                                    value="<?php echo set_value('present_address'); ?>"
                                                    name="present_address" id="present_address" rows="4"
                                                    placeholder="Present Address" autocomplete="off"
                                                    ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Father Info
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-1 my-1 pb-1">
                            <div class="row form-contents">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_name">Father Name<span
                                                class="text-danger required_star">*</span></label>
                                        <input type="text" class="form-control required" id="father_name"
                                            name="father_name" placeholder="Father Name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_email">Father Email</label>
                                        <input type="email" class="form-control" id="father_email" name="father_email"
                                            placeholder="Father Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_mobile_one">Father Mobile Number<span
                                                class="text-danger required_star">*</span></label>
                                        <input type="text" class="form-control" id="father_mobile_one"
                                            name="father_mobile_one" placeholder="Father Mobile Number" maxlength="10" minlength="10"
                                            onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_aadhar">Father Aadhar</label>
                                        <input type="text" class="form-control" id="father_aadhar" name="father_aadhar"
                                            placeholder="Father Aadhar" onkeypress="return isNumberKey(event)"
                                            pattern="[0-9]*" maxlength="12" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_profession">Father Profession</label>
                                        <input type="text" class="form-control required" id="father_profession"
                                            name="father_profession" placeholder="Father Profession" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_qualification">Father Qualification</label>
                                        <input type="text" class="form-control required" id="father_qualification"
                                            name="father_qualification" placeholder="Father Qualification" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="father_annual_income">Father Income</label>
                                        <input type="text" class="form-control required" id="father_annual_income"
                                            name="father_annual_income" placeholder="Father Income" autocomplete="off">
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Mother Info
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-1 my-1 pb-1">
                            <div class="row form-contents">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_name">Mother Name<span
                                                class="text-danger required_star">*</span></label>
                                        <input type="text" class="form-control required" id="mother_name"
                                            name="mother_name" placeholder="Mother Name" maxlength="128"
                                            autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_email">Mother Email</label>
                                        <input type="email" class="form-control" id="mother_email" name="mother_email"
                                            placeholder="Mother Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_mobile_one">Mother Mobile Number<span
                                                class="text-danger required_star">*</span></label>
                                        <input type="text" class="form-control " id="mother_mobile_one"
                                            name="mother_mobile_one" placeholder="Mother Mobile Number" maxlength="10" minlength="10"
                                            onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_aadhar">Mother Aadhar</label>
                                        <input type="text" class="form-control" id="mother_aadhar" name="mother_aadhar"
                                            placeholder="Mother Aadhar" onkeypress="return isNumberKey(event)"
                                            pattern="[0-9]*" maxlength="12" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_profession">Mother Profession</label>
                                        <input type="text" class="form-control required" id="mother_profession"
                                            name="mother_profession" placeholder="Mother Profession" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_profession">Mother Qualification</label>
                                        <input type="text" class="form-control required" id="mother_qualification"
                                            name="mother_qualification" placeholder="Mother Qualification" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="mother_annual_income">Mother Income</label>
                                        <input type="text" class="form-control required" id="mother_annual_income"
                                            name="mother_annual_income" placeholder="Mother Income" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Guardian Info
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-1 my-1 pb-1">
                            <div class="row form-contents">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="guardian_name">Guardian Name</label>
                                        <input type="text" class="form-control required" id="guardian_name"
                                            name="guardian_name" placeholder="Guardian Name" maxlength="128"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="guardian_email">Guardian Email</label>
                                        <input type="email" class="form-control" id="guardian_email"
                                            name="guardian_email" placeholder="Guardian Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="guardian_mobile_no">Guardian Mobile Number</label>
                                        <input type="text" class="form-control " id="guardian_mobile_no"
                                            name="guardian_mobile_no" placeholder="Guardian Mobile Number"
                                            maxlength="10" onkeypress="return isNumberKey(event)" autocomplete="off">
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Emergency Info
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-1 my-1 pb-1">
                            <div class="row form-contents">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name_for_emergency">Person To Be Contacted</label>
                                        <input type="text" class="form-control required" id="name_for_emergency"
                                            name="name_for_emergency" placeholder="Person To Be Contacted"
                                            maxlength="128" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="emergency_mobile">Mobile</label>
                                        <input type="text" class="form-control " id="emergency_mobile"
                                            name="emergency_mobile" placeholder="Mobile" maxlength="10"
                                            onkeypress="return isNumberKey(event)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="relation_type">Relation</label>
                                        <input type="text" class="form-control required" id="relation_type"
                                            name="relation_type" placeholder="Relation" autocomplete="off">
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Medical Info
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-1 my-1 pb-1">
                            <div class="row form-contents">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="is_handicapped">Physically Challenged<span
                                                        class="text-danger"></span></label>
                                                <select class="form-control" id="is_handicapped" name="is_handicapped" required>
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="is_dyslexic">Dyslexia<span
                                                        class="text-danger"></span></label>
                                                <select class="form-control" id="is_dyslexic" name="is_dyslexic" required>
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                <!-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="doctor_name">Doctor Name</label>
                                        <input type="text" class="form-control required" id="doctor_name"
                                            name="doctor_name" placeholder="Doctor Name" maxlength="128"
                                            autocomplete="off">
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="doctor_mobile">Doctor Mobile Number</label>
                                        <input type="text" class="form-control " id="doctor_mobile" name="doctor_mobile"
                                            placeholder="Doctor Mobile Number" maxlength="10"
                                            onkeypress="return isNumberKey(event)" autocomplete="off">
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="allergies">Allergies(if any)</label>
                                        <textarea class="form-control required" name="allergies" id="allergies" rows="4"
                                            placeholder="Allergies(if any)" autocomplete="off"></textarea>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="chronic_ailment">Chronic Ailment(if any)</label>
                                        <textarea class="form-control required" name="chronic_ailment"
                                            id="chronic_ailment" rows="4" placeholder="Chronic Ailment(if any)"
                                            autocomplete="off"></textarea>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="history_of_surgeries">History of Surgeries(if any)</label>
                                        <textarea class="form-control required" name="history_of_surgeries"
                                            id="history_of_surgeries" rows="4"
                                            placeholder="History of Surgeries(if any)" autocomplete="off"></textarea>
                                    </div> -->
                                <!-- </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="other_health_issues">Any Other Health Issues(if any)</label>
                                        <textarea class="form-control required" name="other_health_issues"
                                            id="other_health_issues" rows="4"
                                            placeholder="Any Other Health Issues(if any)" autocomplete="off"></textarea>
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Bank Info
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-1 my-1 pb-1">
                            <div class="row form-contents">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="bank_name">Bank Name</label>
                                        <input type="text" class="form-control required" id="bank_name" name="bank_name"
                                            placeholder="Bank Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="branch_name">Branch Name</label>
                                        <input type="text" class="form-control required" id="branch_name"
                                            name="branch_name" placeholder="Branch Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="bank_account_no">Bank Account Number</label>
                                        <input type="text" class="form-control required" id="bank_account_no"
                                            name="bank_account_no" placeholder="Bank Account Number" maxlength="18"
                                            onkeypress="return isNumberKey(event)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="ifsc_code">IFSC Code</label>
                                        <input type="text" class="form-control required" id="ifsc_code" name="ifsc_code"
                                            placeholder="IFSC Code" autocomplete="off">
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left  pt-0 pb-0 ml-0"
                                        style="font-weight: 600; color: #2864ac; font-size: 16px;">Student Type
                                    </div>
                                </div>
                            </div>
                            <div class="row form-contents">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <select name='type' class="form-control required input_mobile_width">
                                            <option value='0'>REGULAR</option> 
                                            <option value='1'>NEW ADMISSION</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <input style="float:right;" type="submit" class="btn btn-primary" value="Submit" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/staff/student.js" type="text/javascript"></script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = '<?php echo base_url(); ?>/studentDetails';
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

function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 48 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
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


jQuery(document).ready(function() {
    $('.id_required').hide();
    $('#student_id').prop('required',true);
    $(".health_description").hide();

    
    $("#any_health_issues").change(function(e) {
        var value = $("#any_health_issues").val();
        if (value == 'Yes') {
            $(".health_description").show();
        } else {
            $(".health_description").hide();
        }
    });
    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        changeYear: true,
        format: "dd-mm-yyyy",
        yearRange: "1990:2030" // Sets the year range from 1990 to 2030
    });




    $('#term_name').on('change', function() { 
$('#term_name').val(this.value);
if(this.value=="I PUC" ){
    $('.id_required').hide();
    $('#student_id').prop('required',true);
  
   
}else{
$('.id_required').show();
$('#student_id').prop('required',true);
}

});






    $('#admission_status').on('change', function() {
            $('#admission_status_name').val(this.value);
           
            if (this.value == '0') {
                $('.intakeInfo').show();
                $('#intake_year').prop('required',true);
            } else{
               
                $('.intakeInfo').hide();
                $('#intake_year').prop('required',false);
      
            } 
        });

});
</script>