<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = "login";
$route['404_override'] = 'error_404';
/*********** USER DEFINED ROUTES *******************/
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'student';
$route['logout'] = 'user/logout';
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";

//this route for forgot password
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";

//this route for user registration
$route['userRegistration'] = 'registration/userRegistration';
$route['userRegisterDB'] = 'registration/userRegisterDB';

//this route for user profile
$route['profile'] = "student/profile";
$route['profile/(:any)'] = "student/profile/$1";
$route['changePassword'] = "student/changePassword";
$route['changePassword/(:any)'] = "student/changePassword/$1";

// route for student feedback
$route['sendFeedbackToManagement'] = "student/sendFeedbackToManagement";

// route to view class time table
$route['viewTimeTable'] = "timetable/viewTimeTable";

// route for study materials
$route['viewstudyMaterials'] = "studymaterial/viewstudyMaterials";
$route['viewstudyMaterials/(:num)'] = "studymaterial/viewstudyMaterials/$1";
$route['download/(:any)'] = "studymaterial/download/$1";

//this route for overall attendnace report
$route['overallStudentAttendance'] = "student/overallStudentAttendance";
$route['overallStudentAttendance/(:num)'] = "student/overallStudentAttendance/$1";

//this route for student late comer
$route['studentLaterComer'] = "student/studentLaterComer";
$route['studentLaterComer/(:num)'] = "student/studentLaterComer/$1";

//this route for student Notification
$route['studentNotificationReport'] = "student/studentNotificationReport";
$route['studentNotificationReport/(:num)'] = "student/studentNotificationReport/$1";
$route['myNotifications'] = "student/myNotifications";

//this route for my attendance
$route['myAttendance'] = "student/myAttendance";

//this route for my Suggestion
$route['mySuggestion'] = "student/mySuggestion";
$route['suggestionToDB'] = "student/suggestionToDB";

// update family information
$route['updateFamilyInfo'] = "student/updateFamilyInfo";

// route for student exam performance 
$route['examPerformance'] = "performance/examPerformance";
$route['viewAnnualExam'] = "performance/viewAnnualExam";

//online payment and re-admission
// Re-admission routes for II PUC
$route['viewAdmission'] = "admission/viewAdmission";
$route['reAdmissionFeeProcess'] = "admission/reAdmissionFeeProcess";
$route['feePaymentResponse'] = "admission/feePaymentResponse";
$route['viewAdmission_I_PUC'] = "admission/viewAdmission_I_PUC";
$route['admissionFeeProcess_I_PUC'] = "admission/admissionFeeProcess_I_PUC";
$route['viewStudentInfoById/(:any)'] = "student/viewStudentInfoById/$1";
//$route['profile'] = "users/profile";

//fee payment info
$route['getFeePaymentInfo'] = "student/getFeePaymentInfo";

// youtube links
$route['viewYoutubeVideos'] = "studymaterial/viewYoutubeVideos";
$route['viewYoutubeVideos/(:num)'] = "studymaterial/viewYoutubeVideos/$1";

// online class links
$route['viewOnlineClass'] = "online_class/viewOnlineClass";
$route['viewOnlineClass/(:num)'] = "online_class/viewOnlineClass/$1";
$route['supplementaryFeeInfo'] = "admission/supplementaryFeeInfo";
$route['paySupplementaryFee'] = "admission/paySupplementaryFee";
$route['supplyPaymentResponse'] = "admission/supplyPaymentResponse";
$route['payTmfeePaymentResponse_I_PUC'] = "admission/payTmfeePaymentResponse_I_PUC";

//mun fee payment info
$route['munRegistrationFeeProcess'] = "student/munRegistrationFeeProcess";
$route['payTmMunRegFeePaymentResponse'] = "student/payTmMunRegFeePaymentResponse";
$route['realisticDrawRegistrationFeeProcess'] = "student/realisticDrawRegistrationFeeProcess";
$route['payTmRGDRegFeePaymentResponse'] = "student/payTmRGDRegFeePaymentResponse";

//this route for staff feedback
$route['viewStaffForFeedback'] = "feedback/viewStaffForFeedback";
$route['viewStaffForFeedback/(:num)'] = "feedback/viewStaffForFeedback/$1";
$route['saveMyFeedback'] = "feedback/saveMyFeedback";
$route['viewSadhanaStaffForFeedback'] = "feedback/viewSadhanaStaffForFeedback";
$route['saveMyCounsellorFeedback'] = "feedback/saveMyCounsellorFeedback";

