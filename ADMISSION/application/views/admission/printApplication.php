<?php
//============================================================+
// File name   : example_020.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 020 for TCPDF class
//               Two columns composed by MultiCell of different
//               heights
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
* Creates an example PDF TEST document using TCPDF
* @package com.tecnick.tcpdf
* @abstract TCPDF - Example: Two columns composed by MultiCell of different heights
* @author Nicola Asuni
* @since 2008-03-04
*/

// Include the main TCPDF library (search for installation path).


// extend TCPF with custom functions
class MYPDF extends TCPDF {
    public function Header() {
        
        
    }

	
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 14);
// add a page
$pdf->SetTitle('View/Print Application');
$pdf->AddPage();
$education_qualification= "";
$sl=1;
$date_of_birth = date('d/m/Y',strtotime($studentApplicationInfo->dob));
$student_email = strtolower($studentApplicationInfo->email);
$parent_email = strtolower($studentApplicationInfo->family_email);
$current_date = date('d-m-Y');
$table= "";

foreach($studentMarkInfo as $mark){
    if($mark->subject_name == 'EXEMPTED'){
        $max_mark = 'EX';
        $obtained_mark = 'EX';

    }else{
        $max_mark = $mark->max_mark;
        $obtained_mark = $mark->obtnd_mark;

    }
    $table .= '<tr>
    <td style="vertical-align:middle;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$mark->subject_name.'</b></td>
    <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$max_mark.'</b></td>
    <td style="vertical-align:middle;text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$obtained_mark.'</b></td>
    </tr>';

    $table9th .= '<tr>
    <td style="vertical-align:middle;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$mark->subject_name.'</b></td>
    <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$max_mark.'</b></td>
    </tr>';
} 

    if($boardInfo->board_name == "KARNATAKA STATE BOARD"){
        $board_name = "SSLC";
    }else{
        $board_name = $boardInfo->board_name;
    }
    $total_max_mark = 0;
    $total_mark = 0;
    if($boardInfo->board_name == "CBSE"){
        foreach($studentMarkInfo as $mark){
            $total_max_mark += $mark->max_mark;  
            $total_mark += $mark->obtnd_mark;
            $totalPercentage = ($total_mark / $total_max_mark) * 100;
        }
    } else if($boardInfo->board_name == "ICSE"){
        $markInfo = array_slice($studentMarkInfo, 0, 5, true);
        foreach($markInfo as $mark){
            $total_max_mark += $mark->max_mark;  
            $total_mark += $mark->obtnd_mark;
            $totalPercentage = ($total_mark / $total_max_mark) * 100;
        }
    } else {
        foreach($studentMarkInfo as $mark){
            if($mark->subject_name == 'EXEMPTED'){
                $max_mark = 0;  
            }else{
                $max_mark = $mark->max_mark;  
            }
            $total_max_mark += $max_mark;  
            $total_mark += $mark->obtnd_mark;
            $totalPercentage = ($total_mark / $total_max_mark) * 100;
        }
    }
    $total_percentage = round($totalPercentage,2);


$set_html=<<<EOD
<tr nobr="true">
    <td style="font-size: 15px;">Application No.: <b style="color: red;">$appInfo->application_number</b></td>
</tr>
<table cellpadding="3" cellspacing="1">
    <tr nobr="true">
        <td width="100" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;vertical-align:middle;">
            <img width="200" height="220" src="assets/dist/img/logo_stxpuc.jpg" alt="logo">
        </td>
        <td width="470" style="text-align:center;border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <td style="font-size:20px;"><b>ST. XAVIER'S PRE–UNIVERSITY COLLEGE</b></td>
            </tr>
            <tr>
                <td style="font-size:14px;">(Department of Pre-University Education, Government of Karnataka)</td>
            </tr>
            <tr>
                <td style="font-size: 13px">N.H 50, SIRNOOR KALABURAGI - 585308</td>
            </tr>
            <tr>
                <td style="font-size:18px;font-weight: bold;">Admission Form for I PUC 2024-25</td>
            </tr>
        </td>
        <td style="border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;" width="100">
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;" width="672">
            <table cellpadding="1" cellspacing="1">
                <tr nobr="true">
                    <td style="text-align: center;font-size:12px;"><b>For Office Use Only</b></td>
                </tr>
                <tr>
                    <td style="width: 530px">
                        <table cellpadding="0">
                        <tr>
                        <td style="font-size: 2px;"></td>
                    </tr>

                    <tr>
                    <td style="font-size: 2px;"></td>
                </tr>
                
                <tr>
                <td style="font-size: 2px;"></td>
            </tr>
            
            <tr>
            <td style="font-size: 2px;"></td>
        </tr>
        
        <tr>
        <td style="font-size: 2px;"></td>
    </tr>
    
    <tr>
    <td style="font-size: 2px;"></td>
