<?php if (!defined('BASEPATH')) {
exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Attendance extends BaseController {
public function __construct()
{
    parent::__construct();
    $this->load->library('excel');
    $this->load->model('staff_model','staff');
    $this->load->model('leave_model','leave');
    $this->load->model('studentAttendance_model','attendance');
    $this->load->model('settings_model','settings');
    $this->load->model('students_model','student');
    $this->load->model('push_notification_model');
    $this->load->model('holiday_model','holiday');
    $this->isLoggedIn();
}

public function getMyAttendanceInfoPage(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }else {
        $data_array_new = [];
        $date = date('Y-m-d',strtotime($this->input->post('date')));
        $dateInfo = $this->staff->getPunchDateByStaffId($this->staff_id);
        $late_count = 0;
        $punch_out_nill = 0;
      
        
        foreach($dateInfo as $staff) {
            $staff_data = $this->staff->getAllStaffAttendanceFromModel($this->staff_id,$staff->punch_date);
            if(!empty($staff_data->staff_id)){
                $check_in_compare = new DateTime(date("h:i:s",strtotime($staff_data->in_time)));
                $check_out_compare = new DateTime(date("h:i:s",strtotime($staff_data->out_time)));

                $check_in_compare_test = new DateTime(date("H:i:s",strtotime($staff_data->in_time)));

                $interval = $check_in_compare->diff($check_out_compare);
                if($staff_data->shift_code != 'OS' ){
                    if(!empty($staff_data->in_time)){

                        if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT'){
                            $desired_in_time = "8:30:00"; 
                        }else if($staff->department == 'SUPPORT STAFF'){
                            $desired_in_time = "8:15:00";  
                        }else{
                            $desired_in_time = "8:15:00";  
                        }

                        $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));

                        $time_diff = $check_in_compare_test->diff($in_time_rule);

                        if($time_diff->format('%R%i') <= 0){
                          $late_count++;
                        }
                    }else{
                        
                    }
                }
    
                if($staff_data->out_time == '00:00:00'){
                    $punch_out_nill++;
                }else{
                    $check_out = $staff_data->out_time;
                }
             
            }
       }
        $data['total_late'] = $late_count;
        $data['punch_out_nill'] = $punch_out_nill;
        $this->global['pageTitle'] = 'ST XAVIER SCHOOL : My Attendance Details ';
        $this->loadViews("staffs/viewMyAttendance", $this->global, $data, NULL);
    }
}

public function get_my_attendance_info(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
          $data_array_new = [];
          $date = date('Y-m-d',strtotime($this->input->post('date')));
          $dateInfo = $this->staff->getPunchDateByStaffId($this->staff_id);
          $late_count = 0;
          $punch_out_nill = 0;
        
          
          foreach($dateInfo as $staff) {
              $staff_data = $this->staff->getAllStaffAttendanceFromModel($this->staff_id,$staff->punch_date);
              if(!empty($staff_data->staff_id)){
                  $check_in_compare = new DateTime(date("H:i:s",strtotime($staff_data->in_time)));
                  $check_out_compare = new DateTime(date("H:i:s",strtotime($staff_data->out_time)));

                  $check_in_compare_test = new DateTime(date("H:i:s",strtotime($staff_data->in_time)));

                  $interval = $check_in_compare->diff($check_out_compare);
                  if($staff->shift_code != 'OS' ){
                    if(!empty($staff_data->in_time)){
                        $actual_in_time = new DateTime($staff->start_time);

                        if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT'){
                            $desired_in_time = "8:30:00"; 
                        }else if($staff->department == 'SUPPORT STAFF'){
                            $desired_in_time = "8:15:00";  
                        }else{
                            $desired_in_time = "8:15:00";  
                        }

                        $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));

                        $time_diff = $check_in_compare_test->diff($in_time_rule);
                        if($time_diff->format('%R%i') <= 0){
                            $in_time =  '<span style="color:red">'. $staff_data->in_time.'</span>';
                        }else{
                            $in_time =  '<span style="color:green">'. $staff_data->in_time.'</span>';
                        }
                    }else{
                        $in_time =  '<span style="color:red">AB</span>';
                    }
                }else{
                    if(!empty($staff_data->in_time)){
                        $in_time =  '<span style="color:green">'. $staff_data->in_time.'</span>';
                    }else{
                        $in_time =  '<span style="color:red">AB</span>';
                    }
                }
      
                    if($staff_data->out_time == '00:00:00'){
                        $check_out = '--';
                    }else{
                        $check_out = $staff_data->out_time;
                    }
                    if($staff_data->out_time != '00:00:00'){
                        $worked_hours = $interval->format('%h').':'.$interval->format('%s');
                     }else{
                        $worked_hours = '--';
                     }
                  $data_array_new[] = array(
                     date('d-m-Y',strtotime($staff->punch_date)),
                     $in_time,
                     $check_out,
                     $worked_hours
                );
              }else{
                  $data_array_new[] = array(
                      date('d-m-Y',strtotime($staff->punch_date)),
                      '<span style="color:red">AB</span>',
                      '<span style="color:red">AB</span>',
                      '<span style="color:red">--</span>',
                 );
              }
         }
        
        
         $count = count($dateInfo);
          $result = array(
               "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data_array_new,
           );
      echo json_encode($result);
      exit();
    } 
}

