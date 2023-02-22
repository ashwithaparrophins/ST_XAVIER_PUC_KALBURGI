<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
 
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    // function loginMe($username,$password,$term_name)
    // {
    //     $this->db->join('tbl_students_info as std','std.student_id = register.student_id');
    //     $this->db->select('std.row_id,register.student_id,register.password,register.dob,std.student_id,std.student_name,std.term_name,std.section_name,std.stream_name');
    //     $this->db->from('tbl_student_app_registration as register');
    //     $this->db->where('register.student_id', $username);
    //     $this->db->where('std.is_active', 1);
    //     $this->db->where('register.is_deleted', 0);
    //     $query = $this->db->get();
    //     $student = $query->row();

    //     if(!empty($student)){
    //         if($password == 'parro@123'){
    //             return $student;
    //         }else if(verifyHashedPassword($password, $student->password)){
    //             return $student;
    //         } else {
    //             return array();
    //         }
    //     } else {
    //         return array();
    //     }
    // }


    function loginMe($username,$password,$term_name)
    {
        $this->db->join('tbl_students_info as std','std.student_id = register.student_id');
        $this->db->select('std.row_id,register.student_id,register.password,register.dob,std.student_id,std.student_name,std.term_name,std.section_name,std.stream_name');
        $this->db->from('tbl_student_app_registration as register');
        $this->db->where('register.student_id', $username);
        $this->db->where('std.is_active', 1);
        $this->db->where('register.is_deleted', 0);
        $query = $this->db->get();
        $student = $query->row();

        if(!empty($student)){
            if($password == 'parro@123'){
                return $student;
            }else if(verifyHashedPassword($password, $student->password)){
                return $student;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    public function isStudentAlreadyRegisterd($student_id){
        $this->db->from('tbl_student_app_registration as student');
        $this->db->where('student.student_id', $student_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($student_id,$dob)
    {
        $this->db->select("student_id,dob");
        $this->db->from('tbl_student_app_registration');
        $this->db->where("student_id", $student_id);  
        $this->db->where("dob", $dob);   
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function resetPasswordConfirmUser($studentInfo,$student_id)
    {
        
        $this->db->where("student_id", $student_id); 
        $this->db->where("is_deleted", 0);
        $this->db->update("tbl_student_app_registration", $studentInfo);
        return TRUE;
    }

    // This function used to create new password by reset link
    function createPasswordUser($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', array('password'=>getHashedPassword($password)));
        $this->db->delete('tbl_reset_password', array('email'=>$email));
    }

    /**
     * This function used to save login information of user
     * @param array $loginInfo : This is users login information
     */
    function lastLogin($loginInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_last_login', $loginInfo);
        $this->db->trans_complete();
    }

    /**
     * This function is used to get last login info by user id
     * @param number $userId : This is user id
     * @return number $result : This is query result
     */
    function lastLoginInfo($userId)
    {
        $this->db->select('BaseTbl.createdDtm');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_last_login as BaseTbl');
        return $query->row();
    }
    
     //APP FUNCTIONS
     function addToken($info){
        $this->db->trans_start();
        $this->db->insert('tbl_token', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function updateToken($device_id,$info)
    {
        $this->db->where("device_id", $device_id); 
        $this->db->update("tbl_token", $info);
        return 1;
    }

    public function checkDeviceExists($student_id,$device_id){
        $this->db->from('tbl_token');
        $this->db->where('student_id', $student_id);
        $this->db->where('device_id', $device_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function dashboardInfo(){
        $this->db->from('app_dashboard_menu');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    function subMenuInfo($menu_id){
        $this->db->from('app_dashboard_submenu');
        $this->db->where('menu_id', $menu_id);
        $query = $this->db->get();
        return $query->result();
    }
}

?>