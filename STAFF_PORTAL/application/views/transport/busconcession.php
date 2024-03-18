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

    <strong>Error!</strong> 

    <?php echo $this->session->flashdata('error'); ?>

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

<?php

        $warning = $this->session->flashdata('warning');

        if ($warning) {

        ?>

<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

        <span aria-hidden="true">×</span>

    </button>

    <i class="fa fa-check mx-2"></i>

    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>

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

                        <div class="row c-m-b">

                            <div class="col-lg-5 col-12 col-md-5 box-tools">

                                <span class="page-title">

                                    <i class="fas fa-rupee-sign"></i> Bus Concession

                                </span>

                            </div>

                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">

                                <b class="text-dark" style="font-size: 20px;">Total Students: <?php echo $totalCount; ?></b>

                            </div>

                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">

                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                                    <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#" data-toggle="modal" data-target="#concessionModal">

                                        <i class="fa fa-plus"></i> Add New</a>

                            

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

                        <form action="<?php echo base_url(); ?>viewBusFeeConcession" method="POST" id="byFilterMethod">

                                <tr class="filter_row" class="text-center">

                                    <td>

                                        <div class="form-group mb-0">

                                            <select class="form-control text-dark" id="year"
                                                    name="year" value="<?php echo $year;  ?>">
                                                    <?php if(!empty($year)){ ?>
                                                    <option value="<?php echo $year; ?>" selected><b>Selected: <?php echo $year; ?></b></option>
                                                <?php } ?>
                                                <option value="">Select Year</option>
                                                <!-- <option value="2024">2024</option> -->
                                                <option value="2023">2023</option>
                                            </select>

                                        </div>

                                    </td>

                                    <td>

                                        <div class="form-group mb-0">

                                            <input type="text" name="admission_no" value="<?php echo $admission_no ?>" id="admission_no" class="form-control input-sm" placeholder="Student ID" autocomplete="off">

                                        </div>

                                    </td>

                                    <td>

                                        <div class="form-group mb-0">

                                            <input type="text" name="by_name" id="by_name" value="<?php echo $by_name  ?>" class="form-control input-sm" placeholder="Name" autocomplete="off">

                                        </div>

                                    </td>

                                    <td>

                                        <div class="form-group mb-0">

                                            <input type="text" name="amount" id="amount" value="<?php echo $amount ?>" class="form-control input-sm" placeholder="Amount" autocomplete="off">

                                        </div>

                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" name="concession_from" value="<?php echo $concession_from ?>" id="concession_from" class="form-control input-sm datepicker" placeholder="Concession from" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" name="concession_to" value="<?php echo $concession_to  ?>" id="concession_to" class="form-control input-sm datepicker" placeholder="Concession To" autocomplete="off">
                                        </div>
                                    </td> -->
                                    <td>

                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>

                                    </td>

                                </tr>

                            </form>

                            <thead>

                                <tr class="text-center table_row_background">

                                    <!-- <th><input type="checkbox" id="selectAll" /></th> -->
                                    <th>Year</th>

                                    <th>Student ID</th>

                                    <th>Name</th>

                                    <th>Amount</th>
                                    <!-- <th>Concession From</th>
                                    <th>Concession To</th> -->
                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if(!empty($concessionInfo)){

                                    foreach($concessionInfo as $fee){ ?>

                                    <tr>
                                        <th class="text-center"><?php echo $fee->con_year; ?></th>
                                       
                                        <th class="text-center"><?php echo $fee->student_id; ?></th>

                                        <th><?php echo $fee->student_name; ?></th>

                                        <th class="text-center"><?php echo $fee->fee_amt; ?></th>
                                        <!-- <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->concession_from)); ?></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->concession_to)); ?></th> -->

                                        <th class="text-center">

                                         



                                                <a href="#" class="btn btn-xs btn-primary" title="<b>Remarks:</b>" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="<b><?php echo $fee->description; ?></b>"><i class="fa fa-info"></i></a>



                                               <?php  if($fee->approved_status != 1){  ?>

                                                    <a class="btn btn-xs btn-info" target="_blank"

                                                    href="<?php echo base_url(); ?>editBusConcession/<?php echo $fee->row_id; ?>" title="Edit Student"><i

                                                    class="fas fa-pencil-alt"></i></a>

                                                    <?php }  



                                                  if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_CORRESPONDENT){ 

                                                   if($fee->approved_status == 1){ ?>

                                                        <a class="btn btn-xs btn-danger rejectBusConcession p-2"

                                                        href="#" data-row_id="<?php echo $fee->row_id; ?>"> Reject</a>

                                                        <span class="text-success">APPROVED</span>

                                                <?php }  

                                                if($fee->approved_status != 1){  ?>

                                                        <a class="btn btn-xs btn-success approveBusConcession p-2"

                                                        href="#" data-row_id="<?php echo $fee->row_id; ?>"> Approve</a>

                                            <?php } ?> 

                                              

                                                <!-- <a class="btn btn-xs btn-danger deleteBusConcession" href="#"

                                                    data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i

                                                        class="fa fa-trash"></i></a> -->

                                              <?php } ?>           

                                                  

                                        </th>

                                    </tr>

                                <?php } }else{  ?>

                                <tr>

                                    <th colspan="8" class="text-center">Scholarship Record Not Found</th>

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



    <div class="modal" id="concessionModal">

        <div class="modal-dialog modal-md">

            <div class="modal-content">

                <div class="modal-header bg-primary" style="padding: 7px 15px;">

                    <h4 class="modal-title"> Add Concession</h4>

                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>

                </div>

                <!-- Modal body -->

                <div class="modal-body p-2">

                    <?php $this->load->helper("form"); ?>

                    <form role="form" id="addConcessionInfo" action="<?php echo base_url() ?>addBusConcession" method="post" role="form">

                        <div class="row form-contents">

                            <div class="col-lg-6">

                                <div class="form-group mb-2">

                                    <label for="exampleInputEmail1">Student<span class="text-danger required_star">*</span></label>

                                    <select class="form-control selectpicker" name="student_id" id="student_id" data-live-search="true" required autocomplete="off">

                                        <option value="">Select Student</option>

                                        <?php if(!empty($studentInfo)){

                                            foreach($studentInfo as $std){  ?>

                                            <option value="<?php echo $std->row_id; ?>"><b><?php echo $std->student_id.'- '.$std->student_name.'- '.$std->term_name; ?></b></option>

                                        <?php } } ?>
                                       

                                    </select>

                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="form-group mb-2">

                                     <label for="exampleInputEmail1">Amount<span class="text-danger required_star">*</span></label>

                                    <input type="text" class="form-control" id="fee_amount" name="fee_amount" placeholder="Enter Amount" onkeypress="return isNumberKey(event)" required autocomplete="off">

                                </div>

                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="usr">Concession From</label>
                                    <input type="text" name="concession_from" class="form-control datepicker" required
                                                        Placeholder="Concession From" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="usr">Concession To</label>
                                    <input type="text" name="concession_to" class="form-control datepicker" required
                                                        Placeholder="Concession To" autocomplete="off" >
                                </div>
                            </div> -->
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1">Year<span class="text-danger required_star">*</span></label>
                                    <select class="form-control text-dark" name="con_year">
                                        <!-- <option value="2024">2024</option> -->
                                        <option value="2023">2023</option>
                                        <!-- <option value="2022">2022</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">

                                <div class="form-group mb-0">

                                     <label for="exampleInputEmail1">Remarks<span class="text-danger required_star">*</span></label>

                                    <textarea type="text" class="form-control" id="description" name="description" rows="5" placeholder="Enter Remarks"  autocomplete="off" maxlength="1500" required></textarea>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <!-- Modal footer -->

                <div class="modal-footer" style="padding: 7px 15px;">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <input type="submit" form="addConcessionInfo" class="btn btn-success pull-right" value="Save" />

                </div>



            </div>

        </div>

    </div>





 </div>



 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/transport.js" charset="utf-8"></script>

<script type="text/javascript">

jQuery(document).ready(function() {



    jQuery('ul.pagination li a').click(function (e) {

        e.preventDefault();            

        var link = jQuery(this).get(0).href;            

        var value = link.substring(link.lastIndexOf('/') + 1);

        jQuery("#byFilterMethod").attr("action", baseURL + "viewBusFeeConcession/" + value);

        jQuery("#byFilterMethod").submit();

    });



    jQuery('.datepicker').datepicker({

        autoclose: true,

        orientation: "bottom",

        format: "dd-mm-yyyy",

        endDate : "today"

    });



$('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });

      $('[data-toggle="popover"]').mouseenter(function(){

          $(this).trigger('focus');

      });



    //checkbox select

    $('#selectAll').click(function() {

        if ($('#selectAll').is(':checked')) {

            $('.singleSelect').prop('checked', true);

        } else {

            $('.singleSelect').prop('checked', false);

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