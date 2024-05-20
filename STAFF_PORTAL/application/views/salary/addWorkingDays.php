<?php

 require APPPATH . 'views/includes/db.php'; 



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

<div class="row">

    <div class="col-md-12">

        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>

    </div>

</div>

<style>

input[type=number]::-webkit-inner-spin-button, 

input[type=number]::-webkit-outer-spin-button { 

    -webkit-appearance: none;

    -moz-appearance: none;

    appearance: none;

    margin: 0; 

}



.loaderScreen {

    display: block;

    visibility: visible;

    position: absolute;

    z-index: 999;

    top: 0px;

    left: 0px;

    width: 100%;

    height: 100%;

    background-color: #0a0a0a94;

    vertical-align: bottom;

    padding-top: 20%;

    filter: alpha(opacity=75);

    opacity: 0.75;

    font-size: large;

    color: blue;

    font-style: italic;

    font-weight: 400;



    background-repeat: no-repeat;

    background-attachment: fixed;

    background-position: center;

}

</style>

<!-- Content Header (Page header) -->

<div class="main-content-container px-3 pt-1">

    <div class="row p-0">

        <div class="col column_padding_card">

            <div class="card card-small card_heading_title p-0 m-b-1">

                <div class="card-body p-2">

                    <div class="row c-m-b">

                        <div class="col-6">

                            <span class="page-title count_heading">

                                <i class="material-icons">mode_edit</i> Add Working

                            </span>

                        </div>

                        <div class="col-6">

                            <a onclick="window.history.back();"

                                class="btn btn-secondary mobile-btn float-right text-white pt-2"

                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="row form-employee">

        <div class="col-12 column_padding_card">

            <div class="card card-small c-border p-2">

            
                <hr class="mt-1 mb-1">

                <div class="table-responsive-sm">

                    <div class="row pb-2">

                        <div class="col-lg-4 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Year:

                                <b><?php echo $year; ?></b></span>

                        </div>

                        <div class="col-lg-4 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Month:

                                <b><?php echo $month; ?></b></span>

                        </div>
                      
                        <div class="col-lg-4 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Total Staffs:

                                <b><?php echo count($staffInfo); ?><b></b></span>

                        </div>

                    </div>

                    <?php // } ?>

                    <form action="<?php echo base_url(); ?>addSalarySlip" method="POST" id="addInternalMarK">

                        <table class="table table-bordered text-dark tblnavigate">

                            <thead class="text-center">

                                <tr class="table_row_background">

                                    <th width="200">Staff ID</th>

                                    <th>Name</th>

                                    <th width="200">No. of Working Days </th>

                                    <th width="200">Total Days</th>

                            </thead>

                            <tbody>

                                <?php

                                    $update_byutton_active = false;

                                    if(!empty($staffInfo)){

                                        $update_byutton_active = false;

                                        ?>

                                <input type="hidden" value="<?php echo $year; ?>" name="year" />
                                <input type="hidden" value="<?php echo $month; ?>" name="month" />
                              


                                <?php foreach($staffInfo as $record) { ?>



                                <tr>

                                    <td class="text-center"><?php echo $record->staff_id; ?></td>

                                    <td><?php echo $record->name; ?></td>

                                    <?php

                                            $mark_status = false;

                                            $update_mark_status = false;

                                            $total_mark = 0;

                                            $staff_id = trim($record->staff_id);

                                        $attendanceExists = isAddditionaDetailsExists($con,$staff_id,$month);


                                        if(!empty($attendanceExists)){

                                            $class_held = $numDays;

                                            $class_attended = trim($attendanceExists['working_day']);

                                        }else{

                                            $class_held = $numDays;

                                            $class_attended = "";

                                        }

                                        

                                           ?>

                                    <td width="20%">

                                        <input value="<?php echo $class_attended; ?>"

                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="3"

                                            onkeypress="return isNumberKey(event)"

                                            id="working_day_<?php echo $staff_id; ?>"

                                            class="form-control input-sm numberonly mark_col_width"

                                            placeholder="Enter No. of Working Days" type="text"  oninput="validateDays('<?php echo $staff_id; ?>')" 

                                            name="working_day_<?php echo $staff_id; ?>" autocomplete="off" />

                                    </td> 

                                    <?php if(empty($class_held)){ ?>

                                        <td><?php echo $class_held; ?></td>

                                    <?php }else{ ?>

                                        <td> 

                                            <input value="<?php echo $class_held; ?>"

                                                style="font-size: 15px;font-weight: 700 !important;" maxlength="3"

                                                onkeypress="return isNumberKey(event)"

                                                id="total_days_<?php echo $staff_id; ?>"

                                                class="form-control input-sm numberonly mark_col_width"

                                                placeholder="Enter No. of Working Days" type="text"  oninput="validateDays('<?php echo $staff_id; ?>')" 

                                                name="total_days_<?php echo $staff_id; ?>" autocomplete="off" />

                                        </td>

                                    <?php } ?>

                                 

                              

                               

                                </tr>

                                <?php } }else { ?>

                                <td colspan="7" class="alert alert-info text-center">

                                    <strong>To Enter Attendance Details, Search through above options!</strong>

                                </td>

                                <?php } ?>

                            </tbody>

                        </table>

                        <?php if(!empty($staffInfo)){ ?>

                        <div class="row">

                            <div class="col-lg-12 text-center">

                                <button class="btn btn-primary btn-md mb-4" id="submitMark" type="submit">Submit</button>

                            </div>

                        </div>

                        <?php } ?>

                    </form>

                </div>

            </div>

        </div>

    </div>







