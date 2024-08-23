<?php 
class SqlManager {
    private $connection;
    private $mQueryLogPath;  // QUERY LOG DIRECTORY PATH

	public static $msDBcon;
	public static $msAesKey;
	private $mOrderFlds 		 = array();
	private $mGroupFlds			 = array();
	private $mDateFields		 = array();
    private $mLimit			 	 = array();
	private $mUseIndex 		 	 = array();

    private $mTableNameWithAlias = array();
    private $mFldConds 			 = array();
    private $mFieldNames 		 = array();
	public static $msEncryptFlds = array();
	private $mInsrtFields	 	 = array();
	
	private $mTableNames 		 = array();
	private $mTableColumns 		 = array();
	
	private $mIgnoreIndex 		 = array();
	
	private static $mTblColumnInfo		 = array(); 
    public function __construct() {
        //include 'config.php';

		$this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
       // echo $this->connection ;
	  // echo 'connected';
        self::$msDBcon = $this->connection;
    }
    public function AddFlds($FldArr) {
		if ($FldArr == "*")
			$this->mFieldNames = array("*");
		else
			$this->mFieldNames = $FldArr;
	}
    public function AddFldCond($FldName, $FldValue, $Condition = "=", $Operator = "AND", $GroupStart = "", $GroupEnd = "") {
		$this->mFldConds[] = array("fld_name" => $FldName, "fld_value" => $FldValue, "condition" => $Condition, "operator" => $Operator, "group_start" => $GroupStart, "group_end" => $GroupEnd, "is_field" => false);
	}
    public function AddTbls($TblName) {
		if (is_array($TblName)) 
			$this->mTableNames = array_merge($this->mTableNames, $TblName);
		else 
			$this->mTableNames[] = $TblName;
	}
    public function AddTblCond($FldName, $FldValue, $Condition = "=", $Operator = "AND", $GroupStart = "", $GroupEnd = "") {
		$this->mFldConds[] = array("fld_name" => $FldName, "fld_value" => $FldValue, "condition" => $Condition, "operator" => $Operator, "group_start" => $GroupStart, "group_end" => $GroupEnd, "is_field" => true);
	}
    public function AddInsrtFlds($Fields) {
		$this->mInsrtFields = $Fields;
	}
    public function InsertSingle(){
		$TableName 		= $this->mTableNames[0];
		$InsertFields 	= $this->GetDataChangeQueryOptions();
		$FieldStr 		= implode(", ", $InsertFields['fields']);
		$ValueStr 		= implode(", ", $InsertFields['values']);
		$Sql 			= "INSERT INTO ".$TableName." (".$FieldStr.") VALUES (".$ValueStr.");";
		$Result 		= $this->ExecQuery($Sql);
		if ($Result)
			return mysqli_insert_id(self::$msDBcon);
		else
			return "E";
	}
    public function InsertMultiple() {
		$TableName 		= $this->mTableNames[0];
		$InsertFields 	= $this->GetMultipleDataChangeQueryOptions();
		$FieldStr 		= implode(", ", $InsertFields['fields']);
		$ValueStr 		= implode(", ", $InsertFields['valueset']);
		$Sql 			= "INSERT INTO ".$TableName."(".$FieldStr.") VALUES ".$ValueStr.";";
		$Result 		= $this->ExecQuery($Sql);
		
		if ($Result)
			return mysqli_insert_id(self::$msDBcon);
		else
			return "E";
	}
	
