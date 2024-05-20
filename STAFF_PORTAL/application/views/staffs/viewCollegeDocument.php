<?php

            $this->load->helper('form');

            $error = $this->session->flashdata('error');

            if($error)

            {

        ?>

<div class="alert alert-danger alert-dismissable">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    <?php echo $this->session->flashdata('error'); ?>

</div>

<?php } ?>

<?php  

            $success = $this->session->flashdata('success');

            if($success)

            {

        ?>

<div class="alert alert-success alert-dismissable">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    <?php echo $this->session->flashdata('success'); ?>

</div>

<?php } ?>



<?php  

            $noMatch = $this->session->flashdata('nomatch');

            if($noMatch)

            {

        ?>

<div class="alert alert-warning alert-dismissable">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    <?php echo $this->session->flashdata('nomatch'); ?>

</div>

<?php } ?>







<!-- Content Header (Page header) -->

<div class="main-content-container px-3 pt-1">

    <div class="row">

        <div class="col-md-12">

            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>

        </div>

    </div>

    <div class="row p-0">

        <div class="col column_padding_card">

            <div class="card card-small card_heading_title p-0 m-b-1">

                <div class="card-body p-2">

                    <div class="row c-m-b">

                        <div class="col-lg-4 col-sm-4 col-12">

                            <span class="page-title absent_table_title_mobile">

                                <i class="fa fa-book"></i> Documents </span>

                            </span>

                        </div>

                        <div class="col-lg-4 col-6 col-sm-4 text-center">

                            <b class="text-dark" style="font-size: 20px;">Total Documents:
                                <?php echo $studyRecordsCount; ?></b>

                        </div>

                        <div class="col-lg-4 col-6 col-sm-4">

                            <a onclick="window.history.back();"
                                class="btn btn-secondary mobile-btn float-right text-white border_left_radius"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_PRINCIPAL  || $role == ROLE_SUPER_ADMIN || $role == ROLE_DIRECTOR) {

                                ?>

                            <button class="btn btn-danger float-right mobile-btn border_right_radius"
                                data-toggle="modal" data-target="#addNewDocModel"><i class="fa fa-plus"></i> Add
                                New</button>

                            <?php } ?>

                        </div>

                        <div class="col-lg-4">



                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="row form-employee">

        <div class="col-12 column_padding_card">

            <div class="card card-small c-border p-2">

                <div class="table-responsive-sm">

                    <table class="table table-hover table-bordered mb-0">

                        <tr class="row_filter">

                            <form action="<?php echo base_url() ?>viewDocumentInfo" method="POST" id="byFilterMethod">

                                <th>

                                    <input type="text" value="<?php echo $by_date; ?>" name="by_date" id=""
                                        class="form-control datepicker input-sm text-uppercase"
                                        placeholder="Date" autocomplete="off">

                                </th>

                                <th>

                                    <select class="form-control input-sm" id="" name="by_year">

                                        <?php if($by_year != ""){ ?>

                                        <option value="<?php echo $by_year; ?>" selected><b>Sorted:

                                                <?php echo $by_year; ?></b></option>

                                        <?php } ?>

                                        <option value="">By Year</option>
                                        <option value="2024">2024</option>

                                    </select>

                                </th>


                                <th>

                                    <select class="form-control input-sm" id="type" name="type">

                                        <?php if($type != ""){ ?>

                                        <option value="<?php echo $type; ?>" selected><b>Sorted:

                                                <?php echo $type; ?></b></option>

                                        <?php } ?>

                                        <option value="">By Type</option>

                                        <?php foreach($documentTypeInfo as $doc){ ?>
                                    <option value="<?php echo $doc->document_name ?>"><?php echo $doc->document_name ?></option>
                                   <?php } ?>

                                    </select>

                                </th>

                                <th>
                                <input type="text" value="<?php echo $doc_name; ?>" name="doc_name" id=""
                                    class="form-control  input-sm"
                                    placeholder="Enter Document Name" autocomplete="off">
                                </th>


                                <th>

                                </th>

                                <th>

                                <input type="text" value="<?php echo $by_expiry_date; ?>" name="by_expiry_date" id=""
                                    class="form-control datepicker input-sm text-uppercase"
                                    placeholder="Expiry Date" autocomplete="off">

                                </th>



                                <th>
                                <input type="text" value="<?php echo $by_description; ?>" name="by_description" id=""
                                    class="form-control  input-sm"
                                    placeholder="Enter Description" autocomplete="off">
                                </th>



                                <th class="text-center"><button type="submit" class="btn btn-primary btn-md btn-block">
                                        Search</button>

                                </th>

                            </form>

                        </tr>



                        <tr class="table_row_background text-dark text-center">

                            <th width="150">Date</th>

                            <th width="150">Year</th>

                            <th width="150">Doc Type</th>
                            <th width="150">Doc Name</th>

                            <th width="150">Document</th>
                            <th width="150">Expiry Date</th>

                            <th>Description</th>

                            <th width="100">Actions</th>

                        </tr>

                        <?php if(!empty($studyRecords)) {

                            foreach($studyRecords as $record) { ?>

                        <tr>

                            <td class="text-center"><?php echo date('d-m-Y',strtotime($record->date)); ?></td>

                            <td class="text-center"><?php echo $record->document_year; ?></td>

                            <td><?php echo $record->type; ?></td>
                            <td><?php echo $record->doc_name; ?></td>


                            <td class="text-center">
                                <!-- <a href="<?php echo base_url().$record->document_name_url; ?>"
                                    download>Download</a> -->
                                    <a href="<?php echo base_url(); ?><?php echo $record->document_name_url; ?>"
                                                                target="_blank"> View</a>

                            </td>

                            <?php if($record->expiry_date == '01-01-1970' || $record->expiry_date == '' || $record->expiry_date == '1970-01-01' || $record->expiry_date == '0000-00-00'){
                                    $expiry_Date = '';
                                  }else{ 
                                    $expiry_Date = date('d-m-Y',strtotime($record->expiry_date));
                                  }?>

                                    <?php if(strtotime(date('Y-m-d')) > strtotime($expiry_Date)){ ?>
                                        <td class="text-center" style = "color:red">
                                        <?php echo $expiry_Date; ?></td>
                                     <?php }else{ ?>
                                         <td class="text-center">
                                         <?php echo $expiry_Date; ?></td>
                                    <?php } ?>
                            <!-- <td class="text-center"><?php echo $expiry_Date; ?></td> -->


                            <td><?php echo $record->description; ?></td>

                            <td class="text-center">

                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL  || $role == ROLE_SUPER_ADMIN || $role == ROLE_DIRECTOR) { ?>

                                <a class="btn btn-sm btn-danger deleteDocument px-2 py-1" href="#"
                                    data-row_id="<?php echo $record->row_id; ?>" title="Delete Document"><i
                                        class="fa fa-trash"></i></a>

                                <?php } ?>



                            </td>

                        </tr>

                        <?php } }else{ ?>

                        <tr class="card_heading_title text-dark">

                            <td class="text-center" colspan="8">

                                Document not found!.

                            </td>

                        </tr>

                        <?php } ?>

                    </table>

                </div>

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-12">

                        <?php echo $this->pagination->create_links(); ?>

                    </div>

                </div>

            </div>

        </div>

    </div>





