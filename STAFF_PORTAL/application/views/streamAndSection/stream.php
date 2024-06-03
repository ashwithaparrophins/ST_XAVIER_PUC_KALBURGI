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
                            <div class="col-lg-7 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">book</i> Stream & Section Management
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12">
                                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    
                                <?php if($role == ROLE_ADMIN || $role == ROLE_OFFICE || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                    href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>
                                    Add New</a>
                                <?php } ?>
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
                            <form action="<?php echo base_url(); ?>classStreamDetails" method="POST" id="byFilterMethod">
                                <tr> 
                                <td class="p-0">
                                    <select class="form-control" id="exampleFormControlSelect1" name="by_term" id="by_term">
                                    <?php if(!empty($searchTerm)){ ?>
                                        <option value="<?php echo $searchTerm ?>" selected><b>Selected: <?php echo $searchTerm ?></b></option>
                                    <?php } ?>
                                    <option value="">By Term Name</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                    </select>
                                </td>
                                <td class="p-0">
                                    <div class="form-group m-0">
                                    <select class="form-control" id="exampleFormControlSelect1" name="by_stream" id="by_stream">
                                        <?php if(!empty($searchStream)){ ?>
                                            <option value="<?php echo $searchStream ?>" selected><b>Selected: <?php echo $searchStream ?></b></option>
                                        <?php } ?>
                                        <option value="">By Stream Name</option>
                                        <?php if(!empty($streamInfo)){
                                            foreach($streamInfo as $stream){ ?>
                                            <option value="<?php echo $stream->stream_name ?>">
                                                <?php echo $stream->stream_name ?>
                                            </option>
                                        <?php }  } ?>
                                       
                                    </select>
                                    </select>
                                    </div>
                                </td>
                                <td class="p-0">
                                    <div class="form-group m-0">
                                    <select class="form-control" id="exampleFormControlSelect1" name="by_section" id="by_section">
                                        <?php if(!empty($searchSection)){ ?>
                                            <option value="<?php echo $searchSection ?>" selected><b>Selected: <?php echo $searchSection ?></b></option>
                                        <?php } ?>
                                        <option value="">By Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <!-- <option value="D">D</option> -->
                                        <!-- <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                        <option value="H">H</option>
                                        <option value="I">I</option>
                                        <option value="J">J</option>
                                        <option value="K">K</option>
                                        <option value="L">L</option>
                                        <option value="M">M</option>-->
                                        <option value=" ">ALL (No Section)</option>
                                    </select>
                                    </div>
                                </td>
                                <!-- <td>
                                    <select class="form-control" id="by_class_type" name="by_class_type" readonly>
                                        <?php if(!empty($by_class_type)){ ?>
                                            <option value="<?php echo $by_class_type; ?>"><?php echo $by_class_type; ?></option>
                                        <?php } ?>
                                        <option value="">Select Class Type</option> -->
                                        <!-- <option value="Aided">Aided</option>
                                        <option value="Unaided" selected>Unaided</option> -->
                                    <!-- </select> -->
                                <!-- </td>  -->
                                <!-- <td class="p-0">
                                <div class="form-group m-0">
                                    <select class="form-control" data-live-search="true" id="by_class_teacher" name="by_class_teacher">
                                        <?php if(!empty($by_class_teacher)){ ?>
                                            <option value="<?php echo $by_class_teacher; ?>"><?php echo $by_class_teacher; ?></option>
                                        <?php } ?>
                                        <option value="">Select Class Teacher</option>
                                        <?php if(!empty($staffInfo)){
                                            foreach($staffInfo as $staff){  ?>
                                                <option value="<?php echo $staff->staff_id; ?>"><?php echo $staff->name; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                </td> -->
                                <td class="p-0">    
                                    <button type="submit"class="btn btn-success btn-block mobile-width"> Search</button>
                                </td>
                                </tr>
                            </form>
                            <tr class="table_row_background">
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Section</th>
                                <!-- <th>Class Type</th> -->
                                <!-- <th>Class Teacher</th> -->
                                <th>Action</th>
                            </tr>
                            <?php if(!empty($sectionInfo)){
                                foreach($sectionInfo as $section){ ?>
                            <tr class="text-dark">
                                <td><?php echo $section->term_name; ?></td>
                                <td><?php echo $section->stream_name; ?></td>
                                <td class="text-center"><?php echo $section->section_name; ?></td>
                                <!-- <td><?php echo $section->class_type; ?></td> -->
                                <!-- <td><?php echo $section->name; ?></td> -->
                                <td class="text-center">  
                                <a class="btn btn-xs btn-danger deleteSection" href="#" data-row_id="<?php echo $section->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } }else{ ?>
                                <tr class="text-dark">
                                <td colspan="6" style="background-color: #e3cfff;">Stream & Section Not Found</td>
                                </tr>
                            <?php } ?>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Section</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-2">
                    <form role="form" action="<?php echo base_url() ?>addSection" method="post" id="modelForm">
                        <div class="row form-contents">
                            <div class="col-6 pr-1">
                                <div class="form-group">
                                    <select class="form-control" id="term_name" name="term_name" data-live-search="true" autocomplete="off" required>
                                        <option value="">Select Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 pl-1">
                                <div class="form-group">
                                    <select name="stream" id="stream" class="form-control" data-live-search="true" autocomplete="off" required>
                                    <option value="">Select Stream</option>
                                    <?php if(!empty($streamInfo)){
                                        foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->row_id ?>">
                                            <?php echo $stream->stream_name ?>
                                        </option>

                                      
                                    <?php }  } ?>
                                    
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 pr-1">
                                <div class="form-group">
                                    <select class="form-control" id="section" name="section" data-live-search="true" autocomplete="off" required>
                                        <option value="">Select Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <!-- <option value="D">D</option>
                                        <option value="E">E</option>
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
                                        <option value="S">S</option>-->
                                        <option value=" ">ALL (No Section)</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-6 pl-1"> 
                                <select class="form-control required selectpicker" id="class_type" name="class_type" readonly>
                                    <option value="Unaided">Unaided</option>
                                    <option value="Aided">Aided</option>
                                    <option value="Unaided">Unaided</option>
                                </select>
                            </div> -->
                            <!-- <div class="col-6 pr-1">
                                <select class="form-control required selectpicker" data-live-search="true" id="class_teacher" name="class_teacher">
                                    <option value="">Select Class Teacher</option>
                                    <?php if(!empty($staffInfo)){
                                        foreach($staffInfo as $staff){  ?>
                                            <option value="<?php echo $staff->staff_id; ?>"><?php echo $staff->name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div> -->
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success font-weight-bold" value="Add" form="modelForm"/>
                    <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            var newClassupdate = 'disabled';
        } else {
            var newClassupdate = '';
        }
        $(this).html(
            '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
            title + '" ' +
            newClassupdate + ' /> </div>');

        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });


    var table = $('#item-list').DataTable({
        columnDefs: [
            // { className: "my_class", targets: "_all" },
            {
                className: "text-left",
                targets: 1,

            }
        ],
        lengthMenu: [
            [200, 150, 100, 50, 20, 10],
            [200, 150, 100, 50, 20, 10]
        ],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        responsive: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Stream",
            "infoFiltered": "(filtered from _MAX_ total Stream)",
            "search": "",
            searchPlaceholder: "Search Class And Stream",
            "lengthMenu": "Show _MENU_ Stream",
            "infoEmpty": "Showing 0 to 0 of 0 Stream",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/ get_stream',
            type: 'POST',

            // dataType: 'json',
        },

    });



    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
});
</script>