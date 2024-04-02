<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
ini_set('max_execution_time', 0);
class Students extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model','student');
        $this->load->model('settings_model','settings');
        $this->load->model('subjects_model','subject');
        $this->load->model('staff_model','staff');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('push_notification_model');
        $this->load->model('transport_model', 'transport');
        $this->load->model('fee_model', 'fee');
        $this->load->library('pagination');
        $this->load->library('excel');
        $this->isLoggedIn();   

          //load library
		$this->load->library('zend');
    }

    function studentDetails() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $by_elective = $this->security->xss_clean($this->input->post('by_elective'));
            $year = $this->input->post('admission_year');

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;
            $data['by_elective'] = $by_elective;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['by_elective'] = $by_elective;
            $filter['year'] = $year;

            if(!empty($by_dob)){
                $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
                $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            }else{
                $data['by_dob'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();

            // TEACHING STAFF
            $class_name = array();
            $section = array(); 
            $studentData = array(); 
            $student_row_id = array();
            $filter['class'] = '';
            $i = 0;
            if($this->role == ROLE_TEACHING_STAFF){
                $staffClassInfo = $this->staff->getSectionByStaffId($this->staff_id);
                foreach($staffClassInfo as $class){
                     if($class->section_name == 'ALL'){
                       $sectionName = '';
                       }else{
                       $sectionName = $class->section_name;  
                    }
          
                    $filter['by_term_T'] = $class->term_name;
            
                    $filter['by_stream_T'] = $class->stream_name;
                    
                $filter['by_Section_T'] = $sectionName;
                $studentInfo = $this->student->getAllstudentInfoRowId($filter);
                array_push($studentData,$studentInfo);
                    // array_push($class_name,trim($class->term_name));
                    // array_push($section,$sectionName);
                    // $i++;
                }
              
                 $studentData=array_merge(...$studentData);
                 $j=0;
                 foreach($studentData as $std){
                  $student_row_id[$j] = $std->row_id;
                  $j++;
                 }
                }else{
  
                }
               // ENDDD
            $count = $this->student->getAllstudentInfoCount($filter,$student_row_id);
            $returns = $this->paginationCompress("studentDetails/", $count, 100);
            $data['totalCount'] = $count;
            // log_message('debug','as'.print_r( $data['totalCount'],true));
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->student->getAllstudentInfo($filter,$student_row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
            $this->loadViews("students/students", $this->global,$data, NULL);

        }
    }

    public function get_students(){
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $data_array_new = [];
            $year = $this->input->post('admission_year');
            $studentInfo = $this->student->getAllstudentInfo($year);
            foreach($studentInfo as $student) {
                $editButton = "";
                $deleteButton = "";
                $checkbox = '<input type="checkbox" class="singleSelect" value="<?php echo .$student->student_id; ?>" />';
                    $studentViewMore = '<a class="btn btn-xs btn-primary" target="_blank"
                    href="'.base_url().'viewStudentInfoById/'.$student->row_id.'"
                    title="View More"><i class="fa fa-eye"></i></a>';
                
                
                if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR|| $this->role == ROLE_OFFICE){
                    $editButton = '<a class="btn btn-xs btn-info" target="_blank"
                    href="'.base_url().'editStudent/'.$student->row_id.'" title="Edit Student"><i
                        class="fas fa-pencil-alt"></i></a>';
                }
                        
                if($this->role == ROLE_PRIMARY_ADMINISTRATOR){
                    $deleteButton = '<a class="btn btn-xs btn-danger deleteStudent"
                    data-row_id="'.$student->application_no.'" href="#" title="Delete">
                    <i class="fas fa-trash"></i></a>';
                        
                }
                    $data_array_new[] = array(
                    $checkbox,
                    $student->student_id,
                    $student->application_no,
                    $student->student_name,
                    $student->term_name,
                    $student->stream_name,
                    $student->section_name,
                    $studentViewMore.' '.$editButton.' '.$deleteButton
                    );
                }
            $count = count($studentInfo);
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data_array_new
            );
            echo json_encode($result);
            exit();
        }
    } 

    public function viewStudentInfoById($row_id = null) {
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('studentDetails');
            }
            $filter = array();
            $exam_mark_first_test = array();
            $exam_mark_second_test = array();
            $exam_mark_first_term = array();
            $exam_mark_mid_term = array();
            $exam_mark_first_preparatory = array();
            $subject_attendance = array();
            $total_class_held = 0;
            $total_class_attended = 0;
            $total_attendance_percentage = 0;
            $student = $this->student->getStudentInfoById($row_id);
            $std_batch = $student->batch;
            $filter['doj'] = '';
            if(date('Y-m-d',strtotime($student->doj))){
                $filter['doj'] = date('Y-m-d',strtotime($student->doj));
            } else{
                $filter['doj'] = '';
            }
            $filter['stream_name'] = $student->stream_name;
            if($student->section_name != ''){
                $filter['section_name'] = $student->section_name;
            }else{
                $filter['section_name'] = 'ALL';
            }
            $filter['subject_type'] = 'THEORY';
            $filter['term_name'] = $student->term_name; 
            $subjects_code = array();
            $elective_sub = strtoupper($student->elective_sub);
            if($elective_sub == "KANNADA"){
                array_push($subjects_code, '01');
            }else if($elective_sub == 'HINDI'){
                array_push($subjects_code, '03');
            } else if($elective_sub == 'FRENCH'){
                array_push($subjects_code, '12');
            }else{
                array_push($subject_mark_chart,0);
                array_push($subject_names, 'EXM');
            }
            array_push($subjects_code, '02');
            $subjects = $this->getSubjectCodes($student->stream_name);
            $subjects_code = array_merge($subjects_code,$subjects);
            $total_class_held_per_std = 0;
            for($i=0;$i<count($subjects_code);$i++){
                $class_held[] = 0;
                $class_held_lab[]  = 0;
                $class_attended = 0;
                $absent_count[] = 0;
                $std_absent_count[] = 0;
                $absent_count_theory[] = 0;
                $absent_count_lab[] = 0;
                $absent_countLab[] = 0;
                $subInfo[$subjects_code[$i]] = $this->subject->getAllSubjectByID($subjects_code[$i]);

                    $type="THEORY";
                    $filter['std_batch'] = '';
                    $class_held[$subjects_code[$i]]+= $this->attendance->getClassInfoAttendanceReportStudent($subjects_code[$i],$filter,$type);
                    
                    $type="LAB";
                    $filter['std_batch'] = $std_batch;
                    $class_held_lab[$subjects_code[$i]]+= $this->attendance->getClassInfoAttendanceReportStudent($subjects_code[$i],$filter,$type);

                    // if($class_held_lab != 0){
                        $class_held[$subjects_code[$i]]+= ($class_held_lab[$subjects_code[$i]] * 2);
                    // }
                    // $data['classHeldDate'] = $this->attendance->getTotalClassHeldByStaff($subjects_code[$i],$filter,$type);
                    
                    // foreach($data['classHeldDate'] as $classdata){
                    $type="THEORY";
                    $absent_count_theory[$subjects_code[$i]] = $this->attendance->isStudentIsAbsentForClass($student->student_id,$subjects_code[$i],$filter,$type);
                    
                    // log_message('debug','absent_count_theory='.print_r($absent_count_theory,true));
                    $type="LAB";
                    $absent_count_lab[$subjects_code[$i]] = $this->attendance->isStudentIsAbsentForClass($student->student_id,$subjects_code[$i],$filter,$type);
                    $absent_countLab[$subjects_code[$i]] = $absent_count_lab[$subjects_code[$i]] * 2;

                    $std_absent_count[$subjects_code[$i]] = $absent_count_theory[$subjects_code[$i]] + $absent_countLab[$subjects_code[$i]];
                    //     if($absent_count_theory != NULL){
                    //         $absent_count += 1;
                    //     }
                    
                    // }
                
                    
                    //no change
                    // $total_class_held_per_std+= $class_held;
                    $absent_count[$subjects_code[$i]] = $class_held[$subjects_code[$i]] - $std_absent_count[$subjects_code[$i]];
                    $absentCount[$subjects_code[$i]]+= $std_absent_count[$subjects_code[$i]];
                    $total_attd_class_std = $absentCount[$subjects_code[$i]];
                    
                    // if($class_held != 0){
                    //     $avg = ($absent_count)/$class_held;
                    //     $percentage = round($avg*100, 2);
                    // }else{
                    //     $percentage = 0;
                    // }
                    // if(!empty($percentage_sort)){
                    //     if($percentage <= $percentage_sort){
                    //         $percentage_active = true;
                    //     }
                    // }




                $getMarkOfFirstUnitTest = $this->student->getFirstInternaltMark($student->student_id,$subjects_code[$i]);

                
                $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

                // $getMarkOfFirstTermExam = $this->student->getFirstTermMark($student->student_id,$subjects_code[$i]);
                // $exam_mark_first_term[$i] = $getMarkOfFirstTermExam;

                $getMarkOfmidTermExam = $this->student->getMidTermMark($student->student_id,$subjects_code[$i]); 
                $exam_mark_mid_term[$i] = $getMarkOfmidTermExam;
             
                $getMarkOfSecondUnitTest = $this->student->getSecondInternalMark($student->student_id,$subjects_code[$i]);
                $exam_mark_second_test[$i] = $getMarkOfSecondUnitTest;
                
                $getFirstPreparatoryMark = $this->student->getFirstPreparatoryMark($student->student_id,$subjects_code[$i]); 
                $exam_mark_first_preparatory[$i] = $getFirstPreparatoryMark;

                $subject_attendance[$subjects_code[$i]]['sub_name'] = $this->subject->getSubjectInfoById($subjects_code[$i]);
                $subject_attendance[$subjects_code[$i]]['class_held'] = $this->student->getClassHeldInfo($filter,$subjects_code[$i]);
                $class_absent = $this->student->getStudentAbsentInfo($student->student_id,$subjects_code[$i]);
                $subject_attendance[$subjects_code[$i]]['class_attended'] = $subject_attendance[$subjects_code[$i]]['class_held'] - $class_absent;
                if($subject_attendance[$subjects_code[$i]]['class_held'] == 0){
                    $subject_attendance[$subjects_code[$i]]['percentage'] = 0;
                }else{
                    $subject_attendance[$subjects_code[$i]]['percentage'] = ($subject_attendance[$subjects_code[$i]]['class_attended'] / $subject_attendance[$subjects_code[$i]]['class_held']) * 100;
                }
                $total_class_held += $subject_attendance[$subjects_code[$i]]['class_held'];
                $total_class_attended += $subject_attendance[$subjects_code[$i]]['class_attended'];
            }
            if($total_class_held == 0){
                $total_attendance_percentage = 0;
            }else{
                $total_attendance_percentage = ($total_class_attended/$total_class_held)*100;
            }
            $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
            // $data['firstTermMarkInfo'] = $exam_mark_first_term;
            $data['midTermMarkInfo'] = $exam_mark_mid_term;
             $data['secondUnitTestMarkInfo'] = $exam_mark_second_test;
        //  log_message('debug', 'sdfedf... to student id'.print_r($data['secondUnitTestMarkInfo'],true));
             $data['firstPreparatoryMarkInfo'] = $exam_mark_first_preparatory;
            $data['total_attendance_percentage'] = $total_attendance_percentage;
            $data['subject_attendance'] = $subject_attendance;
            $data['subject_code'] = $subjects_code;
            $data['studentInfo'] = $student;
            $data['remarkNameInfo'] = $this->settings->getRemarkNameInfo();
            $data['remarkInfo'] = $this->student->getRemarksData($row_id);
            // $data['studentFamilyInfo'] = $this->student->getStudentFamilyInfoById($row_id);
            // $data['studentImage'] = $this->student->getStudentImageById($row_id);
            $data['class_held'] = $class_held;
            $data['class_attended'] = $absent_count;
            $data['subjects'] = $subInfo;

            $date_to = $this->input->post('date_to');
            $date_from = $this->input->post('date_from');
           
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            if (empty($date_from))
            {
                $filter['date_from'] = date('Y-m-d', strtotime('2023-06-01'));
                $data['date_from'] = date('d-m-Y', strtotime('01-06-2023'));
            }else {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
                $data['date_from'] = date('d-m-Y', strtotime($date_from));
            }
            if (!empty($date_to)) {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to .' +1 day'));
                $data['date_to'] = date('d-m-Y', strtotime($date_to));
            }
            $data['notifications'] = $this->push_notification_model->getStudentIndividualNotificationsforView($filter,$row_id);
           
            $data['stdFeePaymentInfo'] = $this->fee->getFeePaidInfoForStudentView($row_id,CURRENT_YEAR);
            $feeInfo = $this->fee->getTotalFeeAmountForReport($student->term_name,$student->stream_name,CURRENT_YEAR);
            $data['total_fee'] = $feeInfo->total_fee;
            $data['bill_model'] = $this->fee;
            $data['active'] = '';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Student Details';
            $this->loadViews("students/viewStudent", $this->global, $data, null);
        }
    }

    public function editStudent($row_id = null) {
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('studentDetails');
            }
            $data['studentInfo'] = $this->student->getStudentsInfoById($row_id);
           
            $data['religionInfo'] = $this->settings->getAllReligionInfo();
            $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
            // $data['stateInfo'] = $this->student_model->getStateInfo();
            $data['casteInfo'] = $this->settings->getAllCasteInfo();
            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();
            // $data['motherTongueInfo'] = $this->student->getMotherTongueInfo();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['routeInfo'] = $this->transport->getTransportNameInfo();
           
            
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Student Details';
            $this->loadViews("students/editStudent", $this->global, $data, null);
        }
    }

    public function updateStudent(){
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('student_name','Student Name','trim|required');
            // $this->form_validation->set_rules('dob','DOB','trim|required');
            // $this->form_validation->set_rules('application_no','Application Number','trim|required');
            // $this->form_validation->set_rules('nationality','Nationality','trim|required');
            // $this->form_validation->set_rules('gender','Gender','trim|required');
            // $this->form_validation->set_rules('permanent_address','Permanent Address','trim|required');
            $row_id = $this->input->post('row_id');
            $application_no = $this->input->post('application_no');
            if($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Student Update failed');
                redirect('editStudent/'.$row_id);  
            } else {
                $image_path="";
                $config=['upload_path' => './upload/',
                'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                    $imgdata = file_get_contents($image_path);
                }
            
                $student_name = ucwords(strtolower($this->security->xss_clean($this->input->post('student_name'))));
                $gender = $this->security->xss_clean($this->input->post('gender'));
                $nationality = $this->security->xss_clean($this->input->post('nationality'));
                $religion = $this->security->xss_clean($this->input->post('religion'));
                $category = $this->security->xss_clean($this->input->post('category'));
                $mother_tongue = $this->security->xss_clean($this->input->post('mother_tongue'));
                $blood_group = $this->security->xss_clean($this->input->post('blood_group'));
                $present_address = $this->security->xss_clean($this->input->post('present_address'));
                $permanent_address = $this->security->xss_clean($this->input->post('permanent_address'));
                $caste = $this->security->xss_clean($this->input->post('caste'));
                $is_handicapped = $this->security->xss_clean($this->input->post('is_handicapped'));
                $is_dyslexic = $this->security->xss_clean($this->input->post('is_dyslexic'));
                $dob = $this->security->xss_clean($this->input->post('dob'));
                $sub_caste = $this->security->xss_clean($this->input->post('sub_caste'));
                $route = $this->input->post('route');

                
                $father_name = $this->security->xss_clean($this->input->post('father_name'));
                $father_educational_qualification = $this->security->xss_clean($this->input->post('father_educational_qualification'));
                $father_profession = $this->security->xss_clean($this->input->post('father_profession'));
                $father_annual_income = $this->security->xss_clean($this->input->post('father_annual_income'));
                $father_mobile = $this->security->xss_clean($this->input->post('father_mobile'));
                $father_email = $this->security->xss_clean($this->input->post('father_email'));

                
                $mother_name = $this->security->xss_clean($this->input->post('mother_name'));
                $mother_educational_qualification = $this->security->xss_clean($this->input->post('mother_educational_qualification'));
                $mother_profession = $this->security->xss_clean($this->input->post('mother_profession'));
                $mother_annual_income = $this->security->xss_clean($this->input->post('mother_annual_income'));
                $mother_mobile = $this->security->xss_clean($this->input->post('mother_mobile'));
                $mother_email = $this->security->xss_clean($this->input->post('mother_email'));
                $primary_mobile = $this->security->xss_clean($this->input->post('primary_mobile'));
                
                if(!empty($dob)) {
                    $dob = date('Y-m-d',strtotime($dob));
                } else {
                    $dob = "";
                }
                if(!empty($image_path)){
                    $studentInfo['photo_url'] = $image_path;

                }
               
                $studentInfo = array(
                    'student_name' => $student_name,
                    'dob' => $dob,
                    'gender' => $gender,
                    'nationality' => $nationality,
                    'religion' => $religion, 
                    'category' => $category,
                    'caste' => $caste,
                    'mother_tongue' => $mother_tongue, 
                    'sub_caste' => $sub_caste, 
                    'blood_group'=> $blood_group,
                    'present_address'=> $present_address,
                    'residential_address' => $permanent_address,
                    'Is_physically_challenged' => $is_handicapped,
                    'is_dyslexic' => $is_dyslexic,
                    'father_name' => $father_name,
                    'father_educational_qualification'=> $father_educational_qualification,
                    'father_profession'=> $father_profession,
                    'father_annual_income' => $father_annual_income,
                    'father_mobile' => $father_mobile,
                    'father_email' => $father_email,
                    'mother_name' => $mother_name,
                    'mother_educational_qualification'=> $mother_educational_qualification,
                    'mother_profession'=> $mother_profession,
                    'mother_annual_income' => $mother_annual_income,
                    'mother_mobile' => $mother_mobile,
                    'mother_email' => $mother_email,
                    'primary_mobile' => $primary_mobile,
                    'route_id' => $route,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'),
                    'photo_url' => $image_path
                );

                    
                     
                $result = $this->student->updateStudentInfo($studentInfo,$row_id);

                // if(!empty($imgdata)){
                //     $studentImage = array(
                //         'document' => $imgdata,
                //         'name' => 'Photo',
                //         'is_photo' => 1,
                //         'modified_by'=>$this->staff_id, 'last_modified_date'=>date('Y-m-d H:i:s'));
                //     $result1 = $this->student->updateStudentImage($studentImage,$application_no);

                // }
                

                if($result > 0) {
                    $this->session->set_flashdata('success', 'Student Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Student Update failed');
                }
                redirect('editStudent/'.$row_id);  
            }
        }
    }

    public function updateStudentAcademicInfo(){
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $application_no = $this->input->post('application_no');
            $this->form_validation->set_rules('term_name','Term','trim|required');
            $this->form_validation->set_rules('elective_sub', 'Elective Subject', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editStudent/'.$row_id);  
            } else {
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $elective_sub = strtoupper($this->security->xss_clean($this->input->post('elective_sub')));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $register_no = $this->security->xss_clean($this->input->post('register_no'));
                $hall_ticket_no = $this->security->xss_clean($this->input->post('hall_ticket_no'));
                $date_of_admission = $this->security->xss_clean($this->input->post('date_of_admission'));
                $doj = $this->security->xss_clean($this->input->post('doj'));
                $sat_number = $this->security->xss_clean($this->input->post('sat_number'));
                $admission_number = $this->security->xss_clean($this->input->post('admission_number'));
                
                if(!empty($date_of_admission)) {
                    $date_of_admission = date('Y-m-d',strtotime($date_of_admission));
                } else {
                    $date_of_admission = "";
                }

                if(!empty($doj)) {
                    $doj = date('Y-m-d',strtotime($doj));
                } else {
                    $doj = "";
                }

                
                $studentAcademicInfo = array(
                    'elective_sub' => $elective_sub,
                    'section_name' => $section_name,
                    'pu_board_number' => $register_no,
                    'term_name' => $term_name,
                    'stream_name' => $stream_name,
                    'hall_ticket_no' => $hall_ticket_no,
                    'date_of_admission' => $date_of_admission,
                    'doj' => $doj,
                    'sat_number' => $sat_number,
                    'admission_number' => $admission_number,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->student->updateStudentInfo($studentAcademicInfo,$row_id);
                

                if($result > 0) {
                    $this->session->set_flashdata('success', 'Student Academic Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Student Update failed');
                }
                redirect('editStudent/'.$row_id);  
            }
        }
    }

    public function deleteStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $studentInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->student->updateStudentInfo($studentInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
                $studentAcademicInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
                $result = $this->student->updateStudentAcademicInfo($studentAcademicInfo, $row_id);
            } else {echo (json_encode(array('status' => false)));}
        } 
    }

      //student Promotion
    public function promoteStudent(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $filter = array();
            $students = json_decode(stripslashes($this->input->post('student_id')));
       
            foreach($students as $student_id){  
                $data_students = $this->student->getStudentById($student_id);
                $studentId = $data_students->row_id;
                $studentInfo = array(
                    'intake_year_id' => '2021',
                    'term_name' => 'II PUC',
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));
              
                $result = $this->student->updateStudentInfo($studentInfo,$studentId);
            }
            if ($result > 0) {
                $this->session->set_flashdata('success', 'Student Promoted successfully');
            } else {
                $this->session->set_flashdata('error', 'Promotion failed');
            }
            redirect('studentDetails');
        }
    }

    
    function studentAlumniInfo() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $year = $this->input->post('admission_year');

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['year'] = $year;

            if(!empty($by_dob)){
                $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
                $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            }else{
                $data['by_dob'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->student->getAlumniStudentCount($filter);
            $returns = $this->paginationCompress("studentAlumniInfo/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->student->getAlumniStudentInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Alumni Student';
            $this->loadViews("students/studentAlumni", $this->global,$data, NULL);

        }
    }

    //getting single student info for tc
    public function getStudentById() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{        
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $studentInfo = $this->student->getStudentById($student_id);
            echo json_encode($studentInfo);
            exit(0);
        }
    }

    //add tc information from office staff
    public function addNewTcInfo(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('leaving_date','Leaving Date','trim|required');
            $this->form_validation->set_rules('qualified_status','Qualified Status','trim|required');
            // $this->form_validation->set_rules('reason_unqualified','Reason Unqualified','trim|required');
            $this->form_validation->set_rules('belong_sc_st','Belong SC or ST','trim|required');
            // $this->form_validation->set_rules('college_due_status','College Due Status','required');
            $this->form_validation->set_rules('character','Character and Conduct','trim|required'); 
        }
        // if($this->form_validation->run() == FALSE) {
        //     $this->getAllstudents();
        // } else {
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $leaving_date = $this->security->xss_clean($this->input->post('leaving_date'));
            $qualified_status = $this->security->xss_clean($this->input->post('qualified_status'));
            $reason_unqualified = $this->security->xss_clean($this->input->post('reason_unqualified'));
            $belong_sc_st = $this->security->xss_clean($this->input->post('belong_sc_st'));
            $admission_date = $this->security->xss_clean($this->input->post('admission_date'));
            // $admission_number = $this->security->xss_clean($this->input->post('admission_number'));
            $last_class = $this->security->xss_clean($this->input->post('last_class'));
            $fee_due = $this->security->xss_clean($this->input->post('fee_due'));

            $caste = $this->security->xss_clean($this->input->post('caste'));
             $college_due_status = "YES";
            $character = $this->security->xss_clean($this->input->post('character'));
            $leaving_date = date("Y-m-d", strtotime($leaving_date));
            // $appliedYear =  date('Y');
            $appliedYear =  2023;
            $admissionDate = date("Y-m-d", strtotime($admission_date));

            $isExists = $this->student->checkTCNumberExists($student_id,$appliedYear);
            if($isExists == 0){ 
                $appliedID = $this->student->getStudentTCAppliedLastRowId($appliedYear);
                if(empty($appliedID)){
                    $tc_id = 0;
                    $tcNumber = sprintf("%04d", ++$tc_id);
                    $tc_number = 'STXPUC/'.$appliedYear.'/'.$tcNumber;
                }else{
                    $tc_id = array_pop(explode('/', $appliedID->tc_number));
                    $tcNumber = sprintf("%04d", ++$tc_id);
                    $tc_number = 'STXPUC/'.$appliedYear.'/'.$tcNumber;
                }
            }else{
                $tc_number = $isExists->tc_number;
            }
            $status = $this->student->checkStudentTCAppliedStatus($student_id);
            $tcInfo = array('student_id'=> $student_id,
                'leaving_date'=>$leaving_date,
                'last_class'=>$last_class,

                'date_of_admission'=>$admissionDate,
              
                'is_promoted'=>$qualified_status,
                'is_belongs_sc_st'=>$belong_sc_st,
                'is_cleared_college_due'=>$college_due_status,
                'fee_due'=>$fee_due,
                
                'character_conduct'=>$character,
                'tc_number'=>$tc_number,
                'applied_year'=>$appliedYear,
                'created_by'=>$this->staff_id,
                'updated_by'=>$this->staff_id,
                'reason_unqualified'=>$reason_unqualified,
                'updated_date_time'=>date('Y-m-d H:i:s'),
                'created_date_time'=>date('Y-m-d H:i:s'));