    private function GetDataChangeQueryOptions() {
		$FieldNames 			= $FieldValues = array();
		$this->mTableColumns 	= $this->GetTableColumns();
		foreach ($this->mInsrtFields as $FieldName => $FieldValue) {
			if (!in_array($FieldName, $this->mTableColumns[0])) continue;
			
			$FieldNames[] = $FieldName;
			/*if (isset($this->mTableColumns[1][$FieldName]))
				$FieldValue = $this->GetDBformatDate($this->mTableColumns[1][$FieldName], $FieldValue);*/
			
			$FieldValues[] = $this->EncryptFieldValue($this->mTableNames[0], $FieldName, $FieldValue);
		}
		return array("fields" => $FieldNames, "values" => $FieldValues);
	}
    private function EncryptFieldValue($TableName, $FieldName, $FielValue) {
		if (is_string($FielValue)) {
			/*$FielValue = addslashes($FielValue);
			if ($this->IsEncryptField($TableName, $FieldName))
				$FielValue = "AES_ENCRYPT('".$FielValue."', '".self::$msAesKey."') ";
			else*/
				$FielValue = "'".addslashes($FielValue)."'";
		} else {
			
		}		
		return $FielValue;
	}
    private function GetTableColumns() {
		if (!isset(self::$mTblColumnInfo[$this->mTableNames[0]])) {
			$Fields = $DateFields = array();
			$Sql = "SHOW COLUMNS FROM `".$this->mTableNames[0]."` FROM `".'Inbestments'."`";
			$Res = $this->GetQuery($Sql);
			
			foreach ($Res as $Item) {
				$Fields[] = $Item['Field'];
				if (in_array($Item['Type'], array('date', 'datetime', 'timestamp', 'time', 'year')))
					$DateFields[$Item['Field']] = $Item['Type'];
			}
			
			self::$mTblColumnInfo[$this->mTableNames[0]] = array($Fields, $DateFields);
		}
		return self::$mTblColumnInfo[$this->mTableNames[0]];
	}
    public function GetQuery($Sql, $ReturnAssoc = true) {
		$ResArr = array();
		$Result = $this->ExecQuery($Sql);
		while ($Row = mysqli_fetch_array($Result, $ReturnAssoc ? MYSQLI_ASSOC : MYSQLI_NUM)) {
			foreach ($Row as $Key => $Data) 
				$Row[$Key] = stripslashes($Data);
			$ResArr[] = $Row;
		}
		mysqli_free_result($Result);
		return $ResArr;
	}
    private function GetMultipleDataChangeQueryOptions(){
		$FieldNames 			= $FieldValues = $FieldValueSet = array();
		$this->mTableColumns 	= $this->GetTableColumns();
		$Columns 				= array_keys($this->mInsrtFields[0]);
		
		foreach ($Columns as $Column) {
			if (!in_array($Column, $this->mTableColumns[0])) continue;
			$FieldNames[] = $Column;
		}
		
		foreach ($this->mInsrtFields as $Key => $FieldSet) {
			$FieldValues = array();
			foreach ($FieldNames as $FieldName) {
				//if (isset($this->mTableColumns[1][$FieldName]))
				//$FieldSet[$FieldName]	= $this->GetDBformatDate($this->mTableColumns[1][$FieldName], $FieldSet[$FieldName]);
				$FieldValues[] 			= $this->EncryptFieldValue($this->mTableNames[0], $FieldName, $FieldSet[$FieldName]);
			}
			$FieldValueSet[] = "(".implode(", ", $FieldValues).")";
		}
		return array("fields" => $FieldNames, "valueset" => $FieldValueSet);
	}
	/*
    public function ExecQuery($Sql) {
		
		$Sql = $this->RemoveMultiSpace(trim($Sql));
		//echo self::$msDBcon;
		$Result =  mysqli_query(self::$msDBcon, $Sql);
		if (QUERY_LOG) {
			$fp = fopen($this->mQueryLogPath.date('Ymd_')."query.txt", 'a+');
			fwrite($fp, "\n".$Sql);
			fclose($fp);
		}
		if (!$Result) {
			$err_str = $Sql."|||ERROR :".mysqli_error(self::$msDBcon)."\n";
			$fp = fopen($this->mQueryLogPath.date('Ymd')."_ERROR.txt", 'a+');
			fwrite($fp, $err_str);
			fclose($fp);
		}
		return $Result;
	}*/
	public function ExecQuery($Sql) {
        $Sql = $this->RemoveMultiSpace(trim($Sql));
       // echo "SQL";
       // var_dump($Sql);
        //$Sql = "SHOW COLUMNS FROM `insights_cron_function_status` FROM `Inbestments`";
        $Result =  mysqli_query(self::$msDBcon, $Sql);
        //$Sql = "SHOW COLUMNS FROM `insights_cron_function_status` FROM `Inbestments`";
        
       //echo "RESULT";
       // var_dump($Result);
        if (!$Result) {
            $err_str = $Sql . "|||ERROR :" . mysqli_error(self::$msDBcon) . "\n";
            $fp = fopen($this->mQueryLogPath . date('Ymd') . "_ERROR.txt", 'a+');
            fwrite($fp, $err_str);
            fclose($fp);
        }
        
        return $Result;
    }
	
