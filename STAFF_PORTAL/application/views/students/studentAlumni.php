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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-12 col-md-4 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-users"></i> Alumni Student
                                </span>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    
                                <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <!-- <a class="dropdown-item" href="#" id="study_certificate"><i class="fa fa-file"></i> Study Certificate</a> -->
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="conduct_certificate"><i class="fa fa-file"></i> Conduct Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="mark_card_print"><i class="fa fa-file"></i> Mark Card</a>
                                        <div class="dropdown-divider m-0"></div>
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
                            <form action="<?php echo base_url(); ?>studentAlumniInfo" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $application_no; ?>" name="application_no" id="application_no" class="form-control input-sm" placeholder="By Application Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name" class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_term" id="by_term">
                                                <?php if(!empty($by_term)){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Selected: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_stream" id="by_stream">
                                                <?php if(!empty($by_stream)){ ?>
                                                    <option value="<?php echo $by_stream; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_Section" id="by_Section">
                                                <?php if(!empty($by_Section)){ ?>
                                                    <option value="<?php echo $by_Section; ?>" selected><b>Selected: <?php echo $by_Section; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Section</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <!-- <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option> -->
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th width="140">Student ID</th>
                                    <th width="140">Appln. No.</th>
                                    <th>Student Name</th>
                                    <th width="110">Term</th>
                                    <th width="110">Stream</th>
                                    <th width="110">Section</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentInfo)){
                                    foreach($studentInfo as $std){ ?>
                                    <tr>
                                        <th><input type="checkbox" class="singleSelect" value="<?php echo $std->student_id; ?>" /></th>
                                        <th class="text-center"><?php echo $std->student_id; ?></th>
                                        <th class="text-center"><?php echo $std->application_no; ?></th>
                                        <th><?php echo strtoupper($std->student_name); ?></th>
                                        <th class="text-center"><?php echo $std->term_name; ?></th>
                                        <th class="text-center"><?php echo $std->stream_name; ?></th>
                                        <th class="text-center"><?php echo $std->section_name; ?></th>
                                        <th class="text-center" width="140">
                                            <a class="btn btn-xs btn-primary mb-1" target="_blank"
                                            href="<?php echo base_url(); ?>viewStudentInfoById/<?php echo $std->row_id; ?>"
                                            title="View More"><i class="fa fa-eye"></i></a>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN){ ?>
                                                <a class="btn btn-xs btn-info mb-1" target="_blank"
                                                href="<?php echo base_url(); ?>editStudent/<?php echo $std->row_id; ?>" title="Edit Student"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                             <?php } ?>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                                                <a class="btn btn-xs btn-danger deleteStudent mb-1"
                                                data-row_id="<?php echo $std->application_no; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                            <?php } ?>
                                            <?php if($role != ROLE_TEACHING_STAFF) { ?>
                                                <a onclick="openModel('<?php echo $std->student_id; ?>')" class="btn btn-xs btn-warning" style="color: white;" 
                                                title="Give Transfer Certificate"><i class="fa fa-file"></i> Give TC</a>
                                            <?php } ?>
                                                                
                                           
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Student Record Not Found</th>
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





<div class="modal fade" id="tcModel" tabindex="-1" role="dialog" aria-labelledby="tcModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                    <h4 class="modal-title" id="stdName"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        <div class="modal-body p-1">
            <table class="table  table-bordered mb-2">
                <tr>
                    <th class="table-primary">Name </th>
                    <th id="studentName" class="table-info"></th>
                    <th class="table-primary">DOB</th>
                    <th id="dob" class="table-info"></th>
                    <th class="table-primary">Section</th>
                    <th id="section" class="table-info"></th>
                </tr>
                <tr >
                    <th class="table-primary">Nationality</th>
                    <th class="table-info" id="nationality"></th>
                    <th class="table-primary">Religion </th>
                    <th class="table-info" id="religion"></th>
                    <th class="table-primary">Caste</th>
                    <th class="table-info">
                        <input type="text" placeholder="Caste" class="form-control " name="caste" id="caste">
                    </th>
                    
                </tr>
                <tr>
                    <th class="table-primary">Father Name </th>
                    <th class="table-info" id="father_name"></th>
                    <th class="table-primary">Mother Name</th>
                    <th class="table-info" id="mother_name"></th>
                    <th class="table-primary">Admission Date</th>
                    <th class="table-info" id="admission_date"></th>
                </tr>
                <tr>
                    <th class="table-primary">Medium </th>
                    <th class="table-info" id="instruction_medium"></th>
                    <th class="table-primary">Optionals</th>
                    <th class="table-info" id="optionals"></th>
                    <th class="table-primary">Languages</th>
                    <th class="table-info" id="languages"></th>
                </tr>
            
            </table>
            <form  id="addTcList">
                <input type="hidden" id="student_id" name="student_id"  />
                <div class="row">
                <div class="col-lg-6 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="leaving_date" class="col-form-label">Date of Leaving:</label>
                            <input type="text" placeholder="Select Student Leaving Date" class="form-control datepicker" name="leaving_date" id="leaving_date">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="date_of_admission" class="col-form-label">Date of Admission:</label>
                            <input type="text" placeholder="Select Student admission Date" class="form-control datepicker" name="date_of_admission" id="date_of_admission">
                        </div>
                    </div>
                </div>
                <div class="row">
                <!-- <div class="col-lg-6 col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="admission_number" class="col-form-label">Admission Number:</label>
                        <input type="text" placeholder="Select Student admission number" class="form-control" name="admission_number" id="admission_number"></div>
                    </div> -->
                    <div class="col-lg-12 col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="qualified_status" class="col-form-label">Whether Qualified for promotion to a higher class?</label>
                        <select class="form-control required" id="qualified_status" name="qualified_status">
                        <option value="YES" >YES</option>
                        <option value="NO">NO </option>
                    </select></div>
                    </div>


                    
                </div>
                <div class="form-group">
                    <label for="role">Whether the candidate belongs to Scheduled Caste or Tribe?</label>
                    <select class="form-control required" id="belong_sc_st" name="belong_sc_st">
                        <option value="NO">NO </option>
                        <option value="YES" >YES</option>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="last_class">Class in which the student was studying at the time of leaving?</label>
                    <input type="text" placeholder="Select Class" class="form-control" name="last_class" id="last_class">
                </div>
                            <div class="form-group">
                                <label for="fee_due" class="col-form-label pb-0">Fee Due<span>*</span></label>
                                <select class="form-control required pendingFee" id="fee_due" name="fee_due" required>
                                    <option value="" disabled>Select Fee Due</option>
                                    <option  value="YES">YES</option>
                                    <option value="NO">NO </option>
                                </select>
                            </div>
                        
                <div class="form-group">
                    <label for="role">Character and Conduct?</label>
                    <select class="form-control required" id="character" name="character">
                        <option value="GOOD" >GOOD</option>
                        <option value="VERY GOOD">VERY GOOD </option>
                        <option value="SATISFIED">SATISFIED </option>
                    </select>
                </div>

                <div class="alertMessage">
                </div>
                
            </div>
            <div class="modal-footer">
            
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="saveTcInfo" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade-scale" id="printMarkCardOption">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue p-2">
                <h4 class="modal-title">Students Mark Card Confirm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>
                    <input type="hidden" value="I PUC" id="term" />
                    <label style="font-size: 18px;">Total Students Selected for Print Mark Card: <label
                            id="countStudentsForMarkCard"></label></label>
                    <hr class="m-1">
                    <div class="errorMessage">

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Select Examination Year</label>
                            <select class=" form-control input-md" id="exam_year" name="exam_year">
                                <option value="">Select Examination Year</option>
                                 <!-- <option value="FEBRUARY - 2022_D"><strong>Annual Exam(Detained)</strong></option> -->
                                 <option value="annual_exam"><strong>Annual Exam</strong></option>
                                <!-- <option value="FEBRUARY - 2021"><strong>FEBRUARY - 2021</strong></option>
                                <option value="MARCH - 2021"><strong>MARCH - 2021</strong></option>
                                <option value="JULY - 2021"><strong>JULY - 2021</strong></option>
                                <option value="APRIL - 2021"><strong>APRIL - 2021</strong></option>
                                <option value="FEBRUARY - 2020"><strong>FEBRUARY - 2020</strong></option>
                                <option value="MARCH - 2020"><strong>MARCH - 2020</strong></option>
                                <option value="JULY - 2020"><strong>JULY - 2020</strong></option>
                                <option value="APRIL - 2020"><strong>APRIL - 2020</strong></option>
                                <option value="FEBRUARY - 2019"><strong>FEBRUARY - 2019</strong></option>
                                <option value="MARCH - 2019"><strong>MARCH - 2019</strong></option>
                                <option value="APRIL - 2019"><strong>APRIL - 2019</strong></option>
                                <option value="JULY - 2019"><strong>JULY - 2019</strong></option>
                                <option value="FEBRUARY - 2018"><strong>FEBRUARY - 2018</strong></option> -->
                            </select>
                        </div>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span> Close</button>
                <button id="printMarkSheet" type="button" class="btn btn-md btn-primary"><i
                        class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "studentAlumniInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });
   
    
    $(".custom_loader").hide();
    $("#custom_loader_text").css('display','none');

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

    // study certificate
    $('#study_certificate').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Study Certificate!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>generateStudyCertificate?student_id='+btoa(students));
    });

    
    //conduct certificate
    $('#conduct_certificate').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Conduct Certificate!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>generateConductCertificate?student_id='+btoa(students));
    }); 

 //print mark card for students
    $('#mark_card_print').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#printMarkCardOption').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudentsForMarkCard').html($('.singleSelect:checkbox:checked').length);
    });

    
    $('#printMarkSheet').click(function(){
        var students = [];
        var exam_year = $('#exam_year').val();
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Mark Card!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        if (exam_year == "") {
            $(".errorMessage").html(`<div class="alert alert-danger" role="alert">
                  Please Select Examination Year!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>`);
            return;
        }else if(exam_year == 'FEBRUARY - 2022_D'){
          window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }else if(exam_year == 'annual_exam'){
          window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint2022?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }else{
          window.open('<?php echo base_url(); ?>getMarkCardToPrint?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }
    });
    
    $("#saveTcInfo").click(function(){
          
        var qualified_status = $('#qualified_status :selected').val();
        var reason_unqualified = $('#reason_unqualified_val :selected').val();
        var belong_sc_st = $('#belong_sc_st :selected').val();
        var fee_due = $('#fee_due :selected').val();
        /// var college_due_status = $('#college_due_status :selected').val();
        var character = $('#character :selected').val();
        var leaving_date = $('#leaving_date').val();
        var admission_date = $('#date_of_admission').val();
        // var admission_number=$('#admission_number').val();
        var student_id = $('#student_id').val();
        var caste = $('#caste').val();
        var last_class = $('#last_class').val();
        
        if(leaving_date == ""){ 
            $(".alertMessage").html('<div class="alert alert-warning alert-dismissable">Sorry! Leaving date Empty!</div>');
            $(".alertMessage").show();
        }else{
            $.ajax({
                url: '<?php echo base_url(); ?>/addNewTcInfo',
                type: 'POST',
                data: {
                    qualified_status: qualified_status,
                    reason_unqualified: reason_unqualified,
                    belong_sc_st: belong_sc_st,
                    character: character,
                    leaving_date: leaving_date,
                    student_id : student_id,
                    admission_date : admission_date,
                    // admission_number : admission_number,
                    caste : caste,
                    last_class:last_class,
                    fee_due:fee_due,
                },

                success: function(data) {
                    $(".alertMessage").html('<div class="alert alert-success alert-dismissable">'+data+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                    $(".alertMessage").show();
                },
                error: function(result){
                    $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Error! Something Went Wrong</div>');
                    $(".alertMessage").show();
                },
                fail:(function(status) {
                    $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Error! Something Went Wrong</div>');
                    $(".alertMessage").show();
                }),
                beforeSend:function(d){
                    // $('.modal-title').html('<center> Loading..</center>');
                }
            });
        }
    });

});

function openModel(student_id){
    $(".alertMessage").hide();
    $('.modal-title').html('Transfer Certificate <span style="float:right;">Student ID: '+ student_id + '</span>');
   // alert(student_id);
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentTcInfo',
        type: 'POST',
        data: {
            student_id : student_id,
        },

        success: function(data) {
            var studentTcInfo = JSON.parse(data);
            if(studentTcInfo != null){
        

            // var leavingDate = studentTcInfo.leaving_date
            var leavingDate = "03-31-2024";
            $('#leaving_date').val(appendLeadingZeroes(new Date(leavingDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getFullYear()));
            // $('#leaving_date').val(studentTcInfo.leaving_date);
            $('#qualified_status').val(studentTcInfo.is_promoted);
            $('#belong_sc_st').val(studentTcInfo.is_belongs_sc_st);
            $('#character').val(studentTcInfo.character_conduct);
            // $('#admission_number').val(studentTcInfo.admission_number);
            $('#last_class').val(studentInfo.term_name + ' ' + studentInfo.program_name);

            $('#fee_due').val(studentTcInfo.fee_due);
            // alert(studentInfo.fee_due);

            if(studentTcInfo.reason_unqualified != ""){
                $('#reason_unqualified_val').val(studentTcInfo.reason_unqualified);
                $(".reason_unqualified").show();
            }else{
                $('#reason_unqualified_val').val(studentTcInfo.reason_unqualified);
                $(".reason_unqualified").hide();
            }
            $("#saveTcInfo").text("Update");
            }else{
            $("#saveTcInfo").text("Save");
            $(".reason_unqualified").hide();
            $('#addTcList')[0].reset();
            }
        },
        error: function(result)
            {
                $(".modal-title").html("Error");
            },
            fail:(function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
    });
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentById',
        type: 'POST',

        data: {
            student_id : student_id,
        },

        success: function(data) {
            var studentInfo = JSON.parse(data);
            var leavingDate = "03-31-2024";
            $('#leaving_date').val(appendLeadingZeroes(new Date(leavingDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getFullYear()));
            var admissionDate = studentInfo.date_of_admission;
            $('#student_id').val(student_id);
            $('#stdName').html(studentInfo.student_name);
           // alert(studentInfo.student_name);
            $('#studentName').html(studentInfo.student_name);
            $('#dob').html(studentInfo.dob);
            $('#section').html(studentInfo.section_name);
            $('#nationality').html(studentInfo.nationality);
            $('#father_name').html(studentInfo.father_name);
            $('#mother_name').html(studentInfo.mother_name);
        

            $('#religion').html(studentInfo.religion);
            $('#caste').val(studentInfo.caste);
            //   $('#admission_number').val(studentInfo.admission_number);
              $('#last_class').val(studentInfo.term_name + ' ' + studentInfo.program_name);

           
            // $('#fee_due').val(studentInfo.is_cleared_college_due);

            $('#languages').html(studentInfo.elective_sub);

            if(admissionDate != ' ' && admissionDate != '1970-01-01' && admissionDate != '0000-00-00'){
                $('#admission_date').html(appendLeadingZeroes(new Date(admissionDate).getDate()) 
                + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
                + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear()));
                // $('#admission_date').html(studentInfo.date_of_admission);
            }

            if(admissionDate != ' '){
                var admission = appendLeadingZeroes(new Date(admissionDate).getDate()) 
                + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
                + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear());

                $('#date_of_admission').val(admission);
            }else{
                $('#date_of_admission').val(admissionDate);
            }

            $('#instruction_medium').html("English");
            $('#optionals').html(studentInfo.stream_name);
            // if(studentInfo.date_of_admission == ""){
            // alert("Please Upadte Admission Date!");
            // return;
            // }
            $('#tcModel').modal('show');
        },
        error: function(result)
            {
                $(".modal-title").html("Error");
            },
            fail:(function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
    });
    
}   
    
function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
</script>
</script>