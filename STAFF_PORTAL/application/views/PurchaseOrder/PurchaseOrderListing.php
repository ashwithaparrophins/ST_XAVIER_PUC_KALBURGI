 <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/css/timepicker.less" /> -->
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
<?php
        $warning = $this->session->flashdata('warning');
        if ($warning) {
        ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
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
                <div class="card card-small  p-0 m-b-1">
                    <div class="card-body p-2 card_heading_title">
                        <div class="row c-m-b ">
                            <div class="col-lg-5 col-12 col-md-12 box-tools ">
                                <span class="page-title">
                                <i class="material-icons"><span class="material-symbols-outlined">payments</span></i> Purchase Order Info 
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalSalaryCount; ?></b>
                            </div>
                          
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                            <a class="btn btn_back btn-primary mobile-btn float-right text-white border_left_radius btn-backtrack" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <a class="btn btn-success mobile-btn pull-right"
                                    href="<?php echo base_url() ?>addNewPurchaseOrder" ><i class="fa fa-plus"></i> Add New </a>
                            <div class="dropdown mobile-btn float-right">
                                    <!-- <button type="button" class="btn btn-info dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button> -->
                                    <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>

                                        <!-- <div class="dropdown-menu p-0"><a id="" class="dropdown-item " href="<?php echo base_url() ?>addNewPurchaseOrder" ><i class="fa fa-plus"></i> Add New</a>
                                        <a id="Salary_Print" class="dropdown-item " href="#"><i class="fa fa-file"></i>Print</a>
                                        
                                        <div class="dropdown-divider m-0"></div>
                                        <div class="dropdown-divider m-0"></div>
                                    </div> -->
                                    <?php } ?>
                                    
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                        <form action="<?php echo base_url(); ?>PurchaseOrderListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $date; ?>" name="date" id="date" class="form-control input-sm dateSearch" placeholder="Search Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $PO_NO; ?>" name="PO_NO" id="PO_NO" class="form-control input-sm" placeholder="Search PO No." autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $party_name; ?>" name="party_name" id="party_name" class="form-control input-sm" placeholder="By Party Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $due_date; ?>" name="due_date" id="due_date" class="form-control input-sm dateSearch" placeholder="Search Due Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $total_amount; ?>" name="total_amount" id="total_amount" class="form-control input-sm" placeholder="Total Amount" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $created_by; ?>" name="created_by" id="created_by" class="form-control input-sm" placeholder="Created By" autocomplete="off">
                                        </div>
                                    </td>
                                  
                                    
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th class="text-center"  width="120">Date</th>
                                    <th class="text-center"  width="120">PO No.</th>
                                    <th class="text-center" width="140">Party Name</th>
                                    <th class="text-center" width="140">Due Date</th>
                                    <th class="text-center" width="140">Total Amount</th>
                                    <th class="text-center" width="140">Created By</th>
                                    <th class="text-center" width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($OrderInfo)){
                                    foreach($OrderInfo as $order){ ?>
                                    <tr>
                                    <th><input type="checkbox" class="singleSelect" value="<?php echo $order->row_id; ?>" /></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($order->date)); ?></th>
                                        <th class="text-center"><?php echo $order->row_id; ?></th>
                                        <th ><?php echo $order->party_name; ?></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($order->due_date)); ?></th>
                                        <th class="text-center"><?php echo custom_round_format_number($order->total_amount); ?></th>
                                        <th class="text-center"><?php echo $order->created_by; ?></th>
                                        <th class="text-center" width="180">
                                            
                                            <?php if($role == ROLE_ADMIN  || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){  ?>
                                            <a class="btn btn-xs btn-danger deletePurchaseOrder" href="#" data-row_id="<?php echo $order->row_id; ?>" title="Delete Salary Slip"><i class="fa fa-trash"></i></a>
                                            <a class="btn btn-xs btn-primary" target="_blank"
                                                href="<?php echo base_url() ?>viewPrintPurchaseOrder/<?php echo $order->row_id; ?>"
                                                title="Print"><i class="fa fa-print"></i></a> 
                                                <?php if($order->status != 'LOCKED'){ ?>
                                            <a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url(); ?>editPurchaseOrder/<?php echo $order->row_id; ?>" title="Edit Party"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                    <?php } ?>
                                                        <!-- like button if returned -->
                                                    <?php if(empty($order->status)){ 
                                                        ?>
                                                    <a onclick="openModel('<?php echo $order->row_id; ?>')" style="color: white;"
                                                    class="btn btn-xs btn-success mobile-btn" href="#" title="Payment Mode">
                                                    <i class="fa fa-thumbs-up"></i> </a>

                                                   
                                            <?php   } else{?>
                                                 <a  onclick="openModel2('<?php echo $order->row_id; ?>')"style="color: white;"
                                                    class="btn btn-xs btn-danger mobile-btn" href="#" title="Payment Mode">
                                                    <i class="fa fa-thumbs-up"></i> </a>

                                                  <?php } } ?>
                                            
                                                  <?php //log_message('debug','zzzzz'.$this->staff_id); ?>
                                                      <?php if($this->staff_id == "207" || $this->staff_id == "208") { ?>
                                                        <?php //log_message('debug','zzzzz'.$this->staff_id); ?>

                                                  <?php if($order->status != 'LOCKED'){ ?>

                                                     <a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url(); ?>editPurchaseOrder/<?php echo $order->row_id; ?>" title="Edit Party"><i
                                                      class="fas fa-pencil-alt"></i></a>
                                                    <?php } } ?>

                                            
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="10" class="text-center"> Record Not Found</th>
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

  <!-- modal Bigin -->
  <div class="row">
            <div class="col">
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header modal-call-report p-2">
                                <div class=" col-md-10 col-10">
                                    <span class="text-white mobile-title" style="font-size : 20px">lock?</span>
                                </div>
                                <div class=" col-md-2 col-2">
                                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                                </div>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <?php $this->load->helper("form"); ?>
                                <form role="form" id="addUnitInfo" action="<?php echo base_url() ?>lock" method="post"
                                    role="form">
                                    <input type="hidden" name="order_row_id" id="student_id">
                                    <div class="row form-contents">
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                            <input type="radio" id="status" name="status" value="Yes" required>
                                             <label for="status">Yes</label>
        
        
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" style="flaot : left" value="Submit" />
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- unlock -->
         <!-- modal Bigin -->
  <div class="row">
            <div class="col">
            <div id="myModal2" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header modal-call-report p-2">
                                <div class=" col-md-10 col-10">
                                    <span class="text-white mobile-title" style="font-size : 20px">Unlock?</span>
                                </div>
                                <div class=" col-md-2 col-2">
                                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                                </div>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <?php $this->load->helper("form"); ?>
                                <form role="form" id="addUnitInfo" action="<?php echo base_url() ?>unlock" method="post"
                                    role="form">
                                    <input type="hidden" name="order_row_id2" id="student_id2">
                                    <div class="row form-contents">
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                            <input type="radio" id="status2" name="status2" value="Yes" required>
                                             <label for="status">Yes</label>
        
        
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" style="flaot : left" value="Submit" />
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
<script type="text/javascript">

 $('.start_time').datetimepicker(
        {
            
          format: 'hh:mm A',
          icons: {
                    up: "fa fa-chevron-up",
                  down: "fa fa-chevron-down"
                 },

       });
 
jQuery(document).ready(function() {
    $("form").submit(()=>{
        showLoader();
    });
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "PurchaseOrderListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        startDate: new Date(),
        format: "dd-mm-yyyy"
    });

    jQuery(document).on("click", ".deletePurchaseOrder", function(){
            
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deletePurchaseOrder",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure to delete this Purchase Order ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Purchase Order successfully deleted"); }
                    else if(data.status = false) { alert("Purchase Order deletion failed"); }
                    else { alert("Access denied..!"); }
                });
            }
        });

    jQuery('.dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"
    });

     $('.btn-number').click(function(e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }


    });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
