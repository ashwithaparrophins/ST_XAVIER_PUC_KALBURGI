<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

|--------------------------------------------------------------------------

| Display Debug backtrace

|--------------------------------------------------------------------------

|

| If set to TRUE, a backtrace will be displayed along with php errors. If

| error_reporting is disabled, the backtrace will not display, regardless

| of this setting

|

*/

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);



/*

|--------------------------------------------------------------------------

| File and Directory Modes

|--------------------------------------------------------------------------

|

| These prefs are used when checking and setting modes when working

| with the file system.  The defaults are fine on servers with proper

| security, but you may wish (or even need) to change the values in

| certain environments (Apache running a separate process for each

| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should

| always be used to set the mode correctly.

|

*/

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);

defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);

defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);

defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);



/*

|--------------------------------------------------------------------------

| File Stream Modes

|--------------------------------------------------------------------------

|

| These modes are used when working with fopen()/popen()

|

*/

defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');

defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');

defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care

defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care

defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');

defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');

defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');

defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



/*

|--------------------------------------------------------------------------

| Exit Status Codes

|--------------------------------------------------------------------------

|

| Used to indicate the conditions under which the script is exit()ing.

| While there is no universal standard for error codes, there are some

| broad conventions.  Three such conventions are mentioned below, for

| those who wish to make use of them.  The CodeIgniter defaults were

| chosen for the least overlap with these conventions, while still

| leaving room for others to be defined in future versions and user

| applications.

|

| The three main conventions used for determining exit status codes

| are as follows:

|

|    Standard C/C++ Library (stdlibc):

|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html

|       (This link also contains other GNU-specific conventions)

|    BSD sysexits.h:

|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits

|    Bash scripting:

|       http://tldp.org/LDP/abs/html/exitcodes.html

|

*/

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors

defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error

defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error

defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found

defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class

defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member

defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input

defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error

defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code

defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



 

/**** USER DEFINED CONSTANTS **********/



define('ROLE_PRINCIPAL',                        '1');

define('ROLE_TEACHING_STAFF',                   '2');

define('EXAM_COMMITTEE',                        '3');

define('ROLE_ADMIN',                            '4');

define('ROLE_NON_TEACHING_STAFF',               '5');

define('ROLE_OFFICE',                           '6');

define('ROLE_COUNSELOR',                        '7');

define('ROLE_ERROR_COMMITTEE',                  '8');

define('ROLE_APPROVE_COMMITTEE',                '9');

define('ROLE_RECTOR',                           '10');

define('ROLE_ACCOUNT',                          '11');

define('ROLE_LIBRARY',                          '12');

define('ROLE_VICE_PRINCIPAL',                   '13');

define('ROLE_RECEPTION',                        '14');

define('ROLE_PRIMARY_ADMINISTRATOR',            '15');

define('ROLE_SECURITY',                         '16');
define('ROLE_SUPER_ADMIN',                      '50');

// define('ROLE_MANAGER',                          '16');

define('CL',                            'CASUAL LEAVE');

define('CURRENT_YEAR',                            '2024');

define('ADMISSION_YEAR',                            '2024');

define('SEGMENT',								2);


define('TITLE','ST XAVIER\'S PRE–UNIVERSITY COLLEGE, KALABURAGI');
define('EXCEL_TITLE','ST XAVIER’S PRE–UNIVERSITY COLLEGE, KALABURAGI');
define('ADDRESS', 'NH 218, SIRNOOR POST - 585 308 - GULBARGA DIST');

define('SUB_TITLE','STXPUC');

define('INSTITUTION_LOGO','assets/dist/img/logo_stxpuc.jpg');

define('FIRST_YEAR','2020-21');

define('SECOND_YEAR','2019-20');

define('EXAM_YEAR','2023-24');

define('TAB_TITLE','SchoolPhins - STXPUC');

define('ADMISSION_DOCUMENT_PATH','https://kxpuc.schoolphins.com/admission/');

define('ADMISSION_FILE_PATH',$_SERVER['DOCUMENT_ROOT'].'/https://kxpuc.schoolphins.com/admission/');



/************************** EMAIL CONSTANTS *****************************/



define('EMAIL_FROM',                            'info@schoolphins.com');		// e.g. email@example.com

define('EMAIL_BCC',                            	'');		// e.g. email@example.com

define('FROM_NAME',                             'SJBHS Schoolphins');	// Your system name

define('EMAIL_PASS',                            'Your email password');	// Your email password

define('PROTOCOL',                             	'smtp');				// mail, sendmail, smtp

define('SMTP_HOST',                             'Your smtp host');		// your smtp host e.g. smtp.gmail.com

define('SMTP_PORT',                             '25');					// your smtp port e.g. 25, 587

define('SMTP_USER',                             'Your smtp user');		// your smtp user

define('SMTP_PASS',                             'Your password');	// your smtp password

define('MAIL_PATH',                             '/usr/sbin/sendmail');





/************************* PUSH-NOTIFICATION CONSTANTS ****************************/

define('PROJECT_ID',                                   'STXPUCHK_STAFF_KALABURGI');

define('OS_LOCAL_STORAGE_KEY',                         'OSNC');



