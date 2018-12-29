<?php
/**********************************
 * DEFINE GLOBAL DEFAULT CONSTANTS *
 **********************************/

define('APP_NAME', 'MY YII APPLICATION');
define('APP_SHORT_NAME', 'YII');

#Defines separators
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

#Specifies whether the application is running in debug mode. Set "TRUE" to enable.
defined('DEBUG') || define('DEBUG', TRUE);

#Specifies which environment the application is running in. (prod or dev)
defined('ENV') || define('ENV', 'dev');

 #Sets the default timezone used by all date/time functions in a script 
defined('DEFAULT_TIMEZONE') || define('DEFAULT_TIMEZONE', 'Asia/Ho_Chi_Minh');

#Defines root path
define('ROOT', str_replace(DS, '/', dirname(dirname(dirname(__DIR__)))));

#Defines domain name and protocols
define('DOMAIN', isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:gethostname());

#Defines path to system directories
define('APPLICATION', realpath(ROOT.'/application'));
define('DATA', realpath(ROOT.'/data'));
define('VENDOR', realpath(ROOT.'/vendor'));
define('PUBLIC', ROOT.'/public');

#Defines application base url
defined('BASE_URL') || define('BASE_URL', 'http://'.DOMAIN);
defined('BASE_URL_SECURE') || define('BASE_URL_SECURE', 'https://'.DOMAIN);

defined('BACKEND_URL') ||  define('BACKEND_URL', '/admincp');
//defined('BACKEND_URL') ||  define('BACKEND_URL', 'http://admin.needtoknow.loc');

defined('UPLOADS_DIR') || define('UPLOADS_DIR', ROOT.'/public/uploads');
defined('UPLOADS_URL') || define('UPLOADS_URL', BASE_URL.'/advanced/public/uploads');

defined('STATIC_URL') || define('STATIC_URL', BASE_URL.'/static');
defined('MINIFY_URL') || define('MINIFY_URL', BASE_URL.'/min');






# Mininum length of user's password
define('USER_MIN_PASSWORD_LENGTH', 3);


defined('ADMIN_EMAIL') || define('ADMIN_EMAIL', 'info@dkduyanh.info'); //ssl, tls

#When set to "FALSE" the site is online. Set to "TRUE" the site is offline
defined('MAINTENANCE') || define('MAINTENANCE', FALSE);





defined('TEMP_DIR') || define('TEMP_DIR', DATA.'/runtime'); //or call sys_get_temp_dir() for default
defined('HASH_FILE_METHOD') || define('HASH_FILE_METHOD', 'md5'); //md5, sha1, sha256, sha512




defined('UPLOAD_MAX_FILESIZE') || define('UPLOAD_MAX_FILESIZE', ini_get('upload_max_filesize'));

defined('MIN_ROWS_PER_PAGE') || define('MIN_ROWS_PER_PAGE', 10);
defined('MAX_ROWS_PER_PAGE') || define('MAX_ROWS_PER_PAGE', 300);
defined('DEFAULT_ROWS_PER_PAGE') || define('DEFAULT_ROWS_PER_PAGE', 20);


//CMS
defined('CMS_MEDIA_THUMB_SIZES') || define('CMS_MEDIA_THUMB_SIZES', '');
defined('CMS_POST_ALERT_CHANGE') || define('CMS_POST_ALERT_CHANGE', false);

//Define cache constants
define('DEFAULT_CACHE_PREFIX', 'YII_CMS');
define('DEFAULT_SHORT_CACHE_EXPIRED', 900); //15 mins
define('DEFAULT_MEDIUM_CACHE_EXPIRED', 3600); //1 hour
define('DEFAULT_LONG_CACHE_EXPIRED', 86400); //1 day
define('DEFAULT_TIME_CACHE_EXPIRED', DEFAULT_LONG_CACHE_EXPIRED);

//Define custom constants
define('DEFAULT_USER_IMAGE', '');