</tr>
<tr>
<td style="font-size: 2px;"></td>
</tr>
<tr>
<td style="font-size: 2px;"></td>
</tr>
<tr>
<td style="font-size: 2px;"></td>
</tr>


                <tr nobr="true">
                <td style="font-size: 12px;width: 90px;"><i>Application No: </b></td>
                <td style="font-size: 12px;width: 180px;"><b>$appInfo->application_number</b></td>
                <td style="font-size: 12px;width: 130px;"><i>Admission No:</i></td>
            </tr>
            <tr>
<td style="font-size: 2px;"></td>
</tr>
<tr>
<td style="font-size: 2px;"></td>
</tr>
                           
                            <tr nobr="true">
                                <td style="font-size: 12px;width: 270px;"><i>Registration No:</b></td>
                                <td style="font-size: 12px;width: 150px;"><i>Reciept No:</i></td>
                            </tr>
                            <tr>
                                <td style="font-size: 2px;"></td>
                            </tr>
                            <tr nobr="true">
                                <td style="font-size: 12px;width: 267px;"><i>Date:</i></td>
                                <td style="font-size: 12px;width: 80px;"><i>Admitted To:</b></td>
                                <td style="font-size: 12px;width: 80px;"><b>$studentAdmissionInfo->second_language</b></td>
                            </tr>
                        </table>
                    </td>
                    <td><img style="vertical-align:middle;" height="120" width="150" src="$photoInfo->doc_path" alt="Student Image"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;" width="672">
            <table cellpadding="1">
                <tr nobr="true">
                    <td style="font-size: 12px;width: 40px;"><i>Name:</b></td>
                    <td style="font-size: 12px;width: 240px;"><b>$studentApplicationInfo->name</b></td>
                    <td style="font-size: 12px;width: 76px;"><i>Date of Birth:</i></td>
                    <td style="font-size: 12px;width: 122px;"><b>$date_of_birth</b></td>
                    <td style="font-size: 12px;width: 50px;"><i>Gender:</i></td>
                    <td style="font-size: 12px;"><b>$studentApplicationInfo->gender</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 112px;"><i>Place of Birth:Taluk:</i></td>
                    <td style="font-size: 12px;width: 167px;"><b>$studentApplicationInfo->native_taluk</b></td>
                    <td style="font-size: 12px;width: 45px;"><i>District:</b></td>
                    <td style="font-size: 12px;width: 154px;"><b>$studentApplicationInfo->native_district</b></td>
                    <td style="font-size: 12px;width: 35px;"><i>State:</i></td>
                    <td style="font-size: 12px;width: 158px;"><b>$studentApplicationInfo->native_state</b></td>
                   
                  
                </tr>
                <tr nobr="true">
                <td style="font-size: 12px;width: 70px;"><i>Nationality:</b></td>
                <td style="font-size: 12px;width: 100px;"><b>$studentApplicationInfo->nationality</b></td>
                <td style="font-size: 12px;width: 55px;"><i>Religion:</i></td>
                <td style="font-size: 12px;width: 110px;"><b>$studentApplicationInfo->religion</b></td>
                <td style="font-size: 12px;width: 40px;"><i>Caste:</i></td>
                <td style="font-size: 12px;width: 100px;"><b>$studentApplicationInfo->caste</b></td>       
                <td style="font-size: 12px;width: 62px;"><i>Sub Caste:</i></td>
                <td style="font-size: 12px;width: 125px;"><b>$studentApplicationInfo->sub_caste</b></td>   
               
            </tr>
            <tr nobr="true">
             
                <td style="font-size: 12px;width: 120px;"><i>Caste Certificate No:</i></td>
                <td style="font-size: 12px;width: 220px;"><b>$studentApplicationInfo->caste_no</b></td>
                <td style="font-size: 12px;width: 125px;"><i>Income Certificate No:</i></td>
                <td style="font-size: 12px;width: 200px;"><b>$studentApplicationInfo->income_no</b></td>          
               
            </tr>

            <tr nobr="true">
            <td style="font-size: 12px;width: 75px;"><i>Aadhaar No:</i></td>
            <td style="font-size: 12px;width: 120px;"><b>$studentApplicationInfo->aadhar_no</b></td>
            <td style="font-size: 12px;width: 40px;"><i>Email:</i></td>
            <td style="font-size: 12px;width: 255px;"><b>$studentApplicationInfo->student_email</b></td>
            <td style="font-size: 12px;width: 72px;"><i>Whatsap No:</i></td>
            <td style="font-size: 12px;width: 100px;"><b>$studentApplicationInfo->student_mobile</b></td>       
       
           
        </tr>

                <tr nobr="true">
                    <td style="font-size: 12px;width: 90px;"><i>Father's Name:</b></td>
                    <td style="font-size: 12px;width: 270px;"><b>$studentApplicationInfo->father_name</b></td>
                    <td style="font-size: 12px;width: 70px;"><i>Mobile No:</b></td>
                    <td style="font-size: 12px;width: 250px;"><b>$studentApplicationInfo->father_mobile</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 80px;"><i>Qualification:</b></td>
                    <td style="font-size: 12px;width: 280px;"><b>$studentApplicationInfo->father_qualification</b></td>
                    <td style="font-size: 12px;width: 70px;"><i>Occupation:</b></td>
                    <td style="font-size: 12px;width: 250px;"><b>$studentApplicationInfo->father_profession</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 90px;"><i>Mother's Name:</b></td>
                    <td style="font-size: 12px;width: 270px;"><b>$studentApplicationInfo->mother_name</b></td>
                    <td style="font-size: 12px;width: 70px;"><i>Mobile No:</b></td>
                    <td style="font-size: 12px;width: 250px;"><b>$studentApplicationInfo->mother_mobile</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 80px;"><i>Qualification:</b></td>
                    <td style="font-size: 12px;width: 280px;"><b>$studentApplicationInfo->mother_qualification</b></td>
                    <td style="font-size: 12px;width: 70px;"><i>Occupation:</b></td>
                    <td style="font-size: 12px;width: 250px;"><b>$studentApplicationInfo->mother_profession</b></td>
                </tr>
                <tr nobr="true">
                <td style="font-size: 12px;width: 150px;"><i>Monthly Income Of Family:</b></td>
                <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->monthly_income</b></td>
            </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 100px;"><i>Guardian's Name:</b></td>
                    <td style="font-size: 12px;width: 260px;"><b>$studentApplicationInfo->guardian_name</b></td>
                    <td style="font-size: 12px;width: 110px;"><i>Guardian's mobile:</b></td>
                    <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->guardian_mobile</b></td>
                </tr>
                <tr nobr="true">
                <td style="font-size: 12px;width: 115px;"><i>Guardian's Relation:</b></td>
                <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->guardian_relation</b></td>
            </tr>
            <tr nobr="true">
            <td style="font-size: 12px;width: 115px;"><i>Guardian's Address:</b></td>
            <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->guardian_address</b></td>
        </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 180px;"><i>Medium of Instruction in School:</b></td>
                    <td style="font-size: 12px;width: 180px;"><b>$studentSchoolInfo->medium_instruction</b></td>
                    <td style="font-size: 12px;width: 97px;"><i>Year of Passing:</b></td>
                    <td style="font-size: 12px;"><b>$studentSchoolInfo->year_of_passed</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 265px;"><i>Name and Address of the school Last Attended:</b></td>
                    <td style="font-size: 12px;width: 387px;"><b>$studentSchoolInfo->name_of_the_school</b></td>
                </tr>
                <tr nobr="true"><td style="font-size: 12px;width: 654px;"><b>$studentSchoolInfo->school_address</b></td>
                </tr>
                <tr nobr="true">
                <td style="font-size: 12px;width: 85px;"><i>Hostel Facility:</b></td>
                <td style="font-size: 12px;width: 120px;"><b>$studentApplicationInfo->hostel_facility</b></td>
                <td style="font-size: 12px;width: 70px;"><i>Bus Facility:</b></td>
                <td style="font-size: 12px;width: 50px;"><b>$studentApplicationInfo->bus_facility</b></td>
                <td style="font-size: 12px;width: 90px;"><i>Boarding Point:</b></td>
                <td style="font-size: 12px;width: 240px;"><b>$studentApplicationInfo->boarding_point</b></td>
            </tr>
            <tr nobr="true">
            <td style="width: 260px">
            <table cellpadding="1" cellspacing="3" border="0">
                <tr nobr="true">
                    <td style="font-size: 12px;">
                        <b>Permanent Address</b>
                    </td>
                </tr>
                <tr nobr="true" cellpaddimg="2">
                    <td style="border:1px solid black;font-size: 12px;height: 40px"><b>$studentApplicationInfo->permanent_address_line_1<br>$studentApplicationInfo->permanent_address_line_2<br>$studentApplicationInfo->permanent_address_district<br>$studentApplicationInfo->permanent_address_state - $studentApplicationInfo->permanent_address_pincode</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 1px;"></td>
                </tr>             
            </table>
        </td>
            </tr>
            </table>
        </td>
    </tr>
    
    <tr nobr="true">
    <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;" width="672">
        <tr nobr="true">
            <td style="width: 400px">
                <tr nobr="true">
                    <td style="font-size: 12px;width: 250px"><b>Marks Scored in Class X :</b></td>
                    <td style="font-size: 12px;"><b>$studentInfo->registration_number</b></td>
                </tr>
                <tr>
                    <td style="font-size: 2px;"></td>
                </tr>
                <table cellpadding="2" border-width="thin">
                <tr nobr="true">
                <td style="text-align: center;width: 220px;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>Subjects</b></td>
                <td style="text-align: center;width: 70px;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>Max Marks</b></td>
                <td style="text-align: center;width: 90px;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>Marks Scored</b></td>

            </tr>
                
                    $table
                    <tr nobr="true">
                        <td style="font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>TOTAL</b></td>
                        <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$total_max_mark</b></td>
                        <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$total_mark</b></td>

                    </tr>
                    <tr nobr="true">
                        <td style="font-size: 12px;width: 110px"><b>10th Percentage:</b></td>
                        <td style="font-size: 12px;width: 90px"><b>$total_percentage %</b></td>
                    </tr>

                    <tr nobr="true">
                    <td style="font-size: 12px;width: 100px">Board Name:</td>
                    <td style="font-size: 12px;width: 190px"><b>$boardInfo->board_name</b></td>
                </tr>

                <tr nobr="true">
                <td style="font-size: 12px;width: 170px">Month and Year of Passing:</td>
                <td style="font-size: 12px;width: 300px"><b>$studentSchoolInfo->month_of_passed , $studentSchoolInfo->year_of_passed</b></td>
            </tr>

            <tr nobr="true">
            <td style="font-size: 12px;width: 100px">No. of Attempts:</td>
            <td style="font-size: 12px;width: 400px"><b>$studentSchoolInfo->no_of_attempt</b></td>
            <td style="font-size: 12px;width: 160px;"><b>Principal's Signature</b></td>

        </tr>
                  
                </table>
            </td>
            <td style="width: 260px">
                <table cellpadding="1" cellspacing="3" border="0">
                    <tr nobr="true">
                        <td style="font-size: 1px;"></td>
                    </tr>
                    <tr nobr="true">
                        <td style="border:1px solid black;font-size: 12px;"><b>First Preference : $studentAdmissionInfo->stream_name</b><br/>
                            <b>Second Preference : $studentAdmissionInfo->second_stream_name</b>
                        </td>
                    </tr>
                    <tr nobr="true">
                    <td style="font-size: 1px;"></td>
                </tr>
                <tr nobr="true">
                    <td style="border:1px solid black;font-size: 12px;"><b>Register Number : $studentSchoolInfo->register_number </b>
                    </td>
                </tr>
               
                </table>
            </td>
        </tr>
    </td>
    </tr>
    </table>



    </br>
  
    



