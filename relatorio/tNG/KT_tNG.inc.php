<?php
//include the definitions
require_once(CONN_DIR.'/../tNG/KT_tNG_defines.inc.php');
//include the delete rules
@include_once(CONN_DIR.'/../tNG/dTables.inc.php');
// include the base class
require_once(CONN_DIR.'/../tNG/KT_tNG_base.inc.php');
// include the default triggers 
require_once(CONN_DIR.'/../tNG/KT_tNG_defTrigg.inc.php');
// include the Login Transaction and triggers
require_once(CONN_DIR.'/../tNG/KT_tNG_loginTriggers.inc.php');
require_once(CONN_DIR.'/../tNG/KT_tNG_login.inc.php');

//class interface
class KT_tNG extends KT_tNG_base {

	// constants
	//correspondence between a datatype and the empty value associate
	var $type2empty;
	//correspondence between a datatype and the quote
	var $type2quote;
	//correspondence between a datatype and the default tru value (especially for checkboxes)
	var $type2alt;
	

	//	
	// properties
	//
	

	// transaction type ('insert','update','delete','custom');
	var $type; //string

	// the affected table 
	var $table; //string
	
	// Unique Key
	var $uniqueKey; //string
	// Unique Key Value
	var $uniqueKeyValue;
	// Unique Key Data Type 
	var $uniqueKeyType;
	
	// columns name
	var $columnsName; //array
	// data Tyep of columns
	var $columnsType; //array
	// columns Value
	var $columnsValue; //array
	// empty values
	var $emptyValues; //array
	// alternative values
	var $altValues; //array
	//associative array columnsName->columnsValue
	var $nameToValue; //array
	//associative array columnsName->index
	var $name2index;
  //this flag will verify if the fields have already added slashes and they will be removed before being added once again
	var $remove_quotes;

	// constructor 
	
	function KT_tNG() {
		// initialisation of all properties goes here
		$this->type2empty = array(NUMERIC_TYPE => 'null' , DATA_TYPE => 'null' , STRING_TYPE=>'null',FILE_TYPE=>'null' , 
															CHECKBOX_YN_TYPE=>'N', CHECKBOX_1_0_TYPE=>'0', DATE_ACCESS_TYPE=>'#0#', 
															CHECKBOX_TF_TYPE=>'f');
		//correspondence between a datatype and the quote
		$this->type2quote = array(NUMERIC_TYPE => '' , DATA_TYPE => '\'' , 
															STRING_TYPE=>'\'',  DATE_ACCESS_TYPE=>'#', 
															FILE_TYPE=>'\'',
															CHECKBOX_TF_TYPE=>'\'',
															CHECKBOX_YN_TYPE=>'\'',
															CHECKBOX_1_0_TYPE=>''
															);
		//correspondence between a datatype and the default tru value (especially for checkboxes)
		$this->type2alt = array(CHECKBOX_TF_TYPE=>'t', CHECKBOX_YN_TYPE=>'Y', CHECKBOX_1_0_TYPE=>'1');
		$this->remove_quotes = false;
	}
	
	//
	//public methods
	//
	

	/**
	set the Transaction type
	$i_type = ('Update'|'Insert'|'Delete'|'Custom')
	**/
	function setTransactionType($i_type) {
		$this->type = $i_type;
	}

	/**
	get the Transaction type
	**/
	function getTransactionType() {
		return $this->type;
	}
	
	/**
	set the name of the affected table
	$i_tableName = string
	**/
	function setTable($i_tableName) {
		$this->table = $i_tableName;
	}
	
	/**
	get the name of the affected table
	**/
	function getTable() {
		return $this->table;
	}
	
	/**
	set the unique key
	$i_keyName = string (name of the key)
	$i_keyValue = (value of the key)
	$i_keyQuote = unique Key Data Type
	**/
	function setUniqueKey($i_keyName,$i_keyValue,$i_keyType) {
		$this->uniqueKey = $i_keyName;
		$this->uniqueKeyValue = $i_keyValue;
		$this->uniqueKeyType = $i_keyType;
	}
	
	/**
	get the unique key information
	(name,value,quote)
	**/
	function getUniqueKey() {
		return array($this->uniqueKey, $this->uniqueKeyValue, $this->uniqueKeyType);
	}
	
	

	/**
	set the columns names 
	$i_colNames = array of strings
	**/
	function setColumnsName($i_colNames) {
		$this->columnsName = $i_colNames;
	}
	
	/**
	get the columns names
	**/
	function getColumnsName() {
		return $this->columnsName;
	}

