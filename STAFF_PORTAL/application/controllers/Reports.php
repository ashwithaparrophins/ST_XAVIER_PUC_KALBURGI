<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
// require FCPATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


class Reports extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('staff_model', 'staff');
        $this->load->model('Students_model', 'student');
        $this->load->model('subjects_model', 'subject');
        $this->load->model('settings_model', 'settings');
        $this->load->model('admissionEnquiry_model', 'admission');
        $this->load->model('application_model', 'application');
        $this->load->model('Mun_model', 'mun');
        $this->load->model('fee_model', 'fee');
        $this->load->model('transport_model','transport');
        $this->load->model('leave_model', 'leave');
        $this->load->model('sms_model', 'sms');
        $this->load->library('excel');
        $this->load->library('pdf');
        $this->isLoggedIn();
    }

    public function reportDashboard()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['designation'] = $this->staff->getStaffRoles();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['staffInfo'] = $this->staff->getAllStaffInfo();
            $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
            $data['routeInfo'] = $this->transport->getTransportNameInfo();
            $data['busNoInfo'] = $this->transport->getTransportBusNo();
            $data['miscellaneousTypeInfo'] = $this->settings->getAllMiscellaneousTypeInfo();
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Reports';
            $this->loadViews("reports/reports", $this->global, $data, NULL);
        }
    }


    public function downloadAdmissionEnquiryExcelReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            set_time_limit(0);
            $term_name = $this->security->xss_clean($this->input->post('term_name'));

            $filter = array();
            if ($term_name == 'PU1') {
                $term = 'I PUC';
            } else {
                $term = 'II PUC';
            }
            if (!empty($term_name)) {
                $filter['term_name'] = $term_name;
                $data['term_name'] = $term_name;
            }


            $sheet = 0;
            $j = 1;
            $excel_row = 6;
            $section_name = $sections[$sheet];
            $this->excel->setActiveSheetIndex($sheet);

            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term_name . '-' . " Admission Enquiry Report 2021-2022");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            // $this->excel->getActiveSheet()->mergeCells('A3:K3');



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Email');

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Term');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Phone No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Course');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Elective');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Current Institution');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'Exam Coaching');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Comment');
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:K4')->applyFromArray($styleBorderArray);
            $this->excel->getActiveSheet()->getStyle('A5:K999')->applyFromArray($styleBorderArray);
            $filter['term_name'] = $term_name;
            $students = $this->admission->getAdmissionEnquiryInfoForReportDownload($filter);

            $excel_row = 4;
            foreach ($students as $student) {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->email);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $student->term_name);

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->phone_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->program_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->elective_sub);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->current_institution_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->exam_coaching);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->comment);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }

            $this->excel->createSheet();

            $filename = $term_name . '_Admission_Enquiry_Report.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    //download fee structure format
    public function downloadDayWiseFeeReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:J1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID FOR THE YEAR - 2024");
            $spreadsheet->getActiveSheet()->mergeCells("A2:J2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Date');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Receipt No.');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Order Id');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Mode');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('B:K')->getAlignment()->setHorizontal('center');
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
           
            $filter = array();
            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            $filter['preference'] = $preference;
            $filter['term_name'] = $term_name;
            // foreach($feeTypeInfo as $type){
          
                $studentInfo = $this->fee->getAllFeePaymentInfoForReport($filter);
                
                if (!empty($studentInfo)) {
                    foreach ($studentInfo as $std) {
                        //$frenchFeePaid = $this->fee->getFrenchFeePaidByReceipt($std->row_id);
                        if($frenchFeePaid == ''){
                            $frenchFeePaid = 0;
                        }
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_id);
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->stream_name);
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->ref_receipt_no);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->order_id);
                        $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $std->paid_amount);
                        $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $std->payment_type);
                        $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $std->pending_balance);

                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                        $sl_number++;
                        $excel_row++;
                    }
                }
       
           
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
         

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_paid_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }

    public function downloadRejectedAppFeeReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            // $preference = $this->security->xss_clean($this->input->post('preference'));
            // $date_from = $this->security->xss_clean($this->input->post('date_from'));
            // $date_to = $this->security->xss_clean($this->input->post('date_to'));
            
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:J1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " REJECTED APPLICATION FEES PAID FOR THE YEAR -" . date('Y'));
            $spreadsheet->getActiveSheet()->mergeCells("A2:J2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Date');
          //  $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
          //  $spreadsheet->getActiveSheet()->setCellValue('E3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Receipt No.');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Order Id');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Mode');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('B:K')->getAlignment()->setHorizontal('center');
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
           
            $filter = array();
            // $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            // $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            // $filter['preference'] = $preference;
            $filter['term_name'] = $term_name;
            // foreach($feeTypeInfo as $type){
          
                $studentInfo = $this->fee->getRejectedAppFeePaymentInfoForReport($filter);
                
                if (!empty($studentInfo)) {
                    foreach ($studentInfo as $std) {
                        //$frenchFeePaid = $this->fee->getFrenchFeePaidByReceipt($std->row_id);
                        if($frenchFeePaid == ''){
                            $frenchFeePaid = 0;
                        }
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                       // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_id);
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                      //  $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->stream_name);
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->ref_receipt_no);
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->order_id);
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->paid_amount);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->payment_type);
                        $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $std->pending_balance);

                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                        $sl_number++;
                        $excel_row++;
                    }
                }
       
           
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
         

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_paid_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }
    public function downloadFeeDueReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $year = $this->security->xss_clean($this->input->post('year'));
            // log_message('debug','term_name'.$term_name);
            // $year = $this->security->xss_clean($this->input->post('year'));
            // log_message('debug','year'.$year);
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', "ST XAVIER’S PRE–UNIVERSITY COLLEGE, KALABURAGI");
            $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES DUE REPORT-" .$year);
            $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
            // $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
            // $spreadsheet->getActiveSheet()->setCellValue('E3', 'Lang');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
            // $spreadsheet->getActiveSheet()->setCellValue('G3', 'SC/ST/CATI');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
            // $spreadsheet->getActiveSheet()->setCellValue('I3', 'French Fee');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Total Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Pending');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Concession');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Scholarship');

            $spreadsheet->getActiveSheet()->getStyle("A3:K3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:I500')->applyFromArray($styleBorderArray);

            $spreadsheet->getActiveSheet()->getStyle('A3:J3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A:K')->getAlignment()->setHorizontal('center');
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
           
           
            // foreach($feeTypeInfo as $type){
            if ($term_name == 'I PUC') {

                $studentInfo = $this->student->getAllStudentInfo_For_FeeDuereport($term_name,$preference,$year);
            
                foreach ($studentInfo as $std) {
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'I PUC';
                    $filter['stream_name'] = $std->stream_name;
                   
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_amount = $total_fees = $total_fee->total_fee;
                    $total_paid_amount = $this->fee->getTotalFeePaidReportInfo($std->row_id,$year);
                    $paidInfo = $this->fee->getFeePaidInfoAttempt($std->row_id,$year);

                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount;
                    }
                    if($paidInfo->attempt == '1'){
                        $total_fee_amount = $total_fee_amount -2000;
                    }else{
                        $total_fee_amount =$total_fee_amount;
                    }
                    $feeConcession = $this->fee->getStudentFeeConcession($std->row_id);
                
                    if(!empty($feeConcession)){
                        $concession_amt = $feeConcession->fee_amt;
                    }else{
                        $concession_amt = 0;
                    }
                    $feeScholarship = $this->fee->getStudentFeeScholarship($std->row_id);
                
                    if(!empty($feeScholarship)){
                        $scholarship_amt = $feeScholarship->fee_amt;
                    }else{
                        $scholarship_amt = 0;
                    }
                    if($total_fee_amount - $total_paid_amount->paid_amount - $concession_amt - $scholarship_amt> 0){
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                        // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fees);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount - $concession_amt - $scholarship_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row, $concession_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$excel_row, $scholarship_amt);

                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    
                        $sl_number++;
                        $excel_row++;
                    }
                }
            } else {
                if($year == CURRENT_YEAR ){
                    $yr = $year-1;
                }else{
                    $yr = $year-2;
                }
                $studentInfo = $this->student->getAllStudentInfo_For_FeeDuereport($term_name,$preference,$yr);
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                  

                    // $filter['category'] = strtoupper($std->category);

                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_amount = $total_fees =$total_fee->total_fee;
                    if($year== CURRENT_YEAR){
                       
                        $total_paid_amount = $this->fee->getTotalFeePaidReportInfo($std->row_id,$year);
                       //  log_message('debug','paid'.print_r($total_paid_amount,true));
                    }else{
                        $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoIIPucLastYear($application_no);
                    }
                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount;
                    }
                    $paidInfo = $this->fee->getFeePaidInfoAttempt($std->row_id,$year);

                    if($paidInfo->attempt == '1'){
                        $total_fee_amount = $total_fee_amount -2000;
                    }else{
                        $total_fee_amount =$total_fee_amount;
                    }
                    $feeConcession = $this->fee->getStudentFeeConcession($std->row_id);
                
                    if(!empty($feeConcession)){
                        $concession_amt = $feeConcession->fee_amt;
                    }else{
                        $concession_amt = 0;
                    }
                    $feeScholarship = $this->fee->getStudentFeeScholarship($std->row_id);
                
                    if(!empty($feeScholarship)){
                        $scholarship_amt = $feeScholarship->fee_amt;
                    }else{
                        $scholarship_amt = 0;
                    }
                    if($total_fee_amount - $total_paid_amount->paid_amount - $concession_amt - $scholarship_amt> 0){

                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                        // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                        
                    
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fees);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount - $concession_amt - $scholarship_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row, $concession_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('I'.$excel_row, $scholarship_amt);
                    $excel_row++;
                    $sl_number++;

                    }
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                }
            }
            // $excel_row++;

            // //$sl_number++;
            // $excel_row++;
            // }
            // $excel_row++;
            // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
            // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
            // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
            // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
            //getting optional fee info


            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_structure_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }
    public function downloadFeePaidReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $year = $this->security->xss_clean($this->input->post('year'));
          
            
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:I1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID FOR THE YEAR - ".$year);
            $spreadsheet->getActiveSheet()->mergeCells("A2:I2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No.');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Payment Date');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Receipt No.');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Total Fee');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Fee Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:I3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle("A3:I3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('B:K')->getAlignment()->setHorizontal('center');
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
           
            $filter = array();
         
            $filter['preference'] = $preference;
            $filter['term_name'] = $term_name;
            $filter['year'] = $year;

            // foreach($feeTypeInfo as $type){
          
                $studentInfo = $this->fee->getAllFeePaymentInfoForDueReport($filter);
                
                if (!empty($studentInfo)) {
                    foreach ($studentInfo as $std) {
                        $feeInfo = $this->fee->getTotalFeeAmountForReport($term_name,$preference,$year);
                        $total_fee = $feeInfo->total_fee;
                        $feePaidInfo = $this->fee->getFeePaidInfoForReport($std->row_id,$year);
                       
                        if(!empty($feePaidInfo->paid_amount)){
                            $paid_amt = $feePaidInfo->paid_amount;
                        }else{
                            $paid_amt = 0;
                        }
                        $pending_bal = $total_fee - $paid_amt;
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_id);
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->stream_name);
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->ref_receipt_no);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row, $std->total_amount);
                        $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $std->paid_amount);
                        $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $std->pending_balance);

                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                        $sl_number++;
                        $excel_row++;
                    }
                }
       
           
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
         

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_due_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }



    //download fee structure format
    public function download_fee_structure_excel()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES STRUCTURE FOR THE YEAR -" .$year);
            $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Student ID');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Lang');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'SC/ST/CATI');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Payable');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'French Fee');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Total Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('K3', 'Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:K3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:J3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A:K')->getAlignment()->setHorizontal('center');
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);

            // foreach($feeTypeInfo as $type){
            if ($term_name == 'I PUC') {

                $studentInfo = $this->application->getAdmissionCompletedStudent($year);
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  "");
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_number);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->second_language);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->student_category);
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'I PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->second_language) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                        $french_fee = 5000;
                    } else {
                        $filter['lang_fee_status'] = false;
                        $french_fee = 0;
                    }

                    $filter['category'] = strtoupper($std->student_category);
                    $boardInfo = $this->application->getStudentRegisteredInfo($std->resgisted_tbl_row_id);
                    $data['board_id'] = $boardInfo->sslc_board_name_id;
                    if ($boardInfo->sslc_board_name_id == 1) {
                        $filter['board_name'] = "SSLC";
                    } else {
                        $filter['board_name'] = "OTHER";
                    }
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_amount = $total_fee->total_fee;
                    $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2021_I_PUC($std->application_number,$year);
                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount;
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $french_fee);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            } else {
                if($year == CURRENT_YEAR ){
                    $yr = $year-1;
                }else{
                    $yr = $year-2;
                }
                $studentInfo = $this->student->getAllStudentInfo_For_Fee_report($term_name,$yr);
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {

                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->elective_sub);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->category);
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->elective_sub) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                        $french_fee = 5000;
                    } else {
                        $filter['lang_fee_status'] = false;
                        $french_fee = 0;
                    }

                    $filter['category'] = strtoupper($std->category);

                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_amount = $total_fee->total_fee;
                    if($year== CURRENT_YEAR){
                        $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2021($std->application_no,$year);
                    }else{
                        $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoIIPucLastYear($application_no);
                    }
                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount;
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $french_fee);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            }
            // $excel_row++;

            // //$sl_number++;
            // $excel_row++;
            // }
            // $excel_row++;
            // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
            // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
            // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
            // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
            //getting optional fee info




            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_structure_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }


    public function downloadApplicationStack()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $board_name = $this->security->xss_clean($this->input->post('by_board'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year')); 
            $category_by = $this->security->xss_clean($this->input->post('by_category'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));

            if($admission_year ==2022){

                $header = ' LIST 2022-2023';
            }else{
                $header = ' LIST 2021-2022';

            }

            if($report_type == 'APPLICATION_REJECTED'){

                $typee = 'REJECTED';
            }else{
                $typee = ' APPROVED';

            }
            
            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );
            for ($sheet = 0; $sheet < count($category); $sheet++) {
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet

                $this->excel->getActiveSheet()->setTitle($category[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $typee . $header);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:L1');
                $this->excel->getActiveSheet()->mergeCells('A2:L2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);


                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);



                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preference');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Integrated Batch');
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                $this->excel->getActiveSheet()->mergeCells('A4:L4');
                $this->excel->getActiveSheet()->getStyle('A4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet] . "- LIST");
                $this->excel->getActiveSheet()->getStyle('A4:L4')->getFont()->setBold(true);



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:L4')->applyFromArray($styleBorderArray);

                $students = $this->application->getApprovedListDetails($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type, $report_type,$admission_year,$integrated_batch);
                $j = 1;

                $excel_row = 5;
                if ($student_type == 'NCC') {
                    $student_type_print = 'NCC';
                } else if ($student_type == 'SPORTS') {
                    $student_type_print = 'SPORTS';
                } else if ($student_type == 'DYC') {
                    $student_type_print = 'Dyslexia';
                } else if ($student_type == 'PH') {
                    $student_type_print = 'PH';
                } else {
                    $student_type_print = 'ALL';
                }

                foreach ($students as $student) {
                    if ($student->board_name == 'KARNATAKA STATE BOARD') {
                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {
                        $board_name_sheet = 'OTHERS';
                    } else {
                        $board_name_sheet = $student->board_name;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->dyslexia_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->physically_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $student->integrated_batch);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':L' . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                $this->excel->createSheet();
            }
            $filename =  $report_type . '_Application_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    //  public function downloadApplicationStack(){
    //     if($this->isAdmin() == TRUE){
    //         setcookie('isDownLoaded',1); 
    //         $this->loadThis();
    //     } else {    

    //         $report_type = $this->security->xss_clean($this->input->post('report_type'));
    //         $preference = $this->security->xss_clean($this->input->post('preference'));
    //         $board_name = $this->security->xss_clean($this->input->post('by_board'));
    //         $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
    //         $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
    //         $student_type = $this->security->xss_clean($this->input->post('student_type')); 
    //         $category_by = $this->security->xss_clean($this->input->post('by_category'));
    //         $category = array(
    //             'ROMAN CATHOLIC',
    //             'OTHER CHRISTIANS',
    //             'GENERAL MERIT(GM)',
    //             'SC',
    //             'ST',
    //             'CAT-I',
    //             '2A',
    //             '3A',
    //             '2B',
    //             '3B');
    //         for($sheet = 0; $sheet < count($category);  $sheet++){
    //             $this->excel->setActiveSheetIndex($sheet);
    //             //name the worksheet

    //             $this->excel->getActiveSheet()->setTitle($category[$sheet]);
    //             $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

    //             //set Title content with some text
    //             $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
    //             $this->excel->getActiveSheet()->setCellValue('A2', "I PUC ".$preference." APPROVED LIST 2021-2022");
    //             $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    //             $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    //             $this->excel->getActiveSheet()->mergeCells('A1:G1');
    //             $this->excel->getActiveSheet()->mergeCells('A2:G2');
    //             $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);


    //             $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    //             $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
    //             $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    //             $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
    //             $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
    //             $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //             $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preference');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
    //             $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true); 
    //             $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true); 
    //             $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



    //             $this->excel->getActiveSheet()->mergeCells('A4:K4');
    //             $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet]."- LIST");
    //             $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



    //             $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    //             $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);

    //             $students = $this->application->getApprovedListDetails($preference,$category[$sheet],$board_name,$percentage_from,$percentage_to,$type,$student_type,$report_type);
    //             $j=1;

    //             $excel_row = 5;
    //             if($student_type == 'NCC'){
    //                 $student_type_print = 'NCC';
    //             }else if($student_type == 'SPORTS'){
    //                 $student_type_print = 'SPORTS';
    //             }else if($student_type == 'DYC'){
    //                 $student_type_print = 'Dyslexia';
    //             }else if($student_type == 'PH'){
    //                 $student_type_print = 'PH';
    //             }else{
    //                 $student_type_print = 'ALL';
    //             }

    //             foreach($students as $student){
    //                 if($student->board_name == 'KARNATAKA STATE BOARD'){
    //                     $board_name_sheet = 'SSLC';
    //                 } else if($student->board_name == 'OTHER'){
    //                     $board_name_sheet = 'OTHERS';
    //                 }else{
    //                     $board_name_sheet = $student->board_name;
    //                 }

    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$student->application_number);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->name);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$board_name_sheet);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$student->stream_name);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->student_category);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$student->sslc_percentage);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$student->dyslexia_challenged);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$student->physically_challenged);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$student->ncc_certificate_status);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,$student->national_level_sports_status);
    //                 $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':K'.$excel_row)->applyFromArray($styleBorderArray);
    //                 $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //                 $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':K'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //                 $excel_row++;
    //             }

    //             $this->excel->createSheet(); 

    //         }
    //         $filename =  $report_type.'_Application_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
    //         header('Content-Type: application/vnd.ms-excel'); //mime type
    //         header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    //         header('Cache-Control: max-age=0'); //no cache

    //         //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //         //if you want to save it as .XLSX Excel 2007 format
    //         $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    //         ob_start();
    //         setcookie('isDownLoaded',1);  
    //         $objWriter->save("php://output");
    //     }
    // }


    public function downloadAdmittedStudentInfo()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $preference = $this->security->xss_clean($this->input->post('stream_name'));
            $board_name = $this->security->xss_clean($this->input->post('by_board'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $category_by = $this->security->xss_clean($this->input->post('by_category'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));

            if($admission_year ==2022){

                $header = ' ADMITTED LIST 2022-2023';
            }else{
                $header = ' ADMITTED LIST 2021-2022';

            }
            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );
            $sheet = 0;
            //for($sheet = 0; $sheet < count($category);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet

            $this->excel->getActiveSheet()->setTitle($preference);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
            $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . $header);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preference');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Religion');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Elective');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            $this->excel->getActiveSheet()->mergeCells('A4:K4');
            $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet]."- LIST");
            $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:K4')->applyFromArray($styleBorderArray);

            $students = $this->application->getAdmittedListDetails($preference, $board_name, $percentage_from, $percentage_to, $type, $student_type, $report_type,$admission_year,$integrated_batch);
            $j = 1;

            $excel_row = 5;
            if ($student_type == 'NCC') {
                $student_type_print = 'NCC';
            } else if ($student_type == 'SPORTS') {
                $student_type_print = 'SPORTS';
            } else if ($student_type == 'DYC') {
                $student_type_print = 'Dyslexia';
            } else if ($student_type == 'PH') {
                $student_type_print = 'PH';
            } else {
                $student_type_print = 'ALL';
            }

            foreach ($students as $student) {
                if ($student->board_name == 'KARNATAKA STATE BOARD') {
                    $board_name_sheet = 'SSLC';
                } else if ($student->board_name == 'OTHER') {
                    $board_name_sheet = 'OTHERS';
                } else {
                    $board_name_sheet = $student->board_name;
                }

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->religion);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->second_language);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':K' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':K' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }

            $this->excel->createSheet();

            // }
            $filename =  $report_type . '_Application_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }
    public function downloadAdmissionRegisteredStudent()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $student = $this->security->xss_clean($this->input->post('by_student'));
            $term = $this->security->xss_clean($this->input->post('term'));
            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $by_sslc_board = $this->security->xss_clean($this->input->post('by_board'));
            $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
            $cellNameByStudentReport = array('G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            $this->excel->getActiveSheet()->setTitle($sheet);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:N500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $report_type . " Report");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:N1');
            $this->excel->getActiveSheet()->mergeCells('A2:N2');
            $this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel_row = 3;
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(16);

            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
            $this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'SL No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, 'DOB');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, 'Registration No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, 'Board Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, 'Mobile');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, 'Email');
            $filter['report_type'] = $report_type;
            // $filter['stream_name']= $stream[$sheet];
            $filter['by_sslc_board'] = $by_sslc_board;

            $filter['term'] = $term;
            $sl = 1;
            $excel_row = 4;
            $studentInfo = $this->application->getAllRegisteredStdInfo($filter);
            foreach ($studentInfo as $std) {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $std->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, date('d-m-Y', strtotime($std->dob)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $std->registration_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $std->board_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $std->mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $std->email);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C' . $excel_row . ':F' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();
            // }

        }

        $filename =  $report_type . '_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_start();
        setcookie('isDownLoaded', 1);
        $objWriter->save("php://output");
    }


    public function dayWiseStructureFeePayment()
    {
        $filter = array();
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $date_from = $this->security->xss_clean($this->input->post('date_from'));


        $cellNameByStudentReport = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF');
        $sheet = 0;
        $this->excel->setActiveSheetIndex($sheet);
        //name the worksheet
        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->excel->getActiveSheet()->setTitle('Fee Paid Report By Structure');
        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
        //set Title content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $this->excel->getActiveSheet()->setCellValue('A2', $term . " Fee Structure Report 2021-22");
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        // $this->excel->getActiveSheet()->setCellValue('A3', "Account Number : ".$bankAccount->account_no);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('A1:AF1');
        $this->excel->getActiveSheet()->mergeCells('A2:AF2');
        $this->excel->getActiveSheet()->mergeCells('A3:AF3');
        $this->excel->getActiveSheet()->getStyle('A1:AF3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $excel_row = 4;
        if (!empty($date_to) && !empty($date_from)) {
            $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
        } else {
            $filter['date_to'] = "";
            $filter['date_from'] = "";
        }

        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, 'Invoice No.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, 'Application No');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, 'Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, 'Stream');
        $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':Z' . $excel_row)->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $cell_name = 1;
        $bank_account_amount = array();
        $fee_structure_total = array();
        $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReport();
        $fee_type_name = "";
        $array_of_fee_type_id = array('');
        $fee_name_row_id = array('1', '2', '9', '4', '7', '3');
        foreach ($fee_name_row_id as $row_id) {
            $feeInfo = $this->fee->getFeeTitleInfoById($row_id);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $feeInfo->fee_name);

            $this->excel->getActiveSheet()->getStyle($cellNameByStudentReport[$cell_name] . $excel_row . ':Z' . $this->excel->getActiveSheet()->getHighestRow())
                ->getAlignment()->setWrapText(true);
            $cell_name++;
        }
        // foreach($feeStructureInfo as $fee){

        //     $fee_structure_total[$fee->row_id] = 0;
        //    // $fee_structure[$fee->row_id] = 0;
        //     // if($fee_type_name != $fee->fees_type){
        //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name].$excel_row, $fee->fee_name);

        //     $this->excel->getActiveSheet()->getStyle($cellNameByStudentReport[$cell_name].$excel_row.':Z'.$this->excel->getActiveSheet()->getHighestRow())
        //     ->getAlignment()->setWrapText(true);
        //     $cell_name++;
        //  //  }
        //   // $fee_type_name = $fee->fees_type;
        // }

        $this->excel->getActiveSheet()->getStyle('A4:Z4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name+1].$excel_row, 'Society Fee');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, 'Grand Total');
        $excel_row++;
        $grand_total = 0;
        $paidInfo = $this->fee->getFeePaidInfoForReport($date_from, $date_to);

        foreach ($paidInfo as $paid) {
            $cell_name = 1;
            $grand_total_date = 0;
            $fee_type_name = "";
            $amount = 0;
            $total_fee_row = 0;
            $elective = substr($paid->second_language, 0, 1);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, date('d-m-Y', strtotime($paid->payment_date)));
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $paid->row_id);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $paid->application_no);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $paid->name);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $paid->stream_name);

            // foreach($feeStructureInfo as $fee){
            //     $paidAmt = $this->fee->getFeeStructureAmount($paid->receipt_number,$fee->fees_type);
            //     $amount = $paidAmt->paid_amount;
            //     $total_fee_row += $amount;
            //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name].$excel_row, $amount);
            //     $cell_name++;
            // }
            $total_amt = array();
            foreach ($fee_name_row_id as $row_id) {
                $paidAmt = $this->fee->getFeeStructureAmount($paid->receipt_number, $row_id);
                if ($row_id == 7) {
                    $mgmtAmt = $this->fee->getMgmtFeePaidInfo($paid->application_no);
                    if (!empty($mgmtAmt)) {
                        $mgmt_amt = $mgmtAmt->amount;
                        $total_fee_row += $mgmtAmt->amount;
                        $total_mgnt_fee += $mgmt_amt;
                    } else {
                        $mgmt_amt = 0;
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $mgmt_amt);
                    $cell_name++;
                    // log_message('debug','ehue'.$total_fee_row);
                } else {
                    $amount = $paidAmt->paid_amount;
                    $total_fee_row += $amount;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $amount);
                    $cell_name++;
                }
            }


            // $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name+1].$excel_row, $mgmt_amt);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $total_fee_row);

            $this->excel->getActiveSheet()->getStyle('L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel_row++;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'Total');
        }
        $this->excel->getActiveSheet()->getStyle('A' . $excel_row)->getFont()->setBold(true);

        $date_from_ = strtotime($date_from); // Convert date to a UNIX timestamp  
        $date_to_ = strtotime($date_to); // Convert date to a UNIX timestamp  

        // Loop from the start date to end date and output all dates inbetween 

        for ($i = $date_from_; $i <= $date_to_; $i += 86400) {

            $date =  date("Y-m-d", $i);
            //  log_message('debug','fghjk='.$date); 



        }


        $this->excel->createSheet();
        $filename =  'Fees_Structure_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // $objWriter->setPreCalculateFormulas(true);  
        ob_start();
        setcookie('isDownLoaded', 1);
        $objWriter->save("php://output");
    }

    // exam mark sheet
    public function downloadExamMarkSheet()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $subject_code = $this->security->xss_clean($this->input->post('subject_code'));
            $filter = array();
            $filter['term'] = $term_name;
            $filter['subject_code'] = $subject_code;
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $stream_name;

            $term = $term_name;
            $cellNameCategory = array('E', 'F', 'G', 'H', 'I', 'J');
            $filter['section_name'] = $section_name;
            if ($section_name != "ALL") {
                $section = $section_name;
            } else {
                $section = '';
            }
            $sections = array($section_name);
            $subjectInfo = $this->subject->getAllSubjectByID($subject_code);
            $sheet = 0;
            $j = 1;
            $excel_row = 6;
            $filter['subject_name'] = $subjectInfo->sub_name;
            $subject_name = $subjectInfo->sub_name;
            // $class_section = $section_name[$sheet];
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($stream_name);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term . ' ' . $stream_name . ' ' . $section . " MARKS SHEET 2022-23");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:J1');
            $this->excel->getActiveSheet()->mergeCells('A2:J2');
            $this->excel->getActiveSheet()->getStyle('A1:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A1:J1');
            $this->excel->getActiveSheet()->mergeCells('A2:J2');
            $this->excel->getActiveSheet()->setCellValue('A3', strtoupper($subjectInfo->sub_name));
            $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A3:J3');


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);


            if ($subjectInfo->subject_code == 12) {
                $labStatus = 'true';
                $lab_title = 8;
            } else {
                $labStatus = $subjectInfo->lab_status;
                $lab_title = 8;
            }


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'REG. No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'NAME OF THE STUDENT');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'PASS MARKS');
            if ($labStatus == 'true') {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'LAB');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'UNIT TEST-1');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'ASSIGNMENT-2');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'LAB-' . $lab_title);
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'INT. ASSMNT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'TOTAL MARKS');

                // if($subjectInfo->subject_code != 12){
                //     $this->excel->setActiveSheetIndex($sheet)->setCellValue('H5', 'REC-10');
                // }
            } else {
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'ASSIGNMENT-1');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'UNIT TEST-1');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'ASSIGNMENT-2');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'INT. ASSMNT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'TOTAL MARKS');
            }


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D5', 'THEORY');


            // $this->excel->getActiveSheet()->getStyle('A3:J5')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:J5')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:J5')->applyFromArray($styleBorderArray);

            $students = $this->student->getStudentInfoForInternal($filter);
            // log_message('debug','dnd='.print_r($filter,true));
            $total_mark = 0;
            foreach ($students as $student) {
                $section = $student->section_name;
                $filter['section'] = $section;
                $percentage_active = false;
                $elective_sub = strtoupper($student->elective_sub);

                if ($labStatus == 'true') {
                    if ($subjectInfo->subject_code == 12) {
                        $pass_mark_theory = 18;
                        $pass_mark_lab = 0;
                    } else {
                        $pass_mark_theory = 12;
                        $pass_mark_lab = 0;
                    }
                } else {
                    $pass_mark_theory = 35;
                    $pass_mark_lab = 0;
                }

                $subject_code == $subjectInfo->subject_code;
                $total_class_held_per_std = 0;
                $total_attd_class_std = 0;
                $absentCount = 0;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $pass_mark_theory);

                $cellName = 0;
                if ($labStatus == 'true') {
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $pass_mark_lab);
                    $cellName++;
                    // $exam_type = array('ASSIGNMENT_I', 'ASSIGNMENT_II');
                    $exam_type = array('I_UNIT_TEST');
                    if ($subjectInfo->subject_code == 12) {
                        $lab_assessment = 8;
                    } else {
                        $lab_assessment = 8;
                    }
                } else {
                    // $exam_type = array('ASSIGNMENT_I', 'ASSIGNMENT_II');
                    $exam_type = array('I_UNIT_TEST');
                    $lab_assessment = 0;
                    // ,'INTERNAL_ASSESSMENT'
                }
                //,'LAB_ASSESSMENT','INTERNAL_ASSESSMENT'

                // if ($student->student_id == '20P5965' || $student->student_id == '20P4140' || $student->student_id == '20P1754') {
                //     $internal_assessment = 1;
                // } else {
                //     $internal_assessment = 5;
                // }
                $mark_obt = 0;
                $total_mark = 0;
                foreach ($exam_type as $exam) {

                    $stdMarkInfo = $this->student->getStudentFinalMarks($student->student_id, $subject_code, $exam);
                    $sub_marks = 0;
                    $mark_obt = 0;
                    // if ($stdMarkInfo->exam_type == 'ASSIGNMENT_I' || $stdMarkInfo->exam_type == 'ASSIGNMENT_II') {
                    //     if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
                    //         $mark_obt = 0;
                    //     } else {
                    //         $sub_marks = $this->getAssessmentMark($stdMarkInfo->obt_theory_mark, $stdMarkInfo->exam_type, $labStatus, $subject_code);
                    //         $mark_obt = $sub_marks;
                    //     }
                    // } else {
                        if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
                            $mark_obt = 0;
                        } else {
                            $mark_obt = $stdMarkInfo->obt_theory_mark;
                        }
                    // }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $mark_obt);
                    $total_mark += $mark_obt;
                    $cellName++;
                }
                if ($labStatus == 'true') {
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $lab_assessment);
                    $cellName++;
                }
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $internal_assessment);
                $totalMark = $total_mark + $pass_mark_theory + $pass_mark_lab + $lab_assessment;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $totalMark);
                $cellName++;

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':J' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':J' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel_row++;
            }

            $this->excel->createSheet();

            $filename =  $term . '_' . $stream_name . '_' . $subject_name . '_EXAM_MARKS_SHEET.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    // combined mark report - assignment exam
    public function downloadAssignmentExamMarkReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $j = 1;
            $sheet = 0;
            $term_name = $this->input->post("term_name");
            $stream_name = $this->input->post("stream_name");

            // $term_name = 'I PUC';
            $first_cell = array("L", "O", "R", "U");
            $middle_cell = array("M", "P", "S", "V");
            $last_cell = array("N", "Q", "T", "W");
            //$section = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q");
            $streamInfo = $this->student->getAllStreamName();

            if ($stream_name == 'ALL') {
                $stream_name = array(
                    'PCMB',
                    'PCMC',
                    'CEBA',
                    'SEBA',
                    'HESP',
                    'HEBA'
                );
            } else {
                $stream_name = array($stream_name);
            }

            // $term = 'I PUC';

            foreach ($stream_name as $stream) {
                $stream_name = $stream;
                $subjects = $this->getSubjectCodes($stream_name);
                // log_message('debug','subjects '.print_r($subjects,true));


                $this->excel->setActiveSheetIndex($sheet);
                // $sheet++;
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($stream_name);
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "ANNUAL EXAMINATION OF ".$term_name." AUGUST-2022");
                $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
                $this->excel->getActiveSheet()->setCellValue('A4', "MO: Marks Obtained | IA: Internal Assessment | TH: Theory | PR: Practical | LT: Language Total | ST: Subjects Total | TM: Total Marks");
                $this->excel->getActiveSheet()->setCellValue('A5', $term_name . " - " . $stream_name);

                //change the font size 
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
                $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle('A1:A5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('A1:Z1');
                $this->excel->getActiveSheet()->mergeCells('A2:Z2');
                $this->excel->getActiveSheet()->mergeCells('A3:Z3');
                $this->excel->getActiveSheet()->mergeCells('A4:Z4');
                $this->excel->getActiveSheet()->mergeCells('A5:Z5');
                $this->excel->getActiveSheet()->mergeCells('A6:A7');
                $this->excel->getActiveSheet()->mergeCells('C6:C7');
                $this->excel->getActiveSheet()->mergeCells('B6:B7');
                $this->excel->getActiveSheet()->mergeCells('D6:D7');
                $this->excel->getActiveSheet()->mergeCells('E6:E7');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //settting border style 
                $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:Z300')->applyFromArray($styleArray);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'SAT No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lang');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'Lng');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'Code');
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(38);

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G6', 'Language');
                $this->excel->getActiveSheet()->mergeCells('G6:I6');


                $this->excel->getActiveSheet()->mergeCells('X6:X7');
                $this->excel->getActiveSheet()->mergeCells('Y6:Y7');
                $this->excel->getActiveSheet()->mergeCells('Z6:Z7');

                $this->excel->getActiveSheet()->getStyle('G6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J6', 'English(02)');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J7', 'Marks');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K7', 'LT');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('X6', 'ST');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y6', 'TM');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z6', 'Result');

                //$this->excel->getActiveSheet()->mergeCells('K2:M2');
                $excel_row = 7;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(14);
                $this->excel->getActiveSheet()->getStyle('F1:F3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('E6:Z300')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I7:I999')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A6:Z7')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getStyle('J8:J150')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('X8:Z999')->getFont()->setBold(true);
                $this->cellColor('A6:Z7', 'D5DBDB');

                //first subject heading
                for ($i = 0; $i < 4; $i++) {
                    $subjectInfo = $this->subject->getAllSubjectByID($subjects[$i]);
                    $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(6);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '6', $subjectInfo->sub_name . '(' . $subjects[$i] . ')');
                    $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '6:' . $last_cell[$i] . '6');
                    $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '6:' . $last_cell[$i] . '6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($subjectInfo->lab_status == "true") {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'PR');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', "Marks");
                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '7:' . $last_cell[$i] . '7');
                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '7:' . $last_cell[$i] . '7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(5);
                    }
                }

                $studentInfo = $this->student->getStudentsToAnnualResultReport($term_name, $stream_name);
                $excel_row = 8;
                $k = 1;
                foreach ($studentInfo  as $row) {
                    $subjects_code = array();
                    $elective_sub = strtoupper($row->elective_sub);
                    if ($elective_sub == "KANNADA") {
                        array_push($subjects_code, '01');
                    } else if ($elective_sub == 'HINDI') {
                        array_push($subjects_code, '03');
                    } else if ($elective_sub == 'FRENCH') {
                        array_push($subjects_code, '12');
                    }
                    array_push($subjects_code, '02');
                    $subjects_code = array_merge($subjects_code, $subjects);
                    // log_message('debug','scdcndj'.print_r($subjects_code,true));

                    $first_language_code = '';
                    $first_language_name = '';
                    $total_marks_subjects = 0;
                    $total_marks_all_subjects = 0;
                    $fail_flag = false;
                    $student_status = 0;
                    // $data['studentsMarks'] = $this->exams->getFullMarksOfStudentInternal($row->student_id,$exam_type);

                    // if(!empty($data['studentsMarks']) && $student_status == 0){
                    $first_language_total = 0;
                    $second_lang_mark = 0;
                    $first_lan_TH = 0;
                    $first_lan_IA = 0;
                    $subject_code_from_subjects = 0;
                    foreach ($subjects_code as $subject) {
                        // foreach($data['studentsMarks']  as $mark){
                        $subject_true = false;
                        if ($subject == '01') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $first_language_code = $subject;
                            $first_language_name = "KAN";
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $first_lan_TH =  $theory_mark;
                            $first_lan_IA =  $lab_mark;
                            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;

                            $first_language_total =  $first_language_total;

                            // if($first_language_total < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     // log_message('debug','value==' .$pass_mark);
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }
                        } else if ($subject == '03') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $first_language_code = $subject;
                            $first_language_name = "HINDI";
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $first_lan_TH =  $theory_mark;
                            $first_lan_IA =  $lab_mark;
                            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                            $first_language_total =  $first_language_total;


                            // if($first_language_total < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }
                        } else if ($subject == '12') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $first_language_code = $subject;
                            $first_language_name = "FRENCH";
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $first_lan_TH =  $theory_mark;
                            $first_lan_IA =  $lab_mark;
                            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                            $first_language_total =  $first_language_total;

                            // if($first_lan_TH < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // } else if($first_language_total < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }

                        } else if ($subject == '02') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $second_lang_mark =  $theory_mark;

                            // if($second_lang_mark < $pass_mark && $second_lang_mark != 'ASGN'){
                            //     $this->cellColor('I'.$excel_row.':J'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }
                        } else {
                            $sub_theory_mark = 0;
                            $sub_lab_mark = 0;
                            for ($i = 0; $i < 4; $i++) {
                                if ($subject == $subjects[$i]) {
                                    $subjectInfo = $this->subject->getAllSubjectByID($subjects[$i]);
                                    $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                                    $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);

                                    if ($subjectInfo->lab_status == 'true') {
                                        $sub_theory_mark = (int)$theory_mark;
                                        $sub_lab_mark = (int)$lab_mark;
                                        $sub_total_mark = $sub_theory_mark + $sub_lab_mark;
                                        $sub_total_mark =  $sub_total_mark;
                                        $sub_theory_mark = $sub_theory_mark;

                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $theory_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $lab_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_total_mark);
                                    } else {
                                        $sub_theory_mark = (int)$theory_mark;
                                        $sub_theory_mark = $sub_theory_mark;

                                        // if($sub_theory_mark < $pass_mark && $theory_mark != 'ASGN'){
                                        //     $fail_flag = true;
                                        //     $this->cellColor($first_cell[$i].$excel_row.':'.$first_cell[$i].$excel_row, 'FFEE58');
                                        // }
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $theory_mark);
                                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row);
                                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    }
                                    $total_marks_subjects +=  $sub_theory_mark + $sub_lab_mark;
                                }
                            }
                        }
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $k++);
                    //student info
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sat_number);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->student_id);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->student_name);
                    //adding first Language
                    // $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row,  $first_language_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row,  $first_language_code);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $first_lan_TH);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row,  $first_lan_IA);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $first_language_total);
                    //second Language
                    $total_language_mark = $first_language_total + (int)$second_lang_mark;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $second_lang_mark);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $total_language_mark);

                    $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total + (int)$second_lang_mark;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('X' . $excel_row, $total_marks_subjects);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y' . $excel_row, $total_marks_all_subjects);

                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':C' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($fail_flag == true) {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z' . $excel_row, "Failed");
                    } else {
                        $result = $this->calculateResult($total_marks_all_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z' . $excel_row, $result);
                    }
                    $excel_row++;
                    // }

                }
                $this->excel->createSheet();
                $sheet++;
                // }
            }

            $filename =  $term_name . '_' . $stream_name . '_EXAM_MARKS_SHEET.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    public function cellColor($cells, $color)
    {
        return $this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }



    public function getAllMeritListByApproved()
    {

        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $type = $this->security->xss_clean($this->input->post('type'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));

            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );



            for ($sheet = 0; $sheet < count($category); $sheet++) {
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet

                $this->excel->getActiveSheet()->setTitle($category[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . " MERIT LIST 2021-2022");
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:G1');
                $this->excel->getActiveSheet()->mergeCells('A2:G2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);


                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preferences');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                $this->excel->getActiveSheet()->mergeCells('A4:K4');
                $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet] . "- LIST");
                $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);

                $students = $this->application->getMertListDetailsApproved($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type);
                $j = 1;

                $excel_row = 5;
                if ($student_type == 'NCC') {
                    $student_type_print = 'NCC';
                } else if ($student_type == 'SPORTS') {
                    $student_type_print = 'SPORTS';
                } else if ($student_type == 'DYC') {
                    $student_type_print = 'Dyslexia';
                } else if ($student_type == 'PH') {
                    $student_type_print = 'PH';
                } else {
                    $student_type_print = 'ALL';
                }

                foreach ($students as $student) {
                    if ($student->board_name == 'KARNATAKA STATE BOARD') {
                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {
                        $board_name_sheet = 'OTHERS';
                    } else {
                        $board_name_sheet = $student->board_name;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->dyslexia_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->physically_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':K' . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':K' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                $this->excel->createSheet();
            }
            $filename = 'just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache


            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
            $xlsData = ob_get_contents();
            ob_end_clean();



            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }


    public function getAllMeritList()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $category_by = $this->security->xss_clean($this->input->post('by_category'));

            $type = $this->security->xss_clean($this->input->post('type'));

            $preference = $this->security->xss_clean($this->input->post('preference'));

            $board_name = $this->security->xss_clean($this->input->post('board_name'));

            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));

            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));

            $student_type = $this->security->xss_clean($this->input->post('student_type'));

            $category = array(

                'ROMAN CATHOLIC',

                'OTHER CHRISTIANS',

                'GENERAL MERIT(GM)',

                'SC',

                'ST',

                'CAT-I',

                '2A',

                '3A',

                '2B',

                '3B'
            );



            $j = 1;

            $excel_row = 5;

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle($preference);

            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

            $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");

            $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . " MERIT LIST 2021-2022");

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $this->excel->getActiveSheet()->mergeCells('A1:G1');

            $this->excel->getActiveSheet()->mergeCells('A2:G2');

            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);





            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);

            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);

            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);

            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);

            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);

            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



            $this->excel->setActiveSheetIndex(0)->setCellValue('A3', 'SL. NO.');

            $this->excel->setActiveSheetIndex(0)->setCellValue('B3', 'Application Number');

            $this->excel->setActiveSheetIndex(0)->setCellValue('C3', 'Name');

            $this->excel->setActiveSheetIndex(0)->setCellValue('D3', 'Board');

            $this->excel->setActiveSheetIndex(0)->setCellValue('E3', 'Preferences');

            $this->excel->setActiveSheetIndex(0)->setCellValue('F3', 'Category');

            $this->excel->setActiveSheetIndex(0)->setCellValue('G3', 'Percentage');



            $this->excel->setActiveSheetIndex(0)->setCellValue('H3', 'Elective');

            $this->excel->setActiveSheetIndex(0)->setCellValue('I3', 'Religion');

            $this->excel->setActiveSheetIndex(0)->setCellValue('J3', 'Student Id');

            $this->excel->setActiveSheetIndex(0)->setCellValue('K3', 'Section');



            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->mergeCells('A4:K4');

            $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->setCellValue('A4', $board_name . "- LIST");

            $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



            if ($student_type == 'NCC') {

                $student_type_print = 'NCC';
            } else if ($student_type == 'SPORTS') {

                $student_type_print = 'SPORTS';
            } else if ($student_type == 'DYC') {

                $student_type_print = 'Dyslexia';
            } else if ($student_type == 'PH') {

                $student_type_print = 'PH';
            } else {

                $student_type_print = 'ALL';
            }

            for ($sheet = 0; $sheet < count($category); $sheet++) {



                //set Title content with some text



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

                $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);



                $students = $this->application->getMertListDetails($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type);



                foreach ($students as $student) {

                    if ($student->board_name == 'KARNATAKA STATE BOARD') {

                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {

                        $board_name_sheet = 'OTHERS';
                    } else {

                        $board_name_sheet = $student->board_name;
                    }

                    if ($student->student_category == 'ROMAN CATHOLIC') {

                        $qouta_name = 'RC';
                    } else if ($student->student_category == 'OTHER CHRISTIANS') {

                        $qouta_name = 'CHR';
                    } else if ($student->student_category == 'GENERAL MERIT(GM)') {

                        $qouta_name = 'GM';
                    } else if ($student->student_category == 'SC') {

                        $qouta_name = 'SC';
                    } else if ($student->student_category == 'ST') {

                        $qouta_name = 'ST';
                    } else if ($student->student_category == 'CAT-I') {

                        $qouta_name = 'CAT-I';
                    } else if ($student->student_category == '2A') {

                        $qouta_name = '2A';
                    } else if ($student->student_category == '2B') {

                        $qouta_name = '2B';
                    } else if ($student->student_category == '3A') {

                        $qouta_name = '3A';
                    } else if ($student->student_category == '3B') {

                        $qouta_name = '3B';
                    }

                    $this->excel->setActiveSheetIndex(0)->setCellValue('A' . $excel_row, $j++);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('B' . $excel_row, $student->application_number);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('C' . $excel_row, $student->name);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('D' . $excel_row, $board_name_sheet);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('E' . $excel_row, $student->stream_name);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('F' . $excel_row, $qouta_name);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('G' . $excel_row, $student->sslc_percentage);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('H' . $excel_row, $student->second_language);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('I' . $excel_row, $student->religion);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('J' . $excel_row, "");

                    $this->excel->setActiveSheetIndex(0)->setCellValue('K' . $excel_row, "");

                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':K' . $excel_row)->applyFromArray($styleBorderArray);

                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':K' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel_row++;
                }

                // $this->excel->createSheet(); 

            }

            $filename = 'just_some_random_name.xls'; //save our workbook as this file name

            header('Content-Type: application/vnd.ms-excel'); //mime type

            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            ob_start();

            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);

            $xlsData = ob_get_contents();

            ob_end_clean();



            $response =  array(

                'op' => 'ok',

                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)

            );

            die(json_encode($response));
        }
    }


    public function getAllShortlistedList()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $category_by = $this->security->xss_clean($this->input->post('by_category'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $shortlist_number = $this->security->xss_clean($this->input->post('shortlist_number'));    
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));    

            if($admission_year ==2022){

                $header = 'SHORTLISTED LIST 2022-2023';
            }else{
                $header = 'SHORTLISTED LIST 2021-2022';

            }


            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );
            for ($sheet = 0; $sheet < count($category); $sheet++) {
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet

                $this->excel->getActiveSheet()->setTitle($category[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . $header);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:N1');
                $this->excel->getActiveSheet()->mergeCells('A2:N2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);


                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);




                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preferences');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Father Mobile');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M3', 'Mother Mobile');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N3', 'Integrated Batch');
                $this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                $this->excel->getActiveSheet()->mergeCells('A4:N4');
                $this->excel->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet] . "- LIST");
                $this->excel->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(true);



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:N4')->applyFromArray($styleBorderArray);

                $students = $this->application->getAllShortlistedList($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type,$admission_year,$shortlist_number,$integrated_batch);
                $j = 1;

                $excel_row = 5;
                if ($student_type == 'NCC') {
                    $student_type_print = 'NCC';
                } else if ($student_type == 'SPORTS') {
                    $student_type_print = 'SPORTS';
                } else if ($student_type == 'DYC') {
                    $student_type_print = 'Dyslexia';
                } else if ($student_type == 'PH') {
                    $student_type_print = 'PH';
                } else {
                    $student_type_print = 'ALL';
                }

                foreach ($students as $student) {
                    if ($student->board_name == 'KARNATAKA STATE BOARD') {
                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {
                        $board_name_sheet = 'OTHERS';
                    } else {
                        $board_name_sheet = $student->board_name;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->dyslexia_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->physically_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $student->father_mobile);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('M' . $excel_row, $student->mother_mobile);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('N' . $excel_row, $student->integrated_batch);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':N' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                $this->excel->createSheet();
            }
            $filename = 'just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
            $xlsData = ob_get_contents();

            ob_end_clean();
            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }

    function getAssessmentMark($totalMark, $exam_type, $labStatus, $subject_code)
    {
        if (is_numeric($totalMark) && !empty($totalMark)) {
            if ($labStatus == 'false') {
                if ($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II') {
                    if ($totalMark >= 81 && $totalMark <= 100) {
                        return '30';
                    } else if ($totalMark >= 71 && $totalMark <= 80) {
                        return '25';
                    } else if ($totalMark >= 61 && $totalMark <= 70) {
                        return '20';
                    } else if ($totalMark >= 51 && $totalMark <= 60) {
                        return '15';
                    } else if ($totalMark >= 41 && $totalMark <= 50) {
                        return '10';
                    } else {
                        return '5';
                    }
                }
            } else {
                if ($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12') {
                    if ($totalMark >= 26 && $totalMark <= 35) {
                        return '4';
                    } else if ($totalMark >= 36 && $totalMark <= 45) {
                        return '8';
                    } else if ($totalMark >= 46 && $totalMark <= 55) {
                        return '12';
                    } else if ($totalMark >= 56 && $totalMark <= 65) {
                        return '16';
                    } else if ($totalMark >= 66 && $totalMark <= 75) {
                        return '20';
                    } else {
                        return '25';
                    }
                } else if ($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II') {
                    if ($totalMark >= 1 && $totalMark <= 28) {
                        return '4';
                    } else if ($totalMark >= 29 && $totalMark <= 35) {
                        return '8';
                    } else if ($totalMark >= 36 && $totalMark <= 42) {
                        return '12';
                    } else if ($totalMark >= 43 && $totalMark <= 49) {
                        return '16';
                    } else if ($totalMark >= 50 && $totalMark <= 56) {
                        return '19';
                    } else {
                        return '22';
                    }
                }
            }
        } else {
            return '';
        }
    }


    function getAssignmentExamTheoryTotalMark($student_id, $subject_code, $lab_status)
    {

        if ($subject_code == 12) {
            $labStatus = 'true';
        } else {
            $labStatus = $lab_status;
        }
        if ($labStatus == 'true') {
            if ($subject_code == 12) {
                $pass_mark_theory = 25;
            } else {
                $pass_mark_theory = 21;
            }
        } else {
            $pass_mark_theory = 35;
        }

        if ($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754') {
            $internal_assessment = 1;
        } else {
            $internal_assessment = 5;
        }
        // $exam_type = array('ASSIGNMENT_I', 'ASSIGNMENT_II');
        // ,'INTERNAL_ASSESSMENT' I_UNIT_TEST
        $exam_type = array('I_UNIT_TEST');
        $total_mark = 0;
        foreach ($exam_type as $exam) {
            $stdMarkInfo = $this->student->getStudentFinalMarks($student_id, $subject_code, $exam);
            $sub_marks = 0;
            $mark_obt = 0;
            // if ($stdMarkInfo->exam_type == 'ASSIGNMENT_I' || $stdMarkInfo->exam_type == 'ASSIGNMENT_II') {
            //     if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
            //         $mark_obt = 0;
            //     } else {
            //         $sub_marks = $this->getAssessmentMark($stdMarkInfo->obt_theory_mark, $stdMarkInfo->exam_type, $labStatus, $subject_code);
            //         $mark_obt = $sub_marks;
            //     }
            // } else {
                if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
                    $mark_obt = 0;
                } else {
                    $mark_obt = $stdMarkInfo->obt_theory_mark;
                }
            // }
            // log_message('debug','bsch'.print_r($mark_obt,true));
            // log_message('debug','student_id '.$student_id);
            $total_mark += $mark_obt;
        }


        $totalMark = $total_mark + $pass_mark_theory + $internal_assessment;
        return $totalMark;
    }


    function getAssignmentExamLabTotalMark($student_id, $subject_code, $lab_status)
    {

        if ($subject_code == 12) {
            $labStatus = 'true';
        } else {
            $labStatus = $lab_status;
        }
        if ($labStatus == 'true') {
            if ($subject_code == 12) {
                $pass_mark_lab = 10;
                $lab_assessment = 10;
            } else {
                $pass_mark_lab = 14;
                $lab_assessment = 16;
            }
        } else {
            $pass_mark_lab = 0;
            $lab_assessment = 0;
        }

        $exam_type = array('LAB_ASSESSMENT');

        // foreach($exam_type as $exam){
        //     $stdMarkInfo = $this->student->getStudentFinalMarks($student_id,$subject_code,$exam);
        //     $sub_marks = 0;
        //     $mark_obt = 0;
        //     if($stdMarkInfo->exam_type == 'ASSIGNMENT_I' || $stdMarkInfo->exam_type == 'ASSIGNMENT_II'){
        //         if($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN'){
        //             $mark_obt = 0;
        //         }else{
        //             $sub_marks = $this->getAssessmentMark($stdMarkInfo->obt_theory_mark,$stdMarkInfo->exam_type,$labStatus,$subject_code);
        //             $mark_obt = $sub_marks;
        //         }
        //     }else{
        //         if($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN'){
        //             $mark_obt = 0;
        //         }else{
        //             $mark_obt = $stdMarkInfo->obt_theory_mark;
        //         }
        //     }
        //     $total_mark += $mark_obt;
        // }


        // $totalLabMark = $total_mark + $pass_mark_lab + $lab_assessment;
        $totalLabMark = $pass_mark_lab + $lab_assessment;
        return $totalLabMark;
    }


    public function shorlitedStudentPDF_PRINT()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {

            $preference = $this->security->xss_clean($this->input->post('preference'));
            $this->global['pageTitle'] = '' . TAB_TITLE . ' :PDF';
            // $data['feeInfo'] = $this->fee->getStudentManagementFeeInfoById($row_id);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font' => 'timesnewroman', 'format' => [190, 236]]);
            $mpdf->AddPage('L', '', '', '', '', 2, 2, 2, 1, 8, 8);
            //$mpdf->AddPage('L','','','','',50,50,50,50,10,10);
            $info = $this->application->getAllShortlistedList_PDF($preference);
            $data['stdInfo'] = $info;
            $data['preference'] = $preference;
            $data_html = $this->load->view('application/printShortlistedPdf', $data, true);

            // $mpdf->WriteHTML('<columns column-count="3" vAlign="J" column-gap="2" />');
            $mpdf->WriteHTML($data_html);
            // $mpdf->WriteHTML($html_college_copy);
            // $mpdf->WriteHTML($html_bank_copy);
            $mpdf->Output($preference . '.pdf', 'I');
        }
    }


    


    //download Staff info
    public function downloadStaffExcelReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $staff_role = $this->security->xss_clean($this->input->post('staff_role'));
            $staff_department = $this->security->xss_clean($this->input->post('staff_department'));
            $fields = $this->security->xss_clean($this->input->post('fields'));

            if ($staff_department == 'ALL') {
                $filter['staff_department'] = "";
                $data['staff_department'] = 'ALL';
            } else {
                $filter['staff_department'] = $staff_department;
                $data['staff_department'] = $staff_department;
            }

            if ($staff_role == 'ALL') {
                $filter['staff_role'] = "";
                $data['staff_role'] = 'ALL';
                $stafRoleName = 'ALL';
            } else {
                $filter['staff_role'] = $staff_role;
                $data['staff_role'] = $staff_role;
                $role_name = $this->staff->getStaffRoleByName($filter);
                $stafRoleName = $role_name->role;
            }

            $date = date('Y');
            $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $total_fields = count($fields);
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', " STAFF INFORMATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:' . $cellName[$total_fields] . '1');
            $this->excel->getActiveSheet()->mergeCells('A2:' . $cellName[$total_fields] . '2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:' . $cellName[$total_fields] . '2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

            $excel_row = 3;
            $cell = 1;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL No.');

            for ($h = 1; $h <= $total_fields; $h++) {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$h] . $excel_row, $fields[$h - 1]);
            }
            $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:' . $cellName[$total_fields] . $total_fields)->applyFromArray($styleBorderArray);


            $staffs = $this->staff->getStaffInfoForReportDownload($filter);
            $j = 1;
            $excel_row = 4;

            foreach ($staffs as $stf) {
                if (empty($stf->dob) || $stf->dob == '0000-00-00' || $stf->dob == '1970-01-01') {
                    $dob = '';
                } else {
                    $dob = date("d-m-Y", strtotime($stf->dob));
                }

                if (empty($stf->doj) || $stf->doj == '0000-00-00' || $stf->doj == '1970-01-01') {
                    $doj = '';
                } else {
                    $doj = date("d-m-Y", strtotime($stf->doj));
                }


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);

                for ($c = 1; $c <= $total_fields; $c++) {
                    if ($fields[$c - 1] == 'dob') {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $dob);
                    } else if ($fields[$c - 1] == 'doj') {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $doj);
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $stf->{$fields[$c - 1]});
                    }
                }

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . $cellName[$total_fields] . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':' . $cellName[$total_fields] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();
            // }
            $filename =  '_STAFF_Report_' . $stafRoleName . '-' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }


    //download mun external report
    public function downloadMunExternalReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $status = $this->security->xss_clean($this->input->post('status'));
            $register_type = $this->security->xss_clean($this->input->post('register_type'));

            $filter['status'] = $status;
            if ($register_type != 'ALL') {
                $filter['register_type'] = $register_type;
            } else {
                $filter['register_type'] = '';
            }


            $date = date('Y');
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setTitle('MUN REGISRTATION');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "MUN EXTERNAL REGISTRATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:G1');
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);


            $excel_row = 3;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'Register ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'College Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Type');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Mobile');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Email');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Total Students');

            // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:G3')->applyFromArray($styleBorderArray);


            $eventInfo = $this->mun->getExternalMunRegistrationInfo($filter);
            $excel_row = 4;

            foreach ($eventInfo as $evt) {


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $evt->event_register_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, date('d-m-Y', strtotime($evt->created_date_time)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $evt->college_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $evt->registeration_type);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $evt->mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $evt->email);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $evt->total_students);

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'G' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('G' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();

            // $sheet = 1;
            // $this->excel->setActiveSheetIndex($sheet);

            // //set Title content with some text
            // $this->excel->getActiveSheet()->setTitle('MUN PARTICIPANTS');
            // $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            // $this->excel->getActiveSheet()->setCellValue('A2', "MUN EXTERNAL PARTICIPANT");
            // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            // $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            // $this->excel->getActiveSheet()->mergeCells('A1:I1');
            // $this->excel->getActiveSheet()->mergeCells('A2:I2');
            // $this->excel->getActiveSheet()->getStyle('A1:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);



            // $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            // $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
            // $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            // $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
            // $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            // $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(32);
            // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            // // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            // // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
            // // $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

            // $excel_row = 3;
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'Register ID');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Name');
            // // $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'DOB');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Class');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Institution');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Email');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Whatsapp No.');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Country');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Preferred Allotment');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Achievements');

            // // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            // $this->excel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
            // $this->excel->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            // $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            // $this->excel->getActiveSheet()->getStyle('A1:I3')->applyFromArray($styleBorderArray);


            // $eventInfo = $this->mun->getExternalMunRegistrationInfo($filter);
            // $excel_row = 4;

            // foreach ($eventInfo as $evt) {
            //     $participantInfo = $this->mun->getParticipantInfo($evt->event_register_id);
            //     foreach ($participantInfo as $part) {
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $part->registration_row_id);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $part->student_name);
            //         // $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, date('d-m-Y', strtotime($part->dob)));
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $part->class);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $part->institution_name);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $part->email);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $part->whatsapp_no);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $part->country_name);
            //         // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $part->city);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $part->preferred_allotments);
            //         // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $part->preferred_allotments_2);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $part->past_mun_achievements);

            //         $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'I' . $excel_row)->applyFromArray($styleBorderArray);
            //         $this->excel->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //         $this->excel->getActiveSheet()->getStyle('C' . $excel_row . ':' . 'D' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //         $this->excel->getActiveSheet()->getStyle('F' . $excel_row . ':' . 'H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //         $excel_row++;
            //     }
            // }
            // $this->excel->createSheet();
            $filename =  'MUN_EXTERNAL_' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }

    public function getCancelReceiptReport(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownLoaded',1);  
            $this->loadThis();
        } else {
            $filter = array();
           
            $year = $this->security->xss_clean($this->input->post('year'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $type = $this->security->xss_clean($this->input->post('type'));
            // if($type == 'Fee Refund'){ 
                $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                // $filter['bank_settlement'] = $bank_settlement;
                $sheet = 0;
                    $this->excel->setActiveSheetIndex($sheet);
                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle("CANCEL RECEIPT REPORT");
                    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:Q500');
                    //set Title content with some text
                    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                    $this->excel->getActiveSheet()->setCellValue('A2', "Cancel Receipt Report");
                    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->mergeCells('A1:H1');
                    $this->excel->getActiveSheet()->mergeCells('A2:H2');
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A1:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $excel_row = 3;
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                    
                    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
                    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Date');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Application No.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Gender');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Class');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Stream');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Receipt No.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Amount');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Remarks');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'Father Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Mother Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Father Mobile');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, 'Mother Mobile');
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true); 
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A1:H500')->applyFromArray($styleBorderArray);
            
                   
                    $filter['year']= $year;
                    $data['year'] = $year;
    
                    $sl = 1;
                    $excel_row = 4;
    
                    // log_message('debug','refund'.print_r($filter,true));
                    $studentInfo = $this->fee->getCancelReceiptInfoForReport($filter);
                //    log_message('debug','std'.print_r($studentInfo,true));
    
                        foreach($studentInfo as $std){
                          
                           // if($std->refund_amt >0){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($std->refund_date)));
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->application_no);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->student_name);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->gender);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->term_name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->stream_name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->receipt_number);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->paid_amount);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->remarks);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, $std->father_name);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $std->mother_name);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->father_mobile);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, $std->mother_mobile);
    
                                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':I'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('J'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':R'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $excel_row++;
                            //}
                        }
                        $this->excel->createSheet(); 
                    
                
                    $filename =  $report_type.'_Cancel_Receipt_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                    header('Content-Type: application/vnd.ms-excel'); //mime type
                    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache
                                
                    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                    //if you want to save it as .XLSX Excel 2007 format
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                    ob_start();
                    setcookie('isDownLoaded',1);  
                    $objWriter->save("php://output");
              
    
            }
        }
    // DOWNLOAD mun internal report
    public function downloadMunInternalReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $status = $this->security->xss_clean($this->input->post('status'));

            $filter['status'] = $status;


            $date = date('Y');
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setTitle('MUN');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "MUN INTERNAL REGISTRATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);

            $excel_row = 3;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL NO');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Student ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Whatsapp No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preferred Allotment');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Term');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Section');

            // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:H3')->applyFromArray($styleBorderArray);


            $eventInfo = $this->mun->downloadMunInternalReport($filter);
            $excel_row = 4;
            $sl_no = 1;

            foreach ($eventInfo as $evt) {


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl_no++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $evt->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $evt->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $evt->whatsapp_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $evt->committee);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $evt->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $evt->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $evt->section_name);

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'H' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();

            $filename =  'MUN_INTERNAL_' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }




    public function downloadApplicationFeePaid()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $status = $this->security->xss_clean($this->input->post('status'));

            $filter['status'] = $status;


            $date = date('Y');
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setTitle('MUN');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "MUN INTERNAL REGISTRATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);

            $excel_row = 3;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL NO');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Student Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Integrated Batch');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Board');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Fee');

            // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:H3')->applyFromArray($styleBorderArray);


            $eventInfo = $this->mun->downloadMunInternalReport($filter);
            $excel_row = 4;
            $sl_no = 1;

            foreach ($eventInfo as $evt) {


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl_no++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $evt->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $evt->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $evt->whatsapp_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $evt->committee);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $evt->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $evt->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $evt->section_name);

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'H' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();

            $filename =  'MUN_INTERNAL_' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }







     // DOWNLOAD Course internal report
     public function downloadCourseRegistrationReport()
     {
         if ($this->isAdmin() == TRUE) {
             setcookie('isDownLoaded', 1);
             $this->loadThis();
         } else {
             $filter = array();
             $status = $this->security->xss_clean($this->input->post('status'));
 
             $filter['status'] = $status;
 
 
             $date = date('Y');
             $sheet = 0;
 
             // for($sheet = 0; $sheet < count($preferences);  $sheet++){
             $this->excel->setActiveSheetIndex($sheet);
             //name the worksheet
             // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
             $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
             //set Title content with some text
             $this->excel->getActiveSheet()->setTitle('COURSE');
             $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
             $this->excel->getActiveSheet()->setCellValue('A2', "COURSE REGISTRATION");
             $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
             $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
             $this->excel->getActiveSheet()->mergeCells('A1:E1');
             $this->excel->getActiveSheet()->mergeCells('A2:E2');
             $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
 
 
 
             $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
             $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
             $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
             $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
             $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
           ;
 
             $excel_row = 3;
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL NO');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Student ID');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Course Name');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Amount');
        
 
             // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
             $this->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
             $this->excel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
 
             $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
             $this->excel->getActiveSheet()->getStyle('A1:E3')->applyFromArray($styleBorderArray);
 
 
             $courseInfo = $this->student->getAllCourseRegisterInfoForReport();
             $excel_row = 4;
             $sl_no = 1;
 
             foreach ($courseInfo as $course) {
 
 
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl_no++);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $course->student_id);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $course->student_name);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $course->course_name);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $course->paid_amount);
          
 
                 $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'E' . $excel_row)->applyFromArray($styleBorderArray);
                 $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':E' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $excel_row++;
             }
             $this->excel->createSheet();
 
             $filename =  'COURSE_REGISTRATION.xls'; //save our workbook as this file name
             header('Content-Type: application/vnd.ms-excel'); //mime type
             header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
             header('Cache-Control: max-age=0'); //no cache
 
             //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
             //if you want to save it as .XLSX Excel 2007 format
             $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
             ob_start();
             $objWriter->save("php://output");
             setcookie('isDownLoaded', 1);
         }
     }













    //download fee structure format
    public function download_fee_structure_excel_2020()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:F1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEE REPORT");
            $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Student ID');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Lang');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'SC/ST/CATI');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Payable');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A:C')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('E:F')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal('center');
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(28);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(17);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(17);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(18);
            // foreach($feeTypeInfo as $type){
            if ($term_name == 'I PUC') {
                $studentInfo = $this->fee->getAllFeePendingAmount2020();
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {

                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->elective_sub);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->category);
                    $filter['fee_year'] = '2020';
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->elective_sub) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                    } else {
                        $filter['lang_fee_status'] = false;
                    }
                    $feeYear = '2020';

                    $filter['category'] = strtoupper($std->category);
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    // $total_fee_amount = $total_fee->total_fee;
                    $total_fee_amount = $std->total_fee;
                    $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2020($std->application_no);

                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            } else {
                $studentInfo = $this->fee->getAllFeePendingAmount2019();
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {

                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->elective_sub);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->category);
                    $filter['fee_year'] = '2020';
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->elective_sub) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                    } else {
                        $filter['lang_fee_status'] = false;
                    }
                    $feeYear = '2019';
                    $filter['category'] = strtoupper($std->category);
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    // $total_fee_amount = $total_fee->total_fee;
                    $total_fee_amount = $std->total_fee;
                    $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2020($std->application_no);

                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            }
            // $excel_row++;

            // //$sl_number++;
            // $excel_row++;
            // }
            // $excel_row++;
            // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
            // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
            // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
            // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
            //getting optional fee info




            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_paid_' . $feeYear . '_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }

    function getFullMarksOfStudent()
    {
        $j = 1;
        $type = $this->input->post("type");
        $stream_name = $this->input->post("streamName");
        // $section_name = $this->input->post("section_name");
        $term_name = 'I PUC';
        if ($stream_name == 'All') {
            $streamName = '';
        }else{
            $streamName =  $stream_name;
        }
        $first_cell = array("K", "N", "Q", "T");
        $middle_cell = array("L", "O", "R", "U");
        $last_cell = array("M", "P", "S", "V");
        $section = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
        if ($type == 'All') {
            for ($sheet = 0; $sheet < count($section); $sheet++) {
                $section_name = $section[$sheet];
                // log_message('debug', 'secton => ' .$section_name);
                $stream_name = $this->student->getStudentsStreamName($section_name, $term_name, $streamName);
                $subjects = $this->getSubjectCodes($stream_name->stream_name);
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($section_name);
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST.JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC  ANNUAL EXAMINATION RESULT 2021-22");
                $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
                $this->excel->getActiveSheet()->setCellValue('A4', "MO: Marks Obtained | IA: Internal Assessment | TH: Theory | PR: Practical | LT: Language Total | ST: Subjects Total | TM: Total Marks");
                $this->excel->getActiveSheet()->setCellValue('A5', "I PUC " . $section_name . " SECTION (" . $stream_name->Stream_Name . ")");
                //change the font size 
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
                $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle('A1:A5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('A1:Y1');
                $this->excel->getActiveSheet()->mergeCells('A2:Y2');
                $this->excel->getActiveSheet()->mergeCells('A3:Y3');
                $this->excel->getActiveSheet()->mergeCells('A4:Y4');
                $this->excel->getActiveSheet()->mergeCells('A5:Y5');
                $this->excel->getActiveSheet()->mergeCells('A6:A7');
                $this->excel->getActiveSheet()->mergeCells('C6:C7');
                $this->excel->getActiveSheet()->mergeCells('B6:B7');
                $this->excel->getActiveSheet()->mergeCells('D6:D7');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //settting border style 
                $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:Y120')->applyFromArray($styleArray);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Lang');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lng');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E7', 'Code');
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(38);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'Language');
                $this->excel->getActiveSheet()->mergeCells('F6:H6');
                $this->excel->getActiveSheet()->mergeCells('W6:W7');
                $this->excel->getActiveSheet()->mergeCells('X6:X7');
                $this->excel->getActiveSheet()->mergeCells('Y6:Y7');
                $this->excel->getActiveSheet()->getStyle('F6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I6', 'English(02)');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'Marks');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J7', 'LT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('W6', 'ST');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('X6', 'TM');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y6', 'Result');
                //$this->excel->getActiveSheet()->mergeCells('K2:M2');
                $excel_row = 7;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(14);
                $this->excel->getActiveSheet()->getStyle('E1:E3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('D6:Y120')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('H7:H999')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A6:Y7')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('J8:J150')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('W8:Y999')->getFont()->setBold(true);
                $this->cellColor('A6:Y7', 'D5DBDB');
                //first subject heading
                for ($i = 0; $i < 4; $i++) {
                    $subjectInfo = $this->subject->getSubjectsById($subjects[$i]);
                    $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(6);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '6', $subjectInfo->name . '(' . $subjects[$i] . ')');
                    $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '6:' . $last_cell[$i] . '6');
                    $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '6:' . $last_cell[$i] . '6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($subjectInfo->lab_status == "true") {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'PR');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', "Marks");
                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '7:' . $last_cell[$i] . '7');
                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '7:' . $last_cell[$i] . '7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(5);
                    }
                }
                $data['studentsResult'] = $this->student->getStudentsToAddMark($term_name, $section_name);
                $excel_row = 8;
                foreach ($data['studentsResult']  as $row) {
                    $total_marks_subjects = 0;
                    $total_marks_all_subjects = 0;
                    $fail_flag = false;
                    $subject_total = array();
                    $data['studentsMarks'] = $this->student->getFullMarksOfStudent($row->student_id);
                    $student_status = $row->tc_given_status;
                    if (!empty($data['studentsMarks']) && $student_status == 0) {
                        $first_language_total = 0;
                        $second_lang_mark = 0;
                        $first_lan_TH = 0;
                        $first_lan_IA = 0;
                        $subject_code_from_subjects = 0;
                        foreach ($data['studentsMarks']  as $mark) {
                            $subject_true = false;
                            if ($mark->subject_code == '01') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "KAN";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_language_total < 35) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else if ($mark->subject_code == '03') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "HINDI";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_language_total < 35) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else if ($mark->subject_code == '12') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "FRENCH";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                } else if ($first_language_total < 35) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else if ($mark->subject_code == '02') {
                                $second_lang_mark = $mark->obt_theory_mark;
                                if ($second_lang_mark < 35) {
                                    $this->cellColor('I' . $excel_row . ':J' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else {
                                $sub_theory_mark = 0;
                                $sub_lab_mark = 0;
                                for ($i = 0; $i < 4; $i++) {
                                    if ($mark->subject_code == $subjects[$i]) {
                                        if ($mark->lab_status == 'true') {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                            $subject_total[$i] = $sub_theory_mark + $sub_lab_mark;
                                            if ($sub_theory_mark < 21) {
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            } else if (($sub_theory_mark + $sub_lab_mark) < 35) {
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            }
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $sub_theory_mark);
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $sub_lab_mark);
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_theory_mark + $sub_lab_mark);
                                        } else {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $subject_total[$i] = $sub_theory_mark;
                                            if ($sub_theory_mark < 35) {
                                                $fail_flag = true;
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $first_cell[$i] . $excel_row, 'FFEE58');
                                            }
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $sub_theory_mark);
                                            $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row);
                                            $this->excel->getActiveSheet()->getStyle($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                        }
                                        $total_marks_subjects +=  $sub_theory_mark + $sub_lab_mark;
                                    }
                                }
                            }
                        }
                        if($first_language_total >= 35 && (int)$second_lang_mark >= 35){
                            if($total_marks_subjects >= 140){
                                if($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30){
                                    $fail_flag = false;
                                }else{
                                    $fail_flag = true;
                                }
                                // if($first_language_total >= 35){
                                //     $fail_flag = false; 
                                // }else{
                                //     $fail_flag = true;
                                // }
        
                                // if($second_lang_mark >= 35){
                                //     $fail_flag = false; 
                                // }else{
                                //     $fail_flag = true;
                                // }
                                
                            }}


                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                        //student info
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->student_id);
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->student_name);
                        //adding first Language
                        // $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row,  $first_language_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row,  $first_language_code);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $first_lan_TH);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row,  $first_lan_IA);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $first_language_total);
                        //second Language
                        $total_language_mark = $first_language_total + (int)$second_lang_mark;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $second_lang_mark);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $total_language_mark);
                        $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total + (int)$second_lang_mark;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('W' . $excel_row, $total_marks_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('X' . $excel_row, $total_marks_all_subjects);
                        if ($fail_flag == true) {
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y' . $excel_row, "Failed");
                        } else {
                            // $student_info = array(
                            //     'intake_year_id' => 2022,
                            //     'term_name' => 'II PUC'
                            // );
                            // $this->student->updateStudentInfoBStdId($student_info, $row->student_id);
                            $result = $this->calculateResult($total_marks_all_subjects);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y' . $excel_row, $result);
                        }
                        $excel_row++;
                    }
                }
                $this->excel->createSheet();
            }
        } else {
            for ($sheet = 0; $sheet < count($section); $sheet++) {
                $section_name = $section[$sheet];
                // log_message('debug', 'secton => ' .$section_name);
                $stream_name = $this->student->getStudentsStreamName($section_name, $term_name, $streamName);
                $subjects = $this->getSubjectCodes($stream_name->stream_name);
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($section_name);
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST.JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC  ANNUAL EXAMINATION FAILED STUDENTS  RESULT 2021-22");
                $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
                $this->excel->getActiveSheet()->setCellValue('A4', "MO: Marks Obtained | IA: Internal Assessment | TH: Theory | PR: Practical | LT: Language Total | ST: Subjects Total | TM: Total Marks");
                $this->excel->getActiveSheet()->setCellValue('A5', "I PUC " . $section_name . " SECTION (" . $stream_name->Stream_Name . ")");
                //change the font size 
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
                $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle('A1:A5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('D5:Y5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('A1:Y1');
                $this->excel->getActiveSheet()->mergeCells('A2:Y2');
                $this->excel->getActiveSheet()->mergeCells('A3:Y3');
                $this->excel->getActiveSheet()->mergeCells('A4:Y4');
                $this->excel->getActiveSheet()->mergeCells('A5:C5');
                $this->excel->getActiveSheet()->mergeCells('D5:Y5');
                $this->excel->getActiveSheet()->mergeCells('A6:A7');
                $this->excel->getActiveSheet()->mergeCells('C6:C7');
                $this->excel->getActiveSheet()->mergeCells('B6:B7');
                $this->excel->getActiveSheet()->mergeCells('D6:D7');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('D5', "Color Abbreviation:- 1 Sub Failed - GREEN | 2 Sub Failed - BLUE | 3 Sub Failed - YELLOW | 4 or More Sub Failed - RED ");
                //settting border style 
                $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:Y120')->applyFromArray($styleArray);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Lang');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lng');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E7', 'Code');
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(38);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'Language');
                $this->excel->getActiveSheet()->mergeCells('F6:H6');
                $this->excel->getActiveSheet()->mergeCells('W6:W7');
                $this->excel->getActiveSheet()->mergeCells('X6:X7');
                $this->excel->getActiveSheet()->mergeCells('Y6:Y7');
                $this->excel->getActiveSheet()->getStyle('F6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I6', 'English(02)');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'Marks');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J7', 'LT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('W6', 'ST');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('X6', 'TM');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y6', 'Result');
                //$this->excel->getActiveSheet()->mergeCells('K2:M2');
                $excel_row = 7;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
                $this->excel->getActiveSheet()->getStyle('E1:E3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('D6:Y120')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('H7:H999')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A6:Y7')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('J8:J150')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('W8:Y999')->getFont()->setBold(true);
                $this->cellColor('A6:Y7', 'D5DBDB');
                //first subject heading
                for ($i = 0; $i < 4; $i++) {
                    $subjectInfo = $this->subject->getSubjectsById($subjects[$i]);
                    $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(6);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '6', $subjectInfo->name . '(' . $subjects[$i] . ')');
                    $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '6:' . $last_cell[$i] . '6');
                    $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '6:' . $last_cell[$i] . '6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($subjectInfo->lab_status == "true") {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'PR');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', "Marks");
                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '7:' . $last_cell[$i] . '7');
                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '7:' . $last_cell[$i] . '7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(5);
                    }
                }
                $data['studentsResult'] = $this->student->getStudentsToAddMark($term_name, $section_name);
                $excel_row = 8;
                foreach ($data['studentsResult']  as $row) {
                    $total_marks_subjects = 0;
                    $total_marks_all_subjects = 0;
                    $fail_flag = false;
                    $first_language_code = "";
                    $first_language_name = "";
                    $data['studentsMarks'] = $this->student->getFullMarksOfStudent($row->student_id);
                    if (!empty($data['studentsMarks'])) {
                        $first_language_total = 0;
                        $second_lang_mark = 0;
                        $first_lan_TH = 0;
                        $first_lan_IA = 0;
                        $subject_code_from_subjects = 0;
                        $failed_subject_codes = array();
                        foreach ($data['studentsMarks']  as $mark) {
                            $subject_true = false;
                            if ($mark->subject_code == '01') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "KAN";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else if ($mark->subject_code == '03') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "HINDI";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else if ($mark->subject_code == '12') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "FRENCH";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                } else if ($first_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else if ($mark->subject_code == '02') {
                                $second_lang_mark = $mark->obt_theory_mark;
                                if ($second_lang_mark < 35) {
                                    array_push($failed_subject_codes, $mark->subject_code);
                                    $this->cellColor('I' . $excel_row . ':J' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                            } else {
                                $sub_theory_mark = 0;
                                $sub_lab_mark = 0;
                                for ($i = 0; $i < 4; $i++) {
                                    if ($mark->subject_code == $subjects[$i]) {
                                        if ($mark->lab_status == 'true') {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                            if ($sub_theory_mark < 21) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            } else if (($sub_theory_mark + $sub_lab_mark) < 35) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            }
                                        } else {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            if ($sub_theory_mark < 35) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                $fail_flag = true;
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $first_cell[$i] . $excel_row, 'FFEE58');
                                            }
                                        }
                                        $total_marks_subjects +=  $sub_theory_mark + $sub_lab_mark;
                                    }
                                }
                            }
                        }
                    }
                    if ($fail_flag == true) {
                        $data['studentsMarks'] = $this->student->getFullMarksOfStudent($row->student_id);
                        foreach ($data['studentsMarks']  as $mark) {
                            for ($i = 0; $i < 4; $i++) {
                                if ($mark->subject_code == $subjects[$i]) {
                                    $sub_theory_mark = (int)$mark->obt_theory_mark;
                                    $sub_lab_mark = (int)$mark->obt_lab_mark;
                                    if ($mark->lab_status == 'true') {
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $sub_theory_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $sub_lab_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_theory_mark + $sub_lab_mark);
                                    } else {
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $sub_theory_mark);
                                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row);
                                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    }
                                }
                            }
                        }
                        if (count($failed_subject_codes) >= 4) {
                            for ($i = 0; $i < count($failed_subject_codes); $i++) {
                                if (in_array('01', $failed_subject_codes) || in_array('03', $failed_subject_codes) || in_array('12', $failed_subject_codes)) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'E74C3C');
                                }
                                for ($j = 0; $j < 4; $j++) {
                                    if (in_array($subjects[$j], $failed_subject_codes)) {
                                        $this->cellColor($first_cell[$j] . $excel_row . ':' . $last_cell[$j] . $excel_row, 'E74C3C');
                                    }
                                }
                            }
                        } else if (count($failed_subject_codes) == 2) {
                            for ($i = 0; $i < count($failed_subject_codes); $i++) {
                                if (in_array('01', $failed_subject_codes) || in_array('03', $failed_subject_codes) || in_array('12', $failed_subject_codes)) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, '3498DB');
                                }
                                for ($j = 0; $j < 4; $j++) {
                                    if (in_array($subjects[$j], $failed_subject_codes)) {
                                        $this->cellColor($first_cell[$j] . $excel_row . ':' . $last_cell[$j] . $excel_row, '3498DB');
                                    }
                                }
                            }
                        } else if (count($failed_subject_codes) == 1) {
                            for ($i = 0; $i < count($failed_subject_codes); $i++) {
                                if (in_array('01', $failed_subject_codes) || in_array('03', $failed_subject_codes) || in_array('12', $failed_subject_codes)) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, '28B463');
                                }
                                for ($j = 0; $j < 4; $j++) {
                                    if (in_array($subjects[$j], $failed_subject_codes)) {
                                        $this->cellColor($first_cell[$j] . $excel_row . ':' . $last_cell[$j] . $excel_row, '28B463');
                                    }
                                }
                            }
                        }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                        //student info
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->student_id);
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->Name);
                        //adding first Language
                        // $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row,  $first_language_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row,  $first_language_code);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $first_lan_TH);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row,  $first_lan_IA);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $first_language_total);
                        //second Language
                        $total_language_mark = $first_language_total + (int)$second_lang_mark;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $second_lang_mark);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $total_language_mark);
                        $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total + (int)$second_lang_mark;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('W' . $excel_row, $total_marks_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('X' . $excel_row, $total_marks_all_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y' . $excel_row, "Failed");
                        $excel_row++;
                    }
                }
                $this->excel->createSheet();
            }
        }
        $filename = 'just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();
        $response =  array(
            'op' => 'ok',
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
        die(json_encode($response));
    }

    


