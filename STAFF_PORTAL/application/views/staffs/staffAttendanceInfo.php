<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}

.form-control {
    border: 1px solid #0e0e0e5c !important
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

<div class="main-content-container px-3 pt-1">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row p-0 ">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2 ">
                        <div class="row c-m-b">
                            <div class="col-lg-3 col-sm-12 col-12">
                                <span class="page-title">
                                    <i class="fa fa-user"></i> Staff Attendance
                                </span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12 box-tools">
                                <form method="POST" action="<?php echo base_url(); ?>getStaffAttendanceInfo">
                                    <div class="input-group search-box">
                                        <input type="text" name="dateSearch" id="dateSearch"
                                            value="<?php echo $searchDate; ?>"
                                            class="form-control input-lg pull-right dateSearch"
                                            placeholder="Search By Date" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-md btn-primary searchList"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-5 col-sm-12 col-12 box-tools">
                                <button class="btn btn-danger mobile-btn pull-right" data-toggle="modal"
                                    data-target="#addNewStaffAttendance"><i class="fa fa-plus"></i>
                                    Add New</button>

                                <button class="btn btn-primary mobile-btn pull-right" data-toggle="modal"
                                    data-target="#leaveInfoModel"><i class="fa fa-eye"></i>
                                    Analysis</button>

                                <button class="btn btn-success mobile-btn pull-left" data-toggle="modal"
                                    data-target="#staffAttendanceDownlaod"><i class="fa fa-download"></i>
                                    Download</button>


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
                        <table id="item-list" style="width:100%"
                            class="display table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="200">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>In-Time</th>
                                    <th>Out-Time</th>
                                    <!-- <th>Shift</th> -->
                                    <?php if($role == ROLE_ADMIN || $this->staff_id == '123456') {?>
                                    <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="200">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>In-Time</th>
                                    <th>Out-Time</th>
                                    <!-- <th>Shift</th> -->
                                    <?php if($role == ROLE_ADMIN || $this->staff_id == '123456') {?>
                                    <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </tfoot>
                        </table>
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
                        <h4 class="modal-title">Analysis</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" style="padding:0px;">
                        <div class="card-body contents-body">
                            <div class="row">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Total Late Teaching Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['late_count_teaching_staff']; ?></th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Total Late Non-Teaching Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['late_count_non_teaching_staff']; ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Total Late Support Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['late_count_support_staff']; ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Total Absent Teaching Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['absent_count_teaching_staff']; ?></th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Total Absent Non-Teaching Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['absent_count_non_teaching_staff']; ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Total Absent Support Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['absent_count_support_staff']; ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Without Punch-Out Teaching Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['no_punch_count_teaching_staff']; ?></th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Without Punch-Out Non-Teaching Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['no_punch_count_non_teaching_staff']; ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Without Punch-Out Support Staff</th>
                                        <th id="total_late_year" scope="col ">
                                            <?php echo $analysis_count['no_punch_count_support_staff']; ?></th>
                                    </tr>
                                </thead>

                            </table>

                            </div>


                            <hr class="mt-1 mb-1">
                            <!-- Modal footer -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- The leave view Modal -->
        <div class="modal" id="staffAttendanceDownlaod">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h4 class="modal-title">Staff Attendance Info Download</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" style="padding:0px;">
                        <div class="card-body contents-body">
                            <form id="downloadReportForm" data-download_form="true">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date From</label>
                                            <input type="text" class="dateFrom form-control" name="fromDate"
                                                id="fromDate" placeholder="Date From" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date To</label>
                                            <input type="text" class="dateTo form-control" name="toDate" id="toDate"
                                                placeholder="Date To" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label for="team_id">Department Sort</label>
                                            <select required name="department" id="department_sort"
                                                class="form-control required selectpicker" data-live-search="true">
                                                <option value="ALL">ALL</option>
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
                                                } }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label for="team_id">Report Type</label>
                                            <select required id="report_type" name="report_type"
                                                class="form-control required ">
                                                <option value="latecomer">Latecomer</option>
                                                <option value="absent_staff">Only Absented Staffs </option>
                                                <option value="no_punch_out">Without Punching Out </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div id="loader"></div>
                                        <button type="submit" class="btn pull-right btn-primary text-white"
                                            id="downloadReportButton" name="add">Download</button>
                                        <button type="button" class="btn btn-danger pull-left"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Modal footer -->

                        </div>
                    </div>
                </div>
            </div>
        </div>








        <!-- The add new staff attendnce Modal -->
        <div class="modal" id="addNewStaffAttendance">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h4 class="modal-title">Add New Staff Attendance</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" style="padding:0px;">
                        <div class="card-body contents-body">
                            <form method="POST" id="addNewStaff" action="<?php echo base_url() ?>addNewStaffAttendance">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="staffInfo">Select Staff</label>
                                            <select class="form-control input-sm selectpicker" id="applied_staff_id"
                                                name="attendance_staff_id" data-live-search="true" required>
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
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Attendance Date</label>
                                            <input type="text" class="addNewDate form-control" name="new_date" value="<?php echo date('d-m-Y')?>"
                                                id="addNewDate" placeholder="Select Date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="exampleInputEmail1">Check-In Time(Eg: HH:MM:SS)</label>
                                        <div class="input-group">
                                            <input min="1" max="24" type="number" class="form-control"
                                                name="check_in_hh" id="check_out" placeholder="HH" required>
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_in_mm" id="check_out" placeholder="MM" required>
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_in_ss" id="check_out" placeholder="SS" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="exampleInputEmail1">Check-Out Time(Eg: HH:MM:SS)</label>
                                        <div class="input-group">
                                            <input min="1" max="24" type="number" class="form-control"
                                                name="check_out_hh" id="check_out" placeholder="HH" >
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_out_mm" id="check_out" placeholder="MM" >
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_out_ss" id="check_out" placeholder="SS" >
                                        </div>
                                    </div>
                                </div>


                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div id="loader"></div>
                                        <button type="submit" class="btn pull-right btn-primary text-white" onclick="showLoader();"
                                            id="downloadReportButton" name="add">Add</button>
                                        <button type="button" class="btn btn-danger pull-left"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Modal footer -->

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- The add new staff attendnce Modal -->
        <div class="modal" id="editStaffAttendanceModel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header ">
                        <h4 class="modal-title">Edit Staff Attendance</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" style="padding:0px;">
                        <div class="card-body contents-body">
                            <form method="POST" id="addNewStaff" action="<?php echo base_url() ?>updateStaffAttendance">
                                <input type="hidden" value="" id="editStaffId" name="staff_id" required />
                                <input type="hidden" value="" id="editPunchDate" name="punch_date" required />
                                <input type="hidden" id="staff_attendance_row_id" name="staff_attendance_row_id" />
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Punch Date</th>
                                                    <th id="punch_date_edit_view">--</th>
                                                </tr>

                                                <tr>
                                                    <th>Staff Name</th>
                                                    <th id="staff_name_edit_view">--</th>
                                                </tr>
                                                <tr>
                                                    <th>Role</th>
                                                    <th id="staff_role_edit_view">--</th>
                                                </tr>
                                                <!-- <tr>
                                                    <th>Shift Name</th>
                                                    <th id="staff_shift_edit_view">--</th>
                                                </tr> -->
                                                <tr>
                                                    <th>Check-In</th>
                                                    <th id="staff_check_in_edit_view">--</th>
                                                </tr>
                                                <tr>
                                                    <th>Check-Out</th>
                                                    <th id="staff_check_out_edit_view">--</th>
                                                </tr>

                                            </thead>

                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="exampleInputEmail1">New Check-In Time(Eg: HH:MM:SS)</label>
                                        <div class="input-group">
                                            <input min="1" max="24" type="number" class="form-control"
                                                name="check_in_hh" id="check_out" placeholder="HH" >
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_in_mm" id="check_out" placeholder="MM" >
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_in_ss" id="check_out" placeholder="SS" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="exampleInputEmail1">New Check-Out Time(Eg: HH:MM:SS)</label>
                                        <div class="input-group">
                                            <input min="1" max="24" type="number" class="form-control"
                                                name="check_out_hh" id="check_out" placeholder="HH" >
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_out_mm" id="check_out" placeholder="MM" >
                                            <input min="0" max="60" type="number" class="form-control"
                                                name="check_out_ss" id="check_out" placeholder="SS" >
                                        </div>
                                    </div>
                                </div>


                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div id="loader"></div>
                                        <button type="submit" class="btn pull-right btn-primary text-white" onclick="showLoader();"
                                            id="downloadReportButton" name="add">Add</button>
                                        <button type="button" class="btn btn-danger pull-left"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Modal footer -->

                        </div>
                    </div>
                </div>
            </div>
        </div>






        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/attendance.js" charset="utf-8"></script>
        <script type="text/javascript">
        var loader = '<img height="50" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

        function openModal(customer_name, customer_id) {
            $("#Modal").modal('show');
            $("#Modal .modal-title").html(customer_name);
            document.getElementById("customer_id").value = customer_id;
        }

        jQuery(document).ready(function() {

            $('#item-list thead tr').clone(true).appendTo('#item-list thead');
            $('#item-list thead tr:eq(1) th').each(function(i) {
                var title = $(this).text();
                if (title == 'Date') {
                    var newClassupdate = 'disabled';
                } else {
                    var newClassupdate = '';
                }
                $(this).html(
                    '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
                    title + '" ' +
                    newClassupdate + ' /> </div>');

                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });


            var table = $('#item-list').DataTable({
                columnDefs: [
                    // { className: "my_class", targets: "_all" },
                    {
                        className: "text-left",
                        targets: 2
                    }
                ],
                lengthMenu: [
                    [200, 150, 100, 50, 20, 10],
                    [200, 150, 100, 50, 20, 10]
                ],
                processing: true,
                orderCellsTop: true,
                fixedHeader: true,
                language: {
                    "info": "Showing _START_ to _END_ of _TOTAL_ Attendance",
                    "infoFiltered": "(filtered from _MAX_ total attendance)",
                    "search": "",
                    searchPlaceholder: "Search Attendance",
                    "lengthMenu": "Show _MENU_ Attendance",
                    "infoEmpty": "Showing 0 to 0 of 0 Attendance",
                    //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
                },

                "ajax": {
                    url: '<?php echo base_url(); ?>/get_attendance ',
                    type: 'POST',
                    data: {
                        date: $("#dateSearch").val()
                    }
                    // dataType: 'json',
                },

            });

            jQuery('.datepicker, .dateSearch, .dateFrom, .dateTo, .addNewDate').datepicker({
                autoclose: true,
                orientation: "bottom",
                format: "dd-mm-yyyy"

            });



            var $downloadReportForm = $('#downloadReportForm');

            $downloadReportForm.on('submit', function(ev) {
                ev.preventDefault();

                $.ajax({
                    url: '<?php echo base_url(); ?>/downloadStaffAttendanceReport',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        date_from: $("#fromDate").val(),
                        date_to: $("#toDate").val(),
                        department: $("#department_sort").val(),
                        report_type: $("#report_type").val(),
                    },
                    success: function(data) {
                        $('#loader').html("");
                        $("#downloadReportButton").prop('disabled', false);
                        var $a = $("<a>");
                        $a.attr("href", data.file);
                        $("body").append($a);
                        $a.attr("download", $('#department_sort :selected').text() +
                            "_STAFF_LIST_2019.xls");
                        $a[0].click();
                        $a.remove();
                    },
                    error: function(result) {
                        $("#downloadReportButton").prop('disabled', false);
                        alert("Server Error!!  Failed");
                    },
                    fail: (function(status) {
                        $("#downloadReportButton").prop('disabled', false);
                        alert("Server Error!!  Failed");
                    }),
                    beforeSend: function(d) {
                        $('#loader').html(loader);
                        $("#downloadReportButton").prop('disabled', true);
                    }
                });
            });

        });

        function editStaffAttendance(staff_id) {
           var punch_date = $("#dateSearch").val();
           $('#editStaffId').val(staff_id);
           $('#editPunchDate').val(punch_date);
            $.ajax({
                url: '<?php echo base_url(); ?>/getStaffAttendanceInfoByDate_Staff_Id',
                type: 'POST',
                dataType: 'json',
                data: {
                    staff_id: staff_id,
                    date: punch_date,
                },
                success: function(data) {
                    $('#punch_date_edit_view').html(punch_date);
                    $('#staff_name_edit_view').html(data.name);
                    $('#staff_role_edit_view').html(data.role);
                    $('#staff_shift_edit_view').html(data.shift_name);
                    $('#staff_check_in_edit_view').html(data.in_time);
                    $('#staff_check_out_edit_view').html(data.out_time);
                    $('#staff_attendance_row_id').val(data.row_id);
                    $('#editStaffAttendanceModel').modal('show');
                },
                error: function(result) {

                    alert("Server Error!!  Failed");
                },
                fail: (function(status) {

                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    $('#loader').html(loader);
                }
            });
        }
        </script>