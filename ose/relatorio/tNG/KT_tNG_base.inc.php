<?php
class KT_tNG_base {

	//	
	// properties
	//

	// the connection that will execute the transaction
	var $connection;	
	// the database name 
	var $databasename;
	// result of the transaction
	var $transactionResult;
	// Is set if an error occure during the transaction
	var $errorNo; // numeric
	// contains an error number
	var $errorMsg; // string
	// Contains some notices that may be generated during the transaction
	var $notice; // array

	// triggers
	// first dimension is the type of the trigger (after,before,error)
	// second dimension is an associative array with (key = triggerName,value = priority)
	var $triggers; 	// multidimensional associative array
	
	// the SQL 
	var $SQL; //string

	// Contains the recordId (last inserted Id if the transaction was an insert)
	var $recordId;

	// constructor 
	
	function KT_tNG_base() {
		// initialisation of all properties goes here
	}

	//
	//public methods
	//
	

	/**
	NAME:
	setConnection
	DESCRIPTION:
	set the connection object 
	PARAMETERS:
	&$i_connection = Object Reference (the connection object that will execute the transaction)
	RETURN:
	none
	**/
	function setConnection(&$i_connection, $i_databasename) {
		$this->connection = $i_connection;
		$this->databasename = $i_databasename;
	}
	
	/**
	NAME:
	getConnection
	DESCRIPTION:
	get the connection object
	PARAMETERS:
	none
	RETURNS:
	Object Reference (the connection object that will execute the transaction)
	**/
	function &getConnection() {
		return $this->connection;
	}

	/** 
	register a Trigger to this Transaction
	$i_triggerType = string ('after'|'before'|'error') - set the type of the trigger
	$i_triggerName = string (the name of the method)
	$i_priority = numeral (the priority order of the triggers) - it doesn't count if te trigger is of type 'error'
	returns true if succeded/ false otherwise
	**/
	function registerTrigger($i_triggerType,$i_triggerName,$i_priority) {
		// check if the trigger type is valid
		if (in_array($i_triggerType,array(STARTER,AFTER,BEFORE,ERROR))) {
			$params = array();
			if (func_num_args() > 3) {
				$params = array_slice(func_get_args(),3);
			}
			$this->triggers[$i_triggerType][$i_triggerName] = array($i_priority,$params);
			return true;
		} else {
			$this->errorNo = KT_UNKNOWN_TRIGGER_TYPE;
			$this->errorMsg = 'Unknown Trigger Type!';
			return false;
		}
	}

	/**
	FUNCTION:
	setSQL
	DESCRIPTION:
	set the SQL of a transaction
	This method will be used to make custom transactions
	PARAMETERS:
	$i_SQL - string - the SQL query that the transaction will execute
	RETURN:
	none
	**/
	function setSQL($i_SQL) {
		$this->SQL = $i_SQL;
	}
	
	
	/**
	FUNCTION:
	getSQL
	DESCRIPTION:
	Returns the SQL of the transaction
	PARAMETERS:
	none
	RETURN:
	string - the SQL query of the transaction
	**/
	function getSQL() {
		return $this->SQL;
	}

	/**
	NAME:
	prepareSQL
	DESCRIPTION:
	acctualy does nothing but may be overwriten by derived class to autogenerate the SQL
	PAREMETERS:
	none
	RETURN:
	none
	**/
	function prepareSQL() {
		//to be implemented in derived class
	}
	

	/**
	Execute the transaction 
	Before Executing the transaction it executes the BeforeTriggers and 
	after executing the transaction it executes the AfterTriggers
	**/
	function executeTransaction() {

		//calling the starter triggers and terminate execution if we had an error
		//we do not throw the errors triggers.
		$this->executeStarterTriggers();
		
		if (isset($this->errorNo) && $this->errorNo) {
			$this->errorNo = 0;
			return;
		}
		//calling the before triggers and terminate execution if we had an error
		$this->executeBeforeTriggers();
		if (isset($this->errorNo) && $this->errorNo) {
			$this->executeErrorTriggers();
			return;
		}
		//process the SQL for eventual auto-generation
		$this->prepareSQL();
		if (isset($this->errorNo) && $this->errorNo) {
			$this->executeErrorTriggers();
			return;
		}
		//executing the transaction
		if ($this->SQL) {
			mysql_select_db($this->databasename, $this->connection);
			if (!is_array($this->SQL)) {
				$this->transactionResult = mysql_query($this->SQL, $this->connection);
			} else {
				for ($i=0;$i<sizeof($this->SQL);$i++) {
					$this->transactionResult = mysql_query($this->SQL[$i], $this->connection);
					if (!$this->transactionResult) {
						break;
					}
				}
			}
			//check if the transaction has been done OK
			if (!$this->transactionResult) {
				$this->errorNo = KT_TRANSACTION_FAILED;
				$this->errorMsg = 'Transaction failed!<br>Your SQL: <br>' . $this->SQL . '<br>Error Msg: <br>' .mysql_error() . '<br>';
				$this->executeErrorTriggers();
				return;
			}
		}

		if (isset($this->type) && ($this->type == UNIQUE_SELECT_TYPE)) {
			if (mysql_num_rows($this->transactionResult) == 0) {
				$this->transactionResult = null;
			} else {
				$this->transactionResult = mysql_fetch_assoc($this->transactionResult);
			}
		}

		// Check if it was an insert statement and recover the table
		$matches = array();
		if (!is_array($this->SQL)){
			if (preg_match('/^\s*insert\s+into\s+(\w+)\s/i',$this->SQL,$matches)) {
				//get the insert ID 
				$this->recordId = mysql_insert_id();//$this->connection->Insert_ID(null,$matches[1]);
			}
		}
		
		//calling the after triggers
		$this->executeAfterTriggers();
		if (isset($this->errorNo) && $this->errorNo) {
			$this->executeErrorTriggers();
			return;
		}
	}