</div>







<?php

function isAddditionaDetailsExists($con,$staff_id,$month){

    $query = "SELECT * FROM tbl_staff_salary_slip as attd 

    WHERE attd.staff_id = '$staff_id'  

    AND attd.month = '$month' AND attd.is_deleted = 0";

    $pdo_statement = $con->prepare($query);

    $pdo_statement->execute();

    return $pdo_statement->fetch();

}

?>



<script type="text/javascript">

var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

var term_name = 'I';





jQuery(document).ready(function() {

    var term = $("#term_name").val();

    var stream = $(".stream_name").val();

    var staf_rowId = $("#staff_subject_row_id").val();

    var examType = $("#exam_type").val();



    $('#streamName').prop('disabled', 'disabled');

    if(stream != ''){

        $('#streamName').prop('required', true); 

        $('#streamName').prop('disabled', false);

        $('.loaderScreen').hide();

    }



    $('.loaderScreen').hide();

    // $('select').selectpicker();

    $(".numberonly").focus(function() {

        $(this).attr("type", "number")

    });

    $(".numberonly").blur(function() {

        $(this).attr("type", "text")

    });



    $("#submitMark").submit(function(e) {

        e.preventDefault();

    });

    



    $("#submitMark,#searchButton").click(function() {

        if(term == ''){

            $('.loaderScreen').hide();

        } else if(examType == ''){

            $('.loaderScreen').hide();

        } else if(stream == ''){

            $('.loaderScreen').hide();

        } else if(staf_rowId == ''){

            $('.loaderScreen').hide();

        } else if ($('#streamName').prop("disabled") == true) {

            alert('cbd');

        } else{

            $('.loaderScreen').show();

        }

    });


    

    $(function() {

        $('#attendanceDate').datepicker({

            autoclose: true,

            endDate: "today",

            format: 'dd-mm-yyyy',

        });

    });



    $("#term_name").change(function(){

        var term_name = $("#term_name").val()

        if(term_name == 'II PUC'){

            $('#exam_type_two').show();

        }else{

            $('#exam_type_two').hide();

        }

        if(this.value != 0){

            $('#streamName').prop('disabled', false);

            $('#streamName option:not(:first)').remove();

            $.ajax({

            url: '<?php echo base_url(); ?>/getStreamSectionByTerm',

            type: 'POST',

            dataType: "json",

            data: { term_name : term_name },



            success: function(data) {

                //var examObject = JSON.parse(data);

                var examObject = JSON.stringify(data)

                var count = data.result.length;

                if(count != 0){

                    for(var i=0; i<=count; i++){

                        $("#streamName").append(new Option(data.result[i].stream_name +' - '+ data.result[i].section_name, data.result[i].row_id));

                    }

                }else{

                    $('#streamName').prop('disabled', 'disabled');

                }

            }

        });

        }else{

            $('#streamName').prop('disabled', 'disabled');

            $('#streamName option:not(:first)').remove();

        }

    });

});



function isNumberKey(evt) {

    //alert(mark_ent)

    

    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode > 31 && (charCode > 64 && charCode < 91 ) && (charCode < 48 || charCode > 57  || charCode.length < 4))

        return false;

    return true;

}







</script>
<script>
    // JavaScript function to check if Working Days is greater than Total Days
    function validateDays(staffId) {
        var workingDays = parseInt(document.getElementById('working_day_' + staffId).value, 10) || 0;
        var totalDays = parseInt(document.getElementById('total_days_' + staffId).value, 10) || 0;

        if (workingDays > totalDays) {
            alert('Working Days cannot be greater than Total Days');
            // You can choose to clear the input or take other actions as needed
            document.getElementById('working_day_' + staffId).value = '';
        }
    }

    // Attach the validation function to the input's onchange event
    document.getElementById('working_day_<?php echo $staff_id; ?>').onchange = function() {
        validateDays('<?php echo $staff_id; ?>');
    };
</script>
