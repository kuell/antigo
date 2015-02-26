<?php

//include the common declarations
require_once(CONN_DIR.'/../includes/nextensio2/KT_back.php');

//include the tNG defines
require_once(CONN_DIR.'/../tNG/KT_tNG_defines.inc.php');



//Nextensio List Class
class NxtList {

	//list type (SINGLE,DETAIL,MASTER)
	var $listType; //string
	//this list name (is used to uniquely identify global variables that belongs to this List)
	var $listName; //string
	//column properties
	var $columns; //associtive array
	//table prefix
	var $tPrefix; //associative array
	//sql WHERE condition
	var $whereCondition; //string
	//sql orderBy
	var $orderBy; //string
	//the default list filter
	var $auxWhereCondition;
	
	
	//ordered list
	var $orderCol;
	
	var $table;
	var $primaryKey;
	var $connection;

	//constructor
	function NxtList($listName) {
		$this->columns = array();
		$this->tPrefix = array();
		$this->listName = $listName;
	
		//correspondence between a datatype and the quote
		$this->type2quote = array(NUMERIC_TYPE => '' , DATA_TYPE => '\'' , 
															STRING_TYPE=>'\'',  DATE_ACCESS_TYPE=>'#', 
															FILE_TYPE=>'\'',
															CHECKBOX_TF_TYPE=>'\'',
															CHECKBOX_YN_TYPE=>'\'',
															CHECKBOX_1_0_TYPE=>''
															);
		// initialisation of all properties goes here
		$this->type2empty = array(CHECKBOX_YN_TYPE=>'N', CHECKBOX_1_0_TYPE=>'0', CHECKBOX_TF_TYPE=>'f');
		
		//correspondence between a datatype and the default tru value (especially for checkboxes)
		$this->type2alt = array(CHECKBOX_TF_TYPE=>'t', CHECKBOX_YN_TYPE=>'Y', CHECKBOX_1_0_TYPE=>'1');
		//valid relations
		$this->validRelation = array('<','<=','=','>=','>','!=','');
	}
	
	/*
	NAME:
	addColumn()
	DESCRIPTION:
		add a column to the list
	*/
	function addColumn($columnName, $columnType) {
		$tm = explode('.',$columnName);
		if (count($tm) == 2) {
			$this->columns[$tm[1]] = $columnType;
			$this->tPrefix[$tm[1]] = $tm[0];
		} else {
		$this->columns[$columnName] = $columnType;
	}
	}

	/*
	NAME:
	setTable()
	DESCRIPTION:
		setter for $table property
	*/
	function setTable($table) {
		$this->table = $table;
	}

	/*
	NAME:
	setPrimaryKey()
	DESCRIPTION:
		setter for $primaryKey property
	*/
	function setPrimaryKey($primaryKey) {
		$this->primaryKey = $primaryKey;
	}

	/*
	NAME:
	setConnection()
	DESCRIPTION:
		setter for $connection property
	*/
	function setConnection(&$connection, $databasename) {
		$this->connection = $connection;
		$this->databasename = $databasename;
	}

	/*
	NAME:
	setListName()
	DESCRIPTION:
		setter for $listName property
	*/
	function setListName($listName) {
		$this->listName = $listName;
	}

	/*
	NAME:
	setOrderCol()
	DESCRIPTION:
		setter for $orderCol property
	*/
	function setOrderCol($orderCol) {
		$this->orderCol = $orderCol;
	}

	/*
	NAME:
	setListType()
	DESCRIPTION:
		setter for $listType property
	*/
	function setListType($listType) {
		$this->listType = $listType;
	}

	/*
	NAME:
	setDefaultFilter()
	DESCRIPTION:
		sets the default filter
	*/
	function setDefaultFilter($filter) {
		$this->auxWhereCondition = $filter;
	}
	
	/*
	NAME:
	setDefaultOrder()
	DESCRIPTION:
		sets the default list order
	*/
	function setDefaultOrder($orderString) {
		$this->orderBy = $orderString;
	}
	