    private function RemoveMultiSpace($Str) {
		return trim(preg_replace('/\s+/', ' ',trim($Str))); // Replacing multiple spaces with a single space
	}
	public function GetSingle() {
		$ResArr 	= $this->GetQuery($this->GetSingleQuery());
		if (count( $ResArr ))
			return $ResArr[0];
		return $ResArr;
	}
	public function GetSingleQuery() {
		$this->TableNamesWithAlias();
		$QueryOpns 	= $this->GetSelectQueryOptions();
		$Index = $this->GetIndex();
		return "SELECT {$QueryOpns['fields']} FROM {$QueryOpns['table']} {$Index} {$QueryOpns['condition']} {$QueryOpns['groupby']} {$QueryOpns['orderby']} LIMIT 0, 1";
	}
	public function TableNamesWithAlias() {
		foreach ($this->mTableNames as $TableName) {
			$TableName 	= $this->RemoveMultiSpace($TableName);
			$TableAlias = $TableName;
			$TableArr 	= explode(" ", $TableName);
			if (count($TableArr) == 2)
				$this->mTableNameWithAlias[$TableArr[1]] = $TableArr[0];
			else 
				$this->mTableNameWithAlias[] = $TableName;
		} 
	}
	private function GetIndex() {
		$Index = "";
		if (count($this->mUseIndex))
			$Index .= "USE INDEX (".implode(',', $this->mUseIndex).") ";
		if (count($this->mIgnoreIndex))
			$Index .= "IGNORE INDEX (".implode(',', $this->mIgnoreIndex).")";
		return $Index;
	}
	/*
    public function GetMultiple() {
		$ResArr = $this->GetQuery($this->GetMultipleQuery());
		return $ResArr;
	}
	
    public function GetMultipleQuery() {
		$this->TableNamesWithAlias();
		$QueryOpns 	= $this->GetSelectQueryOptions();
		$Limit 		= "";
		if (count($this->mLimit))
			$Limit = "LIMIT {$this->mLimit['start_index']}, {$this->mLimit['limit']}";
		$Index = $this->GetIndex();
		return "SELECT {$QueryOpns['fields']} FROM {$QueryOpns['table']} {$Index} {$QueryOpns['condition']} {$QueryOpns['groupby']} {$QueryOpns['orderby']} {$Limit}";
	}
	*/	

    
	