public function downloadStaffAttendanceReport(){
if($this->isAdmin() == TRUE)
{
    $this->loadThis();
} else {
    $date_from = $this->security->xss_clean($this->input->post('date_from'));
    $date_to = $this->security->xss_clean($this->input->post('date_to'));
    $department = $this->security->xss_clean($this->input->post('department'));
    $report_type = $this->security->xss_clean($this->input->post('report_type'));
    $sheet = 0;
    if($department == "ALL"){
        $department_list = $this->staff->getStaffDepartment();
    }else{
       
        $department_list = $this->staff->getStaffDepartmentById($department);
    }	
    setcookie('isDownloading', 0);
    foreach($department_list as $dept){
    $this->excel->setActiveSheetIndex($sheet);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle($dept->name);
    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
    //set Title content with some text
    $this->excel->getActiveSheet()->setCellValue('A1', "JOSEPH'S INDIAN PRIMARY SCHOOL");
    $this->excel->getActiveSheet()->setCellValue('A2', "STAFF ATTENDANCE INFORMATION 2024-25");
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    $this->excel->getActiveSheet()->mergeCells('A1:H1');
    $this->excel->getActiveSheet()->mergeCells('A2:H2');
    $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);

    $this->excel->getActiveSheet()->setCellValue('A3', "Date From: ".$date_from." Date To: ".$date_to);
    $this->excel->getActiveSheet()->mergeCells('A3:D3');
    $this->excel->getActiveSheet()->setCellValue('E3', "Report Type: ".$report_type);
    $this->excel->getActiveSheet()->mergeCells('E3:H3');
    $this->excel->getActiveSheet()->getStyle('E3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);


    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Date');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Staff ID');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Name');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Department');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Role');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'In-Time');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Out-Time');
   
    
    $this->excel->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setWrapText(true); 
    $this->excel->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true); 
    $this->excel->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $this->excel->getActiveSheet()->getStyle('A1:H4')->applyFromArray($styleBorderArray);
    $staffInfo = $this->staff->getAllStaffInfoByDeptName($dept->dept_id);
    $start_date = strtotime(date('Y-m-d',strtotime($date_from))); 
    $end_date = strtotime(date('Y-m-d',strtotime($date_to))); 
    $j=1;
    $excel_row = 5;
    foreach($staffInfo as $staff){
        for ($currentDate = $start_date; $currentDate <= $end_date; $currentDate += (86400)) { 
          
            $date_attendance = date('Y-m-d', $currentDate);
            $weekName = date('l', strtotime($date_attendance));
            if($weekName == 'Saturday' && $staff->roleId == ROLE_TEACHING_STAFF){
             continue;       
            }
            if($weekName == 'Sunday'){
                continue;
            }
            if($staff->shift_code == 'OS'){
                continue;
            }
            $attInfo = $this->staff->getSingleStaffAttendanceInfo($staff->staff_id,$date_attendance);
            if($report_type == 'absent_staff'){
                if(empty($attInfo)){
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($date_attendance)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->staff_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->department);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->role);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,"AB");
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,"AB");
                    
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':H'.$excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
            }else{
                if(!empty($attInfo)){
                    $in_time_punch = $attInfo->in_time;
                    $out_time_punch = $attInfo->out_time;
                    $out_time_null = false;
                    $write_excel_status = false;
                    if($report_type == 'absent_staff'){
                        if(empty($attInfo->punch_date)){
                            $write_excel_status = true;
                        }else{
                            $write_excel_status = false;
                        }
                    } else if($report_type == 'latecomer'){
                        $check_in_compare_test = new DateTime(date("H:i:s",strtotime($attInfo->in_time)));
                        if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT'){
                            $desired_in_time = "8:30:00"; 
                        }else if($staff->department == 'SUPPORT STAFF'){
                            $desired_in_time = "8:15:00";  
                        }else{
                            $desired_in_time = "8:15:00";  
                        }
                        $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));
                        $time_diff = $check_in_compare_test->diff($in_time_rule);
                        
                        if($time_diff->format('%R%i') < 0){
                        $write_excel_status = true;
                        }
                        if(empty($attInfo->punch_date)){
                            $write_excel_status = true;
                        }
                    } else if($report_type == 'no_punch_out'){
                        $check_in_rule = new DateTime(date("H:i:s",strtotime($attInfo->punch_time)));
                        $in_time_rule = new DateTime($attInfo->start_time);
                        $time_diff = $check_in_rule->diff($in_time_rule);
                        // if($time_diff->format('%R%i') == 0){
                        if($attInfo->out_time == "00:00:00"){
                        $write_excel_status = true;
                        $out_time_null = true;
                        }
                    }
                    
                    if($write_excel_status == true){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($date_attendance)));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->staff_id);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->department);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$attInfo->role);
                        if(empty($attInfo->punch_date)){
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,"AB");
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,"AB");
                        }else{
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$in_time_punch);
                            if($out_time_null == true){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,"--");
                            }else{
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$out_time_punch);
                            }
                        
                        }
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':H'.$excel_row)->applyFromArray($styleBorderArray);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        //$this->excel->getActiveSheet()->getStyle('D'.$excel_row.':F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $excel_row++;
                    }
                }
            }
        }
    }
    $this->excel->createSheet();
    $sheet++;
    }
    setcookie('isDownLoaded',0);  
    $filename='just_some_random_name.xls'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
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
}



public function deleteStaffAttendance(){
if ($this->isAdmin() == true) {
    echo (json_encode(array('status' => 'access')));
} else {
    $row_id = $this->input->post('row_id');
    $attData = $this->staff->getStaffAttendanceByRowId($row_id);
    $updateInfo = array('is_deleted' => 1, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
    $result = $this->staff->deleteStaffAttendanceInfo($attData->staff_id, $attData->punch_date, $updateInfo);
    if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
}
}


public function getAttendanceDetails(){
if($this->isAdmin() == TRUE) {
    $this->loadThis();
} else {
    $filter = array();
    $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));
    $todayDate = date('Y-m-d');
    $weekname = date('l', strtotime($todayDate));
    if(!empty($attendance_date)){
        $data['attendance_date'] = date('d-m-Y',strtotime($attendance_date));
        $filter['attendance_date'] = date('l',strtotime($attendance_date));
        $data['attendanceDate']= date('d-m-Y', strtotime($attendance_date));
        $filter['search_date'] = date('Y-m-d',strtotime($attendance_date));
    }else{
        $data['attendance_date'] = '';
        $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        $filter['weekName'] = $weekname;
        $filter['search_date'] = date('Y-m-d');
    }
    
    if($this->role == ROLE_TEACHING_STAFF){
        $filter['staff_id'] = $this->staff_id;
        $data['staff_id'] = $this->staff_id;
    }else{
        $data['staff_id'] = '';
    }

    $data['streamSectionInfo'] = $this->staff->getTermSectionByStaffId($filter);
   
    // $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
    $data['staffSubjectInfo'] = $this->staff->getAllSubjectInfo($filter);
  
    $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();

    // $isExists = $this->attendance->CheckTimetableDayShiftExists($filter);
    // if(!empty($isExists)){
    //     $filter['week'] = $isExists->week_name;
    //     $filter['attendance_date'] = $isExists->week_name;
    //     $count = $this->attendance->getShiftTimetableInfoCount($filter);
    //     $returns = $this->paginationCompress("getAttendanceDetails/", $count, 100);
    //     $data['attendanceInfo'] = $this->attendance->getShiftTimetableInfo($filter,$returns["page"], $returns["segment"]);
    // }else{
    //     $count = $this->attendance->getClassForAttendanceCount($filter);
    //     $returns = $this->paginationCompress("getAttendanceDetails/", $count, 100);
    //     $data['attendanceInfo'] = $this->attendance->getClassForAttendance($filter,$returns["page"], $returns["segment"]);
    // }
    
    // log_message('debug','dmkme='.print_r($data['attendanceInfo'],true));
    // $data['attendanceCount'] = $count;
    $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';
    $this->loadViews("attendance/attendance", $this->global, $data, NULL);
}
}

public function getStudentInfoForAttendance(){
if($this->isAdmin() == TRUE) {
    $this->loadThis();
} else {
    $filter = array();
    $term_name = $this->security->xss_clean($this->input->post('term_name'));
    
    $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
    $section_name = $this->security->xss_clean($this->input->post('section_name'));
    $subject_code = $this->security->xss_clean($this->input->post('subject_code'));
    $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));
    $time_row_id = $this->security->xss_clean($this->input->post('time_row_id'));
    $section_row_id = $this->security->xss_clean($this->input->post('section_row_id'));
    $staff_subject_row_id = $this->security->xss_clean($this->input->post('staff_subject_row_id'));

     
    $filter['time_row_id'] = $time_row_id;
    $filter['section_row_id'] = $section_row_id;
    $filter['staff_subject_row_id'] = $staff_subject_row_id;
    $sectionInfo = $this->attendance->getSectionInfoByRowId($filter);
    $subjectInfo = $this->attendance->getSubjectByRowId($filter);
    $sectionName = $section_name;

    $filter['term_name'] = $term_name;
    $filter['subject_name'] = $subjectInfo->sub_name;
    if($sectionName == "ALL"){
        $filter['section_name'] = '';
    }else{
        $filter['section_name'] = $sectionName;
    }


    $data['attendance_date'] = $attendance_date;
    $data['term_name'] = $term_name;
    $data['subject_name'] = $subjectInfo->sub_name;
    $data['section_name'] = $sectionName;
    $data['subject_code'] = $subjectInfo->subject_code;
    $data['subject_type'] = $subjectInfo->subject_type;
    $data['time_row_id'] = $time_row_id;
    $data['section_row_id'] = $section_row_id;
    $data['staff_subject_row_id'] = $staff_subject_row_id;
    $data['staff_id'] = $this->staff_id;
    $data['studentRecord'] = $this->student->getStudentInfoForInternalAttendance($filter);
    $data['classCompletedInfo'] = $this->attendance->checkClassCompletedInfo(date('Y-m-d',strtotime($attendance_date)),$subjectInfo->subject_code,$time_row_id,$term_name,$sectionName);
    $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';
    $this->loadViews("attendance/takeAttendance", $this->global, $data, NULL);
}
}

