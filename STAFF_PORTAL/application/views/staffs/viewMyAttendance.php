<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #0e0e0e5c !important
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

<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper ">
        <div class="row p-0 ">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-10 col-sm-12 col-10">
                                <span class="page-title">
                                    <i class="fa fa-user"></i> My Attendance
                                </span>
                            </div>

                            <div class="col-lg-2 col-sm-12 col-2 box-tools">
                                <div class="form-group">
                                    <button class="btn btn-primary mobile-btn pull-right" data-toggle="modal"
                                        data-target="#leaveInfoModel"><i class="fa fa-eye"></i>
                                        Analysis</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table id="item-list" style="width:100%"
                            class="display table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>In-Time</th>
                                    <th>Out-Time</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>In-Time</th>
                                    <th>Out-Time</th>
                                    <th>Total Hours</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- End Modal -->
    </div>
</div>


<!-- The leave view Modal -->
<div class="modal" id="leaveInfoModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Analysis</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Total Late</th>
                                        <th id="total_late" scope="col "><?php echo $total_late; ?></th>

                                    </tr>
                                    <tr>
                                        <th scope="col">Not Punched Out</th>
                                        <th scope="col"><?php echo $punch_out_nill; ?></th>

                                    </tr>
                                </thead>

                            </table>
                        </div>


                    </div>


                    <hr class="mt-1 mb-1">
                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            var newClassupdate = 'datePickerSelect';
        } else {
            var newClassupdate = '';
        }
        $(this).html(
            '<div class="form-group position-relative mb-0 mt-0 " style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm ' +
            newClassupdate + '" placeholder="Search ' +
            title + '"/> </div>');

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
        // columnDefs: [{
        //     className: "text-left",
        //     targets: 
        // }],
        lengthMenu: [
            [200, 150, 100, 50, 20, 10],
            [200, 150, 100, 50, 20, 10]
        ],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Attendance",
            "infoFiltered": "(filtered from _MAX_ total attendance)",
            "search": "",
            searchPlaceholder: "Search Attendance",
            "lengthMenu": "Show _MENU_ Attendance",
            "infoEmpty": "Showing 0 to 0 of 0 Attendance",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        ajax : {
            url: '<?php echo base_url(); ?>/get_my_attendance_info',
            type: 'POST',
            dataType: 'json',
            data: {
                date: $("#dateSearch").val(),
            },
        },

    });

    jQuery('.datePickerSelect, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
});
</script>