public function downloadTransportFeeInfoReport()
{
    if ($this->isAdmin() == true) {
        setcookie('isDownLoaded', 1);
        $this->loadThis();
    } else {
        $filter = array();
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
        $month = $this->security->xss_clean($this->input->post('month'));
        $year = CURRENT_YEAR;
        $spreadsheet = new Spreadsheet();
        $headerFontSize = [
            'font' => [
                'size' => 16,
                'bold' => true,
            ]
        ];
        $font_style_total = [
            'font' => [
                'size' => 12,
                'bold' => true,
            ]
        ];
        $filter['term_name'] = $term_name;
       // $filter['month'] = $month;

        $spreadsheet->getProperties()
            ->setCreator("SJPUC")
            ->setLastModifiedBy($this->staff_id)
            ->setTitle("SJPUC Fee Info")
            ->setSubject("Fee Structure")
            ->setDescription(
                "SJPUC"
            )
            ->setKeywords("SJPUC")
            ->setCategory("Fee");
        $i = 0;

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('FEE');
        $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $spreadsheet->getActiveSheet()->mergeCells("A1:J1");
        $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " TRANSPORT FEE PAID REPORT -" . date('Y'));
        $spreadsheet->getActiveSheet()->mergeCells("A2:J2");
        $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
        // $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('E3', 'Paid Amt.');
        // $spreadsheet->getActiveSheet()->setCellValue('G3', 'Pending Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('F3', 'Month');
        $spreadsheet->getActiveSheet()->setCellValue('G3', 'Route');
        $spreadsheet->getActiveSheet()->setCellValue('H3', 'Bus No.');
        
            
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
        // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

        $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2')
                ),
                'font'  => array(
                    'bold'  =>  true
                )
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
        $excel_row = 4;
        $sl_number = 1;
        $total_sslc_state_fee = 0;
        $total_cbse_icse_fee = 0;
        $total_nri_fee = 0;
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
       
        $filter = array();
        $filter['term_name'] = $term_name;
        
        if($month == 'ALL'){
            $filter['month'] = '';
        }else{
            $filter['month'] = $month;
        }
        // foreach($feeTypeInfo as $type){
    
            $studentInfo = $this->student->getCurrentStudentInfoForTransReport($filter);
         
            if (!empty($studentInfo)) {
                foreach ($studentInfo as $std) {
                    $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December'
                    ];
                    $monthNumber = $std->month; 
                    $monthName = $months[$monthNumber];
                    $routeInfo = $this->transport->getTranportRateById($std->route_id);
                
               
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    // $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->total_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->amount);
                    // $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->pending_balance);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $monthName);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $routeInfo->name);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $routeInfo->bus_no);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                  //  }
                }
            }
   
       
        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
        $spreadsheet->createSheet();
        $i++;
     

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Transport_fee_paid_' . $term_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        setcookie('isDownLoaded', 1);
        $writer->save("php://output");
    }
}

