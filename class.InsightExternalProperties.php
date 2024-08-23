<?php 
class InsightExternalProperties{
    public static function CallFetchPropertiesForCalibration($GetPropertiesForExternalActive)
    {
        $Month = date('m');
        $Year = date('Y');
        if($GetPropertiesForExternalActive)
        {
          $GetCurrentMonthPropertise = self::FetchPropertiesForCalibration($Month, $Year);
          echo 'PropertiesForExternalApi :: <pre>';
          print_r($GetCurrentMonthPropertise);
            
    
          if(!empty($GetCurrentMonthPropertise)){
            
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($GetCurrentMonthPropertise,CONFIG_IS_EXTERNAL_API_COMPLETED,'P');
        
            foreach ($GetCurrentMonthPropertise as $Item) {
              
              $Row = array();

              
              $Row = EstimatedPrice::ParseZestimateData($Item);
              
            if(isset($Row->total) && $Row->total == 0) {

                self::InsertIssuePropertyNotFound($Item);

                self::UpdateTPAPI($Item['insights_property_id'], 'N');     
                $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_FOR_EXTERNAL_API, 'insights_property_id' => $Item['insights_property_id'], 
                'cron_function_status_flag' => AddressNotFoundInExternal,'tp_api'=>'N',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
     
              } else {
                if (isset($Row) && $Row != 2 && $Row != 3 && count($Row)) {
                  $Row['est_month'] = $Month;
                  $Row['est_year'] = $Year;
                  $Row['insights_property_id'] = $Item['insights_property_id'];
                  self::InsertUpdateZAVM($Row, INSIGHTS_PROPERTY_SOURCE);
                  self::InsertUpdateZProperty($Row);
                    
                  $insightsPropertyDetailsByExternal = self::InsertUpdateExternal($Row);

                    $insightsMainArray = array();
                    if(isset($Row['bathrooms']) && $Row['bathrooms']!='' && $Row['bathrooms']!=0
                        && (empty($Item['bathroom_count']) || $Item['bathroom_count'] < $Row['bathrooms'])) {
                        $insightsMainArray['bathroom'] = $Row['bathrooms'];
                        $insightsMainArray['bathroom_src'] = 'tbl_insights_property_details_by_external';
                    }
                    if(isset($Row['year_built']) && $Row['year_built']!=''
                        && (empty($Item['year_built']) || $Item['year_built'] < $Row['year_built'])) { 
                        $insightsMainArray['year_built'] = $Row['year_built'];
                        $insightsMainArray['year_built_src'] = 'tbl_insights_property_details_by_external';
                    }
                    if(isset($Row['bedrooms']) && $Row['bedrooms']!=''  && $Row['bedrooms']!=0
                        && (empty($Item['bedroom_count']) || $Item['bedroom_count'] < $Row['bedrooms'])) {
                        $insightsMainArray['bedroom'] = $Row['bedrooms'];
                        $insightsMainArray['bedroom_src'] = 'tbl_insights_property_details_by_external';
                    }
                    if(isset($Row['living_square_foot']) && $Row['living_square_foot']!='' && $Row['living_square_foot']!=0
                        && (empty($Item['square_foot']) || $Item['square_foot'] < $Row['living_square_foot'])) {
                        $insightsMainArray['square_foot'] =  $Row['living_square_foot'];
                        $insightsMainArray['square_foot_src'] =  'tbl_insights_property_details_by_external';
                    }
                    if(isset($Row['sold_last_for']) && $Row['sold_last_for']!='' && $Row['sold_last_for']!=0
                        && (empty($Item['sold_price']) || $Item['sold_price'] < $Row['sold_last_for'])) {
                        $insightsMainArray['purchase_price'] = $Row['sold_last_for'];
                        $insightsMainArray['purchase_price_src'] = 'tbl_insights_property_details_by_external';
                    }
                    if(isset($Row['sold_last_on']) && $Row['sold_last_on']!='' && $Row['sold_last_on']!=0
                        && (empty($Item['sold_date']) || $Item['sold_date'] < $Row['sold_last_on'])) { 
                        $insightsMainArray['purchase_date'] = $Row['sold_last_on'];
                        $insightsMainArray['purchase_date_src'] = 'tbl_insights_property_details_by_external';
                    }
                    if(isset($Row['tax_assessment_year']) && $Row['tax_assessment_year']!='' && $Row['tax_assessment_year'] != 0
                        && (empty($Item['property_tax_year']) || $Item['property_tax_year'] < $Row['tax_assessment_year'])) {
                        $insightsMainArray['property_tax_year'] = $Row['tax_assessment_year'];
                        $insightsMainArray['property_tax_year_src'] = 'tbl_insights_property_details_by_external';
                        $insightsMainArray['property_tax'] = $Row['tax_assessment'];
                        $insightsMainArray['property_tax_source'] = 'tbl_insights_property_details_by_external';
                    }
                    if (count($insightsMainArray) > 0)
                        self::UpdateInsightsMain($Row['insights_property_id'],$insightsMainArray);

                    $auditHistoryArray = array();
                    if(isset($Row['bedrooms']) && $Row['bedrooms']!='' && $Row['bedrooms']!=0)
                        array( 'changed_column_name' => 'bedroom',  'column_new_value' => $Row['bedrooms']);
                    if(isset($Row['bathrooms']) && $Row['bathrooms']!='' && $Row['bathrooms']!=0)
                        array( 'changed_column_name' => 'bathroom', 'column_new_value' => $Row['bathrooms']);
                    if(isset($Row['living_square_foot']) && $Row['living_square_foot']!='' && $Row['living_square_foot']!=0) 
                        array( 'changed_column_name' => 'square_foot', 'column_new_value' => $Row['living_square_foot']);
                    if(isset($Row['sold_last_for']) && $Row['sold_last_for']!='' && $Row['sold_last_for']!=0)
                        array( 'changed_column_name' => 'purchase_price', 'column_new_value' => $Row['sold_last_for']);
                    if(isset($Row['sold_last_on']) && $Row['sold_last_on']!='' && $Row['sold_last_on']!=0) 
                        array( 'changed_column_name' => 'purchase_date', 'column_new_value' => $Row['sold_last_on']); 
                    if(isset($Row['year_built']) && $Row['year_built']!='' && $Row['year_built']!=0) 
                        array( 'changed_column_name' => 'year_built', 'column_new_value' => $Row['year_built']);     

                    if (count($auditHistoryArray) > 0) {
                        $AuditHistoryParam = array(
                            'table_name' => 'tbl_insights_property_details_by_external', 
                            'table_primary_key_name' => 'id',
                            'table_primary_key_value' => 0, 
                            'insights_property_id' => $Row['insights_property_id'],
                            'column_source' => 'cron_external',
                            'property_details'=> $auditHistoryArray
                        );
                    
                        $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);
                    }    
                  self::UpdateTPAPI($Item['insights_property_id']);

                  SIFlagIssues::UpdateInsightIssuesForAddressFound($Item['insights_property_id']);
                  $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_FOR_EXTERNAL_API, 'insights_property_id' => $Item['insights_property_id'], 
                  'cron_function_status_flag' => AddressFoundInExternal,'tp_api'=>'Y',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                  $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                   
                } 

            
                if($Row["est_price"] > 10000)
                {
                  self::InsertExternalHomeValue($Row);   
                }   
                
              }
              $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Item['insights_property_id'], CONFIG_IS_EXTERNAL_API_COMPLETED,'Y');
             }
              
          }
        
        }
    }
    public static function InsertExternalHomeValue($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_new_programmatic'));
        $Obj->AddInsrtFlds(
            array(
            'insights_property_id' => $Row["insights_property_id"],
            'est_price' => $Row["est_price"],
            'high_est_price' => $Row["high_est_price"],
            'low_est_price' => $Row["low_est_price"],
            'est_month' => $Row["est_month"],
            'est_year' => $Row["est_year"],
            'pcomp_criteria_id' => '10000',
            'is_best' => 'N',
            'record_status' => 'A'
            )
            //   'is_best' => 'Y',
        );
        $newId = $Obj->InsertSingle();
    }         

    
    public static function UpdateInsightsMain($InsightsPropertyID, $Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_main'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->Update();
    }
     
    public static function InsertUpdateZProperty($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_property_details_by_user'));
        
        $Check = self::CheckZProperty($Row);
        if (count($Check)) {
      if(isset($Row['tax_assessment_year']))
      {
        // echo "isset_tax_assessment_year :: ";
        if(empty($Check['tax_assessment_year']) || $Check['tax_assessment_year'] < $Row['tax_assessment_year'])
        {
        $Obj->AddFldCond('id', $Check['id']);
        $Obj->AddInsrtFlds(array('tax_assessment_year' => $Row['tax_assessment_year'],'tax_assessment' => $Row['tax_assessment'] ));
        $Obj->Update();
        // echo "isset_tax_assessment_year_updated:: ".$Check['id'];
        }
      }
    
        } else
        {
          $Obj->AddInsrtFlds($Row);   
          $Obj->InsertSingle();
        }
            
    }
    public static function CheckZProperty($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_property_details_by_user'));
        $Obj->AddFlds(array('id','tax_assessment_year'));
        $Obj->AddFldCond('insights_property_id', $Row['insights_property_id']);
        return $Obj->GetSingle();
    }     
    public static function InsertUpdateExternal($Row)
        {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_property_details_by_external'));
            $insertRecord=false;
            $Check = self::CheckPropertyForExternal($Row);
            if (!count($Check)) {
                 $insertRecord = true;
            }else{
				if(isset($Row['tax_assessment_year'])){
					if($Check['tax_assessment_year'] < $Row['tax_assessment_year']){
						$insertRecord = true; 
					}
					if($Check['tax_assessment_year'] = $Row['tax_assessment_year'] &&  $Check['tax_assessment'] != $Row['tax_assessment'] ){
						$insertRecord = true; 
					} 
				}                
            }
   
            if($insertRecord){
                $Obj->AddInsrtFlds($Row);   
                $Obj->InsertSingle();               
            }       
            return $Obj; 

        }
        public static function CheckPropertyForExternal($Row)
        {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_property_details_by_external'));
            $Obj->AddFlds(array('id','tax_assessment_year','tax_assessment'));
            $Obj->AddFldCond('insights_property_id', $Row['insights_property_id']);

            return $Obj->GetSingle();
        }     
    public static function UpdateTPAPI($InsightsPropertyID, $Flag = 'Y')
    {
        if ($InsightsPropertyID > 0) {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_main'));
            $Obj->AddInsrtFlds(array('tp_api' => $Flag));
            $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
            $Obj->Update();
        }
    } 
    public static function InsertIssuePropertyNotFound($Item)
      {
          $Obj = new SqlManager();
          $Obj->AddTbls(array('insights_issues'));
          $Obj->AddInsrtFlds(
              array(
              'insights_property_id' => $Item["insights_property_id"],
              'issues_present' => 'Y',
              'issue_description' => "Address Not Found In External",
              'issue_found_date' => date(DB_DATETIME_FORMAT),
              'modified_date' => date(DB_DATETIME_FORMAT),
              'modified_by_user' => 0,
              'is_mandatory_for_home_value' => 'N'
              )
          );
          $CheckIssue = self::CheckInsightsIssue($Item);
            if (!$CheckIssue) {
                $Obj->InsertSingle();
            }  
           
      } 
      public static function CheckInsightsIssue($Item)
      {
          $Obj = new SqlManager();
          $Obj->AddTbls(array('insights_issues'));
          $Obj->AddFlds(array('id'));
          $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
          $Obj->AddFldCond('issue_description', 'Address Not Found In External');
          $Obj->AddFldCond('issues_present', 'Y');
          return $Obj->GetSingle();
      }
      public static function InsertUpdateZAVM($Row, $propertySrc)
      {
          $Row['property_src'] = $propertySrc;
          $Obj = new SqlManager();
          $Obj->AddTbls(array('insights_external_estimate'));
          $Obj->AddInsrtFlds($Row);
  
          $Check = self::CheckZData($Row);
          if (count($Check)) {
              $Obj->AddFldCond('id', $Check['id']);
              $Obj->Update();
          } else
              $Obj->InsertSingle();
      }
      public static function CheckZData($Row)
      {
          $Obj = new SqlManager();
          $Obj->AddTbls(array('insights_external_estimate'));
          $Obj->AddFlds(array('id'));
          $Obj->AddFldCond('insights_property_id', $Row['insights_property_id']);
          $Obj->AddFldCond('est_month', $Row['est_month']);
          $Obj->AddFldCond('est_year', $Row['est_year']);
          return $Obj->GetSingle();
      }       
    public static function FetchPropertiesForCalibration($Month, $Year)
      {
          $Obj = new SqlManager();
          $Query = "SELECT 
                    im.inbestments_property_id id, 
                    im.insights_property_id insights_property_id,
                    IF(usps.address2 != '', usps.address2 ,im.property_address) property_address,
                    IF(usps.city != '', usps.city ,im.property_city) property_city,
                    IF(usps.state != '', usps.state ,im.property_state) property_state, 
                    IF(usps.zip5 != '', usps.zip5 ,im.property_zipcode) property_zipcode,
                    IF(usps.address2 != '', '' ,im.unit_number) unit_number,
                    im.property_tax_year
                  FROM 
                    insights_main im 
                  LEFT JOIN property_details_mls mls ON(im.inbestments_property_id = mls.id) 
                  LEFT JOIN insights_address_usps usps ON (usps.insights_property_id = im.insights_property_id)
                  LEFT JOIN insights_external_estimate zd ON(im.insights_property_id = zd.insights_property_id 
                    AND zd.est_month = '".$Month."' AND zd.est_year = ".$Year.")
                  WHERE 
                     (zd.est_month IS NULL AND zd.est_year IS NULL ) 
                    ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
                    AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs WHERE icfs.cron_function_name='".CONFIG_GET_PROPERTIES_FOR_EXTERNAL_API."'   AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  ) GROUP BY im.insights_property_id ORDER BY im.insights_property_id DESC  LIMIT 15  ";
                    echo 'External-FetchPropertiesForCalibration :: <pre>';
                    print_r($Query);                    
          return $Obj->GetQuery($Query);
      }
      public static function CallFetchPropertiesForRental($ExternalPropertyDataArray)
        {

            $Month = date('m');
            $Year = date('Y');
            $GetMlsForRentalProperties = self::GetMlsForRental();
            echo 'GetMlsForRental :: <pre>';
            print_r($GetMlsForRentalProperties);
            
            if(!empty($GetMlsForRentalProperties)){
                $ValidateData = false;
                foreach ($GetMlsForRentalProperties as $Item) {
                    foreach ($ExternalPropertyDataArray as $Property) {
                        if(is_array($Property)) {
                            if($Property['insights_property_id'] == $Item['insights_property_id']){
                                $ValidateData = true;
                                $ExternalPropertyData = $Property; 
                            }
                            if($ValidateData)
                                break;   
                        }
                    }
                    if(!$ValidateData){
                        $ExternalPropertyData = array();
                        $ExternalPropertyData = EstimatedPrice::ParseZestimateData($Item);
                    }
                    echo 'Row :: <pre>';
                    print_r($ExternalPropertyData);
                    // Check property address not found in zData 
                    if(isset($ExternalPropertyData->total) && $ExternalPropertyData->total == 0){
                        // $Parms = array('cron_function_name' => CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM, 'insights_property_id' => $Item['insights_property_id'], 'cron_function_status_flag' => AddressNotFoundInExternal);  
                        // $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                        
                        $Parms = array('cron_function_name' => CONFIG_IS_RENTAL_EXTERNAL_API_CHECKED, 'insights_property_id' => $Item['insights_property_id'], 'cron_function_status_flag' => AddressNotFoundInExternal,
                        'month' => CURRENT_MONTH,
                        'year' => CURRENT_YEAR );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 

                        ##### cron_status = 2_rent_est_external_failed 
                        $Parms1 = array(
                            'cron_function_name' => MlsCronStatus, 
                            'insights_property_id' => $Item['insights_property_id'], 
                            'cron_function_status_flag' => MlsCronStatusRentEstExternalFailed,
                            'month' => CURRENT_MONTH,
                            'year' => CURRENT_YEAR 
                        );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                        $Parms2 = array('cron_status' => MlsCronStatusRentEstExternalFailed);  
                        print_r($Parms2);
                        echo '####External API #1<hr>';
                        $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $Item['insights_property_id']); 
                        #####                

                    } else {
                        if (isset($ExternalPropertyData) && count($ExternalPropertyData)) {
                                $ExternalPropertyData['est_month'] = $Month;
                                $ExternalPropertyData['est_year'] = $Year;
                                $ExternalPropertyData['insights_property_id'] = $Item['insights_property_id'];
                                if(!isset($ExternalPropertyData['est_monthly_rent'])){
                                    $Parms = array('cron_function_name' => CONFIG_IS_RENTAL_EXTERNAL_API_CHECKED, 'insights_property_id' => $Item['insights_property_id'], 'cron_function_status_flag' => RentalValueNotFoundInExternal,
                                    'month' => CURRENT_MONTH,
                                    'year' => CURRENT_YEAR );  
                                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
    
                                    ##### cron_status = 2_rent_est_external_failed 
                                    $Parms1 = array(
                                        'cron_function_name' => MlsCronStatus, 
                                        'insights_property_id' => $Item['insights_property_id'], 
                                        'cron_function_status_flag' => MlsCronStatusRentEstExternalFailed,
                                        'month' => CURRENT_MONTH,
                                        'year' => CURRENT_YEAR 
                                    );  
                                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                                    $Parms2 = array('cron_status' => MlsCronStatusRentEstExternalFailed);  
                                    print_r($Parms2);
                                    echo '####External API #2<hr>';
                                    $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $Item['insights_property_id']); 
                                    #####   
                                }else{
                                    $Parms = array('cron_function_name' => CONFIG_IS_RENTAL_EXTERNAL_API_CHECKED, 'insights_property_id' => $Item['insights_property_id'], 'cron_function_status_flag' => RentalValueFoundInExternal,
                                    'month' => CURRENT_MONTH,
                                    'year' => CURRENT_YEAR );  
                                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                                    // Insert/Update in external estimate 
                                    self::InsertUpdateZAVM($ExternalPropertyData, MLS_PROPERTY_SOURCE);
                                    // Insert/Update in tbl_insights_est_rent_mls
                                    self::InsertUpdateEstRentMls($ExternalPropertyData);          
                                    ##### cron_status = 2_rent_est_completed 
                                    $Parms1 = array(
                                        'cron_function_name' => MlsCronStatus, 
                                        'insights_property_id' => $Item['insights_property_id'], 
                                        'cron_function_status_flag' => MlsCronStatusRentEstExternalCompleted,
                                        'month' => CURRENT_MONTH,
                                        'year' => CURRENT_YEAR 
                                    );  
                                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms1,false); 
                                    if(!$ValidateData){    
                                        $PropertyDetailsArray = array();
                                        // if(isset($ExternalPropertyData['bathrooms']) && $ExternalPropertyData['bathrooms']!='' && $ExternalPropertyData['bathrooms']!=0) {
                                        //     $PropertyDetailsArray['bathroom_count'] = $ExternalPropertyData['bathrooms'];
                                        // }
                                        // if(isset($ExternalPropertyData['year_built']) && $ExternalPropertyData['year_built']!='') { 
                                        //     $PropertyDetailsArray['year_built'] = $ExternalPropertyData['year_built'];
                                        // }
                                        // if(isset($ExternalPropertyData['bedrooms']) && $ExternalPropertyData['bedrooms']!=''  && $ExternalPropertyData['bedrooms']!=0) {
                                        //     $PropertyDetailsArray['bedroom_count'] = $ExternalPropertyData['bedrooms'];
                                        // }
                                        // if(isset($ExternalPropertyData['living_square_foot']) && $ExternalPropertyData['living_square_foot']!='' && $ExternalPropertyData['living_square_foot']!=0) {
                                        //     $PropertyDetailsArray['square_foot'] =  $ExternalPropertyData['living_square_foot'];
                                        // }
                                        // if(isset($ExternalPropertyData['sold_last_for']) && $ExternalPropertyData['sold_last_for']!='' && $ExternalPropertyData['sold_last_for']!=0) {
                                        //     $PropertyDetailsArray['sold_price'] = $ExternalPropertyData['sold_last_for'];
                                        // }
                                        // if(isset($ExternalPropertyData['sold_last_on']) && $ExternalPropertyData['sold_last_on']!='' && $ExternalPropertyData['sold_last_on']!=0) { 
                                        //     $PropertyDetailsArray['sold_date'] = $ExternalPropertyData['sold_last_on'];
                                        // }
                                        if(isset($ExternalPropertyData['tax_assessment_year']) && $ExternalPropertyData['tax_assessment_year']!='' && $ExternalPropertyData['tax_assessment_year'] != 0
                                            && (empty($Item['tax_year']) || $Item['tax_year'] < $ExternalPropertyData['tax_assessment_year'])) {
                                            $PropertyDetailsArray['tax_year'] = $ExternalPropertyData['tax_assessment_year'];
                                            $PropertyDetailsArray['annual_taxes'] = $ExternalPropertyData['tax_assessment'];
                                        }
                                        $PropertyDetailsArray['cron_status'] = MlsCronStatusRentEstExternalCompleted;
                                        if (count($PropertyDetailsArray) > 0)
                                        HomeValueCustom::UpdatePropertyDetails($ExternalPropertyData['insights_property_id'],$PropertyDetailsArray);                                                                       
                                    } else {    
                                    $Parms2 = array('cron_status' => MlsCronStatusRentEstExternalCompleted);  
                                    print_r($Parms2);
                                    echo '####External API<hr>';
                                    $UpdateCronStatus=Common::UpdateTable('property_details_mls', $Parms2,'id', $Item['insights_property_id']); 
                                    }
                                    #####                                                                              
                                }
              
                                // UPDATE CRON STATUS 
                                // $Parms = array('cron_function_name' => CONFIG_IS_RENT_ESTIMATE_COMPLETED_CUSTOM, 'insights_property_id' => $Item['insights_property_id'], 'cron_function_status_flag' => AddressFoundInExternal );  
                                // $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                        } 
                    }
                }
            }
            
        }
        public static function GetMlsForRental()
        {
            $CurrentDate = date(DB_DATETIME_FORMAT);
            $AYearAgo=date('Y-m-d', strtotime('-13 month'));
          
            $Obj = new SqlManager();
            $Query = "SELECT id AS insights_property_id, ml_number, mls_updated_date, status, address AS property_address,city_name AS property_city, state_code AS property_state,zip_code AS property_zipcode, unit_number, tax_year, ml_number FROM tbl_property_details_mls 
            WHERE 1=1 AND cron_status='".MlsCronStatusRentEstInComplete."'
             ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION." 
              ORDER BY  mls_updated_date LIMIT  65";
           
            echo 'External-GetMlsForRental :: <pre>';
            //  AND mls_updated_date >='".$AYearAgo."'
            print_r($Query);                    
            return $Obj->GetQuery($Query);
        }
        
        public static function InsertUpdateEstRentMls($Row)
        {
            $MedianValue = ($Row["high_est_monthly_rent"]+$Row["low_est_monthly_rent"]) / 2;

            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_est_rent_mls'));
            $Obj->AddInsrtFlds(
                array(
                    'insights_property_id' => $Row["insights_property_id"],
                    'est_monthly_rent' => $Row["est_monthly_rent"],
                    'avg_est_monthly_rent' => $MedianValue,
                    'high_est_monthly_rent' => $Row["high_est_monthly_rent"],
                    'low_est_monthly_rent' => $Row["low_est_monthly_rent"],
                    'median_est_monthly_rent' => $MedianValue,
                    'est_month' => $Row["est_month"],
                    'est_year' => $Row["est_year"],
                    'rcomp_criteria_id' => 10000,  
                    'is_best' => 'Y',  
                    'last_modified' => date(DB_DATETIME_FORMAT),
                    'last_modified_by' => 0,
                )
            );
            $Check = self::CheckZDataRentalExternal($Row);
            if (count($Check)) {
                $Obj->AddFldCond('id', $Check['id']);
                $Obj->Update();
            } else{
                $Obj->InsertSingle();
            }
        }
        public static function CheckZDataRentalExternal($Row)
        {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_est_rent_mls'));
            $Obj->AddFlds(array('id'));
            $Obj->AddFldCond('insights_property_id', $Row['insights_property_id']);
            $Obj->AddFldCond('rcomp_criteria_id', 10000);
            $Obj->AddFldCond('est_month', CURRENT_MONTH);
            $Obj->AddFldCond('est_year', CURRENT_YEAR);
            return $Obj->GetSingle();
        }
      

}