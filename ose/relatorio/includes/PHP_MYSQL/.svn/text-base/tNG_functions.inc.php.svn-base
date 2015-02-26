<?php
  // functions needed by impakt generated pages
  if (!defined('CONN_DIR')) define('CONN_DIR',dirname(__FILE__));
  function KT_replaceParam($qstring, $paramName, $paramValue) {
    if (preg_match("/&" . $paramName . "=/", $qstring)) {
      return preg_replace("/&" . $paramName . "=[^&]+/", "&" . $paramName . "=" . urlencode($paramValue), $qstring);
    } else {
      return $qstring . "&" . $paramName . "=" . urlencode($paramValue);
    }
  }

  function KT_removeParam($qstring, $paramName) {
    if($qstring == "&"){
      $qstring = "";
    }
    return preg_replace("/&" . $paramName . "=[^&]+/", "", $qstring);
  }


/***
* KT_keep_arrayParams
* Description: Transform an array into an URL string delimited with &
* Parameters:
* $the_array - The array which it should be transformed
* $the_var - The initial string to which it will add this URL string representation
* $keepName - The name to be keeped if the array has multiple levels 
* $paramName - A key/array of keys name from the array whitch it should be eliminated
*/

function KT_keep_arrayParams($the_array, $the_var, $keepName='', $paramName=''){
	while (list($key, $value) = each($the_array)) {
		if ($paramName == '' OR (!(is_array($paramName)) AND $key != $paramName) OR (is_array($paramName) AND !(in_array($key, $paramName, TRUE)))) {
			if (!is_array($value)){
				$the_var .= "&" . ($keepName!=''?($keepName."["):"").urlencode($key) .($keepName!=''?"]":""). "=" . urlencode($value);
			}else{
				$the_var = KT_keep_arrayParams($value, $the_var, ($keepName!=''?($keepName."["):"").urlencode($key).($keepName!=''?"]":""),$paramName); 
			}
		}
	}
	return $the_var;
}

function KT_keepParams($paramName) {
	global $MM_keepURL, $MM_keepForm, $MM_keepBoth, $MM_keepNone, $_GET, $_POST;
	$MM_keepNone="";

	// add the URL parameters to the MM_keepURL string
	$MM_keepURL = KT_keep_arrayParams($_GET, '', '', $paramName);
	
	// add the Form variables to the MM_keepForm string
	$MM_keepForm = KT_keep_arrayParams($_POST, '', '', $paramName);
	
	// create the Form + URL string and remove the intial '&' from each of the strings
	$MM_keepBoth = $MM_keepURL . $MM_keepForm;
	if (strlen($MM_keepBoth) > 0) $MM_keepBoth = substr($MM_keepBoth,1);
	if (strlen($MM_keepURL) > 0) $MM_keepURL = substr($MM_keepURL,1);
	if (strlen($MM_keepForm) > 0) $MM_keepForm = substr($MM_keepForm,1);
}
  
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
        break;
      case "date":
        // format the date according to the current locale
        global $KT_localFormat;
        global $KT_serverFormat;
        if ($theValue != "") {
            $theValue = KT_convertDate($theValue, $KT_localFormat, $KT_serverFormat);
        }
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }

/*
class fakeRecordSet{
	var $fields=array();
	function prepareValue($field, $value){
		if($value=="NULL"){
	    $value="";
		}
		$this->fields[$field]=$value;
	}
	function Fields($field){
		return $this->fields[$field];
	}
	function Close(){
		unset($this->fields);
	}
}
*/
function fakeRecordSet_prepareValue($field, $value, &$KT_fakeRs) {
	if($value=="NULL"){
    $value="";
	}
	$KT_fakeRs[$field]=$value;
}