define('ONE_SIGNAL_APP_ID',                    '1a5b1589-ce36-4852-8e24-9894f7de85d9');

define('ONE_SIGNAL_PRIVATE_KEY',               'Nzg2NTZmNGUtNmFjNC00YjI4LTg1YzItOTFiMDA5NzhjYjZk');

define('ONE_SIGNAL_AUTHORIZATION',             'Authorization: Basic Nzg2NTZmNGUtNmFjNC00YjI4LTg1YzItOTFiMDA5NzhjYjZk');

define('ONE_SIGNAL_NOTIFICATION_URL',          'https://onesignal.com/api/v1/notifications');

define('STAFF_URL_TO_BE_OPENED_ON_CLICK',      'https://sjpuchassan.schoolphins.com/staff/staffNotifications');

define('STUDENT_URL_TO_BE_OPENED_ON_CLICK',    'http://studentsjpuchassan.schoolphins.com/myNotifications');

define('NOTIFICATION_BADGE',                   'https://www.parrophins.com/img/logo/parro_logo.png');

define('NOTIFICATION_ICON',                    'http://sjpuchassan.schoolphins.com/staff/icons/sjpuch_256.png'); //256x256 (recommended)







//textlocal bulksms config

define('USERNAME_TEXTLOCAL',                            '');

define('HASH_TEXTLOCAL',                                '');

define('SENDERID_TEXTLOCAL',                            '');	





//payment Paytm

// define('PAYTM_ENVIRONMENT', 'PROD'); // PROD

// define('PAYTM_MERCHANT_KEY', 'snG2NhlRQ6@Dpmbd'); //Change this constant's value with Merchant key received from Paytm.

// define('PAYTM_MERCHANT_MID', 'StJose17167863663023'); //Change this constant's value with MID (Merchant ID) received from Paytm.

// define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.



// $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/order/status';

// $PAYTM_TXN_URL='https://securegw-stage.paytm.in/order/process';

// if (PAYTM_ENVIRONMENT == 'PROD') {

// 	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/order/status';

// 	$PAYTM_TXN_URL='https://securegw.paytm.in/order/process';

// }



// define('PAYTM_REFUND_URL', '');

// define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);

// define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);

// define('PAYTM_TXN_URL', $PAYTM_TXN_URL);



/************************* FCM PUSH-NOTIFICATION CONSTANTS ****************************/
define('FCM_SERVER_KEY',                               'AAAAR6IqTfE:APA91bHt25LobZMbUDvlQ-m2bLbBwkOSkTj_pMkR-jxEx7LTNZjdruBOo-FQw9TsUPWYR1w9wkRmBYTBl-nsGzzllfww07MS3xj6CrxIg4YEtBIvOIwbyp6dL2fW4QOnIusNpSmoAHB_');
define('NOTIFICATION_LOGO',                            '');
define('FCM_URL',                                      'https://fcm.googleapis.com/fcm/send');
define('PUBLIC_FCM_SERVER_VAPID_KEY',                  'BPcLD-4QUQOxDb9WGszkEP6pF-e5A0EEInEg28MejZePAGXWAzZsDWVGwwF5-U5q2e_Jniyysgi1fFWfBNMP2gU');
define('PROJECT_ID',                                   'flutter-notification-2-9aac6');


define('STAFF_FCM_SERVER_KEY',                               'AAAABm4avIA:APA91bEzyWQg9ukhCSNVEnKRvU7JcinSEc6eQcHXlsLqX82U_cVLFdW99f73dmRFRtEUwE-yLYsIZGdpMYDgZzEzLjtfrhEkLQUwcTdmio2Ih6icj8iKj_CXoYoz5tpkNgdAWJIBFDus');
define('STAFF_NOTIFICATION_LOGO',                            '');
define('STAFF_FCM_URL',                                      'https://fcm.googleapis.com/fcm/send');
define('STAFF_PUBLIC_FCM_SERVER_VAPID_KEY',                  'BAuVZCqXmNYTPdCWlCeitLkpHOlaUOemXuXSvPMoxx5HFdKT44PzZ7VspFTvNiXcX5MbRzfdcSqfCu12wMOmJy0');



define('PASSWORD','parro@123');

define('APP_USERNAME_TEXTLOCAL',                            'kjes@schoolphins.com'); 
define('APP_HASH_TEXTLOCAL',                                'fc8d5300f261a57362c974bdd0a3ed81862f874df4f99fc1b4004673ff97b40c'); 
define('APP_SENDERID_TEXTLOCAL',                            'PARROP');   
define('APP_API_KEY',                                       'MzE2ZTcyNTkzODM1NDE2MjM5NmMzNTczNzA0ODY4NGU='); 

define('KJES_LINK',                                       'http://192.168.0.65/KJES_STAFF/ADMIN_PANEL/apifetchTokenSuperAdmin/'); 

//define('KJES_LINK',                                       'https://kjes.schoolphins.com/apifetchTokenSuperAdmin/'); 

define('LEAVE_YEAR', '2024');

define('JOB_PORTAL_PATH','http://localhost/ST_XAVIER_PUC_KALBURGI/job_portal/');