	/*
	NAME:
	computeAll()
	DESCRIPTION:
		Generates all the output variables (where condition, sort orders, URL parameter etc)
	
	PARAMETERS:
	- none
	RETURN:
	- none
	*/
	function computeAll() {
		global $_POST, $_SESSION, $_SERVER;
		$listName = $this->listName;
		$_F = $listName . "_F";
		$_S = $listName . "_S";
		$_W = $listName . "_W";

		$this->checkOrder();

		// if we have post variables
		if (isset($_POST) && sizeof($_POST) > 0) {

			// if the user pushed the "Filter" button
			if (isset($_POST[$_F])) {
				session_unregister($_W);
				if (!isset($_SESSION[$_F])) {
					$_SESSION[$_F] = array();
				}
				
				$this->processSubmitFilter($_POST[$_F],$_F);


				//redirect to the request uri deleting the totalRows and pageNum parameters
				$tmp = $_SERVER['PHP_SELF'].'?'.@$_SERVER['QUERY_STRING'];
				$tmp = KT_removeParam($tmp, "totalRows_.*?");
				$tmp = KT_removeParam($tmp, "pageNum_.*?");
				KT_redir($tmp);
			}

			// if the user clicked on a colums (sort)
			if (isset($_POST[$_S]) && isset($this->columns[$_POST[$_S]])) {
				if (!isset($_SESSION[$_S])) {
					$_SESSION[$_S] = '';
				}

				$$_S = &$_SESSION[$_S];

				// reverse the sort direction if the user clicked on the column twice
				$tmp  = preg_replace("/ .*$/", "", $$_S);
				if ($tmp == $_POST[$_S]) {
					if (preg_match("/ ASC$/", $$_S)) {
						$$_S = $_POST[$_S] . " DESC";
					} else {
						$$_S = $_POST[$_S] . " ASC";
					}
				} else {
					$$_S = $_POST[$_S] . " ASC";
				}

				//register the sort
				session_register($_S);

				//redirect to the request uri
				$tmp = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
				KT_redir($tmp);
			}
		}

		// if we have the where condition saved in the session, then take it from there.
		if (isset($_SESSION[$_W])) {
			$this->whereCondition = $_SESSION[$_W];
		} else {
			if (isset($_SESSION[$_F])) {
				while (list($key, $value) = each($_SESSION[$_F])) {
					if (isset($value)) {
						if (isset($whereCondition)) {
							$whereCondition .= " AND";
						} else {
							$whereCondition = "";
						}
						$whereCondition .= $this->buildCondition($key,trim($value));
					}
				}
				if (isset($whereCondition)) {
					$$_W = $whereCondition;
					session_register($_W);
					$this->whereCondition = $$_W;
				}
			}
		}

		if (isset($_SESSION[$_S])) {
			$this->orderBy = $_SESSION[$_S];
		} else {
			$_SESSION[$_S] = $this->orderBy;
		}
	}

