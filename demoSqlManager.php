<?php 
class SqlManager {
    private $connection;
    private $mQueryLogPath;  // QUERY LOG DIRECTORY PATH

	public static $msDBcon;
	public static $msAesKey;
	public static $msEncryptFlds = array();
	private $mInsrtFields	 	 = array();
	
	private $mTableNames 		 = array();
	private $mTableColumns 		 = array();
	
	private static $mTblColumnInfo		 = array(); 
	
    /*
    define('DB_HOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','root123');
    define('DB_NAME','Inbestments');
    */
    public function __construct() {
        //include 'config.php';
        $this->connection = new mysqli('localhost', 'root', 'root123', 'Inbestments');
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
       // echo $this->connection ;
        self::$msDBcon = $this->connection;
    }

    public function AddTbls($TblName) {
        if (is_array($TblName)) 
			$this->mTableNames = array_merge($this->mTableNames, $TblName);
		else 
			$this->mTableNames[] = $TblName;
        echo "table name";
        var_dump($this->mTableNames);
    }

    public function AddInsrtFlds($Fields) {
        $this->mInsrtFields = $Fields;
        echo "columns";
        var_dump($this->mInsrtFields);
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
    function InsertMultiple() {
        // This method should execute an insert query for multiple records
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
	
    public function ExecQuery($Sql) {
        $Sql = $this->RemoveMultiSpace(trim($Sql));
        echo "SQL";
        var_dump($Sql);
        //$Sql = "SHOW COLUMNS FROM `insights_cron_function_status` FROM `Inbestments`";
        $Result =  mysqli_query(self::$msDBcon, $Sql);
        //$Sql = "SHOW COLUMNS FROM `insights_cron_function_status` FROM `Inbestments`";
        
        echo "RESULT";
        var_dump($Result);
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
}

$Parms = array(
    'cron_function_name' =>'IS_WELCOME_EMAIL_SENT' , 'insights_property_id' => 120,
    'cron_function_status_flag' => 'Y', 'tp_api' => 'N',  'month' => date('m'), 'year' => date('Y')
);
$Obj = new SqlManager();
$Obj->AddTbls('insights_cron_function_status');
$Obj->AddInsrtFlds($Parms);

$Obj->InsertSingle();
?>