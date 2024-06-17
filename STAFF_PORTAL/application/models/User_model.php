<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '',$role,$vendorId,$manager_id,$team_lead_id)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if($role == ROLE_MANAGER){
            $this->db->where('BaseTbl.manager_id', $vendorId);
            $this->db->where('BaseTbl.userId !=', $vendorId);
        }else if($role == ROLE_TEAM_LEAD){
            $this->db->where('BaseTbl.team_lead_id', $vendorId);
            $this->db->where('BaseTbl.userId !=', $vendorId);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page, $segment,$role,$vendorId,$manager_id,$team_lead_id)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if($role == ROLE_MANAGER){
            $this->db->where('BaseTbl.manager_id', $vendorId);
            $this->db->where('BaseTbl.userId !=', $vendorId);
        }else if($role == ROLE_TEAM_LEAD){
            $this->db->where('BaseTbl.team_lead_id', $vendorId);
            $this->db->where('BaseTbl.userId !=', $vendorId);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles($role)
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $this->db->where('roleId !=', '50');
        $this->db->where('roleId !=', $role);
        if($role == ROLE_MANAGER){
            $this->db->where('roleId !=', ROLE_EMPLOYEE);  
        }else if( $role == ROLE_ADMIN){
            $this->db->where('roleId !=', ROLE_TEAM_LEAD);
            $this->db->where('roleId !=', ROLE_EMPLOYEE);  
        }else if( $role == ROLE_TEAM_LEAD){
            $this->db->where('roleId !=', ROLE_TEAM_LEAD);
            $this->db->where('roleId !=', ROLE_MANAGER);  
        }
        $query = $this->db->get();
        return $query->result();
    }


    function getTeamLeads()
    {
        $this->db->select('roleId, name');
        $this->db->from('tbl_users');
        $this->db->where('roleId =', 4);
        $query = $this->db->get();
        return $query->result();
    }
    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function addNewUserRelation($userRelationInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_user_relation', $userRelationInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
		$this->db->where('roleId !=', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editStaff($staffInfo, $staffId)
    {
        $this->db->where('staff_id', $staffId);
        $this->db->update('tbl_staff', $staffInfo);
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($staff_id, $staffInfo)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->update('tbl_staff', $staffInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($staff_id, $oldPassword)
    {
        $this->db->select('staff_id, password');
        $this->db->where('staff_id', $staff_id);        
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_staff');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($staff_id, $staffInfo)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_staff', $staffInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function loginHistory($userId, $searchText, $fromDate, $toDate, $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tbl_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getStaffInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.staff_id, BaseTbl.email, BaseTbl.name, BaseTbl.mobile_one, BaseTbl.role, Roles.role as role_name');
        $this->db->from('tbl_staff as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.role');
        $this->db->where('BaseTbl.staff_id', $userId);
        $this->db->where('BaseTbl.is_deleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }
    function getStaffDepartmentById($dept_id){
        $this->db->select('name');
        $this->db->from('tbl_department');
        $this->db->where('dept_id', $dept_id);
        $query = $this->db->get();
        return $query->row();
    }

    //get section names by staff id
    function getStaffSectionsById($staff_id){
        $this->db->select('first_year_section, second_year_section, staff_id');
        $this->db->from('tbl_staff_sections');
        $this->db->where('staff_id', $staff_id);
        $query = $this->db->get();
        return $query->row();
    }


    function changePasswordAdmin($row_id, $staffInfo)
    {
        $this->db->where('row_id', $row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_staff', $staffInfo);
        
        return $this->db->affected_rows();
    }

    public function getAlldocumentInfoDashboard(){
        $this->db->from('tbl_college_document as doc'); 
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function getExpiryDocument($doc){

        $this->db->from('tbl_college_document as document');
        $todayDate=date('Y-m-d');
        $NewDate=date('Y-m-d', strtotime("+10 days"));

        $this->db->where('document.expiry_date BETWEEN "'.$todayDate. '" and "'. $NewDate.'"');
        $this->db->where('document.row_id', $doc);
        $this->db->where('document.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    
    }
}

  