public function downloadArrearTransportFeeInfoReport()
{
    if ($this->isAdmin() == true) {
        setcookie('isDownLoaded', 1);
        $this->loadThis();
    } else {
        $filter = array();
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
       
        $year = CURRENT_YEAR - 1;
        $spreadsheet = new Spreadsheet();
        $headerFontSize = [
            'font' => [
                'size' => 16,
                'bold' => true,
            ]
        ];
        $font_style_total = [
            'font' => [
                'size' => 12,
                'bold' => true,
            ]
        ];
        $filter['term_name'] = $term_name;
       // $filter['month'] = $month;

        $spreadsheet->getProperties()
            ->setCreator("SJPUC")
            ->setLastModifiedBy($this->staff_id)
            ->setTitle("SJPUC Fee Info")
            ->setSubject("Fee Structure")
            ->setDescription(
                "SJPUC"
            )
            ->setKeywords("SJPUC")
            ->setCategory("Fee");
        $i = 0;

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('FEE');
        $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $spreadsheet->getActiveSheet()->mergeCells("A1:E1");
        $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " TRANSPORT FEE PAID REPORT - " . 2022);
        $spreadsheet->getActiveSheet()->mergeCells("A2:E2");
        $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
        //$spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
        // $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Paid Amt.');
     
        
            
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
        // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

        $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2')
                ),
                'font'  => array(
                    'bold'  =>  true
                )
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
        $excel_row = 4;
        $sl_number = 1;
        $total_sslc_state_fee = 0;
        $total_cbse_icse_fee = 0;
        $total_nri_fee = 0;
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
       
        $filter = array();
        $filter['term_name'] = $term_name;
        $filter['year'] = $year;
        //log_message('debug','filter'.print_r($filter,true));
      
        // foreach($feeTypeInfo as $type){
    
            $studentInfo = $this->student->getArrearStudentInfoForTransReport($filter);
         
            if (!empty($studentInfo)) {
                foreach ($studentInfo as $std) {
                  
                   
                
               
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->bus_fees);
                 
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                  //  }
                }
            }
   
       
        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
        $spreadsheet->createSheet();
        $i++;
     

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Arrear_Transport_fee_paid_' . $term_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        setcookie('isDownLoaded', 1);
        $writer->save("php://output");
    }
}

