<?php require APPPATH . 'views/includes/db.php'; ?>

<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.2);
}

input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    color: red;
    width: 10px;
    height: 10px;
    visibility: visible;
    border: 1px solid #3c8dbc;
    padding: 2px;
    margin: 1px 0;
    border-radius: 1px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
}

input[type=checkbox]:checked:after {
    content: "\2714";
    display: unset;
    font-weight: bold;
    width: 10px;
    height: 10px;
    padding: 2px
}
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { ?>
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
if ($success) {  ?>
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
                            <div class="col-lg-7 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">format_list_bulleted</i> Take Attendance
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12">
                                <a onclick="GoBackWithRefresh();return false;" class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="row p-1">
                        <div class="col-lg-3 col-sm-6 col-7">
                            <h6 class="mb-0">Subject : <span class="font-weight-bold"><?php echo $subject_name; ?></span></h6>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-5">
                            <h6 class="mb-0">Date : <span class="font-weight-bold"><?php echo $attendance_date; ?></span></h6>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-7">
                            <h6 class="mb-0">Term & Stream : <span class="font-weight-bold"><?php echo $term_name.' '.$stream_name; ?></span></h6>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-5">
                            <h6 class="mb-0">Section : <span class="font-weight-bold"><?php echo $section_name; ?></span></h6>
                        </div>
                        <?php if(!empty($class_batch)){ ?>
                        <div class="col-lg-3 col-sm-6 col-5">
                            <h6 class="mb-0">Batch : <span class="font-weight-bold"><?php echo $class_batch; ?></span></h6>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="card-body p-1 pb-2 table-responsive">
                        <form action="#" method="POST" id="selectedAbsentStudents"> 
                            <table class="table table-hover table-bordered text-dark mb-0">
                                <thead>
                                    <input type="hidden" name="term_name" value="<?php echo $term_name; ?>" />
                                    <input type="hidden" name="stream_name" value="<?php echo $stream_name; ?>" />
                                    <input type="hidden" name="subject_name" value="<?php echo $subject_name; ?>" />
                                    <input type="hidden" name="attendance_date" value="<?php echo $attendance_date; ?>" />
                                    <input type="hidden" name="section_name" value="<?php echo $section_name; ?>" />
                                    <input type="hidden" name="time_row_id" value="<?php echo $time_row_id; ?>" />
                                    <input type="hidden" name="section_row_id" value="<?php echo $section_row_id; ?>" />
                                    <input type="hidden" name="staff_subject_row_id" value="<?php echo $staff_subject_row_id; ?>" />
                                    <input type="hidden" name="subject_code" value="<?php echo $subject_code; ?>" />
                                    <input type="hidden" name="subject_type" value="<?php echo $subject_type; ?>" />
                                    <input type="hidden" name="student_batch" value="<?php echo $class_batch; ?>" />
                                    <tr class="table_row_background text-center">
                                    <th width="10%">SL No.</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if(!empty($studentRecord)){
                                        $s = 0;
                                        foreach($studentRecord as $std){ 
                                            $s++;
                                            $absentDate = date('Y-m-d',strtotime($attendance_date));
                                            $absentData = getAbsentStudentList($con,$std->row_id,$section_row_id,$time_row_id,$absentDate,$subject_code,$class_batch);
                                            if(!empty($absentData)){
                                                $isAbsent = true;
                                            }else{
                                                $isAbsent = false;
                                            }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $s ?></td>
                                            <td class="text-center"><?php echo $std->student_id; ?></td>
                                            <td><?php echo $std->student_name; ?></td>
                                            <th class="text-center">
                                                <?php if($isAbsent == 'true'){ ?>
                                                    <input type="checkbox" class="singleSelect" checked data-toggle="toggle" data-size="xs" name="<?php echo $std->row_id; ?>" value="true" data-off="Present" data-on="Absent"  data-onstyle="danger" data-offstyle="success" checked>
                                                    <!-- <input name="<?php echo $std->student_id; ?>" type="checkbox" class="singleSelect" value="true" checked /> -->
                                                <?php }else{ ?>
                                                    <input type="checkbox" class="singleSelect" data-toggle="toggle" data-size="xs" name="<?php echo $std->row_id; ?>" value="true" data-off="Present" data-on="Absent"  data-onstyle="danger" data-offstyle="success">
                                                    <!-- <input name="<?php echo $std->student_id; ?>" type="checkbox" class="singleSelect" value="true" /> -->
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                </thead>
                            </table>
                            <div class="msgAlert"></div>
                            <?php if(!empty($classCompletedInfo)){ 
                            if($staff_id == $classCompletedInfo->staff_id){ ?>
                                <button onclick="confirmAbsentedStudents()" type="button" class="btn btn-success float-right mt-1">Confirm</button>
                            <?php } }else{ ?>
                                 <button onclick="confirmAbsentedStudents()" type="button" class="btn btn-success float-right mt-1">Confirm</button>
                            <?php }?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="attendanceModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Absented Students</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div id="msg"></div>
                <form action="#" method="POST" id="searchList">
                <div class="row">
                    <div class="col-lg-3 col-xs-5 col-sm-4 col-6">
                        <label>Date: <b style="color:green" id="attendanceDateConfirm"></b></label>
                    </div>
                    <div class="col-lg-2 col-xs-4 col-sm-4 col-6">
                        <label>Term: <b id="term_nameConfirm"></b></label>
                    </div>
                    <div class="col-lg-2 col-xs-4 col-sm-4 col-6">
                        <label>Stream: <b id="stream_nameConfirm"></b></label>
                    </div>
                    <div class="col-lg-2 col-xs-3 col-sm-4 col-6">
                        <label>Section: <b id="section_nameConfirm"></b></label>
                    </div>
                    <div class="col-lg-3 col-xs-12 col-sm-8 col-6">
                        <label>Subject: <b id="subject_nameConfirm"></b></label>
                    </div>
                    <div class="col-lg-3 col-xs-12 col-sm-8 col-6">
                        <label>Batch: <b id="student_batchConfirm"></b></label>
                    </div>
                </div>
                
                <table class="table table-hover table-bordered">
                    <tr class="table-primary">
                        <th width="90">Student ID</th>
                        <th width="90">Name</th>
                        <th width="50">Attendance</th>
                    </tr>
                    <tbody class="absentList">
                    </tbody>
                </table>
                    
            </div>
            <div class="modal-footer p-1">
                <div class="row w-100 ml-0">
                    <div class="col-8 pl-0">
                        <div class="float-left">
                            <h5 class="mb-0"><b>Total Absent Students : </b><span class="text-danger" id="countAbsent"></span></h5>
                        </div>
                    </div>
                    <div class="col-2 pr-0">
                        <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal">Close</button>
                    </div>
                    <div class="col-2 pl-0">
                        <button id="confirmToSubmitAbsentedStudents" type="button" class="btn btn-md btn-primary float-right" ><i class="fa fa-save"></i> Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
jQuery(document).ready(function() {
    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",

    });

    $('#selectAll').click(function(){
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);          
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    
    $('#confirmToSubmitAbsentedStudents').click(function(){
        var formData = $('#selectedAbsentStudents').serializeArray();
    
        $.ajax({
            url: '<?php echo base_url(); ?>/addSingleSubjectAttendanceByStaff',
            type: 'POST',
            
            data: {
                attInfo : JSON.stringify(formData),
            },
            success: function(data) { 
                $('.msgAlert').html('');
                if(data == 'true'){
                    $('#attendanceModel').modal('hide');
                    $('.msgAlert').html(`
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Attendance Added Successfully!
                    </div>
                    `);
                }else{
                    $('.msgAlert').html(`
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Nothing changes applied in attendance..
                    </div>`);
                    $('#attendanceModel').modal('hide');
                }
            },
            error: function(result)
            {
                alert("Network Server Error!!  Failed");
            },
            fail:(function(status) {
                alert("Server Error!!  Failed");
            }),
            beforeSend:function(d){
                $('.msgAlert').html(loader);
                $("#confirmToSubmitAbsentedStudents").prop('disabled', true);
            }
        });
    });

});

function confirmAbsentedStudents(){
    var total_absent_count = 0;
    $("#confirmToSubmitAbsentedStudents").prop('disabled', false);
    $(".absentList").html('');
    var formData = $('#selectedAbsentStudents').serializeArray();
    
    $.each(formData, async function(i, field){
        
        if(field.name == "term_name"){
        $("#term_nameConfirm").html(field.value);
        }else if(field.name == "stream_name"){
        $("#stream_nameConfirm").html(field.value);
        }else if(field.name == "section_name"){
        $("#section_nameConfirm").html(field.value);
        }else if(field.name == "subject_name"){
        $("#subject_nameConfirm").html(field.value);
        }else if(field.name == "attendance_date"){
        $('#attendanceDateConfirm').html(field.value);
        }else if(field.value == 'true'){ 
        total_absent_count++;
        var str = field.name;  
        var student_id = str.split(" ",1);
        var name = str.split(" /").pop(); 
        // alert(name)
        let std_name = "";
        try{
            std_name = await getNameByAdmissionNo(student_id[0]);
        }catch(err){
            std_name = "";
        }

        let student_id_display = "";
        try{
            student_id_display = await getStudentIdByAdmissionNo(student_id[0]);
        }catch(err){
            student_id_display = "";
        }
        $(".absentList > tr.all-present").remove()
        $(".absentList").append("<tr><td>" + student_id_display + "</td><td>" + std_name + "</td><td style='color:red'> Absent </td></tr>");
        }
    });
    $("#countAbsent").html(total_absent_count);
    if($('.absentList').text() == ""){
        $(".absentList").html("<tr class='text-center all-present'> <td colspan='2' style='color:green'> All student are present? </td></tr>");
    }
    $('#attendanceModel').modal('show');
}
</script>

<script>
    const getNameByAdmissionNo = student_id =>{
        return new Promise((resolve, reject)=>{
            try{
                $.post('<?=base_url()?>getNameByStudentNumber', { student_id })
                .then(result=>{
                    if(result === '0'){
                        reject('404');
                    }else{
                        resolve(result);
                    }
                }).catch(err2=>{
                    reject(err2);
                });;
            }catch(err){
                reject(err);
            }
        });
    }

    const getStudentIdByAdmissionNo = student_id =>{
        return new Promise((resolve, reject)=>{
            try{
                $.post('<?=base_url()?>getStudentIdByAdmissionNo', { student_id })
                .then(result=>{
                    if(result === '0'){
                        reject('404');
                    }else{
                        resolve(result);
                    }
                }).catch(err2=>{
                    reject(err2);
                });;
            }catch(err){
                reject(err);
            }
        });
    }

</script>

<?php
function getAbsentStudentList($con,$student_id,$section_row_id,$time_row_id,$absentDate,$subject_code,$class_batch){
    $query = "SELECT * FROM tbl_student_attendance_details as attendance 
    WHERE attendance.student_row_id = '$student_id' AND attendance.class_section_row_id = '$section_row_id' 
    AND attendance.time_row_id = '$time_row_id' AND attendance.absent_date = '$absentDate' 
    AND attendance.subject_code = '$subject_code' AND attendance.student_batch = '$class_batch' AND attendance.is_deleted = 0";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}
?>