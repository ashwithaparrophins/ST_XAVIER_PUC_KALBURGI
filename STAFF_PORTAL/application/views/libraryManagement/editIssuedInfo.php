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
<?php } ?>
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
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12 padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1 card_head_dashboard">
                        <div class="row ">
                            <div class="col-md-6 col-8 text-black m-auto " style="font-size:22px;"><i class="material-icons">book</i> Edit Library management
                            </div>
                            <div class="col-md-6 col-4 m-auto">
                                <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white btn-primary btn-bck float-right mobile-btn "><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="editIssuedInfo" action="<?php echo base_url() ?>updateIssuedInfo" method="post" role="form" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $libraryInfo->row_id; ?>" id="row_id" name="row_id">
                            <input type="hidden" value="<?php echo $libraryInfo->return_date; ?>" id="return_date" name="return_date">
                            <input type="hidden" value="<?php echo $libraryInfo->access_code; ?>" id="isbn" name="isbn">
                            <div class="row form-contents">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="actual_return_date">Actual Return Date<span class="text-danger required_star">*</span><i class='fas fa-info-circle ml-2' data-toggle='tooltip' data-placement='top'  title='Student book returned actual date'></i></span></label>
                                                <input type="text" class="form-control required datepicker" id="actual_return_date" name="actual_return_date" value="<?php if(!empty($libraryInfo->actual_return_date)){ 
                                                                                                                                                                                echo date('d-m-Y',strtotime($libraryInfo->actual_return_date));
                                                                                                                                                                            }else{ 
                                                                                                                                                                                echo date('d-m-Y');} ?>" 
                                                placeholder="Enter Actual Return date" autocomplete="off" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="fine_id">Fine Name<span class="text-danger required_star">*</span></label>
                                                <select name="fine_id" id="fine_id" class="form-control input-sm selectpicker" data-live-search="true" required>
                                                
                                                <option value="<?php echo $libraryInfo->fine_id; ?>">Selected: <?php echo strtoupper($fine_amt->fine_name); ?></option>
                                                    <option value="">Select Fine Name</option>
                                                    <?php if (!empty($fineInfo)) {
                                                        foreach ($fineInfo as $fine) { ?>
                                                            <option value="<?php echo $fine->row_id; ?>"><?php echo $fine->fine_name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="remarks">Remarks</label>
                                                <textarea class="form-control"  name="remarks" id="remarks" rows="4" maxlength="300" placeholder="Remarks" autocomplete="off"><?php echo $libraryInfo->remarks; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/staff/student.js" type="text/javascript"></script>
<script type="text/javascript">
    function GoBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = '<?php echo base_url(); ?>/viewIssuedBooks';
            /* OR */
            //location.replace(document.referrer);
        } else {
            window.history.back();
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 48 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#uploadedImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#vImg").change(function() {
        readURL(this);
    });

    jQuery(document).ready(function() {

        jQuery('.datepicker').datepicker({
            autoclose: true,
            orientation: "bottom",
            // format: "dd-mm-yyyy"
            dateFormat: "dd-mm-yy" 

        });

    });
</script>