//log_message('debug','admissin'.print_r($tcInfo,true));
        
            $studentInfo = array('student_id'=> $student_id,
                'date_of_admission'=>$admissionDate,
                //  'admission_number'=>$admission_number,
               
                'caste'=>$caste,
                'tc_taken_status'=> 1,
                'is_active'=> 0,
                'updated_date_time'=>date('Y-m-d H:i:s'),
                'created_date_time'=>date('Y-m-d H:i:s'));
log_message('debug','admissin_student'.print_r($tcInfo,true));
            if($status == 1){
                $result = $this->student->updateTcInfo($tcInfo, $student_id);
                $result_one = $this->student->updateStudentTcStatusInfo($studentInfo, $student_id);
                if($result == TRUE){
                    echo 'Successfully Updated student TC Information';
                }else{
                    echo 'Update Failed';
                }
            }else{
                $result = $this->student->addStudentTcInfo($tcInfo);
                $result_one = $this->student->updateStudentTcStatusInfo($studentInfo, $student_id);
                if($result > 0) {
                    echo 'Successfully Added student TC Information';
                } else {
                    echo 'Failed to add TC info';
                } 
            }
        // }
    }
    public function getStudentTcInfo(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{        
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $studentTcInfo = $this->student->getStudentTcInfoById($student_id);
            echo json_encode($studentTcInfo);
            exit(0);
        }
    }

    //student applied tc list  
    function getStudentAppliedForTc() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $register_no = $this->security->xss_clean($this->input->post('register_no'));
            $tc_number = $this->security->xss_clean($this->input->post('tc_number'));
            $year = $this->input->post('admission_year');
            $by_date = $this->security->xss_clean($this->input->post('by_date'));

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['student_name'] = $student_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['section_name'] = $section_name;
            $data['register_no'] = $register_no;
            $data['tc_number'] = $tc_number;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['student_name'] = $student_name;
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $stream_name;
            $filter['section_name'] = $section_name;
            $filter['register_no'] = $register_no;
            $filter['tc_number'] = $tc_number;
            // $filter['year'] = $year;

            //   if(!empty($year)){
            //     $filter['year'] = $year;
               
            // }else{
            //      $data['year'] = CURRENT_YEAR;
            //      $filter['year'] = CURRENT_YEAR;
            // }

            if(empty($year)) {
                $filter['year'] = CURRENT_YEAR;
                 $data['year'] = CURRENT_YEAR;
            }else {
                $filter['year']  = $year;
                 $data['year'] = $year;

            }

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->student->getStudentsDetailsForTcCount($filter);
            $returns = $this->paginationCompress("getStudentAppliedForTc/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentTcInfo'] = $this->student->getStudentsDetailsForTC($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
            $this->loadViews("students/viewAppliedStudentTC", $this->global,$data, NULL);

        }
    }

    // get student info for TC Print
    public function getStudentsTcInfoById(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{     
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $data['studentInfo'] = $this->student->getStudentsTcInfoById($student_id); 
            
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Transfer Certificate'; 
            $this->loadViews("students/viewStudentTC", $this->global,$data, NULL);
            // $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'helvetica','default_font_size' => 14, 'format' => 'A4-P','mode' => '4,4,4,4,9,9']);
            // $mpdf->SetTitle('Transfer certificate');
            // $html = $this->load->view('students/viewStudentTC',$data,true);
            // $mpdf->AddPage('P','','','','',8,8,6,6,8,8);
            // $mpdf->WriteHTML($html);
            // $mpdf->Output('Tranfer_Certificate.pdf', 'I');
        }
    } 

    // study certificate
    public function generateStudyCertificate($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            error_reporting(0);
            $filter = array();
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                $filter['student_id'] = $student_id;
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
          
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Study Certificate';
            $data['studentInfo'] = $this->student->getInfoForStudyCertificate($student_id);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A5-L']);
           
            $mpdf->AddPage('L','','','','',8,8,8,8,8,8);
            $mpdf->SetTitle('Study Certificate');
            $html = $this->load->view('students/studyCertificate',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Study_Certificate.pdf', 'I');
        }
    }

    public function checkCertificateName(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{        
            $student_id = json_decode(stripslashes($this->input->post('student_id')));
            $data['certificateName'] = $this->student->getInfoForCertificate($student_id);
            header('Content-type: text/plain'); 
            // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    // conduct certificate
    public function generateConductCertificate($student_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
           
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
            }
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            // log_message('debug', 'sdfedf... to student id'.print_r($data['studentsRecords'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Conduct Certificate';
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A5-L']);
           
            $mpdf->AddPage('L','','','','',8,8,8,8,8,8);
            $mpdf->SetTitle('Conduct Certificate');
            $html = $this->load->view('students/generateConductCertificate',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Conduct_Certificate.pdf', 'I');
            $this->loadViews("students/generateConductCertificate", $this->global, $data, null);
        }
    }

    // mark card assignment
    public function getMarkCardToPrint($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',10,10,12,12,15,15);
            $mpdf->SetTitle('Mark Card');
            $html = $this->load->view('students/generateMarkCard',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Mark_Card.pdf', 'I');
        }
    }

    // UNIT TEST EXAM REPORT CARD
    public function generateUnitTestExamReportCard($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            // $exam_year = $this->input->get("exam_year");
                $exam_type = $this->input->get("exam_type");
                $data['exam_type'] = $exam_type;
            }
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card';
            $this->loadViews("students/generateUnitTestMarkCard", $this->global, $data, null);

        }
    }



        // MID TERM REPORT CARD
        public function generateMidTermExamReportCard($student_id = null){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                // $exam_year = $this->input->get("exam_year");
                    $exam_type = $this->input->get("exam_type");
                    $data['exam_type'] = $exam_type;
                }
                $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card';
                $this->loadViews("students/generateMidTermMarkCard", $this->global, $data, null);
    
            }
        }
        public function generatePreparatoryExamReportCard($student_id = null){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                // $exam_year = $this->input->get("exam_year");
                    $exam_type = $this->input->get("exam_type");
                    $data['exam_type'] = $exam_type;
                }
                $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card';
                $this->loadViews("students/generatePreparatoryMarkCard", $this->global, $data, null);
    
            }
        }


        // mark card assignment annual depromoted 
    public function getAnnualMarkCardToPrint($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',10,10,12,12,15,15);
            $mpdf->SetTitle('DETAINED MARKS CARD');
            $html = $this->load->view('examReport22/generateAnnualMarkCardDetained',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('DETAINED_MARKS_CARD.pdf', 'I');
        }
    }

        // mark card assignment annual depromoted 
    public function getAnnualMarkCardToPrint2022($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',6,6,6,8,15,15);
            $mpdf->SetTitle('ANNUAL MARKS CARD');
            $html = $this->load->view('examReport22/generateAnnualMarkCard',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('ANNUAL_MARKS_CARD.pdf', 'I');
        }
    }

    
    // update student batch
    public function updateStudentBatch(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $student_id = json_decode(stripslashes($this->input->post('student_id')));
            $class_batch = $this->security->xss_clean($this->input->post('class_batch'));
            
            foreach($student_id as $std_id){           
                $std_info = array(
                    'batch'=> $class_batch,
                    'updated_by' => $this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'),
                );
                $return_id = $this->student->updateStudentInfoBStdId($std_info,$std_id);
            }

            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($return_id);
            exit(0); 
        }
    }
    
    public function downloadStudentExcelReport(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
            setcookie('isDownLoaded',1);  
        }else{
            $filter = array();
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $term = $this->security->xss_clean($this->input->post('term'));
            $academic_year = $this->security->xss_clean($this->input->post('academic_year'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $fields = $this->security->xss_clean($this->input->post('fields'));
            // log_message('debug','test=='.print_r($preference,true));

            if(!empty($term)){
                $filter['term'] = $term;
                $data['term'] = $term;
            }
            
            if($section_name == 'ALL'){
                $filter['section_name'] = '';
            }else{
                $filter['section_name'] = $section_name;
            }

            $date = date('Y');
            if($preference == 'ALL'){
                $preferences = array(
                    'PCMB',
                    'PCMC',
                    'PCME',
                    'PCMS',
                    'PEBA',
                    'CSBA',
                    'CEBA',
                    'MEBA',
                    'MSBA',
                    'SEBA',
                    'HEPS');
                   
            }else{
                $preferences = array($preference);   
               
            }
            // if($academic_year == 'ALL'){
            //     $academicYear = array(
            //         '2019-2020',
            //         '2020-2021',
            //         '2021-2022');
            //         $filter['academic_year'] = $academicYear;
                   
            // }else{
            //     $academicYear = array($academic_year);   
            //     $filter['academic_year'] = $academicYear;
               
            // }
            $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            $total_fields = count($fields);
            
            $curr_year = date('Y');
            
            for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2',$term.' '.$preferences[$sheet].' INFORMATION '.$curr_year);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:'.$cellName[$total_fields].'1');
            $this->excel->getActiveSheet()->mergeCells('A2:'.$cellName[$total_fields].'2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:'.$cellName[$total_fields].'2')->getFont()->setBold(true);
        
        
            
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);

            $excel_row=3;
            $cell = 1;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL No.');
        
            for($h=1;$h<=$total_fields;$h++){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$h].$excel_row, $fields[$h-1]);   
            }
            $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:'.$cellName[$total_fields].$total_fields)->applyFromArray($styleBorderArray);

            // $filter[$sheet] = $sheet;
            $filter['preference'] = $preferences[$sheet];
          
            $students = $this->student->getStudentInfoForReportDownload($filter);
            //log_message('debug','test=='.print_r($students,true));
            $j=1;
            $excel_row = 4;
            
            foreach($students as $student){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                
                for($c=1;$c<=$total_fields;$c++){
                    // log_message('error', 'JSON=   ' .$student[$fields[$c-1]]);
                    if($fields[$c-1] == 'dob'){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c].$excel_row,date("d-m-Y", strtotime($student->dob)));
                    }else if($fields[$c-1] == 'doj'){
                        if($student->doj != '1970-01-01' && $student->doj != '0000-00-00' && $student->doj != ''){
                            $doj = date("d-m-Y", strtotime($student->doj));
                        }else{
                            $doj = '';
                        }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c].$excel_row,$doj);
                    }else{
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c].$excel_row,$student->{$fields[$c-1]});
                    } 
                }
            

                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':'.$cellName[$total_fields].$excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':'.$cellName[$total_fields].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet(); 
        }
            $filename =  $term.'_Report_'.$preference.'-'.$date.'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
                        
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownLoaded',1);  
            $objWriter->save("php://output");
        
        }
    }   

    // get student quick info

    public function getAllCurrentStudents(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            // log_message('debug','dne=='.print_r($data['studentInfo'],true));
            header('Content-type: text/plain'); 
            // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    // Student hall ticket - first puc
    public function getFirstYearStudentHallTicket($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $filter = array();
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                $filter['student_id'] = $student_id;
            }
            $students = $this->student->getStdInfoByStudentId($filter);
            $data['examData'] = $this->student;
            // $students= $this->student->getStudentsInfoForPrintMarkCard($student_id,'I_PUC');
            // $studentExamInfo = array();

            // foreach($students as $std){
            //     $subjects_code = array();
            //     $elective_sub = strtoupper($std->elective_sub); 
            //     if($elective_sub == "KANNADA"){
            //         array_push($subjects_code, '01');
            //     }else if($elective_sub == 'HINDI'){
            //         array_push($subjects_code, '03');
            //     } else if($elective_sub == 'FRENCH'){
            //         array_push($subjects_code, '12');
            //     }
            //     array_push($subjects_code, '02');
                
            //     $subjects = $this->getSubjectCodes($std->stream_name);
            //     $subjects_code = array_merge($subjects_code,$subjects);
            //     $examInfo = $this->student->getSubjectsForHallTicketPrintFirstYear($subjects_code);
            //     $studentExamInfo[$std->student_id] = $examInfo;
            //     $stdImageInfo[$std->student_id] = $this->student->getFirstYearProfileImage($std->application_no);
            // }     

            $data['studentsRecords'] = $students;
            // $data['studentExamInfo'] = $studentExamInfo;
            // $data['stdImageInfo'] = $stdImageInfo;
            $this->global['pageTitle'] = 'SchoolPhins-STXPUC : Hall Ticket';
            $this->loadViews("office/firstYearHallTicket", $this->global, $data, null);
        }
    }

    // Student hall ticket - second puc
    public function getSecondYearStudentHallTicket(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $students= $this->student->getStudentsInfoForPrintMarkCard($student_id,'II_PUC');
            // $students= $this->students_model->getSecondYearStudentInfoByStudentIdBioData($student_id);

            $subjects = $this->getSubjectCodes($students[0]->stream_name);
            $data['studentsRecords'] = $students;
            $data['labSubjects'] = $this->student->getSubjectsForHallTicketPrint($subjects);
            $this->global['pageTitle'] = 'SchoolPhins-STXPUC : Hall Ticket';
            $this->loadViews("office/secondYearHallTicket", $this->global, $data, null);
        }
    }

    public function generateExcellenciaCertificate($student_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
            }
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->global['pageTitle'] = 'SchoolPhins-STXPUC : Students Excellence Certificate To Print';
            $this->loadViews("students/generateExcellenciaCertificate", $this->global, $data, null);
        }
    }

    //study certificate
    function getCertificate()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $filter = array();
           
            $request_sub = $this->security->xss_clean($this->input->post('request_sub'));
            $request_issue = $this->security->xss_clean($this->input->post('request_issue'));
            $request_certificate = $this->security->xss_clean($this->input->post('request_certificate'));
            $student_row_id = $this->security->xss_clean($this->input->post('student_row_id'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            
            $data['student_row_id'] = $filter['student_row_id'] = $student_row_id;
            $data['student_name'] = $filter['student_name'] = $student_name;
            $data['student_id'] = $filter['student_id'] = $student_id;
            $data['request_sub']  = $filter['request_sub'] = $request_sub;
            $data['request_issue']  = $filter['request_issue'] = $request_issue;
            $data['request_certificate']  = $filter['request_certificate'] = $request_certificate;
            $data['certificateData'] = $this->student->getCertificateInfo($request_certificate);
            
            $count = $this->student->getAllRequestFormInfoCount($filter);
            $returns = $this->paginationCompress("getCertificate/", $count, 100);
            $data['RecordsCount'] = $count;
            $data['studentRecords'] = $this->student->getAllRequestFormInfo($filter,$returns["page"], $returns["segment"]);
            $data['studentInfo'] = $this->student->studentData();
           $data['certificateInfo'] = $this->student->certificateNames();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Request Form Details';
            $this->loadViews("students/requestCertificate", $this->global,$data, NULL);

        }
    }

    public function addStudentRequestForm(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            // $this->form_validation->set_rules('request_sub','Request Subject','trim|required');
            $this->form_validation->set_rules('request_certificate','Request Certificate Number','trim|required');
            // $this->form_validation->set_rules('request_issue','Request Issue','trim|required');
            $this->form_validation->set_rules('student_row_id','student row id','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->getCertificate();
            } else {
                $request_sub = $this->security->xss_clean($this->input->post('request_sub'));
                $request_certificate = $this->security->xss_clean($this->input->post('request_certificate'));
                $request_issue = $this->security->xss_clean($this->input->post('request_issue'));
                $student_row_id = $this->security->xss_clean($this->input->post('student_row_id'));
                $college_from = $this->security->xss_clean($this->input->post('college_from'));
                $college_to = $this->security->xss_clean($this->input->post('college_to'));
                $classes_from = $this->security->xss_clean($this->input->post('classes_from'));
                $classes_to = $this->security->xss_clean($this->input->post('classes_to'));
                $character = $this->security->xss_clean($this->input->post('character'));
                $progress = $this->security->xss_clean($this->input->post('progress'));
                if($request_certificate == 2){
                    $requestInfo = array(
                        'student_row_id' => $student_row_id,
                        'request_sub' => $request_sub,
                        'certificate_Id' => $request_certificate,
                        'issue' => $request_issue,
                        'college_from' => $college_from,
                        'college_to' => $college_to,
                        'classes_from' => $classes_from,
                        'classes_to' => $classes_to,
                        'progress' => $progress,
                        'character_conduct' => $character,
                        'created_by' => $this->staff_id,
                        'created_date_time' =>date('Y-m-d H:i:s')
                    );
                    $return_id = $this->student->addStudentRequestForm($requestInfo);
                }else{
                    $requestInfo = array(
                        'student_row_id' => $student_row_id,
                        'request_sub' => $request_sub,
                        'certificate_Id' => $request_certificate,
                        'issue' => $request_issue,
                        'college_from' => $college_from,
                        'college_to' => $college_to,
                        'classes_from' => $classes_from,
                        'classes_to' => $classes_to,
                        'character_conduct' => $character,
                        'created_by' => $this->staff_id,
                        'created_date_time' =>date('Y-m-d H:i:s')
                    );
                    $return_id = $this->student->addStudentRequestForm($requestInfo);
                }
                
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Request Data Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'New Request Data failed to add');
                }
                redirect('getCertificate');
            }
        }
    }

    public function getStudentBiodata(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
          
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            
            $this->global['pageTitle'] = 'SchoolPhins-STXPUC : Students Bio-Data To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->loadViews("students/getStudentBiodata", $this->global, $data, null);
        }
    }


           // mark card assignment annual depromoted 
    public function getSupplementaryMarkPrint2022($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',6,6,6,8,15,15);
            $mpdf->SetTitle('SUPPLEMENTARY MARKS CARD');
            $html = $this->load->view('examReport22/generateSupplementaryMarkCard',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('SUPPLEMENTARY_MARKS_CARD.pdf', 'I');
        }
    }


     //Course Register Listing



     public function getAllCourseRegisterInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->input->post('student_id');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $course_name = $this->security->xss_clean($this->input->post('course_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
              
            $data['by_student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['course_name'] = $course_name;
            $data['amount'] = $amount;
             
            $filter['by_student_id']= $student_id;
            $filter['student_name']= $student_name;
            $filter['course_name']= $course_name;
            $filter['amount']= $amount;
           
            $this->load->library('pagination');
            $count = $this->student->getAllCourseRegisterInfoCount($filter);
            $returns = $this->paginationCompress("getAllCourseRegisterInfo/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['courseRegisterInfo'] = $this->student->getAllCourseRegisterInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Payment Pending Application';
            $this->loadViews("students/courseRegisterListing", $this->global, $data, null);
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

        //Alumni student tc list  
        function getAlumniStudentTc() {
            if($this->isAdmin() == TRUE ){
                $this->loadThis();
            } else {
                $filter = array();
                $name = $this->security->xss_clean($this->input->post('name'));
                $class = $this->security->xss_clean($this->input->post('class'));
                $register_no = $this->security->xss_clean($this->input->post('register_no'));
                $tc_number = $this->security->xss_clean($this->input->post('tc_number'));
                $by_date = $this->security->xss_clean($this->input->post('by_date'));
    
               
                $data['name'] = $name;
                $data['class'] = $class;              
                $data['register_no'] = $register_no;
                $data['tc_number'] = $tc_number;
    
                
                $filter['name'] = $name;
                $filter['class'] = $class;               
                $filter['register_no'] = $register_no;
                $filter['tc_number'] = $tc_number;
                
                
                if(!empty($by_date)){
                    $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                    $data['by_date'] = date('d-m-Y',strtotime($by_date));
                }else{
                    $data['by_date'] = '';
                }
                
                $count = $this->student->getStudentsDetailsForAlumniTcCount($filter);
                $returns = $this->paginationCompress("getAlumniStudentTc/", $count, 100);
                $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
                $data['religionInfo'] = $this->settings->getAllReligionInfo();
                $data['totalCount'] = $count;
                $filter['page'] = $returns["page"];
                $filter['segment'] = $returns["segment"];
                $data['studentTcInfo'] = $this->student->getAluminiStudentsDetailsForTC($filter);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
                $this->loadViews("students/viewAlumniStudentTC", $this->global,$data, NULL);
    
            }
        }


        public function addAlumniStudentTCInfo(){
            if($this->isAdmin() == TRUE  ){
                $this->loadThis();
            } else {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name','Student Name','trim|required');
                $this->form_validation->set_rules('dob','DOB','trim|required');
               
                if($this->form_validation->run() == FALSE) {
                    redirect('getAlumniStudentTc/');  
                } else {
                    
                    
                    $roll_no = $this->security->xss_clean($this->input->post('roll_no'));
                    $nationality = $this->security->xss_clean($this->input->post('nationality'));
                    $religion = $this->security->xss_clean($this->input->post('religion'));
                    $name = $this->security->xss_clean($this->input->post('name'));
                    $dob = $this->security->xss_clean($this->input->post('dob'));
                    $mother_name = $this->security->xss_clean($this->input->post('mother_name'));

                    $father_name = $this->security->xss_clean($this->input->post('father_name'));
                    $date_of_admission = $this->security->xss_clean($this->input->post('date_of_admission'));
                    $date_of_leaving = $this->security->xss_clean($this->input->post('date_of_leaving'));
                    $class = $this->security->xss_clean($this->input->post('class'));
                    $language_subject = $this->security->xss_clean($this->input->post('language_subject'));
                    $optional_subject = $this->security->xss_clean($this->input->post('optional_subject'));
                    $medium = $this->security->xss_clean($this->input->post('medium'));

                    $qualified_status = $this->security->xss_clean($this->input->post('qualified_status'));
                    $reason_unqualified = $this->security->xss_clean($this->input->post('reason_unqualified'));                    

                    $register_no = $this->security->xss_clean($this->input->post('register_no'));
                    $belong_sc_st = $this->security->xss_clean($this->input->post('belong_sc_st'));
                    $fee_due = $this->security->xss_clean($this->input->post('fee_due'));
                    $character = $this->security->xss_clean($this->input->post('character'));   
                    $tc_number = $this->security->xss_clean($this->input->post('tc_number'));        
                    $remarks = $this->security->xss_clean($this->input->post('remarks'));           
                    $appliedYear =  CURRENT_YEAR;
                    
                    if(!empty($dob)) {
                        $dob = date('Y-m-d',strtotime($dob));
                    } else {
                        $dob = "";
                    }
                    for($i=0;$i<count($optional_subject);$i++){
                        $subjects.= $optional_subject[$i].',';
                    }
                    for($i=0;$i<count($language_subject);$i++){
                        $language.= $language_subject[$i].',';
                    }
                 
                           
                    // $isExists = $this->student->checkAlumniTCNumberExists($roll_no,$appliedYear);
                    // if($isExists == 0){ 
                    //     $appliedID = $this->student->getAlumniStudentTCAppliedLastRowId($appliedYear);
                    //     if(empty($appliedID)){
                    //         $tc_id = 0;
                    //         $tcNumber = sprintf("%04d", ++$tc_id);
                    //         $tc_number = 'SJPUC/'.$appliedYear.'/'.$tcNumber;
                    //     }else{
                    //         $tc_id = array_pop(explode('/', $appliedID->tc_number));
                    //         $tcNumber = sprintf("%04d", ++$tc_id);
                    //         $tc_number = 'SJPUC/'.$appliedYear.'/'.$tcNumber;
                    //     }
                    // }else{
                    //     $tc_number = $isExists->tc_number;
                    // }
                    $studentInfo = array(
                        'tc_number'=>$tc_number,
                        'roll_no' => $roll_no,
                        'name' => $name,
                        'dob' => $dob,
                        'nationality' => $nationality,
                        'religion' => $religion, 
                        'father_name' => $father_name,
                        'mother_name' => $mother_name,
                        'date_of_admission' => $date_of_admission, 
                        'date_of_leaving' => $date_of_leaving, 
                        'class'=> $class,
                        'language_subject'=> $language,
                        'optional_subject' => $subjects,
                        'medium' => $medium,
                        'qualified_status' => $qualified_status,
                        'reason_unqualified'=>$reason_unqualified,
                        'register_no' => $register_no,
                        'belong_sc_st'=> $belong_sc_st,
                        'fee_due'=> $fee_due,
                        'conduct_character' => $character,
                        'applied_year'=>$appliedYear,
                        'remarks'=>$remarks,
                        'updated_by'=>$this->staff_id, 
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->student->AddAluminiStudentTCInfo($studentInfo);
                    
                    if($result > 0) {
                        $this->session->set_flashdata('success', 'Student Details Successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Student Update failed');
                    }
                    redirect('getAlumniStudentTc/');  
                }
            }
        }


            // get student info for TC Print
    public function getAlumniStudentsTcInfoById(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{     
            $row_id = $this->security->xss_clean($this->input->get('row_id'));
            $row_id = base64_decode(urldecode($row_id));
            $row_id = json_decode(stripslashes($row_id));
            $data['studentInfo'] = $this->student->getAlumniStudentsTcInfoById($row_id); 
            log_message('debug','dadaaa--'.print_r($data['studentInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Transfer Certificate'; 
            $this->loadViews("students/viewAlumniStudentTCprint", $this->global,$data, NULL);
           
        }
    } 

    public function getAlumniStudentTcInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{          
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $studentTcInfo = $this->student->getAlumniStudentsTcInfoById($row_id);
            log_message('debug','dataa'.print_r($studentTcInfo ,true));
            echo json_encode($studentTcInfo);
            exit(0);
        }
    }


    public function deleteStudentRequestDetails(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $requestInfo = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->student->updateRequestCertificate($requestInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    

    public function addRemarks(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 

                
                $filter = array();
                $student_Id = $this->security->xss_clean($this->input->post('row_id'));
                $remarks_type_id = $this->security->xss_clean($this->input->post('remarks_type_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $remark = $this->security->xss_clean($this->input->post('remark'));
               
                $image_path="";
                $target_dir="upload/remarks/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path'] = $image_path;
                }
                
                // $studSemInfo = $this->student->getStudentInfoByStdRowId($student_Id);
                $student = $this->student->getStudentInfoById($student_Id);

                $remarkInfo= array(
                    'student_id' => $student_Id,
                    'type_id' => $remarks_type_id,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'year' => date('Y'),
                    'term_name' => $student->term_name,
                    'file_path' => $image_path,
                    'description' => $description,
                    'remarks' => $remark,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s'));

                $return_id = $this->student->addRemarks($remarkInfo);
                    
                if($return_id > 0){
                    $studInfo = $this->student->getStudentInfoById($student_Id);
                    // $this->sendNotificationForRemark($studInfo->sat_number);
                    $this->session->set_flashdata('success', 'Remarks Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to add ');
                }
                redirect('viewStudentInfoById/'.$student_Id);  
            
            
        }
    }


    public function updateRemarksInfo(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 

                
                $filter = array();
                $remark_id = $this->security->xss_clean($this->input->post('remark_id'));
                $student_Id = $this->security->xss_clean($this->input->post('row_id'));
                $remarks_type_id = $this->security->xss_clean($this->input->post('remarks_type_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $remark = $this->security->xss_clean($this->input->post('remark'));

                $image_path="";
                $target_dir="upload/remarks/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path'] = $image_path;
                }
                log_message('debug','imagePath'.$image_path);
                // $studSemInfo = $this->student->getStudentInfoByStdRowId($student_Id);
                $student = $this->student->getStudentInfoById($student_Id);
               if(!empty($image_path)){
                $remarkInfo= array(
                    'student_id' => $student_Id,
                    'type_id' => $remarks_type_id,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'year' => date('Y'),
                    'file_path' => $image_path,
                    'description' => $description,
                    'remarks' => $remark,
                    // 'created_by' => $this->staff_id,
                    // 'created_date_time' => date('Y-m-d h:i:s')),
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d h:i:s'));
                    
                }else{
                    $remarkInfo= array(
                        'student_id' => $student_Id,
                        'type_id' => $remarks_type_id,
                        'date' =>date('Y-m-d',strtotime($date)),
                        'year' => date('Y'),
                        'description' => $description,
                        // 'created_by' => $this->staff_id,
                        // 'created_date_time' => date('Y-m-d h:i:s')); 
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d h:i:s'));
                }

                $return_id = $this->student->updateRemarksInfo($remarkInfo,$remark_id);
                    
                if($return_id > 0){
                    $studInfo = $this->student->getStudentInfoById($student_Id);
                    // $this->sendNotificationForRemark($studInfo->sat_number);
                    $this->session->set_flashdata('success', 'Remarks Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Update Remarks');
                }
                redirect('viewStudentInfoById/'.$student_Id);  
            
            
        }
    }

    public function getNameByStudentNumber(){
        $student_id = trim($this->input->post('student_id'));

        $filter['student_id'] =  $student_id;
        if(!empty($student_id)){
            $result = $this->student->getStudentInfoByStudentId($filter);
            if(!empty($result)) echo $result->student_name;
            // log_message('debug','info'.print_r($result->student_name,true));}
            else echo 0;
        }else echo 0;
    }


    public function deleteStudentRemarkDetails(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            
            $remarkInfo = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->student->updateRemarksInfo($remarkInfo, $row_id);
           
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }



    public function generateBarcodeForStudent($row_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                $row_id = $this->security->xss_clean($this->input->get('row_id'));
                $row_id = base64_decode(urldecode($row_id));
                $row_id = json_decode(stripslashes($row_id));
            }
          
            foreach($row_id as $id){
                
                $roll_number[$id] = $this->student->getStudentRollNo($id);
                // log_message('debug','data'.print_r($roll_number[$id],true));
                // log_message('debug','data'.$roll_number[$id]->student_id);
                $generate_barcode[$id] = $this->set_barcode($roll_number[$id]->student_id);
            }
            $data['generate_barcode'] = $generate_barcode;
           
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman','format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',7,7,7,7,8,8);
            $mpdf->SetTitle('Bar Code');
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Barcode';

            $html = $this->load->view('students/viewBarCodePrintForStudent',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('BarCode.pdf', 'I'); 

        }
    }


    function set_barcode($code)
        {
            //load in folder Zend
            $this->zend->load('Zend/Barcode');
            //generate barcode
            $file = Zend_Barcode::draw('code128', 'image', array('text'=>$code), array());
            //$code = str_replace('/', '_', $code);
            $code = time().$code;
            $barcodeRealPath = APPPATH. '/barcode/'.$code.'.png';
            $barcodePath = APPPATH.'/barcode/';
    
            header('Content-Type: image/png');
            $store_image = imagepng($file,$barcodeRealPath);
            return $barcodePath.$code.'.png';
        }

        
    public function redirectStudentView(){
        $std_row_id = $this->security->xss_clean($this->input->post('student_id'));
        redirect('viewStudentInfoById/'.$std_row_id);
    }



    public function getAnnualMarkCardToPrint2024($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',6,6,6,8,15,15);
            $mpdf->SetTitle('ANNUAL MARKS CARD');
            // $html = $this->load->view('exam_report/generateAnnualMarkCard',$data,true);
            $html = $this->load->view('examReport22/generateAnnualMarkCardNew',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('ANNUAL_MARKS_CARD.pdf', 'I');
        }
    }

    
}

?>