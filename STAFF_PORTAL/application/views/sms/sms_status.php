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
                            <div class="col-lg-3 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">book</i> SMS Sent Status
                                </span>
                            </div>
                            <div class="col-lg-9 col-md-5 col-12">
                                <form action="<?php echo base_url(); ?>getSMSResponse" method="POST" id="byFilterMethod">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <!-- <label for="date">Date From<span class="text-danger required_star">*</span></label> -->
                                                Date From:<input type="text" class="required datepicker" name="date_from" placeholder="Date from for wallet" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($start_date)); ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <!-- <label for="date">Date To<span class="text-danger required_star">*</span></label> -->
                                                Date To:<input type="text" class="required datepicker" name="date_to" placeholder="Date to for wallet" autocomplete="off" value="<?php echo date('d-m-Y',strtotime($end_date)); ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-group">
                                            <button type="submit"class="btn primary_color float-left"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                        </div>
                                    </div>
                                </from>
                                
                                <!-- <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                    href="<?php echo base_url(); ?>addNewSubject"><i class="fa fa-plus"></i>
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
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table id="item-list" style="width:100%" class="display table  table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Name</th>
                                    <th>Term</th>
                                    <th>Stream</th>
                                    <th>Section</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/subject.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        // if (title == 'Date') {
        //     var newClassupdate = 'disabled';
        // } else {
            var newClassupdate = '';
        //}
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
            "info": "Showing _START_ to _END_ of _TOTAL_ Subjects",
            "infoFiltered": "(filtered from _MAX_ total Subjects)",
            "search": "",
            searchPlaceholder: "Search Subjects",
            "lengthMenu": "Show _MENU_ Subjects",
            "infoEmpty": "Showing 0 to 0 of 0 Subjects",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_sms_response',
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