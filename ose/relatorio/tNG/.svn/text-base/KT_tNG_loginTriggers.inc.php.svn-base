<?php
/*
	NAME:
	KT_TriggerAFTER_LoginTrigger
	DESCRIPTION:
		Checks the transaction result to be non empty(that means that username and password match)
	and then create the SESSION variable that indicates authentication on this site
	PARAMETERS:
		&$tNG - reference to caller tNG Object
		$sitename - site name (in which is valid the authentication)
		$rememberMe - optional - if it's set then set 2 cookies with username and password (crypted)
	RETURN:
	 - none
*/
function KT_TriggerAFTER_LoginTrigger(&$tNG, $sitename, $rememberMe=null) {
	global $_SESSION;
	//construct the session variables names
	$USER_VAR = LOGIN_USER_VAR . $sitename;
	$PASSWORD_VAR = LOGIN_PASSWORD_VAR . $sitename;
	$ID_VAR = LOGIN_ID_VAR . $sitename;
	$LEVEL_VAR = LOGIN_LEVEL_VAR . $sitename;
	//reinitialize the session variables
	KT_session_unregister($USER_VAR);
	KT_session_unregister($ID_VAR);
	KT_session_unregister($LEVEL_VAR);
	$tNG->transactionResult = mysql_fetch_assoc($tNG->transactionResult);	
	if (!$tNG->transactionResult) {
		$tNG->setError(KT_LOGIN_FAILED,"<br>Login Failed!");
	} else {
		global $$USER_VAR, $$ID_VAR;
		KT_session_register($USER_VAR,$tNG->transactionResult[$tNG->userNameField]);
		KT_session_register($ID_VAR,$tNG->transactionResult[$tNG->uniqueKey]);
		
		if ($tNG->levelField) {
			global $$LEVEL_VAR;
			KT_session_register($LEVEL_VAR,$tNG->transactionResult[$tNG->levelField]);
		}
		
		if (isset($rememberMe)) {
			setcookie($USER_VAR, $tNG->transactionResult[$tNG->userNameField], time()+COOKIE_TIME, "/");
			if (!$tNG->pswdIsCrypted) {
				$tmp = $tNG->cryptString($tNG->transactionResult[$tNG->passwordField],1);
			} else {
				$tmp = $tNG->transactionResult[$tNG->passwordField];
			}
			setcookie($PASSWORD_VAR, $tmp, time()+COOKIE_TIME, "/");
		}
	}
}
/*
	NAME:
	restrictAccessToPage
	DESCRIPTION:
		Check the session(or cookie) vars if the user is loggen on and if not redirect the user to the login page
	PARAMETERS:
		$connection - object - connection object
		$sitename - string - the sitename for which the authentication will be valid
		$failedUrl - string - URL to redirect if user is not authorized to view this page
		$tableLgin - string - the login table name
		$uniqueKeyColumn - string - the column name of the unique key in login table
		$usernameColumn - string  - the username column name
		$passwordColumn - string - the password column name
		$levelColumn - string (optional) - the user authentication level column name
		$passwordIsCrypted - boolean - indicates if the password is stored crypted in database
		$grantLevels - string - level of authorization valid for this page (separated by spaces)
		
	RETURN:
	 - none
*/
function restrictAccessToPage(&$connection, $databasename, $sitename, $failedUrl, $tableLogin, $uniqueKeyColumn, $usernameColumn, $passwordColumn, $levelColumn, $passwordIsCrypted, $grantLevels = array()) {
	//we should see if there is need to also pass the database name
	//define global variables
	global $_SESSION, $_COOKIE, $_SERVER;
	$KT_authFailedURL=$failedUrl;
	$KT_grantAccess=false;
	//construct the session variables names
	$USER_VAR = LOGIN_USER_VAR . $sitename;
	$PASSWORD_VAR = LOGIN_PASSWORD_VAR . $sitename;
	$ID_VAR = LOGIN_ID_VAR . $sitename;
	$LEVEL_VAR = LOGIN_LEVEL_VAR . $sitename;
	if (isset($_SESSION[$USER_VAR])) {
		//check if the user has the authorization level to enter this page
		if (count($grantLevels) > 0) {
			if (in_array($_SESSION[$LEVEL_VAR], $grantLevels)) {
				$KT_grantAccess = true;
			}
		} else {
			$KT_grantAccess = true;
		}
		/*
		if (!(isset($_SESSION[$LEVEL_VAR])) || in_array($_SESSION[$LEVEL_VAR], $grantLevels)) {
			$KT_grantAccess = true;
		}
		*/
	} else {
		//if the user have remebered his login in browser cookies
		if (isset($_COOKIE[$USER_VAR]) && isset($_COOKIE[$PASSWORD_VAR])) {
			mysql_select_db($databasename, $connection);
			$KT_rs = mysql_fetch_assoc(mysql_query('select * from ' . $tableLogin . ' where ' . $usernameColumn . ' = \'' . $_COOKIE[$USER_VAR] . '\'', $connection));
			if ($KT_rs) {
				//generate the crypted password
				//initialize a KT_tNG_login object for crypting
				$cryptPasswd = cryptText($KT_rs[$passwordColumn], $sitename, $passwordIsCrypted);
				//$cryptPasswd = cryptText($KT_rs[$passwordColumn], $sitename, false);
				//see if the two password match
				if ($cryptPasswd == $_COOKIE[$PASSWORD_VAR]) {
					//check if the user has the authorization level to enter this page
					if ((!($levelColumn)) || in_array($KT_rs[$levelColumn], $grantLevels)) {
						global $$USER_VAR, $$ID_VAR;
						KT_session_register($USER_VAR, $KT_rs[$usernameColumn]);

						KT_session_register($ID_VAR, $KT_rs[$uniqueKeyColumn]);

						if ($levelColumn) {
							global $$LEVEL_VAR;
							KT_session_register($LEVEL_VAR, $KT_rs[$levelColumn]);
						}
						$KT_grantAccess = true;
					}
				}
			}
		}
	}
	//if we don't get the access redirect user
	if (!$KT_grantAccess) {
		$KT_qsChar = "?";
		if (strpos($KT_authFailedURL, "?")) $KT_qsChar = "&";
		$KT_authFailedURL = $KT_authFailedURL . $KT_qsChar;
		if(isset($_GET['accessdenied'])) {
			$KT_authFailedURL .= "accessdenied=" . urlencode($_GET['accessdenied']);
		} else {
			$KT_referrer = $_SERVER["REQUEST_URI"];
			$KT_authFailedURL .= "accessdenied=" . urlencode($KT_referrer);
		}
		KT_redir($KT_authFailedURL);
	}	
}

