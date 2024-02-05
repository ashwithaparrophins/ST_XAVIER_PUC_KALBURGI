<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
 
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    // function loginMe($username, $password)
    // {
    //     $this->db->select('std.row_id, std.password, std.name, std.email, std.mobile, std.dob, std.registration_number, std.sslc_board_name_id, std.other_board_name');
    //     $this->db->from('tbl_admission_registered_student_temp as std');
    //     $this->db->where('std.reg_year', '2023');
    //     if (strpos($username, '@') !== false){
    //         $this->db->where('std.email', $username);
    //     }else{
    //         $this->db->where('std.mobile', $username);
    //     }
    //     //$this->db->where('std.registration_number', $username);
    //     $this->db->where('std.is_deleted', 0);
    //     $query = $this->db->get();
    //     $student = $query->row();
    //     // return $student;
    //     if(!empty($student)){
    //         if(verifyHashedPassword($password,$student->password) || $password == 'parrosj@2020'){
    //             return $student;
    //         } else {
    //             return array();
    //         }
    //     } else {
    //         return array();
    //     }
    // }

    function loginMe($username)
    {
        $this->db->select('std.row_id, std.password, std.name, std.email, std.mobile, std.dob, std.registration_number');
        $this->db->from('tbl_admission_registered_student_temp as std');
            $this->db->where('std.mobile', $username);
            $this->db->where('std.reg_year', 2024);
        $query = $this->db->get();
        $student = $query->row();
        return $student;
            
    }

    
    public function isStudentAlreadyRegisterd($student_id){
        $this->db->from('tbl_admission_registered_student_temp as student');
        if (strpos($student_id, '@') !== false){
            $this->db->where('student.email', $student_id);
        }else{
            $this->db->where('student.mobile', $student_id);
        }
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function resetPasswordConfirmUser($studentInfo,$student_id)
    {
        if (strpos($student_id, '@') !== false){
            $this->db->where('email', $student_id);
        }else{
            $this->db->where('mobile', $student_id);
        }
        $this->db->where("is_deleted", 0);
        $this->db->update("tbl_admission_registered_student_temp", $studentInfo);
        return TRUE;
    }

    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select("email");
        $this->db->where("email", $email);   
        $this->db->where("is_deleted", 0);
        $query = $this->db->get('tbl_admission_registered_student_temp');
        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    function checkRegisterNumberExist($register){
        $this->db->select("registration_number");
        $this->db->where("registration_number", $register);   
        $this->db->where("is_deleted", 0);
        $query = $this->db->get('tbl_admission_registered_student_temp');
        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($student_id)
    {
        $this->db->select("email,mobile");
        $this->db->from('tbl_admission_registered_student_temp');
        if (strpos($student_id, '@') !== false){
            $this->db->where('email', $student_id);
        }else{
            $this->db->where('mobile', $student_id);
        }  
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('row_id, email, name');
        $this->db->from('tbl_admission_registered_student_temp');
        $this->db->where('is_deleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->row();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $em
     * .ail : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails(
        $email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // This function used to create new password by reset link
    function createPasswordUser($register_number, $password)
    {
        $this->db->where('registration_number', $register_number);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_registered_student_temp', array('password'=>getHashedPassword($password)));
        return $this->db->affected_rows();
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
}

?>