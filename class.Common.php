<?php 
class Common{
	public static function callExternalAPI($url, $method = 'POST', $postFields)
		{
			// echo "<br> url: $url <br> ";
			// echo "Params:: "; print_r($postFields);
			$ch = curl_init();
		
			$UpdateArray = array();
			
			// $postFields = array('html' => $Item['content'], 'subject' => $Item['subject'], 'cc' => $Item['cc'], 'bcc' => $Item['bcc']);
			
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json'
				)
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
			
			$Response = curl_exec($ch);
			$StatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			$ResponseArray = json_decode($Response, true);
			// echo "<hr>ResponseArray:: "; print_r($ResponseArray);
			
			$Status = 'E';
			if (isset($ResponseArray['success'])) {
				$Status = 'S';
			}
	
			return  array( 'processed_at' => date(DB_DATETIME_FORMAT),'status' => $Status, 'data' => json_encode($ResponseArray));
	
		
			curl_close($ch);
		}

	
	public static function UpdateTable($TableName, $Parms,$UpdateColumn, $UpdateId) {
		$Obj = new SqlManager();
		$Obj->AddTbls($TableName);
		$Obj->AddInsrtFlds($Parms);
		$Obj->AddFldCond($UpdateColumn, $UpdateId);
		$Obj->AddLimit(0,1);
		return $Obj->Update();
	}  
    public static function InsertData($Table, $Parms, $IsBulk = false) {
		
        $Obj = new SqlManager();
        $Obj->AddTbls($Table);
        $Obj->AddInsrtFlds($Parms);
        if (!$IsBulk)
            return $Obj->InsertSingle();
        else
           return $Obj->InsertMultiple();
    }
    public static function GetDomainDetails($DomainName)
		{
			$Obj = new SqlManager();
			$Obj->AddTbls(array('domain_config'));
			$Obj->AddFlds(array('*'));
			$Obj->AddFldCond('domain_url', $DomainName);
			$Obj->AddFldCond('is_active', "Y");
			return $Obj->GetSingle();
		}
        public static function GetCronFunctionFrequency() 
		{
			$Obj = new SqlManager();
			$Query = "SELECT * FROM insights_cron_function_frequency"; 
			return $Obj->GetQuery($Query);
		}		

        public static function CheckCronFunctionStatus($CronFunctions, $CronFunctionName)
		{
			foreach ($CronFunctions as $CronFunction)
			{
					if($CronFunction['cron_function_name']==$CronFunctionName)
					{
						return $CronFunctionStatus =  ($CronFunction['is_active']=='Yes') ? true : false; 
					}
			}
			return false; 
		}
        public static function UpdateCronProcessStatus($Properties,$CronFunctionName,$CronTaskStatus)
		{
			if (!empty($Properties)){
				foreach ($Properties as $Property) {
					$Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' =>$Property['insights_property_id'], 
					'cron_function_status_flag' => $CronTaskStatus,  'month' => date('m'), 'year' => date('Y') );  
					self::InsertUpdateCronProcessStatusFlag($Parms );
				}
			}
		}

    public static function CheckInsightPropertyIdFlag($insightsPropertyId,$CronFunctionName)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_cron_function_status'));
        $Obj->AddFlds(array('insights_property_id'));
				$Obj->AddFldCond('insights_property_id', $insightsPropertyId);
				$Obj->AddFldCond('cron_function_name', $CronFunctionName);
        return $Obj->GetSingle();
    }
        
        public static function InsertUpdateCronProcessStatusFlag($Parms) {

         //   echo 'Hello';
         //   print_r('hello');
			$Check = self::CheckInsightPropertyIdFlag($Parms['insights_property_id'], $Parms['cron_function_name']);
			$Obj = new SqlManager();
			$Obj->AddTbls('insights_cron_function_status');
			$Obj->AddInsrtFlds($Parms);
			if (count($Check)) {
				$Obj->AddFldCond('insights_property_id', $Parms['insights_property_id']);
				$Obj->AddFldCond('cron_function_name', $Parms['cron_function_name']);
				$Obj->Update();
			} else{
				$Obj->InsertSingle();
			}
		}
        public static function UpdateCronCompleteStatus($insightsPropertyId, $CronFunctionName,$CompleteFlag)
		{
			$Obj = new SqlManager();
			$Obj->AddTbls(array('insights_cron_function_status'));
	 
			$Obj->AddInsrtFlds(array('cron_function_status_flag' => $CompleteFlag));
			
			$Obj->AddFldCond('insights_property_id', $insightsPropertyId);
			$Obj->AddFldCond('cron_function_name', $CronFunctionName);
			$Obj->AddFldCond('month', CURRENT_MONTH);
			$Obj->AddFldCond('year',CURRENT_YEAR);
	 
			$Obj->Update();
		}
        public static function InsightsAuditHistoryArray($Parms) {

			$recordArray=[];
			if($Parms['column_source']=='cron_property_mapping' || $Parms['column_source']=='cron_attom_avm' 
			|| $Parms['column_source']=='attom_sales_history_endpoint' || $Parms['column_source']=='cron_attom' 
			|| $Parms['column_source']=='cron_external'){
			
				foreach ($Parms['property_details'] as $Item){
					$recordArray=[
					'insights_property_id' => $Parms['insights_property_id'],    
					'table_name' => $Parms['table_name'], 
					'table_primary_key_name' => $Parms['table_primary_key_name'], 
					'table_primary_key_value' => $Parms['insights_property_id'], 
					'changed_column_name' => $Item['changed_column_name'],  
					'column_past_value' => 0, 
					'column_new_value' => $Item['column_new_value'],
					'column_source' => $Parms['column_source'],
					'is_new_record' => 'N', 
					'last_updated_by' => 0, 
					'last_updated_datetime' => CURRENT_DATETIME ];
					$InsertInsightsAuditHistory = self::InsertInsightsAuditHistory($recordArray);
				}
			}	
			
		}
		/**
		 * @member of common.php
		 * @description - This common method used to insert the record in tbl_insights_audit_history 
		*/
		public static function InsertInsightsAuditHistory($Parms) {
	 		$Obj = new SqlManager();
			$Obj->AddTbls('insights_audit_history');
			$Obj->AddInsrtFlds($Parms);
			$Obj->InsertSingle();
		}
		
		public static function UpdateCompleteStatusForMapping()
		{
			$CompletePendingProperties = self:: GetPendingCompleteForMapping();
			echo 'CompletePendingProperties::<pre>';
			print_r($CompletePendingProperties);  			
			if (!empty($CompletePendingProperties))
			{
				foreach ($CompletePendingProperties as $Property) 
				{
					$Parms = array('cron_function_name' => CONFIG_IS_MAPPING_COMPLETED, 'insights_property_id' =>$Property['insights_property_id'], 
					'cron_function_status_flag' => 'Y',  'month' => date('m'), 'year' => date('Y') );  
					self::InsertUpdateCronProcessStatusFlag($Parms );
				}
			}
		}
		public static function GetPendingCompleteForMapping()
		{
			$Obj = new SqlManager();
			$Query = "SELECT * FROM insights_cron_function_status icfs WHERE     icfs.cron_function_name='".CONFIG_FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API."' 
			AND (  icfs.cron_function_status_flag='".AddressNotFoundAfterValidateUSPS."' OR  icfs.cron_function_status_flag='".AddressNotFoundInMLS."')
			AND insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs 
			WHERE icfs.cron_function_name='".CONFIG_IS_MAPPING_COMPLETED."'  AND  icfs.cron_function_status_flag='Y' )
			 "; 
			echo 'UpdateCompleteStatusForMapping :: <pre>';
			//print_r($Query);			
			return $Obj->GetQuery($Query);  			
		}
		public static function UpdateSendMailStatus($insightsPropertyId,$mailType, $sendMailStatus)
		{
				$Obj = new SqlManager();
				$Obj->AddTbls(array('insights_send_mail_status'));
				$Check = self::CheckInsightProperty($insightsPropertyId, $mailType);
				if (count($Check)> 0) {
						$Obj->AddInsrtFlds(array('mail_type' => $mailType,'send_mail' => $sendMailStatus, 'last_updated_date_time' => date('Y-m-d h:i:s')));
						$Obj->AddFldCond('id', $Check['id']);
						$Obj->Update();
				}  
		}   
		public static function CheckInsightProperty($InsightsPropertyID, $mailType)
		{
				$Obj = new SqlManager();
				$Obj->AddTbls(array('insights_send_mail_status'));
				$Obj->AddFlds(array('id'));
				$Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
				$Obj->AddFldCond('mail_type', $mailType);
				return $Obj->GetSingle();
		}
		public static function GetSettingValues($Option)
    {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('settings'));
            $Obj->AddFlds(array('option_value'));
            $Obj->AddFldCond('option_name', $Option);
            return $Obj->GetSingle();
    }
	public static function UpdateInsightsMainTable($InsightsPropertyID, $Data)
		{
			$Obj = new SqlManager();
			$Obj->AddTbls(array('insights_main'));
			$Obj->AddInsrtFlds($Data);
			$Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
			$Obj->Update();
		}			
		
		
		public static function CheckIsBestStatus($insightsPropertyId)
		{
			$Obj = new SqlManager();
			$Obj->AddTbls(array('insights_est_price_new_programmatic'));
			$Obj->AddFlds(array('insights_property_id'));
			$Obj->AddFldCond('insights_property_id', $insightsPropertyId);
			$Obj->AddFldCond('is_best', "Y");
			$Obj->AddFldCond('est_month', CURRENT_MONTH);
			$Obj->AddFldCond('est_year',CURRENT_YEAR);					
			return $Obj->GetSingle();
		}
}
?>