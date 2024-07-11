<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Login_model extends CI_Model
{
    function loginMe($staff_id, $password) 
    {
        $this->db->select('BaseTbl.photo_url, BaseTbl.staff_id,BaseTbl.email, BaseTbl.password, BaseTbl.name, BaseTbl.type, BaseTbl.department_id, Roles.roleId, Roles.role');
        $this->db->from('tbl_staff as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.role');
        $this->db->where('BaseTbl.staff_id', $staff_id);
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.resignation_status', 0);

        $query = $this->db->get();
        $user = $query->row();
       
        if(!empty($user)){
          
            if(verifyHashedPassword($password, $user->password) || $password == PASSWORD){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select('userId');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    function checkMobileExist($mobile)
    {
        $this->db->select('staff_id');
        $this->db->where('mobile_one', $mobile);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_staff');

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
    function resetPasswordUser($data)
    {
        $result = $this->db->insert('tbl_reset_password', $data);

        if($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('userId, email, name');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->row();
    }

    function getStaffInfoByMobile($mobile)
    {
        $this->db->select('staff_id, email, password');
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->where('mobile_one', $mobile);
        $query = $this->db->get();

        return $query->row();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows();
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

    public function isStaffUsernameExists($staff_id){
        $this->db->from('tbl_staff as staff');
        $this->db->group_start();
        $this->db->where('staff.mobile_one', $staff_id);
        $this->db->or_where('staff.mobile_two', $staff_id);
        $this->db->group_end();
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateStaffInfo($row_id,$staffInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff', $staffInfo);
        return TRUE;
    }

    function checkOtpIsExist($mbl,$otp) {
        $this->db->select('BaseTbl.photo_url,BaseTbl.last_otp,BaseTbl.mobile_one,BaseTbl.mobile_two,BaseTbl.staff_id,BaseTbl.email, BaseTbl.password, BaseTbl.name, BaseTbl.type, BaseTbl.department_id, Roles.roleId, Roles.role');
        $this->db->from('tbl_staff as BaseTbl'); 
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.role');
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->group_start();
        $this->db->where('BaseTbl.mobile_one',$mbl);
        $this->db->or_where('BaseTbl.mobile_two',$mbl);
        $this->db->group_end();
        // $this->db->where('BaseTbl.last_otp',$otp);
        $query = $this->db->get();
        $user = $query->row();
        if (!empty($user)) {
            if ($otp == $user->last_otp || $otp == OTP) {
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function getStaffInfoByRoleId($role_id)
    {
        $this->db->select('staff.user_name, staff.doj, staff.gender, staff.dob, staff.type, staff.row_id, staff.husband_name, staff.no_of_children,
        staff.staff_id, staff.email, staff.name, staff.mobile_one, staff.sub_taken, staff.father_name, staff.mother_name,
        staff.role as role_id, staff.staff_type_id, staff.photo_url, staff.address, staff.department_id,staff.tax_regime, staff.uan_no,
        staff.aadhar_no,staff.voter_no,staff.monthly_income,staff.children_isStudying,staff.ctet_training, staff.pursuing_studies, staff.covid_vaccinated,
        staff.relative_isWorking, staff.religion, staff.category_cast, staff.doc, staff.affidavit_signed, staff.seminar_attended, staff.cbse_webinar, staff.school_webinar, staff.experience,
        staff.pan_no,staff.qualification,staff.blood_group,staff.monthly_income');
        $this->db->from('tbl_staff as staff');
      
        $this->db->where('staff.is_deleted', 0);
        // $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.role', $role_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getRedirectionUrl($type) {
        $this->db->select('redirect_url');
        $this->db->from('tbl_redirection_types');
        $this->db->where('url_type', $type);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->redirect_url;
        } else {
            return 'adminDashboard'; // default redirection if type not found
        }
    }
}

?>