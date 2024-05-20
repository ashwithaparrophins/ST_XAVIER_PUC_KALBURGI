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
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12  padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1">
                        <div class="row ">
                        <div class="col-lg-10 col-12 col-md-12 box-tools">
                            <span class="page-title">
                                    <i class="fa fa-user"></i> Edit Party Details
                                </span>
                            </div>
                            <div class="col-md-2 col-12 m-auto"> <a href="#" onclick="GoBackWithRefresh();return false;"class="btn text-white btn-success btn-bck float-right mobile-btn mobile-bck"><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a></div>
                        </div>
                    </div>
                    <div class="card-body contents-body ">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="updateParty" action="<?php echo base_url() ?>updateParty"
                            method="post" role="form">
                            <div class="row form-contents">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="party_name">Party Name</label>
                                                <input type="text" class="form-control " id="party_name" name="party_name" value="<?php echo $partyInfo->party_name; ?>"
                                                    placeholder="Enter party Name" autocomplete="off" >
                                                    <input type="hidden" value="<?php echo $partyInfo->row_id; ?>" name="row_id" id="row_id" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                            <label for="email">Email address (Optional) </label>
                                                <input type="email" class="form-control email " id="email" name="email" value="<?php echo $partyInfo->email; ?>"
                                                    maxlength="128" placeholder="Enter Email Address"
                                                    autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_number_one">Contact Number One</label>
                                                <input type="text" class="form-control " id="contact_number_one" value="<?php echo $partyInfo->contact_number_one; ?>"
                                                    name="contact_number_one" placeholder="Enter Contact Number One" minlength="10"
                                                    maxlength="10" onkeypress="return isNumberKey(event)"
                                                    autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_number_two">Contact Number Two (Optional)</label>
                                                <input type="text" class="form-control " id="contact_number_two" value="<?php echo $partyInfo->contact_number_two; ?>"
                                                    name="contact_number_two" placeholder="Enter Contact Number Two" minlength="10"
                                                    maxlength="10" onkeypress="return isNumberKey(event)"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="gst">GSTIN NO.</label>
                                                <input type="text" class="form-control "  minlength="15" maxlength="15" id="gst" value="<?php echo $partyInfo->party_gst; ?>"
                                                    name="gst" placeholder="Enter GSTIN No."
                                                    maxlength="15"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_number_two">State Code</label>
                                                <input type="text" class="form-control " id="state_code" value="<?php echo $partyInfo->party_state_code; ?>"
                                                    name="state_code" placeholder="Enter Party State Code"
                                                    maxlength="6" onkeypress="return isNumberKey(event)"
                                                    autocomplete="off">
                                            </div>
                                        </div> -->
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label for="party_address">Address</label>
                                                <textarea class="form-control " placeholder="Enter Address"
                                                    name="party_address" id="party_address" rows="3" autocomplete="off"
                                                    ><?php echo $partyInfo->party_address; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                            <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/party/party.js" charset="utf-8">
</script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = '<?php echo base_url(); ?>PartyDetails';
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

function blockSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        jQuery("#searchList").attr("action", link);
        jQuery("#searchList").submit();
    });
    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })
});
</script>