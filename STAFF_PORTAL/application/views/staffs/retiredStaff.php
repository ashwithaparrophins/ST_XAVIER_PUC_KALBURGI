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

<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-10 col-sm-8 col-8">
                                <span class="page-title">
                                    <i class="fa fa-user"></i> Retired Staff
                                </span>
                            </div>

                            <div class="col-lg-2 col-sm-4 col-4 box-tools">
                                <?php if($role == ROLE_ADMIN){ ?>
                                <!-- <div class="form-group">
                                    <a class="btn btn-primary mobile-btn pull-right" onclick="showLoader()"
                                        href="<?php echo base_url(); ?>addNewStaff"><i class="fa fa-plus"></i>
                                        Add New</a>
                                </div> -->
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col column_padding_card">
                <div class="card card-small mb-4 column_padding_card">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table id="item-list" style="width:100%"
                            class="display table table-bordered table-striped dt-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="230">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Retired Date</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="200">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Retired Date</th>
                                    <th width="100">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal" id="my_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Edit Resign Date  - <span id="staffName"></span></h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form role="form" id="add" action="<?php echo base_url() ?>updateResignedDate" method="post" role="form">
                    <input type="hidden" value="" name="staff_id" id="staff_identity" />

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date">Resigned Date<span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required datepicker_resign" name="resigned_date"
                                    id="resigned_date" placeholder="Resigned Date" autocomplete="off" required />
                            </div>
                        </div>
                    </div>                                          
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
<script>
function editResignDate(date,row_id,name) {
    $('#resigned_date').val(date);
    $('#staff_identity').val(row_id);
    $('#staffName').html(name);
    $('#my_modal').modal('show');
}
</script>

<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('.datepicker_resign').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        // startDate : "01-01-2021",
        // endDate: "today"
    });


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
            "info": "Showing _START_ to _END_ of _TOTAL_ Staffs",
            "infoFiltered": "(filtered from _MAX_ total staffs)",
            "search": "",
            searchPlaceholder: "Search Staff",
            "lengthMenu": "Show _MENU_ Staffs",
            "infoEmpty": "Showing 0 to 0 of 0 Staffs",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_staffs_retired',
            type: 'POST',

            // dataType: 'json',
        },

    });

    new $.fn.dataTable.FixedHeader(table);


    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
});
</script>