<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 5px !important;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.5);
}

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
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-12 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-bus"></i> <span style="font-size: 23px;font-weight: 600;">
                                        BusFee Payment Portal
                                    </span>
                                    <!-- <small>By Student</small> -->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
          <!--   <div id="coverScreen" class="loaderScreen text-center">
                <img height="90" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="">
            </div> -->
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2  ">
                        <form action="<?php echo base_url() ?>getStudentTransFeePaymentInfo" method="POST">
                            <div class="row">
                                <!-- <div class="col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true"
                                            name="year" id="year" required autocomplete="off">
                                            <?php if(!empty($year)){ ?>
                                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                            <?php } ?>
                                            <option value="2023">2023</option>
                                        </select>
                                    </div>
                                </div>    -->
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" data-live-search="true"
                                            name="student_row_id" id="student_row_id" required autocomplete="off">
                                            <?php if(!empty($studentData)){ ?>
                                                <option value="<?php echo $studentData->row_id; ?>">
                                                <b><?php echo $studentData->student_name.' - '.$studentData->term_name.' '.$studentData->section_name; ?></b></option>
                                            <?php } ?>
                                            <option value="">Select Student</option>
                                            <?php if(!empty($studentInfo)){
                                            foreach($studentInfo as $std){  ?>
                                            <option value="<?php echo $std->row_id; ?>">
                                                <b><?php echo $std->student_name.' - '.$std->term_name.' '.$std->section_name; ?></b></option>
                                            <?php } } ?>
                                        </select>

                                    </div>
                                </div>           
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <button id="searchStudentFeeInfo" class="btn btn-primary btn-block"
                                            type="submit">Search</button>
                                    </div>
                                </div>

                            </div>
                        </form>


                        <div class="row">
                            <div class="col-lg-12">
                                <?php 
                                // if($fee_pending_status){
                                   if(!empty($studentData->student_name)){ ?>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card border-success mb-3">
                                            <div class="card-header bg-transparent border-success">Fee Info</div>
                                            <div class="card-body ">
                                                <table class="table table-hover">
                                                    <thead style="line-height: 1.2;font-size: 0.9em;font-weight: bold; color: black;">
                                                        <tr class="table-success">
                                                            <th class="text-left" scope="col">Name</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo  $studentData->student_name; ?></th>
                                                        </tr>
                                                        <tr class="table-success">
                                                            <th class="text-left" scope="col">Term & Stream</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo $studentData->term_name.' '.$studentData->stream_name; ?></th>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <th class="text-left" scope="col">Stud ID</th>
                                                            <th class="text-left" scope="col"><?php echo $studentData->student_id; ?></th>
                                                        </tr>
                                                        
                                                        <tr class="table-primary">
                                                            <th class="text-left" scope="col">Bus Pick Point</th>
                                                            <th class="text-left" scope="col"><?php echo $RateInfo->pickup_point_name; ?></th>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <th class="text-left" scope="col">Bus No.</th>
                                                            <th class="text-left" scope="col"><?php echo $RateInfo->route_name; ?></th>
                                                        </tr>
                                                        <tr class="bg-primary text-white">
                                                            <th class="text-left" scope="col">Total Fee</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($total_fee,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php if(!empty($feePaidInfo->paid_amount)){ ?>
                                                        <tr class="bg-success text-white">
                                                            <th class="text-left" scope="col">Total Fee Paid</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($feePaidInfo->paid_amount,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php 
                                                        if(!empty($feeConcession->fee_amt)){ ?>
                                                        <tr class="bg-warning text-white" >
                                                            <th class="text-left" scope="col">Concession</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($feeConcession->fee_amt,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php //if(!empty($fee_amount)){ ?>
                                                        <tr class="bg-danger text-white">
                                                            <th class="text-left" scope="col">Pending Balance</th>
                                                            <th class="text-left" scope="col">
                                                            <?php if($studentData->term_name == 'I PUC') {
                                                                if($studentData->cancel_bus_status == 1){echo number_format(0,2); }else{echo number_format($fee_amount,2); }
                                                                    }else{
                                                                if($studentData->cancel_bus_statusII == 1){echo number_format(0,2); }else{echo number_format($fee_amount,2); }

                                                                }?>
                                                            </th>
                                                        </tr>
                                                        <?php if($studentData->term_name == 'II PUC') {
                                                        if($IPUCfee_amount > 0 ){?>
                                                        <tr class="bg-danger text-white">
                                                            <th class="text-left" scope="col">I PUC Pending Balance</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($IPUCfee_amount,2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } }?>
                                                        <?php if($studentData->cancel_bus_status == 1 || $studentData->cancel_bus_statusII == 1){ ?>
                                                        <tr class="bg-secondary text-white">
                                                            <th class="text-left" scope="col">Remark</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo "Bus Facility Cancelled"; ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                    </thead>

                                                </table>
                                             

                                            </div>

                                        </div>
                                    </div>

                                <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_CASHIER ){ ?>
                                   
                                    <div class="col-6">
                                        <div class="card border-success mb-1">
                                            <div class="card-header bg-transparent border-success"><?php echo $studentData->term_name; ?> Payment Info</div>
                                            <div class="card-body">
                                            <?php if($fee_amount != 0){ ?>
                                                <div class="form-group mb-1 mt-0">
                                                    <label for="usr">Transaction Date</label>
                                                    <input type="text" name="transaction_date" 
                                                        value="<?php echo date('d-m-Y'); ?>" class="form-control card_date"
                                                        Placeholder="Transaction Date" id="transaction_date_first"
                                                        autocomplete="off" readonly>
                                                </div>
                                                <div class="row mt-2">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                            
                                                                <input type="text" name="from_date" 
                                                                    class="form-control datepicker"
                                                                    Placeholder="Month From" id="from_date"
                                                                    autocomplete="off" >
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                
                                                                <input type="text" name="to_date" 
                                                                    class="form-control datepicker"
                                                                    Placeholder="Month To" id="to_date"
                                                                    autocomplete="off" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="month_difference">Months</label>
                                                        <input type="text" class="form-control" id="month_difference" readonly>
                                                    </div>
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control reference_receipt_no" id="receipt_number"
                                                        name="receipt_number" placeholder="Reference Receipt No."
                                                        onkeypress="return isNumberKey(event)" required
                                                        autocomplete="off" >
                                                        <h6 class="error-hint display-none receiptHide" style="color: red;">Receipt Number Already exists</h6>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" class="form-control " id="paid_amount"
                                                        name="paid_amount" placeholder="Paid Amount"
                                                        onkeypress="return isNumberKey(event)" required
                                                        autocomplete="off" >
                                                </div>
                                                <div class="form-group mb-1">
                                                    <select class="form-control text-dark" id="payment_type_select"
                                                        name="payment_type">
                                                        <option value="">Select Payment Type</option>
                                                        <option value="CASH">CASH</option>
                                                        <!-- <option value="BANK">BANK</option>-->
                                                        <option value="DD">DD</option>
                                                        <option value="CARD">CARD</option> 
                                                         <option value="UPI">UPI</option>
                                                    </select>
                                                </div>

                                                <button id="paymentInfoSubmit" style="float:right"
                                                    type="submit" class="btn btn-success btn-block mt-1">Submit</button>
                                            <?php }else{ ?>
                                                    <div class="text-success h4 text-center">Transport Fees Cleared!</div>
                                            <?php } ?>
                                            </div>

                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                <?php  }else{
                                            echo "<h5>Search by Student</h5>";
                                }
                                // }else{
                                //     echo "<h5 class='text-center'>No Pending payment</h5>"; ?>
                                    
                                    
                                <?php //} ?>
                                
                                <?php if(!empty($studentData)){ ?>
                                    <?php if($role == ROLE_PRIMARY_ADMINISTRATOR  || $role == ROLE_CASHIER){ ?>
                                    <!-- <div class="row"> -->
                                        <div class="col-6 table-responsive">
                                            <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr class="text-center table-success">
                                                    <th colspan="6">FEE PAID DETAILS</th>
                                                </tr>
                                                <tr class="text-center table-info">
                                                    <th>Date</th>
                                                    <!-- <th>Admission No</th> -->
                                                    <!-- <th>Class</th> -->
                                                    <!-- <th>Section</th> -->
                                                    <th>Receipt No.</th>
                                                    <!-- <th>Order ID.</th> -->
                                                    <th>Amount</th>
                                                    <th>Month From</th>
                                                    <th>Month To</th>
                                                    <!-- <th>Pending Amt</th> -->
                                                    <!-- <th>Payment Type</th> -->
                                                    <!-- <th>Bank</th> -->
                                                    <!-- <th>Bank Date</th> -->
                                                    <th width='120'>Action</th>
                                                </tr>
                                                <?php foreach($stdFeePaymentInfo as $fee){ ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->created_date_time)); ?></th>
                                                        <!-- <th class="text-center"><?php echo $fee->admission_no; ?></th> -->
                                                        <!-- <th class="text-center"><?php echo $fee->term_name; ?></th> -->
                                                        <!-- <th class="text-center"><?php echo $fee->section_name; ?></th> -->
                                                        <th class="text-center"><?php echo $fee->ref_receipt_no; ?></th>
                                                        <!-- <th class="text-center"><?php echo $fee->order_id; ?></th> -->
                                                        <th class="text-center"><?php echo $fee->bus_fees; ?></th>
                                                        <th class="text-center"><?php echo date('M-Y',strtotime($fee->from_date)); ?></th>
                                                        <th class="text-center"><?php echo date('M-Y',strtotime($fee->to_date)); ?></th>
                                                        <!-- <th class="text-center"><?php if($fee->pending_balance == 0){ ?>
                                                            <b style="color:green"><?php echo $fee->pending_balance; ?></b>
                                                            <?php }else{
                                                                ?>
                                                            <b style="color:red"><?php echo $fee->pending_balance; ?></b>
                                                            <?php
                                                            } ?></th> -->

                                                        <!-- <th class="text-center"><?php echo $fee->payment_type; ?></th> -->
                                                        <!-- <th class="text-center"><?php if($fee->bank_settlement_status == 1){
                                                            echo "<b class='color-green'>Settled</b>";
                                                        }else{
                                                            echo "<b class='color-red'>Pending</b>";
                                                        }  ?></th> -->
                                                        <!-- <th class="text-center"><?php if(!empty($fee->date)){
                                                                echo date('d-m-Y',strtotime($fee->date)); 
                                                            } ?> -->
                                                        </th>
                                                        <th>
                                                            <a href="<?php echo base_url(); ?>printStudentTransportBill/<?php echo $fee->row_id; ?>"
                                                                target="_blank">Receipt</a>
                                                            <a class="btn btn-xs btn-danger deleteFeeReceipt px-2 py-1" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                        </th>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    <!-- </div> -->
                                <?php } ?>
                                <!-- <div class="row">  -->
                                <?php if($studentData->term_name == 'II PUC') {
                                    if($IPUCfee_amount > 0 ){?>
                                <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_CASHIER ){ ?>
                                   
                                   <div class="col-6">
                                       <div class="card border-success mb-1">
                                           <div class="card-header bg-transparent border-success">I PUC Payment Info</div>
                                           <div class="card-body">
                                           <?php if($fee_amount != 0){ ?>
                                               <div class="form-group mb-1 mt-0">
                                                   <label for="usr">Transaction Date</label>
                                                   <input type="text" name="transaction_date" 
                                                       value="<?php echo date('d-m-Y'); ?>" class="form-control card_date"
                                                       Placeholder="Transaction Date" id="transaction_date_first1"
                                                       autocomplete="off" readonly>
                                               </div>
                                               <div class="row mt-2">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            
                                                            <input type="text" name="from_date" 
                                                                    class="form-control datepicker"
                                                                    Placeholder="Month From" id="from_date_IPUC"
                                                                    autocomplete="off" >
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                                
                                                            <input type="text" name="to_date" 
                                                                class="form-control datepicker"
                                                                Placeholder="Month To" id="to_date_IPUC"
                                                                autocomplete="off" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="month_difference">Months</label>
                                                    <input type="text" class="form-control" id="month_difference_IPUC" readonly>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control reference_receipt_no" id="receipt_number_IPUC"
                                                        name="receipt_number" placeholder="Reference Receipt No."
                                                        onkeypress="return isNumberKey(event)" required
                                                        autocomplete="off" >
                                                        <h6 class="error-hint display-none receiptHide" style="color: red;">Receipt Number Already exists</h6>
                                                </div>
                                               <div class="form-group mb-1">
                                                   <input type="text" class="form-control " id="paid_amount1"
                                                       name="paid_amount" placeholder="Paid Amount"
                                                       onkeypress="return isNumberKey(event)" required
                                                       autocomplete="off" >
                                               </div>
                                               <div class="form-group mb-1">
                                                   <select class="form-control text-dark" id="payment_type_select1"
                                                       name="payment_type">
                                                       <option value="">Select Payment Type</option>
                                                       <option value="CASH">CASH</option>
                                                        <!-- <option value="BANK">BANK</option>-->
                                                        <option value="DD">DD</option>
                                                        <option value="CARD">CARD</option> 
                                                         <option value="UPI">UPI</option>
                                                   </select>
                                               </div>

                                               <button id="IPUCpaymentInfoSubmit" style="float:right"
                                                   type="submit" class="btn btn-success btn-block mt-1">Submit</button>
                                           <?php }else{ ?>
                                                   <div class="text-success h4 text-center">Transport Fees Cleared!</div>
                                           <?php } ?>
                                           </div>

                                       </div>
                                   </div>
                                   <?php } ?>
                                    <?php } }?>
                                    <?php if(!empty($stdIPUCFeePaymentInfo)){ ?>
                                    <?php if($role == ROLE_PRIMARY_ADMINISTRATOR  || $role == ROLE_CASHIER){ ?>
                                        <div class="col-6 table-responsive">
                                            <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr class="text-center table-success">
                                                    <th colspan="7">I PUC FEE PAID DETAILS</th>
                                                </tr>
                                                <tr class="text-center table-info">
                                                    <th>Date</th>
                                                    <th>Receipt No.</th>
                                                    <th>Amount</th>
                                                    <th>Month From</th>
                                                    <th>Month To</th>
                                                    <th>Payment Type</th>
                                                    <th width='110'>Action</th>
                                                </tr>
                                                <?php foreach($stdIPUCFeePaymentInfo as $fee){ ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->payment_date)); ?></th>
                                                        <th class="text-center"><?php echo $fee->ref_receipt_no; ?></th>
                                                        <th class="text-center"><?php echo $fee->bus_fees; ?></th>
                                                        <th class="text-center"><?php echo date('M-Y',strtotime($fee->from_date)); ?></th>
                                                        <th class="text-center"><?php echo date('M-Y',strtotime($fee->to_date)); ?></th>
                                                        <th class="text-center"><?php echo $fee->payment_type; ?></th>
                                                        </th>
                                                        <th>
                                                            <a href="<?php echo base_url(); ?>printStudentTransportBill/<?php echo $fee->row_id; ?>"
                                                                target="_blank">Receipt</a>
                                                            <a class="btn btn-xs btn-danger deleteFeeReceipt px-2 py-1" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                        </th>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                    </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<div class="modal" id="installmentModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 7px 15px;">
                    <h4 class="modal-title">Add Bank Challan Details</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addFeeInstallment" action="<?php echo base_url() ?>addBusFeeChallan" method="post" role="form">
                        <div class="row form-contents">
                            <input type="hidden" name="application_no" value="<?php echo $application_number; ?>" />
                            <input type="hidden" name="student_row_id" value="<?php echo $student_row_id; ?>" />
                            <input type="hidden" name="from" value="1" />
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1">Bus Fee Amount <span class="text-danger required_star">*</span></label>
                                    <input type="text" class="form-control "
                                     id="annual_fee" value="" name="annual_fee" placeholder="Enter Bus Fee Amount" autocomplete="off" >
                                
                                </div>
                            </div>
                            <?php if($studentData->term_name == 'I PUC'){ ?>
                                <div class="col-lg-6">
                                    <div class="form-group mb-2">
                                    <label for="exampleInputEmail1">Term Name<span class="text-danger required_star"></span></label>
                                   
                                        <input type="text" class="form-control" name="term_name" value="<?php echo $studentData->term_name; ?>" readonly />
                                    </div>
                                </div>

                            <?php } else {?>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1">Term Name<span class="text-danger required_star">*</span></label>
                                    <select class="form-control text-dark" id="term_name_select" name="term_name">
                                        <option value="">Select Term Name</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>                 
                                    </select>
                                </div>
                            </div>
                            <?php }?>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                     <label for="exampleInputEmail1">Last date for payment<span class="text-danger required_star"></span></label>
                                    <input type="text" class="form-control required searchDatePicker" id="last_date"  name="last_date" placeholder="Last date for payment" autocomplete="off">
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer" style="padding: 7px 15px;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-success">Save</button>
                     </form>
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

                <form role="form" id="addFeePaymentInfo" action="<?php echo base_url() ?>addTransFeePaymentInfo"
                    method="post" role="form">

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Fee Amount</th>
                                        <td id="fee_amount_display"> <?php echo $fee_amount; ?></td>

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
                                        <th scope="row">Excess Fee</th>
                                        <td id="excess_fee_display"></td>
                                    </tr>
                                    <!-- <tr>
                                        <th scope="row">Payment Type</th>
                                        <td id="payment_type_display"></td>
                                    </tr> -->
                                </tbody>
                            </table>

                            <div class="card_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="tran_number" required
                                                class="form-control" Placeholder="Transaction Number" id="tran_number"
                                                autocomplete="off">
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
                                            <input type="text" name="tran_bank_name" Value="" required
                                                class="form-control" Placeholder="Enter Bank Name" id="tran_bank_name"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="dd_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="dd_number" required
                                                class="form-control" Placeholder="Enter DD Number" id="dd_number"
                                                autocomplete="off">
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
                                            <input type="text" name="dd_bank_name" class="form-control" required
                                                Placeholder="Enter Bank Name" id="dd_bank_name" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="bank_info">
                                <div class="row">
                                <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="bank_tran_number" required
                                                class="form-control" Placeholder="Bank Transaction Number" id="tran_number"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Date:</label>
                                            <input type="text" name="bank_tran_date" class="form-control" required
                                                Placeholder="Enter Transaction Date" id="transaction_date_bank" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="bank_name" class="form-control" required
                                                Placeholder="Enter Bank Name" id="tran_bank_name" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="neft_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Reference Number:</label>
                                            <input  type="text" name="ref_number" required
                                                class="form-control" Placeholder="Payment Ref Number" id="dd_number"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">NEFT Date:</label>
                                            <input type="text" name="neft_date" class="form-control" required
                                                Placeholder="Enter NEFT Date" id="neft_date" autocomplete="off">
                                        </div>
                                    </div>

                                  

                                </div>
                            </div>
                            <div class="upi_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">UPI Reference No:</label>
                                            <input type="text" name="upi_ref_no" required class="form-control"
                                                Placeholder="Enter UPI Reference No." id="upi_ref_no"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <div id="optional_fee_input"></div>
                    <input type="hidden" name="payment_date" id="payment_date_selected" value="" required />
                    <input type="hidden" name="student_row_id" value="<?php echo $studentData->row_id; ?>" required />
                    <input type="hidden" name="year" value="<?php echo $year; ?>" required />
                    <input type="hidden" id="paid_fee_amount" name="paid_fee_amount" value="" required />
                    <input type="hidden" id="term_name_selected" name="term_name_selected" value="" required />
                    <input type="hidden" id="payment_type_input" name="payment_type" value="" required />
                    <input type="hidden" name="month_diff" id="month_diff" value="" required />
                    <input type="hidden" name="month_from" id="date_from_selected" value="" required />
                    <input type="hidden" name="month_to" id="date_to_selected" value="" required />
                    <input type="hidden" id="receipt_no" name="receipt_no" value="" required />

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
 <div id="receiptEdit" class="modal" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header modal-call-report">
                    <div class=" col-md-10 col-10">
                        <span class="text-white mobile-title m-1" style="font-size : 20px">Edit Generated Date</span>
                    </div>
                    <div class=" col-md-2 col-2">
                        <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <!-- Modal body -->
                <div class="modal-body m-0 p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="updateFeeChallanDate" action="<?php echo base_url() ?>updateBusFeeChallanDate"
                        method="post" role="form">
                        <input type="hidden" name="row_id" id="row_id" value="" />
                        <input type="hidden" name="from" id="row_id" value="1" />
                        <div class="row">
                            <!-- <div class="col-12">
                                <div class="form-group">
                                    <label>Paid Amount</label>
                                    <input type="text" class="form-control " id="paid_amt"
                                        name="paid_amt" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Generated Date</label>
                                    <input type="text" class="form-control searchDatePicker" id="pay_date" name="pay_date" autocomplete="off" required>
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
jQuery(document).ready(function() {
    $('.receiptHide').hide();
    $('.reference_receipt_no').on('keyup', function(evt){
            let reference_receipt_no = $(this).val();
            let year = $('#year').val();
          //alert(reference_receipt_no);
            $('.receiptHide').hide();
            $.ajax({
                url: '<?php echo base_url(); ?>/getReceipt',
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
    jQuery(document).on("click", ".deleteFeeReceipt", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteFeeReceipt",
				currentRow = $(this);

			var confirmation = confirm("Are you sure delete this Receipt ?");

			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){

					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Fee Receipt successfully Deleted"); }
					else if(data.status = false) { alert("Failed to delete Receipt"); }
					else { alert("Access denied..!"); }
				});
			}

		});

        jQuery(document).on("click", ".deleteBusFeeChallan", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteBusFeeChallan",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this challan Info?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Record successfully deleted"); }
				else if(data.status = false) { alert("Record deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });
  
    $('.dd_info').hide();
    $('.card_info').hide();
    $('.bank_info').hide();
    $('.neft_info').hide(); 
    $('.upi_info').hide();

   // $('.loaderScreen').hide();

    
    // $("#searchStudentFeeInfo").click(function() {
    //     $('.loaderScreen').show();
    // });
    // $("#optionalFee").on('change', function() {
    //     alert(this.value);
    // });

    

 


      //slect payment method option change
      $("#paymentInfoSubmit").on('click', function() {
        var fee_amount = '<?php echo $fee_amount; ?>';
        var term_name = '<?php echo $studentData->term_name; ?>';
        var paid_amount_display = Number($('#paid_amount').val());
        var transaction_date = $('#transaction_date_first').val();
        var month_difference = $('#month_difference').val();
        var payment_type = $('#payment_type_select').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var receipt_number = $('#receipt_number').val();

        if (from_date == "") {
            alert("Please Select From Date");
            return;
        }else if (to_date == "") {
            alert("Please Select To Date");
            return;
        }else if (receipt_number == "") {
            alert("Please Enter Receipt No.");
            return;
        }else if (paid_amount_display == "") {
            alert("Please Enter Paid Amount");
            return;
        }else if (transaction_date == "") {
            alert("Please Select Transaction Date");
            return;
        }else if (payment_type == "") {
            alert("Please Select Payment Type");
            return;
        }
       
        
        // alert(payment_type);
        if (payment_type == "DD") {
            $('.dd_info').show();
            $('.card_info').hide();
            $('.bank_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "BANK") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.bank_info').show();
            $('.neft_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "CASH") {
            $('.dd_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        }else if (payment_type == "CARD") {
            $('.dd_info').hide();
            $('.card_info').show();
            $('.bank_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        }else if (payment_type == "NEFT") {
            $('.dd_info').hide();
            // $('.card_info').hide();
            $('.neft_info').show();
            $('.upi_info').hide();
        }else if (payment_type == "UPI") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.bank_info').hide();
            $('.upi_info').show();
        }else{
            $('.dd_info').hide();
            // $('.card_info').hide();
            $('.bank_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        }
        var optional_amt = 0;
        var fee_optional_input = "";
       
        //alert(optional_amt);
       // fee_amount = optional_amt + fee_amount;
     //   paid_amount_display = optional_amt + paid_amount_display;
        var pending_fee_amount = fee_amount - paid_amount_display;

        if (pending_fee_amount < 0) {
            var excess_amount = pending_fee_amount;
        } else {
            var excess_amount = 0;
        }
        $('#fee_amount_display').html(fee_amount);
        $('#paid_amount_display').html(paid_amount_display);
        $('#pending_fee_display').html(pending_fee_amount);
        $('#excess_fee_display').html(excess_amount);
        $('#payment_type_display').html(payment_type);

        $('#paid_fee_amount').val(paid_amount_display);
        $('#payment_type_input').val(payment_type);
       
        $('#month_diff').val(month_difference);
        $('#date_from_selected').val(from_date);
       
       $('#date_to_selected').val(to_date);
        $('#payment_date_selected').val(transaction_date);
        $('#receipt_no').val(receipt_number);
        $('#term_name_selected').val(term_name);
        $('#myReportModal').modal('show');
    });

    $("#IPUCpaymentInfoSubmit").on('click', function() {
        var fee_amount = '<?php echo $IPUCfee_amount; ?>';
        var paid_amount_display = Number($('#paid_amount1').val());
        var transaction_date = $('#transaction_date_first1').val();
        var month_difference = $('#month_difference_IPUC').val();
        var payment_type = $('#payment_type_select1').val();
        var from_date = $('#from_date_IPUC').val();
        var to_date = $('#to_date_IPUC').val();
        var receipt_number = $('#receipt_number_IPUC').val();

        if (from_date == "") {
            alert("Please Select From Date");
            return;
        }else if (to_date == "") {
            alert("Please Select To Date");
            return;
        }if (paid_amount_display == "") {
            alert("Please Enter Paid Amount");
            return;
        }else if (transaction_date == "") {
            alert("Please Select Transaction Date");
            return;
        }else if (payment_type == "") {
            alert("Please Select Payment Type");
            return;
        }else if (receipt_number == "") {
            alert("Please Enter Receipt No.");
            return;
        }
       
        
        // alert(payment_type);
        if (payment_type == "DD") {
            $('.dd_info').show();
            $('.card_info').hide();
            $('.bank_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "BANK") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.bank_info').show();
            $('.neft_info').hide();
            $('.upi_info').hide();
        } else if (payment_type == "CASH") {
            $('.dd_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        }else if (payment_type == "CARD") {
            $('.dd_info').hide();
            $('.card_info').show();
            $('.bank_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        }else if (payment_type == "NEFT") {
            $('.dd_info').hide();
            // $('.card_info').hide();
            $('.neft_info').show();
            $('.upi_info').hide();
        }else if (payment_type == "UPI") {
            $('.dd_info').hide();
            $('.card_info').hide();
            $('.bank_info').hide();
            $('.upi_info').show();
        }else{
            $('.dd_info').hide();
            // $('.card_info').hide();
            $('.bank_info').hide();
            $('.neft_info').hide();
            $('.upi_info').hide();
        }
        var optional_amt = 0;
        var fee_optional_input = "";
       
        //alert(optional_amt);
       // fee_amount = optional_amt + fee_amount;
     //   paid_amount_display = optional_amt + paid_amount_display;
        var pending_fee_amount = fee_amount - paid_amount_display;

        if (pending_fee_amount < 0) {
            var excess_amount = pending_fee_amount;
        } else {
            var excess_amount = 0;
        }
        $('#fee_amount_display').html(fee_amount);
        $('#paid_amount_display').html(paid_amount_display);
        $('#pending_fee_display').html(pending_fee_amount);
        $('#excess_fee_display').html(excess_amount);
        $('#payment_type_display').html(payment_type);

        $('#paid_fee_amount').val(paid_amount_display);
        $('#payment_type_input').val(payment_type);
       
        $('#term_name_selected').val('I PUC');
        $('#payment_date_selected').val(transaction_date);
        $('#month_diff').val(month_difference);
        $('#date_from_selected').val(from_date);
       $('#date_to_selected').val(to_date);
       $('#receipt_no').val(receipt_number);
        
        $('#myReportModal').modal('show');
    });

    jQuery('#transaction_date, #transaction_date_first, .dateSearch, #tran_date, #dd_date, #transaction_date_bank,.card_date').datepicker({
        autoclose: true,
        orientation: "top",
        format: "dd-mm-yyyy"

    });

    $(".proceedFeePaymentInfoButton").click(function() {
        if($( "#addFeePaymentInfo" ).valid()){
        // $('.loaderScreen').show();
        $('#myReportModal').modal('hide')
        }
      
    });
    jQuery('#transaction_date, .dateSearch, #tran_date, #dd_date, #neft_date').datepicker({
        autoclose: true,
        orientation: "top",
        format: "dd-mm-yyyy"

    });

    jQuery('.searchDatePicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
       // startDate : "01-04-2023"
    });
});

function openModel(row_id, pay_date) {
    $('#row_id').val(row_id);
    // $('#paid_amt').val(paid_amount);
    var yourString = String(pay_date);
    var result = yourString.substring(1, yourString.length-1);
    $('#pay_date').val(result);
    $('#receiptEdit').modal('show');
}

function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 &&
      (charCode < 48 || charCode > 57))
      return false;
  return true;
}

$(document).ready(function() {
    $('#from_date_IPUC, #to_date_IPUC').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        dateFormat: "MM yy",
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            calculateMonthDifference($('#from_date_IPUC').val(), $('#to_date_IPUC').val(), $('#month_difference_IPUC'));
        }
    });
    // Initialize datepickers for the second set
    $('#from_date, #to_date').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        dateFormat: "MM yy",
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            calculateMonthDifference($('#from_date').val(), $('#to_date').val(), $('#month_difference'));
        }
    });
        $('.ui-datepicker-calender').css("display","none");

        function calculateMonthDifference(fromDate, toDate, monthField) {
            var fromDate = new Date(fromDate);
            var toDate = new Date(toDate); 
            
            if (fromDate && toDate) {     
                var months = (toDate.getFullYear() - fromDate.getFullYear()) * 12 + (toDate.getMonth() - fromDate.getMonth())
                monthField.val((months +1));
            } else {
                monthField.val(""); // Clear the field if dates are not selected
            }
        }
        
    });
</script>