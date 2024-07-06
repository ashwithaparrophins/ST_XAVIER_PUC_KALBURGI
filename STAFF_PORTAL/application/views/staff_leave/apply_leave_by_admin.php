<style>
.table td {
    text-align: center;
    padding: 1px !important;
    color: black;
    font-weight: 500;
}
</style>
<div class="col-md-12">
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


</div> 
<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="row mt-1">
            <div class="col column_padding_card">
                <div class="card card_heading_title card-small p-0">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-12">
                                <span class="page-title">
                                    <i class="fa fa-clock"></i> Apply Leave by Administrator
                                </span>
                            </div>

                            <div class="col-lg-2 col-sm-2 col-12 box-tools">
                            <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white "
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12 column_padding_card">
                <div class="card card-body p-2 mb-4">

                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="<?php echo base_url().'applyStaffLeaveByAdmin'?>" enctype="multipart/form-data">
                                
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <label for="role">Select Applied Staff</label>
                                        <select class="form-control input-sm selectpicker" id="applied_staff_id"
                                            name="applied_staff_id" data-live-search="true" required>
                                            <option value="">Select Staff </option>
                                            <?php
                                        if(!empty($staffInfo))
                                        {
                                            foreach ($staffInfo as $rl)
                                            {
                                                ?>
                                            <option value="<?php echo $rl->staff_id ?>">
                                                <?php echo strtoupper($rl->name); ?></option>
                                            <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="leave_type">Leave Type</label>
                                            <select name="leave_type" class="form-control"
                                                id="leave_type" required>
                                             
                                                <option value="">Select One</option>
                                              
                                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Total Number of
                                                Leave</label>
                                            <input  min="0" max="31" step=".10" id="days_no" placeholder="Total Number of Leave" class=" form-control"
                                                name="total_leave_days" type="number" list="leaves" required />
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

                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Leave Date From</label>
                                            <input type="text" class="ldatefrom form-control" name="fromDate"
                                                id="fromDate" placeholder="Date From" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-12 dateTo">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Leave Date To</label>
                                            <input type="text" class="ldateto form-control" name="toDate" id="toDate"
                                                placeholder="Date To" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row"> -->
                                    

                                    
                                <!-- </div> -->

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Reason for
                                                leave</label>
                                            <textarea placeholder="Write staff reason here.." name="leave_reason"
                                                class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" id="medical_certificate_upload">
                                    <div class="col-4 text-center">
                                        <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" class="img-thumbnail"
                                            width="130" height="130" id="uploadedImage" alt="Medical Certificate">
                                        <div class="profileImg">
                                            <div class="file btn btn-sm btn-primary">
                                                UPLOAD
                                                <input type="file" class="form-control-sm" id="vImg" name="userfile" accept=".jpg,.png,.jpeg">
                                            </div>
                                        </div>
                                        <!-- <span class="text-danger font-weight-bold">(The Image maximum size is 300KB)</span> -->
                                        <span id="certificate_msg" class="text-danger font-weight-bold"></span>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header" style="padding: 6px;">
                                        <h6 class="mb-1 pull-left">Work assign during staff absence.</h6>
                                        <button type="button" class="btn btn-danger pull-right" data-toggle="modal"
                                            data-target="#assignClassModel">Assign
                                            Work</button>
                                    </div>
                                    <div class="card-body" style="padding: 6px;">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12">
                                                <table id="staffAssignTableNew" class="table mb-0 table-bordered">
                                                    <thead>
                                                        <tr class="text-white bg-primary ">
                                                            <th>Date</th>
                                                            <th>Period</th>
                                                            <th>Class</th>
                                                             <th>Stream</th>
                                                            <th>Section</th>
                                                            <th>Staff</th>
                                                            <th class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <hr class="mt-0 mb-1"> -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="btn btn-success btn-md float-right">Apply
                                            Leave</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="assignClassModel">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Work Assign during staff absence.</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="role">Select Date</label>
                                <input type="text" class="assignDate form-control" id="assignedDate" placeholder="Date"
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
                            <select class="form-control selectpicker" id="assignedClass" data-live-search="true">
                                <option value="">Select Class</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Stream</label>
                            <select class="form-control selectpicker" id="assignedStream" data-live-search="true">
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
                            <select class="form-control input-sm selectpicker" id="assigned_staff_id" name="staff_id"
                                data-live-search="true">
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




<script>
jQuery(document).ready(function() {




    jQuery('.assignDate, .datepicker_from, .datepicker_to, #dateAssigned, #fromDate, #toDate').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"
    });
    $('#leave_type').change(function() {
        var leave_type = $(this).val();
        if (leave_type === '') {
            $('#days_no, #fromDate').prop('disabled', true);
        } else {
            $('#days_no, #fromDate').prop('disabled', false);
        }
        
    }).change();

    $('.dateTo').hide();
    $('#days_no').on('input', function() {
        var days = this.value;
        if(days > 1){
            $('.dateTo').show();
            $('#toDate').prop('required', true);
        } else {
            $('.dateTo').hide();
            $('#toDate').prop('required', false);
        }
    });
    $('#toDate').on('change', validateDates);

    $('#applied_staff_id').on('change', function() {
        var staff_id = this.value;
        $('#leave_type option:not(:first)').remove();
        $.ajax({
        url: baseURL+'/getStaffLeaveInfoByStaffId',
        type: 'POST',
        dataType: 'json',
        data: {
            staff_id: staff_id,
        },
        success: function(data) {
            if(data.leaveInfo != null || data.leaveInfo != ""){
                var cl_rem = data.leaveInfo.casual_leave_earned - data.used_leave_cl.total_days_leave;
                var ml_rem = data.leaveInfo.sick_leave_earned - data.used_leave_ml.total_days_leave;
                var mdl_rem = data.leaveInfo.marriage_leave_earned - data.used_leave_marl.total_days_leave;
                var pl_rem = data.leaveInfo.paternity_leave_earned - data.used_leave_pl.total_days_leave;
                var mtl_rem = data.leaveInfo.maternity_leave_earned - data.used_leave_matl.total_days_leave;
                var el_rem = data.leaveInfo.earned_leave - data.used_leave_el.total_days_leave;
                var od_rem = data.leaveInfo.official_duty_earned - data.used_leave_od.total_days_leave;
                
                if(cl_rem != 0){
                    $("#leave_type").append(new Option('CASUAL LEAVE (Rem: '+cl_rem+')',
                                'CL'));
                }
                if(ml_rem != 0){
                    $("#leave_type").append(new Option('MEDICAL LEAVE (Rem: '+ml_rem+')',
                                'ML'));
                }
                if(mdl_rem != 0){
                    $("#leave_type").append(new Option('MARRIAGE LEAVE (Rem: '+mdl_rem+')',
                                'MARL'));
                }
                if(pl_rem != 0){
                    $("#leave_type").append(new Option('PATERNITY LEAVE (Rem: '+pl_rem+')',
                                'PL'));
                }
                if(mtl_rem != 0){
                    $("#leave_type").append(new Option('MATERNITY LEAVE (Rem: '+mtl_rem+')',
                                'MATL'));
                }
                if(el_rem != 0){
                    $("#leave_type").append(new Option('EARNED LEAVE (Rem: '+el_rem+')',
                                'EL'));
                }
                if(od_rem != 0){
                    $("#leave_type").append(new Option('OFFICIAL DUTY (Rem: '+od_rem+')',
                                'OD'));
                }
            }
        },
        error: function(result) {
            alert("Network Server Error!!  Failed");
        },
        fail: (function(status) {
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {}
    });

    $("#leave_type").append(new Option('Loss Of Pay(LOP)',
                                'LOP'));
    });

    
    $('#medical_certificate_upload').hide();
    $("#leave_type").change(function(){
        var leave_type = $("#leave_type").val();
        if(leave_type == 'ML'){
            $('#medical_certificate_upload').show();
            $('#vImg').prop('required',true);
        }else{
            $('#medical_certificate_upload').hide();
            $('#vImg').prop('required',false);
        }
    });

});
</script>
<script>
function productAddToTable() {
    if ($("#staffAssignTableNew tbody").length == 0) {
        $("#staffAssignTableNew").append("<tbody></tbody>");
    }
    if ($("#assignedDate").val() == 0) {
        alert('Please Select Assigned Date');
        return;
    }
    if ($("#assignedPeriod").val() == "") {
        alert('Please Select  Period to Assign');
    } else if ($("#assignedClass").val() == "") {
        alert('Please Select Class');
    } else if ($("#assignedStream").val() == "") {
        alert('Please Select Stream');
    } else if ($("#assigned_staff_id").val() == "") {
        alert('Please Select Staff');
    }else {
        // Append product to the table
        $("#staffAssignTableNew tbody").append(
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

function validateDates() {
    var fromDate = new Date(document.getElementById('fromDate').value);
    var toDate = new Date(document.getElementById('toDate').value);
    var totalDays = parseFloat(document.getElementById('days_no').value);

    if (isNaN(fromDate.getTime()) || isNaN(toDate.getTime()) || isNaN(totalDays)) {
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

function viewMoreInfo(row_id) {
    $("#staffAssignTable tbody").html("");
    $.ajax({
        url: '<?php echo base_url(); ?>/getStaffLeaveInfoById',
        type: 'POST',
        dataType: 'json',
        data: {
            row_id: row_id,
        },
        success: function(data) {
            //format date as per indian standard
            let current_datetime = new Date(data.leaveInfo.date_from);
            let formatted_date_from_date = appendLeadingZeroes(current_datetime.getDate()) + "-" +
                appendLeadingZeroes((current_datetime.getMonth() + 1)) +
                "-" + current_datetime.getFullYear();

            let current_datetime_to = new Date(data.leaveInfo.date_to);
            let formatted_date_to_date = appendLeadingZeroes(current_datetime_to.getDate()) + "-" +
                appendLeadingZeroes((current_datetime_to.getMonth() + 1)) +
                "-" + current_datetime_to.getFullYear();
            var leave_type = "";
            if (data.leaveInfo.leave_type == 'LOP') {
                leave_type = "LOSS OF PAY";
            } else if (data.leaveInfo.leave_type == 'CL') {
                leave_type = "CASUAL LEAVE";
            } else if (data.leaveInfo.leave_type == 'MARL') {
                leave_type = "MARRIAGE LEAVE";
            } else if (data.leaveInfo.leave_type == 'PL') {
                leave_type = "PATERNITY LEAVE";
            } else if (data.leaveInfo.leave_type == 'MATL') {
                leave_type = "MATERNITY LEAVE";
            } else if (data.leaveInfo.leave_type == 'ML') {
                leave_type = "MEDICAL LEAVE";
            }
            $("#staff_name_view").html(data.leaveInfo.name);
            $("#date_from_view").html(formatted_date_from_date);
            $("#date_to_view").html(formatted_date_to_date);
            $("#total_day_view").html(data.leaveInfo.total_days_leave);
            $("#leave_type_view").html(leave_type);
            $("#reason_view").html(data.leaveInfo.leave_reason);

            $("#casual_pending").html(data.leavePending.casual_leave_earned - data.leavePending
                .casual_leave_used);
            $("#medical_pending").html(data.leavePending.sick_leave_earned - data.leavePending
                .sick_leave_used);
            $("#loss_of_pay_used").html(data.leavePending.lop_leave);



            for (var i = 0; i < Object.keys(data.workAssign).length; i++) {
                var work_assign_date = new Date(data.workAssign[i].assigned_date);
                var work_assign_date_valid = appendLeadingZeroes(work_assign_date.getDate()) + "-" +
                    appendLeadingZeroes((work_assign_date.getMonth() + 1)) +
                    "-" + work_assign_date.getFullYear();
                $("#staffAssignTable tbody").append(
                    "<tr class='text-center'>" +
                    "<td >" +
                    work_assign_date_valid +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_period +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_class_name +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_stream_name +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_class_section +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_staff_id +
                    "</td>" +
                    "</tr>"
                );
            }
            if (Object.keys(data.workAssign).length == 0) {
                $("#staffAssignTable tbody").append(
                    "<tr>" +
                    "<td class='text-center' colspan='6'> Work assign not found! </td>" +
                    "</tr>"
                );
            }
            var approveButton = "";

            if (data.leaveInfo.approved_status == 0) {
                approveButton = "<b class='pull-right' style='color:red;'>Pending</b>";
            } else if (data.leaveInfo.approved_status == 1) {
                approveButton = "<b class='pull-right' style='color:green;'>Approved</b>";
            } else {
                approveButton = "<b class='pull-right' style='color:red;'>Rejected</b>";
            }
            $("#approveButton").html(approveButton);
            $('#leaveInfoModel').modal('show');
        },
        error: function(result) {
            alert("Network Server Error!!  Failed");
        },
        fail: (function(status) {
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {}
    });
}

function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
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