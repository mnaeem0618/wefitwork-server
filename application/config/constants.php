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

### PATH CONSTANTS
defined('ADMIN')       OR define('ADMIN', 'admin');
defined('UPLOAD_PATH')  OR define('UPLOAD_PATH','./uploads/');
defined('SITE_IMAGES')  OR define('SITE_IMAGES','./uploads/');
defined('UPLOADIMAGE')  OR define('UPLOADIMAGE','./uploads/');
defined('UPLOAD_VPATH') OR define('UPLOAD_VPATH','./v/');

defined('UPLOADS')  OR define('UPLOADS','uploads/');
defined('ASSETS')   OR define('ASSETS','assets/');

// ### STIRPE KEY CONSTANTS
define('API_PUBLIC_KEY', 'pk_test_ityujjthfgh');
define('API_SECRET_KEY', 'sk_test_fghfgh');

// define('API_PUBLIC_KEY', 'pk_live_fghfgh');
// define('API_SECRET_KEY', 'sk_live_fghfghfgh');

define('SENDINBLUE_API_SECRET_KEY', 'fghfghf');
define('RECAPTCHA_SITE_SECRET_KEY', 'fghfghfgh');
define('MAILGUN_API_KEY', 'b77f87741fb0d3fghfghfghrtyu5723a4ccc894a369026-eb38c18d-a64310df');
define('STRIPE_WEBHOOK_SECRET_KEY', 'whsec_jKsi2J2viaJqdeaohjryttryhfghfghfghnMQ3NsVHOULE0pM3');
// 
//EMAIL TEMPLATE CSS
defined('EMAIL_BODY_CSS_1')   OR define('EMAIL_BODY_CSS_1','
text-align: center;
background: #ffffff;
font-weight: 600;
font-size: 26px;
padding: 30px 30px 30px 30px;
color: #1355ff;');

defined('EMAIL_BODY_CSS_2')   OR define('EMAIL_BODY_CSS_2','
background: #fff;
font-size: 18px;
text-align: left;
line-height: 40px;
color: #000000;
padding: 30px 25px;
');

defined('EMAIL_BODY_CSS_3')   OR define('EMAIL_BODY_CSS_3','padding-top: 30px');

defined('EMAIL_BODY_CSS_4')   OR define('EMAIL_BODY_CSS_4','padding: 40px 0 40px 0; text-align: center');
defined('EMAIL_BODY_CSS_5')   OR define('EMAIL_BODY_CSS_5','
background: #1355ff;
color: #fff;
padding: 12px 30px;
text-decoration: none;
border-radius: 3px;
letter-spacing: 0.3px;');

defined('EMAIL_BODY_CSS_6')   OR define('EMAIL_BODY_CSS_6','padding: 0px');
defined('EMAIL_BODY_CSS_7')   OR define('EMAIL_BODY_CSS_7','color: #3ba1da; text-decoration: none');
defined('EMAIL_BODY_CSS_8')   OR define('EMAIL_BODY_CSS_8','background: #1355ff; color: #fff; padding: 20px 30px');
