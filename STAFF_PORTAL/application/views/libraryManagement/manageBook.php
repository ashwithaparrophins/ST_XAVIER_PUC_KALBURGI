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
                            <div class="col-lg-5 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">book</i> Library Management Details
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total Entry: <?php echo $totalLibraryMgmtCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary mobile-btn float-right border_right_radius" href="<?php echo base_url(); ?>addLibraryInfo"><i class="fa fa-plus"></i>
                                    Add New</a>
                                <a class="btn btn-danger mobile-btn float-right" href="#" id="barcode"><i class="fa fa-file"></i> Generate Barcode</a>
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
                            <form action="<?php echo base_url(); ?>libraryManagementSystem" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $bill_date; ?>" name="bill_date"  id="date" class="form-control input-sm datepicker" placeholder="By Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $bill_no; ?>" name="bill_no" id="no" class="form-control input-sm " placeholder="By Bill No" autocomplete="off">
                                        </div>
                                    </td> -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $price; ?>" name="price" id="price" class="form-control input-sm " placeholder="Price" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $access_no; ?>" name="access_no" id="access_no" class="form-control input-sm " placeholder="Accession No." autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $book_title; ?>" name="book_title" id="book_title" class="form-control input-sm" placeholder="By Book Title" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $category; ?>" name="category" id="category" class="form-control input-sm" placeholder="By Subject" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $author_name; ?>" name="author_name" id="author_name" class="form-control input-sm" placeholder="By author name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $publisher_name; ?>" name="publisher_name" id="publisher_name" class="form-control input-sm" placeholder="By publisher name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $no_of_copies; ?>" name="no_of_copies" id="no_of_copy" class="form-control input-sm" placeholder="By No. of Copies" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $year; ?>" name="year" id="year" class="form-control input-sm" placeholder="By year" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $shelf_no; ?>" name="shelf_no" id="shelf_no" class="form-control input-sm" placeholder="By shelf no" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th width="100">Bill No./Date</th>
                                    <!-- <th>Bill No.</th> -->
                                    <th>Price</th>
                                    <th>Accession No.</th>
                                    <!-- <th>ISBN</th> -->
                                    <th>Book Title</th>
                                    <th>Subject</th>
                                    <th>Author name</th>
                                    <th>Publisher Name</th>
                                    <th>No. of copies</th>
                                    <th>Year of Edition</th>
                                    <th>Shelf No.</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($libraryMgmtInfo)) {
                                    foreach ($libraryMgmtInfo as $library) { ?>
                                        <tr>
                                        <th><input type="checkbox" class="singleSelect" value="<?php echo $library->access_code; ?>" /></th>
                                        <th class="text-center"><?php if(empty($library->bill_date) || $library->bill_date == '0000-00-00'|| $library->bill_date == '1970-01-01'){
                                                        echo $library->bill_no;
                                                    } else{
                                                        echo date('d-m-Y',strtotime($library->bill_date)). ' ' . $library->bill_no;
                                                    } ?></th>
                                        <!-- <th class="text-center"><?php echo $library->bill_no; ?></th> -->
                                        <th class="text-center"><?php echo $library->price; ?></th>
                                        <th><?php echo strtoupper($library->access_code); ?></th>
                                            <!-- <th><?php echo strtoupper($library->isbn); ?></th> -->
                                          
                                            <th class="text-center"><?php echo $library->book_title; ?></th>
                                            <th class="text-center"><?php echo $library->category; ?></th>
                                            <th class="text-center"><?php echo $library->author_name; ?></th>
                                            <th class="text-center"><?php echo $library->publisher_name; ?></th>
                                            <th class="text-center"><?php echo $library->no_of_copies; ?></th>
                                            <th class="text-center"><?php echo $library->year; ?></th>
                                            <th class="text-center"><?php echo $library->shelf_no; ?></th>
                                            <th class="text-center">
                                                <!-- <span><a href="#" data-toggle="popover" data-content="Comment: <?php echo  $adm->comment; ?> <br/> "><span class="badge badge-primary"> <i class="fa fa-info-circle"></i></span></a></span> -->
                                                <?php if(!empty($library->upload_pdf)){ ?>
                                                    <a href="<?php echo $library->upload_pdf; ?>" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-file"></i>Preview</a>
                                                <?php  } ?>
                                                <?php if ($role == ROLE_ADMIN || $role == ROLE_LIBRARY || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_RECEPTION || $role == ROLE_SUPER_ADMIN) { ?>
                                                    <a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url(); ?>editLibrary/<?php echo $library->row_id; ?>" title="Edit Library Info"><i class="fas fa-pencil-alt"></i></a>
                                                    <a class="btn btn-xs btn-danger deleteLibraryDetails" href="#" data-row_id="<?php echo $library->row_id; ?>" title="Delete Library details"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    <?php }
                                } else {  ?>
                                    <tr>
                                        <th colspan="10" class="text-center">Library Record Not Found</th>
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


<script src="<?php echo base_url(); ?>assets/js/admission.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {

        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#byFilterMethod").attr("action", baseURL + "libraryManagementSystem/" + value);
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



            $('#barcode').click(function(){
            students = [];
            if ($('.singleSelect:checkbox:checked').length == 0) {
                alert("Select atleast one Book to generate barcode!");
                return;
            }
            $('.singleSelect:checked').each(function(i){
                students.push($(this).val());
            });
            students = JSON.stringify(students);
            // alert(students);
            window.open('<?php echo base_url(); ?>generateBarcodeForBook?row_id='+btoa(students));
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