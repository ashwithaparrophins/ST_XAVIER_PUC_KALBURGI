<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('user_model');
        $this->load->model('staff_model','staff');
        $this->load->model('leave_model','leave');
        $this->load->model('Students_model','student');
        $this->load->model('subjects_model','subject');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('push_notification_model');  
        $this->load->model('fee_model','fee');
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->facultyDashboard();
    }

    /**
     * This function is used to load the user list
     * 
     */
    public function facultyDashboard()
    {
        $todayDate = date('Y-m-d');
        $data['staffInfo'] = $this->staff->getStaffInfoForProfile($this->staff_id);
        $data['allStudentInfo'] = $this->student->getAllCurrentStudentInfo();
        $data['AllstaffInfo'] = $this->staff->getAllStaffInfo();
        $subjects_code = array();
        $exam_mark_first_test = array();

        // $filter['by_role'] = ROLE_TEACHING_STAFF;
        // $data['teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_NON_TEACHING_STAFF;
        // $data['non_teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_SUPPORT_STAFF;
        // $data['support_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_ADMIN;
        // $data['admin_total']= $this->staff->staffListingCount($filter);
        $deptInfo = $this->staff->getStaffDepartment();
        $data['total_staff'] = 0;
        foreach($deptInfo as $dept){
            $filter['by_dept'] = $dept->dept_id;
            $countStaff = $this->staff->staffListingCount($filter);
            $staffCount[$dept->dept_id] = $countStaff;
            $data['total_staff'] += $countStaff;
        }
        $data['staffCount'] = $staffCount;
       
        $data['deptInfo'] = $deptInfo;
        // $data['staffInTime']= $this->staff->getStaffAttendanceInTimeByID($todayDate,$this->staff_id);
        // $data['staffOutTime']= $this->staff->getStaffAttendanceOutTimeByID($todayDate,$this->staff_id);
        
        // $data['notificationLeave']= $this->leave->getStaffAppliedLeaveInfoByDate($todayDate, $this->staff_id);
        
        // $data['totalPresentsTeachingStaffs']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_TEACHING_STAFF);
        // $data['totalNonTeachingPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_NON_TEACHING_STAFF);
        // $data['totalSupportStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_SUPPORT_STAFF);
        // $data['totalAdminStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_ADMIN);
        $filter['by_intake_year'] = ''.FIRST_YEAR.'';
        $filter['term'] = 'I PUC';
       $data['totalFirstYearStudents']= $this->student->getCountOfStudents($filter,);
       $filter['term'] = 'II PUC';
        $filter['by_intake_year'] = ''.SECOND_YEAR.'';
        $staff_id = '';
       $data['totalSecondYearStudents']= $this->student->getCountOfStudents($filter);
       $data['staffSubjectInfo']= $this->staff->getAllSubjectByStaffId($this->staff_id);
        $staffClass = $this->staff->getStaffSubjectSectionByStaffId($this->staff_id);
        $subjectInfo = $this->subject->getStaffSubjectCodebyStaffId($this->staff_id);
       $data['assignedStaffsection'] = $this->staff->getSectionByStaffId($this->staff_id);
       $data['alumniStudents'] =  $this->student->getAlumniStudentCount($filter);
      //  $data['staffClassCompletedInfo'] = $this->attendance->getStaffClassCompletenfoById();
        $classCompletedCount = array();
        $data['assignedStaffClass'] = $staffClass;
        foreach($staffClass as $class){
            for($i=0;$i<count($subjectInfo);$i++){
                $subject_code[$i] = $subjectInfo[$i]->subject_id;
            }
            $subjectCode = $subject_code;
            $staff_id = $this->staff_id;
            $classCompletedCount[$class->row_id] = $this->staff->geStaffClassCompletetedCount($staff_id,$class->term_name,$class->section_name,$class->stream_name);
        }
        $data['classCompletedCount'] = $classCompletedCount;
     
        
        // $filter['search_date'] = $todayDate;
        // $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();
        // $isExists = $this->attendance->CheckTimetableDayShiftExists($filter);
        // if($this->role == ROLE_TEACHING_STAFF){
        //     $filter['staff_id'] = $this->staff_id;
        // }
        // if(!empty($isExists)){
        //     $filter['week'] = $isExists->week_name;
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getShiftTimetableInfo($filter,$returns = '',$returns = '');
        // }else{
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $filter['weekName'] = date('l',strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getClassForAttendance($filter,$returns = '',$returns = '');
        // }
        
        $exam_mark_first_test = array();
        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        if(!empty($student_id)){
            $filter['student_id'] = $student_id;
            $studentRecord = $this->student->getStudentInfoByStudentId($filter); 
            if(!empty($studentRecord)){
                $std_batch = $studentRecord->batch;
                $filter['doj'] = '';
                if(date('Y-m-d',strtotime($studentRecord->doj))){
                    $filter['doj'] = date('Y-m-d',strtotime($studentRecord->doj));
                } else{
                    $filter['doj'] = '';
                }
                // $filter['stream_name'] = $studentRecord->stream_name;
                // $filter['section_name'] = $studentRecord->section_name;
                // $filter['term_name'] = $studentRecord->term_name; 
                $data['studentsRecords'] = $studentRecord;
                $elective_sub = strtoupper($studentRecord->elective_sub);            
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
                $subjects = $this->getSubjectCodes($studentRecord->stream_name);
               // log_message('debug','subjectsss'.print_r($subjects,true));
               // log_message('debug','subjectssscodeee'.print_r($subjects_code,true));

                $subjects_code = array_merge($subjects_code,$subjects);
                $data['subject_code'] = $subjects_code;
                // $filter['term_name'] = $studentRecord->term_name; 
                $filter['term'] = '';

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
                    $absent_count_theory[$subjects_code[$i]] = $this->attendance->isStudentIsAbsentForClass($studentRecord->student_id,$subjects_code[$i],$filter,$type);
                    
                    // log_message('debug','absent_count_theory='.print_r($absent_count_theory,true));
                    $type="LAB";
                    $absent_count_lab[$subjects_code[$i]] = $this->attendance->isStudentIsAbsentForClass($studentRecord->student_id,$subjects_code[$i],$filter,$type);
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
                    // $total_attd_class_std = $absentCount[$subjects_code[$i]];

                    $data['class_held'] = $class_held;
                    $data['class_attended'] = $absent_count;
                    $data['subjects'] = $subInfo;
                    
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
                     $getMarkOfFirstUnitTest = $this->student->getFirstInternaltMark($studentRecord->student_id,$subjects_code[$i]);
                
                    $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

                    $getMarkOfmidTermExam = $this->student->getMidTermMark($studentRecord->student_id,$subjects_code[$i]); 
                    $exam_mark_mid_term[$i] = $getMarkOfmidTermExam;
                }
                $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
                $data['midTermMarkInfo'] = $exam_mark_mid_term;

            } else {
                $data['studentsRecords'] = '';
                $data['studentSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                Invalid Student ID
              </div>';
            }
            $data['student_id'] =  $student_id;
      
        } else {
            $data['student_id'] =  '';
            $data['studentsRecords'] = '';
            $data['studentSearchMsg'] = '<div class="alert card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
            Search by Student ID 
          </div>';
        }
     
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
        if(!empty($staff_id)){
            $staffRecord = $this->staff->getStaffInfoForProfile($staff_id); 
            if(!empty($staffRecord)){ 
                $data['staffSectionInfo'] = $this->staff->getSectionByStaffId($staff_id);
                $data['staffSubjectInfo'] = $this->staff->getAllSubjectByStaffId($staff_id);
                $data['staffRecord'] = $staffRecord;
            } else {
                $data['staffRecord'] = '';
                $data['staffSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                    Invalid Staff ID
                </div>';
            }
            $data['staff_id'] =  $staff_id;
      
        } else {
            $data['staff_id'] =  '';
            $data['staffRecord'] = '';
            $data['staffSearchMsg'] = '<div class="alert  card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
                Search by Staff ID 
            </div>';
        }

        $current_date_month =date('m-d');
        $staffDob = array();
        $staffbirthDate = $this->staff->getAllStaffInfo();
        //log_message('debug','data'.print_r($staffbirthDate,true));
        for($i=0;$i<count($staffbirthDate);$i++) {
            $staff_dob = date('m-d',strtotime($staffbirthDate[$i]->dob));
            //log_message('debug','data'.print_r($staff_dob,true));
                if($staffbirthDate[$i]->dob != '0000-00-00' && $staffbirthDate[$i]->dob != ''){
                 if($staff_dob == $current_date_month){
                    $staffDob[$i] = $staffbirthDate[$i]->staff_id;
                 }
    
               }
            }

            if(!empty($staffDob)){
                $data['staffsBirthday'] = $this->staff->getStaffBirthdayInfoById($staffDob);
               // log_message('debug','data'.print_r($data['staffsBirthday'],true));
                }else{
                    $data['staffDob'] =  '';
                    $data['staffsBirthday'] = '';
                    $data['staffbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                            No Birthdays Today!
                          </div>';
                }

                $studentDob = array();
           $studentbirthDate = $this->student->getstudentInfo();
            for($j=0;$j<count($studentbirthDate);$j++) {
               if(!empty($studentbirthDate[$j]->dob)){
                 if($studentbirthDate[$i]->dob != '0000-00-00' && $studentbirthDate[$i]->dob != ''){
               $student_dob = date('m-d',strtotime($studentbirthDate[$j]->dob));
                     if($student_dob == $current_date_month){
                       
                        $studentDob[$j] = $studentbirthDate[$j]->dob;
                     }  
               }
            }   
           }

           if(!empty($studentDob)){
            $data['studentsBirthday'] = $this->student->getStudentsBirthdayNotification($studentDob);
            }else{
                $data['studentDob'] =  '';
                $data['studentsBirthday'] = '';
                $data['studentbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                        No Birthdays Today!
                      </div>';
            }
                
                $start_date = date('d')+1;
            $end_date = date('d')+6;
            // log_message('debug','data'.print_r($end_date,true));
            $fromDate = date('m').'-'.$start_date;
            $toDate = date('m').'-'.$end_date;

            $staff_upcoming = array();
            $staffUpcomingBday =  $this->staff->getAllStaffInfo();

            for($i=0;$i<count($staffUpcomingBday);$i++) {
                $staff_up = date('m-d',strtotime($staffUpcomingBday[$i]->dob));
                if($staffUpcomingBday[$i]->dob != '0000-00-00' && $staffUpcomingBday[$i]->dob != ''){
                        if($staff_up >= $fromDate && $staff_up <= $toDate){
                            $staff_upcoming[$i] = $staffUpcomingBday[$i]->staff_id;
                        }
                        }
           }

           if(!empty($staff_upcoming)){
            $data['staffUpcomingBday'] = $this->staff->getStaffBirthdayInfoById($staff_upcoming);
            }else{
                $data['staff_upcoming'] =  '';
                $data['staffUpcomingBday'] = '';
                $data['staffUpcomingbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                        No Upcoming Birthdays!
                      </div>';
            }

            $student_upcoming = array();
       $studentUpcomingBday = $this->student->getstudentInfo();
        for($j=0;$j<count($studentUpcomingBday);$j++) {
            if(!empty($studentUpcomingBday[$j]->dob)){
           $student_up = date('m-d',strtotime($studentUpcomingBday[$j]->dob));
                 if($student_up >= $fromDate && $student_up <= $toDate){
                   
                    $student_upcoming[$j] = $studentUpcomingBday[$j]->dob;
                    
                 }
            }

       }

       if(!empty($student_upcoming)){
        $data['studentUpcomingBday'] = $this->student->getStudentsBirthdayNotification($student_upcoming);

        }else{
            $data['student_upcoming'] =  '';
            $data['studentUpcomingBday'] = '';
            $data['studentUpcomingbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                    No Upcoming Birthdays!
                  </div>';
        }
    
        if($this->role == ROLE_TEACHING_STAFF){
            $filter['role'] = 'Staff';
            $filter['role_one'] = 'ALL';
        }
        $this->load->library('pagination');
        $newsCount = $this->staff->getNewsFeedCount($filter);
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
       // log_message('debug','count'.print_r($returns,true));
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        $data['from_date'] = $from_date = $this->security->xss_clean($this->input->post('from_date'));
     $data['to_date'] = $to_date = $this->security->xss_clean($this->input->post('to_date'));
     if(empty($from_date)){
         $from_date = date('Y-m-d');
         $to_date = date('Y-m-d');
        
     }
     
     $data['from_date'] = $from_date;
     $data['to_date'] = $to_date;
 
     $data['fees_paid'] = $this->fee->getTotalPaidAmountByDate($from_date,$to_date);
     $data['mis_paid'] = $this->fee->getTotalMisAmountByDate($from_date,$to_date);
  
       // $newsCount = $this->staff->getNewsFeedCount($filter);
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
       // $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        // foreach($data['newsInfo'] as $news){
        //     $news->isLiked=$this->staff->isLiked($news->row_id,$this->session->userdata('staff_id'));
        //     $news->totalLikes=$this->staff->totalLikes($news->row_id);
        // }
        $data['documentInfo'] = $this->user_model->getAlldocumentInfoDashboard();
        $data['UserModel'] = $this->user_model;
        
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Teaching Staff Dashboard';
        $this->loadViews("dashboard", $this->global, $data, null);
    }
   

    public function adminDashboard()
    {
        $todayDate = date('Y-m-d');
        $data['staffInfo'] = $this->staff->getStaffInfoForProfile($this->staff_id);
        $data['allStudentInfo'] = $this->student->getAllCurrentStudentInfo();
        $data['AllstaffInfo'] = $this->staff->getAllStaffInfo();
        $subjects_code = array();
        $exam_mark_first_test = array();

        // $filter['by_role'] = ROLE_TEACHING_STAFF;
        // $data['teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_NON_TEACHING_STAFF;
        // $data['non_teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_SUPPORT_STAFF;
        // $data['support_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_ADMIN;
        // $data['admin_total']= $this->staff->staffListingCount($filter);
        $deptInfo = $this->staff->getStaffDepartment();
        $data['total_staff'] = 0;
        foreach($deptInfo as $dept){
            $filter['by_dept'] = $dept->dept_id;
            $countStaff = $this->staff->staffListingCount($filter);
            $staffCount[$dept->dept_id] = $countStaff;
            $data['total_staff'] += $countStaff;
        }
        $data['staffCount'] = $staffCount;
       
        $data['deptInfo'] = $deptInfo;
        // $data['staffInTime']= $this->staff->getStaffAttendanceInTimeByID($todayDate,$this->staff_id);
        // $data['staffOutTime']= $this->staff->getStaffAttendanceOutTimeByID($todayDate,$this->staff_id);
        
        // $data['notificationLeave']= $this->leave->getStaffAppliedLeaveInfoByDate($todayDate, $this->staff_id);
        
        // $data['totalPresentsTeachingStaffs']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_TEACHING_STAFF);
        // $data['totalNonTeachingPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_NON_TEACHING_STAFF);
        // $data['totalSupportStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_SUPPORT_STAFF);
        // $data['totalAdminStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_ADMIN);
        $filter['by_intake_year'] = ''.FIRST_YEAR.'';
        $filter['term'] = 'I PUC';
       $data['totalFirstYearStudents']= $this->student->getCountOfStudents($filter,);
       $filter['term'] = 'II PUC';
        $filter['by_intake_year'] = ''.SECOND_YEAR.'';
        $staff_id = '';
       $data['totalSecondYearStudents']= $this->student->getCountOfStudents($filter);
       $data['staffSubjectInfo']= $this->staff->getAllSubjectByStaffId($this->staff_id);
        $staffClass = $this->staff->getStaffSubjectSectionByStaffId($this->staff_id);
        $subjectInfo = $this->subject->getStaffSubjectCodebyStaffId($this->staff_id);
       $data['assignedStaffsection'] = $this->staff->getSectionByStaffId($this->staff_id);
       $data['alumniStudents'] =  $this->student->getAlumniStudentCount($filter);
      //  $data['staffClassCompletedInfo'] = $this->attendance->getStaffClassCompletenfoById();
        $classCompletedCount = array();
        $data['assignedStaffClass'] = $staffClass;
        foreach($staffClass as $class){
            for($i=0;$i<count($subjectInfo);$i++){
                $subject_code[$i] = $subjectInfo[$i]->subject_id;
            }
            $subjectCode = $subject_code;
            $staff_id = $this->staff_id;
            $classCompletedCount[$class->row_id] = $this->staff->geStaffClassCompletetedCount($staff_id,$class->term_name,$class->section_name,$class->stream_name);
        }
        $data['classCompletedCount'] = $classCompletedCount;
     
        
        // $filter['search_date'] = $todayDate;
        // $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();
        // $isExists = $this->attendance->CheckTimetableDayShiftExists($filter);
        // if($this->role == ROLE_TEACHING_STAFF){
        //     $filter['staff_id'] = $this->staff_id;
        // }
        // if(!empty($isExists)){
        //     $filter['week'] = $isExists->week_name;
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getShiftTimetableInfo($filter,$returns = '',$returns = '');
        // }else{
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $filter['weekName'] = date('l',strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getClassForAttendance($filter,$returns = '',$returns = '');
        // }
        
        $exam_mark_first_test = array();
        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        if(!empty($student_id)){
            $filter['student_id'] = $student_id;
            $studentRecord = $this->student->getStudentInfoByStudentId($filter); 
            if(!empty($studentRecord)){
                $std_batch = $studentRecord->batch;
                $filter['doj'] = '';
                if(date('Y-m-d',strtotime($studentRecord->doj))){
                    $filter['doj'] = date('Y-m-d',strtotime($studentRecord->doj));
                } else{
                    $filter['doj'] = '';
                }
                // $filter['stream_name'] = $studentRecord->stream_name;
                // $filter['section_name'] = $studentRecord->section_name;
                // $filter['term_name'] = $studentRecord->term_name; 
                $data['studentsRecords'] = $studentRecord;
                $elective_sub = strtoupper($studentRecord->elective_sub);            
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
                $subjects = $this->getSubjectCodes($studentRecord->stream_name);
               // log_message('debug','subjectsss'.print_r($subjects,true));
               // log_message('debug','subjectssscodeee'.print_r($subjects_code,true));

                $subjects_code = array_merge($subjects_code,$subjects);
                $data['subject_code'] = $subjects_code;
                // $filter['term_name'] = $studentRecord->term_name; 
                $filter['term'] = '';

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
                    $absent_count_theory[$subjects_code[$i]] = $this->attendance->isStudentIsAbsentForClass($studentRecord->student_id,$subjects_code[$i],$filter,$type);
                    
                    // log_message('debug','absent_count_theory='.print_r($absent_count_theory,true));
                    $type="LAB";
                    $absent_count_lab[$subjects_code[$i]] = $this->attendance->isStudentIsAbsentForClass($studentRecord->student_id,$subjects_code[$i],$filter,$type);
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
                    // $total_attd_class_std = $absentCount[$subjects_code[$i]];

                    $data['class_held'] = $class_held;
                    $data['class_attended'] = $absent_count;
                    $data['subjects'] = $subInfo;
                    
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
                     $getMarkOfFirstUnitTest = $this->student->getFirstInternaltMark($studentRecord->student_id,$subjects_code[$i]);
                
                    $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

                    $getMarkOfmidTermExam = $this->student->getMidTermMark($studentRecord->student_id,$subjects_code[$i]); 
                    $exam_mark_mid_term[$i] = $getMarkOfmidTermExam;
                }
                $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
                $data['midTermMarkInfo'] = $exam_mark_mid_term;

            } else {
                $data['studentsRecords'] = '';
                $data['studentSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                Invalid Student ID
              </div>';
            }
            $data['student_id'] =  $student_id;
      
        } else {
            $data['student_id'] =  '';
            $data['studentsRecords'] = '';
            $data['studentSearchMsg'] = '<div class="alert card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
            Search by Student ID 
          </div>';
        }
     
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
        if(!empty($staff_id)){
            $staffRecord = $this->staff->getStaffInfoForProfile($staff_id); 
            if(!empty($staffRecord)){ 
                $data['staffSectionInfo'] = $this->staff->getSectionByStaffId($staff_id);
                $data['staffSubjectInfo'] = $this->staff->getAllSubjectByStaffId($staff_id);
                $data['staffRecord'] = $staffRecord;
            } else {
                $data['staffRecord'] = '';
                $data['staffSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                    Invalid Staff ID
                </div>';
            }
            $data['staff_id'] =  $staff_id;
      
        } else {
            $data['staff_id'] =  '';
            $data['staffRecord'] = '';
            $data['staffSearchMsg'] = '<div class="alert  card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
                Search by Staff ID 
            </div>';
        }

        $current_date_month =date('m-d');
        $staffDob = array();
        $staffbirthDate = $this->staff->getAllStaffInfo();
        //log_message('debug','data'.print_r($staffbirthDate,true));
        for($i=0;$i<count($staffbirthDate);$i++) {
            $staff_dob = date('m-d',strtotime($staffbirthDate[$i]->dob));
            //log_message('debug','data'.print_r($staff_dob,true));
                if($staffbirthDate[$i]->dob != '0000-00-00' && $staffbirthDate[$i]->dob != ''){
                 if($staff_dob == $current_date_month){
                    $staffDob[$i] = $staffbirthDate[$i]->staff_id;
                 }
    
               }
            }

            if(!empty($staffDob)){
                $data['staffsBirthday'] = $this->staff->getStaffBirthdayInfoById($staffDob);
               // log_message('debug','data'.print_r($data['staffsBirthday'],true));
                }else{
                    $data['staffDob'] =  '';
                    $data['staffsBirthday'] = '';
                    $data['staffbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                            No Birthdays Today!
                          </div>';
                }

                $studentDob = array();
           $studentbirthDate = $this->student->getstudentInfo();
            for($j=0;$j<count($studentbirthDate);$j++) {
               if(!empty($studentbirthDate[$j]->dob)){
                 if($studentbirthDate[$i]->dob != '0000-00-00' && $studentbirthDate[$i]->dob != ''){
               $student_dob = date('m-d',strtotime($studentbirthDate[$j]->dob));
                     if($student_dob == $current_date_month){
                       
                        $studentDob[$j] = $studentbirthDate[$j]->dob;
                     }  
               }
            }   
           }

           if(!empty($studentDob)){
            $data['studentsBirthday'] = $this->student->getStudentsBirthdayNotification($studentDob);
            }else{
                $data['studentDob'] =  '';
                $data['studentsBirthday'] = '';
                $data['studentbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                        No Birthdays Today!
                      </div>';
            }
                
                $start_date = date('d')+1;
            $end_date = date('d')+6;
            // log_message('debug','data'.print_r($end_date,true));
            $fromDate = date('m').'-'.$start_date;
            $toDate = date('m').'-'.$end_date;

            $staff_upcoming = array();
            $staffUpcomingBday =  $this->staff->getAllStaffInfo();

            for($i=0;$i<count($staffUpcomingBday);$i++) {
                $staff_up = date('m-d',strtotime($staffUpcomingBday[$i]->dob));
                if($staffUpcomingBday[$i]->dob != '0000-00-00' && $staffUpcomingBday[$i]->dob != ''){
                        if($staff_up >= $fromDate && $staff_up <= $toDate){
                            $staff_upcoming[$i] = $staffUpcomingBday[$i]->staff_id;
                        }
                        }
           }

           if(!empty($staff_upcoming)){
            $data['staffUpcomingBday'] = $this->staff->getStaffBirthdayInfoById($staff_upcoming);
            }else{
                $data['staff_upcoming'] =  '';
                $data['staffUpcomingBday'] = '';
                $data['staffUpcomingbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                        No Upcoming Birthdays!
                      </div>';
            }

            $student_upcoming = array();
       $studentUpcomingBday = $this->student->getstudentInfo();
        for($j=0;$j<count($studentUpcomingBday);$j++) {
            if(!empty($studentUpcomingBday[$j]->dob)){
           $student_up = date('m-d',strtotime($studentUpcomingBday[$j]->dob));
                 if($student_up >= $fromDate && $student_up <= $toDate){
                   
                    $student_upcoming[$j] = $studentUpcomingBday[$j]->dob;
                    
                 }
            }

       }

       if(!empty($student_upcoming)){
        $data['studentUpcomingBday'] = $this->student->getStudentsBirthdayNotification($student_upcoming);

        }else{
            $data['student_upcoming'] =  '';
            $data['studentUpcomingBday'] = '';
            $data['studentUpcomingbirthdayMsg'] = '<div class=" p-1 mb-0" role="alert">
                    No Upcoming Birthdays!
                  </div>';
        }
    
        if($this->role == ROLE_TEACHING_STAFF){
            $filter['role'] = 'Staff';
            $filter['role_one'] = 'ALL';
        }
        $this->load->library('pagination');
        $newsCount = $this->staff->getNewsFeedCount($filter);
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
       // log_message('debug','count'.print_r($returns,true));
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        $data['from_date'] = $from_date = $this->security->xss_clean($this->input->post('from_date'));
     $data['to_date'] = $to_date = $this->security->xss_clean($this->input->post('to_date'));
     if(empty($from_date)){
         $from_date = date('Y-m-d');
         $to_date = date('Y-m-d');
        
     }
     
     $data['from_date'] = $from_date;
     $data['to_date'] = $to_date;
 
     $data['fees_paid'] = $this->fee->getTotalPaidAmountByDate($from_date,$to_date);
     $data['mis_paid'] = $this->fee->getTotalMisAmountByDate($from_date,$to_date);
  
       // $newsCount = $this->staff->getNewsFeedCount($filter);
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
       // $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        // foreach($data['newsInfo'] as $news){
        //     $news->isLiked=$this->staff->isLiked($news->row_id,$this->session->userdata('staff_id'));
        //     $news->totalLikes=$this->staff->totalLikes($news->row_id);
        // }
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Teaching Staff Dashboard';
        $this->loadViews("adminDashboard", $this->global, $data, null);
    }

    public function viewMyProfile($active = "details")
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $data['staffInfo'] = $this->staff->getStaffInfoForProfile($this->staff_id);
            $data["active"] = $active;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View My Profile';
            $this->loadViews("profile/viewProfile", $this->global, $data, null);
        }
    }

    
    public function updateProfileImage(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
                $image_path="";
                $staffInfo = array();
                $config=['upload_path' => './upload/',
                'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                }

                if(!empty($image_path)){
                    $staffInfo['photo_url'] = $image_path;
                    $result = $this->staff->updateStaff($staffInfo, $row_id);
                }
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'Pofile Image Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Pofile Updation failed');
                }
                redirect('viewMyProfile/'.$active);  
            // }
        }
    }
    
    /**
     * This function is used to check whether email already exist or not
     */
    public function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {echo ("true");} else {echo ("false");}
    }
    /**
     * Page not found : error 404
     */
    public function pageNotFound()
    {
        $this->global['pageTitle'] = ''.TAB_TITLE.' : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    public function loginHistoy($userId = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $userId = ($userId == null ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');
            $data["userInfo"] = $this->user_model->getUserInfoById($userId);
            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            $this->load->library('pagination');
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);
            $returns = $this->paginationCompress("login-history/" . $userId . "/", $count, 10, 3);
            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : User Login History';
            $this->loadViews("loginHistory", $this->global, $data, null);
        }
    }

    /**
     * This function is used to show users profile
     */
    public function profile($active = "details")
    {
        $data["staffInfo"] = $this->user_model->getStaffInfoWithRole($this->staff_id);
        $data["active"] = $active;
        $this->global['pageTitle'] = $active == "details" ? ''.TAB_TITLE.' : My Profile' : ''.TAB_TITLE.' : Change Password';
        $this->loadViews("profile", $this->global, $data, null);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    public function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

        if ($this->form_validation->run() == false) {
            $this->profile($active);
        } else {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));

            $staffInfo = array('name' => $name, 'mobile' => $mobile, 'updated_by' => $this->staff_id, 'modified_date_time' => date('Y-m-d H:i:s'));

            $result = $this->user_model->editStaff($staffInfo, $this->staff_id);

            if ($result == true) {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Profile update failed');
            }

            redirect('profile/' . $active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    public function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == false) {
            $this->viewMyProfile($active);
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('viewMyProfile/' . $active);
            } else {
                $usersData = array('password' => getHashedPassword($newPassword), 'updated_by' => $this->vendorId,
                    'modified_date_time' => date('Y-m-d H:i:s'));
                $result = $this->user_model->changePassword($this->staff_id, $usersData);

                if ($result > 0) {$this->session->set_flashdata('success', 'Password updated successfully');} else { $this->session->set_flashdata('error', 'Password update failed');}

                redirect('viewMyProfile/' . $active);
            }
        }
    }

    public function changePasswordAdmin($row_id)
    {
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[30]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('success', 'Password Miss match');
        } else {
            $newPassword = $this->input->post('newPassword');          
            if (empty($newPassword)) {
                $this->session->set_flashdata('nomatch', 'Your new password is not correct');
               
            } else {
                $usersData = array('password' => getHashedPassword($newPassword), 'updated_by' => $this->staff_id,
                    'modified_date_time' => date('Y-m-d H:i:s'));
                $result = $this->user_model->changePasswordAdmin($row_id, $usersData);

                if ($result > 0) {$this->session->set_flashdata('success', 'Password Updated successfully');} else { $this->session->set_flashdata('error', 'Password update failed');
                }
                //redirect('faculty/viewStaffInfoById/' . $active);
            }
        }

        $data['active'] = "";
        $data['staffInfo'] = $this->staff->getStaffInfoById($row_id);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : View Staff Details';
        $this->loadViews("staffs/staffProfile", $this->global, $data, null);
    }

    // dashboard news feed
    
    public function addNewsFeed(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('visibility_type','Visibility','trim|required');
            $this->form_validation->set_rules('subject','Subject','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('facultyDashboard');  
            } else {
              
                $uploadPath = 'upload/news_feed/';
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $image_path="";
                $config=['upload_path'=> $uploadPath,
                'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx','overwrite' => TRUE,
                'file_ext_tolower' => TRUE,];  
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $config['image_library'] = 'gd2';
                    $config['maintain_ratio'] = TRUE;
                    $config['source_image'] = $uploadPath.$data['raw_name'].$data['file_ext'];
                    $config['new_image'] = $uploadPath.$data['raw_name'].$data['file_ext'];
                    $config['width'] = 550;
                    $config['height'] = 450;

                    //load resize library
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    //Thumbnail Image Upload - End

                        $image_path = $config['source_image'];

                }

                $visibility_type = $this->security->xss_clean($this->input->post('visibility_type'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $subject = $this->security->xss_clean($this->input->post('subject'));
                $description = $this->security->xss_clean($this->input->post('description'));
            
                $newsInfo = array(
                    'term_name' => $term_name,
                    'subject' => $subject,
                    'photo_url' => $image_path,
                    'description' => $description,
                    'date' => date('Y-m-d H:i:s'), 
                    'created_by'=>$this->staff_id, 
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->staff->addNewsFeed($newsInfo);

                if($result > 0){
                    $roleInfo = array(
                        'rel_news_row_id ' => $result,
                        'visible_type' => $visibility_type,
                        'created_by'=>$this->staff_id, 
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result_one = $this->staff->addNewsFeedVisibleType($roleInfo);
                }
                
                $filter['term_name'] = $this->input->post("term_name");

                $title = $subject;
                $body = $description;

                if(strtoupper($visibility_type)=="STUDENT"){
                    $this->sendPushNotificationToStudents($title,$body,$filter);
                }else if(strtoupper($visibility_type)=="STAFF"){
                    $this->sendPushNotificationToAllStaffs($title,$body);
                }else{
                    $this->sendPushNotificationToStudents($title,$body);
                    $this->sendPushNotificationToAllStaffs($title,$body);
                }
                
                if($result_one > 0) {
                    $this->session->set_flashdata('success', 'News Feed Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'News Feed Update failed');
                }
                redirect('facultyDashboard');  
            }
        }
    }
    
    
    public function deleteNewsFeed(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->staff->updateNewsInfo($newsInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {
                echo (json_encode(array('status' => true)));
                $roleInfo = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
                );
                $this->staff->updateNewsRoleInfo($roleInfo, $row_id);
            } else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function likeNewsFeed(){
        if($this->input->server('REQUEST_METHOD') === "POST"){
            if(is_null($this->input->post('data'))){
                echo "ERROR";
            }else{
                echo $this->staff->newsFeedLike($this->input->post('data'), $this->session->userdata('staff_id'));    
            }
        }

    }
    public function disLikeNewsFeed(){
        if($this->input->server('REQUEST_METHOD') === "POST"){
            if(is_null($this->input->post('data'))){
                echo "ERROR";
            }else{
                echo $this->staff->newsFeedDisLike($this->input->post('data'), $this->session->userdata('staff_id'));    
            }
        }
    }

    private function sendPushNotificationToAllStaffs($title,$body){
        $all_users_token = $this->push_notification_model->getAllStaffsToken();
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],USER_TYPE_STAFF);
        }
        $this->session->set_flashdata('success','Notification sent..!'); 
    }

    private function sendPushNotificationToStudents($title,$body,$filters=array()){
        $all_users_token = $this->push_notification_model->getStudentsToken($filters);
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],USER_TYPE_STUDENT);
        }
        $this->session->set_flashdata('success','Notification sent..!'); 
    }





    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        $PCMS = array("33", "34", "35", '31');
        $PCBH = array("33", "34", "36", '67');
        //commarce
        $BEBA = array("75", "22", "27", '30');
        $BSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $EBAC = array("41", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $HEPS = array("21", "22", "29", '28');

        $PEBA = array("29", "22", "27", '30');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
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
            case "PCBH":
                return $PCBH;
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
            case "HEBA":
                return $HEBA;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "HEPE":
                return $HEPE;
                break;
        }
    }


}
?>