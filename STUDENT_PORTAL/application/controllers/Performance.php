<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';



class Performance extends BaseController

{

        /* This is default constructor of the class */

        public function __construct()

        {

                parent::__construct();

                $this->load->model('performance_model');

                $this->load->model('student_model');

                $this->isLoggedIn();   

        }



        /* This function used to load the first screen of the user */

        public function index()

        {

                $this->isLoggedIn();

        }

        

        public function examPerformance(){

                $subjects_code = array();

                $assignment_exam_marks = array();

                $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);

                

                // if($data['studentInfo']->term_name == 'I PUC'){

                    $exam_year = '2023-24';

                // }else{

                //     $exam_year = '2020';

                // }

                

                $elective_sub = strtoupper( $data['studentInfo']->elective_sub);

                if($elective_sub == "KANNADA"){

                array_push($subjects_code, '01');

                }else if($elective_sub == 'HINDI'){

                array_push($subjects_code, '03');

                } else if($elective_sub == 'FRENCH'){

                array_push($subjects_code, '12');

                }

                array_push($subjects_code, '02');

                $exam_mark_first_test = array();

                $exam_mark_mid_term = array();

                $exam_mark_second_test = array();

                $exam_mark_first_preparatory = array();

                $exam_mark_assignment_one = array();

                $exam_mark_assignment_two = array();

                $exam_mark_assignment = array();

                $subjects = $this->getSubjectCodes($data['studentInfo']->stream_name);

                $subjects_code = array_merge($subjects_code,$subjects);

                
                for($i=0;$i < count($subjects_code);$i++){

                        $getMarkOfFirstUnitTest = $this->performance_model->getFirstInternaltMark($this->student_id,$subjects_code[$i],$exam_year);

                        $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

                        $getSubjectName[$i] = $this->performance_model->getAllSubjectInfo($subjects_code[$i]);


                     

                        $getMarkOfMidTerm = $this->performance_model->getMidTermExamMark($this->student_id,$subjects_code[$i],$exam_year);

                        $exam_mark_mid_term[$i] = $getMarkOfMidTerm;


                        $getMarkOfSecondUnitTest = $this->performance_model->getSecondInternalMark($this->student_id,$subjects_code[$i],$exam_year);

                        $exam_mark_second_test[$i] = $getMarkOfSecondUnitTest;


                        $getMarkOfFirstPreparatory = $this->performance_model->getFirstPreparatoryMark($this->student_id,$subjects_code[$i],$exam_year);

                        $exam_mark_first_preparatory[$i] = $getMarkOfFirstPreparatory;

                       $exam_type = array('ASSIGNMENT_I','ASSIGNMENT_II');

                        $total_mark = 0;

                        for($j=0;$j<count($exam_type);$j++){

                                $getAssignmentMarks[$j] = $this->performance_model->getStudentAssignmentExamMarks($this->student_id,$subjects_code[$i],$exam_type[$j]);

                        }

                        $exam_mark_assignment[$i] = $getAssignmentMarks;

                        $exam_types = 'ASSIGNMENT_I';

                        $getAssignmentOneMarks = $this->performance_model->getStudentAssignmentExamMarks($this->student_id,$subjects_code[$i],$exam_types);

                        $exam_mark_assignment_one[$i] = $getAssignmentOneMarks;

                        $examType = 'ASSIGNMENT_II';

                        $getAssignmenttwowMarks = $this->performance_model->getStudentAssignmentExamMarks($this->student_id,$subjects_code[$i],$examType);

                        $exam_mark_assignment_two[$i] = $getAssignmenttwowMarks;

                        // }

                        // $exam_mark_assignment[$i] = $getAssignmentMarks;

                        // 'ASSIGNMENT_II'

                }



                $assignment_exam_marks = array_merge($exam_mark_assignment_one,$exam_mark_assignment_two);

                $total_assignment_mark = array();

                foreach($assignment_exam_marks as $assignmentMarks){

                        if(!empty($assignmentMarks->subject_code)){

                                // $total_assignment_mark[$assignmentMarks->subject_code] = 0;

                                $sub_marks = 0;

                                $mark_obt = 0;

                        
                                if($assignmentMarks->subject_code == 12){

                                        $labStatus = 'true';

                                }else{

                                        $labStatus = $assignmentMarks->lab_status;

                                }

                                if($assignmentMarks->exam_type == 'ASSIGNMENT_I' || $assignmentMarks->exam_type == 'ASSIGNMENT_II'){

                                        if($assignmentMarks->obt_theory_mark == 'AB' || $assignmentMarks->obt_theory_mark == 'EXEM' || $assignmentMarks->obt_theory_mark == 'MP' || $assignmentMarks->obt_theory_mark ==  'ASGN'){

                                                $mark_obt = 0;

                                        }else{

                                                $sub_marks = $this->getAssessmentMark($assignmentMarks->obt_theory_mark,$assignmentMarks->exam_type,$labStatus,$assignmentMarks->subject_code);

                                                $mark_obt = $sub_marks;

                                        }

                                }



                                $total_assignment_mark[$assignmentMarks->subject_code] += $mark_obt;

                        }

                        

                }
               
               
                $data['subjects_code'] = $subjects_code;


                
                $data['getSubjectName'] = $getSubjectName;

               

