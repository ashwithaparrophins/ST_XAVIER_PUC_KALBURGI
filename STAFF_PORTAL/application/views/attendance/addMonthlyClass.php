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

                                <i class="material-icons">mode_edit</i> Add Attendance Month Wise

                            </span>

                        </div>

                        <div class="col-6">

                        <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn 
                        
                        float-right text-white border_left_radius"

                        value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                                <!-- <button style="float:right" type="button" data-toggle="modal" data-target="#myDownloadModal"

                                class="btn btn-md btn-primary border_right_radius"> Download Marks Sheet</button> -->

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="row form-employee">

        <div class="col-12 column_padding_card">

            <div class="card card-small c-border p-2">

                <form role="form" action="<?php echo base_url(); ?>getStudentInfoForAttendnaceAdditionalDetails" method="POST" id="byFilterMethod">

                    <div class="row">

                        <div class="col-lg-2 col-md-3 col-12">

                            <select required name="term_name" id="term_name" class="form-control" data-live-search="true">

                                <?php if(!empty($term_name)){ ?>

                                    <option value="<?php echo $term_name; ?>">Selected: <?php echo $term_name; ?></option>

                                <?php } ?>

                                <option value="">Select Term</option>

                                <option value="I PUC">I PUC</option>

                                <option value="II PUC">II PUC</option>

                            </select>

                        </div>



                        <div class="col-lg-3 col-md-3 col-12">

                            <select required name="section_row_id" id="streamName" class="form-control stream_name" data-live-search="true">

                                <?php if(!empty($section_row_id)){ ?>

                                    <option value="<?php echo $section_row_id; ?>">Selected: <?php echo $stream_name.' - '.$section_name; ?></option>

                                <?php } ?>

                                <option value="">Select Stream & Section</option>

                            </select>

                        </div>

                        

                        <div class="col-lg-3 col-md-3 col-12">

                            <select id="staff_subject_row_id" name="staff_subject_row_id" class="form-control selectpicker" data-live-search="true" required>

                                <?php if(!empty($sub_name)){ ?>

                                <?php } ?>

                                <option value="">Select Subject</option>

                                <?php foreach($staffSubjectInfo as $sub){

                                    if($sub->subject_type == 'THEORY'){

                                        if($subject_row_id == $sub->row_id){ ?>

                                            <option value="<?php echo $sub->row_id; ?>" selected> Selected:

                                                <?php echo $sub_name.'->'.$staff_name; ?>

                                            </option>

                                        <?php }  ?>

                                        <option value="<?php echo $sub->row_id; ?>">

                                            <?php echo strtoupper($sub->sub_name.'->'.(string)$sub->staff_name); ?>

                                        </option>

                                <?php } } ?>

                            </select>

                        </div>

                        <div class="col-lg-2 col-md-3 col-12">

                            <select id="month_name" name="month_name" class="form-control" data-live-search="true" required>

                                <?php if(!empty($month_name)){ ?>

                                    <option value="<?php echo $month_name; ?>" selected> Selected:

                                        <?php echo $month_name; ?>

                                    </option>

                                <?php } ?>

                                <option value="">Select Month</option>

                                <option value="JANUARY">JANUARY</option>

                                <option value="FEBRUARY">FEBRUARY</option>

                                <option value="MARCH">MARCH</option>

                                <option value="APRIL">APRIL</option>

                                <option value="MAY">MAY</option>

                                <option value="JUNE">JUNE</option>

                                <option value="JULY">JULY</option>

                                <option value="AUGUST">AUGUST</option>

                                <option value="SEPTEMBER">SEPTEMBER</option>

                                <option value="OCTOBER">OCTOBER</option>

                                <option value="NOVEMBER">NOVEMBER</option>

                                <option value="DECEMBER">DECEMBER</option>

                            </select>

                        </div>

                        <div class="col-lg-2 col-md-3 col-12">

                            <button type="submit" id="searchButton" class="btn btn-success btn-block">

                                Search</button>

                        </div>

                    </div>

                </form>

                <hr class="mt-1 mb-1">

                <div class="table-responsive-sm">

                    <?php if(!empty($subject->subject_code)){ ?>

                    <div class="row pb-2">

                        <div class="col-lg-3 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Stream:

                                <b><?php echo $stream_name; ?></b></span>

                        </div>

                        <div class="col-lg-3 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Section:

                                <b><?php echo $section_name; ?></b></span>

                        </div>

                        <div class="col-lg-3 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Subject: <b><?php echo $subject->sub_name; ?></b></span>

                        </div>

                        <div class="col-lg-3 col-md-3 col-6 mb-1">

                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Total Students:

                                <b><?php echo count($studentsInfo); ?><b></b></span>

                        </div>

                    </div>

                    <?php } ?>

                    <form action="<?php echo base_url(); ?>addStudentAttendanceAdditionalDetails" method="POST" id="addInternalMarK">

                        <?php 

                            $labStatus = 'false';

                            $pass_count = 0;

                            $fail_count = 0;

                            $absent_count = 0;

                            $exampted_count = 0;



                            $pass_class_min = 35;

                            $pass_class_max = 49;

                            $second_class_min_mark = 50;

                            $second_class_max_mark = 59;

                            $first_class_min_mark = 60;

                            $first_class_max_mark = 84;

                            $dest_min_mark = 85;

                            $dest_max_mark = 100;

                            

                            if(!empty($studentsInfo)){

                        ?>

                         <div class="row">

                             <div class="col-6 mb-2">

                                <input value="<?php echo $class_held; ?>"

                                    style="font-size: 15px;font-weight: 700 !important;" maxlength="3"

                                    onkeypress="return isNumberKey(event)"

                                    id="class_held"

                                    class="form-control input-sm numberonly mark_col_width"

                                    placeholder="Enter Class Held" type="text"

                                    name="class_held" autocomplete="off"/>

                             </div>

                         </div>

                         <?php } ?>

                        <table class="table table-bordered text-dark tblnavigate">

                            <thead class="text-center">

                                <tr class="table_row_background">

                                    <!-- <th width="130">Register No.</th> -->
                                   

                                    <th width="100">Student ID</th>

                                    <th>Name</th>

                                    <th width="200">Class Attended</th>

                                    <th width="200">Class Held</th>

                                    <!-- <th width="200">Actions</th> -->

                                    <!-- <th>Result</th> -->

                            </thead>

                            <tbody>

                                <?php

                                    $update_byutton_active = false;

                                    if(!empty($studentsInfo)){

                                        $count_pass_students = 0;

                                        $count_fail_students = 0;

                                        $count_malparactice_students = 0;

                                        $count_absent_students = 0;

                                        $count_examption_students = 0;

                                        $second_class_count = 0;

                                        $distinction_count = 0;

                                        $first_class_count = 0;

                                        $third_class_count = 0;

                                        $pass_class_count = 0;

                                        $count_attendance_shortage = 0;

                                        $update_byutton_active = false;

                                        ?>

                                <input type="hidden" value="<?php echo $term_name; ?>" name="term_name" />

                                <input type="hidden" value="<?php echo $section_name; ?>" name="section_name" />

                               

                                <input type="hidden" value="<?php echo $labStatus; ?>" id="lab_status" />

                                <input type="hidden" value="<?php echo $subject_code; ?>" name="subject_id" />

                                <input type="hidden" value="<?php echo $stream_name; ?>" name="stream_name" />

                                <input type="hidden" value="<?php echo $section_row_id; ?>" name="section_row_id" />

                                <input type="hidden" value="<?php echo $month_name; ?>" name="month_name" />





                                <input type="hidden" value="<?php echo $staff_subject_row_id; ?>" name="staff_subject_row_id" />

                                <input type="hidden" value="<?php echo $max_mark_theory; ?>" id="max_theory_mark" />

                                <input type="hidden" value="<?php echo $max_lab_mark; ?>" id="max_lab_mark" />

                                <input type="hidden" value="<?php echo $min_mark_pass; ?>" id="min_mark_pass" />



                                <?php foreach($studentsInfo as $record) { ?>



                                <tr>

                                    <td class="text-center"><?php echo $record->student_id; ?></td>

                                    <td><?php echo $record->student_name; ?></td>

                                    <?php

                                            $mark_status = false;

                                            $update_mark_status = false;

                                            $total_mark = 0;

                                            $student_id = trim($record->row_id);

                                           

                                    

                                        $attendanceExists = isAddditionaDetailsExists($con,$student_id,$subject_code,$month_name);

                                        if(!empty($attendanceExists)){

                                            $class_held = trim($attendanceExists['class_held']);

                                            $class_attended = trim($attendanceExists['class_attended']);

                                            // $total_obt_mark = $mark_obt_theory + $lab_mark_obt;

                                        }else{

                                            $class_held = "";

                                            $class_attended = "";

                                            // $total_obt_mark = "";

                                        }

                                        

                                           ?>

                                    <td>

                                        <input value="<?php echo $class_attended; ?>"

                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="3"

                                            onkeypress="return isNumberKey(event)"

                                            id="class_attended_<?php echo $student_id; ?>"

                                            class="form-control input-sm numberonly mark_col_width"

                                            placeholder="Enter Class Attended" type="text"

                                            name="class_attended_<?php echo $student_id; ?>" autocomplete="off" />

                                    </td> 

                                    <?php if(empty($class_held)){ ?>

                                        <td><?php echo $class_held; ?></td>

                                    <?php }else{ ?>

                                        <td> 

                                                <!-- onkeyup="getTotalMarks('<?php echo $student_id; ?>')" -->

                                            <input value="<?php echo $class_held; ?>"

                                                style="font-size: 15px;font-weight: 700 !important;" maxlength="3"

                                                onkeypress="return isNumberKey(event)"

                                                id="class_held_<?php echo $student_id; ?>"

                                                class="form-control input-sm numberonly mark_col_width"

                                                placeholder="Enter Class Held" type="text"

                                                name="class_held_<?php echo $student_id; ?>" autocomplete="off" />

                                        </td>

                                    <?php } ?>

                                 

                              

                               

                                </tr>

                                <?php } }else { ?>

                                <td colspan="7" class="alert alert-info text-center">

                                    <strong>To Enter Attendance Additional Details, Search through above options!</strong>

                                </td>

                                <?php } ?>

                            </tbody>

                        </table>

                        <?php if(!empty($studentsInfo)){ ?>

                        <div class="row">

                            <div class="col-lg-12 text-center">

                                <button class="btn btn-primary btn-md" id="submitMark" type="submit">Submit</button>

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

function isAddditionaDetailsExists($con,$student_id,$subject_id,$month){

    $query = "SELECT * FROM tbl_attendance_additional_info as attd 

    WHERE attd.student_row_id = '$student_id' AND attd.subject_code = '$subject_id' 

    AND attd.month = '$month' AND attd.year='2024' AND attd.is_deleted = 0";

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

    

    // $("#submitMark").click(function() {

    //     var isValid = true;

    //     $('#addInternalMarK input[type=text]').each(function(i,e) {

    //         if(e.value == '') {

    //             $('.loaderScreen').hide();

    //         }else{

    //             $('.loaderScreen').show();

    //         }

    //     });

    // });

    

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



<!-- <script>

var active = 2;

//$('.tblnavigate td').each(function(idx){$(this).html(idx);});

rePosition();



$(document).keydown(function(e) {

    var inp = String.fromCharCode(e.keyCode);

    if (!(/[a-zA-Z0-9-_ ]/.test(inp) || e.keyCode == 96)){

      reCalculate(e);

      rePosition();

      // if key is an arrow key, don't type the user input.

      // if it is any other key (a, b, c, etc)

      // edit the text

      if (e.keyCode > 36 && e.keyCode < 41) {

        return false;

      }

    }

});



$('td').click(function() {

    active = $(this).closest('table tbody').find('td').index(this);

    rePosition();

});





function reCalculate(e) {

    var rows = $('.tblnavigate tbody tr').length;

    var columns = $('.tblnavigate tbody tr:eq(0) td').length;

    var temp;



    if (e.keyCode == 37) { //move left or wrap

        temp = active;

        while (temp > 0) {

            temp = temp - 1;

            // only advance if there is an input field in the td

            if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {

                active = temp;

                break;

            }

        }

    }

    if (e.keyCode == 38) { // move up

        temp = active;

        while (temp - columns >= 0) {

            temp = temp - columns;

            // only advance if there is an input field in the td

            if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {

                active = temp;

                break;

            }

        }

    }

    if (e.keyCode == 39) { // move right or wrap

        temp = active;

        while (temp < (columns * rows) - 1) {

            temp = temp + 1;

            // only advance if there is an input field in the td

            if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {

                active = temp;

                break;

            }

        }

    }

    if (e.keyCode == 40) { // move down

        temp = active;

        while (temp + columns <= (rows * columns) - 1) {

            temp = temp + columns;

            // only advance if there is an input field in the td

            if ($('.tblnavigate tbody tr td').eq(temp).find('input').length != 0) {

                active = temp;

                break;

            }

        }

    }

}



function rePosition() {

    console.log(active);

    $('.active').removeClass('active');

    $('.tblnavigate tbody tr td').eq(active).addClass('active');

    $('.tblnavigate tbody tr td').find('input').removeClass('textClass');

    $('.tblnavigate tbody tr td').eq(active).find('input').addClass('textClass');

    $('.tblnavigate tbody tr td').eq(active).find('input').select();

    var input = $('.tblnavigate tbody tr td').eq(active).find('input').focus();

    scrollInView();

}



function scrollInView() {

    var target = $('.tblnavigate tbody tr td:eq(' + active + ')');

    if (target.length) {

        var top = target.offset().top;



        $('html,body').stop().animate({

            scrollTop: top - 300

        }, 400);

        return false;

    }

}

</script> -->