$('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
      $('[data-toggle="popover"]').mouseenter(function(){
          $(this).trigger('focus');
      });
    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
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

        $('#Salary_Print').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to print tranfer certificate!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getStaffSalaryPrint?student_id=' + btoa(students));
    });

 });  

 function openModal(row_id, visitor_name, visit_date, in_time, mobile_number, visited_vehicle_number, name, visiting_reason, total_visitor, visit_out_date, out_time, visit_status, visitor_type_name) {
 let vDate = new Date(visit_date);
            let visiting_date = appendLeadingZeroes(vDate.getDate()) + "-" +
                appendLeadingZeroes((vDate.getMonth() + 1)) +
           "-" + vDate.getFullYear();

 let oDate = new Date(visit_out_date);
            let out_date = appendLeadingZeroes(oDate.getDate()) + "-" +
                appendLeadingZeroes((oDate.getMonth() + 1)) +
           "-" + oDate.getFullYear();

    $("#name").html(visitor_name); 
    $('#visitorName').html(visitor_name);
     $('#visitorId').val(row_id);
    $('#visitDate').html(visiting_date);
    $('#visitIntime').html(in_time);
    $('#mobileNumber').html(mobile_number);
    $('#vehicleNumber').html(visited_vehicle_number);
    $('#staffName').html(name);
    $('#reason').html(visiting_reason);
    $('#totalVisitor').html(total_visitor);
    $('#typeName').html(visitor_type_name);

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = dd + '-' + mm + '-' + yyyy;

   if(out_date == '' || out_date =='0000-00-00' || out_date=='NaN-NaN-NaN' || out_date == '01-01-1970'){
              $('#visitOutDate').val(today);   
         }else{
            $('#visitOutDate').val(out_date);
      
         }
   
// To get current Time
    var todayDate = new Date();
    var getTodayDate = todayDate.getDate();
    var getTodayMonth =  todayDate.getMonth()+1;
    var getTodayFullYear = todayDate.getFullYear();
    var getCurrentHours = todayDate.getHours();
    var getCurrentMinutes = todayDate.getMinutes();
    var getCurrentAmPm = getCurrentHours >= 12 ? 'PM' : 'AM';
    getCurrentHours = getCurrentHours % 12;
    getCurrentHours = getCurrentHours ? getCurrentHours : 12; 
    getCurrentMinutes = getCurrentMinutes < 10 ? '0'+getCurrentMinutes : getCurrentMinutes;
    var getCurrentDateTime = getCurrentHours + ':' + getCurrentMinutes + ' ' + getCurrentAmPm;

   if(out_time == ''){
     $('#visitOutime').val(getCurrentDateTime);
    }else{
           $('#visitOutime').val(out_time);    
         }
 var statusPending = "Waiting";
 var statusComplete = "Visited";
 var statusAccepted = "Accepted";
   if(visit_status == '0'){
     $('#visitStatus').html(statusPending);
   }else if(visit_status == '1'){
    $('#visitStatus').html(statusComplete);
   }else{
     $('#visitStatus').html(statusAccepted);
   }
   

 }

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
function openModel(student_id) {
   
   $('#student_id').val(student_id); 
   $('#myModal').modal('show');
}
   function openModel2(student_id) {
   
   $('#student_id2').val(student_id); 
   $('#myModal2').modal('show');


}
//popover for info
// $(document).ready(function(){
  