public function downloadArrearFeeInfoReport()
{
    if ($this->isAdmin() == true) {
        setcookie('isDownLoaded', 1);
        $this->loadThis();
    } else {
        $filter = array();
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
       
        $year = CURRENT_YEAR - 1;
        $spreadsheet = new Spreadsheet();
        $headerFontSize = [
            'font' => [
                'size' => 16,
                'bold' => true,
            ]
        ];
        $font_style_total = [
            'font' => [
                'size' => 12,
                'bold' => true,
            ]
        ];
        $filter['term_name'] = $term_name;
       // $filter['month'] = $month;

        $spreadsheet->getProperties()
            ->setCreator("SJPUC")
            ->setLastModifiedBy($this->staff_id)
            ->setTitle("SJPUC Fee Info")
            ->setSubject("Fee Structure")
            ->setDescription(
                "SJPUC"
            )
            ->setKeywords("SJPUC")
            ->setCategory("Fee");
        $i = 0;

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('FEE');
        $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $spreadsheet->getActiveSheet()->mergeCells("A1:E1");
        $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEE PAID REPORT - " . 2022);
        $spreadsheet->getActiveSheet()->mergeCells("A2:E2");
        $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
        //$spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
        // $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Paid Amt.');
     
        
            
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
        // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

        $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2')
                ),
                'font'  => array(
                    'bold'  =>  true
                )
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
        $excel_row = 4;
        $sl_number = 1;
        $total_sslc_state_fee = 0;
        $total_cbse_icse_fee = 0;
        $total_nri_fee = 0;
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
       
        $filter = array();
        $filter['term_name'] = $term_name;
        $filter['year'] = $year;
        //log_message('debug','filter'.print_r($filter,true));
      
        // foreach($feeTypeInfo as $type){
    
            $studentInfo = $this->student->getArrearStudentInfoForFeeReport($filter);
         
            if (!empty($studentInfo)) {
                foreach ($studentInfo as $std) {
               
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->paid_amount);
                 
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                  //  }
                }
            }
   
       
        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
        $spreadsheet->createSheet();
        $i++;
     

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Arrear_Fee_paid_' . $term_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        setcookie('isDownLoaded', 1);
        $writer->save("php://output");
    }
}