	/** 
	set the columns type
	$i_columnsType = array (with types for every column)
	**/
	function setColumnsType($i_columnsType) {
		$this->columnsType = $i_columnsType;
	}
	

	/** 
	get the columns type
	**/
	function getColumnsType() {
		return $this->columnsType;
	}
		
	/** 
	set the columns value
	$i_columnsValue = array (with value for every column)
	**/
	function setColumnsValue($i_columnsValue) {
		$this->columnsValue = $i_columnsValue;
		if (get_magic_quotes_gpc()) {
		for ($idxCol = 0;$idxCol < count($this->columnsValue);$idxCol++) {
			if (isset($this->columnsValue[$idxCol])) {
				$this->columnsValue[$idxCol] = stripslashes($this->columnsValue[$idxCol]);
			}
		}
	}
	}
	

	/** 
	get the columns value
	**/
	function getColumnsValue() {
		return $this->columnsValue;
	}

	/**
	set the alternate value for the SQL fields
	$i_altVal = array 
	**/
	function setAltValues($i_altVal) {
		$this->altValues = $i_altVal;
	}

	/**
	get the alternate value for the SQL fields
	**/
	function getAltValues() {
		return $this->altValues;
	}
	
	/**
	set the empty values for the SQL fields	
	$i_emptyVal = array
	**/
	function setEmptyValues($i_emptyVal) {
		$this->emptyValues = $i_emptyVal;
	}
	

	/**
	get the empty values for the SQL fields	
	**/
	function getEmptyValues() {
		return $this->emptyValues;
	}
	
	/**
	NAME:
	getValueForColumnName
	DESCRIPTION:
	gets the values of the $columnName column
	PARAMETERS:
	$columnName - string - name of the column
	RETURN:
		mixed var - the column value or null if $columnName 
	isn't a valid column of the transaction
	**/
	function getValueForColumnName($columnName) {
		if (isset($this->name2index[$columnName])) {
			return $this->columnsValue[$this->name2index[$columnName]];
		} else {
			return null;
		}
	}

	/**
	NAME:
	getValueForColumnName
	DESCRIPTION:
	sets the values of the $columnName column
	PARAMETERS:
	$columnName - string - name of the column
	$columnValue - mixed var - value of the column
	RETURN:
	mixed var - the column value
	**/
	function setValueForColumnName($columnName, $columnValue) {
		if (isset($this->name2index[$columnName])) {
			$this->columnsValue[$this->name2index[$columnName]] = $columnValue;
			$this->nameToValue[$columnName] = $columnValue;
			return true;
		} else {
			return false;
		}
	}

	/**
	NAME:
	prepareSQL
	DESCRIPTION:
	Genrate the SQL
	PARAMETERS:
	none
	RETURN:
	none
	**/
	function prepareSQL() {
		if (($this->type == INSERT_TYPE) || 
				($this->type == UPDATE_TYPE) || 
				($this->type == DELETE_TYPE) ||
				($this->type == UNIQUE_SELECT_TYPE)) {
					$this->generateSQL();
				}
		parent::prepareSQL();
	}
	
	/**
	Execute the transaction 
	Reimplement default method to generate the SQL if it's  autogenerate
	**/
	function executeTransaction() {
		//construct the associative array columnsName->columnsValues
		$this->generateColumnsAssoc();
		//call the parent method
		parent::executeTransaction();
	}
	
	/**
	Generate the columnsName->columnsValue associative array
	and columnsName->index assocoarive array
	**/
	function generateColumnsAssoc() {
		$this->nameToValue = Array();
		if (isset($this->columnsName)) {
		  for ($colIdx = 0;$colIdx < count($this->columnsName);$colIdx++) {
				// if the data Type is DATA format the value to serverFormat
				switch ($this->columnsType[$colIdx]) {
					case DATA_TYPE:
						$tmValue = $this->columnsValue[$colIdx];
						break;
					case CHECKBOX_YN_TYPE:
					case CHECKBOX_1_0_TYPE:
					case CHECKBOX_TF_TYPE:
					 	$tmValue = (!isset($this->columnsValue[$colIdx])) ?  $this->type2empty[$this->columnsType[$colIdx]] : $this->type2alt[$this->columnsType[$colIdx]] ;
						break;
					case FILE_TYPE:
						$includeField = isset($this->columnsValue[$colIdx]) && (!empty($this->columnsValue[$colIdx]));
					default:
						$tmValue = $this->columnsValue[$colIdx];
				}
			  $this->nameToValue[$this->columnsName[$colIdx]] = $tmValue ;
			  $this->name2index[$this->columnsName[$colIdx]] = $colIdx;
		  }
	  }
		//escape quotes
		if (!$this->remove_quotes){	
			for ($idxCol = 0;$idxCol < count($this->columnsValue);$idxCol++) {
				if (isset($this->columnsValue[$idxCol])) {
					$this->columnsValue[$idxCol] = preg_replace('/(\\\\|\')/i','\\\$1',$this->columnsValue[$idxCol]);
				}
			}
			$this->remove_quotes = true;
		}
	}
	
