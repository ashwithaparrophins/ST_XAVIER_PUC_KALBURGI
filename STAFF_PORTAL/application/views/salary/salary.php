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
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                <i class="material-icons"><span class="material-symbols-outlined">payments</span></i> Salary Slip Info 
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalSalaryCount; ?></b>
                            </div>
                        
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">

                            <a onclick="showLoader();window.history.back();" class="btn btn-primary mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-info dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>

                                        <div class="dropdown-menu p-0"><a id="" class="dropdown-item " href="#" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus"></i> Generate Salary slip</a>
                                        <a id="Salary_Print" class="dropdown-item " href="#"><i class="fa fa-file"></i>Print</a>
                                        
                                        <div class="dropdown-divider m-0"></div>
                                        <div class="dropdown-divider m-0"></div>
                                    </div>
                                    <?php } ?>
                                    
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
                        <form action="<?php echo base_url(); ?>salarySlipListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $date; ?>" name="date" id="date" class="form-control input-sm dateSearch" placeholder="Search Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $name; ?>" name="name" id="name" class="form-control input-sm" placeholder="By Staff Name" autocomplete="off">
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $basic; ?>" name="basic" id="basic" class="form-control input-sm" placeholder="By Basic Salary" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $working_day; ?>" name="working_day" id="working_day"  class="form-control input-sm" placeholder="By Working Days"   autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $gross_salary; ?>" name="gross_salary" id="mobile_number"  class="form-control input-sm" placeholder="By Gross Salary"   autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select id="by_month" name="by_month" class="form-control" placeholder="By Month">
                                            <?php if(!empty($by_month)){?>
                                            <option value="<?php echo $by_month; ?>" selected>Selected:<?php echo $by_month; ?></option>     
                                            <?php }?>
                                             <option value="">Select Month</option>
                                            <option value='January'>January</option>
                                            <option value='February'>February</option>
                                            <option value='March'>March</option>
                                            <option value='April'>April</option>
                                            <option value='May'>May</option>
                                            <option value='June'>June</option>
                                            <option value='July'>July</option>
                                            <option value='August'>August</option>
                                            <option value='September'>September</option>
                                            <option value='October'>October</option>
                                            <option value='November'>November</option>
                                            <option value='December'>December</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select id="by_year" name="by_year" class="form-control" placeholder="By Year">
                                            <?php if(!empty($by_year)){?>
                                            <option value="<?php echo $by_year; ?>" selected>Selected:<?php echo $by_year; ?></option>     
                                            <?php }?>
                                                <option value="">Select Year</option>
                                                <option value="2024">2024</option>
                                            </select>
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
                                    <th class="text-center" width="140">Name</th>
                                    <!-- <th class="text-center" width="140">Institution Name</th> -->
                                    <th class="text-center" width="140">Basic Salary</th>
                                    <th class="text-center" width="140">Working Days</th>
                                    <th class="text-center" width="140">Net Salary Paid</th>
                                    <th class="text-center" width="140">Month</th>
                                    <th class="text-center" width="140">Year</th>
                                    <th class="text-center" width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($salaryInfo)){
                                    foreach($salaryInfo as $salary){ ?>
                                    <tr>
                                    <th><input type="checkbox" class="singleSelect" value="<?php echo $salary->row_id; ?>" /></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($salary->date)); ?></th>
                                        <th ><?php echo strtoupper($salary->name); ?></th>
                                        <!-- <th ><?php echo strtoupper($salary->factory_name); ?></th> -->
                                        <th class="text-center"><?php echo $salary->basic; ?></th>
                                        <th class="text-center"><?php echo $salary->working_day; ?></th>
                                        <th class="text-center"><?php echo round($salary->net_amount,2); ?></th>
                                        <th class="text-center"><?php echo $salary->month; ?></th>
                                        <th class="text-center"><?php echo $salary->year; ?></th>
                                        <th class="text-center" width="180">
                                        <?php $gross_salary = $salary->basic + $salary->hr + $salary->da + $salary->ot_amount ?>
                                           <a href="#" class="btn btn-xs btn-success" title="<b><?php echo $salary->name; ?></b>" data-toggle="popover" data-placement="left"  data-trigger="focus" data-content="<b>A/C No: <?php echo $salary->account_no; ?><br> Basic:<?php echo $salary->basic; ?> <br> No. Of Days:<?php echo $salary->total_days; ?><br> Days Worked:<?php echo $salary->working_day; ?></b> <br> <b> DA:<?php echo $salary->da; ?><br> HR:<?php echo $salary->hr; ?><br> Gross Salary: <?php echo $gross_salary; ?><br> Total Salary:<?php echo $salary->total_salary; ?><br> PF:<?php echo round($salary->pf,2); ?><br> ESI:<?php echo round($salary->esi,2); ?>
                                           <br> Total deduction:<?php echo round($salary->total_deduction,2); ?><br> Net Amount:<?php echo round($salary->net_amount,2); ?>"></b><i class="fa fa-info"></i></a>
                                            
                                            <?php if($role == ROLE_ADMIN  || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN || $role == ROLE_DIRECTOR
){  ?>
                                            <!-- <a class="btn btn-xs btn-danger deleteSalarySlip" href="#" data-row_id="<?php echo $salary->row_id; ?>" title="Delete Salary Slip"><i class="fa fa-trash"></i></a> -->
                                                   
                                                  <?php }  ?>

                                            
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
  <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg mx-auto">
            <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Salary Slip </h6>
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
            <div class="modal-body"   style="padding: 10px;">
              <!-- <form role="form" id="addVisitor" action="<?php echo base_url() ?>addSalarySlip" method="post" role="form" method="POST" role="form" enctype="multipart/form-data"> -->
              <form role="form" id="addVisitor" action="<?php echo base_url() ?>addWorkingDaysToSalarySlip" method="post" role="form" method="POST" role="form" enctype="multipart/form-data">
                <div class="row">

                         
                        <div class="col-lg-6 col-12">
                             <div class="form-group">
                                <label for="exampleInputEmail1">Select Year</label>
                                <select class="form-control"  id="year" name="year" required>
                                <!-- <option value="">Select Year</option> -->
                                <!-- <option value="2023">2023</option> -->
                                <option value="2024">2024</option>
                             </select> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                             <div class="form-group">
                                <label for="exampleInputEmail1">Select Month</label>
                                <select class="form-control"  id="month" name="month" required>
                                <option value="">Select Month</option>
                                <option value='January'>January</option>
                                <option value='February'>February</option>
                                <option value='March'>March</option>
                                <option value='April'>April</option>
                                <option value='May'>May</option>
                                <option value='June'>June</option>
                                <option value='July'>July</option>
                                <option value='August'>August</option>
                                <option value='September'>September</option>
                                <option value='October'>October</option>
                                <option value='November'>November</option>
                                <option value='December'>December</option>
                             </select> 
                            </div>
                        </div>
                      
                    </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12"> 
                                <button type="button" class="btn btn-danger"  data-dismiss="modal" >Close</button>
                                <button type="submit" class="btn btn-success" target="_blank">Add Working Days</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

//  $('.start_time').datetimepicker(
//         {
            
//           format: 'hh:mm A',
//           icons: {
//                     up: "fa fa-chevron-up",
//                   down: "fa fa-chevron-down"
//                  },

//        });
 
jQuery(document).ready(function() {
    $("form").submit(()=>{
        showLoader();
    });
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "salarySlipListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        startDate: new Date(),
        format: "dd-mm-yyyy"
    });

    jQuery(document).on("click", ".deleteSalarySlip", function(){
            
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteSalarySlip",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure to delete this Salary Slip Info ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Salary Slip Info successfully deleted"); }
                    else if(data.status = false) { alert("Salary Slip Info deletion failed"); }
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
            alert("Select atleast one Staff to print Slip!");
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
//popover for info
// $(document).ready(function(){
  
//     $('[data-toggle="popover"]').popover({"html":true});
// });

</script>