function fakeRecordSet_Fields($field, $KT_fakeRs) {
	return $KT_fakeRs[$field];
}

 
	function KT_parseError($a,$b) {
	  //if(strstr($b, "Bad date external representation")){
	  //    $b = "&nbsp;Data nu a fost bine introdusa.";
	  //}
	  echo "<font color=red><p class=\"error\">Error:<br>$b</p></font>";
	}
    
	function KT_DIE($a,$b) {
    echo "<p class=\"error\">An error occured!<br>Error no: $a<br>Error message: $b</p>";
    exit;
	}

   function addReplaceParam($KT_Url,$param,$value=null){
      $sep = (strpos($KT_Url, '?') == false)?"?":"&";
      $value = KT_descape($value);
      if(eregi("$param=[^&]*",$KT_Url)){
         $KT_Url = eregi_replace("$param=[^\&]*", "$param=$value", $KT_Url);
      }else {
         $KT_Url .="$sep$param=$value";
      }
      if ($value == "") {
        $KT_Url = preg_replace("/$param=/", "", $KT_Url);
      }
      $KT_Url = str_replace("?&", "?", $KT_Url);
      $KT_Url = eregi_replace("&+$", "", $KT_Url);
      $KT_Url = preg_replace("/\?$/", "", $KT_Url);
      return $KT_Url;
   }
   
   function KT_descape($KT_text){
     if(eregi("^'.*'$",$KT_text)){
         $KT_text = substr($KT_text, 1, strlen($KT_text)-2);
     }
     return $KT_text;
   }

   function KT_removeEsc($KT_text) {
          if (eregi("^'.*'$",$KT_text)) {
            return substr($KT_text, 1, strlen($KT_text)-2);
        } else {
            return $KT_text;
        }
   }
   
     function KT_convertDate($date, $inFmt, $outFmt) {
        if (($inFmt == "none") || ($outFmt == "none")) {
            return $date;
        }
        if(ereg("^[0-9]+[/|-][0-9]+[/|-][0-9]+$", $date)) {
            $outFmt = eregi_replace(" +.+$", "", $outFmt);
        }
        if (ereg ("%d[/|-]%m[/|-]%Y %H:%M:%S", $inFmt)) {
            if(ereg ("([0-9]{1,2})[/|-]([0-9]{1,2})[/|-]([0-9]{2,4}) *([0-9]{1,2}){0,1}:{0,1}([0-9]{1,2}){0,1}:{0,1}([0-9]{1,2}){0,1}", $date, $regs)){
                for ($i=1;$i<7;$i++) {
                    if ($regs[$i]=="" || !isset($regs[$i])) $regs[$i]="00";
                }
                $outdate = $outFmt;
                $outdate = ereg_replace("%Y",$regs[3],$outdate);
                $outdate = ereg_replace("%m",$regs[2],$outdate);
                $outdate = ereg_replace("%d",$regs[1],$outdate);
                $outdate = ereg_replace("%H",$regs[4],$outdate);
                $outdate = ereg_replace("%M",$regs[5],$outdate);
                $outdate = ereg_replace("%S",$regs[6],$outdate);
            } else {
                $outdate = $date;
            }
        } else if (ereg ("%Y[/|-]%m[/|-]%d %H:%M:%S", $inFmt)) {
            if(ereg ("([0-9]{2,4})[/|-]([0-9]{1,2})[/|-]([0-9]{1,2}) *([0-9]{1,2}){0,1}:{0,1}([0-9]{1,2}){0,1}:{0,1}([0-9]{1,2}){0,1}", $date, $regs)){
                for ($i=1;$i<7;$i++) {
                    if ($regs[$i]=="" || !isset($regs[$i])) $regs[$i]="00";
                }
                $outdate = $outFmt;
                $outdate = ereg_replace("%Y",$regs[1],$outdate);
                $outdate = ereg_replace("%m",$regs[2],$outdate);
                $outdate = ereg_replace("%d",$regs[3],$outdate);
                $outdate = ereg_replace("%H",$regs[4],$outdate);
                $outdate = ereg_replace("%M",$regs[5],$outdate);
                $outdate = ereg_replace("%S",$regs[6],$outdate);
            } else {
                $outdate = $date;
            }
        } else if (ereg ("%m[/|-]%d[/|-]%Y %H:%M:%S", $inFmt)) {
            if(ereg ("([0-9]{1,2})[/|-]([0-9]{1,2})[/|-]([0-9]{2,4}) *([0-9]{1,2}){0,1}:{0,1}([0-9]{1,2}){0,1}:{0,1}([0-9]{1,2}){0,1}", $date, $regs)){
                for ($i=1;$i<7;$i++) {
                    if ($regs[$i]=="" || !isset($regs[$i])) $regs[$i]="00";
                }
                $outdate = $outFmt;
                $outdate = ereg_replace("%Y",$regs[3],$outdate);
                $outdate = ereg_replace("%m",$regs[1],$outdate);
                $outdate = ereg_replace("%d",$regs[2],$outdate);
                $outdate = ereg_replace("%H",$regs[4],$outdate);
                $outdate = ereg_replace("%M",$regs[5],$outdate);
                $outdate = ereg_replace("%S",$regs[6],$outdate);
            } else {
                $outdate = $date;
            }
        } else {
        KT_DIE("KT-Conversion-1", "Unknown data format : ".$inFmt." .");
        }      
        return $outdate;
    }
    
    function KT_redir($url) {
			global $_SERVER;
			$protocol = "http://";;
			$server_name = $_SERVER["HTTP_HOST"];
			if ($server_name != '') {
				$protocol = "http://";;
				if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on")) {
					$protocol = "https://";;;
				}
				if (preg_match("#^/#", $url)) {
					$url = $protocol.$server_name.$url;
				} else if (!preg_match("#^[a-z]+://#", $url)) {
					$url = $protocol.$server_name.(preg_replace("#/[^/]*$#", "/", $_SERVER["PHP_SELF"])).$url;
				}
				header("Location: ".$url);
			}
			exit;
    }
		
		

