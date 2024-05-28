<style>
label{
    font-weight: 500 !important;
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
    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-1">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row ">
                <div class="col">
                    <div class="card card-small p-0 card_heading_title">
                        <div class="card-body p-2 ml-2">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">group</i> Add New Staff
                            </span>

                            <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2 "
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- form start -->
        <form role="form" id="addNewStaff" action="<?php echo base_url() ?>addNewStaffToSjbhs" method="post" role="form"
            enctype="multipart/form-data">
            <!-- Default Light Table -->
            <div class="row form-employee">
                <div class="col-lg-4">
                    <div class="card card-small c-border mb-4 p-2">
                        <div class="card-header text-center">
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
                            <!-- <input type="file" class="form-control-sm" id="vImg" name="userfile"> -->
                        </div>
                        <div class="form-group">
                            <label for="employee_id">Staff ID<span class="text-danger">*</span></label>
                            <input type="text" class="form-control required" value="" id="staff_id" name="staff_id"
                                maxlength="128" placeholder="Enter Staff ID" autocomplete="off" required>
                            <h6 class="error-hint display-none accessHide" style="color:red">Staff Id Already exists</h6>
                        </div>
                        <div class="form-group">
                            <label for="fname">Full Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control required" value="<?php echo set_value('fname'); ?>"
                                id="employee_name" name="fname" maxlength="128" placeholder="Enter Full Name"
                                autocomplete="off" required>
                        </div>
                        <label for="return_date">Date Of Birth (optional)</label>
                        <div class="input-group mb-0 mobile_input_width">
                                <input id="dob" type="text" name="dob" class="form-control datepicker emp-dob required" placeholder="Date of Birth" autocomplete="off" onkeydown="allowHyphen(event)" />
                                <div class="input-group-append">
                                     <button class="btn btn-outline-secondary" type="button" id="datepicker-trigger">
                                    <i class="material-icons date-icon p-2">date_range</i>
                                    </button>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender<span class="text-danger">*</span></label>
                            <select class="form-control required" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="blood_group">Blood Group<span class="text-danger">*</span></label>
                            <select class="form-control required" id="blood_group" name="blood_group" required>
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
                <div class="col-lg-8">
                    <div class="card card-small c-border mb-4 ">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label  for="email ">Email (optional)</label>
                                                <input type="email" class="form-control required" id="email"
                                                    value="<?php echo set_value('email'); ?>" name="email"
                                                    maxlength="228" placeholder="Enter Email Address"
                                                    autocomplete="off" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control required digits"
                                                    id="mobile"
                                                    value="<?php echo set_value('mobile'); ?>"
                                                    name="mobile" maxlength="10" minlength="10"
                                                    placeholder="Enter Contact Number"
                                                    onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Date of Join<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker_doj"
                                                    id="alternative_contact_number"
                                                    value="<?php echo set_value('date_of_join'); ?>"
                                                    name="date_of_join" maxlength="15"
                                                    placeholder="Select Date of Join" autocomplete="off" required/>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="role">Role<span class="text-danger">*</span></label>
                                                <select required name="role" class="form-control required selectpicker" id="role_id" name="role_id" data-live-search="true">
                                                    <option value="">Select Role</option>
                                                    <?php   if(!empty($designation))
                                                {
                                                    foreach ($designation as $rl)
                                                    { 
                                                        if($rl->roleId!= 50){  ?>
                                                        <option value="<?php echo $rl->roleId ?>" <?php if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                        <?php
                                                    }}
                                                } ?>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="team_id">Department<span class="text-danger">*</span></label>
                                                <select required name="department" class="form-control required selectpicker"  data-live-search="true">
                                                    <option value="">Select Department</option>
                                                    <?php
                                                        if(!empty($departments))
                                                        {
                                                            foreach ($departments as $rl)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $rl->dept_id ?>" <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Aadhar Number (optional)</label>
                                                <input type="text" class="form-control required digits"
                                                    id="aadhar_no"
                                                    value="<?php echo set_value('aadhar_no'); ?>"
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
                                                    value="<?php echo set_value('pan_no'); ?>"
                                                    name="pan_no" maxlength="15"
                                                    placeholder="Enter PAN Number"
                                                    autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Voter ID No.(optional)</label>
                                                <input type="text" class="form-control required digits"
                                                    id="voter_no"
                                                    value="<?php echo set_value('voter_no'); ?>"
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
                                                    placeholder="Address" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"> Submit </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form> <!-- form end -->
        <!-- End Default Light Table -->
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/employee/addEmployee.js" type="text/javascript"></script>
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
    $('.accessHide').hide();
    $('#staff_id').on('keyup', function(evt){
            let staffId = $(this).val();
            $('.accessHide').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>/getStaffIdCode',
                type: 'POST',
                dataType: "json",
                data: { 
                    staffId : staffId
                },
                success: function(data) {
                    //var examObject = JSON.parse(data);
                    var examObject = JSON.stringify(data)
                    var count = data.result.length;
                    if(count != 0){
                        if(data.result.staff_id == staffId){
                            $('.accessHide').show();
                        }else{
                            $('.accessHide').hide();
                        }
                    }else{
                        $('.accessHide').hide();
                    }
                }
            });
        });
        
    $('select').selectpicker();
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
        dateFormat: "dd-mm-yy",
        maxDate : 0,
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