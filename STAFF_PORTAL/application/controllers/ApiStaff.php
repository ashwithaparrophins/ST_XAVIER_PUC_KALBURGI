<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class ApiStaff extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('app_staff_login');
        
    }


    public function checkIsExist(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);  
       
        $mbl_number = $obj['mblnumber'];

        log_message('debug','mbl_number-->'.print_r($mbl_number,true));
       

        $isExist = $this->app_staff_login->checkMobNo($mbl_number);
        log_message('debug','isExist-->'.print_r($isExist,true));

       

        if($isExist > 0) { 
            
    //         $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    //         $appId="WPtmySv14q3";
    //         $message = "$otp is your verification code for PARROPASS. $appId 
    // Regards, Parrophins.";
    //         $result_sms = $this->sendOtpmsg($mbl_number, $message);
    
    //        if($mbl_number!='1234567891' && $mbl_number!='1231231231' && $mbl_number!='1212121212'  && $mbl_number!='1313131313'){
    //             if($result_sms == 'success'){
            
    //                 $otpUpdate = array(
    //                     'last_otp'=>$otp
    //                 );
    
    //                 $update = $this->login_model->updateUserOtp($mbl_number,$otpUpdate);
                    
    //             }
    //        }
            $msg='isExist'; 
        }else { 
            $msg= 'failed'; 
        }    
        
       
        
    
        echo json_encode($msg);
        }


   
}
?>