//     $('[data-toggle="popover"]').popover({"html":true});
// });

</script>
<?php 

function custom_round_format_number($number) {
    $rounded_number = round($number); // Round off the number
    $formatted_number = number_format($rounded_number, 2, '.', ''); // Format the rounded number
    $parts = explode('.', $formatted_number);

    $whole_number = $parts[0];
    $length = strlen($whole_number);

    $formatted_whole_number = '';

    $last_three_digits = substr($whole_number, -3); // Extract last three digits
    $rest_of_number = substr($whole_number, 0, -3); // Extract the rest of the number

    while (strlen($rest_of_number) > 0) {
        $group = substr($rest_of_number, -2); // Get the last two digits
        if (!empty($formatted_whole_number)) {
            $formatted_whole_number = ',' . $formatted_whole_number;
        }
        $formatted_whole_number = $group . $formatted_whole_number;
        $rest_of_number = substr($rest_of_number, 0, -2); // Remove the last two digits
    }

    if (!empty($formatted_whole_number)) {
        $formatted_whole_number = $rest_of_number . $formatted_whole_number . ',' . $last_three_digits;
    } else {
        $formatted_whole_number = $whole_number;
    }

    $formatted_number = $formatted_whole_number . '.' . $parts[1]; // Combine with decimal part

    return $formatted_number;
}
function custom_format_number($number) {
    $formatted_number = number_format($number, 2, '.', ''); // Remove decimal point temporarily
    $parts = explode('.', $formatted_number);

    $whole_number = $parts[0];
    $length = strlen($whole_number);

    $formatted_whole_number = '';

    $last_three_digits = substr($whole_number, -3); // Extract last three digits
    $rest_of_number = substr($whole_number, 0, -3); // Extract the rest of the number

    while (strlen($rest_of_number) > 0) {
        $group = substr($rest_of_number, -2); // Get the last two digits
        if (!empty($formatted_whole_number)) {
            $formatted_whole_number = ',' . $formatted_whole_number;
        }
        $formatted_whole_number = $group . $formatted_whole_number;
        $rest_of_number = substr($rest_of_number, 0, -2); // Remove the last two digits
    }

    if (!empty($formatted_whole_number)) {
        $formatted_whole_number = $rest_of_number . $formatted_whole_number . ',' . $last_three_digits;
    } else {
        $formatted_whole_number = $whole_number;
    }

    $formatted_number = $formatted_whole_number . '.' . $parts[1]; // Combine with decimal part

    return $formatted_number;
}
?>