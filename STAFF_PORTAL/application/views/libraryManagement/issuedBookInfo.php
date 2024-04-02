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
<?php } ?>

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
                            <div class="col-lg-4 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">book</i> Issued Book Details
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-12">
                                <form action="<?php echo base_url(); ?>viewIssuedBooks" method="POST" id="byFilterMethod">
                                <div class="input-group">
                                    <select class="form-control p-1 search_select" name="user_type" id="user_type">
                                    <?php if(!empty($user_type)){ ?>
                                                    <option value="<?php echo $user_type; ?>" selected><b>Selected: <?php echo $user_type; ?></b></option>
                                                <?php } ?>
                                            <option value="staff">STAFF</option>
                                            <option value="student" >STUDENT</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_left py-0">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                                <!-- </form> -->
                            </div> 
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total Entry: <?php echo $totalLibraryIssuedCount; ?></b>
                            </div>
                            <div class="col-lg-2 col-12 col-md-6 col-sm-6">
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
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                            <!-- <form action="<?php echo base_url(); ?>viewIssuedBooks" method="POST" id="byFilterMethod"> -->
                                <tr class="filter_row" class="text-center">
                                <td>
                                    <div class="form-group mb-0">
                                        <input type="text" value="<?php echo $access_code; ?>" name="access_code" id="access_code" class="form-control input-sm " placeholder="By Accession No." autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0">
                                        <input type="text" value="<?php echo $book_title; ?>" name="book_title" id="book_title" class="form-control input-sm " placeholder="By Book Title" autocomplete="off">
                                    </div>
                                </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By student Id" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_name; ?>" name="student_name" id="student_name" class="form-control input-sm" placeholder="By Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $issue_date; ?>" name="issue_date" id="issue_date" class="form-control input-sm datepicker" placeholder="By issued date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $renewal_date; ?>" name="renewal_date" id="renewalDate" class="form-control input-sm datepicker" placeholder="By renewal date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $return_date; ?>" name="return_date" id="return_date" class="form-control input-sm datepicker" placeholder="By return date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $actual_return_date; ?>" name="actual_return_date" id="actual_return_date" class="form-control input-sm datepicker" placeholder="By actual return date" autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php // echo $days_delayed; ?>" name="days_delayed" id="days_delayed" class="form-control input-sm" placeholder="Days delayed" autocomplete="off">
                                        </div>
                                    </td> -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $fine; ?>" name="fine" id="fine" class="form-control input-sm" placeholder="By fine" autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $remarks; ?>" name="remarks" id="remarks" class="form-control input-sm" placeholder="Remarks" autocomplete="off">
                                        </div>
                                    </td> -->
                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th>Accession No.</th>
                                    <th>Book Title</th>
                                    <th>Student ID</th>
                                    <th> Name</th>
                                    <th>Issue Date</th>
                                    <th>Renewal Date</th>
                                    <th>Given Date</th>
                                    <th>Returned Date</th>
                                    <!-- <th>Days Delayed</th> -->
                                    <th>Fine</th>
                                    <!-- <th>Remarks</th> -->
                                    <th width="130">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($libraryIssuedInfo)) {
                                    foreach ($libraryIssuedInfo as $library) { ?>
                                        <tr>
                                        <th class="text-center"><?php echo strtoupper($library->access_code); ?></th>
                                        <th class="text-center"><?php echo $library->book_title; ?></th>
                                            <th class="text-center"><?php echo $library->student_id; ?></th>
                                            <th class="text-center"><?php echo $library->student_name; ?></th>
                                            <th class="text-center"><?php echo date('d-m-Y',strtotime($library->issue_date)); ?></th>
                                            <?php if($library->renewal_date == NULL || $library->renewal_date == '1970-01-01'){
                                                    $RD = '';
                                                }else{
                                                    $RD = date('d-m-Y',strtotime($library->renewal_date));
                                                }
                                            ?>
                                            <th class="text-center"><?php echo $RD; ?></th>
                                            <th class="text-center"><?php echo date('d-m-Y',strtotime($library->return_date)); ?></th>
                                            <?php if($library->actual_return_date == NULL || $library->actual_return_date == '1970-01-01'){
                                                    $DD = '';
                                                }else{
                                                    $DD = date('d-m-Y',strtotime($library->actual_return_date));
                                                }
                                            ?>
                                            <th class="text-center"><?php echo $DD; ?></th>
                                            <!-- <th class="text-center"><?php echo $library->days_delayed; ?></th> -->
                                            <th class="text-center"><?php echo $library->fine; ?></th>
                                            <!-- <th class="text-left"><?php echo $library->remarks; ?></th> -->
                                            <th class="text-left">
                                                <!-- <span><a href="#" data-toggle="popover" data-content="Comment: <?php echo  $adm->comment; ?> <br/> "><span class="badge badge-primary"> <i class="fa fa-info-circle"></i></span></a></span> -->
                                                <?php $status = $info->getAccessData($library->access_code);
                                                if($library->is_issued == 0){ ?>
                                                    <div class="btn btn-xs bg-success rounded">
                                                        <span style="font-weight: bold;color:white; font-size:14px;">Recevied</span>
                                                    </div>
                                                <?php } else {
                                                ?>
                                                    <div class="btn btn-xs bg-danger rounded">
                                                        <span style="font-weight: bold;color:white; font-size:14px;">Pending</span>
                                                    </div>
                                                <?php } ?>
                                                <?php if($library->renewal_date == NULL || $library->renewal_date == '1970-01-01'){
                                                    $renewal = 'null';
                                                }else{
                                                    $renewal = date('d-m-Y',strtotime($library->renewal_date));
                                                }
                                            ?>
                                                <?php if ($role == ROLE_ADMIN || $role == ROLE_LIBRARY || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_RECEPTION) { ?>
                                                    <a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url(); ?>editIssuedInfo/<?php echo $library->row_id; ?>" title="Edit Issued Info"><i class="fas fa-pencil-alt"></i></a>
                                                    <a class="btn btn-xs btn-secondary rounded" onclick="openModel(<?php echo $library->row_id; ?>,/<?php echo $renewal; ?>/,/<?php echo date('d-m-Y', strtotime($library->return_date)); ?>/)" title="Renewal" href='#'>Renewal</a>
                                                    <!-- <a class="btn btn-xs btn-danger deleteLibraryDetails" href="#" data-row_id="<?php echo $library->row_id; ?>" title="Delete Library details"><i class="fa fa-trash"></i></a> -->
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    <?php }
                                } else {  ?>
                                    <tr>
                                        <th colspan="10" class="text-center">Issued Book Record Not Found</th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="renewalBook" class="modal" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header modal-call-report">
                    <div class=" col-md-10 col-10">
                        <span class="text-black mobile-title m-1" style="font-size : 20px">Renewal Book</span>
                    </div>
                    <div class=" col-md-2 col-2">
                        <button type="button" class="text-black close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <!-- Modal body -->
                <div class="modal-body m-0 p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="renewalDate" action="<?php echo base_url() ?>updateRenewalDate"
                        method="post" role="form">
                        <input type="hidden" name="row_id" id="row_id" value="" />
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Renewal Date</label>
                                    <input type="text" class="form-control datepicker" id="renewal_date"
                                        name="renewal_date" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Return Date</label>
                                    <input type="text" class="form-control datepicker" id="date" name="return_date" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo base_url(); ?>assets/js/admission.js" type="text/javascript"></script>
<script type="text/javascript">
    function openModel(row_id,renewal_date, return_date) {
    $('#row_id').val(row_id);
   var yourString = String(return_date);
   var result = yourString.substring(1, yourString.length-1);
    $('#date').val(result);
    if(renewal_date == '/null/'){
        var res = '';
    $('#renewal_date').val(res);
    }else{var yourStrings = String(renewal_date);
   var results = yourStrings.substring(1, yourStrings.length-1);
    $('#renewal_date').val(results);
}
   
    $('#renewalBook').modal('show');
}
    jQuery(document).ready(function() {

        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#byFilterMethod").attr("action", baseURL + "viewIssuedBooks/" + value);
            jQuery("#byFilterMethod").submit();
        });

        jQuery('.datepicker, .dateSearch').datepicker({
            autoclose: true,
            orientation: "bottom",
            format: "dd-mm-yyyy"

        });

        jQuery(document).on("click", ".deleteLibraryDetails", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteLibraryDetails",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure to delete this Library Details ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Library Info successfully deleted"); }
                    else if(data.status = false) { alert("Library deletion failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });
        //checkbox select
        $('#selectAll').click(function() {
            if ($('#selectAll').is(':checked')) {
                $('.singleSelect').prop('checked', true);
            } else {
                $('.singleSelect').prop('checked', false);
            }
        });

        // popover
        $('[data-toggle="popover"]').popover({
            "container": "body",
            "trigger": "focus",
            "html": true
        });
        $('[data-toggle="popover"]').mouseenter(function() {
            $(this).trigger('focus');
        });


    });
</script>