	/**
	Generates the SQL of the transaction based on the previos gathered informations (columns names,types,values)
	**/
	function generateSQL() {
		//check the type of the transaction and call the apropiate method
		switch ($this->type) {
			case DELETE_TYPE:
					$this->generateDeleteSQL();
					break;
			case UPDATE_TYPE:
					$this->generateUpdateSQL();
					break;
			case INSERT_TYPE:
					$this->generateInsertSQL();
					break;
			case UNIQUE_SELECT_TYPE:
				$this->generateUniqueSelectSQL();
				break;
			default: // if it isn't an autogenerated type set an error
				$this->errorNo = KT_NO_AUTO_TYPE;
				$this->errorMsg = 'No autogenerated type!';
		}
		
	}	


	
	//
	// private methods
	//

	
	/**
	generate Delete SQL 
	**/
	function generateDeleteSQL() {
		//$keyQuote = (in_array($this->uniqueKeyType,$GLOBALS['KT_define_isQuoted'])) ? "'" : "";
		$keyQuote = $this->type2quote[$this->uniqueKeyType];
		if (($this->table) && ($this->uniqueKey) && ($this->uniqueKeyValue)) {
			if (!function_exists("cascadeDelete")) {
				$this->SQL = 'delete from ' . $this->table . ' where ' . $this->uniqueKey . ' = ';
				$this->SQL = $this->SQL . $keyQuote . $this->uniqueKeyValue . $keyQuote;
			} else {
				$tmp = cascadeDelete($this->table,  $this->uniqueKey . ' = '. $keyQuote . $this->uniqueKeyValue . $keyQuote, $this);
				if (is_array($tmp)) {
					$this->SQL = $tmp;
				} else {
					$this->errorNo = -1;
					$this->errorMsg = $tmp;
				}
			}
		} else {
			$this->errorNo = KT_NO_PARAMS_DELETE_SQL;
			$this->errorMsg = "Not enough parameters to generate delete SQL!";
		}
	}
	
	/**
	generate Update SQL
	**/
	function generateUpdateSQL() {
		// check if all data array have the same size
		if ((count($this->columnsName) != count($this->columnsType)) ||
				(count($this->columnsName) != count($this->columnsValue))) {
					$this->errorNo = KT_COLUMNS_NOT_MATCH;
					$this->errorMsg = "Columns information not match!";
					return;
				}
		// check if we have a valid table with a valid uniqueKey
		if ((!$this->table) || (!$this->uniqueKey) || (!$this->uniqueKeyValue)) {
			$this->errorNo = KT_NO_PARAMS_UPDATE_SQL;
			$this->errorMsg = "Not enough parameters to generate update SQL!";
		}
		// begin the SQL generator
		$this->SQL = 'update ' . $this->table . ' set ';
		$KT_sp = false;
		//$keyQuote = (in_array($this->uniqueKeyType,$GLOBALS['KT_define_isQuoted'])) ? "'" : "";
		$keyQuote = $this->type2quote[$this->uniqueKeyType];
		$uniqueKeyMod = false;
		for ($idxCol = 0; $idxCol < count($this->columnsName); $idxCol++) {
			$includeField = true;
			// if the data Type is DATA format the value to serverFormat
			switch ($this->columnsType[$idxCol]) {
				case DATA_TYPE:
					$tmValue = $this->columnsValue[$idxCol];//KT_convertDate($this->columnsValue[$idxCol], $GLOBALS['KT_localFormat'], $GLOBALS['KT_serverFormat']);
				break;
				case CHECKBOX_YN_TYPE:
				case CHECKBOX_1_0_TYPE:
				case CHECKBOX_TF_TYPE:
				 $tmValue = (!isset($this->columnsValue[$idxCol])) ?  $this->type2empty[$this->columnsType[$idxCol]] 
																																						 : $this->type2alt[$this->columnsType[$idxCol]] ;
					break;
				case FILE_TYPE:
					$includeField = isset($this->columnsValue[$idxCol]) && (!empty($this->columnsValue[$idxCol]));
				default:
					$tmValue = $this->columnsValue[$idxCol];
			}
			if ($includeField) {
				// get the quote of the field
				//$quote = (in_array($this->columnsType[$idxCol],$GLOBALS['KT_define_isQuoted'])) ? "'" : "";
				$quote = $this->type2quote[$this->columnsType[$idxCol]];
				// if it's an empty value replace it with the default emptyVal (for those fields that emptyVal is NULL)
				if ((string)($tmValue) == "") {
					$tmValue = $this->type2empty[$this->columnsType[$idxCol]];
				} else {
					$tmValue = $quote . $tmValue . $quote;
				}
				// set the separator ',' (first time will be none)
				$sep = ($KT_sp) ? ',' : '';
				$KT_sp = true;
				// add the column to the SQL string
				$this->SQL = $this->SQL . $sep . $this->columnsName[$idxCol] . '=' . $tmValue;
				// if the uniqueKey is submited check if it's not empty and replace the new uniqueKey Value
				if (($this->columnsName[$idxCol] == $this->uniqueKey) &&
						($this->columnsValue[$idxCol] != $this->type2empty[$this->columnsType[$idxCol]]))
						{
							$uniqueKeyValue = substr($tmValue,strlen($quote),strlen($tmValue) - 2 * strlen($quote));
							$uniqueKeyMod = true;
						}
			}			
		}
		// add the where clause
		$this->SQL = $this->SQL . ' where ' . $this->uniqueKey . ' = ';
		$this->SQL = $this->SQL . $keyQuote . $this->uniqueKeyValue . $keyQuote;
		// set the uniqueKey Value if it has been modified
		if ($uniqueKeyMod) {
			$this->uniqueKeyValue = $uniqueKeyValue;
		}
	}
	