	/**
	NAME:
	getTransactionResult
	DESCRIPTION:
	gets the result of the transaction
	PARAMETERS:
	none
	RETURN:
	object - the result returned by the ADOConnection->Execute
	**/
	function getTransactionResult() {
		return $this->transactionResult;
	}
	
	/**
	NAME:
	setError
	DESCRIPTION:
	set the error status of the object
	PARAMETERS:
	$i_errorNo = numeric (indicate if an error occured)
	$i_errorMsg = string (Describes the error)
	RETURN:
	none
	**/
	function setError($i_errorNo,$i_errorMsg) {
		$this->errorNo = $i_errorNo;
		$this->errorMsg = $i_errorMsg;
	}
	
	/**
	NAME:
	getErrorNo
	DESCRIPTION:
	get the error status of the transaction
	PARAMETERS:
	none
	RETURN:
	integer - error number (0 means success)
	**/
	function getErrorNo() {
		if(isset($this->errorNo)){
		  return $this->errorNo;
		} else {
			return 0;
		}
	}
	
	/**
	NAME:
	getErrorMsg
	DESCRIPTION:
	get the error message
	PARAMETERS:
	none
	RETURN:
	string - error message ("" means success)
	**/
	function getErrorMsg() {
		if(isset($this->errorMsg)){
		  return $this->errorMsg;
		} else {
			return null;
		}
	}
	
	/**
	adds a notice to this transaction
	$i_notice = string (a text describing a notice)
	**/
	function addNotice($i_notice) {
		$this->notice[] = $i_notice; // adds the notice at the end of the array
	}
	
		
	/**
	get the notices that may be generated during the transaction
	**/
	function getNotices() {
		return $this->notice;		
	}

	/**
	NAME
	getRecordId
	DESCRIPTION:
	get the record ID (if the operation was an insert operation)
	PARAMETERS:
	none
	RETURN:
	integer - record id of -1 if it wasn't an insert transaction or
						the transaction failed
	**/
	function getRecordId() {
		if(isset($this->recordId)){
		  return $this->recordId;
		} else {
			return -1;
		}
	}


	//
	// private methods
	//

	/**
		executes all triggers after the main transaction 
	**/
	function executeAfterTriggers() {
		if (isset($this->triggers[AFTER]) && is_array($this->triggers[AFTER])) {
			uasort($this->triggers[AFTER],array('KT_tNG_base','compareTriggers'));
			foreach ($this->triggers[AFTER] as $triggerName=>$trigger) {
				$tempParam = array_reverse($trigger[1]);
				$tempParam[] = &$this;
				$tempParam = array_reverse($tempParam, true);
				//array_unshift($tempParam,&$this);
				
				call_user_func_array($triggerName,$tempParam);
				if (isset($this->errorNo) && $this->errorNo) {
					return;
				}
			}
		}
	}
	
	/**
		executes all triggers before the main transaction 
	**/
	function executeBeforeTriggers() {
		if (isset($this->triggers[BEFORE]) && is_array($this->triggers[BEFORE])) {
			uasort($this->triggers[BEFORE],array('KT_tNG_base','compareTriggers'));
			foreach ($this->triggers[BEFORE] as $triggerName=>$trigger) {
				$tempParam = array_reverse($trigger[1]);
				$tempParam[] = &$this;
				$tempParam = array_reverse($tempParam, true);
				//array_unshift($tempParam,&$this);
				call_user_func_array($triggerName,$tempParam);
				if (isset($this->errorNo) && $this->errorNo) {
					return;
				}
			}
		}
	}


	/**
		executes all starter triggers (this triggers are executed before the transaction). They
		are separated from BEFORE triggers because when they fail the transaction is invalidate without
		throwing error
	**/
	function executeStarterTriggers() {
		if (isset($this->triggers[STARTER]) && is_array($this->triggers[STARTER])) {
			uasort($this->triggers[STARTER],array('KT_tNG_base','compareTriggers'));
			foreach ($this->triggers[STARTER] as $triggerName=>$trigger) {
				$tempParam = array_reverse($trigger[1]);
				$tempParam[] = &$this;
				$tempParam = array_reverse($tempParam, true);
				//array_unshift($tempParam,&$this);
				call_user_func_array($triggerName,$tempParam);
			}
		}
	}



	/**
		executes all error triggers . This triggers are executed if the transaction fails
	**/
	function executeErrorTriggers() {
		if (isset($this->triggers[ERROR]) && is_array($this->triggers[ERROR])) {
			uasort($this->triggers[ERROR],array('KT_tNG_base','compareTriggers'));
			foreach ($this->triggers[ERROR] as $triggerName=>$trigger) {
				$tempParam = array_reverse($trigger[1]);
				$tempParam[] = &$this;
				$tempParam = array_reverse($tempParam, true);
				//array_unshift($tempParam,&$this);
				call_user_func_array($triggerName,$tempParam);
			}
		}
	}

	/** 
	standard error trigger
	**/
	function standardError() {
		// if it's defined an error trigger call it 
		if (isset($this->triggers[ERROR]) && is_array($this->triggers[ERROR])) {
			foreach ($this->triggers[ERROR] as $triggerName=>$value) {
				$triggerName($this);
			}
			
		} else { //if not do the default action
			echo '<p class=\"error\">The following error has occured: '.$this->errorMsg.'</p>';
		}	
	}
	
	/**
	compare two trigger objects (by their priority)
	**/
	function compareTriggers($a , $b) {
    if ($a[0] == $b[0]) return 0;
    return ($a[0] < $b[0]) ? -1 : 1;
	}
}

?>