                $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;

                

                $data['midTermExamMarkInfo'] = $exam_mark_mid_term;

                $data['SecondUnitTestMarkInfo'] = $exam_mark_second_test;

                $data['firstPreparatoryMarkInfo'] = $exam_mark_first_preparatory;

                $data['assignmentOneExamMarks'] = $exam_mark_assignment_one;

                $data['assignmentTwoExamMarks'] = $exam_mark_assignment_two;

                // $data['subjectInfo'] = $subjectInfo;

                $data['assignmentExamMarks'] = $total_assignment_mark;

                $this->global['pageTitle'] = ''.TAB_TITLE.' : My Performance' ;

                $this->loadViews("student/performance", $this->global, $data, NULL);

        }




        public function examAnnualPerformance(){

                $subjects_code = array();

                $assignment_exam_marks = array();

                $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);

                $exam_year = '2023-24';         

                $elective_sub = strtoupper( $data['studentInfo']->elective_sub);

                if($elective_sub == "KANNADA"){

                array_push($subjects_code, '01');

                }else if($elective_sub == 'HINDI'){

                array_push($subjects_code, '03');

                } else if($elective_sub == 'FRENCH'){

                array_push($subjects_code, '12');

                }

                array_push($subjects_code, '02');

                $exam_mark_first_test = array();

                $subjects = $this->getSubjectCodes($data['studentInfo']->stream_name);

                $subjects_code = array_merge($subjects_code,$subjects);

                
                for($i=0;$i < count($subjects_code);$i++){

                        $getMarkOfFirstUnitTest = $this->performance_model->getAnnualExamMark($this->student_id,$subjects_code[$i],$exam_year);

                        $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

                        $getSubjectName[$i] = $this->performance_model->getAllSubjectInfo($subjects_code[$i]);                               
                }
         
                $data['subjects_code'] = $subjects_code;
               
                $data['getSubjectName'] = $getSubjectName;
            
                $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
               
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Annual Performance' ;

                $this->loadViews("student/annualPerformance", $this->global, $data, NULL);

        }



        public function viewAnnualExam(){

                $data['studentMarkInfo'] = $this->performance_model->getStudentFinalExamMarkInfo($this->student_id);

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Annual Exam Marks' ;

                $this->loadViews("student/annualExam", $this->global, $data, NULL);

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


        

   

        function getAssessmentMark($totalMark,$exam_type,$labStatus,$subject_code){

                if(is_numeric($totalMark) && !empty($totalMark)){

                        if($labStatus == 'false'){ 

                                if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){

                                if($totalMark >= 81 && $totalMark <= 100){

                                        return '30';

                                }else if($totalMark >= 71 && $totalMark <= 80){

                                        return '25';

                                }else if($totalMark >= 61 && $totalMark <= 70){

                                        return '20';

                                }else if($totalMark >= 51 && $totalMark <= 60){

                                        return '15';

                                }else if($totalMark >= 41 && $totalMark <= 50){

                                        return '10';

                                }else{

                                        return '5';

                                }

                                }

                        }else{

                                if($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12'){

                                        if($totalMark >= 26 && $totalMark <= 35){

                                                return '4';

                                        }else if($totalMark >= 36 && $totalMark <= 45){

                                                return '8';

                                        }else if($totalMark >= 46 && $totalMark <= 55){

                                                return '12';

                                        }else if($totalMark >= 56 && $totalMark <= 65){

                                                return '16';

                                        }else if($totalMark >= 66 && $totalMark <= 75){

                                                return '20';

                                        }else{

                                                return '25';

                                        }

                                        }else if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){

                                        if($totalMark >= 1 && $totalMark <= 28){

                                                return '4';

                                        }else if($totalMark >= 29 && $totalMark <= 35){

                                                return '8';

                                        }else if($totalMark >= 36 && $totalMark <= 42){

                                                return '12';

                                        }else if($totalMark >= 43 && $totalMark <= 49){

                                                return '16';

                                        }else if($totalMark >= 50 && $totalMark <= 56){

                                                return '19';

                                        }else{

                                                return '22';

                                        }

                                }

                        }

                }else{

                        return '';

                }

        }

        

}

?>