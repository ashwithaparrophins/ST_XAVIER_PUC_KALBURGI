<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Studymaterial_model extends CI_Model
{
    public function getStudyMaterial($filter,$filterDate,$filterType,$filterSub){
        $study_year = array('2021','2022','2023');
        $this->db->select('study.subject_name,study.type,study.description,study.document_name_url,study.created_date_time,staff.name');
        $this->db->join('tbl_staff as staff','staff.staff_id = study.created_by');
        $this->db->from('tbl_study_material as study');
        $this->db->where('study.term_name', $filter['term_name']);
        $this->db->where_in('study.stream_name',array($filter['stream_name'], $filter['stream_name1']));
        if(!empty($filter['by_name'])){
            $this->db->where('study.name', $filter['by_name']);
        }
        if(!empty($filter['by_type'])){
            $this->db->where('study.type', $filter['by_type']);
        }
        if(!empty($filter['by_description'])){
            $this->db->where('study.description', $filter['by_description']);
        }
        if(!empty($study_year)){
            $likeCriteria = "(study.created_date_time  LIKE '%" . $study_year . "%')";
            $this->db->where_in($likeCriteria);
        }
        if(!empty($filterDate)){
            $this->db->where('DATE(study.created_date_time)', $filterDate);
        }
        if(!empty($filterType)){
            $this->db->where('study.type', $filterType);
        }
        if(!empty($filterSub)){
            $this->db->where('study.subject_name', $filterSub);
        }
        $this->db->where('study.is_deleted',0);
        // $this->db->like('study.created_date_time', '2021');
        $this->db->order_by('study.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getStudyMaterialCount($filter){
        $study_year = array('2021','2022');
        $this->db->from('tbl_study_material as study');
        $this->db->where('study.term_name', $filter['term_name']);
        $this->db->where_in('study.stream_name',array($filter['stream_name'], $filter['stream_name1']));
        if(!empty($filter['by_name'])){
            $this->db->where('study.name', $filter['by_name']);
        }
        if(!empty($filter['by_type'])){
            $this->db->where('study.type', $filter['by_type']);
        }
        if(!empty($filter['by_description'])){
            $this->db->where('study.description', $filter['by_description']);
        }
        if(!empty($study_year)){
            $likeCriteria = "(study.created_date_time  LIKE '%" . $study_year . "%')";
            $this->db->where_in($likeCriteria);
        }
        $this->db->where('study.is_deleted',0);
        $this->db->order_by('study.row_id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // youtube video link
    public function getYoutubeLinkCount($filter) {
        $this->db->from('tbl_youtube_video_details as video');
        $this->db->where('video.term_name', $filter['term_name']);
        $this->db->where_in('video.stream_name',array($filter['stream_name'], $filter['stream_name1']));
        if(!empty($filter['by_name'])){
            $this->db->where('video.video_name', $filter['by_name']);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('video.date', $filter['by_date']);
        }
        if(!empty($filter['subject_name'])){
            $this->db->where('video.subject_name', $filter['subject_name']);
        }
        $this->db->where('video.is_deleted',0);
        $this->db->order_by('video.row_id', 'DESC');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function getYoutubeLink($filter) {
        $this->db->from('tbl_youtube_video_details as video');
        $this->db->where('video.term_name', $filter['term_name']);
        $this->db->where_in('video.stream_name',array($filter['stream_name'], $filter['stream_name1']));
        if(!empty($filter['by_name'])){
            $this->db->where('video.video_name', $filter['by_name']);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('video.date', $filter['by_date']);
        }
        if(!empty($filter['subject_name'])){
            $this->db->where('video.subject_name', $filter['subject_name']);
        }
        $this->db->where('video.is_deleted',0);
        $this->db->order_by('video.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    

    public function getOnlineClass($filter){
        $this->db->from('tbl_student_online_class as study');
        $this->db->where('study.term_name', $filter['term_name']);
        //$this->db->where_in('study.stream_name',array($filter['stream_name'],'ALL'));
      
        $this->db->where_in('study.section_name',array($filter['section_name'],'ALL'));
        
        $this->db->join('tbl_staff as staff', 'staff.staff_id = study.created_by','left');

        if(!empty($filter['by_name'])){
            $this->db->where('study.name', $filter['by_name']);
        }
      
        // if(!empty($filter['by_date'])){
        //     $this->db->where('study.date', $filter['by_date']);
        // }
        if(!empty($filter['by_description'])){
            $this->db->where('study.description', $filter['by_description']);
        }
        if(!empty($filter['subject_name'])){
            $this->db->where('study.subject_name', $filter['by_name']);
        }
        $this->db->where('study.date >=', date('Y-m-d'));
        $this->db->where('study.is_deleted',0);
        $this->db->order_by('study.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getOnlineClassCount($filter){
        $this->db->from('tbl_student_online_class as study');
        $this->db->where('study.term_name', $filter['term_name']);
       // $this->db->where_in('study.stream_name',array($filter['stream_name'],'ALL'));
      
        $this->db->where_in('study.section_name',array($filter['section_name'],'ALL'));
         if(!empty($filter['subject_name'])){
            $this->db->where('study.subject_name', $filter['by_name']);
        }
        // if(!empty($filter['by_date'])){
        //     $this->db->where('study.date', $filter['by_date']);
        // }
        if(!empty($filter['by_type'])){
            $this->db->where('study.type', $filter['by_type']);
        }
        if(!empty($filter['by_description'])){
            $this->db->where('study.description', $filter['by_description']);
        }
        $this->db->where('study.date >=', date('Y-m-d'));
        $this->db->where('study.is_deleted',0);
        $this->db->order_by('study.row_id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

}
?>