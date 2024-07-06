<style>
label {
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
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-1">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row p-0">
                <div class="col ">
                    <div class="card card-small card_heading_title p-0">
                        <div class="card-body p-2 ">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">group</i> Edit Staff Leave Info
                            </span>

                            <button onclick="goBack()"
                                class="btn primary_color float-right text-white pt-2" value="Back"><i class="fa fa-arrow-circle-left"></i>Back </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- form start -->

        <!-- Default Light Table -->
        <div class="row form-employee" >
            <div class="col-12">
                <div class="card card-small c-border mb-4 p-2">
                
                    <form method="POST" action="<?php echo base_url().'updateStaffLeaveInfoByAdmin'?>"  enctype="multipart/form-data">
                        <input type="hidden" name="row_id" value="<?php echo $AppliedLeaveInfo->row_id; ?>"/>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Leave Date From</label>
                                    <input type="text" class="ldatefrom form-control" name="fromDate" id="fromDate"
                                       value="<?php echo date('d-m-Y',strtotime($AppliedLeaveInfo->date_from)); ?>" placeholder="Date From" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Leave Date To</label>
                                    <input type="text" class="ldateto form-control" name="toDate" id="toDate"
                                    value="<?php echo date('d-m-Y',strtotime($AppliedLeaveInfo->date_to)); ?>"  placeholder="Date To" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total Number of Leave</label>
                                    <input placeholder="Total Number of Leave" class=" form-control"
                                    value="<?php echo $AppliedLeaveInfo->total_days_leave; ?>" name="total_leave_days" id="days_no" type="text" list="leaves" required />
                                    <datalist id="leaves">
                                        <option value="0.5">Half Day</option>
                                        <option value="1">One Day</option>
                                        <option value="1.5">One & Half Day</option>
                                        <option value="2">Two Day</option>
                                        <option value="2.5">Two & Half Day</option>
                                        <option value="3">Three Day</option>
                                        <option value="3.5">Three & Half Day</option>
                                        <option value="4">Four Day</option>
                                        <option value="4.5">Four & Half Day</option>
                                        <option value="5">Five Day</option>
                                        <option value="5.5">Five & Half Day</option>
                                        <option value="6">Six Day</option>
                                        <option value="6.5">Six & Half Day</option>
                                        <option value="7">Seven Day</option>
                                        <option value="7.5">Seven & Half Day</option>
                                        <option value="8">Eight Day</option>
                                        <option value="8.5">Eight & Half Day</option>
                                        <option value="9">Nine Day</option>
                                        <option value="9.5">Nine & Half Day</option>
                                        <option value="10">Ten Day</option>
                                        <option value="10.5">Ten & Half Day</option>
                                    </datalist>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group">
                                    <label for="leave_type">Leave Type</label>
                                    <select name="leave_type" class="form-control" id="leaveType" required>
                                        <option value="<?php echo $AppliedLeaveInfo->leave_type; ?>">Selected: <?php echo $AppliedLeaveInfo->leave_type; ?></option>
                                        <?php if(($leaveInfo->casual_leave_earned - $used_leave_cl->total_days_leave) != 0 ){ ?>
                                        <option value="CL">Casual Leave(CL) (rem :<?php echo $leaveInfo->casual_leave_earned - $used_leave_cl->total_days_leave; ?>)</option>
                                        <?php } ?>
                                        <?php if(($leaveInfo->sick_leave_earned - $used_leave_ml->total_days_leave) != 0 ){ ?>
                                        <option value="ML">Medical Leave(ML) (rem :<?php echo $leaveInfo->sick_leave_earned - $used_leave_ml->total_days_leave; ?>)</option>
                                        <?php } ?>
                                        <?php if(($leaveInfo->marriage_leave_earned - $used_leave_marl->total_days_leave) != 0 ){ ?>
                                        <option value="MARL">Marriage Leave(ML) (rem :<?php echo $leaveInfo->marriage_leave_earned - $used_leave_marl->total_days_leave; ?>)</option>
                                        <?php } ?>
                                        <?php if(($leaveInfo->paternity_leave_earned - $used_leave_pl->total_days_leave) != 0 ){ ?>

                                        <option value="PL">Paternity Leave(PL) (rem :<?php echo $leaveInfo->paternity_leave_earned - $used_leave_pl->total_days_leave;?>)</option>
                                        <?php } ?>
                                        <?php if(($leaveInfo->maternity_leave_earned - $used_leave_matl->total_days_leave) != 0 ){ ?>

                                        <option value="MATL">Maternity Leave(ML) (rem :<?php echo $leaveInfo->maternity_leave_earned - $used_leave_matl->total_days_leave; ?>)</option>
                                        <?php } ?>
                                        <?php if(($leaveInfo->earned_leave - $used_leave_el->total_days_leave) != 0 ){ ?>

                                        <option value="EL">Earned Leave(EL) (rem : <?php echo $leaveInfo->earned_leave - $used_leave_el->total_days_leave; ?>)</option>
                                        <?php } ?>
                                        <?php if(($leaveInfo->official_duty_earned - $used_leave_od->total_days_leave) != 0 ){ ?>

                                        <option value="OD">Offical Duty(OD)(rem: <?php echo $leaveInfo->official_duty_earned - $used_leave_od->total_days_leave;?>)</option>
                                        <?php } ?>
                                        <option value='LOP'>Loss Of Pay(LOP)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Reason for
                                        leave</label>
                                    <textarea placeholder="Write your reason here.." name="leave_reason"
                                        class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        required><?php echo $AppliedLeaveInfo->leave_reason; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="medical_certificate_upload">
                            <div class="col-4 text-center">
                                <?php if(!empty($AppliedLeaveInfo->medical_certificate)){ ?>
                                    <img src="<?php echo base_url(); ?><?php echo $AppliedLeaveInfo->medical_certificate; ?>" class="img-thumbnail"
                                        width="130" height="130" id="uploadedImage" alt="Medical Certificate">
                                <?php }else{ ?>
                                    <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" class="img-thumbnail"
                                        width="130" height="130" id="uploadedImage" alt="Medical Certificate">
                                <?php } ?>
                                <div class="profileImg">
                                    <div class="file btn btn-sm btn-primary">
                                        CHANGE
                                        <input type="file" class="form-control-sm" id="vImg" name="userfile" accept=".jpg,.png,.jpeg">
                                    </div>
                                </div>
                                <!-- <span class="text-danger font-weight-bold">(The Image maximum size is 300KB)</span> -->
                                <span id="certificate_msg" class="text-danger font-weight-bold"></span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-1 pull-left">Work Assign during my absence.</h6>
                                <button type="button" class="btn btn-danger pull-right" data-toggle="modal"
                                    data-target="#assignClassModel">Assign
                                    Work</button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <table id="staffAssignTable" class="table mb-0 table-bordered">
                                            <thead>
                                                <tr class="text-white bg-primary ">
                                                    <th>Date</th>
                                                    <th>Period</th>
                                                    <th>Class</th>
                                                    <th>Stream</th>
                                                    <th>Section</th>
                                                    <th>Staff ID</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($workAssign != NULL){
                                                foreach($workAssign as $record){?>
                                                    <tr class="text-center">
                                                    <td><?php echo date('d-m-Y',strtotime($record->assigned_date)); ?></td>
                                                    <td><?php echo $record->assigned_period; ?></td>
                                                    <td><?php echo $record->assigned_class_name; ?></td>
                                                    <td><?php echo $record->assigned_stream_name; ?></td>
                                                    <td><?php echo $record->assigned_class_section; ?></td>
                                                    <td><?php echo $record->assigned_staff_id; ?></td>
                                                    <td><a class="btn btn-sm btn-danger text-white " title="Delete"  onclick="deleteRow(this)"><i class="fa fa-trash"></i></a></td>
                                                    
                                                    </tr>
                                              <?php  }
                                            } else { ?>
                                                <tr class="text-center">
                                                <td colspan="6"> Work Assign Not Found! </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <hr class="mt-0 mb-1"> -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="btn btn-success btn-md float-right">Update
                                    Leave</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <!-- End Default Light Table -->
</div>





<!-- The Modal -->
<div class="modal" id="assignClassModel">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Work Assign during my absence.</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="role">Select Date</label>
                                <input type="text"  class="assignDate form-control" id="assignedDate" placeholder="Date"
                                    required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Period</label>
                            <select class="form-control" id="assignedPeriod">
                                <option value="">Select Period</option>
                                <option value="1">1 Period</option>
                                <option value="2">2 Period</option>
                                <option value="3">3 Period</option>
                                <option value="4">4 Period</option>
                                <option value="5">5 Period</option>
                                <option value="6">6 Period</option>
                                <option value="7">7 Period</option>
                                <option value="8">8 Period</option>
                                <option value="9">9 Period</option>
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Class</label>
                            <select class="form-control" id="assignedClass">
                                <option value="">Select Class</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Stream</label>
                            <select class="form-control" id="assignedStream">
                                <option value="">Select Stream</option>
                               <?php if(!empty($streamInfo)){
                                  foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name ?>">
                                      <?php echo $stream->stream_name ?>
                                    </option>
                                <?php }  } ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Section</label>
                            <select class="form-control" id="assignedSection">
                                <option value="">Select Class/Section</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="ALL">ALL (No Section)</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <label for="role">Assigned staff</label>
                            <select class="form-control input-sm" id="assigned_staff_id" name="staff_id">
                                <option value="">Select Staff </option>
                                <?php
                            if(!empty($staffInfo))
                            {
                                foreach ($staffInfo as $rl)
                                {
                                    ?>
                                <option value="<?php echo $rl->staff_id ?>">
                                    <?php echo $rl->name ?></option>
                                <?php
                                }
                            }
                        ?>
                            </select>
                        </div>
                    </div>


                    <hr class="mt-1 mb-1">
                    <!-- Modal footer -->

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <button type="button" class="btn pull-right btn-primary text-white" id="add" name="add"
                                onClick="productAddToTable();">ADD</button>
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
<script>
jQuery(document).ready(function() {

    jQuery('.ldatefrom , .ldateto, .ldateto, .assignDate').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",

    });
    var leaveType = $("#leaveType").val();
    if(leaveType == 'ML'){
        $('#medical_certificate_upload').show();
    }else{
        $('#medical_certificate_upload').hide();
    }

    $("#leaveType").change(function(){
        var leave_type = $("#leaveType").val();
        if(leave_type == 'ML'){
            $('#medical_certificate_upload').show();
            $('#vImg').prop('required',true);
        }else{
            $('#medical_certificate_upload').hide();
            $('#vImg').prop('required',false);
        }
    });

    $('#toDate').on('change', validateDates);

});
</script>
<script>
function productAddToTable() {
    if ($("#staffAssignTable tbody").length == 0) {
        $("#staffAssignTable").append("<tbody></tbody>");
    }
    if ($("#assignedDate").val() == 0) {
        alert('Please Select Assigned Date');
        return;
    }
    if ($("#assignedPeriod").val() == "") {
        alert('Please Select  Period to Assign');
    } else if ($("#assignedClass").val() == "") {
        alert('Please Select Class');
    } else if ($("#assigned_staff_id").val() == "") {
        alert('Please Select Staff');
    } else {
        // Append product to the table
        $("#staffAssignTable tbody").append(
            "<tr>" +
            "<td>" +
            $("#assignedDate").val() +
            "<input type='hidden' name='assignedDate[]'  id='dateAssigned' value=" + $("#assignedDate").val() +
            ">" +
            "<input type='hidden' name='assignedPeriod[]' id='assigned_period' value=" + $("#assignedPeriod")
        .val() + ">" +
            "<input type='hidden' name='assignedClass[]' id='class_assigned' value=" + $("#assignedClass").val() +
            ">" +
            "<input type='hidden' name='assignedStream[]' id='class_assigned' value=" + $("#assignedStream").val() +
            ">" +
            "<input type='hidden' name='assignedSection[]' id='section_assigned' value=" + $("#assignedSection")
            .val() + ">" +
            "<input type='hidden' name='assigned_staff_id[]' id='staff_id_assigned' value=" + $(
                "#assigned_staff_id").val() + ">" +
            "</td>" +
            "<td>" + $("#assignedPeriod").val() +
            "</td>" +
            "<td>" + $("#assignedClass").val() +
            "</td>" +
            "<td>" + $("#assignedStream").val() +
            "</td>" +
            "<td>" + $("#assignedSection").val() +
            "</td>" +
            "<td>" + $("#assigned_staff_id option:selected").text() +
            "</td>" +
            '<td class="text-center"> <a class="btn btn-sm btn-danger text-white " title="Delete"  onclick="deleteRow(this)"><i class="fa fa-trash"></i></a></td>' +
            "</tr>"
        );
    }
}
function parseDate(dateStr) {
    // Try to parse date in DD-MM-YYYY format
    let parts = dateStr.split('-');
    if (parts.length === 3) {
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }

    // Try to parse date in MM/DD/YYYY format
    parts = dateStr.split('/');
    if (parts.length === 3) {
        return new Date(parts[2], parts[0] - 1, parts[1]);
    }

    // Fallback to Date constructor for other formats
    return new Date(dateStr);
}

