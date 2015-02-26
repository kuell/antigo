<?php
define('DATA_TYPE','data');
define('STRING_TYPE','string');
define('NUMERIC_TYPE','numeric');
define('CHECKBOX_YN_TYPE','checkbox_Y/N');
define('CHECKBOX_1_0_TYPE','checkbox_1/0');
define('CHECKBOX_TF_TYPE','checkbox_tf');
define('DATE_ACCESS_TYPE','date_access');
define('FILE_TYPE','file_type');

define('INSERT_TYPE','insert');
define('UPDATE_TYPE','update');
define('DELETE_TYPE','delete');
define('CUSTOM_TYPE','custom');
define('UNIQUE_SELECT_TYPE','uniqueSelect');

define('STARTER','starter_trigger');
define('AFTER','after_trigger');
define('BEFORE','before_trigger');
define('ERROR','error_trigger');

//Login constants
define('COOKIE_TIME',8640000);//100 days
define('LOGIN_USER_VAR','KT_user_');
define('LOGIN_ID_VAR','KT_id_');
define('LOGIN_PASSWORD_VAR','KT_password_');
define('LOGIN_LEVEL_VAR','KT_level_');

// Transaction errors
define('KT_UNKNOWN_TRIGGER_TYPE',1);
define('KT_TRANSACTION_FAILED',2);
define('KT_NO_AUTO_TYPE',3);
define('KT_NO_PARAMS_DELETE_SQL',4);
define('KT_COLUMNS_NOT_MATCH',5);
define('KT_NO_PARAMS_UPDATE_SQL',6);
define('STOP_AT_STARTER',7);
define('SAVE_DATA_ERROR',8);

//login errors
define('KT_LOGIN_FAILED',101);
//Update Password Errors
define('KT_UP_USER_DONT_EXIST',120);
define('KT_UP_USER_DONT_EXIST_MSG','User not found in database!');
define('KT_UP_UPDATE_FAILED',121);
define('KT_UP_UPDATE_FAILED_MSG','Error updating field!');

//$KT_define_dataTypes = Array(NUMERIC,STRING,DATA);
//$KT_define_isQuoted = Array(STRING,DATA);
?>