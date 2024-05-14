<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App_staff_login extends CI_Model
{
    function checkMobNo($mblNumber)
    {
        log_message('debug', 'model_mbl_number' . print_r($mblNumber, true));
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
        $user = $query->row();
        return $user;
    }

    function fetchStaffDetails($mblNumber)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.staff_id,staff.row_id,staff.user_name,staff.type,staff.mobile_one,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.qualification,staff.blood_group,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.is_deleted', 0);
        $this->db->group_start();
        $this->db->where('staff.mobile_one', $mblNumber);
        $this->db->or_where('staff.mobile_two', $mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result();
    }

    function getStaffName($staff_id)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select('staff.name');
        $this->db->from('tbl_staff as staff');

        $this->db->where('staff.is_deleted', 0);

        $this->db->where('staff.staff_id', $staff_id);

        $query = $this->db->get();
        return $query->result();
    }

    function fetchLeaveMangementInfo($staffID)
    {
        $this->db->from('tbl_staff_leave_management');
        $this->db->where('is_deleted', 0);
        $this->db->where('staff_id', $staffID);
        $query = $this->db->get();
        return $query->result();
    }

    public function applyLeaveInsert($info)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_applied_leave', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getLeaveHistory($staff_id)
    {
        $this->db->from('tbl_staff_applied_leave');
        $this->db->where('staff_id', $staff_id);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('created_date_time', 'desc'); // Sort by created_date_time in descending order
        $query = $this->db->get();
        return $query->result();
    }

    function getApproveLeaveList($staff_id)
    {
        $this->db->from('tbl_staff_applied_leave');
        $this->db->where('staff_id !=', $staff_id); // Modified line
        $this->db->order_by('created_date_time', 'desc'); // Sort by created_date_time in descending order
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function cancellLeave($leaveRowId, $info)
    {
        $this->db->where('row_id', $leaveRowId);
        $this->db->update('tbl_staff_applied_leave', $info);
        return 1;
    }

    function dashboardInfo()
    {
        // $this->db->select('menu.row_id,menu.title,menu.route,menu.icon,menu.primary_color,menu.secondary_color,menu.sub_menu,menu.is_weburl');
        $this->db->from('tbl_staff_dashboard_menu as menu');
        // $this->db->join('app_menu_restrict as rest','rest.menu_id=menu.row_id','left');
        $this->db->where('menu.is_deleted', 0);
        $this->db->order_by('menu.priority', 'ASC');
        // $this->db->where('rest.student_id',$student_id);
        $query = $this->db->get();
        return $query->result();
    }

    // public function getSUmOFUsedLeave($application_no){
    //     $this->db->select('SUM(leave.paid_amount) as paid_amount');
    //     $this->db->from('tbl_staff_applied_leave as leave');
    //     $this->db->where('fee.is_deleted', 0);
    //     $this->db->where('fee.application_no', $application_no);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    public function getLeaveUsedSum($staff_id, $type)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.leave_type', $type);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.approved_status', 1);
        // $this->db->where('leave.date_from >=', LEAVE_DATE_FROM);
        // $this->db->where('leave.date_to <=', LEAVE_DATE_TO);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSumLeaveInfo($staff_id, $type)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.leave_type', $type);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where_in('leave.approved_status', [0, 1]); // Include both approved statuses
        // $this->db->where('leave.date_from >=', LEAVE_DATE_FROM);
        // $this->db->where('leave.date_to <=', LEAVE_DATE_TO);
        $query = $this->db->get();
        return $query->row();
    }

    function approveLeaveUpdate($leaveRowId, $info)
    {
        $this->db->where('row_id', $leaveRowId);
        $this->db->update('tbl_staff_applied_leave', $info);
        return 1;
    }

    public function checkDeviceExists($staffID, $device_id)
    {
        $this->db->from('tbl_staff_token');
        $this->db->where('staff_id', $staffID);
        $this->db->where('device_id', $device_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function updateToken($device_id, $info)
    {
        $this->db->where('device_id', $device_id);
        $this->db->update('tbl_staff_token', $info);
        return 1;
    }

    function addToken($info)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_token', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getAttendance($staff_id)
    {
        // Get current date in 'YYYY-MM-DD' format
        $current_date = date('Y-m-d');
        $this->db->from('tbl_staff_attendance_info as attendance');
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('attendance.staff_id', $staff_id);
        // Add condition to check for the current date
        $this->db->where('DATE(attendance.punch_date)', $current_date);
        $query = $this->db->get();
        return $query->result();
    }


    function getAttendanceList($staff_id)
    {
        // Get current date in 'YYYY-MM-DD' format
      
        $this->db->from('tbl_staff_attendance_info as attendance');
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('attendance.staff_id', $staff_id);
        $this->db->order_by('created_date_time', 'asc'); // Sort by created_date_time in descending order
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }

    function fetchGivenLeave($leaveId)
    {
        // Get current date in 'YYYY-MM-DD' format
      
        $this->db->from('tbl_staff_applied_leave');
        $this->db->where('is_deleted', 0);
        $this->db->where('row_id', $leaveId);
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }


    function getToken($staffId)
    {
        // Get current date in 'YYYY-MM-DD' format
      
        $this->db->from('tbl_staff_token');
        $this->db->where('staff_id', $staffId);
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }

    function fetchApproverList()
    {
        // Get current date in 'YYYY-MM-DD' format
      
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->where('leave_approved_status', 1);
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }


    public function sendMessage($title,$body,$user_tokens,$user_type){

        if(count($user_tokens) > 0){
            $fcm_data=array(
                'title' => $title,
                'body'=> $body,
                'image'=> STAFF_NOTIFICATION_LOGO, 
                'user_type'=>$user_type         
            );

            log_message('debug','fcm_data -->'.print_r($fcm_data,true));
           log_message('debug','user_tokens -->'.print_r($user_tokens,true));
            $fcm_fields= array(
                'registration_ids' => $user_tokens,
                'notification' => $fcm_data,
            );

           // log_message('debug','fcm_fields -->'.print_r($fcm_fields,true));
            $fcm_result_array=$this->fcmPushNotification($fcm_fields);

            log_message('debug','fcm_result_array -->'.print_r($fcm_result_array,true));

            return 1;
        }else{
            return 0;
        }
        
        
    }    

    private static function fcmPushNotification($fields=array()){
        $headers = array(
            'Authorization: key=' . STAFF_FCM_SERVER_KEY,
            'Content-Type: application/json'
        );

        $fields['registration_ids'] = (array) $fields['registration_ids'];
       // log_message('debug','headers -->'.print_r($headers,true));

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, STAFF_FCM_URL);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
     log_message('debug','result -->'.print_r($result,true));

        curl_close( $ch );
        return json_decode($result,true);
    }


    function getStaffRoleId($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'Roles.roleId,staff.leave_approved_status'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id', $staffId);
        $query = $this->db->get();
        return $query->result();
    }


    function fetchSubjectList($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->distinct();
        $this->db->select('teaching.subject_code, section.section_name, subjects.sub_name, term.term_name');
        $this->db->from('tbl_staff_teaching_subjects as teaching');
        $this->db->join('tbl_section_info as section', 'section.row_id = teaching.section_id');
        $this->db->join('tbl_subjects as subjects', 'subjects.subject_code = teaching.subject_code');
        $this->db->join('tbl_term_name as term', 'term.row_id = section.term_id');
        $this->db->where('teaching.staff_id', $staffId);
        $this->db->where('teaching.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
        
    }


    public function deleteToken($id){
        $this->db->where('device_id', $id);
        $this->db->delete('tbl_staff_token');
        return true;
    }


    function fecthStaffAllDetails($row_id)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.is_deleted,staff.staff_id,staff.row_id,staff.user_name,staff.type,staff.mobile_one,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.qualification,staff.blood_group,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.row_id', $row_id);
       
        $query = $this->db->get();
        return $query->result();
    }

    function getManagmentStatus($staff_id)
    {
        $this->db->select('management_view_status');
        $this->db->from('tbl_staff');
        $this->db->where('staff_id', $staff_id); // Modified line
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

   

    function updateOtp($info, $mblNumber)
    {
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $this->db->update('tbl_staff', $info);
        return true;
    }

    function checkOtp($mblNumber, $otp)
    {
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $this->db->where('last_otp', $otp);
        $query = $this->db->get();
        $user = $query->row();
        return $user;
    }

    function getAllApproveLeaveList($staff_id)
    {
        $this->db->select(
            'leave.row_id, leave.staff_id, leave.applied_date_time, leave.date_from, leave.date_to, leave.approved_status, leave.total_days_leave, leave.leave_reason, leave.remark, leave.leave_type, leave.leave_name, leave.approved_by, leave.rejected_by, leave.created_by, leave.created_date_time, leave.updated_date_time, leave.updated_by, leave.is_deleted, leave.medical_certificate'
        );
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->join(
            'tbl_staff as staff',
            'staff.staff_id = leave.staff_id'
        );
        $this->db->where('leave.staff_id !=', $staff_id); // Modified line
        $this->db->order_by('leave.created_date_time', 'desc'); // Sort by created_date_time in descending order
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('staff.management_view_status', 1);
        $query = $this->db->get();
        return $query->result();
    }




    
}

?>
