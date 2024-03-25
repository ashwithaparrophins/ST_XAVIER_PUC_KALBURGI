<!-- Add this to <head> -->

<!-- Load required Bootstrap and BootstrapVue CSS -->
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />

<!-- Load polyfills to support older browsers -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>

<!-- Load Vue followed by BootstrapVue -->
<script src="//unpkg.com/vue@latest/dist/vue.min.js"></script>
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>

<!-- Load the following for BootstrapVueIcons support -->
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.table_search_th {
    padding: .1rem !important;
    vertical-align: top !important;
    border-top: 1px solid #c2c6c7 !important;
}

.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}

.loaderScreen {
    display: block;
    visibility: visible;
    position: absolute;
    z-index: 999;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #0a0a0a94;
    vertical-align: bottom;
    padding-top: 20%;
    filter: alpha(opacity=75);
    opacity: 0.75;
    font-size: large;
    color: blue;
    font-style: italic;
    font-weight: 400;

    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-0" style="padding-bottom: 0px !important;">
                        <div class="row c-m-b">
                            <div class="col-lg-12 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-file"></i> <span style="font-size: 23px;font-weight: 600;">
                                        Fee Payment Portal -
                                    </span>
                                    <small><?php echo CURRENT_YEAR; ?></small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">

            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 ">
                        <form action="<?php echo base_url() ?>getNewStudentFeePaymentInfo" method="POST">
                            <div class="row">

                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <select class="form-control selectpicker" data-live-search="true"
                                            name="application_no" required>
                                            <?php if(!empty($application_no)){ ?>
                                            <option value="<?php echo $application_no; ?>" selected>
                                                <?php echo $studentInfo->student_id; ?></option>
                                            <?php }   ?>
                                            <option value="">Select Student</option>
                                            <?php if(!empty($allStudentInfo)){
                                        foreach($allStudentInfo as $std){  ?>
                                            <option value="<?php echo $std->row_id; ?>">
                                                <b><?php echo $std->student_id.' - '.$std->application_no.' - '.$std->student_name. ' - '.$std->term_name; ?></b>
                                            </option>
                                            <?php } } ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" style="width:170px" class="btn btn-success"
                                                type="button">Search</button>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 ">
                            <?php 
                                    if(!empty($total_fee)){
                                        $total_fee_to_pay = $total_fee;
                                    }else{
                                        $total_fee_to_pay = $feeInfo->total_fee;
                                    }
                                    
                                    if(!empty($studentInfo)){ ?>

                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="card border-success mb-1">
                                        <div class="card-header bg-transparent border-success"><?php echo $text_display_view; ?></div>
                                        <div style=" padding: 0rem 0rem;" class="card-body ">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="table-success">
                                                        <th class="text-left" scope="col" width="280">Name</th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo  $studentInfo->student_name; ?></th>
                                                    </tr>
                                                    <?php if($std_status == 0){?>
                                                    <tr class="table-success">
                                                        <th class="text-left" scope="col">Stud ID</th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo $studentInfo->student_id; ?></th>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr class="table-primary">
                                                        <th class="text-left" scope="col">Term</th>
                                                        <th class="text-left" scope="col"><?php echo $term_name; ?></th>
                                                    </tr>
                                                    <?php if($std_status == 0){?>
                                                    <tr class="table-success">
                                                        <th class="text-left" scope="col">Stream </th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo $studentInfo->stream_name; ?>
                                                        </th>
                                                    </tr>
                                            
                                                    <!-- <tr class="bg-primary text-white">
                                                        <th class="text-left" scope="col">Elective Sub</th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo $studentInfo->elective_sub; ?>
                                                        </th>
                                                    </tr> -->

                                                    <tr class="bg-primary text-white">
                                                        <th class="text-left" scope="col">Total Amount</th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo number_format($total_fee_amount,2); ?>
                                                        </th>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if($std_status == 1){?>
                                                    <tr class="bg-primary text-white">
                                                        <th class="text-left" scope="col">Student Status</th>
                                                        <th class="text-left" scope="col">
                                                            <?php if($std_status == 1){echo 'REJECTED';} ?>
                                                        </th>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if($scholarship != 0){ ?>
                                                        <tr class="bg-secondary text-white">
                                                            <th class="text-left" scope="col">Scholarship Amt</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($scholarship,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                    <?php if($concession != 0){ ?>
                                                        <tr class="bg-secondary text-white">
                                                            <th class="text-left" scope="col">Concession Amt</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($concession,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                      

                                                        <tr class="bg-success text-white">
                                                        <th class="text-left" scope="col">Paid Amount</th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo number_format($paid_amount,2); ?>
                                                        </th>
                                                    </tr>

                                                    <tr class="bg-danger text-white">
                                                        <th class="text-left" scope="col">Total Pending Fee Amt</th>
                                                        <th class="text-left" scope="col">
                                                            <?php echo number_format($pending_amount,2); ?>
                                                        </th>
                                                    </tr>

                                                    <?php if(!empty($fee_installment)){ ?>
                                                        <tr class="bg-secondary text-white">
                                                            <th class="text-left" scope="col">Installment</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($fee_installment->amount,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>

                                                    <?php if ($term_name == "II PUC") { ?>
                                                    <tr class="table-danger text-white">
                                                        <th class="text-left" scope="col">I PUC Balance</th>
                                                        <th class="text-left" scope="col">
                                                            <?php if ($previousBal < 0) {
                                                                echo 0;
                                                            } else {
                                                                echo number_format($previousBal,2);
                                                            } ?>
                                                        </th>
                                                    </tr>
                                                    <?php } ?>

                                                </thead>

                                            </table>

                                        </div>

                                    </div>
                                </div>


                                <div class="col-lg-6 col-12">
                                    <?php if($studentInfo->term_name == 'II PUC'){ ?>
                                    <div class="card border-success mb-3">
                                        <div class="card-header bg-primary border-success p-1 text-white"> II PUC Fee Info</div>
                                        <div class="card-body">
                                            <?php if(trim($studentInfo->intake_year_id) != '2020'){
                                                        if ($pending_amount > 0) { ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input type="text" name="transaction_date"
                                                            value="<?php echo date('d-m-Y'); ?>"
                                                            class="form-control card_date I_datepicker"
                                                            Placeholder="Transaction Date" id="transaction_date"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($studentInfo->is_active == 1){?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class="form-control text-dark" id="ii_fee_type_select"
                                                            name="fee_type">
                                                            <option value="">Select Fee Type</option>
                                                            <option value="1">FIRST ATTEMPT</option>
                                                            <option value="2">SECOND ATTEMPT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control " id="II_PUC_paid_amount"
                                                            name="paid_amount" placeholder="Paid Amount"
                                                            onkeypress="return isNumberKey(event)" required
                                                            autocomplete="off">
                                                            <input type="hidden" value="<?php echo $total_fee_amount - $scholarship - $concession - 2000; ?>" id="ii_paid_amt">

                                                    </div>
                                                </div>
                                           
                                                <div class="col-6">
                                                    <div class="form-group ">
                                                        <select class="form-control text-dark" id="payment_type"
                                                            name="payment_type">
                                                            <option value="">Select Payment Type</option>
                                                            <option value="CASH" selected>CASH</option>
                                                            <option value="DD">DD</option>
                                                            <option value="CARD">CARD</option>
                                                            <option value="UPI">UPI</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                    <input type="hidden" value="<?php echo $fee_year_II; ?>" id="II_PUC_year">
                                                        <input type="text" class="form-control reference_receipt_noII" id="ref_receipt_number"
                                                            name="ref_receipt_number" placeholder="Reference Receipt No."
                                                            onkeypress="return isNumberKey(event)" required
                                                            autocomplete="off" >
                                                            <h6 class="error-hint display-none receiptHideII" style="color: red;">Receipt Number Already exists</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <button id="paymentInfoSubmit" style="margin-top: 1px; float:right" 
                                                    
                                                        class="btn btn-success btn-block mb-1">Submit</button>
                                                </div>
                                            </div>


                                            <?php } else { ?>
                                            <h5 style="color:green">II PUC Fee cleared</h5>
                                            <?php }
                                                     } ?>
                                            <table style="margin-top: 2px;" class="table table-hover">
                                                <thead>
                                                    <tr class="table_row_background">
                                                        <th>Date</th>
                                                        <th>Receipt No.</th>
                                                        <th>Amt.</th>
                                                        <?php if($fee_year_II == '2024' && $std_status == 0){
                                                           ?>
                                                        <th>Fee Type</th>
                                                        <?php } ?>
                                                        <th>Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <?php $j = 1;   $length = count($II_feePaidInfo); if (!empty($II_feePaidInfo)) {
                                                            foreach ($II_feePaidInfo as $fee) { 
                                                                if(!empty($fee->ref_receipt_no)){
                                                                    $fees_receipt_no = $fee->ref_receipt_no;
                                                                }else{
                                                                    $fees_receipt_no = " ";
                                                                } ?>
                                                <tr class="text-dark">
                                                    <td><?php echo date('d-m-Y', strtotime($fee->payment_date)); ?></td>
                                                    <td class="text-center"><?php echo $fee->ref_receipt_no; ?></td>
                                                    <td><?php echo number_format($fee->paid_amount,2); ?></td>
                                                    <?php if($fee_year_II == '2024' && $std_status == 0){
                                                           ?>
                                                    <td><?php if($fee->attempt == "1"){echo "First Attempt";}else{echo "Second Attempt";}; ?></td>
                                                    <?php } ?>
                                                    <td><?php echo $fee->payment_type; ?></td>
                                                    <td>
                                                        <?php if(trim($studentInfo->intake_year_id) == '2020'){ ?>
                                                            <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->receipt_number; ?>"
                                                            target="_blank">Receipt</a>
                                                        <?php }else{ ?>   
                                                            <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                target="_blank">Receipt</a>
                                                        <?php } ?>   
                                                        <a class="btn btn-xs btn-secondary" onclick="openModel(<?php echo $fee->row_id; ?>,/<?php echo $fees_receipt_no; ?>/)" title="Edit" href='#'><i class="fas fa-edit"></i></a>  
                                                        <?php if($length == $j && $fee->payment_type != 'ONLINE'){ ?>                                                                                

                                                            <a class="btn btn-xs btn-danger deleteFeesReceipt" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Cancel Receipt"><i class="fas fa-trash"></i></a>
                                                        <?php  } ?>  
                                                    </td>
                                                </tr>
                                                <?php  $j++;}
                                                        } else { ?>
                                                <tr class="text-dark">
                                                    <td colspan="6">Fee info not found</td>
                                                </tr>
                                                <?php   } ?>
                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php //if(trim($studentInfo->term_name) == 'I PUC'){ ?>
                                    <div class="card border-success mb-1">
                                        <div class="card-header bg-primary border-success p-1 text-white">I PUC Fee Info
                                        </div>
                                        <div class="card-body">
                                            <?php if($previousBal > 0){ //if(trim($studentInfo->term_name) == 'I PUC'){ if ($previousBal > 0) { ?>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input type="text" name="transaction_date"
                                                            value="<?php echo date('d-m-Y'); ?>"
                                                            class="form-control card_date dateSearch"
                                                            Placeholder="Transaction Date" id="transaction_date1"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($studentInfo->intake_year_id == 2023 || $studentInfo->intake_year_id == 2024){ ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class="form-control text-dark" id="i_fee_type_select"
                                                            name="fee_type">
                                                            <option value="">Select Fee Type</option>
                                                            <option value="1">FIRST ATTEMPT</option>
                                                            <option value="2" >SECOND ATTEMPT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>  
                                           <?php } ?>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group mb-2">
                                                        <input type="text" class="form-control " id="i_paid_amount"
                                                            name="paid_amount" placeholder="Paid Amount"
                                                            onkeypress="return isNumberKey(event)" required
                                                            autocomplete="off">

                                                            <input type="hidden" value="<?php echo $I_balance - 2000; ?>" id="i_paid_amt">

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group ">
                                                        <select class="form-control text-dark" id="payment_type"
                                                            name="payment_type">
                                                            <option value="">Select Payment Type</option>
                                                            <option value="CASH">CASH</option>
                                                            <option value="DD">DD</option>
                                                            <option value="CARD">CARD</option>
                                                            <option value="UPI">UPI</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <input type="hidden" value="<?php echo $year; ?>" id="I_PUC_year">
                                                        <input type="text" class="form-control reference_receipt_no" id="ref_receipt_number1"
                                                            name="ref_receipt_number" placeholder="Reference Receipt No."
                                                            onkeypress="return isNumberKey(event)" required
                                                            autocomplete="off" >
                                                            <h6 class="error-hint display-none receiptHide" style="color: red;">Receipt Number Already exists</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <button id="firstPaymentInfoSubmit" 
                                                        style="margin-top: 5px; float:right"
                                                        class="btn btn-success btn-block mb-2">Submit</button>
                                                </div>
                                            </div>

                                            <?php  } else { ?>
                                            <h5 style="color:green">I PUC Fee Cleared</h5>
                                            <?php }  ?>
                                            <table style="margin-top: 5px;" class="table table-hover">
                                                <thead>
                                                    <tr class="table_row_background">
                                                        <th>Date</th>
                                                        <th>Receipt No.</th>
                                                        <th>Amt.</th>
                                                        <?php if(($year == '2023' || $year == '2024') && $std_status == 0){?>
                                                        <th>Fee Type</th>
                                                        <?php }?>
                                                        <th>Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <?php $i = 1;   $length = count($feePaidInfo);if (!empty($feePaidInfo)) {   
                                                            foreach ($feePaidInfo as $fee) {
                                                                if(!empty($fee->ref_receipt_no)){
                                                                    $fee_receipt_no = $fee->ref_receipt_no;
                                                                }else{
                                                                    $fee_receipt_no = " ";
                                                                } ?>
                                                <tr class="text-dark">
                                                    <td><?php echo date('d-m-Y', strtotime($fee->payment_date)); ?></td>
                                                    <td class="text-center"><?php echo $fee->ref_receipt_no; ?></td>
                                                    <td><?php echo number_format($fee->paid_amount,2); ?></td>
                                                    <?php if(($year == '2023'|| $year == '2024') && $std_status == 0){?>
                                                    <td><?php if($fee->attempt == "1"){echo "First Attempt";}else{echo "Second Attempt";}; ?></td>
                                                    <?php } ?>
                                                    <td><?php echo $fee->payment_type; ?></td>
                                                    <td>   
                                                            <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                            target="_blank">Receipt</a> 
                                                            <a class="btn btn-xs btn-secondary" onclick="openModel(<?php echo $fee->row_id; ?>,/<?php echo $fee_receipt_no; ?>/)" title="Edit" href='#'><i class="fas fa-edit"></i></a>
                                                            <?php if($length == $i && $fee->payment_type != 'ONLINE'){ ?>                                                                                
                                                                <a class="btn btn-xs btn-danger deleteFeesReceipt"  href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Cancel Receipt"><i class="fas fa-trash"></i></a>
                                                            <?php  } ?> 
                                                    </td>
                                                </tr>
                                                <?php $i++;}
                                                        } else { ?>
                                                <tr class="text-dark">
                                                    <td colspan="6">Fee info not found</td>
                                                </tr>
                                                <?php  } ?>
                                            </table>
                                        </div>
                                    </div>
                                    <?php //} ?>
                                </div>


                            </div>
                            <?php }else{
                                            echo "<h5 class='text-center'>Select Student for payment</h5>";
                                        }
                       
                                    ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



</div>



<!-- donload report filter modal -->
<div class="modal" id="myReportModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Fee Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">

                <form role="form" id="addFeePaymentInfo" action="<?php echo base_url() ?>newAddFeePaymentInfo"
                    method="post" role="form">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Fee Amount</th>
                                        <td id="fee_amount_display"></td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Paid Amount</th>
                                        <td id="paid_amount_display"></td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Pending Fee</th>
                                        <td id="pending_fee_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Excess Fee / Card Charges</th>
                                        <td id="excess_fee_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Payment Type</th>
                                        <td id="payment_type_display"></td>
                                    </tr>
                                    <!-- <tr>
                                        <th scope="row">Fee Type</th>
                                        <td id="fee_type_display"></td>
                                    </tr> -->
                                </tbody>
                            </table>

                            <div class="card_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="tran_number"
                                                required class="form-control" Placeholder="Transaction Number"
                                                id="tran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Date:</label>
                                            <input type="text" name="tran_date" class="form-control card_date" required
                                                Placeholder="Transaction Date" id="tran_date" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="tran_bank_name" Value="South Indian Bank" required
                                                class="form-control" Placeholder="Enter Bank Name" id="tran_bank_name"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="upi_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input type="text" name="upi_number"
                                                required class="form-control" Placeholder="Transaction Number"
                                                id="upi_number" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dd_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="dd_number"
                                                required class="form-control" Placeholder="Enter DD Number"
                                                id="dd_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Date:</label>
                                            <input type="text" name="dd_date" class="form-control" required
                                                Placeholder="Enter DD Date" id="dd_date" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="bank_name" class="form-control" required
                                                Placeholder="Enter Bank Name" id="dd_bank_name" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>


                    <input type="hidden" id="transaction_date_text" name="transaction_date" value="" required />
                    <input type="hidden" name="application_no" value="<?php echo $application_no; ?>"
                        required />
                    <input type="hidden" id="term_name_selected" name="term_name_selected" value="" required />
                    <input type="hidden" id="payment_year" name="payment_year" value="" required />
                    <input type="hidden" name="student_id" value="<?php echo $studentInfo->student_id; ?>" required />
                    <input type="hidden" id="paid_fee_amount" name="paid_fee_amount" value="" required />
                    <input type="hidden" id="payment_type_input" name="payment_type" value="" required />
                    <input type="hidden" id="excess_amount_input" name="excess_amount" value="" required />
                    <input type="hidden" id="ref_receipt_no" name="ref_receipt_no" value="" required />
                    <input type="hidden" id="fee_type_input" name="fee_type" value="" required />
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" form="addFeePaymentInfo"
                    class="btn btn-success float-right proceedFeePaymentInfoButton" value="Proceed" />
            </div>

        </div>
    </div>
</div>

<!--Edit Receipt Model--->
<div id="receiptNoEdit" class="modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header modal-call-report">
                    <div class=" col-md-10 col-10">
                        <span class="text-white mobile-title" style="font-size : 20px">Edit Receipt</span>
                    </div>
                    <div class=" col-md-2 col-2">
                        <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <!-- Modal body -->
                <div class="modal-body m-0 p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="updateFeeReceipt" action="<?php echo base_url() ?>updateFeeReceipt"
                        method="post" role="form">
                        <input type="hidden" name="row_id" id="row_id" value="" />
                        <div class="row">
                           
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Receipt No.</label>
                                    <input type="text" class="form-control ref_rept_no" id="receipt_no" name="receipt_no" autocomplete="off" required>
                                    <h6 class="error-hint display-none reptHide" style="color: red;">Receipt Number Already exists</h6>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">


    function openModel(row_id, receipt_no) {
      
        $('#row_id').val(row_id);
        var receipt_no = String(receipt_no);
        var receipt_no = receipt_no.substring(1, receipt_no.length-1);
        $('#receipt_no').val(receipt_no);
        $('#receiptNoEdit').modal('show');
    }

jQuery(document).ready(function() {

    jQuery(document).on("click", ".deleteFeesReceipt", function(){
    var row_id = $(this).data("row_id"),
        hitURL = baseURL + "deleteFeesReceipt",
        currentRow = $(this);

    var confirmation = confirm("Are you sure you want to delete this Receipt?");

    if (confirmation) {
        var remark;

        do {
            // Prompt the user to enter a remark
            remark = prompt("Enter remark:");

            // Check if the user clicked "Cancel"
            if (remark === null) {
                // Exit the function if the user cancels
                return;
            }

            // Check if the user entered a remark
            if (remark.trim() === "") {
                alert("Remark is mandatory. Please enter a remark.");
            }
        } while (remark.trim() === "");

        // Continue with the deletion process
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: hitURL,
            data: {
                row_id: row_id,
                remark: remark  // Include the remark in the data sent to the server
            }
        }).done(function(data) {
            currentRow.parents('tr').remove();
            if (data.status === true) {
                alert("Fee Receipt successfully Deleted");
            } else if (data.status === false) {
                alert("Failed to delete Receipt");
            } else {
                alert("Access denied..!");
            }
        });
    }
});

        const II_feeTypeSelect = $("#ii_fee_type_select");
        const II_paidAmountInput = $("#II_PUC_paid_amount");
        const II_paidAmtHidden = $("#ii_paid_amt");

        II_feeTypeSelect.on("change", function () {
           
            if (II_feeTypeSelect.val() == "1") {  
                II_paidAmountInput.val(II_paidAmtHidden.val());
                II_paidAmountInput.prop("readonly", true);
            } else {
                // Handle other cases or set default value
                II_paidAmountInput.val("");
                II_paidAmountInput.prop("readonly", false);
            }
        });

        const I_feeTypeSelect = $("#i_fee_type_select");
        const I_paidAmountInput = $("#i_paid_amount");
        const I_paidAmtHidden = $("#i_paid_amt");

        I_feeTypeSelect.on("change", function () {
          
            if (I_feeTypeSelect.val() == "1") {  
                alert(I_paidAmtHidden.val());
                I_paidAmountInput.val(I_paidAmtHidden.val());
                I_paidAmountInput.prop("readonly", true);
            } else {
                // Handle other cases or set default value
                I_paidAmountInput.val("");
                I_paidAmountInput.prop("readonly", false);
            }
        });


       
    

    $('.receiptHide').hide();
    $('.receiptHideII').hide();

    $('.reference_receipt_noII').on('keyup', function(evt){
            let reference_receipt_no = $(this).val();
           
            let year = $('#II_PUC_year').val();
       
            $('.receiptHideII').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>/getReceiptNumber',
                type: 'POST',
                dataType: "json",
                data: { 
                    reference_receipt_no : reference_receipt_no,
                    year: year
                   
                },
                success: function(data) {
                    //var examObject = JSON.parse(data);
                    var examObject = JSON.stringify(data)
                    var count = data.result.length;
                    if(count != 0){
                        if(data.result.ref_receipt_no == reference_receipt_no){
                            $('.receiptHideII').show();
                        }else{
                            $('.receiptHideII').hide();
                        }
                    }else{
                        $('.receiptHideII').hide();
                    }
                }
            });
        });
        $('.reference_receipt_no').on('keyup', function(evt){
            let reference_receipt_no = $(this).val();
           
            let year = $('#I_PUC_year').val();
          
            $('.receiptHide').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>/getReceiptNumber',
                type: 'POST',
                dataType: "json",
                data: { 
                    reference_receipt_no : reference_receipt_no,
                    year: year
                   
                },
                success: function(data) {
                    //var examObject = JSON.parse(data);
                    var examObject = JSON.stringify(data)
                    var count = data.result.length;
                    if(count != 0){
                        if(data.result.ref_receipt_no == reference_receipt_no){
                            $('.receiptHide').show();
                        }else{
                            $('.receiptHide').hide();
                        }
                    }else{
                        $('.receiptHide').hide();
                    }
                }
            });
        });

    $('.reptHide').hide();
    $('.ref_rept_no').on('keyup', function(evt){
            let ref_rept_no = $(this).val();
           
            $('.reptHide').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>/getReceiptNo',
                type: 'POST',
                dataType: "json",
                data: { 
                    ref_rept_no : ref_rept_no
                },
                success: function(data) {
                    //var examObject = JSON.parse(data);
                    var examObject = JSON.stringify(data)
                    var count = data.result.length;
                    if(count != 0){
                        if(data.result.ref_receipt_no == ref_rept_no){
                            $('.reptHide').show();
                        }else{
                            $('.reptHide').hide();
                        }
                    }else{
                        $('.reptHide').hide();
                    }
                }
            });
        });
        
    jQuery('#transaction_date1, #tran_date, #dd_date,.I_datepicker').datepicker({
        autoclose: true,
        orientation: "top",
        format: "dd-mm-yyyy"

    });
    $('.dd_info').hide();
    $('.card_info').hide();
    //   $('.loaderScreen').hide();

    $("#searchStudentFeeInfo").click(function() {
        $('.loaderScreen').show();
    });

    //slect payment method option change
    $("#paymentInfoSubmit").on('click', function() {
        var payment_type = $('#payment_type').val();
        var ref_receipt_number = $('#ref_receipt_number').val();
        var fee_type = $('#ii_fee_type_select').val();
        var fee_amount = <?php echo $balance; ?>;
        var excess_amount = 0;
        var card_charges = 0;
        var paid_amount_display = $('#II_PUC_paid_amount').val();
        //alert(paid_amount_display);
        if (paid_amount_display == "") {
            alert("Please Enter Paid Amount");
            return;
        }
        var transaction_date = $('#transaction_date').val();
        if (transaction_date == "") {
            alert("Please Select Transaction Date");
            return;
        }
        if (fee_type == "") {
            alert("Please Select Fee Type");
            return;
        }
        if (payment_type == "") {
            alert("Please Select Payment Type");
            return;
        }
        var pending_fee_amount = fee_amount - paid_amount_display;
        // alert(payment_type);
        if (payment_type == "DD") {
            $('.dd_info').show();
            $('.card_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "CARD") {
            card_charges = (2.0 / 100) * paid_amount_display;
            $('.dd_info').hide();
            $('.card_info').show();
            $('.upi_info').hide();
        } else if (payment_type == "CASH") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "UPI") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.upi_info').show();
        } else {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.upi_info').hide();
        }


        if (pending_fee_amount < 0) {
            excess_amount = pending_fee_amount;
        } else {
            excess_amount = 0;
        }
        excess_amount = excess_amount + card_charges;
        excess_amount = Number(excess_amount).toFixed(2);
        $('#paid_amount_display').html(paid_amount_display);
       $('#fee_amount_display').html(fee_amount);
       
        $('#excess_fee_display').html(excess_amount);
        $('#payment_type_display').html(payment_type);
        $('#fee_type_display').html(fee_type);

        if (fee_type === "1") {
            var adjustedFeeAmount = fee_amount - 2000;
            $('#fee_amount_display').html(adjustedFeeAmount);
            pending_fee_amount = adjustedFeeAmount - paid_amount_display;
        } else {
            $('#fee_amount_display').html(fee_amount);
            pending_fee_amount = fee_amount - paid_amount_display;
        }
        $('#pending_fee_display').html(pending_fee_amount);
        $('#paid_fee_amount').val(paid_amount_display);
        $('#payment_type_input').val(payment_type);
        $('#transaction_date_text').val(transaction_date);
        $('#excess_amount_input').val(excess_amount);
        $('#ref_receipt_no').val(ref_receipt_number);
        $('#fee_type_input').val(fee_type);
        $('#term_name_selected').val('II PUC');
        $('#payment_year').val('2023');

        $('#myReportModal').modal('show');
    });

    $("#firstPaymentInfoSubmit").on('click', function() {
        var payment_type = $('#payment_type').val();
        var ref_receipt_number = $('#ref_receipt_number1').val();
        var fee_type = $('#i_fee_type_select').val();
        var fee_amount = <?php echo $I_balance; ?>;
        var excess_amount = 0;
        var card_charges = 0;
        var paid_amount_display = $('#i_paid_amount').val();
        if (paid_amount_display == "") {
            alert("Please Enter I PUC  Paid Amount");
            return;
        }
        var transaction_date = $('#transaction_date1').val();
        if (transaction_date == "") {
            alert("Please Select Transaction Date");
            return;
        }
        
        // if (fee_type == "") {
        //     alert("Please Select Fee Type");
        //     return;
        // }
        if (payment_type == "") {
            alert("Please Select Payment Type");
            return;
        }
        
        var pending_fee_amount = fee_amount - paid_amount_display;
        // alert(payment_type);
        if (payment_type == "DD") {
            $('.dd_info').show();
            $('.card_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "CARD") {
            card_charges = (2.0 / 100) * paid_amount_display;
            $('.dd_info').hide();
            $('.card_info').show();
            $('.upi_info').hide();
        } else if (payment_type == "CASH") {
            $('.dd_info').hide();
            $('.upi_info').hide();
            $('.card_info').hide();
        } else if (payment_type == "UPI") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.upi_info').show();
        } else {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.upi_info').hide();
        }


        if (pending_fee_amount < 0) {
            excess_amount = pending_fee_amount;
        } else {
            excess_amount = 0;
        }
        excess_amount = excess_amount + card_charges;
        excess_amount = Number(excess_amount).toFixed(2);
        $('#paid_amount_display').html(paid_amount_display);
        $('#fee_amount_display').html(fee_amount);
        $('#excess_fee_display').html(excess_amount);
        $('#payment_type_display').html(payment_type);
        $('#fee_type_display').html(fee_type);

      
        if (fee_type === "1") {
            var adjustedFeeAmount = fee_amount - 2000;
            $('#fee_amount_display').html(adjustedFeeAmount);
            pending_fee_amount = adjustedFeeAmount - paid_amount_display;
        } else {
            $('#fee_amount_display').html(fee_amount);
            pending_fee_amount = fee_amount - paid_amount_display;
        }
        $('#pending_fee_display').html(pending_fee_amount);

        $('#paid_fee_amount').val(paid_amount_display);
        $('#payment_type_input').val(payment_type);
        $('#transaction_date_text').val(transaction_date);
        $('#excess_amount_input').val(excess_amount);
        $('#ref_receipt_no').val(ref_receipt_number);
        $('#fee_type_input').val(fee_type);
        $('#term_name_selected').val('I PUC');


        $('#myReportModal').modal('show');
    });



    $(".proceedFeePaymentInfoButton").click(function() {
        if ($("#addFeePaymentInfo").valid()) {
            $('.loaderScreen').show();
            $('#myReportModal').modal('hide')
        }

    });


});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>