function validateDates() {
    var fromDateStr = document.getElementById('fromDate').value;
    var toDateStr = document.getElementById('toDate').value;
    var totalDays = parseFloat(document.getElementById('days_no').value);

    var fromDate = parseDate(fromDateStr);
    var toDate = parseDate(toDateStr);

    // Check if the dates are valid
    if (isNaN(fromDate.getTime()) || isNaN(toDate.getTime()) || isNaN(totalDays)) {
        console.log('Invalid date(s) or totalDays.');
        return;
    }

    var dayCount = 0;
    var currentDate = new Date(fromDate);

    while (currentDate <= toDate) {
        var dayOfWeek = currentDate.getDay();
        if (dayOfWeek !== 0) { // Exclude Sundays (0 is Sunday)
            dayCount++;
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    if (dayCount !== totalDays) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date Range',
            text: 'Please ensure the selected dates cover exactly ' + totalDays + ' working days.',
        });
        document.getElementById('toDate').value = '';
    }
}


function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function goBack() {
    showLoader();
    window.history.back();
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
    if(this.files[0].type === 'application/pdf'){
        alert('Upload Only JPG, PNG or JPEG Files');
        $("#vImg").val('');
    }else{
        var file_size = this.files[0].size;
        if(file_size <= 305000){
            readURL(this);
            $('#certificate_msg').html("");
        }else{
            $("#vImg").val('');
            $('#certificate_msg').html("File size should be less than 300KB"); 
        }
    }
});
</script>