<?php require APPPATH . 'views/includes/db.php'; ?>
<style>
    .break { page-break-before: always; } 
    .break_after { page-break-before: none; } 
    @media print {
        .page-break {
            display: block;
            page-break-before: always;
        }

    }

    @media print {
        .noprint {
            display: none;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .enable-print {
            display: block !important;

        }
        @page {
            size: A4;
            /* margin: 5px;  */
        
        }
        .main-footer,.floating-button{
            display: none !important;
        }
        .main-sidebar, .navbar{
            display: none !important;
        }
    }

    .A4 {
        /* overflow-x: scroll; */
        background: white;
        width: 26cm;
        height: 34.7cm;
        display: block;
        margin: 0 auto;
        padding: 25px;
        color: #000;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    #border {
        border-radius: 1px;
        border: 2px solid black;
        width: 18.5cm;
        height: 26.7cm;

    }

    .stm_work {
        font-size: 25px;
        font-weight: bold;
    }

    .title {
        font-size: 30px;
        margin-left: -25px;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;

        padding: 3px;
    }

    /* ------------------ */
    /* new added changes */
    /* ----------------- */
    .photo1 {
        margin-top: -15px !important;
    }

    /* .picture-box {
        margin-top: 15px;
    } */

    input[type=checkbox] {
        cursor: pointer;
        font-size: 10px;
        visibility: hidden;
        position: unset !important;
        top: 0;
        margin-left: 0px !important;
        transform: scale(1.5);
    }

    input[type=checkbox]:after {
        content: " ";
        background-color: #fff;
        display: inline-block;
        color: black;
        width: 10px;
        height: 10px;
        visibility: visible;
        border: 1px solid black;
        padding: 2px;
        margin: 1px 0;
        border-radius: 1px;
        box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
    }

    input[type=checkbox]:checked:after {
        content: "\2714";
        display: unset;
        font-weight: bold;
        width: 15px;
        height: 15px;
        padding: 2px
    }

    .checkbox-inline {
        padding-left: 9px !important;
    }

    .footer-sign {
        margin-top: 50px;
        text-transform: uppercase;
        font-size: 14px;
    }

    .boredr-only-top {
        border-top: solid;
        border-color: black;
        border-width: 1px;
        margin-top: 15px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1.0 !important;
        vertical-align: inherit !important;
        border-top: 1px solid #ddd;
        border: 1px solid black !important;
        font-size: 14px;
        color: #000 !important;
    }

    tr {
        height: 22px !important;
    }

    .border_full {
        border-style: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_left {
        border-left: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_right {
        border-right: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_left_right {
        border-right: solid;
        border-left: solid;
        padding: 6px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_only_bottom {
        border-bottom: solid;
        /* padding: 7px; */
        border-color: black;
        border-width: 1px;
    }

    .boredr_only_top {
        border-top: solid;
        padding: 6px;
        border-color: black;
        border-width: 1px;
    }

    .text_style_2 {
        margin-left: -12px;
        font-weight: bold;
        float: left;
        margin-top: -8px;
    }

    .photo_style {
        border: 1px solid;
        height: 165px;
        width: 155px;
        text-align: center;
        margin-left: 20px;
        margin-top: -25px !important;
    }

    .heading_three {
        margin-top: -12px;
        font-size: 22px;
        margin-bottom: -12px;
        text-transform: uppercase;
        text-decoration: underline;
    }

    .header-heading {
        margin-left: -80px;
    }

    .pb-5 {
        padding-bottom: 5px !important;
    }

    .headings {
        font-size: 18px !important;
    }

    .table_exam td {
        font-size: 19px !important;
        padding: 9px !important;
    }

    .table_exam th {
        padding: 3px !important;
        font-size: 16px !important;
    }
</style>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row noprint">
            <div class="col">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-md-8 col-8 text-black  " style="font-size:22px;"><i
                                    class="fa fa-file"></i> Students Admission Ticket - 2024
                                </div>
                            <div class="col-md-4 col-4"> 
                                <button style="float:right;" class="btn btn-primary" type="button" title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-print"></i> Print/Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-employee">
            <div class="col-12">
                <div class="card card-small c-border p-0 mb-2">
            <!-- <h3 class="box-title">Students Details <span style="margin-left:50px">Total Students: </span></h3> -->
       <!-- /.box-header -->
       

                <div class="A4 enable-print">

                    <?php if (!empty($studentsRecords)) {
                        $studentCount = 0;
                        $total_students_selected = count((array)$studentsRecords);
                        foreach ($studentsRecords as $record) {
                            $studentCount++;
                            $total_students_selected--;
                            $examDetails = getExamDetails($con,$record->term_name,$record->stream_name);
                            log_message('debug','dddd'.print_r($examDetails,true));
                            $subjects_code = array();
                            $elective_sub = strtoupper($record->elective_sub);
                            if($elective_sub == "KANNADA"){
                                array_push($subjects_code, '01');
                            }else if($elective_sub == 'HINDI'){
                                array_push($subjects_code, '03');
                            } else if($elective_sub == 'FRENCH'){
                                array_push($subjects_code, '12');
                            }
                            array_push($subjects_code, '02');
                            $subjects = getSubjectCodes($record->stream_name);
                            
                            $subjects_code = array_merge($subjects_code,$subjects);
                     if ($record->term_name == 'I PUC') {    
                        $img_path = "assets/images/PHOTOS_22_23_ALL/".$record->student_id.".JPG";
                    }else{
                        $img_path = "assets/images/PHOTOS_21_22_ALL/".$record->student_id.".jpg";
                    }
                        
                    ?>

                            <div class="row boredr_only_top boredr_left_right">
                                <div class="col-2">
                                    <img height="110" class="pull-left" width="110" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" alt="logo">
                                </div>
                                <div class="col-10">
                                    <div class="header-heading text-center">
                                        <b style="font-size: 28px; text-transform: uppercase;">ST XAVIER'S PRE–UNIVERSITY COLLEGE, KALABURAGI</b>
                                        <p style="margin-top: 0px; font-size:19px; text-transform: uppercase;"><b><?php echo strtoupper($record->term_name); ?> I - PREPARATORY EXAMINATION JANUARY - 2024 <br/><u style="font-weight: bold;">Admission Ticket</u></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row boredr_left_right" style="margin-bottom: -10px;">
                                <div class="col-9">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="headings" style="border: 1px solid white !important;"><b>COLLEGE REGISTER NO. &ensp;&ensp;&ensp;&nbsp;: <?php echo $record->student_id; ?></b></td>
                                                <td class="headings" style="border: 1px solid white !important;"><b>SECTION : <?php echo $record->section_name; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="headings" colspan="2" style="border: 1px solid white !important;"> <b>NAME OF THE CANDIDATE &nbsp;: <?php echo strtoupper($record->student_name); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="headings" colspan="2" style="border: 1px solid white !important;"> <b>NAME OF THE FATHER &emsp;&emsp;&nbsp;: <?php echo strtoupper($record->father_name); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="headings" colspan="2" style="border: 1px solid white !important;"> <b>NAME OF THE MOTHER &ensp;&ensp;&ensp;&nbsp;: <?php echo strtoupper($record->mother_name); ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-3" colspan="3" style="margin-top: -10px;">
                                    <div class=" photo1">
                                        <p style="font-size: 14px;margin-top: -15px;">
                                            <!-- <img width="145" height="145" class="text-right" src="<?php echo $img_path; ?>" alt="profile Img"> -->
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row boredr_left_right boredr_only_bottom">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table_exam">
                                            <!-- <thead> -->
                                                <tr>
                                                    <th class="text-center">DATE</th>
                                                    <th class="text-center"><!-- MORNING SESSION <br> -->TIME : 9.15AM TO 12.15PM</th>
                                                    <!-- <th class="text-center">AFTER NOON SESSION <br>TIME : 2.00PM TO 5.15PM</th> -->
                                                    <th class="text-center">INVIGILATOR'S SIGNATURE</th>
                                                </tr>
                                                
                                            <!-- </thead>
                                            <tbody> -->
                                                 <!-- foreach($subjects_code as $sub){  -->
                                                    <?php 
                                                    $exam_name = 'I-PREPARATORY EXAMINATION';
                                                    $examInfo = $examData->getExamInfo($record->term_name,$record->stream_name,$subjects_code,$exam_name);
                                                    // log_message('debug','fffff'.print_r($examInfo,true));
                                                    foreach($examInfo as $exam){  
                                                        if($exam->time == 'Morning session'){ ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo date('d-m-Y',strtotime($exam->exam_date))?></td>
                                                            <td class="text-center" style="text-transform: uppercase;"><?php echo $exam->name; ?></td>
                                                            <!-- <td class="text-center">--</td> -->
                                                            <td class="text-center"></td>
                                                        </tr>
                                                        <?php } /*else{*/ ?>
                                                      <!--   <tr>
                                                            <td class="text-center"><?php echo date('d-m-Y',strtotime($exam->exam_date))?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-center" style="text-transform: uppercase;"><?php echo $exam->name; ?></td>
                                                            <td class="text-center"></td>
                                                        </tr> -->

                                                    <?php  } /*}*/ ?>
                                            <!-- </tbody> -->
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="footer-sign">
                                        <span style="font-size: 16px;" class=""><b>Signature of the Student</b></span>
                                        <span style="font-size: 16px;" class="pull-right"><b>Signature of the Co-Ordinator</b></span>
                                    </div>
                                </div>

                            </div>

                            <?php
                            $pageBreakCheck = fmod($studentCount, 2);
                            if ($pageBreakCheck == 0) {
                            ?>
                                <div class="page-break"></div>
                            <?php } else {
                                echo '<br><br><br><br><br><br>';
                            } ?>
                        <?php } ?>
                    <?php  } ?>
                </div>


            </div>

        <!-- <div class="box-footer clearfix noprint">
            <button style="float:right;" class="btn btn-primary" type="button" title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-download"></i> Print/Save</button>
        </div> -->
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "studentsListing/" + value);
            jQuery("#searchList").submit();
        });
        // jQuery(function() {
        //     jQuery(this).bind("contextmenu", function(event) {
        //         event.preventDefault();
        //     });
        // });
    });
</script>

<?php 


// function getExamInfo($con,$term_name,$stream_name,$subject_code){
//     $query = "SELECT sub.name,exam.exam_date,exam.time,exam.subject_code FROM  tbl_exam_info as exam, tbl_subjects as sub
//     WHERE sub.subject_code = exam.subject_code AND exam.class = '$term_name' AND exam.stream = '$stream_name'
//     AND exam.subject_code = '$subject_code' AND exam.exam_year = '2022' AND exam.exam_name = 'MID-TERM EXAM' AND exam.is_deleted = 0 AND exam.exam_status = 0
//     ORDER BY exam.exam_date DESC";
//     $pdo_statement = $con->prepare($query);
//     $pdo_statement->execute();
//     return $pdo_statement->fetchAll();
// }

function getExamDetails($con,$term_name,$stream_name){
    $query = "SELECT * FROM  tbl_exam_info
    WHERE class = '$term_name' AND stream = '$stream_name'
    AND is_deleted = 0 AND exam_status = 0 AND exam_year = '2023' AND exam_name ='I-PREPARATORY EXAMINATION' GROUP BY class,stream";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}

function getSubjectCodes($stream_name){
    //science
    $PCMB = array("33", "34", "35", '36');
    $PCMC = array("33", "34", "35", '41');
    $PCME = array("33", "34", "35", '40');
    $PCMS = array("33", "34", "35", '31');
    //commarce
    $BEBA = array("75", "22", "27", '30');
    $BSBA = array("75", "31", "27", '30');
    $CSBA = array("41", "31", "27", '30');
    $SEBA = array("31", "22", "27", '30');
    $EBAC = array("41", "22", "27", '30');
    $PEBA = array("29", "22", "27", '30');
    //art
    $HEPP = array("21", "22", "32", '29');
    $MEBA = array("75", "22", "27", '30');
    $MSBA = array("75", "31", "27", '30');
    $HEPS = array("21", "22", "29", '28');
    $HEPE = array("21", "22", "29", '52');
  
    switch ($stream_name) {
        case "PCMB":
            return  $PCMB;
            break;
        case "PCMC":
            return $PCMC;
            break;
        case "PCME":
            return $PCME;
            break;
        case "PCMS":
            return $PCMS;
            break;
        case "PEBA":
            return $PEBA;
            break;
        case "BEBA":
            return $BEBA;
            break;
        case "BSBA":
            return $BSBA;
            break;
        case "CSBA":
            return $CSBA;
            break;
        case "SEBA":
            return $SEBA;
            break;
        case "EBAC":
            return $EBAC;
            break;
        case "HEPP":
            return $HEPP;
            break;
        case "HEPS":
            return $HEPS;
            break;
        case "MEBA":
            return $MEBA;
            break;
        case "MSBA":
            return $MSBA;
            break;
        case "HEPE":
            return $HEPE;
            break;
    }
  }
?>