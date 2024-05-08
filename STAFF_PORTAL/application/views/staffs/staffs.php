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
                            <div class="col-lg-6 col-sm-6 col-12">
                                <span class="page-title">
                                    <i class="material-icons">group</i> Staff Management
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12 box-tools">
                                    <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-success dropdown-toggle border_radius_none" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <!-- <a class="dropdown-item disabled" href="#"><i class="fa fa-download"></i> Download</a> -->
                                        <a class="dropdown-item" href="#" id="barcode"><i class="fa fa-file"></i> Generate Barcode</a>
                                        <!-- <div class="dropdown-divider m-0"></div> -->
                                        <!-- <a class="dropdown-item disabled" href="#"><i class="fa fa-mobile"></i> Send SMS</a> -->
                                    </div>
                                </div>
                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                                <div class="form-group">
                                    <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                        href="<?php echo base_url(); ?>addNewStaff"><i class="fa fa-plus"></i>
                                        Add New</a>
                                </div>
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
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table id="item-list" style="width:100%"
                            class="display table table-bordered table-striped table-responsive table-hover text-center">
                            <thead>
                                <tr>
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="230">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th width="140">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="200">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            var displayStatus = false;
            var newClassupdate = 'disabled';
        } else {
            var displayStatus = true;
            var newClassupdate = '';
        }
        if (title == '') {
            var displayStatus = false;
            var newClassupdate = 'disabled';
        }else if (title == 'Action') {
            var displayStatus = false;
            var newClassupdate = 'disabled';
        }
         else {
            var displayStatus = true;
            var newClassupdate = '';
        }

        if(displayStatus == true){
            $(this).html(
            '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
            title + '" ' +
            newClassupdate + ' /> </div>');
        }else{
            $(this).html('');
        }

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
                targets: 2,

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
            "info": "Showing _START_ to _END_ of _TOTAL_ Staff",
            "infoFiltered": "(filtered from _MAX_ total staff)",
            "search": "",
            searchPlaceholder: "Search Staff",
            "lengthMenu": "Show _MENU_ Staff",
            "infoEmpty": "Showing 0 to 0 of 0 Staff",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_staffs ',
            type: 'POST',

            // dataType: 'json',
        },

    });

    $('#barcode').click(function(){
    var staffs = [];
    if ($('.singleSelect:checkbox:checked').length == 0) {
        alert("Select at least one Staff to generate barcode!");
        return;
    }
    $('.singleSelect:checked').each(function(i){
        staffs.push($(this).val());
    });
    staffs = JSON.stringify(staffs);
    window.open('<?php echo base_url(); ?>generateBarcodeForStaff?row_id=' + btoa(staffs));
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
});
</script>