<style>
label {
    font-weight: 500 !important;
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
    <div class="col-12">
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
                            <div class="col-lg-7 col-9 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Edit Bus Concession
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-3">
                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white "
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small c-border mb-4 p-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2">
                            <form role="form" action="<?php echo base_url() ?>updateBusConcession" method="post"
                                role="form">
                                <input type="hidden" name="row_id" id="row_id" value="<?php echo $feeInfo->row_id; ?>" />
                                <div class="row p-0 column_padding_card">
                                    <div class="col column_padding_card">
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label>Student<span class="text-danger required_star">*</span></label>
                                                <select class="form-control selectpicker" name="student_id" data-live-search="true" id="student_id" autocomplete="off" required>
                                                    <?php if(!empty($feeInfo->student_id)){ ?>
                                                        <option value="<?php echo $feeInfo->student_id; ?>"><b>Selected: <?php echo $studentInfoedit->student_id.'- '.$feeInfo->student_name; ?></b></option>
                                                    <?php } ?>
                                                    <option value="">Select Student </option>
                                                    <?php if(!empty($studentInfo)){
                                                        foreach($studentInfo as $std){  ?>
                                                        <option value="<?php echo $std->row_id; ?>"><b><?php echo $std->student_id.'- '.$std->student_name; ?></b></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Amount<span class="text-danger required_star">*</span></label>
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control" value="<?php echo $feeInfo->fee_amt	; ?>" onkeypress="return isNumberKey(event)" id="fee_amount" name="fee_amount" placeholder="Enter Amount" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="exampleInputEmail1">Year<span class="text-danger required_star">*</span></label>
                                                <div class="form-group mb-2">  
                                                    <select class="form-control selectpicker" data-live-search="true" name="year" id="year" required autocomplete="off">
                                                        <?php if(!empty($feeInfo->con_year)){ ?>
                                                            <option value="<?php echo $feeInfo->con_year; ?>">SELECTED:<?php echo $feeInfo->con_year; ?></option>
                                                        <?php } ?>
                                                        <option value="2023">2023</option>
                                                        <!-- <option value="2022">2022</option>
                                                        <option value="2021">2021</option> -->
                                                    </select>
                                                </div>
                                            </div> 

                                            <div class="form-group col-12">
                                                <label>Remarks<span class="text-danger required_star">*</span></label>
                                                <div class="form-group mb-0">
                                                    <textarea type="text" class="form-control" id="description" name="description" rows="5" 
                                                    placeholder="Enter Remarks"  autocomplete="off" maxlength="1500" required><?php echo $feeInfo->description; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success float-right"> Submit </button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>