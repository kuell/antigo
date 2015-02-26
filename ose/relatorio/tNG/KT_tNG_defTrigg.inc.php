<?php
/**
	Default Starter trigger
	Verifies if additional parameters are set and if not invalidate the transaction
		this is usefull for verifying some global variables.
**/
function KT_TriggerSTARTER_Default(&$tNG){
	$args = func_get_args();
	for ($argsIdx = 1;$argsIdx < count($args);$argsIdx++) {
		if (!isset($args[$argsIdx])) {
			$tNG->setError(STOP_AT_STARTER,'Stop at starter');
			return;
		}
	}
}
/**
	BEFORE Trigger
	Saves the current row data before we execute the transaction
	This used for the update/delete procedures to save the row data for AFTER processing
	
**/
function KT_TriggersBEFORE_SaveData(&$tNG) {
	$separator = $tNG->type2quote[$tNG->uniqueKeyType];
	$saveSQL = 'select * from ' . $tNG->table. ' where ' . $tNG->uniqueKey . ' = ' . $separator . $tNG->uniqueKeyValue . $separator;
	@mysql_select_db($tNG->databasename, $tNG->connection);
	$rs = @mysql_query($saveSQL, $tNG->connection);
	if (is_resource($rs)){
		$tNG->savedData = mysql_fetch_assoc($rs);
	}else{
		$tNG->setError(SAVE_DATA_ERROR,'Invalid primary Key supplied by the programmer or invalid value for the primary key to be updated');
		return;
	}	
	if (!$tNG->savedData) {
	 $tNG->setError(SAVE_DATA_ERROR,'Error executing save SQL!');
	 return;
	}
}
/**
	NAME:
		KT_TriggerERROR_ProduceFakeRs
	DESCRIPTION:
		if the transaction fails produce a fakeRecordset ($KT_fakeRs) and set $KT_error on true
	ARGUMENTS:
		$tNG - tNG Object
	RETURN:
			- none
			- set the globals $KT_fakeRs adn $KT_error
**/
function KT_TriggerERROR_ProduceFakeRs(&$tNG) {
	global $KT_error;
	global $KT_fakeRs;
	//$KT_fakeRs = new fakeRecordSet();
	$KT_fakeRs = array();
	for ($idxCol = 0;$idxCol < count($tNG->columnsName);$idxCol++) {
		switch ($tNG->columnsType[$idxCol]) {
			case CHECKBOX_YN_TYPE:
			case CHECKBOX_1_0_TYPE:
			case CHECKBOX_TF_TYPE:
				fakeRecordSet_prepareValue($tNG->columnsName[$idxCol], 
																((!isset($tNG->columnsValue[$idxCol])) ?  $tNG->type2empty[$tNG->columnsType[$idxCol]] 
																																			 : $tNG->type2alt[$tNG->columnsType[$idxCol]]),
																$KT_fakeRs);
			break;
			default:
				//$KT_fakeRs->PrepareValue($tNG->columnsName[$idxCol],$tNG->columnsValue[$idxCol]);
				fakeRecordSet_prepareValue($tNG->columnsName[$idxCol],
																	stripslashes($tNG->columnsValue[$idxCol]), 
																	$KT_fakeRs);
		}
	}
	$KT_error = true;
}


define ('UNI_VAL_SIZE_NOT_MATCH','UniVal Parameters does not have the same size!');
//define ('UNI_VAL_EMPTY_VAL','Field %s is empty!');
//define ('UNI_VAL_NOT_MATCH','The value of %s is incorect!');
/** 
Class definition
NAME:
	UniValValidator
DESCRIPTION:
	This Class is a simple validator class that incapsulate the UniVal functionality
**/
class UniValValidator {
	var $labels; // - array - the labels (english names) of the fields
	var $required; //- array - specifies if the fields are required
	var $regExp; // - array - validator regExp for avery field
	var $columnsValue; // - array - the value of every column that will be validate
	var $columnsName; // - array - the name of every column that will be validate
	
	
	// constructor
	function UniValValidator($labels, $required, $regExp, $columnsValue, $columnsName) {
		$this->labels = $labels;
		$this->required = $required;
		$this->regExp = $regExp;
		$this->columnsValue = $columnsValue;
		$this->columnsName = $columnsName;
		
	}
		
	/**
	NAME:
		validateFields
	DESCRIPTION:
		validates the columnsValue based on regExp and required information
	ARGUMENTS:
		none - 
		property used: 
				$required
				$regExp
				$columnsValue
				$columnsName
	RETURN:
		string - empty on succes , an error message if fails
		property changed:
			- none
	**/
	function validateFields() {
		if (count($this->required) != count($this->regExp)) {
			return UNI_VAL_SIZE_NOT_MATCH;
		}
		$errStr = "";
		for ($colIdx = 0;$colIdx < count($this->required);$colIdx++) {
			if ($this->required[$colIdx]) {
				if ((string)($this->columnsValue[$this->columnsName[$colIdx]]) == "") {
					$errStr .= "<br>" . $this->labels[$colIdx];
				}
			}
			if ($this->columnsValue[$this->columnsName[$colIdx]] != "") {
				if (!preg_match('/^' . $this->regExp[$colIdx] . '$/i',substr($this->columnsValue[$this->columnsName[$colIdx]],0,400))) {
					$errStr .= "<br>" . $this->labels[$colIdx];
				}
			}
		}
		return $errStr;
	}
}

