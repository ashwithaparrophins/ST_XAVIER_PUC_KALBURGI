<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Holiday_model extends CI_Model
    {
        function getHolidayCount($filter)
        {
           $this->db->from('tbl_college_holiday_info as holiday'); 
         
           if(!empty($filter['reason'])) {
            $likeCriteria = "(holiday.reason  LIKE '%".$filter['reason']."%')";
            $this->db->where($likeCriteria);
        }
            if(!empty($filter['by_date'])) {
                $this->db->where('holiday.holiday_date', date('Y-m-d',strtotime($filter['by_date'])));
            }
          
            $this->db->where('holiday.is_deleted', 0);
            $query = $this->db->get();
            return $query->num_rows();
        }
        
        function getHolidayListing($filter, $page, $segment)
        {
            $this->db->from('tbl_college_holiday_info as holiday'); 
           
            if(!empty($filter['reason'])) {
                $likeCriteria = "(holiday.reason  LIKE '%".$filter['reason']."%')";
                $this->db->where($likeCriteria);
            }
            if(!empty($filter['by_date'])) {
                $this->db->where('holiday.holiday_date', date('Y-m-d',strtotime($filter['by_date'])));
            }
            $this->db->where('holiday.is_deleted', 0);
            $this->db->order_by('holiday.holiday_date', 'ASC');
            $this->db->limit($page, $segment);
            $query = $this->db->get();
            return $query->result();        
        }


        function addNewHoliday($holidayInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_college_holiday_info', $holidayInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        function updateHoliday($holidayInfo, $row_id)
        {
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_college_holiday_info', $holidayInfo);
            return TRUE;
        }
        public function getHolidayInfoById($row_id)
        {
            $this->db->from('tbl_college_holiday_info as holiday');
            $this->db->where('holiday.row_id', $row_id);
            $query = $this->db->get();
            return $query->row();
        }

        public function getHolidayInfoByRole($role){
            $this->db->from('tbl_college_holiday_info as holiday');
            if($role == ROLE_TEACHING_STAFF){
                $this->db->where('holiday.teaching_staff_status', 1);
            } else if($role == ROLE_NON_TEACHING_STAFF || $role == ROLE_ADMIN){
                $this->db->where('holiday.non_teaching_staff_status', 1);
            } else if($role == ROLE_SUPPORT_STAFF){
                $this->db->where('holiday.support_staff_status', 1);
            }
            $this->db->where('holiday.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();          
        }

        
    }