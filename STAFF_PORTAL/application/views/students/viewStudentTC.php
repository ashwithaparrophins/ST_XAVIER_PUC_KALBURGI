
<style>
@media print {
    .main-footer {
        display: none !important;
    }

    .wizard-inner, .card-header, .card-footer {
        display: none;
    }
    .noprint {display:none;}
    ::-webkit-scrollbar {
        display: none;
    }

    @page {
        size: A4;
        /* margin: 0;  */
    }

    .page_break { 
        page-break-before: always;
    }
    .enable-print { display: block !important; }
    
   
}

.A4 {
    overflow: hidden;
    background: white;
    width: 26cm;
    height: 37.5cm;
    display: block;
    margin: 0 auto;
    padding: 20px;
    margin-bottom: 0.2cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    color: black !important;
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


/* ------------------ */
/* new added changes */
/* ----------------- */

.photo1 {
    margin-top: -70px !important;
}

.picture-box {
    margin-top: 15px;
}


.footer_sign {
    float: right;
    margin-right: 90px;
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
    padding: 5px 5px !important;
    vertical-align: middle !important;
    border-top: 1px solid #ddd;
    border: 1px solid black !important;
    font-size: 18px;
    font-weight: 600;
}

tr {
    height: 21px !important;
}


.border_full {
    border-style: solid;
    padding: 5px;
    border-color: black;
    border-width: 1px;
}

.boredr_left {
    border-left: solid;
    padding: 4px;
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
    padding: 23px !important;
    border-color: black;
    border-width: 1px;
    height: 28px;
}

.boredr_only_bottom {
    border-bottom: solid;
    padding: 7px;
    border-color: black;
    border-width: 1px;
}


.boredr_only_top {
    border-top: solid;
    padding: 7px;
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
    height: 175px;
    width: 165px;
    text-align: center;
}

.border_bottom_dashed {
    border-bottom: dashed;
    border-width: 3px;
    border-color: black;
    padding: 7px;
}
.table_declaration{
    margin-bottom: 10px;
}



.table_declaration>tbody>tr>th, .table_declaration>tfoot>tr>td, .table_declaration>tfoot>tr>th, 
.table_declaration>thead>tr>td, .table_declaration>thead>tr>th {
    padding: 3px 4px !important;
    line-height: 1.0 !important;
    vertical-align: middle !important;
    border-top: 1px solid #ddd;
    border: 1px solid transparent !important;
    font-size: 17px;
}

.table_data>tbody>tr>th, .table_data>tfoot>tr>td, .table_data>tfoot>tr>th, 
.table_data>thead>tr>td, .table_data>thead>tr>th {
    padding: 3px 4px !important;
    font-size: 20px;
}
.content_list{
    list-style-type: lower-alpha;
    margin-bottom: 0px;
}
.content_list li{
    padding: 2px 0;
}
.place_date{
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 4px;
    color: black !important;
}
h4{
    color: black !important;
}
.listing_bottom{
    text-indent: 25px;
}
.sub_title{
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 10px;
}
.spacing_left{
    margin-left: 10px;
}

.watermarked {
  position: relative;
}

.watermarked:after {
  content: "";
 
  width: 100%;
  height: 70%;
  position: absolute;
  top: -2px;
  left: 0px;
  background-image: url("<?php echo base_url(); ?>assets/dist/img/logo_stxpuc.jpg");
  background-size: 100% 100%;
  background-position: -10px -20px;
  background-repeat: no-repeat;
  opacity: 0.08;
}
</style>


<div class="main-content-container container-fluid px-4 pt-2 a">
    <div class="content-wrapper">
        <div class="row noprint">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-file"></i> Student Transfer Certificate
                            </div>
                            <div class="col-lg-4 col-md-4 col-4"> 
                                <a href="#" onClick="window.print();" class="btn text-white btn-success btn-bck float-right">
                                <i class="fa fa-download"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

        <?php //if(empty($studentInfo)){ ?>
        <!-- <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
            <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
            </div>
        </div> -->
        <?php //} else {  ?>
            <div class="row form-employee">
                <div class="col-12">
                    <div class="card card-small c-border p-2 mb-4">
                    <?php if(!empty($studentInfo)) {
                        $total_students_selected = count((array)$studentInfo);
                        foreach($studentInfo as $record)
                        {  
                            $total_students_selected--;
                            $stream_name = $record->stream_name;
                            $date = convert_number(date('d',strtotime($record->dob)));
                            $year = convert_numberYear(date('Y',strtotime($record->dob)));
                            $subject = getSubjectsName($stream_name);
                    ?>
                        <div class="A4 enable-print">
                            <div style="mb-0">
                                <br/>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="header-heading text-center">
                                        <p style="font-size: 16px;text-align:right;"><b>ORIGINAL</b></p>
                                        <table class="table table_data" style="margin-top: -30px;">
                                            <tr>
                                   
                                            <th width="220">     
                                            <img id="main-logo" class="d-inline-block logo_mobile_view mr-0 rounded"
                            style="width: 200px;height: 120px" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>"
                            alt="logo"></th>
                                              <th colspan="2">  <b class="mb-1" style="font-size: 30px;font-weight: 400; text-transform: uppercase;font-family: serif;"><strong>ST. XAVIER'S PRE–UNIVERSITY COLLEGE</strong></b>
                                            <p class="mb-1" style="font-size: 18px;font-weight: 600;">NH 50, FARHATABAD POST SIRNOOR, KALABURAGI - 585308</p>
                                            <p class="mb-1" style="font-size: 18px;font-weight: 600;">KARNATAKA, INDIA</p></th></tr>
                                         <tr> <th style="border-right: 4px solid white;" height="50" style="border-left: 4px solid white;"><b class="border_full" style="font-size: 16px;padding-left:10px;"><b>TC No:<?php echo $record->tc_number; ?></b></b></th>  
                                            <th style="border-right: 4px solid white;"><b class="border_full" style="font-size: 18px;padding-left: 150px;padding-right:150px;"><b>TRANSFER CERTIFICATE</b></b></th>
                                            <th><b class="border_full" style="font-size: 18px;padding-left: 20px;padding-right:20px;"><b>Date:<?php echo date('d/m/Y',strtotime($record->created_date_time)); ?></b></b></th>
                                        </tr>
                        </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- <div class="row boredr_only_top boredr_left_right">
                                    <div class="col-6" style="margin-top: -13px;">
                                        <b style="font-size: 18px;">Roll No. :&nbsp;</b>
                                        <span class="border_full" style="font-size: 18px;padding-left: 85px;padding-right:85px;"><b> <?php echo $record->student_id; ?></b></span>
                                    </div>
                                
                                    <div class="col-6" style="margin-top: -13px;">
                                        <b style="font-size: 18px;">T.C. No. :&nbsp;</b>
                                        <span class="border_full" style="font-size: 18px;padding-left: 10px;padding-right:50px;"><b><?php echo $record->tc_number; ?></b></span>
                                    </div>
                                </div> -->
                                <div class="row watermarked">   
                                     <div class="col-lg-12 col-sm-12 col-12" style="margin-top: -13px;">
                                    <table class="table table_data">
                                        <tr>
                                            <th width="480"><b>01. <span class="spacing_left">Name of the Student</span></b>
                                              
                                            </th>
                                            <th><?php echo strtoupper($record->student_name); ?></th>
                                        </tr>
                                        <tr>
                                            <th>02. <span class="spacing_left">Date of Birth</span>
                                                <!-- <ul class="content_list" style="margin-left: 8px;">
                                                    <li> In Figures</li>
                                                    <li> In words</li>
                                                </ul> -->
                                            </th>
                                            <!-- <th><//?php echo date('d/m/Y',strtotime($record->dob)); ?> -->
                                            <th><?php echo date('d F Y', strtotime($record->dob)); ?></th>

                                                <!-- <br><ul class="content_list" style="list-style-type: none;">
                                                    <li style="margin-left: -40px;"><//?php echo date('d/m/Y',strtotime($record->dob)); ?></li>
                                                    <!-- <li style="margin-left: -40px;"><//?php echo strtoupper($date.' '.date('F',strtotime($record->dob)).' '.$year); ?></li> -->
                                                <!-- </ul> -->
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>03. <span class="spacing_left">Nationality</span></th>
                                            <th><?php echo $record->nationality; ?> <!--<?php echo $record->religion; ?> <?php echo $record->caste; ?>--></th>
                                        </tr>
                                        <tr>
                                            <th>04. <span style="margin-left: 10px;">a) Father's Name</span>
                                                <br><span style="margin-left: 40px;line-height: 2;">b) Mother's Name</span>
                                            </th>
                                            <th>
                                                <?php echo strtoupper($record->father_name); ?>
                                                <br><span style="line-height: 2;"><?php echo strtoupper($record->mother_name); ?></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>05. <span class="spacing_left">Religion</span></th>
                                            <th><?php echo $record->religion; ?></th>
                                        </tr>
                                        <tr>
                                            <th>06. <span class="spacing_left">Whether the candidate belongs to Scheduled &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caste or Tribe</span>
                                            </th>
                                            <th><?php echo $record->is_belongs_sc_st; ?></th>
                                        </tr>
                                        <tr>
                                            <th>07. <span class="spacing_left">Date of Admission to the College</span></th>
                                            <th><?php echo date('d/m/Y',strtotime($record->date_of_admission)); ?></th>
                                        </tr>
                                        <tr>
                                            <th>08. <span class="spacing_left">Date of leaving the College</span></th>
                                            <th><?php echo date('d/m/Y',strtotime($record->leaving_date)); ?></th>
                                        </tr>
                                        <tr>
                                            <th>09. <span class="spacing_left">Class in which the student was studying at the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;time of leaving</span></th>
                                            <th><?php echo $record->term_name; $record->program_name; ?>
                                            <?php echo $record->program_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>10. <span class="spacing_left">Subjects studied at the time of leaving</span><span style="margin-left: 6px;"><br/><span style="margin-left: 50px;">a) Languages</span>
                                                <br><span style="margin-left: 50px;">b) Optionals</span>
                                            </th>
                                            <th>
                                              
                                                <span>ENGLISH,<?php echo strtoupper($record->elective_sub); ?></span>
                                                <br><span><?php echo strtoupper($subject); ?></span>
                                            </th>
                                        </tr>
                                        <tr>
                                        <th>11. <span class="spacing_left">Medium</span></th>
                                        <?php if ($record->program_name == 'COMMERCE' || $record->program_name == 'SCIENCE') { ?>
                                            <th>ENGLISH</th>    
                                        <?php } else { ?>
                                            <th>KANNADA</th>
                                        <?php } ?>



                                
                                        </tr>
                                    
                                        <tr>
                                            <th>12. <span class="spacing_left">Whether Qualified for promotion to a higher &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;class</span></th>
                                            <th><?php echo $record->is_promoted; ?>
                                        <!--.' '.$record->reason_unqualified-->
                                        </th>
                                        </tr>
                                        <!-- <tr>
                                            <th>11. <span class="spacing_left">Register Number(Exam No.)</span></th>
                                            <th><?php echo $record->hall_ticket_no; ?></th>
                                        </tr> -->
                                      
                                        <tr>
                                            <th>13. <span class="spacing_left">Whether the student has paid all the fees due &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to the college</span></th>
                                            <th><?php echo $record->is_cleared_college_due; ?></th>
                                        </tr>
                                        <tr>
                                            <th>14. <span class="spacing_left">Character and Conduct</span></th>
                                            <th><?php echo $record->character_conduct; ?></th>
                                        </tr>




                                        <tr>
                                                <th colspan='2' rowspan='5'><br/>College DISE Code :&nbsp;&nbsp;&nbsp;29040512405
                                                <!-- <th><?php echo date('d/m/Y',strtotime($record->dob)); ?></th> -->
                                            
                                              <br/>SATS No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $record->sat_number; ?> 
                                              <br/>Student No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $record->pu_board_number; ?> 
                                              <br/>Admission No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $record->admission_number; ?> 
                                               <!-- <//?php log_message('debug','number'.$record->admission_number); ?>  -->
                                              <br/>Class Reg No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $record->student_id; ?> 
                                             <div class="col-12">
                                                <h6 class="place_date" style="font-size: 16px;"> <span class="footer_sign"><br/><br/><br/><br/><br/><br/>PRINCIPAL</span></h6>
                                            </div>
                                            </th>
                                            </tr>






                                        <!-- <tr>
                                            <th colspan="2">
                                                <span style="font-size: 17px;">Certified that the student was not debarred, rusticated or otherwise disqualified from continuing his studies by the 
                                            Pre-University Board for any malpractice at any Pre-University Examination or for any other kind of misbehaviour.</span>
                                            </th>
                                        </tr> -->
                                    </table>
                                </div></div>
                                
                                <!-- <div class="row" style="margin-top: 0px;margin-bottom: 5px;">
                                    <div class="col-12">
                                        <h6 class="place_date">Date &nbsp;&nbsp;: <?php echo date('d/m/Y',strtotime($record->created_date_time)); ?></h6>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="place_date">Place&nbsp; : Kalaburgi</h6>
                                    </div>
                                </div><br><br><br><br> -->
                                 <div class="row" style="margin-top:10px;font-size: 20px;">
                                    <div class="col-12">
                                        <!-- <h4 class="text-center" style="font-size: 25px;margin-bottom: 0px;"> <b>ST. XAVIER'S PRE–UNIVERSITY COLLEGE, KALABURAGI</b></h4> -->
                                        <!-- <p class="text-center sub_title">Address</p> -->
                                     
                                        <div class="row mt-1">
                                            <!-- <div class="col-12">
                                                <h6 class="place_date" style="font-size: 16px;">Date &nbsp;&nbsp;: <?php echo date('d/m/Y',strtotime($record->created_date_time)); ?></h6>
                                            </div> -->
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>
                        <?php if($total_students_selected > 1) { ?>
                            <div class="page_break"></div>
                        <?php } ?>

                        <?php } } ?>
                        <div class="card-footer p-1">
                            <a href="#" onClick="window.print();" class="btn text-white btn-success btn-bck float-left">
                            <i class="fa fa-download"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php //} ?>
    </div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}