/**
	register a variable in the session taking in account the PHP version
	@params
		$varname - variable name
		$value - variable value
	@return 
		- none
*/
function KT_session_register($varname, $value) {
	if(!function_exists('version_compare')) { //if the version is smaller than php 4.1.0
		if (ini_get('register_globals') == '1') { //if register globals is on
			global $$varname;
			$$varname = $value;
			session_register($varname);
		} 
		
	} else {
		$_SESSION[$varname] = $value;
	}
	global $_SESSION;
	$_SESSION[$varname] = $value;
	
}	


/**
	unregister a variable from the session taking in account the PHP version
	@params
		$varname - variable name
	@return 
		- none
*/
function KT_session_unregister($varname) {
	if(!function_exists('version_compare')) { //if the version is smaller than php 4.1.0
		if (ini_get('register_globals') == '1') { //if register globals is on
			global $$varname;
			session_unregister($varname);
		} 		
	} else {
		unset($_SESSION[$varname]);
	}
	global $_SESSION;
	unset($_SESSION[$varname]);	
}

//normalize SERVER and ENV vars
if (!isset($_SERVER['QUERY_STRING']) && isset($_ENV['QUERY_STRING'])) {
	$_SERVER['QUERY_STRING'] = $_ENV['QUERY_STRING'];
}
if (!isset($_SERVER['REQUEST_URI']) && isset($_ENV['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = $_ENV['REQUEST_URI'];
}
if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER["PHP_SELF"];
	if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!='') {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}
if (!isset($_SERVER['HTTP_HOST']) && isset($_ENV['HTTP_HOST'])) {
	$_SERVER['HTTP_HOST'] = $_ENV['HTTP_HOST'];
}
if (!isset($_SERVER['HTTPS']) && isset($_ENV['HTTPS'])) {
	$_SERVER['HTTPS'] = $_ENV['HTTPS'];
}
if (!isset($_SERVER['PATH_TRANSLATED']) && isset($_ENV['PATH_TRANSLATED'])) {
	$_SERVER['PATH_TRANSLATED'] = $_ENV['PATH_TRANSLATED'];
}
if (!isset($_SERVER['SCRIPT_FILENAME']) && isset($_ENV['SCRIPT_FILENAME'])) {
	$_SERVER['SCRIPT_FILENAME'] = $_ENV['SCRIPT_FILENAME'];
}

if (!isset($_SERVER['HTTP_REFERER']) && isset($_ENV['HTTP_REFERER'])) {
	$_SERVER['HTTP_REFERER'] = $_ENV['HTTP_REFERER'];
}
if (!isset($_SERVER['HTTP_USER_AGENT']) && isset($_ENV['HTTP_USER_AGENT'])) {
	$_SERVER['HTTP_USER_AGENT'] = $_ENV['HTTP_USER_AGENT'];
}

?>