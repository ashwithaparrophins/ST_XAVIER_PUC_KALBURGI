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
                            <div class="col-lg-5 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Scholarship
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total:
                                    <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-4 col-sm-4">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#concessionModal">
                                    <i class="fa fa-plus"></i> Add</a>

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
                            <form action="<?php echo base_url(); ?>viewScholarship" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                <td>
                                    <div class="form-group mb-0">
                                        <select class="form-control text-dark" id="year"
                                                name="year" value="<?php echo $year;  ?>">
                                                <?php if(!empty($year)){ ?>
                                                <option value="<?php echo $year; ?>" selected><b>Selected: <?php echo $year; ?></b></option>
                                            <?php } ?>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            
                                        </select>

                                    </div>

                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="by_name"
                                                class="form-control input-sm" placeholder="Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name"
                                                class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $amount; ?>" name="amount" id="amount"
                                                class="form-control input-sm" placeholder="Amount" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_date; ?>" name="by_date" id="by_date"
                                                class="form-control input-sm datepicker" placeholder="Date"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i
                                                class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="text-center table_row_background">
                                    <th>Year</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($concessionInfo)){
                                    foreach($concessionInfo as $fee){ ?>
                                <tr>
                                    <th class="text-center"><?php echo $fee->year; ?></th>
                                    <th class="text-center" width="180"><?php echo $fee->student_id; ?></th>
                                    <th width="330"><?php echo $fee->student_name; ?></th>
                                    <th class="text-center" width="150"><?php echo $fee->fee_amt; ?></th>
                                    <th class="text-center" width="150"><?php echo date('d-m-Y',strtotime($fee->date)); ?></th>
                                    <th><?php echo $fee->description; ?></th>
                                    <th width="180" class="text-center">

                                        <?php 
                                        if($fee->payment_status == 0){
                                        if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ 
                                                if($fee->payment_status == 0){  ?>
                                        <a class="btn btn-xs btn-info"
                                            href="<?php echo base_url(); ?>editScholarship/<?php echo $fee->row_id; ?>"
                                            title="Edit Student"><i class="fas fa-pencil-alt"></i></a>
                                        <?php if($fee->approved_status == 1){ ?>
                                        <a class="btn btn-xs btn-danger rejectScholarship p-2" href="#"
                                            data-row_id="<?php echo $fee->row_id; ?>"> Reject</a>
                                        <?php } } ?>
                                        <?php if($fee->approved_status != 1){  ?>
                                        <a class="btn btn-xs btn-success approveScholarship p-2" href="#"
                                            data-row_id="<?php echo $fee->row_id; ?>"> Approve</a>
                                        <?php } } 
                                            }else{
                                                echo "<b style='color:green'>Paid</b>";
                                            } ?>
                                        
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
                    <h4 class="modal-title">Add New Scholarship</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addConcessionInfo" action="<?php echo base_url() ?>addScholarship"
                        method="post" role="form">
                        <div class="row form-contents">
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    <label>Select Student <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                        name="application_no" id="student_row_id" required autocomplete="off">
                                        <option value="">Select Student</option>
                                        <?php if(!empty($studentInfo)){
                                            foreach($studentInfo as $std){  ?>
                                        <option value="<?php echo $std->row_id; ?>">
                                            <b><?php echo $std->student_id.' - '.$std->student_name; ?></b></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Enter Scholarship Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="fee_amount" name="fee_amount"
                                        placeholder="Enter Scholarship Amount" onkeypress="return isNumberKey(event)"
                                        required autocomplete="off">
                                </div>
                               
                            </div>
                            <div class="col-lg-6">
                            <div class="form-group mb-2">
                            <label>Year <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" data-live-search="true" name="year" >
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label>Enter Description <span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="description" name="description"
                                        rows="5" placeholder="Enter Description" required autocomplete="off"
                                        maxlength="1500"></textarea>
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

<script src="<?php echo base_url(); ?>assets/js/fee.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewScholarship/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        startDate: "01-11-2020",
        endDate: "today"
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