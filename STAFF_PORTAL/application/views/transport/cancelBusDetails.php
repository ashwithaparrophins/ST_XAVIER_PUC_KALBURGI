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
                                <i class="material-icons">directions_bus</i> Cancelled Bus Student Details
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total Bus: <?php echo $totalBusCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">

                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border-left-radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            
                                <div class="dropdown mobile-btn float-right">
                                <!-- <button type="button" class="btn btn-primary dropdown-toggle border_right_radius"
                                    data-toggle="dropdown">
                                    Action
                                </button> -->
                                <!-- <div class="dropdown-menu p-0"> -->
                                     <a  class="btn btn-danger mobile-btn float-right text-white border_right_radius"  onclick="clearFields();"   type="reset" href="#" data-toggle="modal" id="btn_add"
                                    data-target="#myModal"><i class="fa fa-plus"></i> Add New</a>
                                <!-- </div> -->
                              </div>

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
                        <form action="<?php echo base_url(); ?>cancelBusListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                   
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $sat_number; ?>" name="sat_number" id="sat_number" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $std_name; ?>" name="std_name" id="std_name" class="form-control input-sm" placeholder="Search Student Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control " name="class" id="class" >
                                                <?php if(!empty($class)){ ?>
                                                    <option value="<?php echo $class; ?>" selected><b>Selected: <?php echo $class; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Class</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                              
                                            </select>
                                        </div>
                                    </td>
                                    
                                 
                                    
                                    <td>
                                        <div class="form-group mb-0">
                                           
                                            <select class="form-control " name="route_from" id="route" >
                                                <?php if(!empty($route_from)){ ?>
                                                    <option value="<?php echo $route_from; ?>" selected><b>Selected: <?php echo $route_from; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Route</option>
                                                <?php if(!empty($routeInfo)){
                                                    foreach($routeInfo as $route){ ?>
                                                        <option value="<?php echo $route->name; ?>"><?php echo $route->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $join_date; ?>" name="join_date" id="joined_date" class="form-control input-sm datepicker" placeholder="Search Join Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $end_date; ?>" name="end_date" id="last_date" class="form-control input-sm datepicker" placeholder="Search End Date" autocomplete="off">
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                    <th width="400" class="text-center">Student ID</th>
                                    <th width="400" class="text-center">Student Name</th>
                                    <th width="400" class="text-center">Class</th>
                                    <th width="400" class="text-center">Route</th>
                                    <th width="400" class="text-center">Join Date</th>
                                    <th width="400" class="text-center">End Date</th>

                                    <!-- <th width="700" class="text-center">Permit Expiry Date</th> -->
                                 
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($BusInfo)){
                                    foreach($BusInfo as $bus){ ?>
                                    <tr>
                                        <th width="400" class="text-center"><?php echo $bus->student_id; ?></th>
                                        <th width="400" class="text-center"><?php echo strtoupper($bus->student_name); ?></th>
                                      
                                        <th width="400" class="text-center"><?php echo $bus->term_name; ?></th>
                                        
                                        <th width="400" class="text-center"><?php echo $bus->route_name; ?></th>
                                        <th width="400" class="text-center"><?php echo date('d-m-Y',strtotime($bus->bus_joined_date)); ?></th>
                                        <th width="400" class="text-center"><?php echo date('d-m-Y',strtotime($bus->bus_end_date)); ?></th>
                                       
                                        <th class="text-center">
                                           
                                            <?php  if( $role == ROLE_ADMIN ||$role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE ){ ?>
                                                    <a class="btn btn-xs btn-danger deleteCancelBus" href="#" data-row_id="<?php echo $bus->row_id; ?>" title="Delete Bus"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="12" class="text-center"> Record Not Found</th>
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
     <div class="modal" id="myModal">
        <div class="modal-dialog modal-md mx-auto">
            <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Cancelled Student Bus Details</h6>
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
            <div class="modal-body"   style="padding: 10px;">
              <form role="form" id="addBus" action="<?php echo base_url() ?>updateCancelBus" method="post" role="form">
                    
                   <div class="row">
                         <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Select Student<span class="text-danger required_star">*</span></label>
                                <select class="form-control selectpicker" id="row_id" name="row_id" data-live-search="true" required>
                                    <option value="">Select Student</option>
                                    <?php if(!empty($studentInfo)){
                                        foreach($studentInfo as $route){ ?>
                                        <option value="<?php echo $route->row_id; ?>"><?php echo $route->student_id.' - '.$route->application_no.' - '.$route->student_name.' - '.$route->term_name; ?></option>
                                    <?php } } ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Join Date<span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required datepicker" name="join_date" id="join_date" placeholder="Join Date"autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">End Date <span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required datepicker" id="end_date"  name="end_date" placeholder="End Date" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12"> 
                                <button type="button" class="btn btn-danger"  data-dismiss="modal" >Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</div>




<script src="<?php echo base_url(); ?>assets/js/transport.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "cancelBusListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker,.dateSearch,.insurance,.service,.permit,.tax,.fitness').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
 
});
 function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>