/*
	NAME:
	loginUser
	DESCRIPTION:
		Check the cookie vars and set the session ones if necessary
	PARAMETERS:
		$connection - object - connection object
		$sitename - string - the sitename for which the authentication will be valid
		$tableLgin - string - the login table name
		$uniqueKeyColumn - string - the column name of the unique key in login table
		$usernameColumn - string  - the username column name
		$passwordColumn - string - the password column name
		$levelColumn - string (optional) - the user authentication level column name
		$passwordIsCrypted - boolean - indicates if the password is stored crypted in database
		
	RETURN:
	 - none
*/
function loginUser (&$connection, $sitename, $tableLogin, $uniqueKeyColumn, $usernameColumn, $passwordColumn, $levelColumn, $passwordIsCrypted) {
	//define global variables
	global $_SESSION, $_COOKIE, $_SERVER;
	//construct the session variables names
	$USER_VAR = LOGIN_USER_VAR . $sitename;
	$PASSWORD_VAR = LOGIN_PASSWORD_VAR . $sitename;
	$ID_VAR = LOGIN_ID_VAR . $sitename;
	$LEVEL_VAR = LOGIN_LEVEL_VAR . $sitename;
	if (isset($_SESSION[$USER_VAR])) {
		return;
	} else {
		//if the user have remebered his login in browser cookies
		if (isset($_COOKIE[$USER_VAR]) && isset($_COOKIE[$PASSWORD_VAR])) {
			mysql_select_db($databasename, $connection);
			$KT_rs = mysql_fetch_assoc(mysql_query('select * from ' . $tableLogin . ' where ' . $usernameColumn . ' = \'' . $_COOKIE[$USER_VAR] . '\'', $connection));
			if ($KT_rs) {
				//generate the crypted password
				//initialize a KT_tNG_login object for crypting
				$cryptPasswd = cryptText($KT_rs[$passwordColumn], $sitename, $passwordIsCrypted);
				//see if the two password match
				if ($cryptPasswd == $_COOKIE[$PASSWORD_VAR]) {
					//check if the user has the authorization level to enter this page
					global $$USER_VAR, $$ID_VAR;
					KT_session_register($USER_VAR, $KT_rs[$usernameColumn]);

					KT_session_register($ID_VAR, $KT_rs[$uniqueKeyColumn]);

					if ($levelColumn) {
						global $$LEVEL_VAR;
						KT_session_register($LEVEL_VAR, $KT_rs[$levelColumn]);
					}
				}
			}
		}
	}
}

/*
	NAME:
	userLoggedIn
	DESCRIPTION:
		Check the session vars and see if the current user has demanded rights or not
	PARAMETERS:
		$sitename - string - the sitename for which the authentication will be valid
		$grantLevels - array - level of authorization valid for this page (separated by spaces)
		
	RETURN:
	 - true if the currnt user is logged-in and have correct rights
	 - false otherwise
*/
function userLoggedIn ($sitename, $grantLevels = array()) {
	//define global variables
	global $_SESSION, $_COOKIE, $_SERVER;
	$USER_VAR = LOGIN_USER_VAR . $sitename;
	$LEVEL_VAR = LOGIN_LEVEL_VAR . $sitename;

	// if the user is logged in
	if (isset($_SESSION[$USER_VAR])) {
		// if there are no level demands
		if (sizeof($grantLevels)==0) {
			return true;
		} else {
			// if the user's level is in the demanded levels
			if (in_array($_SESSION[$LEVEL_VAR], $grantLevels)) {
				return true;
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
}

/*
	NAME:
	generateNewPassword
	DESCRIPTION:
		Generate a new password based on a User Unique Identifier and the current system time
	PARAMETERS:
		$passwordLength - optional - the length of new generated password
	RETURN:
		String - new password
*/
function generateNewPassword($passwordLength) {
	//make a seed for the random generator
	list($usec, $sec) = explode(' ', microtime());
	$seed =  (float) $sec + ((float) $usec * 100000);
	//generate a new random value
	srand($seed);
	$newpass = md5(rand());
	if ($passwordLength) {
		return substr($newpass,0,$passwordLength);
	} else {
		return $newpass;
	}
}

/*
	NAME:
	cryptText
	DESCRIPTION
		Crypt atext with a given keyName (uses the KT_tNG_Login object to initialize the crypt engine)
	PARAMETERS:
		$text - text to be cyrpted
		$keyName - the name of the crypt key 
		$uncrypt - optional - if set don't perform any crypting
	RETURN:
		string - the crypt text
*/
function cryptText($text, $keyName, $uncrypt = false) {
	//initialize a KT_tNG_login object for crypting
	$tmLogin = new KT_tNG_login();
	$tmLogin->passwordIsCryptedInDatabase(!$uncrypt);
	$tmLogin->generateSalt($keyName);
	return $tmLogin->cryptString($text);
}
?>
