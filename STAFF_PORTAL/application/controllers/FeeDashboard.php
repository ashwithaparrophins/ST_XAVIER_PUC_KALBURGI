<?php if (!defined('BASEPATH')) {

exit('No direct script access allowed');

}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class FeeDashboard extends BaseController {

public function __construct()

{
    parent::__construct();
    $this->load->model('user_model');
    $this->load->model('feeDashboard_model','fee');
    $this->load->model('Students_model','student');
    $this->isLoggedIn();

}

public function viewFeeDashboard()
{
    $fee_year = $this->security->xss_clean($this->input->post('fee_year'));
    $data['fee_year'] =  $fee_year;
    if($fee_year == '') {
        $fee_year = CURRENT_YEAR;
    }else {
        $fee_year  = $fee_year;
    }

    $todayDate = date('Y-m-d');
    $filter = array();
    $by_class = array();
    $studentCount = array();
    $totalStudent = 0;
    $term = ['I PUC', 'II PUC'];
    $by_stream[0] = 'PCMB';
    $by_stream[1] = 'PCMC';
    $by_stream[2] = 'EBAC';
    $by_stream[3] = 'HEPE';
    $by_stream[4] = 'HEPS';

    $by_class[0] = 'I PUC';
    $by_class[1] = 'II PUC';
    
    for($i=0;$i<count($by_class);$i++){
        $class = $filter['by_class'] = $by_class[$i];
        for($j=0;$j<count($by_stream);$j++){
            $stream = $by_stream[$j];
            $studentPUCount[$i] = $this->fee->getTotalPUStudentsCount($class,$stream);
          
                $studentPUCFeePaid[$stream][$class] = $this->fee->getSumOfPUCFeesPaidClassWise($class,$stream);
                $feeConcessionPUC[$stream][$class] = $this->fee->getSumOfPUCFeesConcession($class,$stream); 
                $feeScholarshipPUC[$stream][$class] = $this->fee->getSumOfPUCFeesScholarship($class,$stream); 
            $studentPUCCount = $this->fee->getTotalPUStudentsCount($class,$stream);
            // $studentII_PUCCount = $this->fee->getTotalPUStudentsCount($class,$stream);
            $filter['term_name'] = $class;
            $filter['stream_name'] = $stream;
            
            $totalFeeAmount = $this->fee->getTotalFeeAmount($filter);

            // $totalDeptFeeAmount = $this->fee->getDepartmentFeeAmount($filter);
            // log_message('debug','totalDeptFeeAmount'.print_r($totalDeptFeeAmount,true));

            $totalClgFee = $totalFeeAmount->total_fee;
            $totalFeeAmountPUC[$stream][$class] = $studentPUCCount * $totalClgFee;

        }
    }
    
    $data['className'] = $by_class;
    $data['studentCount']=$studentPUCount;
    $data['totalStudentCount'] = $studentPUCount;
    $data['feePaidCount'] = $studentPUCFeePaid;
    $data['feeConcessionCount'] = $feeConcessionPUC;
    $data['feeScholarshipCount'] = $feeScholarshipPUC;
    $data['totalStdFee'] = $totalFeeAmountPUC;
    $data['streamName'] = $by_stream;    
    $data['feePaidInfo'] = $this->fee->getCancelledReceiptInfo($fee_year);

    //fees
    $data['from_date'] = $from_date = $this->security->xss_clean($this->input->post('from_date'));
    $data['to_date'] = $to_date = $this->security->xss_clean($this->input->post('to_date'));
    if(empty($from_date)){
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
    }
    $data['from_date'] = $from_date;
    $data['to_date'] = $to_date;
    $data['getFeePaidInfo'] = $this->fee->getFeePaidInfoOverall($from_date,$to_date);

    //mis 
      $data['mis_from_date'] = $mis_from_date = $this->security->xss_clean($this->input->post('mis_from_date'));
      $data['mis_to_date'] = $mis_to_date = $this->security->xss_clean($this->input->post('mis_to_date'));
      if(empty($mis_from_date)){
          $mis_from_date = date('Y-m-d');
          $mis_to_date = date('Y-m-d');
      }
      $data['mis_from_date'] = $mis_from_date;
      $data['mis_to_date'] = $mis_to_date;
      $data['getMiscFeePaidInfo'] = $this->fee->getMiscFeePaidInfoOverall($mis_from_date,$mis_to_date);
      $data['display_type_c'] = "feeDashboard";

    $this->global['pageTitle'] = ''.TAB_TITLE.' : Teaching Staff Dashboard';
    $this->loadViews("feeDashboard", $this->global, $data, null);
}

}?>