jQuery(document).ready(function() {

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })
});
</script>


<?php

function convert_number($number) {
    if (($number < 0) || ($number > 999999999)) {
        throw new Exception("Number is out of range");
    }
    $Gn = floor($number / 1000000);
    /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);
    /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);
    /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);
    /* Tens (deca) */
    $n = $number % 10;
    /* Ones */
    $res = "";
    if ($Gn) {
        $res .= $this->convert_number($Gn) .  "Million";
    }
    if ($kn) {
        $res .= (empty($res) ? "" : " ") .convert_number($kn) . " Thousand";
    }
    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .convert_number($Hn) . " Hundred";
    }
    $ones = array("", "First", "Second", "Third", "Fourth", "Fifth", "Sixth", "Seventh", "Eighth", "Ninth", "Tenth", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");
    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " ";
        }
        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];
            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }
    if (empty($res)) {
        $res = "zero";
    }
    return $res;
}

function convert_numberYear($number) {
    if (($number < 0) || ($number > 999999999)) {
        throw new Exception("Number is out of range");
    }
    $Gn = floor($number / 1000000);
    /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);
    /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);
    /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);
    /* Tens (deca) */
    $n = $number % 10;
    /* Ones */
    $res = "";
    if ($Gn) {
        $res .= $this->convert_numberYear($Gn) .  "Million";
    }
    if ($kn) {
        $res .= (empty($res) ? "" : " ") .convert_numberYear($kn) . " Thousand";
    }
    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .convert_numberYear($Hn) . " Hundred";
    }
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");
    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " ";
        }
        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];
            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }
    if (empty($res)) {
        $res = "zero";
    }
    return $res;
}
function getSubjectsName($stream_name){
    //science
    $PCMB = 'Physics,Chemistry,Mathematics,Biology';
    $PCMC = 'Physics,Chemistry,Mathematics,Computers';
    $PCME = 'Physics,Chemistry,Mathematics,Electronics';
    //commarce
    $PEBA = 'Political Science,Economics,<br/>Business Studies,Accountancy';
    $MEBA = 'Basic Mathematics,Economics,<br/>Business Studies,Accountancy';
    $MSBA = 'Basic Mathematics,Statistics,<br/>Business Studies,Accountancy';
    $CSBA = 'Computer Science,Statistics,<br/>Business Studies,Accountancy';
    $SEBA = 'Statistics,Economics,Business Studies,Accountancy';
    $EBAC = 'Computer Science,Economics,<br/>Business Studies,Accountancy';
    //art
    $HEPS ='History,Economics,Political Science,Sociology';
    $HEPE = 'History,Economics,Political Science and Education';
    switch ($stream_name) {
        case "PCMB":
            return  $PCMB;
            break;
        case "PCMC":
            return $PCMC;
            break;
        case "PEBA":
            return $PEBA;
            break;
        case "PCME":
            return $PCME;
            break;
        case "MEBA":
            return $MEBA;
            break;
        case "MSBA":
            return $MSBA;
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
        case "HEPS":
            return $HEPS;
            break;
        case "HEPE":
            return $HEPE;
            break;
    }
}
?>