<br pagebreak="true" />

<table style="border: 1px solid black;" cellpadding="8" cellspacing="1">

    <tr nobr="true">
        <td class="box" width="672" style="text-align: center;">
            <b style="font-size: 18px">STUDENT/PARENT’S or GUARDIAN’S UNDERTAKING</b>
        </td>
    </tr>
    <tr>
        <td style="text-align: justify;font-size: 14px;"><span>I hereby declare that:</span><br/>
            <span> - I will not reclaim the fees and contribution paid by me to the college if I leave the college.</span><br/>
            <span> - If I do not maintain 75% of attendance in each subject at the end of the academic year as per the P.U.E</span><br/>
            <span>&nbsp;&nbsp;&nbsp;department regulation.</span><br/>
            <span> - If I do not get minimum pass marks in the examination conducted by the college as per the norms of the<br/></span>
            <span>&nbsp;&nbsp;&nbsp; college, and.</span><br/>
            <span> - If I do not keep up with ideas of the college and my conduct is not good.
            The Principal has the rights to <br/></span>
            <span>&nbsp;&nbsp;&nbsp;detain me from proceeding to the Annual Examination conducted by the P.U.E
            Department.</span><br/>
            <span>&nbsp;&nbsp;&nbsp;I promise to abide by the rules and regulations of the college.</span>
        </td>
    </tr>

    <tr>
        <td></td>
    </tr>
    <tr>
        <td><p style="font-size: 14px;"><i>Place: Kalaburagi</i></p>
            <p style="font-size: 14px;"><i>Date: $current_date</i> 
            <i>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Signature of the Applicant</i>  
            <i>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Signature of Parent / Guardian</i></p>
        </td>
    </tr>
</table>






 
 








                     
EOD;
//$pdf->writeHTML($set_html, true, false, true, false, '');
// small box
//$pdf->Cell(6, 6,'', 1, 0, 'R', 0, '', 0); 

$pdf->SetFont('helvetica', '', 18);
$pdf->writeHTML($set_html, true, false, false, false, '');

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
ob_flush();
$pdf->Output('Application.pdf', 'I');
ob_end_flush();
// end_ob_clean();

//============================================================+
// END OF FILE
//============================================================+

?>
