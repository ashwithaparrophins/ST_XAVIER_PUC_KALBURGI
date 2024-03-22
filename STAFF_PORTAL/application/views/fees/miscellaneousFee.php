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
                            <div class="col-lg-4 col-sm-5 col-12">
                                <span class="page-title">
                                    <i class="material-icons">description</i> Miscellaneous Fee
                                </span>
                            </div>
                            <div class="col-lg-4 col-6 col-md-6 col-sm-6">
                                <form action="<?php echo base_url(); ?>miscellaneousFeeListing" method="POST"
                                    id="byFilterMethod"  enctype="multipart/form-data">
                                    <div class="input-group input-groups mobile-btn float-left student_search">
                                        <select class="form-control-sm p-1 search_select" name="intake_year" id="intake_year">
                                            <?php if(!empty($intake_year)){ ?>
                                            <option value="<?php echo $intake_year; ?>" selected><b>
                                                    <?php echo $intake_year; ?></b></option>
                                            <?php } ?>
                                            <option value="">By Year</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                          
                                        </select>
                                   
                                        <div class="input-group-append float-left">
                                            <button type="submit" class="btn btn-success border_radius_none py-0">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form> 
                            </div>
                            <div class="col-lg-4 col-sm-7 col-12 box-tools">
                                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius btn-backtrack"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                                <?php if($role == ROLE_ADMIN   || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_ACCOUNTS){ ?>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#addHostelFee">
                                        <i class="fa fa-plus"></i>&nbsp;Add New
                                    </button>
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
                                    <th width="250"> Date</th>
                                    <th width="100"> Receipt No.</th>
                                    <th width="230">Student ID</th>
                                    <th class="text-left" width="300">Student Name</th>
                                    <th width="250"> Miscellaneous Type</th>
                                    <!-- <th width="250">Amount</th> -->
                                    <th width="200">Quantity</th>
                                    <th width="250">Total Amount</th>
                                    <th width="100">Payment Type</th>
                                    <th width="140">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Staff ID</th>
                                    <th class="text-left" width="200">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Add Hostel Fee payment  -->
