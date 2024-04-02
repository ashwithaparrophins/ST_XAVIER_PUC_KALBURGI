<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class App_staff_login extends CI_Model
{
    function checkMobNo($mblNumber) 
    {

        log_message('debug','mblNumber-->'.print_r($mblNumber,true));

       
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile',$mblNumber);
        $this->db->or_where('mobile_two',$mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
       // log_message('debug','query-->'.print_r($query,true));

        $user = $query->row();
        log_message('debug','user-->'.print_r($user,true));

        return $user;
       
    }
    

   
}

?>