<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<div class="main-content-container px-3">
    <!-- Page Header -->
    <div class="row mt-1 mb-1 ">
        <div class="col padding_left_right_null">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="fas fa-tachometer-alt"></i> Dashboard / Overview
                    </span>
                    <!-- <img class="float-right" height="35" src="<?php echo base_url(); ?><?php echo DASHBOARD_IMAGE; ?>" /> -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Small Stats Blocks -->

    <div class="row ">
        <?php if ($role == ROLE_ADMIN ||$role == ROLE_LIBRARY || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_MANAGEMENT || $role == ROLE_ACCOUNT_MANAGER || $role == ROLE_SUPER_ADMIN) { ?>
            <div class="col-lg-3 col-6 mb-1 column_padding_card">
                <div class="card card-small dash-card" style="background: #6aacc5;">
                    <a onclick="showLoader();" href="<?php echo base_url(); ?>libraryManagementSystem">
                        <div class="card-body pt-1 pb-1">
                            <span class="stats-small__label text-uppercase text-white text-center">Total Books &emsp; <?php echo $bookCount; ?></span>
                            <h6 class="stats-small__value count text-white"></h6>
                            <div class="icon pull-right">
                                <i class="fa fa-book dash-icons"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center dash-footer p-1">
                            <a class="more-info text-white" onclick="showLoader();" href="<?php echo base_url(); ?>libraryManagementSystem">
                            <span class="text-center">View Books</span></a>
                        </div>
                    </a>
                </div>
            </div>
            <?php if ($role != ROLE_MANAGEMENT) { ?>
                <div class="col-lg-3 col-6 mb-1 column_padding_card">
                    <div class="card card-small dash-card" style="background: #6aacc5;">
                        <a onclick="showLoader();" href="<?php echo base_url(); ?>viewIssuedBooks">
                            <div class="card-body pt-1 pb-1">
                                <span class="stats-small__label text-uppercase text-white text-center">Total Borrowed &emsp; <?php echo $borrowedCount; ?></span>
                                <h6 class="stats-small__value count text-white">
                                    
                                </h6>
                                <div class="icon pull-right">
                                    <i class="fa fa-book dash-icons"></i>
                                </div>
                            </div>
                            <div class="card-footer text-center dash-footer p-1">
                                <a class="more-info text-white" onclick="showLoader();" href="<?php echo base_url(); ?>viewIssuedBooks">
                                <span class="text-center">View Borrowed</span></a>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6 mb-1 column_padding_card">
                    <div class="card card-small dash-card" style="background: #6aacc5;">
                        <a onclick="showLoader();" href="<?php echo base_url(); ?>viewIssuedBooks">
                            <div class="card-body pt-1 pb-1">
                                <span class="stats-small__label text-uppercase text-white text-center">Total Fine &emsp; <?php echo $fineCount; ?></span>
                                <h6 class="stats-small__value count text-white"></h6>
                                <div class="icon pull-right">
                                    <i class="far fa-money-bill-alt dash-icons"></i>
                                </div>
                            </div>
                            <div class="card-footer text-center dash-footer p-1">
                                <a class="more-info text-white" onclick="showLoader();" href="<?php echo base_url(); ?>viewIssuedBooks"><span class="text-center">View Fine</span></a>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            
            <?php if ($role != ROLE_ACCOUNT_MANAGER) { ?>
                <div class="col-lg-3 col-6 mb-1 column_padding_card">
                    <div class="card card-small dash-card" style="background: #6aacc5;">
                        <a onclick="showLoader();" href="<?php echo base_url(); ?>studentDetails">
                            <div class="card-body pt-1 pb-1">
                                <span class="stats-small__label text-uppercase text-white text-center">Users &emsp; <?php echo $studentCount; ?></span>
                                <h6 class="stats-small__value count text-white"></h6>
                                <div class="icon pull-right ">
                                    <i class="fa fa-users dash-icons"></i>
                                </div>
                            </div>
                            <div class="card-footer text-center dash-footer p-1">
                                <a class="more-info text-white" onclick="showLoader();" href="<?php echo base_url(); ?>studentDetails"><span class="text-center">View Users</span></a>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?> 
        <?php } ?>
        
 
   

       
    </div>

</div>

<!-- Event Calendar Scripts -->
<link href="<?= base_url() ?>assets/calendar/main.css" rel='stylesheet' />
<script src="<?= base_url() ?>assets/calendar/main.js"></script>
<script src="<?= base_url() ?>assets/plugins/sweetalert/sweetalert2.0.js"></script>