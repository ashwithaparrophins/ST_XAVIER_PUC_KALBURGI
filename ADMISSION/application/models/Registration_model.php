<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Registration_model extends CI_Model
{
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function studentRegistrationToDB($studentInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_admission_registered_student_temp', $studentInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailOrMobileExists($email,$mobile) {
        // $this->db->select("email");
        $this->db->from("tbl_admission_registered_student_temp");
        $this->db->where("email", $email);    
        $this->db->or_where("mobile", $mobile);
        $this->db->where("reg_year", 2024);  
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * This function is used to check whether Mobile number is already exist or not
     * @param {string} $mobile : This is Mobile no
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    // function checkMobileNumberExists($mobile)
    // {
    //     $this->db->select("mobile");
    //     $this->db->from("tbl_admission_registered_student_temp");
    //     $this->db->where("mobile", $mobile);  
    //     $this->db->where("reg_year", 2024);
    //     $this->db->where("is_deleted", 0);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function checkRegisterNumberExists($registration_number)
    {
        $this->db->select("registration_number");
        $this->db->from("tbl_admission_registered_student_temp");
        $this->db->where("registration_number", $registration_number);
        $this->db->where("reg_year", 2024);   
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        return $query->row();
    }
    
        function checkMobileNumberExists($mobile)
    {
        $this->db->select("mobile,name");
        $this->db->from("tbl_admission_registered_student_temp");
        $this->db->where("mobile", $mobile);   
        $this->db->where("is_deleted", 0);
        $this->db->where("reg_year", 2024);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getBoardName(){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->where('board.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();   
    }
 
    
    function getBoardNameByName($sslc_board_name){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->where('board.board_name', $sslc_board_name);
        $this->db->where('board.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }

    //update info
    function updateStudentRegistrationInfo($registered_row_id,$info){
        $this->db->where('row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_registered_student_temp', $info);
        return $this->db->affected_rows();
    }
    
}
?>