<div class="modal fade" id="addHostelFee" tabindex="-1" role="dialog" aria-labelledby="addHostelFee" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Miscellaneous Fee Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>addMiscellaneousPayment" method="POST">
                    <div class="row">

                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label for="date"> Student Status </label>
                                <select class="form-control" id="student_status" name="student_status" required>
                                    <option value="">Select Student Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Alumni">Alumni</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date"> Date</label>
                                <input type="text" class="form-control required datepicker" id="date" name="date"
                                    value="<?php echo date('d-m-Y')?>" placeholder="Date" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="semester"> Select Payment Type</label>
                                <select class="form-control" name="type" id="payment_type">
                                    <option value="">Select Payment Type</option>
                                    <option value="CASH">CASH</option>
                                    <option value="UPI">UPI</option>
                                    <option value="NEFT">NEFT</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group  upi_info">    
                                <label for="usr">UPI Reference No:</label>
                                <input type="text" name="ref_no" required class="form-control"
                                     Placeholder="Enter UPI Reference No." id="upi_ref_no"
                                    autocomplete="off">                            
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group  neft_info">    
                                <label for="usr">Reference No:</label>
                                <input type="text" name="neft_ref_no" required class="form-control"
                                     Placeholder="Enter Reference No." id="neft_ref_no"
                                    autocomplete="off">                            
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group ">
                                <label for="date">Student</label>
                                <select class="form-control selectpicker" data-live-search="true" name="stud_row_id"
                                    id="stud_row_id" autocomplete="off">
                                    <option value="">Select Student</option>
                                    <?php if(!empty($studentInfo)){
                                                    foreach($studentInfo as $std){  ?>
                                    <option value="<?php echo $std->row_id; ?>">
                                        <b><?php echo  $std->student_id.' - '.$std->application_no.' - '.$std->student_name. ' - '.$std->term_name;  ?></b>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-12">
                            <div class="form-group student_name">
                                <label for="Student">Student</label>
                                <input type="text" class="form-control required" id="student_name" name="student_name"
                                    placeholder="Name" autocomplete="off" />
                            </div>
                        </div> -->

                        <div class="col-6">
                            <div class="form-group register_no">
                                <label for="register_no">Register No</label>
                                <input type="text" class="form-control required" id="register_no" name="register_no"
                                    placeholder="Register No" autocomplete="off" />
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group semester">
                                <label for="semester"> Select Year</label>
                                <select class="form-control" name="semester" id="semester">
                                    <option value="">Select</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 course">
                            <div class="form-group ">
                                <label for="course">Select Course</label>
                                <select class="form-control" name="course" id="course">

                                    <option value="">Select</option>
                                    <?php if(!empty($courseInfo)){ 
                                                    foreach ($courseInfo as $course) { ?>
                                    <option value="<?php echo $course->course_name ?>">
                                        <?php echo $course->course_name ?>
                                    </option>
                                    <?php   } 
                                                } ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date">Miscellaneous Type</label>
                                <select class="form-control" id="miscellaneous_type" name="miscellaneous_type" required>
                                    <option value="">Select Miscellaneous Type</option>
                                    <?php if(!empty($miscellaneousTypeInfo)){
                                    foreach($miscellaneousTypeInfo as $type){  ?>
                                    <option value="<?php echo $type->row_id?> ">
                                        <?php echo $type->miscellaneous_type?>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Amount">Amount</label>
                                <input type="text" class="form-control required" id="amount"  name="amount"   placeholder="Amount" required autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Amount">Ref. Receipt No.</label>
                                <input type="text" class="form-control required" id="ref_receipt_no"  name="ref_receipt_no"   placeholder="Ref Receipt No." required autocomplete="off"/>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="semester"> Select Quantity</label>
                                <select class="form-control" name="quantity" id="quantity">
                                    <option value="1">Selected:1</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// $("#student_status").on('change', function() {
//     if (this.value == "Active") {
        
//         $('.student_select').show();
//         $('.student_name').hide();
//         $('.course').hide();
//         $('.semester').hide();
//         $('.register_no').hide();
//         $('#student_name').prop('required', false);
//         $('#stud_row_id').prop('required', true);

//     } else if (this.value == "Alumni") {
//         $('.student_select').hide();
//         $('.student_name').show();
//         $('.course').hide();
//         $('.semester').hide();
//         $('.register_no').hide();
//         $('#student_name').prop('required', true);
//         $('#stud_row_id').prop('required', false);


//     }
// });

$("#payment_type").on('change', function() {
    
    if (this.value == "UPI") {
        $('.upi_info').show();
        $('.neft_info').hide();
        $('.course').hide();
        $('.semester').hide();
        $('.register_no').hide();
        $('#upi_ref_no').prop('required', true);
        $('#neft_ref_no').prop('required', false);

    } else if (this.value == "NEFT") {
        $('.neft_info').show();
        $('.upi_info').hide();
        $('.course').hide();
        $('.semester').hide();
        $('.register_no').hide();
        $('#upi_ref_no').prop('required', false);
        $('#neft_ref_no').prop('required', true);

    }else{

        $('.upi_info').hide();
        $('.neft_info').hide();
        $('#upi_ref_no').prop('required', false);
        $('#neft_ref_no').prop('required', false);
    }
});

$('#miscellaneous_type').on('change',function(){
    var type_id = this.value;
    jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: baseURL + "getMiscellaneousFeeAmount",
            data: {
                type_id: type_id
            }
        }).done(function(data) {
            if (data.amount > 0) {
               $('#amount').val(data.amount); 
            } else {
                alert("Access denied..!");
            }
        });
});



jQuery(document).on("click", ".deleteMiscellaneousFee", function() {

    var row_id = $(this).data("row_id"),
        hitURL = baseURL + "deleteMiscellaneousFee",
        currentRow = $(this);
    var confirmation = confirm("Are you sure to delete this Miscellaneous Fee ?");

    if (confirmation) {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: hitURL,
            data: {
                row_id: row_id
            }
        }).done(function(data) {
            currentRow.parents('tr').remove();
            if (data.status = true) {
                alert("Fee successfully deleted");
            } else if (data.status = false) {
                alert("Fee deletion failed");
            } else {
                alert("Access denied..!");
            }
        });
    }
});



jQuery(document).ready(function() {
    $('.student_select').hide();
    $('.student_name').hide();
    $('.course').hide();
    $('.semester').hide();
    $('.register_no').hide();
    $('.upi_info').hide();
    $('.neft_info').hide();


    var loader = '<img height="70" src="<?php echo base_url(); ?>assets/images/loader.gif"/>';
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
        } else {
            var displayStatus = true;
            var newClassupdate = '';
        }

        if (displayStatus == true) {
            $(this).html(
                '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
                title + '" ' +
                newClassupdate + ' /> </div>');
        } else {
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
                targets: 4,

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
            "info": "Showing _START_ to _END_ of _TOTAL_ Fee",
            "infoFiltered": "(filtered from _MAX_ total Fee)",
            "search": "",
            searchPlaceholder: "Search",
            "lengthMenu": "Show _MENU_ Fee",
            "infoEmpty": "Showing 0 to 0 of 0 Fee",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/getMiscellaneousFeeInfo',
            type: 'POST',
            data: function (d) {
                d.intake_year = $('#intake_year').val(); 
            },
            // dataType: 'json',
        },

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

    jQuery('.fromDate,.toDate,.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",

    });






});
</script>