	/*
	NAME:
		checkOrder
	DESCRIPTION:
		check if the order it's about to modify
	
	PARAMETERS:
		none
	RETURN:
	- none
	*/
	function checkOrder() {
		global $_GET,$_SERVER;
		$_U = $this->listName . "_U";
		$_D = $this->listName . "_D";
		
		if ((isset($_GET[$_D])) && (isset($_GET[$_U]))) {
			if ($_GET[$_D] == -1) {
				$KT_dir = "<";
				$KT_orderDir = "DESC";
			} else {
				$KT_dir = ">";
				$KT_orderDir = "ASC";
			}
		
			$KT_table = $this->table;
			$KT_pk = $this->primaryKey;
			$KT_order = $this->orderCol;
			
			if ($this->auxWhereCondition) {
				$KT_other = $this->auxWhereCondition . " AND";
			} else {
				$KT_other = '';
			}
		
			$KT_sql = "select max($KT_order) as maxorder from $KT_table";
			mysql_select_db($this->databasename, $this->connection); 
			$KT_rs = mysql_query($KT_sql, $this->connection) or die (mysql_error());
			$rows_KT_rs = mysql_fetch_assoc($KT_rs);
			if ($KT_rs && mysql_num_rows($KT_rs) > 0) { // && !$KT_rs->EOF
				$KT_maxOrder = $rows_KT_rs['maxorder'] + 1;
			} else {
				$KT_maxOrder = 1;
			}
		
			$KT_sql = "select $KT_order from $KT_table where $KT_pk=" . $_GET[$_U];
			mysql_select_db($this->databasename, $this->connection);
			$KT_rs = mysql_query($KT_sql, $this->connection) or die (mysql_error());
			$rows_KT_rs = mysql_fetch_assoc($KT_rs);
			if ($KT_rs && mysql_num_rows($KT_rs) > 0) {
				$KT_sql = "select $KT_pk, $KT_order from $KT_table where $KT_other $KT_order $KT_dir " . $rows_KT_rs[$KT_order] . " ORDER BY $KT_order $KT_orderDir"." LIMIT 1";
				mysql_select_db($this->databasename, $this->connection);
				$KT_rs1 = mysql_query($KT_sql, $this->connection) or die (mysql_error());
				$rows_KT_rs1 = mysql_fetch_assoc($KT_rs1);
				
				if ($KT_rs1 && mysql_num_rows($KT_rs1) > 0) {
					//update main record with temporary value
					$KT_sql = "update $KT_table set $KT_order=$KT_maxOrder where $KT_pk=" . $_GET[$_U];
					mysql_select_db($this->databasename, $this->connection);
					mysql_query($KT_sql, $this->connection) or die (mysql_error());
					
					//update other record
					$KT_sql = "update $KT_table set $KT_order=" . $rows_KT_rs[$KT_order] . " where $KT_pk=" . $rows_KT_rs1[$KT_pk];
					mysql_select_db($this->databasename, $this->connection);
					mysql_query($KT_sql, $this->connection) or die (mysql_error());

					
					//update main record
					$KT_sql = "update $KT_table set $KT_order=" . $rows_KT_rs1[$KT_order] . " where $KT_pk=" . $_GET[$_U];
					mysql_select_db($this->databasename, $this->connection);
					mysql_query($KT_sql, $this->connection) or die (mysql_error());
				}
			}
		
			$redirLoc = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			$redirLoc = addReplaceParam($redirLoc, $_U);
			$redirLoc = addReplaceParam($redirLoc, $_D);
			KT_redir($redirLoc);
		}
	}

	/*
	NAME:
		processSubmitFilter()
	DESCRIPTION:
		process the submited filter information and validate the submited values
	
	PARAMETERS:
		$post - the posted filter 
		$_F - the name of the filter (session variable)
	RETURN:
	- none
	*/
	function processSubmitFilter($post,$_F) {
		global $_SESSION;
	
		$$_F = &$_SESSION[$_F];
		
		// for each posted variable, check if it is the form columns and save it in the session
		while (list($key, $type) = each($this->columns)) {
			//echo $key . ' ' . $type . ' ' . $post[$key] .'<br>';
			${$_F}[$key] = $this->getFilter($key, $type, @$post[$key]);
		}

		//register the filter
		session_register($_F);
	}
	

	/*
	NAME:
		getFilter()
	DESCRIPTION:
		get the filter object for every field
	
	PARAMETERS:
		$key - the column name 
		$rawValue - the submited value for this column
	RETURN:
	- filter object
	*/
	function getFilter($key, $type ,$rawValue) {
	
		if (get_magic_quotes_gpc()) {
			$value = $rawValue;
		} else {
			$value = addslashes($rawValue);
		}
		
		switch ($type) {
			case CHECKBOX_YN_TYPE:
			case CHECKBOX_TF_TYPE:
			case CHECKBOX_1_0_TYPE:
				return (!isset($value)) ?  $this->type2empty[$type] : $this->type2alt[$type] ;
			break;
			case NUMERIC_TYPE:
				$match = array();
				if (preg_match("/([<>=!]{0,2})\s*-?\d+\.?\d*/",$value,$match)) {
					if (in_array($match[1],$this->validRelation)) {
						return $value;
					}
				} else {
					return null;
				}
				return null;
			break;
			case STRING_TYPE:
				if (strlen($value)) {
					return $value;
				} else {
					return null;
				}
			break;
			case DATA_TYPE:
				$match = array();
				if (preg_match("/([<>=!]{0,2})[0-9]+(\\-|\\/)[0-9]+(\\-|\\/)[0-9]+/",$value,$match)) {
					if (in_array($match[1],$this->validRelation)) {
						return $value;
					}
				} else {
					return null;
				}
				return null;
			break;
		}
	}