//re admission 2021
$route['reAdmissionForIIPUC'] = "admission/reAdmissionForIIPUC";
$route['payTmReAdmissionFeeAmount'] = "admission/payTmReAdmissionFeeAmount";
$route['feePaymentResponseReAdmission'] = "admission/feePaymentResponseReAdmission";
$route['getReadmission_FeePaymentInfo'] = "admission/getReadmission_FeePaymentInfo";
$route['feePendingPaymentResponse2020'] = "admission/feePendingPaymentResponse2020";


//APP SETUP
$route['apidashboardMenu'] = "api/dashboardMenu";
$route['apidashboardSubMenu'] = "api/dashboardSubMenu";
// //LOGIN
$route['apiloginMe'] = 'api/loginMe';
$route['apiresetPasswordUser'] = "api/resetPasswordUser";
$route['apiresetPasswordConfirmUser'] = "api/resetPasswordConfirmUser";
//REGISTER
$route['apiuserRegisterDB'] = 'api/userRegisterDB';
//ATTENDANCE
$route['apimyAttendance'] = 'api/myAttendance';
//PROFILE
$route['apiprofile'] = "api/profile";
$route['apichangePassword'] = "api/changePassword";
//SUGGESTION
$route['apimySuggestion'] = "api/mySuggestion";
$route['apisuggestionToDB'] = "api/suggestionToDB";
//STUDY MATERIAL
$route['apiviewYoutubeVideos'] = "api/viewYoutubeVideos";
$route['apiviewstudyMaterials'] = "api/viewstudyMaterials";
//NOTIFICATIONS
$route['apimyNotificationsApi'] = "api/myNotificationsApi";
//NEWS FEED
$route['apiviewNewsFeed'] = "api/viewNewsFeed";
//MARKS
$route['apiexamPerformance'] = "api/examPerformance";
$route['apitestPerformance'] = "api/testPerformance";
//WALLET
$route['apiwalletInfo'] = "api/walletInfo";
$route['apipayTmWalletPaymentProcess'] = "api/payTmWalletPaymentProcess";
$route['apipayTmWalletPaymentResponse'] = "api/payTmWalletPaymentResponse";
//TRANSPORT FEE
$route['apiviewTransport'] = "api/viewTransport";
$route['apiprintStudentTransportBill'] = "api/printStudentTransportBill/$1";
//HOSTEL FEE
$route['apiviewHostel'] = "api/viewHostel";
$route['apihostelFeePaymentReceiptPrint'] = "api/hostelFeePaymentReceiptPrint/$1";
//FEE PAYMENT
$route['apiviewFeePaymentInfo'] = "api/viewFeePaymentInfo";
$route['apioverAllFeePaidInfo'] = "api/overAllFeePaidInfo";
$route['apifeePaymentReceiptPrint'] = "api/feePaymentReceiptPrint";
//PAYTM
$route['apipaytmToken'] = "api/paytmToken";
//PAYTM RESPONSE
$route['apifeePaymentResponse'] = "api/feePaymentResponse";
//REMARK
$route['apimyRemarks'] = "api/myRemarks";
//FB TOKEN
$route['apitokenToDB'] = "api/tokenToDB";
//Late
$route['apilateToClassListing'] = "api/lateToClassListing";
//delete account
$route['apideleteAccount'] = "api/deleteAccount";

//Course Registration
$route['courseRegistrationFeeProcess'] = "course/courseRegistrationFeeProcess";
$route['payTmCourseRegFeePaymentResponse'] = "course/payTmCourseRegFeePaymentResponse";

//upcomingEvent
$route['apiupcomingEvent'] = "api/upcomingEvent";
//calender
$route['apicalender'] = "api/calender";
//absentinfo
$route['apiabsentDetails']="api/absentDetails";
//deleteToken
$route['apideleteToken'] = "api/deleteToken";
//singleNotification
$route['apipersonalNotificationsApi'] = "api/personalNotificationsApi";
$route['apicollegeNotificationsApi'] = "api/collegeNotificationsApi";
//transportfee
$route['apiviewTransportPaymentInfo'] = "api/viewTransportPaymentInfo";
$route['apioverAllTransportFeePaidInfo'] = "api/overAllTransportFeePaidInfo";
//logout-logincredentialchanged
$route['apigetStudentId'] = "api/getStudentId";
//REMARKS
$route['apimyRemarks'] = "api/myRemarks";
//changepassword
$route['apicheckpassword'] = "api/checkpassword";

$route['apigetSubjectNames'] = "api/getSubjectNames";

$route['apiviewNotificationFeed'] = "api/viewNotificationFeed";
