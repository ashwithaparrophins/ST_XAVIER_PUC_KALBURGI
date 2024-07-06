<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}

.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
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

<div class="main-content-container px-3 pt-1">
    <div class="content-wrapper">
        <div class="row p-0">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 ">
                    <div class="card-body p-2">
                        <div class="row ">
                            <div class="col-lg-8 col-sm-8 col-12">
                                <span class="page-title">
                                    <i class="fa fa-user"></i> Staff Applied Leave Info
                                </span>
                            </div>

                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="btn-group pull-right" role="group" aria-label="New Action">
                                    <!-- <?php if($role == ROLE_ADMIN || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                        <button data-toggle="modal" data-target="#downloadStaffLeaveReport" type="button"
                                        class="btn btn-info"><i class="material-icons">cloud_download</i>
                                        Report</button>
                                    <?php } ?> -->
                                    <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i>Back </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table id="leave-list" style="width:100%"
                            class="display nowrap table table-bordered table-striped table-hover">
                            <thead>
                                <tr>

                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Total Leaves</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Total Leaves</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>


        </div>

    </div>
</div>


<!-- The leave view Modal -->
<div class="modal" id="leaveInfoModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">View Leave Info of <span id="staff_name_view"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-8 col-8">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="table-danger">
                                        <td>Date From</td>
                                        <td id="date_from_view"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Date To</td>
                                        <td id="date_to_view"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Total Days</td>
                                        <td id="total_day_view"></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Leave Type</td>
                                        <td id="leave_type_view"></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Reason</td>
                                        <td id="reason_view"></td>
                                    </tr>

                                    <tr class="table-default">
                                        <td>Approved Staff ID</td>
                                        <td id="approved_by"></td>
                                    </tr>

                                    <tr class="table-default">
                                        <td>Rejected Staff ID</td>
                                        <td id="rejected_by"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4 col-4">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="table-danger">
                                        <td class="text-center" colspan="2">Quick Info Remaining</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Casual Leave </td>
                                        <td id="casual_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Medical Leave</td>
                                        <td id="medical_pending"></td>
                                    </tr>
                                     <tr class="table-primary">
                                        <td>Marriage Leave</td>
                                        <td id="marriage_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Paternity Leave</td>
                                        <td id="paternity_pending"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Maternity Leave</td>
                                        <td id="maternity_pending"></td>
                                    </tr>
                                     <tr class="table-success">
                                        <td>Earned Leave</td>
                                        <td id="earned_pending"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Official Duty</td>
                                        <td id="official_duty_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Loss Of Pay Used</td>
                                        <td id="loss_of_pay_used"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- <hr class="mt-1 mb-1"> -->

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h6 class="mb-1 text-center">Work Assign during absence time.</h6>
                            <hr class="mt-0 mb-0" />
                            <table id="staffAssignTable" class="table table-bordered">
                                <thead>
                                    <tr class="text-center text-white bg-primary ">
                                        <th>Date</th>
                                        <th>Period</th>
                                        <th>Class</th>
                                        <th>Stream</th>
                                        <th>Section</th>
                                        <th>Staff ID</th>
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div id="medicalCertificate"></div>
                    </div>

                    <hr class="mt-1 mb-1">
                    <!-- Modal footer -->
                    <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $staffID == '123456' || $leave_approved_status == '1'){ ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <span id="approveButton"></span>
                            <span id="rejectButton"></span>

                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- The leave view Modal -->
<div class="modal" id="downloadStaffLeaveReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Download Leave Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="text" class="dateFrom form-control" name="fromDate" id="fromDate_report"
                                        value="" placeholder="Date From" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="text" class="dateTo form-control" name="toDate" id="toDate_report"
                                        value="" placeholder="Date To" required autocomplete="off">
                                </div>
                            </div>
                       
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                <label for="leave_type_report">Leave Type</label>
                                <select id="leave_type_report" name="leave_type_report" class="form-control"
                                    id="exampleFormControlSelect1" required>
                                    <option value="ALL">ALL</option>
                                     <option value="CL">Casual Leave(CL)</option>
                                     <option value="ML">Medical Leave(ML)</option>
                                     <option value="MARL">Marriage Leave(ML)</option>
                                     <option value="PL">Paternity Leave(PL)</option>
                                     <option value="MATL">Maternity Leave(ML)</option>
                                      <option value="EL">Earned Leave(EL)</option>
                                     <option value='LOP'>Loss Of Pay(LOP)</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="applied_staff_id_report"
                                    name="applied_staff_id_report" data-live-search="true" required>
                                    <option value="ALL">ALL</option>
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
                        </div>
                        <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                <label for="leave_status_report">Leave Status</label>
                                <select id="leave_status_report" name="leave_status_report" class="form-control"
                                    id="exampleFormControlSelect1" required>
                                    <option value="ALL">ALL</option>
                                    <option value="PENDING">PENDING</option>
                                     <option value="APPROVED">APPROVED</option>
                                     <option value="REJECTED">REJECTED</option>
                                   
                                </select>
                                </div>
                            </div>
                        </div>
                       
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div id="loader"></div>
                                <button type="button" class="btn pull-right btn-primary text-white"
                                    onclick="downloadLeaveReport()" name="add">Download</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                   
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/leave.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#leave-list thead tr').clone(true).appendTo('#leave-list thead');
    $('#leave-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        var newClassupdate = '';
        if (title == 'Date From') {
            var newClassupdate = 'datepicker_from';
        }
        if (title == 'Date To') {
            var newClassupdate = 'datepicker_to';
        }
        if (title == 'Status') {
            $(this).html(`<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" >
            <input placeholder="Total Number of Leave" class=" form-control"
           type="text" list="leaves" required />
            <datalist id="leaves">
                <option>Approved</option>
                <option>Pending</option>
                <option>Rejected</option>
              
            </datalist>
            </div>`);
        } else {
            $(this).html(
                '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm ' +
                newClassupdate + '" placeholder="Search ' +
                title + '" /> </div>');
        }
        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });


    var table = $('#leave-list').DataTable({
        columnDefs: [

            // { className: "my_class", targets: "_all" },
            // {
            //     className: "text-left",
            //     targets: 1,

            // }
        ],
        lengthMenu: [
            [200, 150, 100, 50, 20, 10],
            [200, 150, 100, 50, 20, 10]
        ],
        // pageLength: 200,
        "order": [[ 6, "desc" ]],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Leave",
            "infoFiltered": "(filtered from _MAX_ total staff Leave)",
            "search": "",
            searchPlaceholder: "Search Leave",
            "lengthMenu": "Show _MENU_ Leave",
            "infoEmpty": "Showing 0 to 0 of 0 Leave",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_applied_leave_info ',
            type: 'POST',

            // dataType: 'json',
        },

    });

    jQuery('.datepicker, .datepicker_from, .datepicker_to, #dateAssigned, #fromDate, #toDate, #toDate_report, #fromDate_report').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        startDate : "01-01-2021"
        
    });


});
</script>
<script type="text/javascript">