	/*
	NAME:
		buildCondition()
	DESCRIPTION:
		build the where condition for a given field
	
	PARAMETERS:
		$key - the column name 
		$value - the submited value for this column
	RETURN:
	- string - the where condition
	*/
	function buildCondition($key, $value) {
		$quote = $this->type2quote[$this->columns[$key]];
		//$myKey = $this->table . '.' . $key;
		$myKey = $key;
		if (isset($this->tPrefix[$key])) {
			$myKey = $this->tPrefix[$key] . '.' . $myKey;
		}
		switch ($this->columns[$key]) {
			case NUMERIC_TYPE:
				$match = array();
				preg_match("/([<>=!]{0,2})\s*(-?\d+\.?\d*)/",$value,$match);
				$newVal = array();
				$newVal['number'] = $match[2];
				if ($match[1]) {
					$newVal['relation'] = $match[1];
				} else {
					$newVal['relation'] = '=';
				}
				return ' ' . $myKey . $newVal['relation'] . $newVal['number'] . ' ';
			break;
			case STRING_TYPE:
				$temp = stripslashes($value);
				$temp = str_replace('\\','\\\\\\\\',$temp);
				$temp = str_replace('%', '\%', $temp);
				$temp = str_replace('\'','\\\'',$temp);
				return ' ' . $myKey . ' LIKE \'%' . $temp . '%\' ';
			break;
			case CHECKBOX_YN_TYPE:
			case CHECKBOX_TF_TYPE:
				return ' ' . $myKey . ' = \'' . $value . '\' ';
			break;
			case CHECKBOX_1_0_TYPE:
				return ' ' . $myKey . ' = ' . $value . ' ';
			break;
			case DATA_TYPE:
				$match = array();
				preg_match("/([<>=!]{0,2})([0-9]+(\\-|\\/)[0-9]+(\\-|\\/)[0-9]+)/",$value,$match);
				$newVal = array();
				$newVal['date'] = $match[2];
				if ($match[1]) {
					$newVal['relation'] = $match[1];
				} else {
					$newVal['relation'] = '=';
				}
				return ' ' . $myKey . $newVal['relation'] . '\'' . KT_convertDate($newVal['date'], $GLOBALS['KT_localFormat'], $GLOBALS['KT_serverFormat']) . '\' ';
			break;

		}
		
	}

	/*
	NAME:
	getSortDirIcon()
	DESCRIPTION:
		returns the small icon (character) that indicates the sort direction for the chosen column
	
	PARAMETERS:
		$column - string - the column to generate the HREF for
	RETURN:
	- string - charecter icon
	*/
	function getSortDirIcon($column) {
		if (isset($this->orderBy)) {
			if ($this->orderBy == "$column DESC") {
				echo "^";
			}
			if ($this->orderBy == "$column ASC") {
				echo "v";
			}
		}
	}

	/*
	 * NAME:
	 *   getWhereCondition()
	 * DESCRIPTION:
	 *   gets the where condition, computed by the computeAll function
	 * PARAMETERS:
	 *   none
	 * RETURNS:
	 *   null if there is no condition, or the condition string
	 */
	function getWhereCondition() {
		if (isset($this->whereCondition)) {
			if (isset($this->auxWhereCondition) && $this->auxWhereCondition != "") {
				return $this->auxWhereCondition . " AND " . $this->whereCondition;
			} else {
				return $this->whereCondition;
			}
		} else {
			if (isset($this->auxWhereCondition) && $this->auxWhereCondition != "") {
				return $this->auxWhereCondition;
			} else {
				return null;
			}
		}
	}

	/*
	 * NAME:
	 *   getOrderBy()
	 * DESCRIPTION:
	 *   gets the order by statement, computed by the computeAll function
	 * PARAMETERS:
	 *   none
	 * RETURNS:
	 *   null if there is no order by, or the starement string
	 */
	function getOrderBy() {
		if ($this->orderCol) { 
			$order = $this->orderCol . ($this->orderBy ? ",".$this->orderBy : "");
		} else {
			$order = $this->orderBy;
		}
		return $order;
	}
	
}
/*
NAME:
	htmsubstr
DESCRIPTION:
	htmlentities + substr
PARAMETERS:
	
RETURNS:
	String - the substring
*/

function htmsubstr($text,$start,$count) {
	return htmlentities(substr($text,$start,$count));
}

?>
