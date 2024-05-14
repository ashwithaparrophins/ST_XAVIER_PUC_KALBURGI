<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ApiAdmin extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('staff_model','staff');
        $this->load->model('Students_model','student');
    }


    public function GetStudentCountApi(){
       log_message('debug','I HAVE BEEN HIT');
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        $filter = array();
        // $result = $this->staff->getAllSchoolStaffInfo();
        $result = $this->student->getCountOfStudents($filter);
        $data = json_encode($result);
        echo $data;
    }
    
    public function GetStaffCountApi(){
        log_message('debug','I HAVE BEEN HIT STAFF');
         $json = file_get_contents('php://input');
         $obj = json_decode($json,true);
         $filter = array();
         // $result = $this->staff->getAllSchoolStaffInfo();
         $deptInfo = $this->staff->getStaffDepartment();
         $total_staff = 0;
         foreach($deptInfo as $dept){
             $filter['by_dept'] = $dept->dept_id;
             $countStaff = $this->staff->staffListingCount($filter);
             $staffCount[$dept->dept_id] = $countStaff;
             $total_staff += $countStaff;
         }
         $data = json_encode($total_staff);
         echo $data;
     }


}
?>