public function addSingleSubjectAttendanceByStaff(){
if ($this->isAdmin() == true) {
    $this->loadThis();
} else {
    $filter = array();
    $registerNos = array();
    $attInfo = json_decode(stripslashes($this->input->post('attInfo')));
    $students = array();
    foreach($attInfo as $info){
        if($info->name == 'staff_subject_row_id'){
            $staff_subject_row_id = $info->value;
        }
        if($info->name == 'attendance_date'){
            $attendance_date = $info->value;
        }

      
        if($info->name == 'term_name'){
            $term_name = $info->value;
        }
        
        if($info->name == 'section_name'){
            $section_name = $info->value;
        }

        if($info->value == true){
            $students[$info->name] = $info->name;
        }
        
    }

    $attendanceDate = date("Y-m-d", strtotime($attendance_date));
    $filter['term_name'] = $term_name;
    $filter['admission_no'] = $students;
    $sectionName = $section_name; 
    if($section_name == "ALL"){
        $filter['section_name'] = '';
    }else{
        $filter['section_name'] = $sectionName;
    }
           
    
    $isExistsClass = $this->attendance->getclassCompletedInfo($attendanceDate,$this->staff_id,$term_name,$section_name);
    if($isExistsClass == NULL){
        $subInfo = array(
            'date' => $attendanceDate,
            // 'subject_code' => $subject_code,
            'staff_id' => $this->staff_id,
            'term_name' => $term_name,
            'section_name' => $section_name,
            // 'subject_type' => $subject_type,
            'created_date_time' => date('Y-m-d H:i:s'),
            'created_by' => $this->staff_id);
        $result = $this->attendance->addStaffTeachedSubjectInfo($subInfo);
        $class_row_id = $result;

    }else{
        $subInfo = array(
            'term_name' =>$term_name,
            'section_name' =>$section_name,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
        $result = $this->attendance->updateStaffTeachedSubjectInfo($this->staff_id,$attendanceDate,$subInfo,$term_name,$section_name);
        $class_row_id = $isExistsClass->row_id;

    }
    $deletedInfo = $this->attendance->getDeletingStudents($attendanceDate,$term_name,$section_name);
    $deletedRegNo = array();
    foreach($deletedInfo as $info){
        array_push($deletedRegNo,$info->sat_number);  
    }
    $this->attendance->deleteAllStudents($attendanceDate,$term_name,$section_name);       
    $data['studentRecords'] = $this->student->getStudentInfoForInternalAttendance($filter);
    //$this->attendance->getStudentInfoForAttendance($filter);
    foreach($data['studentRecords'] as $student){
        if($students[$student->row_id] == $student->row_id){
            $attendanceInfo = array (
                'term_name' => $term_name,
                'section_name' => $section_name,
                'class_row_id' => $class_row_id,
                'student_id' => $student->row_id,
                'absent_date' => $attendanceDate,
                'office_verified_status' => 0,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s'));
            $result =  $this->attendance->addAbsentStudentInfo($attendanceInfo);
            if(!in_array($student->sat_number, $deletedRegNo)){
                array_push($registerNos,$student->sat_number);    
            }
        }
    }
    if($result > 0){
        $this->absentStudentNotification($registerNos);
        echo 'true';
    }else{
        echo 'false';
    }
}
}

public function viewAttendanceInfo() {
if($this->isAdmin() == TRUE) {
    $this->loadThis();
} else {        
    $filter = array();
    // $searchTerm = $this->security->xss_clean($this->input->post('searchTerm'));
    $absentDate =$this->security->xss_clean($this->input->post('absentDate')); 
    $staff_name =$this->security->xss_clean($this->input->post('staff_name')); 
    $student_id =$this->security->xss_clean($this->input->post('student_id')); 
    $subject_id =$this->security->xss_clean($this->input->post('subject_id')); 
    $subject_type =$this->security->xss_clean($this->input->post('subject_type')); 
    $time = $this->security->xss_clean($this->input->post('time')); 
    $by_term = $this->security->xss_clean($this->input->post('by_term'));
    $by_name = $this->security->xss_clean($this->input->post('by_name'));
    $section_name = $this->security->xss_clean($this->input->post('section_name'));
    $date_from_filter = $this->security->xss_clean($this->input->post('date_from_filter'));
            $date_to_filter = $this->security->xss_clean($this->input->post('date_to_filter'));
    if($this->role == ROLE_TEACHING_STAFF ){
        $filter['staff_id'] = $this->staff_id;
        $data['subjectInfo'] = $this->staff->getAllSubjectInfo($filter);
    }else{
        // $data['subjectInfo'] = $this->subject->getAllSchoolSubjectInfo();
    }
    // $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
    // $data['staffInfo'] = $this->staff->getDistinctSubjectInfo($filter);
    // $data['streamInfo'] = $this->settings->getDistinctStreamInfo();

    if(!empty($absentDate)){
        $filter['absentDate'] = date('Y-m-d',strtotime($absentDate));
        $data['absentDate'] = date('d-m-Y',strtotime($absentDate));
    }else{
        $data['absentDate'] = '';
    }

    if(!empty($date_from_filter)){
        $filter['date_from_filter'] = date('Y-m-d',strtotime($date_from_filter));
        $data['date_from_filter'] = $date_from_filter;
    }else{
       $data['date_from_filter'] = date('Y-m-d');
        $filter['date_from_filter'] = date('Y-m-d');
    }


     
    if(!empty($date_to_filter)){
        $filter['date_to_filter'] = date('Y-m-d',strtotime($date_to_filter));
        $data['date_to_filter'] = $date_to_filter;
    }else{
        $data['date_to_filter'] = date('Y-m-d');
        $filter['date_to_filter'] = date('Y-m-d');
    }
    $data['staff_name'] = $staff_name;
    $data['student_id'] = $student_id;
    $data['by_term'] =  $by_term;
    $data['by_name'] =  $by_name;
    $data['subject_id'] = $subject_id;
    $data['subject_type'] = $subject_type;
    $data['time'] = $time;
    $data['section_name'] = $section_name;

    $filter['staff_name'] = $staff_name;
    $filter['student_id'] = $student_id;
    $filter['by_term']= $by_term;
    $filter['by_name'] =  $by_name;
    $filter['subject_id'] = $subject_id;
    $filter['subject_type'] = $subject_type;
    $filter['time'] = $time;
    $filter['section_name'] = $section_name;
    
    $count = $this->attendance->viewAttendanceInfoCount($filter);
    $returns = $this->paginationCompress("viewAttendanceInfo/", $count, 100);
    $data['count_attendance'] = $count;
    $data['attendanceRecords'] = $this->attendance->getViewAttendanceInfo($filter, $returns["page"], $returns["segment"]);
     $data['termInfo'] = $this->student->getTermInfo();
    $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Management';
    $this->loadViews("attendance/viewAbsentInfo", $this->global, $data , NULL);
}
}

public function deleteStudentAttendance(){
if($this->isAdmin() == TRUE){
    $this->loadThis();
} else {   
    $row_id = $this->input->post('row_id');
    $attendanceInfo = array('is_deleted' => 1,
    'updated_date_time' => date('Y-m-d H:i:s'),
    'updated_by' => $this->staff_id);
    $result = $this->attendance->updateAttendanceInfo($row_id,$attendanceInfo);
    if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
} 
}

public function downloadClassCompletedReport(){
if($this->isAdmin() == TRUE)
{
    $this->loadThis();
} else {   
    set_time_limit(0);
    $term_name = $this->security->xss_clean($this->input->post('term_name'));
    $section_name = $this->security->xss_clean($this->input->post('section_name')); 
    $date_from = $this->security->xss_clean($this->input->post('date_from'));
    $date_to = $this->security->xss_clean($this->input->post('date_to'));
    $filter = array();
    $filter['term'] = $term_name;
    $filter['term_name'] = $term_name;
    if(!empty($date_from)){
        $filter['date_from'] = date('Y-m-d',strtotime($date_from));
    }
    if(!empty($date_to)){
        $filter['date_to'] = date('Y-m-d',strtotime($date_to));
    }
    // $stream = $this->timetable->getAssignedStreamInfo($filter)
    // if($section_name == 'ALL'){
    //     $sectionName = array('A','B','C','D','E','F','G','H','I','J');
    // }else{
        // $sectionName = $section_name;
    // }
    $filter['section_name'] = $section_name;
    
    $sections = array($section_name);
    if(!empty($date_from) && !empty($date_to)){
        $date_description = $date_from .' To '. $date_to;
    }else{
        $date_description = "Upto Today Date";
    }

    $class_held_cell_name = array("E","H","K","N","Q","T");
    $class_attended_cell_name = array("F","I","L","O","R","U");
    $class_percentage_cell_name = array("G","J","M","P","S","V");

    // $stream = $this->students_model->getStreamNameBySectionAndTerm($term_name,$section_name);
    $subject_info_header = $this->attendance->getSubjectWithTermStream($subject,$term_name,$section_name);
    $subject_info_header = $this->getSubjectCodes($stream_name);
    $sheet = 0;
    $j=1;
    $excel_row = 6;
    $class_section = $section_name[$sheet];
    $this->excel->setActiveSheetIndex($sheet);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle($stream_name);
    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:W500');
    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
    $this->excel->getActiveSheet()->setCellValue('A2', $term_name.'-'. $stream_name.'-'.$section_name." Section Attendance Report 2020-21");
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    $this->excel->getActiveSheet()->mergeCells('A1:W1');
    $this->excel->getActiveSheet()->mergeCells('A2:W2');
    $this->excel->getActiveSheet()->getStyle('A1:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);


    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(7);

    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(7);

    

    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Roll No');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'LAG');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('W3', 'OA.%');

    $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setWrapText(true); 
    $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true); 
    $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


    $this->excel->getActiveSheet()->mergeCells('A3:A4');
    $this->excel->getActiveSheet()->mergeCells('B3:B4');
    $this->excel->getActiveSheet()->mergeCells('C3:C4');
    $this->excel->getActiveSheet()->mergeCells('D3:D4');

    $this->excel->getActiveSheet()->mergeCells('W3:W4');

    

    //first elective subject
    $this->excel->getActiveSheet()->mergeCells('E3:G3');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Language');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'CH');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'CA');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'A%');

    //english subject
    $this->excel->getActiveSheet()->mergeCells('H3:J3');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'ENGLISH');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'CH');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'CA');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'A%');
    $s=2;
    for($sub=0; $sub<count($subject_info_header); $sub++){
        $subject_name = $this->subject->getAllSubjectByID($subject_info_header[$sub]);
        $this->excel->getActiveSheet()->getColumnDimension($class_held_cell_name[$s])->setWidth(7);
        $this->excel->getActiveSheet()->getColumnDimension($class_attended_cell_name[$s])->setWidth(7);
        $this->excel->getActiveSheet()->getColumnDimension($class_percentage_cell_name[$s])->setWidth(7);
        $this->excel->getActiveSheet()->mergeCells($class_held_cell_name[$s].'3:'.$class_percentage_cell_name[$s].'3');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_held_cell_name[$s].'3', $subject_name->sub_name);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_held_cell_name[$s].'4', 'CH');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_attended_cell_name[$s].'4', 'CA');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_percentage_cell_name[$s].'4', 'A%');
    $s++;
    }
    $this->excel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $this->excel->getActiveSheet()->getStyle('A3:W4')->getFont()->setBold(true);
    
    $this->excel->getActiveSheet()->mergeCells('A5:W5');
    $this->excel->getActiveSheet()->getStyle('A5:W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A5:W5')->getFont()->setBold(true);
    $this->excel->getActiveSheet()->setCellValue('A5', "Report Date: ".$date_description);


    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $this->excel->getActiveSheet()->getStyle('A1:W4')->applyFromArray($styleBorderArray);

    // $students = $this->students_model->getStudentInfoBySectionTerm($term_name,$section_name);
    $students = $this->student->getStudentInfoForReportDownload($filter);
    // log_message('debug','dnd='.print_r($students,true));
    foreach($students as $student){
        // log_message('debug','dnd='.print_r($student->section_name,true));
        $section = $student->section_name;
        $filter['section'] = $section;
        $subjects_code = array();
        $percentage_active = false;
        $elective_sub = strtoupper($student->elective_sub);
    
        if($elective_sub == 'KANNADA'){
            array_push($subjects_code, '01');
        }else if($elective_sub == 'HINDI'){
            array_push($subjects_code, '03');
        } else if($elective_sub == 'FRENCH'){
            array_push($subjects_code, '12');
        }
        array_push($subjects_code, '02');
        $subjects = $this->getSubjectCodes($student->stream_name);
        $subjects_code = array_merge($subjects_code,$subjects);
        $total_class_held_per_std = 0;
        $total_attd_class_std = 0;
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$student->student_id);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->student_name);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$elective_sub);
        for($i=0; $i < count($subjects_code); $i++)
        {
            // if($student->term_name == 'I PUC' && $date_from == ""){
            //     $date_from = $student->date_of_admission; 
            // }
            
            $class_held = 0;
            $class_attended = 0;
            $absent_count = 0;
            $subInfo = $this->subject->getAllSubjectByID($subjects_code[$i]);
           
            $type="THEORY";
            $class_held += $this->attendance->getClassInfoAttendanceReportStudent($subjects_code[$i],$filter,$type);
            // log_message('debug','dnd='.print_r($class_held,true));
            $data['classHeldDate'] = $this->attendance->getTotalClassHeldByStaff($subjects_code[$i],$filter,$type);
            // log_message('debug','classHeldDate='.print_r($data['classHeldDate'],true));
            
            foreach($data['classHeldDate'] as $classdata){
                $absent_count_theory = $this->attendance->isStudentIsAbsentForClass($student->student_id,$subjects_code[$i],$classdata->date,$type);
                
                if($absent_count_theory != NULL){
                    $absent_count += 1;
                }
            
            }
        
            
            //no change
            $total_class_held_per_std += $class_held;
            $total_attd_class_std += $absent_count;
            
            if($class_held != 0){
                $avg = ($class_held-$absent_count)/$class_held;
                $percentage = round($avg*100, 2);
            }else{
                $percentage = 0;
            }
            if(!empty($percentage_sort)){
                if($percentage <= $percentage_sort){
                    $percentage_active = true;
                }
            }
            //writing result to excel cell
            

            $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_held_cell_name[$i].$excel_row,$class_held);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_attended_cell_name[$i].$excel_row,$class_held-$absent_count);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_percentage_cell_name[$i].$excel_row,$percentage);
                
        }
        //total subject percentage
    
        if($total_class_held_per_std != 0){
            $avg = ($total_class_held_per_std-$total_attd_class_std)/$total_class_held_per_std;
            $percentage = round($avg*100, 2);
        }else{
            $percentage = 0;
        }
        
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row,$percentage);
        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':W'.$excel_row)->applyFromArray($styleBorderArray);
        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':W'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        if(!empty($percentage_sort)){
            if($percentage_active == true){
                $excel_row++;
            }else{
                $this->excel->getActiveSheet()->removeRow($excel_row);
            }
        }else{
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row,$percentage);
            $excel_row++;
        }
        
        
    }
    
    $filename='just_some_random_name.xls'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
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
}