/** 
Class definition
NAME:
	FileUpload
DESCRIPTION:
	Provides functionalities for handling file uploads
**/
class FileUpload {
	var $sufix; // the file sufix
	var $prefix; // the file prefix
	var $folder; // folder where will be stored uploaded files
	var $fileInfo; // assoc array of file information. Get from $_FILES[''] array
	var $convert = 'convert'; // the path to the ImageMagik's convert command
	var $sharpen = " -sharpen 1x1"; // the sharpen parameter
	var $jpegQuality = 90; // the quality parameter
	
	//constructor
	function FileUpload($prefix, $sufix, $folder, $fileInfo) {
		$this->prefix = $prefix;
		$this->sufix = $sufix;
		$this->folder = realpath('./') . '/' . $folder;
		if(substr($this->folder, 0, 1) != "/") {
			$this->folder = str_replace('/', '\\', $this->folder);
		}
		$this->fileInfo = &$fileInfo;
	}
	
	/**
	NAME:
		processUploadedFile
	DESCRIPTION:
		handle the uploaded file by copying(and renaming) it in the destination folder. The destination file is 
				formed by relation: folder + prefix + "__" + sufix
		handles required checkbox too
		handles image resize if necessary
	ARGUMENTS:
		$mandatory = is file mandatory
		$isImage = is image
		$keep = keep proportions (for image resize)
		$w = new width
		$wt = width type (pixels or %)
		$h = new height
		$ht = height type (pixels or %)
		
		property used: 
				$prefix
				$sufix
				$folder
				$fileInfo
	RETURN:
		string - empty on succes , an error message if fails
		property changed:
			- none
	**/
	function processUploadedFile($mandatory = '', $isImage = '', $keep = '', $w = '', $h = '', $sharpen = '') {
		//check if the upload folder exists and if not create it
		if (!file_exists($this->folder)) {
			mkdir($this->folder);
		}
		$destination = $this->folder . $this->prefix . '__' . $this->sufix;

		// ups, file upload problem let's check the reasons.
	  if (!file_exists($this->fileInfo['tmp_name'])){
		   if (isset($this->fileInfo['error']) && !is_array($this->fileInfo['error']) && $this->fileInfo['error'] >0){
				  switch ($this->fileInfo['error']){
							case 1: return "<br>The uploaded file exceeds the upload_max_filesize directive in php.ini.<br>Error Reference UPLOAD_ERR_INI_SIZE";
							case 2: return "<br>The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form<br>Error Reference UPLOAD_ERR_FORM_SIZE";
							case 3: return "<br>The uploaded file was only partially uploaded.<br>Error Reference UPLOAD_ERR_PARTIAL";
							case 4: break;
							default: return "<br> Unsupported Error Number ".$this->fileInfo['error']." on file/image upload";
					}
			 }
		}	
		if (is_uploaded_file($this->fileInfo['tmp_name'])) {
			if($isImage != ''){
				return $this->ResizeImage($this->fileInfo['tmp_name'], $destination, $w, $h, $this->fileInfo['type'], $sharpen, $keep);
			}
			if (!copy($this->fileInfo['tmp_name'],$destination)) {
				return "<br>Errors copying file to " . $destination;
			}
		} else {
			if($mandatory != ''){
				if ($this->fileInfo['tmp_name'] != ''){
					return '<br>Possible file upload attack. Filename: ' . $this->fileInfo['tmp_name'];
				} elseif ($this->fileInfo['error'] == 4) {
					return '<br>The file to upload is required.';
				}
			}
		}
		return '';
	}
	
