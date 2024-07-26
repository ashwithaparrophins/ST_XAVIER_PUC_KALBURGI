<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
</style>
<?php
    $this->load->helper('form');
    ?>

<div class="main-content-container px-3">
    <!-- Page Header -->
    <div class="row mt-1 mb-1 ">
        <div class="col padding_left_right_null">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="material-icons">description</i> Report
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row ">
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadAdmissionEnquiryReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Admission Enquiry</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php if($role != EXAM_COMMITTEE){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeeStructure" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Paid Consolidated</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <div class="col-12 mb-1">
                <div class="card p-2 main_card">
                    <h6 class="font-weight-bold mb-2">College Fee Report</h6>
                </div>
            </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadDayWiseFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Day-wise Fee Paid Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Paid Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeeDueReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Due Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#bulkFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Bulk Fee Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMiscellaneousFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Miscellaneous Fee Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadArrearFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Arrear Fee Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadRejectedAppFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Rejected Application Fee Paid Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#cancelReceiptReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Cancel Receipt Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 mb-1">
                <div class="card p-2 main_card">
                    <h6 class="font-weight-bold mb-2">Transport Fee Report</h6>
                </div>
            </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#transportFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Transport Fee Paid Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#transportFeeDueReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Overall Transport Fee Due Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#transportOnlyFeeDue" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Transport Fee Due Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#transportBulkFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Transport Bulk Fee Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#arrearTransportFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Arrear Transport Fee Paid Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
       
        
       
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#assignmentConsolidatedMarkReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Exam Mark Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <div class="col-12 mb-1">
            <div class="card p-2 main_card">
                <h6 class="font-weight-bold mb-2">Academic Report</h6>
            </div>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadStaffReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Staff</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#andlyticReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Subjectwise Analytics Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#smsReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">SMS Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadStaffLeaveReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Leave Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadStaffLeavePendingReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Leave Balance Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadStaffAttendanceMonthlyReportPdf" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Staff Monthly Attendance - PDF </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <?php }
         if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#applicationApprovedReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Approved Application</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMerit" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Merit List</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
       
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#applicationRejectedReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Rejected Application</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php } ?>

        <?php if($role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadShortlistedMerit" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: green;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Shortlisted Application</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php } ?>

        <?php if($role != EXAM_COMMITTEE){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#admissionRegisteredStudent" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Admitted Students</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
    
         <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMunExternalReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">MUN External</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
         <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a class="more-info text-white dashboard_link" href="<?php echo base_url() ?>downloadMunInternalReport">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">MUN INTERNAL</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
        </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeeStructure2020" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">2020 Fee Paid</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a class="more-info text-white dashboard_link" href="<?php echo base_url() ?>downloadCourseRegistrationReport">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">COURSE REGISTRATION</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
        </a>
        </div> -->
        <?php } ?>
        <?php if($role == EXAM_COMMITTEE){ ?>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadIPuReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Annual IPU Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
  </div>
</div>


<!-- Admission Enquiry export modal -->
<div class="modal fade" id="downloadAdmissionEnquiryReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Admission Enquiry</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadAdmissionEnquiryForm" action="<?php echo base_url() ?>downloadAdmissionEnquiryExcelReport" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mt-1">
                           
                                <select class="form-control input-sm" id="term_name" name="term_name" required>
                                <option value="">Select Term</option>
                                <option value="PU1">PU1</option>
                                <option value="PU2">PU2</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="downloadStaffAttendanceMonthlyReportPdf">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Staff Attendance Monthly Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                
                    <form id="" method="POST" data-download_form="true" action="<?php echo base_url(); ?>downloadStaffAttendanceMonthlyReportPdf" target="_blank">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="date" class=" form-control" name="date_from" 
                                        placeholder="Date From" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="date" class="form-control" name="date_to" 
                                        placeholder="Date To" required autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="staffIdd"
                                        name="by_staff_id_report" data-live-search="true">
                                        <option value="ALL">ALL</option>
                                        <?php if(!empty($currentStaffInfo)) {
                                            foreach ($currentStaffInfo as $rl) {  ?>
                                        <option value="<?php echo $rl->staff_id ?>">
                                            <?php echo $rl->name ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row Department_Select">
                            <div class="col-lg-12">
                                <div class="form-group ">
                                    <label for="team_id">Department Sort</label>
                                    <select required name="department" id="departmentStaffId"
                                        class="form-control required selectpicker" data-live-search="true">
                                        <option value="">Select One Dept.</option>
                                        <option value="ALL">ALL</option>
                                        <?php if(!empty($departments)) {
                                                foreach ($departments as $rl) { ?>
                                                <option value="<?php echo $rl->dept_id ?>"
                                            <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>>
                                            <?php echo $rl->name; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                            <button type="submit" class="btn pull-right btn-primary text-white" id="downloadMonthlyReportStaff">Download</button>
                            <button type="button" class="btn btn-danger pull-left"  data-dismiss="modal">Close</button>
                            </div>
                        </div>
                                    </form>
                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadFeeStructure">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeStructureForm" method="POST" action="<?php echo base_url().'download_fee_structure_excel'?>">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="year" required>
                                <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                 
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- fee structure -->
<div class="modal" id="downloadFeeStructure2020">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeStructureForm" method="POST" action="<?php echo base_url().'download_fee_structure_excel_2020'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadDayWiseFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Day-wise Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadDayWiseFeeReport" method="POST" action="<?php echo base_url().'downloadDayWiseFeeReport'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from_fee" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to_fee" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" required>
                            </div>
                        </div>


                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                                
                                <option value="">Select One Preference</option>
                                <option value="ALL">ALL</option> 
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <!-- <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option> -->
                                <option value="EBAC">EBAC</option>
                                <option value="HEPE">HEPE</option>
                                <option value="HEPS">HEPS</option>
                                <!-- <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                 -->
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="downloadRejectedAppFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Rejected Application Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadRejectedAppFeeReport" method="POST" action="<?php echo base_url().'downloadRejectedAppFeeReport'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row mt-2">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from_fee" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to_fee" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" required>
                            </div>
                        </div>


                    </div> -->
                        <!-- <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                                
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                
                                <option value="EBAC">EBAC</option>
                                <option value="HEPE">HEPE</option>
                                <option value="HEPS">HEPS</option>
                                
                            </select>
                        </div>
                    </div> -->
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="downloadFeeDueReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Due Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeDueReport" method="POST" action="<?php echo base_url().'downloadFeeDueReport'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select"  required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
               
                        <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                              
                                <option value="">Select One Preference</option>
                                <option value="ALL">ALL</option> 
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <!-- <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option> -->
                                <option value="EBAC">EBAC</option>
                                <option value="HEPE">HEPE</option>
                                <option value="HEPS">HEPS</option>
                                <!-- <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Year</label>
                            <select class="form-control input-md required" name="year">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="downloadFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeDueReport" method="POST" action="<?php echo base_url().'downloadFeePaidReport'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select"  required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
               
                        <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                              
                                <option value="">Select One Preference</option>
                                <option value="ALL">ALL</option> 
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <!-- <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option> -->
                                <option value="EBAC">EBAC</option>
                                <option value="HEPE">HEPE</option>
                                <option value="HEPS">HEPS</option>
                                <!-- <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Year</label>
                            <select class="form-control input-md required" name="year">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="cancelReceiptReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cancel Receipt Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">

                <!-- <form role="form" id="getCancelReceipt" action="<?php echo base_url() ?>getCancelReceiptReport"
                    method="post" role="form"> -->
                    <form action="<?php echo base_url() ?>getCancelReceiptReport" method="POST" data-download_form="true">

                   
                    <div class="row">
                        <div class="col-6">
                                <label>Payment Year</label>
                                <select class="form-control input-md"  name="year" >
                                    <!-- <option value="">ALL</option> -->
                                    <option value="2024"><?php echo 2024; ?></option>
                                   
                            </select>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button id="downloadReportCancelReceiptExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <!-- <input type="submit" form="getCancelReceipt" class="btn btn-success float-right" value="Download" /> -->
            </div>
            </form>
        </div>
    </div>
</div>
<!-- transport fee paid report -->
<div class="modal" id="transportFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportFeeInfoReport">

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="inputEmail4">Month</label>
                            <select class="form-control text-dark" id="month"
                                name="month">
                                <option value="">Select Month</option>
                                <option value="ALL">All</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Year</label>
                            <select class="form-control input-md required" name="year">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="arrearTransportFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Arrear Transport Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadArrearTransportFeeInfoReport">

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>

                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- The leave report Modal -->
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
                <form action="<?php echo base_url() ?>downloadStaffLeaveReport" method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="text" class="form-control datepicker" name="from_date" id=""
                                        value="" placeholder="Date From" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="text" class="form-control datepicker" name="to_date" id=""
                                        value="" placeholder="Date To" required autocomplete="off">
                                </div>
                            </div>
                       
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                <label for="leave_type_report">Leave Type</label>
                                <select id="" name="leave_type" class="form-control"
                                    id="exampleFormControlSelect1" required>
                                    <option value="ALL">ALL</option>
                                     <option value="CL">Casual Leave(CL)</option>
                                     <option value="ML">Medical Leave(ML)</option>
                                     <option value="PL">Paternity Leave(PL)</option>
                                     <option value="MARL">Marriage Leave(MARL)</option>
                                     <option value="MATL">Maternity Leave(MATL)</option>
                                     <option value="LOP">Loss of Pay(LOP)</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="" multiple
                                    name="applied_staff_id[]" data-live-search="true" required>
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
                                <select id="" name="leave_status" class="form-control"
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
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                     name="add">Download</button>
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



<div class="modal" id="downloadStaffLeavePendingReport">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Download Pending Leave Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form data-download_form="true" action="<?php echo base_url() ?>downloadStaffLeavePendingReport" method="POST">
                        <div class="row"> 
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="applied_staff_id_report" multiple
                                    name="applied_staff_id[]" data-live-search="true" required>
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
                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                <label for="leave_type">Year</label>
                                <select id="year" name="year" class="form-control"
                                    id="exampleFormControlSelect1">
                                    <option value="2022-23">2022-23</option>
                                     <option value="2021-22">2021-22</option>
                                     <option value="2020-21">2020-21</option>
                                     <option value="2019-20">2019-20</option>
                                </select>
                                </div>
                            </div> -->
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="modal-footer row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <!-- <div id="loader"></div> -->
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    name="Download">Download</button>
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


<div class="modal" id="downloadArrearFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Arrear Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadArrearFeeInfoReport">

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>

                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="transportFeeDueReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Fee Due Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportDueInfoReport">

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name_select" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="inputEmail4">Bus No.</label>
                            <select class="form-control text-dark"  name="bus_no" >
                                <option value="">Select Bus No.</option>
                                <?php if (!empty($busNoInfo)) {
                                    foreach ($busNoInfo as $busno) { ?>
                                        <option value="<?php echo $busno->name; ?>"><?php echo $busno->name ?></option>
                                <?php }
                                } ?>
                            </select>
                            
                        </div>

                       
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="year" required>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>                 
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="transportOnlyFeeDue">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Fee Due Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportOnlyDueInfoReport">

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name_select" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="inputEmail4">Bus No.</label>
                            <select class="form-control text-dark"  name="bus_no" >
                                <option value="">Select Bus No.</option>
                                <?php if (!empty($busNoInfo)) {
                                    foreach ($busNoInfo as $busno) { ?>
                                        <option value="<?php echo $busno->name; ?>"><?php echo $busno->name ?></option>
                                <?php }
                                } ?>
                            </select>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="year" required>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>                 
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="bulkFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Bulk Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadBulkFeeReport">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from_bulk" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to_bulk" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>

                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="bulkFeeReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadMiscellaneousFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Miscellaneous Fee Paid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>downloadMiscellaneousFeePaidReport"  data-download_form="true" method="POST">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label for="role">Date From</label>
                            <input type="text" name="date_from" id="date_from_mis" class="form-control datepicker" style="text-transform: uppercase" placeholder="Date From" autocomplete="off" />
                        </div>
                        <div class="col-6 mb-2">
                            <label for="role">Date To</label>
                            <input type="text" name="date_to" id="date_to_mis" class="form-control datepicker" style="text-transform: uppercase" placeholder="Date To" autocomplete="off" />
                        </div>
                        <div class="col-6 mb-2">
                            <label>Miscellaneous type</label>
                            <select class="form-control text-dark selectpicker" id="miscellaneous_type" name="miscellaneous_type[]" multiple>
                                <option value="ALL">All</option>
                                <?php if (!empty($miscellaneousTypeInfo)) {
                                    foreach ($miscellaneousTypeInfo as $type) { ?>
                                        <option value="<?php echo $type->row_id ?>"><?php echo $type->miscellaneous_type ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label>Payment type</label>
                            <select class="form-control selectpicker text-dark" id="payment_type" name="payment_type[]" multiple>
                                <option value="ALL">All</option>
                                <option value="CASH">CASH</option>
                                <!-- <option value="DD">DD</option> -->
                                <option value="NEFT">NEFT</option>
                                <option value="UPI">UPI</option>
                               
                            </select>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <div class="col-4">
                    <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                        <option value="VIEW">VIEW</option>
                        <option value="DOWNLOAD">DOWNLOAD</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" id="transportBulkFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Bulk Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportBulkFeeReport">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from_transport" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to_transport" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>

                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="transportBulkFeeReceipt"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- The Modal for bank settlement-->
<div class="modal" id="applicationStackReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="addBankSettlementSubmit" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                    </div>
                    <input type="hidden" value="APPLICATION_STACK" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                            </select>
                        </div>
                    </div>
                   

                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Elective Language</label>
                            <select class="form-control input-md required" id="" name="elective_sub">
                                <option value="">ALL</option>
                                <option value="KANNADA">KANNADA</option>
                                <option value="HINDI">HINDI</option>
                                <option value="FRENCH">FRENCH</option>
                            </select>
                        </div>
                    </div>
 
 
 
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="addBankSettlementSubmit"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- The Modal for  applicationApprovedReport-->
<div class="modal" id="applicationApprovedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Approved Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="applicationApprovedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                        <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                    </div>
                    <input type="hidden" value="APPLICATION_APPROVED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                               
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                                <option value="">ALL</option>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="applicationRejectedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Rejected Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="applicationRejectedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                        <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                    </div>
                    <input type="hidden" value="APPLICATION_REJECTED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Elective Language</label>
                            <select class="form-control input-md required" id="" name="elective_sub">
                                <option value="">ALL</option>
                                <option value="KANNADA">KANNADA</option>
                                <option value="HINDI">HINDI</option>
                                <option value="FRENCH">FRENCH</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Admission Enquiry export modal -->
<div class="modal fade" id="admissionApplicationFeePayment">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Application Fee Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadAdmissionEnquiryForm" action="<?php echo base_url() ?>downloadApplicationFee" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mt-1">
                           
                                <select class="form-control input-sm" id="paid_status" name="paid_status" required>
                                <option value="PAID">PAID</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="admissionRegisteredStudent">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">ADMITTED Student Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="admissionRegisteredStudent" action="<?php echo base_url(); ?>downloadAdmittedStudentInfo">
                    <!-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                    </div> -->
                    <input type="hidden" value="ADMISSION_COMPLETED" name="report_type" />
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                            </select>
                        </div>
                    </div> -->
                    <div class = "row">
                    <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name" required>
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- donload fee Structure report filter modal -->
<div class="modal" id="dayWiseStructureFeePayment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Detailed Fee Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">

                <form role="form" data-download_form="true" id="downloadReportStructure" action="<?php echo base_url() ?>dayWiseStructureFeePayment"
                    method="post" role="form">

                    <div class="row form-contents">
                        <!-- <div class="col-4">
                            <div class="form-group mb-0">
                                <label for="term_name_select">Term Name</label>
                                <select class="form-control" name="term_name" id="term_name_select" required>
                                     <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option> 
                                    <option value="II PUC" selected>II PUC</option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">By Student</label>
                                <select class="form-control selectpicker" name="by_student" id="by_student"
                                    data-live-search="true" required>
                                    <option value="ALL" selected>ALL</option>
                                    <?php if(!empty($feePaidStdInfo)){ 
                                    foreach($feePaidStdInfo as $std){ ?>
                                    <option value="<?php echo $std->application_no; ?>">
                                        <?php echo $std->student_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div> -->

                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">By Bank Account</label>
                                <select class="form-control selectpicker" name="bank_account" id="bank_account"
                                    data-live-search="true" required>
                                    <option value="">Select Fee Account Type</option>
                                 
                                    <?php if(!empty($bankAccInfo)){ 
                                    foreach($bankAccInfo as $acc){ ?>
                                    <option value="<?php echo $acc->row_id; ?>">
                                        <?php echo $acc->account_no; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Report Type</label>
                                <select class="form-control selectpicker" name="report_type" id="report_type_structure"
                                    data-live-search="true" required>
                                    <option value="">Select Report Type</option>
                                     <option value="BYSTUDENT">By Day Wise</option>
                                    <option value="MONTHWISE">By Year Wise</option>
                                    <option value="DATEWISE">By Date Wise</option>
                                   
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Report Format</label><br/>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="reportFormat" value="PDF" checked>PDF
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="reportFormat" value="EXCEL">EXCEL
                                    </label>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row mt-3">

                    
                        
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Bank Settlement</label>
                                <select class="form-control" name="bank_settlement" id="bank_settlement"
                                    data-live-search="true" required>
                                    <option value="ALL">ALL</option>
                                   
                                    <option value="SETTLED">Only Settled</option> 
                                    <option value="NOT_SETTLED">Not Settled</option> 
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row mt-3 dateSearchShowStructure">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>


                    </div>
                    <!-- <div class="row mt-3 dayWiseDate">

                    <div class="col-6">
                        <div class="form-group">
                            <label for="account_type">Date</label>
                            <input type="text" class="form-control" id="date_day" name="date_day"
                                placeholder="Select Date From" autocomplete="off" >
                        </div>
                    </div>
                    

                    </div> -->
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit"  form="downloadReportStructure" class="btn btn-success float-right" value="Download" />
            </div>

        </div>
    </div>
</div>


<!-- I PUC MARK SHEET -->
<div class="modal" id="IpucMarkSheetSubjectWise">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Exam Mark Sheet - Subject</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true" id="" action="<?php echo base_url(); ?>downloadExamMarkSheet">
                  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Term</label>
                                <select class="form-control input-sm" id="term" name="term_name" required>
                                    <!-- <option value="" >Select Term</option> -->
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name" required>
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                                <!-- <option value="">Select Section</option> -->
                                <option value="">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <!-- <option value="E">E</option>
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
                                <option value="S">S</option> -->
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="role">Subject</label>
                            <select class="form-control input-sm" id="subject" name="subject_code" required>
                                <option value="">By Subject</option>
                                <?php if(!empty($subjectInfo)){
                                    foreach($subjectInfo as $sub){ ?>
                                        <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->sub_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id=subjectWiseAttendanceReport
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Assignment Mark Report - all subject -->
<div class="modal" id="assignmentConsolidatedMarkReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Exam Mark Sheet</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true" id="" action="<?php echo base_url(); ?>downloadAssignmentExamMarkReport">
                  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Term</label>
                                <select class="form-control input-sm" id="term" name="term_name" required>
                                    <option value="" >Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name">
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <!-- <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                                <option value="">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                            </select>
                        </div> -->
                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id=subjectWiseAttendanceReport
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- Assignment Mark Report - all subject -->
<div class="modal" id="andlyticReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Anaytic Reports</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true" id="" action="<?php echo base_url(); ?>getSectionPeformanceAnalyticsPdf">
                  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Term</label>
                                <select class="form-control input-sm" id="term" name="term_name" required>
                                    <option value="" >Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name" required>
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                     <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                                <option value=" ">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <!-- <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option> -->
                            </select>
                        </div> 
                        <div class="col-6">
                                <label for="role">Subject</label>
                                <select class="form-control input-sm" id="subject" name="subject_code" required>
                                    <option value="">By Subject</option>
                                    <?php if(!empty($subjectInfo)){
                                        foreach($subjectInfo as $sub){ ?>
                                            <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->sub_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>

                            <div class="col-6">
                            <select id="" name="exam_type" class="form-control" required>
                                <option value="">Select Exam</option>
                                <option value="I_UNIT_TEST">I UNIT TEST</option>
                                <option value="MID_TERM_EXAM">MID TERM</option>
                                <option value="II_UNIT_TEST">II UNIT TEST</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="modal-footer">
                                <button id="downloadstaffReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                                        class="fa fa-download"></i> Download</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="downloadMerit">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Download Admission Merit List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Select Preference</label>
                            <select class="form-control input-sm" id="preference" name="preference">
                                <?php if($by_first_preference != ""){ ?>
                                <option value="<?php echo $by_first_preference; ?>" selected><b>Sorted:
                                        <?php echo $by_first_preference; ?></b></option>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                                <?php } else  { ?>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                                <?php
                    } ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Filter SSLC Board Name</label>
                            <select class="form-control input-md required" id="by_board_name_download"
                                name="by_board_name_download">
                                <option value="" selected>Filter By SSLC Board Name</option>
                                <option value="">ALL</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <label>By Student Type</label>

                        <select class="form-control input-md required" id="student_type" name="student_type">
                         
                            <option value="">ALL</option>
                            <option value="PH">Physically Challenged</option>
                            <option value="DYC">Dyslexia Challenged</option>
                            <option value="SPORTS">SPORTS Quota</option>
                            <option value="NCC">NCC Quota</option>
                        </select>

                    </div>


                </div>
                <div class="row">
                    <div class="col-12">
                        <label>Percentage Filter</label>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>FROM</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" id="percentage_from_downlaod"
                                type="text" class="form-control" name="percentage_from_downlaod"
                                placeholder="Percentage From(%)">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>TO</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" id="percentage_to_downlaod"
                                type="text" class="form-control" name="percentage_to_downlaod"
                                placeholder="Percentage To(%)">
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button style="float:right;" id="downloadMeritList" type="button" class="btn btn-md btn-primary"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="downloadIPuReport">
    <div class="modal-dialog ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Download Mark List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Select Download Type</label>
                            <select class="form-control required" id="type" name="type">
                                <option value="All" >All Students</option>
                                <option value="Failed" >Only Failed Students</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="streamName" name="streamName">
                                <option value="All">ALL</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <span id="loader"></span>
                <button type="submit" onclick="downloadExcelSheet();" id="downloadAllMarks" class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="downloadShortlistedMerit">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Download Shortlisted List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Select Preference</label>
                            <select class="form-control input-sm" id="stream_name_shortlisted" name="preference">
                                <?php if($by_first_preference != ""){ ?>
                                <option value="<?php echo $by_first_preference; ?>" selected><b>Sorted: <?php echo $by_first_preference; ?></b></option>
                                <option value="ALL" >ALL</option>
                                <option value="PCMB" >PCMB</option>
                                <option value="PCMC" >PCMC</option>
                                <option value="PCME" >PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA" >CEBA</option>
                                <option value="CSBA" >CSBA</option>
                                <option value="MEBA" >MEBA</option>
                                <option value="MSBA" >MSBA</option>
                                <option value="PEBA" >PEBA</option>
                                <option value="SEBA" >SEBA</option>
                                <option value="HEPS" >HEPS</option>
                                <?php } else  { ?>
                                <option value="ALL" >ALL</option>
                                <option value="PCMB" >PCMB</option>
                                <option value="PCMC" >PCMC</option>
                                <option value="PCME" >PCME</option>
                                <option value="CEBA" >CEBA</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CSBA" >CSBA</option>
                                <option value="MEBA" >MEBA</option>
                                <option value="MSBA" >MSBA</option>
                                <option value="PEBA" >PEBA</option>
                                <option value="SEBA" >SEBA</option>
                                <option value="HEPS" >HEPS</option>
                                <?php
                                } ?>
                            
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Filter SSLC Board Name</label>
                            <select class="form-control input-md required" id="by_board_name_shortlisted" name="by_board_name_shortlisted">
                            <option value="" selected>Filter By SSLC Board Name</option>
                            <option value="" >ALL</option>
                            <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch1">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                            <label>By Shortlist Number</label>
                            <select class="form-control input-sm" id="shortlist_number" name="shortlist_number" autocomplete="off">    
                            <option value="">Select</option>
                            <option value="" >ALL</option>
                             <option value="1" >I</option>
                            <option value="2" >II</option>
                             <option value="3" >III</option>
                            <option value="4" >IV</option>
                        </select>
                            </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <label>Percentage Filter</label>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>FROM</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)"  id="percentage_from_downlaod"  type="text" class="form-control" name="percentage_from_downlaod" placeholder="Percentage From(%)">
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>TO</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)"  id="percentage_to_downlaod" type="text" class="form-control" name="percentage_to_downlaod" placeholder="Percentage To(%)">
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="modal-footer">
                <button style="float:right;" id="downloadShortlistedMeritList" type="button" class="btn btn-md btn-primary" ><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- end of the student report modal -->
<div class="modal fade" id="downloadStaffReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header exportModel">
                <h4 class="modal-title">Download Staff Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>downloadStaffExcelReport" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Select Role</label>
                                <select class="form-control input-sm selectpicker" id="staff_role" name="staff_role" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>" <?php if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Select Department</label>
                                <select class="form-control input-sm selectpicker" id="staff_department" name="staff_department" required>
                                      <option value="">Select Department</option>
                                      <option value="ALL">ALL</option>
                                        <?php
                                            if(!empty($departments))
                                            {
                                                foreach ($departments as $rl)
                                                {
                                                    ?>

                                            <option value="<?php echo $rl->dept_id ?>" <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->name; ?></option>
                                            <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h5>Select Required Fields</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" name="fields[]" class="staff_id" value="staff_id" checked /><span style="font-size: 18px;"> </span>

                            <input type="checkbox" class="staff_id disabled" value="" checked disabled /><span style="font-size: 18px;"> &nbsp;&nbsp;Staff Id</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="name" value="name" /><span style="font-size: 18px;"> &nbsp;&nbsp;Staff Name</span>
                        </div>
                           <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="dob" value="dob" /><span style="font-size: 18px;"> &nbsp;&nbsp;Date Of Birth</span>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="doj" value="doj" /><span style="font-size: 18px;"> &nbsp;&nbsp;Date of Join</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="gender" value="gender" /><span style="font-size: 18px;"> &nbsp;&nbsp;Gender</span>
                        </div> 
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="present_address" value="present_address" /><span style="font-size: 18px;"> &nbsp;&nbsp;Present Address </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="aadhar_no " value="aadhar_no" /><span style="font-size: 18px;"> &nbsp;&nbsp;Aadhar No.</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="voter_no" value="voter_no" /><span style="font-size: 18px;"> &nbsp;&nbsp;Voter No.</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="pan_no" value="pan_no" /><span style="font-size: 18px;"> &nbsp;&nbsp;Pan No.</span>
                        </div>
                    </div>
                   <div class="row">
                      <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="mobile" value="mobile" /><span style="font-size: 18px;"> &nbsp;&nbsp;Contact Number</span>
                      </div>
                      <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="email" value="email" /><span style="font-size: 18px;"> &nbsp;&nbsp;Email</span>
                     </div>
                      <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="role" value="role" /><span style="font-size: 18px;"> &nbsp;&nbsp;Role</span>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="department" value="department" /><span style="font-size: 18px;"> &nbsp;&nbsp;Department</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="blood_group" value="blood_group" /><span style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                        </div>
                        <!-- <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="religion" value="religion" /><span style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="blood_group" value="blood_group" /><span style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                        </div> -->
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadstaffReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>




<!-- The Modal for  applicationApprovedReport-->
<div class="modal" id="downloadMunExternalReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">MUN External</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="munExternalreport" action="<?php echo base_url(); ?>downloadMunExternalReport">
                
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Type</label>
                            <select class="form-control input-md required" id="" name="register_type" required>
                                <!-- <option value="">By Type</option> -->
                                <option value="ALL">ALL</option>
                                <option value="PRIVATE Delegation">PRIVATE Delegation</option>
                                <option value="INSTITUTION Delegation">INSTITUTION Delegation</option>
                                <option value="INDIVIDUAL Delegation">INDIVIDUAL Delegation</option>
                            </select>
                        </div>

                        <div class="col-lg-12 mt-2">
                            <label>By Payment Status</label>
                            <select class="form-control input-md required" id="" name="status">
                                <!-- <option value="">ALL</option> -->
                                <option value="Paid">Paid</option>
                                <option value="Not_paid">Not Paid</option>
                            </select>
                        </div>


                        
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="munExternalreport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal" id="smsReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">SMS Sent Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>downloadSMSReport" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="sms_date_from" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="sms_date_to" name="date_to"
                                    placeholder="Select Date To" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control input-sm selectpicker" id="term" name="term" required>
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Select Preference</label>
                                <select class="form-control input-sm selectpicker" id="preference" name="preference" required>
                                    <option value="">Select One Preference</option>
                                   
                                    <?php foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } ?>
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Select Section</label>
                                <select class="form-control input-sm selectpicker" id="section_name" name="section_name" required>
                                    <option value="">Select Section</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value=" ">All(No Section)</option>
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <label>Report type</label>
                            <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                <option value="">Report Type</option>
                                <option value="SMS Report">SMS Report</option>
                                <option value="Absentees Report">Absentees Report</option>
                                
                            </select>
                        </div>
                        
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>






<script type="text/javascript">
const checkDownloadStatus = ()=>{
    const downloadIntervalID = setInterval(() => {
        if( $.cookie('isDownLoaded')==1 ){
            hideLoader();
            clearInterval(downloadIntervalID);
        }
    }, 1000);
}

 //after load student details update student marks entered or not
 function downloadExcelSheet(){
        var loader = '<img height="30" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
        var right_mark = '<img src="<?php echo base_url(); ?>/assets/images/right_symbol.png"/>';
        var type = $('#type :selected').val();
        var streamName = $('#streamName :selected').val();
      //  var section_name = $('#section_name :selected').val();
        
   $.ajax({
           url: '<?php echo base_url(); ?>/getFullMarksOfStudent',
           type: 'POST',
           dataType:'json',
           data: {
            type : type,
            streamName : streamName,
           },

           success: function(data) {
            $("#downloadAllMarks").prop('disabled', false);
            $("#loader").html(right_mark + "<span style='color:green'><b>Downloded</b></span>");
              // var studentObj = JSON.parse(data)
              var $a = $("<a>");
                $a.attr("href",data.file);
                $("body").append($a);
                $a.attr("download","Annual_Result_I_PUC__file.xls");
                $a[0].click();
                $a.remove();
           },
           error: function(result)
               {
                $("#downloadAllMarks").prop('disabled', false);
                  alert("Mark is not added selected section");
                  $("#loader").html("<span style='color:red'>Selected class section not found in mark list!!</span>");
               },
               fail:(function(status) {
                $("#downloadAllMarks").prop('disabled', false);
                alert("Server Error!!  Failed");
               }),
               beforeSend:function(d){
                $("#downloadAllMarks").prop('disabled', true);
                $("#loader").html(loader);
               }
       });
}

jQuery(document).ready(function() {
    $("form").on('submit',()=>{
        $.cookie('isDownLoaded',0);
        checkDownloadStatus();
    });
    $('.pending_future_date').hide();
 //oncahnge active status
    $("#pendingStatus").on('change',function(){
        if(this.value == "Pending"){

            $('.pending_future_date').show();

        }else{

            $('.pending_future_date').hide();
            $('#pendingFutureDate').val('');  
        }
    });

      jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    jQuery('#date_select, #date_day, .dateSearch, #date_from, #date_to, #date_from_bulk, #date_to_bulk, #date_from_mis, #date_to_mis,#date_from_transport, #date_to_transport, #settle_date_bank, .bank_date_search, #date_from_fee, #date_to_fee, #sms_date_from, #sms_date_to').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
       $('#downloadAttendanceReport').click(function(){
        var term_name = $('.termValue').val();
        var section_name = $('#section_name').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var percentage_sort = $('#percentage_sort').val();
        if(section_name == ''){
            var section = 'ALL';
        }else{
            var section = section_name;
        }
        if(term_name == ""){
            alert("Term is Empty!!");
        // }else if(stream_name == ""){
        //     alert("Stream is Empty!!");
        }else{
            
            $.ajax({
                url: '<?php echo base_url(); ?>/downloadAbsentedStudentInfo',
                type: 'POST',
                dataType:'json',
                data: {
                    date_from : date_from,
                    date_to : date_to,
                    term_name : term_name,
                    section_name : section_name
                },
                success: function(data) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    // $("#downloadAttReport").hide();
                    var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download",term_name+"_"+section+"_ATTENDANCE_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) { 
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail:(function(status) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend:function(d){
                    $('#loader').html(loader);
                    $("#downloadAttendanceReport").prop('disabled', true);
                }
            });
        }
    });


    
    $('#downloadMeritList').click(function() {

        //  var by_category = $("#by_category_name_download").val();
        var preference = $("#preference").val();
        var board_name = $("#by_board_name_download").val();
        var percentage_from = $("#percentage_from_downlaod").val();
        var percentage_to = $("#percentage_to_downlaod").val();
        var student_type = $("#student_type").val();
        if (preference == "") {
            alert("Sorry! Select atlest one preference");
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>/getAllMeritListByApproved',
                type: 'POST',
                dataType: 'json',
                data: {
                    student_type : student_type,
                    preference: preference,
                    board_name: board_name,
                    percentage_from: percentage_from,
                    percentage_to: percentage_to,
                    type: 'ALL',
                },

                success: function(data) {
                    $("#downloadMeritList").prop('disabled', false);
                    // $("#loader").html(right_mark + "<span style='color:green'><b>Downloded</b></span>");
                    // var studentObj = JSON.parse(data)
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", preference + "_MERIT-LIST_2019.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) {
                    alert("Server Error!!  Failed");
                    // $("#downloadAllMarks").prop('disabled', false);
                    //   alert("Mark is not added selected section");
                    //   $("#loader").html("<span style='color:red'>Selected class section not found in mark list!!</span>");
                },
                fail: (function(status) {
                    // $("#downloadAllMarks").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    //$("#loaderDiv").html(loader);
                    $("#downloadMeritList").prop('disabled', true);
                    // $("#loader").html(loader);
                }
            });
        }
    });

    
    $('#downloadShortlistedMeritList').click(function(){
        var preference = $("#stream_name_shortlisted").val();
        var board_name = $("#by_board_name_shortlisted").val();
        var percentage_from = $("#percentage_from_downlaod").val();
        var percentage_to = $("#percentage_to_downlaod").val();
        var admission_year = $("#admission_year").val();
        var shortlist_number = $("#shortlist_number").val();
        var integrated_batch = $("#integrated_batch1").val();



        if(preference == ""){
            alert("Sorry! Select atlest one preference");
        }else{
            $.ajax({
            url: '<?php echo base_url(); ?>/getAllShortlistedList',
            type: 'POST',
            dataType:'json',
            data: {
                preference : preference,
                board_name : board_name,
                percentage_from : percentage_from,
                percentage_to : percentage_to,
                admission_year : admission_year,
                shortlist_number:shortlist_number,
                integrated_batch:integrated_batch,
                type : 'NOT',
            },

            success: function(data) {
                $("#downloadMeritList").prop('disabled', false);
                // $("#loader").html(right_mark + "<span style='color:green'><b>Downloded</b></span>");
                // var studentObj = JSON.parse(data)
                var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download",preference+"_SHORTLISTED-LIST_2021.xls");
                    $a[0].click();
                    $a.remove();
            },
            error: function(result)
                {
                    alert("Server Error!!  Failed");
                    // $("#downloadAllMarks").prop('disabled', false);
                    //   alert("Mark is not added selected section");
                    //   $("#loader").html("<span style='color:red'>Selected class section not found in mark list!!</span>");
                },
                fail:(function(status) {
                    // $("#downloadAllMarks").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend:function(d){
                    //$("#loaderDiv").html(loader);
                    $("#downloadMeritList").prop('disabled', true);
                    // $("#loader").html(loader);
                }
        });
        }
 
      });

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function toggleDepartmentSelect() {
        if ($('#staffIdd').val() === 'ALL') {
            $('.Department_Select').show();
            $('#departmentStaffId').attr('required', true);
        } else {
            $('.Department_Select').hide();
            $('#departmentStaffId').attr('required', false);
        }
    }

    // Initial check
    toggleDepartmentSelect();

    // Handle change event
    $('#staffIdd').on('change', function() {
        toggleDepartmentSelect();
    });



});
</script>