public function viewClassCompletedInfo() {
if($this->isAdmin() == TRUE) {
    $this->loadThis();
} else {        
    $filter = array();
    $classDate =$this->security->xss_clean($this->input->post('classDate')); 
    $staff_id =$this->security->xss_clean($this->input->post('staff_id')); 
    $subject_code =$this->security->xss_clean($this->input->post('subject_code')); 
    $subject_id =$this->security->xss_clean($this->input->post('subject_id')); 
    $subject_type =$this->security->xss_clean($this->input->post('subject_type')); 
    $time = $this->security->xss_clean($this->input->post('time')); 
    $by_term = $this->security->xss_clean($this->input->post('by_term'));
    $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
    $section_name = $this->security->xss_clean($this->input->post('section_name'));
    $filter['subject_code'] = '';
    $subjectCode = array();
    if($this->role == ROLE_TEACHING_STAFF ){
        $filter['staff_id'] = $this->staff_id;
        $staff_sub = $this->staff->getAllSubjectInfo($filter);
        $data['subjectInfo'] = $staff_sub;
        foreach($staff_sub as $sub){
            array_push($subjectCode,$sub->subject_code);
        } 
        $filter['subject_code'] = $subjectCode;
    }else{
        // $data['subjectInfo'] = $this->subject->getAllSchoolSubjectInfo();
        $subject_code = $subject_code;
        $filter['subject_code'] = $subject_code;
    }
    // $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
    $data['staffInfo'] = $this->staff->getAllSubjectInfo($filter);
    // $data['streamInfo'] = $this->settings->getDistinctStreamInfo();
    $data['termInfo'] = $this->student->getTermInfo();


    if(!empty($classDate)){
        $filter['classDate'] = date('Y-m-d',strtotime($classDate));
        $data['classDate'] = date('d-m-Y',strtotime($classDate));
    }else{
        $data['classDate'] = '';
    }
    $data['staff_id'] = $staff_id;
    $data['subject_code'] = $subject_code;
    $data['by_term'] =  $by_term;
    $data['subject_id'] = $subject_id;
    $data['subject_type'] = $subject_type;
    $data['time'] = $time;
    $data['stream_name'] = $stream_name;
    $data['section_name'] = $section_name;

    $filter['by_term']= $by_term;
    $filter['subject_id'] = $subject_id;
    $filter['subject_type'] = $subject_type;
    $filter['time'] = $time;
    $filter['stream_name'] = $stream_name;
    $filter['section_name'] = $section_name;
    $filter['staffId'] = $staff_id;
    $count = $this->attendance->getAllClassCompletedInfoCount($filter);
    $returns = $this->paginationCompress("viewClassCompletedInfo/", $count, 100);
    $data['classCount'] = $count;
    $data['classRecord'] = $this->attendance->getAllClassCompletedInfo($filter, $returns["page"], $returns["segment"]);
    $this->global['pageTitle'] = ''.TAB_TITLE.' : My Class Completed';
    $this->loadViews("attendance/classCompleted", $this->global, $data , NULL);
}
}