public function downloadBulkFeeReport(){
     
    $filter = array();
       // $term = $this->security->xss_clean($this->input->post('term_name'));
        $date_from = $this->security->xss_clean($this->input->post('date_from'));
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
        $payment_year = $this->security->xss_clean($this->input->post('payment_year'));
        
        $filter['term_name'] = $term;
        $data['term_name'] = $term;
        if(!empty($date_from)){
        $filter['date_from'] = date('Y-m-d',strtotime($date_from));
        
        }
        if(!empty($date_to)){
        $filter['date_to'] = date('Y-m-d',strtotime($date_to));
        }
        $filter['payment_type'] = $payment_type;
        $filter['payment_year'] = $payment_year;
        $data['payment_type'] = $payment_type;

       
        $paidInfo = $this->fee->getFeeBulkReceipt($filter);
        $data['paidInfo'] = $paidInfo; 
       
        $data['feeModel'] = $this->fee;

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A4-L']);
            $mpdf->AddPage('L','','','','',7,7,7,7,8,8);
            if (!empty($paidInfo)) {
                
                foreach ($paidInfo as $studentInfo) {
                    $feeInfo = $this->fee->getFeeInfoByReceiptNumBulk($studentInfo->fee_row_id);
                    $data['feeInfo'] = $feeInfo;

                    $data['studentInfo'] = $studentInfo; 
                    $data['paid_amount'] = $studentInfo->paid_amount;
                    $data['previousFeePaidInfo'] = $this->fee->getPreviousFeePaidInfo($studentInfo->fee_row_id,$studentInfo->row_id, $studentInfo->term_name);
                    $data['paid_amount_words'] = $this->getIndianCurrency(floatval($data['paid_amount']));
                    $data['name_count'] = 0;
                    $html_student_copy = $this->load->view('fees/bulkFeeReceiptPrint',$data,true);
                    $data['name_count'] = 1;
                    $html_office_copy = $this->load->view('fees/bulkFeeReceiptPrint',$data,true);

                    $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="10" />');
                    $mpdf->WriteHTML($html_student_copy);
                    $mpdf->WriteHTML($html_office_copy);
                }
            }
     
        $mpdf->Output('Fee_Receipt.pdf', 'I');   
}