// $('.casual_pending').hide();
// $('.medical_pending').hide();
//$('.marriage_pending').hide();
// $('.earned_pending').hide();

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
            }
             else if (data.leaveInfo.leave_type == 'MARL') {
                leave_type = "MARRIAGE LEAVE";
            } else if (data.leaveInfo.leave_type == 'PL') {
                leave_type = "PATERNITY LEAVE";
            } else if (data.leaveInfo.leave_type == 'MATL') {
                leave_type = "MATERNITY LEAVE";
            }
             else if (data.leaveInfo.leave_type == 'ML') {
                leave_type = "MEDICAL LEAVE";
             } 
             else if (data.leaveInfo.leave_type == 'EL') {
                leave_type = "EARNED LEAVE";
            }
            $("#staff_name_view").html(data.leaveInfo.name);
            $("#date_from_view").html(formatted_date_from_date);
            $("#date_to_view").html(formatted_date_to_date);
            $("#total_day_view").html(data.leaveInfo.total_days_leave);
            $("#leave_type_view").html(leave_type);
            $("#reason_view").html(data.leaveInfo.leave_reason);
           
          

              
            $("#casual_pending").html(data.leavePending.casual_leave_earned - data.used_leave_cl.total_days_leave);

            $("#medical_pending").html(data.leavePending.sick_leave_earned - data.used_leave_ml.total_days_leave);

            $("#marriage_pending").html(data.leavePending.marriage_leave_earned - data.used_leave_marl.total_days_leave);

            $("#paternity_pending").html(data.leavePending.paternity_leave_earned - data.used_leave_pl.total_days_leave);

            $("#maternity_pending").html(data.leavePending.maternity_leave_earned - data.used_leave_matl.total_days_leave);

            $("#earned_pending").html(data.leavePending.earned_leave - data.used_leave_el.total_days_leave);
            $("#official_duty_pending").html(data.leavePending.official_duty_earned - data.used_leave_od.total_days_leave);



            $("#loss_of_pay_used").html(data.used_leave_lop.total_days_leave);
               
                // if(data.leavePending.lop_leave != '' && data.leavePending.lop_leave != 0){
                //     $('.loss_of_pay_used').show();
                // $("#loss_of_pay_used").html(data.leavePending.lop_leave - data.leavePending
                //     .lop_leave_used);
                // }

                // $("#loss_of_pay_used").html(data.leavePending.lop_leave);
        
            $("#approved_by").html(data.leaveInfo.approved_by);
            $("#rejected_by").html(data.leaveInfo.rejected_by); 
            
            if (data.leaveInfo.leave_type == 'ML') {
                $("#medicalCertificate").html(`<img src=`+ data.leaveInfo.medical_certificate +` width="400">`);
            }else{
                $("#medicalCertificate").hide();
            }

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
                    "<td class='text-center' colspan='5'> Work assign not found! </td>" +
                    "</tr>"
                );
            }
            var approveButton = "";
            var rejectButton = "";
            if (data.leaveInfo.approved_status != 1) {
                approveButton = `<button type="button" class="btn pull-right btn-success text-white" id="approveStaffLeave" name="add"
            data-row_id="` + row_id + `">Approve</button>`;
            } else {
                approveButton = "<b class='pull-right' style='color:green;'>Approved</b>";
            }

            rejectButton = `<button type="button" class="btn pull-left btn-danger text-white" id="rejectStaffLeave" name="add"
            data-row_id="` + row_id + `">Reject</button>`;



            $("#approveButton").html(approveButton);
            $("#rejectButton").html(rejectButton);
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


function downloadLeaveReport() {
    var from_date = $('#fromDate_report').val();
    var to_date = $('#toDate_report').val();
    var leave_type = $('#leave_type_report').val();
    var applied_staff_id = $('#applied_staff_id_report').val();
    var leave_status = $('#leave_status_report').val();
    if (from_date == "") {
        alert("Please enter From Date!");
    } else if (to_date == "") {
        alert("Please enter To Date!");
    } else {
        $.ajax({
            url: '<?php echo base_url(); ?>/downloadStaffLeaveReport',
            type: 'POST',
            dataType: 'json',
            data: {
                from_date: from_date,
                to_date: to_date,
                leave_type: leave_type,
                applied_staff_id: applied_staff_id,
                leave_status: leave_status
            },

            success: function(data) {
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", leave_type+"_Leave_Report_" + from_date + "_to_" + to_date +
                "_Report_file.xls");
                $a[0].click();
                $a.remove();
            },
            error: function(result) {
                alert("Search Error!!  Failed");
            },
            fail: (function(status) {
                alert("Server Error!!  Failed");
            }),
            beforeSend: function(d) {
                // $("#loader").html(loader);
            }
        });
    }
}
function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
</script>