public function deleteClassCompleted(){
if($this->isAdmin() == TRUE){
    $this->loadThis();
} else {   
    $row_id = $this->input->post('row_id');
    $classCompletedInfo = array('is_deleted' => 1,
    'updated_date_time' => date('Y-m-d H:i:s'),
    'updated_by' => $this->staff_id);
    $result = $this->attendance->updateClassCompletedInfo($row_id, $classCompletedInfo);
    if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
} 
}

public function downloadAbsentedStudentInfo(){
if($this->isAdmin() == TRUE)
{
    setcookie('isDownLoaded',0);  
    $this->loadThis();
} else
{   
    set_time_limit(0);
    $class = $this->security->xss_clean($this->input->post('term_name'));
    $section_name = $this->security->xss_clean($this->input->post('section_name')); 
    $date_from = $this->security->xss_clean($this->input->post('date_from'));
    $date_to = $this->security->xss_clean($this->input->post('date_to'));
   
    $sections = array($section_name);
    if(!empty($date_from) && !empty($date_to)){
        $date_description = $date_from .' To '. $date_to;
    }else{
        $date_description = "Upto Today Date";
    }
 
    // $stream = $this->student->getStreamNameBySectionAndTerm($term_name,$section_name);
    $filter = array();
    // $filter['by_term'] = $class;
    if(!empty($date_from)){
        $filter['absentDateFrom'] = date('Y-m-d',strtotime($date_from));
    }
    if(!empty($date_to)){
        $filter['absentDateTo'] = date('Y-m-d',strtotime($date_to));
    }
    if($section_name == 'ALL'){
        $filter['section_name'] = '';
    }else{
        $filter['section_name'] = $section_name;
    }
    if($class == 'ALL'){
        $filter['by_term'] = '';
    }else{
        $filter['by_term'] = $class;
    }
    // $subject_info_header = $this->getSubjectCodes($stream_name);
    $sheet = 0;
    $j=1;
    $excel_row = 6;
    $section_name = $sections[$sheet];
    $this->excel->setActiveSheetIndex($sheet);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle($class);
    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
    $this->excel->getActiveSheet()->setCellValue('A2', $class.'-'.$section_name." Attendance Report 2022");
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
    $this->excel->getActiveSheet()->mergeCells('A1:F1');
    $this->excel->getActiveSheet()->mergeCells('A2:F2');

    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
     $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

    
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Date');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Sat No');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Name');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Class');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Section');
    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Staff');
    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Subject');
    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Time');
    $this->excel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setWrapText(true); 
    $this->excel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true); 
    $this->excel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A3:W4')->getFont()->setBold(true);
    
    $this->excel->getActiveSheet()->setCellValue('A3', "Report Date: ".$date_description);
    $this->excel->getActiveSheet()->mergeCells('A3:F3');
    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $this->excel->getActiveSheet()->getStyle('A1:F4')->applyFromArray($styleBorderArray);
    $this->excel->getActiveSheet()->getStyle('A5:F999')->applyFromArray($styleBorderArray);
   
    $students = $this->attendance->getAbsentedStudentInfo($filter);
    $excel_row = 5;
    foreach($students as $student){
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($student->absent_date)));
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->student_id);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$student->student_name);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$student->term_name);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->section_name);
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->staff_name);
        
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$student->sub_name);
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$student->start_time .'-'.$student->end_time);
        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel_row++;
    }
    $filename='just_some_random_name.xls'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    ob_end_clean();
    ob_start();
    setcookie('isDownLoaded',0);  
    $objWriter->save('php://output');
    
}
}



public function downloadClassCompletedStudentInfo(){
if($this->isAdmin() == TRUE)
{
    setcookie('isDownLoaded',0);  
    $this->loadThis();
} else
{   
    set_time_limit(0);
    $class = $this->security->xss_clean($this->input->post('term_name'));
    $section_name = $this->security->xss_clean($this->input->post('section_name')); 
    $date_from = $this->security->xss_clean($this->input->post('date_from'));
    $date_to = $this->security->xss_clean($this->input->post('date_to'));
   
    $sections = array($section_name);
    if(!empty($date_from) && !empty($date_to)){
        $date_description = $date_from .' To '. $date_to;
    }else{
        $date_description = "Upto Today Date";
    }
 
    // $stream = $this->student->getStreamNameBySectionAndTerm($term_name,$section_name);
    $filter = array();
    // $filter['by_term'] = $class;
    if(!empty($date_from)){
        $filter['completedDateFrom'] = date('Y-m-d',strtotime($date_from));
    }
    if(!empty($date_to)){
        $filter['completedDateTo'] = date('Y-m-d',strtotime($date_to));
    }
    if($section_name == 'ALL'){
        $filter['section_name'] = '';
    }else{
        $filter['section_name'] = $section_name;
    }
    if($class == 'ALL'){
        $filter['by_term'] = '';
    }else{
        $filter['by_term'] = $class;
    }
    // $subject_info_header = $this->getSubjectCodes($stream_name);
    $sheet = 0;
    $j=1;
    $excel_row = 6;
    $section_name = $sections[$sheet];
    $this->excel->setActiveSheetIndex($sheet);
    //name the worksheet
    $this->excel->getActiveSheet()->setTitle($class);
    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
    $this->excel->getActiveSheet()->setCellValue('A2', $class.'-'.$section_name." Class Completed Report 2022");
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
    $this->excel->getActiveSheet()->mergeCells('A1:D1');
    $this->excel->getActiveSheet()->mergeCells('A2:D2');

    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

    
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Date');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Class');
    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Section');
    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Staff');
    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Subject');
    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Time');
    $this->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setWrapText(true); 
    $this->excel->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true); 
    $this->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $this->excel->getActiveSheet()->getStyle('A3:W4')->getFont()->setBold(true);
    
    $this->excel->getActiveSheet()->setCellValue('A3', "Report Date: ".$date_description);
    $this->excel->getActiveSheet()->mergeCells('A3:D3');
    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    $this->excel->getActiveSheet()->getStyle('A1:D4')->applyFromArray($styleBorderArray);
    $this->excel->getActiveSheet()->getStyle('A5:D999')->applyFromArray($styleBorderArray);
   
    $students = $this->attendance->getClassCompletedStudentInfo($filter);
    $excel_row = 5;
    foreach($students as $student){
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($student->date)));
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->term_name);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$student->section_name);
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->staff_name);
        
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$student->sub_name);
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$student->start_time .'-'.$student->end_time);
        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel_row++;
    }
    $filename='just_some_random_name.xls'; //save our workbook as this file name
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    ob_end_clean();
    ob_start();
    setcookie('isDownLoaded',0);  
    $objWriter->save('php://output');
    
}
}

