<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
require_once 'vendor/autoload.php';

class Salary extends BaseController
{
 public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('salary_model','salary');
        $this->load->model('staff_model','staff');
        $this->load->model('settings_model','settings');
        $this->isLoggedIn();   
    }
function salarySlipListing()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $name = $this->security->xss_clean($this->input->post('name'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
            $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
            $net_amount = $this->security->xss_clean($this->input->post('net_amount'));
            $basic = $this->security->xss_clean($this->input->post('basic'));
            $working_day = $this->security->xss_clean($this->input->post('working_day'));
            $by_month = $this->security->xss_clean($this->input->post('by_month'));
            $by_year = $this->security->xss_clean($this->input->post('by_year'));

            $data['name'] = $name;
            $data['gross_salary'] = $gross_salary;
            $data['grade_pay'] = $grade_pay;
            $data['staff_id'] = $staff_id;
            $data['net_amount'] = $net_amount;
            $data['basic'] = $basic;
            $data['working_day'] = $working_day;
            $data['by_month'] = $by_month;
            $data['by_year'] = $by_year;
           
            $filter['name'] = $name;
            $filter['gross_salary'] = $gross_salary;
            $filter['staff_id'] = $staff_id;
            $filter['net_amount'] = $net_amount;
            $filter['basic'] = $basic;
            $filter['working_day'] = $working_day;
            $filter['by_month'] = $by_month;
            $filter['by_year'] = $by_year;

            if(!empty($date)){
                $filter['date'] = date('Y-m-d',strtotime($date));
                $data['date'] = date('d-m-Y',strtotime($date));
            }else{
                $data['date'] = '';
                $filter['date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->salary->getAllSalaryCount($filter);
            $returns = $this->paginationCompress("salarySlipListing/", $count, 100);
            $data['totalSalaryCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['staffInfo'] = $this->staff->getStaffDetails($filter);
            $data['salaryInfo'] = $this->salary->getAllSalaryInfo($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip Details';
            $this->loadViews("salary/salary.php", $this->global, $data, NULL);

        }
    }
  

        public function addNewSalarySlipInfo() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

             $this->form_validation->set_rules('staff_id', 'Staff', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->salarySlipListing();
            } else {
                $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
                $service = $this->security->xss_clean($this->input->post('service'));
                $category = $this->security->xss_clean($this->input->post('category'));
                $account_no = $this->security->xss_clean($this->input->post('account_no'));
                $basic = $this->security->xss_clean($this->input->post('basic'));
                $da = $this->security->xss_clean($this->input->post('da'));
                $hra = $this->security->xss_clean($this->input->post('hra'));
                $ta = $this->security->xss_clean($this->input->post('ta'));
                $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
                $mgt_cont_to_pf_1 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_1'));
                $admin_charges_1 = $this->security->xss_clean($this->input->post('admin_charges_1'));
                $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
                $mgt_cont_to_pf_2 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_2'));
                $admin_charges_2 = $this->security->xss_clean($this->input->post('admin_charges_2'));
                $pf = $this->security->xss_clean($this->input->post('pf'));
                $pt = $this->security->xss_clean($this->input->post('pt'));
                $lic = $this->security->xss_clean($this->input->post('lic'));
                $school_loan = $this->security->xss_clean($this->input->post('school_loan'));
                $bank_guardian = $this->security->xss_clean($this->input->post('bank_guardian'));
                $sib = $this->security->xss_clean($this->input->post('sib'));
                $it = $this->security->xss_clean($this->input->post('it'));
                $lop = $this->security->xss_clean($this->input->post('lop'));
                $total_deduction = $this->security->xss_clean($this->input->post('total_deduction'));
                $net_amount = $this->security->xss_clean($this->input->post('net_amount'));
                
                // $isExist = $this->salary->checkVisitorExists($mobile_number);
                // if(!empty($isExist)){
                //     $this->session->set_flashdata('warning', 'Visitor  Already Exists');
                //     redirect('visitorListing');
                // }else{
                     $info = array(
                        'staff_id' => $staff_id, 
                        'service' => $service, 
                        'category' => $category, 
                        'account_no' => $account_no, 
                        'basic' => $basic, 
                        'da' => $da, 
                        'hra' => $hra, 
                        'ta' => $ta, 
                        'grade_pay' => $grade_pay, 
                        'mgt_cont_to_pf_1' => $mgt_cont_to_pf_1, 
                        'admin_charges_1' => $admin_charges_1, 
                        'gross_salary' => $gross_salary, 
                        'mgt_cont_to_pf_2' => $mgt_cont_to_pf_2, 
                        'admin_charges_2' => $admin_charges_2, 
                        'pf' => $pf, 
                        'pt' => $pt, 
                        'lic' => $lic, 
                        'school_loan' => $school_loan, 
                        'bank_guardian' => $bank_guardian, 
                        'sib' => $sib, 
                        'it' => $it, 
                        'lop' => $lop, 
                        'total_deduction' => $total_deduction, 
                        'net_amount' => $net_amount,
                        'year' => d('Y'),
                        'month' => d('m'),
                        'date' => d('Y-m-d'),
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->salary->addSalarySlipInfo($info);
                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'New Salary Slip Info Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'New Salary Slip Info Add failed');
                    }
                 // }
                 
                redirect('salarySlipListing');
            }
        }
    }

    
    
    public function editSalarySlip($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('salarySlipListing');
            }
            $data['staffInfo'] = $this->staff->getStaffDetails();
            $data['salaryInfo'] = $this->salary->getSalaryInfoById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Salary Slip';
            $this->loadViews("salary/editSalary", $this->global, $data, null);
        }
    }

    public function updateSalarySlip(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
             $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('staff_id', 'Staff', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->editSalarySlip();
            } else {

             $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $service = $this->security->xss_clean($this->input->post('service'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $account_no = $this->security->xss_clean($this->input->post('account_no'));
            $basic = $this->security->xss_clean($this->input->post('basic'));
            $da = $this->security->xss_clean($this->input->post('da'));
            $hra = $this->security->xss_clean($this->input->post('hra'));
            $ta = $this->security->xss_clean($this->input->post('ta'));
            $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
            $mgt_cont_to_pf_1 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_1'));
            $admin_charges_1 = $this->security->xss_clean($this->input->post('admin_charges_1'));
            $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
            $mgt_cont_to_pf_2 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_2'));
            $admin_charges_2 = $this->security->xss_clean($this->input->post('admin_charges_2'));
            $pf = $this->security->xss_clean($this->input->post('pf'));
            $pt = $this->security->xss_clean($this->input->post('pt'));
            $lic = $this->security->xss_clean($this->input->post('lic'));
            $school_loan = $this->security->xss_clean($this->input->post('school_loan'));
            $bank_guardian = $this->security->xss_clean($this->input->post('bank_guardian'));
            $sib = $this->security->xss_clean($this->input->post('sib'));
            $it = $this->security->xss_clean($this->input->post('it'));
            $lop = $this->security->xss_clean($this->input->post('lop'));
            $total_deduction = $this->security->xss_clean($this->input->post('total_deduction'));
            $net_amount = $this->security->xss_clean($this->input->post('net_amount'));


           
                    $info = array(
                        'staff_id' => $staff_id, 
                        'service' => $service, 
                        'category' => $category, 
                        'account_no' => $account_no, 
                        'basic' => $basic, 
                        'da' => $da, 
                        'hra' => $hra, 
                        'ta' => $ta, 
                        'grade_pay' => $grade_pay, 
                        'mgt_cont_to_pf_1' => $mgt_cont_to_pf_1, 
                        'admin_charges_1' => $admin_charges_1, 
                        'gross_salary' => $gross_salary, 
                        'mgt_cont_to_pf_2' => $mgt_cont_to_pf_2, 
                        'admin_charges_2' => $admin_charges_2, 
                        'pf' => $pf, 
                        'pt' => $pt, 
                        'lic' => $lic, 
                        'school_loan' => $school_loan, 
                        'bank_guardian' => $bank_guardian, 
                        'sib' => $sib, 
                        'it' => $it, 
                        'lop' => $lop, 
                        'total_deduction' => $total_deduction, 
                        'net_amount' => $net_amount,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' =>date('Y-m-d H:i:s'));

                $return_id = $this->salary->updateSalarySlipInfo($info,$row_id);
            
                if($return_id){
                    $this->session->set_flashdata('success', 'Salary Slip Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Salary Slip Update failed');
                }
                redirect('editSalarySlip/'.$row_id);
            }
        }
    }
  

    public function deleteSalarySlip(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->salary->updateSalarySlipInfo($info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

//    public function addSalarySlip(){
        
//         $year = $this->security->xss_clean($this->input->post('year'));
//         $month = $this->security->xss_clean($this->input->post('month'));

//         // Validate year and month (optional but recommended)
//         if (is_numeric($year) && $year >= 0 && $year <= 9999 && is_string($month)) {
//             // Convert the month name to a month number (1 to 12)
//             $monthNumber = date('n', strtotime("1 $month 2000"));
//             // Get the number of days in the specified month and year
//             $numDays = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
//         }
//            // Find the start and end dates of the specified month and year
//         $date_from = date('Y-m-01', strtotime("$year-$monthNumber-01"));
//         $date_to = date('Y-m-t', strtotime("$year-$monthNumber-01"));
//         $filter = array();
//         if($this->role == ROLE_MANAGER){
//             $filter['staff_factory'] = $this->factory;
//         }
//         $staffInfo = $this->staff->getAllStaffInfoSalarySlipGenartion($filter);

//           foreach($staffInfo as $staff) {
//             $IsExists = $this->salary->CheckSlarySlipGenerated($staff->staff_id,$year,$month);
//             if(empty($IsExists)){
//                     $working_day = 0;
//                     $attInformation = $this->salary->getSingleStaffAttendanceInfoAB($staff->staff_id,$date_from,$date_to);
//                     foreach($attInformation as $attInfo) { 
//                             if(!empty($attInfo->punch_time)){
//                                 $working_day++;
//                             }
//                     }
//                 if($working_day!=0){
//                     if(!empty($staff->salary_id)){
//                         $total_advance_salary = 0;
//                         $AdvanceSalaryInfo = $this->salary->getStaffAdvanceSalaryInfo($staff->staff_id);
//                         $OTInfo = $this->salary->getStaffOtInfo($staff->staff_id,$date_from,$date_to);
                        
//                         $total_allowances = $staff->hr + $staff->con + $staff->da ;
//                         $total_salary = $staff->basic_salary + $total_allowances + $OTInfo;
//                         $basic_deduction = ($staff->basic_salary * $working_day)/$numDays;
//                         $allowance_deduction = ($total_allowances * $working_day)/$numDays;
//                         $salary_paid = $basic_deduction + $allowance_deduction + $OTInfo;

//                         foreach($AdvanceSalaryInfo as $advanceInfo){
//                             $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
//                             $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
//                             if($PaidAmount > 0){
//                                 $advance_salary = $advanceInfo->installment_amount;
//                             }else{
//                                 $advance_salary = 0;
//                             }
//                             $total_advance_salary += $advance_salary;
//                         }
                        
//                         $pf = ($basic_deduction*$staff->pf)/100;
//                         $esi = ($basic_deduction*$staff->esi)/100;
//                         $pt = ($basic_deduction*$staff->pt)/100;
//                         $total_deduction = round($pf,2) + round($esi,2) + round($pt,2) + $total_advance_salary;
//                         $net_amount =  round($salary_paid,2) - round($total_deduction,2) ;

                       
//                         $info = array(
//                             'staff_id' => $staff->staff_id, 
//                             'account_no' => $staff->bank_account_no, 
//                             'basic' => $staff->basic_salary, 
//                             'hr' => $staff->hr, 
//                             'con' => $staff->con, 
//                             'da' => $staff->da, 
//                             'total_days' => $numDays, 
//                             'working_day' => $working_day, 
//                             'total_allowances' => $total_allowances, 
//                             'total_salary' => $total_salary, 
//                             'basic_deduction' => round($basic_deduction,2), 
//                             'allowance_deduction' => round($allowance_deduction,2), 
//                             'salary_paid' => round($salary_paid,2), 
//                             'pf' => round($pf,2), 
//                             'esi' => round($esi,2), 
//                             'pt' => round($pt,2),
//                             'advance_salary' => $total_advance_salary, 
//                             'total_deduction' => round($total_deduction,2), 
//                             'net_amount' => round($net_amount,2),
//                             'tax_regime' => $staff->tax_regime,
//                             'ot_amount' =>$OTInfo,
//                             'year' => $year,
//                             'month' => $month,
//                             'date' => date('Y-m-d'),
//                             'created_by'=>$this->staff_id,
//                             'created_date_time'=>date('Y-m-d H:i:s'));
//                         $result = $this->salary->addSalarySlipInfo($info);

//                         foreach($AdvanceSalaryInfo as $advanceInfo){
//                             $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
//                             $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
//                             if($PaidAmount > 0){
//                                 $advance_salary_amount = $advanceInfo->installment_amount;
//                             }else{
//                                 $advance_salary_amount = 0;
//                             }
//                             if($PaidAmount > 0){
//                                 $info = array(
//                                     'staff_id' => $staff->staff_id, 
//                                     'total_amount' => $advanceInfo->advance_amount, 
//                                     'advance_id' => $advanceInfo->row_id, 
//                                     'salary_slip_id' => $result,
//                                     'installment_amount' => $advance_salary_amount, 
//                                     'year' => $year,
//                                     'month' => $month,
//                                     'date' => date('Y-m-d'),
//                                     'created_by'=>$this->staff_id,
//                                     'created_date_time'=>date('Y-m-d H:i:s'));
//                                 $this->salary->addAdvanceSalaryInstallmentInfo($info);
//                             }
//                         }
//                     }
//                 }
//             }
                    
//         } 
//         if($result>0){
//             $this->session->set_flashdata('success', 'Salary Slip Generated successfully');
//         } else {
//             $this->session->set_flashdata('error', 'Salary Slip Generation failed');
//         }
//         redirect('salarySlipListing');
//     } 

        // view TCpublic 
        public function getStaffSalaryPrint(){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                error_reporting(0);
                $filter = array();
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                $filter['student_id'] = $student_id;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip';
                $data['staffData'] = $this->salary->getStaffSalarySlipInfoById($filter);
                define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','format' => 'A4-L']);
                $mpdf->AddPage('P','','','','',10,10,8,8,8,8);
                $mpdf->SetTitle('Staff Salary Slip');
                $html = $this->load->view('salary/printSalarySlip',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('Salary_Slip.pdf', 'I');
            }
        }
        public function downloadStaffSalaryReport(){
            if($this->isAdmin() == TRUE)
            {
                $this->loadThis();
            } else {
                $salary_month = $this->security->xss_clean($this->input->post('salary_month'));
                $salary_year = $this->security->xss_clean($this->input->post('salary_year'));
                $filter['salary_month'] = $salary_month;
                $filter['salary_year'] = $salary_year;
                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                $this->excel->getActiveSheet()->setTitle('STAFF SALARY DETAILS');
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "STAFF SALARY DETAILS ".strtoupper($salary_month).' - '.$salary_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:U1');
                $this->excel->getActiveSheet()->mergeCells('A2:U2');
                $this->excel->getActiveSheet()->mergeCells('A3:U3');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:U2')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(16);
                $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                $this->excel->getActiveSheet()->setCellValue('A3', "");
                $this->excel->getActiveSheet()->mergeCells('A3:S3');
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);
          
          
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Staff ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Role');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Institution Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'No. Of Days');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Days Worked');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Basic Wages');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'HR-1');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'CON-1');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K4', 'Total Allowances');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L4', 'OT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M4', 'Total Salary');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N4', 'Deduction on Basics');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O4', 'Deduction on Allowances');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P4', 'Salary Paid');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q4', 'P.F');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('R4', 'E.S.I');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('S4', 'Advance Amount');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('T4', 'Total Deduction');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('U4', 'Net Wage Paid');
                
                $this->excel->getActiveSheet()->getStyle('A4:U4')->getAlignment()->setWrapText(true); 
                $this->excel->getActiveSheet()->getStyle('A4:U4')->getFont()->setBold(true); 
                $this->excel->getActiveSheet()->getStyle('A4:U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:U4')->applyFromArray($styleBorderArray);
                if($this->role == ROLE_MANAGER){
                    $filter['staff_factory'] = $this->factory;
                }
                $staffInfo = $this->salary->getStaffSalaryDetails($filter);
                $j=1;
                $excel_row = 5;
                if(!empty($staffInfo)){
                    foreach($staffInfo as $staff){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$staff->staff_id);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->role);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->factory_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->total_days);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->working_day);
                     
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->basic);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$staff->hr);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$staff->con);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,$staff->total_allowances);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,$staff->ot_amount);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row,$staff->total_salary);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row,round($staff->basic_deduction,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row,round($staff->allowance_deduction,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row,round($staff->salary_paid,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row,round($staff->pf,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row,round($staff->esi,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row,round($staff->advance_salary,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('T'.$excel_row,round($staff->total_deduction,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('U'.$excel_row,round($staff->net_amount,2));
                        
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':U'.$excel_row)->applyFromArray($styleBorderArray);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':U'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $excel_row++;
                    }
                }
              
                $this->excel->createSheet();
                //}
                $filename='just_some_random_name.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
          
                $response =  array(
                    'op' => 'ok',
                    'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
                );
                die(json_encode($response));
            }
          }

          public function updateSalaryAdvanceInfo(){
            $staff_row_id =$this->security->xss_clean($this->input->post('staff_row_id'));
            $Advance_row_id =$this->security->xss_clean($this->input->post('Advance_row_id'));
            $advance_amount = $this->security->xss_clean($this->input->post('advance_amount'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $repayment_period = $this->security->xss_clean($this->input->post('repayment_period'));
            $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
            $bank_tran_number = $this->security->xss_clean($this->input->post('bank_tran_number'));
            $bank_tran_date = $this->security->xss_clean($this->input->post('bank_tran_date'));
            $ref_number = $this->security->xss_clean($this->input->post('ref_number'));
            $neft_date = $this->security->xss_clean($this->input->post('neft_date'));
            $upi_number = $this->security->xss_clean($this->input->post('upi_number'));
            $installment_amount = $this->security->xss_clean($this->input->post('installment_amount'));
            $StaffInfo= array(
                'payment_type' => $payment_type,
                'date' =>date('Y-m-d',strtotime($date)),
                'advance_amount' => $advance_amount,
                'dd_number' => $dd_number,
                'installment_amount' => $installment_amount,
                'dd_date' => date('Y-m-d',strtotime($dd_date)),
                'repayment_period' => $repayment_period,
                'bank_tran_number' => $bank_tran_number,
                'bank_tran_date' =>date('Y-m-d',strtotime($bank_tran_date)),
                'bank_name' => $bank_name,
                'ref_number' => $ref_number,
                'neft_date' => date('Y-m-d',strtotime($neft_date)),
                'upi_number' => $upi_number,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'));
    
                $result = $this->salary->updateAdvancePaymentDetails($StaffInfo,$Advance_row_id);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'Advance Salary Info Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Advance Salary Info Updation failed');
                }
                redirect('editStaff/'.$staff_row_id);  
           
        
    }
    public function downloadStaffAdvanceSalaryReport(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $factory_name = $this->security->xss_clean($this->input->post('factory_name'));
          
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('STAFF ADVANCE SALARY INFO');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "STAFF ADVANCE SALARY INFO");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:J1');
            $this->excel->getActiveSheet()->mergeCells('A2:J2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
      
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(23);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
            if(!empty($date_from)){
                $this->excel->getActiveSheet()->setCellValue('A3', "Date From : ".$date_from." Date To : ".$date_to);
            }
            $this->excel->getActiveSheet()->mergeCells('A3:J3');
            $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
            // $this->excel->getActiveSheet()->setCellValue('E3', "Pass Type: ");
            // $this->excel->getActiveSheet()->mergeCells('E3:I3');
            $this->excel->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
      
      
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Staff ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Department');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Role');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Factory Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Advance Salary');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'Paid Amount');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'Pending Amount');
            
            $this->excel->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:J4')->applyFromArray($styleBorderArray);
            
            if(!empty($date_from) || !empty($date_from)){
                $filter['date_from'] = date('Y-m-d',strtotime($date_from)); 
                $filter['date_to'] = date('Y-m-d',strtotime($date_to)); 
            }
            $filter['factory_name'] =$factory_name;
            $staffInfo = $this->salary->getAllStaffAdvanceSalaryInfo($filter);
            $j=1;
            $excel_row = 5;
            if(!empty($staffInfo)){
                foreach($staffInfo as $staff){
                    $paid_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$staff->advance_id);
                    $pending_amount = $staff->advance_amount - $paid_amount;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$staff->staff_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->department);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->role);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->factory_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,date('d-m-Y',strtotime($staff->date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->advance_amount);
                    if(!empty($paid_amount)){
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$paid_amount);
                    }else{
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,0);
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$pending_amount);
                    
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':J'.$excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':J'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
            }
          
            $this->excel->createSheet();
            //}
            $filename='just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();
      
            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
            die(json_encode($response));
        }
      }

      public function addWorkingDaysToSalarySlip(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $year = $this->security->xss_clean($this->input->post('year'));
            $month = $this->security->xss_clean($this->input->post('month'));
           

            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
           
            $data['year'] = $year;
            $data['month'] = $month;
           
            if (is_numeric($year) && $year >= 0 && $year <= 9999 && is_string($month)) {
                // Convert the month name to a month number (1 to 12)
                $monthNumber = date('n', strtotime("1 $month 2000"));
                // Get the number of days in the specified month and year
                $data['numDays'] = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
                $data['class_held'] = $data['numDays'];
            }
           
            $data['staffInfo'] = $this->salary->getAllStaffInfoSalarySlipGenartion($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip Details';
            $this->loadViews("salary/addWorkingDays.php", $this->global, $data, NULL);
        }
    }
    public function addSalarySlip(){
        
        $year = $this->security->xss_clean($this->input->post('year'));
        $month = $this->security->xss_clean($this->input->post('month'));
        // $institution_name = $this->security->xss_clean($this->input->post('institution_name'));
        $filter = array();
        // $filter['institution_name'] = $institution_name;
            // Validate year and month (optional but recommended)
        if (is_numeric($year) && $year >= 0 && $year <= 9999 && is_string($month)) {
            // Convert the month name to a month number (1 to 12)
            $monthNumber = date('n', strtotime("1 $month 2000"));
            // Get the number of days in the specified month and year
            $numDays = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
        }
           // Find the start and end dates of the specified month and year
        $date_from = date('Y-m-01', strtotime("$year-$monthNumber-01"));
        $date_to = date('Y-m-t', strtotime("$year-$monthNumber-01"));

        // log_message('debug','$date_from '.$date_from);
        // log_message('debug','$date_to '.$date_to);

        $staffInfo = $this->salary->getStaffInfoSalarySlipGenartion($filter);

        // log_message('debug','$staffInfo '.print_r($staffInfo,true));

          foreach($staffInfo as $staff) {

            $staff_id = trim($staff->staff_id);
            $working_day = $this->input->post("working_day_".$staff_id);
            $numDays = $this->input->post("total_days_".$staff_id);
            $IsExists = $this->salary->CheckSlarySlipGenerated($staff->staff_id,$year,$month);
            if(empty($IsExists)){
                if($working_day!=0){
                    if(!empty($staff->salary_id)){
                        $total_advance_salary = 0;
                        $AdvanceSalaryInfo = $this->salary->getStaffAdvanceSalaryInfo($staff->staff_id);
                        $OTInfo = $this->salary->getStaffOtInfo($staff->staff_id,$date_from,$date_to);
                        
                        $total_allowances = $staff->hr + $staff->con + $staff->da ;
                        $total_salary = $staff->basic_salary + $total_allowances + $OTInfo;
                        $basic_deduction = ($staff->basic_salary * $working_day)/$numDays;
                        $allowance_deduction = ($total_allowances * $working_day)/$numDays;
                        $salary_paid = $basic_deduction + $allowance_deduction + $OTInfo;

                        foreach($AdvanceSalaryInfo as $advanceInfo){
                            $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                            $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                            if($PaidAmount > 0){
                                $advance_salary = $advanceInfo->installment_amount;
                            }else{
                                $advance_salary = 0;
                            }
                            $total_advance_salary += $advance_salary;
                        }
                        $pf = ($basic_deduction*$staff->pf)/100;
                        $esi = ($basic_deduction*$staff->esi)/100;
                        $pt = $staff->pt;
                        $total_deduction = round($pf,2) + round($esi,2) + $pt + $total_advance_salary;


                        $net_amount =  round($salary_paid,2) - round($total_deduction,2) ;
                        
                        // log_message('debug','$net_amount '.$net_amount);

                        $info = array(
                            'staff_id' => $staff->staff_id, 
                            'account_no' => $staff->account_no, 
                            'basic' => $staff->basic_salary, 
                            'hr' => $staff->hr, 
                            'con' => $staff->con, 
                            'da' => $staff->da, 
                            'total_days' => $numDays, 
                            'working_day' => $working_day, 
                            'total_allowances' => $total_allowances, 
                            'total_salary' => $total_salary, 
                            'basic_deduction' => round($basic_deduction,2), 
                            'allowance_deduction' => round($allowance_deduction,2), 
                            'salary_paid' => round($salary_paid,2), 
                            'pf' => round($pf,2), 
                            'esi' => round($esi,2), 
                            'pt' => round($pt,2),
                            'advance_salary' => $total_advance_salary, 
                            'total_deduction' => round($total_deduction,2), 
                            'net_amount' => round($net_amount,2),
                            'tax_regime' => $staff->tax_regime,
                            'ot_amount' =>$OTInfo,
                            'year' => $year,
                            'month' => $month,
                            'date' => date('Y-m-d'),
                            'created_by'=>$this->staff_id,
                            'created_date_time'=>date('Y-m-d H:i:s'));
                        $result = $this->salary->addSalarySlipInfo($info);

                        foreach($AdvanceSalaryInfo as $advanceInfo){
                            $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                            $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                            if($PaidAmount > 0){
                                $advance_salary_amount = $advanceInfo->installment_amount;
                            }else{
                                $advance_salary_amount = 0;
                            }
                            if($PaidAmount > 0){
                                $info = array(
                                    'staff_id' => $staff->staff_id, 
                                    'total_amount' => $advanceInfo->advance_amount, 
                                    'advance_id' => $advanceInfo->row_id, 
                                    'salary_slip_id' => $result,
                                    'installment_amount' => $advance_salary_amount, 
                                    'year' => $year,
                                    'month' => $month,
                                    'date' => date('Y-m-d'),
                                    'created_by'=>$this->staff_id,
                                    'created_date_time'=>date('Y-m-d H:i:s'));
                                $this->salary->addAdvanceSalaryInstallmentInfo($info);
                            }
                        }
                    }
                }
            }else{
                if($working_day!=0){
                    if(!empty($staff->salary_id)){
                        $total_advance_salary = 0;
                        $AdvanceSalaryInfo = $this->salary->getStaffAdvanceSalaryInfo($staff->staff_id);
                        $OTInfo = $this->salary->getStaffOtInfo($staff->staff_id,$date_from,$date_to);
                        
                        $total_allowances = $staff->hr + $staff->con + $staff->da ;
                        $total_salary = $staff->basic_salary + $total_allowances + $OTInfo;
                        $basic_deduction = ($staff->basic_salary * $working_day)/$numDays;
                        $allowance_deduction = ($total_allowances * $working_day)/$numDays;
                        $salary_paid = $basic_deduction + $allowance_deduction + $OTInfo;

                        foreach($AdvanceSalaryInfo as $advanceInfo){
                            $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                            $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                            if($PaidAmount > 0){
                                $advance_salary = $advanceInfo->installment_amount;
                            }else{
                                $advance_salary = 0;
                            }
                            $total_advance_salary += $advance_salary;
                        }
                        
                        $pf = ($basic_deduction*$staff->pf)/100;
                        $esi = ($basic_deduction*$staff->esi)/100;
                        $pt = $staff->pt;
                        $total_deduction = round($pf,2) + round($esi,2) + $pt + $total_advance_salary;
                        $net_amount =  round($salary_paid,2) - round($total_deduction,2) ;

                        $info = array(
                            'staff_id' => $staff->staff_id, 
                            'account_no' => $staff->bank_account_no, 
                            'basic' => $staff->basic_salary, 
                            'hr' => $staff->hr, 
                            'con' => $staff->con, 
                            'da' => $staff->da, 
                            'total_days' => $numDays, 
                            'working_day' => $working_day, 
                            'total_allowances' => $total_allowances, 
                            'total_salary' => $total_salary, 
                            'basic_deduction' => round($basic_deduction,2), 
                            'allowance_deduction' => round($allowance_deduction,2), 
                            'salary_paid' => round($salary_paid,2), 
                            'pf' => round($pf,2), 
                            'esi' => round($esi,2), 
                            'pt' => round($pt,2),
                            'advance_salary' => $total_advance_salary, 
                            'total_deduction' => round($total_deduction,2), 
                            'net_amount' => round($net_amount,2),
                            'tax_regime' => $staff->tax_regime,
                            'ot_amount' =>$OTInfo,
                            'year' => $year,
                            'month' => $month,
                            'updated_by'=>$this->staff_id,
                            'updated_date_time'=>date('Y-m-d H:i:s'));
                        $result = $this->salary->updateSalarySlipInfo($info,$IsExists->row_id);
                        $deleteAdvanceSalaryInfo = array(
                            'is_deleted'=>1
                        );
                        $this->salary->deleteAdanceInstallmentInfo($IsExists->row_id,$deleteAdvanceSalaryInfo);
                        foreach($AdvanceSalaryInfo as $advanceInfo){
                            $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                            $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                            if($PaidAmount > 0){
                                $advance_salary_amount = $advanceInfo->installment_amount;
                            }else{
                                $advance_salary_amount = 0;
                            }
                            if($PaidAmount > 0){
                                $info = array(
                                    'staff_id' => $staff->staff_id, 
                                    'total_amount' => $advanceInfo->advance_amount, 
                                    'advance_id' => $advanceInfo->row_id, 
                                    'salary_slip_id' => $result,
                                    'installment_amount' => $advance_salary_amount, 
                                    'year' => $year,
                                    'month' => $month,
                                    'date' => date('Y-m-d'),
                                    'created_by'=>$this->staff_id,
                                    'created_date_time'=>date('Y-m-d H:i:s'));
                                $this->salary->addAdvanceSalaryInstallmentInfo($info);
                            }
                        }
                    }
                }
            }
                    
        } 
        if($result>0){
            $this->session->set_flashdata('success', 'Salary Slip Generated successfully');
        } else {
            $this->session->set_flashdata('error', 'Salary Slip Generation failed');
        }
        redirect('salarySlipListing');
    } 
}
?>