    private function GetSelectQueryOptions() {
		$TableNames = $this->mTableNames;
		//$this->mTableNames = $this->GetTableNames();
		
		if (count($this->mFieldNames) == 1) {
			if ($this->mFieldNames[0] == "*") {
				$ResFields = $this->GetTableColumns();
				$this->mFieldNames 	= $ResFields[0];
				$this->mDateFields 	= $ResFields[1];
			}
		}
		$FieldStr 	= $this->GetFieldStr();
		$CondStr 	= $this->GetConditionStr();
		$GroupStr 	= $this->GetGroupByStr();
		$OrderStr 	= $this->GetOrderByStr();
		$Table 		= implode(", ", $TableNames);
		return array("table" => $Table, "fields" => $FieldStr, "condition" => $CondStr, "groupby" => $GroupStr, "orderby" => $OrderStr);
	}
	private function GetFieldStr() {
		$FieldStr = "";
		if (count($this->mFieldNames)) {
			foreach ($this->mFieldNames as  $Key => $FieldName){
				$this->mFieldNames[$Key] = $FieldName = $this->RemoveMultiSpace($FieldName);
				if (strpos($FieldName, "#") !== false)
					$FieldName = $this->SqlfuncField($FieldName);
			 	else
					$FieldName = $this->DecryptField($FieldName, true);
				$FieldNames[$Key] = $FieldName;
			}
		}
		return implode(", ", $FieldNames);
	}
	private function SqlfuncField($FieldName) {
		$FieldName = $this->RemoveMultiSpace($FieldName);
		while (strpos($FieldName, "#") !== false) {
			$Pos1 			= strpos($FieldName, "#");
			$FieldName 		= substr_replace($FieldName, "|", $Pos1, 1);
			$Pos2 			= strpos($FieldName, "#");
			$FieldName 		= substr_replace($FieldName, "|", $Pos2, 1);
			$StrLen 		= $Pos2 - $Pos1;
			$SubFieldStr 	= substr($FieldName, $Pos1, $StrLen + 1);
			$SubField 		= str_replace("|", "", $SubFieldStr);
			
			$SubField2 		= $this->DecryptField($SubField);
			$FieldName 		= str_replace($SubField, $SubField2, $FieldName);
		}
		$FieldName = str_replace("|", "", $FieldName);
		return trim($FieldName);
	}
	private function DecryptField($FieldName, $IsAlias = false) {
		$ColumnName = $FieldName;
		$FieldInfo  = $this->GetColumnInfo($FieldName);
		if ($this->IsEncryptField($FieldInfo['tbl_name'], $FieldInfo['tbl_col_name'])) {
			$ColumnName = "AES_DECRYPT(".$FieldInfo['col_name'].", '".self::$msAesKey."') ";
			if ($FieldInfo['col_alias'] != "")
				$ColumnName .= $FieldInfo['col_alias'];
			else if($IsAlias)
				$ColumnName .= $FieldInfo['tbl_col_name'];
		}
		return trim($ColumnName);
	}
	private function IsEncryptField($TableName, $FieldName) {
		//echo "<br /> Table: ".$TableName."  -  Column Name: ".$FieldName;
		if (isset(self::$msEncryptFlds[$TableName])) {
			if (in_array($FieldName, self::$msEncryptFlds[$TableName])) {
				//echo "<br /> Table: ".$TableName."  -  Column Name: ".$FieldName;
				return true;
			}
		}
		return false;
	}
	private function GetColumnInfo($FieldName) {
		$FieldInfo = array();
		$ColumnAlias = $TableAlias = "";
		$ColumnName  = $FieldName;
		
		$FieldNameArr = explode(" ", $FieldName);
		if (count($FieldNameArr) > 1) {
			$ColumnAlias =  $FieldNameArr[1];
			$ColumnName  = $FieldName = $FieldNameArr[0];
		}
		$TableColumnName = $ColumnName;
		
		$FieldNameArr = explode(".", $FieldName);
		if (count($FieldNameArr) > 1) {
			$TableAlias  	 = $FieldNameArr[0];
			$TableColumnName = $FieldNameArr[1];
		}
		
		if (count($this->mTableNames) > 1 ) {
			if (count($FieldNameArr) > 1) 
				$TableName  = $this->mTableNameWithAlias[$TableAlias];
			else
				$TableName  = "";
		} else {
			/*if (!isset($this->mTableNameWithAlias[0]))
				print_r(reset($this->mTableNameWithAlias));*/
			$TableName = reset($this->mTableNameWithAlias);
		}		
		
		$FieldInfo["col_alias"] 	= $ColumnAlias; 
		$FieldInfo["col_name"] 		= $ColumnName; 
		$FieldInfo["tbl_alais"] 	= $TableAlias;
		$FieldInfo["tbl_col_name"] 	= $TableColumnName; 
		$FieldInfo["tbl_name"] 		= $TableName;
		
		return $FieldInfo;
	}
	private function GetConditionStr() {
		$CondStr = "";
		if (count($this->mFldConds)) {
			$CondStr .= " WHERE ";
			foreach ($this->mFldConds as  $Key => $FldCond) {
				if (strpos($FldCond['fld_name'], "#") !== false)
					$FldCond['fld_name'] = $this->SqlfuncField($FldCond['fld_name']);
			 	else
					$FldCond['fld_name'] =  $this->DecryptField($FldCond['fld_name']);
				$this->mFldConds[$Key] = $FldCond;
				
				if ($Key == 0)
					$FldCond['operator'] = "";
				
				$CondStr .= $FldCond['operator']." ".$FldCond['group_start']." (".$this->__GetGroupByStr($FldCond).") ".$FldCond['group_end']." ";
			}
		}
		return $CondStr;
	}
	private function __GetGroupByStr($FldCond) {
		$CondStr = '';
		if ($FldCond['condition'] != 'IN' && $FldCond['condition'] != 'NOT IN') {
			if ($FldCond['is_field'])
				$CondStr = $FldCond['fld_name']." ".$FldCond['condition']." ".$FldCond['fld_value'];
			else 
				$CondStr = $FldCond['fld_name']." ".$FldCond['condition']." '".$FldCond['fld_value']."'";
		} else {
			if (!$FldCond['is_field']) {
				if (is_array($FldCond['fld_value']))
					$CondStr = $FldCond['fld_name']." ".$FldCond['condition']." ('".implode("','", $FldCond['fld_value'])."')";
				else
					$CondStr = $FldCond['fld_name']." ".$FldCond['condition']." ('".$FldCond['fld_value']."')";
			} else {
				if (is_array($FldCond['fld_value']))
					$CondStr = $FldCond['fld_name']." ".$FldCond['condition']." (".implode(",", $FldCond['fld_value']).")";
				else	
					$CondStr = $FldCond['fld_name']." ".$FldCond['condition']." (".$FldCond['fld_value'].")";
			}
		}
		return $CondStr;	
	}
	private function GetGroupByStr() {
		$GroupByStr = "";
		$GroupFields=array();
		if (count($this->mGroupFlds) ) {
			$GroupByStr  .= " GROUP BY ";
			foreach ($this->mGroupFlds as  $Key => $FieldName) {
				if (strpos($FieldName, "#") !== false) 
					$FieldName = $this->SqlfuncField($FieldName);
				else
					$FieldName = $this->DecryptField($FieldName);
				
				$GroupFields[$Key] = $FieldName;
			}
			return $GroupByStr.implode(", ", $GroupFields);
		}
		return "";
	}
	private function GetOrderByStr() {
		$OrderByStr = "";
		if (count($this->mOrderFlds)) {
			$OrderByStr = " ORDER BY ";
			
			foreach ($this->mOrderFlds as $Item) {
				foreach ($Item['fields'] as $Key => $OrderField) {
					if (strpos($OrderField, "#") !== false)
						$OrderField = $this->SqlfuncField($OrderField);
					else
						$OrderField = $this->DecryptField($OrderField);
					$Item['fields'][$Key] = $OrderField;
				}
				foreach ($Item['fields'] as $OrdFld)
					$OrderByStr .= $OrdFld." ".$Item['order_type'].", ";
			}
			
			return substr($OrderByStr , 0, -2);
			//return  $OrderByStr.implode(", ", $this->mOrderFlds['fields'])." ".$this->mOrderFlds['order_type'];
		}
		return $OrderByStr;
	}
	public function GetMultiple() {
		$ResArr = $this->GetQuery($this->GetMultipleQuery());
		return $ResArr;
	}
	public function GetMultipleQuery() {
		$this->TableNamesWithAlias();
		$QueryOpns 	= $this->GetSelectQueryOptions();
		$Limit 		= "";
		if (count($this->mLimit))
			$Limit = "LIMIT {$this->mLimit['start_index']}, {$this->mLimit['limit']}";
		$Index = $this->GetIndex();
		return "SELECT {$QueryOpns['fields']} FROM {$QueryOpns['table']} {$Index} {$QueryOpns['condition']} {$QueryOpns['groupby']} {$QueryOpns['orderby']} {$Limit}";
	}
		/*
    private function GetIndex() {
		$Index = "";
		if (count($this->mUseIndex))
			$Index .= "USE INDEX (".implode(',', $this->mUseIndex).") ";
		if (count($this->mIgnoreIndex))
			$Index .= "IGNORE INDEX (".implode(',', $this->mIgnoreIndex).")";
		return $Index;
	}
	*/
	public function Update() {
		$Result 		= $this->ExecQuery($this->UpdateQuery());
		return $Result;
	}
	
	public function UpdateQuery() {
		$this->TableNamesWithAlias();
		$TableName 		= $this->mTableNames[0];
		$UpdFieldStr 	= "";
		$UpdFieldArr	= array();
		$UpdFields 		= $this->GetDataChangeQueryOptions();
		$CondStr 		= $this->GetConditionStr();
		
		foreach ($UpdFields['fields'] as $key => $Field) {
			$UpdFieldArr[] = $Field." = ".$UpdFields['values'][$key];
		}
		$UpdFieldStr 	= implode(", ", $UpdFieldArr);
		return "UPDATE ".$TableName." SET {$UpdFieldStr} {$CondStr}";		
	}
	public function AddOrderFlds($FldName, $OrderType = "ASC") {
		if (!is_array($FldName))
			$FldName = array($FldName);
		
		$this->mOrderFlds[] = array("fields" => $FldName, "order_type" => strtoupper($OrderType));
	}
	public function AddLimit($StartIndex, $Limit = 10) {
		$this->mLimit = array("start_index" => $StartIndex, "limit" => $Limit);
	}
}