public function downloadTransportBulkFeeReport(){
     
    $filter = array();
       // $term = $this->security->xss_clean($this->input->post('term_name'));
        $date_from = $this->security->xss_clean($this->input->post('date_from'));
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
        $payment_year = $this->security->xss_clean($this->input->post('payment_year'));
        
        $filter['term_name'] = $term;
        $data['term_name'] = $term;
        if(!empty($date_from)){
        $filter['date_from'] = date('Y-m-d',strtotime($date_from));
        
        }
        if(!empty($date_to)){
        $filter['date_to'] = date('Y-m-d',strtotime($date_to));
        }
        $filter['payment_type'] = $payment_type;
        $filter['payment_year'] = $payment_year;
        $data['payment_type'] = $payment_type;

       
        $TransportInfo = $this->transport->getTransportFeeBulkReceipt($filter);
       
        $data['TransportInfo'] = $TransportInfo; 
       
        $data['feeModel'] = $this->fee;

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A4-L']);
            $mpdf->AddPage('L','','','','',7,7,25,15,8,8);
            if (!empty($TransportInfo)) {
                
                foreach ($TransportInfo as $studentInfo) {
                  //  $feeInfo = $this->fee->getFeeInfoByReceiptNum($studentInfo->row_id);
                   // $data['feeInfo'] = $feeInfo;
                   $data['studentTransportInfo'] = $studentInfo; 
                   //log_message('debug','transport'.print_r($studentInfo,true));
                    $data['transport_rate'] = $studentInfo->bus_fees;
                    $data['transport_rate_words'] = $this->getIndianCurrency(floatval($data['transport_rate']));
                    $data['name_count'] = 0;
                    $html_student_copy = $this->load->view('transport/bulkTransportReceiptPrint',$data,true);
                    $data['name_count'] = 1;
                    $html_office_copy = $this->load->view('transport/bulkTransportReceiptPrint',$data,true);
                    $data['name_count'] = 2;
                    $html_bus_copy = $this->load->view('transport/bulkTransportReceiptPrint',$data,true);

                    $mpdf->WriteHTML('<columns column-count="3" vAlign="J" column-gap="10" />');
                    $mpdf->WriteHTML($html_student_copy);
                    $mpdf->WriteHTML($html_office_copy);
                    $mpdf->WriteHTML($html_bus_copy);
                }
            }
     
        $mpdf->Output('Transport_Receipt.pdf', 'I');   
}