function absentStudentNotification($admissionNos){
    $title = 'Absent For Class';
    $attachmentURL = '';
        //FCM////////////
        for($i=0;$i<count($admissionNos);$i++){
            $studentInfo = $this->student->getStudentInfoBySatNumber($admissionNos[$i]);
            $body = 'Dear Parent, your ward '.$studentInfo->student_name.' is absent for class on '.date('d-m-Y');
            $all_users_token = $this->push_notification_model->getSingleStudentsToken($admissionNos[$i]);
            $tokenBatch = array_chunk($all_users_token,500);
            for($itr = 0; $itr < count($tokenBatch); $itr++){
                $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],"student");
            }
            // $this->push_notification_model->sendIndividualPushNotification($title,$body,$admissionNos[$i],$attachmentURL);
        }
        //FCM///////////
}

public function downloadStaffAttendanceMonthlyReportPdf(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    } else {
      ini_set('max_execution_time', 0);
        $date_format_db = "Y-m-d";
        $interval = new DateInterval('P1D'); // 1 Day interval
      // $interval_year = new DateInterval('P1D');
       $staff_name = 'ALL STAFF';
        $date_from = $this->security->xss_clean($this->input->post('date_from'));
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $department = $this->security->xss_clean($this->input->post('department'));
        $report_type = "MONTHLY";
        $staff_id = $this->security->xss_clean($this->input->post('by_staff_id_report'));
        $shift_code = $this->security->xss_clean($this->input->post('shift_code'));
        $sheet = 0;
  
        if($shift_code == ""){
          $shift_name = 'ALL';
        }else{
        //   $staffShiftInfo = $this->staff->getStaffShiftByCode($shift_code);
        //   $shift_name = $staffShiftInfo->name;
        }	
        if($department == "ALL"){
          
            $department_list = $this->staff->getStaffAllDepartmentInfoForReport();
        }else{
            $department_list = $this->staff->getStaffDepartmentById($department);
        }	

        if($staff_id != "ALL"){
          $single_staff_info = $this->staff->getStaffInfoForProfile($staff_id);
          $staff_name = $single_staff_info->name;
          $department_list = $this->staff->getStaffDepartmentById($single_staff_info->dept_id); 

        }
        $data['department_list'] = $department_list;
        $data['shift_code'] = $shift_code;
        $data['staff_id'] = $staff_id;
        $data['interval'] = $interval;
        $data['report_type'] = $report_type;
        if(!empty($date_from)){
          $data['date_from'] = $date_from;
        }else{
          $data['date_from'] = '';
        }
        if(!empty($date_to)){
          $data['date_to'] = $date_to;
        }else{
          $data['date_to'] = '';
        }
        
        foreach($department_list as $dept){
          $staffInfo[$dept->dept_id] = $this->staff->getAllStaffInfoByDeptIdReport($dept->dept_id,$staff_id);
          // foreach($staffInfo[$dept->dept_id] as $staff){
          //       $holiday[$staff->roleId] = $this->holiday->getHolidayInfoByRole($staff->roleId);
          // }

        }
        
        // log_message('debug','dcndj'.print_r($holiday,true));
        
        $data['start_date'] = strtotime(date('Y-m-d',strtotime($date_from))); 
        $data['end_date'] = strtotime(date('Y-m-d',strtotime($date_to))); 
  
        $data['staffInfo'] = $staffInfo;
        // $data['holiday'] = $holiday;
        $data['holiday_model']= $this->holiday;
        $data['staff_model']= $this->staff;
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'helvetica','format' => 'A4-L',
        'pagenumPrefix' => 'Page number ',]);
        $mpdf->SetTitle('Attendance Monthly Report');
        $html = $this->load->view('report/attendanceMonthlyReport',$data,true);
        $mpdf->setFooter('{PAGENO}');
        $mpdf->AddPage('L','','','','',10,10,20,20,15,15);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Monthly_report.pdf', 'I');
      //  ob_end_clean();
  
    
    }
  }

    //getstaff attaendance view page
    function getStaffAttendanceInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else {
            $search_date = $this->input->post('dateSearch');
            if(!empty($search_date)){
                $date = date('Y-m-d',strtotime($search_date));
                $data['searchDate'] = date('d-m-Y',strtotime($search_date));
            }else{
                $data['searchDate'] = date('d-m-Y');
                $date = date('Y-m-d');
            }
            $late_count_teaching_staff = 0;
            $absent_count_teaching_staff = 0;
            $no_punch_count_teaching_staff = 0;
            $late_count_non_teaching_staff = 0;
            $no_punch_count_non_teaching_staff = 0;
            $absent_count_non_teaching_staff = 0;
            $late_count_support_staff = 0;
            $absent_count_support_staff = 0;
            $no_punch_count_support_staff = 0;
            $on_time_staff_total = 0;
            $staffInfo = $this->staff->getAllCurrentStaffInfo();
            foreach($staffInfo as $staff) {
                $staff_data = $this->staff->getAllStaffAttendanceFromModel($staff->staff_id,$date);
                if(!empty($staff_data->staff_id)){
                    $check_in_compare = new DateTime(date("h:i:s",strtotime($staff_data->in_time)));
                    $check_out_compare = new DateTime(date("h:i:s",strtotime($staff_data->out_time)));
                    $check_in_compare_test = new DateTime(date("H:i:s",strtotime($staff_data->in_time)));

                    $interval = $check_in_compare->diff($check_out_compare);
                    if($staff->shift_code != 'OS' ){
                        if(!empty($staff_data->in_time)){
                            if(date('l', strtotime($date)) == 'Saturday'){
                                if($staff_data->role_id == ROLE_SUPPORT_STAFF){
                                    $time = strtotime($staff_data->start_time);
                                    $startTime = date("H:i:s", strtotime('+30 minutes', $time));
                                    $actual_in_time = new DateTime($startTime);
                                    if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT' || $staff->role == 'Office' || $staff->department == 'OFFICE STAFF'){
                                        $desired_in_time = "8:30:00"; 
                                    }else if($staff->department == 'SUPPORT STAFF'){
                                        $desired_in_time = "8:15:00";  
                                    }else{
                                        $desired_in_time = "8:15:00";  
                                    }
                                    $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));
                                    $time_diff = $check_in_compare_test->diff($in_time_rule);
                                }else{
                                    $actual_in_time = new DateTime($staff_data->start_time);
                                    if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT' || $staff->role == 'Office' || $staff->department == 'OFFICE STAFF'){
                                        $desired_in_time = "8:30:00"; 
                                    }else if($staff->department == 'SUPPORT STAFF'){
                                        $desired_in_time = "8:15:00";  
                                    }else{
                                        $desired_in_time = "8:15:00";  
                                    }
                                    $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));
                                    $time_diff = $check_in_compare_test->diff($in_time_rule);
                                }
                            }else{
                                $actual_in_time = new DateTime($staff_data->start_time);
                                if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT' || $staff->role == 'Office' || $staff->department == 'OFFICE STAFF'){
                                    $desired_in_time = "8:30:00"; 
                                }else if($staff->department == 'SUPPORT STAFF'){
                                    $desired_in_time = "8:15:00";  
                                }else{
                                    $desired_in_time = "8:15:00";  
                                }
                                $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));
                                $time_diff = $check_in_compare_test->diff($in_time_rule);
                            }
                            if($time_diff->format('%R%i') <= 0){
                                if($staff_data->role_id == ROLE_TEACHING_STAFF){
                                    $late_count_teaching_staff++;
                                }else if($staff_data->role_id == ROLE_NON_TEACHING_STAFF || $staff_data->role_id == ROLE_ADMIN || $staff_data->role_id == ROLE_PRIMARY_ADMINISTRATOR ){
                                    $late_count_non_teaching_staff++;
                                }else if($staff_data->role_id == ROLE_SUPPORT_STAFF){
                                    $late_count_support_staff++;
                                }else{
                                    $late_count_non_teaching_staff++;
                                }
                            }else{
                                $on_time_staff_total++;
                            }
                          
                                if($staff_data->out_time == '00:00:00'){
                                    if($staff_data->role_id == ROLE_TEACHING_STAFF){
                                        $no_punch_count_teaching_staff++;
                                    }else if($staff_data->role_id == ROLE_NON_TEACHING_STAFF || $staff_data->role_id == ROLE_ADMIN || $staff_data->role_id == ROLE_PRINCIPAL || $staff_data->role_id == ROLE_PRIMARY_ADMINISTRATOR || $staff_data->role_id == ROLE_ACCOUNTS|| $staff_data->role_id == ROLE_LIBRARY || $staff_data->role_id == ROLE_OFFICE|| $staff_data->role_id == ROLE_COUNSELOR){
                                        $no_punch_count_non_teaching_staff++;
                                    }else if($staff_data->role_id == ROLE_SUPPORT_STAFF){
                                        $no_punch_count_support_staff++;
                                    }else{
                                        $no_punch_count_non_teaching_staff++;
                                    }
                                }
                        }else{
                            if(date('l', strtotime($date)) != 'Sunday'){
                                if($staff_data->role_id == ROLE_TEACHING_STAFF){
                                    $absent_count_teaching_staff++;
                                }else if($staff_data->role_id == ROLE_NON_TEACHING_STAFF || $staff_data->role_id == ROLE_ADMIN || $staff_data->role_id == ROLE_PRINCIPAL || $staff_data->role_id == ROLE_PRIMARY_ADMINISTRATOR || $staff_data->role_id == ROLE_ACCOUNTS|| $staff_data->role_id == ROLE_LIBRARY || $staff_data->role_id == ROLE_OFFICE|| $staff_data->role_id == ROLE_COUNSELOR){
                                    $absent_count_non_teaching_staff++;
                                }else if($staff_data->role_id == ROLE_SUPPORT_STAFF){
                                    $absent_count_support_staff++;
                                }else{
                                    $absent_count_non_teaching_staff++;
                                }
                                }
                            }
                        
                    }else{
                        if(empty($staff_data->in_time)){
                            if(date('l', strtotime($date)) != 'Sunday'){
                                if($staff_data->role_id == ROLE_TEACHING_STAFF){
                                    $absent_count_teaching_staff++;
                                }else if($staff_data->role_id == ROLE_NON_TEACHING_STAFF || $staff_data->role_id == ROLE_ADMIN || $staff_data->role_id == ROLE_PRINCIPAL || $staff_data->role_id == ROLE_PRIMARY_ADMINISTRATOR || $staff_data->role_id == ROLE_DIRECTOR || $staff_data->role_id == ROLE_ACCOUNTS|| $staff_data->role_id == ROLE_LIBRARY || $staff_data->role_id == ROLE_OFFICE|| $staff_data->role_id == ROLE_COUNSELOR){
                                    $absent_count_non_teaching_staff++;
                                }else if($staff_data->role_id == ROLE_SUPPORT_STAFF){
                                    $absent_count_support_staff++;
                                }else{
                                    $absent_count_non_teaching_staff++;
                                }
                            }
                        }
                
                    }
                }else{
                    if($staff->role_id == ROLE_TEACHING_STAFF){
                        $absent_count_teaching_staff++;
                    }else if($staff->role_id == ROLE_NON_TEACHING_STAFF || $staff->role_id == ROLE_ADMIN || $staff->role_id == ROLE_PRINCIPAL || $staff->role_id == ROLE_PRIMARY_ADMINISTRATOR || $staff->role_id == ROLE_DIRECTOR || $staff->role_id == ROLE_ACCOUNTS|| $staff->role_id == ROLE_LIBRARY || $staff->role_id == ROLE_OFFICE|| $staff->role_id == ROLE_COUNSELOR){
                        $absent_count_non_teaching_staff++;
                    }else if($staff->role_id == ROLE_SUPPORT_STAFF){
                        $absent_count_support_staff++;
                    }else{
                        $absent_count_non_teaching_staff++;
                    }
                }
        }
        $analysis_count = array(
            'late_count_teaching_staff' => $late_count_teaching_staff,
            'late_count_non_teaching_staff' => $late_count_non_teaching_staff,
            'late_count_support_staff' => $late_count_support_staff,

            'absent_count_teaching_staff' => $absent_count_teaching_staff,
            'absent_count_non_teaching_staff' => $absent_count_non_teaching_staff,
            'absent_count_support_staff' => $absent_count_support_staff,

            'no_punch_count_teaching_staff' => $no_punch_count_teaching_staff,
            'no_punch_count_non_teaching_staff' => $no_punch_count_non_teaching_staff,
            'no_punch_count_support_staff' => $no_punch_count_support_staff,

        );
            $data['analysis_count'] = $analysis_count;
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['staffInfo'] = $this->staff->getAllCurrentStaffInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staff Attendance Details ';
            $this->loadViews("staffs/staffAttendanceInfo", $this->global, $data, NULL);
        }
    }

    //get all staff attendance
    public function get_attendance()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
            $data_array_new = [];
            $date = date('Y-m-d',strtotime($this->input->post('date')));
            $staffInfo = $this->staff->getAllCurrentStaffInfo();
        
            
            foreach($staffInfo as $staff) {
                $editButton = " ";
                $deleteButton = "";
                $staff_data = $this->staff->getAllStaffAttendanceFromModel($staff->staff_id,$date);
                if(!empty($staff_data->staff_id)){
                    $deleteButton = "";
                    $updateButton = "";
                    $editButton = "";
                    $check_in_compare = new DateTime(date("h:i:s",strtotime($staff_data->in_time)));
                    $check_out_compare = new DateTime(date("h:i:s",strtotime($staff_data->out_time)));

                    $check_in_compare_test = new DateTime(date("H:i:s",strtotime($staff_data->in_time)));

                    $interval = $check_in_compare->diff($check_out_compare);
                    if($staff->shift_code != 'OS' ){
                        if(!empty($staff_data->in_time)){
                            $actual_in_time = new DateTime($staff->start_time);

                            if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT'){
                                $desired_in_time = "8:30:00"; 
                            }else if($staff->department == 'SUPPORT STAFF'){
                                $desired_in_time = "8:15:00";  
                            }else{
                                $desired_in_time = "8:15:00";  
                            }

                            $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));

                            $time_diff = $check_in_compare_test->diff($in_time_rule);
                            if($time_diff->format('%R%i') <= 0){
                                $in_time =  '<span style="color:red">'. $staff_data->in_time.'</span>';
                            }else{
                                $in_time =  '<span style="color:green">'. $staff_data->in_time.'</span>';
                            }
                        }else{
                            $in_time =  '<span style="color:red">AB</span>';
                        }
                    }else{
                        if(!empty($staff_data->in_time)){
                            $in_time =  '<span style="color:green">'. $staff_data->in_time.'</span>';
                        }else{
                            $in_time =  '<span style="color:red">AB</span>';
                        }
                    }

                    if($staff_data->out_time == '00:00:00'){
                        $check_out = '--';
                    }else{
                        $check_out = $staff_data->out_time;
                    }
                    if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                        $deleteButton = '<a class="btn btn-xs btn-danger deleteStaffAttendance" href="#"
                        data-row_id="'.$staff_data->row_id.'" title="Delete Attendance"><i
                            class="fa fa-trash"></i></a>';
                        $editButton = '<button onclick="editStaffAttendance('.$staff_data->row_id.')" class="btn btn-xs btn-info"
                        title="Edit Attendance"><i
                            class="fa fa-edit"></i></button>';
                    }

                    $data_array_new[] = array(
                    date('d-m-Y',strtotime($date)),
                    $staff->staff_id,
                    $staff->name,
                    $staff->department,
                    $staff->role,
                    $in_time,
                    $check_out,
                    //    $staff->shift_name,
                    $editButton.' '.$deleteButton,
                );
                }else{
                    $data_array_new[] = array(
                        date('d-m-Y',strtotime($date)),
                        $staff->staff_id,
                        $staff->name,
                        $staff->department,
                        $staff->role,
                        '<span style="color:red">AB</span>',
                        '<span style="color:red">AB</span>',
                        // $staff->shift_name,
                        $editButton.' '.$deleteButton,
                );
                }
        }
        $count = count($staffInfo);
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data_array_new
            );
        echo json_encode($result);
        exit();
    }
    public function addNewStaffAttendance(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('attendance_staff_id','Staff Name','trim|required');
            $this->form_validation->set_rules('new_date','Attendance Date','trim|required');
            $this->form_validation->set_rules('check_in_hh', 'Check In', 'trim|required|numeric|min_length[2]');
            $this->form_validation->set_rules('check_in_mm', 'Check In', 'trim|required|numeric|min_length[2]');
            $this->form_validation->set_rules('check_in_ss', 'Check In', 'trim|required|numeric|min_length[2]');
            
            if($this->form_validation->run() == FALSE){
                redirect('getStaffAttendanceInfo');  
            }else{
                $staff_id = $this->security->xss_clean($this->input->post('attendance_staff_id'));
                $new_date =$this->security->xss_clean($this->input->post('new_date')); 
                $check_in_hh =$this->security->xss_clean($this->input->post('check_in_hh')); 
                $check_in_mm =$this->security->xss_clean($this->input->post('check_in_mm')); 
                $check_in_ss =$this->security->xss_clean($this->input->post('check_in_ss')); 
                $check_out_hh =$this->security->xss_clean($this->input->post('check_out_hh')); 
                $check_out_mm =$this->security->xss_clean($this->input->post('check_out_mm')); 
                $check_out_ss =$this->security->xss_clean($this->input->post('check_out_ss')); 
        
                $punch_in_time = $check_in_hh.":".$check_in_mm.":".$check_in_ss;
                $punch_out_time = $check_out_hh.":".$check_out_mm.":".$check_out_ss;

                $punch_date = date('Y-m-d',strtotime($new_date));

                if($check_out_hh == '00' && $check_out_mm == '00' && $check_out_ss == '00'){
                    $attendance_type = 'CheckIn' ;
                    $punch_out_date = '0000:00:00';
                }else if(!empty($check_out_hh && $check_out_mm && $check_out_ss)){
                    $attendance_type = 'CheckOut' ;
                    $punch_out_date = $punch_date;
                }else{
                    $attendance_type = 'CheckIn' ;
                    $punch_out_date = '0000:00:00';
                }
                $attendance_time = strtotime($punch_date.$punch_in_time);
                $attInfoCheckIn = array(
                    'service_tag_id' => 'manual_check_in',
                    'staff_id' => $staff_id,
                    'attendance_time' => $attendance_time,
                    'punch_time' => $punch_in_time,
                    'punch_date' => $punch_date,
                    'punch_out_time' => $punch_out_time,
                    'punch_out_date' => $punch_out_date,
                    'attendance_type' => $attendance_type,
                    'created_date_time' =>date('Y-m-d H:i:s'),
                );
                $attendance_time = strtotime($punch_date.' '.$punch_out_time);
                $result = $this->staff->addNewStaffAttendance($attInfoCheckIn);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Staff Attendance Added successfully');
                }else{
                    $this->session->set_flashdata('error', 'Staff Attendance Add failed');
                }
                redirect('getStaffAttendanceInfo');  
            }

        }
    }
    public function getStaffAttendanceInfoByDate_Staff_Id(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }
        else{
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $date = $this->security->xss_clean($this->input->post('date')); 
            $result = $this->staff->getAllStaffAttendanceDisplay($staff_id,date('Y-m-d',strtotime($date)));
            echo json_encode($result);
            exit();
        }
    }
    public function updateStaffAttendance(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        }else{

                $punch_date =$this->security->xss_clean($this->input->post('punch_date')); 
                $check_in_hh =$this->security->xss_clean($this->input->post('check_in_hh')); 
                $check_in_mm =$this->security->xss_clean($this->input->post('check_in_mm')); 
                $check_in_ss =$this->security->xss_clean($this->input->post('check_in_ss')); 
                $check_out_hh =$this->security->xss_clean($this->input->post('check_out_hh')); 
                $check_out_mm =$this->security->xss_clean($this->input->post('check_out_mm')); 
                $check_out_ss =$this->security->xss_clean($this->input->post('check_out_ss')); 
                $row_id = $this->input->post('staff_attendance_row_id'); 
                $attendanceInfo = $this->staff->getStaffAttendanceInfoByRowId($row_id);

        
                if(!empty($check_in_hh && $check_in_mm && $check_in_ss)){
                    $punch_in_time = $check_in_hh.":".$check_in_mm.":".$check_in_ss;
                    $attendance_type = 'CheckIn' ;
                  }else{
                    $punch_in_time = $attendanceInfo->punch_time;
                     $attendance_type = 'CheckIn' ;
                  }
                  if($check_out_hh == '00' && $check_out_mm == '00' && $check_out_ss == '00'){
                    $attendance_type = 'CheckIn' ;
                    $punch_out_date = '0000:00:00';
                  }else if(!empty($check_out_hh && $check_out_mm && $check_out_ss)){
                    $punch_out_time = $check_out_hh.":".$check_out_mm.":".$check_out_ss;
                    $attendance_type = 'CheckOut' ;
                    $punch_out_date = $attendanceInfo->punch_date;
                  }else{
                    $punch_out_time = $attendanceInfo->punch_out_time;
                    $attendance_type = 'CheckIn' ;
                    $punch_out_date = '0000:00:00';
                  }
                  
                  $updateInfo = array(
                      'service_tag_id' => 'manual_updated',
                      'updated_by' => $this->staff_id,
                      'punch_time' => $punch_in_time,
                      'attendance_type' => $attendance_type,
                      'punch_out_date' => $punch_out_date,
                      'punch_out_time' => $punch_out_time,
                      'updated_date_time' =>date('Y-m-d H:i:s'),
                  );
                 
                  $result = $this->staff->updateStaffAttendanceByID($row_id, $updateInfo);

                if($result > 0){
                    $this->session->set_flashdata('success', 'Staff Attendance Updated successfully');
                }else{
                    $this->session->set_flashdata('error', 'Staff Attendance Update failed');
                }
                redirect('getStaffAttendanceInfo');  
        }
    }
}
?>