<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Timetable extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('staff_model','staff');
        $this->load->model('settings_model','settings');
        $this->load->model('timetable_model','timetable');
        $this->isLoggedIn();   
    }

    function timeTableDetails() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $data['streamDetail'] = $this->settings->getDistinctStreamInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Time Table';
            $this->loadViews("timetable/timetable", $this->global,$data, NULL);
        }
    }

    public function get_class(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $data_array_new = [];
            $classInfo = $this->settings->getSectionInfo();
            foreach($classInfo as $class) {
                $editButton = "";
                $deleteButton = "";
                $addTimeTable = "";
            
                if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_TEACHING_STAFF  
                || $this->role == ROLE_OFFICE || $this->role == ROLE_PRINCIPAL || $this->role == ROLE_VICE_PRINCIPAL){
                    
                    $addTimeTable = '<a class="btn btn-xs btn-success"
                    href="'.base_url().'addTimeTable/'.$class->row_id.'" title="Add">
                    <i class="material-icons">access_time</i> Time Table</a>';
                }  

                $data_array_new[] = array(
                    $class->term_name,
                    $class->stream_name,
                    $class->section_name,
                    $class->class_type,
                    $class->name,
                    $addTimeTable.' '.$editButton.' '.$deleteButton
                );
            }
            $count = count($classInfo);
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

    public function addTimeTable($row_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('timeTableDetails');
            }
            $data['classInfo'] = $this->timetable->getSectionInfoById($row_id);
            $data['staffInfo'] = $this->staff->getAllTeachingStaff();
            $data['classTimingsInfo'] = $this->timetable->getClassTimingsforWeekDays(); 
            $data['weekName'] = $this->timetable->getWeekDayNames();
            $data['timingsInfo'] = $this->timetable->getClassTimingsforWeekend(); 
            $data['weekInfo'] = $this->timetable->getWeekendNames();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Time Table';
            $this->loadViews("timetable/addTimetable", $this->global,$data, NULL);
        }
    }

    public function addTimeTableToDB(){ 
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $class_stream_id = $this->input->post('class_stream_id');
            $time_id = $this->input->post('time_id');
            $week_name_id = $this->input->post('week_name_id');
            $subject_type_row_id = $this->security->xss_clean($this->input->post('subject_name'));

                $timeTableInfo = array(
                    'time_row_id' => $time_id, 
                    'week_name_row_id' => $week_name_id, 
                    'staff_subjects_row_id' => $subject_type_row_id,
                    'section_info_row_id' => $class_stream_id, 
                    'time_year'=> date('Y'),
                    'created_by' => $this->staff_id, 
                    'created_date_time' => date('Y-m-d H:i:s'));
                
                $result = $this->timetable->addTimeTable($timeTableInfo);
                
                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Subject Added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to Add Subject');
                }

                redirect('addTimeTable/'.$class_stream_id);
              
        }  
    }

    // get staff assigned subject 
    public function getAssignedSubjects(){
        $staff_id = $this->input->post("staff_id");
        $data['result'] = $this->staff->getAllSubjectByStaffId($staff_id);
        header('Content-type: text/plain'); 
        header('Content-type: application/json'); 
        echo json_encode($data);
        exit(0);
    }

    // get staff subject info
    public function getStaffSubjectInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $staff_id = $this->input->post("staff_id");
            $data['result'] = $this->timetable->getAllStaffSubjectInfo($staff_id);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    // get class timings based on week
    public function getClassTimimgsByWeekId(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $week_id = $this->input->post("week_id");
            if($week_id != 6){
                $week_id = 1;
            }else{
                $week_id = $week_id;
            }
            $data['result'] = $this->timetable->getTimeByRowID($week_id);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }
    
    public function deleteClassInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $classInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->timetable->updateClassSubject($classInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addMultipleTimeTable(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $term = $this->security->xss_clean($this->input->post('term'));
            if(!empty($term)){
                $filter['term'] = $term;
            }

            $data['streamData'] = $this->timetable->getAssignedStreamInfo($filter);
            $data['staffInfo'] = $this->staff->getAllTeachingStaff();
            $data['streamInfo'] = $this->settings->getDistinctStreamInfo();
            $data['allWeekName'] = $this->timetable->getAllWeekName();

            $data['classTimingsInfo'] = $this->timetable->getClassTimingsforWeekDays(); 
            $data['weekName'] = $this->timetable->getWeekDayNames();
            $data['timingsInfo'] = $this->timetable->getClassTimingsforWeekend(); 
            $data['weekInfo'] = $this->timetable->getWeekendNames();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Time Table';
            $this->loadViews("timetable/addMultipleTimeTable", $this->global,$data, NULL);
        }
    }
    
    public function addMultipleTimeTableToDB(){ 
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $time_id = $this->input->post('time_id');
            $week_name_id = $this->input->post('week_name_id');
            $stream_section_id = $this->input->post('stream_section_id');
            $subject_type_row_id = $this->security->xss_clean($this->input->post('subject_name'));
            $term = $this->security->xss_clean($this->input->post('term'));

            if(!empty($term)){
                $filter['term'] = $term;
            }

            $data['streamData'] = $this->timetable->getAssignedStreamInfo($filter);

            for($i=0;$i<count($stream_section_id);$i++){
                $streamName = $stream_section_id[$i];

                    $timeTableInfo = array(
                        'time_row_id' => $time_id, 
                        'week_name_row_id' => $week_name_id, 
                        'staff_subjects_row_id' => $subject_type_row_id,
                        'section_info_row_id' => $stream_section_id[$i], 
                        'created_by' => $this->staff_id, 
                        'time_year'=> date('Y'),
                        'created_date_time' => date('Y-m-d H:i:s'));
                        // log_message('debug','tdv=='.print_r($timeTableInfo,true));
                    $result = $this->timetable->addTimeTable($timeTableInfo);
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
            
        }  
    }


    // stream and section info
    function classStreamDetails()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_section = $this->security->xss_clean($this->input->post('by_section'));
            $by_class_type = $this->security->xss_clean($this->input->post('by_class_type'));
            $by_class_teacher = $this->security->xss_clean($this->input->post('by_class_teacher'));
            if(!empty($by_term)){
                $filter['by_term'] = $by_term;
                $data['searchTerm'] = $by_term;
            }else{
                $data['searchTerm'] = '';
            }
            if(!empty($by_stream)){
                $filter['by_stream'] = $by_stream;
                $data['searchStream'] = $by_stream;
            }else{
                $data['searchStream'] = '';
            }
            if(!empty($by_section)){
                $filter['by_section'] = $by_section;
                $data['searchSection'] = $by_section;
            }else{
                $data['searchSection'] = '';
            }
            if(!empty($by_class_type)){
                $filter['by_class_type'] = $by_class_type;
                $data['by_class_type'] = $by_class_type;
            }else{
                $data['by_class_type'] = '';
            }
            if(!empty($by_class_teacher)){
                $filter['by_class_teacher'] = $by_class_teacher;
                $data['by_class_teacher'] = $by_class_teacher;
            }else{
                $data['by_class_teacher'] = '';
            }

            $data['staffInfo'] = $this->staff->getAllTeachingStaff();
            $data['streamInfo'] = $this->settings->getDistinctStreamInfo();
            $this->load->library('pagination');
            //$count = $this->settings->getSectionCount($filter);
            // $returns = $this->paginationCompress ( "classStreamDetails/", $count, 8);
            // $filter['page'] = $returns["page"];
            // $filter['segment'] = $returns["segment"];
            // $data['totalStudyMaterial'] = $count;
            $data['sectionInfo'] = $this->settings->getSectionInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Class & Stream Details';
            $this->loadViews("streamAndSection/stream", $this->global, $data, NULL);
        }
    }
    
    public function addSection(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $stream_id =$this->security->xss_clean($this->input->post('stream'));
            $term_name =$this->security->xss_clean($this->input->post('term_name'));
            $section =$this->security->xss_clean($this->input->post('section'));
            $class_type =$this->security->xss_clean($this->input->post('class_type'));
            $class_teacher =$this->security->xss_clean($this->input->post('class_teacher'));
            $isExist = $this->settings->checkSectionExists($section,$stream_id,$term_name);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Section already exists!');
                redirect('classStreamDetails');
            }else{
                $sectionInfo = array('section_name'=>$section,
                    'stream_id'=>$stream_id,
                    'term_name'=>$term_name,
                    'class_type'=>$class_type,
                    'class_teacher'=>$class_teacher,
                    'year'=>date('Y'),
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addSection($sectionInfo);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Section Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Section creation failed');
                }
                redirect('classStreamDetails');
            }
        }
    }
    public function deleteSection(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $sectionInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSection($sectionInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }



    function getFormInformation3(){
        $streamName = $this->security->xss_clean($this->input->post('streamName'));
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
        $filter = array();
        $filter['by_term'] = $term_name;
        $filter['by_stream'] = $streamName;

        $data['subjectInfo'] = $this->settings->getSectionInfo($filter);
        //$data['courseInfo']= $this->settings->getAllCourseInfo();
        header('Content-type: text/plain'); 
        // set json non IE
        header('Content-type: application/json'); 
        echo json_encode($data);
        exit(0);
    }

}
?>