function getIndianCurrency(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}


public function downloadTransportDueInfoReport()
{
    if ($this->isAdmin() == true) {
        setcookie('isDownLoaded', 1);
        $this->loadThis();
    } else {
        $filter = array();
        $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
        $bus_no = $this->security->xss_clean($this->input->post('bus_no'));
        $year = CURRENT_YEAR;
        $spreadsheet = new Spreadsheet();
        $headerFontSize = [
            'font' => [
                'size' => 16,
                'bold' => true,
            ]
        ];
        $font_style_total = [
            'font' => [
                'size' => 12,
                'bold' => true,
            ]
        ];
        $filter['term_name'] = $term_name;

        $spreadsheet->getProperties()
            ->setCreator("SJPUC")
            ->setLastModifiedBy($this->staff_id)
            ->setTitle("SJPUC Fee Info")
            ->setSubject("Fee Structure")
            ->setDescription(
                "SJPUC"
            )
            ->setKeywords("SJPUC")
            ->setCategory("Fee");
        $i = 0;

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('FEE');
        $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $spreadsheet->getActiveSheet()->mergeCells("A1:J1");
        $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " TRANSPORT FEE DUE REPORT - 2023");
        $spreadsheet->getActiveSheet()->mergeCells("A2:J2");
        $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
        $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('F3', 'Paid Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('G3', 'Pending Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('H3', 'Concession');
        $spreadsheet->getActiveSheet()->setCellValue('I3', 'Route');
        $spreadsheet->getActiveSheet()->setCellValue('J3', 'Bus No.');
        
            
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
        // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

        $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2')
                ),
                'font'  => array(
                    'bold'  =>  true
                )
            )
        );


        $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
        $excel_row = 4;
        $sl_number = 1;
        $total_sslc_state_fee = 0;
        $total_cbse_icse_fee = 0;
        $total_nri_fee = 0;
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
     
       
        $filter = array();
        $filter['term_name'] = $term_name;
        $filter['bus_no'] = $bus_no;
        // foreach($feeTypeInfo as $type){
      
            $studentInfo = $this->student->getStudentInfoForTransReport($filter);

            if (!empty($studentInfo)) {
                foreach ($studentInfo as $std) {
                    $routeInfo = $this->transport->getTranportRateById($std->route_id);
                   
                    $total_fee = $routeInfo->rate;
                    $feePaidInfo = $this->transport->getTransportTotalPaidAmount($std->row_id,$year);

                    if(!empty($feePaidInfo->paid_amount)){
                        $paid_amt = $feePaidInfo->paid_amount;
                    }else{
                        $paid_amt = 0;
                    }
                  

                    $pending_bal = $total_fee - $paid_amt;
                   
                    $BusfeeConcession = $this->transport->getFeeConcessionInfo($std->row_id,$year); 
                    if(!empty($BusfeeConcession->fee_amt)){
                        $concession_amt = $BusfeeConcession->fee_amt;
                    }else{
                        $concession_amt = 0;
                    }
                    $pending_bal -= $BusfeeConcession->fee_amt;
                   // if($paid_amt == 0) {
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $pending_bal);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $concession_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $routeInfo->name);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $routeInfo->bus_no);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
               // }
            }
            }
   
       
        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
        $spreadsheet->createSheet();
        $i++;
     

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="transport_fee_due_' . $term_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        setcookie('isDownLoaded', 1);
        $writer->save("php://output");
    }
}

public function downloadTransportOnlyDueInfoReport()
{
    if ($this->isAdmin() == true) {
        setcookie('isDownLoaded', 1);
        $this->loadThis();
    } else {
        $filter = array();
        $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
        $bus_no = $this->security->xss_clean($this->input->post('bus_no'));
        $year = CURRENT_YEAR;
        $spreadsheet = new Spreadsheet();
        $headerFontSize = [
            'font' => [
                'size' => 16,
                'bold' => true,
            ]
        ];
        $font_style_total = [
            'font' => [
                'size' => 12,
                'bold' => true,
            ]
        ];
        $filter['term_name'] = $term_name;

        $spreadsheet->getProperties()
            ->setCreator("SJPUC")
            ->setLastModifiedBy($this->staff_id)
            ->setTitle("SJPUC Fee Info")
            ->setSubject("Fee Structure")
            ->setDescription(
                "SJPUC"
            )
            ->setKeywords("SJPUC")
            ->setCategory("Fee");
        $i = 0;

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('FEE');
        $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $spreadsheet->getActiveSheet()->mergeCells("A1:J1");
        $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " TRANSPORT FEE DUE REPORT - 2023");
        $spreadsheet->getActiveSheet()->mergeCells("A2:J2");
        $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
        $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('F3', 'Paid Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('G3', 'Pending Amt.');
        $spreadsheet->getActiveSheet()->setCellValue('H3', 'Concession');
        $spreadsheet->getActiveSheet()->setCellValue('I3', 'Route');
        $spreadsheet->getActiveSheet()->setCellValue('J3', 'Bus No.');
        
            
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
        // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

        $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E4E2')
                ),
                'font'  => array(
                    'bold'  =>  true
                )
            )
        );


        $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $this->excel->getActiveSheet()->getStyle('A1:K3')->applyFromArray($styleBorderArray);
        $excel_row = 4;
        $sl_number = 1;
        $total_sslc_state_fee = 0;
        $total_cbse_icse_fee = 0;
        $total_nri_fee = 0;
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
       
        $filter = array();
        $filter['term_name'] = $term_name;
        $filter['bus_no'] = $bus_no;
        // foreach($feeTypeInfo as $type){
      
            $studentInfo = $this->student->getStudentInfoForTransReport($filter);

            if (!empty($studentInfo)) {
                foreach ($studentInfo as $std) {
                    $routeInfo = $this->transport->getTranportRateById($std->route_id);
                   
                    $total_fee = $routeInfo->rate;
                    $feePaidInfo = $this->transport->getTransportTotalPaidAmount($std->row_id,$year);

                    if(!empty($feePaidInfo->paid_amount)){
                        $paid_amt = $feePaidInfo->paid_amount;
                    }else{
                        $paid_amt = 0;
                    }
                  

                    $pending_bal = $total_fee - $paid_amt;
                    $BusfeeConcession = $this->transport->getFeeConcessionInfo($std->row_id,$year); 
                    if(!empty($BusfeeConcession->fee_amt)){
                        $concession_amt = $BusfeeConcession->fee_amt;
                    }else{
                        $concession_amt = 0;
                    }
                    $pending_bal -= $BusfeeConcession->fee_amt;

                   // if($paid_amt == 0) {
                    if($pending_bal > 0){
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $pending_bal);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $concession_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $routeInfo->name);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $routeInfo->bus_no);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
               // }
                    }
            }
            }
   
       
        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
        $spreadsheet->createSheet();
        $i++;
     

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="transport_fee_due_' . $term_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        setcookie('isDownLoaded', 1);
        $writer->save("php://output");
    }
}
public function downloadMiscellaneousFeePaidReport(){
    if($this->isAdmin() == TRUE) {
        setcookie('isDownloading',0);
        $this->loadThis();
    } else {  
        $filter = array();
        $miscellaneous_type = $this->security->xss_clean($this->input->post('miscellaneous_type'));
        $date_from = $this->security->xss_clean($this->input->post('date_from'));
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
        $payment_type = $this->security->xss_clean($this->input->post('payment_type'));

      
        if(!empty($date_from)){
            $filter['date_from'] = date('Y-m-d',strtotime($date_from));
        }else{
            $filter['date_from'] = '';
        }
        if(!empty($date_to)){
            $filter['date_to'] = date('Y-m-d',strtotime($date_to));
        }else{
            $filter['date_to'] = '';
        }

        if($payment_type[0] == 'ALL'){
            $filter['payment_type'] = '';
            }else{
            $filter['payment_type'] = $payment_type;
        }
        if($miscellaneous_type[0] == 'ALL'){
            $filter['miscellaneous_type'] = '';
        }else{
            $filter['miscellaneous_type'] = $miscellaneous_type;
        }
        if($reportFormat == 'VIEW'){
            $data['dt_filter'] = $filter;
            //$data['miscellaneous'] = $miscellaneous;
            $data['fee'] = $this->fee;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : MISCELLANEOUS FEE INFO';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
            $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle('MISCELLANEOUS FEE INFO');
            $html = $this->load->view('reports/misView',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('MIS.pdf', 'I');                                                              
        }else{
            // $filter['miscellaneous_type'] = $miscellaneous_type;
            $report_date = date('d-m-Y');
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle("MISCELLANEOUS FEE INFO");
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:J500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2'," MISCELLANEOUS FEE INFO");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:L1');
            $this->excel->getActiveSheet()->mergeCells('A2:L2');
            $this->excel->getActiveSheet()->getStyle('A1:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
    
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Paid Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Receipt No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Register No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Term');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Year');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Miscellaneous Type');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'Quantity');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Amount');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Total Amount');


            $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:L3')->applyFromArray($styleBorderArray);
            // log_message('debug','ndcjd'.print_r($feeRecord,true));
            $j=1;
            $excel_row = 4;
           // for($i=0; $i<count($miscellaneous);$i++){
               /// $filter['miscellaneous'] = $miscellaneous[$i];
            //log_message('debug','mis'.print_r($filter,true));
                $miscellaneousFeePaidInfo = $this->fee->getMiscellaneousFeesInfoReport($filter);

                foreach($miscellaneousFeePaidInfo as $fee){

                    if(empty($fee->qnty)){

                        $total_amount =  $fee->amount;   
        
                    }else {
                    $total_amount = $fee->qnty * $fee->amount;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($fee->date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $fee->ref_receipt_no);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $fee->student_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $fee->student_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $fee->term);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $fee->stream);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $fee->year);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $fee->miscellaneous_type);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $fee->qnty);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, $fee->amount);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,  $total_amount);


                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':L'.$excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('F'.$excel_row.':L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'TOTAL');
                $this->excel->getActiveSheet()->getStyle('J'.$excel_row.':L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                     
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,"=SUM(K4:K".($excel_row-1).")");
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,"=SUM(L4:L".($excel_row-1).")");
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':O'.$excel_row)->getFont()->setBold(true);
           // }
            $this->excel->createSheet(); 
        
            $filename ='Miscellaneous_Fee_Report_'.$report_date.'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownloading',0);
            $objWriter->save("php://output");
        }
    }
}