</div>



<!-- The Modal -->

<div class="modal" id="addNewDocModel">

    <div class="modal-dialog modal-lg">

        <div class="modal-content ">

            <!-- Modal Header -->

            <div class="modal-header">

                <h4 class="modal-title">Add New Document</h4>

                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>



            <!-- Modal body -->

            <div class="modal-body p-2">

                <form action="<?php echo base_url() ?>addNewDocumentDetails" method="POST" role="form"
                    enctype="multipart/form-data">

                    <div class="text-center" id="alertMsg"></div>

                    <div class="row">

                        <div class="col-lg-12 ">

                            <div class="form-group">

                                <img src="<?php echo base_url(); ?>assets/images/file.png" class="avatar" width="30"
                                    height="40" src="#" id="uploadedImage" name="userfile" width="80" height="80"
                                    alt="avatar">

                                <label for="fname">Select a Document </label>

                                <input type="file" class="form-control" id="doc_path" name="doc_path"
                                    accept=".pdf,.doc,.docx,.xlsx,.csv,.xls,.ppt,.pptx,.jpeg,.png,.jpg" required>

                                <label class="text-danger" style="font-size:15px">File Format:
                                    pdf,doc,docx,xlsx,csv,xls,ppt,pptx<span class="pl-2">Maximum File Size 50
                                        MB</span></label>

                            </div>

                        </div>

                    </div>

                    <div class="row">



                    </div>



                    <div class="row">

                        <div class="col-lg-6">
                            <label for="cl">Date</label>

                            <div class="form-group">

                                <input id="" type="text" placeholder="Enter Date" name="date" 
                                    class="form-control datepicker required" value="" autocomplete="off" required />


                            </div>

                        </div>

                        <div class="col-lg-6">
                            <label for="cl">Document Name</label>

                            <div class="form-group">

                                <input id="" type="text" placeholder="Enter Document Name" name="doc_name" 
                                    class="form-control required" value="" autocomplete="off" required />


                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-6">

                            <label for="cl">Document Type</label>

                            <div class="form-group">

                                <select class="form-control input-sm selectpicker" data-live-search="true" id="doc_type" name="doc_type" required>

                                    <option value="">Select Doc Type</option>
                                   
                                    <?php foreach($documentTypeInfo as $doc){ ?>
                                    <option value="<?php echo $doc->document_name ?>"><?php echo $doc->document_name ?></option>
                                   <?php } ?>

                                </select>

                            </div>

                        </div>


                        <div class="col-lg-6 col-sm-6">

                            <label for="cl">Year</label>

                            <div class="form-group">

                                <select class="form-control input-sm" id="document_year" name="document_year" required>

                                    <option value="">Select Year</option>

                                    <option value="2024">2024</option>
                                    <!-- <option value="2023">2023</option>

                                    <option value="2022">2022</option> -->

                                </select>

                            </div>

                        </div>
                        <div class="col-lg-6">
                            <label for="cl">Document Expiry Date</label>

                            <div class="form-group">

                                <input id="" type="text" placeholder="Enter Document Expiry Date" name="expiry_date" 
                                    class="form-control datepicker required" value="" autocomplete="off" />


                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <textarea class="form-control" rows="5" placeholder="Remarks"
                                    id="description" name="description"></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer pt-2 pb-0">

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/studyMaterial.js" charset="utf-8"></script>

<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        endDate: ""
    });

    jQuery(document).on("click", ".deleteDocument", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteDocument",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Document?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                currentRow.parents('tr').remove();
                if(data.status = true) { 
                    alert("Document successfully deleted");
                    window.location.reload();
                 }
                else if(data.status = false) { alert("Document deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });




    $('#selectAll').click(function() {

        if ($('#selectAll').is(':checked')) {

            $('.singleSelect').prop('checked', true);

        } else {

            $('.singleSelect').prop('checked', false);

        }

    });



    jQuery('ul.pagination li a').click(function(e) {

        e.preventDefault();

        var link = jQuery(this).get(0).href;

        var value = link.substring(link.lastIndexOf('/') + 1);

        jQuery("#searchList").attr("action", baseURL + "viewStudyMaterials/" + value);

        jQuery("#searchList").submit();

    });









});
</script>