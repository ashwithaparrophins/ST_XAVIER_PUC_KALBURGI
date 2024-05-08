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
<style>
      input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }
</style>
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
                                <i class="material-icons">directions_bus</i> Bus Management
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total Bus: <?php echo $totalBusCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">

                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            
                                <div class="dropdown mobile-btn float-right">
                                <button type="button" class="btn btn-primary dropdown-toggle border_right_radius"
                                    data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu p-0">
                                     <a class="dropdown-item" onclick="clearFields();"   type="reset" href="#" data-toggle="modal" id="btn_add"
                                    data-target="#myModal"><i class="fa fa-plus"></i> Add New</a>
                                </div>
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
                        <form action="<?php echo base_url(); ?>viewBusListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                   
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $vehicle_number; ?>" name="vehicle_number" id="vehicle_number" class="form-control input-sm" placeholder="By Vehicle Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $insurance_expiry_date; ?>" name="insurance_expiry_date" id="insurance_expiry_date" class="form-control input-sm datepicker" placeholder="Search Insurance Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $emission_expiry_date; ?>" name="emission_expiry_date" id="emission_expiry_date" class="form-control input-sm datepicker" placeholder="Search Emission Expiry Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $permit_date; ?>" name="permit_date" id="permit_date" class="form-control input-sm datepicker" placeholder="Search Permit Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $tax_expiry_date; ?>" name="tax_expiry_date" id="tax_expiry_date" class="form-control input-sm datepicker" placeholder="Search Tax Expiry Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $fitness_certificate_expiry_date; ?>" name="fitness_certificate_expiry_date" id="fitness_certificate_expiry_date" class="form-control input-sm datepicker" placeholder="Search Fitness Expiry Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <!-- <input type="text" value="<?php echo $route; ?>" name="route" id="route" class="form-control input-sm" placeholder="By Route" autocomplete="off"> -->
                                            <select class="form-control " name="route" id="route" >
                                                <?php if(!empty($by_class)){ ?>
                                                    <option value="<?php echo $route; ?>" selected><b>Selected: <?php echo $route; ?></b></option>
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
                                            <input type="text" value="<?php echo $driver_name; ?>" name="driver_name" id="driver_name" class="form-control input-sm" placeholder="By Driver Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $driver_mobile; ?>" name="driver_mobile" id="driver_mobile" class="form-control input-sm" placeholder="Driver Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $total_seat_capacity; ?>" name="total_seat_capacity" id="total_seat_capacity" class="form-control input-sm" placeholder="By Total Seat Capacity" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                    <th width="400" class="text-center">Vehicle Number</th>
                                    <th width="400" class="text-center">Insurance Expiry Date</th>
                                    <th width="400" class="text-center">Emission Expiry Date</th>
                                    <th width="700" class="text-center">Permit Expiry Date</th>
                                     <th width="700" class="text-center">Tax Expiry Date</th>
                                      <th width="400" class="text-center">Fitness Certificate Expiry Date</th>
                                    <th width="400" class="text-center">Route</th>
                                    <th width="400" class="text-center">Driver Name</th>
                                    <th class="text-center">Driver Number</th>
                                    <th width="150"class="text-center">Total Seat Capacity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($BusInfo)){
                                    foreach($BusInfo as $bus){ ?>
                                    <tr>
                                        <th width="400" class="text-center"><?php echo $bus->vehicle_number; ?></th>
                                        <th width="400" class="text-center"><?php echo date('d-m-Y',strtotime($bus->insurance_expiry_date)); ?></th>
                                        <th width="400" class="text-center"><?php echo date('d-m-Y',strtotime($bus->emission_expiry_date)); ?></th>
                                        <th width="400" class="text-center"><?php  if(empty($bus->permit_date) || $bus->permit_date == '0000-00-00'|| $bus->permit_date == '1970-01-01'){
                                                        echo "";
                                                    } else{
                                                        echo date('d-m-Y',strtotime($bus->permit_date));
                                                    } ?></th>
                                         <th width="400" class="text-center"><?php  if(empty($bus->tax_expiry_date) || $bus->tax_expiry_date == '0000-00-00'|| $bus->tax_expiry_date == '1970-01-01'){
                                                        echo "";
                                                    } else{
                                                        echo date('d-m-Y',strtotime($bus->tax_expiry_date));
                                                    } ?></th>
                                        <th width="400" class="text-center"><?php  if(empty($bus->fitness_certificate_expiry_date) || $bus->fitness_certificate_expiry_date == '0000-00-00'|| $bus->fitness_certificate_expiry_date == '1970-01-01'){
                                                        echo "";
                                                    } else{
                                                        echo date('d-m-Y',strtotime($bus->fitness_certificate_expiry_date));
                                                    } ?></th>
                                        <th width="400"><?php echo $bus->route; ?></th>
                                          <th width="400"><?php echo strtoupper($bus->driver_name); ?></th>
                                        <th class="text-center"><?php echo $bus->driver_mobile; ?></th>
                                         <th width="150" class="text-center"><?php echo $bus->total_seat_capacity; ?></th>
                                        <th class="text-center">
                                           
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE  || $role == ROLE_SUPER_ADMIN){ ?>
                                                    <a class="btn btn-xs btn-info" href="<?php echo base_url().'editBus/'.$bus->row_id; ?>" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <?php } if( $role == ROLE_ADMIN ||$role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN){ ?>
                                                    <a class="btn btn-xs btn-danger deleteBus" href="#" data-row_id="<?php echo $bus->row_id; ?>" title="Delete Bus"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="12" class="text-center">Bus Record Not Found</th>
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
        <div class="modal-dialog modal-lg mx-auto">
            <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add New Bus Details</h6>
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
            <div class="modal-body"   style="padding: 10px;">
              <form role="form" id="addBus" action="<?php echo base_url() ?>addNewBus" method="post" role="form">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                               <label for="exampleInputEmail1">Vehicle Number<span class="text-danger required_star">*</span></label>
                                 <input type="text" class="form-control required" name="vehicle_number" id="vehicle_number" maxlength="10" placeholder="Vehicle Number"autocomplete="off" required/>
                            </div>
                        </div>

                       <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Insurance Expiry Date<span class="text-danger required_star">*</span></label>
                                <input type="date" class="form-control required "
                                id="insurance_expiry_date"  name="insurance_expiry_date"
                                placeholder="Insurance Expiry Date" autocomplete="off" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Emission Expiry Date<span class="text-danger required_star">*</span></label>
                                <input type="date" class="form-control required" name="emission_expiry_date" id="emission_expiry_date" placeholder="Emission Expiry Date"autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permit Expiry Date</label>
                                <input type="date" class="form-control required" id="permit_date"  name="permit_date" placeholder="Permit Expiry Date" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tax Expiry Date<span class="text-danger required_star">*</span></label>
                                <input type="date" class="form-control required"
                                id="tax_expiry_date"  name="tax_expiry_date"
                                placeholder="Tax Expiry Date" autocomplete="off" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fitness Certificate Expiry Date<span class="text-danger required_star">*</span></label>
                                <input type="date" class="form-control required"
                                id="fitness_certificate_expiry_date"  name="fitness_certificate_expiry_date"
                                placeholder="Fitness Certificate Expiry Date" autocomplete="off" required/>
                            </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Driver Name<span class="text-danger required_star">*</span></label>
                                 <input type="text" class="form-control required" id="driver_name" maxlength="128" name="driver_name" placeholder="Driver Name" autocomplete="off" required>
                            </div>
                        </div>
                       <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Driver Mobile<span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required" name="driver_mobile" id="driver_mobile" onkeypress="return isNumberKey(event)" maxlength="10" pattern="[0-9]{10}" placeholder="Driver Mobile" autocomplete="off" required/>
                            </div>
                        </div>
                       
                     </div>
                   <div class="row">
                         <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Route<span class="text-danger required_star">*</span></label>
                                <select class="form-control selectpicker" id="route" name="route" data-live-search="true" required>
                                    <option value="">Select Route</option>
                                    <?php if(!empty($routeInfo)){
                                        foreach($routeInfo as $route){ ?>
                                        <option value="<?php echo $route->name; ?>"><?php echo $route->name; ?></option>
                                    <?php } } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Total Seat Capacity<span class="text-danger required_star">*</span></label>
                                 <input type="text" class="form-control required" onkeypress="return isNumberKey(event)" id="total_seat_capacity"  name="total_seat_capacity" placeholder="Total Seat Capacity" maxlength="3" autocomplete="off" required/>
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
        jQuery("#byFilterMethod").attr("action", baseURL + "viewBusListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    // jQuery('.datepicker,.dateSearch,.insurance,.service,.permit,.tax,.fitness').datepicker({
    //     autoclose: true,
    //     orientation: "bottom",
    //     format: "dd-mm-yyyy"

    // });

    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        endDate: "today"
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