	/**
	generate Insert SQL
	**/
	function generateInsertSQL() {
		// check if all data array have the same size
		if ((count($this->columnsName) != count($this->columnsType)) ||
				(count($this->columnsName) != count($this->columnsValue))) {
					$this->errorNo = KT_COLUMNS_NOT_MATCH;
					$this->errorMsg = "Columns information not match!";
					return;
				}
		$this->SQL = 'insert into ' . $this->table;
		$tmColStr  = $tmValStr = '';
		$KT_sp = false;
		//generate the column and the value strings
		for ($idxCol = 0; $idxCol < count($this->columnsName); $idxCol++) {
			$sep = ($KT_sp) ? ',' : '';
			$KT_sp = true;
			// if the data Type is DATA format the value to serverFormat
			switch ($this->columnsType[$idxCol]) {
				case DATA_TYPE:
					$tmValue = $this->columnsValue[$idxCol]; //KT_convertDate($this->columnsValue[$idxCol], $GLOBALS['KT_localFormat'], $GLOBALS['KT_serverFormat']);
				break;
				case CHECKBOX_YN_TYPE:
				case CHECKBOX_1_0_TYPE:
				case CHECKBOX_TF_TYPE:
				 $tmValue = (isset($this->columnsValue[$idxCol])) ? $this->type2alt[$this->columnsType[$idxCol]] 
																																						: $this->type2empty[$this->columnsType[$idxCol]];
					break;
				default:
					$tmValue = $this->columnsValue[$idxCol];
			}
			// get the quote of the field
			$quote = $this->type2quote[$this->columnsType[$idxCol]];
			// if it's an empty value replace it with the default emptyVal (for those fields that emptyVal is NULL)
			if ($tmValue == '') {
				$tmValue = $this->type2empty[$this->columnsType[$idxCol]];
			} else {
				$tmValue = $quote . $tmValue . $quote;
			}
			//build the nameList and valueList
			$tmColStr = $tmColStr . $sep . $this->columnsName[$idxCol];
			$tmValStr = $tmValStr . $sep . $tmValue;
		}
		// build the final SQL
		$this->SQL = $this->SQL . ' (' . $tmColStr . ') values (' . $tmValStr . ')';
	}
	
	/*
	NAME:
	generateUniqueSelectSQL()
	DESCRIPTION:
	generate a select SQL from one table based on a unique key
	PARAMETERS:
	none
	RETURN:
	sets the SQL property
	*/
	function generateUniqueSelectSQL() {
		$keyQuote = $this->type2quote[$this->uniqueKeyType];
		$this->SQL = 'select * from ' . $this->table;
		$this->SQL = $this->SQL . ' where ' . $this->uniqueKey . ' = ';
		$this->SQL = $this->SQL . $keyQuote . $this->uniqueKeyValue . $keyQuote;
	}
	
	
	/*
		generateEmptyValues()
		does nothing ! It's here for backwards compatibility
	*/
	function generateEmptyValues() {
	}

}
?>
