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
                                <i class="material-icons" >work</i> Work Assigned </span>
                            </span>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4 text-center">
                            <b class="text-dark" style="font-size: 20px;">Total: <?php echo $studyRecordsCount; ?></b>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4">
                            <a class="btn btn-secondary btn_back mobile-btn float-right text-white border_left_radius btn-backtrack"
                                    value="Back" href="<?php echo base_url(); ?>dashboard"><i class="fa fa-arrow-circle-left"></i> Back </a>
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
                            <form action="<?php echo base_url() ?>viewWorkAssigned" method="POST" id="byFilterMethod">
                                 <th>
                                <div class="form-group"> 
                                    <input type="text" name="by_date" value="<?php echo $by_date; ?>" class="form-control form-control-md  datepicker pull-right" placeholder="Search by Date" autocomplete="off"/>
                                </div>
                              </th>

                              <th>
                                <div class="form-group"> 
                                    <input type="text" name="absentStaff" value="<?php echo $absentStaff; ?>" class="form-control form-control-md  pull-right" placeholder="Search by Absent Staff" autocomplete="off"/>
                                </div>
                              </th>

                               <th>
                              </th>

                                <th>
                                    <select class="form-control input-sm" id="assigned_class_name" name="assigned_class_name">
                                        <?php if($assigned_class_name != ""){ ?>
                                        <option value="<?php echo $assigned_class_name; ?>" selected><b>Sorted:
                                                <?php echo $assigned_class_name; ?></b></option>
                                        <?php } ?>
                                        <option value="">By Class</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                    

                                    </select>
                                </th>

                                <th>
                                    <select class="form-control input-sm" id="assigned_stream_name" name="assigned_stream_name">
                                        <?php if($assigned_class_name != ""){ ?>
                                        <option value="<?php echo $assigned_class_name; ?>" selected><b>Sorted:
                                                <?php echo $assigned_class_name; ?></b></option>
                                        <?php } ?>
                                        <option value="">By Stream</option>
                                        <?php if(!empty($streamInfo)){
                                  foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name ?>">
                                      <?php echo $stream->stream_name ?>
                                    </option>
                                <?php }  } ?>

                                    </select>
                                </th>
                               
                                <th>
                                    <select class="form-control input-sm" id="assigned_class_section" name="assigned_class_section">
                                        <?php if($assigned_class_section != ""){ ?>
                                            <option value="<?php echo $assigned_class_section; ?>" selected><b>Sorted:
                                            <?php echo $assigned_class_section; ?></b></option>
                                        <?php } ?>
                                        <option value="">By Batch</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                  </select>
                                </th>

                                <th>
                                <div class="form-group"> 
                                    <input type="text" name="assignedStaff" value="<?php echo $assignedStaff; ?>" class="form-control form-control-md  pull-right" placeholder="Search by Assigned Staff" autocomplete="off"/>
                                </div>
                              </th>

                                <th class="text-center"><button type="submit"
                                    class="btn btn-primary btn-md btn-block"> Search</button>
                                </th>
                            </form>
                        </tr>

                        <tr class="table_row_background text-dark text-center">
                            <th>Date</th>
                            <th>Absent Staff</th>
                            <th>Period</th>
                            <th>Class</th>
                            <th>Stream</th>
                            <th>Batch</th>
                            <th>Assigned staff</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($studyRecords)) {
                            foreach($studyRecords as $record) { ?>
                        <tr>
                            <td class="text-center"><?php echo date('d-m-Y',strtotime($record->assigned_date)) ?></td>
                            <td class="text-center"><?php echo $record->absentStaff; ?></td>
                            <td class="text-center"><?php echo $record->assigned_period; ?></td>
                            <td class="text-center"><?php echo $record->assigned_class_name; ?></td>
                            <td class="text-center"><?php echo $record->assigned_stream_name; ?></td>
                            <td class="text-center"><?php echo $record->assigned_class_section; ?></td>
                            <td><?php echo strtoupper($record->assignedStaff); ?></td>
                            <td class="text-center">
                                <?php if($role == ROLE_ADMIN || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $staff_id == '003') { ?>
                                <a class="btn btn-sm btn-danger deleteWorkAssigned px-2 py-1" href="#"
                                    data-row_id="<?php echo $record->row_id; ?>" title="Delete Work Assigned"><i
                                        class="fa fa-trash"></i></a>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php } }else{ ?>
                        <tr class="card_heading_title text-dark">
                            <td class="text-center" colspan="8">
                                Record not found!.
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


<script type="text/javascript">
jQuery(document).ready(function() {

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
        jQuery("#searchList").attr("action", baseURL + "viewWorkAssigned/" + value);
        jQuery("#searchList").submit();
    });

      jQuery(document).on("click", ".deleteWorkAssigned", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteWorkAssigned",
            currentRow = $(this);
        var confirmation = confirm("Are you sure to delete this Work assigned Info?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                    
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Work assigned successfully deleted"); }
                else if(data.status = false) { alert("Work assigned deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

 jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2020"
    });


});
</script>