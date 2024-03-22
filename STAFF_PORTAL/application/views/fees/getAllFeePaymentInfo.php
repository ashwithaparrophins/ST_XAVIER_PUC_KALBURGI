<style>
.table_search_th {
    padding: 0px !important;

}

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
                        <form action="<?php echo base_url(); ?>getAllFeePaymentInfo" method="POST" id="byFilterMethod">
                            <div class="row c-m-b">
                                <div class="col-lg-2 col-12 col-md-5 box-tools">
                                    <span class="page-title">
                                        <i class="material-icons">book</i> Fee Paid Info
                                    </span>
                                </div>
                                <div class="col-lg-2 col-12 col-md-3 box-tools ">
                                    <span class="page-title float-right">
                                        Total Receipt: <b><?php echo $online_pay_count; ?></b>
                                    </span>
                                </div>
                                <div class="col-lg-3 col-md-5 col-12">
                               
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            </div>
                                        <input type="text" value="<?php echo date('d-m-Y',strtotime($date_from_filter)); ?>"
                                            class="form-control rounded datepicker" id="" name="date_from_filter"
                                            placeholder="Date From" style="font-weight:500;color:black;" aria-label="Search"
                                            aria-describedby="search-addon" autocomplete="off" />
                                        
                                    <div class="input-group-prepend">
                                        <!-- <span class="input-group-text" id="basic-addon1"><b>To Date</b></span> -->
                                        </div>
                                    <input type="text" value="<?php echo date('d-m-Y',strtotime($date_to_filter)); ?>"
                                        class="form-control rounded datepicker" id="" name="date_to_filter"
                                        placeholder="Date To" style="font-weight:500;color:black;" aria-label="Search"
                                        aria-describedby="search-addon" autocomplete="off" />
                                    
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-2 input-group float-right">
                                    <select class="form-control" name="year" id="year">
                                        <?php if(!empty($year)){ ?>
                                        <option value="<?php echo $year; ?>" selected><b><?php echo $year; ?></b>
                                        </option>
                                        <?php } ?>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                              
                                    </select>
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit">Search</button>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-5 col-12">



                                    <!-- <a class="btn btn-danger mobile-btn float-right border_right_radius" href="#"
                                        data-toggle="modal" data-target="#orderIDProcesse" id="orderID"><i
                                            class="fas fa-university"></i>
                                        Re-Adm Order ID Process</a>
                                        <a class="btn btn-danger mobile-btn float-right border_right_radius" href="#"
                                        data-toggle="modal" data-target="#neworderIDProcesse" id="orderID"><i
                                            class="fas fa-university"></i>
                                        New-Adm Order ID Process</a> -->

                                    <a class="btn btn-success mobile-btn float-right" href="#"
                                        id="addBankSettlement"><i class="fa fa-university"></i>
                                        Bank Settlement</a>
                                    <!-- <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_radius_none"
                                        data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                      
                                    <a class="btn btn-success mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#feeDetailedPaidReport"><i class="fa fa-plus"></i>
                                    Fee Paid Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="btn btn-primary mobile-btn  border_right_radius" href="#"
                                    data-toggle="modal" data-target="#downloadReportStructureWiseII"><i class="fa fa-plus"></i>
                                    Fee Structure Wise Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="btn btn-info mobile-btn  border_right_radius" href="#"
                                    data-toggle="modal" data-target="#myReportModal"><i class="fa fa-plus"></i>
                                    Bank Report</a>
                                    </div>
                                    </div> -->

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table class="table table-bordered text-dark mb-0">
                            <thead class="text-center">

                                <tr>
                                    <td class="p-0 table_search_th"></td>
                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <input type="text" value="<?php echo $date_select;  ?>" name="date_select"
                                                class="form-control" Placeholder="Select Date" id="date_select"
                                                autocomplete="off" />
                                        </div>
                                    </td>
                                    <!-- <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <input type="text" value="<?php echo $application_no;  ?>"
                                                name="application_no" class="form-control" Placeholder="Application No."
                                                id="application_no" maxlength="10" autocomplete="off" />
                                        </div>
                                    </td> -->
                                    <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input type="text" value="<?php echo $student_id;  ?>" name="student_id"
                                                    class="form-control" Placeholder="Student Id." id="student_id"
                                                    maxlength="8" autocomplete="off" />
                                            </div>
                                        </td>
                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <input onkeypress="return isNumberKey(event)" type="text"
                                                value="<?php echo $receipt_number;  ?>" name="receipt_number"
                                                class="form-control" Placeholder="Receipt Number" id="receipt_number"
                                                autocomplete="off" />
                                        </div>
                                    </td>
                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <input type="text" value="<?php echo $order_id;  ?>" name="reference_number"
                                                class="form-control" Placeholder="Order ID Number" id="reference_number"
                                                autocomplete="off" />
                                        </div>
                                    </td>


                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <input onkeypress="return isNumberKey(event)" type="text"
                                                value="<?php echo $amount_paid  ?>" name="amount_paid"
                                                class="form-control" Placeholder="Amount Paid" id="amount_paid"
                                                autocomplete="off" />
                                        </div>
                                    </td>
                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <input onkeypress="return isNumberKey(event)" type="text"
                                                value="<?php echo $amount_pending  ?>" name="amount_pending"
                                                class="form-control" Placeholder="Amount Pending" id="amount_pending"
                                                autocomplete="off" />
                                        </div>
                                    </td>
                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <select class="form-control text-dark" id="payment_type" name="payment_type"
                                                value="<?php echo $payment_type  ?>">
                                                <option value=""> Payment Type</option>
                                                <option value="ONLINE">ONLINE</option>
                                                <option value="CASH">CASH</option>
                                                <option value="DD">DD</option>
                                                <option value="CARD">CARD</option>
                                                <option value="UPI">UPI</option>
                                            </select>
                                        </div>
                                    </td>

                                    <td class="p-0 table_search_th">
                                        <div class="form-group m-0">
                                            <select class="form-control text-dark" id="payment_type"
                                                name="bank_settlement">
                                                <option value=""> By Settlement </option>
                                                <option value="">ALL</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Settled">Settled</option>

                                            </select>
                                        </div>
                                    </td>
                                    <td class=" table_search_th">
                                        <div class="form-group m-0">
                                            <input type="text" value="<?php echo $by_bank_date;  ?>" name="by_bank_date"
                                                class="form-control bank_date_search" Placeholder="Select Bank Date"
                                                id="by_bank_date" autocomplete="off" />
                                        </div>
                                    </td>
                                    <td class="p-0 table_search_th">
                                        <button id="filterButton" type="submit"
                                            class="btn btn-success btn-block mobile-width">
                                            Search</button>
                                    </td>
                                </tr>
                                </form>
                                <tr class="table_row_background">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Date</th>
                                    <!-- <th>Application No.</th> -->
                                    <th>Student ID</th>
                                    <th>Receipt No.</th>
                                    <th>Order ID.</th>

                                    <th>Amount</th>
                                    <th>Pending Amt</th>
                                    <th>Payment Type</th>
                                    <th>Bank</th>
                                    <th>Bank Date</th>
                                    <th>Action</th>
                                </tr>
                                <?php if(!empty($feePaidInfo)){
                                foreach($feePaidInfo as $online){ ?>
                                <tr class="text-dark">
                                    <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $online->row_id; ?>" /></th>
                                    <td><?php echo date('d-m-Y',strtotime($online->payment_date)); ?></td>
                                    <!-- <td><?php echo $online->application_no; ?></td> -->
                                    <td><?php echo $online->student_id; ?></td>
                                    <td class="text-center"><?php echo  $online->ref_receipt_no; ?></td>
                                    <td><?php echo $online->order_id; ?></td>
                                    <td><?php echo $online->paid_amount; ?></td>
                                    <td><?php if($online->pending_balance == 0){ ?>
                                        <b style="color:green"><?php echo $online->pending_balance; ?></b>
                                        <?php }else{
                                            ?>
                                        <b style="color:red"><?php echo $online->pending_balance; ?></b>
                                        <?php
                                        } ?>
                                    </td>

                                    <td><?php echo $online->payment_type; ?></td>
                                    <td><?php if($online->bank_settlement_status == 1){
                                        echo "<b class='color-green'>Settled</b>";
                                    }else{
                                        echo "<b class='color-red'>Pending</b>";
                                    }  ?></td>
                                    <td><?php if(!empty($online->date)){
                                        echo date('d-m-Y',strtotime($online->date)); 
                                    }
                                    ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $online->row_id; ?>"
                                            target="_blank">Receipt</a>
                                    </td>

                                </tr>
                                <?php } }else{ ?>
                                <tr class="text-dark">
                                    <td colspan="11" style="background-color: #e3cfff;">Fee info not found</td>
                                </tr>
                                <?php } ?>
                            </thead>
                        </table>

                        <div class="box-footer clearfix">
                            <?php echo $this->pagination->create_links(); ?>
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
                <h4 class="modal-title">Download Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">

                <form role="form" id="addSchoolInfo" action="<?php echo base_url() ?>downloadOverallFeeReportIIPUC"
                    method="post" role="form">

                    <div class="row form-contents">
                        <div class="col-4">
                            <div class="form-group mb-0">
                                <label for="term_name_select">Term Name</label>
                                <select class="form-control" name="term_name" id="term_name_select" required>
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">By Student</label>
                                <select class="form-control selectpicker" name="by_student" id="by_student"
                                    data-live-search="true" required>
                                    <option value="ALL">ALL</option>
                                    <?php if(!empty($feePaidStdInfo)){ 
                                    foreach($feePaidStdInfo as $std){ ?>
                                    <option value="<?php echo $std->application_no; ?>">
                                        <?php echo $std->student_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">By Bank Account</label>
                                <select class="form-control selectpicker" name="bank_account" id="bank_account"
                                    data-live-search="true" required>
                                    <option value="">Select Fee Account Type</option>
                                    <option value="ALL">ALL</option>
                                    <?php if(!empty($bankAccInfo)){ 
                                    foreach($bankAccInfo as $acc){ ?>
                                    <option value="<?php echo $acc->row_id; ?>">
                                        <?php echo $acc->account_no; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Report Type</label>
                                <select class="form-control selectpicker" name="report_type" id="report_type"
                                    data-live-search="true" required>
                                    <option value="">Select Report Type</option>
                                    <option value="BYSTUDENT">By Student Wise</option>
                                    <option value="DATEWISE">By Date Wise</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Bank Settlement</label>
                                <select class="form-control" name="bank_settlement" id="bank_settlement"
                                    data-live-search="true" required>
                                    <option value="ALL">ALL</option>

                                    <option value="SETTLED">Only Settled</option>
                                    <option value="NOT_SETTLED">Not Settled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 dateSearchShow">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from" name="date_from"
                                    placeholder="Select Date From" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to" name="date_to"
                                    placeholder="Select Date To" autocomplete="off">
                            </div>
                        </div>


                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" form="addSchoolInfo" class="btn btn-success float-right" value="Download" />
            </div>

        </div>
    </div>
</div>



<!-- The Modal for bank settlement-->
<div class="modal" id="bankSettlementModel">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Fee Bank Settlement</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">

                <div class="row">

                    <div class="col-lg-12">
                        <span id="alertMsg"></span>
                        <b>Total Receipts Selected: <span id="totalReceipt"></span></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Settlement Date</label>
                            <input readonly type="text" id="settle_date_bank" name="settle_date" class="form-control"
                                value="" required></input>
                        </div>
                    </div>
                </div>


                <!-- Modal footer -->
                <div class="modal-footer" style="padding:5px;">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" id="addBankSettlementSubmit" class="btn btn-success">Send</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>




<!-- donload fee Structure report filter modal -->
<div class="modal" id="downloadReportStructureWiseII">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Detailed Fee Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">

                <form role="form" id="downloadReportStructure"
                    action="<?php echo base_url() ?>downloadReportStructureWiseII" method="post" role="form">

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

                        <div class="col-4">
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
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Report Type</label>
                                <select class="form-control selectpicker" name="report_type" id="report_type_structure"
                                    data-live-search="true" required>
                                    <option value="">Select Report Type</option>
                                    <!-- <option value="BYSTUDENT">By Student Wise</option> -->
                                    <option value="MONTHWISE">By Month Wise</option>
                                    <option value="DATEWISE">By Date Wise</option>

                                </select>
                            </div>
                        </div>
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
                                    placeholder="Select Date From" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to" name="date_to"
                                    placeholder="Select Date To" autocomplete="off">
                            </div>
                        </div>


                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" form="downloadReportStructure" class="btn btn-success float-right"
                    value="Download" />
            </div>

        </div>
    </div>
</div>




<!-- The Modal for  applicationAdmittedReport-->
<div class="modal" id="feeDetailedPaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">II PUC Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="" action="<?php echo base_url(); ?>download_II_PUC_StudentFeePaidReport">


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

                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Payment Type</label>
                            <select class="form-control input-md required" id="" name="payment_type">
                                <option value="">ALL</option>
                                <option value="FULL">Full Payment</option>
                                <option value="HALF">Half Payment</option>
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



<!-- The Modal for bank settlement-->
<div class="modal" id="orderIDProcesse">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Order Id status check</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" action="<?php echo base_url() ?>reAdmissionOrderIdProcess">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Enter Order ID</label>
                                <!-- <input type="text" style="text-transform:uppercase" placeholder="Enter Order ID"
                                    id="order_id" name="order_id" class="form-control" value="" required></input> -->
                                    <select class="form-control selectpicker" data-live-search="true" name="order_id" required>
                                        <option value="">Select Order ID to process</option>
                                            <?php if (!empty($orderIDInfo)) {
                                                foreach ($orderIDInfo as $oid) {  ?>
                                                <option value="<?php echo $oid->order_id; ?>">
                                                <b><?php echo $oid->order_id; ?></b></option>
                                        <?php }
                                        } ?>
                                    </select>
                            </div>

                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="orderIDProcess" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>

<div class="modal" id="neworderIDProcesse">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Order Id status check</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" action="<?php echo base_url() ?>newAdmissionOrderIdProcess">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Enter Order ID</label>
                                <!-- <input type="text" style="text-transform:uppercase" placeholder="Enter Order ID"
                                    id="order_id" name="order_id" class="form-control" value="" required></input> -->
                                    <select class="form-control selectpicker" data-live-search="true" name="order_id" required>
                                        <option value="">Select Order ID to process</option>
                                            <?php if (!empty($neworderIDInfo)) {
                                                foreach ($neworderIDInfo as $oid) {  ?>
                                                <option value="<?php echo $oid->order_id; ?>">
                                                <b><?php echo $oid->order_id; ?></b></option>
                                        <?php }
                                        } ?>
                                    </select>
                            </div>

                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="orderIDProcess" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('#alertMsg').html('');
    $('.dateSearchShow').hide();
    $('.dateSearchShowStructure').hide();
    jQuery('ul.pagination li a').click(function(e) {
        $('.loaderScreen').show();
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getAllFeePaymentInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    $("#report_type").on('change', function() {
        var report_type = $('#report_type').val();
        if (report_type == 'DATEWISE') {
            $('.dateSearchShow').show();
        } else {
            $('.dateSearchShow').hide();
        }
    });

    $("#report_type_structure").on('change', function() {
        var report_type = $('#report_type_structure').val();
        if (report_type == 'DATEWISE') {
            $('.dateSearchShowStructure').show();
        } else {
            $('.dateSearchShowStructure').hide();
        }
    });



    jQuery('#date_select, .dateSearch, #date_from, #date_to, #settle_date_bank, .bank_date_search').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    $('#filterButton').click(function() {
        $('.loaderScreen').show();
    });
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    $('#addBankSettlement').click(function() {
        var receipt_number = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select Minimum one Fee payment for Bank settlement!");
            return;
        } else {
            $('#totalReceipt').html($('.singleSelect:checkbox:checked').length);
            $('#bankSettlementModel').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            receipt_number.push($(this).val());
        });
    });


    $('#addBankSettlementSubmit').click(function() {
        var receipt_number = [];
        if ($('#settle_date_bank') == "") {
            $('#alertMsg').html(`<div class="alert alert-danger" role="alert">
          Please select Settlement date !
        </div>`);
        } else {
            $('#alertMsg').html('Please wait..');
            //$('#shortListModelView').modal('show');
            $('.singleSelect:checked').each(function(i) {
                receipt_number.push($(this).val());
            });
            $.ajax({
                url: baseURL + '/addBankSettlementSubmit',
                type: 'POST',
                data: {
                    receipt_number: JSON.stringify(receipt_number),
                    date: $('#settle_date_bank').val(),
                },
                success: function(data) {
                    if (data == 'success') {
                        $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  Bank Settled Successfully!
                  </div>`);
                    } else {
                        $('#alertMsg').html(`<div class="alert alert-error" role="alert">
                  Problem in bank Settlement!
                  </div>`);
                    }
                },
                error: function(result) {
                    $('#alertMsg').html('');
                    alert("Retry Again! Something Went Wrong");
                },
                fail: (function(status) {
                    $('#alertMsg').html('');
                    alert("Retry Again! Something Went Wrong");
                }),
                beforeSend: function(d) {
                    $('#alertMsg').html('Loading..');
                }
            });
        }
    });
});
</script>