public function downloadSMSReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            set_time_limit(0);
            ini_set('memory_limit', '2048M');
            $filter = array();
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $term = $this->security->xss_clean($this->input->post('term'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            if($reportFormat == 'SMS Report'){ 
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:T500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "SMS Report");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel_row = 3;
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(45);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);

            $this->excel->getActiveSheet()->getStyle('A3:R3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'SL No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, 'Student Id');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, 'Application No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, 'Term Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, 'Section');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, 'Message');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, 'Mobile');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, 'Sms Count');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, 'Status');


            if ($date_from != '') {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            } else {
                $filter['date_from'] = '';
            }
            if ($date_to != '') {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            } else {
                $filter['date_to'] = '';
            }

            $filter['term_name'] = $term;
            $filter['stream_name'] = $preference;
            $filter['section_name'] = $section_name;

            $sl = 1;
            $excelRow = 4;
            $excel_row = 4;
            $accountDetails = $this->student->getSMSReport($filter);
            $smsDetails = $this->sms->getSMSListReport($filter);
            // log_message('debug','sms'.print_r($smsDetails,true));
            foreach ($accountDetails as $account) {
                if(empty($account->term_name)){
                    $term = 'I PUC';
                }else{
                    $term = $account->term_name;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, date('d-m-Y',strtotime($account->sent_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $account->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $account->application_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, strtoupper($account->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $term);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $account->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $account->section_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $account->message);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $account->mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $account->sms_count);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $account->status);

                // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':D' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('J' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
                $row_no = $excel_row;
            }
            foreach ($smsDetails as $sms) {
               
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, date('d-m-Y',strtotime($sms->sent_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, );
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, );
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, );
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, );
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, );
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, );
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $sms->message);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $sms->mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $sms->sms_count);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $sms->status);

                // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':D' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('J' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
                $row_no = $excel_row;
            }
            $this->excel->getActiveSheet()->getStyle('A' . $row_no . ':K' . $row_no)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A' . $row_no . ':K' . $row_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->createSheet();


            $filename =  'SMS_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }else{
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:T500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "Absentees SMS Report");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:I1');
            $this->excel->getActiveSheet()->mergeCells('A2:I2');
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel_row = 3;
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);


            $this->excel->getActiveSheet()->getStyle('A3:R3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'SL No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, 'Student Id');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, 'Application No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, 'Term Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, 'Section');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, 'Subject');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, 'Mobile');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, 'Sms Count');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, 'Status');


            if ($date_from != '') {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            } else {
                $filter['date_from'] = '';
            }
            if ($date_to != '') {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            } else {
                $filter['date_to'] = '';
            }
            $filter['term_name'] = $term;
            $filter['stream_name'] = $preference;
            $filter['section_name'] = $section_name;
            
            $sl = 1;
            $excelRow = 4;
            $excel_row = 4;
            $smsDetails = $this->student->getAbsenteesSMSReport($filter);
       
            foreach ($smsDetails as $account) {
                if(empty($account->term_name)){
                    $term = 'I PUC';
                }else{
                    $term = $account->term_name;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, date('d-m-Y',strtotime($account->date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $account->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $account->application_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, strtoupper($account->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $term);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $account->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $account->section_name);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $account->name);
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $account->mobile);
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $account->sms_count);
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $account->status);

                // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':D' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('J' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
                $row_no = $excel_row;
            } 
            $this->excel->getActiveSheet()->getStyle('A' . $row_no . ':K' . $row_no)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A' . $row_no . ':K' . $row_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->createSheet();


            $filename =  'Absentees_SMS_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
        }
    }


    public function downloadStaffLeaveReport(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
            setcookie('isDownloading',0);
        } else {
            $date_from = $this->security->xss_clean($this->input->post('from_date'));
            $date_to = $this->security->xss_clean($this->input->post('to_date'));
            $leave_type = $this->security->xss_clean($this->input->post('leave_type'));
            $applied_staff_id = $this->security->xss_clean($this->input->post('applied_staff_id'));
            $leave_status = $this->security->xss_clean($this->input->post('leave_status'));
            $file_format = $this->security->xss_clean($this->input->post('file_format'));
            $sheet = 0;
            
            if($leave_type == 'CL'){
                $leave_type_display = "CASUAL LEAVE";
            } else if($leave_type== 'ML'){
                $leave_type_display = 'MEDICAL LEAVE';
            }else if($leave_type == 'MARL'){
                $leave_type_display = 'MARRIAGE LEAVE';
            }else if($leave_type == 'PL'){
                $leave_type_display = 'MANAGEMENT LEAVE';
            }else if($leave_type == 'MATL'){
                $leave_type_display = 'MATERNITY LEAVE';
            }else if($leave_type == 'LOP'){
                $leave_type_display = 'LOSS OF PAY';
            }else{
                $leave_type_display = 'ALL';
            }
            if($file_format == 'PDF'){
                
                $data['date_from'] = date('d-m-Y',strtotime($date_from));
                $data['date_to'] = date('d-m-Y',strtotime($date_to));
                $data['leave_type_display'] = $leave_type;
                $data['leave_status'] = $leave_status;
                $start_date = date('Y-m-d',strtotime($date_from)); 
                $end_date = date('Y-m-d',strtotime($date_to)); 
                $data['staffInfo'] = $this->leave->getAllStaffLeaveInfoForReport($start_date, $end_date, $applied_staff_id, $leave_type, $leave_status);
                
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'helvetica','format' => 'A4-L',
                'pagenumPrefix' => 'Page number ',]);
                $mpdf->SetTitle('STAFF LEAVE INFORMATION'.$leave_status);
                // $mpdf->SetHeader('ST. JOSEPH\'S BOYS\' HIGH SCHOOL');
                $html = $this->load->view('reports/staffLeaveReport',$data,true);
                $mpdf->setFooter('{PAGENO}');
                $mpdf->AddPage('L','','','','',10,10,20,20,15,15);
                $mpdf->WriteHTML($html);
                setcookie('isDownloading',0);
                $mpdf->Output('Leave.pdf', 'D');
            }else{
                // foreach($department_list as $dept){
                    $this->excel->setActiveSheetIndex($sheet);
                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle('Leave');
                    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
                    //set Title content with some text
                    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                    $this->excel->getActiveSheet()->setCellValue('A2', "STAFF LEAVE INFORMATION - ".$leave_status);
                    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->mergeCells('A1:H1');
                    $this->excel->getActiveSheet()->mergeCells('A2:H2');
                    $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
            
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(28);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        
                    $this->excel->getActiveSheet()->setCellValue('A3', "Date From: ".$date_from." Date To: ".$date_to);
                    $this->excel->getActiveSheet()->mergeCells('A3:D3');
                    $this->excel->getActiveSheet()->setCellValue('E3', "Leave Type: ".$leave_type);
                    $this->excel->getActiveSheet()->mergeCells('E3:H3');
                    $this->excel->getActiveSheet()->getStyle('E3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
        
        
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Date From');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Date To');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Staff ID');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Name');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Leave Type');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Reason');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Total Days');
                
                    
                    $this->excel->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setWrapText(true); 
                    $this->excel->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true); 
                    $this->excel->getActiveSheet()->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A1:H4')->applyFromArray($styleBorderArray);
                    $start_date = date('Y-m-d',strtotime($date_from)); 
                    $end_date = date('Y-m-d',strtotime($date_to)); 
                    $staffInfo = $this->leave->getAllStaffLeaveInfoForReportTwo($start_date, $end_date, $applied_staff_id, $leave_type, $leave_status);
                    $j=1;
                    $excel_row = 5;
                    
                    if(!empty($staffInfo)){
                        foreach($staffInfo as $staff){
                            $leave_type_text = "";
                            if($staff->leave_type == 'CL'){
                                $leave_type_text = "CASUAL LEAVE";
                            } else if($staff->leave_type == 'ML'){
                                $leave_type_text = 'MEDICAL LEAVE';
                            }else if($staff->leave_type == 'MARL'){
                                $leave_type_text = 'MARRIAGE LEAVE';
                            }else if($staff->leave_type == 'PL'){
                                $leave_type_text = 'PATERNITY LEAVE';
                            }else if($staff->leave_type == 'MATL'){
                                $leave_type_text = 'MATERNITY LEAVE';
                            }else if($staff->leave_type == 'LOP'){
                                $leave_type_text = 'LOSS OF PAY';
                            }
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($staff->date_from)));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,date('d-m-Y',strtotime($staff->date_to)));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->staff_id);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->leave_type);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->leave_reason);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->total_days_leave);
                            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':H'.$excel_row)->applyFromArray($styleBorderArray);
                            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':D'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $this->excel->getActiveSheet()->getStyle('H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel_row++;
                        }
                    }
                
                    $this->excel->createSheet();
              
                    $filename ='Staff_Leave_Report_'.$report_date.'.xls'; //save our workbook as this file name
                    header('Content-Type: application/vnd.ms-excel'); //mime type
                    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                    ob_start();
                    setcookie('isDownLoaded',1);
                    $objWriter->save("php://output");
            }
        }
    }


    // staff leave report
 public function downloadStaffLeavePendingReport(){
    if($this->isAdmin() == TRUE) {
        $this->loadThis();
        setcookie('isDownloading',0);
    } else {
        // $leave_type = $this->security->xss_clean($this->input->post('leave_type'));
        $applied_staff_id = $this->security->xss_clean($this->input->post('applied_staff_id'));
        $year = $this->security->xss_clean($this->input->post('year'));
        $year = '2023-24';
        $file_format = $this->security->xss_clean($this->input->post('file_format'));
        $sheet = 0;
        
        // if($leave_type == 'CL'){
        //     $leave_type_display = "CASUAL LEAVE";
        // } else if($leave_type== 'ML'){
        //     $leave_type_display = 'MEDICAL LEAVE';
        // }else if($leave_type == 'MARL'){
        //     $leave_type_display = 'MARRIAGE LEAVE';
        // }else if($leave_type == 'PL'){
        //     $leave_type_display = 'PATERNITY LEAVE';
        // }else if($leave_type == 'MATL'){
        //     $leave_type_display = 'MATERNITY LEAVE';
        // }else if($leave_type == 'LOP'){
        //     $leave_type_display = 'LOSS OF PAY';
        // }else if($leave_type == 'WFH'){
        //     $leave_type_display = 'WORK FROM HOME';
        // }else{
        //     $leave_type_display = 'ALL';
        // }
        // if($file_format == 'PDF'){
            
        //     $data['date_from'] = date('d-m-Y',strtotime($date_from));
        //     $data['date_to'] = date('d-m-Y',strtotime($date_to));
        //     $data['leave_type_display'] = $leave_type_display;
        //     $data['leave_status'] = $leave_status;
        //     $start_date = date('Y-m-d',strtotime($date_from)); 
        //     $end_date = date('Y-m-d',strtotime($date_to)); 
        //     $data['staffInfo'] = $this->leave->getAllStaffLeavePendingInfoForReport($applied_staff_id, $leave_type);
            
        //     $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'helvetica','format' => 'A4-L',
        //     'pagenumPrefix' => 'Page number ',]);
        //     $mpdf->SetTitle('STAFF LEAVE INFORMATION'.$leave_status);
        //     // $mpdf->SetHeader('ST. JOSEPH\'S BOYS\' HIGH SCHOOL');
        //     $html = $this->load->view('reports/staffLeaveReport',$data,true);
        //     $mpdf->setFooter('{PAGENO}');
        //     $mpdf->AddPage('L','','','','',10,10,20,20,15,15);
        //     $mpdf->WriteHTML($html);
        //     setcookie('isDownloading',0);
        //     $mpdf->Output('Leave.pdf', 'D');
        // }else{
            // foreach($department_list as $dept){
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle('Leave');
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST XAVIER'S PRE–UNIVERSITY COLLEGE");
                $this->excel->getActiveSheet()->setCellValue('A2', "STAFF LEAVE BALANCE INFORMATION - ".$year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:R1');
                $this->excel->getActiveSheet()->mergeCells('A2:R2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
        
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(18);

                // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
                // $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
                // $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
                // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

    
                // $this->excel->getActiveSheet()->setCellValue('A3', "Date From: ".$date_from." Date To: ".$date_to);
                $this->excel->getActiveSheet()->mergeCells('A3:R3');
                // $this->excel->getActiveSheet()->setCellValue('E3', "Leave Type: ".$leave_type_display);
                // $this->excel->getActiveSheet()->mergeCells('E3:H3');
                $this->excel->getActiveSheet()->getStyle('A3:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:R3')->getFont()->setBold(true);
    
    
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Staff ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Casual Leave');
                $this->excel->getActiveSheet()->mergeCells('D4:F4');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D5', 'Earned');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E5', 'Used');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F5', 'Pending');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Medical Leave');
                $this->excel->getActiveSheet()->mergeCells('G4:I4');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G5', 'Earned');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H5', 'Used');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I5', 'Pending');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'Paternity Leave');
                $this->excel->getActiveSheet()->mergeCells('J4:L4');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J5', 'Earned');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K5', 'Used');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L5', 'Pending');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M4', 'Maternity Leave');
                $this->excel->getActiveSheet()->mergeCells('M4:O4');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M5', 'Earned');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N5', 'Used');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O5', 'Pending');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P4', 'Marriage Leave');
                $this->excel->getActiveSheet()->mergeCells('P4:R4');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P5', 'Earned');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q5', 'Used');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('R5', 'Pending');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Medical Leave');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Paternity Leave');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Maternity Leave');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Marriage Leave');


                

                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Maternity Leave');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'Loss Of Pay');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'Work From Home');
            
                
                $this->excel->getActiveSheet()->getStyle('A4:R5')->getAlignment()->setWrapText(true); 
                $this->excel->getActiveSheet()->getStyle('A4:R5')->getFont()->setBold(true); 
                $this->excel->getActiveSheet()->getStyle('A4:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:R5')->applyFromArray($styleBorderArray);
                $staffInfo = $this->leave->getAllStaffLeavePendingInfoForReport2($applied_staff_id,$year);
                $j=1;
                $excel_row = 6;
                
                if(!empty($staffInfo)){
                    foreach($staffInfo as $staff){
                        // $leave_type_text = "";
                        // if($staff->leave_type == 'CL'){
                        //     $leave_type_text = "CASUAL LEAVE";
                        // } else if($staff->leave_type == 'ML'){
                        //     $leave_type_text = 'MEDICAL LEAVE';
                        // }else if($staff->leave_type == 'MARL'){
                        //     $leave_type_text = 'MARRIAGE LEAVE';
                        // }else if($staff->leave_type == 'PL'){
                        //     $leave_type_text = 'PATERNITY LEAVE';
                        // }else if($staff->leave_type == 'MATL'){
                        //     $leave_type_text = 'MATERNITY LEAVE';
                        // }else if($staff->leave_type == 'LOP'){
                        //     $leave_type_text = 'LOSS OF PAY';
                        // }else if($staff->leave_type == 'WFH'){
                        //     $leave_type_text = 'WORK FROM HOME';
                        // }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$staff->staff_id);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->casual_leave_earned);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->casual_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->casual_leave_earned - $staff->casual_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->sick_leave_earned);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->sick_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$staff->sick_leave_earned - $staff->sick_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$staff->paternity_leave_earned);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,$staff->paternity_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,$staff->paternity_leave_earned - $staff->paternity_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row,$staff->maternity_leave_earned);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row,$staff->maternity_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row,$staff->maternity_leave_earned - $staff->maternity_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row,$staff->marriage_leave_earned);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row,$staff->marriage_leave_used);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row,$staff->marriage_leave_earned - $staff->marriage_leave_used);

                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->sick_leave_earned - $staff->sick_leave_used);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->paternity_leave_earned - $staff->paternity_leave_used);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->maternity_leave_earned - $staff->maternity_leave_used);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->marriage_leave_earned - $staff->marriage_leave_used);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$staff->wfh_leave);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':R'.$excel_row)->applyFromArray($styleBorderArray);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':R'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel_row++;
                    }
                }
            
                $this->excel->createSheet();
                //}
                // $filename='just_some_random_name.xls'; //save our workbook as this file name
                // header('Content-Type: application/vnd.ms-excel'); //mime type
                // header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                // header('Cache-Control: max-age=0'); //no cache
                // $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                // ob_end_clean();
                // ob_start();
                // $objWriter->save("php://output");
                // $xlsData = ob_get_contents();
                // ob_end_clean();
    
                // $response =  array(
                //     'op' => 'ok',
                //     'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
                // );
                // die(json_encode($response));
                $filename =  'Leave_Pending_Report_file.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment; filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                            
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
                ob_start();
                setcookie('isDownloading',0);
                $objWriter->save("php://output");
        // }
    }
}

    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        $PCMS = array("33", "34", "35", '31');
        //commarce
        $BEBA = array("75", "22", "27", '30');
        $BSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        $PEBA = array("29", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $HEPS = array("21", "22", "29", '28');

        switch ($stream_name) {
            case "PCMB":
                return  $PCMB;
                break;
            case "PCMC":
                return $PCMC;
                break;
            case "PCME":
                return $PCME;
                break;
            case "PCMS":
                return $PCMS;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "BEBA":
                return $BEBA;
                break;
            case "BSBA":
                return $BSBA;
                break;
            case "CSBA":
                return $CSBA;
                break;
            case "SEBA":
                return $SEBA;
                break;
            case "CEBA":
                return $CEBA;
                break;
            case "HEPP":
                return $HEPP;
                break;
            case "HEPS":
                return $HEPS;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
        }
    }


    function calculateResult($total_marks)
    {
        $percentage = floor(($total_marks / 600) * 100);
        if ($percentage >= 85) {
            return "Distinction";
        } else if ($percentage >= 60 && $percentage <= 84) {
            return "I Class";
        } else if ($percentage >= 50 && $percentage <= 59) {
            return "II Class";
        } else if ($percentage >= 35 && $percentage <= 49) {
            return "III Class";
        } else {
            return "Fail";
        }
    }

}
