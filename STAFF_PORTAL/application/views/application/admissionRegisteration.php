<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.2);
}

input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    color: red;
    width: 10px;
    height: 10px;
    visibility: visible;
    border: 1px solid #3c8dbc;
    padding: 2px;
    margin: 1px 0;
    border-radius: 1px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
}

input[type=checkbox]:checked:after {
    content: "\2714";
    display: unset;
    font-weight: bold;
    width: 10px;
    height: 10px;
    padding: 2px
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
                        <div class="row c-m-b">
                            <div class=" col-12 col-md-6 col-lg-4 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-file"></i> Registered Student
                                </span>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <b class="text-dark" style="font-size: 18px;">Total: <?php echo $studentCount; ?></b>
                            </div>
                            <div class="col-lg-2">
                            <form action="<?php echo base_url() ?>getAdmissionRegisteredStudent" method="POST" id="byFilterMethod">
                            <div class="input-group mobile-btn float-right student_search">
                                        <select class="p-1 search_select" name="admission_year" id="admission_year">
                                            <?php if(!empty($admission_year)){ ?>
                                                <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                            <?php } ?>
                                            <option value="<?php echo ADMISSION_YEAR?>"><?php echo ADMISSION_YEAR?></option>
                                            <option value="<?php echo 2023?>"><?php echo 2023?></option>

                                            <!-- <option value="2021">2021</option> -->
                                            
                                        </select>
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-lg-2">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-1 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <!-- <th width="25"><input type="checkbox" id="selectAll" /></th> -->
                                    <th>Date</th>
                                    <th>Name</th>
                                    <!-- <th>DOB</th>
                                    <th>Board</th> -->
                                    <th>Mobile No.</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                <tr class="row_filter">
                                        <!-- <th></th> -->
                                        <th style="padding: 1px;"> <input type="text" name="date"
                                                id="date" value="<?php echo $date; ?>"
                                                class="form-control datepicker input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Registered Date"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;"> <input type="text" name="name"
                                                id="name" value="<?php echo $name; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Name"
                                                autocomplete="off" />
                                        </th>
                                        <!-- <th style="padding: 1px;"> <input type="text" name="dob"
                                                id="dob" value="<?php echo $dob; ?>"
                                                class="form-control datepicker input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Date of Birth"
                                                autocomplete="off" />
                                        </th>


                                        <th>
                                            <select class="form-control input-sm" id="board_name" name="board_name" autocomplete="off">
                                                <?php if(!empty($board_name)){ ?>
                                                <option value="<?php echo $board_name; ?>">
                                                    <?php echo $board_name; ?></option>
                                                <?php } ?><option value="">By Board</option>
                                               

                                                <?php if(!empty($boardInfo)){ 
                                                    foreach($boardInfo as $board){ ?>
                                                    <option value="<?php echo $board->board_name; ?>"><?php echo $board->board_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th> -->
                                        <th style="padding: 1px;"> <input type="text" name="mobile"
                                                id="mobile" value="<?php echo $mobile; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Mobile No."
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;"> <input type="text" name="email"
                                                id="email" value="<?php echo $email; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Email"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;" class="text-center">
                                            <button type="submit" class="btn btn-success btn-md btn-block"><i
                                                    class="fa fa-filter"></i> Filter</button>
                                        </th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if(!empty($studentInfo)) {
                                    foreach($studentInfo as $record) {
                                ?> <tr>
                                    <!-- <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $record->application_number; ?>" /></th> -->
                                    <th class="text-center"><?php echo date('d-m-Y',strtotime($record->created_date)); ?></th>
                                    <?php if(empty($record->name )){ ?> 
                                        <th class="text-success ">Name not updated</th>
                                        <?php } else { ?>
                                    <th><?php echo $record->name; ?></th>
                                    <?php } ?>
                                    <!-- <th class="text-center"><?php echo date('d-m-Y',strtotime($record->dob)); ?></th>
                                    <th><?php echo $record->board_name; ?></th> -->
                                    <th class="text-center"><?php echo $record->mobile; ?> </th>
                                    <?php if(empty($record->email )){ ?> 
                                        <th class="text-success text-center">Email not updated</th>
                                        <?php } else { ?>
                                    <th class="text-center"><?php echo $record->email; ?> </th>
                                    <?php } ?>
                                    <th class="text-center"></th>
                                    <!-- <th class="text-center" width="180"> -->
                                        <!-- <a class="btn btn-xs btn-info" title="<?php echo $record->name; ?>" data-toggle="popover" data-placement="left" 
                                            data-content="<b>Student Mobile No.:</b> <?php echo $record->student_mobile; ?><br/><b>Father Mobile No.:</b> <?php echo $record->father_mobile; ?> <br/> <b>Mother Mobile No.:</b> <?php echo $record->mother_mobile; ?> <br/> <b>Applied Date:</b> <?php if($record->updated_date_time != '0000-00-00 00:00:00'){ echo date('d-m-Y',strtotime($record->updated_date_time)); } ?>"
                                            href="#" title="View More"><i class="fa fa-info-circle"></i></a> -->
                                    <!-- </th> -->
                                </tr>
                                <?php } }else{ ?>
                                <tr>
                                    <td class="text-center" colspan="9">Record Not Found</td>
                                </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th>Date</th>
                                    <th>Name</th>
                                    <!-- <th>DOB</th>
                                    <th>Board</th> -->
                                    <th>Mobile No.</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer text-center pt-1 px-1 pb-0">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/admission.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    // $(".reason_unqualified").hide();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getAdmissionRegisteredStudent/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });



    $('#leaving_date, .datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });

    // popover
    $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
    $('[data-toggle="popover"]').mouseenter(function(){
      $(this).trigger('focus');
    }); 
});
</script>