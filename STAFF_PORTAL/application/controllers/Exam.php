<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Exam extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->load->model('staff_model','staff');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('students_model','student');
        $this->load->model('subjects_model','subjects');
        $this->load->model('exam_model','exams');
        $this->load->library('excel');
        $this->isLoggedIn();
    }

    // internal exam marks
    public function addInternalMark() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {        
            $filter = array();
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
                $data['staff_id'] = $this->staff_id;
            }else{
                $data['staff_id'] = '';
            }
            $data['staffSubjectInfo'] = $this->staff->getAllSubjectInfo($filter);
            $data['streamInfo'] = $this->student->getAllStreamName(); 
            $data['exam_type'] = '';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Internal Marks';
            $this->loadViews("exam/addInternalMark", $this->global, $data , NULL);
        }
    }

    // get stream and section by term
    public function getStreamSectionByTerm(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $term_name = $this->input->post("term_name");
            $filter['term_name'] = $term_name;
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $data['result'] = $this->staff->getSectionById($filter);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    // get student details
    public function getStudentForInternalMark(){ 
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('term_name','Term','trim|required');
            $this->form_validation->set_rules('section_row_id','Stream','trim|required');
            $this->form_validation->set_rules('staff_subject_row_id','Subject','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->addInternalMark();
            }else{
                $filter= array();
                if($this->role == ROLE_TEACHING_STAFF){
                    $filter['staff_id'] = $this->staff_id;
                }
                $term_name = $this->input->post("term_name");
                $section_row_id = $this->input->post("section_row_id");
                $staff_subject_row_id = $this->input->post("staff_subject_row_id");
                $exam_type = $this->input->post("exam_type");
                $filter['section_row_id'] = $section_row_id;
                $filter['staff_subject_row_id'] = $staff_subject_row_id;
                $sectionInfo = $this->attendance->getSectionInfoByRowId($filter);
                $subjectInfo = $this->attendance->getSubjectByRowId($filter);
                $data['term_name'] = $term_name;
                $data['stream_name'] = $sectionInfo->stream_name;
                $data['sub_name'] = $subjectInfo->sub_name;
                $data['subject_row_id'] = $subjectInfo->row_id;
                $data['subject_code'] = $subjectInfo->subject_code;
                $data['staff_name'] = $subjectInfo->staff_name; 
                $data['exam_type'] = $exam_type;
                $data['section_name'] = $sectionInfo->section_name; 
                $data['section_row_id'] = $section_row_id;
                $data['staff_subject_row_id'] = $staff_subject_row_id;
                $data['subject'] = $subjectInfo; 

                $sectionName = $sectionInfo->section_name;
                if($sectionName == "ALL"){
                    $filter['section_name'] = '';
                }else{
                    $filter['section_name'] = $sectionName;
                }
                $filter['stream_name'] = $sectionInfo->stream_name;
                $filter['term_name'] = $term_name;
                $filter['subject_name'] = $subjectInfo->sub_name;

                $data['streamInfo'] = $this->student->getAllStreamName(); 
                $data['studentsInfo'] = $this->student->getStudentInfoForInternal($filter);
                $data['staffSubjectInfo'] = $this->staff->getAllSubjectInfo($filter);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Annual Exam Marks';
                $this->loadViews("exam/addInternalMark", $this->global, $data , NULL);
            }
        
        }  
    }

    //exam listing for hall ticket
    public function examListing(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $filter = array();
            $exam_date = $this->security->xss_clean($this->input->post('exam_date'));
            $by_class = $this->security->xss_clean($this->input->post('by_class'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $max_marks = $this->security->xss_clean($this->input->post('max_marks'));
            $min_marks = $this->security->xss_clean($this->input->post('min_marks'));
            $to_class = $this->security->xss_clean($this->input->post('to_class'));
            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
            $time = $this->security->xss_clean($this->input->post('time'));
            $exam_name = $this->security->xss_clean($this->input->post('exam_name'));
            $exam_type = $this->security->xss_clean($this->input->post('exam_type'));
            $max_marks = $this->security->xss_clean($this->input->post('max_marks'));
            $min_marks = $this->security->xss_clean($this->input->post('min_marks'));
            

    
            $data['max_marks'] = $max_marks;
            $data['min_marks'] = $min_marks;
            $data['by_class'] = $by_class;
            $data['by_stream'] = $by_stream;
            $data['to_class'] = $to_class;
            $data['subject_name'] = $subject_name;
            $data['exam_name'] = $exam_name;
            $data['exam_type'] = $exam_type;
            $data['time'] = $time;
    
            $filter['max_marks']= $max_marks;
            $filter['min_marks']= $min_marks;
            $filter['by_class'] = $by_class;
            $filter['by_stream'] = $by_stream;
            $filter['to_class'] = $to_class;
            $filter['subject_name'] = $subject_name;
            $filter['exam_name'] = $exam_name;
            $filter['exam_type'] = $exam_type;
            $filter['time'] = $time;
            
            if(!empty($exam_date)){
                $filter['exam_date'] = date('Y-m-d',strtotime($exam_date));
                $data['exam_date'] = date('d-m-Y',strtotime($exam_date));
            }else{
                $data['exam_date'] = '';
                $filter['exam_date'] = '';
            }

           if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
    
            $this->load->library('pagination');
            $count = $this->exams->getExamCount($filter);
            $returns = $this->paginationCompress("examListing/", $count, 100);
            $data['totalCount'] = $count;
            $data['examInfo'] = $this->exams->getExamInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subjects->getAllSubjectInfo($filter);
             $data['streamInfo'] = $this->student->getAllStreamName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Exam Details';
            $this->loadViews("exam/exam", $this->global, $data, null);
        }
    }

    public function addExam(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('exam_date','Exam Date','trim|required');
            $this->form_validation->set_rules('time','Time','trim|required');
            $this->form_validation->set_rules('exam_name','Exam Name','trim|required');
            $this->form_validation->set_rules('exam_type','Exam Type','trim|required');
            $this->form_validation->set_rules('subject_name','Subject','trim|required');
            $this->form_validation->set_rules('subject_name','Subject','trim|required');
           
            if($this->form_validation->run() == FALSE){
                $this->examListing();
            } else {
                $filter = array();
                $exam_date = $this->security->xss_clean($this->input->post('exam_date'));
                $class = $this->security->xss_clean($this->input->post('class'));
                $stream = $this->security->xss_clean($this->input->post('stream'));
                $max_marks = $this->security->xss_clean($this->input->post('max_marks'));
                $min_marks =$this->security->xss_clean($this->input->post('min_marks'));
                $exam_name = $this->security->xss_clean($this->input->post('exam_name'));
                $exam_type = $this->security->xss_clean($this->input->post('exam_type'));
                $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
                $time = $this->security->xss_clean($this->input->post('time'));

                for($i=0;$i<count($stream);$i++){
                    $examInfo= array(
                        'exam_date' => date('Y-m-d',strtotime($exam_date)),
                        'class' => $class,
                        'stream' => $stream[$i],
                        'time' => $time,
                        'exam_name' => $exam_name,
                        'exam_type' => $exam_type,
                        'subject_code' => $subject_name,
                        'exam_year' => CURRENT_YEAR,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'));
                    $return_id = $this->exams->addExam($examInfo);
                }
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'Exam Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to add Exam');
                }
                redirect('examListing');
            }
            
        }
    }

     //delete an exam info
     public function deleteExam(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $examInfo = array('is_deleted' => 1,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->exams->updateExam($row_id, $examInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    } 
    
    public function inactiveExam(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $examInfo = array('exam_status' => 1,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->exams->updateExam($row_id, $examInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    } 
    public function activeExam(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $examInfo = array('exam_status' => 0,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->exams->updateExam($row_id, $examInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }

    
    public function addStudentInternalMarkByStaff(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('term_name','Term','trim|required');
            $this->form_validation->set_rules('subject_id','Subject Name','trim|required');
           // $this->form_validation->set_rules('subject_id','Subject Name','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->addInternalMark();
            }else{
                $term_name = $this->input->post("term_name");
                $section_row_id = $this->input->post("section_row_id");
                $stream_name = $this->input->post("stream_name");
                $subject_id = $this->input->post("subject_id");
                $section_name = $this->input->post("section_name");
                $exam_type = $this->input->post("exam_type");
                $subject = $this->subjects->getAllSubjectByID($subject_id);
                $exam_year =EXAM_YEAR;
                $filter= array();
                if($this->role == ROLE_TEACHING_STAFF){
                    $filter['staff_id'] = $this->staff_id;
                }
               
                $staff_subject_row_id = $this->input->post("staff_subject_row_id");
                $filter['staff_subject_row_id'] = $staff_subject_row_id;
                $data['staff_subject_row_id'] = $staff_subject_row_id;
                $subjectInfo = $this->attendance->getSubjectByRowId($filter);
                $data['term_name'] = $term_name;
                $data['stream_name'] = $stream_name;
                $data['sub_name'] = $subjectInfo->sub_name;
                $data['subject_row_id'] = $subjectInfo->row_id;
                $data['subject_code'] = $subjectInfo->subject_code;
                $data['staff_name'] = $subjectInfo->staff_name; 
                $data['section_row_id'] = $section_row_id; 
                $data['exam_type'] = $exam_type;
                $data['section_name'] = $section_name; 
                $data['subject'] = $subjectInfo; 

                $filter['stream_name'] = $stream_name;
                $filter['term_name'] = $term_name;
                $filter['subject_name'] = $subjectInfo->sub_name;
                $sectionName = $section_name;
                if($sectionName == "ALL"){
                    $filter['section_name'] = '';
                }else{
                    $filter['section_name'] = $sectionName;
                }

                $data['studentsInfo'] = $this->student->getStudentInfoForInternal($filter);
               
                $return_id = 0;
                foreach($data['studentsInfo'] as $student){
                    $student_id = trim($student->student_id);
                    $theory_mark = $this->input->post("obt_theory_mark_".$student_id);
                    $lab_mark = $this->input->post("lab_obt_mark_".$student_id);
                   // $this->form_validation->set_rules("obt_theory_mark_".$student_id,'STUDENT Theory Mark','trim|required');
                    // if($this->form_validation->run() == FALSE) {
                    //     redirect('addInternalMark');
                    // }
                    $markInfo = array(
                        'student_id' => $student_id,
                        'staff_id' => $this->staff_id,
                        'subject_code' => $subject_id,
                        'obt_theory_mark' => $theory_mark,
                        'obt_lab_mark' => $lab_mark,
                        'exam_year' => $exam_year,
                        'exam_type' => $exam_type,
                        'staff_updated_status' => 1,
                        'office_validation_status' => 0,
                        'created_by' => $this->staff_id, 
                        'created_date_time' => date('Y-m-d H:i:s'));
                    $markInfoUpdate = array(
                        'subject_code' => $subject_id,
                        'staff_id' => $this->staff_id,
                        'student_id' => $student_id,
                        'obt_theory_mark' => $theory_mark,
                        'obt_lab_mark' => $lab_mark,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s'));
                    if($theory_mark!= ''){
                        $isExist = $this->exams->getInternalExamSubjectMarkByID($subject_id,$student_id,$exam_type,$exam_year);
                        if(empty($isExist)){
                            $return_id += $this->exams->addStudentInternalMark($markInfo);
                            $this->session->set_flashdata('success', 'Subject mark added Successfully');
                        }else{
                            //$return_id = 0;
                            $return_id += $this->exams->updateStudentInternalMark($subject_id,$student_id,$exam_type,$markInfoUpdate,$exam_year);
                            $this->session->set_flashdata('success', 'Subject Mark Updated');
                        }
                    }
                }
                if($return_id == 0){
                    $this->session->set_flashdata('error', 'Subject mark add Failed'); 
                }
                
                $data['streamInfo'] = $this->student->getAllStreamName(); 
                $data['staffSubjectInfo'] = $this->staff->getAllSubjectInfo($filter);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Annual Exam Marks';
                $this->loadViews("exam/addInternalMark", $this->global, $data , NULL);
            }
        }
    } 


    
function getInternalMarkSheet(){
    $j=1; 
    $term_name = $this->input->post("term_name");
    $section_name = $this->input->post("type");
    $exam_type = $this->input->post("exam_type");
    $report_type = $this->input->post("report_type");
    $stream_name_id = $this->input->post("stream_name_id");
    // $term_name = 'II PUC';
    // $first_cell = array("J", "K", "L","M");
    // // $middle_cell = array("M", "P", "S","V");
    // $last_cell = array("J", "K", "L","M");
    
    $first_cell = array("J", "M", "P","S");
    $middle_cell = array("K", "N", "Q","T");
    $last_cell = array("L", "O", "R","U");
    if($section_name == 'ALL'){
        $section = array(" ","A","B","C","D");
    }else{
        $section[0] = $section_name;
    }
    
    if($report_type == 'only_failed'){
        $reportType = 'Failed Students';
    }else{
        $reportType = 'Distinction Students';
    }
    if($exam_type == 'I_UNIT_TEST'){
        $examType = 'I UNIT TEST';
    }else if($exam_type == 'MID_TERM_EXAM'){
        $examType = 'MID TERM EXAM';
    }else{
        $examType = str_replace('_',' ',$exam_type);
    }



    if ($section_name === ' ') {
        $display_section = 'ALL';
    } else {
        $display_section = $section_name;
    }
    
    // if($stream == "ALL"){
    //     $streamInfo = array(
    //         'PCMB',
    //         'PCMC',
    //         'PCMS',
    //         'CEBA',
    //         'CSBA',
    //         'MEBA',
    //         'MSBA',
    //         'PEBA',
    //         'SEBA',
    //         'HEPS',
    //         'PCME');
    // }else{
    //     $streamInfo = array($stream);   
       
    // }
    
    // foreach($streamInfo as $stream){
        // $subjects = $this->getSubjectCodes($stream_name);
  //  }
    // if($stream == "ALL"){

    for($sheet = 0; $sheet < count($section);  $sheet++){
            
            $section_name = $section[$sheet];
        // foreach($streamInfo as $stream){
        //     $stream_name = $stream->stream_name;
          
        //  }
        $stream ="";
        $stream_info = $this->student->getStudentsStreamName($section_name,$term_name,$stream_name_id);

        $subjects = $this->getSubjectCodes($stream_name_id);
        
        $this->excel->setActiveSheetIndex($sheet);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($section_name);
        //set Title content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $this->excel->getActiveSheet()->setCellValue('A2', $term_name.' '.$examType." RESULT - 2023-24");
        $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
        $this->excel->getActiveSheet()->setCellValue('A4', "LT: Language Total | ST: Subjects Total | TM: Total Marks");
        $this->excel->getActiveSheet()->setCellValue('A5', $term_name." - ".$stream_name_id." - ".$display_section);

        //change the font size 
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
        $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('A1:A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('A1:Y1');
        $this->excel->getActiveSheet()->mergeCells('A2:Y2');
        $this->excel->getActiveSheet()->mergeCells('A3:Y3');
        $this->excel->getActiveSheet()->mergeCells('A4:Y4');
        $this->excel->getActiveSheet()->mergeCells('A5:Y5');
        $this->excel->getActiveSheet()->mergeCells('A6:A7');
        $this->excel->getActiveSheet()->mergeCells('C6:C7');
        $this->excel->getActiveSheet()->mergeCells('B6:B7');
        $this->excel->getActiveSheet()->mergeCells('D6:D7');
        $this->excel->getActiveSheet()->mergeCells('E6:E7');
        $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //settting border style 
        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $this->excel->getActiveSheet()->getStyle('A1:Y900')->applyFromArray($styleArray);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');

        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'Suvidya No.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'Student ID');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Section');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lang');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'Lng');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'Code');

        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z7', 'SAT Number');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(38);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G6', 'Language');
        // $this->excel->getActiveSheet()->mergeCells('G6:I6');


        $this->excel->getActiveSheet()->mergeCells('V6:V7');
        $this->excel->getActiveSheet()->mergeCells('W6:W7');
        $this->excel->getActiveSheet()->mergeCells('X6:X7');
        $this->excel->getActiveSheet()->mergeCells('Y6:Y7');

        $this->excel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'Marks');
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'IA');
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'Marks');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H6', 'English(02)');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'Marks');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'LT');

        $this->excel->setActiveSheetIndex($sheet)->setCellValue('V6', 'ST');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('W6', 'TM');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('X6', '%');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y6', 'Result');
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z6', 'Result');

        //$this->excel->getActiveSheet()->mergeCells('K2:M2');
        $excel_row = 7;
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
        // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(16);
        $this->excel->getActiveSheet()->getStyle('F1:F3')->getAlignment()->setWrapText(true); 
        $this->excel->getActiveSheet()->getStyle('A8:A999')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B8:B999')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D6:Y900')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G7:G999')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('H7:H999')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('I7:I999')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A6:Y7')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getStyle('J8:Y900')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('N8:Y999')->getFont()->setBold(true);
        $this->cellColor('A6:Y7', 'D5DBDB');
        //first subject heading
        for($i=0; $i<4; $i++){
            $subjectInfo = $this->subjects->getAllSubjectByID($subjects[$i]);
            if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                if($subjectInfo->lab_status == 'false'){
                    $calculate_mark = 40;
                }else{
                    $calculate_mark = 35;
                }
            }else if($exam_type == 'ANNUAL_EXAMINATION'){
                if($subjectInfo->subject_code == 12){
                    $calculate_mark = 100;
                } else if($subjectInfo->lab_status == 'true'){
                    $calculate_mark = 100;
                } else {
                    $calculate_mark = 100;
                } 
            }else if($exam_type == 'MID_TERM_EXAM' || $exam_type == 'I_PREPARATORY'){
                 if($subjectInfo->lab_status == 'true'){
                    $calculate_mark = 70;
                } else {
                    $calculate_mark = 80;
                } 
            // }else if($exam_type == 'I_PREPARATORY'){
            //    if($subjectInfo->lab_status == 'true' && $subjectInfo->subject_code != 12){
            //         $calculate_mark = 100;
            //     } else {
            //         $calculate_mark = 100;
            //     } 
            }else if($exam_type == 'II_ASSIGNMENT'){
                $calculate_mark = 10;

            }else{
            }
            $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
            $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
            $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(8);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].'6', $subjectInfo->sub_name.'('.$subjects[$i].')');
            $this->excel->getActiveSheet()->mergeCells($first_cell[$i].'6:'.$last_cell[$i].'6');
            $this->excel->getActiveSheet()->getStyle($first_cell[$i].'6:'.$last_cell[$i].'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_ASSIGNMENT' || $exam_type == 'II_UNIT_TEST'){
                $sub_lab_status = "false";
            }else{
                $sub_lab_status = $subjectInfo->lab_status;
            }
            // if($sub_lab_status == "true"){
            //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].'7', 'TH');
            //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].'7', 'PR');
            //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i].'7', 'MO');
            // }else{
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].'7', "Marks");
                $this->excel->getActiveSheet()->mergeCells($first_cell[$i].'7:'.$last_cell[$i].'7');
                $this->excel->getActiveSheet()->getStyle($first_cell[$i].'7:'.$last_cell[$i].'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(5);
            // } 
        }
        $data['studentsResult'] = $this->student->getInternalMarkStudentInfo($term_name,$stream_name_id,$section_name);
        $excel_row = 8;
        $j =1;
        foreach($data['studentsResult']  as $row)
        {
            if($report_type == 'only_failed'){
                $markList = array('AB','SAT','EXEM','MP');
                $std_mark = $min_marks;
            }else{
                $markList = '';
                $std_mark = '';
            }
            $first_language_code = '';
            $first_language_name = '';
            $total_marks_subjects = 0;
            $total_marks_all_subjects = 0;
            $total_percentage = 0;
            $total_theory_marks_subjects = 0;
            $total_marks_overall = 0;
            $fail_flag = false;
            $student_status = 0;
            $total_max_mark = 0;
           
            $exam_year = EXAM_YEAR;
            $data['studentsMarks'] = $this->exams->getFullMarksOfStudentInternal($row->student_id,$exam_type);
            
            // $student_status = $row->tc_given_status;
            if(!empty($data['studentsMarks']) && $student_status == 0){
                $first_language_total =0;      
                $second_lang_mark= 0;   
                $first_lang_mark_obtained = 0;   
                $second_lang_mark_obtained = 0;
                $theory_subject = 0;
                $first_lan_TH = 0;
                $first_lan_IA = 0;
                $subject_code_from_subjects = 0;
            foreach($data['studentsMarks']  as $mark){

                if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_UNIT_TEST'){
                    if($mark->lab_status == 'false'){
                        $calculate_mark = 40;
                        $min_marks = 14;
                    }else{
                        $calculate_mark = 35;
                        $min_marks = 12;
                    }
                }else if($exam_type == 'ANNUAL_EXAMINATION'){
                    if($mark->subject_code == 12){
                        $max_lab_mark = 20;
                        $min_marks = 24;
                        $calculate_mark = 100;
                    } else if($mark->lab_status == 'true'){
                        $max_lab_mark = 30;
                        $min_marks = 21;
                        $calculate_mark = 100;
                    } else {
                        $min_marks = 35;
                        $calculate_mark = 100;
                    } 
                }else if($exam_type == 'MID_TERM_EXAM' || $exam_type == 'I_PREPARATORY'){
                    if($mark->subject_code == 12){
                        $max_lab_mark = 20;
                        $min_marks = 24;
                        $calculate_mark = 100;
                    } else if($mark->lab_status == 'true'){
                        $max_lab_mark = 30;
                        $min_marks = 21;
                        $calculate_mark = 70;
                    } else {
                        $min_marks = 28;
                        $calculate_mark = 80;
                    } 
                // }else if($exam_type == 'I_PREPARATORY'){
                //    if($mark->lab_status == 'true' && $mark->subject_code != 12){
                //         $max_lab_mark = 30;
                //         $min_marks = 21;
                //         $calculate_mark = 100;
                //     } else {
                //         $min_marks = 35;
                //         $calculate_mark = 100;
                //     } 
                }else if($exam_type == 'II_ASSIGNMENT'){
                    $calculate_mark = 10;
                    $min_marks = 0;

                }else{
                    $min_marks = 35;
                }

                $subject_fail_count = array();
                $subject_true = false;
                $first_lang_fail_count= 0;
                if($mark->subject_code == '01'){
                    $first_language_code = $mark->subject_code;
                    $first_language_name = "KAN";
                    $first_lan_TH =  $mark->obt_theory_mark;
                    $first_lan_IA =  $mark->obt_lab_mark;
                    $first_language_total =  (float)$first_lan_TH + (float)$first_lan_IA;
                    if($first_language_total < $min_marks){
                        $this->cellColor('F'.$excel_row.':G'.$excel_row, 'FFEE58');
                        $fail_flag = true;
                        if($first_lan_TH != 'AB'){
                            $first_lang_fail_count++;
                        }
                    }
                }else if($mark->subject_code == '03'){
                    $first_language_code = $mark->subject_code;
                    $first_language_name = "HINDI";
                    $first_lan_TH =  $mark->obt_theory_mark;
                    $first_lan_IA =  $mark->obt_lab_mark;
                    $first_language_total =  (float)$first_lan_TH + (float)$first_lan_IA;
                    if($first_language_total < $min_marks){
                        $this->cellColor('F'.$excel_row.':G'.$excel_row, 'FFEE58');
                        $fail_flag = true;
                        if($first_lan_TH != 'AB'){
                            $first_lang_fail_count++;
                        }
                    }
                }else if($mark->subject_code == '12'){
                    $first_language_code = $mark->subject_code;
                    $first_language_name = "FRENCH";
                    $first_lan_TH =  $mark->obt_theory_mark;
                    $first_lan_IA =  $mark->obt_lab_mark;
                    $first_language_total =  (float)$first_lan_TH + (float)$first_lan_IA;
                    // $first_lang_mark_obtained = ($first_language_total * 100) / $calculate_mark;
                    if($first_lan_TH < 12){
                        $this->cellColor('F'.$excel_row.':G'.$excel_row, 'FFEE58');
                        $fail_flag = true;
                    } else if($first_language_total < $min_marks){
                        $this->cellColor('F'.$excel_row.':G'.$excel_row, 'FFEE58');
                        $fail_flag = true;
                        if($first_lan_TH != 'AB'){
                            $first_lang_fail_count++;
                        }
                    } 
                    // else if($first_language_total < 9 ){
                    //     $this->cellColor('F'.$excel_row.':G'.$excel_row, 'FFEE58');
                    //     $fail_flag = true;
                    // }
                
                }else if($mark->subject_code == '02'){
                    $second_lang_mark = $mark->obt_theory_mark;
                    $second_lang = (float)$second_lang_mark;
                    // $second_lang_mark_obtained = ($second_lang * 100) / $calculate_mark;
                    if($second_lang < $min_marks){
                        $this->cellColor('H'.$excel_row, 'FFEE58');
                        $fail_flag = true;
                        if($second_lang_mark != 'AB'){
                            $second_lang_fail_count++;
                        }
                    } 
                }else{
                $sub_theory_mark = 0;
                $sub_lab_mark = 0;
               
                for($i=0;$i<4;$i++){
                    if($mark->subject_code == $subjects[$i]){
                        $sub_theory_mark = (float)$mark->obt_theory_mark;
                        $sub_lab_mark = (float)$mark->obt_lab_mark;
                        $total_mark_obt = $sub_theory_mark + $sub_lab_mark;
                        $total_obt_subject = ($total_mark_obt * 100) / $calculate_mark;
                        if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_ASSIGNMENT' ||$exam_type == 'II_UNIT_TEST'){
                            $mark_lab_status = "false";
                        }else{
                            $mark_lab_status = $mark->lab_status;
                        }
                        // $theory_subject = ($sub_theory_mark * 100) / $calculate_mark;
                        // if($mark->lab_status == 'true'){
                        //     if($theory_subject < $min_marks){
                        //         $this->cellColor($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row, 'FFEE58');
                        //         $fail_flag = true; 
                        //     }else if(($sub_theory_mark + $sub_lab_mark) < $min_marks){
                        //         $this->cellColor($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row, 'FFEE58');
                        //         $fail_flag = true;
                        //     }
                        //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $theory_subject);
                        //     // $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].$excel_row, $mark->obt_lab_mark);
                        //     // $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i].$excel_row,  $sub_theory_mark + $sub_lab_mark );
                        // if($mark_lab_status == 'true'){
                        //     if($mark->obt_theory_mark == 'EXEM' || $mark->obt_theory_mark == 'AB' || $mark->obt_theory_mark == 'MP' || $mark->obt_theory_mark == 'SAT'){
                        //         $this->cellColor($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row, 'FFEE58');
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $mark->obt_theory_mark);
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].$excel_row, $mark->obt_lab_mark);
                        //         $fail_flag = true; 
                        //         if($mark->obt_theory_mark != ''){
                        //             $absent_theory_count[$subjects[$i]]++;
                        //         }
                        //     }else if($mark->obt_lab_mark == 'EXEM' || $mark->obt_lab_mark == 'AB' || $mark->obt_lab_mark == 'MP' || $mark->obt_lab_mark == 'SAT'){
                        //         $this->cellColor($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row, 'FFEE58');
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $mark->obt_theory_mark);
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].$excel_row, $mark->obt_lab_mark);
                        //         $fail_flag = true; 
                        //         if($mark->obt_lab_mark != ''){
                        //             $absent_lab_count[$subjects[$i]]++;
                        //         }
                        //     }else if($sub_theory_mark < $min_marks || $total_mark_obt < 35){
                        //         $this->cellColor($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row, 'FFEE58');
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $sub_theory_mark);
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].$excel_row, $sub_lab_mark);
                        //         $fail_flag = true; 
                        //         if($mark->obt_theory_mark != 'AB'){
                        //             $fail_count[$subjects[$i]]++;
                        //         }
                        //     }else{
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $sub_theory_mark);
                        //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].$excel_row, $sub_lab_mark);
                        //     }
                            
                        //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i].$excel_row,  $total_mark_obt);
                    
                        // }else{
                            if($mark->obt_theory_mark == 'EXEM' || $mark->obt_theory_mark == 'AB' || $mark->obt_theory_mark == 'MP' || $mark->obt_theory_mark == 'SAT'){
                                $fail_flag = true;
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $mark->obt_theory_mark);
                                $this->cellColor($first_cell[$i].$excel_row.':'.$first_cell[$i].$excel_row, 'FFEE58');
                                $this->excel->getActiveSheet()->mergeCells($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row);
                                $this->excel->getActiveSheet()->getStyle($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                if($mark->obt_theory_mark != ''){
                                    $absent_theory_count[$subjects[$i]]++;
                                }
                            }else{
                                // $sub_theory_mark = (int)$mark->obt_theory_mark;
                                if($total_mark_obt < $min_marks){
                                    $fail_flag = true;
                                    $this->cellColor($first_cell[$i].$excel_row.':'.$first_cell[$i].$excel_row, 'FFEE58');
                                    // $subject_fail_count[$subjects[$i]] += 1;
                                    if($mark->obt_theory_mark != 'AB'){
                                        $fail_count[$subjects[$i]]++;
                                    }
                                }
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $sub_theory_mark);
                                $this->excel->getActiveSheet()->mergeCells($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row);
                                $this->excel->getActiveSheet()->getStyle($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            
                            }
                        //}
                        $total_marks_subjects+=  $sub_theory_mark + $sub_lab_mark;
                        $total_theory_marks_subjects+=  $total_mark_obt;
                    }
                }
            }
            $total_max_mark +=  $calculate_mark;

            }

            // if($first_language_total >= 35 && (int)$second_lang_mark >= 35){
            //     if($total_marks_subjects >= 140){
            //         if($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30){
            //             $fail_flag = false;
            //         }else{
            //             $fail_flag = true;
            //         }
            //     }}
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j);
            //student info
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->student_id);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, strtoupper($row->student_name));
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->section_name);  
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $row->pu_board_number);   
            //$this->excel->setActiveSheetIndex($sheet)->setCellValue('AB'.$excel_row, $row->sat_number);
            //adding first Language
            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,  $first_language_name );
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,  $first_language_code );
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $first_lan_TH);
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,  $first_lan_IA);
            if($first_lan_TH == 'EXEM' || $first_lan_TH == 'AB' || $first_lan_TH == 'MP' || $first_lan_TH == 'SAT'){
                $fail_flag = true;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $first_lan_TH);
                $this->cellColor('G'.$excel_row, 'FFEE58');
                if($first_lan_TH != ''){
                    $first_lang_absent_count++;
                }
            }
            // }else{
            //     $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $first_language_total);
            // }
            //second Language
            $total_language_mark = $first_language_total+(int)$second_lang_mark;
            if($second_lang_mark == 'EXEM' || $second_lang_mark == 'AB' || $second_lang_mark == 'MP' || $second_lang_mark == 'SAT'){
                $fail_flag = true;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $second_lang_mark);
                $this->cellColor('H'.$excel_row, 'FFEE58');
                if($second_lang_mark != ''){
                    $second_lang_absent_count++;
                }
            }else{
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $second_lang);
            }
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $total_language_mark);
            
            $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total+(int)$second_lang;
            $total_marks_overall = $total_marks_subjects + (int)$first_language_total + (int)$second_lang;
            if($exam_type == 'I_UNIT_TEST'){
                if($stream_name_id == 'PCMB' || $stream_name_id == 'PCMC'){
                        $total_max_mark = 225;
                }else if($stream_name_id == 'HEPS' || $stream_name_id == 'HEPE'){
                        $total_max_mark = 240;
                    }else if($stream_name_id == 'EBAC'){
                        $total_max_mark = 235;
                }
            }
            if($exam_type == 'MID_TERM_EXAM'){
                if($stream_name_id == 'PCMB' || $stream_name_id == 'PCMC'){
                        $total_max_mark = 450;
                }else if($stream_name_id == 'HEPS' || $stream_name_id == 'HEPE'){
                        $total_max_mark = 480;
                    }else if($stream_name_id == 'EBAC'){
                        $total_max_mark = 470;
                }
            }
            // if($exam_type == 'II_UNIT_TEST'){
            //     $total_max_mark += 70;
            // }
            $total_percentage = ($total_marks_overall / $total_max_mark) * 100;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('V'.$excel_row, $total_theory_marks_subjects);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row, $total_marks_overall);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('X'.$excel_row, round($total_percentage,2));
            if($fail_flag == true){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y'.$excel_row, "FAIL");
            }else{
                $result = $this->calculateResult($total_marks_overall);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y'.$excel_row, "PASS");
            }
           
       

        if($report_type == 'only_failed'){
          
            if($fail_flag){
               $j++;
                $excel_row++;
            }
        }else{
            $j++;
            $excel_row++;
        }
        }
        

       
        } 
        
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'FAIL');
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $first_lang_fail_count);
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $second_lang_fail_count);
        // $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':AA'.$excel_row)->getFont()->setBold(true);
        
            // for($i=0;$i<4;$i++){
            //     $subjectInfo = $this->subjects->getAllSubjectByID($subjects[$i]);
            //     if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_ASSIGNMENT'){
            //         $sub_lab_status = "false";
            //     }else{
            //         $sub_lab_status = $subjectInfo->lab_status;
            //     }
            //     if($sub_lab_status == 'true'){
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i].$excel_row, $fail_count[$subjects[$i]]);
            //         // $this->excel->getActiveSheet()->mergeCells($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row);
            //         $this->excel->getActiveSheet()->getStyle($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //     }else{
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $fail_count[$subjects[$i]]);
            //         $this->excel->getActiveSheet()->mergeCells($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row);
            //         $this->excel->getActiveSheet()->getStyle($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //     }
            // }
            
           // $excel_row++;
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'ABSENT');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $first_lang_absent_count);
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $second_lang_absent_count);
            // $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':AA'.$excel_row)->getFont()->setBold(true);
            // log_message('debug','dcd'.print_r($absent_lab_count,true));
            
            // for($i=0;$i<4;$i++){
            //     $subjectInfo = $this->subjects->getAllSubjectByID($subjects[$i]);
            //     if($exam_type == 'I_UNIT_TEST' || $exam_type == 'II_ASSIGNMENT'){
            //         $sub_lab_status = "false";
            //     }else{
            //         $sub_lab_status = $subjectInfo->lab_status;
            //     }
            //     if($sub_lab_status == 'true'){
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $absent_theory_count[$subjects[$i]]);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i].$excel_row, $absent_lab_count[$subjects[$i]]);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i].$excel_row, $absent_theory_count[$subjects[$i]] + $absent_lab_count[$subjects[$i]]);
            //         // $this->excel->getActiveSheet()->mergeCells($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row);
            //         $this->excel->getActiveSheet()->getStyle($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //     }else{
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i].$excel_row, $absent_theory_count[$subjects[$i]]);
            //         $this->excel->getActiveSheet()->mergeCells($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row);
            //         $this->excel->getActiveSheet()->getStyle($first_cell[$i].$excel_row.':'.$last_cell[$i].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //     }
            // }
            
        $this->excel->createSheet(); 
        // $sheet++;
        // }
    }
   

        $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $response =  array(
            'op' => 'ok',
            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        );

        die(json_encode($response));
    }

    public function cellColor($cells,$color){
        return $this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }

    
    function calculateResult($total_marks){
        $percentage = floor(($total_marks / 600) * 100);
        if($percentage >= 85){
            return "Distinction";
        } else if($percentage >= 60 && $percentage <= 84){
            return "I Class";
        } else if($percentage >= 50 && $percentage <= 59){
            return "II Class";
        } else if($percentage >= 35 && $percentage <= 49){
            return "III Class";
        }
    }
        
    public function getSubjectCodes($stream_name){
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
}
?>