	/**
		 BRI TREBUIE SA COMENTEZE ACEASTA FUNCTIE!!!!!!!!!!!!!!! 
	**/
	function ResizeImage ($image, $pathToSave, $newWidth, $newHeight, $imagetype, $sharpen, $keep) {
		// removes the image if it exists
		if (file_exists($pathToSave)) {
			$a=unlink($pathToSave);
		}
		if (!preg_match("#^image/#", $imagetype)) {
			return "<br>Image type not recognized : " . $imagetype;
		}
		$resize = ($newWidth != '' || $newHeight != '');
		
		if($sharpen == '' && !$resize){
			if (!move_uploaded_file($image, $pathToSave)) {
				return "<br>Error writing file to <b>" . $pathToSave . "</b>.<br>Please check folder permissions.";
			}
			return "";
		}

		$gd = false;
		if (function_exists("ImageTypes")) {
		if ($imagetype == 'image/gif' && @ImageTypes() & IMG_GIF) {
			$gd = true;
		} elseif (($imagetype == 'image/x-png' || $imagetype == 'image/png') && @ImageTypes() & IMG_PNG) {
			$gd = true;
		} elseif (($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg' || $imagetype == 'image/jpg') && @ImageTypes() & IMG_JPG) {
			$gd = true;
		}
		}
		if ($sharpen == 0 && $gd) {
			switch($imagetype) {
				case "image/gif":
					$srcImage=@imagecreatefromgif($image);
					break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					$srcImage=@imagecreatefromjpeg($image);
					break;
				case "image/x-png":
				case "image/png":
					$srcImage=@imagecreatefrompng($image);
					break;
				default:
					$srcImage=@imagecreatefromjpeg($image);
					break;
			}
			if ($srcImage) {
				$srcWidth = ImageSX( $srcImage ); 
				$srcHeight = ImageSY( $srcImage ); 
				if ($keep == '1') {
					if ($newWidth != '' && $newHeight != '') {
						$ratioWidth = $srcWidth/$newWidth; 
						$ratioHeight = $srcHeight/$newHeight; 
						if( $ratioWidth < $ratioHeight ){ 
							$destWidth = $newWidth * $srcWidth/$srcHeight; 
							$destHeight = $newHeight; 
						} else { 
							$destWidth = $newWidth; 
							$destHeight = $srcHeight/$ratioWidth; 
						}
					} else {
						if ($newWidth != '') {
							$ratioWidth = $srcWidth/$newWidth; 
							$destWidth = $newWidth; 
							$destHeight = $srcHeight/$ratioWidth; 
						} else if ($newHeight != '') {
							$ratioHeight = $srcHeight/$newHeight; 
							$destHeight = $newHeight; 
							$destWidth = $srcWidth/$ratioHeight; 
						} else {
							$destWidht = $srcWidth;
							$destHeight = $srcHeight;
						}
					}
				} else {
					$destWidth = $newWidth; 
					$destHeight = $newHeight; 
				}
				$destWidth = round ($destWidth);
				$destHeight = round ($destHeight);
				// RST - do not resize if image is smaller
				if($srcWidth <= $destWidth && $srcHeight <= $destHeight) {
					return '';
				}
				ob_start();
				phpinfo(8);
				$phpinfo=ob_get_contents();
				ob_end_clean();
				$phpinfo=strip_tags($phpinfo);
				$phpinfo=stristr($phpinfo,"gd version");
				$phpinfo=stristr($phpinfo,"version");
				$end=strpos($phpinfo,".");
				$phpinfo=substr($phpinfo,0,$end);
				$length = strlen($phpinfo)-1;
				$phpinfo=substr($phpinfo,$length);

				if (function_exists('imagecreatetruecolor') && $phpinfo>=2) {
					$destImage = @imagecreatetruecolor ($destWidth, $destHeight); 
				} else {
					$destImage = @imagecreate ($destWidth, $destHeight); 
				}
				if (function_exists('imagecopyresampled') && $phpinfo>=2) {
					@ImageCopyResampled ($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
				} else {
					@ImageCopyResized ($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
				}
				@ImageJPEG ($destImage, $pathToSave, $this->jpegQuality); 
				@ImageDestroy ($srcImage); 
				@ImageDestroy ($destImage);
				if (file_exists ($pathToSave)) {
					return "";
				} else {
					return "<br>Error writing file to " . $pathToSave . ".<br>Please check folder permissions.";
				}
			} else {
				return "<br>Unidentified GD Error";
			}
		} else {
			//RST first identify image
			$cmd = 'identify -format "%wx%h" '. $image;
			$result = exec($cmd);
			if($result == '') {
				//command not found 
				return '<br>Please check ImageMagik installation.';
			} else if(preg_match("/\dx\d/i", $result)) {
				$wh = split("x", $result);
				$srcWidth = $wh[0];
				$srcHeight = $wh[1];
			} else {
				// some error
				return '<br>'.$result;
			}
		
			$cmd = $this->convert;
			// RST - add > after size so image will be only resized down 
			if ($resize) {
				$cmd .= " -sample ";
				if($newWidth) {
					$cmd .= "'${newWidth}";
				} else {
					$cmd .= "'${srcWidth}";
				}
				if ($newHeight) {
					$cmd .= "x${newHeight}>'";
				} else {
					$cmd .= "x${srcHeight}>'";
				}
				if (!$keep) {
					$cmd .= "!";
				}
				if (($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg' || $imagetype == 'image/jpg')
					 or ($imagetype == 'image/x-png' || $imagetype == 'image/png')) {
					$cmd .= " -quality ".$this->jpegQuality;
				}
			}
			if ($sharpen) {
				$cmd .= $this->sharpen;
			}
			$cmd .= " $image $pathToSave";
			$status = 0;
			$output = array();
			$result = exec("$cmd 2>&1",$output,$status);
			if (($result != '') || ($status != 0)){
				return "<br>Error writing file to <b>" . $pathToSave . "</b>. Please check folder permissions and ImageMagik installation.";
			}
		}
	}
}

?>
