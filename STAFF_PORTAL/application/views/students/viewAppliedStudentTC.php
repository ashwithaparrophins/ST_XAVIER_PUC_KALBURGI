<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.1);
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
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card noprint">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class=" col-12 col-md-4 col-lg-4 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">group</i> Transfer Certificate
                                </span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <h5 class="mb-0 font-weight-bold text-dark">Total: <?php echo $totalCount; ?></h5>
                            </div>

                             <div class="col-lg-3 col-md-3 col-3">
                                <form action="<?php echo base_url() ?>getStudentAppliedForTc" method="POST"
                                        id="byFilterMethod">
                                <div class="input-group mobile-btn float-right student_search">
                                        <select class="p-1 search_select" name="admission_year" id="admission_year">
                                            <?php if(!empty($admission_year)){ ?>
                                                <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                            <?php } ?>
                                            <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                            <option value="2023">2023</option>

                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            
                                        </select>
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-6">

                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right border_right_radius">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_right_radius"
                                        data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item"  id="tranfer_certificate" href="#"><i class="fa fa-file"></i> 
                                        Transfer Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-0">
                    <div class="card-body p-1 pb-2">
                        <div class="table-responsive">
                            <table class="display table  table-bordered table-striped table-hover w-100 mb-0">
                            <tr class="row_filter">
                                    
                                        <th></th>
                                        <th> <input type="text" value="<?php echo $by_date; ?>" name="by_date" id="by_date" class="form-control input-sm datepicker" style="text-transform: uppercase" placeholder="TC Applied Date" autocomplete="off"></th>

                                         <th style="padding: 1px;"> <input type="text" name="tc_number" id="tc_number"
                                                value="<?php echo $tc_number ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="TC Number"
                                                autocomplete="off" />
                                        </th>

                                        <th style="padding: 1px;"> <input type="text" name="student_id" id="student_id"
                                                value="<?php echo $student_id ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Student ID"
                                                autocomplete="off" />
                                        </th>

                                        <th style="padding: 1px;"> <input type="text" name="student_name"
                                                id="student_name" value="<?php echo $student_name ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="By Name"
                                                autocomplete="off" />
                                        </th>
                                         
                                        <th width="90" style="padding: 1px;">
                                            <select class="form-control input-sm" id="term_name" name="term_name"
                                                autocomplete="off">
                                                <?php if($term_name != ""){ ?>
                                                <option value="<?php echo $term_name; ?>" selected><b>Sorted:
                                                        <?php echo $term_name; ?></b></option>

                                                <?php } ?>
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>

                                            </select>
                                        </th>

                                        <th style="padding: 1px;">
                                            <select class="form-control" name="section_name" id="section_name">
                                                <?php if(!empty($section_name)){ ?>
                                                    <option value="<?php echo $section_name; ?>" selected><b>Selected: <?php echo $section_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Section</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <!-- <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option> -->
                                            </select>
                                        </th>

                                        <th style="padding: 1px;"> 
                                            <select class="form-control input-sm" id="stream_name" name="stream_name" autocomplete="off">
                                                <?php if(!empty($stream_name)){ ?>
                                                    <option value="<?php echo $stream_name; ?>" selected><b>Sorted:
                                                    <?php echo $stream_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th style="padding: 1px;">
                                            <button type="submit"
                                            class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i>
                                            Filter</button>
                                        </th>



                                    </form>
                                </tr>
                                <thead>
                                    <tr class="table_row_backgrond text-center">
                                        <th width="25">
                                            <input type="checkbox" id="selectAll" />
                                        </th>
                                        <th width="160">TC Applied Date</th>
                                        <th width="160">TC No.</th>
                                        <th width="160">Student ID</th>
                                        <th>Name</th>
                                        <th>Term</th>
                                        <th>Section</th>
                                        <th width="160">Stream Name</th>
                                        <th width="160">Register. No.</th>
                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <?php
                                    if(!empty($studentTcInfo)) {
                                        foreach($studentTcInfo as $record) { ?> 
                                    <tr>
                                        <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $record->student_id; ?>" /></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($record->created_date_time)); ?></th>
                                        <th class="text-center"><?php echo $record->tc_number; ?></th>
                                        <th class="text-center"><?php echo $record->student_id; ?></th>
                                        <th width="300"><?php echo strtoupper($record->student_name); ?></th>
                                        <th width="110" class="text-center"><?php echo $record->term_name; ?></th>
                                        <th width="110" class="text-center"><?php echo $record->section_name; ?></th>
                                        <th class="text-center"><?php echo $record->stream_name; ?></th>
                                        <th class="text-center"><?php echo $record->exam_register_no; ?></th>
                                    </tr>
                                    <?php } }else{  ?>
                                        <tr>
                                            <th class="text-center" colspan="8">Student Record Not Found</th>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer p-1 mb-0">
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="bulkTcPrint">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Transfer Certificate</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form role="form" method="post" action="<?php echo base_url(); ?>getBulkStudentTCPrint" target="_blank">
            <div class="modal-body p-1">
                <div class="row">
                    <div class="col-lg-6">   
                        <select class="form-control input-sm" id="term_name" name="term_name" autocomplete="off" required>
                            <option value="">By Term</option>
                            <option value="I PUC">I PUC</option>
                            <option value="II PUC">II PUC</option>
                        </select>
                    </div>     
                    <div class="col-lg-6">   
                        <select class="form-control input-sm" id="stream_name" name="stream_name" autocomplete="off">
                            <option value="">By Stream</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $stream){ ?>
                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                            <?php } } ?>
                        </select>
                    </div>     
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button</button> -->
                <button id="printTransferCertificate" type="submit" class="btn btn-md btn-primary"><i
                        class="fa fa-print"></i> Print</button>
            </div>

        </form>   

        <!-- Modal footer -->
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getStudentAppliedForTc/" + value);
        jQuery("#byFilterMethod").submit();
    });

    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    $('#tranfer_certificate').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to print tranfer certificate!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getStudentsTcInfoById?student_id=' + btoa(students));
    });
    
});

</script>