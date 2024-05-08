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

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                    <form action="<?php echo base_url(); ?>viewStudentTransportListing" method="POST" id="byFilterMethod">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                <i class="material-icons">group</i> Transport Payment Info
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total : <?php echo $totalStudentTransportCount; ?></b>
                            </div>
                            <div class="col-lg-2 input-group float-right">
                                <select class="form-control" name="year" id="year">
                                    <?php if(!empty($year)){ ?>
                                    <option value="<?php echo $year; ?>" selected><b><?php echo $year; ?></b>
                                    </option>
                                    <?php } ?>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                              
                                </select>
                                <div class="form-group">
                                    <button class="btn btn-success border_left_radius" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white "
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <!-- <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                    href="<?php echo base_url(); ?>addNewStudentTransport"><i class="fa fa-plus"></i>
                                    Add New</a> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                      
                                <tr class="filter_row" class="text-center">
                                   
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                             <select  class="form-control selectpicker" data-live-search="true" id="student_id" name="student_id" placeholder="By Student Id">
                                            <?php if(!empty($student_id)){?>
                                            <option value="<?php echo $student_id; ?>" selected>Selected:<?php echo $student_id; ?></option>     
                                            <?php }?>
                                             <option value="">Select Student Id</option>
                                                            <?php if(!empty($studentInfo)){
                                                        foreach($studentInfo as $std){ ?>
                                                    <option value="<?php echo $std->student_id; ?>"><?php echo $std->student_id; ?></option>
                                                    <?php } } ?>
                                            </select>
                                        </div>
                                    </td> -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $payment_date; ?>" name="payment_date" id="payment_date" class="form-control input-sm datepicker" placeholder="Search From Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $receipt_no; ?>" name="receipt_no" id="receipt_no" class="form-control input-sm" placeholder="By Receipt No." autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name" class="form-control input-sm" placeholder="By Student Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                        <select id="bus_number" name="bus_number" class="form-control" placeholder="By Vehicle Number">
                                        <?php if(!empty($bus_number)){?>
                                        <option value="<?php echo $bus_number; ?>" selected>Selected:<?php echo $bus_number; ?></option>     
                                        <?php }?>
                                             <option value="">Select Vehicle Number</option>
                                                            <?php if(!empty($busInfo)){
                                                        foreach($busInfo as $bus){ ?>
                                                    <option value="<?php echo $bus->vehicle_number; ?>"><?php echo $bus->vehicle_number; ?></option>
                                                    <?php } } ?>
                                            </select>
                                        </div>
                                    </td> -->
                                    <?php if($year == CURRENT_YEAR){ ?>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $payment_date; ?>" name="date_from" id="date_from" class="form-control input-sm datepicker" placeholder="Search Month From" autocomplete="off">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $payment_date; ?>" name="date_to" id="date_to" class="form-control input-sm datepicker" placeholder="Search Month To" autocomplete="off">
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="form-group mb-0">
                                           
                                            <select class="form-control " name="route_from" id="route" >
                                                <?php if(!empty($by_class)){ ?>
                                                    <option value="<?php echo $route_from; ?>" selected><b>Selected: <?php echo $route_from; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Route</option>
                                                <?php if(!empty($routeInfo)){
                                                    foreach($routeInfo as $route){ ?>
                                                        <option value="<?php echo $route->name; ?>"><?php echo $route->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $bus_no; ?>" name="bus_no" id="bus_no" class="form-control input-sm datepicker" placeholder="Search Bus No." autocomplete="off">
                                        </div>
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <div class="form-group mb-0">
                                        <select class="form-control text-dark" id="payment_type"
                                                    name="payment_type" value="<?php echo $payment_type  ?>">
                                                    <option value=""> Payment Type</option>
                                                    <option value="CASH">CASH</option>
                                                    <option value="BANK">BANK</option>
                                                    <option value="DD">DD</option>
                                                    <option value="CARD">CARD</option>
                                                    <option value="UPI">UPI</option>
                                                </select>
                                        </div>
                                    </td>

                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $route_to; ?>" name="route_to" id="route_to" class="form-control input-sm" placeholder="By Route From" autocomplete="off">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $from_date; ?>" name="from_date" id="from_date" class="form-control input-sm datepicker" placeholder="Search From Date" autocomplete="off">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $to_date; ?>" name="to_date" id="to_date" class="form-control input-sm datepicker" placeholder="Search From Date" autocomplete="off">
                                        </div>
                                    </td> -->
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                    <th class="text-center">Payment Date</th>
                                    <th class="text-center">Receipt No.</th>
                                    <th class="text-center">Student ID</th>
                                    <th class="text-center">Name</th>
                                    <!-- <th class="text-center">Vehicle Number</th> -->
                                    <?php if($year == CURRENT_YEAR){ ?>
                                    <th class="text-center">Month From</th>
                                    <th class="text-center">Month To</th>
                                  
                                    <th class="text-center">Route</th>
                                    <th class="text-center">Bus No.</th>
                                    <?php } ?>
                                    <th class="text-center">Payment Type</th>
                                    <!-- <th class="text-center">From Date</th>
                                    <th class="text-center">To Date</th> -->
                                    <th class="text-center" width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentTransportInfo)){
                                    foreach($studentTransportInfo as $trans){ ?>
                                    <tr>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($trans->payment_date)); ?></th>
                                        <th class="text-center"><?php echo $trans->ref_receipt_no; ?></th>
                                        <th class="text-center"><?php echo $trans->student_id; ?></th>
                                         <th><?php echo strtoupper($trans->student_name); ?></th>
                                        <!-- <th class="text-center"><?php echo $trans->vehicle_number; ?></th> -->
                                        <?php if($year == CURRENT_YEAR){ ?>
                                        <th class="text-center"><?php echo date('M-Y',strtotime($trans->from_date)); ?></th>
                                        <th class="text-center"><?php echo date('M-Y',strtotime($trans->to_date)); ?></th>
                                       
                                        <th><?php echo $trans->route_name; ?></th>
                                        <th class="text-center"><?php echo $trans->bus_no; ?></th>
                                        <?php } ?>
                                        <th class="text-center"><?php echo $trans->payment_type; ?></th>
                                        
                                        <!-- <th><?php echo $trans->route_to; ?></th> -->
                                       
                                        <th class="text-center">
                                           <!-- <a href="#" class="btn btn-xs btn-success" title="<b>Bus Fees :</b>" data-toggle="popover" data-placement="left"  data-trigger="focus" data-content="<b><?php echo $trans->rate; ?></b>"><i class="fa fa-info"></i></a> -->
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN){ ?>
                                                    <!-- <a class="btn btn-xs btn-info" href="<?php echo base_url().'editStudentTransport/'.$trans->row_id; ?>" title="Edit"><i class="fas fa-pencil-alt"></i></a> -->
                                                    <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo base_url().'printStudentTransportBill/'.$trans->row_id; ?>" title="Print Receipt"><i class="fas fa-print"></i></a>
                                                    <?php } if($role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){ ?>
                                                    <!-- <a class="btn btn-xs btn-danger deleteStudentTransport" href="#" data-row_id="<?php echo $trans->row_id; ?>" title="Delete Transport"><i class="fa fa-trash"></i></a> -->
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="10" class="text-center">Transport Payment Record Not Found</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/transport.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewStudentTransportListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery(' .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: false,
            dateFormat: "MM yy",
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                calculateMonthDifference();
            }

            // $('.ui-datepicker-calender').css("display","none");

        });
        $('.ui-datepicker-calender').css("display","none");

    $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
    $('[data-toggle="popover"]').mouseenter(function(){
        $(this).trigger('focus');
    });


   
});
</script>